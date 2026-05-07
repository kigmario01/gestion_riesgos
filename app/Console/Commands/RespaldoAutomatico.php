<?php

namespace App\Console\Commands;

use App\Models\RespaldoBd;
use App\Models\RespaldoConfig;
use App\Models\BitacoraAuditoria;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class RespaldoAutomatico extends Command
{
    protected $signature   = 'respaldo:automatico';
    protected $description = 'Genera un respaldo automático si está habilitado y toca ejecutar';

    public function handle(): void
    {
        $config = RespaldoConfig::instancia();

        if (!$config->activo) {
            $this->info('Respaldo automático desactivado.');
            return;
        }

        if (!$this->tocaEjecutar($config)) {
            $this->info('No toca ejecutar aún.');
            return;
        }

        $this->generarRespaldo($config);
    }

    private function tocaEjecutar(RespaldoConfig $config): bool
    {
        $ahora     = now();
        $horaActual = $ahora->format('H:i');
        $horaProg   = substr($config->hora, 0, 5); // HH:MM

        if ($horaActual !== $horaProg) return false;

        // Si ya se ejecutó hoy a esta hora, no repetir
        if ($config->ultimo_ejecutado && $config->ultimo_ejecutado->isToday()) return false;

        return match ($config->frecuencia) {
            'diario'   => true,
            'semanal'  => $ahora->dayOfWeek === (int) $config->dia_semana,
            'mensual'  => $ahora->day === (int) $config->dia_mes,
            default    => false,
        };
    }

    private function generarRespaldo(RespaldoConfig $config): void
    {
        $fileName = 'backup_' . now()->format('Y-m-d_H-i-s') . '.sql';
        $dir      = storage_path('app/backups');
        $filePath = $dir . DIRECTORY_SEPARATOR . $fileName;

        if (!is_dir($dir)) mkdir($dir, 0755, true);

        $estado   = 'fallido';
        $errorMsg = '';
        $conn     = config('database.default');
        $db       = config("database.connections.{$conn}");
        $driver   = DB::connection()->getDriverName();

        if ($driver === 'mysql' && $this->tryMysqldump($db, $filePath, $errorMsg)) {
            $estado = 'completado';
        }
        if ($estado !== 'completado' && $this->tryPdoDump($db, $filePath, $errorMsg)) {
            $estado = 'completado';
        }

        $respaldo = RespaldoBd::create([
            'nombre_archivo' => $fileName,
            'ruta_archivo'   => 'backups/' . $fileName,
            'tamanio_bytes'  => ($estado === 'completado' && file_exists($filePath)) ? filesize($filePath) : null,
            'tipo'           => 'automatico',
            'estado'         => $estado,
            'notas'          => $estado === 'fallido' ? $errorMsg : 'Respaldo automático programado',
            'generado_por'   => null,
        ]);

        $config->update(['ultimo_ejecutado' => now()]);

        BitacoraAuditoria::registrar(
            'exportar', 'respaldos_bd',
            'Respaldo automático ' . ($estado === 'completado' ? 'exitoso' : 'falló') . ': ' . $fileName,
            $respaldo->id, [], ['archivo' => $fileName, 'estado' => $estado]
        );

        $this->info($estado === 'completado' ? "Respaldo generado: {$fileName}" : "Falló: {$errorMsg}");
    }

    private function tryMysqldump(array $db, string $filePath, string &$errorMsg): bool
    {
        $candidates = ['mysqldump', '/usr/bin/mysqldump', '/usr/local/bin/mysqldump'];
        foreach ($candidates as $bin) {
            $password = $db['password'] ?? '';
            $passArg  = $password !== '' ? '-p' . escapeshellarg($password) : '';
            $cmd = sprintf('%s -u%s %s -h%s %s > %s 2>&1',
                escapeshellarg($bin), escapeshellarg($db['username']),
                $passArg, escapeshellarg($db['host']),
                escapeshellarg($db['database']), escapeshellarg($filePath));
            $code = -1;
            if (function_exists('exec')) @exec($cmd, $out, $code);
            if ($code === 0 && file_exists($filePath) && filesize($filePath) > 100) return true;
            if (file_exists($filePath)) @unlink($filePath);
        }
        $errorMsg = 'mysqldump no disponible.';
        return false;
    }

    private function tryPdoDump(array $db, string $filePath, string &$errorMsg): bool
    {
        try {
            $driver = DB::connection()->getDriverName();
            $pdo    = DB::connection()->getPdo();
            $sql    = "-- RiskGuard TI - Backup automático " . now()->toDateTimeString() . "\n\n";

            if ($driver === 'pgsql') {
                $tables = $pdo->query("SELECT tablename FROM pg_tables WHERE schemaname = 'public' ORDER BY tablename")->fetchAll(\PDO::FETCH_COLUMN);
                foreach ($tables as $table) {
                    $rows = $pdo->query("SELECT * FROM \"{$table}\"")->fetchAll(\PDO::FETCH_ASSOC);
                    if (!$rows) continue;
                    $cols = '"' . implode('", "', array_keys($rows[0])) . '"';
                    $sql .= "DELETE FROM \"{$table}\";\n";
                    foreach ($rows as $row) {
                        $vals = array_map(fn($v) => $v === null ? 'NULL' : $pdo->quote($v), array_values($row));
                        $sql .= "INSERT INTO \"{$table}\" ({$cols}) VALUES (" . implode(', ', $vals) . ");\n";
                    }
                    $sql .= "\n";
                }
            } else {
                $tables = $pdo->query("SHOW FULL TABLES FROM `{$db['database']}` WHERE Table_type = 'BASE TABLE'")->fetchAll(\PDO::FETCH_COLUMN);
                $sql .= "SET FOREIGN_KEY_CHECKS=0;\n\n";
                foreach ($tables as $table) {
                    $cr = $pdo->query("SHOW CREATE TABLE `{$table}`")->fetch(\PDO::FETCH_ASSOC);
                    $sql .= "DROP TABLE IF EXISTS `{$table}`;\n" . ($cr['Create Table'] ?? '') . ";\n\n";
                    $rows = $pdo->query("SELECT * FROM `{$table}`")->fetchAll(\PDO::FETCH_ASSOC);
                    if (!$rows) continue;
                    $cols = '`' . implode('`, `', array_keys($rows[0])) . '`';
                    foreach ($rows as $row) {
                        $vals = array_map(fn($v) => $v === null ? 'NULL' : $pdo->quote($v), array_values($row));
                        $sql .= "INSERT INTO `{$table}` ({$cols}) VALUES (" . implode(', ', $vals) . ");\n";
                    }
                    $sql .= "\n";
                }
                $sql .= "SET FOREIGN_KEY_CHECKS=1;\n";
            }

            file_put_contents($filePath, $sql);
            return file_exists($filePath) && filesize($filePath) > 100;
        } catch (\Throwable $e) {
            $errorMsg = 'PDO dump falló: ' . $e->getMessage();
            return false;
        }
    }
}

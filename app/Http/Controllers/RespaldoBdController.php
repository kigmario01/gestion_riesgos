<?php

namespace App\Http\Controllers;

use App\Models\RespaldoBd;
use App\Models\BitacoraAuditoria;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RespaldoBdController extends Controller
{
    public function index()
    {
        $respaldos = RespaldoBd::with('generador')
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        $totalRespaldos = RespaldoBd::count();
        $exitosos       = RespaldoBd::where('estado', 'exitoso')->count();
        $ultimoRespaldo = RespaldoBd::where('estado', 'exitoso')->latest('created_at')->first();

        return view('respaldos.index', compact('respaldos', 'totalRespaldos', 'exitosos', 'ultimoRespaldo'));
    }

    public function store(Request $request)
    {
        $request->validate(['notas' => 'nullable|string|max:500']);

        $db       = config('database.connections.mysql');
        $fileName = 'backup_' . now()->format('Y-m-d_H-i-s') . '.sql';
        $dir      = storage_path('app/backups');
        $filePath = $dir . DIRECTORY_SEPARATOR . $fileName;

        if (!is_dir($dir)) {
            mkdir($dir, 0755, true);
        }

        // Intentar con mysqldump (busca en PATH del sistema, sin ruta hardcodeada)
        $estado = 'fallido';
        $errorMsg = '';

        if ($this->tryMysqldump($db, $filePath, $errorMsg)) {
            $estado = 'exitoso';
        } else {
            // Fallback: volcado completo vía PDO
            if ($this->tryPdoDump($db, $filePath, $errorMsg)) {
                $estado = 'exitoso';
            }
        }

        $respaldo = RespaldoBd::create([
            'nombre_archivo' => $fileName,
            'ruta_archivo'   => 'backups/' . $fileName,
            'tamanio_bytes'  => ($estado === 'exitoso' && file_exists($filePath)) ? filesize($filePath) : null,
            'tipo'           => 'manual',
            'estado'         => $estado,
            'notas'          => $estado === 'fallido' ? $errorMsg : $request->notas,
            'generado_por'   => auth()->id(),
            'created_at'     => now(),
        ]);

        BitacoraAuditoria::registrar(
            'exportar',
            'respaldos_bd',
            'Respaldo de base de datos ' . ($estado === 'exitoso' ? 'generado exitosamente' : 'falló') . ': ' . $fileName,
            $respaldo->id,
            [],
            ['archivo' => $fileName, 'estado' => $estado]
        );

        if ($estado === 'exitoso') {
            return redirect()->route('respaldos.index')
                ->with('success', 'Respaldo generado exitosamente: ' . $fileName);
        }

        return redirect()->route('respaldos.index')
            ->with('error', 'Error al generar el respaldo: ' . $errorMsg);
    }

    private function tryMysqldump(array $db, string $filePath, string &$errorMsg): bool
    {
        // Busca mysqldump en el PATH del sistema (funciona en Linux/Mac/Windows con MySQL en PATH)
        $candidates = ['mysqldump', 'mysqldump.exe'];

        // También intenta rutas comunes por si no está en PATH
        if (PHP_OS_FAMILY === 'Windows') {
            $candidates = array_merge($candidates, [
                'C:\\xampp\\mysql\\bin\\mysqldump.exe',
                'C:\\Program Files\\MySQL\\MySQL Server 8.0\\bin\\mysqldump.exe',
                'C:\\Program Files\\MySQL\\MySQL Server 5.7\\bin\\mysqldump.exe',
            ]);
        } else {
            $candidates = array_merge($candidates, [
                '/usr/bin/mysqldump',
                '/usr/local/bin/mysqldump',
                '/opt/homebrew/bin/mysqldump',
            ]);
        }

        foreach ($candidates as $bin) {
            $password = $db['password'] ?? '';
            $passArg  = $password !== '' ? '-p' . escapeshellarg($password) : '';

            if (PHP_OS_FAMILY === 'Windows') {
                $cmd = sprintf(
                    '"%s" -u%s %s -h%s %s > "%s" 2>&1',
                    $bin,
                    escapeshellarg($db['username']),
                    $passArg,
                    escapeshellarg($db['host']),
                    escapeshellarg($db['database']),
                    $filePath
                );
            } else {
                $cmd = sprintf(
                    '%s -u%s %s -h%s %s > %s 2>&1',
                    escapeshellarg($bin),
                    escapeshellarg($db['username']),
                    $passArg,
                    escapeshellarg($db['host']),
                    escapeshellarg($db['database']),
                    escapeshellarg($filePath)
                );
            }

            $output = [];
            $code   = -1;

            if (function_exists('exec')) {
                @exec($cmd, $output, $code);
            } else {
                continue;
            }

            if ($code === 0 && file_exists($filePath) && filesize($filePath) > 100) {
                return true;
            }

            // Limpiar archivo vacío/corrupto antes de probar siguiente candidato
            if (file_exists($filePath)) {
                @unlink($filePath);
            }
        }

        $errorMsg = 'mysqldump no disponible o falló.';
        return false;
    }

    private function tryPdoDump(array $db, string $filePath, string &$errorMsg): bool
    {
        try {
            $pdo = DB::connection()->getPdo();
            $database = $db['database'];

            $sql  = "-- RiskGuard TI - Backup generado el " . now()->toDateTimeString() . "\n";
            $sql .= "-- Base de datos: {$database}\n";
            $sql .= "SET FOREIGN_KEY_CHECKS=0;\n\n";

            // Obtener todas las tablas
            $tables = $pdo->query("SHOW FULL TABLES FROM `{$database}` WHERE Table_type = 'BASE TABLE'")->fetchAll(\PDO::FETCH_COLUMN);

            foreach ($tables as $table) {
                // DROP + CREATE
                $createRow = $pdo->query("SHOW CREATE TABLE `{$table}`")->fetch(\PDO::FETCH_ASSOC);
                $createSql = $createRow['Create Table'] ?? '';
                $sql .= "DROP TABLE IF EXISTS `{$table}`;\n";
                $sql .= $createSql . ";\n\n";

                // Datos
                $rows = $pdo->query("SELECT * FROM `{$table}`")->fetchAll(\PDO::FETCH_ASSOC);
                if (count($rows) > 0) {
                    $cols = '`' . implode('`, `', array_keys($rows[0])) . '`';
                    foreach ($rows as $row) {
                        $vals = array_map(fn($v) => $v === null ? 'NULL' : $pdo->quote($v), array_values($row));
                        $sql .= "INSERT INTO `{$table}` ({$cols}) VALUES (" . implode(', ', $vals) . ");\n";
                    }
                    $sql .= "\n";
                }
            }

            $sql .= "SET FOREIGN_KEY_CHECKS=1;\n";

            file_put_contents($filePath, $sql);
            return file_exists($filePath) && filesize($filePath) > 100;

        } catch (\Throwable $e) {
            $errorMsg = 'PDO dump falló: ' . $e->getMessage();
            return false;
        }
    }

    public function download(RespaldoBd $respaldo)
    {
        $path = storage_path('app/' . $respaldo->ruta_archivo);

        if (!file_exists($path)) {
            return redirect()->route('respaldos.index')
                ->with('error', 'El archivo de respaldo ya no existe en el servidor.');
        }

        BitacoraAuditoria::registrar(
            'exportar',
            'respaldos_bd',
            'Descarga de respaldo: ' . $respaldo->nombre_archivo,
            $respaldo->id,
            [],
            []
        );

        return response()->download($path, $respaldo->nombre_archivo, [
            'Content-Type'        => 'application/octet-stream',
            'Content-Disposition' => 'attachment; filename="' . $respaldo->nombre_archivo . '"',
        ]);
    }

    public function destroy(RespaldoBd $respaldo)
    {
        $path = storage_path('app/' . $respaldo->ruta_archivo);

        if (file_exists($path)) {
            unlink($path);
        }

        BitacoraAuditoria::registrar(
            'eliminar',
            'respaldos_bd',
            'Respaldo eliminado: ' . $respaldo->nombre_archivo,
            $respaldo->id,
            ['archivo' => $respaldo->nombre_archivo],
            []
        );

        $respaldo->delete();

        return redirect()->route('respaldos.index')
            ->with('success', 'Respaldo eliminado correctamente.');
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\RespaldoBd;
use App\Models\BitacoraAuditoria;
use Illuminate\Http\Request;

class RespaldoBdController extends Controller
{
    public function index()
    {
        $respaldos = RespaldoBd::with('generador')
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        $totalRespaldos   = RespaldoBd::count();
        $exitosos         = RespaldoBd::where('estado', 'completado')->count();
        $ultimoRespaldo   = RespaldoBd::where('estado', 'completado')->latest('created_at')->first();

        return view('respaldos.index', compact('respaldos', 'totalRespaldos', 'exitosos', 'ultimoRespaldo'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'notas' => 'nullable|string|max:500',
        ]);

        $db       = config('database.connections.mysql');
        $fileName = 'backup_' . now()->format('Y-m-d_H-i-s') . '.sql';
        $dir      = storage_path('app/backups');
        $filePath = $dir . DIRECTORY_SEPARATOR . $fileName;

        if (!is_dir($dir)) {
            mkdir($dir, 0755, true);
        }

        $mysqldump = 'C:\\xampp\\mysql\\bin\\mysqldump.exe';
        $password  = $db['password'] ?? '';

        if ($password !== '') {
            $cmd = sprintf(
                '"%s" -u%s -p%s -h%s %s > "%s" 2>&1',
                $mysqldump,
                $db['username'],
                $password,
                $db['host'],
                $db['database'],
                $filePath
            );
        } else {
            $cmd = sprintf(
                '"%s" -u%s -h%s %s > "%s" 2>&1',
                $mysqldump,
                $db['username'],
                $db['host'],
                $db['database'],
                $filePath
            );
        }

        exec($cmd, $output, $code);

        $estado = ($code === 0 && file_exists($filePath) && filesize($filePath) > 0)
            ? 'completado'
            : 'fallido';

        $respaldo = RespaldoBd::create([
            'nombre_archivo' => $fileName,
            'ruta_archivo'   => 'backups/' . $fileName,
            'tamanio_bytes'  => $estado === 'completado' ? filesize($filePath) : null,
            'tipo'           => 'manual',
            'estado'         => $estado,
            'notas'          => $estado === 'fallido'
                ? 'Error (código ' . $code . '): ' . implode(' ', $output)
                : $request->notas,
            'generado_por'   => auth()->id(),
            'created_at'     => now(),
        ]);

        BitacoraAuditoria::registrar(
            'exportar',
            'respaldos_bd',
            'Respaldo de base de datos ' . ($estado === 'completado' ? 'generado exitosamente' : 'falló') . ': ' . $fileName,
            $respaldo->id,
            [],
            ['archivo' => $fileName, 'estado' => $estado]
        );

        if ($estado === 'completado') {
            return redirect()->route('respaldos.index')
                ->with('success', 'Respaldo generado exitosamente: ' . $fileName);
        }

        return redirect()->route('respaldos.index')
            ->with('error', 'Error al generar el respaldo. Verifica los permisos de MySQL y la configuración.');
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

        return response()->download($path, $respaldo->nombre_archivo);
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

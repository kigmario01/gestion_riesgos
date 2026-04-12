<?php

namespace App\Http\Controllers;

use App\Models\BitacoraAuditoria;
use Illuminate\Http\Request;

class BitacoraController extends Controller
{
    public function index(Request $request)
    {
        $query = BitacoraAuditoria::with('usuario')->orderBy('created_at', 'desc');

        if ($request->filled('accion')) {
            $query->where('accion', $request->accion);
        }
        if ($request->filled('modulo')) {
            $query->where('modulo', $request->modulo);
        }
        if ($request->filled('buscar')) {
            $query->where('descripcion', 'like', '%' . $request->buscar . '%')
                  ->orWhere('user_nombre', 'like', '%' . $request->buscar . '%');
        }

        $logs = $query->paginate(20);
        return view('bitacora.index', compact('logs'));
    }
}

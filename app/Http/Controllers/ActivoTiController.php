<?php

namespace App\Http\Controllers;

use App\Models\ActivoTi;
use App\Models\BitacoraAuditoria;
use Illuminate\Http\Request;

class ActivoTiController extends Controller
{
    public function index()
    {
        $activos = ActivoTi::with('registrador')
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('activos.index', compact('activos'));
    }

    public function create()
    {
        return view('activos.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre'         => 'required|string|max:255',
            'codigo'         => 'required|string|max:50|unique:activos_ti,codigo',
            'tipo'           => 'required|in:hardware,software,red,datos,servicios,personas,instalaciones',
            'descripcion'    => 'nullable|string',
            'ubicacion'      => 'nullable|string|max:255',
            'responsable'    => 'nullable|string|max:255',
            'criticidad'     => 'required|in:baja,media,alta,critica',
            'estado'         => 'required|in:activo,inactivo,en_mantenimiento',
            'valor_economico'=> 'nullable|numeric|min:0',
        ]);

        $activo = ActivoTi::create([
            ...$request->only([
                'nombre', 'codigo', 'tipo', 'descripcion',
                'ubicacion', 'responsable', 'criticidad',
                'estado', 'valor_economico',
            ]),
            'registrado_por' => auth()->id(),
        ]);

        BitacoraAuditoria::registrar(
            'crear', 'activos_ti',
            "Creó el activo: {$activo->nombre} ({$activo->codigo})",
            $activo->id,
            [],
            $activo->toArray()
        );

        return redirect()->route('activos.index')
            ->with('success', "Activo '{$activo->nombre}' registrado correctamente.");
    }

    public function show(ActivoTi $activo)
    {
        $activo->load(['registrador', 'evaluaciones.amenaza']);
        return view('activos.show', compact('activo'));
    }

    public function edit(ActivoTi $activo)
    {
        return view('activos.edit', compact('activo'));
    }

    public function update(Request $request, ActivoTi $activo)
    {
        $request->validate([
            'nombre'         => 'required|string|max:255',
            'codigo'         => 'required|string|max:50|unique:activos_ti,codigo,' . $activo->id,
            'tipo'           => 'required|in:hardware,software,red,datos,servicios,personas,instalaciones',
            'descripcion'    => 'nullable|string',
            'ubicacion'      => 'nullable|string|max:255',
            'responsable'    => 'nullable|string|max:255',
            'criticidad'     => 'required|in:baja,media,alta,critica',
            'estado'         => 'required|in:activo,inactivo,en_mantenimiento',
            'valor_economico'=> 'nullable|numeric|min:0',
        ]);

        $anterior = $activo->toArray();

        $activo->update($request->only([
            'nombre', 'codigo', 'tipo', 'descripcion',
            'ubicacion', 'responsable', 'criticidad',
            'estado', 'valor_economico',
        ]));

        BitacoraAuditoria::registrar(
            'editar', 'activos_ti',
            "Editó el activo: {$activo->nombre} ({$activo->codigo})",
            $activo->id,
            $anterior,
            $activo->toArray()
        );

        return redirect()->route('activos.index')
            ->with('success', "Activo '{$activo->nombre}' actualizado correctamente.");
    }

    public function destroy(ActivoTi $activo)
    {
        BitacoraAuditoria::registrar(
            'eliminar', 'activos_ti',
            "Eliminó el activo: {$activo->nombre} ({$activo->codigo})",
            $activo->id,
            $activo->toArray()
        );

        $activo->delete();

        return redirect()->route('activos.index')
            ->with('success', "Activo '{$activo->nombre}' eliminado correctamente.");
    }
}

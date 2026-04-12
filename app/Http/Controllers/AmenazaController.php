<?php

namespace App\Http\Controllers;

use App\Models\Amenaza;
use App\Models\BitacoraAuditoria;
use Illuminate\Http\Request;

class AmenazaController extends Controller
{
    public function index()
    {
        $amenazas = Amenaza::with('registrador')
            ->orderBy('created_at', 'desc')
            ->paginate(10);
        return view('amenazas.index', compact('amenazas'));
    }

    public function create()
    {
        return view('amenazas.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre'    => 'required|string|max:255',
            'codigo'    => 'required|string|max:50|unique:amenazas,codigo',
            'categoria' => 'required|in:accidental,deliberada,ambiental,tecnica,humana',
            'origen'    => 'required|in:interno,externo,natural',
            'descripcion' => 'nullable|string',
            'estado'    => 'required|in:activa,inactiva',
        ]);

        $amenaza = Amenaza::create([
            ...$request->only(['nombre','codigo','categoria','origen','descripcion','estado']),
            'registrado_por' => auth()->id(),
        ]);

        BitacoraAuditoria::registrar('crear', 'amenazas', "Creó la amenaza: {$amenaza->nombre} ({$amenaza->codigo})", $amenaza->id, [], $amenaza->toArray());

        return redirect()->route('amenazas.index')->with('success', "Amenaza '{$amenaza->nombre}' registrada correctamente.");
    }

    public function show(Amenaza $amenaza)
    {
        $amenaza->load(['registrador', 'evaluaciones.activo']);
        return view('amenazas.show', compact('amenaza'));
    }

    public function edit(Amenaza $amenaza)
    {
        return view('amenazas.edit', compact('amenaza'));
    }

    public function update(Request $request, Amenaza $amenaza)
    {
        $request->validate([
            'nombre'    => 'required|string|max:255',
            'codigo'    => 'required|string|max:50|unique:amenazas,codigo,' . $amenaza->id,
            'categoria' => 'required|in:accidental,deliberada,ambiental,tecnica,humana',
            'origen'    => 'required|in:interno,externo,natural',
            'descripcion' => 'nullable|string',
            'estado'    => 'required|in:activa,inactiva',
        ]);

        $anterior = $amenaza->toArray();
        $amenaza->update($request->only(['nombre','codigo','categoria','origen','descripcion','estado']));
        BitacoraAuditoria::registrar('editar', 'amenazas', "Editó la amenaza: {$amenaza->nombre}", $amenaza->id, $anterior, $amenaza->toArray());

        return redirect()->route('amenazas.index')->with('success', "Amenaza '{$amenaza->nombre}' actualizada correctamente.");
    }

    public function destroy(Amenaza $amenaza)
    {
        BitacoraAuditoria::registrar('eliminar', 'amenazas', "Eliminó la amenaza: {$amenaza->nombre}", $amenaza->id, $amenaza->toArray());
        $amenaza->delete();
        return redirect()->route('amenazas.index')->with('success', "Amenaza eliminada correctamente.");
    }
}

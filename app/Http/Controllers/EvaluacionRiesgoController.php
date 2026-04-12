<?php

namespace App\Http\Controllers;

use App\Models\EvaluacionRiesgo;
use App\Models\ActivoTi;
use App\Models\Amenaza;
use App\Models\BitacoraAuditoria;
use Illuminate\Http\Request;

class EvaluacionRiesgoController extends Controller
{
    public function index()
    {
        $evaluaciones = EvaluacionRiesgo::with(['activo', 'amenaza', 'evaluador'])
            ->orderBy('created_at', 'desc')
            ->paginate(10);
        return view('evaluaciones.index', compact('evaluaciones'));
    }

    public function create()
    {
        $activos  = ActivoTi::where('estado', 'activo')->orderBy('nombre')->get();
        $amenazas = Amenaza::where('estado', 'activa')->orderBy('nombre')->get();
        return view('evaluaciones.create', compact('activos', 'amenazas'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'activo_id'    => 'required|exists:activos_ti,id',
            'amenaza_id'   => 'required|exists:amenazas,id',
            'impacto'      => 'required|integer|min:1|max:5',
            'probabilidad' => 'required|integer|min:1|max:5',
            'vulnerabilidades'     => 'nullable|string',
            'controles_existentes' => 'nullable|string',
            'observaciones'        => 'nullable|string',
            'fecha_evaluacion'     => 'required|date',
            'proxima_revision'     => 'nullable|date',
        ]);

        // Calcular riesgo automáticamente
        $calculo = EvaluacionRiesgo::calcularNivel($request->impacto, $request->probabilidad);

        // Generar código automático
        $ultimo = EvaluacionRiesgo::withTrashed()->count() + 1;
        $codigo = 'EVA-' . str_pad($ultimo, 3, '0', STR_PAD_LEFT);

        $evaluacion = EvaluacionRiesgo::create([
            'codigo'               => $codigo,
            'activo_id'            => $request->activo_id,
            'amenaza_id'           => $request->amenaza_id,
            'impacto'              => $request->impacto,
            'probabilidad'         => $request->probabilidad,
            'valor_riesgo'         => $calculo['valor'],
            'nivel_riesgo'         => $calculo['nivel'],
            'vulnerabilidades'     => $request->vulnerabilidades,
            'controles_existentes' => $request->controles_existentes,
            'observaciones'        => $request->observaciones,
            'fecha_evaluacion'     => $request->fecha_evaluacion,
            'proxima_revision'     => $request->proxima_revision,
            'estado'               => 'activa',
            'evaluado_por'         => auth()->id(),
        ]);

        BitacoraAuditoria::registrar('calcular_riesgo', 'evaluaciones_riesgo', "Creó evaluación {$codigo} — Nivel: " . strtoupper($calculo['nivel']), $evaluacion->id, [], $evaluacion->toArray());

        return redirect()->route('evaluaciones.index')->with('success', "Evaluación {$codigo} creada. Nivel de riesgo: " . strtoupper($calculo['nivel']));
    }

    public function show(EvaluacionRiesgo $evaluacion)
    {
        $evaluacion->load(['activo', 'amenaza', 'evaluador', 'planes']);
        return view('evaluaciones.show', compact('evaluacion'));
    }

    public function edit(EvaluacionRiesgo $evaluacion)
    {
        $activos  = ActivoTi::where('estado', 'activo')->orderBy('nombre')->get();
        $amenazas = Amenaza::where('estado', 'activa')->orderBy('nombre')->get();
        return view('evaluaciones.edit', compact('evaluacion', 'activos', 'amenazas'));
    }

    public function update(Request $request, EvaluacionRiesgo $evaluacion)
    {
        $request->validate([
            'activo_id'    => 'required|exists:activos_ti,id',
            'amenaza_id'   => 'required|exists:amenazas,id',
            'impacto'      => 'required|integer|min:1|max:5',
            'probabilidad' => 'required|integer|min:1|max:5',
            'vulnerabilidades'     => 'nullable|string',
            'controles_existentes' => 'nullable|string',
            'observaciones'        => 'nullable|string',
            'fecha_evaluacion'     => 'required|date',
            'proxima_revision'     => 'nullable|date',
            'estado'               => 'required|in:borrador,activa,cerrada,reevaluacion',
        ]);

        $calculo  = EvaluacionRiesgo::calcularNivel($request->impacto, $request->probabilidad);
        $anterior = $evaluacion->toArray();

        $evaluacion->update([
            'activo_id'            => $request->activo_id,
            'amenaza_id'           => $request->amenaza_id,
            'impacto'              => $request->impacto,
            'probabilidad'         => $request->probabilidad,
            'valor_riesgo'         => $calculo['valor'],
            'nivel_riesgo'         => $calculo['nivel'],
            'vulnerabilidades'     => $request->vulnerabilidades,
            'controles_existentes' => $request->controles_existentes,
            'observaciones'        => $request->observaciones,
            'fecha_evaluacion'     => $request->fecha_evaluacion,
            'proxima_revision'     => $request->proxima_revision,
            'estado'               => $request->estado,
            'version'              => $evaluacion->version + 1,
        ]);

        BitacoraAuditoria::registrar('editar', 'evaluaciones_riesgo', "Actualizó evaluación {$evaluacion->codigo}", $evaluacion->id, $anterior, $evaluacion->toArray());

        return redirect()->route('evaluaciones.index')->with('success', "Evaluación actualizada. Nuevo nivel: " . strtoupper($calculo['nivel']));
    }

    public function destroy(EvaluacionRiesgo $evaluacion)
    {
        BitacoraAuditoria::registrar('eliminar', 'evaluaciones_riesgo', "Eliminó evaluación {$evaluacion->codigo}", $evaluacion->id, $evaluacion->toArray());
        $evaluacion->delete();
        return redirect()->route('evaluaciones.index')->with('success', 'Evaluación eliminada correctamente.');
    }
}

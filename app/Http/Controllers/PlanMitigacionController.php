<?php

namespace App\Http\Controllers;

use App\Models\PlanMitigacion;
use App\Models\EvaluacionRiesgo;
use App\Models\BitacoraAuditoria;
use Illuminate\Http\Request;

class PlanMitigacionController extends Controller
{
    public function index()
    {
        $planes = PlanMitigacion::with(['evaluacion.activo', 'evaluacion.amenaza', 'creador'])
            ->orderBy('created_at', 'desc')
            ->paginate(10);
        return view('mitigacion.index', compact('planes'));
    }

    public function create()
    {
        $evaluaciones = EvaluacionRiesgo::with(['activo', 'amenaza'])
            ->where('estado', 'activa')
            ->orderBy('nivel_riesgo')
            ->get();
        return view('mitigacion.create', compact('evaluaciones'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'evaluacion_id'      => 'required|exists:evaluaciones_riesgo,id',
            'titulo'             => 'required|string|max:255',
            'descripcion'        => 'required|string',
            'tipo_control'       => 'required|in:preventivo,detectivo,correctivo,disuasivo',
            'estrategia'         => 'required|in:reducir,transferir,aceptar,evitar',
            'acciones_requeridas'=> 'required|string',
            'responsable'        => 'required|string|max:255',
            'fecha_inicio'       => 'required|date',
            'fecha_limite'       => 'required|date|after:fecha_inicio',
            'prioridad'          => 'required|in:baja,media,alta,urgente',
        ]);

        $ultimo = PlanMitigacion::withTrashed()->count() + 1;
        $codigo = 'MIT-' . str_pad($ultimo, 3, '0', STR_PAD_LEFT);

        $plan = PlanMitigacion::create([
            ...$request->only(['evaluacion_id','titulo','descripcion','tipo_control','estrategia','acciones_requeridas','responsable','fecha_inicio','fecha_limite','prioridad']),
            'codigo'     => $codigo,
            'estado'     => 'pendiente',
            'creado_por' => auth()->id(),
        ]);

        BitacoraAuditoria::registrar('crear', 'planes_mitigacion', "Creó plan de mitigación: {$codigo}", $plan->id, [], $plan->toArray());

        return redirect()->route('mitigacion.index')->with('success', "Plan {$codigo} creado correctamente.");
    }

    public function show(PlanMitigacion $mitigacion)
    {
        $mitigacion->load(['evaluacion.activo', 'evaluacion.amenaza', 'creador', 'aprobador']);
        return view('mitigacion.show', compact('mitigacion'));
    }

    public function edit(PlanMitigacion $mitigacion)
    {
        $evaluaciones = EvaluacionRiesgo::with(['activo', 'amenaza'])->where('estado', 'activa')->get();
        return view('mitigacion.edit', compact('mitigacion', 'evaluaciones'));
    }

    public function update(Request $request, PlanMitigacion $mitigacion)
    {
        $request->validate([
            'titulo'             => 'required|string|max:255',
            'descripcion'        => 'required|string',
            'tipo_control'       => 'required|in:preventivo,detectivo,correctivo,disuasivo',
            'estrategia'         => 'required|in:reducir,transferir,aceptar,evitar',
            'acciones_requeridas'=> 'required|string',
            'responsable'        => 'required|string|max:255',
            'fecha_inicio'       => 'required|date',
            'fecha_limite'       => 'required|date',
            'prioridad'          => 'required|in:baja,media,alta,urgente',
            'estado'             => 'required|in:pendiente,en_progreso,completado,cancelado,vencido',
            'porcentaje_avance'  => 'required|integer|min:0|max:100',
        ]);

        $anterior = $mitigacion->toArray();
        $mitigacion->update($request->only(['titulo','descripcion','tipo_control','estrategia','acciones_requeridas','responsable','fecha_inicio','fecha_limite','prioridad','estado','porcentaje_avance','evidencias']));
        BitacoraAuditoria::registrar('editar', 'planes_mitigacion', "Actualizó plan {$mitigacion->codigo}", $mitigacion->id, $anterior, $mitigacion->toArray());

        return redirect()->route('mitigacion.index')->with('success', "Plan actualizado correctamente.");
    }

    public function aprobar(PlanMitigacion $mitigacion)
    {
        $mitigacion->update([
            'aprobado_por'    => auth()->id(),
            'fecha_aprobacion'=> now(),
            'estado'          => 'en_progreso',
        ]);
        BitacoraAuditoria::registrar('aprobar', 'planes_mitigacion', "Aprobó plan {$mitigacion->codigo}", $mitigacion->id);
        return redirect()->route('mitigacion.index')->with('success', "Plan {$mitigacion->codigo} aprobado.");
    }

    public function destroy(PlanMitigacion $mitigacion)
    {
        BitacoraAuditoria::registrar('eliminar', 'planes_mitigacion', "Eliminó plan {$mitigacion->codigo}", $mitigacion->id, $mitigacion->toArray());
        $mitigacion->delete();
        return redirect()->route('mitigacion.index')->with('success', 'Plan eliminado correctamente.');
    }
}

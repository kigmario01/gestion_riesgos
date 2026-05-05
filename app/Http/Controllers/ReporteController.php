<?php

namespace App\Http\Controllers;

use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\ActivoTi;
use App\Models\Amenaza;
use App\Models\EvaluacionRiesgo;
use App\Models\PlanMitigacion;
use App\Models\BitacoraAuditoria;

class ReporteController extends Controller
{
    public function ejecutivo()
    {
        $riesgosNivel = EvaluacionRiesgo::where('estado', 'activa')
            ->groupBy('nivel_riesgo')
            ->selectRaw('nivel_riesgo, COUNT(*) as total')
            ->pluck('total', 'nivel_riesgo');

        $data = [
            'totalActivos'   => ActivoTi::count(),
            'totalAmenazas'  => Amenaza::where('estado', 'activa')->count(),
            'totalRiesgos'   => EvaluacionRiesgo::where('estado', 'activa')->count(),
            'totalPlanes'    => PlanMitigacion::count(),
            'critico'        => $riesgosNivel->get('critico', 0),
            'alto'           => $riesgosNivel->get('alto', 0),
            'medio'          => $riesgosNivel->get('medio', 0),
            'bajo'           => $riesgosNivel->get('bajo', 0),
            'planesEstado'   => PlanMitigacion::groupBy('estado')
                ->selectRaw('estado, COUNT(*) as total')->pluck('total', 'estado'),
            'riesgosRecientes' => EvaluacionRiesgo::with(['activo', 'amenaza'])
                ->where('estado', 'activa')->orderByDesc('created_at')->take(10)->get(),
            'generado_por'   => auth()->user()->name,
            'generado_en'    => now()->format('d/m/Y H:i'),
        ];

        $pdf = Pdf::loadView('reportes.ejecutivo', $data)->setPaper('a4', 'portrait');
        return $pdf->download('reporte-ejecutivo-' . now()->format('Ymd') . '.pdf');
    }

    public function activos()
    {
        $activos = ActivoTi::with('registrador')->orderBy('criticidad')->orderBy('nombre')->get();
        $pdf = Pdf::loadView('reportes.activos', [
            'activos'      => $activos,
            'generado_por' => auth()->user()->name,
            'generado_en'  => now()->format('d/m/Y H:i'),
        ])->setPaper('a4', 'landscape');
        return $pdf->download('reporte-activos-' . now()->format('Ymd') . '.pdf');
    }

    public function amenazas()
    {
        $amenazas = Amenaza::orderBy('categoria')->orderBy('nombre')->get();
        $pdf = Pdf::loadView('reportes.amenazas', [
            'amenazas'     => $amenazas,
            'generado_por' => auth()->user()->name,
            'generado_en'  => now()->format('d/m/Y H:i'),
        ])->setPaper('a4', 'landscape');
        return $pdf->download('reporte-amenazas-' . now()->format('Ymd') . '.pdf');
    }

    public function evaluaciones()
    {
        $evaluaciones = EvaluacionRiesgo::with(['activo', 'amenaza', 'evaluador'])
            ->orderByDesc('valor_riesgo')->orderBy('nivel_riesgo')->get();
        $pdf = Pdf::loadView('reportes.evaluaciones', [
            'evaluaciones' => $evaluaciones,
            'generado_por' => auth()->user()->name,
            'generado_en'  => now()->format('d/m/Y H:i'),
        ])->setPaper('a4', 'landscape');
        return $pdf->download('reporte-evaluaciones-' . now()->format('Ymd') . '.pdf');
    }

    public function mitigacion()
    {
        $planes = PlanMitigacion::with(['evaluacion.activo', 'evaluacion.amenaza', 'creador'])
            ->orderBy('prioridad')->orderBy('fecha_limite')->get();
        $pdf = Pdf::loadView('reportes.mitigacion', [
            'planes'       => $planes,
            'generado_por' => auth()->user()->name,
            'generado_en'  => now()->format('d/m/Y H:i'),
        ])->setPaper('a4', 'landscape');
        return $pdf->download('reporte-mitigacion-' . now()->format('Ymd') . '.pdf');
    }

    public function bitacora()
    {
        $logs = BitacoraAuditoria::with('usuario')->orderByDesc('created_at')->take(200)->get();
        $pdf = Pdf::loadView('reportes.bitacora', [
            'logs'         => $logs,
            'generado_por' => auth()->user()->name,
            'generado_en'  => now()->format('d/m/Y H:i'),
        ])->setPaper('a4', 'landscape');
        return $pdf->download('reporte-bitacora-' . now()->format('Ymd') . '.pdf');
    }
}

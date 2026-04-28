<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ActivoTi;
use App\Models\Amenaza;
use App\Models\EvaluacionRiesgo;
use App\Models\PlanMitigacion;
use App\Models\BitacoraAuditoria;

class DashboardController extends Controller
{
    public function index()
    {
        // Conteo de riesgos por nivel (1 sola query con groupBy)
        $riesgosNivel = EvaluacionRiesgo::where('estado', 'activa')
            ->groupBy('nivel_riesgo')
            ->selectRaw('nivel_riesgo, COUNT(*) as total')
            ->pluck('total', 'nivel_riesgo');

        $totalCritico = $riesgosNivel->get('critico', 0);
        $totalAlto    = $riesgosNivel->get('alto', 0);
        $totalMedio   = $riesgosNivel->get('medio', 0);
        $totalBajo    = $riesgosNivel->get('bajo', 0);

        // Totales generales (optimizados)
        $totalActivos   = ActivoTi::count();
        $totalAmenazas  = Amenaza::where('estado', 'activa')->count();
        $totalRiesgos   = EvaluacionRiesgo::where('estado', 'activa')->count();
        $totalPlanes    = PlanMitigacion::whereIn('estado', ['pendiente', 'en_progreso'])->count();

        // Últimos riesgos registrados (ya optimizado)
        $ultimosRiesgos = EvaluacionRiesgo::with(['activo', 'amenaza', 'evaluador'])
            ->where('estado', 'activa')
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        // Últimos registros de bitácora (ya optimizado)
        $ultimaBitacora = BitacoraAuditoria::with('usuario')
            ->orderBy('created_at', 'desc')
            ->take(6)
            ->get();

        return view('dashboard', compact(
            'totalCritico', 'totalAlto', 'totalMedio', 'totalBajo',
            'totalActivos', 'totalAmenazas', 'totalRiesgos', 'totalPlanes',
            'ultimosRiesgos', 'ultimaBitacora'
        ));
    }
}

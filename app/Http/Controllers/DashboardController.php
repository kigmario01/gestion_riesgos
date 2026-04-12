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
        // Conteo de riesgos por nivel
        $totalCritico = EvaluacionRiesgo::where('nivel_riesgo', 'critico')->where('estado', 'activa')->count();
        $totalAlto    = EvaluacionRiesgo::where('nivel_riesgo', 'alto')->where('estado', 'activa')->count();
        $totalMedio   = EvaluacionRiesgo::where('nivel_riesgo', 'medio')->where('estado', 'activa')->count();
        $totalBajo    = EvaluacionRiesgo::where('nivel_riesgo', 'bajo')->where('estado', 'activa')->count();

        // Totales generales
        $totalActivos   = ActivoTi::count();
        $totalAmenazas  = Amenaza::where('estado', 'activa')->count();
        $totalRiesgos   = EvaluacionRiesgo::where('estado', 'activa')->count();
        $totalPlanes    = PlanMitigacion::where('estado', 'pendiente')->orWhere('estado', 'en_progreso')->count();

        // Últimos riesgos registrados
        $ultimosRiesgos = EvaluacionRiesgo::with(['activo', 'amenaza', 'evaluador'])
            ->where('estado', 'activa')
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        // Últimos registros de bitácora
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

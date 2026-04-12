<?php

namespace App\Http\Controllers;

use App\Models\EvaluacionRiesgo;
use Illuminate\Http\Request;

class MatrizRiesgoController extends Controller
{
    public function index()
    {
        $evaluaciones = EvaluacionRiesgo::with(['activo', 'amenaza'])
            ->where('estado', 'activa')
            ->orderByDesc('valor_riesgo')
            ->get();

        // Agrupar por nivel
        $criticos = $evaluaciones->where('nivel_riesgo', 'critico');
        $altos    = $evaluaciones->where('nivel_riesgo', 'alto');
        $medios   = $evaluaciones->where('nivel_riesgo', 'medio');
        $bajos    = $evaluaciones->where('nivel_riesgo', 'bajo');

        // Construir matriz 5x5
        $matriz = [];
        for ($i = 1; $i <= 5; $i++) {
            for ($j = 1; $j <= 5; $j++) {
                $valor = $i * $j;
                $nivel = match(true) {
                    $valor >= 16 => 'critico',
                    $valor >= 10 => 'alto',
                    $valor >= 5  => 'medio',
                    default      => 'bajo',
                };
                $matriz[$i][$j] = [
                    'valor' => $valor,
                    'nivel' => $nivel,
                    'count' => $evaluaciones->where('impacto', $i)->where('probabilidad', $j)->count(),
                ];
            }
        }

        return view('matriz.index', compact('evaluaciones', 'criticos', 'altos', 'medios', 'bajos', 'matriz'));
    }
}

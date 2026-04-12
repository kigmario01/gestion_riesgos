<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class PlanMitigacion extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'planes_mitigacion';

    protected $fillable = [
        'codigo', 'evaluacion_id', 'titulo', 'descripcion',
        'tipo_control', 'estrategia', 'acciones_requeridas',
        'responsable', 'fecha_inicio', 'fecha_limite',
        'prioridad', 'estado', 'porcentaje_avance',
        'evidencias', 'aprobado_por', 'fecha_aprobacion', 'creado_por',
    ];

    protected $casts = [
        'fecha_inicio'     => 'date',
        'fecha_limite'     => 'date',
        'fecha_aprobacion' => 'datetime',
    ];

    public function evaluacion()
    {
        return $this->belongsTo(EvaluacionRiesgo::class, 'evaluacion_id');
    }

    public function creador()
    {
        return $this->belongsTo(User::class, 'creado_por');
    }

    public function aprobador()
    {
        return $this->belongsTo(User::class, 'aprobado_por');
    }
}

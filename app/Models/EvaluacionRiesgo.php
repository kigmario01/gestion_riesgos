<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class EvaluacionRiesgo extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'evaluaciones_riesgo';

    protected $fillable = [
        'codigo', 'activo_id', 'amenaza_id',
        'impacto', 'probabilidad', 'valor_riesgo', 'nivel_riesgo',
        'vulnerabilidades', 'controles_existentes', 'observaciones',
        'version', 'estado', 'fecha_evaluacion', 'proxima_revision',
        'evaluado_por',
    ];

    protected $casts = [
        'fecha_evaluacion' => 'date',
        'proxima_revision' => 'date',
    ];

    public function activo()
    {
        return $this->belongsTo(ActivoTi::class, 'activo_id');
    }

    public function amenaza()
    {
        return $this->belongsTo(Amenaza::class, 'amenaza_id');
    }

    public function evaluador()
    {
        return $this->belongsTo(User::class, 'evaluado_por');
    }

    public function planes()
    {
        return $this->hasMany(PlanMitigacion::class, 'evaluacion_id');
    }

    // Calcula automáticamente el nivel según el valor
    public static function calcularNivel(int $impacto, int $probabilidad): array
    {
        $valor = $impacto * $probabilidad;

        $nivel = match(true) {
            $valor >= 16 => 'critico',
            $valor >= 10 => 'alto',
            $valor >= 5  => 'medio',
            default      => 'bajo',
        };

        return ['valor' => $valor, 'nivel' => $nivel];
    }
}

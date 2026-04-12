<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class ActivoTi extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'activos_ti';

    protected $fillable = [
        'nombre', 'codigo', 'tipo', 'descripcion',
        'ubicacion', 'responsable', 'criticidad',
        'estado', 'valor_economico', 'registrado_por',
    ];

    public function registrador()
    {
        return $this->belongsTo(User::class, 'registrado_por');
    }

    public function evaluaciones()
    {
        return $this->hasMany(EvaluacionRiesgo::class, 'activo_id');
    }
}

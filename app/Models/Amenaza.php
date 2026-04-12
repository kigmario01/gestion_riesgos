<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class Amenaza extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'amenazas';

    protected $fillable = [
        'nombre', 'codigo', 'categoria',
        'origen', 'descripcion', 'estado', 'registrado_por',
    ];

    public function registrador()
    {
        return $this->belongsTo(User::class, 'registrado_por');
    }

    public function evaluaciones()
    {
        return $this->hasMany(EvaluacionRiesgo::class, 'amenaza_id');
    }
}

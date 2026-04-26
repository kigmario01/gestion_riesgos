<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RespaldoBd extends Model
{
    public $timestamps = false;

    protected $table = 'respaldos_bd';

    protected $fillable = [
        'nombre_archivo',
        'ruta_archivo',
        'tamanio_bytes',
        'tipo',
        'estado',
        'notas',
        'generado_por',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'tamanio_bytes' => 'integer',
    ];

    public function generador()
    {
        return $this->belongsTo(User::class, 'generado_por');
    }

    public function getTamanioFormateadoAttribute(): string
    {
        $bytes = $this->tamanio_bytes ?? 0;
        if ($bytes >= 1048576) return round($bytes / 1048576, 2) . ' MB';
        if ($bytes >= 1024)    return round($bytes / 1024, 1) . ' KB';
        return $bytes . ' B';
    }
}

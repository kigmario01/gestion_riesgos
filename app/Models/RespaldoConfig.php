<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RespaldoConfig extends Model
{
    protected $table = 'respaldo_config';

    protected $fillable = ['activo', 'frecuencia', 'hora', 'dia_semana', 'dia_mes', 'ultimo_ejecutado'];

    protected $casts = [
        'activo'          => 'boolean',
        'ultimo_ejecutado' => 'datetime',
    ];

    public static function instancia(): self
    {
        return self::firstOrCreate([], [
            'activo'     => false,
            'frecuencia' => 'diario',
            'hora'       => '02:00:00',
        ]);
    }
}

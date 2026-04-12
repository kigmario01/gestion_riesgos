<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BitacoraAuditoria extends Model
{
    protected $table = 'bitacora_auditoria';

    // Solo tiene created_at, no updated_at
    public $timestamps = false;

    protected $fillable = [
        'user_id', 'user_nombre', 'accion',
        'modulo', 'registro_id', 'descripcion',
        'datos_anteriores', 'datos_nuevos',
        'ip_address', 'user_agent',
    ];

    protected $casts = [
        'datos_anteriores' => 'array',
        'datos_nuevos'     => 'array',
        'created_at'       => 'datetime',
    ];

    public function usuario()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // Método estático para registrar fácilmente
    public static function registrar(string $accion, string $modulo, string $descripcion, ?int $registroId = null, array $datosAnteriores = [], array $datosNuevos = []): void
    {
        self::create([
            'user_id'          => auth()->id(),
            'user_nombre'      => auth()->user()?->name ?? 'Sistema',
            'accion'           => $accion,
            'modulo'           => $modulo,
            'registro_id'      => $registroId,
            'descripcion'      => $descripcion,
            'datos_anteriores' => $datosAnteriores ?: null,
            'datos_nuevos'     => $datosNuevos ?: null,
            'ip_address'       => request()->ip(),
            'user_agent'       => request()->userAgent(),
        ]);
    }
}

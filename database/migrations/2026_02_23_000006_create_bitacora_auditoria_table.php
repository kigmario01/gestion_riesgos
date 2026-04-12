<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Bitácora de auditoría — NUNCA se permite UPDATE ni DELETE.
     * Se llena automáticamente desde Observers en cada modelo.
     */
    public function up(): void
    {
        Schema::create('bitacora_auditoria', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained('users');
            $table->string('user_nombre')->nullable();
            $table->enum('accion', [
                'login',
                'logout',
                'login_fallido',
                'crear',
                'editar',
                'eliminar',
                'restaurar',
                'ver',
                'exportar',
                'calcular_riesgo',
                'aprobar',
                'rechazar'
            ]);
            $table->string('modulo');
            $table->unsignedBigInteger('registro_id')->nullable();
            $table->string('descripcion');
            $table->json('datos_anteriores')->nullable();
            $table->json('datos_nuevos')->nullable();
            $table->string('ip_address', 45)->nullable();
            $table->string('user_agent')->nullable();
            $table->timestamp('created_at')->useCurrent();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('bitacora_auditoria');
    }
};

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('planes_mitigacion', function (Blueprint $table) {
            $table->id();
            $table->string('codigo')->unique();
            $table->foreignId('evaluacion_id')->constrained('evaluaciones_riesgo');
            $table->string('titulo');
            $table->text('descripcion');
            $table->enum('tipo_control', [
                'preventivo',
                'detectivo',
                'correctivo',
                'disuasivo'
            ]);
            $table->enum('estrategia', [
                'reducir',
                'transferir',
                'aceptar',
                'evitar'
            ]);
            $table->text('acciones_requeridas');
            $table->string('responsable');
            $table->date('fecha_inicio');
            $table->date('fecha_limite');
            $table->enum('prioridad', ['baja', 'media', 'alta', 'urgente'])->default('media');
            $table->enum('estado', [
                'pendiente',
                'en_progreso',
                'completado',
                'cancelado',
                'vencido'
            ])->default('pendiente');
            $table->unsignedTinyInteger('porcentaje_avance')->default(0);
            $table->text('evidencias')->nullable();
            $table->foreignId('aprobado_por')->nullable()->constrained('users');
            $table->timestamp('fecha_aprobacion')->nullable();
            $table->foreignId('creado_por')->constrained('users');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('planes_mitigacion');
    }
};

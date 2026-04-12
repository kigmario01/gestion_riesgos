<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * FÓRMULA ISO 27001:
     *   Riesgo = Impacto × Probabilidad
     *   Escala: 1 a 5 en ambos factores → resultado: 1 a 25
     *
     * CLASIFICACIÓN:
     *   1  - 4  → BAJO
     *   5  - 9  → MEDIO
     *   10 - 15 → ALTO
     *   16 - 25 → CRÍTICO
     */
    public function up(): void
    {
        Schema::create('evaluaciones_riesgo', function (Blueprint $table) {
            $table->id();
            $table->string('codigo')->unique();
            $table->foreignId('activo_id')->constrained('activos_ti');
            $table->foreignId('amenaza_id')->constrained('amenazas');
            $table->unsignedTinyInteger('impacto');
            $table->unsignedTinyInteger('probabilidad');
            $table->unsignedTinyInteger('valor_riesgo');
            $table->enum('nivel_riesgo', ['bajo', 'medio', 'alto', 'critico']);
            $table->text('vulnerabilidades')->nullable();
            $table->text('controles_existentes')->nullable();
            $table->text('observaciones')->nullable();
            $table->unsignedInteger('version')->default(1);
            $table->enum('estado', ['borrador', 'activa', 'cerrada', 'reevaluacion'])->default('activa');
            $table->date('fecha_evaluacion');
            $table->date('proxima_revision')->nullable();
            $table->foreignId('evaluado_por')->constrained('users');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('evaluaciones_riesgo');
    }
};

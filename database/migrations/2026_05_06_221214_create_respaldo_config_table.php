<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('respaldo_config', function (Blueprint $table) {
            $table->id();
            $table->boolean('activo')->default(false);
            $table->enum('frecuencia', ['diario', 'semanal', 'mensual'])->default('diario');
            $table->time('hora')->default('02:00:00');
            $table->tinyInteger('dia_semana')->nullable(); // 0=domingo .. 6=sábado (para semanal)
            $table->tinyInteger('dia_mes')->nullable();    // 1-28 (para mensual)
            $table->timestamp('ultimo_ejecutado')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('respaldo_config');
    }
};

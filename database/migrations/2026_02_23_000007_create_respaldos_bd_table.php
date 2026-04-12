<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('respaldos_bd', function (Blueprint $table) {
            $table->id();
            $table->string('nombre_archivo');
            $table->string('ruta_archivo');
            $table->unsignedBigInteger('tamanio_bytes')->nullable();
            $table->enum('tipo', ['manual', 'automatico'])->default('manual');
            $table->enum('estado', ['completado', 'fallido', 'en_proceso'])->default('completado');
            $table->text('notas')->nullable();
            $table->foreignId('generado_por')->nullable()->constrained('users');
            $table->timestamp('created_at')->useCurrent();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('respaldos_bd');
    }
};

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('activos_ti', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->string('codigo')->unique();
            $table->enum('tipo', [
                'hardware',
                'software',
                'red',
                'datos',
                'servicios',
                'personas',
                'instalaciones'
            ]);
            $table->text('descripcion')->nullable();
            $table->string('ubicacion')->nullable();
            $table->string('responsable')->nullable();
            $table->enum('criticidad', ['baja', 'media', 'alta', 'critica'])->default('media');
            $table->enum('estado', ['activo', 'inactivo', 'en_mantenimiento'])->default('activo');
            $table->decimal('valor_economico', 12, 2)->nullable();
            $table->foreignId('registrado_por')->constrained('users');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('activos_ti');
    }
};

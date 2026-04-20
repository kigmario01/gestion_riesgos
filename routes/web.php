<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ActivoTiController;
use App\Http\Controllers\AmenazaController;
use App\Http\Controllers\EvaluacionRiesgoController;
use App\Http\Controllers\PlanMitigacionController;
use App\Http\Controllers\BitacoraController;
use App\Http\Controllers\MatrizRiesgoController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('login');
});

// Dashboard
Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware(['auth'])->group(function () {

    // Perfil
    Route::get('/profile',    [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile',  [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Activos TI
    Route::resource('activos', ActivoTiController::class);

    // Amenazas
    Route::resource('amenazas', AmenazaController::class);

    // Evaluaciones de Riesgo
    Route::resource('evaluaciones', EvaluacionRiesgoController::class);

    // Planes de Mitigación
    Route::resource('mitigacion', PlanMitigacionController::class);
    Route::post('mitigacion/{mitigacion}/aprobar', [PlanMitigacionController::class, 'aprobar'])->name('mitigacion.aprobar');

    // Matriz de Riesgos
    Route::get('matriz', [MatrizRiesgoController::class, 'index'])->name('matriz.index');

    // Bitácora
    Route::get('bitacora', [BitacoraController::class, 'index'])->name('bitacora.index');

    // Usuarios
    Route::resource('usuarios', \App\Http\Controllers\UsuarioController::class);
    Route::post('usuarios/{usuario}/toggle', [\App\Http\Controllers\UsuarioController::class, 'toggleActivo'])->name('usuarios.toggle');

    // Roles
    Route::resource('roles', \App\Http\Controllers\RolController::class)
        ->only(['index', 'show', 'edit', 'update'])
        ->parameters(['roles' => 'rol']);

});

require __DIR__.'/auth.php';

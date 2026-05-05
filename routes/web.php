<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ActivoTiController;
use App\Http\Controllers\AmenazaController;
use App\Http\Controllers\EvaluacionRiesgoController;
use App\Http\Controllers\PlanMitigacionController;
use App\Http\Controllers\BitacoraController;
use App\Http\Controllers\MatrizRiesgoController;
use App\Http\Controllers\RespaldoBdController;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\RolController;
use Illuminate\Support\Facades\Route;

Route::get('/', fn() => redirect()->route('login'));

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified', 'permission:dashboard.ver'])
    ->name('dashboard');

Route::middleware(['auth'])->group(function () {

    // Perfil
    Route::get('/profile',    [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile',  [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // ── Activos TI ──
    Route::middleware('permission:activos.ver')->group(function () {
        Route::get('activos',          [ActivoTiController::class, 'index'])->name('activos.index');
        Route::get('activos/{activo}', [ActivoTiController::class, 'show'])->name('activos.show');
    });
    Route::middleware('permission:activos.crear')->group(function () {
        Route::get('activos/create',         [ActivoTiController::class, 'create'])->name('activos.create');
        Route::post('activos',               [ActivoTiController::class, 'store'])->name('activos.store');
    });
    Route::middleware('permission:activos.editar')->group(function () {
        Route::get('activos/{activo}/edit',  [ActivoTiController::class, 'edit'])->name('activos.edit');
        Route::put('activos/{activo}',       [ActivoTiController::class, 'update'])->name('activos.update');
        Route::patch('activos/{activo}',     [ActivoTiController::class, 'update']);
    });
    Route::delete('activos/{activo}', [ActivoTiController::class, 'destroy'])
        ->middleware('permission:activos.eliminar')->name('activos.destroy');

    // ── Amenazas ──
    Route::middleware('permission:amenazas.ver')->group(function () {
        Route::get('amenazas',           [AmenazaController::class, 'index'])->name('amenazas.index');
        Route::get('amenazas/{amenaza}', [AmenazaController::class, 'show'])->name('amenazas.show');
    });
    Route::middleware('permission:amenazas.crear')->group(function () {
        Route::get('amenazas/create',        [AmenazaController::class, 'create'])->name('amenazas.create');
        Route::post('amenazas',              [AmenazaController::class, 'store'])->name('amenazas.store');
    });
    Route::middleware('permission:amenazas.editar')->group(function () {
        Route::get('amenazas/{amenaza}/edit', [AmenazaController::class, 'edit'])->name('amenazas.edit');
        Route::put('amenazas/{amenaza}',      [AmenazaController::class, 'update'])->name('amenazas.update');
        Route::patch('amenazas/{amenaza}',    [AmenazaController::class, 'update']);
    });
    Route::delete('amenazas/{amenaza}', [AmenazaController::class, 'destroy'])
        ->middleware('permission:amenazas.eliminar')->name('amenazas.destroy');

    // ── Evaluaciones ──
    Route::middleware('permission:evaluaciones.ver')->group(function () {
        Route::get('evaluaciones',             [EvaluacionRiesgoController::class, 'index'])->name('evaluaciones.index');
        Route::get('evaluaciones/{evaluacion}',[EvaluacionRiesgoController::class, 'show'])->name('evaluaciones.show');
    });
    Route::middleware('permission:evaluaciones.calcular')->group(function () {
        Route::get('evaluaciones/create',          [EvaluacionRiesgoController::class, 'create'])->name('evaluaciones.create');
        Route::post('evaluaciones',                [EvaluacionRiesgoController::class, 'store'])->name('evaluaciones.store');
    });
    Route::middleware('permission:evaluaciones.editar')->group(function () {
        Route::get('evaluaciones/{evaluacion}/edit', [EvaluacionRiesgoController::class, 'edit'])->name('evaluaciones.edit');
        Route::put('evaluaciones/{evaluacion}',      [EvaluacionRiesgoController::class, 'update'])->name('evaluaciones.update');
        Route::patch('evaluaciones/{evaluacion}',    [EvaluacionRiesgoController::class, 'update']);
        Route::delete('evaluaciones/{evaluacion}',   [EvaluacionRiesgoController::class, 'destroy'])->name('evaluaciones.destroy');
    });

    // ── Mitigación ──
    Route::middleware('permission:mitigacion.ver')->group(function () {
        Route::get('mitigacion',             [PlanMitigacionController::class, 'index'])->name('mitigacion.index');
        Route::get('mitigacion/{mitigacion}',[PlanMitigacionController::class, 'show'])->name('mitigacion.show');
    });
    Route::middleware('permission:mitigacion.crear')->group(function () {
        Route::get('mitigacion/create',       [PlanMitigacionController::class, 'create'])->name('mitigacion.create');
        Route::post('mitigacion',             [PlanMitigacionController::class, 'store'])->name('mitigacion.store');
    });
    Route::middleware('permission:mitigacion.editar')->group(function () {
        Route::get('mitigacion/{mitigacion}/edit', [PlanMitigacionController::class, 'edit'])->name('mitigacion.edit');
        Route::put('mitigacion/{mitigacion}',      [PlanMitigacionController::class, 'update'])->name('mitigacion.update');
        Route::patch('mitigacion/{mitigacion}',    [PlanMitigacionController::class, 'update']);
        Route::delete('mitigacion/{mitigacion}',   [PlanMitigacionController::class, 'destroy'])->name('mitigacion.destroy');
    });
    Route::post('mitigacion/{mitigacion}/aprobar', [PlanMitigacionController::class, 'aprobar'])
        ->middleware('permission:mitigacion.aprobar')->name('mitigacion.aprobar');

    // ── Matriz ──
    Route::get('matriz', [MatrizRiesgoController::class, 'index'])
        ->middleware('permission:matriz.ver')->name('matriz.index');

    // ── Bitácora ──
    Route::get('bitacora', [BitacoraController::class, 'index'])
        ->middleware('permission:bitacora.ver')->name('bitacora.index');

    // ── Usuarios ──
    Route::middleware('permission:usuarios.ver')->group(function () {
        Route::get('usuarios',           [UsuarioController::class, 'index'])->name('usuarios.index');
        Route::get('usuarios/{usuario}', [UsuarioController::class, 'show'])->name('usuarios.show');
    });
    Route::middleware('permission:usuarios.crear')->group(function () {
        Route::get('usuarios/create',    [UsuarioController::class, 'create'])->name('usuarios.create');
        Route::post('usuarios',          [UsuarioController::class, 'store'])->name('usuarios.store');
    });
    Route::middleware('permission:usuarios.editar')->group(function () {
        Route::get('usuarios/{usuario}/edit', [UsuarioController::class, 'edit'])->name('usuarios.edit');
        Route::put('usuarios/{usuario}',      [UsuarioController::class, 'update'])->name('usuarios.update');
        Route::patch('usuarios/{usuario}',    [UsuarioController::class, 'update']);
        Route::post('usuarios/{usuario}/toggle', [UsuarioController::class, 'toggleActivo'])->name('usuarios.toggle');
    });
    Route::delete('usuarios/{usuario}', [UsuarioController::class, 'destroy'])
        ->middleware('permission:usuarios.eliminar')->name('usuarios.destroy');

    // ── Roles ──
    Route::middleware('permission:roles.ver')->group(function () {
        Route::get('roles',        [RolController::class, 'index'])->name('roles.index');
        Route::get('roles/{rol}',  [RolController::class, 'show'])->name('roles.show');
    });
    Route::middleware('permission:roles.editar')->group(function () {
        Route::get('roles/{rol}/edit',  [RolController::class, 'edit'])->name('roles.edit');
        Route::put('roles/{rol}',       [RolController::class, 'update'])->name('roles.update');
        Route::patch('roles/{rol}',     [RolController::class, 'update']);
    });

    // ── Respaldos ──
    Route::get('respaldos', [RespaldoBdController::class, 'index'])
        ->middleware('permission:basedatos.ver')->name('respaldos.index');
    Route::post('respaldos', [RespaldoBdController::class, 'store'])
        ->middleware('permission:basedatos.respaldar')->name('respaldos.store');
    Route::get('respaldos/{respaldo}/download', [RespaldoBdController::class, 'download'])
        ->middleware('permission:basedatos.respaldar')->name('respaldos.download');
    Route::delete('respaldos/{respaldo}', [RespaldoBdController::class, 'destroy'])
        ->middleware('permission:basedatos.configurar')->name('respaldos.destroy');

});

require __DIR__.'/auth.php';

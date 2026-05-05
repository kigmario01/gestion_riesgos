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
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('login');
});

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified', 'permission:dashboard.ver'])
    ->name('dashboard');

Route::middleware(['auth'])->group(function () {

    // Perfil — acceso libre para cualquier usuario autenticado
    Route::get('/profile',    [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile',  [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Activos TI
    Route::resource('activos', ActivoTiController::class)->middleware([
        'index'   => 'permission:activos.ver',
        'show'    => 'permission:activos.ver',
        'create'  => 'permission:activos.crear',
        'store'   => 'permission:activos.crear',
        'edit'    => 'permission:activos.editar',
        'update'  => 'permission:activos.editar',
        'destroy' => 'permission:activos.eliminar',
    ]);

    // Amenazas
    Route::resource('amenazas', AmenazaController::class)->middleware([
        'index'   => 'permission:amenazas.ver',
        'show'    => 'permission:amenazas.ver',
        'create'  => 'permission:amenazas.crear',
        'store'   => 'permission:amenazas.crear',
        'edit'    => 'permission:amenazas.editar',
        'update'  => 'permission:amenazas.editar',
        'destroy' => 'permission:amenazas.eliminar',
    ]);

    // Evaluaciones de Riesgo
    Route::resource('evaluaciones', EvaluacionRiesgoController::class)->middleware([
        'index'   => 'permission:evaluaciones.ver',
        'show'    => 'permission:evaluaciones.ver',
        'create'  => 'permission:evaluaciones.calcular',
        'store'   => 'permission:evaluaciones.calcular',
        'edit'    => 'permission:evaluaciones.editar',
        'update'  => 'permission:evaluaciones.editar',
        'destroy' => 'permission:evaluaciones.editar',
    ]);

    // Planes de Mitigación
    Route::resource('mitigacion', PlanMitigacionController::class)->middleware([
        'index'   => 'permission:mitigacion.ver',
        'show'    => 'permission:mitigacion.ver',
        'create'  => 'permission:mitigacion.crear',
        'store'   => 'permission:mitigacion.crear',
        'edit'    => 'permission:mitigacion.editar',
        'update'  => 'permission:mitigacion.editar',
        'destroy' => 'permission:mitigacion.editar',
    ]);
    Route::post('mitigacion/{mitigacion}/aprobar', [PlanMitigacionController::class, 'aprobar'])
        ->middleware('permission:mitigacion.aprobar')
        ->name('mitigacion.aprobar');

    // Matriz de Riesgos
    Route::get('matriz', [MatrizRiesgoController::class, 'index'])
        ->middleware('permission:matriz.ver')
        ->name('matriz.index');

    // Bitácora
    Route::get('bitacora', [BitacoraController::class, 'index'])
        ->middleware('permission:bitacora.ver')
        ->name('bitacora.index');

    // Usuarios
    Route::resource('usuarios', \App\Http\Controllers\UsuarioController::class)->middleware([
        'index'   => 'permission:usuarios.ver',
        'show'    => 'permission:usuarios.ver',
        'create'  => 'permission:usuarios.crear',
        'store'   => 'permission:usuarios.crear',
        'edit'    => 'permission:usuarios.editar',
        'update'  => 'permission:usuarios.editar',
        'destroy' => 'permission:usuarios.eliminar',
    ]);
    Route::post('usuarios/{usuario}/toggle', [\App\Http\Controllers\UsuarioController::class, 'toggleActivo'])
        ->middleware('permission:usuarios.editar')
        ->name('usuarios.toggle');

    // Roles
    Route::resource('roles', \App\Http\Controllers\RolController::class)
        ->only(['index', 'show', 'edit', 'update'])
        ->parameters(['roles' => 'rol'])
        ->middleware([
            'index'  => 'permission:roles.ver',
            'show'   => 'permission:roles.ver',
            'edit'   => 'permission:roles.editar',
            'update' => 'permission:roles.editar',
        ]);

    // Respaldo BD
    Route::get('respaldos', [RespaldoBdController::class, 'index'])
        ->middleware('permission:basedatos.ver')
        ->name('respaldos.index');
    Route::post('respaldos', [RespaldoBdController::class, 'store'])
        ->middleware('permission:basedatos.respaldar')
        ->name('respaldos.store');
    Route::get('respaldos/{respaldo}/download', [RespaldoBdController::class, 'download'])
        ->middleware('permission:basedatos.respaldar')
        ->name('respaldos.download');
    Route::delete('respaldos/{respaldo}', [RespaldoBdController::class, 'destroy'])
        ->middleware('permission:basedatos.configurar')
        ->name('respaldos.destroy');

});

require __DIR__.'/auth.php';

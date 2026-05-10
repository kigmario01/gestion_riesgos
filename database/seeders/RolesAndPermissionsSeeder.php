<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolesAndPermissionsSeeder extends Seeder
{
    public function run(): void
    {
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // PERMISOS
        $permisos = [
            'activos.ver', 'activos.crear', 'activos.editar', 'activos.eliminar',
            'amenazas.ver', 'amenazas.crear', 'amenazas.editar', 'amenazas.eliminar',
            'evaluaciones.ver', 'evaluaciones.crear', 'evaluaciones.editar', 'evaluaciones.calcular',
            'mitigacion.ver', 'mitigacion.crear', 'mitigacion.editar', 'mitigacion.aprobar',
            'matriz.ver', 'matriz.exportar',
            'reportes.generar',
            'bitacora.ver',
            'evidencias.ver', 'evidencias.aprobar',
            'usuarios.ver', 'usuarios.crear', 'usuarios.editar', 'usuarios.eliminar',
            'roles.ver', 'roles.editar',
            'basedatos.ver', 'basedatos.configurar', 'basedatos.respaldar',
            'dashboard.ver',
        ];

        foreach ($permisos as $permiso) {
            Permission::firstOrCreate(['name' => $permiso, 'guard_name' => 'web']);
        }

        // ROLES — syncPermissions solo si el rol se acaba de crear
        // Si el rol ya existe en BD, no se sobreescriben los permisos modificados desde la UI
        $po = Role::firstOrCreate(['name' => 'product_owner', 'guard_name' => 'web']);
        if ($po->wasRecentlyCreated) {
            $po->syncPermissions([
                'dashboard.ver', 'activos.ver', 'amenazas.ver', 'evaluaciones.ver',
                'mitigacion.ver', 'mitigacion.aprobar', 'matriz.ver', 'matriz.exportar',
                'reportes.generar', 'bitacora.ver',
                'usuarios.ver', 'roles.ver', 'evidencias.ver',
            ]);
        }

        $sm = Role::firstOrCreate(['name' => 'scrum_master', 'guard_name' => 'web']);
        if ($sm->wasRecentlyCreated) {
            $sm->syncPermissions([
                'dashboard.ver', 'activos.ver', 'amenazas.ver', 'evaluaciones.ver',
                'mitigacion.ver', 'matriz.ver', 'matriz.exportar',
                'reportes.generar', 'bitacora.ver',
                'usuarios.ver', 'roles.ver',
            ]);
        }

        $frontend = Role::firstOrCreate(['name' => 'frontend', 'guard_name' => 'web']);
        if ($frontend->wasRecentlyCreated) {
            $frontend->syncPermissions([
                'dashboard.ver', 'activos.ver', 'amenazas.ver', 'evaluaciones.ver',
                'mitigacion.ver', 'matriz.ver', 'matriz.exportar', 'reportes.generar',
            ]);
        }

        $backend = Role::firstOrCreate(['name' => 'backend', 'guard_name' => 'web']);
        if ($backend->wasRecentlyCreated) {
            $backend->syncPermissions([
                'dashboard.ver',
                'activos.ver', 'activos.crear', 'activos.editar', 'activos.eliminar',
                'amenazas.ver', 'amenazas.crear', 'amenazas.editar', 'amenazas.eliminar',
                'evaluaciones.ver', 'evaluaciones.crear', 'evaluaciones.editar', 'evaluaciones.calcular',
                'mitigacion.ver', 'mitigacion.crear', 'mitigacion.editar', 'mitigacion.aprobar',
                'matriz.ver', 'matriz.exportar', 'reportes.generar',
                'bitacora.ver',
                'usuarios.ver', 'usuarios.crear', 'usuarios.editar', 'usuarios.eliminar',
                'roles.ver', 'roles.editar',
                'basedatos.ver', 'basedatos.respaldar', 'basedatos.configurar',
            ]);
        }

        $bd = Role::firstOrCreate(['name' => 'base_datos', 'guard_name' => 'web']);
        if ($bd->wasRecentlyCreated) {
            $bd->syncPermissions([
                'dashboard.ver', 'activos.ver', 'activos.crear', 'activos.editar',
                'amenazas.ver', 'amenazas.crear', 'evaluaciones.ver', 'mitigacion.ver',
                'matriz.ver', 'matriz.exportar', 'reportes.generar', 'usuarios.ver',
                'basedatos.ver', 'basedatos.configurar', 'basedatos.respaldar',
            ]);
        }

        $auditoria = Role::firstOrCreate(['name' => 'auditoria', 'guard_name' => 'web']);
        if ($auditoria->wasRecentlyCreated) {
            $auditoria->syncPermissions([
                'dashboard.ver', 'activos.ver', 'amenazas.ver', 'evaluaciones.ver',
                'mitigacion.ver', 'mitigacion.aprobar', 'matriz.ver', 'matriz.exportar',
                'reportes.generar', 'bitacora.ver',
                'evidencias.ver', 'evidencias.aprobar',
                'usuarios.ver', 'roles.ver',
            ]);
        }

        // USUARIOS DE PRUEBA
        $admin = User::firstOrCreate(
            ['email' => 'admin@gestion.com'],
            [
                'name'     => 'Administrador',
                'password' => Hash::make('Admin1234!'),
                'activo'   => true,
            ]
        );
        $admin->syncRoles(['backend', 'auditoria']);

        $mario = User::firstOrCreate(
            ['email' => 'mario.alvarez@gestion.com'],
            [
                'name'     => 'Mario Álvarez',
                'password' => Hash::make('Scrum1234!'),
                'activo'   => true,
            ]
        );
        $mario->assignRole('scrum_master');

        $this->command->info('✅ Roles, permisos y usuarios creados correctamente.');
    }
}

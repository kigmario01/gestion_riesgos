<?php

use Illuminate\Database\Migrations\Migration;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

return new class extends Migration
{
    public function up(): void
    {
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        $perm = Permission::firstOrCreate(['name' => 'reportes.generar', 'guard_name' => 'web']);

        // Eliminar permisos obsoletos si existen
        foreach (['reportes.ver', 'reportes.exportar'] as $old) {
            Permission::where('name', $old)->delete();
        }

        // Asignar a todos los roles que deben tener acceso
        $rolesConReportes = ['product_owner', 'scrum_master', 'frontend', 'backend', 'base_datos', 'auditoria'];
        foreach ($rolesConReportes as $rolName) {
            $rol = Role::where('name', $rolName)->where('guard_name', 'web')->first();
            if ($rol && !$rol->hasPermissionTo('reportes.generar')) {
                $rol->givePermissionTo($perm);
            }
        }

        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();
    }

    public function down(): void
    {
        Permission::where('name', 'reportes.generar')->delete();
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();
    }
};

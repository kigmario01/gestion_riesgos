<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class FixAdminPerms extends Command
{
    protected $signature = 'app:fix-admin-perms {email? : Email del usuario admin}';
    protected $description = 'Restaura todos los permisos al rol backend y lo asigna al admin';

    public function handle()
    {
        app()['\Spatie\Permission\PermissionRegistrar']->forgetCachedPermissions();

        $email = $this->argument('email') ?? 'admin@gestion.com';
        $admin = User::where('email', $email)->first();

        if (!$admin) {
            $this->error("Usuario {$email} no encontrado.");
            return 1;
        }

        $this->info("Usuario encontrado: {$admin->name} ({$admin->email})");
        $this->info("Roles actuales: " . implode(', ', $admin->getRoleNames()->toArray()));

        // Asegurar que el rol backend tiene todos los permisos
        $backend = Role::where('name', 'backend')->where('guard_name', 'web')->first();
        if (!$backend) {
            $this->error("Rol backend no encontrado.");
            return 1;
        }

        $todosLosPermisos = Permission::where('guard_name', 'web')->pluck('name')->toArray();
        $backend->syncPermissions($todosLosPermisos);
        $this->info("Rol backend actualizado con " . count($todosLosPermisos) . " permisos.");

        // Asegurar que el admin tiene el rol backend
        if (!$admin->hasRole('backend')) {
            $admin->assignRole('backend');
            $this->info("Rol backend asignado al usuario.");
        }

        app()['\Spatie\Permission\PermissionRegistrar']->forgetCachedPermissions();

        $this->info("Permisos del rol backend: " . implode(', ', $backend->fresh()->permissions->pluck('name')->toArray()));
        $this->info("Listo. El usuario {$admin->name} ahora tiene acceso completo.");

        return 0;
    }
}

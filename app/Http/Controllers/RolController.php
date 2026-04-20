<?php

namespace App\Http\Controllers;

use App\Models\BitacoraAuditoria;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolController extends Controller
{
    public function index()
    {
        $roles = Role::withCount(['users', 'permissions'])->orderBy('name')->get();
        return view('roles.index', compact('roles'));
    }

    public function show(Role $rol)
    {
        $rol->load(['permissions', 'users']);
        $permisosPorModulo = Permission::orderBy('name')->get()->groupBy(function ($p) {
            return explode('.', $p->name)[0];
        });
        return view('roles.show', compact('rol', 'permisosPorModulo'));
    }

    public function edit(Role $rol)
    {
        $rol->load('permissions');
        $permisosPorModulo = Permission::orderBy('name')->get()->groupBy(function ($p) {
            return explode('.', $p->name)[0];
        });
        return view('roles.edit', compact('rol', 'permisosPorModulo'));
    }

    public function update(Request $request, Role $rol)
    {
        $request->validate([
            'permissions'   => 'nullable|array',
            'permissions.*' => 'exists:permissions,name',
        ]);

        $anterior = $rol->permissions->pluck('name')->toArray();
        $rol->syncPermissions($request->permissions ?? []);

        BitacoraAuditoria::registrar(
            'editar', 'roles',
            "Actualizó permisos del rol: {$rol->name}",
            $rol->id,
            ['permissions' => $anterior],
            ['permissions' => $request->permissions ?? []]
        );

        return redirect()->route('roles.show', $rol)
            ->with('success', "Permisos del rol '{$rol->name}' actualizados correctamente.");
    }
}

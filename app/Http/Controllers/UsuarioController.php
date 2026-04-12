<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\BitacoraAuditoria;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class UsuarioController extends Controller
{
    public function index()
    {
        $usuarios = User::with('roles')
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('usuarios.index', compact('usuarios'));
    }

    public function create()
    {
        $roles = Role::orderBy('name')->get();
        return view('usuarios.create', compact('roles'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
            'role'     => 'required|exists:roles,name',
        ]);

        $usuario = User::create([
            'name'               => $request->name,
            'email'              => $request->email,
            'password'           => Hash::make($request->password),
            'activo'             => true,
            'email_verified_at'  => now(),
        ]);

        $usuario->assignRole($request->role);

        BitacoraAuditoria::registrar(
            'crear', 'users',
            "Creó usuario: {$usuario->name} ({$usuario->email}) con rol: {$request->role}",
            $usuario->id, [], $usuario->toArray()
        );

        return redirect()->route('usuarios.index')
            ->with('success', "Usuario '{$usuario->name}' creado correctamente.");
    }

    public function show(User $usuario)
    {
        $usuario->load('roles');
        return view('usuarios.show', compact('usuario'));
    }

    public function edit(User $usuario)
    {
        $roles = Role::orderBy('name')->get();
        $usuario->load('roles');
        return view('usuarios.edit', compact('usuario', 'roles'));
    }

    public function update(Request $request, User $usuario)
    {
        $request->validate([
            'name'  => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $usuario->id,
            'role'  => 'required|exists:roles,name',
            'password' => 'nullable|string|min:8|confirmed',
            'activo'   => 'nullable|boolean',
        ]);

        $anterior = $usuario->toArray();

        $datos = [
            'name'   => $request->name,
            'email'  => $request->email,
            'activo' => $request->has('activo'),
        ];

        if ($request->filled('password')) {
            $datos['password'] = Hash::make($request->password);
        }

        $usuario->update($datos);
        $usuario->syncRoles([$request->role]);

        BitacoraAuditoria::registrar(
            'editar', 'users',
            "Editó usuario: {$usuario->name} ({$usuario->email})",
            $usuario->id, $anterior, $usuario->toArray()
        );

        return redirect()->route('usuarios.index')
            ->with('success', "Usuario '{$usuario->name}' actualizado correctamente.");
    }

    public function destroy(User $usuario)
    {
        if ($usuario->id === auth()->id()) {
            return redirect()->route('usuarios.index')
                ->with('error', 'No puedes eliminar tu propio usuario.');
        }

        BitacoraAuditoria::registrar(
            'eliminar', 'users',
            "Eliminó usuario: {$usuario->name} ({$usuario->email})",
            $usuario->id, $usuario->toArray()
        );

        $usuario->delete();

        return redirect()->route('usuarios.index')
            ->with('success', "Usuario eliminado correctamente.");
    }

    public function toggleActivo(User $usuario)
    {
        if ($usuario->id === auth()->id()) {
            return redirect()->route('usuarios.index')
                ->with('error', 'No puedes desactivar tu propio usuario.');
        }

        $usuario->update(['activo' => !$usuario->activo]);

        $accion = $usuario->activo ? 'activado' : 'desactivado';

        BitacoraAuditoria::registrar(
            'editar', 'users',
            "Usuario {$accion}: {$usuario->name}",
            $usuario->id
        );

        return redirect()->route('usuarios.index')
            ->with('success', "Usuario '{$usuario->name}' {$accion} correctamente.");
    }
}

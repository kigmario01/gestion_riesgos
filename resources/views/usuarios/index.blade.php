@extends('layouts.main')

@section('title', 'Usuarios')

@section('topbar-left')
    <div class="topbar-icon"><i class="fas fa-users-cog"></i></div>
    <div class="topbar-title">Gestión de Usuarios</div>
@endsection

@section('topbar-right')
    @can('usuarios.crear')<a href="{{ route('usuarios.create') }}" class="btn btn-primary btn-sm"><i class="fas fa-plus"></i> Nuevo Usuario</a>@endcan
@endsection

@push('styles')
<style>
.user-cell{display:flex;align-items:center;gap:10px;}
.mini-avatar{width:32px;height:32px;border-radius:50%;background:#3b82f6;display:flex;align-items:center;justify-content:center;font-weight:700;font-size:11px;color:#fff;flex-shrink:0;}
.role-badge{background:#eff6ff;color:#1d4ed8;padding:3px 10px;border-radius:6px;font-size:11px;font-weight:500;display:inline-block;}
</style>
@endpush

@section('content')
<div class="panel">
    <div class="panel-header">
        <div class="panel-title"><i class="fas fa-list"></i> Usuarios del Sistema</div>
        <span class="panel-subtitle">Total: {{ $usuarios->total() }} usuarios</span>
    </div>

    @if($usuarios->count() > 0)
    <table class="table">
        <thead>
            <tr>
                <th>Usuario</th>
                <th>Email</th>
                <th>Rol</th>
                <th>Estado</th>
                <th>Último acceso</th>
                <th>Registro</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
        @foreach($usuarios as $usuario)
        <tr>
            <td>
                <div class="user-cell">
                    <div class="mini-avatar">{{ strtoupper(substr($usuario->name,0,2)) }}</div>
                    <div>
                        <div style="font-weight:500;">{{ $usuario->name }}</div>
                        @if($usuario->id === auth()->id())
                        <div style="font-size:10px;color:#3b82f6;font-weight:500;">← Tú</div>
                        @endif
                    </div>
                </div>
            </td>
            <td style="color:#64748b;">{{ $usuario->email }}</td>
            <td>
                @foreach($usuario->roles as $role)
                <span class="role-badge">{{ str_replace('_',' ',strtoupper($role->name)) }}</span>
                @endforeach
                @if($usuario->roles->isEmpty())
                <span style="color:#94a3b8;font-size:12px;">Sin rol</span>
                @endif
            </td>
            <td><span class="badge badge-{{ $usuario->activo ? 'activo' : 'inactivo' }}">{{ $usuario->activo ? 'ACTIVO' : 'INACTIVO' }}</span></td>
            <td style="font-size:12px;color:#64748b;">
                {{ $usuario->ultimo_acceso ? \Carbon\Carbon::parse($usuario->ultimo_acceso)->diffForHumans() : 'Nunca' }}
            </td>
            <td style="font-size:12px;color:#64748b;">{{ $usuario->created_at->format('d/m/Y') }}</td>
            <td>
                <div class="actions">
                    <a href="{{ route('usuarios.show', $usuario) }}" class="btn btn-outline btn-xs"><i class="fas fa-eye"></i></a>
                    @can('usuarios.editar')<a href="{{ route('usuarios.edit', $usuario) }}" class="btn btn-outline btn-xs"><i class="fas fa-edit"></i></a>@endcan
                    @if($usuario->id !== auth()->id())
                    @can('usuarios.editar')
                    <form method="POST" action="{{ route('usuarios.toggle', $usuario) }}">
                        @csrf
                        <button type="submit" class="btn btn-xs {{ $usuario->activo ? 'btn-warning' : 'btn-success' }}" title="{{ $usuario->activo ? 'Desactivar' : 'Activar' }}">
                            <i class="fas fa-{{ $usuario->activo ? 'ban' : 'check' }}"></i>
                        </button>
                    </form>
                    @endcan
                    @can('usuarios.eliminar')
                    <form method="POST" action="{{ route('usuarios.destroy', $usuario) }}" onsubmit="return confirm('¿Eliminar usuario {{ $usuario->name }}?')">
                        @csrf @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-xs"><i class="fas fa-trash"></i></button>
                    </form>
                    @endcan
                    @endif
                </div>
            </td>
        </tr>
        @endforeach
        </tbody>
    </table>
    <div style="padding:14px 18px;">{{ $usuarios->links() }}</div>
    @else
    <div class="empty-state">
        <i class="fas fa-users"></i>
        <p>No hay usuarios registrados.</p>
        <a href="{{ route('usuarios.create') }}" class="btn btn-primary"><i class="fas fa-plus"></i> Crear usuario</a>
    </div>
    @endif
</div>
@endsection

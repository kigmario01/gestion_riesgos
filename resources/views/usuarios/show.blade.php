@extends('layouts.main')

@section('title', $usuario->name . ' — Usuario')

@section('topbar-left')
    <div class="topbar-icon"><i class="fas fa-user"></i></div>
    <div class="topbar-title">Detalle de Usuario</div>
@endsection

@section('topbar-right')
    <a href="{{ route('usuarios.edit', $usuario) }}" class="btn btn-outline btn-sm"><i class="fas fa-edit"></i> Editar</a>
    <a href="{{ route('usuarios.index') }}" class="btn btn-outline btn-sm"><i class="fas fa-arrow-left"></i> Volver</a>
@endsection

@push('styles')
<style>
.profile-header{display:flex;align-items:center;gap:20px;padding:24px 20px;border-bottom:1px solid #f1f5f9;}
.profile-avatar{width:64px;height:64px;border-radius:50%;background:#3b82f6;display:flex;align-items:center;justify-content:center;font-weight:700;font-size:24px;color:#fff;flex-shrink:0;}
.role-badge{background:#eff6ff;color:#1d4ed8;padding:4px 12px;border-radius:6px;font-size:12px;font-weight:600;display:inline-block;margin:2px;}
.perm-list{padding:16px 20px;display:flex;flex-wrap:wrap;gap:8px;}
.perm-item{background:#f8fafc;border:1px solid #e2e8f0;border-radius:6px;padding:4px 10px;font-size:11px;color:#475569;font-weight:500;}
</style>
@endpush

@section('content')

<div class="panel">
    <div class="profile-header">
        <div class="profile-avatar">{{ strtoupper(substr($usuario->name,0,2)) }}</div>
        <div style="flex:1;min-width:0;">
            <div style="font-size:20px;font-weight:700;color:#1e293b;">
                {{ $usuario->name }}
                @if($usuario->id === auth()->id())
                <span style="font-size:12px;color:#3b82f6;font-weight:500;"> ← Tú</span>
                @endif
            </div>
            <div style="font-size:13px;color:#64748b;margin-top:2px;">{{ $usuario->email }}</div>
            <div style="margin-top:8px;display:flex;gap:6px;flex-wrap:wrap;">
                @foreach($usuario->roles as $role)
                <span class="role-badge"><i class="fas fa-shield-alt" style="font-size:10px;margin-right:4px;"></i> {{ str_replace('_',' ',strtoupper($role->name)) }}</span>
                @endforeach
                @if($usuario->roles->isEmpty())
                <span style="color:#94a3b8;font-size:12px;">Sin rol asignado</span>
                @endif
            </div>
        </div>
        <div>
            <span class="badge badge-{{ $usuario->activo ? 'activo' : 'inactivo' }}" style="font-size:13px;padding:6px 16px;">
                <i class="fas fa-{{ $usuario->activo ? 'check-circle' : 'times-circle' }}"></i>
                {{ $usuario->activo ? 'ACTIVO' : 'INACTIVO' }}
            </span>
        </div>
    </div>

    <div class="panel-header" style="border-top:1px solid #f1f5f9;">
        <div class="panel-title"><i class="fas fa-info-circle"></i> Información de Cuenta</div>
    </div>
    <div class="detail-grid">
        <div class="detail-item">
            <div class="detail-label">Fecha de Registro</div>
            <div class="detail-value">{{ $usuario->created_at->format('d/m/Y H:i') }}</div>
        </div>
        <div class="detail-item">
            <div class="detail-label">Último Acceso</div>
            <div class="detail-value">
                {{ $usuario->ultimo_acceso ? \Carbon\Carbon::parse($usuario->ultimo_acceso)->format('d/m/Y H:i') : 'Nunca' }}
            </div>
        </div>
        <div class="detail-item">
            <div class="detail-label">Email Verificado</div>
            <div class="detail-value">{{ $usuario->email_verified_at ? $usuario->email_verified_at->format('d/m/Y') : 'No verificado' }}</div>
        </div>
        <div class="detail-item">
            <div class="detail-label">Última Actualización</div>
            <div class="detail-value">{{ $usuario->updated_at->format('d/m/Y H:i') }}</div>
        </div>
        @if($usuario->intentos_fallidos > 0)
        <div class="detail-item">
            <div class="detail-label">Intentos Fallidos</div>
            <div class="detail-value" style="color:#dc2626;font-weight:700;">{{ $usuario->intentos_fallidos }}</div>
        </div>
        @endif
        @if($usuario->bloqueado_hasta)
        <div class="detail-item">
            <div class="detail-label">Bloqueado Hasta</div>
            <div class="detail-value" style="color:#dc2626;">{{ \Carbon\Carbon::parse($usuario->bloqueado_hasta)->format('d/m/Y H:i') }}</div>
        </div>
        @endif
    </div>
</div>

@foreach($usuario->roles as $role)
<div class="panel">
    <div class="panel-header">
        <div class="panel-title"><i class="fas fa-key"></i> Permisos del rol: {{ str_replace('_',' ',strtoupper($role->name)) }}</div>
        <a href="{{ route('roles.show', $role) }}" class="btn btn-outline btn-xs"><i class="fas fa-external-link-alt"></i> Ver rol</a>
    </div>
    <div class="perm-list">
        @foreach($role->permissions->sortBy('name') as $perm)
        <span class="perm-item"><i class="fas fa-check" style="color:#16a34a;font-size:10px;margin-right:4px;"></i>{{ $perm->name }}</span>
        @endforeach
        @if($role->permissions->isEmpty())
        <span style="color:#94a3b8;font-size:13px;">Sin permisos asignados.</span>
        @endif
    </div>
</div>
@endforeach

@if($usuario->id !== auth()->id())
<div class="panel">
    <div class="panel-header">
        <div class="panel-title"><i class="fas fa-cog"></i> Acciones</div>
    </div>
    <div style="padding:16px 20px;display:flex;gap:10px;">
        <form method="POST" action="{{ route('usuarios.toggle', $usuario) }}">
            @csrf
            <button type="submit" class="btn {{ $usuario->activo ? 'btn-warning' : 'btn-success' }}">
                <i class="fas fa-{{ $usuario->activo ? 'ban' : 'check' }}"></i>
                {{ $usuario->activo ? 'Desactivar usuario' : 'Activar usuario' }}
            </button>
        </form>
    </div>
</div>
@endif

@endsection

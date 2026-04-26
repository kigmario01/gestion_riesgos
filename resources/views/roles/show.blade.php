@extends('layouts.main')

@section('title', strtoupper($rol->name) . ' — Rol')

@section('topbar-left')
    <div class="topbar-icon"><i class="fas fa-user-shield"></i></div>
    <div class="topbar-title">Rol: {{ str_replace('_',' ',strtoupper($rol->name)) }}</div>
@endsection

@section('topbar-right')
    <a href="{{ route('roles.edit', $rol) }}" class="btn btn-outline btn-sm"><i class="fas fa-edit"></i> Editar permisos</a>
    <a href="{{ route('roles.index') }}" class="btn btn-outline btn-sm"><i class="fas fa-arrow-left"></i> Volver</a>
@endsection

@push('styles')
<style>
.role-header-section{display:flex;align-items:center;gap:20px;padding:20px;}
.role-icon-lg{width:60px;height:60px;border-radius:12px;background:#eff6ff;display:flex;align-items:center;justify-content:center;color:#3b82f6;font-size:24px;flex-shrink:0;}
.stat-chips{display:flex;gap:16px;padding:0 20px 16px;}
.stat-chip{background:#f8fafc;border:1px solid #e2e8f0;border-radius:8px;padding:10px 16px;text-align:center;}
.stat-chip-num{font-size:22px;font-weight:700;color:#3b82f6;}
.stat-chip-label{font-size:11px;color:#94a3b8;}
.perm-module-header{padding:10px 20px;background:#f8fafc;border-bottom:1px solid #f1f5f9;font-size:11px;font-weight:700;color:#475569;text-transform:uppercase;letter-spacing:1px;display:flex;align-items:center;gap:8px;}
.perm-module-body{display:flex;flex-wrap:wrap;gap:8px;padding:14px 20px;border-bottom:1px solid #f1f5f9;}
.perm-module-body:last-child{border-bottom:none;}
.perm-chip{display:inline-flex;align-items:center;gap:6px;padding:5px 12px;border-radius:20px;font-size:12px;font-weight:500;}
.perm-has{background:#f0fdf4;color:#16a34a;border:1px solid #bbf7d0;}
.perm-not{background:#f8fafc;color:#cbd5e1;border:1px solid #e2e8f0;}
.mini-avatar{width:30px;height:30px;border-radius:50%;background:#3b82f6;display:flex;align-items:center;justify-content:center;font-weight:700;font-size:11px;color:#fff;flex-shrink:0;}
</style>
@endpush

@section('content')
@php
$roleInfo = [
    'product_owner' => ['icon' => 'fa-user-tie',     'desc' => 'Visibilidad general y aprobación de planes de mitigación.'],
    'scrum_master'  => ['icon' => 'fa-tasks',         'desc' => 'Supervisión de tareas del equipo y generación de reportes.'],
    'frontend'      => ['icon' => 'fa-desktop',       'desc' => 'Acceso a vistas y reportes. Sin modificación de fórmulas o base de datos.'],
    'backend'       => ['icon' => 'fa-code',          'desc' => 'Acceso completo CRUD incluyendo usuarios y configuración.'],
    'base_datos'    => ['icon' => 'fa-database',      'desc' => 'Gestión de tablas, relaciones, respaldos y optimización.'],
    'auditoria'     => ['icon' => 'fa-clipboard-check','desc' => 'Trazabilidad, bitácora de auditoría y evidencias. Principalmente lectura.'],
];
$info = $roleInfo[$rol->name] ?? ['icon' => 'fa-user-shield', 'desc' => ''];
@endphp

<div class="panel">
    <div class="role-header-section">
        <div class="role-icon-lg"><i class="fas {{ $info['icon'] }}"></i></div>
        <div>
            <div style="font-size:22px;font-weight:700;color:#1e293b;">{{ str_replace('_',' ',strtoupper($rol->name)) }}</div>
            <div style="font-size:13px;color:#64748b;margin-top:4px;">{{ $info['desc'] }}</div>
        </div>
    </div>
    <div class="stat-chips">
        <div class="stat-chip">
            <div class="stat-chip-num">{{ $rol->permissions->count() }}</div>
            <div class="stat-chip-label">Permisos</div>
        </div>
        <div class="stat-chip">
            <div class="stat-chip-num">{{ $rol->users->count() }}</div>
            <div class="stat-chip-label">Usuarios</div>
        </div>
    </div>
</div>

<div class="panel">
    <div class="panel-header">
        <div class="panel-title"><i class="fas fa-key"></i> Permisos por Módulo</div>
    </div>
    @php $rolPerms = $rol->permissions->pluck('name')->toArray(); @endphp
    @foreach($permisosPorModulo as $modulo => $permisos)
    <div>
        <div class="perm-module-header">
            <i class="fas fa-cube"></i> {{ strtoupper($modulo) }}
            <span style="font-size:10px;color:#94a3b8;font-weight:400;margin-left:4px;">
                ({{ $permisos->filter(fn($p) => in_array($p->name, $rolPerms))->count() }}/{{ $permisos->count() }})
            </span>
        </div>
        <div class="perm-module-body">
            @foreach($permisos as $perm)
            @if(in_array($perm->name, $rolPerms))
            <span class="perm-chip perm-has"><i class="fas fa-check"></i> {{ explode('.',$perm->name)[1] ?? $perm->name }}</span>
            @else
            <span class="perm-chip perm-not"><i class="fas fa-times"></i> {{ explode('.',$perm->name)[1] ?? $perm->name }}</span>
            @endif
            @endforeach
        </div>
    </div>
    @endforeach
</div>

<div class="panel">
    <div class="panel-header">
        <div class="panel-title"><i class="fas fa-users"></i> Usuarios con este Rol</div>
    </div>
    @if($rol->users->count() > 0)
    <table class="table">
        <thead><tr><th>Usuario</th><th>Email</th><th>Estado</th><th>Último acceso</th><th></th></tr></thead>
        <tbody>
        @foreach($rol->users as $u)
        <tr>
            <td>
                <div style="display:flex;align-items:center;gap:10px;">
                    <div class="mini-avatar">{{ strtoupper(substr($u->name,0,2)) }}</div>
                    <span style="font-weight:500;">{{ $u->name }}</span>
                </div>
            </td>
            <td style="color:#64748b;">{{ $u->email }}</td>
            <td><span class="badge badge-{{ $u->activo ? 'activo' : 'inactivo' }}">{{ $u->activo ? 'ACTIVO' : 'INACTIVO' }}</span></td>
            <td style="font-size:12px;color:#64748b;">{{ $u->ultimo_acceso ? \Carbon\Carbon::parse($u->ultimo_acceso)->diffForHumans() : 'Nunca' }}</td>
            <td><a href="{{ route('usuarios.show', $u) }}" class="btn btn-outline btn-xs"><i class="fas fa-eye"></i></a></td>
        </tr>
        @endforeach
        </tbody>
    </table>
    @else
    <div class="empty-state">
        <i class="fas fa-user-slash"></i>
        <p>Ningún usuario tiene este rol asignado.</p>
    </div>
    @endif
</div>
@endsection

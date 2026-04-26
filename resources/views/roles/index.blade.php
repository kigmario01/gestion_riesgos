@extends('layouts.main')

@section('title', 'Control de Roles')

@section('topbar-left')
    <div class="topbar-icon"><i class="fas fa-user-shield"></i></div>
    <div class="topbar-title">Control de Roles</div>
@endsection

@push('styles')
<style>
.roles-grid{display:grid;grid-template-columns:repeat(auto-fill,minmax(320px,1fr));gap:20px;}
.role-card{background:#fff;border-radius:12px;border:1px solid #e2e8f0;overflow:hidden;transition:box-shadow 0.2s;}
.role-card:hover{box-shadow:0 4px 20px rgba(0,0,0,0.08);}
.role-card-header{padding:18px 20px;border-bottom:1px solid #f1f5f9;display:flex;align-items:center;gap:14px;}
.role-icon{width:44px;height:44px;border-radius:10px;background:#eff6ff;display:flex;align-items:center;justify-content:center;color:#3b82f6;font-size:18px;flex-shrink:0;}
.role-name{font-size:15px;font-weight:700;color:#1e293b;}
.role-desc{font-size:11px;color:#64748b;margin-top:2px;}
.role-stats{display:flex;gap:0;border-bottom:1px solid #f1f5f9;}
.role-stat{flex:1;padding:12px 16px;text-align:center;border-right:1px solid #f1f5f9;}
.role-stat:last-child{border-right:none;}
.role-stat-num{font-size:20px;font-weight:700;color:#3b82f6;}
.role-stat-label{font-size:10px;color:#94a3b8;text-transform:uppercase;letter-spacing:0.5px;margin-top:2px;}
.role-card-footer{padding:12px 16px;display:flex;gap:8px;justify-content:flex-end;}
</style>
@endpush

@section('content')
@php
$roleInfo = [
    'product_owner' => ['icon' => 'fa-user-tie',     'desc' => 'Visibilidad general, aprobación de planes'],
    'scrum_master'  => ['icon' => 'fa-tasks',         'desc' => 'Supervisión de tareas, reportes'],
    'frontend'      => ['icon' => 'fa-desktop',       'desc' => 'Vistas y reportes, solo lectura'],
    'backend'       => ['icon' => 'fa-code',          'desc' => 'Acceso completo CRUD y usuarios'],
    'base_datos'    => ['icon' => 'fa-database',      'desc' => 'Tablas, respaldos, optimización'],
    'auditoria'     => ['icon' => 'fa-clipboard-check','desc' => 'Trazabilidad, bitácora, evidencias'],
];
@endphp

<div class="roles-grid">
    @foreach($roles as $rol)
    @php $info = $roleInfo[$rol->name] ?? ['icon' => 'fa-user-shield', 'desc' => '']; @endphp
    <div class="role-card">
        <div class="role-card-header">
            <div class="role-icon"><i class="fas {{ $info['icon'] }}"></i></div>
            <div>
                <div class="role-name">{{ str_replace('_',' ',strtoupper($rol->name)) }}</div>
                <div class="role-desc">{{ $info['desc'] }}</div>
            </div>
        </div>
        <div class="role-stats">
            <div class="role-stat">
                <div class="role-stat-num">{{ $rol->permissions_count }}</div>
                <div class="role-stat-label">Permisos</div>
            </div>
            <div class="role-stat">
                <div class="role-stat-num">{{ $rol->users_count }}</div>
                <div class="role-stat-label">Usuarios</div>
            </div>
        </div>
        <div class="role-card-footer">
            <a href="{{ route('roles.show', $rol) }}" class="btn btn-outline btn-sm"><i class="fas fa-eye"></i> Ver</a>
            <a href="{{ route('roles.edit', $rol) }}" class="btn btn-outline btn-sm"><i class="fas fa-edit"></i> Editar permisos</a>
        </div>
    </div>
    @endforeach
</div>
@endsection

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ strtoupper($rol->name) }} — Roles</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css'])
    <style>
        *{margin:0;padding:0;box-sizing:border-box}body{font-family:'Inter',sans-serif;background:#f0f4f8;color:#1e293b}
        .sidebar{position:fixed;top:0;left:0;width:250px;height:100vh;background:#1e40af;display:flex;flex-direction:column;z-index:100;overflow-y:auto}
        .sidebar-logo{padding:24px 20px;border-bottom:1px solid rgba(255,255,255,0.1)}.sidebar-logo h1{color:#fff;font-size:18px;font-weight:700}.sidebar-logo p{color:rgba(255,255,255,0.6);font-size:11px;margin-top:3px}
        .nav-section-title{padding:16px 20px 6px;font-size:10px;font-weight:600;letter-spacing:1.5px;text-transform:uppercase;color:rgba(255,255,255,0.4)}
        .nav-item{display:flex;align-items:center;gap:10px;padding:10px 20px;color:rgba(255,255,255,0.75);text-decoration:none;font-size:13.5px;transition:all 0.2s;border-left:3px solid transparent}
        .nav-item:hover{background:rgba(255,255,255,0.08);color:#fff}.nav-item.active{background:rgba(255,255,255,0.12);color:#fff;border-left-color:#60a5fa;font-weight:500}
        .nav-item i{width:18px;text-align:center;font-size:14px}
        .sidebar-footer{margin-top:auto;padding:16px 20px;border-top:1px solid rgba(255,255,255,0.1)}
        .user-info{display:flex;align-items:center;gap:10px}.user-avatar{width:36px;height:36px;border-radius:50%;background:#60a5fa;display:flex;align-items:center;justify-content:center;font-weight:700;font-size:14px;color:#1e40af}
        .user-name{font-size:13px;color:#fff;font-weight:500}.user-role{font-size:11px;color:rgba(255,255,255,0.5)}
        .btn-logout{display:flex;align-items:center;gap:6px;margin-top:10px;padding:7px 12px;background:rgba(255,255,255,0.08);color:rgba(255,255,255,0.7);border-radius:8px;font-size:12px;border:none;cursor:pointer;width:100%}
        .main{margin-left:250px;min-height:100vh;display:flex;flex-direction:column}
        .topbar{background:#fff;border-bottom:1px solid #e2e8f0;padding:0 28px;height:58px;display:flex;align-items:center;justify-content:space-between;position:sticky;top:0;z-index:50}
        .topbar-title{font-size:16px;font-weight:600}.topbar-right{display:flex;align-items:center;gap:10px}
        .btn{display:inline-flex;align-items:center;gap:6px;padding:8px 16px;border-radius:8px;font-size:13px;font-weight:500;cursor:pointer;border:none;text-decoration:none;transition:all 0.2s}
        .btn-primary{background:#1e40af;color:#fff}.btn-outline{background:#fff;color:#475569;border:1px solid #e2e8f0}.btn-outline:hover{border-color:#1e40af;color:#1e40af}
        .btn-sm{padding:5px 10px;font-size:12px}
        .content{padding:24px 28px;flex:1}
        .alert-success{background:#f0fdf4;border:1px solid #bbf7d0;border-left:4px solid #22c55e;border-radius:10px;padding:12px 18px;margin-bottom:20px;color:#15803d;font-size:13px;display:flex;align-items:center;gap:8px}
        .panel{background:#fff;border-radius:12px;border:1px solid #e2e8f0;overflow:hidden;margin-bottom:20px}
        .panel-header{padding:16px 20px;border-bottom:1px solid #f1f5f9;display:flex;align-items:center;justify-content:space-between}
        .panel-title{font-size:14px;font-weight:600;display:flex;align-items:center;gap:8px}.panel-title i{color:#1e40af}
        .role-header{display:flex;align-items:center;gap:20px;padding:20px}
        .role-icon-lg{width:60px;height:60px;border-radius:12px;background:#eff6ff;display:flex;align-items:center;justify-content:center;color:#1e40af;font-size:24px;flex-shrink:0}
        .perm-module{margin-bottom:0}
        .perm-module-header{padding:10px 20px;background:#f8fafc;border-bottom:1px solid #f1f5f9;font-size:11px;font-weight:700;color:#475569;text-transform:uppercase;letter-spacing:1px;display:flex;align-items:center;gap:8px}
        .perm-module-body{display:flex;flex-wrap:wrap;gap:8px;padding:14px 20px;border-bottom:1px solid #f1f5f9}
        .perm-module-body:last-child{border-bottom:none}
        .perm-chip{display:inline-flex;align-items:center;gap:6px;padding:5px 12px;border-radius:20px;font-size:12px;font-weight:500}
        .perm-has{background:#f0fdf4;color:#16a34a;border:1px solid #bbf7d0}
        .perm-not{background:#f8fafc;color:#cbd5e1;border:1px solid #e2e8f0}
        .table{width:100%;border-collapse:collapse}
        .table th{padding:10px 16px;text-align:left;font-size:11px;font-weight:600;color:#64748b;text-transform:uppercase;letter-spacing:0.5px;background:#f8fafc;border-bottom:1px solid #e2e8f0}
        .table td{padding:12px 16px;font-size:13px;color:#374151;border-bottom:1px solid #f1f5f9;vertical-align:middle}
        .table tr:last-child td{border-bottom:none}.table tr:hover td{background:#f8fafc}
        .badge-activo{background:#f0fdf4;color:#16a34a;padding:3px 10px;border-radius:20px;font-size:11px;font-weight:600;display:inline-flex}
        .badge-inactivo{background:#fef2f2;color:#dc2626;padding:3px 10px;border-radius:20px;font-size:11px;font-weight:600;display:inline-flex}
        .mini-avatar{width:30px;height:30px;border-radius:50%;background:#1e40af;display:flex;align-items:center;justify-content:center;font-weight:700;font-size:11px;color:#fff;flex-shrink:0}
        .empty-state{padding:40px 20px;text-align:center;color:#94a3b8;font-size:13px}
        .empty-state i{font-size:32px;margin-bottom:10px;display:block}
        .stat-chips{display:flex;gap:16px;padding:0 20px 16px}
        .stat-chip{background:#f8fafc;border:1px solid #e2e8f0;border-radius:8px;padding:10px 16px;text-align:center}
        .stat-chip-num{font-size:22px;font-weight:700;color:#1e40af}
        .stat-chip-label{font-size:11px;color:#94a3b8}
    </style>
</head>
<body>
<aside class="sidebar">
    <div class="sidebar-logo"><h1>🛡️ RiskGuard TI</h1><p>Gestión de Riesgos · ISO 27001</p></div>
    <nav>
        <div class="nav-section-title">Principal</div>
        <a href="{{ route('dashboard') }}" class="nav-item"><i class="fas fa-chart-pie"></i> Dashboard</a>
        <a href="{{ route('matriz.index') }}" class="nav-item"><i class="fas fa-map"></i> Matriz de Riesgos</a>
        <div class="nav-section-title">Gestión</div>
        <a href="{{ route('activos.index') }}" class="nav-item"><i class="fas fa-server"></i> Activos TI</a>
        <a href="{{ route('amenazas.index') }}" class="nav-item"><i class="fas fa-biohazard"></i> Amenazas</a>
        <a href="{{ route('evaluaciones.index') }}" class="nav-item"><i class="fas fa-search"></i> Evaluaciones</a>
        <a href="{{ route('mitigacion.index') }}" class="nav-item"><i class="fas fa-tools"></i> Mitigación</a>
        <div class="nav-section-title">Auditoría</div>
        <a href="{{ route('bitacora.index') }}" class="nav-item"><i class="fas fa-clipboard-list"></i> Bitácora</a>
        <div class="nav-section-title">Sistema</div>
        <a href="{{ route('usuarios.index') }}" class="nav-item"><i class="fas fa-users"></i> Usuarios</a>
        <a href="{{ route('roles.index') }}" class="nav-item active"><i class="fas fa-shield-alt"></i> Control de Roles</a>
    </nav>
    <div class="sidebar-footer">
        <div class="user-info">
            <div class="user-avatar">{{ strtoupper(substr(auth()->user()->name,0,2)) }}</div>
            <div><div class="user-name">{{ auth()->user()->name }}</div><div class="user-role">{{ auth()->user()->getRoleNames()->first() ?? 'Sin rol' }}</div></div>
        </div>
        <form method="POST" action="{{ route('logout') }}">@csrf<button type="submit" class="btn-logout"><i class="fas fa-sign-out-alt"></i> Cerrar sesión</button></form>
    </div>
</aside>

<div class="main">
    <header class="topbar">
        <div class="topbar-title"><i class="fas fa-shield-alt" style="color:#1e40af;margin-right:8px;"></i> Rol: {{ str_replace('_',' ',strtoupper($rol->name)) }}</div>
        <div class="topbar-right">
            <a href="{{ route('roles.edit', $rol) }}" class="btn btn-outline"><i class="fas fa-edit"></i> Editar permisos</a>
            <a href="{{ route('roles.index') }}" class="btn btn-outline"><i class="fas fa-arrow-left"></i> Volver</a>
        </div>
    </header>

    <div class="content">
        @if(session('success'))<div class="alert-success"><i class="fas fa-check-circle"></i> {{ session('success') }}</div>@endif

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
            <div class="role-header">
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

        {{-- Permisos por módulo --}}
        <div class="panel">
            <div class="panel-header">
                <div class="panel-title"><i class="fas fa-key"></i> Permisos por Módulo</div>
            </div>
            @php $rolPerms = $rol->permissions->pluck('name')->toArray(); @endphp
            @foreach($permisosPorModulo as $modulo => $permisos)
            <div class="perm-module">
                <div class="perm-module-header">
                    <i class="fas fa-cube"></i> {{ strtoupper($modulo) }}
                    <span style="font-size:10px;color:#94a3b8;font-weight:400;margin-left:4px;">({{ $permisos->filter(fn($p) => in_array($p->name, $rolPerms))->count() }}/{{ $permisos->count() }})</span>
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

        {{-- Usuarios con este rol --}}
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
                    <td><span class="badge-{{ $u->activo ? 'activo' : 'inactivo' }}">{{ $u->activo ? 'ACTIVO' : 'INACTIVO' }}</span></td>
                    <td style="font-size:12px;color:#64748b;">{{ $u->ultimo_acceso ? \Carbon\Carbon::parse($u->ultimo_acceso)->diffForHumans() : 'Nunca' }}</td>
                    <td><a href="{{ route('usuarios.show', $u) }}" class="btn btn-outline btn-sm"><i class="fas fa-eye"></i></a></td>
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
    </div>
</div>
</body>
</html>

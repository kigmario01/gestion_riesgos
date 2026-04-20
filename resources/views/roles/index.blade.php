<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Control de Roles — RiskGuard TI</title>
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
        .topbar-title{font-size:16px;font-weight:600}
        .btn{display:inline-flex;align-items:center;gap:6px;padding:8px 16px;border-radius:8px;font-size:13px;font-weight:500;cursor:pointer;border:none;text-decoration:none;transition:all 0.2s}
        .btn-primary{background:#1e40af;color:#fff}.btn-outline{background:#fff;color:#475569;border:1px solid #e2e8f0}.btn-outline:hover{border-color:#1e40af;color:#1e40af}
        .btn-sm{padding:5px 10px;font-size:12px}
        .content{padding:24px 28px;flex:1}
        .alert-success{background:#f0fdf4;border:1px solid #bbf7d0;border-left:4px solid #22c55e;border-radius:10px;padding:12px 18px;margin-bottom:20px;color:#15803d;font-size:13px;display:flex;align-items:center;gap:8px}
        .roles-grid{display:grid;grid-template-columns:repeat(auto-fill,minmax(320px,1fr));gap:20px}
        .role-card{background:#fff;border-radius:12px;border:1px solid #e2e8f0;overflow:hidden;transition:box-shadow 0.2s}
        .role-card:hover{box-shadow:0 4px 20px rgba(0,0,0,0.08)}
        .role-card-header{padding:18px 20px;border-bottom:1px solid #f1f5f9;display:flex;align-items:center;gap:14px}
        .role-icon{width:44px;height:44px;border-radius:10px;background:#eff6ff;display:flex;align-items:center;justify-content:center;color:#1e40af;font-size:18px;flex-shrink:0}
        .role-name{font-size:15px;font-weight:700;color:#1e293b}
        .role-desc{font-size:11px;color:#64748b;margin-top:2px}
        .role-stats{display:flex;gap:0;border-bottom:1px solid #f1f5f9}
        .role-stat{flex:1;padding:12px 16px;text-align:center;border-right:1px solid #f1f5f9}
        .role-stat:last-child{border-right:none}
        .role-stat-num{font-size:20px;font-weight:700;color:#1e40af}
        .role-stat-label{font-size:10px;color:#94a3b8;text-transform:uppercase;letter-spacing:0.5px;margin-top:2px}
        .role-card-footer{padding:12px 16px;display:flex;gap:8px;justify-content:flex-end}
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
        <div class="topbar-title"><i class="fas fa-shield-alt" style="color:#1e40af;margin-right:8px;"></i> Control de Roles</div>
    </header>

    <div class="content">
        @if(session('success'))<div class="alert-success"><i class="fas fa-check-circle"></i> {{ session('success') }}</div>@endif

        @php
        $roleInfo = [
            'product_owner' => ['icon' => 'fa-user-tie',    'desc' => 'Visibilidad general, aprobación de planes'],
            'scrum_master'  => ['icon' => 'fa-tasks',        'desc' => 'Supervisión de tareas, reportes'],
            'frontend'      => ['icon' => 'fa-desktop',      'desc' => 'Vistas y reportes, solo lectura'],
            'backend'       => ['icon' => 'fa-code',         'desc' => 'Acceso completo CRUD y usuarios'],
            'base_datos'    => ['icon' => 'fa-database',     'desc' => 'Tablas, respaldos, optimización'],
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
    </div>
</div>
</body>
</html>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $usuario->name }} — Usuarios</title>
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
        .btn-warning{background:#fff7ed;color:#ea580c;border:1px solid #fed7aa}.btn-success{background:#f0fdf4;color:#16a34a;border:1px solid #bbf7d0}
        .btn-sm{padding:5px 10px;font-size:12px}
        .content{padding:24px 28px;flex:1}
        .panel{background:#fff;border-radius:12px;border:1px solid #e2e8f0;overflow:hidden;margin-bottom:20px}
        .panel-header{padding:16px 20px;border-bottom:1px solid #f1f5f9;display:flex;align-items:center;justify-content:space-between}
        .panel-title{font-size:14px;font-weight:600;display:flex;align-items:center;gap:8px}.panel-title i{color:#1e40af}
        .profile-header{display:flex;align-items:center;gap:20px;padding:24px 20px;border-bottom:1px solid #f1f5f9}
        .profile-avatar{width:64px;height:64px;border-radius:50%;background:#1e40af;display:flex;align-items:center;justify-content:center;font-weight:700;font-size:24px;color:#fff;flex-shrink:0}
        .profile-name{font-size:20px;font-weight:700;color:#1e293b}
        .profile-email{font-size:13px;color:#64748b;margin-top:2px}
        .detail-grid{display:grid;grid-template-columns:1fr 1fr;gap:20px;padding:20px}
        .detail-item{display:flex;flex-direction:column;gap:6px}
        .detail-label{font-size:11px;font-weight:600;color:#64748b;text-transform:uppercase;letter-spacing:0.5px}
        .detail-value{font-size:14px;color:#1e293b;font-weight:500}
        .badge{display:inline-flex;align-items:center;gap:4px;padding:4px 12px;border-radius:20px;font-size:11px;font-weight:600}
        .badge-activo{background:#f0fdf4;color:#16a34a}.badge-inactivo{background:#fef2f2;color:#dc2626}
        .role-badge{background:#eff6ff;color:#1e40af;padding:4px 12px;border-radius:6px;font-size:12px;font-weight:600;display:inline-block;margin:2px}
        .perm-list{padding:16px 20px;display:flex;flex-wrap:wrap;gap:8px}
        .perm-item{background:#f8fafc;border:1px solid #e2e8f0;border-radius:6px;padding:4px 10px;font-size:11px;color:#475569;font-weight:500}
        .stat-row{display:flex;gap:16px;padding:16px 20px;border-bottom:1px solid #f1f5f9}
        .stat-card{flex:1;background:#f8fafc;border-radius:8px;padding:12px 16px;border:1px solid #f1f5f9}
        .stat-number{font-size:22px;font-weight:700;color:#1e40af}
        .stat-label{font-size:11px;color:#64748b;margin-top:2px}
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
        <a href="{{ route('usuarios.index') }}" class="nav-item active"><i class="fas fa-users"></i> Usuarios</a>
        <a href="{{ route('roles.index') }}" class="nav-item"><i class="fas fa-shield-alt"></i> Control de Roles</a>
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
        <div class="topbar-title"><i class="fas fa-user" style="color:#1e40af;margin-right:8px;"></i> Detalle de Usuario</div>
        <div class="topbar-right">
            <a href="{{ route('usuarios.edit', $usuario) }}" class="btn btn-outline"><i class="fas fa-edit"></i> Editar</a>
            <a href="{{ route('usuarios.index') }}" class="btn btn-outline"><i class="fas fa-arrow-left"></i> Volver</a>
        </div>
    </header>

    <div class="content">
        <div class="panel">
            <div class="profile-header">
                <div class="profile-avatar">{{ strtoupper(substr($usuario->name,0,2)) }}</div>
                <div>
                    <div class="profile-name">
                        {{ $usuario->name }}
                        @if($usuario->id === auth()->id())
                        <span style="font-size:12px;color:#1e40af;font-weight:500;">← Tú</span>
                        @endif
                    </div>
                    <div class="profile-email">{{ $usuario->email }}</div>
                    <div style="margin-top:8px;display:flex;gap:6px;flex-wrap:wrap;">
                        @foreach($usuario->roles as $role)
                        <span class="role-badge"><i class="fas fa-shield-alt" style="font-size:10px;"></i> {{ str_replace('_',' ',strtoupper($role->name)) }}</span>
                        @endforeach
                        @if($usuario->roles->isEmpty())
                        <span style="color:#94a3b8;font-size:12px;">Sin rol asignado</span>
                        @endif
                    </div>
                </div>
                <div style="margin-left:auto;">
                    <span class="badge badge-{{ $usuario->activo ? 'activo' : 'inactivo' }}" style="font-size:13px;padding:6px 16px;">
                        <i class="fas fa-{{ $usuario->activo ? 'check-circle' : 'times-circle' }}"></i>
                        {{ $usuario->activo ? 'ACTIVO' : 'INACTIVO' }}
                    </span>
                </div>
            </div>

            <div class="panel-header">
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
                    <div class="detail-value" style="color:#dc2626;">{{ $usuario->intentos_fallidos }}</div>
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

        {{-- Permisos del rol --}}
        @foreach($usuario->roles as $role)
        <div class="panel">
            <div class="panel-header">
                <div class="panel-title"><i class="fas fa-key"></i> Permisos del rol: {{ str_replace('_',' ',strtoupper($role->name)) }}</div>
                <a href="{{ route('roles.show', $role) }}" class="btn btn-outline btn-sm"><i class="fas fa-external-link-alt"></i> Ver rol</a>
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

        {{-- Acciones --}}
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
    </div>
</div>
</body>
</html>

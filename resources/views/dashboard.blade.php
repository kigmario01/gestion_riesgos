<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard — Gestión de Riesgos TI</title>
    @vite(['resources/css/app.css'])
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif; background: #f0f4f8; color: #1e293b; }
        .sidebar { position: fixed; top: 0; left: 0; width: 250px; height: 100vh; background: #1e40af; display: flex; flex-direction: column; z-index: 100; overflow-y: auto; }
        .sidebar-logo { padding: 24px 20px; border-bottom: 1px solid rgba(255,255,255,0.1); }
        .sidebar-logo h1 { color: #fff; font-size: 18px; font-weight: 700; }
        .sidebar-logo p { color: rgba(255,255,255,0.6); font-size: 11px; margin-top: 3px; }
        .nav-section-title { padding: 16px 20px 6px; font-size: 10px; font-weight: 600; letter-spacing: 1.5px; text-transform: uppercase; color: rgba(255,255,255,0.4); }
        .nav-item { display: flex; align-items: center; gap: 10px; padding: 10px 20px; color: rgba(255,255,255,0.75); text-decoration: none; font-size: 13.5px; transition: all 0.15s; border-left: 3px solid transparent; }
        .nav-item:hover { background: rgba(255,255,255,0.08); color: #fff; }
        .nav-item.active { background: rgba(255,255,255,0.12); color: #fff; border-left-color: #60a5fa; font-weight: 500; }
        .nav-item i { width: 18px; text-align: center; font-size: 14px; }
        .sidebar-footer { margin-top: auto; padding: 16px 20px; border-top: 1px solid rgba(255,255,255,0.1); }
        .user-info { display: flex; align-items: center; gap: 10px; }
        .user-avatar { width: 36px; height: 36px; border-radius: 50%; background: #60a5fa; display: flex; align-items: center; justify-content: center; font-weight: 700; font-size: 14px; color: #1e40af; flex-shrink: 0; }
        .user-name { font-size: 13px; color: #fff; font-weight: 500; }
        .user-role { font-size: 11px; color: rgba(255,255,255,0.5); }
        .btn-logout { display: flex; align-items: center; gap: 6px; margin-top: 10px; padding: 7px 12px; background: rgba(255,255,255,0.08); color: rgba(255,255,255,0.7); border-radius: 8px; font-size: 12px; border: none; cursor: pointer; width: 100%; }
        .btn-logout:hover { background: rgba(239,68,68,0.2); color: #fca5a5; }
        .main { margin-left: 250px; min-height: 100vh; display: flex; flex-direction: column; }
        .topbar { background: #fff; border-bottom: 1px solid #e2e8f0; padding: 0 28px; height: 58px; display: flex; align-items: center; justify-content: space-between; position: sticky; top: 0; z-index: 50; }
        .topbar-title { font-size: 16px; font-weight: 600; }
        .topbar-right { display: flex; align-items: center; gap: 10px; }
        .btn { display: inline-flex; align-items: center; gap: 6px; padding: 8px 16px; border-radius: 8px; font-size: 13px; font-weight: 500; cursor: pointer; border: none; text-decoration: none; transition: all 0.15s; }
        .btn-primary { background: #1e40af; color: #fff; }
        .btn-primary:hover { background: #1d3a9e; }
        .btn-outline { background: #fff; color: #475569; border: 1px solid #e2e8f0; }
        .btn-outline:hover { border-color: #1e40af; color: #1e40af; }
        .content { padding: 24px 28px; flex: 1; }
        .alert-critical { background: #fef2f2; border: 1px solid #fecaca; border-left: 4px solid #ef4444; border-radius: 10px; padding: 14px 18px; display: flex; align-items: center; gap: 12px; margin-bottom: 24px; }
        .alert-critical i { color: #ef4444; font-size: 18px; }
        .alert-critical-title { font-size: 13px; font-weight: 600; color: #dc2626; }
        .alert-critical-desc { font-size: 12px; color: #6b7280; margin-top: 2px; }
        .stats-grid { display: grid; grid-template-columns: repeat(4, 1fr); gap: 16px; margin-bottom: 24px; }
        .stat-card { background: #fff; border-radius: 12px; padding: 20px; border: 1px solid #e2e8f0; position: relative; overflow: hidden; transition: transform 0.15s, box-shadow 0.15s; text-decoration: none; display: block; color: inherit; }
        .stat-card:hover { transform: translateY(-2px); box-shadow: 0 8px 24px rgba(0,0,0,0.08); }
        .stat-card::before { content: ''; position: absolute; top: 0; left: 0; right: 0; height: 3px; }
        .stat-card.critico::before { background: #ef4444; }
        .stat-card.alto::before { background: #f97316; }
        .stat-card.medio::before { background: #eab308; }
        .stat-card.bajo::before { background: #22c55e; }
        .stat-icon { width: 44px; height: 44px; border-radius: 10px; display: flex; align-items: center; justify-content: center; font-size: 18px; margin-bottom: 14px; }
        .stat-icon.critico { background: #fef2f2; color: #ef4444; }
        .stat-icon.alto { background: #fff7ed; color: #f97316; }
        .stat-icon.medio { background: #fefce8; color: #eab308; }
        .stat-icon.bajo { background: #f0fdf4; color: #22c55e; }
        .stat-value { font-size: 32px; font-weight: 700; color: #1e293b; line-height: 1; margin-bottom: 4px; }
        .stat-label { font-size: 12px; color: #64748b; }
        .grid-2 { display: grid; grid-template-columns: 1fr 360px; gap: 20px; margin-bottom: 20px; }
        .panel { background: #fff; border-radius: 12px; border: 1px solid #e2e8f0; overflow: hidden; }
        .panel-header { padding: 16px 20px; border-bottom: 1px solid #f1f5f9; display: flex; align-items: center; justify-content: space-between; }
        .panel-title { font-size: 14px; font-weight: 600; color: #1e293b; display: flex; align-items: center; gap: 8px; }
        .panel-title i { color: #1e40af; }
        .panel-link { font-size: 12px; color: #1e40af; text-decoration: none; font-weight: 500; }
        .panel-link:hover { text-decoration: underline; }
        .table { width: 100%; border-collapse: collapse; }
        .table th { padding: 10px 16px; text-align: left; font-size: 11px; font-weight: 600; color: #64748b; text-transform: uppercase; letter-spacing: 0.5px; background: #f8fafc; border-bottom: 1px solid #e2e8f0; }
        .table td { padding: 12px 16px; font-size: 13px; color: #374151; border-bottom: 1px solid #f1f5f9; }
        .table tr:last-child td { border-bottom: none; }
        .table tr:hover td { background: #f8fafc; }
        .badge { display: inline-flex; align-items: center; gap: 4px; padding: 3px 10px; border-radius: 20px; font-size: 11px; font-weight: 600; }
        .badge-critico { background: #fef2f2; color: #dc2626; }
        .badge-alto { background: #fff7ed; color: #ea580c; }
        .badge-medio { background: #fefce8; color: #ca8a04; }
        .badge-bajo { background: #f0fdf4; color: #16a34a; }
        .badge-dot { width: 5px; height: 5px; border-radius: 50%; background: currentColor; }
        .resumen-item { display: flex; align-items: center; justify-content: space-between; padding: 14px 20px; border-bottom: 1px solid #f1f5f9; text-decoration: none; color: inherit; transition: background 0.15s; }
        .resumen-item:hover { background: #f8fafc; }
        .resumen-item:last-child { border-bottom: none; }
        .resumen-left { display: flex; align-items: center; gap: 12px; }
        .resumen-icon { width: 38px; height: 38px; border-radius: 9px; display: flex; align-items: center; justify-content: center; font-size: 16px; }
        .resumen-label { font-size: 13px; font-weight: 500; color: #1e293b; }
        .resumen-sub { font-size: 11px; color: #94a3b8; margin-top: 2px; }
        .resumen-value { font-size: 22px; font-weight: 700; color: #1e293b; }
        .log-item { display: flex; gap: 12px; padding: 12px 20px; border-bottom: 1px solid #f1f5f9; }
        .log-item:last-child { border-bottom: none; }
        .log-dot { width: 8px; height: 8px; border-radius: 50%; margin-top: 5px; flex-shrink: 0; }
        .log-desc { font-size: 12.5px; color: #374151; }
        .log-meta { font-size: 11px; color: #94a3b8; margin-top: 3px; }
        .empty-state { padding: 40px 20px; text-align: center; color: #94a3b8; font-size: 13px; }
        .empty-state i { font-size: 32px; margin-bottom: 10px; display: block; }
        .status-bar { background: #fff; border-top: 1px solid #e2e8f0; padding: 8px 28px; display: flex; align-items: center; gap: 20px; font-size: 11px; color: #94a3b8; }
        .status-item { display: flex; align-items: center; gap: 5px; }
        .status-dot { width: 6px; height: 6px; border-radius: 50%; }
    </style>
</head>
<body>
<aside class="sidebar">
    <div class="sidebar-logo"><h1>🛡️ RiskGuard TI</h1><p>Gestión de Riesgos · ISO 27001</p></div>
    <nav>
        <div class="nav-section-title">Principal</div>
        <a href="{{ route('dashboard') }}" class="nav-item active"><i class="fas fa-chart-pie"></i> Dashboard</a>
        <a href="{{ route('matriz.index') }}" class="nav-item"><i class="fas fa-map"></i> Matriz de Riesgos</a>
        <div class="nav-section-title">Gestión</div>
        <a href="{{ route('activos.index') }}" class="nav-item"><i class="fas fa-server"></i> Activos TI</a>
        <a href="{{ route('amenazas.index') }}" class="nav-item"><i class="fas fa-biohazard"></i> Amenazas</a>
        <a href="{{ route('evaluaciones.index') }}" class="nav-item"><i class="fas fa-search"></i> Evaluaciones</a>
        <a href="{{ route('evaluaciones.create') }}" class="nav-item"><i class="fas fa-calculator"></i> Cálculo de Riesgo</a>
        <a href="{{ route('mitigacion.index') }}" class="nav-item"><i class="fas fa-tools"></i> Mitigación</a>
        <div class="nav-section-title">Auditoría</div>
        <a href="{{ route('bitacora.index') }}" class="nav-item"><i class="fas fa-clipboard-list"></i> Bitácora</a>
        <a href="#" class="nav-item"><i class="fas fa-file-alt"></i> Reportes</a>
        <a href="#" class="nav-item"><i class="fas fa-check-circle"></i> Evidencias</a>
        <div class="nav-section-title">Sistema</div>
        <a href="{{ route('usuarios.index') }}" class="nav-item"><i class="fas fa-users"></i> Usuarios</a>
        <a href="{{ route('roles.index') }}" class="nav-item"><i class="fas fa-shield-alt"></i> Control de Roles</a>
        <a href="#" class="nav-item"><i class="fas fa-database"></i> Respaldo BD</a>
    </nav>
    <div class="sidebar-footer">
        <div class="user-info">
            <div class="user-avatar">{{ strtoupper(substr(auth()->user()->name, 0, 2)) }}</div>
            <div><div class="user-name">{{ auth()->user()->name }}</div><div class="user-role">{{ auth()->user()->getRoleNames()->first() ?? 'Sin rol' }}</div></div>
        </div>
        <form method="POST" action="{{ route('logout') }}">@csrf<button type="submit" class="btn-logout"><i class="fas fa-sign-out-alt"></i> Cerrar sesión</button></form>
    </div>
</aside>
<div class="main">
    <header class="topbar">
        <div class="topbar-title"><i class="fas fa-chart-pie" style="color:#1e40af;margin-right:8px;"></i> Dashboard General</div>
        <div class="topbar-right">
            <span style="font-size:12px;color:#94a3b8;">{{ now()->format('d/m/Y H:i') }}</span>
            <a href="{{ route('evaluaciones.index') }}" class="btn btn-outline"><i class="fas fa-list"></i> Ver Riesgos</a>
            <a href="{{ route('evaluaciones.create') }}" class="btn btn-primary"><i class="fas fa-plus"></i> Nuevo Riesgo</a>
        </div>
    </header>
    <div class="content">
        @if($totalCritico > 0)
        <div class="alert-critical">
            <i class="fas fa-exclamation-triangle"></i>
            <div>
                <div class="alert-critical-title">{{ $totalCritico }} riesgo(s) crítico(s) requieren atención inmediata</div>
                <div class="alert-critical-desc">Revisa la <a href="{{ route('matriz.index') }}" style="color:#dc2626;">matriz de riesgos</a> y asigna planes de mitigación urgentes.</div>
            </div>
        </div>
        @endif
        <div class="stats-grid">
            <a href="{{ route('evaluaciones.index') }}" class="stat-card critico">
                <div class="stat-icon critico"><i class="fas fa-exclamation-circle"></i></div>
                <div class="stat-value">{{ $totalCritico }}</div>
                <div class="stat-label">Riesgos Críticos</div>
            </a>
            <a href="{{ route('evaluaciones.index') }}" class="stat-card alto">
                <div class="stat-icon alto"><i class="fas fa-exclamation-triangle"></i></div>
                <div class="stat-value">{{ $totalAlto }}</div>
                <div class="stat-label">Riesgos Altos</div>
            </a>
            <a href="{{ route('evaluaciones.index') }}" class="stat-card medio">
                <div class="stat-icon medio"><i class="fas fa-minus-circle"></i></div>
                <div class="stat-value">{{ $totalMedio }}</div>
                <div class="stat-label">Riesgos Medios</div>
            </a>
            <a href="{{ route('evaluaciones.index') }}" class="stat-card bajo">
                <div class="stat-icon bajo"><i class="fas fa-check-circle"></i></div>
                <div class="stat-value">{{ $totalBajo }}</div>
                <div class="stat-label">Riesgos Bajos</div>
            </a>
        </div>
        <div class="grid-2">
            <div class="panel">
                <div class="panel-header">
                    <div class="panel-title"><i class="fas fa-list"></i> Últimos Riesgos Registrados</div>
                    <a href="{{ route('evaluaciones.index') }}" class="panel-link">Ver todos →</a>
                </div>
                @if($ultimosRiesgos->count() > 0)
                <table class="table">
                    <thead><tr><th>Amenaza / Activo</th><th>Impacto</th><th>Prob.</th><th>Nivel</th></tr></thead>
                    <tbody>
                    @foreach($ultimosRiesgos as $riesgo)
                    <tr>
                        <td>
                            <div style="font-weight:500;">{{ $riesgo->amenaza->nombre ?? 'N/A' }}</div>
                            <div style="font-size:11px;color:#94a3b8;">{{ $riesgo->activo->nombre ?? 'N/A' }}</div>
                        </td>
                        <td>{{ $riesgo->impacto }}</td>
                        <td>{{ $riesgo->probabilidad }}</td>
                        <td><span class="badge badge-{{ $riesgo->nivel_riesgo }}"><span class="badge-dot"></span>{{ strtoupper($riesgo->nivel_riesgo) }}</span></td>
                    </tr>
                    @endforeach
                    </tbody>
                </table>
                @else
                <div class="empty-state"><i class="fas fa-shield-alt"></i>No hay riesgos registrados aún.<br><a href="{{ route('evaluaciones.create') }}" style="color:#1e40af;">Registrar el primer riesgo →</a></div>
                @endif
            </div>
            <div class="panel">
                <div class="panel-header"><div class="panel-title"><i class="fas fa-chart-bar"></i> Resumen General</div></div>
                <a href="{{ route('activos.index') }}" class="resumen-item">
                    <div class="resumen-left"><div class="resumen-icon" style="background:#eff6ff;color:#1e40af;"><i class="fas fa-server"></i></div><div><div class="resumen-label">Activos TI</div><div class="resumen-sub">Registrados en el sistema</div></div></div>
                    <div class="resumen-value">{{ $totalActivos }}</div>
                </a>
                <a href="{{ route('amenazas.index') }}" class="resumen-item">
                    <div class="resumen-left"><div class="resumen-icon" style="background:#fef2f2;color:#ef4444;"><i class="fas fa-biohazard"></i></div><div><div class="resumen-label">Amenazas Activas</div><div class="resumen-sub">Identificadas y clasificadas</div></div></div>
                    <div class="resumen-value">{{ $totalAmenazas }}</div>
                </a>
                <a href="{{ route('evaluaciones.index') }}" class="resumen-item">
                    <div class="resumen-left"><div class="resumen-icon" style="background:#fefce8;color:#eab308;"><i class="fas fa-exclamation-triangle"></i></div><div><div class="resumen-label">Evaluaciones Activas</div><div class="resumen-sub">Riesgos bajo seguimiento</div></div></div>
                    <div class="resumen-value">{{ $totalRiesgos }}</div>
                </a>
                <a href="{{ route('mitigacion.index') }}" class="resumen-item">
                    <div class="resumen-left"><div class="resumen-icon" style="background:#f0fdf4;color:#22c55e;"><i class="fas fa-tools"></i></div><div><div class="resumen-label">Planes de Mitigación</div><div class="resumen-sub">Pendientes o en progreso</div></div></div>
                    <div class="resumen-value">{{ $totalPlanes }}</div>
                </a>
            </div>
        </div>
        <div class="panel">
            <div class="panel-header">
                <div class="panel-title"><i class="fas fa-clipboard-list"></i> Actividad Reciente — Bitácora</div>
                <a href="{{ route('bitacora.index') }}" class="panel-link">Ver bitácora completa →</a>
            </div>
            @if($ultimaBitacora->count() > 0)
                @foreach($ultimaBitacora as $log)
                <div class="log-item">
                    <div class="log-dot" style="background:@if(in_array($log->accion,['crear','aprobar']))#22c55e @elseif(in_array($log->accion,['eliminar','login_fallido']))#ef4444 @elseif($log->accion=='editar')#eab308 @else #3b82f6 @endif;"></div>
                    <div>
                        <div class="log-desc">{{ $log->descripcion }}</div>
                        <div class="log-meta">{{ $log->user_nombre ?? 'Sistema' }} · {{ \Carbon\Carbon::parse($log->created_at)->diffForHumans() }} · {{ strtoupper($log->accion) }}</div>
                    </div>
                </div>
                @endforeach
            @else
                <div class="empty-state"><i class="fas fa-clipboard"></i>La bitácora está vacía.</div>
            @endif
        </div>
    </div>
    <div class="status-bar">
        <div class="status-item"><div class="status-dot" style="background:#22c55e;"></div> Sistema operativo</div>
        <div class="status-item"><div class="status-dot" style="background:#22c55e;"></div> BD conectada</div>
        @if($totalCritico > 0)<div class="status-item"><div class="status-dot" style="background:#ef4444;"></div> {{ $totalCritico }} alerta(s) crítica(s)</div>@endif
        <div style="margin-left:auto;">ISO 27001 · Grupo 4 · v1.0</div>
    </div>
</div>
</body>
</html>

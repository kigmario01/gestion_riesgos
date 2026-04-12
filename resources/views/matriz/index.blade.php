<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Matriz de Riesgos</title>
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
        .btn{display:inline-flex;align-items:center;gap:6px;padding:8px 16px;border-radius:8px;font-size:13px;font-weight:500;cursor:pointer;border:none;text-decoration:none}
        .btn-primary{background:#1e40af;color:#fff}.btn-outline{background:#fff;color:#475569;border:1px solid #e2e8f0}
        .content{padding:24px 28px;flex:1}

        /* STATS */
        .stats-grid{display:grid;grid-template-columns:repeat(4,1fr);gap:16px;margin-bottom:24px}
        .stat-card{background:#fff;border-radius:12px;padding:18px;border:1px solid #e2e8f0;text-align:center;position:relative;overflow:hidden}
        .stat-card::before{content:'';position:absolute;top:0;left:0;right:0;height:3px}
        .stat-card.critico::before{background:#ef4444}.stat-card.alto::before{background:#f97316}.stat-card.medio::before{background:#eab308}.stat-card.bajo::before{background:#22c55e}
        .stat-value{font-size:36px;font-weight:800;line-height:1}.stat-label{font-size:12px;color:#64748b;margin-top:4px}
        .c-critico{color:#dc2626}.c-alto{color:#ea580c}.c-medio{color:#ca8a04}.c-bajo{color:#16a34a}

        /* MATRIZ */
        .matriz-wrap{background:#fff;border-radius:12px;border:1px solid #e2e8f0;padding:24px;margin-bottom:24px}
        .matriz-title{font-size:14px;font-weight:600;margin-bottom:16px;display:flex;align-items:center;gap:8px}
        .matriz-title i{color:#1e40af}
        .matriz-grid{display:grid;grid-template-columns:40px repeat(5,1fr);gap:4px;max-width:600px}
        .matriz-axis{display:flex;align-items:center;justify-content:center;font-size:11px;font-weight:600;color:#64748b}
        .matriz-cell{aspect-ratio:1;border-radius:8px;display:flex;flex-direction:column;align-items:center;justify-content:center;font-size:13px;font-weight:700;cursor:pointer;transition:opacity 0.2s;position:relative}
        .matriz-cell:hover{opacity:0.8}.mc-bajo{background:#dcfce7;color:#16a34a}.mc-medio{background:#fef9c3;color:#ca8a04}.mc-alto{background:#ffedd5;color:#ea580c}.mc-critico{background:#fee2e2;color:#dc2626}
        .mc-count{font-size:10px;font-weight:400;opacity:0.8}
        .eje-label{font-size:10px;color:#94a3b8;text-align:center;margin-top:8px}

        /* LEYENDA */
        .leyenda{display:flex;gap:16px;margin-top:12px;flex-wrap:wrap}
        .ley-item{display:flex;align-items:center;gap:6px;font-size:12px;color:#374151}
        .ley-dot{width:12px;height:12px;border-radius:3px}

        /* TABLA */
        .panel{background:#fff;border-radius:12px;border:1px solid #e2e8f0;overflow:hidden}
        .panel-header{padding:16px 20px;border-bottom:1px solid #f1f5f9;display:flex;align-items:center;justify-content:space-between}
        .panel-title{font-size:14px;font-weight:600;display:flex;align-items:center;gap:8px}.panel-title i{color:#1e40af}
        .table{width:100%;border-collapse:collapse}.table th{padding:10px 16px;text-align:left;font-size:11px;font-weight:600;color:#64748b;text-transform:uppercase;letter-spacing:0.5px;background:#f8fafc;border-bottom:1px solid #e2e8f0}
        .table td{padding:12px 16px;font-size:13px;color:#374151;border-bottom:1px solid #f1f5f9}.table tr:last-child td{border-bottom:none}.table tr:hover td{background:#f8fafc}
        .badge{display:inline-flex;align-items:center;gap:4px;padding:3px 10px;border-radius:20px;font-size:11px;font-weight:600}
        .badge-critico{background:#fef2f2;color:#dc2626}.badge-alto{background:#fff7ed;color:#ea580c}.badge-medio{background:#fefce8;color:#ca8a04}.badge-bajo{background:#f0fdf4;color:#16a34a}
        .empty-state{padding:60px 20px;text-align:center;color:#94a3b8}.empty-state i{font-size:40px;margin-bottom:12px;display:block;color:#cbd5e1}
    </style>
</head>
<body>
<aside class="sidebar">
    <div class="sidebar-logo"><h1>🛡️ RiskGuard TI</h1><p>Gestión de Riesgos · ISO 27001</p></div>
    <nav>
        <div class="nav-section-title">Principal</div>
        <a href="/dashboard" class="nav-item"><i class="fas fa-chart-pie"></i> Dashboard</a>
        <a href="{{ route('matriz.index') }}" class="nav-item active"><i class="fas fa-map"></i> Matriz de Riesgos</a>
        <div class="nav-section-title">Gestión</div>
        <a href="{{ route('activos.index') }}" class="nav-item"><i class="fas fa-server"></i> Activos TI</a>
        <a href="{{ route('amenazas.index') }}" class="nav-item"><i class="fas fa-biohazard"></i> Amenazas</a>
        <a href="{{ route('evaluaciones.index') }}" class="nav-item"><i class="fas fa-search"></i> Evaluaciones</a>
        <a href="{{ route('mitigacion.index') }}" class="nav-item"><i class="fas fa-tools"></i> Mitigación</a>
        <div class="nav-section-title">Auditoría</div>
        <a href="{{ route('bitacora.index') }}" class="nav-item"><i class="fas fa-clipboard-list"></i> Bitácora</a>
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
        <div class="topbar-title"><i class="fas fa-map" style="color:#1e40af;margin-right:8px;"></i> Matriz de Riesgos TI — ISO 27001</div>
        <a href="{{ route('evaluaciones.create') }}" class="btn btn-primary"><i class="fas fa-plus"></i> Nueva Evaluación</a>
    </header>
    <div class="content">

        <!-- STATS -->
        <div class="stats-grid">
            <div class="stat-card critico"><div class="stat-value c-critico">{{ $criticos->count() }}</div><div class="stat-label">🔴 Crítico (16-25)</div></div>
            <div class="stat-card alto"><div class="stat-value c-alto">{{ $altos->count() }}</div><div class="stat-label">🟠 Alto (10-15)</div></div>
            <div class="stat-card medio"><div class="stat-value c-medio">{{ $medios->count() }}</div><div class="stat-label">🟡 Medio (5-9)</div></div>
            <div class="stat-card bajo"><div class="stat-value c-bajo">{{ $bajos->count() }}</div><div class="stat-label">🟢 Bajo (1-4)</div></div>
        </div>

        <!-- MATRIZ 5x5 -->
        <div class="matriz-wrap">
            <div class="matriz-title"><i class="fas fa-th"></i> Matriz de Riesgo 5×5 (Impacto vs Probabilidad)</div>
            <div style="display:flex;gap:24px;align-items:flex-start;flex-wrap:wrap;">
                <div>
                    <div style="font-size:11px;font-weight:600;color:#64748b;margin-bottom:8px;text-align:center;">PROBABILIDAD →</div>
                    <div class="matriz-grid">
                        <div class="matriz-axis" style="grid-column:1;grid-row:1;"></div>
                        @for($p=1;$p<=5;$p++)
                        <div class="matriz-axis">{{ $p }}</div>
                        @endfor

                        @for($i=5;$i>=1;$i--)
                        <div class="matriz-axis" style="font-size:10px;">I={{ $i }}</div>
                        @for($p=1;$p<=5;$p++)
                        <div class="matriz-cell mc-{{ $matriz[$i][$p]['nivel'] }}" title="Impacto:{{ $i }} × Prob:{{ $p }} = {{ $matriz[$i][$p]['valor'] }}">
                            {{ $matriz[$i][$p]['valor'] }}
                            @if($matriz[$i][$p]['count'] > 0)
                            <span class="mc-count">({{ $matriz[$i][$p]['count'] }})</span>
                            @endif
                        </div>
                        @endfor
                        @endfor
                    </div>
                    <div class="eje-label">↑ IMPACTO</div>
                    <div class="leyenda">
                        <div class="ley-item"><div class="ley-dot" style="background:#dcfce7;border:1px solid #16a34a;"></div> Bajo (1-4)</div>
                        <div class="ley-item"><div class="ley-dot" style="background:#fef9c3;border:1px solid #ca8a04;"></div> Medio (5-9)</div>
                        <div class="ley-item"><div class="ley-dot" style="background:#ffedd5;border:1px solid #ea580c;"></div> Alto (10-15)</div>
                        <div class="ley-item"><div class="ley-dot" style="background:#fee2e2;border:1px solid #dc2626;"></div> Crítico (16-25)</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- TABLA DE RIESGOS -->
        <div class="panel">
            <div class="panel-header">
                <div class="panel-title"><i class="fas fa-exclamation-triangle"></i> Riesgos Activos ordenados por criticidad</div>
                <span style="font-size:12px;color:#94a3b8;">{{ $evaluaciones->count() }} evaluaciones</span>
            </div>
            @if($evaluaciones->count() > 0)
            <table class="table">
                <thead><tr><th>Código</th><th>Activo</th><th>Amenaza</th><th>I</th><th>P</th><th>Valor</th><th>Nivel</th></tr></thead>
                <tbody>
                @foreach($evaluaciones as $ev)
                <tr>
                    <td><code style="background:#f1f5f9;padding:2px 6px;border-radius:4px;font-size:11px;">{{ $ev->codigo }}</code></td>
                    <td><div style="font-weight:500;">{{ $ev->activo->nombre ?? 'N/A' }}</div><div style="font-size:11px;color:#94a3b8;">{{ $ev->activo->tipo ?? '' }}</div></td>
                    <td>{{ $ev->amenaza->nombre ?? 'N/A' }}</td>
                    <td style="text-align:center;font-weight:600;">{{ $ev->impacto }}</td>
                    <td style="text-align:center;font-weight:600;">{{ $ev->probabilidad }}</td>
                    <td style="text-align:center;font-size:18px;font-weight:800;" class="c-{{ $ev->nivel_riesgo }}">{{ $ev->valor_riesgo }}</td>
                    <td><span class="badge badge-{{ $ev->nivel_riesgo }}">{{ strtoupper($ev->nivel_riesgo) }}</span></td>
                </tr>
                @endforeach
                </tbody>
            </table>
            @else
            <div class="empty-state"><i class="fas fa-shield-alt"></i><p>No hay evaluaciones activas. <a href="{{ route('evaluaciones.create') }}" style="color:#1e40af;">Crear primera evaluación →</a></p></div>
            @endif
        </div>
    </div>
</div>
</body>
</html>

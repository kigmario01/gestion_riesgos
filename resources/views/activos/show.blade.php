<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $activo->nombre }} — Activos TI</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css'])
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Inter', sans-serif; background: #f0f4f8; color: #1e293b; }

        .sidebar {
            position: fixed; top: 0; left: 0;
            width: 250px; height: 100vh;
            background: #1e40af;
            display: flex; flex-direction: column;
            z-index: 100; overflow-y: auto;
        }
        .sidebar-logo { padding: 24px 20px; border-bottom: 1px solid rgba(255,255,255,0.1); }
        .sidebar-logo h1 { color: #fff; font-size: 18px; font-weight: 700; }
        .sidebar-logo p { color: rgba(255,255,255,0.6); font-size: 11px; margin-top: 3px; }
        .nav-section-title { padding: 16px 20px 6px; font-size: 10px; font-weight: 600; letter-spacing: 1.5px; text-transform: uppercase; color: rgba(255,255,255,0.4); }
        .nav-item { display: flex; align-items: center; gap: 10px; padding: 10px 20px; color: rgba(255,255,255,0.75); text-decoration: none; font-size: 13.5px; transition: all 0.2s; border-left: 3px solid transparent; }
        .nav-item:hover { background: rgba(255,255,255,0.08); color: #fff; }
        .nav-item.active { background: rgba(255,255,255,0.12); color: #fff; border-left-color: #60a5fa; font-weight: 500; }
        .nav-item i { width: 18px; text-align: center; font-size: 14px; }
        .sidebar-footer { margin-top: auto; padding: 16px 20px; border-top: 1px solid rgba(255,255,255,0.1); }
        .user-info { display: flex; align-items: center; gap: 10px; }
        .user-avatar { width: 36px; height: 36px; border-radius: 50%; background: #60a5fa; display: flex; align-items: center; justify-content: center; font-weight: 700; font-size: 14px; color: #1e40af; }
        .user-name { font-size: 13px; color: #fff; font-weight: 500; }
        .user-role { font-size: 11px; color: rgba(255,255,255,0.5); }
        .btn-logout { display: flex; align-items: center; gap: 6px; margin-top: 10px; padding: 7px 12px; background: rgba(255,255,255,0.08); color: rgba(255,255,255,0.7); border-radius: 8px; font-size: 12px; text-decoration: none; transition: all 0.2s; border: none; cursor: pointer; width: 100%; }
        .btn-logout:hover { background: rgba(239,68,68,0.2); color: #fca5a5; }

        .main { margin-left: 250px; min-height: 100vh; display: flex; flex-direction: column; }
        .topbar { background: #fff; border-bottom: 1px solid #e2e8f0; padding: 0 28px; height: 58px; display: flex; align-items: center; justify-content: space-between; position: sticky; top: 0; z-index: 50; }
        .topbar-title { font-size: 16px; font-weight: 600; color: #1e293b; }
        .topbar-right { display: flex; align-items: center; gap: 10px; }
        .btn { display: inline-flex; align-items: center; gap: 6px; padding: 8px 16px; border-radius: 8px; font-size: 13px; font-weight: 500; cursor: pointer; border: none; text-decoration: none; transition: all 0.2s; }
        .btn-primary { background: #1e40af; color: #fff; }
        .btn-primary:hover { background: #1d3a9e; }
        .btn-outline { background: #fff; color: #475569; border: 1px solid #e2e8f0; }
        .btn-outline:hover { border-color: #1e40af; color: #1e40af; }
        .btn-danger { background: #fef2f2; color: #dc2626; border: 1px solid #fecaca; }
        .btn-danger:hover { background: #fee2e2; }
        .btn-sm { padding: 5px 10px; font-size: 12px; }

        .content { padding: 24px 28px; flex: 1; }

        .alert-success { background: #f0fdf4; border: 1px solid #bbf7d0; border-left: 4px solid #22c55e; border-radius: 10px; padding: 12px 18px; margin-bottom: 20px; color: #15803d; font-size: 13px; display: flex; align-items: center; gap: 8px; }

        .panel { background: #fff; border-radius: 12px; border: 1px solid #e2e8f0; overflow: hidden; margin-bottom: 20px; }
        .panel-header { padding: 16px 20px; border-bottom: 1px solid #f1f5f9; display: flex; align-items: center; justify-content: space-between; }
        .panel-title { font-size: 14px; font-weight: 600; color: #1e293b; display: flex; align-items: center; gap: 8px; }
        .panel-title i { color: #1e40af; }

        .detail-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 20px; padding: 20px; }
        .detail-item { display: flex; flex-direction: column; gap: 6px; }
        .detail-label { font-size: 11px; font-weight: 600; color: #64748b; text-transform: uppercase; letter-spacing: 0.5px; }
        .detail-value { font-size: 14px; color: #1e293b; font-weight: 500; }

        .badge { display: inline-flex; align-items: center; gap: 4px; padding: 4px 12px; border-radius: 20px; font-size: 11px; font-weight: 600; }
        .badge-critica { background: #fef2f2; color: #dc2626; }
        .badge-alta { background: #fff7ed; color: #ea580c; }
        .badge-media { background: #fefce8; color: #ca8a04; }
        .badge-baja { background: #f0fdf4; color: #16a34a; }
        .badge-activo { background: #f0fdf4; color: #16a34a; }
        .badge-inactivo { background: #fef2f2; color: #dc2626; }
        .badge-en_mantenimiento { background: #eff6ff; color: #1e40af; }

        .table { width: 100%; border-collapse: collapse; }
        .table th { padding: 10px 16px; text-align: left; font-size: 11px; font-weight: 600; color: #64748b; text-transform: uppercase; letter-spacing: 0.5px; background: #f8fafc; border-bottom: 1px solid #e2e8f0; }
        .table td { padding: 12px 16px; font-size: 13px; color: #374151; border-bottom: 1px solid #f1f5f9; vertical-align: middle; }
        .table tr:last-child td { border-bottom: none; }
        .table tr:hover td { background: #f8fafc; }

        .empty-state { padding: 40px 20px; text-align: center; color: #94a3b8; font-size: 13px; }
        .empty-state i { font-size: 32px; margin-bottom: 10px; display: block; }
    </style>
</head>
<body>

<aside class="sidebar">
    <div class="sidebar-logo">
        <h1>🛡️ RiskGuard TI</h1>
        <p>Gestión de Riesgos · ISO 27001</p>
    </div>
    <nav>
        <div class="nav-section-title">Principal</div>
        <a href="{{ route('dashboard') }}" class="nav-item"><i class="fas fa-chart-pie"></i> Dashboard</a>
        <a href="{{ route('matriz.index') }}" class="nav-item"><i class="fas fa-map"></i> Matriz de Riesgos</a>
        <div class="nav-section-title">Gestión</div>
        <a href="{{ route('activos.index') }}" class="nav-item active"><i class="fas fa-server"></i> Activos TI</a>
        <a href="{{ route('amenazas.index') }}" class="nav-item"><i class="fas fa-biohazard"></i> Amenazas</a>
        <a href="{{ route('evaluaciones.index') }}" class="nav-item"><i class="fas fa-search"></i> Evaluaciones</a>
        <a href="{{ route('evaluaciones.create') }}" class="nav-item"><i class="fas fa-calculator"></i> Cálculo de Riesgo</a>
        <a href="{{ route('mitigacion.index') }}" class="nav-item"><i class="fas fa-tools"></i> Mitigación</a>
        <div class="nav-section-title">Auditoría</div>
        <a href="{{ route('bitacora.index') }}" class="nav-item"><i class="fas fa-clipboard-list"></i> Bitácora</a>
        <div class="nav-section-title">Sistema</div>
        <a href="{{ route('usuarios.index') }}" class="nav-item"><i class="fas fa-users"></i> Usuarios</a>
        <a href="#" class="nav-item"><i class="fas fa-shield-alt"></i> Control de Roles</a>
        <a href="#" class="nav-item"><i class="fas fa-database"></i> Respaldo BD</a>
    </nav>
    <div class="sidebar-footer">
        <div class="user-info">
            <div class="user-avatar">{{ strtoupper(substr(auth()->user()->name, 0, 2)) }}</div>
            <div>
                <div class="user-name">{{ auth()->user()->name }}</div>
                <div class="user-role">{{ auth()->user()->getRoleNames()->first() ?? 'Sin rol' }}</div>
            </div>
        </div>
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="btn-logout"><i class="fas fa-sign-out-alt"></i> Cerrar sesión</button>
        </form>
    </div>
</aside>

<div class="main">
    <header class="topbar">
        <div class="topbar-title"><i class="fas fa-server" style="color:#1e40af; margin-right:8px;"></i> Detalles del Activo TI</div>
        <div class="topbar-right">
            <a href="{{ route('activos.edit', $activo) }}" class="btn btn-outline"><i class="fas fa-edit"></i> Editar</a>
            <a href="{{ route('activos.index') }}" class="btn btn-outline"><i class="fas fa-arrow-left"></i> Volver</a>
        </div>
    </header>

    <div class="content">

        @if(session('success'))
        <div class="alert-success"><i class="fas fa-check-circle"></i> {{ session('success') }}</div>
        @endif

        <div class="panel">
            <div class="panel-header">
                <div class="panel-title"><i class="fas fa-info-circle"></i> Información General</div>
            </div>
            <div class="detail-grid">
                <div class="detail-item">
                    <div class="detail-label">Código</div>
                    <div class="detail-value"><code style="background:#f1f5f9; padding:2px 6px; border-radius:4px; font-size:12px;">{{ $activo->codigo }}</code></div>
                </div>
                <div class="detail-item">
                    <div class="detail-label">Nombre</div>
                    <div class="detail-value">{{ $activo->nombre }}</div>
                </div>
                <div class="detail-item">
                    <div class="detail-label">Tipo</div>
                    <div class="detail-value" style="text-transform:capitalize;">{{ $activo->tipo }}</div>
                </div>
                <div class="detail-item">
                    <div class="detail-label">Criticidad</div>
                    <div class="detail-value"><span class="badge badge-{{ $activo->criticidad }}">{{ strtoupper($activo->criticidad) }}</span></div>
                </div>
                <div class="detail-item">
                    <div class="detail-label">Estado</div>
                    <div class="detail-value"><span class="badge badge-{{ $activo->estado }}">{{ strtoupper(str_replace('_', ' ', $activo->estado)) }}</span></div>
                </div>
                <div class="detail-item">
                    <div class="detail-label">Ubicación</div>
                    <div class="detail-value">{{ $activo->ubicacion ?? '—' }}</div>
                </div>
                <div class="detail-item">
                    <div class="detail-label">Responsable</div>
                    <div class="detail-value">{{ $activo->responsable ?? '—' }}</div>
                </div>
                <div class="detail-item">
                    <div class="detail-label">Valor Económico</div>
                    <div class="detail-value">{{ $activo->valor_economico ? '$' . number_format($activo->valor_economico, 2) : '—' }}</div>
                </div>
                <div class="detail-item">
                    <div class="detail-label">Registrado por</div>
                    <div class="detail-value">{{ $activo->registrador->name ?? '—' }}</div>
                </div>
                <div class="detail-item">
                    <div class="detail-label">Fecha de Registro</div>
                    <div class="detail-value">{{ $activo->created_at->format('d/m/Y H:i') }}</div>
                </div>
                <div class="detail-item">
                    <div class="detail-label">Última Actualización</div>
                    <div class="detail-value">{{ $activo->updated_at->format('d/m/Y H:i') }}</div>
                </div>
            </div>
            @if($activo->descripcion)
            <div style="padding:20px; border-top:1px solid #f1f5f9;">
                <div style="font-size:11px; font-weight:600; color:#64748b; text-transform:uppercase; letter-spacing:0.5px; margin-bottom:8px;">Descripción</div>
                <div style="font-size:14px; color:#374151; line-height:1.5;">{{ $activo->descripcion }}</div>
            </div>
            @endif
        </div>

        <div class="panel">
            <div class="panel-header">
                <div class="panel-title"><i class="fas fa-exclamation-triangle"></i> Evaluaciones de Riesgo</div>
                <a href="{{ route('evaluaciones.create', ['activo_id' => $activo->id]) }}" class="btn btn-primary btn-sm"><i class="fas fa-plus"></i> Nueva Evaluación</a>
            </div>
            @if($activo->evaluaciones->count() > 0)
            <table class="table">
                <thead>
                    <tr>
                        <th>Amenaza</th>
                        <th>Impacto</th>
                        <th>Probabilidad</th>
                        <th>Nivel de Riesgo</th>
                        <th>Fecha</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($activo->evaluaciones as $evaluacion)
                    <tr>
                        <td>
                            <div style="font-weight:500;">{{ $evaluacion->amenaza->nombre ?? 'N/A' }}</div>
                            @if($evaluacion->amenaza->descripcion)
                            <div style="font-size:11px; color:#94a3b8;">{{ Str::limit($evaluacion->amenaza->descripcion, 40) }}</div>
                            @endif
                        </td>
                        <td>{{ $evaluacion->impacto }}</td>
                        <td>{{ $evaluacion->probabilidad }}</td>
                        <td><span class="badge badge-{{ $evaluacion->nivel_riesgo }}">{{ strtoupper($evaluacion->nivel_riesgo) }}</span></td>
                        <td style="font-size:12px; color:#64748b;">{{ $evaluacion->created_at->format('d/m/Y') }}</td>
                        <td>
                            <a href="{{ route('evaluaciones.show', $evaluacion) }}" class="btn btn-outline btn-sm"><i class="fas fa-eye"></i></a>
                            <a href="{{ route('evaluaciones.edit', $evaluacion) }}" class="btn btn-outline btn-sm"><i class="fas fa-edit"></i></a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            @else
            <div class="empty-state">
                <i class="fas fa-shield-alt"></i>
                <p>No hay evaluaciones de riesgo para este activo.</p>
                <a href="{{ route('evaluaciones.create', ['activo_id' => $activo->id]) }}" class="btn btn-primary"><i class="fas fa-plus"></i> Crear primera evaluación</a>
            </div>
            @endif
        </div>
    </div>
</div>

</body>
</html>
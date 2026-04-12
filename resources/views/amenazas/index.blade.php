<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Amenazas — Gestión de Riesgos</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css'])
    <style>
        * { margin:0; padding:0; box-sizing:border-box; }
        body { font-family:'Inter',sans-serif; background:#f0f4f8; color:#1e293b; }
        .sidebar { position:fixed; top:0; left:0; width:250px; height:100vh; background:#1e40af; display:flex; flex-direction:column; z-index:100; overflow-y:auto; }
        .sidebar-logo { padding:24px 20px; border-bottom:1px solid rgba(255,255,255,0.1); }
        .sidebar-logo h1 { color:#fff; font-size:18px; font-weight:700; }
        .sidebar-logo p { color:rgba(255,255,255,0.6); font-size:11px; margin-top:3px; }
        .nav-section-title { padding:16px 20px 6px; font-size:10px; font-weight:600; letter-spacing:1.5px; text-transform:uppercase; color:rgba(255,255,255,0.4); }
        .nav-item { display:flex; align-items:center; gap:10px; padding:10px 20px; color:rgba(255,255,255,0.75); text-decoration:none; font-size:13.5px; transition:all 0.2s; border-left:3px solid transparent; }
        .nav-item:hover { background:rgba(255,255,255,0.08); color:#fff; }
        .nav-item.active { background:rgba(255,255,255,0.12); color:#fff; border-left-color:#60a5fa; font-weight:500; }
        .nav-item i { width:18px; text-align:center; font-size:14px; }
        .sidebar-footer { margin-top:auto; padding:16px 20px; border-top:1px solid rgba(255,255,255,0.1); }
        .user-info { display:flex; align-items:center; gap:10px; }
        .user-avatar { width:36px; height:36px; border-radius:50%; background:#60a5fa; display:flex; align-items:center; justify-content:center; font-weight:700; font-size:14px; color:#1e40af; }
        .user-name { font-size:13px; color:#fff; font-weight:500; }
        .user-role { font-size:11px; color:rgba(255,255,255,0.5); }
        .btn-logout { display:flex; align-items:center; gap:6px; margin-top:10px; padding:7px 12px; background:rgba(255,255,255,0.08); color:rgba(255,255,255,0.7); border-radius:8px; font-size:12px; border:none; cursor:pointer; width:100%; }
        .btn-logout:hover { background:rgba(239,68,68,0.2); color:#fca5a5; }
        .main { margin-left:250px; min-height:100vh; display:flex; flex-direction:column; }
        .topbar { background:#fff; border-bottom:1px solid #e2e8f0; padding:0 28px; height:58px; display:flex; align-items:center; justify-content:space-between; position:sticky; top:0; z-index:50; }
        .topbar-title { font-size:16px; font-weight:600; }
        .btn { display:inline-flex; align-items:center; gap:6px; padding:8px 16px; border-radius:8px; font-size:13px; font-weight:500; cursor:pointer; border:none; text-decoration:none; transition:all 0.2s; }
        .btn-primary { background:#1e40af; color:#fff; }
        .btn-primary:hover { background:#1d3a9e; }
        .btn-outline { background:#fff; color:#475569; border:1px solid #e2e8f0; }
        .btn-outline:hover { border-color:#1e40af; color:#1e40af; }
        .btn-danger { background:#fef2f2; color:#dc2626; border:1px solid #fecaca; }
        .btn-sm { padding:5px 10px; font-size:12px; }
        .content { padding:24px 28px; flex:1; }
        .alert-success { background:#f0fdf4; border:1px solid #bbf7d0; border-left:4px solid #22c55e; border-radius:10px; padding:12px 18px; margin-bottom:20px; color:#15803d; font-size:13px; display:flex; align-items:center; gap:8px; }
        .panel { background:#fff; border-radius:12px; border:1px solid #e2e8f0; overflow:hidden; }
        .panel-header { padding:16px 20px; border-bottom:1px solid #f1f5f9; display:flex; align-items:center; justify-content:space-between; }
        .panel-title { font-size:14px; font-weight:600; display:flex; align-items:center; gap:8px; }
        .panel-title i { color:#1e40af; }
        .table { width:100%; border-collapse:collapse; }
        .table th { padding:10px 16px; text-align:left; font-size:11px; font-weight:600; color:#64748b; text-transform:uppercase; letter-spacing:0.5px; background:#f8fafc; border-bottom:1px solid #e2e8f0; }
        .table td { padding:12px 16px; font-size:13px; color:#374151; border-bottom:1px solid #f1f5f9; vertical-align:middle; }
        .table tr:last-child td { border-bottom:none; }
        .table tr:hover td { background:#f8fafc; }
        .badge { display:inline-flex; align-items:center; gap:4px; padding:3px 10px; border-radius:20px; font-size:11px; font-weight:600; }
        .badge-accidental { background:#eff6ff; color:#1e40af; }
        .badge-deliberada { background:#fef2f2; color:#dc2626; }
        .badge-ambiental { background:#f0fdf4; color:#16a34a; }
        .badge-tecnica { background:#fefce8; color:#ca8a04; }
        .badge-humana { background:#fdf4ff; color:#9333ea; }
        .badge-interno { background:#fff7ed; color:#ea580c; }
        .badge-externo { background:#fef2f2; color:#dc2626; }
        .badge-natural { background:#f0fdf4; color:#16a34a; }
        .badge-activa { background:#f0fdf4; color:#16a34a; }
        .badge-inactiva { background:#f8fafc; color:#64748b; }
        .actions { display:flex; gap:6px; }
        .empty-state { padding:60px 20px; text-align:center; color:#94a3b8; }
        .empty-state i { font-size:40px; margin-bottom:12px; display:block; color:#cbd5e1; }
    </style>
</head>
<body>
<aside class="sidebar">
    <div class="sidebar-logo"><h1>🛡️ RiskGuard TI</h1><p>Gestión de Riesgos · ISO 27001</p></div>
    <nav>
        <div class="nav-section-title">Principal</div>
        <a href="/dashboard" class="nav-item"><i class="fas fa-chart-pie"></i> Dashboard</a>
        <a href="{{ route('matriz.index') }}" class="nav-item"><i class="fas fa-map"></i> Matriz de Riesgos</a>
        <div class="nav-section-title">Gestión</div>
        <a href="{{ route('activos.index') }}" class="nav-item"><i class="fas fa-server"></i> Activos TI</a>
        <a href="{{ route('amenazas.index') }}" class="nav-item active"><i class="fas fa-biohazard"></i> Amenazas</a>
        <a href="{{ route('evaluaciones.index') }}" class="nav-item"><i class="fas fa-search"></i> Evaluaciones</a>
        <a href="{{ route('mitigacion.index') }}" class="nav-item"><i class="fas fa-tools"></i> Mitigación</a>
        <div class="nav-section-title">Auditoría</div>
        <a href="{{ route('bitacora.index') }}" class="nav-item"><i class="fas fa-clipboard-list"></i> Bitácora</a>
        <div class="nav-section-title">Sistema</div>
        <a href="{{ route('usuarios.index') }}" class="nav-item"><i class="fas fa-users"></i> Usuarios</a>
        <a href="#" class="nav-item"><i class="fas fa-shield-alt"></i> Control de Roles</a>
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
        <div class="topbar-title"><i class="fas fa-biohazard" style="color:#1e40af;margin-right:8px;"></i> Amenazas</div>
        <a href="{{ route('amenazas.create') }}" class="btn btn-primary"><i class="fas fa-plus"></i> Nueva Amenaza</a>
    </header>
    <div class="content">
        @if(session('success'))<div class="alert-success"><i class="fas fa-check-circle"></i> {{ session('success') }}</div>@endif
        <div class="panel">
            <div class="panel-header">
                <div class="panel-title"><i class="fas fa-list"></i> Listado de Amenazas</div>
                <span style="font-size:12px;color:#94a3b8;">Total: {{ $amenazas->total() }}</span>
            </div>
            @if($amenazas->count() > 0)
            <table class="table">
                <thead><tr><th>Código</th><th>Nombre</th><th>Categoría</th><th>Origen</th><th>Estado</th><th>Acciones</th></tr></thead>
                <tbody>
                @foreach($amenazas as $amenaza)
                <tr>
                    <td><code style="background:#f1f5f9;padding:2px 6px;border-radius:4px;font-size:12px;">{{ $amenaza->codigo }}</code></td>
                    <td>
                        <div style="font-weight:500;">{{ $amenaza->nombre }}</div>
                        @if($amenaza->descripcion)<div style="font-size:11px;color:#94a3b8;">{{ Str::limit($amenaza->descripcion,50) }}</div>@endif
                    </td>
                    <td><span class="badge badge-{{ $amenaza->categoria }}">{{ ucfirst($amenaza->categoria) }}</span></td>
                    <td><span class="badge badge-{{ $amenaza->origen }}">{{ ucfirst($amenaza->origen) }}</span></td>
                    <td><span class="badge badge-{{ $amenaza->estado }}">{{ strtoupper($amenaza->estado) }}</span></td>
                    <td>
                        <div class="actions">
                            <a href="{{ route('amenazas.edit', $amenaza) }}" class="btn btn-outline btn-sm"><i class="fas fa-edit"></i></a>
                            <form method="POST" action="{{ route('amenazas.destroy', $amenaza) }}" onsubmit="return confirm('¿Eliminar?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm"><i class="fas fa-trash"></i></button>
                            </form>
                        </div>
                    </td>
                </tr>
                @endforeach
                </tbody>
            </table>
            <div style="padding:16px;">{{ $amenazas->links() }}</div>
            @else
            <div class="empty-state"><i class="fas fa-biohazard"></i><p>No hay amenazas registradas.</p><a href="{{ route('amenazas.create') }}" class="btn btn-primary"><i class="fas fa-plus"></i> Registrar primera amenaza</a></div>
            @endif
        </div>
    </div>
</div>
</body>
</html>

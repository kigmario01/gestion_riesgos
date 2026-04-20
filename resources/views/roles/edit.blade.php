<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Permisos — {{ strtoupper($rol->name) }}</title>
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
        .btn-primary{background:#1e40af;color:#fff}.btn-primary:hover{background:#1d3a9e}
        .btn-outline{background:#fff;color:#475569;border:1px solid #e2e8f0}.btn-outline:hover{border-color:#1e40af;color:#1e40af}
        .btn-sm{padding:5px 10px;font-size:12px}
        .content{padding:24px 28px;flex:1}
        .panel{background:#fff;border-radius:12px;border:1px solid #e2e8f0;overflow:hidden;margin-bottom:20px}
        .panel-header{padding:16px 20px;border-bottom:1px solid #f1f5f9;display:flex;align-items:center;justify-content:space-between}
        .panel-title{font-size:14px;font-weight:600;display:flex;align-items:center;gap:8px}.panel-title i{color:#1e40af}
        .module-block{border-bottom:1px solid #f1f5f9}
        .module-block:last-child{border-bottom:none}
        .module-header{padding:12px 20px;background:#f8fafc;display:flex;align-items:center;justify-content:space-between;cursor:pointer}
        .module-title{font-size:12px;font-weight:700;color:#475569;text-transform:uppercase;letter-spacing:1px;display:flex;align-items:center;gap:8px}
        .module-body{padding:14px 20px;display:flex;flex-wrap:wrap;gap:10px}
        .perm-toggle{display:flex;align-items:center;gap:8px;cursor:pointer;user-select:none}
        .perm-toggle input[type=checkbox]{width:16px;height:16px;cursor:pointer;accent-color:#1e40af}
        .perm-label{font-size:13px;color:#374151;font-weight:500}
        .perm-label-sub{font-size:11px;color:#94a3b8}
        .select-all-btn{font-size:11px;color:#1e40af;cursor:pointer;background:none;border:none;font-weight:600;padding:0}
        .action-bar{background:#fff;border-top:1px solid #e2e8f0;padding:16px 28px;display:flex;align-items:center;justify-content:space-between;position:sticky;bottom:0;z-index:40}
        .warning-note{background:#fff7ed;border:1px solid #fed7aa;border-radius:8px;padding:10px 14px;font-size:12px;color:#92400e;display:flex;align-items:center;gap:8px}
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
        <div class="topbar-title"><i class="fas fa-edit" style="color:#1e40af;margin-right:8px;"></i> Editar Permisos — {{ str_replace('_',' ',strtoupper($rol->name)) }}</div>
        <div class="topbar-right">
            <a href="{{ route('roles.show', $rol) }}" class="btn btn-outline"><i class="fas fa-arrow-left"></i> Cancelar</a>
        </div>
    </header>

    <form method="POST" action="{{ route('roles.update', $rol) }}">
        @csrf @method('PUT')

        <div class="content">
            <div class="warning-note" style="margin-bottom:20px;">
                <i class="fas fa-exclamation-triangle"></i>
                Los cambios de permisos afectan inmediatamente a todos los usuarios con este rol. Procede con cuidado.
            </div>

            @php $rolPerms = $rol->permissions->pluck('name')->toArray(); @endphp

            <div class="panel">
                <div class="panel-header">
                    <div class="panel-title"><i class="fas fa-key"></i> Permisos del Rol</div>
                    <button type="button" class="select-all-btn" onclick="toggleAll(true)"><i class="fas fa-check-double"></i> Seleccionar todos</button>
                </div>

                @foreach($permisosPorModulo as $modulo => $permisos)
                <div class="module-block">
                    <div class="module-header" onclick="toggleModule('{{ $modulo }}')">
                        <div class="module-title"><i class="fas fa-cube"></i> {{ strtoupper($modulo) }}</div>
                        <button type="button" class="select-all-btn" onclick="event.stopPropagation(); selectModule('{{ $modulo }}')">Seleccionar módulo</button>
                    </div>
                    <div class="module-body" id="module-{{ $modulo }}">
                        @foreach($permisos as $perm)
                        @php $action = explode('.', $perm->name)[1] ?? $perm->name; @endphp
                        <label class="perm-toggle">
                            <input type="checkbox" name="permissions[]" value="{{ $perm->name }}"
                                {{ in_array($perm->name, $rolPerms) ? 'checked' : '' }}
                                data-module="{{ $modulo }}">
                            <div>
                                <div class="perm-label">{{ ucfirst($action) }}</div>
                                <div class="perm-label-sub">{{ $perm->name }}</div>
                            </div>
                        </label>
                        @endforeach
                    </div>
                </div>
                @endforeach
            </div>
        </div>

        <div class="action-bar">
            <div style="font-size:13px;color:#64748b;" id="counter">
                <span id="selected-count">{{ count($rolPerms) }}</span> permisos seleccionados
            </div>
            <div style="display:flex;gap:10px;">
                <a href="{{ route('roles.show', $rol) }}" class="btn btn-outline">Cancelar</a>
                <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Guardar Cambios</button>
            </div>
        </div>
    </form>
</div>

<script>
function updateCounter() {
    document.getElementById('selected-count').textContent =
        document.querySelectorAll('input[name="permissions[]"]:checked').length;
}
document.querySelectorAll('input[name="permissions[]"]').forEach(cb => cb.addEventListener('change', updateCounter));

function toggleAll(val) {
    document.querySelectorAll('input[name="permissions[]"]').forEach(cb => cb.checked = val);
    updateCounter();
}
function selectModule(mod) {
    const cbs = document.querySelectorAll(`input[data-module="${mod}"]`);
    const allChecked = Array.from(cbs).every(cb => cb.checked);
    cbs.forEach(cb => cb.checked = !allChecked);
    updateCounter();
}
function toggleModule(mod) {
    const body = document.getElementById(`module-${mod}`);
    body.style.display = body.style.display === 'none' ? '' : 'none';
}
</script>
</body>
</html>

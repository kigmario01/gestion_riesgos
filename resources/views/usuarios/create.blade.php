<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ isset($usuario) ? 'Editar' : 'Nuevo' }} Usuario — RiskGuard TI</title>
    @vite(['resources/css/app.css'])
    <style>
        *{margin:0;padding:0;box-sizing:border-box}body{font-family:'Inter',-apple-system,BlinkMacSystemFont,'Segoe UI',sans-serif;background:#f0f4f8;color:#1e293b}
        .sidebar{position:fixed;top:0;left:0;width:250px;height:100vh;background:#1e40af;display:flex;flex-direction:column;z-index:100;overflow-y:auto}
        .sidebar-logo{padding:24px 20px;border-bottom:1px solid rgba(255,255,255,0.1)}.sidebar-logo h1{color:#fff;font-size:18px;font-weight:700}.sidebar-logo p{color:rgba(255,255,255,0.6);font-size:11px;margin-top:3px}
        .nav-section-title{padding:16px 20px 6px;font-size:10px;font-weight:600;letter-spacing:1.5px;text-transform:uppercase;color:rgba(255,255,255,0.4)}
        .nav-item{display:flex;align-items:center;gap:10px;padding:10px 20px;color:rgba(255,255,255,0.75);text-decoration:none;font-size:13.5px;transition:all 0.15s;border-left:3px solid transparent}
        .nav-item:hover{background:rgba(255,255,255,0.08);color:#fff}.nav-item.active{background:rgba(255,255,255,0.12);color:#fff;border-left-color:#60a5fa;font-weight:500}
        .nav-item i{width:18px;text-align:center;font-size:14px}
        .sidebar-footer{margin-top:auto;padding:16px 20px;border-top:1px solid rgba(255,255,255,0.1)}
        .user-info{display:flex;align-items:center;gap:10px}.user-avatar{width:36px;height:36px;border-radius:50%;background:#60a5fa;display:flex;align-items:center;justify-content:center;font-weight:700;font-size:14px;color:#1e40af;flex-shrink:0}
        .user-name{font-size:13px;color:#fff;font-weight:500}.user-role{font-size:11px;color:rgba(255,255,255,0.5)}
        .btn-logout{display:flex;align-items:center;gap:6px;margin-top:10px;padding:7px 12px;background:rgba(255,255,255,0.08);color:rgba(255,255,255,0.7);border-radius:8px;font-size:12px;border:none;cursor:pointer;width:100%}
        .main{margin-left:250px;min-height:100vh;display:flex;flex-direction:column}
        .topbar{background:#fff;border-bottom:1px solid #e2e8f0;padding:0 28px;height:58px;display:flex;align-items:center;justify-content:space-between;position:sticky;top:0;z-index:50}
        .topbar-title{font-size:16px;font-weight:600}
        .btn{display:inline-flex;align-items:center;gap:6px;padding:8px 16px;border-radius:8px;font-size:13px;font-weight:500;cursor:pointer;border:none;text-decoration:none;transition:all 0.15s}
        .btn-primary{background:#1e40af;color:#fff}.btn-primary:hover{background:#1d3a9e}
        .btn-outline{background:#fff;color:#475569;border:1px solid #e2e8f0}.btn-outline:hover{border-color:#1e40af;color:#1e40af}
        .content{padding:24px 28px;flex:1}
        .form-card{background:#fff;border-radius:12px;border:1px solid #e2e8f0;overflow:hidden;max-width:700px}
        .form-header{padding:20px 24px;border-bottom:1px solid #f1f5f9}.form-header h2{font-size:15px;font-weight:600;display:flex;align-items:center;gap:8px}.form-header h2 i{color:#1e40af}
        .form-header p{font-size:12px;color:#94a3b8;margin-top:4px}
        .form-body{padding:24px}.form-grid{display:grid;grid-template-columns:1fr 1fr;gap:18px}
        .form-group{display:flex;flex-direction:column;gap:6px}.form-group.full{grid-column:1/-1}
        label{font-size:12.5px;font-weight:500;color:#374151}label span{color:#ef4444}
        input,select{padding:9px 12px;border:1px solid #e2e8f0;border-radius:8px;font-size:13px;color:#1e293b;font-family:inherit;outline:none;transition:border-color 0.2s;background:#fff}
        input:focus,select:focus{border-color:#1e40af;box-shadow:0 0 0 3px rgba(30,64,175,0.08)}
        .error-msg{font-size:11.5px;color:#dc2626}
        .form-footer{padding:16px 24px;border-top:1px solid #f1f5f9;display:flex;justify-content:flex-end;gap:10px;background:#f8fafc}
        .hint{font-size:11px;color:#94a3b8;margin-top:2px}
        .role-info{background:#eff6ff;border:1px solid #bfdbfe;border-radius:8px;padding:12px 16px;margin-top:8px}
        .role-info-title{font-size:12px;font-weight:600;color:#1e40af;margin-bottom:4px}
        .role-info-desc{font-size:11px;color:#3b82f6}
        .roles-desc { display: none; }
        .roles-desc.active { display: block; }
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
        <div class="topbar-title">
            <i class="fas fa-{{ isset($usuario) ? 'edit' : 'user-plus' }}" style="color:#1e40af;margin-right:8px;"></i>
            {{ isset($usuario) ? 'Editar Usuario' : 'Nuevo Usuario' }}
        </div>
        <a href="{{ route('usuarios.index') }}" class="btn btn-outline"><i class="fas fa-arrow-left"></i> Volver</a>
    </header>
    <div class="content">
        <div class="form-card">
            <div class="form-header">
                <h2><i class="fas fa-user"></i> {{ isset($usuario) ? 'Editando: '.$usuario->name : 'Registrar nuevo usuario' }}</h2>
                @if(isset($usuario))<p>Creado el {{ $usuario->created_at->format('d/m/Y') }}</p>@endif
            </div>
            <form method="POST" action="{{ isset($usuario) ? route('usuarios.update', $usuario) : route('usuarios.store') }}">
                @csrf
                @if(isset($usuario)) @method('PUT') @endif
                <div class="form-body">
                    <div class="form-grid">

                        <div class="form-group full">
                            <label>Nombre completo <span>*</span></label>
                            <input type="text" name="name" value="{{ old('name', $usuario->name ?? '') }}" required placeholder="Ej: Juan Pérez">
                            @error('name')<span class="error-msg">{{ $message }}</span>@enderror
                        </div>

                        <div class="form-group full">
                            <label>Correo electrónico <span>*</span></label>
                            <input type="email" name="email" value="{{ old('email', $usuario->email ?? '') }}" required placeholder="usuario@ejemplo.com">
                            @error('email')<span class="error-msg">{{ $message }}</span>@enderror
                        </div>

                        <div class="form-group">
                            <label>Contraseña {{ isset($usuario) ? '' : '*' }}</label>
                            <input type="password" name="password" placeholder="{{ isset($usuario) ? 'Dejar vacío para no cambiar' : 'Mínimo 8 caracteres' }}" {{ isset($usuario) ? '' : 'required' }}>
                            <span class="hint">Mínimo 8 caracteres</span>
                            @error('password')<span class="error-msg">{{ $message }}</span>@enderror
                        </div>

                        <div class="form-group">
                            <label>Confirmar contraseña {{ isset($usuario) ? '' : '*' }}</label>
                            <input type="password" name="password_confirmation" placeholder="Repite la contraseña" {{ isset($usuario) ? '' : 'required' }}>
                        </div>

                        <div class="form-group full">
                            <label>Rol del sistema <span>*</span></label>
                            <select name="role" id="roleSelect" required onchange="mostrarDescRol()">
                                <option value="">Seleccionar rol...</option>
                                @foreach($roles as $role)
                                <option value="{{ $role->name }}" {{ old('role', isset($usuario) ? $usuario->getRoleNames()->first() : '') == $role->name ? 'selected' : '' }}>
                                    {{ str_replace('_', ' ', strtoupper($role->name)) }}
                                </option>
                                @endforeach
                            </select>
                            @error('role')<span class="error-msg">{{ $message }}</span>@enderror

                            <div id="desc-product_owner" class="roles-desc role-info">
                                <div class="role-info-title">Product Owner</div>
                                <div class="role-info-desc">Consulta reportes, valida prioridades y aprueba resultados. Solo lectura en módulos técnicos.</div>
                            </div>
                            <div id="desc-scrum_master" class="roles-desc role-info">
                                <div class="role-info-title">Scrum Master</div>
                                <div class="role-info-desc">Supervisa tareas, controla el cronograma. No modifica datos críticos del sistema.</div>
                            </div>
                            <div id="desc-frontend" class="roles-desc role-info">
                                <div class="role-info-title">Frontend</div>
                                <div class="role-info-desc">Acceso a vistas y reportes visuales. No puede modificar fórmulas ni base de datos.</div>
                            </div>
                            <div id="desc-backend" class="roles-desc role-info">
                                <div class="role-info-title">Backend</div>
                                <div class="role-info-desc">Acceso completo a lógica del sistema, CRUD, cálculo de riesgo y gestión de usuarios.</div>
                            </div>
                            <div id="desc-base_datos" class="roles-desc role-info">
                                <div class="role-info-title">Base de Datos</div>
                                <div class="role-info-desc">Gestiona tablas, relaciones, respaldos y optimización. No modifica la interfaz visual.</div>
                            </div>
                            <div id="desc-auditoria" class="roles-desc role-info">
                                <div class="role-info-title">Auditoría / Calidad</div>
                                <div class="role-info-desc">Verifica trazabilidad, valida evidencias y emite reportes. Principalmente consulta.</div>
                            </div>
                        </div>

                        @if(isset($usuario))
                        <div class="form-group full">
                            <label style="display:flex;align-items:center;gap:8px;cursor:pointer;">
                                <input type="checkbox" name="activo" value="1" {{ old('activo', $usuario->activo) ? 'checked' : '' }} style="width:16px;height:16px;accent-color:#1e40af;">
                                Usuario activo
                            </label>
                            <span class="hint">Desmarcar para desactivar el acceso del usuario al sistema</span>
                        </div>
                        @endif

                    </div>
                </div>
                <div class="form-footer">
                    <a href="{{ route('usuarios.index') }}" class="btn btn-outline">Cancelar</a>
                    <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> {{ isset($usuario) ? 'Guardar cambios' : 'Crear usuario' }}</button>
                </div>
            </form>
        </div>
    </div>
</div>
<script>
function mostrarDescRol() {
    document.querySelectorAll('.roles-desc').forEach(el => el.classList.remove('active'));
    const val = document.getElementById('roleSelect').value;
    if (val) {
        const desc = document.getElementById('desc-' + val);
        if (desc) desc.classList.add('active');
    }
}
window.onload = mostrarDescRol;
</script>
</body>
</html>

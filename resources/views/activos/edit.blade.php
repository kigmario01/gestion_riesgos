<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Activo TI</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css'])
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Inter', sans-serif; background: #f0f4f8; color: #1e293b; }
        .sidebar { position: fixed; top: 0; left: 0; width: 250px; height: 100vh; background: #1e40af; display: flex; flex-direction: column; z-index: 100; overflow-y: auto; }
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
        .btn { display: inline-flex; align-items: center; gap: 6px; padding: 8px 16px; border-radius: 8px; font-size: 13px; font-weight: 500; cursor: pointer; border: none; text-decoration: none; transition: all 0.2s; }
        .btn-primary { background: #1e40af; color: #fff; }
        .btn-primary:hover { background: #1d3a9e; }
        .btn-outline { background: #fff; color: #475569; border: 1px solid #e2e8f0; }
        .btn-outline:hover { border-color: #1e40af; color: #1e40af; }
        .content { padding: 24px 28px; flex: 1; }
        .form-card { background: #fff; border-radius: 12px; border: 1px solid #e2e8f0; overflow: hidden; max-width: 800px; }
        .form-header { padding: 20px 24px; border-bottom: 1px solid #f1f5f9; }
        .form-header h2 { font-size: 15px; font-weight: 600; color: #1e293b; display: flex; align-items: center; gap: 8px; }
        .form-header h2 i { color: #1e40af; }
        .form-header p { font-size: 12px; color: #94a3b8; margin-top: 4px; }
        .form-body { padding: 24px; }
        .form-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 18px; }
        .form-group { display: flex; flex-direction: column; gap: 6px; }
        .form-group.full { grid-column: 1 / -1; }
        label { font-size: 12.5px; font-weight: 500; color: #374151; }
        label span { color: #ef4444; }
        input, select, textarea { padding: 9px 12px; border: 1px solid #e2e8f0; border-radius: 8px; font-size: 13px; color: #1e293b; font-family: 'Inter', sans-serif; outline: none; transition: border-color 0.2s; background: #fff; }
        input:focus, select:focus, textarea:focus { border-color: #1e40af; box-shadow: 0 0 0 3px rgba(30,64,175,0.08); }
        textarea { resize: vertical; min-height: 80px; }
        .error-msg { font-size: 11.5px; color: #dc2626; margin-top: 2px; }
        .form-footer { padding: 16px 24px; border-top: 1px solid #f1f5f9; display: flex; justify-content: flex-end; gap: 10px; background: #f8fafc; }
        .hint { font-size: 11px; color: #94a3b8; margin-top: 2px; }
        .badge-info { background: #eff6ff; color: #1e40af; padding: 4px 10px; border-radius: 6px; font-size: 11px; font-weight: 500; }
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
        <a href="#" class="nav-item"><i class="fas fa-file-alt"></i> Reportes</a>
        <a href="#" class="nav-item"><i class="fas fa-check-circle"></i> Evidencias</a>
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
        <div class="topbar-title"><i class="fas fa-edit" style="color:#1e40af; margin-right:8px;"></i> Editar Activo TI</div>
        <div>
            <a href="{{ route('activos.index') }}" class="btn btn-outline"><i class="fas fa-arrow-left"></i> Volver</a>
        </div>
    </header>

    <div class="content">
        <div class="form-card">
            <div class="form-header">
                <h2><i class="fas fa-server"></i> Editando: {{ $activo->nombre }}</h2>
                <p>Código: <span class="badge-info">{{ $activo->codigo }}</span> · Registrado el {{ $activo->created_at->format('d/m/Y') }}</p>
            </div>

            <form method="POST" action="{{ route('activos.update', $activo) }}">
                @csrf
                @method('PUT')
                <div class="form-body">
                    <div class="form-grid">

                        <div class="form-group">
                            <label>Nombre del activo <span>*</span></label>
                            <input type="text" name="nombre" value="{{ old('nombre', $activo->nombre) }}" required>
                            @error('nombre') <span class="error-msg">{{ $message }}</span> @enderror
                        </div>

                        <div class="form-group">
                            <label>Código <span>*</span></label>
                            <input type="text" name="codigo" value="{{ old('codigo', $activo->codigo) }}" required>
                            @error('codigo') <span class="error-msg">{{ $message }}</span> @enderror
                        </div>

                        <div class="form-group">
                            <label>Tipo de activo <span>*</span></label>
                            <select name="tipo" required>
                                <option value="">Seleccionar tipo...</option>
                                @foreach(['hardware','software','red','datos','servicios','personas','instalaciones'] as $tipo)
                                <option value="{{ $tipo }}" {{ old('tipo', $activo->tipo) == $tipo ? 'selected' : '' }}>
                                    {{ ucfirst($tipo) }}
                                </option>
                                @endforeach
                            </select>
                            @error('tipo') <span class="error-msg">{{ $message }}</span> @enderror
                        </div>

                        <div class="form-group">
                            <label>Criticidad <span>*</span></label>
                            <select name="criticidad" required>
                                @foreach(['baja','media','alta','critica'] as $c)
                                <option value="{{ $c }}" {{ old('criticidad', $activo->criticidad) == $c ? 'selected' : '' }}>
                                    {{ ucfirst($c) }}
                                </option>
                                @endforeach
                            </select>
                            @error('criticidad') <span class="error-msg">{{ $message }}</span> @enderror
                        </div>

                        <div class="form-group">
                            <label>Estado <span>*</span></label>
                            <select name="estado" required>
                                @foreach(['activo','inactivo','en_mantenimiento'] as $e)
                                <option value="{{ $e }}" {{ old('estado', $activo->estado) == $e ? 'selected' : '' }}>
                                    {{ ucfirst(str_replace('_', ' ', $e)) }}
                                </option>
                                @endforeach
                            </select>
                            @error('estado') <span class="error-msg">{{ $message }}</span> @enderror
                        </div>

                        <div class="form-group">
                            <label>Responsable</label>
                            <input type="text" name="responsable" value="{{ old('responsable', $activo->responsable) }}">
                            @error('responsable') <span class="error-msg">{{ $message }}</span> @enderror
                        </div>

                        <div class="form-group">
                            <label>Ubicación</label>
                            <input type="text" name="ubicacion" value="{{ old('ubicacion', $activo->ubicacion) }}">
                            @error('ubicacion') <span class="error-msg">{{ $message }}</span> @enderror
                        </div>

                        <div class="form-group">
                            <label>Valor económico</label>
                            <input type="number" name="valor_economico" value="{{ old('valor_economico', $activo->valor_economico) }}" step="0.01" min="0">
                            @error('valor_economico') <span class="error-msg">{{ $message }}</span> @enderror
                        </div>

                        <div class="form-group full">
                            <label>Descripción</label>
                            <textarea name="descripcion">{{ old('descripcion', $activo->descripcion) }}</textarea>
                            @error('descripcion') <span class="error-msg">{{ $message }}</span> @enderror
                        </div>

                    </div>
                </div>

                <div class="form-footer">
                    <a href="{{ route('activos.index') }}" class="btn btn-outline">Cancelar</a>
                    <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Guardar Cambios</button>
                </div>
            </form>
        </div>
    </div>
</div>

</body>
</html>

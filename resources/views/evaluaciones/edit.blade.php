<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Evaluación</title>
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
        .btn-primary{background:#1e40af;color:#fff}.btn-outline{background:#fff;color:#475569;border:1px solid #e2e8f0}
        .content{padding:24px 28px;flex:1}
        .form-card{background:#fff;border-radius:12px;border:1px solid #e2e8f0;overflow:hidden;max-width:800px}
        .form-header{padding:20px 24px;border-bottom:1px solid #f1f5f9}.form-header h2{font-size:15px;font-weight:600;display:flex;align-items:center;gap:8px}.form-header h2 i{color:#1e40af}
        .form-header p{font-size:12px;color:#94a3b8;margin-top:4px}
        .form-body{padding:24px}.form-grid{display:grid;grid-template-columns:1fr 1fr;gap:18px}
        .form-group{display:flex;flex-direction:column;gap:6px}.form-group.full{grid-column:1/-1}
        label{font-size:12.5px;font-weight:500;color:#374151}label span{color:#ef4444}
        input,select,textarea{padding:9px 12px;border:1px solid #e2e8f0;border-radius:8px;font-size:13px;color:#1e293b;font-family:'Inter',sans-serif;outline:none;transition:border-color 0.2s;background:#fff}
        input:focus,select:focus,textarea:focus{border-color:#1e40af;box-shadow:0 0 0 3px rgba(30,64,175,0.08)}
        textarea{resize:vertical;min-height:80px}
        .error-msg{font-size:11.5px;color:#dc2626}
        .form-footer{padding:16px 24px;border-top:1px solid #f1f5f9;display:flex;justify-content:flex-end;gap:10px;background:#f8fafc}
        .calc-box{background:#f8fafc;border:2px solid #e2e8f0;border-radius:12px;padding:20px;text-align:center;transition:all 0.3s}
        .calc-box.critico{background:#fef2f2;border-color:#fecaca}.calc-box.alto{background:#fff7ed;border-color:#fed7aa}.calc-box.medio{background:#fefce8;border-color:#fef08a}.calc-box.bajo{background:#f0fdf4;border-color:#bbf7d0}
        .calc-valor{font-size:48px;font-weight:800;line-height:1}.calc-nivel{font-size:14px;font-weight:700;letter-spacing:1px;text-transform:uppercase;margin-top:6px}.calc-formula{font-size:12px;color:#94a3b8;margin-top:4px}
        .c-critico{color:#dc2626}.c-alto{color:#ea580c}.c-medio{color:#ca8a04}.c-bajo{color:#16a34a}
        .badge-info{background:#eff6ff;color:#1e40af;padding:3px 10px;border-radius:6px;font-size:11px;font-weight:500}
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
        <a href="{{ route('amenazas.index') }}" class="nav-item"><i class="fas fa-biohazard"></i> Amenazas</a>
        <a href="{{ route('evaluaciones.index') }}" class="nav-item active"><i class="fas fa-search"></i> Evaluaciones</a>
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
        <div class="topbar-title"><i class="fas fa-edit" style="color:#1e40af;margin-right:8px;"></i> Editar Evaluación</div>
        <a href="{{ route('evaluaciones.index') }}" class="btn btn-outline"><i class="fas fa-arrow-left"></i> Volver</a>
    </header>
    <div class="content">
        <div class="form-card">
            <div class="form-header">
                <h2><i class="fas fa-search"></i> Editando: {{ $evaluacion->codigo }}</h2>
                <p>Versión actual: <span class="badge-info">v{{ $evaluacion->version }}</span> · Creada el {{ $evaluacion->created_at->format('d/m/Y') }}</p>
            </div>
            <form method="POST" action="{{ route('evaluaciones.update', $evaluacion) }}">
                @csrf @method('PUT')
                <div class="form-body">
                    <div class="form-grid">
                        <div class="form-group">
                            <label>Activo TI <span>*</span></label>
                            <select name="activo_id" required>
                                <option value="">Seleccionar...</option>
                                @foreach($activos as $activo)
                                <option value="{{ $activo->id }}" {{ old('activo_id', $evaluacion->activo_id) == $activo->id ? 'selected' : '' }}>{{ $activo->codigo }} — {{ $activo->nombre }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Amenaza <span>*</span></label>
                            <select name="amenaza_id" required>
                                <option value="">Seleccionar...</option>
                                @foreach($amenazas as $amenaza)
                                <option value="{{ $amenaza->id }}" {{ old('amenaza_id', $evaluacion->amenaza_id) == $amenaza->id ? 'selected' : '' }}>{{ $amenaza->codigo }} — {{ $amenaza->nombre }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Impacto (1-5) <span>*</span></label>
                            <select name="impacto" id="impacto" required onchange="calcularRiesgo()">
                                @foreach([1=>'Muy Bajo',2=>'Bajo',3=>'Medio',4=>'Alto',5=>'Muy Alto'] as $val=>$lbl)
                                <option value="{{ $val }}" {{ old('impacto', $evaluacion->impacto) == $val ? 'selected' : '' }}>{{ $val }} — {{ $lbl }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Probabilidad (1-5) <span>*</span></label>
                            <select name="probabilidad" id="probabilidad" required onchange="calcularRiesgo()">
                                @foreach([1=>'Muy Baja',2=>'Baja',3=>'Media',4=>'Alta',5=>'Muy Alta'] as $val=>$lbl)
                                <option value="{{ $val }}" {{ old('probabilidad', $evaluacion->probabilidad) == $val ? 'selected' : '' }}>{{ $val }} — {{ $lbl }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group full">
                            <label>Resultado del cálculo</label>
                            <div class="calc-box" id="calcBox">
                                <div class="calc-valor" id="calcValor">{{ $evaluacion->valor_riesgo }}</div>
                                <div class="calc-nivel c-{{ $evaluacion->nivel_riesgo }}" id="calcNivel">Nivel: {{ strtoupper($evaluacion->nivel_riesgo) }}</div>
                                <div class="calc-formula" id="calcFormula">{{ $evaluacion->impacto }} × {{ $evaluacion->probabilidad }} = {{ $evaluacion->valor_riesgo }}</div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Estado</label>
                            <select name="estado">
                                @foreach(['borrador','activa','cerrada','reevaluacion'] as $e)
                                <option value="{{ $e }}" {{ old('estado', $evaluacion->estado) == $e ? 'selected' : '' }}>{{ ucfirst($e) }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Fecha evaluación <span>*</span></label>
                            <input type="date" name="fecha_evaluacion" value="{{ old('fecha_evaluacion', $evaluacion->fecha_evaluacion->format('Y-m-d')) }}" required>
                        </div>
                        <div class="form-group">
                            <label>Próxima revisión</label>
                            <input type="date" name="proxima_revision" value="{{ old('proxima_revision', $evaluacion->proxima_revision?->format('Y-m-d')) }}">
                        </div>
                        <div class="form-group full">
                            <label>Vulnerabilidades</label>
                            <textarea name="vulnerabilidades">{{ old('vulnerabilidades', $evaluacion->vulnerabilidades) }}</textarea>
                        </div>
                        <div class="form-group full">
                            <label>Controles existentes</label>
                            <textarea name="controles_existentes">{{ old('controles_existentes', $evaluacion->controles_existentes) }}</textarea>
                        </div>
                        <div class="form-group full">
                            <label>Observaciones</label>
                            <textarea name="observaciones">{{ old('observaciones', $evaluacion->observaciones) }}</textarea>
                        </div>
                    </div>
                </div>
                <div class="form-footer">
                    <a href="{{ route('evaluaciones.index') }}" class="btn btn-outline">Cancelar</a>
                    <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Guardar Cambios</button>
                </div>
            </form>
        </div>
    </div>
</div>
<script>
function calcularRiesgo() {
    const i = parseInt(document.getElementById('impacto').value)||0;
    const p = parseInt(document.getElementById('probabilidad').value)||0;
    const box = document.getElementById('calcBox');
    const valEl = document.getElementById('calcValor');
    const nivEl = document.getElementById('calcNivel');
    const frmEl = document.getElementById('calcFormula');
    if(!i||!p){return;}
    const v = i*p;
    let nivel,clase,color;
    if(v>=16){nivel='CRÍTICO';clase='critico';color='c-critico';}
    else if(v>=10){nivel='ALTO';clase='alto';color='c-alto';}
    else if(v>=5){nivel='MEDIO';clase='medio';color='c-medio';}
    else{nivel='BAJO';clase='bajo';color='c-bajo';}
    valEl.textContent=v;valEl.className='calc-valor '+color;
    nivEl.textContent='Nivel: '+nivel;nivEl.className='calc-nivel '+color;
    frmEl.textContent=i+' × '+p+' = '+v;
    box.className='calc-box '+clase;
}
window.onload=calcularRiesgo;
</script>
</body>
</html>

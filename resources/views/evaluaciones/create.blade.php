@extends('layouts.main')

@section('title', 'Nueva Evaluación de Riesgo')

@section('topbar-left')
    <div class="topbar-icon"><i class="fas fa-calculator"></i></div>
    <div class="topbar-title">Cálculo de Riesgo</div>
@endsection

@section('topbar-right')
    <a href="{{ route('evaluaciones.index') }}" class="btn btn-outline btn-sm"><i class="fas fa-arrow-left"></i> Volver</a>
@endsection

@push('styles')
<style>
.calc-box{background:#f8fafc;border:2px solid #e2e8f0;border-radius:12px;padding:20px;text-align:center;transition:all 0.3s;}
.calc-box.critico{background:#fef2f2;border-color:#fecaca;}.calc-box.alto{background:#fff7ed;border-color:#fed7aa;}.calc-box.medio{background:#fefce8;border-color:#fef08a;}.calc-box.bajo{background:#f0fdf4;border-color:#bbf7d0;}
.calc-valor{font-size:48px;font-weight:800;line-height:1;}
.calc-nivel{font-size:14px;font-weight:700;letter-spacing:1px;text-transform:uppercase;margin-top:6px;}
.calc-formula{font-size:12px;color:#94a3b8;margin-top:4px;}
.c-critico{color:#dc2626;}.c-alto{color:#ea580c;}.c-medio{color:#ca8a04;}.c-bajo{color:#16a34a;}
</style>
@endpush

@push('styles')
<style>
.guia-iso{background:#fff7ed;border:1px solid #fed7aa;border-radius:12px;margin-bottom:20px;overflow:hidden;}
.guia-iso-header{padding:13px 18px;display:flex;align-items:center;gap:10px;cursor:pointer;user-select:none;}
.guia-iso-header:hover{background:rgba(255,255,255,0.4);}
.guia-iso-icon{width:34px;height:34px;border-radius:9px;background:#ffedd5;display:flex;align-items:center;justify-content:center;flex-shrink:0;}
.guia-iso-title{font-size:13px;font-weight:700;color:#c2410c;flex:1;}
.guia-iso-ref{font-size:10px;font-weight:600;background:#ffedd5;color:#ea580c;padding:2px 9px;border-radius:20px;}
.guia-iso-body{padding:4px 18px 16px 18px;border-top:1px solid #fed7aa;}
.guia-paso{display:flex;align-items:flex-start;gap:9px;margin-bottom:8px;font-size:12.5px;color:#374151;line-height:1.5;}
.guia-num{min-width:22px;height:22px;border-radius:50%;background:#ffedd5;color:#ea580c;font-size:10px;font-weight:700;display:flex;align-items:center;justify-content:center;flex-shrink:0;margin-top:1px;}
.guia-nota{margin-top:10px;padding:9px 13px;background:rgba(255,255,255,0.65);border-radius:8px;font-size:11.5px;color:#475569;display:flex;gap:8px;}
</style>
@endpush

@section('content')

<div class="guia-iso">
    <div class="guia-iso-header" onclick="this.nextElementSibling.style.display=this.nextElementSibling.style.display==='none'?'':'none'">
        <div class="guia-iso-icon"><i class="fas fa-question-circle" style="color:#ea580c;font-size:14px;"></i></div>
        <div class="guia-iso-title">Cómo completar correctamente el cálculo de riesgo</div>
        <span class="guia-iso-ref">ISO 27001 — Evaluación de Riesgo</span>
        <i class="fas fa-chevron-up" style="color:#ea580c;font-size:11px;"></i>
    </div>
    <div class="guia-iso-body" style="display:none">
        <div class="guia-paso"><div class="guia-num">1</div><div><strong>Activo TI:</strong> Selecciona el activo que estás evaluando. Si no aparece en la lista, primero regístralo en el módulo de Activos TI.</div></div>
        <div class="guia-paso"><div class="guia-num">2</div><div><strong>Amenaza:</strong> Selecciona la amenaza específica que podría afectar a ese activo. Puedes crear múltiples evaluaciones del mismo activo con diferentes amenazas.</div></div>
        <div class="guia-paso"><div class="guia-num">3</div><div><strong>Impacto:</strong> ¿Qué consecuencias tendría si la amenaza se materializa sobre este activo? Considera pérdida económica, reputacional y operacional. <em>1 = insignificante, 5 = catastrófico</em>.</div></div>
        <div class="guia-paso"><div class="guia-num">4</div><div><strong>Probabilidad:</strong> ¿Qué tan probable es que ocurra? Considera el historial, el entorno y las vulnerabilidades conocidas. <em>1 = muy improbable, 5 = muy probable o ya ocurrió</em>.</div></div>
        <div class="guia-paso"><div class="guia-num">5</div><div><strong>Vulnerabilidades:</strong> Documenta las debilidades específicas que hacen posible que la amenaza explote el activo (ej. "contraseñas débiles", "sin cifrado en reposo").</div></div>
        <div class="guia-paso"><div class="guia-num">6</div><div><strong>Controles existentes:</strong> Lista los controles que ya tienes implementados. Esto demuestra madurez del SGSI y puede justificar una probabilidad menor.</div></div>
        <div class="guia-nota">
            <i class="fas fa-lightbulb" style="color:#f59e0b;flex-shrink:0;margin-top:1px;"></i>
            <span>El sistema calcula automáticamente el valor (Impacto × Probabilidad) y el nivel de riesgo en tiempo real. Riesgos <strong>Alto o Crítico</strong> deben tener un Plan de Mitigación creado inmediatamente después.</span>
        </div>
    </div>
</div>

<div class="form-card">
    <div class="form-header">
        <h2><i class="fas fa-search-plus"></i> Calcular nivel de riesgo — ISO 27001</h2>
    </div>
    <form method="POST" action="{{ route('evaluaciones.store') }}">
        @csrf
        <div class="form-body">
            <div class="form-grid">

                <div class="form-group">
                    <label>Activo TI <span class="req">*</span></label>
                    <select name="activo_id" required>
                        <option value="">Seleccionar activo...</option>
                        @foreach($activos as $activo)
                        <option value="{{ $activo->id }}" {{ old('activo_id', request('activo_id')) == $activo->id ? 'selected' : '' }}>
                            {{ $activo->codigo }} — {{ $activo->nombre }}
                        </option>
                        @endforeach
                    </select>
                    @error('activo_id')<span class="error-msg">{{ $message }}</span>@enderror
                </div>

                <div class="form-group">
                    <label>Amenaza <span class="req">*</span></label>
                    <select name="amenaza_id" required>
                        <option value="">Seleccionar amenaza...</option>
                        @foreach($amenazas as $amenaza)
                        <option value="{{ $amenaza->id }}" {{ old('amenaza_id') == $amenaza->id ? 'selected' : '' }}>
                            {{ $amenaza->codigo }} — {{ $amenaza->nombre }}
                        </option>
                        @endforeach
                    </select>
                    @error('amenaza_id')<span class="error-msg">{{ $message }}</span>@enderror
                </div>

                <div class="form-group">
                    <label>Impacto (1–5) <span class="req">*</span></label>
                    <select name="impacto" id="impacto" required onchange="calcularRiesgo()">
                        <option value="">Seleccionar...</option>
                        <option value="1" {{ old('impacto') == 1 ? 'selected' : '' }}>1 — Muy Bajo</option>
                        <option value="2" {{ old('impacto') == 2 ? 'selected' : '' }}>2 — Bajo</option>
                        <option value="3" {{ old('impacto') == 3 ? 'selected' : '' }}>3 — Medio</option>
                        <option value="4" {{ old('impacto') == 4 ? 'selected' : '' }}>4 — Alto</option>
                        <option value="5" {{ old('impacto') == 5 ? 'selected' : '' }}>5 — Muy Alto</option>
                    </select>
                    @error('impacto')<span class="error-msg">{{ $message }}</span>@enderror
                </div>

                <div class="form-group">
                    <label>Probabilidad (1–5) <span class="req">*</span></label>
                    <select name="probabilidad" id="probabilidad" required onchange="calcularRiesgo()">
                        <option value="">Seleccionar...</option>
                        <option value="1" {{ old('probabilidad') == 1 ? 'selected' : '' }}>1 — Muy Baja</option>
                        <option value="2" {{ old('probabilidad') == 2 ? 'selected' : '' }}>2 — Baja</option>
                        <option value="3" {{ old('probabilidad') == 3 ? 'selected' : '' }}>3 — Media</option>
                        <option value="4" {{ old('probabilidad') == 4 ? 'selected' : '' }}>4 — Alta</option>
                        <option value="5" {{ old('probabilidad') == 5 ? 'selected' : '' }}>5 — Muy Alta</option>
                    </select>
                    @error('probabilidad')<span class="error-msg">{{ $message }}</span>@enderror
                </div>

                <div class="form-group full">
                    <label>Resultado del cálculo (automático)</label>
                    <div class="calc-box" id="calcBox">
                        <div class="calc-valor" id="calcValor">—</div>
                        <div class="calc-nivel" id="calcNivel">Selecciona impacto y probabilidad</div>
                        <div class="calc-formula" id="calcFormula">Fórmula: Impacto × Probabilidad</div>
                    </div>
                </div>

                <div class="form-group">
                    <label>Fecha de evaluación <span class="req">*</span></label>
                    <input type="date" name="fecha_evaluacion" value="{{ old('fecha_evaluacion', date('Y-m-d')) }}" required>
                    @error('fecha_evaluacion')<span class="error-msg">{{ $message }}</span>@enderror
                </div>

                <div class="form-group">
                    <label>Próxima revisión</label>
                    <input type="date" name="proxima_revision" value="{{ old('proxima_revision') }}">
                </div>

                <div class="form-group full">
                    <label>Vulnerabilidades identificadas</label>
                    <textarea name="vulnerabilidades" placeholder="Describe las vulnerabilidades encontradas...">{{ old('vulnerabilidades') }}</textarea>
                </div>

                <div class="form-group full">
                    <label>Controles existentes</label>
                    <textarea name="controles_existentes" placeholder="Controles de seguridad ya implementados...">{{ old('controles_existentes') }}</textarea>
                </div>

                <div class="form-group full">
                    <label>Observaciones</label>
                    <textarea name="observaciones" placeholder="Observaciones adicionales...">{{ old('observaciones') }}</textarea>
                </div>

            </div>
        </div>
        <div class="form-footer">
            <a href="{{ route('evaluaciones.index') }}" class="btn btn-outline">Cancelar</a>
            <button type="submit" class="btn btn-primary"><i class="fas fa-calculator"></i> Calcular y Guardar</button>
        </div>
    </form>
</div>
@endsection

@push('scripts')
<script>
function calcularRiesgo() {
    const impacto = parseInt(document.getElementById('impacto').value) || 0;
    const prob    = parseInt(document.getElementById('probabilidad').value) || 0;
    const box     = document.getElementById('calcBox');
    const valEl   = document.getElementById('calcValor');
    const nivEl   = document.getElementById('calcNivel');
    const frmEl   = document.getElementById('calcFormula');

    if (!impacto || !prob) {
        valEl.textContent = '—';
        valEl.className   = 'calc-valor';
        nivEl.textContent = 'Selecciona impacto y probabilidad';
        nivEl.className   = 'calc-nivel';
        box.className = 'calc-box';
        return;
    }

    const valor = impacto * prob;
    let nivel, clase, color;
    if (valor >= 16)      { nivel = 'CRÍTICO';  clase = 'critico'; color = 'c-critico'; }
    else if (valor >= 10) { nivel = 'ALTO';     clase = 'alto';    color = 'c-alto';    }
    else if (valor >= 5)  { nivel = 'MEDIO';    clase = 'medio';   color = 'c-medio';   }
    else                  { nivel = 'BAJO';     clase = 'bajo';    color = 'c-bajo';    }

    valEl.textContent = valor;
    valEl.className   = 'calc-valor ' + color;
    nivEl.textContent = '⚠ Nivel: ' + nivel;
    nivEl.className   = 'calc-nivel ' + color;
    frmEl.textContent = `${impacto} (impacto) × ${prob} (probabilidad) = ${valor}`;
    box.className = 'calc-box ' + clase;
}
</script>
@endpush

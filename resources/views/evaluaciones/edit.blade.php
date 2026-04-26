@extends('layouts.main')

@section('title', 'Editar Evaluación')

@section('topbar-left')
    <div class="topbar-icon"><i class="fas fa-edit"></i></div>
    <div class="topbar-title">Editar Evaluación</div>
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
.badge-info{background:#eff6ff;color:#1d4ed8;padding:3px 10px;border-radius:6px;font-size:11px;font-weight:500;}
</style>
@endpush

@section('content')
<div class="form-card">
    <div class="form-header">
        <h2><i class="fas fa-search-plus"></i> Editando: {{ $evaluacion->codigo }}</h2>
        <p>Versión actual: <span class="badge-info">v{{ $evaluacion->version }}</span> · Creada el {{ $evaluacion->created_at->format('d/m/Y') }}</p>
    </div>
    <form method="POST" action="{{ route('evaluaciones.update', $evaluacion) }}">
        @csrf @method('PUT')
        <div class="form-body">
            <div class="form-grid">

                <div class="form-group">
                    <label>Activo TI <span class="req">*</span></label>
                    <select name="activo_id" required>
                        <option value="">Seleccionar...</option>
                        @foreach($activos as $activo)
                        <option value="{{ $activo->id }}" {{ old('activo_id', $evaluacion->activo_id) == $activo->id ? 'selected' : '' }}>
                            {{ $activo->codigo }} — {{ $activo->nombre }}
                        </option>
                        @endforeach
                    </select>
                    @error('activo_id')<span class="error-msg">{{ $message }}</span>@enderror
                </div>

                <div class="form-group">
                    <label>Amenaza <span class="req">*</span></label>
                    <select name="amenaza_id" required>
                        <option value="">Seleccionar...</option>
                        @foreach($amenazas as $amenaza)
                        <option value="{{ $amenaza->id }}" {{ old('amenaza_id', $evaluacion->amenaza_id) == $amenaza->id ? 'selected' : '' }}>
                            {{ $amenaza->codigo }} — {{ $amenaza->nombre }}
                        </option>
                        @endforeach
                    </select>
                    @error('amenaza_id')<span class="error-msg">{{ $message }}</span>@enderror
                </div>

                <div class="form-group">
                    <label>Impacto (1–5) <span class="req">*</span></label>
                    <select name="impacto" id="impacto" required onchange="calcularRiesgo()">
                        @foreach([1=>'Muy Bajo',2=>'Bajo',3=>'Medio',4=>'Alto',5=>'Muy Alto'] as $val=>$lbl)
                        <option value="{{ $val }}" {{ old('impacto', $evaluacion->impacto) == $val ? 'selected' : '' }}>{{ $val }} — {{ $lbl }}</option>
                        @endforeach
                    </select>
                    @error('impacto')<span class="error-msg">{{ $message }}</span>@enderror
                </div>

                <div class="form-group">
                    <label>Probabilidad (1–5) <span class="req">*</span></label>
                    <select name="probabilidad" id="probabilidad" required onchange="calcularRiesgo()">
                        @foreach([1=>'Muy Baja',2=>'Baja',3=>'Media',4=>'Alta',5=>'Muy Alta'] as $val=>$lbl)
                        <option value="{{ $val }}" {{ old('probabilidad', $evaluacion->probabilidad) == $val ? 'selected' : '' }}>{{ $val }} — {{ $lbl }}</option>
                        @endforeach
                    </select>
                    @error('probabilidad')<span class="error-msg">{{ $message }}</span>@enderror
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
                    <label>Fecha evaluación <span class="req">*</span></label>
                    <input type="date" name="fecha_evaluacion" value="{{ old('fecha_evaluacion', $evaluacion->fecha_evaluacion->format('Y-m-d')) }}" required>
                    @error('fecha_evaluacion')<span class="error-msg">{{ $message }}</span>@enderror
                </div>

                <div class="form-group">
                    <label>Próxima revisión</label>
                    <input type="date" name="proxima_revision" value="{{ old('proxima_revision', $evaluacion->proxima_revision?->format('Y-m-d')) }}">
                </div>

                <div class="form-group full">
                    <label>Vulnerabilidades identificadas</label>
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
@endsection

@push('scripts')
<script>
function calcularRiesgo() {
    const i = parseInt(document.getElementById('impacto').value) || 0;
    const p = parseInt(document.getElementById('probabilidad').value) || 0;
    const box = document.getElementById('calcBox');
    const valEl = document.getElementById('calcValor');
    const nivEl = document.getElementById('calcNivel');
    const frmEl = document.getElementById('calcFormula');
    if (!i || !p) return;
    const v = i * p;
    let nivel, clase, color;
    if (v >= 16)      { nivel = 'CRÍTICO';  clase = 'critico'; color = 'c-critico'; }
    else if (v >= 10) { nivel = 'ALTO';     clase = 'alto';    color = 'c-alto';    }
    else if (v >= 5)  { nivel = 'MEDIO';    clase = 'medio';   color = 'c-medio';   }
    else              { nivel = 'BAJO';     clase = 'bajo';    color = 'c-bajo';    }
    valEl.textContent = v;
    valEl.className   = 'calc-valor ' + color;
    nivEl.textContent = 'Nivel: ' + nivel;
    nivEl.className   = 'calc-nivel ' + color;
    frmEl.textContent = i + ' × ' + p + ' = ' + v;
    box.className = 'calc-box ' + clase;
}
window.addEventListener('DOMContentLoaded', calcularRiesgo);
</script>
@endpush

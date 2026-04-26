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

@section('content')
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

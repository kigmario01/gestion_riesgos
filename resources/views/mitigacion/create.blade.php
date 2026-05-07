@extends('layouts.main')

@section('title', isset($mitigacion) ? 'Editar Plan' : 'Nuevo Plan de Mitigación')

@section('topbar-left')
    <div class="topbar-icon"><i class="fas fa-shield-virus"></i></div>
    <div class="topbar-title">{{ isset($mitigacion) ? 'Editar Plan' : 'Nuevo Plan de Mitigación' }}</div>
@endsection

@section('topbar-right')
    <a href="{{ route('mitigacion.index') }}" class="btn btn-outline btn-sm"><i class="fas fa-arrow-left"></i> Volver</a>
@endsection

@push('styles')
<style>
.guia-iso{background:#f0fdf4;border:1px solid #bbf7d0;border-radius:12px;margin-bottom:20px;overflow:hidden;}
.guia-iso-header{padding:13px 18px;display:flex;align-items:center;gap:10px;cursor:pointer;user-select:none;}
.guia-iso-header:hover{background:rgba(255,255,255,0.4);}
.guia-iso-icon{width:34px;height:34px;border-radius:9px;background:#dcfce7;display:flex;align-items:center;justify-content:center;flex-shrink:0;}
.guia-iso-title{font-size:13px;font-weight:700;color:#15803d;flex:1;}
.guia-iso-ref{font-size:10px;font-weight:600;background:#dcfce7;color:#16a34a;padding:2px 9px;border-radius:20px;}
.guia-iso-body{padding:4px 18px 16px 18px;border-top:1px solid #bbf7d0;}
.guia-paso{display:flex;align-items:flex-start;gap:9px;margin-bottom:8px;font-size:12.5px;color:#374151;line-height:1.5;}
.guia-num{min-width:22px;height:22px;border-radius:50%;background:#dcfce7;color:#16a34a;font-size:10px;font-weight:700;display:flex;align-items:center;justify-content:center;flex-shrink:0;margin-top:1px;}
.guia-nota{margin-top:10px;padding:9px 13px;background:rgba(255,255,255,0.65);border-radius:8px;font-size:11.5px;color:#475569;display:flex;gap:8px;}
</style>
@endpush

@section('content')

<div class="guia-iso">
    <div class="guia-iso-header" onclick="this.nextElementSibling.style.display=this.nextElementSibling.style.display==='none'?'':'none'">
        <div class="guia-iso-icon"><i class="fas fa-question-circle" style="color:#16a34a;font-size:14px;"></i></div>
        <div class="guia-iso-title">Cómo crear un Plan de Mitigación efectivo</div>
        <span class="guia-iso-ref">ISO 27001 — Plan de Tratamiento</span>
        <i class="fas fa-chevron-up" style="color:#16a34a;font-size:11px;"></i>
    </div>
    <div class="guia-iso-body" style="display:none">
        <div class="guia-paso"><div class="guia-num">1</div><div><strong>Evaluación asociada:</strong> Selecciona la evaluación de riesgo que origina este plan. Un plan sin evaluación asociada no cumple el ciclo ISO — la trazabilidad es obligatoria.</div></div>
        <div class="guia-paso"><div class="guia-num">2</div><div><strong>Tipo de control:</strong> <em>Preventivo</em> = evita que el riesgo ocurra; <em>Detectivo</em> = detecta cuando ya ocurrió; <em>Correctivo</em> = repara el daño; <em>Disuasivo</em> = desalienta al atacante.</div></div>
        <div class="guia-paso"><div class="guia-num">3</div><div><strong>Estrategia:</strong> <em>Reducir</em> = implementar controles; <em>Transferir</em> = seguro o contrato; <em>Evitar</em> = eliminar la actividad; <em>Aceptar</em> = decisión documentada de no actuar.</div></div>
        <div class="guia-paso"><div class="guia-num">4</div><div><strong>Responsable:</strong> Debe ser una persona específica con nombre y apellido, no un departamento. Esta persona responde ante auditorías por la ejecución del plan.</div></div>
        <div class="guia-paso"><div class="guia-num">5</div><div><strong>Acciones requeridas:</strong> Lista concreta de lo que hay que hacer — cuanto más detallada, mejor. Esto se convierte en evidencia auditable de la implementación del control.</div></div>
        <div class="guia-paso"><div class="guia-num">6</div><div><strong>Fechas:</strong> La fecha límite debe ser realista. ISO 27001 no exige que sea inmediata, pero sí que se cumpla. Los planes vencidos sin actualizar son hallazgos de auditoría.</div></div>
        <div class="guia-nota">
            <i class="fas fa-lightbulb" style="color:#f59e0b;flex-shrink:0;margin-top:1px;"></i>
            <span>Un auditor ISO buscará que cada riesgo Alto/Crítico tenga un plan con responsable definido, fechas comprometidas y evidencia de seguimiento. La prioridad <strong>Urgente</strong> indica que debe iniciarse de inmediato.</span>
        </div>
    </div>
</div>

<div class="form-card" style="max-width:860px;">
    <div class="form-header">
        <h2><i class="fas fa-shield-virus"></i> {{ isset($mitigacion) ? 'Editando: '.$mitigacion->codigo : 'Registrar plan de mitigación' }}</h2>
    </div>
    <form method="POST" action="{{ isset($mitigacion) ? route('mitigacion.update', $mitigacion) : route('mitigacion.store') }}">
        @csrf
        @if(isset($mitigacion)) @method('PUT') @endif
        <div class="form-body">
            <div class="form-grid">

                <div class="form-group full">
                    <label>Evaluación de riesgo asociada <span class="req">*</span></label>
                    <select name="evaluacion_id" required>
                        <option value="">Seleccionar evaluación...</option>
                        @foreach($evaluaciones as $ev)
                        <option value="{{ $ev->id }}" {{ old('evaluacion_id', $mitigacion->evaluacion_id ?? request('evaluacion_id')) == $ev->id ? 'selected' : '' }}>
                            {{ $ev->codigo }} — {{ $ev->activo->nombre ?? '' }} / {{ $ev->amenaza->nombre ?? '' }} ({{ strtoupper($ev->nivel_riesgo) }})
                        </option>
                        @endforeach
                    </select>
                    @error('evaluacion_id')<span class="error-msg">{{ $message }}</span>@enderror
                </div>

                <div class="form-group full">
                    <label>Título del plan <span class="req">*</span></label>
                    <input type="text" name="titulo" value="{{ old('titulo', $mitigacion->titulo ?? '') }}" required placeholder="Ej: Implementar firewall perimetral">
                    @error('titulo')<span class="error-msg">{{ $message }}</span>@enderror
                </div>

                <div class="form-group">
                    <label>Tipo de control <span class="req">*</span></label>
                    <select name="tipo_control" required>
                        @foreach(['preventivo'=>'Preventivo','detectivo'=>'Detectivo','correctivo'=>'Correctivo','disuasivo'=>'Disuasivo'] as $val=>$lbl)
                        <option value="{{ $val }}" {{ old('tipo_control', $mitigacion->tipo_control ?? '') == $val ? 'selected' : '' }}>{{ $lbl }}</option>
                        @endforeach
                    </select>
                    @error('tipo_control')<span class="error-msg">{{ $message }}</span>@enderror
                </div>

                <div class="form-group">
                    <label>Estrategia <span class="req">*</span></label>
                    <select name="estrategia" required>
                        @foreach(['reducir'=>'Reducir','transferir'=>'Transferir','aceptar'=>'Aceptar','evitar'=>'Evitar'] as $val=>$lbl)
                        <option value="{{ $val }}" {{ old('estrategia', $mitigacion->estrategia ?? '') == $val ? 'selected' : '' }}>{{ $lbl }}</option>
                        @endforeach
                    </select>
                    @error('estrategia')<span class="error-msg">{{ $message }}</span>@enderror
                </div>

                <div class="form-group">
                    <label>Prioridad <span class="req">*</span></label>
                    <select name="prioridad" required>
                        @foreach(['baja'=>'Baja','media'=>'Media','alta'=>'Alta','urgente'=>'Urgente'] as $val=>$lbl)
                        <option value="{{ $val }}" {{ old('prioridad', $mitigacion->prioridad ?? 'media') == $val ? 'selected' : '' }}>{{ $lbl }}</option>
                        @endforeach
                    </select>
                    @error('prioridad')<span class="error-msg">{{ $message }}</span>@enderror
                </div>

                <div class="form-group">
                    <label>Responsable <span class="req">*</span></label>
                    <input type="text" name="responsable" value="{{ old('responsable', $mitigacion->responsable ?? '') }}" required placeholder="Nombre del responsable">
                    @error('responsable')<span class="error-msg">{{ $message }}</span>@enderror
                </div>

                <div class="form-group">
                    <label>Fecha inicio <span class="req">*</span></label>
                    <input type="date" name="fecha_inicio" value="{{ old('fecha_inicio', isset($mitigacion) ? $mitigacion->fecha_inicio->format('Y-m-d') : date('Y-m-d')) }}" required>
                    @error('fecha_inicio')<span class="error-msg">{{ $message }}</span>@enderror
                </div>

                <div class="form-group">
                    <label>Fecha límite <span class="req">*</span></label>
                    <input type="date" name="fecha_limite" value="{{ old('fecha_limite', isset($mitigacion) ? $mitigacion->fecha_limite->format('Y-m-d') : '') }}" required>
                    @error('fecha_limite')<span class="error-msg">{{ $message }}</span>@enderror
                </div>

                @if(isset($mitigacion))
                <div class="form-group">
                    <label>Estado</label>
                    <select name="estado">
                        @foreach(['pendiente','en_progreso','completado','cancelado','vencido'] as $e)
                        <option value="{{ $e }}" {{ old('estado', $mitigacion->estado) == $e ? 'selected' : '' }}>{{ ucfirst(str_replace('_',' ',$e)) }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label>Porcentaje de avance</label>
                    <input type="number" name="porcentaje_avance" value="{{ old('porcentaje_avance', $mitigacion->porcentaje_avance) }}" min="0" max="100">
                    <span class="hint">Valor entre 0 y 100</span>
                </div>
                @endif

                <div class="form-group full">
                    <label>Descripción <span class="req">*</span></label>
                    <textarea name="descripcion" required placeholder="Describe el plan de mitigación...">{{ old('descripcion', $mitigacion->descripcion ?? '') }}</textarea>
                    @error('descripcion')<span class="error-msg">{{ $message }}</span>@enderror
                </div>

                <div class="form-group full">
                    <label>Acciones requeridas <span class="req">*</span></label>
                    <textarea name="acciones_requeridas" required placeholder="Lista las acciones necesarias para implementar este plan...">{{ old('acciones_requeridas', $mitigacion->acciones_requeridas ?? '') }}</textarea>
                    @error('acciones_requeridas')<span class="error-msg">{{ $message }}</span>@enderror
                </div>

                @if(isset($mitigacion))
                <div class="form-group full">
                    <label>Evidencias</label>
                    <textarea name="evidencias" placeholder="Describe las evidencias de implementación...">{{ old('evidencias', $mitigacion->evidencias ?? '') }}</textarea>
                </div>
                @endif

            </div>
        </div>
        <div class="form-footer">
            <a href="{{ route('mitigacion.index') }}" class="btn btn-outline">Cancelar</a>
            <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Guardar Plan</button>
        </div>
    </form>
</div>
@endsection

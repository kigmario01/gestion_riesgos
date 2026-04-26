@extends('layouts.main')

@section('title', isset($mitigacion) ? 'Editar Plan' : 'Nuevo Plan de Mitigación')

@section('topbar-left')
    <div class="topbar-icon"><i class="fas fa-shield-virus"></i></div>
    <div class="topbar-title">{{ isset($mitigacion) ? 'Editar Plan' : 'Nuevo Plan de Mitigación' }}</div>
@endsection

@section('topbar-right')
    <a href="{{ route('mitigacion.index') }}" class="btn btn-outline btn-sm"><i class="fas fa-arrow-left"></i> Volver</a>
@endsection

@section('content')
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

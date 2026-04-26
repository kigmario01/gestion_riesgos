@extends('layouts.main')

@section('title', ($mitigacion->codigo ?? 'Plan') . ' — Mitigación')

@section('topbar-left')
    <div class="topbar-icon"><i class="fas fa-shield-virus"></i></div>
    <div class="topbar-title">Detalle del Plan de Mitigación</div>
@endsection

@section('topbar-right')
    <a href="{{ route('mitigacion.edit', $mitigacion) }}" class="btn btn-outline btn-sm"><i class="fas fa-edit"></i> Editar</a>
    <a href="{{ route('mitigacion.index') }}" class="btn btn-outline btn-sm"><i class="fas fa-arrow-left"></i> Volver</a>
@endsection

@push('styles')
<style>
.plan-header{display:flex;align-items:flex-start;gap:18px;padding:20px;}
.plan-icon{width:52px;height:52px;border-radius:12px;background:#eff6ff;display:flex;align-items:center;justify-content:center;color:#3b82f6;font-size:20px;flex-shrink:0;}
.c-critico{color:#dc2626;}.c-alto{color:#ea580c;}.c-medio{color:#ca8a04;}.c-bajo{color:#16a34a;}
</style>
@endpush

@section('content')

<div class="panel">
    <div class="plan-header">
        <div class="plan-icon"><i class="fas fa-shield-virus"></i></div>
        <div style="flex:1;min-width:0;">
            <div style="font-size:18px;font-weight:700;color:#1e293b;">{{ $mitigacion->titulo }}</div>
            <div style="font-size:12px;color:#94a3b8;margin-top:4px;">
                <code class="tag">{{ $mitigacion->codigo }}</code>
                &nbsp;·&nbsp; {{ ucfirst($mitigacion->tipo_control) }} &nbsp;·&nbsp; Estrategia: {{ ucfirst($mitigacion->estrategia) }}
            </div>
        </div>
        <div style="display:flex;flex-direction:column;align-items:flex-end;gap:6px;flex-shrink:0;">
            <span class="badge badge-{{ $mitigacion->prioridad }}" style="font-size:12px;padding:4px 12px;">{{ strtoupper($mitigacion->prioridad) }}</span>
            <span class="badge badge-{{ $mitigacion->estado }}">{{ strtoupper(str_replace('_',' ',$mitigacion->estado)) }}</span>
        </div>
    </div>

    <div class="panel-header" style="border-top:1px solid #f1f5f9;">
        <div class="panel-title"><i class="fas fa-info-circle"></i> Información del Plan</div>
    </div>

    <div class="detail-grid">
        <div class="detail-item">
            <div class="detail-label">Evaluación de Riesgo</div>
            <div class="detail-value">
                <a href="{{ route('evaluaciones.show', $mitigacion->evaluacion) }}" style="color:#3b82f6;text-decoration:none;font-weight:600;">
                    {{ $mitigacion->evaluacion->codigo ?? '—' }}
                </a>
                @if($mitigacion->evaluacion)
                <div style="font-size:11px;color:#94a3b8;margin-top:2px;">
                    {{ $mitigacion->evaluacion->activo->nombre ?? '' }} / {{ $mitigacion->evaluacion->amenaza->nombre ?? '' }}
                </div>
                @endif
            </div>
        </div>
        <div class="detail-item">
            <div class="detail-label">Responsable</div>
            <div class="detail-value">{{ $mitigacion->responsable }}</div>
        </div>
        <div class="detail-item">
            <div class="detail-label">Fecha de Inicio</div>
            <div class="detail-value">{{ $mitigacion->fecha_inicio->format('d/m/Y') }}</div>
        </div>
        <div class="detail-item">
            <div class="detail-label">Fecha Límite</div>
            <div class="detail-value" style="color:{{ $mitigacion->fecha_limite < now() && $mitigacion->estado != 'completado' ? '#dc2626' : 'inherit' }};">
                {{ $mitigacion->fecha_limite->format('d/m/Y') }}
                @if($mitigacion->fecha_limite < now() && $mitigacion->estado != 'completado')
                <span style="font-size:11px;margin-left:4px;">(vencido)</span>
                @endif
            </div>
        </div>
        <div class="detail-item">
            <div class="detail-label">Registrado el</div>
            <div class="detail-value">{{ $mitigacion->created_at->format('d/m/Y H:i') }}</div>
        </div>
        <div class="detail-item">
            <div class="detail-label">Última actualización</div>
            <div class="detail-value">{{ $mitigacion->updated_at->format('d/m/Y H:i') }}</div>
        </div>
    </div>

    <div style="padding:16px 20px;border-top:1px solid #f1f5f9;">
        <div class="detail-label" style="margin-bottom:8px;">Avance: {{ $mitigacion->porcentaje_avance }}%</div>
        <div class="progress-track" style="height:10px;border-radius:5px;">
            <div class="progress-fill" style="width:{{ $mitigacion->porcentaje_avance }}%;height:100%;border-radius:5px;"></div>
        </div>
    </div>

    @if($mitigacion->descripcion)
    <div class="text-block">
        <div class="text-label">Descripción</div>
        <div class="text-content">{{ $mitigacion->descripcion }}</div>
    </div>
    @endif

    @if($mitigacion->acciones_requeridas)
    <div class="text-block">
        <div class="text-label">Acciones Requeridas</div>
        <div class="text-content">{{ $mitigacion->acciones_requeridas }}</div>
    </div>
    @endif

    @if($mitigacion->evidencias)
    <div class="text-block">
        <div class="text-label">Evidencias</div>
        <div class="text-content">{{ $mitigacion->evidencias }}</div>
    </div>
    @endif
</div>

@if($mitigacion->id !== auth()->id() && $mitigacion->estado !== 'completado')
<div class="panel">
    <div class="panel-header">
        <div class="panel-title"><i class="fas fa-cog"></i> Acciones</div>
    </div>
    <div style="padding:16px 20px;display:flex;gap:10px;">
        @if($mitigacion->estado === 'pendiente')
        <form method="POST" action="{{ route('mitigacion.aprobar', $mitigacion) }}">
            @csrf
            <button type="submit" class="btn btn-success"><i class="fas fa-check"></i> Aprobar plan</button>
        </form>
        @endif
        <form method="POST" action="{{ route('mitigacion.destroy', $mitigacion) }}" onsubmit="return confirm('¿Eliminar este plan de mitigación?')">
            @csrf @method('DELETE')
            <button type="submit" class="btn btn-danger"><i class="fas fa-trash"></i> Eliminar</button>
        </form>
    </div>
</div>
@endif

@endsection

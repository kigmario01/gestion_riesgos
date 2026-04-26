@extends('layouts.main')

@section('title', $evaluacion->codigo . ' — Evaluación de Riesgo')

@section('topbar-left')
    <div class="topbar-icon"><i class="fas fa-search-plus"></i></div>
    <div class="topbar-title">Detalle de Evaluación</div>
@endsection

@section('topbar-right')
    <a href="{{ route('evaluaciones.edit', $evaluacion) }}" class="btn btn-outline btn-sm"><i class="fas fa-edit"></i> Editar</a>
    <a href="{{ route('evaluaciones.index') }}" class="btn btn-outline btn-sm"><i class="fas fa-arrow-left"></i> Volver</a>
@endsection

@push('styles')
<style>
.risk-summary{display:flex;align-items:center;gap:20px;padding:20px;background:#f8fafc;border-bottom:1px solid #f1f5f9;}
.valor-box{display:inline-flex;align-items:center;justify-content:center;width:54px;height:54px;border-radius:12px;font-weight:800;font-size:24px;flex-shrink:0;}
.valor-critico{background:#fef2f2;color:#dc2626;}.valor-alto{background:#fff7ed;color:#ea580c;}.valor-medio{background:#fefce8;color:#ca8a04;}.valor-bajo{background:#f0fdf4;color:#16a34a;}
.version-badge{background:#eff6ff;color:#1d4ed8;padding:3px 8px;border-radius:6px;font-size:11px;font-weight:600;}
</style>
@endpush

@section('content')

<div class="panel">
    <div class="risk-summary">
        <span class="valor-box valor-{{ $evaluacion->nivel_riesgo }}">{{ $evaluacion->valor_riesgo }}</span>
        <div>
            <div>
                <span class="badge badge-{{ $evaluacion->nivel_riesgo }}" style="font-size:13px;padding:5px 14px;">
                    <span class="badge-dot"></span> RIESGO {{ strtoupper($evaluacion->nivel_riesgo) }}
                </span>
            </div>
            <div style="margin-top:6px;font-size:13px;color:#64748b;">
                Impacto <strong>{{ $evaluacion->impacto }}</strong> × Probabilidad <strong>{{ $evaluacion->probabilidad }}</strong> = <strong>{{ $evaluacion->valor_riesgo }}</strong>
            </div>
        </div>
        <div style="margin-left:auto;display:flex;flex-direction:column;align-items:flex-end;gap:6px;">
            <code class="tag" style="font-size:13px;font-weight:600;">{{ $evaluacion->codigo }}</code>
            <span class="version-badge">v{{ $evaluacion->version ?? 1 }}</span>
            <span class="badge badge-{{ $evaluacion->estado }}">{{ strtoupper($evaluacion->estado) }}</span>
        </div>
    </div>

    <div class="panel-header" style="border-top:1px solid #f1f5f9;">
        <div class="panel-title"><i class="fas fa-info-circle"></i> Información General</div>
    </div>
    <div class="detail-grid">
        <div class="detail-item">
            <div class="detail-label">Activo TI</div>
            <div class="detail-value">
                <a href="{{ route('activos.show', $evaluacion->activo) }}" style="color:#3b82f6;text-decoration:none;font-weight:600;">
                    {{ $evaluacion->activo->nombre ?? 'N/A' }}
                </a>
                @if($evaluacion->activo)
                <div style="font-size:11px;color:#94a3b8;margin-top:2px;">{{ $evaluacion->activo->codigo }}</div>
                @endif
            </div>
        </div>
        <div class="detail-item">
            <div class="detail-label">Amenaza</div>
            <div class="detail-value">{{ $evaluacion->amenaza->nombre ?? 'N/A' }}</div>
        </div>
        <div class="detail-item">
            <div class="detail-label">Impacto (1–5)</div>
            <div class="detail-value" style="font-size:22px;font-weight:700;">{{ $evaluacion->impacto }}</div>
        </div>
        <div class="detail-item">
            <div class="detail-label">Probabilidad (1–5)</div>
            <div class="detail-value" style="font-size:22px;font-weight:700;">{{ $evaluacion->probabilidad }}</div>
        </div>
        <div class="detail-item">
            <div class="detail-label">Fecha de Evaluación</div>
            <div class="detail-value">{{ $evaluacion->fecha_evaluacion->format('d/m/Y') }}</div>
        </div>
        <div class="detail-item">
            <div class="detail-label">Próxima Revisión</div>
            <div class="detail-value">{{ $evaluacion->proxima_revision ? $evaluacion->proxima_revision->format('d/m/Y') : '—' }}</div>
        </div>
        <div class="detail-item">
            <div class="detail-label">Evaluado por</div>
            <div class="detail-value">{{ $evaluacion->evaluador->name ?? '—' }}</div>
        </div>
        <div class="detail-item">
            <div class="detail-label">Última Actualización</div>
            <div class="detail-value">{{ $evaluacion->updated_at->format('d/m/Y H:i') }}</div>
        </div>
    </div>

    @if($evaluacion->vulnerabilidades)
    <div class="text-block">
        <div class="text-label">Vulnerabilidades</div>
        <div class="text-content">{{ $evaluacion->vulnerabilidades }}</div>
    </div>
    @endif

    @if($evaluacion->controles_existentes)
    <div class="text-block">
        <div class="text-label">Controles Existentes</div>
        <div class="text-content">{{ $evaluacion->controles_existentes }}</div>
    </div>
    @endif

    @if($evaluacion->observaciones)
    <div class="text-block">
        <div class="text-label">Observaciones</div>
        <div class="text-content">{{ $evaluacion->observaciones }}</div>
    </div>
    @endif
</div>

<div class="panel">
    <div class="panel-header">
        <div class="panel-title"><i class="fas fa-shield-virus"></i> Planes de Mitigación</div>
        <a href="{{ route('mitigacion.create', ['evaluacion_id' => $evaluacion->id]) }}" class="btn btn-primary btn-sm"><i class="fas fa-plus"></i> Nuevo Plan</a>
    </div>
    @if($evaluacion->planes->count() > 0)
    <table class="table">
        <thead>
            <tr><th>Código</th><th>Nombre</th><th>Responsable</th><th>Estado</th><th>Fecha Límite</th><th>Acciones</th></tr>
        </thead>
        <tbody>
        @foreach($evaluacion->planes as $plan)
        <tr>
            <td><code class="tag">{{ $plan->codigo ?? '—' }}</code></td>
            <td><div style="font-weight:500;">{{ $plan->nombre ?? $plan->titulo }}</div></td>
            <td>{{ $plan->responsable ?? '—' }}</td>
            <td><span class="badge badge-{{ $plan->estado }}">{{ strtoupper(str_replace('_',' ',$plan->estado)) }}</span></td>
            <td style="font-size:12px;color:#64748b;">{{ $plan->fecha_limite ? \Carbon\Carbon::parse($plan->fecha_limite)->format('d/m/Y') : '—' }}</td>
            <td><a href="{{ route('mitigacion.show', $plan) }}" class="btn btn-outline btn-xs"><i class="fas fa-eye"></i></a></td>
        </tr>
        @endforeach
        </tbody>
    </table>
    @else
    <div class="empty-state">
        <i class="fas fa-shield-virus"></i>
        <p>No hay planes de mitigación para esta evaluación.</p>
        <a href="{{ route('mitigacion.create', ['evaluacion_id' => $evaluacion->id]) }}" class="btn btn-primary btn-sm"><i class="fas fa-plus"></i> Crear plan</a>
    </div>
    @endif
</div>

@endsection

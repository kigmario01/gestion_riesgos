@extends('layouts.main')

@section('title', $activo->nombre . ' — Activo TI')

@section('topbar-left')
    <div class="topbar-icon"><i class="fas fa-server"></i></div>
    <div class="topbar-title">Detalles del Activo TI</div>
@endsection

@section('topbar-right')
    <a href="{{ route('activos.edit', $activo) }}" class="btn btn-outline btn-sm"><i class="fas fa-edit"></i> Editar</a>
    <a href="{{ route('activos.index') }}" class="btn btn-outline btn-sm"><i class="fas fa-arrow-left"></i> Volver</a>
@endsection

@section('content')

<div class="panel">
    <div class="panel-header">
        <div class="panel-title"><i class="fas fa-info-circle"></i> Información General</div>
        <span class="badge badge-{{ $activo->criticidad }}">{{ strtoupper($activo->criticidad) }}</span>
    </div>
    <div class="detail-grid">
        <div class="detail-item">
            <div class="detail-label">Código</div>
            <div class="detail-value"><code class="tag">{{ $activo->codigo }}</code></div>
        </div>
        <div class="detail-item">
            <div class="detail-label">Nombre</div>
            <div class="detail-value">{{ $activo->nombre }}</div>
        </div>
        <div class="detail-item">
            <div class="detail-label">Tipo</div>
            <div class="detail-value" style="text-transform:capitalize;">{{ $activo->tipo }}</div>
        </div>
        <div class="detail-item">
            <div class="detail-label">Estado</div>
            <div class="detail-value"><span class="badge badge-{{ $activo->estado }}">{{ strtoupper(str_replace('_',' ',$activo->estado)) }}</span></div>
        </div>
        <div class="detail-item">
            <div class="detail-label">Ubicación</div>
            <div class="detail-value">{{ $activo->ubicacion ?? '—' }}</div>
        </div>
        <div class="detail-item">
            <div class="detail-label">Responsable</div>
            <div class="detail-value">{{ $activo->responsable ?? '—' }}</div>
        </div>
        <div class="detail-item">
            <div class="detail-label">Valor Económico</div>
            <div class="detail-value">{{ $activo->valor_economico ? '$'.number_format($activo->valor_economico,2) : '—' }}</div>
        </div>
        <div class="detail-item">
            <div class="detail-label">Registrado por</div>
            <div class="detail-value">{{ $activo->registrador->name ?? '—' }}</div>
        </div>
        <div class="detail-item">
            <div class="detail-label">Fecha de Registro</div>
            <div class="detail-value">{{ $activo->created_at->format('d/m/Y H:i') }}</div>
        </div>
        <div class="detail-item">
            <div class="detail-label">Última Actualización</div>
            <div class="detail-value">{{ $activo->updated_at->format('d/m/Y H:i') }}</div>
        </div>
    </div>
    @if($activo->descripcion)
    <div class="text-block">
        <div class="text-label">Descripción</div>
        <div class="text-content">{{ $activo->descripcion }}</div>
    </div>
    @endif
</div>

<div class="panel">
    <div class="panel-header">
        <div class="panel-title"><i class="fas fa-exclamation-triangle"></i> Evaluaciones de Riesgo</div>
        <a href="{{ route('evaluaciones.create', ['activo_id' => $activo->id]) }}" class="btn btn-primary btn-sm"><i class="fas fa-plus"></i> Nueva Evaluación</a>
    </div>
    @if($activo->evaluaciones->count() > 0)
    <table class="table">
        <thead>
            <tr><th>Amenaza</th><th style="text-align:center;">Impacto</th><th style="text-align:center;">Probabilidad</th><th>Nivel</th><th>Fecha</th><th>Acciones</th></tr>
        </thead>
        <tbody>
        @foreach($activo->evaluaciones as $ev)
        <tr>
            <td>
                <div style="font-weight:500;">{{ $ev->amenaza->nombre ?? 'N/A' }}</div>
                @if($ev->amenaza?->descripcion)
                <div style="font-size:11px;color:#94a3b8;">{{ Str::limit($ev->amenaza->descripcion, 40) }}</div>
                @endif
            </td>
            <td style="text-align:center;font-weight:600;">{{ $ev->impacto }}</td>
            <td style="text-align:center;font-weight:600;">{{ $ev->probabilidad }}</td>
            <td><span class="badge badge-{{ $ev->nivel_riesgo }}">{{ strtoupper($ev->nivel_riesgo) }}</span></td>
            <td style="font-size:12px;color:#64748b;">{{ $ev->created_at->format('d/m/Y') }}</td>
            <td>
                <div class="actions">
                    <a href="{{ route('evaluaciones.show', $ev) }}" class="btn btn-outline btn-xs"><i class="fas fa-eye"></i></a>
                    <a href="{{ route('evaluaciones.edit', $ev) }}" class="btn btn-outline btn-xs"><i class="fas fa-edit"></i></a>
                </div>
            </td>
        </tr>
        @endforeach
        </tbody>
    </table>
    @else
    <div class="empty-state">
        <i class="fas fa-shield-alt"></i>
        <p>No hay evaluaciones de riesgo para este activo.</p>
        <a href="{{ route('evaluaciones.create', ['activo_id' => $activo->id]) }}" class="btn btn-primary btn-sm"><i class="fas fa-plus"></i> Crear primera evaluación</a>
    </div>
    @endif
</div>

@endsection

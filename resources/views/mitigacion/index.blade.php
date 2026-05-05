@extends('layouts.main')

@section('title', 'Planes de Mitigación')

@section('topbar-left')
    <div class="topbar-icon"><i class="fas fa-shield-virus"></i></div>
    <div class="topbar-title">Planes de Mitigación</div>
@endsection

@section('topbar-right')
    @can('mitigacion.crear')<a href="{{ route('mitigacion.create') }}" class="btn btn-primary btn-sm"><i class="fas fa-plus"></i> Nuevo Plan</a>@endcan
@endsection

@push('styles')
<style>
.mplan-stripe { height:3px; }
.ms-pendiente   { background:linear-gradient(90deg,#64748b,#475569); }
.ms-en_progreso { background:linear-gradient(90deg,#4f8ef7,#3b82f6); }
.ms-completado  { background:linear-gradient(90deg,#22c55e,#16a34a); }
.ms-cancelado   { background:linear-gradient(90deg,#ef4444,#dc2626); }
.ms-vencido     { background:linear-gradient(90deg,#f97316,#ea580c); }
.mplan-icon { width:40px;height:40px;border-radius:10px;display:flex;align-items:center;justify-content:center;font-size:15px;flex-shrink:0; }
.mi-preventivo  { background:#eff6ff;color:#3b82f6; }
.mi-correctivo  { background:#fef2f2;color:#dc2626; }
.mi-detectivo   { background:#fefce8;color:#ca8a04; }
.mi-transferencia { background:#fdf4ff;color:#9333ea; }
.mi-aceptacion  { background:#f0fdf4;color:#16a34a; }
</style>
@endpush

@section('content')

@php
    $estadoTabs = [
        'pendiente'   => ['label'=>'Pendiente',   'dot'=>'#64748b', 'tab'=>''],
        'en_progreso' => ['label'=>'En progreso',  'dot'=>'#4f8ef7', 'tab'=>'active'],
        'completado'  => ['label'=>'Completado',   'dot'=>'#22c55e', 'tab'=>'active-green'],
        'cancelado'   => ['label'=>'Cancelado',    'dot'=>'#ef4444', 'tab'=>'active-red'],
    ];
    $prioBadge = ['urgente'=>'badge-urgente','alta'=>'badge-alta','media'=>'badge-media','baja'=>'badge-baja'];
    $tipoIcon  = [
        'preventivo'   => ['icon'=>'fa-shield-alt',     'cls'=>'mi-preventivo'],
        'correctivo'   => ['icon'=>'fa-wrench',          'cls'=>'mi-correctivo'],
        'detectivo'    => ['icon'=>'fa-search',          'cls'=>'mi-detectivo'],
        'transferencia'=> ['icon'=>'fa-exchange-alt',    'cls'=>'mi-transferencia'],
        'aceptacion'   => ['icon'=>'fa-check-circle',    'cls'=>'mi-aceptacion'],
    ];
    $progColors = [
        'completado'  => '#22c55e',
        'en_progreso' => '#4f8ef7',
        'cancelado'   => '#ef4444',
        'pendiente'   => '#94a3b8',
    ];
@endphp

{{-- Filter tabs --}}
<div class="filter-tabs">
    <button class="filter-tab active" onclick="filterPlanes('all', this)">
        Todos <span class="tab-count">{{ $planes->total() }}</span>
    </button>
    @foreach($estadoTabs as $estado => $cfg)
    <button class="filter-tab" onclick="filterPlanes('{{ $estado }}', this)">
        <span style="width:8px;height:8px;border-radius:50%;background:{{ $cfg['dot'] }};display:inline-block;flex-shrink:0;"></span>
        {{ $cfg['label'] }}
    </button>
    @endforeach
</div>

@if($planes->count() > 0)
<div class="card-grid" id="planesGrid">
    @foreach($planes as $plan)
    @php
        $ti = $tipoIcon[$plan->tipo_control] ?? ['icon'=>'fa-shield-alt','cls'=>'mi-preventivo'];
        $stripeCls = 'ms-'.str_replace(' ','_',$plan->estado);
        $progColor = $progColors[$plan->estado] ?? '#94a3b8';
        $isOverdue = $plan->fecha_limite < now() && $plan->estado !== 'completado';
    @endphp
    <div class="item-card" data-estado="{{ $plan->estado }}">
        <div class="mplan-stripe {{ $stripeCls }}"></div>
        <div class="item-card-header">
            <div class="mplan-icon {{ $ti['cls'] }}">
                <i class="fas {{ $ti['icon'] }}"></i>
            </div>
            <div style="min-width:0;flex:1;">
                <div class="item-card-name" style="white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">{{ $plan->titulo }}</div>
                <div class="item-card-sub">
                    <code class="tag" style="font-size:10px;">{{ $plan->codigo }}</code>
                    &nbsp;·&nbsp;{{ ucfirst($plan->tipo_control) }}
                </div>
            </div>
            <div style="flex-shrink:0;display:flex;flex-direction:column;align-items:flex-end;gap:4px;">
                <span class="badge {{ $prioBadge[$plan->prioridad] ?? '' }}" style="font-size:10px;">{{ strtoupper($plan->prioridad) }}</span>
                <span class="badge badge-{{ $plan->estado }}" style="font-size:10px;">{{ strtoupper(str_replace('_',' ',$plan->estado)) }}</span>
            </div>
        </div>

        <div class="item-card-body">
            {{-- Riesgo asociado --}}
            <div style="background:#f8fafc;border-radius:8px;padding:9px 11px;margin-bottom:10px;border:1px solid #f1f5f9;">
                <div style="font-size:10px;font-weight:600;color:#94a3b8;text-transform:uppercase;letter-spacing:.5px;margin-bottom:4px;">Riesgo asociado</div>
                <div style="font-size:12.5px;font-weight:500;color:#1e293b;">{{ $plan->evaluacion->activo->nombre ?? 'N/A' }}</div>
                <div style="font-size:11px;color:#94a3b8;">{{ $plan->evaluacion->amenaza->nombre ?? '—' }}</div>
            </div>

            {{-- Progreso --}}
            <div>
                <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:5px;">
                    <span style="font-size:11px;font-weight:600;color:#374151;">Avance</span>
                    <span style="font-size:12px;font-weight:700;color:{{ $progColor }};">{{ $plan->porcentaje_avance }}%</span>
                </div>
                <div class="progress-track" style="height:7px;">
                    <div class="progress-fill" style="width:{{ $plan->porcentaje_avance }}%;background:{{ $progColor }};"></div>
                </div>
            </div>

            {{-- Fecha límite --}}
            <div style="margin-top:10px;display:flex;align-items:center;gap:6px;">
                <i class="fas fa-calendar{{ $isOverdue ? '-times' : '' }}" style="font-size:10px;color:{{ $isOverdue ? '#dc2626' : '#94a3b8' }};"></i>
                <span style="font-size:11.5px;color:{{ $isOverdue ? '#dc2626' : '#64748b' }};font-weight:{{ $isOverdue ? '600' : '400' }};">
                    {{ $plan->fecha_limite->format('d/m/Y') }}
                    @if($isOverdue) &nbsp;<span style="font-size:10px;background:#fef2f2;color:#dc2626;padding:1px 6px;border-radius:4px;">VENCIDO</span>@endif
                </span>
            </div>
        </div>

        <div class="item-card-footer">
            <span style="font-size:11px;color:#94a3b8;">
                {{ ucfirst($plan->estrategia ?? '—') }}
            </span>
            <div class="actions">
                <a href="{{ route('mitigacion.show', $plan) }}" class="btn btn-outline btn-xs" title="Ver"><i class="fas fa-eye"></i></a>
                @can('mitigacion.editar')<a href="{{ route('mitigacion.edit', $plan) }}" class="btn btn-outline btn-xs" title="Editar"><i class="fas fa-edit"></i></a>@endcan
                @can('mitigacion.aprobar')
                @if($plan->estado == 'pendiente')
                <form method="POST" action="{{ route('mitigacion.aprobar', $plan) }}" style="display:inline;">
                    @csrf
                    <button type="submit" class="btn btn-success btn-xs" title="Aprobar"><i class="fas fa-check"></i></button>
                </form>
                @endif
                @endcan
                @can('mitigacion.editar')
                <form method="POST" action="{{ route('mitigacion.destroy', $plan) }}" onsubmit="return confirm('¿Eliminar este plan?')" style="display:inline;">
                    @csrf @method('DELETE')
                    <button type="submit" class="btn btn-danger btn-xs" title="Eliminar"><i class="fas fa-trash"></i></button>
                </form>
                @endcan
            </div>
        </div>
    </div>
    @endforeach
</div>

<div style="padding:14px 4px;display:flex;align-items:center;justify-content:space-between;">
    <span style="font-size:12px;color:#94a3b8;">{{ $planes->total() }} plan(es) en total</span>
    {{ $planes->links() }}
</div>
@else
<div class="empty-state">
    <i class="fas fa-shield-virus"></i>
    <p>No hay planes de mitigación registrados.</p>
    <a href="{{ route('mitigacion.create') }}" class="btn btn-primary"><i class="fas fa-plus"></i> Crear primer plan</a>
</div>
@endif

@endsection

@push('scripts')
<script>
function filterPlanes(estado, btn) {
    document.querySelectorAll('.filter-tab').forEach(t =>
        t.classList.remove('active','active-red','active-orange','active-yellow','active-green')
    );
    const map = { all:'active', pendiente:'active', en_progreso:'active', completado:'active-green', cancelado:'active-red' };
    btn.classList.add(map[estado] || 'active');

    document.querySelectorAll('#planesGrid .item-card').forEach(card => {
        card.style.display = (estado === 'all' || card.dataset.estado === estado) ? '' : 'none';
    });
}
</script>
@endpush

@extends('layouts.main')

@section('title', 'Evaluaciones de Riesgo')

@section('topbar-left')
    <div class="topbar-icon"><i class="fas fa-search-plus"></i></div>
    <div class="topbar-title">Evaluaciones de Riesgo</div>
@endsection

@section('topbar-right')
    <a href="{{ route('evaluaciones.create') }}" class="btn btn-primary btn-sm"><i class="fas fa-plus"></i> Nueva Evaluación</a>
@endsection

@push('styles')
<style>
.kanban-board { align-items: start; }
</style>
@endpush

@section('content')

@php
    $grouped  = $evaluaciones->groupBy('nivel_riesgo');
    $total    = $evaluaciones->count();
    $niveles  = ['critico'=>'CRÍTICO','alto'=>'ALTO','medio'=>'MEDIO','bajo'=>'BAJO'];
    $kchMap   = ['critico'=>'kch-critico','alto'=>'kch-alto','medio'=>'kch-medio','bajo'=>'kch-bajo'];
    $strMap   = ['critico'=>'stripe-critico','alto'=>'stripe-alto','medio'=>'stripe-medio','bajo'=>'stripe-bajo'];
    $rcvMap   = ['critico'=>'rcv-critico','alto'=>'rcv-alto','medio'=>'rcv-medio','bajo'=>'rcv-bajo'];
    $tagMap   = ['critico'=>'rc-tag-critico','alto'=>'rc-tag-alto','medio'=>'rc-tag-medio','bajo'=>'rc-tag-bajo'];
    $dotColor = ['critico'=>'#ef4444','alto'=>'#f97316','medio'=>'#eab308','bajo'=>'#22c55e'];
    $activeTab= ['critico'=>'active-red','alto'=>'active-orange','medio'=>'active-yellow','bajo'=>'active-green'];
@endphp

{{-- Filter tabs --}}
<div class="filter-tabs">
    <button class="filter-tab active" onclick="filterEval('all', this)">
        Todos <span class="tab-count">{{ $total }}</span>
    </button>
    @foreach($niveles as $nivel => $label)
    <button class="filter-tab" onclick="filterEval('{{ $nivel }}', this)">
        <span style="width:8px;height:8px;border-radius:50%;background:{{ $dotColor[$nivel] }};display:inline-block;flex-shrink:0;"></span>
        {{ ucfirst($nivel) }} <span class="tab-count">{{ $grouped->get($nivel, collect())->count() }}</span>
    </button>
    @endforeach
</div>

@if($evaluaciones->count() > 0)
<div class="kanban-board" id="evalKanban">
    @foreach($niveles as $nivel => $label)
    <div class="kanban-col" data-col="{{ $nivel }}">
        <div class="kanban-col-header {{ $kchMap[$nivel] }}">
            <span>{{ $label }}</span>
            <span class="kch-count">{{ $grouped->get($nivel, collect())->count() }}</span>
        </div>

        @forelse($grouped->get($nivel, collect()) as $ev)
        <div class="risk-card">
            <div class="risk-card-stripe {{ $strMap[$nivel] }}"></div>
            <div class="risk-card-body">
                <div class="risk-card-top">
                    <div class="risk-card-tags">
                        <span class="rc-tag {{ $tagMap[$nivel] }}">{{ $label }}</span>
                        @if($ev->activo)
                        <span class="rc-tag rc-tag-tipo" style="text-transform:capitalize;">{{ $ev->activo->tipo }}</span>
                        @endif
                    </div>
                    <div class="rc-valor {{ $rcvMap[$nivel] }}">{{ $ev->valor_riesgo }}</div>
                </div>

                <div class="risk-card-title">{{ $ev->amenaza->nombre ?? 'Sin amenaza' }}</div>
                <div class="risk-card-path">
                    <i class="fas fa-server" style="font-size:9px;"></i>
                    {{ $ev->activo->nombre ?? 'Sin activo' }}
                </div>

                <div class="risk-card-meta">
                    <div class="rc-meta-item">
                        <i class="fas fa-bolt" style="font-size:9px;color:#f59e0b;"></i> Impacto {{ $ev->impacto }}/5
                    </div>
                    <div class="rc-meta-item">
                        <i class="fas fa-percent" style="font-size:9px;color:#6366f1;"></i> Prob. {{ $ev->probabilidad }}/5
                    </div>
                    <div class="rc-meta-item">
                        <i class="fas fa-calendar" style="font-size:9px;color:#94a3b8;"></i>
                        {{ $ev->fecha_evaluacion->format('d/m/Y') }}
                    </div>
                </div>

                <div class="risk-card-footer">
                    <div class="rc-assignee">
                        <div class="rc-avatar" style="background:linear-gradient(135deg,#4f8ef7,#6366f1);">
                            {{ strtoupper(substr($ev->evaluador->name ?? 'S', 0, 2)) }}
                        </div>
                        <div>
                            <div class="rc-name">{{ $ev->evaluador->name ?? 'Sistema' }}</div>
                            <div class="rc-dept">Evaluador</div>
                        </div>
                    </div>
                    <div style="display:flex;align-items:center;gap:5px;">
                        <span class="rc-id">{{ $ev->codigo }}</span>
                        <div class="rc-actions">
                            <a href="{{ route('evaluaciones.show', $ev) }}" class="btn btn-outline btn-xs" title="Ver detalle">
                                <i class="fas fa-eye"></i>
                            </a>
                            <a href="{{ route('evaluaciones.edit', $ev) }}" class="btn btn-outline btn-xs" title="Editar">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form method="POST" action="{{ route('evaluaciones.destroy', $ev) }}" onsubmit="return confirm('¿Eliminar esta evaluación?')" style="display:inline;">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-xs" title="Eliminar">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @empty
        <div style="background:#f8fafc;border-radius:10px;border:1.5px dashed #e8eaf0;padding:26px 14px;text-align:center;color:#cbd5e1;font-size:11.5px;">
            <i class="fas fa-check-circle" style="font-size:22px;display:block;margin-bottom:8px;"></i>
            Sin riesgos en este nivel
        </div>
        @endforelse
    </div>
    @endforeach
</div>

<div style="padding:10px 4px;font-size:12px;color:#94a3b8;">
    {{ $total }} evaluación(es) en total
</div>

@else
<div class="empty-state">
    <i class="fas fa-search"></i>
    <p>No hay evaluaciones de riesgo registradas.</p>
    <a href="{{ route('evaluaciones.create') }}" class="btn btn-primary">
        <i class="fas fa-plus"></i> Crear primera evaluación
    </a>
</div>
@endif

@endsection

@push('scripts')
<script>
function filterEval(nivel, btn) {
    document.querySelectorAll('.filter-tab').forEach(t =>
        t.classList.remove('active','active-red','active-orange','active-yellow','active-green')
    );
    const map = { all:'active', critico:'active-red', alto:'active-orange', medio:'active-yellow', bajo:'active-green' };
    btn.classList.add(map[nivel]);

    document.querySelectorAll('#evalKanban [data-col]').forEach(col => {
        col.style.display = (nivel === 'all' || col.dataset.col === nivel) ? '' : 'none';
    });
}
</script>
@endpush

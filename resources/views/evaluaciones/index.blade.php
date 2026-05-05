@extends('layouts.main')

@section('title', 'Evaluaciones de Riesgo')

@section('topbar-left')
    <div class="topbar-icon"><i class="fas fa-search-plus"></i></div>
    <div class="topbar-title">Evaluaciones de Riesgo</div>
@endsection

@section('topbar-right')
    @can('evaluaciones.calcular')<a href="{{ route('evaluaciones.create') }}" class="btn btn-primary btn-sm"><i class="fas fa-plus"></i> Nueva Evaluación</a>@endcan
@endsection

@push('styles')
<style>
.kanban-board { align-items: start; }
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
.guia-tabla-niveles{width:100%;border-collapse:collapse;margin:10px 0;font-size:11.5px;}
.guia-tabla-niveles th{padding:6px 10px;background:#ffedd5;color:#c2410c;font-weight:700;text-align:left;}
.guia-tabla-niveles td{padding:6px 10px;border-bottom:1px solid #fed7aa;}
.guia-nota{margin-top:10px;padding:9px 13px;background:rgba(255,255,255,0.65);border-radius:8px;font-size:11.5px;color:#475569;display:flex;gap:8px;}
</style>
@endpush

@section('content')

<div class="guia-iso">
    <div class="guia-iso-header" onclick="this.nextElementSibling.style.display=this.nextElementSibling.style.display==='none'?'':'none'; this.querySelector('.guia-chevron').style.transform=this.nextElementSibling.style.display===''?'rotate(180deg)':''">
        <div class="guia-iso-icon"><i class="fas fa-book-open" style="color:#ea580c;font-size:14px;"></i></div>
        <div class="guia-iso-title">¿Cómo se analiza y evalúa el riesgo según ISO 27001?</div>
        <span class="guia-iso-ref">ISO 27001 — Fases 4.3 y 4.4 · Análisis y Evaluación</span>
        <i class="fas fa-chevron-up guia-chevron" style="color:#ea580c;font-size:11px;transition:transform .2s;"></i>
    </div>
    <div class="guia-iso-body">
        <p style="font-size:12.5px;color:#9a3412;margin-bottom:12px;line-height:1.6;">
            El análisis de riesgo combina el <strong>impacto potencial</strong> de una amenaza sobre un activo con la <strong>probabilidad</strong> de que ocurra. El resultado es un valor numérico que determina la urgencia de actuar. ISO 27001 requiere documentar cada evaluación con su justificación.
        </p>
        <div class="guia-paso"><div class="guia-num">1</div><div><strong>Selecciona el activo</strong> que deseas evaluar y la <strong>amenaza</strong> específica que podría afectarlo (puedes hacer múltiples evaluaciones del mismo activo con distintas amenazas).</div></div>
        <div class="guia-paso"><div class="guia-num">2</div><div><strong>Impacto (1–5):</strong> ¿Qué tan grave sería el daño si la amenaza se materializara? 1 = insignificante / 5 = pérdida financiera insoportable para el negocio.</div></div>
        <div class="guia-paso"><div class="guia-num">3</div><div><strong>Probabilidad (1–5):</strong> ¿Con qué frecuencia podría ocurrir este evento? 1 = muy rara vez / 5 = ha ocurrido recientemente o es muy probable.</div></div>
        <div class="guia-paso"><div class="guia-num">4</div><div><strong>Valor de riesgo = Impacto × Probabilidad.</strong> El sistema lo calcula automáticamente y determina el nivel según esta escala:</div></div>
        <table class="guia-tabla-niveles">
            <tr><th>Valor</th><th>Nivel</th><th>Acción requerida</th></tr>
            <tr><td><strong style="color:#dc2626;">16–25</strong></td><td><span style="background:#fef2f2;color:#dc2626;padding:1px 8px;border-radius:10px;font-weight:700;">CRÍTICO</span></td><td>Acción inmediata obligatoria. Escalar a dirección.</td></tr>
            <tr><td><strong style="color:#ea580c;">10–15</strong></td><td><span style="background:#fff7ed;color:#ea580c;padding:1px 8px;border-radius:10px;font-weight:700;">ALTO</span></td><td>Plan de mitigación en el corto plazo (&lt; 30 días).</td></tr>
            <tr><td><strong style="color:#ca8a04;">5–9</strong></td><td><span style="background:#fefce8;color:#ca8a04;padding:1px 8px;border-radius:10px;font-weight:700;">MEDIO</span></td><td>Plan de mitigación a mediano plazo (&lt; 90 días).</td></tr>
            <tr><td><strong style="color:#16a34a;">1–4</strong></td><td><span style="background:#f0fdf4;color:#16a34a;padding:1px 8px;border-radius:10px;font-weight:700;">BAJO</span></td><td>Monitorear periódicamente. Puede aceptarse.</td></tr>
        </table>
        <div class="guia-paso"><div class="guia-num">5</div><div><strong>Documenta vulnerabilidades y controles existentes.</strong> Esto es evidencia auditada de que conoces el riesgo y estás gestionándolo activamente.</div></div>
        <div class="guia-nota">
            <i class="fas fa-lightbulb" style="color:#f59e0b;flex-shrink:0;margin-top:1px;"></i>
            <span>Todo riesgo con nivel <strong>Alto o Crítico</strong> debe tener un Plan de Mitigación asociado en el módulo de Mitigación. La evaluación sin plan de tratamiento no cumple con ISO 27001.</span>
        </div>
    </div>
</div>

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
                            <a href="{{ route('evaluaciones.show', $ev) }}" class="btn btn-outline btn-xs" title="Ver detalle"><i class="fas fa-eye"></i></a>
                            @can('evaluaciones.editar')<a href="{{ route('evaluaciones.edit', $ev) }}" class="btn btn-outline btn-xs" title="Editar"><i class="fas fa-edit"></i></a>@endcan
                            @can('evaluaciones.editar')
                            <form method="POST" action="{{ route('evaluaciones.destroy', $ev) }}" onsubmit="return confirm('¿Eliminar esta evaluación?')" style="display:inline;">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-xs" title="Eliminar"><i class="fas fa-trash"></i></button>
                            </form>
                            @endcan
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @empty
        <div class="kanban-empty">
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

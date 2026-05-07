@extends('layouts.main')

@section('title', 'Dashboard')

@section('topbar-left')
    <div class="topbar-icon"><i class="fas fa-chart-pie"></i></div>
    <div>
        <div class="topbar-title">Dashboard General</div>
    </div>
@endsection

@section('topbar-right')
    <a href="{{ route('evaluaciones.index') }}" class="btn btn-outline btn-sm"><i class="fas fa-layer-group"></i> Todos los riesgos</a>
    <a href="{{ route('evaluaciones.create') }}" class="btn btn-primary btn-sm"><i class="fas fa-plus"></i> Nuevo Riesgo</a>
@endsection

@section('content')

@if($totalCritico > 0)
<div class="alert alert-error">
    <i class="fas fa-exclamation-triangle"></i>
    <div>
        <strong>{{ $totalCritico }} riesgo(s) crítico(s) requieren atención inmediata.</strong>
        Revisa la <a href="{{ route('matriz.index') }}" style="color:#dc2626;font-weight:600;">matriz de riesgos</a> y asigna planes de mitigación urgentes.
    </div>
</div>
@endif

{{-- Risk level stats --}}
<div class="stats-grid">
    <a href="{{ route('evaluaciones.index') }}" style="text-decoration:none;" aria-label="Ver riesgos críticos: {{ $totalCritico }}">
        <div class="stat-card" style="border-top:3px solid #ef4444;">
            <div class="stat-icon si-red"><i class="fas fa-exclamation-circle" aria-hidden="true"></i></div>
            <div>
                <div class="stat-num">{{ $totalCritico }}</div>
                <div class="stat-lbl">Riesgos Críticos</div>
                @if($totalCritico > 0)<div class="stat-trend trend-up"><i class="fas fa-arrow-up" style="font-size:9px;" aria-hidden="true"></i> Atención requerida</div>@endif
            </div>
        </div>
    </a>
    <a href="{{ route('evaluaciones.index') }}" style="text-decoration:none;" aria-label="Ver riesgos altos: {{ $totalAlto }}">
        <div class="stat-card" style="border-top:3px solid #f97316;">
            <div class="stat-icon si-orange"><i class="fas fa-exclamation-triangle" aria-hidden="true"></i></div>
            <div>
                <div class="stat-num">{{ $totalAlto }}</div>
                <div class="stat-lbl">Riesgos Altos</div>
            </div>
        </div>
    </a>
    <a href="{{ route('evaluaciones.index') }}" style="text-decoration:none;" aria-label="Ver riesgos medios: {{ $totalMedio }}">
        <div class="stat-card" style="border-top:3px solid #eab308;">
            <div class="stat-icon si-yellow"><i class="fas fa-minus-circle" aria-hidden="true"></i></div>
            <div>
                <div class="stat-num">{{ $totalMedio }}</div>
                <div class="stat-lbl">Riesgos Medios</div>
            </div>
        </div>
    </a>
    <a href="{{ route('evaluaciones.index') }}" style="text-decoration:none;" aria-label="Ver riesgos bajos: {{ $totalBajo }}">
        <div class="stat-card" style="border-top:3px solid #22c55e;">
            <div class="stat-icon si-green"><i class="fas fa-check-circle" aria-hidden="true"></i></div>
            <div>
                <div class="stat-num">{{ $totalBajo }}</div>
                <div class="stat-lbl">Riesgos Bajos</div>
                @if($totalBajo > 0)<div class="stat-trend trend-down"><i class="fas fa-check" style="font-size:9px;" aria-hidden="true"></i> Bajo control</div>@endif
            </div>
        </div>
    </a>
</div>

{{-- Kanban: últimos riesgos --}}
@php
    $grupos    = $ultimosRiesgos->groupBy('nivel_riesgo');
    $niveles   = ['critico'=>'CRÍTICO','alto'=>'ALTO','medio'=>'MEDIO','bajo'=>'BAJO'];
    $kchMap    = ['critico'=>'kch-critico','alto'=>'kch-alto','medio'=>'kch-medio','bajo'=>'kch-bajo'];
    $strMap    = ['critico'=>'stripe-critico','alto'=>'stripe-alto','medio'=>'stripe-medio','bajo'=>'stripe-bajo'];
    $rcvMap    = ['critico'=>'rcv-critico','alto'=>'rcv-alto','medio'=>'rcv-medio','bajo'=>'rcv-bajo'];
    $tagMap    = ['critico'=>'rc-tag-critico','alto'=>'rc-tag-alto','medio'=>'rc-tag-medio','bajo'=>'rc-tag-bajo'];
@endphp

<div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:12px;">
    <div style="font-size:13px;font-weight:600;color:#1b1f3b;display:flex;align-items:center;gap:8px;" class="text-adaptive">
        <i class="fas fa-layer-group" style="color:#f97316;font-size:12px;" aria-hidden="true"></i> Últimos Riesgos Activos
        <span style="font-size:11px;font-weight:400;color:#94a3b8;">— {{ $ultimosRiesgos->count() }} más recientes</span>
    </div>
    <a href="{{ route('evaluaciones.index') }}" class="btn btn-outline btn-sm">Ver todos →</a>
</div>

<div class="kanban-board" style="margin-bottom:20px;">
    @foreach($niveles as $nivel => $label)
    <div class="kanban-col">
        <div class="kanban-col-header {{ $kchMap[$nivel] }}">
            <span>{{ $label }}</span>
            <span class="kch-count">{{ $grupos->get($nivel, collect())->count() }}</span>
        </div>
        @forelse($grupos->get($nivel, collect()) as $riesgo)
        <a href="{{ route('evaluaciones.show', $riesgo) }}" style="text-decoration:none;">
            <div class="risk-card">
                <div class="risk-card-stripe {{ $strMap[$nivel] }}"></div>
                <div class="risk-card-body">
                    <div class="risk-card-top">
                        <div class="risk-card-tags">
                            <span class="rc-tag {{ $tagMap[$nivel] }}">{{ $label }}</span>
                        </div>
                        <div class="rc-valor {{ $rcvMap[$nivel] }}">{{ $riesgo->valor_riesgo }}</div>
                    </div>
                    <div class="risk-card-title">{{ $riesgo->amenaza->nombre ?? 'Sin amenaza' }}</div>
                    <div class="risk-card-path">
                        <i class="fas fa-server" style="font-size:9px;"></i>
                        {{ $riesgo->activo->nombre ?? 'Sin activo' }}
                    </div>
                    <div class="risk-card-meta">
                        <div class="rc-meta-item"><i class="fas fa-bolt" style="font-size:9px;color:#f59e0b;"></i> Imp. {{ $riesgo->impacto }}/5</div>
                        <div class="rc-meta-item"><i class="fas fa-percent" style="font-size:9px;color:#6366f1;"></i> Prob. {{ $riesgo->probabilidad }}/5</div>
                    </div>
                    <div class="risk-card-footer">
                        <div class="rc-assignee">
                            <div class="rc-avatar" style="background:linear-gradient(135deg,#4f8ef7,#6366f1);">{{ strtoupper(substr($riesgo->evaluador->name ?? 'S', 0, 2)) }}</div>
                            <div>
                                <div class="rc-name">{{ $riesgo->evaluador->name ?? 'Sistema' }}</div>
                            </div>
                        </div>
                        <span class="rc-id">{{ $riesgo->codigo }}</span>
                    </div>
                </div>
            </div>
        </a>
        @empty
        <div class="kanban-empty">
            <i class="fas fa-check-circle" style="font-size:18px;display:block;margin-bottom:6px;"></i>Sin riesgos
        </div>
        @endforelse
    </div>
    @endforeach
</div>

{{-- Bottom row --}}
<div style="display:grid;grid-template-columns:1fr 320px;gap:18px;padding-bottom:32px;">

    {{-- Bitácora --}}
    <div class="panel" style="margin-bottom:0;">
        <div class="panel-header">
            <div class="panel-title"><i class="fas fa-clipboard-list" aria-hidden="true"></i> Actividad Reciente</div>
            <a href="{{ route('bitacora.index') }}" style="font-size:12px;color:#f97316;text-decoration:none;font-weight:500;">Ver bitácora →</a>
        </div>
        @if($ultimaBitacora->count() > 0)
            @foreach($ultimaBitacora as $log)
            <div style="display:flex;gap:12px;padding:10px 18px;border-bottom:1px solid #f5f6fa;">
                <div style="width:7px;height:7px;border-radius:50%;margin-top:5px;flex-shrink:0;
                    background:@if(in_array($log->accion,['crear','aprobar']))#22c55e
                              @elseif(in_array($log->accion,['eliminar','login_fallido']))#ef4444
                              @elseif($log->accion=='editar')#eab308
                              @else #4f8ef7 @endif;">
                </div>
                <div style="min-width:0;">
                    <div style="font-size:12.5px;color:#374151;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;" class="text-adaptive">{{ $log->descripcion }}</div>
                    <div style="font-size:11px;color:#94a3b8;margin-top:2px;">
                        {{ $log->user_nombre ?? 'Sistema' }} &middot; {{ \Carbon\Carbon::parse($log->created_at)->diffForHumans() }}
                        &middot; <span style="font-weight:600;text-transform:uppercase;font-size:10px;">{{ $log->accion }}</span>
                    </div>
                </div>
            </div>
            @endforeach
        @else
            <div class="empty-state" style="padding:32px 20px;">
                <i class="fas fa-clipboard" style="font-size:28px;"></i>
                <p style="margin-bottom:0;">La bitácora está vacía.</p>
            </div>
        @endif
    </div>

    {{-- Resumen general --}}
    <div class="panel" style="margin-bottom:0;">
        <div class="panel-header">
            <div class="panel-title"><i class="fas fa-chart-bar"></i> Resumen General</div>
        </div>
        @php
        $resumen = [
            ['route'=>'activos.index',     'icon'=>'fa-server',              'si'=>'si-blue',   'label'=>'Activos TI',       'sub'=>'Registrados',      'val'=>$totalActivos],
            ['route'=>'amenazas.index',    'icon'=>'fa-biohazard',           'si'=>'si-red',    'label'=>'Amenazas',         'sub'=>'Activas',          'val'=>$totalAmenazas],
            ['route'=>'evaluaciones.index','icon'=>'fa-exclamation-triangle','si'=>'si-yellow', 'label'=>'Evaluaciones',     'sub'=>'Bajo seguimiento', 'val'=>$totalRiesgos],
            ['route'=>'mitigacion.index',  'icon'=>'fa-shield-virus',        'si'=>'si-green',  'label'=>'Planes Mitigación','sub'=>'En progreso',      'val'=>$totalPlanes],
        ];
        @endphp
        @foreach($resumen as $item)
        <a href="{{ route($item['route']) }}" style="display:flex;align-items:center;justify-content:space-between;padding:14px 18px;border-bottom:1px solid #f5f6fa;text-decoration:none;color:inherit;transition:background .15s;"
           onmouseover="this.style.background='#fafbff'" onmouseout="this.style.background=''">
            <div style="display:flex;align-items:center;gap:12px;">
                <div class="stat-icon {{ $item['si'] }}" style="width:36px;height:36px;border-radius:9px;font-size:14px;flex-shrink:0;">
                    <i class="fas {{ $item['icon'] }}"></i>
                </div>
                <div>
                    <div style="font-size:13px;font-weight:500;color:#1e293b;" class="text-adaptive">{{ $item['label'] }}</div>
                    <div style="font-size:11px;color:#94a3b8;">{{ $item['sub'] }}</div>
                </div>
            </div>
            <div style="font-size:22px;font-weight:800;color:#1b1f3b;" class="text-adaptive">{{ $item['val'] }}</div>
        </a>
        @endforeach
        <div style="padding:12px 18px;display:flex;gap:8px;">
            <a href="{{ route('matriz.index') }}" class="btn btn-outline btn-sm" style="flex:1;justify-content:center;">
                <i class="fas fa-th"></i> Ver Matriz
            </a>
            <a href="{{ route('respaldos.index') }}" class="btn btn-outline btn-sm" style="flex:1;justify-content:center;">
                <i class="fas fa-database"></i> Respaldos
            </a>
        </div>
    </div>

</div>

@endsection

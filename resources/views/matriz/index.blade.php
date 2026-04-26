@extends('layouts.main')

@section('title', 'Matriz de Riesgos')

@section('topbar-left')
    <div class="topbar-icon"><i class="fas fa-th"></i></div>
    <div class="topbar-title">Matriz de Riesgos TI — ISO 27001</div>
@endsection

@section('topbar-right')
    <a href="{{ route('evaluaciones.create') }}" class="btn btn-primary btn-sm"><i class="fas fa-plus"></i> Nueva Evaluación</a>
@endsection

@push('styles')
<style>
.stats-grid{display:grid;grid-template-columns:repeat(4,1fr);gap:16px;margin-bottom:20px;}
.stat-card{background:#fff;border-radius:12px;padding:18px;border:1px solid #e2e8f0;text-align:center;position:relative;overflow:hidden;}
.stat-card::before{content:'';position:absolute;top:0;left:0;right:0;height:3px;}
.stat-card.critico::before{background:#ef4444;}.stat-card.alto::before{background:#f97316;}.stat-card.medio::before{background:#eab308;}.stat-card.bajo::before{background:#22c55e;}
.stat-value{font-size:36px;font-weight:800;line-height:1;}.stat-label{font-size:12px;color:#64748b;margin-top:4px;}
.c-critico{color:#dc2626;}.c-alto{color:#ea580c;}.c-medio{color:#ca8a04;}.c-bajo{color:#16a34a;}
.matriz-wrap{background:#fff;border-radius:12px;border:1px solid #e2e8f0;padding:24px;margin-bottom:20px;}
.matriz-title{font-size:14px;font-weight:600;margin-bottom:16px;display:flex;align-items:center;gap:8px;color:#1e293b;}
.matriz-title i{color:#3b82f6;}
.matriz-grid{display:grid;grid-template-columns:40px repeat(5,1fr);gap:4px;max-width:580px;}
.matriz-axis{display:flex;align-items:center;justify-content:center;font-size:11px;font-weight:600;color:#64748b;}
.matriz-cell{aspect-ratio:1;border-radius:8px;display:flex;flex-direction:column;align-items:center;justify-content:center;font-size:13px;font-weight:700;cursor:default;transition:opacity 0.2s;position:relative;}
.matriz-cell:hover{opacity:0.8;}
.mc-bajo{background:#dcfce7;color:#16a34a;}.mc-medio{background:#fef9c3;color:#ca8a04;}.mc-alto{background:#ffedd5;color:#ea580c;}.mc-critico{background:#fee2e2;color:#dc2626;}
.mc-count{font-size:10px;font-weight:400;opacity:0.8;}
.eje-label{font-size:10px;color:#94a3b8;text-align:center;margin-top:8px;}
.leyenda{display:flex;gap:16px;margin-top:12px;flex-wrap:wrap;}
.ley-item{display:flex;align-items:center;gap:6px;font-size:12px;color:#374151;}
.ley-dot{width:12px;height:12px;border-radius:3px;}
</style>
@endpush

@section('content')

<div class="stats-grid">
    <div class="stat-card critico">
        <div class="stat-value c-critico">{{ $criticos->count() }}</div>
        <div class="stat-label">Crítico (16–25)</div>
    </div>
    <div class="stat-card alto">
        <div class="stat-value c-alto">{{ $altos->count() }}</div>
        <div class="stat-label">Alto (10–15)</div>
    </div>
    <div class="stat-card medio">
        <div class="stat-value c-medio">{{ $medios->count() }}</div>
        <div class="stat-label">Medio (5–9)</div>
    </div>
    <div class="stat-card bajo">
        <div class="stat-value c-bajo">{{ $bajos->count() }}</div>
        <div class="stat-label">Bajo (1–4)</div>
    </div>
</div>

<div class="matriz-wrap">
    <div class="matriz-title"><i class="fas fa-th"></i> Matriz de Riesgo 5×5 (Impacto vs Probabilidad)</div>
    <div style="font-size:11px;font-weight:600;color:#64748b;margin-bottom:8px;">PROBABILIDAD →</div>
    <div class="matriz-grid">
        <div class="matriz-axis"></div>
        @for($p=1;$p<=5;$p++)
        <div class="matriz-axis">{{ $p }}</div>
        @endfor

        @for($i=5;$i>=1;$i--)
        <div class="matriz-axis" style="font-size:10px;">I={{ $i }}</div>
        @for($p=1;$p<=5;$p++)
        <div class="matriz-cell mc-{{ $matriz[$i][$p]['nivel'] }}" title="Impacto:{{ $i }} × Prob:{{ $p }} = {{ $matriz[$i][$p]['valor'] }}">
            {{ $matriz[$i][$p]['valor'] }}
            @if($matriz[$i][$p]['count'] > 0)
            <span class="mc-count">({{ $matriz[$i][$p]['count'] }})</span>
            @endif
        </div>
        @endfor
        @endfor
    </div>
    <div class="eje-label">↑ IMPACTO</div>
    <div class="leyenda">
        <div class="ley-item"><div class="ley-dot" style="background:#dcfce7;border:1px solid #16a34a;"></div> Bajo (1–4)</div>
        <div class="ley-item"><div class="ley-dot" style="background:#fef9c3;border:1px solid #ca8a04;"></div> Medio (5–9)</div>
        <div class="ley-item"><div class="ley-dot" style="background:#ffedd5;border:1px solid #ea580c;"></div> Alto (10–15)</div>
        <div class="ley-item"><div class="ley-dot" style="background:#fee2e2;border:1px solid #dc2626;"></div> Crítico (16–25)</div>
    </div>
</div>

<div class="panel">
    <div class="panel-header">
        <div class="panel-title"><i class="fas fa-exclamation-triangle"></i> Riesgos activos ordenados por criticidad</div>
        <span class="panel-subtitle">{{ $evaluaciones->count() }} evaluaciones</span>
    </div>
    @if($evaluaciones->count() > 0)
    <table class="table">
        <thead>
            <tr><th>Código</th><th>Activo</th><th>Amenaza</th><th style="text-align:center;">I</th><th style="text-align:center;">P</th><th style="text-align:center;">Valor</th><th>Nivel</th></tr>
        </thead>
        <tbody>
        @foreach($evaluaciones as $ev)
        <tr>
            <td><code class="tag">{{ $ev->codigo }}</code></td>
            <td>
                <div style="font-weight:500;">{{ $ev->activo->nombre ?? 'N/A' }}</div>
                <div style="font-size:11px;color:#94a3b8;">{{ $ev->activo->tipo ?? '' }}</div>
            </td>
            <td>{{ $ev->amenaza->nombre ?? 'N/A' }}</td>
            <td style="text-align:center;font-weight:600;">{{ $ev->impacto }}</td>
            <td style="text-align:center;font-weight:600;">{{ $ev->probabilidad }}</td>
            <td style="text-align:center;font-size:18px;font-weight:800;" class="c-{{ $ev->nivel_riesgo }}">{{ $ev->valor_riesgo }}</td>
            <td><span class="badge badge-{{ $ev->nivel_riesgo }}">{{ strtoupper($ev->nivel_riesgo) }}</span></td>
        </tr>
        @endforeach
        </tbody>
    </table>
    @else
    <div class="empty-state">
        <i class="fas fa-shield-alt"></i>
        <p>No hay evaluaciones activas. <a href="{{ route('evaluaciones.create') }}" style="color:#3b82f6;">Crear primera evaluación →</a></p>
    </div>
    @endif
</div>

@endsection

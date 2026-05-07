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

<div style="background:#fef2f2;border:1px solid #fecaca;border-radius:12px;margin-bottom:20px;overflow:hidden;">
    <div style="padding:13px 18px;display:flex;align-items:center;gap:10px;cursor:pointer;user-select:none;" onclick="var b=this.nextElementSibling;b.style.display=b.style.display==='none'?'':'none';this.querySelector('.gch').style.transform=b.style.display===''?'rotate(180deg)':''">
        <div style="width:34px;height:34px;border-radius:9px;background:#fee2e2;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
            <i class="fas fa-book-open" style="color:#dc2626;font-size:14px;"></i>
        </div>
        <div style="font-size:13px;font-weight:700;color:#b91c1c;flex:1;">¿Cómo interpretar la Matriz de Riesgos 5×5 de ISO 27001?</div>
        <span style="font-size:10px;font-weight:600;background:#fee2e2;color:#dc2626;padding:2px 9px;border-radius:20px;">ISO 27001 — Fase 4.4 · Evaluación del Riesgo</span>
        <i class="fas fa-chevron-up gch" style="color:#dc2626;font-size:11px;transition:transform .2s;transform:rotate(180deg);"></i>
    </div>
    <div style="padding:4px 18px 16px 18px;border-top:1px solid #fecaca;display:none;">
        <p style="font-size:12.5px;color:#991b1b;margin-bottom:12px;line-height:1.6;">
            La matriz de riesgos es la <strong>herramienta visual principal</strong> del SGSI. Cruza el eje de Impacto (cuánto daño causa) con el eje de Probabilidad (qué tan probable es), generando una cuadrícula de 5×5 = 25 celdas que clasifica cada riesgo en su nivel correspondiente.
        </p>
        <div style="display:flex;align-items:flex-start;gap:9px;margin-bottom:8px;font-size:12.5px;color:#374151;line-height:1.5;">
            <span style="min-width:22px;height:22px;border-radius:50%;background:#fee2e2;color:#dc2626;font-size:10px;font-weight:700;display:flex;align-items:center;justify-content:center;flex-shrink:0;margin-top:1px;">1</span>
            <div><strong>Eje Y (vertical) = Impacto:</strong> Cuánto daño causaría la amenaza al materializarse. Va de 1 (insignificante) a 5 (catastrófico para el negocio).</div>
        </div>
        <div style="display:flex;align-items:flex-start;gap:9px;margin-bottom:8px;font-size:12.5px;color:#374151;line-height:1.5;">
            <span style="min-width:22px;height:22px;border-radius:50%;background:#fee2e2;color:#dc2626;font-size:10px;font-weight:700;display:flex;align-items:center;justify-content:center;flex-shrink:0;margin-top:1px;">2</span>
            <div><strong>Eje X (horizontal) = Probabilidad:</strong> Qué tan probable es que la amenaza ocurra. Va de 1 (muy poco probable) a 5 (prácticamente seguro).</div>
        </div>
        <div style="display:flex;align-items:flex-start;gap:9px;margin-bottom:8px;font-size:12.5px;color:#374151;line-height:1.5;">
            <span style="min-width:22px;height:22px;border-radius:50%;background:#fee2e2;color:#dc2626;font-size:10px;font-weight:700;display:flex;align-items:center;justify-content:center;flex-shrink:0;margin-top:1px;">3</span>
            <div><strong>Cada celda muestra el número de riesgos</strong> que caen en esa combinación. Los colores indican el nivel: <span style="background:#fee2e2;color:#dc2626;padding:1px 7px;border-radius:8px;font-size:11px;font-weight:700;">CRÍTICO ≥16</span> <span style="background:#fff7ed;color:#ea580c;padding:1px 7px;border-radius:8px;font-size:11px;font-weight:700;">ALTO ≥10</span> <span style="background:#fefce8;color:#ca8a04;padding:1px 7px;border-radius:8px;font-size:11px;font-weight:700;">MEDIO ≥5</span> <span style="background:#f0fdf4;color:#16a34a;padding:1px 7px;border-radius:8px;font-size:11px;font-weight:700;">BAJO &lt;5</span></div>
        </div>
        <div style="display:flex;align-items:flex-start;gap:9px;margin-bottom:8px;font-size:12.5px;color:#374151;line-height:1.5;">
            <span style="min-width:22px;height:22px;border-radius:50%;background:#fee2e2;color:#dc2626;font-size:10px;font-weight:700;display:flex;align-items:center;justify-content:center;flex-shrink:0;margin-top:1px;">4</span>
            <div><strong>La zona roja (esquina superior derecha)</strong> concentra los riesgos más urgentes. ISO 27001 exige que la dirección fije un <em>umbral de riesgo aceptable</em> — todo lo que esté por encima requiere tratamiento.</div>
        </div>
        <div style="display:flex;align-items:flex-start;gap:9px;margin-bottom:8px;font-size:12.5px;color:#374151;line-height:1.5;">
            <span style="min-width:22px;height:22px;border-radius:50%;background:#fee2e2;color:#dc2626;font-size:10px;font-weight:700;display:flex;align-items:center;justify-content:center;flex-shrink:0;margin-top:1px;">5</span>
            <div><strong>El objetivo del SGSI</strong> es que con el tiempo, gracias a los planes de mitigación, los puntos migren hacia la zona verde (bajo impacto, baja probabilidad).</div>
        </div>
        <div style="margin-top:10px;padding:9px 13px;background:rgba(255,255,255,0.65);border-radius:8px;font-size:11.5px;color:#475569;display:flex;gap:8px;">
            <i class="fas fa-lightbulb" style="color:#f59e0b;flex-shrink:0;margin-top:1px;"></i>
            <span>Esta matriz se actualiza en tiempo real con las evaluaciones registradas. Para moverla hacia zonas más seguras, implementa los planes de mitigación del módulo correspondiente y reevalúa los riesgos periódicamente.</span>
        </div>
    </div>
</div>

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

@extends('reportes.layout')
@section('rpt-titulo', 'Evaluaciones de Riesgo')

@section('content')

@php
$porNivel = $evaluaciones->groupBy('nivel_riesgo');
@endphp

<div class="stats-row">
    <div class="stat-box sb-red"><div class="num">{{ $porNivel->get('critico',collect())->count() }}</div><div class="lbl">Crítico</div></div>
    <div class="stat-box sb-orange"><div class="num">{{ $porNivel->get('alto',collect())->count() }}</div><div class="lbl">Alto</div></div>
    <div class="stat-box sb-yellow"><div class="num">{{ $porNivel->get('medio',collect())->count() }}</div><div class="lbl">Medio</div></div>
    <div class="stat-box sb-green"><div class="num">{{ $porNivel->get('bajo',collect())->count() }}</div><div class="lbl">Bajo</div></div>
    <div class="stat-box sb-blue"><div class="num">{{ $evaluaciones->count() }}</div><div class="lbl">Total</div></div>
    <div class="stat-box sb-slate">
        <div class="num">{{ $evaluaciones->count() > 0 ? round($evaluaciones->avg('valor_riesgo'),1) : 0 }}</div>
        <div class="lbl">Valor Promedio</div>
    </div>
</div>

<div class="section-title">Detalle de Evaluaciones de Riesgo</div>
<table class="rpt">
    <thead>
        <tr>
            <th>#</th>
            <th>Código</th>
            <th>Activo TI</th>
            <th>Amenaza</th>
            <th>Impacto</th>
            <th>Probabilidad</th>
            <th>Valor</th>
            <th>Nivel</th>
            <th>Estado</th>
            <th>Evaluador</th>
            <th>Fecha</th>
            <th>Próx. Revisión</th>
        </tr>
    </thead>
    <tbody>
    @foreach($evaluaciones as $i => $ev)
    <tr>
        <td>{{ $i+1 }}</td>
        <td><strong>{{ $ev->codigo }}</strong></td>
        <td>{{ $ev->activo->nombre ?? '—' }}</td>
        <td style="font-size:9px;">{{ $ev->amenaza->nombre ?? '—' }}</td>
        <td style="text-align:center;">{{ $ev->impacto }}/5</td>
        <td style="text-align:center;">{{ $ev->probabilidad }}/5</td>
        <td style="text-align:center;font-weight:800;">{{ $ev->valor_riesgo }}</td>
        <td><span class="badge b-{{ $ev->nivel_riesgo }}">{{ strtoupper($ev->nivel_riesgo) }}</span></td>
        <td><span class="badge b-{{ $ev->estado }}">{{ strtoupper($ev->estado) }}</span></td>
        <td style="font-size:9px;">{{ $ev->evaluador->name ?? 'Sistema' }}</td>
        <td>{{ $ev->fecha_evaluacion->format('d/m/Y') }}</td>
        <td>{{ $ev->proxima_revision ? $ev->proxima_revision->format('d/m/Y') : '—' }}</td>
    </tr>
    @endforeach
    </tbody>
</table>

@endsection

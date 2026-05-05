@extends('reportes.layout')
@section('rpt-titulo', 'Reporte Ejecutivo')

@section('content')

{{-- KPIs --}}
<div class="stats-row">
    <div class="stat-box sb-blue"><div class="num">{{ $totalActivos }}</div><div class="lbl">Activos TI</div></div>
    <div class="stat-box sb-slate"><div class="num">{{ $totalAmenazas }}</div><div class="lbl">Amenazas Activas</div></div>
    <div class="stat-box sb-red"><div class="num">{{ $critico }}</div><div class="lbl">Riesgo Crítico</div></div>
    <div class="stat-box sb-orange"><div class="num">{{ $alto }}</div><div class="lbl">Riesgo Alto</div></div>
    <div class="stat-box sb-yellow"><div class="num">{{ $medio }}</div><div class="lbl">Riesgo Medio</div></div>
    <div class="stat-box sb-green"><div class="num">{{ $bajo }}</div><div class="lbl">Riesgo Bajo</div></div>
    <div class="stat-box sb-blue"><div class="num">{{ $totalPlanes }}</div><div class="lbl">Planes Mitigación</div></div>
</div>

{{-- Resumen planes por estado --}}
<div class="section-title">Estado de Planes de Mitigación</div>
<div class="stats-row">
    @foreach(['pendiente'=>['sb-slate','Pendiente'],'en_progreso'=>['sb-blue','En Progreso'],'completado'=>['sb-green','Completado'],'cancelado'=>['sb-red','Cancelado'],'vencido'=>['sb-orange','Vencido']] as $est=>$cfg)
    <div class="stat-box {{ $cfg[0] }}">
        <div class="num">{{ $planesEstado->get($est,0) }}</div>
        <div class="lbl">{{ $cfg[1] }}</div>
    </div>
    @endforeach
</div>

{{-- Top riesgos --}}
<div class="section-title">Top 10 Riesgos Activos (por valor)</div>
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
            <th>Fecha Evaluación</th>
        </tr>
    </thead>
    <tbody>
    @foreach($riesgosRecientes as $i => $ev)
    <tr>
        <td>{{ $i+1 }}</td>
        <td><strong>{{ $ev->codigo }}</strong></td>
        <td>{{ $ev->activo->nombre ?? '—' }}</td>
        <td>{{ $ev->amenaza->nombre ?? '—' }}</td>
        <td style="text-align:center;">{{ $ev->impacto }}/5</td>
        <td style="text-align:center;">{{ $ev->probabilidad }}/5</td>
        <td style="text-align:center;font-weight:800;font-size:13px;">{{ $ev->valor_riesgo }}</td>
        <td><span class="badge b-{{ $ev->nivel_riesgo }}">{{ strtoupper($ev->nivel_riesgo) }}</span></td>
        <td>{{ $ev->fecha_evaluacion->format('d/m/Y') }}</td>
    </tr>
    @endforeach
    </tbody>
</table>

<div class="note-box">
    Este reporte es de carácter confidencial y debe ser tratado de acuerdo con las políticas de seguridad de la información de la organización. Generado automáticamente por RiskGuard TI conforme a los lineamientos de la norma ISO/IEC 27001.
</div>

@endsection

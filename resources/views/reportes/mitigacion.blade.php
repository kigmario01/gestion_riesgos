@extends('reportes.layout')
@section('rpt-titulo', 'Planes de Mitigación')

@section('content')

@php
$porEstado = $planes->groupBy('estado');
@endphp

<div class="stats-row">
    <div class="stat-box sb-slate"><div class="num">{{ $porEstado->get('pendiente',collect())->count() }}</div><div class="lbl">Pendiente</div></div>
    <div class="stat-box sb-blue"><div class="num">{{ $porEstado->get('en_progreso',collect())->count() }}</div><div class="lbl">En Progreso</div></div>
    <div class="stat-box sb-green"><div class="num">{{ $porEstado->get('completado',collect())->count() }}</div><div class="lbl">Completado</div></div>
    <div class="stat-box sb-red"><div class="num">{{ $porEstado->get('cancelado',collect())->count() }}</div><div class="lbl">Cancelado</div></div>
    <div class="stat-box sb-orange"><div class="num">{{ $porEstado->get('vencido',collect())->count() }}</div><div class="lbl">Vencido</div></div>
    <div class="stat-box sb-yellow">
        <div class="num">{{ $planes->count() > 0 ? round($planes->avg('porcentaje_avance')) : 0 }}%</div>
        <div class="lbl">Avance Prom.</div>
    </div>
</div>

<div class="section-title">Detalle de Planes de Mitigación</div>
<table class="rpt">
    <thead>
        <tr>
            <th>#</th>
            <th>Código</th>
            <th>Título</th>
            <th>Activo / Riesgo</th>
            <th>Tipo Control</th>
            <th>Prioridad</th>
            <th>Estado</th>
            <th>Avance</th>
            <th>Responsable</th>
            <th>F. Inicio</th>
            <th>F. Límite</th>
        </tr>
    </thead>
    <tbody>
    @foreach($planes as $i => $plan)
    @php
        $isOverdue = $plan->fecha_limite < now() && $plan->estado !== 'completado';
        $progColor = match($plan->estado) {
            'completado'  => 'prog-green',
            'en_progreso' => 'prog-blue',
            'cancelado'   => 'prog-red',
            default       => 'prog-orange',
        };
    @endphp
    <tr>
        <td>{{ $i+1 }}</td>
        <td><strong>{{ $plan->codigo }}</strong></td>
        <td style="font-size:9.5px;">{{ \Illuminate\Support\Str::limit($plan->titulo, 40) }}</td>
        <td style="font-size:9px;">{{ $plan->evaluacion->activo->nombre ?? '—' }}</td>
        <td style="text-transform:capitalize;font-size:9px;">{{ $plan->tipo_control }}</td>
        <td><span class="badge b-{{ $plan->prioridad }}">{{ strtoupper($plan->prioridad) }}</span></td>
        <td><span class="badge b-{{ $plan->estado }}" style="{{ $isOverdue ? 'background:#fff7ed;color:#ea580c;' : '' }}">
            {{ strtoupper(str_replace('_',' ',$plan->estado)) }}{{ $isOverdue ? ' !' : '' }}
        </span></td>
        <td style="min-width:60px;">
            <div class="prog-wrap">
                <div class="prog-fill {{ $progColor }}" style="width:{{ $plan->porcentaje_avance }}%;"></div>
            </div>
            <div style="font-size:8px;text-align:right;color:#64748b;margin-top:1px;">{{ $plan->porcentaje_avance }}%</div>
        </td>
        <td style="font-size:9px;">{{ $plan->responsable }}</td>
        <td>{{ $plan->fecha_inicio->format('d/m/Y') }}</td>
        <td style="{{ $isOverdue ? 'color:#dc2626;font-weight:700;' : '' }}">{{ $plan->fecha_limite->format('d/m/Y') }}</td>
    </tr>
    @endforeach
    </tbody>
</table>

@endsection

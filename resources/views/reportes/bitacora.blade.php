@extends('reportes.layout')
@section('rpt-titulo', 'Bitácora de Auditoría')

@section('content')

@php
$porAccion = $logs->groupBy('accion');
@endphp

<div class="stats-row">
    <div class="stat-box sb-blue"><div class="num">{{ $logs->count() }}</div><div class="lbl">Registros (últimos 200)</div></div>
    <div class="stat-box sb-green"><div class="num">{{ $porAccion->get('crear',collect())->count() }}</div><div class="lbl">Creaciones</div></div>
    <div class="stat-box sb-yellow"><div class="num">{{ $porAccion->get('editar',collect())->count() }}</div><div class="lbl">Ediciones</div></div>
    <div class="stat-box sb-red"><div class="num">{{ $porAccion->get('eliminar',collect())->count() }}</div><div class="lbl">Eliminaciones</div></div>
    <div class="stat-box sb-slate">
        <div class="num">{{ $logs->unique('user_id')->count() }}</div>
        <div class="lbl">Usuarios únicos</div>
    </div>
</div>

<div class="section-title">Registro de Actividad del Sistema</div>
<table class="rpt">
    <thead>
        <tr>
            <th>#</th>
            <th>Fecha y Hora</th>
            <th>Usuario</th>
            <th>Acción</th>
            <th>Módulo</th>
            <th>Descripción</th>
            <th>IP</th>
        </tr>
    </thead>
    <tbody>
    @foreach($logs as $i => $log)
    @php
        $accionColor = match($log->accion) {
            'crear','calcular_riesgo','aprobar','respaldar' => '#16a34a',
            'editar','actualizar'                           => '#ca8a04',
            'eliminar'                                      => '#dc2626',
            'login','logout'                                => '#1d4ed8',
            default                                         => '#64748b',
        };
    @endphp
    <tr>
        <td>{{ $i+1 }}</td>
        <td style="white-space:nowrap;font-size:9px;">{{ $log->created_at->format('d/m/Y H:i:s') }}</td>
        <td style="font-size:9px;">{{ $log->user_nombre ?? $log->usuario?->name ?? '—' }}</td>
        <td><span style="background:#f8fafc;color:{{ $accionColor }};border:1px solid #e8eaf0;padding:2px 7px;border-radius:5px;font-size:9px;font-weight:700;white-space:nowrap;">
            {{ strtoupper(str_replace('_',' ',$log->accion)) }}
        </span></td>
        <td style="font-size:9px;color:#475569;">{{ str_replace('_',' ',ucfirst($log->modulo ?? '—')) }}</td>
        <td style="font-size:9px;color:#374151;">{{ \Illuminate\Support\Str::limit($log->descripcion ?? '—', 70) }}</td>
        <td style="font-size:9px;color:#94a3b8;">{{ $log->ip_address ?? '—' }}</td>
    </tr>
    @endforeach
    </tbody>
</table>

@endsection

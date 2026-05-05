@extends('reportes.layout')
@section('rpt-titulo', 'Inventario de Activos TI')

@section('content')

<div class="stats-row">
    @foreach(['critica'=>['sb-red','Crítica'],'alta'=>['sb-orange','Alta'],'media'=>['sb-yellow','Media'],'baja'=>['sb-green','Baja']] as $nivel=>$cfg)
    <div class="stat-box {{ $cfg[0] }}">
        <div class="num">{{ $activos->where('criticidad',$nivel)->count() }}</div>
        <div class="lbl">Criticidad {{ $cfg[1] }}</div>
    </div>
    @endforeach
    <div class="stat-box sb-blue"><div class="num">{{ $activos->where('estado','activo')->count() }}</div><div class="lbl">Activos</div></div>
    <div class="stat-box sb-slate"><div class="num">{{ $activos->count() }}</div><div class="lbl">Total</div></div>
</div>

<div class="section-title">Listado Completo de Activos TI</div>
<table class="rpt">
    <thead>
        <tr>
            <th>#</th>
            <th>Código</th>
            <th>Nombre</th>
            <th>Tipo</th>
            <th>Criticidad</th>
            <th>Estado</th>
            <th>Responsable</th>
            <th>Ubicación</th>
            <th>Valor Económico</th>
            <th>Registrado</th>
        </tr>
    </thead>
    <tbody>
    @foreach($activos as $i => $activo)
    <tr>
        <td>{{ $i+1 }}</td>
        <td><strong>{{ $activo->codigo }}</strong></td>
        <td>{{ $activo->nombre }}</td>
        <td style="text-transform:capitalize;">{{ $activo->tipo }}</td>
        <td><span class="badge b-{{ $activo->criticidad }}">{{ strtoupper($activo->criticidad) }}</span></td>
        <td><span class="badge b-{{ $activo->estado }}">{{ strtoupper($activo->estado) }}</span></td>
        <td>{{ $activo->responsable ?? '—' }}</td>
        <td>{{ $activo->ubicacion ?? '—' }}</td>
        <td>{{ $activo->valor_economico ? '$'.number_format($activo->valor_economico,2) : '—' }}</td>
        <td>{{ $activo->created_at->format('d/m/Y') }}</td>
    </tr>
    @endforeach
    </tbody>
</table>

@endsection

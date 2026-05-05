@extends('reportes.layout')
@section('rpt-titulo', 'Catálogo de Amenazas')

@section('content')

<div class="stats-row">
    @foreach(['accidental','deliberada','ambiental','tecnica','humana'] as $cat)
    <div class="stat-box sb-slate">
        <div class="num">{{ $amenazas->where('categoria',$cat)->count() }}</div>
        <div class="lbl">{{ ucfirst($cat) }}</div>
    </div>
    @endforeach
    <div class="stat-box sb-green">
        <div class="num">{{ $amenazas->where('estado','activa')->count() }}</div>
        <div class="lbl">Activas</div>
    </div>
</div>

<div class="section-title">Listado de Amenazas</div>
<table class="rpt">
    <thead>
        <tr>
            <th>#</th>
            <th>Código</th>
            <th>Nombre</th>
            <th>Categoría</th>
            <th>Origen</th>
            <th>Estado</th>
            <th>Descripción</th>
            <th>Registrada</th>
        </tr>
    </thead>
    <tbody>
    @foreach($amenazas as $i => $amenaza)
    <tr>
        <td>{{ $i+1 }}</td>
        <td><strong>{{ $amenaza->codigo }}</strong></td>
        <td>{{ $amenaza->nombre }}</td>
        <td><span class="badge b-{{ $amenaza->categoria }}">{{ ucfirst($amenaza->categoria) }}</span></td>
        <td style="text-transform:capitalize;">{{ $amenaza->origen ?? '—' }}</td>
        <td><span class="badge b-{{ $amenaza->estado }}">{{ strtoupper($amenaza->estado) }}</span></td>
        <td style="font-size:9px;color:#64748b;">{{ \Illuminate\Support\Str::limit($amenaza->descripcion ?? '—', 80) }}</td>
        <td>{{ $amenaza->created_at->format('d/m/Y') }}</td>
    </tr>
    @endforeach
    </tbody>
</table>

@endsection

@extends('layouts.main')

@section('title', 'Bitácora de Auditoría')

@section('topbar-left')
    <div class="topbar-icon"><i class="fas fa-clipboard-list"></i></div>
    <div class="topbar-title">Bitácora de Auditoría</div>
@endsection

@section('topbar-right')
    <span style="font-size:11.5px;color:#94a3b8;background:#f1f5f9;padding:4px 10px;border-radius:6px;">
        <i class="fas fa-lock" style="font-size:10px;margin-right:4px;"></i> Registro inmutable
    </span>
@endsection

@push('styles')
<style>
.accion-badge{display:inline-flex;align-items:center;padding:2px 8px;border-radius:4px;font-size:10px;font-weight:600;text-transform:uppercase;letter-spacing:0.5px;}
.a-crear{background:#f0fdf4;color:#16a34a;}.a-editar{background:#fefce8;color:#ca8a04;}.a-eliminar{background:#fef2f2;color:#dc2626;}
.a-login{background:#eff6ff;color:#1d4ed8;}.a-logout{background:#f8fafc;color:#64748b;}.a-calcular_riesgo{background:#fdf4ff;color:#9333ea;}
.a-aprobar{background:#f0fdf4;color:#16a34a;}.a-exportar{background:#fff7ed;color:#ea580c;}.a-login_fallido{background:#fef2f2;color:#dc2626;}
.a-descargar{background:#eff6ff;color:#1d4ed8;}.a-respaldo{background:#fdf4ff;color:#9333ea;}
.iso-badge{background:#eff6ff;color:#1d4ed8;padding:2px 8px;border-radius:4px;font-size:10px;font-weight:600;}
</style>
@endpush

@section('content')
<div class="panel">
    <div class="panel-header">
        <div class="panel-title">
            <i class="fas fa-shield-alt"></i> Log de Auditoría del Sistema
            <span class="iso-badge">ISO 27001</span>
        </div>
        <span class="panel-subtitle">Total: {{ $logs->total() }} registros</span>
    </div>

    <form method="GET" action="{{ route('bitacora.index') }}">
        <div class="filter-bar">
            <input type="text" name="buscar" class="filter-input" placeholder="🔍 Buscar usuario, descripción..." value="{{ request('buscar') }}" style="flex:1;min-width:180px;">
            <select name="accion" class="filter-input">
                <option value="">Todas las acciones</option>
                @foreach(['login','logout','login_fallido','crear','editar','eliminar','calcular_riesgo','aprobar','exportar','descargar','respaldo'] as $ac)
                <option value="{{ $ac }}" {{ request('accion') == $ac ? 'selected' : '' }}>{{ ucfirst(str_replace('_',' ',$ac)) }}</option>
                @endforeach
            </select>
            <select name="modulo" class="filter-input">
                <option value="">Todos los módulos</option>
                @foreach(['activos_ti','amenazas','evaluaciones_riesgo','planes_mitigacion','users','respaldos_bd'] as $mod)
                <option value="{{ $mod }}" {{ request('modulo') == $mod ? 'selected' : '' }}>{{ ucfirst(str_replace('_',' ',$mod)) }}</option>
                @endforeach
            </select>
            <button type="submit" class="btn btn-primary btn-sm"><i class="fas fa-filter"></i> Filtrar</button>
            @if(request()->hasAny(['buscar','accion','modulo']))
            <a href="{{ route('bitacora.index') }}" class="btn btn-outline btn-sm"><i class="fas fa-times"></i> Limpiar</a>
            @endif
        </div>
    </form>

    @if($logs->count() > 0)
    <table class="table">
        <thead>
            <tr>
                <th>Fecha / Hora</th>
                <th>Usuario</th>
                <th>Acción</th>
                <th>Módulo</th>
                <th>Descripción</th>
                <th>IP</th>
            </tr>
        </thead>
        <tbody>
        @foreach($logs as $log)
        <tr>
            <td style="font-size:11px;color:#64748b;white-space:nowrap;">{{ \Carbon\Carbon::parse($log->created_at)->format('d/m/Y H:i:s') }}</td>
            <td>
                <div style="font-weight:500;font-size:12.5px;">{{ $log->user_nombre ?? 'Sistema' }}</div>
            </td>
            <td><span class="accion-badge a-{{ $log->accion }}">{{ str_replace('_',' ',$log->accion) }}</span></td>
            <td style="font-size:11px;color:#64748b;">{{ str_replace('_',' ',$log->modulo) }}</td>
            <td style="max-width:300px;">{{ $log->descripcion }}</td>
            <td style="font-size:11px;color:#94a3b8;">{{ $log->ip_address ?? '—' }}</td>
        </tr>
        @endforeach
        </tbody>
    </table>
    <div style="padding:14px 18px;">{{ $logs->links() }}</div>
    @else
    <div class="empty-state">
        <i class="fas fa-clipboard"></i>
        <p>No hay registros en la bitácora aún.</p>
    </div>
    @endif
</div>
@endsection

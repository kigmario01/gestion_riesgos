@extends('layouts.main')

@section('title', 'Respaldo de Base de Datos')

@section('topbar-left')
    <div class="topbar-icon"><i class="fas fa-database"></i></div>
    <div class="topbar-title">Respaldo de Base de Datos</div>
@endsection

@section('topbar-right')
    <form method="POST" action="{{ route('respaldos.store') }}" id="backupForm">
        @csrf
        <button type="submit" class="btn btn-primary btn-sm" onclick="return confirm('¿Generar nuevo respaldo ahora?')">
            <i class="fas fa-download"></i> Generar Respaldo
        </button>
    </form>
@endsection

@push('styles')
<style>
.stats-row{display:grid;grid-template-columns:repeat(3,1fr);gap:16px;margin-bottom:20px;}
.stat-box{background:#fff;border-radius:12px;border:1px solid #e2e8f0;padding:18px 20px;display:flex;align-items:center;gap:14px;}
.stat-icon{width:44px;height:44px;border-radius:10px;display:flex;align-items:center;justify-content:center;font-size:18px;flex-shrink:0;}
.stat-icon.blue{background:#eff6ff;color:#3b82f6;}
.stat-icon.green{background:#f0fdf4;color:#16a34a;}
.stat-icon.slate{background:#f8fafc;color:#64748b;}
.stat-num{font-size:24px;font-weight:700;color:#1e293b;}
.stat-lbl{font-size:11px;color:#94a3b8;margin-top:2px;}
.size-badge{background:#f8fafc;color:#475569;border:1px solid #e2e8f0;padding:2px 8px;border-radius:6px;font-size:11px;font-weight:600;}
</style>
@endpush

@section('content')

<div class="stats-row">
    <div class="stat-box">
        <div class="stat-icon blue"><i class="fas fa-database"></i></div>
        <div>
            <div class="stat-num">{{ $totalRespaldos }}</div>
            <div class="stat-lbl">Total de respaldos</div>
        </div>
    </div>
    <div class="stat-box">
        <div class="stat-icon green"><i class="fas fa-check-circle"></i></div>
        <div>
            <div class="stat-num">{{ $exitosos }}</div>
            <div class="stat-lbl">Exitosos</div>
        </div>
    </div>
    <div class="stat-box">
        <div class="stat-icon slate"><i class="fas fa-clock"></i></div>
        <div>
            <div class="stat-num" style="font-size:14px;font-weight:600;">
                {{ $ultimoRespaldo ? $ultimoRespaldo->created_at->format('d/m/Y H:i') : 'Nunca' }}
            </div>
            <div class="stat-lbl">Último respaldo</div>
        </div>
    </div>
</div>

<div class="panel">
    <div class="panel-header">
        <div class="panel-title"><i class="fas fa-list"></i> Historial de Respaldos</div>
        <span class="panel-subtitle">{{ $respaldos->total() }} registros</span>
    </div>

    @if($respaldos->count() > 0)
    <table class="table">
        <thead>
            <tr>
                <th>Archivo</th>
                <th>Tipo</th>
                <th>Tamaño</th>
                <th>Estado</th>
                <th>Generado por</th>
                <th>Fecha</th>
                <th>Notas</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
        @foreach($respaldos as $respaldo)
        <tr>
            <td>
                <div style="font-weight:500;font-size:12.5px;font-family:monospace;">{{ $respaldo->nombre_archivo }}</div>
            </td>
            <td><span class="badge badge-{{ $respaldo->tipo }}">{{ strtoupper($respaldo->tipo) }}</span></td>
            <td><span class="size-badge">{{ $respaldo->tamanio_formateado }}</span></td>
            <td>
                @if(in_array($respaldo->estado, ['exitoso', 'completado']))
                <span class="badge badge-activo"><i class="fas fa-check" style="font-size:9px;"></i> EXITOSO</span>
                @elseif($respaldo->estado === 'fallido')
                <span class="badge badge-inactivo"><i class="fas fa-times" style="font-size:9px;"></i> FALLIDO</span>
                @else
                <span class="badge badge-en_progreso">{{ strtoupper($respaldo->estado) }}</span>
                @endif
            </td>
            <td style="font-size:12px;">{{ $respaldo->generador->name ?? 'Sistema' }}</td>
            <td style="font-size:12px;color:#64748b;white-space:nowrap;">{{ $respaldo->created_at->format('d/m/Y H:i') }}</td>
            <td style="font-size:11px;color:#94a3b8;max-width:180px;">{{ $respaldo->notas ? Str::limit($respaldo->notas, 45) : '—' }}</td>
            <td>
                <div class="actions">
                    @if(in_array($respaldo->estado, ['exitoso', 'completado']))
                    <a href="{{ route('respaldos.download', $respaldo) }}" class="btn btn-outline btn-xs" title="Descargar">
                        <i class="fas fa-download"></i>
                    </a>
                    @endif
                    <form method="POST" action="{{ route('respaldos.destroy', $respaldo) }}" onsubmit="return confirm('¿Eliminar este respaldo permanentemente?')">
                        @csrf @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-xs" title="Eliminar"><i class="fas fa-trash"></i></button>
                    </form>
                </div>
            </td>
        </tr>
        @endforeach
        </tbody>
    </table>
    <div style="padding:14px 18px;">{{ $respaldos->links() }}</div>
    @else
    <div class="empty-state">
        <i class="fas fa-database"></i>
        <p>No hay respaldos generados aún.</p>
        <form method="POST" action="{{ route('respaldos.store') }}" style="display:inline;">
            @csrf
            <button type="submit" class="btn btn-primary"><i class="fas fa-download"></i> Generar primer respaldo</button>
        </form>
    </div>
    @endif
</div>

<div class="panel">
    <div class="panel-header">
        <div class="panel-title"><i class="fas fa-info-circle"></i> Información del Sistema de Respaldos</div>
    </div>
    <div style="padding:16px 20px;display:grid;grid-template-columns:1fr 1fr;gap:16px;font-size:13px;color:#374151;">
        <div>
            <div style="font-size:10.5px;font-weight:600;color:#94a3b8;text-transform:uppercase;letter-spacing:0.7px;margin-bottom:6px;">Motor de respaldo</div>
            <div><code class="tag">PDO dump</code> (PostgreSQL compatible)</div>
        </div>
        <div>
            <div style="font-size:10.5px;font-weight:600;color:#94a3b8;text-transform:uppercase;letter-spacing:0.7px;margin-bottom:6px;">Ubicación de archivos</div>
            <div><code class="tag">storage/app/backups/</code></div>
        </div>
        <div>
            <div style="font-size:10.5px;font-weight:600;color:#94a3b8;text-transform:uppercase;letter-spacing:0.7px;margin-bottom:6px;">Base de datos</div>
            <div><code class="tag">{{ config('database.connections.' . config('database.default') . '.database') }}</code></div>
        </div>
        <div>
            <div style="font-size:10.5px;font-weight:600;color:#94a3b8;text-transform:uppercase;letter-spacing:0.7px;margin-bottom:6px;">Respaldo automático</div>
            <div><code class="tag">Diario</code> a medianoche (Colombia)</div>
        </div>
    </div>
</div>

@endsection

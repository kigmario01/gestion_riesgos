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

<div style="background:#f8fafc;border:1px solid #e2e8f0;border-radius:12px;margin-bottom:20px;overflow:hidden;">
    <div style="padding:13px 18px;display:flex;align-items:center;gap:10px;cursor:pointer;user-select:none;" onclick="var b=this.nextElementSibling;b.style.display=b.style.display==='none'?'':'none';this.querySelector('.gch').style.transform=b.style.display===''?'rotate(180deg)':''">
        <div style="width:34px;height:34px;border-radius:9px;background:#f1f5f9;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
            <i class="fas fa-book-open" style="color:#475569;font-size:14px;"></i>
        </div>
        <div style="font-size:13px;font-weight:700;color:#334155;flex:1;">¿Qué es la Bitácora de Auditoría y por qué es obligatoria en ISO 27001?</div>
        <span style="font-size:10px;font-weight:600;background:#f1f5f9;color:#475569;padding:2px 9px;border-radius:20px;">ISO 27001 — Cláusula 9.1 · Seguimiento y Medición</span>
        <i class="fas fa-chevron-up gch" style="color:#475569;font-size:11px;transition:transform .2s;"></i>
    </div>
    <div style="padding:4px 18px 16px 18px;border-top:1px solid #e2e8f0;">
        <p style="font-size:12.5px;color:#334155;margin-bottom:12px;line-height:1.6;">
            La bitácora es el <strong>registro inmutable de todas las acciones</strong> realizadas en el sistema. ISO 27001 (cláusula 9.1) exige mantener evidencia de que el SGSI está siendo monitoreado y controlado. Este registro es la principal fuente de evidencia en una auditoría.
        </p>
        <div style="display:flex;align-items:flex-start;gap:9px;margin-bottom:8px;font-size:12.5px;color:#374151;line-height:1.5;">
            <span style="min-width:22px;height:22px;border-radius:50%;background:#f1f5f9;color:#475569;font-size:10px;font-weight:700;display:flex;align-items:center;justify-content:center;flex-shrink:0;margin-top:1px;">1</span>
            <div><strong>Trazabilidad completa:</strong> Cada creación, edición, eliminación y aprobación queda registrada con el usuario, la fecha, la hora y la dirección IP. Nadie puede actuar sin dejar huella.</div>
        </div>
        <div style="display:flex;align-items:flex-start;gap:9px;margin-bottom:8px;font-size:12.5px;color:#374151;line-height:1.5;">
            <span style="min-width:22px;height:22px;border-radius:50%;background:#f1f5f9;color:#475569;font-size:10px;font-weight:700;display:flex;align-items:center;justify-content:center;flex-shrink:0;margin-top:1px;">2</span>
            <div><strong>Detección de anomalías:</strong> Múltiples eliminaciones en poco tiempo, accesos fuera de horario o cambios en roles de seguridad son señales de alerta que debes monitorear aquí.</div>
        </div>
        <div style="display:flex;align-items:flex-start;gap:9px;margin-bottom:8px;font-size:12.5px;color:#374151;line-height:1.5;">
            <span style="min-width:22px;height:22px;border-radius:50%;background:#f1f5f9;color:#475569;font-size:10px;font-weight:700;display:flex;align-items:center;justify-content:center;flex-shrink:0;margin-top:1px;">3</span>
            <div><strong>Evidencia ante incidentes:</strong> Si ocurre una brecha de seguridad, la bitácora permite reconstruir la línea de tiempo de lo que pasó, quién lo hizo y qué datos fueron afectados.</div>
        </div>
        <div style="display:flex;align-items:flex-start;gap:9px;margin-bottom:8px;font-size:12.5px;color:#374151;line-height:1.5;">
            <span style="min-width:22px;height:22px;border-radius:50%;background:#f1f5f9;color:#475569;font-size:10px;font-weight:700;display:flex;align-items:center;justify-content:center;flex-shrink:0;margin-top:1px;">4</span>
            <div><strong>Revisión periódica obligatoria:</strong> ISO 27001 requiere que el responsable de seguridad revise la bitácora regularmente (al menos mensualmente) y documente que lo hizo. El reporte PDF de bitácora sirve como evidencia de esta revisión.</div>
        </div>
        <div style="margin-top:10px;padding:9px 13px;background:rgba(255,255,255,0.65);border-radius:8px;font-size:11.5px;color:#475569;display:flex;gap:8px;">
            <i class="fas fa-lightbulb" style="color:#f59e0b;flex-shrink:0;margin-top:1px;"></i>
            <span>Los registros de esta bitácora <strong>no pueden ser eliminados ni modificados</strong> por ningún usuario del sistema, garantizando la integridad de la evidencia. Usa el filtro por acción o módulo para revisar actividad específica, y genera el reporte PDF para presentar en auditorías.</span>
        </div>
    </div>
</div>

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

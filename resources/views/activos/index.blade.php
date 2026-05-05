@extends('layouts.main')

@section('title', 'Activos TI')

@section('topbar-left')
    <div class="topbar-icon"><i class="fas fa-server"></i></div>
    <div class="topbar-title">Activos TI</div>
@endsection

@section('topbar-right')
    @can('activos.crear')<a href="{{ route('activos.create') }}" class="btn btn-primary btn-sm"><i class="fas fa-plus"></i> Nuevo Activo</a>@endcan
@endsection

@push('styles')
<style>
.activo-tipo-icon { width:44px;height:44px;border-radius:11px;display:flex;align-items:center;justify-content:center;font-size:17px;flex-shrink:0; }
.at-hardware    { background:#eff6ff;color:#3b82f6; }
.at-software    { background:#f5f3ff;color:#7c3aed; }
.at-red         { background:#fff7ed;color:#f97316; }
.at-datos       { background:#fdf4ff;color:#9333ea; }
.at-servicios   { background:#ecfeff;color:#0891b2; }
.at-personas    { background:#f0fdf4;color:#16a34a; }
.at-instalaciones { background:#fef2f2;color:#dc2626; }
.activo-stripe { height:3px; }
.stripe-critica { background:linear-gradient(90deg,#ef4444,#dc2626); }
.stripe-alta    { background:linear-gradient(90deg,#f97316,#ea580c); }
.stripe-media   { background:linear-gradient(90deg,#eab308,#ca8a04); }
.stripe-baja    { background:linear-gradient(90deg,#22c55e,#16a34a); }
</style>
@endpush

@push('styles')
<style>
.guia-iso{background:#eff6ff;border:1px solid #bfdbfe;border-radius:12px;margin-bottom:20px;overflow:hidden;}
.guia-iso-header{padding:13px 18px;display:flex;align-items:center;gap:10px;cursor:pointer;user-select:none;}
.guia-iso-header:hover{background:rgba(255,255,255,0.4);}
.guia-iso-icon{width:34px;height:34px;border-radius:9px;background:#dbeafe;display:flex;align-items:center;justify-content:center;flex-shrink:0;}
.guia-iso-title{font-size:13px;font-weight:700;color:#1d4ed8;flex:1;}
.guia-iso-ref{font-size:10px;font-weight:600;background:#dbeafe;color:#3b82f6;padding:2px 9px;border-radius:20px;}
.guia-iso-body{padding:4px 18px 16px 18px;border-top:1px solid #bfdbfe;}
.guia-paso{display:flex;align-items:flex-start;gap:9px;margin-bottom:8px;font-size:12.5px;color:#374151;line-height:1.5;}
.guia-num{min-width:22px;height:22px;border-radius:50%;background:#dbeafe;color:#3b82f6;font-size:10px;font-weight:700;display:flex;align-items:center;justify-content:center;flex-shrink:0;margin-top:1px;}
.guia-nota{margin-top:10px;padding:9px 13px;background:rgba(255,255,255,0.65);border-radius:8px;font-size:11.5px;color:#475569;display:flex;gap:8px;}
</style>
@endpush

@section('content')

<div class="guia-iso">
    <div class="guia-iso-header" onclick="this.nextElementSibling.style.display=this.nextElementSibling.style.display==='none'?'':'none'; this.querySelector('.guia-chevron').style.transform=this.nextElementSibling.style.display===''?'rotate(180deg)':''">
        <div class="guia-iso-icon"><i class="fas fa-book-open" style="color:#3b82f6;font-size:14px;"></i></div>
        <div class="guia-iso-title">¿Qué es el Inventario de Activos TI y por qué es importante?</div>
        <span class="guia-iso-ref">ISO 27001 — Fase 4.1</span>
        <i class="fas fa-chevron-up guia-chevron" style="color:#3b82f6;font-size:11px;transition:transform .2s;"></i>
    </div>
    <div class="guia-iso-body">
        <p style="font-size:12.5px;color:#1e40af;margin-bottom:12px;line-height:1.6;">
            El inventario de activos es el <strong>punto de partida del SGSI</strong>. No puedes proteger lo que no conoces. ISO 27001 exige identificar todos los activos de información de la organización, clasificarlos y asignarles un responsable.
        </p>
        <div class="guia-paso"><div class="guia-num">1</div><div><strong>Identifica</strong> todos los recursos de la organización: servidores, aplicaciones, bases de datos, redes, personas clave, instalaciones físicas y servicios contratados.</div></div>
        <div class="guia-paso"><div class="guia-num">2</div><div><strong>Clasifica el tipo</strong> de activo: Hardware, Software, Red, Datos, Servicios, Personas o Instalaciones. Esto determina qué controles aplican.</div></div>
        <div class="guia-paso"><div class="guia-num">3</div><div><strong>Asigna la criticidad</strong> según el impacto si ese activo fallara: Baja (interrupción mínima) → Media → Alta → Crítica (parada total del negocio).</div></div>
        <div class="guia-paso"><div class="guia-num">4</div><div><strong>Designa un responsable</strong> (propietario del activo) que será quien tome decisiones sobre él y responda ante incidentes.</div></div>
        <div class="guia-paso"><div class="guia-num">5</div><div><strong>Mantén actualizado</strong> el inventario. Un activo que sale de producción o cambia de responsable debe actualizarse de inmediato.</div></div>
        <div class="guia-nota">
            <i class="fas fa-lightbulb" style="color:#f59e0b;flex-shrink:0;margin-top:1px;"></i>
            <span>Las evaluaciones de riesgo del siguiente módulo usan estos activos como base. Sin un inventario completo, el análisis de riesgos estará incompleto. Empieza por los activos más críticos para el negocio.</span>
        </div>
    </div>
</div>

@php
    $tipoIcon = [
        'hardware'=>['icon'=>'fa-microchip','cls'=>'at-hardware'],
        'software'=>['icon'=>'fa-code','cls'=>'at-software'],
        'red'=>['icon'=>'fa-network-wired','cls'=>'at-red'],
        'datos'=>['icon'=>'fa-database','cls'=>'at-datos'],
        'servicios'=>['icon'=>'fa-cloud','cls'=>'at-servicios'],
        'personas'=>['icon'=>'fa-users','cls'=>'at-personas'],
        'instalaciones'=>['icon'=>'fa-building','cls'=>'at-instalaciones'],
    ];
    $critColors = ['critica'=>'badge-critica','alta'=>'badge-alta','media'=>'badge-media','baja'=>'badge-baja'];
    $critDot    = ['critica'=>'#ef4444','alta'=>'#f97316','media'=>'#eab308','baja'=>'#22c55e'];
@endphp

{{-- Filter tabs --}}
<div class="filter-tabs">
    <button class="filter-tab active" onclick="filterActivos('all','tipo', this)">
        Todos <span class="tab-count">{{ $activos->total() }}</span>
    </button>
    @foreach(['hardware','software','red','datos','servicios','personas','instalaciones'] as $t)
    <button class="filter-tab" onclick="filterActivos('{{ $t }}','tipo', this)" style="text-transform:capitalize;">
        <i class="fas {{ $tipoIcon[$t]['icon'] ?? 'fa-box' }}" style="font-size:10px;"></i>
        {{ ucfirst($t) }}
    </button>
    @endforeach
</div>

@if($activos->count() > 0)
<div class="card-grid" id="activosGrid">
    @foreach($activos as $activo)
    @php
        $ti = $tipoIcon[$activo->tipo] ?? ['icon'=>'fa-box','cls'=>'at-hardware'];
        $stripeCls = 'stripe-'.$activo->criticidad;
    @endphp
    <div class="item-card" data-tipo="{{ $activo->tipo }}" data-criticidad="{{ $activo->criticidad }}">
        <div class="activo-stripe {{ $stripeCls }}"></div>
        <div class="item-card-header">
            <div class="activo-tipo-icon {{ $ti['cls'] }}">
                <i class="fas {{ $ti['icon'] }}"></i>
            </div>
            <div style="min-width:0;">
                <div class="item-card-name" style="white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">{{ $activo->nombre }}</div>
                <div class="item-card-sub">
                    <code class="tag" style="font-size:10px;">{{ $activo->codigo }}</code>
                    &nbsp;·&nbsp;
                    <span style="text-transform:capitalize;">{{ $activo->tipo }}</span>
                </div>
            </div>
            <div style="margin-left:auto;flex-shrink:0;">
                <span class="badge {{ $critColors[$activo->criticidad] ?? '' }}">
                    <span class="badge-dot" style="background:{{ $critDot[$activo->criticidad] ?? '#94a3b8' }};"></span>
                    {{ strtoupper($activo->criticidad) }}
                </span>
            </div>
        </div>

        <div class="item-card-body">
            @if($activo->descripcion)
            <div style="font-size:12px;color:#64748b;line-height:1.5;margin-bottom:10px;">
                {{ Str::limit($activo->descripcion, 80) }}
            </div>
            @endif
            <div style="display:grid;grid-template-columns:1fr 1fr;gap:8px;font-size:11.5px;">
                <div>
                    <div style="font-size:10px;font-weight:600;color:#94a3b8;text-transform:uppercase;letter-spacing:.5px;margin-bottom:2px;">Responsable</div>
                    <div style="color:#374151;font-weight:500;">{{ $activo->responsable ?? '—' }}</div>
                </div>
                <div>
                    <div style="font-size:10px;font-weight:600;color:#94a3b8;text-transform:uppercase;letter-spacing:.5px;margin-bottom:2px;">Estado</div>
                    <span class="badge badge-{{ $activo->estado }}" style="font-size:10px;">{{ strtoupper(str_replace('_',' ',$activo->estado)) }}</span>
                </div>
                <div>
                    <div style="font-size:10px;font-weight:600;color:#94a3b8;text-transform:uppercase;letter-spacing:.5px;margin-bottom:2px;">Registrado por</div>
                    <div style="color:#374151;">{{ $activo->registrador->name ?? '—' }}</div>
                </div>
                @if($activo->ubicacion)
                <div>
                    <div style="font-size:10px;font-weight:600;color:#94a3b8;text-transform:uppercase;letter-spacing:.5px;margin-bottom:2px;">Ubicación</div>
                    <div style="color:#374151;">{{ Str::limit($activo->ubicacion, 24) }}</div>
                </div>
                @endif
            </div>
        </div>

        <div class="item-card-footer">
            <span style="font-size:11px;color:#94a3b8;">
                <i class="fas fa-calendar" style="font-size:9px;"></i>
                {{ $activo->created_at->format('d/m/Y') }}
            </span>
            <div class="actions">
                <a href="{{ route('activos.show', $activo) }}" class="btn btn-outline btn-xs" title="Ver detalle"><i class="fas fa-eye"></i></a>
                @can('activos.editar')<a href="{{ route('activos.edit', $activo) }}" class="btn btn-outline btn-xs" title="Editar"><i class="fas fa-edit"></i></a>@endcan
                @can('activos.eliminar')
                <form method="POST" action="{{ route('activos.destroy', $activo) }}" onsubmit="return confirm('¿Eliminar este activo?')">
                    @csrf @method('DELETE')
                    <button type="submit" class="btn btn-danger btn-xs" title="Eliminar"><i class="fas fa-trash"></i></button>
                </form>
                @endcan
            </div>
        </div>
    </div>
    @endforeach
</div>

<div style="padding:14px 4px;display:flex;align-items:center;justify-content:space-between;">
    <span style="font-size:12px;color:#94a3b8;">{{ $activos->total() }} activo(s) en total</span>
    {{ $activos->links() }}
</div>
@else
<div class="empty-state">
    <i class="fas fa-server"></i>
    <p>No hay activos TI registrados aún.</p>
    <a href="{{ route('activos.create') }}" class="btn btn-primary"><i class="fas fa-plus"></i> Registrar primer activo</a>
</div>
@endif

@endsection

@push('scripts')
<script>
function filterActivos(val, field, btn) {
    document.querySelectorAll('.filter-tab').forEach(t =>
        t.classList.remove('active','active-red','active-orange','active-yellow','active-green')
    );
    btn.classList.add('active');

    document.querySelectorAll('#activosGrid .item-card').forEach(card => {
        card.style.display = (val === 'all' || card.dataset[field] === val) ? '' : 'none';
    });
}
</script>
@endpush

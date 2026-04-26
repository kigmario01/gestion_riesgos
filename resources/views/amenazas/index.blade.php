@extends('layouts.main')

@section('title', 'Amenazas')

@section('topbar-left')
    <div class="topbar-icon"><i class="fas fa-biohazard"></i></div>
    <div class="topbar-title">Amenazas</div>
@endsection

@section('topbar-right')
    <a href="{{ route('amenazas.create') }}" class="btn btn-primary btn-sm"><i class="fas fa-plus"></i> Nueva Amenaza</a>
@endsection

@push('styles')
<style>
.amenaza-icon { width:44px;height:44px;border-radius:11px;display:flex;align-items:center;justify-content:center;font-size:17px;flex-shrink:0; }
.ai-accidental { background:#eff6ff;color:#3b82f6; }
.ai-deliberada { background:#fef2f2;color:#dc2626; }
.ai-ambiental  { background:#f0fdf4;color:#16a34a; }
.ai-tecnica    { background:#fefce8;color:#ca8a04; }
.ai-humana     { background:#fdf4ff;color:#9333ea; }
.amenaza-stripe { height:3px; }
.asm-accidental { background:linear-gradient(90deg,#3b82f6,#1d4ed8); }
.asm-deliberada { background:linear-gradient(90deg,#ef4444,#dc2626); }
.asm-ambiental  { background:linear-gradient(90deg,#22c55e,#16a34a); }
.asm-tecnica    { background:linear-gradient(90deg,#eab308,#ca8a04); }
.asm-humana     { background:linear-gradient(90deg,#9333ea,#7c3aed); }
</style>
@endpush

@section('content')

@php
    $catIcon = [
        'accidental' => ['icon'=>'fa-bolt','cls'=>'ai-accidental'],
        'deliberada' => ['icon'=>'fa-user-secret','cls'=>'ai-deliberada'],
        'ambiental'  => ['icon'=>'fa-leaf','cls'=>'ai-ambiental'],
        'tecnica'    => ['icon'=>'fa-cogs','cls'=>'ai-tecnica'],
        'humana'     => ['icon'=>'fa-user-times','cls'=>'ai-humana'],
    ];
@endphp

{{-- Filter tabs --}}
<div class="filter-tabs">
    <button class="filter-tab active" onclick="filterAmenazas('all', this)">
        Todos <span class="tab-count">{{ $amenazas->total() }}</span>
    </button>
    @foreach(['accidental','deliberada','ambiental','tecnica','humana'] as $cat)
    <button class="filter-tab" onclick="filterAmenazas('{{ $cat }}', this)">
        <i class="fas {{ $catIcon[$cat]['icon'] }}" style="font-size:10px;"></i>
        {{ ucfirst($cat) }}
    </button>
    @endforeach
    <button class="filter-tab" onclick="filterEstado('activa', this)" style="margin-left:auto;">
        <span style="width:7px;height:7px;border-radius:50%;background:#22c55e;display:inline-block;"></span>
        Solo activas
    </button>
</div>

@if($amenazas->count() > 0)
<div class="card-grid" id="amenazasGrid">
    @foreach($amenazas as $amenaza)
    @php
        $ci = $catIcon[$amenaza->categoria] ?? ['icon'=>'fa-biohazard','cls'=>'ai-accidental'];
        $stripeCls = 'asm-'.($amenaza->categoria);
    @endphp
    <div class="item-card" data-cat="{{ $amenaza->categoria }}" data-estado="{{ $amenaza->estado }}">
        <div class="amenaza-stripe {{ $stripeCls }}"></div>
        <div class="item-card-header">
            <div class="amenaza-icon {{ $ci['cls'] }}">
                <i class="fas {{ $ci['icon'] }}"></i>
            </div>
            <div style="min-width:0;flex:1;">
                <div class="item-card-name" style="white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">{{ $amenaza->nombre }}</div>
                <div class="item-card-sub">
                    <code class="tag" style="font-size:10px;">{{ $amenaza->codigo }}</code>
                </div>
            </div>
            <span class="badge badge-{{ $amenaza->estado }}" style="font-size:10px;flex-shrink:0;">{{ strtoupper($amenaza->estado) }}</span>
        </div>

        <div class="item-card-body">
            @if($amenaza->descripcion)
            <div style="font-size:12px;color:#64748b;line-height:1.5;margin-bottom:10px;">
                {{ Str::limit($amenaza->descripcion, 90) }}
            </div>
            @endif
            <div style="display:flex;gap:6px;flex-wrap:wrap;">
                <span class="badge badge-{{ $amenaza->categoria }}" style="font-size:10.5px;">
                    <i class="fas {{ $ci['icon'] }}" style="font-size:9px;"></i>
                    {{ ucfirst($amenaza->categoria) }}
                </span>
                <span class="badge badge-{{ $amenaza->origen }}" style="font-size:10.5px;">
                    {{ ucfirst($amenaza->origen) }}
                </span>
            </div>
        </div>

        <div class="item-card-footer">
            <span style="font-size:11px;color:#94a3b8;">
                <i class="fas fa-calendar" style="font-size:9px;"></i>
                {{ $amenaza->created_at->format('d/m/Y') }}
            </span>
            <div class="actions">
                <a href="{{ route('amenazas.edit', $amenaza) }}" class="btn btn-outline btn-xs" title="Editar">
                    <i class="fas fa-edit"></i>
                </a>
                <form method="POST" action="{{ route('amenazas.destroy', $amenaza) }}" onsubmit="return confirm('¿Eliminar esta amenaza?')">
                    @csrf @method('DELETE')
                    <button type="submit" class="btn btn-danger btn-xs" title="Eliminar"><i class="fas fa-trash"></i></button>
                </form>
            </div>
        </div>
    </div>
    @endforeach
</div>

<div style="padding:14px 4px;display:flex;align-items:center;justify-content:space-between;">
    <span style="font-size:12px;color:#94a3b8;">{{ $amenazas->total() }} amenaza(s) en total</span>
    {{ $amenazas->links() }}
</div>
@else
<div class="empty-state">
    <i class="fas fa-biohazard"></i>
    <p>No hay amenazas registradas.</p>
    <a href="{{ route('amenazas.create') }}" class="btn btn-primary"><i class="fas fa-plus"></i> Registrar primera amenaza</a>
</div>
@endif

@endsection

@push('scripts')
<script>
let activeFilter = { cat: 'all', estado: 'all' };

function applyFilter() {
    document.querySelectorAll('#amenazasGrid .item-card').forEach(card => {
        const catOk    = activeFilter.cat   === 'all' || card.dataset.cat    === activeFilter.cat;
        const estadoOk = activeFilter.estado === 'all' || card.dataset.estado === activeFilter.estado;
        card.style.display = (catOk && estadoOk) ? '' : 'none';
    });
}

function filterAmenazas(cat, btn) {
    document.querySelectorAll('.filter-tab').forEach(t =>
        t.classList.remove('active','active-green')
    );
    btn.classList.add('active');
    activeFilter.cat = cat;
    activeFilter.estado = 'all';
    applyFilter();
}

function filterEstado(estado, btn) {
    const isActive = btn.classList.contains('active-green');
    document.querySelectorAll('.filter-tab').forEach(t =>
        t.classList.remove('active-green')
    );
    if (!isActive) {
        btn.classList.add('active-green');
        activeFilter.estado = estado;
    } else {
        activeFilter.estado = 'all';
    }
    applyFilter();
}
</script>
@endpush

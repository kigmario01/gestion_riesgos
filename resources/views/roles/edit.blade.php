@extends('layouts.main')

@section('title', 'Editar Permisos — ' . strtoupper($rol->name))

@section('topbar-left')
    <div class="topbar-icon"><i class="fas fa-edit"></i></div>
    <div class="topbar-title">Editar Permisos — {{ str_replace('_',' ',strtoupper($rol->name)) }}</div>
@endsection

@section('topbar-right')
    <a href="{{ route('roles.show', $rol) }}" class="btn btn-outline btn-sm"><i class="fas fa-arrow-left"></i> Cancelar</a>
@endsection

@push('styles')
<style>
.module-block{border-bottom:1px solid #f1f5f9;}
.module-block:last-child{border-bottom:none;}
.module-header{padding:12px 20px;background:#f8fafc;display:flex;align-items:center;justify-content:space-between;cursor:pointer;user-select:none;}
.module-title{font-size:12px;font-weight:700;color:#475569;text-transform:uppercase;letter-spacing:1px;display:flex;align-items:center;gap:8px;}
.module-body{padding:14px 20px;display:flex;flex-wrap:wrap;gap:14px;}
.perm-toggle{display:flex;align-items:center;gap:8px;cursor:pointer;user-select:none;}
.perm-toggle input[type=checkbox]{width:16px;height:16px;cursor:pointer;accent-color:#3b82f6;flex-shrink:0;}
.perm-label{font-size:13px;color:#374151;font-weight:500;}
.perm-label-sub{font-size:11px;color:#94a3b8;}
.select-all-btn{font-size:11px;color:#3b82f6;cursor:pointer;background:none;border:none;font-weight:600;padding:0;font-family:inherit;}
.select-all-btn:hover{text-decoration:underline;}
.action-bar{background:#fff;border-top:1px solid #e2e8f0;padding:14px 26px;display:flex;align-items:center;justify-content:space-between;position:sticky;bottom:0;z-index:40;box-shadow:0 -4px 16px rgba(0,0,0,0.05);}
.warning-note{background:#fffbeb;border:1px solid #fde68a;border-radius:8px;padding:10px 14px;font-size:12px;color:#92400e;display:flex;align-items:center;gap:8px;margin-bottom:20px;}
</style>
@endpush

@section('content')
<div class="warning-note">
    <i class="fas fa-exclamation-triangle"></i>
    Los cambios de permisos afectan inmediatamente a todos los usuarios con este rol. Procede con cuidado.
</div>

<form method="POST" action="{{ route('roles.update', $rol) }}" id="permForm">
    @csrf @method('PUT')

    @php $rolPerms = $rol->permissions->pluck('name')->toArray(); @endphp

    <div class="panel">
        <div class="panel-header">
            <div class="panel-title"><i class="fas fa-key"></i> Permisos del Rol</div>
            <button type="button" class="select-all-btn" onclick="toggleAll(true)"><i class="fas fa-check-double"></i> Seleccionar todos</button>
        </div>

        @foreach($permisosPorModulo as $modulo => $permisos)
        <div class="module-block">
            <div class="module-header" onclick="toggleModule('{{ $modulo }}')">
                <div class="module-title"><i class="fas fa-cube"></i> {{ strtoupper($modulo) }}</div>
                <button type="button" class="select-all-btn" onclick="event.stopPropagation(); selectModule('{{ $modulo }}')">
                    Seleccionar módulo
                </button>
            </div>
            <div class="module-body" id="module-{{ $modulo }}">
                @foreach($permisos as $perm)
                @php $action = explode('.', $perm->name)[1] ?? $perm->name; @endphp
                <label class="perm-toggle">
                    <input type="checkbox" name="permissions[]" value="{{ $perm->name }}"
                        {{ in_array($perm->name, $rolPerms) ? 'checked' : '' }}
                        data-module="{{ $modulo }}">
                    <div>
                        <div class="perm-label">{{ ucfirst($action) }}</div>
                        <div class="perm-label-sub">{{ $perm->name }}</div>
                    </div>
                </label>
                @endforeach
            </div>
        </div>
        @endforeach
    </div>

    <div class="action-bar">
        <div style="font-size:13px;color:#64748b;">
            <span id="selected-count">{{ count($rolPerms) }}</span> permisos seleccionados
        </div>
        <div style="display:flex;gap:10px;">
            <a href="{{ route('roles.show', $rol) }}" class="btn btn-outline">Cancelar</a>
            <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Guardar Cambios</button>
        </div>
    </div>
</form>
@endsection

@push('scripts')
<script>
function updateCounter() {
    document.getElementById('selected-count').textContent =
        document.querySelectorAll('input[name="permissions[]"]:checked').length;
}
document.querySelectorAll('input[name="permissions[]"]').forEach(cb => cb.addEventListener('change', updateCounter));

function toggleAll(val) {
    document.querySelectorAll('input[name="permissions[]"]').forEach(cb => cb.checked = val);
    updateCounter();
}
function selectModule(mod) {
    const cbs = document.querySelectorAll(`input[data-module="${mod}"]`);
    const allChecked = Array.from(cbs).every(cb => cb.checked);
    cbs.forEach(cb => cb.checked = !allChecked);
    updateCounter();
}
function toggleModule(mod) {
    const body = document.getElementById(`module-${mod}`);
    body.style.display = body.style.display === 'none' ? '' : 'none';
}
</script>
@endpush

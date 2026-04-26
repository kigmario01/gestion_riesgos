@extends('layouts.main')

@section('title', isset($usuario) ? 'Editar Usuario' : 'Nuevo Usuario')

@section('topbar-left')
    <div class="topbar-icon"><i class="fas fa-{{ isset($usuario) ? 'edit' : 'user-plus' }}"></i></div>
    <div class="topbar-title">{{ isset($usuario) ? 'Editar Usuario' : 'Nuevo Usuario' }}</div>
@endsection

@section('topbar-right')
    <a href="{{ route('usuarios.index') }}" class="btn btn-outline btn-sm"><i class="fas fa-arrow-left"></i> Volver</a>
@endsection

@push('styles')
<style>
.role-info{background:#eff6ff;border:1px solid #bfdbfe;border-radius:8px;padding:12px 16px;margin-top:8px;}
.role-info-title{font-size:12px;font-weight:600;color:#1d4ed8;margin-bottom:4px;}
.role-info-desc{font-size:11px;color:#3b82f6;}
.roles-desc{display:none;}.roles-desc.active{display:block;}
</style>
@endpush

@section('content')
<div class="form-card">
    <div class="form-header">
        <h2><i class="fas fa-user"></i> {{ isset($usuario) ? 'Editando: '.$usuario->name : 'Registrar nuevo usuario' }}</h2>
        @if(isset($usuario))<p>Creado el {{ $usuario->created_at->format('d/m/Y') }}</p>@endif
    </div>
    <form method="POST" action="{{ isset($usuario) ? route('usuarios.update', $usuario) : route('usuarios.store') }}">
        @csrf
        @if(isset($usuario)) @method('PUT') @endif
        <div class="form-body">
            <div class="form-grid">

                <div class="form-group full">
                    <label>Nombre completo <span class="req">*</span></label>
                    <input type="text" name="name" value="{{ old('name', $usuario->name ?? '') }}" required placeholder="Ej: Juan Pérez">
                    @error('name')<span class="error-msg">{{ $message }}</span>@enderror
                </div>

                <div class="form-group full">
                    <label>Correo electrónico <span class="req">*</span></label>
                    <input type="email" name="email" value="{{ old('email', $usuario->email ?? '') }}" required placeholder="usuario@ejemplo.com">
                    @error('email')<span class="error-msg">{{ $message }}</span>@enderror
                </div>

                <div class="form-group">
                    <label>Contraseña {{ isset($usuario) ? '' : '*' }}</label>
                    <input type="password" name="password" placeholder="{{ isset($usuario) ? 'Dejar vacío para no cambiar' : 'Mínimo 8 caracteres' }}" {{ isset($usuario) ? '' : 'required' }}>
                    <span class="hint">Mínimo 8 caracteres</span>
                    @error('password')<span class="error-msg">{{ $message }}</span>@enderror
                </div>

                <div class="form-group">
                    <label>Confirmar contraseña {{ isset($usuario) ? '' : '*' }}</label>
                    <input type="password" name="password_confirmation" placeholder="Repite la contraseña" {{ isset($usuario) ? '' : 'required' }}>
                </div>

                <div class="form-group full">
                    <label>Rol del sistema <span class="req">*</span></label>
                    <select name="role" id="roleSelect" required onchange="mostrarDescRol()">
                        <option value="">Seleccionar rol...</option>
                        @foreach($roles as $role)
                        <option value="{{ $role->name }}" {{ old('role', isset($usuario) ? $usuario->getRoleNames()->first() : '') == $role->name ? 'selected' : '' }}>
                            {{ str_replace('_', ' ', strtoupper($role->name)) }}
                        </option>
                        @endforeach
                    </select>
                    @error('role')<span class="error-msg">{{ $message }}</span>@enderror

                    <div id="desc-product_owner" class="roles-desc role-info">
                        <div class="role-info-title">Product Owner</div>
                        <div class="role-info-desc">Consulta reportes, valida prioridades y aprueba resultados. Solo lectura en módulos técnicos.</div>
                    </div>
                    <div id="desc-scrum_master" class="roles-desc role-info">
                        <div class="role-info-title">Scrum Master</div>
                        <div class="role-info-desc">Supervisa tareas, controla el cronograma. No modifica datos críticos del sistema.</div>
                    </div>
                    <div id="desc-frontend" class="roles-desc role-info">
                        <div class="role-info-title">Frontend</div>
                        <div class="role-info-desc">Acceso a vistas y reportes visuales. No puede modificar fórmulas ni base de datos.</div>
                    </div>
                    <div id="desc-backend" class="roles-desc role-info">
                        <div class="role-info-title">Backend</div>
                        <div class="role-info-desc">Acceso completo a lógica del sistema, CRUD, cálculo de riesgo y gestión de usuarios.</div>
                    </div>
                    <div id="desc-base_datos" class="roles-desc role-info">
                        <div class="role-info-title">Base de Datos</div>
                        <div class="role-info-desc">Gestiona tablas, relaciones, respaldos y optimización. No modifica la interfaz visual.</div>
                    </div>
                    <div id="desc-auditoria" class="roles-desc role-info">
                        <div class="role-info-title">Auditoría / Calidad</div>
                        <div class="role-info-desc">Verifica trazabilidad, valida evidencias y emite reportes. Principalmente consulta.</div>
                    </div>
                </div>

                @if(isset($usuario))
                <div class="form-group full">
                    <label style="display:flex;align-items:center;gap:8px;cursor:pointer;font-size:13px;">
                        <input type="checkbox" name="activo" value="1" {{ old('activo', $usuario->activo) ? 'checked' : '' }} style="width:16px;height:16px;accent-color:#3b82f6;">
                        Usuario activo
                    </label>
                    <span class="hint">Desmarcar para desactivar el acceso del usuario al sistema</span>
                </div>
                @endif

            </div>
        </div>
        <div class="form-footer">
            <a href="{{ route('usuarios.index') }}" class="btn btn-outline">Cancelar</a>
            <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> {{ isset($usuario) ? 'Guardar cambios' : 'Crear usuario' }}</button>
        </div>
    </form>
</div>
@endsection

@push('scripts')
<script>
function mostrarDescRol() {
    document.querySelectorAll('.roles-desc').forEach(el => el.classList.remove('active'));
    const val = document.getElementById('roleSelect').value;
    if (val) {
        const desc = document.getElementById('desc-' + val);
        if (desc) desc.classList.add('active');
    }
}
window.addEventListener('DOMContentLoaded', mostrarDescRol);
</script>
@endpush

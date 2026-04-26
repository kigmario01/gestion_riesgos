@extends('layouts.main')

@section('title', 'Nuevo Activo TI')

@section('topbar-left')
    <div class="topbar-icon"><i class="fas fa-plus"></i></div>
    <div class="topbar-title">Registrar Nuevo Activo TI</div>
@endsection

@section('topbar-right')
    <a href="{{ route('activos.index') }}" class="btn btn-outline btn-sm"><i class="fas fa-arrow-left"></i> Volver</a>
@endsection

@section('content')
<div class="form-card">
    <div class="form-header">
        <h2><i class="fas fa-server"></i> Información del Activo TI</h2>
    </div>
    <form method="POST" action="{{ route('activos.store') }}">
        @csrf
        <div class="form-body">
            <div class="form-grid">

                <div class="form-group">
                    <label>Nombre del activo <span class="req">*</span></label>
                    <input type="text" name="nombre" value="{{ old('nombre') }}" placeholder="Ej: Servidor principal" required>
                    @error('nombre') <span class="error-msg">{{ $message }}</span> @enderror
                </div>

                <div class="form-group">
                    <label>Código <span class="req">*</span></label>
                    <input type="text" name="codigo" value="{{ old('codigo') }}" placeholder="Ej: AKT-001" required>
                    <span class="hint">Debe ser único. Ej: AKT-001, AKT-002…</span>
                    @error('codigo') <span class="error-msg">{{ $message }}</span> @enderror
                </div>

                <div class="form-group">
                    <label>Tipo de activo <span class="req">*</span></label>
                    <select name="tipo" required>
                        <option value="">Seleccionar tipo…</option>
                        @foreach(['hardware'=>'Hardware','software'=>'Software','red'=>'Red','datos'=>'Datos','servicios'=>'Servicios','personas'=>'Personas','instalaciones'=>'Instalaciones'] as $v=>$l)
                        <option value="{{ $v }}" {{ old('tipo') == $v ? 'selected' : '' }}>{{ $l }}</option>
                        @endforeach
                    </select>
                    @error('tipo') <span class="error-msg">{{ $message }}</span> @enderror
                </div>

                <div class="form-group">
                    <label>Criticidad <span class="req">*</span></label>
                    <select name="criticidad" required>
                        <option value="">Seleccionar…</option>
                        @foreach(['baja'=>'Baja','media'=>'Media','alta'=>'Alta','critica'=>'Crítica'] as $v=>$l)
                        <option value="{{ $v }}" {{ old('criticidad') == $v ? 'selected' : '' }}>{{ $l }}</option>
                        @endforeach
                    </select>
                    @error('criticidad') <span class="error-msg">{{ $message }}</span> @enderror
                </div>

                <div class="form-group">
                    <label>Estado <span class="req">*</span></label>
                    <select name="estado" required>
                        @foreach(['activo'=>'Activo','inactivo'=>'Inactivo','en_mantenimiento'=>'En mantenimiento'] as $v=>$l)
                        <option value="{{ $v }}" {{ old('estado','activo') == $v ? 'selected' : '' }}>{{ $l }}</option>
                        @endforeach
                    </select>
                    @error('estado') <span class="error-msg">{{ $message }}</span> @enderror
                </div>

                <div class="form-group">
                    <label>Responsable</label>
                    <input type="text" name="responsable" value="{{ old('responsable') }}" placeholder="Nombre del responsable">
                    @error('responsable') <span class="error-msg">{{ $message }}</span> @enderror
                </div>

                <div class="form-group">
                    <label>Ubicación</label>
                    <input type="text" name="ubicacion" value="{{ old('ubicacion') }}" placeholder="Ej: Sala de servidores, Piso 2">
                    @error('ubicacion') <span class="error-msg">{{ $message }}</span> @enderror
                </div>

                <div class="form-group">
                    <label>Valor económico (opcional)</label>
                    <input type="number" name="valor_economico" value="{{ old('valor_economico') }}" placeholder="0.00" step="0.01" min="0">
                    @error('valor_economico') <span class="error-msg">{{ $message }}</span> @enderror
                </div>

                <div class="form-group full">
                    <label>Descripción</label>
                    <textarea name="descripcion" placeholder="Descripción detallada del activo…">{{ old('descripcion') }}</textarea>
                    @error('descripcion') <span class="error-msg">{{ $message }}</span> @enderror
                </div>

            </div>
        </div>
        <div class="form-footer">
            <a href="{{ route('activos.index') }}" class="btn btn-outline">Cancelar</a>
            <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Guardar Activo</button>
        </div>
    </form>
</div>
@endsection

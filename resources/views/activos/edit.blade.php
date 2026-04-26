@extends('layouts.main')

@section('title', 'Editar Activo TI')

@section('topbar-left')
    <div class="topbar-icon"><i class="fas fa-edit"></i></div>
    <div class="topbar-title">Editar Activo TI</div>
@endsection

@section('topbar-right')
    <a href="{{ route('activos.index') }}" class="btn btn-outline btn-sm"><i class="fas fa-arrow-left"></i> Volver</a>
@endsection

@section('content')
<div class="form-card">
    <div class="form-header">
        <h2><i class="fas fa-server"></i> Editando: {{ $activo->nombre }}</h2>
        <p>Código: <code class="tag">{{ $activo->codigo }}</code> · Registrado el {{ $activo->created_at->format('d/m/Y') }}</p>
    </div>
    <form method="POST" action="{{ route('activos.update', $activo) }}">
        @csrf @method('PUT')
        <div class="form-body">
            <div class="form-grid">

                <div class="form-group">
                    <label>Nombre del activo <span class="req">*</span></label>
                    <input type="text" name="nombre" value="{{ old('nombre', $activo->nombre) }}" required>
                    @error('nombre') <span class="error-msg">{{ $message }}</span> @enderror
                </div>

                <div class="form-group">
                    <label>Código <span class="req">*</span></label>
                    <input type="text" name="codigo" value="{{ old('codigo', $activo->codigo) }}" required>
                    @error('codigo') <span class="error-msg">{{ $message }}</span> @enderror
                </div>

                <div class="form-group">
                    <label>Tipo de activo <span class="req">*</span></label>
                    <select name="tipo" required>
                        @foreach(['hardware','software','red','datos','servicios','personas','instalaciones'] as $t)
                        <option value="{{ $t }}" {{ old('tipo', $activo->tipo) == $t ? 'selected' : '' }}>{{ ucfirst($t) }}</option>
                        @endforeach
                    </select>
                    @error('tipo') <span class="error-msg">{{ $message }}</span> @enderror
                </div>

                <div class="form-group">
                    <label>Criticidad <span class="req">*</span></label>
                    <select name="criticidad" required>
                        @foreach(['baja','media','alta','critica'] as $c)
                        <option value="{{ $c }}" {{ old('criticidad', $activo->criticidad) == $c ? 'selected' : '' }}>{{ ucfirst($c) }}</option>
                        @endforeach
                    </select>
                    @error('criticidad') <span class="error-msg">{{ $message }}</span> @enderror
                </div>

                <div class="form-group">
                    <label>Estado <span class="req">*</span></label>
                    <select name="estado" required>
                        @foreach(['activo','inactivo','en_mantenimiento'] as $e)
                        <option value="{{ $e }}" {{ old('estado', $activo->estado) == $e ? 'selected' : '' }}>{{ ucfirst(str_replace('_',' ',$e)) }}</option>
                        @endforeach
                    </select>
                    @error('estado') <span class="error-msg">{{ $message }}</span> @enderror
                </div>

                <div class="form-group">
                    <label>Responsable</label>
                    <input type="text" name="responsable" value="{{ old('responsable', $activo->responsable) }}">
                    @error('responsable') <span class="error-msg">{{ $message }}</span> @enderror
                </div>

                <div class="form-group">
                    <label>Ubicación</label>
                    <input type="text" name="ubicacion" value="{{ old('ubicacion', $activo->ubicacion) }}">
                    @error('ubicacion') <span class="error-msg">{{ $message }}</span> @enderror
                </div>

                <div class="form-group">
                    <label>Valor económico</label>
                    <input type="number" name="valor_economico" value="{{ old('valor_economico', $activo->valor_economico) }}" step="0.01" min="0">
                    @error('valor_economico') <span class="error-msg">{{ $message }}</span> @enderror
                </div>

                <div class="form-group full">
                    <label>Descripción</label>
                    <textarea name="descripcion">{{ old('descripcion', $activo->descripcion) }}</textarea>
                    @error('descripcion') <span class="error-msg">{{ $message }}</span> @enderror
                </div>

            </div>
        </div>
        <div class="form-footer">
            <a href="{{ route('activos.index') }}" class="btn btn-outline">Cancelar</a>
            <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Guardar Cambios</button>
        </div>
    </form>
</div>
@endsection

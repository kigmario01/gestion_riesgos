@extends('layouts.main')

@section('title', isset($amenaza) ? 'Editar Amenaza' : 'Nueva Amenaza')

@section('topbar-left')
    <div class="topbar-icon"><i class="fas fa-biohazard"></i></div>
    <div class="topbar-title">{{ isset($amenaza) ? 'Editar Amenaza' : 'Nueva Amenaza' }}</div>
@endsection

@section('topbar-right')
    <a href="{{ route('amenazas.index') }}" class="btn btn-outline btn-sm"><i class="fas fa-arrow-left"></i> Volver</a>
@endsection

@section('content')
<div class="form-card">
    <div class="form-header">
        <h2><i class="fas fa-biohazard"></i> {{ isset($amenaza) ? 'Editando: '.$amenaza->nombre : 'Registrar nueva amenaza' }}</h2>
    </div>
    <form method="POST" action="{{ isset($amenaza) ? route('amenazas.update', $amenaza) : route('amenazas.store') }}">
        @csrf
        @if(isset($amenaza)) @method('PUT') @endif
        <div class="form-body">
            <div class="form-grid">
                <div class="form-group">
                    <label>Nombre <span class="req">*</span></label>
                    <input type="text" name="nombre" value="{{ old('nombre', $amenaza->nombre ?? '') }}" required>
                    @error('nombre')<span class="error-msg">{{ $message }}</span>@enderror
                </div>
                <div class="form-group">
                    <label>Código <span class="req">*</span></label>
                    <input type="text" name="codigo" value="{{ old('codigo', $amenaza->codigo ?? '') }}" placeholder="Ej: AME-001" required>
                    @error('codigo')<span class="error-msg">{{ $message }}</span>@enderror
                </div>
                <div class="form-group">
                    <label>Categoría <span class="req">*</span></label>
                    <select name="categoria" required>
                        <option value="">Seleccionar…</option>
                        @foreach(['accidental','deliberada','ambiental','tecnica','humana'] as $cat)
                        <option value="{{ $cat }}" {{ old('categoria', $amenaza->categoria ?? '') == $cat ? 'selected' : '' }}>{{ ucfirst($cat) }}</option>
                        @endforeach
                    </select>
                    @error('categoria')<span class="error-msg">{{ $message }}</span>@enderror
                </div>
                <div class="form-group">
                    <label>Origen <span class="req">*</span></label>
                    <select name="origen" required>
                        <option value="">Seleccionar…</option>
                        @foreach(['interno','externo','natural'] as $o)
                        <option value="{{ $o }}" {{ old('origen', $amenaza->origen ?? '') == $o ? 'selected' : '' }}>{{ ucfirst($o) }}</option>
                        @endforeach
                    </select>
                    @error('origen')<span class="error-msg">{{ $message }}</span>@enderror
                </div>
                <div class="form-group">
                    <label>Estado <span class="req">*</span></label>
                    <select name="estado" required>
                        <option value="activa"  {{ old('estado', $amenaza->estado ?? 'activa') == 'activa'  ? 'selected' : '' }}>Activa</option>
                        <option value="inactiva"{{ old('estado', $amenaza->estado ?? '')       == 'inactiva'? 'selected' : '' }}>Inactiva</option>
                    </select>
                </div>
                <div class="form-group full">
                    <label>Descripción</label>
                    <textarea name="descripcion">{{ old('descripcion', $amenaza->descripcion ?? '') }}</textarea>
                </div>
            </div>
        </div>
        <div class="form-footer">
            <a href="{{ route('amenazas.index') }}" class="btn btn-outline">Cancelar</a>
            <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Guardar</button>
        </div>
    </form>
</div>
@endsection

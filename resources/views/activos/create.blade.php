@extends('layouts.main')

@section('title', 'Nuevo Activo TI')

@section('topbar-left')
    <div class="topbar-icon"><i class="fas fa-plus"></i></div>
    <div class="topbar-title">Registrar Nuevo Activo TI</div>
@endsection

@section('topbar-right')
    <a href="{{ route('activos.index') }}" class="btn btn-outline btn-sm"><i class="fas fa-arrow-left"></i> Volver</a>
@endsection

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
    <div class="guia-iso-header" onclick="this.nextElementSibling.style.display=this.nextElementSibling.style.display==='none'?'':'none'">
        <div class="guia-iso-icon"><i class="fas fa-question-circle" style="color:#3b82f6;font-size:14px;"></i></div>
        <div class="guia-iso-title">Guía para registrar un activo TI correctamente</div>
        <span class="guia-iso-ref">ISO 27001 — Inventario de Activos</span>
        <i class="fas fa-chevron-up" style="color:#3b82f6;font-size:11px;"></i>
    </div>
    <div class="guia-iso-body" style="display:none">
        <div class="guia-paso"><div class="guia-num">1</div><div><strong>Nombre y Código:</strong> Usa un nombre descriptivo y un código único (ej. <code style="background:#dbeafe;padding:1px 5px;border-radius:4px;">AKT-001</code>). El código sirve para referenciar el activo en evaluaciones y reportes.</div></div>
        <div class="guia-paso"><div class="guia-num">2</div><div><strong>Tipo:</strong> Selecciona la categoría que mejor describe el activo. ISO 27001 reconoce: Hardware (equipos físicos), Software (aplicaciones), Red (infraestructura de red), Datos (información almacenada), Servicios (cloud, SaaS), Personas y Instalaciones.</div></div>
        <div class="guia-paso"><div class="guia-num">3</div><div><strong>Criticidad:</strong> Evalúa el impacto en el negocio si este activo se pierde o falla. <strong>Crítica</strong> = operaciones detenidas; <strong>Alta</strong> = impacto severo; <strong>Media</strong> = impacto moderado; <strong>Baja</strong> = impacto mínimo.</div></div>
        <div class="guia-paso"><div class="guia-num">4</div><div><strong>Responsable:</strong> Es el propietario del activo, no necesariamente quien lo opera. Es quien toma decisiones sobre su uso, protección y baja.</div></div>
        <div class="guia-paso"><div class="guia-num">5</div><div><strong>Valor económico:</strong> Ayuda a priorizar controles. Incluye costo de reposición, costo de los datos y costo del tiempo de inactividad.</div></div>
        <div class="guia-nota">
            <i class="fas fa-lightbulb" style="color:#f59e0b;flex-shrink:0;margin-top:1px;"></i>
            <span>Una vez registrado el activo, podrás evaluarlo en el módulo de <strong>Evaluaciones de Riesgo</strong> seleccionando qué amenazas lo afectan y calculando su nivel de riesgo.</span>
        </div>
    </div>
</div>

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

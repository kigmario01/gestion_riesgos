@extends('layouts.main')

@section('title', 'Acceso denegado')

@section('topbar-left')
    <div class="topbar-icon"><i class="fas fa-ban"></i></div>
    <div class="topbar-title">Acceso denegado</div>
@endsection

@section('content')
<div style="display:flex;flex-direction:column;align-items:center;justify-content:center;min-height:60vh;text-align:center;gap:16px;">
    <div style="width:80px;height:80px;border-radius:50%;background:#fef2f2;display:flex;align-items:center;justify-content:center;font-size:36px;color:#ef4444;">
        <i class="fas fa-lock"></i>
    </div>
    <div>
        <div style="font-size:22px;font-weight:800;color:#1b1f3b;margin-bottom:6px;">Sin permiso para acceder</div>
        <div style="font-size:13px;color:#94a3b8;max-width:380px;">Tu rol no tiene acceso a esta sección. Si crees que es un error, contacta al administrador.</div>
    </div>
    <a href="{{ url()->previous() !== url()->current() ? url()->previous() : route('dashboard') }}" class="btn btn-outline" style="margin-top:8px;">
        <i class="fas fa-arrow-left"></i> Volver
    </a>
</div>
@endsection

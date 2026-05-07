@extends('layouts.main')

@section('title', 'Mi Perfil')

@section('topbar-left')
    <div class="topbar-icon"><i class="fas fa-user-circle"></i></div>
    <div class="topbar-title">Mi Perfil</div>
@endsection

@section('content')
<div class="form-card" style="max-width:560px;margin:0 auto;">
    <div class="form-header">
        <h2><i class="fas fa-user-circle"></i> Editar Perfil</h2>
    </div>
    <form method="POST" action="{{ route('perfil.update') }}" enctype="multipart/form-data">
        @csrf
        <div class="form-body" style="display:flex;flex-direction:column;gap:22px;">

            {{-- Avatar --}}
            <div style="display:flex;flex-direction:column;align-items:center;gap:14px;">
                <div id="avatarPreview" style="width:96px;height:96px;border-radius:50%;overflow:hidden;border:3px solid #fed7aa;flex-shrink:0;background:linear-gradient(135deg,#f97316,#ea580c);display:flex;align-items:center;justify-content:center;">
                    @if($user->avatar_url)
                        <img src="{{ $user->avatar_url }}" style="width:100%;height:100%;object-fit:cover;" id="avatarImg">
                    @else
                        <span style="font-size:32px;font-weight:700;color:#fff;" id="avatarInitials">{{ strtoupper(substr($user->display_name, 0, 2)) }}</span>
                    @endif
                </div>

                <div style="display:flex;gap:8px;align-items:center;">
                    <label for="avatarInput" class="btn btn-outline btn-sm" style="cursor:pointer;margin:0;">
                        <i class="fas fa-camera"></i> Cambiar foto
                    </label>
                    <input type="file" name="avatar" id="avatarInput" accept="image/jpg,image/jpeg,image/png,image/webp" style="display:none;" onchange="previewAvatar(this)">
                    @if($user->avatar)
                    <label style="display:flex;align-items:center;gap:6px;font-size:12px;color:#94a3b8;cursor:pointer;">
                        <input type="checkbox" name="remove_avatar" value="1" style="width:14px;height:14px;">
                        Quitar foto
                    </label>
                    @endif
                </div>
                <span style="font-size:11px;color:#94a3b8;">JPG, PNG o WebP · Máx. 2MB</span>
            </div>

            {{-- Alias --}}
            <div>
                <label class="label" style="display:block;margin-bottom:6px;">
                    Alias <span style="font-size:11px;color:#94a3b8;">(nombre que se mostrará en el sistema)</span>
                </label>
                <input type="text" name="alias" value="{{ old('alias', $user->alias) }}"
                    placeholder="Ej: Mario A., MKD..."
                    maxlength="50" class="form-control" style="width:100%;">
                @error('alias')<span style="font-size:11px;color:#dc2626;">{{ $message }}</span>@enderror
            </div>

            {{-- Info de solo lectura --}}
            <div style="background:#f8fafc;border-radius:10px;padding:14px 16px;border:1px solid #f1f5f9;">
                <div style="font-size:10.5px;font-weight:600;color:#94a3b8;text-transform:uppercase;letter-spacing:.5px;margin-bottom:10px;">Información de cuenta</div>
                <div style="display:grid;grid-template-columns:1fr 1fr;gap:10px;font-size:13px;">
                    <div>
                        <div style="font-size:10px;color:#94a3b8;margin-bottom:2px;">Nombre completo</div>
                        <div style="font-weight:500;color:#374151;">{{ $user->name }}</div>
                    </div>
                    <div>
                        <div style="font-size:10px;color:#94a3b8;margin-bottom:2px;">Email</div>
                        <div style="font-weight:500;color:#374151;">{{ $user->email }}</div>
                    </div>
                    <div>
                        <div style="font-size:10px;color:#94a3b8;margin-bottom:2px;">Rol</div>
                        <div style="font-weight:500;color:#374151;">{{ $user->getRoleNames()->first() ?? '—' }}</div>
                    </div>
                    <div>
                        <div style="font-size:10px;color:#94a3b8;margin-bottom:2px;">Último acceso</div>
                        <div style="font-weight:500;color:#374151;">{{ $user->ultimo_acceso?->format('d/m/Y H:i') ?? '—' }}</div>
                    </div>
                </div>
            </div>

        </div>
        <div class="form-footer">
            <a href="{{ route('dashboard') }}" class="btn btn-outline btn-sm">Cancelar</a>
            <button type="submit" class="btn btn-primary btn-sm"><i class="fas fa-save"></i> Guardar cambios</button>
        </div>
    </form>
</div>
@endsection

@push('scripts')
<script>
function previewAvatar(input) {
    if (!input.files || !input.files[0]) return;
    var reader = new FileReader();
    reader.onload = function(e) {
        var preview = document.getElementById('avatarPreview');
        preview.innerHTML = '<img src="' + e.target.result + '" style="width:100%;height:100%;object-fit:cover;">';
    };
    reader.readAsDataURL(input.files[0]);
}
</script>
@endpush

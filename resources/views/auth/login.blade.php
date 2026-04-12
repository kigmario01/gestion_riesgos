<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar Sesión — RiskGuard TI</title>
    @vite(['resources/css/app.css'])
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif; background: #f0f4f8; min-height: 100vh; display: flex; align-items: center; justify-content: center; }

        .login-wrapper {
            display: flex;
            width: 100%;
            max-width: 900px;
            min-height: 500px;
            border-radius: 16px;
            overflow: hidden;
            box-shadow: 0 20px 60px rgba(0,0,0,0.12);
            margin: 24px;
        }

        .login-left {
            flex: 1;
            background: #1e40af;
            padding: 48px 40px;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            position: relative;
            overflow: hidden;
        }

        .login-left::before {
            content: '';
            position: absolute;
            bottom: -80px; right: -80px;
            width: 300px; height: 300px;
            background: rgba(255,255,255,0.05);
            border-radius: 50%;
        }

        .login-left::after {
            content: '';
            position: absolute;
            top: -40px; left: -40px;
            width: 200px; height: 200px;
            background: rgba(255,255,255,0.04);
            border-radius: 50%;
        }

        .brand { position: relative; z-index: 1; }
        .brand-icon { font-size: 36px; margin-bottom: 12px; display: block; }
        .brand-name { color: #fff; font-size: 22px; font-weight: 700; margin-bottom: 4px; }
        .brand-sub { color: rgba(255,255,255,0.6); font-size: 12px; letter-spacing: 1px; text-transform: uppercase; }

        .login-info { position: relative; z-index: 1; }
        .info-title { color: #fff; font-size: 18px; font-weight: 600; margin-bottom: 8px; }
        .info-desc { color: rgba(255,255,255,0.65); font-size: 13px; line-height: 1.6; }

        .info-features { margin-top: 20px; }
        .feature-item { display: flex; align-items: center; gap: 10px; margin-bottom: 10px; }
        .feature-dot { width: 6px; height: 6px; border-radius: 50%; background: #60a5fa; flex-shrink: 0; }
        .feature-text { color: rgba(255,255,255,0.75); font-size: 12.5px; }

        .login-badge { position: relative; z-index: 1; }
        .iso-badge { display: inline-flex; align-items: center; gap: 6px; background: rgba(255,255,255,0.1); color: rgba(255,255,255,0.8); padding: 6px 12px; border-radius: 20px; font-size: 11px; border: 1px solid rgba(255,255,255,0.15); }

        .login-right {
            width: 400px;
            background: #fff;
            padding: 48px 40px;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .login-title { font-size: 22px; font-weight: 700; color: #1e293b; margin-bottom: 4px; }
        .login-subtitle { font-size: 13px; color: #64748b; margin-bottom: 32px; }

        .form-group { margin-bottom: 20px; }
        label { display: block; font-size: 13px; font-weight: 500; color: #374151; margin-bottom: 6px; }
        input[type="email"], input[type="password"] {
            width: 100%;
            padding: 11px 14px;
            border: 1px solid #e2e8f0;
            border-radius: 8px;
            font-size: 13.5px;
            color: #1e293b;
            font-family: inherit;
            outline: none;
            transition: border-color 0.2s, box-shadow 0.2s;
            background: #fff;
        }
        input[type="email"]:focus, input[type="password"]:focus {
            border-color: #1e40af;
            box-shadow: 0 0 0 3px rgba(30,64,175,0.1);
        }

        .remember-row {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 24px;
        }

        .remember-label {
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 13px;
            color: #64748b;
            cursor: pointer;
        }

        input[type="checkbox"] { width: 15px; height: 15px; cursor: pointer; accent-color: #1e40af; }

        .btn-login {
            width: 100%;
            padding: 12px;
            background: #1e40af;
            color: #fff;
            border: none;
            border-radius: 8px;
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
            transition: background 0.2s;
            font-family: inherit;
            letter-spacing: 0.3px;
        }
        .btn-login:hover { background: #1d3a9e; }

        .error-msg {
            background: #fef2f2;
            border: 1px solid #fecaca;
            border-radius: 8px;
            padding: 10px 14px;
            font-size: 12.5px;
            color: #dc2626;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .login-footer {
            margin-top: 24px;
            text-align: center;
            font-size: 11px;
            color: #94a3b8;
        }
    </style>
</head>
<body>

<div class="login-wrapper">

    <!-- IZQUIERDA -->
    <div class="login-left">
        <div class="brand">
            <span class="brand-icon">🛡️</span>
            <div class="brand-name">RiskGuard TI</div>
            <div class="brand-sub">Plataforma de gestión · Grupo 4</div>
        </div>

        <div class="login-info">
            <div class="info-title">Gestión de Riesgos TI en Emergencias</div>
            <div class="info-desc">Plataforma centralizada para identificar, evaluar y mitigar riesgos tecnológicos.</div>
            <div class="info-features">
                <div class="feature-item"><div class="feature-dot"></div><span class="feature-text">Identificación de activos TI</span></div>
                <div class="feature-item"><div class="feature-dot"></div><span class="feature-text">Cálculo automático de riesgo ISO 27001</span></div>
                <div class="feature-item"><div class="feature-dot"></div><span class="feature-text">Matriz de riesgos exportable</span></div>
                <div class="feature-item"><div class="feature-dot"></div><span class="feature-text">Bitácora de auditoría inmutable</span></div>
                <div class="feature-item"><div class="feature-dot"></div><span class="feature-text">Control de roles y permisos RBAC</span></div>
            </div>
        </div>

        <div class="login-badge">
            <span class="iso-badge">✓ Basado en ISO 27001</span>
        </div>
    </div>

    <!-- DERECHA -->
    <div class="login-right">
        <div class="login-title">Iniciar sesión</div>
        <div class="login-subtitle">Ingresa tus credenciales para continuar</div>

        @if ($errors->any())
        <div class="error-msg">
            ⚠️ {{ $errors->first() }}
        </div>
        @endif

        @if (session('status'))
        <div style="background:#f0fdf4; border:1px solid #bbf7d0; border-radius:8px; padding:10px 14px; font-size:12.5px; color:#16a34a; margin-bottom:20px;">
            {{ session('status') }}
        </div>
        @endif

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <div class="form-group">
                <label for="email">Correo electrónico</label>
                <input type="email" id="email" name="email" value="{{ old('email') }}" required autofocus placeholder="usuario@ejemplo.com">
            </div>

            <div class="form-group">
                <label for="password">Contraseña</label>
                <input type="password" id="password" name="password" required placeholder="••••••••">
            </div>

            <div class="remember-row">
                <label class="remember-label">
                    <input type="checkbox" name="remember"> Recordarme
                </label>
                @if (Route::has('password.request'))
                <a href="{{ route('password.request') }}" style="font-size:13px; color:#1e40af; text-decoration:none;">¿Olvidaste tu contraseña?</a>
                @endif
            </div>

            <button type="submit" class="btn-login">Iniciar sesión</button>
        </form>

        <div class="login-footer">
            RiskGuard TI · ISO 27001 · Grupo 4 · v1.0
        </div>
    </div>

</div>

</body>
</html>

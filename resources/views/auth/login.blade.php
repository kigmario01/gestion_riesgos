<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar Sesión — RiskGuard TI</title>
    @vite(['resources/css/app.css'])
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        *, *::before, *::after { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
            background: #f0f4f8;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .login-card {
            display: flex;
            width: 100%;
            max-width: 960px;
            min-height: 580px;
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 24px 64px rgba(0,0,0,0.13);
            margin: 24px;
        }

        /* ─── LEFT: Form Panel ─────────────────── */
        .panel-form {
            flex: 0 0 360px;
            background: #fff;
            padding: 52px 44px;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .logo-area {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 6px;
        }

        .logo-bars {
            display: flex;
            align-items: flex-end;
            gap: 3px;
            height: 28px;
        }

        .logo-bars span {
            display: block;
            width: 5px;
            border-radius: 3px;
            background: linear-gradient(to top, #1e3a8a, #3b82f6);
        }

        .logo-bars span:nth-child(1) { height: 12px; }
        .logo-bars span:nth-child(2) { height: 18px; }
        .logo-bars span:nth-child(3) { height: 24px; }
        .logo-bars span:nth-child(4) { height: 28px; }

        .logo-name {
            font-size: 20px;
            font-weight: 700;
            color: #1e3a8a;
            letter-spacing: -0.3px;
        }

        .login-heading {
            font-size: 13px;
            color: #6b7280;
            margin-bottom: 32px;
            margin-top: 4px;
        }

        .form-label {
            display: block;
            font-size: 13px;
            font-weight: 500;
            color: #374151;
            margin-bottom: 6px;
        }

        .input-wrap {
            position: relative;
            margin-bottom: 18px;
        }

        .input-wrap input {
            width: 100%;
            padding: 11px 44px 11px 14px;
            border: 1.5px solid #e5e7eb;
            border-radius: 10px;
            font-size: 13.5px;
            color: #1e293b;
            font-family: inherit;
            outline: none;
            transition: border-color 0.2s, box-shadow 0.2s;
            background: #f9fafb;
        }

        .input-wrap input:focus {
            border-color: #f97316;
            background: #fff;
            box-shadow: 0 0 0 3px rgba(249,115,22,0.12);
        }

        .input-wrap input::placeholder { color: #9ca3af; }

        .input-icon {
            position: absolute;
            right: 13px;
            top: 50%;
            transform: translateY(-50%);
            width: 30px;
            height: 30px;
            border-radius: 8px;
            background: #f97316;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .input-icon svg {
            width: 15px;
            height: 15px;
            fill: white;
        }

        .forgot-link {
            display: block;
            text-align: right;
            font-size: 12.5px;
            color: #f97316;
            text-decoration: none;
            margin-top: -10px;
            margin-bottom: 22px;
            font-weight: 500;
        }

        .forgot-link:hover { text-decoration: underline; }

        .btn-login {
            width: 100%;
            padding: 13px;
            background: linear-gradient(135deg, #f97316 0%, #ea580c 100%);
            color: #fff;
            border: none;
            border-radius: 10px;
            font-size: 14.5px;
            font-weight: 700;
            cursor: pointer;
            transition: opacity 0.2s, transform 0.1s;
            font-family: inherit;
            letter-spacing: 0.3px;
            box-shadow: 0 4px 14px rgba(249,115,22,0.35);
        }

        .btn-login:hover { opacity: 0.92; transform: translateY(-1px); }
        .btn-login:active { transform: translateY(0); }

        .divider {
            display: flex;
            align-items: center;
            gap: 10px;
            margin: 20px 0;
            color: #9ca3af;
            font-size: 12px;
        }

        .divider::before, .divider::after {
            content: '';
            flex: 1;
            height: 1px;
            background: #e5e7eb;
        }

        .btn-signup {
            width: 100%;
            padding: 11px;
            background: transparent;
            color: #f97316;
            border: 1.5px solid #f97316;
            border-radius: 10px;
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
            font-family: inherit;
            transition: background 0.2s, color 0.2s;
            text-decoration: none;
            display: block;
            text-align: center;
        }

        .btn-signup:hover {
            background: #fff7ed;
        }

        .error-box {
            background: #fef2f2;
            border: 1px solid #fecaca;
            border-radius: 9px;
            padding: 10px 14px;
            font-size: 12.5px;
            color: #dc2626;
            margin-bottom: 18px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .success-box {
            background: #f0fdf4;
            border: 1px solid #bbf7d0;
            border-radius: 9px;
            padding: 10px 14px;
            font-size: 12.5px;
            color: #16a34a;
            margin-bottom: 18px;
        }

        /* ─── RIGHT: Illustration Panel ───────── */
        .panel-illustration {
            flex: 1;
            background: linear-gradient(155deg, #1e3a8a 0%, #1d4ed8 55%, #2563eb 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
            overflow: hidden;
            padding: 40px;
        }

        .panel-illustration::before {
            content: '';
            position: absolute;
            bottom: -100px; right: -100px;
            width: 380px; height: 380px;
            background: rgba(255,255,255,0.04);
            border-radius: 50%;
        }

        .panel-illustration::after {
            content: '';
            position: absolute;
            top: -60px; left: -60px;
            width: 260px; height: 260px;
            background: rgba(255,255,255,0.04);
            border-radius: 50%;
        }

        .illus-inner {
            position: relative;
            z-index: 2;
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 20px;
            width: 100%;
            max-width: 380px;
            overflow-y: auto;
            max-height: 100%;
        }

        .illus-img {
            width: 100%;
            max-width: 300px;
            height: auto;
            filter: drop-shadow(0 12px 32px rgba(0,0,0,0.2));
            flex-shrink: 0;
        }

        /* ─── SGSI Info Block ───────────────────── */
        .sgsi-block {
            width: 100%;
            background: rgba(255,255,255,0.07);
            border: 1px solid rgba(255,255,255,0.14);
            border-radius: 14px;
            padding: 20px 22px;
            backdrop-filter: blur(6px);
        }

        .sgsi-header {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 12px;
        }

        .sgsi-icon {
            width: 34px;
            height: 34px;
            background: rgba(249,115,22,0.25);
            border-radius: 9px;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .sgsi-icon svg { width: 18px; height: 18px; fill: #fb923c; }

        .sgsi-title {
            font-size: 13px;
            font-weight: 700;
            color: #fff;
            line-height: 1.2;
        }

        .sgsi-subtitle {
            font-size: 10.5px;
            color: rgba(255,255,255,0.5);
            margin-top: 1px;
        }

        .sgsi-desc {
            font-size: 11.5px;
            color: rgba(255,255,255,0.65);
            line-height: 1.6;
            margin-bottom: 14px;
        }

        .sgsi-features {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 7px;
        }

        .sgsi-feat {
            display: flex;
            align-items: flex-start;
            gap: 7px;
            font-size: 11px;
            color: rgba(255,255,255,0.75);
            line-height: 1.35;
        }

        .sgsi-feat-dot {
            width: 5px;
            height: 5px;
            border-radius: 50%;
            background: #f97316;
            margin-top: 4px;
            flex-shrink: 0;
        }

        .sgsi-divider {
            height: 1px;
            background: rgba(255,255,255,0.1);
            margin: 12px 0;
        }

        .sgsi-footer {
            display: flex;
            align-items: center;
            gap: 6px;
            font-size: 10.5px;
            color: rgba(255,255,255,0.45);
        }

        .sgsi-footer-dot {
            width: 5px; height: 5px;
            background: #4ade80;
            border-radius: 50%;
            flex-shrink: 0;
        }

        @media (max-width: 720px) {
            .login-card { flex-direction: column; max-width: 420px; }
            .panel-form { flex: none; padding: 40px 32px; }
            .panel-illustration { min-height: auto; padding: 28px; }
            .illus-img { max-width: 200px; }
            .sgsi-features { grid-template-columns: 1fr; }
        }
    </style>
</head>
<body>

<div class="login-card">

    <!-- ─── LEFT: Form ─── -->
    <div class="panel-form">

        <div class="logo-area">
            <div class="logo-bars">
                <span></span><span></span><span></span><span></span>
            </div>
            <span class="logo-name">Network</span>
        </div>
        <p class="login-heading">Login into your account</p>

        @if ($errors->any())
        <div class="error-box">
            <svg viewBox="0 0 20 20" fill="currentColor" style="width:15px;height:15px;flex-shrink:0"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/></svg>
            {{ $errors->first() }}
        </div>
        @endif

        @if (session('status'))
        <div class="success-box">{{ session('status') }}</div>
        @endif

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <label class="form-label" for="email">Email address</label>
            <div class="input-wrap">
                <input type="email" id="email" name="email" value="{{ old('email') }}"
                       required autofocus placeholder="alex@email.com">
                <span class="input-icon">
                    <svg viewBox="0 0 24 24"><path d="M20 4H4c-1.1 0-2 .9-2 2v12c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2zm0 4l-8 5-8-5V6l8 5 8-5v2z"/></svg>
                </span>
            </div>

            <label class="form-label" for="password">Password</label>
            <div class="input-wrap">
                <input type="password" id="password" name="password"
                       required placeholder="Enter your password">
                <span class="input-icon">
                    <svg viewBox="0 0 24 24"><path d="M18 8h-1V6c0-2.76-2.24-5-5-5S7 3.24 7 6v2H6c-1.1 0-2 .9-2 2v10c0 1.1.9 2 2 2h12c1.1 0 2-.9 2-2V10c0-1.1-.9-2-2-2zm-6 9c-1.1 0-2-.9-2-2s.9-2 2-2 2 .9 2 2-.9 2-2 2zm3.1-9H8.9V6c0-1.71 1.39-3.1 3.1-3.1 1.71 0 3.1 1.39 3.1 3.1v2z"/></svg>
                </span>
            </div>

            @if (Route::has('password.request'))
            <a href="{{ route('password.request') }}" class="forgot-link">Forgot password?</a>
            @endif

            <button type="submit" class="btn-login">Login now</button>
        </form>

        <div class="divider">OR</div>

        @if (Route::has('register'))
        <a href="{{ route('register') }}" class="btn-signup">Signup now</a>
        @else
        <span class="btn-signup" style="opacity:0.4;cursor:default;">Signup now</span>
        @endif

    </div>

    <!-- ─── RIGHT: Illustration + SGSI ─── -->
    <div class="panel-illustration">
        <div class="illus-inner">
            <img
                src="{{ asset('images/login-illustration.svg') }}"
                alt="Secure login illustration"
                class="illus-img"
            >

            <!-- SGSI ISO 27001 Info Block -->
            <div class="sgsi-block">
                <div class="sgsi-header">
                    <div class="sgsi-icon">
                        <svg viewBox="0 0 24 24"><path d="M12 1L3 5v6c0 5.55 3.84 10.74 9 12 5.16-1.26 9-6.45 9-12V5l-9-4zm0 4l5 2.18V11c0 3.5-2.33 6.79-5 7.93-2.67-1.14-5-4.43-5-7.93V7.18L12 5zm-1 3v4h2V8h-2zm0 6v2h2v-2h-2z"/></svg>
                    </div>
                    <div>
                        <div class="sgsi-title">SGSI · ISO/IEC 27001</div>
                        <div class="sgsi-subtitle">Sistema de Gestión de Seguridad de la Información</div>
                    </div>
                </div>

                <p class="sgsi-desc">
                    Plataforma alineada al estándar internacional ISO/IEC 27001 para identificar, evaluar y tratar riesgos sobre activos de información críticos de la organización.
                </p>

                <div class="sgsi-features">
                    <div class="sgsi-feat"><span class="sgsi-feat-dot"></span>Inventario de activos TI</div>
                    <div class="sgsi-feat"><span class="sgsi-feat-dot"></span>Análisis de amenazas</div>
                    <div class="sgsi-feat"><span class="sgsi-feat-dot"></span>Cálculo de riesgo residual</div>
                    <div class="sgsi-feat"><span class="sgsi-feat-dot"></span>Matriz de riesgos</div>
                    <div class="sgsi-feat"><span class="sgsi-feat-dot"></span>Controles Anexo A</div>
                    <div class="sgsi-feat"><span class="sgsi-feat-dot"></span>Bitácora de auditoría</div>
                </div>

                <div class="sgsi-divider"></div>

                <div class="sgsi-footer">
                    <span class="sgsi-footer-dot"></span>
                    Cumplimiento ISO/IEC 27001:2022 · Gestión de Riesgos TI · Grupo 4
                </div>
            </div>
        </div>
    </div>

</div>

</body>
</html>

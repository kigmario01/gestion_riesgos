<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar Sesión — RiskGuard TI</title>
    <link rel="icon" type="image/png" href="{{ asset('images/logo.png') }}">
    @vite(['resources/css/app.css'])
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <script>(function(){ document.documentElement.setAttribute('data-theme', localStorage.getItem('rg-theme') || 'light'); })();</script>
    <style>
        *, *::before, *::after { margin: 0; padding: 0; box-sizing: border-box; }

        :root {
            --orange: #f97316;
            --orange-dark: #ea580c;
            --navy: #1e3a8a;
            --navy-light: #1d4ed8;
        }

        body {
            font-family: 'Inter', -apple-system, sans-serif;
            background: #f0f4f8;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
        }

        /* ── Animated background ── */
        body::before {
            content: '';
            position: fixed;
            inset: 0;
            background:
                radial-gradient(ellipse 80% 60% at 20% 80%, rgba(249,115,22,0.08) 0%, transparent 60%),
                radial-gradient(ellipse 60% 60% at 80% 20%, rgba(30,58,138,0.08) 0%, transparent 60%);
            pointer-events: none;
            z-index: 0;
        }

        /* Floating orbs */
        .orb {
            position: fixed;
            border-radius: 50%;
            filter: blur(80px);
            pointer-events: none;
            animation: floatOrb 8s ease-in-out infinite;
            z-index: 0;
        }
        .orb-1 { width: 400px; height: 400px; background: rgba(249,115,22,0.07); top: -100px; right: -100px; animation-delay: 0s; }
        .orb-2 { width: 300px; height: 300px; background: rgba(30,58,138,0.07); bottom: -80px; left: -80px; animation-delay: 3s; }
        .orb-3 { width: 200px; height: 200px; background: rgba(249,115,22,0.05); top: 40%; left: 40%; animation-delay: 1.5s; }
        @keyframes floatOrb {
            0%, 100% { transform: translate(0, 0) scale(1); }
            33% { transform: translate(30px, -20px) scale(1.05); }
            66% { transform: translate(-20px, 20px) scale(0.95); }
        }

        .login-wrapper {
            position: relative;
            z-index: 1;
            width: 100%;
            padding: 24px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .login-card {
            display: flex;
            width: 100%;
            max-width: 980px;
            min-height: 600px;
            border-radius: 24px;
            overflow: hidden;
            box-shadow:
                0 32px 80px rgba(0,0,0,0.12),
                0 8px 32px rgba(0,0,0,0.06),
                0 0 0 1px rgba(255,255,255,0.8);
            animation: cardEntrance 0.6s cubic-bezier(0.16, 1, 0.3, 1) both;
        }
        @keyframes cardEntrance {
            from { opacity: 0; transform: translateY(32px) scale(0.97); }
            to   { opacity: 1; transform: translateY(0) scale(1); }
        }

        /* ─── LEFT: Form ─────────────────── */
        .panel-form {
            flex: 0 0 380px;
            background: #ffffff;
            padding: 56px 48px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            position: relative;
        }

        /* Staggered entry for form elements */
        .fade-in { animation: fadeUp 0.5s cubic-bezier(0.16, 1, 0.3, 1) both; }
        .delay-1 { animation-delay: 0.15s; }
        .delay-2 { animation-delay: 0.25s; }
        .delay-3 { animation-delay: 0.35s; }
        .delay-4 { animation-delay: 0.45s; }
        .delay-5 { animation-delay: 0.55s; }
        @keyframes fadeUp {
            from { opacity: 0; transform: translateY(16px); }
            to   { opacity: 1; transform: translateY(0); }
        }

        .logo-area {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-bottom: 8px;
        }

        .logo-icon {
            width: 46px; height: 46px;
            border-radius: 14px;
            overflow: hidden;
            box-shadow: 0 6px 20px rgba(249,115,22,0.35);
            transition: transform 0.3s cubic-bezier(0.34, 1.56, 0.64, 1), box-shadow 0.3s ease;
        }
        .logo-icon:hover {
            transform: rotate(-6deg) scale(1.1);
            box-shadow: 0 10px 28px rgba(249,115,22,0.45);
        }
        .logo-icon img { width: 100%; height: 100%; object-fit: cover; display: block; }

        .logo-name { font-size: 16px; font-weight: 800; color: var(--navy); letter-spacing: -0.2px; }
        .logo-sub  { font-size: 11px; color: #94a3b8; font-weight: 500; margin-top: 1px; }

        .login-heading {
            font-size: 22px;
            font-weight: 800;
            color: #1b1f3b;
            margin-top: 20px;
            margin-bottom: 4px;
            letter-spacing: -0.4px;
        }
        .login-subheading {
            font-size: 13px;
            color: #64748b;
            margin-bottom: 32px;
        }

        .form-label {
            display: block;
            font-size: 12.5px;
            font-weight: 600;
            color: #374151;
            margin-bottom: 7px;
        }

        .input-wrap { position: relative; margin-bottom: 20px; }

        .input-wrap input {
            width: 100%;
            padding: 13px 48px 13px 16px;
            border: 2px solid #e5e7eb;
            border-radius: 12px;
            font-size: 14px;
            color: #1e293b;
            font-family: inherit;
            outline: none;
            background: #f9fafb;
            transition: border-color 0.25s, box-shadow 0.25s, background 0.25s, transform 0.15s;
        }
        .input-wrap input:focus {
            border-color: var(--orange);
            background: #fff;
            box-shadow: 0 0 0 4px rgba(249,115,22,0.10);
            transform: translateY(-1px);
        }
        .input-wrap input::placeholder { color: #9ca3af; }
        .input-wrap input:valid:not(:placeholder-shown) {
            border-color: #22c55e;
        }

        .input-icon {
            position: absolute;
            right: 12px; top: 50%;
            transform: translateY(-50%);
            width: 32px; height: 32px;
            border-radius: 9px;
            background: linear-gradient(135deg, var(--orange), var(--orange-dark));
            display: flex; align-items: center; justify-content: center;
            box-shadow: 0 2px 8px rgba(249,115,22,0.3);
            transition: transform 0.2s cubic-bezier(0.34, 1.56, 0.64, 1), box-shadow 0.2s;
        }
        .input-wrap:focus-within .input-icon {
            transform: translateY(-50%) scale(1.1) rotate(5deg);
            box-shadow: 0 4px 14px rgba(249,115,22,0.4);
        }
        .input-icon svg { width: 15px; height: 15px; fill: white; }

        /* ── Submit Button ── */
        .btn-login {
            width: 100%;
            padding: 15px;
            background: linear-gradient(135deg, var(--orange) 0%, var(--orange-dark) 100%);
            color: #fff;
            border: none;
            border-radius: 12px;
            font-size: 15px;
            font-weight: 700;
            cursor: pointer;
            font-family: inherit;
            letter-spacing: 0.3px;
            box-shadow: 0 6px 20px rgba(249,115,22,0.38);
            position: relative;
            overflow: hidden;
            transition: transform 0.2s cubic-bezier(0.34, 1.56, 0.64, 1), box-shadow 0.2s, opacity 0.2s;
        }
        .btn-login::before {
            content: '';
            position: absolute;
            inset: 0;
            background: linear-gradient(135deg, rgba(255,255,255,0.15) 0%, transparent 60%);
            opacity: 0;
            transition: opacity 0.2s;
        }
        .btn-login::after {
            content: '';
            position: absolute;
            top: 50%; left: 50%;
            width: 0; height: 0;
            background: rgba(255,255,255,0.3);
            border-radius: 50%;
            transform: translate(-50%, -50%);
            transition: width 0.5s, height 0.5s, opacity 0.5s;
            opacity: 0;
        }
        .btn-login:hover {
            transform: translateY(-3px) scale(1.01);
            box-shadow: 0 10px 30px rgba(249,115,22,0.45);
            opacity: 1;
        }
        .btn-login:hover::before { opacity: 1; }
        .btn-login:active {
            transform: translateY(0) scale(0.98);
            box-shadow: 0 4px 14px rgba(249,115,22,0.3);
        }
        .btn-login:active::after {
            width: 300px; height: 300px; opacity: 0;
            transition: width 0.3s, height 0.3s, opacity 0.3s;
        }

        /* Loading state */
        .btn-login.loading {
            pointer-events: none;
            opacity: 0.8;
        }
        .btn-login .btn-text { transition: opacity 0.2s; }
        .btn-login .btn-spinner {
            position: absolute; top: 50%; left: 50%;
            transform: translate(-50%, -50%);
            width: 20px; height: 20px;
            border: 2px solid rgba(255,255,255,0.3);
            border-top-color: #fff;
            border-radius: 50%;
            animation: spin 0.7s linear infinite;
            opacity: 0;
            transition: opacity 0.2s;
        }
        @keyframes spin { to { transform: translate(-50%, -50%) rotate(360deg); } }
        .btn-login.loading .btn-text { opacity: 0; }
        .btn-login.loading .btn-spinner { opacity: 1; }

        .info-box {
            display: flex;
            align-items: flex-start;
            gap: 9px;
            background: #eff6ff;
            border: 1px solid #bfdbfe;
            border-radius: 10px;
            padding: 11px 14px;
            font-size: 12.5px;
            color: #1e40af;
            line-height: 1.5;
            margin-top: 18px;
            transition: transform 0.2s, box-shadow 0.2s;
        }
        .info-box:hover { transform: translateX(2px); box-shadow: 2px 0 0 var(--orange); }

        .error-box {
            background: #fef2f2; border: 1px solid #fecaca;
            border-radius: 10px; padding: 11px 14px;
            font-size: 12.5px; color: #dc2626;
            margin-bottom: 20px;
            display: flex; align-items: center; gap: 9px;
            animation: shakeIn 0.4s cubic-bezier(0.36, 0.07, 0.19, 0.97) both;
        }
        @keyframes shakeIn {
            0%, 100% { transform: translateX(0); }
            20% { transform: translateX(-6px); }
            40% { transform: translateX(6px); }
            60% { transform: translateX(-4px); }
            80% { transform: translateX(4px); }
        }

        /* ─── RIGHT: Illustration ───────── */
        .panel-illustration {
            flex: 1;
            background: linear-gradient(155deg, #0f2060 0%, #1e3a8a 40%, #1d4ed8 75%, #2563eb 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
            overflow: hidden;
            padding: 48px 40px;
        }

        /* Animated mesh grid */
        .panel-illustration::before {
            content: '';
            position: absolute;
            inset: 0;
            background-image:
                linear-gradient(rgba(255,255,255,0.03) 1px, transparent 1px),
                linear-gradient(90deg, rgba(255,255,255,0.03) 1px, transparent 1px);
            background-size: 48px 48px;
            animation: meshShift 20s linear infinite;
        }
        @keyframes meshShift {
            0% { background-position: 0 0; }
            100% { background-position: 48px 48px; }
        }

        /* Glowing orbs on illustration side */
        .illus-orb {
            position: absolute;
            border-radius: 50%;
            filter: blur(60px);
            animation: floatOrb 6s ease-in-out infinite;
        }
        .illus-orb-1 { width: 280px; height: 280px; background: rgba(249,115,22,0.15); top: -60px; right: -60px; animation-delay: 0s; }
        .illus-orb-2 { width: 200px; height: 200px; background: rgba(99,102,241,0.12); bottom: -40px; left: -40px; animation-delay: 2s; }

        .illus-inner {
            position: relative; z-index: 2;
            display: flex; flex-direction: column;
            align-items: center; gap: 24px;
            width: 100%; max-width: 380px;
        }

        .illus-img {
            width: 100%; max-width: 280px; height: auto;
            filter: drop-shadow(0 16px 40px rgba(0,0,0,0.25));
            animation: floatImg 4s ease-in-out infinite;
        }
        @keyframes floatImg {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-12px); }
        }

        /* SGSI Block */
        .sgsi-block {
            width: 100%;
            background: rgba(255,255,255,0.08);
            border: 1px solid rgba(255,255,255,0.15);
            border-radius: 16px;
            padding: 22px 24px;
            backdrop-filter: blur(12px);
            transition: transform 0.3s, background 0.3s;
        }
        .sgsi-block:hover {
            transform: translateY(-2px);
            background: rgba(255,255,255,0.11);
        }

        .sgsi-header { display: flex; align-items: center; gap: 12px; margin-bottom: 14px; }
        .sgsi-icon {
            width: 38px; height: 38px;
            background: linear-gradient(135deg, rgba(249,115,22,0.3), rgba(249,115,22,0.15));
            border-radius: 10px;
            display: flex; align-items: center; justify-content: center;
            border: 1px solid rgba(249,115,22,0.3);
        }
        .sgsi-icon svg { width: 20px; height: 20px; fill: #fb923c; }
        .sgsi-title { font-size: 14px; font-weight: 700; color: #fff; }
        .sgsi-subtitle { font-size: 11px; color: rgba(255,255,255,0.5); margin-top: 2px; }
        .sgsi-desc { font-size: 12px; color: rgba(255,255,255,0.65); line-height: 1.65; margin-bottom: 16px; }

        .sgsi-features { display: grid; grid-template-columns: 1fr 1fr; gap: 8px; }
        .sgsi-feat {
            display: flex; align-items: center; gap: 8px;
            font-size: 11.5px; color: rgba(255,255,255,0.78);
            background: rgba(255,255,255,0.05);
            padding: 7px 10px; border-radius: 8px;
            border: 1px solid rgba(255,255,255,0.08);
            transition: background 0.2s, transform 0.2s;
        }
        .sgsi-feat:hover { background: rgba(255,255,255,0.10); transform: scale(1.02); }
        .sgsi-feat-dot { width: 6px; height: 6px; border-radius: 50%; background: var(--orange); flex-shrink: 0; box-shadow: 0 0 6px var(--orange); }

        .sgsi-divider { height: 1px; background: rgba(255,255,255,0.1); margin: 16px 0; }
        .sgsi-footer { display: flex; align-items: center; gap: 7px; font-size: 11px; color: rgba(255,255,255,0.4); }
        .sgsi-footer-dot {
            width: 7px; height: 7px; background: #4ade80; border-radius: 50%;
            box-shadow: 0 0 6px #4ade80;
            animation: pulse 2s ease-in-out infinite;
        }
        @keyframes pulse {
            0%, 100% { opacity: 1; transform: scale(1); }
            50% { opacity: 0.6; transform: scale(0.85); }
        }

        /* Theme toggle */
        .theme-btn {
            position: fixed; top: 18px; right: 18px; z-index: 100;
            width: 40px; height: 40px; border-radius: 12px;
            background: rgba(255,255,255,0.9);
            backdrop-filter: blur(8px);
            border: 1.5px solid #e5e7eb;
            color: #64748b; display: flex; align-items: center; justify-content: center;
            cursor: pointer;
            box-shadow: 0 4px 14px rgba(0,0,0,0.08);
            transition: all 0.25s cubic-bezier(0.34, 1.56, 0.64, 1);
        }
        .theme-btn:hover {
            border-color: var(--orange); color: var(--orange);
            transform: rotate(15deg) scale(1.1);
            box-shadow: 0 6px 20px rgba(249,115,22,0.2);
        }

        /* Responsive */
        @media (max-width: 760px) {
            .login-card { flex-direction: column; max-width: 440px; min-height: auto; }
            .panel-form { flex: none; padding: 44px 36px; }
            .panel-illustration { padding: 32px; min-height: auto; }
            .illus-img { max-width: 180px; }
            .sgsi-features { grid-template-columns: 1fr; }
        }

        /* Dark mode */
        [data-theme="dark"] body { background: #090d1a; }
        [data-theme="dark"] .panel-form { background: #131929; }
        [data-theme="dark"] .login-heading { color: #f1f5f9; }
        [data-theme="dark"] .login-subheading { color: #64748b; }
        [data-theme="dark"] .logo-name { color: var(--orange); }
        [data-theme="dark"] .form-label { color: #cbd5e1; }
        [data-theme="dark"] .input-wrap input { background: #0f1525; border-color: #1e2d4a; color: #e2e8f0; }
        [data-theme="dark"] .input-wrap input:focus { background: #161f38; border-color: var(--orange); box-shadow: 0 0 0 4px rgba(249,115,22,0.12); }
        [data-theme="dark"] .input-wrap input::placeholder { color: #374151; }
        [data-theme="dark"] .error-box { background: #2d1515; border-color: #7f1d1d; color: #fca5a5; }
        [data-theme="dark"] .info-box { background: #0d1f38; border-color: #1e3a5f; color: #93c5fd; }
        [data-theme="dark"] .login-card { box-shadow: 0 32px 80px rgba(0,0,0,0.5), 0 0 0 1px rgba(255,255,255,0.05); }
        [data-theme="dark"] .theme-btn { background: rgba(19,25,41,0.9); border-color: #1e2d4a; color: #94a3b8; }
    </style>
</head>
<body>

<div class="orb orb-1"></div>
<div class="orb orb-2"></div>
<div class="orb orb-3"></div>

<button id="loginThemeToggle" class="theme-btn" onclick="loginToggleTheme()" title="Cambiar tema"></button>

<div class="login-wrapper">
<div class="login-card">

    <!-- LEFT: Form -->
    <div class="panel-form">

        <div class="logo-area fade-in">
            <div class="logo-icon">
                <img src="{{ asset('images/logo.png') }}" alt="RiskGuard TI">
            </div>
            <div>
                <div class="logo-name">RiskGuard TI</div>
                <div class="logo-sub">Gestión de Riesgos · ISO 27001</div>
            </div>
        </div>

        <h1 class="login-heading fade-in delay-1">Bienvenido de nuevo</h1>
        <p class="login-subheading fade-in delay-1">Ingresa tus credenciales para continuar</p>

        @if ($errors->any())
        <div class="error-box fade-in">
            <svg viewBox="0 0 20 20" fill="currentColor" style="width:16px;height:16px;flex-shrink:0"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/></svg>
            {{ $errors->first() }}
        </div>
        @endif

        @if (session('status'))
        <div style="background:#f0fdf4;border:1px solid #bbf7d0;border-radius:10px;padding:11px 14px;font-size:12.5px;color:#16a34a;margin-bottom:20px;" class="fade-in">
            {{ session('status') }}
        </div>
        @endif

        <form method="POST" action="{{ route('login') }}" id="loginForm">
            @csrf

            <div class="fade-in delay-2">
                <label class="form-label" for="email">Correo electrónico</label>
                <div class="input-wrap">
                    <input type="email" id="email" name="email" value="{{ old('email') }}"
                           required autofocus placeholder="tu@correo.com">
                    <span class="input-icon">
                        <svg viewBox="0 0 24 24"><path d="M20 4H4c-1.1 0-2 .9-2 2v12c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2zm0 4l-8 5-8-5V6l8 5 8-5v2z"/></svg>
                    </span>
                </div>
            </div>

            <div class="fade-in delay-3">
                <label class="form-label" for="password">Contraseña</label>
                <div class="input-wrap">
                    <input type="password" id="password" name="password"
                           required placeholder="••••••••">
                    <span class="input-icon" id="pwdToggle" style="cursor:pointer;" onclick="togglePwd()" title="Mostrar/ocultar contraseña">
                        <svg id="eyeIcon" viewBox="0 0 24 24"><path d="M12 4.5C7 4.5 2.73 7.61 1 12c1.73 4.39 6 7.5 11 7.5s9.27-3.11 11-7.5c-1.73-4.39-6-7.5-11-7.5zM12 17c-2.76 0-5-2.24-5-5s2.24-5 5-5 5 2.24 5 5-2.24 5-5 5zm0-8c-1.66 0-3 1.34-3 3s1.34 3 3 3 3-1.34 3-3-1.34-3-3-3z"/></svg>
                    </span>
                </div>
            </div>

            <div class="fade-in delay-4">
                <button type="submit" class="btn-login" id="loginBtn">
                    <span class="btn-text">Iniciar sesión</span>
                    <div class="btn-spinner"></div>
                </button>
            </div>
        </form>

        <div class="info-box fade-in delay-5">
            <svg viewBox="0 0 20 20" fill="currentColor" style="width:15px;height:15px;flex-shrink:0"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/></svg>
            <span>¿Sin cuenta? Contacta al <strong>administrador</strong>: <a href="mailto:mario.alvarezr@campusucc.edu.co" style="color:#f97316;text-decoration:none;font-weight:600;">mario.alvarezr@campusucc.edu.co</a></span>
        </div>

    </div>

    <!-- RIGHT: Illustration -->
    <div class="panel-illustration">
        <div class="illus-orb illus-orb-1"></div>
        <div class="illus-orb illus-orb-2"></div>

        <div class="illus-inner">
            <img src="{{ asset('images/login-illustration.svg') }}"
                 alt="Secure login" class="illus-img">

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
                    Plataforma alineada al estándar ISO/IEC 27001 para identificar, evaluar y tratar riesgos sobre activos críticos de la organización.
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
</div>

<script>
// Theme toggle
var MOON = '<svg xmlns="http://www.w3.org/2000/svg" width="17" height="17" viewBox="0 0 24 24" fill="currentColor"><path d="M21 12.79A9 9 0 1111.21 3a7 7 0 109.79 9.79z"/></svg>';
var SUN  = '<svg xmlns="http://www.w3.org/2000/svg" width="17" height="17" viewBox="0 0 24 24" fill="currentColor"><circle cx="12" cy="12" r="5"/><line x1="12" y1="1" x2="12" y2="3" stroke="currentColor" stroke-width="2" stroke-linecap="round"/><line x1="12" y1="21" x2="12" y2="23" stroke="currentColor" stroke-width="2" stroke-linecap="round"/><line x1="4.22" y1="4.22" x2="5.64" y2="5.64" stroke="currentColor" stroke-width="2" stroke-linecap="round"/><line x1="18.36" y1="18.36" x2="19.78" y2="19.78" stroke="currentColor" stroke-width="2" stroke-linecap="round"/><line x1="1" y1="12" x2="3" y2="12" stroke="currentColor" stroke-width="2" stroke-linecap="round"/><line x1="21" y1="12" x2="23" y2="12" stroke="currentColor" stroke-width="2" stroke-linecap="round"/><line x1="4.22" y1="19.78" x2="5.64" y2="18.36" stroke="currentColor" stroke-width="2" stroke-linecap="round"/><line x1="18.36" y1="5.64" x2="19.78" y2="4.22" stroke="currentColor" stroke-width="2" stroke-linecap="round"/></svg>';
function updateThemeIcon(t) {
    var btn = document.getElementById('loginThemeToggle');
    if (btn) btn.innerHTML = t === 'dark' ? SUN : MOON;
}
function loginToggleTheme() {
    var curr = document.documentElement.getAttribute('data-theme');
    var next = curr === 'dark' ? 'light' : 'dark';
    document.documentElement.setAttribute('data-theme', next);
    localStorage.setItem('rg-theme', next);
    updateThemeIcon(next);
}
updateThemeIcon(document.documentElement.getAttribute('data-theme'));

// Password toggle
function togglePwd() {
    var input = document.getElementById('password');
    var icon = document.getElementById('eyeIcon');
    if (input.type === 'password') {
        input.type = 'text';
        icon.innerHTML = '<path d="M12 7c2.76 0 5 2.24 5 5 0 .65-.13 1.26-.36 1.83l2.92 2.92c1.51-1.26 2.7-2.89 3.43-4.75-1.73-4.39-6-7.5-11-7.5-1.4 0-2.74.25-3.98.7l2.16 2.16C10.74 7.13 11.35 7 12 7zM2 4.27l2.28 2.28.46.46C3.08 8.3 1.78 10.02 1 12c1.73 4.39 6 7.5 11 7.5 1.55 0 3.03-.3 4.38-.84l.42.42L19.73 22 21 20.73 3.27 3 2 4.27zM7.53 9.8l1.55 1.55c-.05.21-.08.43-.08.65 0 1.66 1.34 3 3 3 .22 0 .44-.03.65-.08l1.55 1.55c-.67.33-1.41.53-2.2.53-2.76 0-5-2.24-5-5 0-.79.2-1.53.53-2.2zm4.31-.78l3.15 3.15.02-.16c0-1.66-1.34-3-3-3l-.17.01z"/>';
    } else {
        input.type = 'password';
        icon.innerHTML = '<path d="M12 4.5C7 4.5 2.73 7.61 1 12c1.73 4.39 6 7.5 11 7.5s9.27-3.11 11-7.5c-1.73-4.39-6-7.5-11-7.5zM12 17c-2.76 0-5-2.24-5-5s2.24-5 5-5 5 2.24 5 5-2.24 5-5 5zm0-8c-1.66 0-3 1.34-3 3s1.34 3 3 3 3-1.34 3-3-1.34-3-3-3z"/>';
    }
}

// Btn loading state on submit
document.getElementById('loginForm').addEventListener('submit', function() {
    var btn = document.getElementById('loginBtn');
    btn.classList.add('loading');
});
</script>
</body>
</html>

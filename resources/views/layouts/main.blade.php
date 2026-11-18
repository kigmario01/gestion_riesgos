<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=5.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'RiskGuard TI') — Gestión de Riesgos</title>
    <meta name="description" content="@yield('meta-description', 'RiskGuard TI — Sistema de Gestión de Seguridad de la Información basado en ISO/IEC 27001. Gestiona riesgos, activos, amenazas y planes de mitigación.')">
    <meta name="robots" content="noindex, nofollow">
    <link rel="icon" type="image/png" href="{{ asset('images/logo.png') }}">
    <link rel="apple-touch-icon" href="{{ asset('images/logo.png') }}">
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link rel="preload" href="https://fonts.bunny.net/css?family=inter:400,500,600,700,800&display=swap" as="style" onload="this.onload=null;this.rel='stylesheet'">
    <noscript><link href="https://fonts.bunny.net/css?family=inter:400,500,600,700,800&display=swap" rel="stylesheet"></noscript>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('styles')
    <script>
        (function(){
            var t = localStorage.getItem('rg-theme') || 'light';
            document.documentElement.setAttribute('data-theme', t);
        })();
    </script>
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
        html { scroll-behavior: smooth; }
        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            background: #f8fafc;
            color: #1e293b;
            min-height: 100vh;
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
            overflow-x: hidden;
        }

        /* ══ ACCESSIBILITY SKIP LINK ══ */
        .skip-link {
            position: absolute; top: -100px; left: 16px; z-index: 9999;
            background: #f97316; color: #fff; padding: 8px 18px;
            border-radius: 0 0 10px 10px; font-weight: 700; font-size: 13px;
            text-decoration: none; box-shadow: 0 4px 14px rgba(249,115,22,0.4);
            transition: top 0.2s cubic-bezier(0.16, 1, 0.3, 1);
        }
        .skip-link:focus { top: 0; }

        /* ══ SIDEBAR BACKDROP (Mobile) ══ */
        .sidebar-backdrop {
            position: fixed; inset: 0;
            background: rgba(15, 23, 42, 0.55);
            backdrop-filter: blur(4px); -webkit-backdrop-filter: blur(4px);
            z-index: 1040; opacity: 0; pointer-events: none;
            transition: opacity 0.25s cubic-bezier(0.16, 1, 0.3, 1);
        }
        body.sidebar-open .sidebar-backdrop {
            opacity: 1; pointer-events: auto;
        }

        /* ══ SIDEBAR ══ */
        .sidebar {
            width: 240px; height: 100vh;
            background: #ffffff;
            border-right: 1px solid #e8eaf0;
            display: flex; flex-direction: column;
            position: fixed; top: 0; left: 0; z-index: 1050;
            box-shadow: 2px 0 16px rgba(0,0,0,0.04);
            transition: transform 0.3s cubic-bezier(0.16, 1, 0.3, 1), box-shadow 0.3s ease;
        }

        /* Sidebar Header */
        .sidebar-header {
            padding: 18px 16px 16px;
            display: flex; align-items: center; justify-content: space-between;
            border-bottom: 1px solid #f1f5f9;
            flex-shrink: 0;
        }
        .sidebar-brand-wrap {
            display: flex; align-items: center; gap: 11px; text-decoration: none;
        }
        .sidebar-logo {
            width: 38px; height: 38px; flex-shrink: 0;
            border-radius: 11px; display: flex; align-items: center; justify-content: center;
            overflow: hidden;
            box-shadow: 0 4px 14px rgba(249,115,22,0.35); text-decoration: none;
            transition: transform 0.2s cubic-bezier(0.34, 1.56, 0.64, 1);
        }
        .sidebar-logo img { width: 100%; height: 100%; object-fit: cover; display: block; }
        .sidebar-brand-wrap:hover .sidebar-logo { transform: scale(1.08) rotate(-2deg); }
        .sidebar-app-name {
            font-size: 14px; font-weight: 800; color: #1e3a8a;
            letter-spacing: -0.2px; line-height: 1.2;
        }
        .sidebar-app-sub {
            font-size: 10.5px; color: #94a3b8; font-weight: 500;
        }
        .sidebar-close-btn {
            display: none; width: 32px; height: 32px; border-radius: 8px;
            background: #f1f5f9; border: none; color: #64748b;
            cursor: pointer; align-items: center; justify-content: center;
            font-size: 14px; transition: all 0.15s ease;
        }
        .sidebar-close-btn:hover { background: #fee2e2; color: #dc2626; }

        /* Sidebar Usuario */
        .sidebar-user {
            padding: 13px 16px;
            display: flex; align-items: center; gap: 10px;
            border-bottom: 1px solid #f1f5f9;
            flex-shrink: 0; text-decoration: none;
            transition: background 0.15s ease;
        }
        .sidebar-user:hover { background: #fff7ed; }
        .sidebar-user-avatar {
            width: 36px; height: 36px; border-radius: 50%; flex-shrink: 0;
            background: linear-gradient(135deg, #f97316, #ea580c);
            display: flex; align-items: center; justify-content: center;
            font-weight: 800; font-size: 11.5px; color: #fff;
            border: 2px solid #fed7aa;
            box-shadow: 0 2px 8px rgba(249,115,22,0.25);
        }
        .sidebar-user-name {
            font-size: 12.5px; font-weight: 700; color: #1e293b;
            white-space: nowrap; overflow: hidden; text-overflow: ellipsis;
        }
        .sidebar-user-role {
            font-size: 10.5px; color: #94a3b8; font-weight: 500;
        }

        /* Sidebar Nav */
        .sidebar-nav {
            flex: 1; overflow-y: auto; overflow-x: hidden;
            padding: 12px 10px;
            scrollbar-width: thin;
            scrollbar-color: #e2e8f0 transparent;
        }
        .sidebar-nav::-webkit-scrollbar { width: 4px; }
        .sidebar-nav::-webkit-scrollbar-thumb { background: #e2e8f0; border-radius: 4px; }

        .nav-section-label {
            font-size: 9.5px; font-weight: 800; letter-spacing: 1.1px;
            color: #94a3b8; text-transform: uppercase;
            padding: 14px 10px 6px; display: block;
        }
        .nav-section-label:first-child { padding-top: 2px; }

        .nav-item {
            display: flex; align-items: center; gap: 11px;
            padding: 9px 12px; border-radius: 10px;
            color: #475569; font-size: 13px; font-weight: 500;
            text-decoration: none; cursor: pointer;
            transition: all 0.18s cubic-bezier(0.16, 1, 0.3, 1);
            margin-bottom: 3px; white-space: nowrap;
            position: relative;
        }
        .nav-item i { width: 17px; text-align: center; font-size: 13.5px; flex-shrink: 0; transition: transform 0.18s ease; }
        .nav-item:hover {
            background: #fff7ed;
            color: #ea580c;
            transform: translateX(3px);
        }
        .nav-item:hover i { color: #f97316; transform: scale(1.15); }
        .nav-item:active { transform: scale(0.98); }
        .nav-item.active {
            background: linear-gradient(135deg, #f97316 0%, #ea580c 100%);
            color: #fff; font-weight: 700;
            box-shadow: 0 4px 14px rgba(249,115,22,0.32);
        }
        .nav-item.active i { color: #fff; }

        /* Logout */
        .sidebar-bottom {
            padding: 12px 14px;
            border-top: 1px solid #f1f5f9;
            flex-shrink: 0;
        }
        .logout-btn {
            display: flex; align-items: center; gap: 10px;
            width: 100%; padding: 10px 12px; border-radius: 10px;
            background: #fef2f2; border: 1px solid #fecaca;
            color: #dc2626; font-size: 12.5px; font-weight: 600;
            cursor: pointer; font-family: inherit;
            transition: all 0.18s cubic-bezier(0.16, 1, 0.3, 1);
            text-align: left;
        }
        .logout-btn i { width: 16px; text-align: center; font-size: 13px; }
        .logout-btn:hover { background: #fee2e2; color: #b91c1c; transform: translateY(-1px); }
        .logout-btn:active { transform: scale(0.98); }

        /* ══ APP WRAPPER ══ */
        .app-wrapper {
            margin-left: 240px; min-height: 100vh;
            display: flex; flex-direction: column;
            transition: margin-left 0.3s cubic-bezier(0.16, 1, 0.3, 1);
        }

        /* ══ TOPBAR ══ */
        .topbar {
            height: 64px; background: rgba(255, 255, 255, 0.90);
            backdrop-filter: blur(12px); -webkit-backdrop-filter: blur(12px);
            border-bottom: 1px solid #e8eaf0;
            padding: 0 24px; display: flex; align-items: center; gap: 14px;
            position: sticky; top: 0; z-index: 100;
            box-shadow: 0 1px 3px rgba(0,0,0,0.02);
        }
        .sidebar-toggle-btn {
            display: none; width: 38px; height: 38px; border-radius: 10px;
            background: #f5f6fb; border: 1.5px solid #e8eaf0;
            color: #1e293b; align-items: center; justify-content: center;
            cursor: pointer; font-size: 15px; flex-shrink: 0;
            transition: all 0.18s ease;
        }
        .sidebar-toggle-btn:hover { border-color: #f97316; color: #f97316; background: #fff7ed; }
        .sidebar-toggle-btn:active { transform: scale(0.95); }

        .topbar-left { display: flex; align-items: center; gap: 12px; flex-shrink: 0; min-width: 0; }
        .topbar-icon {
            width: 36px; height: 36px; border-radius: 10px; background: #fff7ed;
            display: flex; align-items: center; justify-content: center;
            color: #f97316; font-size: 14px; flex-shrink: 0;
            border: 1px solid #ffedd5;
        }
        .topbar-title {
            font-size: 15px; font-weight: 800; color: #1b1f3b;
            white-space: nowrap; overflow: hidden; text-overflow: ellipsis;
            letter-spacing: -0.2px;
        }

        .topbar-search { flex: 1; max-width: 480px; position: relative; margin: 0 8px; }
        .topbar-search input {
            width: 100%; padding: 9px 40px 9px 38px;
            background: #f5f6fb; border: 1.5px solid #e8eaf0; border-radius: 11px;
            font-size: 13px; color: #374151; outline: none; font-family: inherit;
            transition: all 0.2s cubic-bezier(0.16, 1, 0.3, 1);
        }
        .topbar-search input:focus {
            border-color: #f97316; background: #fff;
            box-shadow: 0 0 0 3px rgba(249,115,22,0.12);
        }
        .topbar-search input::placeholder { color: #9ca3af; }
        .topbar-search-icon {
            position: absolute; left: 13px; top: 50%; transform: translateY(-50%);
            color: #9ca3af; font-size: 13px; pointer-events: none;
        }
        .search-shortcut-badge {
            position: absolute; right: 10px; top: 50%; transform: translateY(-50%);
            font-size: 10px; font-weight: 700; color: #94a3b8;
            background: #e2e8f0; border-radius: 5px; padding: 2px 6px;
            font-family: monospace; pointer-events: none;
        }

        .topbar-right { display: flex; align-items: center; gap: 8px; margin-left: auto; flex-shrink: 0; }
        .topbar-date {
            font-size: 12px; color: #64748b; font-weight: 500;
            padding: 4px 8px; background: #f8fafc; border-radius: 8px; border: 1px solid #f1f5f9;
        }

        .notif-btn {
            width: 38px; height: 38px; border-radius: 10px;
            background: #f5f6fb; border: 1.5px solid #e8eaf0;
            color: #64748b; display: flex; align-items: center; justify-content: center;
            cursor: pointer; font-size: 14px; position: relative; text-decoration: none;
            transition: all 0.18s cubic-bezier(0.16, 1, 0.3, 1);
        }
        .notif-btn:hover {
            border-color: #f97316; color: #f97316; background: #fff7ed;
            transform: translateY(-1px);
        }
        .notif-btn:active { transform: scale(0.95); }

        /* ══ CONTENT ══ */
        .app-content {
            padding: 24px 28px 44px; flex: 1; overflow-y: auto;
        }

        /* ══ PAGE HEADER ══ */
        .page-header {
            display: flex; align-items: flex-start; justify-content: space-between;
            gap: 16px; margin-bottom: 20px; flex-wrap: wrap;
        }
        .page-header-left { display: flex; flex-direction: column; gap: 3px; min-width: 0; }
        .page-title {
            font-size: 20px; font-weight: 800; color: #1b1f3b;
            display: flex; align-items: center; gap: 10px; letter-spacing: -0.3px;
        }
        .page-subtitle { font-size: 13px; color: #64748b; line-height: 1.4; }
        .page-actions { display: flex; align-items: center; gap: 8px; flex-shrink: 0; flex-wrap: wrap; }

        /* ══ FILTER TABS ══ */
        .filter-tabs {
            display: flex; gap: 6px; padding: 6px;
            background: #ffffff; border-radius: 14px; border: 1px solid #e8eaf0;
            margin-bottom: 20px; overflow-x: auto; flex-wrap: nowrap;
            -webkit-overflow-scrolling: touch;
            scrollbar-width: none;
        }
        .filter-tabs::-webkit-scrollbar { display: none; }
        .filter-tab {
            display: flex; align-items: center; gap: 8px;
            padding: 8px 16px; border-radius: 10px;
            font-size: 12.5px; font-weight: 600; color: #64748b;
            cursor: pointer; text-decoration: none;
            transition: all 0.18s cubic-bezier(0.16, 1, 0.3, 1);
            white-space: nowrap; border: none; background: transparent; font-family: inherit;
        }
        .filter-tab:hover { background: #f8fafc; color: #1e293b; transform: translateY(-1px); }
        .filter-tab:active { transform: scale(0.97); }
        .filter-tab.active {
            background: #f97316; color: #fff;
            box-shadow: 0 4px 12px rgba(249,115,22,0.32);
        }
        .filter-tab.active-red   { background: #ef4444; color: #fff; box-shadow: 0 4px 12px rgba(239,68,68,0.32); }
        .filter-tab.active-orange{ background: #f97316; color: #fff; box-shadow: 0 4px 12px rgba(249,115,22,0.32); }
        .filter-tab.active-yellow{ background: #eab308; color: #fff; box-shadow: 0 4px 12px rgba(234,179,8,0.32); }
        .filter-tab.active-green { background: #22c55e; color: #fff; box-shadow: 0 4px 12px rgba(34,197,94,0.32); }
        .tab-count {
            min-width: 20px; height: 20px; border-radius: 6px; padding: 0 6px;
            display: inline-flex; align-items: center; justify-content: center;
            font-size: 11px; font-weight: 700; background: rgba(255,255,255,0.25);
        }
        .filter-tab:not(.active):not(.active-red):not(.active-orange):not(.active-yellow):not(.active-green) .tab-count {
            background: #f1f5f9; color: #475569;
        }

        /* ══ KANBAN BOARD ══ */
        .kanban-board {
            display: grid; grid-template-columns: repeat(4, 1fr);
            gap: 16px; align-items: start;
        }
        .kanban-col { display: flex; flex-direction: column; gap: 12px; }
        .kanban-col-header {
            padding: 10px 14px; border-radius: 11px;
            display: flex; align-items: center; justify-content: space-between;
            font-size: 11.5px; font-weight: 800; letter-spacing: 0.5px; text-transform: uppercase;
        }
        .kch-critico { background: #fef2f2; color: #dc2626; border: 1px solid #fee2e2; }
        .kch-alto    { background: #fff7ed; color: #ea580c; border: 1px solid #ffedd5; }
        .kch-medio   { background: #fefce8; color: #ca8a04; border: 1px solid #fef9c3; }
        .kch-bajo    { background: #f0fdf4; color: #16a34a; border: 1px solid #dcfce7; }
        .kch-count {
            background: rgba(0,0,0,0.08); padding: 2px 8px; border-radius: 8px; font-size: 11px; font-weight: 700;
        }

        /* ══ RISK CARD ══ */
        .risk-card {
            background: #fff; border-radius: 13px; border: 1px solid #e8eaf0;
            overflow: hidden;
            transition: all 0.22s cubic-bezier(0.16, 1, 0.3, 1);
            cursor: pointer; position: relative;
        }
        .risk-card:hover {
            box-shadow: 0 10px 25px -4px rgba(0,0,0,0.08), 0 4px 10px -2px rgba(0,0,0,0.04);
            transform: translateY(-3px); border-color: #cbd5e1;
        }
        .risk-card:active { transform: scale(0.99); }
        .risk-card-stripe { height: 4px; }
        .stripe-critico { background: linear-gradient(90deg, #ef4444, #dc2626); }
        .stripe-alto    { background: linear-gradient(90deg, #f97316, #ea580c); }
        .stripe-medio   { background: linear-gradient(90deg, #eab308, #ca8a04); }
        .stripe-bajo    { background: linear-gradient(90deg, #22c55e, #16a34a); }
        .risk-card-body { padding: 14px 16px; }
        .risk-card-top { display: flex; align-items: center; justify-content: space-between; margin-bottom: 10px; }
        .risk-card-tags { display: flex; align-items: center; gap: 6px; flex-wrap: wrap; }
        .rc-tag { font-size: 10px; font-weight: 800; padding: 3px 8px; border-radius: 6px; letter-spacing: 0.3px; }
        .rc-tag-tipo { background: #eff6ff; color: #1d4ed8; }
        .rc-tag-critico { background: #fef2f2; color: #dc2626; border: 1px solid #fee2e2; }
        .rc-tag-alto    { background: #fff7ed; color: #ea580c; border: 1px solid #ffedd5; }
        .rc-tag-medio   { background: #fefce8; color: #ca8a04; border: 1px solid #fef9c3; }
        .rc-tag-bajo    { background: #f0fdf4; color: #16a34a; border: 1px solid #dcfce7; }
        .risk-card-title {
            font-size: 13.5px; font-weight: 700; color: #1e293b;
            margin-bottom: 6px; line-height: 1.4;
        }
        .risk-card-path {
            font-size: 11.5px; color: #64748b; margin-bottom: 10px;
            display: flex; align-items: center; gap: 5px;
        }
        .risk-card-meta {
            display: flex; align-items: center; gap: 10px;
            font-size: 11px; color: #64748b; margin-bottom: 12px; flex-wrap: wrap;
        }
        .rc-meta-item {
            display: flex; align-items: center; gap: 4px; font-weight: 500;
            background: #f8fafc; padding: 2px 7px; border-radius: 6px;
        }
        .risk-card-footer {
            display: flex; align-items: center; justify-content: space-between;
            padding-top: 10px; border-top: 1px solid #f1f5f9;
        }
        .rc-assignee { display: flex; align-items: center; gap: 8px; }
        .rc-avatar {
            width: 26px; height: 26px; border-radius: 50%;
            background: #f97316; display: flex; align-items: center; justify-content: center;
            font-size: 9.5px; font-weight: 800; color: #fff; flex-shrink: 0;
        }
        .rc-name { font-size: 12px; font-weight: 600; color: #374151; }
        .rc-id {
            font-size: 10.5px; color: #64748b; background: #f1f5f9;
            padding: 3px 8px; border-radius: 6px; border: 1px solid #e2e8f0;
            font-family: monospace; font-weight: 600;
        }
        .rc-valor {
            width: 32px; height: 32px; border-radius: 9px;
            display: flex; align-items: center; justify-content: center;
            font-weight: 800; font-size: 14px; flex-shrink: 0;
        }
        .rcv-critico { background: #fef2f2; color: #dc2626; border: 1px solid #fecaca; }
        .rcv-alto    { background: #fff7ed; color: #ea580c; border: 1px solid #fed7aa; }
        .rcv-medio   { background: #fefce8; color: #ca8a04; border: 1px solid #fef08a; }
        .rcv-bajo    { background: #f0fdf4; color: #16a34a; border: 1px solid #bbf7d0; }

        /* ══ STATS CARDS ══ */
        .stats-grid {
            display: grid; grid-template-columns: repeat(4, 1fr);
            gap: 16px; margin-bottom: 20px;
        }
        .stat-card {
            background: #fff; border-radius: 14px; border: 1px solid #e8eaf0;
            padding: 18px 20px; display: flex; align-items: center; gap: 16px;
            transition: all 0.22s cubic-bezier(0.16, 1, 0.3, 1);
            position: relative; overflow: hidden;
        }
        .stat-card:hover {
            box-shadow: 0 10px 25px -4px rgba(0,0,0,0.08), 0 4px 10px -2px rgba(0,0,0,0.03);
            transform: translateY(-2px); border-color: #cbd5e1;
        }
        .stat-card:active { transform: scale(0.99); }
        .stat-icon {
            width: 48px; height: 48px; border-radius: 13px;
            display: flex; align-items: center; justify-content: center;
            font-size: 19px; flex-shrink: 0;
            transition: transform 0.2s cubic-bezier(0.34, 1.56, 0.64, 1);
        }
        .stat-card:hover .stat-icon { transform: scale(1.1); }
        .si-red    { background: #fef2f2; color: #ef4444; border: 1px solid #fee2e2; }
        .si-orange { background: #fff7ed; color: #f97316; border: 1px solid #ffedd5; }
        .si-yellow { background: #fefce8; color: #eab308; border: 1px solid #fef9c3; }
        .si-green  { background: #f0fdf4; color: #22c55e; border: 1px solid #dcfce7; }
        .si-blue   { background: #eff6ff; color: #2563eb; border: 1px solid #dbeafe; }
        .si-purple { background: #fdf4ff; color: #9333ea; border: 1px solid #fae8ff; }
        .si-slate  { background: #f8fafc; color: #64748b; border: 1px solid #e2e8f0; }
        .si-indigo { background: #eef2ff; color: #6366f1; border: 1px solid #e0e7ff; }
        .stat-num { font-size: 32px; font-weight: 800; color: #1b1f3b; line-height: 1; letter-spacing: -0.5px; }
        .stat-lbl { font-size: 12px; color: #64748b; margin-top: 4px; font-weight: 600; }
        .stat-trend {
            font-size: 11px; font-weight: 700; display: inline-flex;
            align-items: center; gap: 4px; margin-top: 5px; padding: 2px 7px; border-radius: 6px;
        }
        .trend-up   { background: #fef2f2; color: #dc2626; }
        .trend-down { background: #f0fdf4; color: #16a34a; }
        .trend-neutral { background: #f1f5f9; color: #64748b; }

        /* ══ PANELS ══ */
        .panel {
            background: #fff; border-radius: 14px; border: 1px solid #e8eaf0;
            overflow: hidden; margin-bottom: 20px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.02);
            transition: border-color 0.18s ease;
        }
        .panel-header {
            padding: 16px 20px; border-bottom: 1px solid #f1f5f9;
            display: flex; align-items: center; justify-content: space-between; gap: 12px;
            flex-wrap: wrap;
        }
        .panel-title {
            font-size: 14px; font-weight: 700; color: #1e293b;
            display: flex; align-items: center; gap: 8px; letter-spacing: -0.2px;
        }
        .panel-title i { color: #f97316; font-size: 14px; }
        .panel-subtitle { font-size: 12px; color: #94a3b8; }

        /* ══ TABLES & RESPONSIVE CONTAINERS ══ */
        .table-responsive {
            width: 100%; overflow-x: auto; -webkit-overflow-scrolling: touch;
        }
        .table { width: 100%; border-collapse: collapse; min-width: 600px; }
        .table th {
            padding: 11px 16px; text-align: left; font-size: 11px; font-weight: 700;
            color: #64748b; text-transform: uppercase; letter-spacing: 0.6px;
            background: #f8fafc; border-bottom: 1px solid #e8eaf0; white-space: nowrap;
        }
        .table td {
            padding: 14px 16px; font-size: 13px; color: #374151;
            border-bottom: 1px solid #f5f6fa; vertical-align: middle;
            transition: background 0.12s ease;
        }
        .table tr:last-child td { border-bottom: none; }
        .table tr:hover td { background: #fafbff; }

        /* ══ BADGES ══ */
        .badge {
            display: inline-flex; align-items: center; gap: 5px;
            padding: 3px 10px; border-radius: 20px; font-size: 11.5px; font-weight: 700;
            line-height: 1.2;
        }
        .badge-dot { width: 6px; height: 6px; border-radius: 50%; background: currentColor; }
        .badge-critico, .badge-critica { background: #fef2f2; color: #dc2626; border: 1px solid #fee2e2; }
        .badge-alto, .badge-alta       { background: #fff7ed; color: #ea580c; border: 1px solid #ffedd5; }
        .badge-medio, .badge-media     { background: #fefce8; color: #ca8a04; border: 1px solid #fef9c3; }
        .badge-bajo, .badge-baja       { background: #f0fdf4; color: #16a34a; border: 1px solid #dcfce7; }
        .badge-activo, .badge-activa, .badge-completado, .badge-exitoso, .badge-natural { background: #f0fdf4; color: #16a34a; border: 1px solid #bbf7d0; }
        .badge-inactivo, .badge-inactiva, .badge-cancelado, .badge-fallido, .badge-deliberada, .badge-urgente { background: #fef2f2; color: #dc2626; border: 1px solid #fecaca; }
        .badge-en_mantenimiento, .badge-en_progreso, .badge-en_proceso, .badge-accidental, .badge-cerrada { background: #eff6ff; color: #1d4ed8; border: 1px solid #bfdbfe; }
        .badge-pendiente, .badge-borrador, .badge-manual { background: #f8fafc; color: #64748b; border: 1px solid #e2e8f0; }
        .badge-vencido, .badge-reevaluacion, .badge-interno { background: #fff7ed; color: #ea580c; border: 1px solid #fed7aa; }
        .badge-humana, .badge-automatico { background: #fdf4ff; color: #9333ea; border: 1px solid #fae8ff; }
        .badge-ambiental, .badge-tecnica { background: #fefce8; color: #ca8a04; border: 1px solid #fef08a; }

        /* ══ BUTTONS ══ */
        .btn {
            display: inline-flex; align-items: center; justify-content: center; gap: 7px;
            padding: 9px 16px; border-radius: 10px; font-size: 13px; font-weight: 600;
            cursor: pointer; border: none; text-decoration: none;
            transition: all 0.18s cubic-bezier(0.16, 1, 0.3, 1);
            white-space: nowrap; font-family: inherit; line-height: 1;
        }
        .btn:active { transform: scale(0.97); }
        .btn-sm  { padding: 7px 13px; font-size: 12px; border-radius: 8px; }
        .btn-xs  { padding: 4px 9px; font-size: 11px; border-radius: 7px; }
        .btn-primary {
            background: linear-gradient(135deg, #f97316 0%, #ea580c 100%);
            color: #fff; box-shadow: 0 4px 14px rgba(249,115,22,0.30);
        }
        .btn-primary:hover {
            opacity: 0.95; transform: translateY(-1px);
            box-shadow: 0 6px 18px rgba(249,115,22,0.40);
        }
        .btn-secondary { background: #1e3a8a; color: #fff; }
        .btn-secondary:hover { background: #1d4ed8; transform: translateY(-1px); }
        .btn-outline {
            background: #fff; color: #475569; border: 1.5px solid #e8eaf0;
        }
        .btn-outline:hover {
            border-color: #f97316; color: #f97316; background: #fff7ed;
            transform: translateY(-1px);
        }
        .btn-success { background: #f0fdf4; color: #16a34a; border: 1px solid #bbf7d0; }
        .btn-success:hover { background: #dcfce7; transform: translateY(-1px); }
        .btn-danger  { background: #fef2f2; color: #dc2626; border: 1px solid #fecaca; }
        .btn-danger:hover  { background: #fee2e2; transform: translateY(-1px); }
        .btn-warning { background: #fffbeb; color: #b45309; border: 1px solid #fde68a; }
        .btn-warning:hover { background: #fef3c7; transform: translateY(-1px); }
        .btn-ghost   { background: transparent; color: #64748b; }
        .btn-ghost:hover { background: #f5f6fb; color: #374151; }

        /* ══ ALERTS ══ */
        .alert {
            display: flex; align-items: flex-start; gap: 12px;
            padding: 13px 18px; border-radius: 12px; border: 1px solid;
            margin-bottom: 18px; font-size: 13px; font-weight: 500; line-height: 1.5;
            animation: fadeInAlert 0.25s ease-out;
        }
        @keyframes fadeInAlert {
            from { opacity: 0; transform: translateY(-6px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .alert i { margin-top: 2px; flex-shrink: 0; font-size: 15px; }
        .alert-success { background: #f0fdf4; border-color: #bbf7d0; color: #15803d; }
        .alert-error   { background: #fef2f2; border-color: #fecaca; color: #dc2626; }
        .alert-warning { background: #fffbeb; border-color: #fde68a; color: #b45309; }
        .alert-info    { background: #eff6ff; border-color: #bfdbfe; color: #1d4ed8; }

        /* ══ FORMS ══ */
        .form-card {
            background: #fff; border-radius: 14px; border: 1px solid #e8eaf0;
            overflow: hidden; max-width: 880px; box-shadow: 0 1px 3px rgba(0,0,0,0.02);
        }
        .form-header { padding: 22px 26px; border-bottom: 1px solid #f1f5f9; }
        .form-header h2 {
            font-size: 17px; font-weight: 700; color: #1b1f3b;
            display: flex; align-items: center; gap: 10px;
        }
        .form-header h2 i { color: #f97316; }
        .form-header p { font-size: 12.5px; color: #64748b; margin-top: 5px; }
        .form-body { padding: 24px 26px; }
        .form-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 18px; }
        .form-group { display: flex; flex-direction: column; gap: 6px; }
        .form-group.full { grid-column: 1 / -1; }
        label { font-size: 12.5px; font-weight: 600; color: #374151; }
        label .req, label span.req { color: #ef4444; }
        input, select, textarea {
            padding: 10px 14px; border: 1.5px solid #e8eaf0; border-radius: 10px;
            font-size: 13px; color: #1e293b; font-family: inherit; outline: none;
            transition: all 0.18s ease; background: #fff; width: 100%;
        }
        input:focus, select:focus, textarea:focus {
            border-color: #f97316; box-shadow: 0 0 0 3px rgba(249,115,22,0.12);
        }
        textarea { resize: vertical; min-height: 90px; }
        .error-msg { font-size: 11.5px; color: #dc2626; margin-top: 3px; font-weight: 500; }
        .hint { font-size: 11px; color: #94a3b8; margin-top: 3px; }
        .form-footer {
            padding: 16px 26px; border-top: 1px solid #f1f5f9;
            display: flex; justify-content: flex-end; gap: 10px; background: #f8fafc;
        }

        /* ══ MISC ══ */
        .filter-bar {
            display: flex; gap: 10px; padding: 14px 20px;
            background: #f8fafc; border-bottom: 1px solid #f1f5f9;
            flex-wrap: wrap; align-items: center;
        }
        .filter-input {
            padding: 8px 13px; border: 1.5px solid #e8eaf0; border-radius: 9px;
            font-size: 13px; color: #374151; background: #fff; outline: none;
            font-family: inherit; transition: all 0.18s ease;
        }
        .filter-input:focus { border-color: #f97316; box-shadow: 0 0 0 3px rgba(249,115,22,0.1); }
        .empty-state { padding: 56px 20px; text-align: center; color: #94a3b8; }
        .empty-state i { font-size: 44px; margin-bottom: 14px; display: block; color: #cbd5e1; }
        .empty-state p { font-size: 13.5px; margin-bottom: 16px; }
        .actions { display: flex; gap: 6px; align-items: center; flex-wrap: wrap; }
        code.tag {
            background: #f1f5f9; color: #1e293b; padding: 3px 8px;
            border-radius: 6px; font-size: 12px;
            font-family: 'Cascadia Code', 'Fira Code', monospace; border: 1px solid #e8eaf0;
        }
        .detail-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 20px; padding: 22px 20px; }
        .detail-item { display: flex; flex-direction: column; gap: 5px; }
        .detail-label { font-size: 11px; font-weight: 700; color: #94a3b8; text-transform: uppercase; letter-spacing: 0.7px; }
        .detail-value { font-size: 13.5px; color: #1e293b; font-weight: 600; line-height: 1.4; }
        .text-block { padding: 18px 20px; border-top: 1px solid #f1f5f9; }
        .text-label { font-size: 11px; font-weight: 700; color: #94a3b8; text-transform: uppercase; letter-spacing: 0.7px; margin-bottom: 8px; }
        .text-content {
            font-size: 13px; color: #374151; line-height: 1.6;
            background: #f8fafc; padding: 13px; border-radius: 10px; border: 1px solid #f1f5f9;
        }
        .progress-track { height: 7px; background: #f1f5f9; border-radius: 4px; overflow: hidden; margin-top: 5px; }
        .progress-fill { height: 100%; border-radius: 4px; background: linear-gradient(90deg, #f97316, #ea580c); }

        /* ══ STATUSBAR ══ */
        .statusbar {
            background: #fff; border-top: 1px solid #e8eaf0; padding: 8px 24px;
            display: flex; align-items: center; gap: 18px; font-size: 11.5px; color: #64748b;
            flex-wrap: wrap;
        }
        .statusbar-dot {
            width: 7px; height: 7px; border-radius: 50%; display: inline-block;
            margin-right: 5px; vertical-align: middle;
        }

        /* ══ CARD GRID ══ */
        .card-grid {
            display: grid; grid-template-columns: repeat(auto-fill, minmax(290px, 1fr));
            gap: 16px;
        }
        .item-card {
            background: #fff; border-radius: 14px; border: 1px solid #e8eaf0;
            overflow: hidden; transition: all 0.22s cubic-bezier(0.16, 1, 0.3, 1);
        }
        .item-card:hover {
            box-shadow: 0 10px 25px -4px rgba(0,0,0,0.08), 0 4px 10px -2px rgba(0,0,0,0.03);
            transform: translateY(-2px); border-color: #cbd5e1;
        }
        .item-card-header {
            padding: 16px 18px; border-bottom: 1px solid #f5f6fa;
            display: flex; align-items: center; gap: 13px;
        }
        .item-card-icon {
            width: 44px; height: 44px; border-radius: 12px;
            display: flex; align-items: center; justify-content: center;
            font-size: 18px; flex-shrink: 0;
        }
        .item-card-body { padding: 15px 18px; }
        .item-card-footer {
            padding: 12px 18px; background: #fafbff; border-top: 1px solid #f5f6fa;
            display: flex; align-items: center; justify-content: space-between; gap: 8px;
        }
        .item-card-name { font-size: 14.5px; font-weight: 700; color: #1b1f3b; }
        .item-card-sub { font-size: 11.5px; color: #94a3b8; margin-top: 2px; }
        .item-stat-row { display: flex; gap: 12px; margin-top: 12px; flex-wrap: wrap; }
        .item-stat {
            flex: 1; min-width: 70px; background: #f5f6fb; border-radius: 9px;
            padding: 9px 12px; text-align: center;
        }
        .item-stat-num { font-size: 20px; font-weight: 800; color: #f97316; }
        .item-stat-lbl { font-size: 10px; color: #94a3b8; text-transform: uppercase; font-weight: 600; margin-top: 2px; }

        /* ══ DASHBOARD BOTTOM GRID ══ */
        .dashboard-bottom-grid {
            display: grid; grid-template-columns: 1fr 340px; gap: 18px; padding-bottom: 32px;
        }

        /* ══ RESPONSIVE BREAKPOINTS (Mobile-First / Fluid Media Queries) ══ */
        @media (max-width: 1200px) {
            .kanban-board { grid-template-columns: repeat(2, 1fr); }
        }

        @media (max-width: 1024px) {
            .sidebar {
                transform: translateX(-100%);
                width: 270px; max-width: 85vw;
                box-shadow: 10px 0 30px rgba(0,0,0,0.15);
            }
            body.sidebar-open .sidebar {
                transform: translateX(0);
            }
            .sidebar-close-btn { display: flex; }
            .app-wrapper { margin-left: 0 !important; width: 100%; }
            .sidebar-toggle-btn { display: flex; }
            .stats-grid { grid-template-columns: repeat(2, 1fr); gap: 12px; }
            .dashboard-bottom-grid { grid-template-columns: 1fr; }
        }

        @media (max-width: 768px) {
            .topbar { height: 58px; padding: 0 16px; gap: 10px; }
            .topbar-date { display: none; }
            .topbar-title { font-size: 13.5px; }
            .app-content { padding: 18px 16px 36px; }
            .form-grid { grid-template-columns: 1fr; }
            .detail-grid { grid-template-columns: 1fr; padding: 16px 14px; }
            .form-body, .form-header, .form-footer { padding: 18px 18px; }
            .stat-num { font-size: 28px; }
            .page-header { margin-bottom: 16px; }
            .page-title { font-size: 18px; }
            .search-shortcut-badge { display: none; }
        }

        @media (max-width: 640px) {
            .kanban-board { grid-template-columns: 1fr; gap: 14px; }
            .stats-grid { grid-template-columns: 1fr; gap: 10px; }
            .card-grid { grid-template-columns: 1fr; }
            .topbar-search { margin: 0 4px; }
            .page-actions { width: 100%; justify-content: flex-start; }
            .page-actions .btn { flex: 1; text-align: center; }
            .filter-tab { padding: 7px 12px; font-size: 12px; }
        }

        /* ══════════════════════════════════════════════════
           🌙 PRO DARK MODE (Refined Slate & Luminous Accents)
        ══════════════════════════════════════════════════ */
        [data-theme="dark"] body {
            background: #090d16 !important;
            color: #e2e8f0 !important;
        }

        /* ── Sidebar & Topbar ── */
        [data-theme="dark"] .sidebar {
            background: #0d1527 !important;
            border-right: 1px solid rgba(255, 255, 255, 0.08) !important;
            box-shadow: 4px 0 24px rgba(0, 0, 0, 0.4) !important;
        }
        [data-theme="dark"] .sidebar-header {
            border-bottom: 1px solid rgba(255, 255, 255, 0.06) !important;
        }
        [data-theme="dark"] .sidebar-app-name { color: #f97316 !important; }
        [data-theme="dark"] .sidebar-app-sub { color: #94a3b8 !important; }
        [data-theme="dark"] .sidebar-close-btn {
            background: #18233c !important;
            color: #cbd5e1 !important;
        }
        [data-theme="dark"] .sidebar-close-btn:hover {
            background: rgba(239, 68, 68, 0.2) !important;
            color: #fca5a5 !important;
        }
        [data-theme="dark"] .sidebar-user {
            border-bottom: 1px solid rgba(255, 255, 255, 0.06) !important;
        }
        [data-theme="dark"] .sidebar-user:hover {
            background: rgba(255, 255, 255, 0.04) !important;
        }
        [data-theme="dark"] .sidebar-user-name { color: #f1f5f9 !important; }
        [data-theme="dark"] .sidebar-user-role { color: #94a3b8 !important; }
        [data-theme="dark"] .sidebar-nav {
            scrollbar-color: #1e2d4d transparent !important;
        }
        [data-theme="dark"] .sidebar-nav::-webkit-scrollbar-thumb {
            background: #1e2d4d !important;
        }
        [data-theme="dark"] .nav-section-label { color: #64748b !important; }
        [data-theme="dark"] .nav-item {
            color: #cbd5e1 !important;
        }
        [data-theme="dark"] .nav-item i { color: #94a3b8 !important; }
        [data-theme="dark"] .nav-item:hover {
            background: rgba(249, 115, 22, 0.14) !important;
            color: #fb923c !important;
        }
        [data-theme="dark"] .nav-item:hover i { color: #f97316 !important; }
        [data-theme="dark"] .nav-item.active {
            background: linear-gradient(135deg, #f97316 0%, #ea580c 100%) !important;
            color: #ffffff !important;
            box-shadow: 0 4px 18px rgba(249, 115, 22, 0.45) !important;
        }
        [data-theme="dark"] .nav-item.active i { color: #ffffff !important; }
        [data-theme="dark"] .sidebar-bottom {
            border-top: 1px solid rgba(255, 255, 255, 0.06) !important;
        }
        [data-theme="dark"] .logout-btn {
            background: rgba(239, 68, 68, 0.12) !important;
            border: 1px solid rgba(239, 68, 68, 0.25) !important;
            color: #f87171 !important;
        }
        [data-theme="dark"] .logout-btn:hover {
            background: rgba(239, 68, 68, 0.22) !important;
            color: #fca5a5 !important;
        }
        [data-theme="dark"] .topbar {
            background: rgba(13, 21, 39, 0.92) !important;
            backdrop-filter: blur(12px) !important;
            -webkit-backdrop-filter: blur(12px) !important;
            border-bottom: 1px solid rgba(255, 255, 255, 0.08) !important;
            box-shadow: 0 2px 12px rgba(0, 0, 0, 0.3) !important;
        }
        [data-theme="dark"] .sidebar-toggle-btn {
            background: #18233c !important;
            border: 1.5px solid #223254 !important;
            color: #e2e8f0 !important;
        }
        [data-theme="dark"] .sidebar-toggle-btn:hover {
            border-color: #f97316 !important;
            color: #f97316 !important;
            background: rgba(249, 115, 22, 0.14) !important;
        }
        [data-theme="dark"] .topbar-title { color: #f1f5f9 !important; }
        [data-theme="dark"] .topbar-date {
            color: #94a3b8 !important;
            background: #18233c !important;
            border-color: rgba(255, 255, 255, 0.08) !important;
        }
        [data-theme="dark"] .topbar-search input {
            background: #131c33 !important;
            border-color: #223254 !important;
            color: #f1f5f9 !important;
        }
        [data-theme="dark"] .topbar-search input:focus {
            border-color: #f97316 !important;
            background: #18233c !important;
            box-shadow: 0 0 0 3px rgba(249, 115, 22, 0.2) !important;
        }
        [data-theme="dark"] .topbar-search input::placeholder { color: #64748b !important; }
        [data-theme="dark"] .search-shortcut-badge {
            background: #223254 !important;
            color: #94a3b8 !important;
        }
        [data-theme="dark"] .topbar-icon {
            background: rgba(249, 115, 22, 0.14) !important;
            color: #fb923c !important;
            border: 1px solid rgba(249, 115, 22, 0.28) !important;
        }
        [data-theme="dark"] .notif-btn {
            background: #18233c !important;
            border-color: #223254 !important;
            color: #94a3b8 !important;
        }
        [data-theme="dark"] .app-content {
            background: #090d16 !important;
        }
        [data-theme="dark"] .statusbar {
            background: #0d1527 !important;
            border-top: 1px solid rgba(255, 255, 255, 0.08) !important;
            color: #94a3b8 !important;
        }

        /* ── Surfaces & Panels ── */
        [data-theme="dark"] .panel,
        [data-theme="dark"] .form-card,
        [data-theme="dark"] .item-card,
        [data-theme="dark"] .matriz-wrap {
            background: #111a2f !important;
            border: 1px solid rgba(255, 255, 255, 0.08) !important;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.25) !important;
        }
        [data-theme="dark"] .panel-header {
            border-bottom: 1px solid rgba(255, 255, 255, 0.06) !important;
        }
        [data-theme="dark"] .panel-title { color: #f1f5f9 !important; }
        [data-theme="dark"] .panel-subtitle { color: #94a3b8 !important; }

        /* ── Stat Cards ── */
        [data-theme="dark"] .stat-card {
            background: #111a2f !important;
            border: 1px solid rgba(255, 255, 255, 0.08) !important;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.25) !important;
        }
        [data-theme="dark"] .stat-num { color: #f1f5f9 !important; }
        [data-theme="dark"] .stat-lbl { color: #94a3b8 !important; }

        /* ── Stat Icons (Rich translucent glow, no blinding white squares) ── */
        [data-theme="dark"] .si-red    { background: rgba(239, 68, 68, 0.16) !important; color: #f87171 !important; border: 1px solid rgba(239, 68, 68, 0.3) !important; }
        [data-theme="dark"] .si-orange { background: rgba(249, 115, 22, 0.16) !important; color: #fb923c !important; border: 1px solid rgba(249, 115, 22, 0.3) !important; }
        [data-theme="dark"] .si-yellow { background: rgba(234, 179, 8, 0.16) !important; color: #facc15 !important; border: 1px solid rgba(234, 179, 8, 0.3) !important; }
        [data-theme="dark"] .si-green  { background: rgba(34, 197, 94, 0.16) !important; color: #4ade80 !important; border: 1px solid rgba(34, 197, 94, 0.3) !important; }
        [data-theme="dark"] .si-blue   { background: rgba(59, 130, 246, 0.16) !important; color: #60a5fa !important; border: 1px solid rgba(59, 130, 246, 0.3) !important; }
        [data-theme="dark"] .si-purple { background: rgba(168, 85, 247, 0.16) !important; color: #c084fc !important; border: 1px solid rgba(168, 85, 247, 0.3) !important; }
        [data-theme="dark"] .si-slate  { background: rgba(148, 163, 184, 0.12) !important; color: #cbd5e1 !important; border: 1px solid rgba(148, 163, 184, 0.2) !important; }
        [data-theme="dark"] .si-indigo { background: rgba(99, 102, 241, 0.16) !important; color: #a5b4fc !important; border: 1px solid rgba(99, 102, 241, 0.3) !important; }

        /* ── Trends ── */
        [data-theme="dark"] .trend-up      { background: rgba(239, 68, 68, 0.18) !important; color: #f87171 !important; }
        [data-theme="dark"] .trend-down    { background: rgba(34, 197, 94, 0.18) !important; color: #4ade80 !important; }
        [data-theme="dark"] .trend-neutral { background: rgba(148, 163, 184, 0.14) !important; color: #cbd5e1 !important; }

        /* ── Risk Cards (Kanban) ── */
        [data-theme="dark"] .risk-card {
            background: #111a2f !important;
            border: 1px solid rgba(255, 255, 255, 0.08) !important;
            box-shadow: 0 4px 18px rgba(0, 0, 0, 0.25) !important;
        }
        [data-theme="dark"] .risk-card-title { color: #f1f5f9 !important; }
        [data-theme="dark"] .risk-card-path { color: #94a3b8 !important; }
        [data-theme="dark"] .rc-meta-item {
            background: #18233c !important;
            color: #cbd5e1 !important;
            border: 1px solid rgba(255, 255, 255, 0.04) !important;
        }
        [data-theme="dark"] .risk-card-footer {
            border-top: 1px solid rgba(255, 255, 255, 0.06) !important;
        }
        [data-theme="dark"] .rc-id {
            background: #0d1527 !important;
            border: 1px solid rgba(255, 255, 255, 0.08) !important;
            color: #94a3b8 !important;
        }
        [data-theme="dark"] .rc-name { color: #e2e8f0 !important; }

        /* ── Score Values in Risk Cards ── */
        [data-theme="dark"] .rcv-critico { background: rgba(239, 68, 68, 0.2) !important; color: #f87171 !important; border: 1px solid rgba(239, 68, 68, 0.4) !important; }
        [data-theme="dark"] .rcv-alto    { background: rgba(249, 115, 22, 0.2) !important; color: #fb923c !important; border: 1px solid rgba(249, 115, 22, 0.4) !important; }
        [data-theme="dark"] .rcv-medio   { background: rgba(234, 179, 8, 0.2) !important; color: #facc15 !important; border: 1px solid rgba(234, 179, 8, 0.4) !important; }
        [data-theme="dark"] .rcv-bajo    { background: rgba(34, 197, 94, 0.2) !important; color: #4ade80 !important; border: 1px solid rgba(34, 197, 94, 0.4) !important; }

        /* ── Tags in Risk Cards ── */
        [data-theme="dark"] .rc-tag-critico { background: rgba(239, 68, 68, 0.16) !important; color: #f87171 !important; border: 1px solid rgba(239, 68, 68, 0.3) !important; }
        [data-theme="dark"] .rc-tag-alto    { background: rgba(249, 115, 22, 0.16) !important; color: #fb923c !important; border: 1px solid rgba(249, 115, 22, 0.3) !important; }
        [data-theme="dark"] .rc-tag-medio   { background: rgba(234, 179, 8, 0.16) !important; color: #facc15 !important; border: 1px solid rgba(234, 179, 8, 0.3) !important; }
        [data-theme="dark"] .rc-tag-bajo    { background: rgba(34, 197, 94, 0.16) !important; color: #4ade80 !important; border: 1px solid rgba(34, 197, 94, 0.3) !important; }
        [data-theme="dark"] .rc-tag-tipo    { background: rgba(59, 130, 246, 0.16) !important; color: #60a5fa !important; border: 1px solid rgba(59, 130, 246, 0.3) !important; }

        /* ── Badges ── */
        [data-theme="dark"] .badge-critico, [data-theme="dark"] .badge-critica { background: rgba(239, 68, 68, 0.18) !important; color: #f87171 !important; border: 1px solid rgba(239, 68, 68, 0.35) !important; }
        [data-theme="dark"] .badge-alto, [data-theme="dark"] .badge-alta       { background: rgba(249, 115, 22, 0.18) !important; color: #fb923c !important; border: 1px solid rgba(249, 115, 22, 0.35) !important; }
        [data-theme="dark"] .badge-medio, [data-theme="dark"] .badge-media     { background: rgba(234, 179, 8, 0.18) !important; color: #facc15 !important; border: 1px solid rgba(234, 179, 8, 0.35) !important; }
        [data-theme="dark"] .badge-bajo, [data-theme="dark"] .badge-baja       { background: rgba(34, 197, 94, 0.18) !important; color: #4ade80 !important; border: 1px solid rgba(34, 197, 94, 0.35) !important; }
        [data-theme="dark"] .badge-activo, [data-theme="dark"] .badge-activa, [data-theme="dark"] .badge-completado, [data-theme="dark"] .badge-exitoso { background: rgba(34, 197, 94, 0.18) !important; color: #4ade80 !important; border: 1px solid rgba(34, 197, 94, 0.35) !important; }
        [data-theme="dark"] .badge-inactivo, [data-theme="dark"] .badge-fallido, [data-theme="dark"] .badge-cancelado, [data-theme="dark"] .badge-deliberada { background: rgba(239, 68, 68, 0.18) !important; color: #f87171 !important; border: 1px solid rgba(239, 68, 68, 0.35) !important; }
        [data-theme="dark"] .badge-en_mantenimiento, [data-theme="dark"] .badge-en_progreso, [data-theme="dark"] .badge-en_proceso, [data-theme="dark"] .badge-accidental { background: rgba(59, 130, 246, 0.18) !important; color: #60a5fa !important; border: 1px solid rgba(59, 130, 246, 0.35) !important; }
        [data-theme="dark"] .badge-pendiente, [data-theme="dark"] .badge-borrador, [data-theme="dark"] .badge-manual { background: rgba(148, 163, 184, 0.14) !important; color: #cbd5e1 !important; border: 1px solid rgba(148, 163, 184, 0.25) !important; }

        /* ── Kanban Column Headers ── */
        [data-theme="dark"] .kch-critico { background: rgba(239, 68, 68, 0.16) !important; color: #f87171 !important; border: 1px solid rgba(239, 68, 68, 0.3) !important; }
        [data-theme="dark"] .kch-alto    { background: rgba(249, 115, 22, 0.16) !important; color: #fb923c !important; border: 1px solid rgba(249, 115, 22, 0.3) !important; }
        [data-theme="dark"] .kch-medio   { background: rgba(234, 179, 8, 0.16) !important; color: #facc15 !important; border: 1px solid rgba(234, 179, 8, 0.3) !important; }
        [data-theme="dark"] .kch-bajo    { background: rgba(34, 197, 94, 0.16) !important; color: #4ade80 !important; border: 1px solid rgba(34, 197, 94, 0.3) !important; }
        [data-theme="dark"] .kch-count   { background: rgba(255, 255, 255, 0.12) !important; color: #f1f5f9 !important; }
        [data-theme="dark"] .kanban-empty {
            background: #111a2f !important;
            border: 1.5px dashed rgba(255, 255, 255, 0.1) !important;
            color: #64748b !important;
        }

        /* ── Tables ── */
        [data-theme="dark"] .table th {
            background: #0d1527 !important;
            color: #94a3b8 !important;
            border-bottom: 1px solid rgba(255, 255, 255, 0.08) !important;
        }
        [data-theme="dark"] .table td {
            color: #e2e8f0 !important;
            border-bottom: 1px solid rgba(255, 255, 255, 0.05) !important;
        }
        [data-theme="dark"] .table tr:hover td {
            background: rgba(255, 255, 255, 0.04) !important;
        }

        /* ── Filter Tabs ── */
        [data-theme="dark"] .filter-tabs {
            background: #111a2f !important;
            border: 1px solid rgba(255, 255, 255, 0.08) !important;
        }
        [data-theme="dark"] .filter-tab {
            color: #94a3b8 !important;
            background: transparent !important;
        }
        [data-theme="dark"] .filter-tab:hover {
            background: rgba(255, 255, 255, 0.05) !important;
            color: #f1f5f9 !important;
        }
        [data-theme="dark"] .filter-tab.active {
            background: #f97316 !important;
            color: #ffffff !important;
            box-shadow: 0 4px 14px rgba(249, 115, 22, 0.38) !important;
        }
        [data-theme="dark"] .filter-tab:not(.active) .tab-count {
            background: #18233c !important;
            color: #94a3b8 !important;
        }

        /* ── Alerts ── */
        [data-theme="dark"] .alert-error {
            background: rgba(239, 68, 68, 0.12) !important;
            border: 1px solid rgba(239, 68, 68, 0.3) !important;
            color: #fca5a5 !important;
        }
        [data-theme="dark"] .alert-error a {
            color: #f87171 !important;
        }
        [data-theme="dark"] .alert-success {
            background: rgba(34, 197, 94, 0.12) !important;
            border: 1px solid rgba(34, 197, 94, 0.3) !important;
            color: #86efac !important;
        }
        [data-theme="dark"] .alert-warning {
            background: rgba(234, 179, 8, 0.12) !important;
            border: 1px solid rgba(234, 179, 8, 0.3) !important;
            color: #fde047 !important;
        }
        [data-theme="dark"] .alert-info {
            background: rgba(59, 130, 246, 0.12) !important;
            border: 1px solid rgba(59, 130, 246, 0.3) !important;
            color: #93c5fd !important;
        }

        /* ── Forms ── */
        [data-theme="dark"] .form-header {
            border-bottom: 1px solid rgba(255, 255, 255, 0.06) !important;
        }
        [data-theme="dark"] .form-header h2 { color: #f1f5f9 !important; }
        [data-theme="dark"] .form-footer {
            background: #0d1527 !important;
            border-top: 1px solid rgba(255, 255, 255, 0.06) !important;
        }
        [data-theme="dark"] input,
        [data-theme="dark"] select,
        [data-theme="dark"] textarea {
            background: #18233c !important;
            border: 1.5px solid #223254 !important;
            color: #f1f5f9 !important;
        }
        [data-theme="dark"] input:focus,
        [data-theme="dark"] select:focus,
        [data-theme="dark"] textarea:focus {
            border-color: #f97316 !important;
            box-shadow: 0 0 0 3px rgba(249, 115, 22, 0.18) !important;
            background: #1e2c4c !important;
        }
        [data-theme="dark"] label { color: #cbd5e1 !important; }
        [data-theme="dark"] .hint { color: #94a3b8 !important; }

        /* ── Detail views & tags ── */
        [data-theme="dark"] code.tag {
            background: #18233c !important;
            color: #f1f5f9 !important;
            border-color: rgba(255, 255, 255, 0.08) !important;
        }
        [data-theme="dark"] .detail-value { color: #f1f5f9 !important; }
        [data-theme="dark"] .detail-label { color: #94a3b8 !important; }
        [data-theme="dark"] .text-content {
            background: #18233c !important;
            border: 1px solid rgba(255, 255, 255, 0.08) !important;
            color: #cbd5e1 !important;
        }
        [data-theme="dark"] .filter-bar {
            background: #0d1527 !important;
            border-bottom: 1px solid rgba(255, 255, 255, 0.06) !important;
        }
        [data-theme="dark"] .filter-input {
            background: #18233c !important;
            border-color: #223254 !important;
            color: #f1f5f9 !important;
        }
        [data-theme="dark"] .empty-state { color: #64748b !important; }
        [data-theme="dark"] .empty-state i { color: #1e2d4d !important; }

        /* ── Matriz Dark ── */
        [data-theme="dark"] .matriz-title { color: #f1f5f9 !important; }
        [data-theme="dark"] .matriz-axis { color: #94a3b8 !important; }
        [data-theme="dark"] .mc-bajo    { background: rgba(34,197,94,0.2) !important; color: #4ade80 !important; }
        [data-theme="dark"] .mc-medio   { background: rgba(234,179,8,0.2) !important; color: #facc15 !important; }
        [data-theme="dark"] .mc-alto    { background: rgba(249,115,22,0.2) !important; color: #fb923c !important; }
        [data-theme="dark"] .mc-critico { background: rgba(239,68,68,0.22) !important; color: #f87171 !important; }
        [data-theme="dark"] .ley-item   { color: #cbd5e1 !important; }

        /* ── ISO Guide Accordion Dark ── */
        [data-theme="dark"] .guia-iso {
            background: rgba(30, 58, 138, 0.16) !important;
            border: 1px solid rgba(59, 130, 246, 0.3) !important;
        }
        [data-theme="dark"] .guia-iso-header:hover {
            background: rgba(255, 255, 255, 0.04) !important;
        }
        [data-theme="dark"] .guia-iso-icon {
            background: rgba(59, 130, 246, 0.25) !important;
        }
        [data-theme="dark"] .guia-iso-icon i { color: #60a5fa !important; }
        [data-theme="dark"] .guia-iso-title { color: #93c5fd !important; }
        [data-theme="dark"] .guia-iso-ref {
            background: rgba(59, 130, 246, 0.25) !important;
            color: #93c5fd !important;
        }
        [data-theme="dark"] .guia-iso-body {
            border-top: 1px solid rgba(59, 130, 246, 0.2) !important;
        }
        [data-theme="dark"] .guia-iso p { color: #cbd5e1 !important; }
        [data-theme="dark"] .guia-paso { color: #cbd5e1 !important; }
        [data-theme="dark"] .guia-paso strong { color: #f1f5f9 !important; }
        [data-theme="dark"] .guia-num {
            background: rgba(59, 130, 246, 0.25) !important;
            color: #93c5fd !important;
        }
        [data-theme="dark"] .guia-nota {
            background: rgba(255, 255, 255, 0.05) !important;
            color: #cbd5e1 !important;
        }

        /* ── Text adaptive classes ── */
        [data-theme="dark"] .text-adaptive { color: #f1f5f9 !important; }
        [data-theme="dark"] .page-title { color: #f1f5f9 !important; }
        [data-theme="dark"] .page-subtitle { color: #94a3b8 !important; }
        [data-theme="dark"] .c-critico { color: #f87171 !important; }
        [data-theme="dark"] .c-alto    { color: #fb923c !important; }
        [data-theme="dark"] .c-medio   { color: #facc15 !important; }
        [data-theme="dark"] .c-bajo    { color: #4ade80 !important; }

        /* Dashboard row helpers */
        [data-theme="dark"] .dashboard-activity-row {
            border-bottom: 1px solid rgba(255, 255, 255, 0.06) !important;
        }
        [data-theme="dark"] .dashboard-activity-row:hover {
            background: rgba(255, 255, 255, 0.04) !important;
        }

        /* ══════════════════════════════════════════════════
           ✨ ENHANCED INTERACTIONS & ANIMATIONS v2
        ══════════════════════════════════════════════════ */

        /* Page content entrance */
        .app-content { animation: contentFadeIn 0.4s cubic-bezier(0.16, 1, 0.3, 1) both; }
        @keyframes contentFadeIn {
            from { opacity: 0; transform: translateY(12px); }
            to   { opacity: 1; transform: translateY(0); }
        }

        /* Stat cards — counter animation + glow on hover */
        .stat-card {
            cursor: pointer;
        }
        html:not([data-theme="dark"]) .stat-card {
            background: #fff;
        }
        .stat-card::after {
            content: '';
            position: absolute;
            inset: 0;
            border-radius: 14px;
            background: radial-gradient(circle at 30% 30%, rgba(249,115,22,0.06) 0%, transparent 70%);
            opacity: 0;
            transition: opacity 0.3s;
            pointer-events: none;
        }
        .stat-card:hover::after { opacity: 1; }
        .stat-card:hover .stat-num {
            color: #f97316;
        }
        .stat-num { transition: color 0.25s ease; }

        /* Risk cards — richer lift */
        .risk-card {
            transition: all 0.25s cubic-bezier(0.16, 1, 0.3, 1);
        }
        .risk-card:hover {
            box-shadow:
                0 20px 40px -8px rgba(0,0,0,0.12),
                0 8px 16px -4px rgba(0,0,0,0.06);
            transform: translateY(-5px) scale(1.01);
        }

        /* Buttons — ripple effect + stronger spring */
        .btn {
            position: relative;
            overflow: hidden;
        }
        .btn::after {
            content: '';
            position: absolute;
            top: 50%; left: 50%;
            width: 0; height: 0;
            background: rgba(255,255,255,0.25);
            border-radius: 50%;
            transform: translate(-50%, -50%);
            transition: width 0.5s ease, height 0.5s ease, opacity 0.5s ease;
            opacity: 0;
            pointer-events: none;
        }
        .btn:active::after {
            width: 240px; height: 240px; opacity: 0;
            transition: 0s;
        }
        .btn-primary:hover {
            transform: translateY(-2px) scale(1.02);
            box-shadow: 0 8px 24px rgba(249,115,22,0.42);
        }
        .btn-primary:active { transform: translateY(0) scale(0.98); }

        .btn-outline:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 14px rgba(249,115,22,0.15);
        }
        .btn-secondary:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 14px rgba(30,58,138,0.25);
        }
        .btn-danger:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 14px rgba(239,68,68,0.2);
        }

        /* Nav items — pulse on active */
        .nav-item.active::before {
            content: '';
            position: absolute;
            left: -10px; top: 50%; transform: translateY(-50%);
            width: 4px; height: 60%;
            background: #fff;
            border-radius: 0 3px 3px 0;
            opacity: 0.6;
        }

        /* Topbar — sticky with blur animation */
        .topbar {
            transition: box-shadow 0.2s, background 0.2s;
        }

        /* Sidebar logo — spring bounce */
        .sidebar-logo {
            transition: transform 0.35s cubic-bezier(0.34, 1.56, 0.64, 1), box-shadow 0.3s;
        }
        .sidebar-brand-wrap:hover .sidebar-logo {
            transform: scale(1.12) rotate(-4deg);
            box-shadow: 0 6px 20px rgba(249,115,22,0.4);
        }

        /* Alert — slide in from top */
        .alert {
            animation: slideAlert 0.35s cubic-bezier(0.16, 1, 0.3, 1) both;
        }
        @keyframes slideAlert {
            from { opacity: 0; transform: translateY(-10px) scale(0.98); }
            to   { opacity: 1; transform: translateY(0) scale(1); }
        }

        /* Table rows — smooth highlight */
        .table tr { transition: background 0.15s; }
        .table tr:hover td {
            background: #fff8f4;
        }
        [data-theme="dark"] .table tr:hover td { background: #1e2438; }

        /* Panels — subtle slide up on load */
        .panel {
            animation: panelIn 0.4s cubic-bezier(0.16, 1, 0.3, 1) both;
        }
        .panel:nth-child(2) { animation-delay: 0.05s; }
        .panel:nth-child(3) { animation-delay: 0.10s; }
        @keyframes panelIn {
            from { opacity: 0; transform: translateY(16px); }
            to   { opacity: 1; transform: translateY(0); }
        }

        /* Stat cards stagger */
        .stats-grid .stat-card:nth-child(1) { animation: statIn 0.4s 0.05s cubic-bezier(0.16,1,0.3,1) both; }
        .stats-grid .stat-card:nth-child(2) { animation: statIn 0.4s 0.10s cubic-bezier(0.16,1,0.3,1) both; }
        .stats-grid .stat-card:nth-child(3) { animation: statIn 0.4s 0.15s cubic-bezier(0.16,1,0.3,1) both; }
        .stats-grid .stat-card:nth-child(4) { animation: statIn 0.4s 0.20s cubic-bezier(0.16,1,0.3,1) both; }
        @keyframes statIn {
            from { opacity: 0; transform: translateY(20px) scale(0.96); }
            to   { opacity: 1; transform: translateY(0) scale(1); }
        }

        /* Kanban cols stagger */
        .kanban-col:nth-child(1) { animation: colIn 0.4s 0.10s cubic-bezier(0.16,1,0.3,1) both; }
        .kanban-col:nth-child(2) { animation: colIn 0.4s 0.18s cubic-bezier(0.16,1,0.3,1) both; }
        .kanban-col:nth-child(3) { animation: colIn 0.4s 0.26s cubic-bezier(0.16,1,0.3,1) both; }
        .kanban-col:nth-child(4) { animation: colIn 0.4s 0.34s cubic-bezier(0.16,1,0.3,1) both; }
        @keyframes colIn {
            from { opacity: 0; transform: translateY(24px); }
            to   { opacity: 1; transform: translateY(0); }
        }

        /* Badge pulse for critical */
        .badge-critico, .badge-critica {
            animation: badgePulse 2.5s ease-in-out infinite;
        }
        @keyframes badgePulse {
            0%, 100% { box-shadow: 0 0 0 0 rgba(239,68,68,0); }
            50% { box-shadow: 0 0 0 4px rgba(239,68,68,0.15); }
        }

        /* Logout button — warning shake on hover */
        .logout-btn {
            transition: all 0.2s cubic-bezier(0.16, 1, 0.3, 1);
        }
        .logout-btn:hover {
            transform: translateX(2px);
            box-shadow: inset 3px 0 0 #dc2626;
        }

        /* Notif btn — bell ring */
        .notif-btn:hover i.fa-bell {
            animation: bellRing 0.4s cubic-bezier(0.36, 0.07, 0.19, 0.97) both;
        }
        @keyframes bellRing {
            0%, 100% { transform: rotate(0deg); }
            20% { transform: rotate(-15deg); }
            40% { transform: rotate(15deg); }
            60% { transform: rotate(-10deg); }
            80% { transform: rotate(10deg); }
        }

        /* Focus ring override — orange accent */
        :focus-visible {
            outline: 2px solid #f97316;
            outline-offset: 2px;
            border-radius: 6px;
        }

        /* Smooth scroll */
        html { scroll-behavior: smooth; }

        /* Item cards stagger */
        .card-grid .item-card:nth-child(1) { animation: statIn 0.4s 0.05s cubic-bezier(0.16,1,0.3,1) both; }
        .card-grid .item-card:nth-child(2) { animation: statIn 0.4s 0.10s cubic-bezier(0.16,1,0.3,1) both; }
        .card-grid .item-card:nth-child(3) { animation: statIn 0.4s 0.15s cubic-bezier(0.16,1,0.3,1) both; }
        .card-grid .item-card:nth-child(4) { animation: statIn 0.4s 0.20s cubic-bezier(0.16,1,0.3,1) both; }
        .card-grid .item-card:nth-child(5) { animation: statIn 0.4s 0.25s cubic-bezier(0.16,1,0.3,1) both; }
        .card-grid .item-card:nth-child(n+6) { animation: statIn 0.4s 0.30s cubic-bezier(0.16,1,0.3,1) both; }

        /* Progress bar animation */
        .progress-fill {
            animation: progressFill 1s cubic-bezier(0.16, 1, 0.3, 1) both;
            animation-delay: 0.3s;
        }
        @keyframes progressFill {
            from { width: 0 !important; }
        }

        /* Topbar search focus expand */
        .topbar-search input:focus {
            box-shadow: 0 0 0 3px rgba(249,115,22,0.12), 0 4px 16px rgba(0,0,0,0.06);
        }

        /* Theme toggle spin */
        #themeToggle:hover {
            transform: rotate(20deg) scale(1.1);
            transition: transform 0.3s cubic-bezier(0.34, 1.56, 0.64, 1);
        }

        /* Sidebar items stagger on open */
        @media (max-width: 1024px) {
            body.sidebar-open .nav-item:nth-child(1) { animation: navSlide 0.3s 0.05s both; }
            body.sidebar-open .nav-item:nth-child(2) { animation: navSlide 0.3s 0.10s both; }
            body.sidebar-open .nav-item:nth-child(3) { animation: navSlide 0.3s 0.15s both; }
            body.sidebar-open .nav-item:nth-child(n+4) { animation: navSlide 0.3s 0.20s both; }
            @keyframes navSlide {
                from { opacity: 0; transform: translateX(-10px); }
                to   { opacity: 1; transform: translateX(0); }
            }
        }
    </style>
</head>
<body>

<a href="#main-content" class="skip-link">Saltar al contenido principal</a>

{{-- Backdrop for mobile drawer --}}
<div id="sidebarBackdrop" class="sidebar-backdrop" onclick="toggleSidebar(false)" aria-hidden="true"></div>

<aside class="sidebar" id="appSidebar" role="complementary" aria-label="Navegación lateral">

    {{-- Header con logo y botón cerrar en móvil --}}
    <div class="sidebar-header">
        <a href="{{ route('dashboard') }}" class="sidebar-brand-wrap" aria-label="RiskGuard TI — Ir al dashboard">
            <div class="sidebar-logo"><img src="{{ asset('images/logo.png') }}" alt="RiskGuard TI"></div>
            <div>
                <div class="sidebar-app-name">RiskGuard TI</div>
                <div class="sidebar-app-sub">Gestión de Riesgos</div>
            </div>
        </a>
        <button type="button" class="sidebar-close-btn" aria-label="Cerrar menú" onclick="toggleSidebar(false)">
            <i class="fas fa-times"></i>
        </button>
    </div>

    {{-- Usuario --}}
    <a href="{{ route('perfil.edit') }}" class="sidebar-user" title="Editar perfil">
        @if(auth()->user()->avatar_url)
            <img src="{{ auth()->user()->avatar_url }}" style="width:36px;height:36px;border-radius:50%;object-fit:cover;flex-shrink:0;border:2px solid #fed7aa;">
        @else
            <div class="sidebar-user-avatar">{{ strtoupper(substr(auth()->user()->display_name, 0, 2)) }}</div>
        @endif
        <div style="min-width:0;flex:1;">
            <div class="sidebar-user-name">{{ auth()->user()->display_name }}</div>
            <div class="sidebar-user-role">{{ auth()->user()->getRoleNames()->first() ?? 'Sin rol' }}</div>
        </div>
        <i class="fas fa-pen" style="font-size:10px;color:#94a3b8;flex-shrink:0;"></i>
    </a>

    {{-- Navegación con scroll --}}
    <nav class="sidebar-nav" role="navigation" aria-label="Menú principal">
        @can('dashboard.ver')
        <span class="nav-section-label">Principal</span>
        <a href="{{ route('dashboard') }}" class="nav-item {{ request()->routeIs('dashboard') ? 'active' : '' }}">
            <i class="fas fa-chart-pie"></i> Dashboard
        </a>
        @endcan
        @can('matriz.ver')
        <a href="{{ route('matriz.index') }}" class="nav-item {{ request()->routeIs('matriz.*') ? 'active' : '' }}">
            <i class="fas fa-th"></i> Matriz de Riesgos
        </a>
        @endcan

        @if(auth()->user()->canAny(['activos.ver','amenazas.ver','evaluaciones.ver','mitigacion.ver']))
        <span class="nav-section-label">Gestión</span>
        @can('activos.ver')
        <a href="{{ route('activos.index') }}" class="nav-item {{ request()->routeIs('activos.*') ? 'active' : '' }}">
            <i class="fas fa-server"></i> Activos TI
        </a>
        @endcan
        @can('amenazas.ver')
        <a href="{{ route('amenazas.index') }}" class="nav-item {{ request()->routeIs('amenazas.*') ? 'active' : '' }}">
            <i class="fas fa-biohazard"></i> Amenazas
        </a>
        @endcan
        @can('evaluaciones.ver')
        <a href="{{ route('evaluaciones.index') }}" class="nav-item {{ request()->routeIs('evaluaciones.index','evaluaciones.show','evaluaciones.edit') ? 'active' : '' }}">
            <i class="fas fa-search-plus"></i> Evaluaciones
        </a>
        @endcan
        @can('evaluaciones.calcular')
        <a href="{{ route('evaluaciones.create') }}" class="nav-item {{ request()->routeIs('evaluaciones.create') ? 'active' : '' }}">
            <i class="fas fa-calculator"></i> Cálculo de Riesgo
        </a>
        @endcan
        @can('mitigacion.ver')
        <a href="{{ route('mitigacion.index') }}" class="nav-item {{ request()->routeIs('mitigacion.*') ? 'active' : '' }}">
            <i class="fas fa-shield-virus"></i> Mitigación
        </a>
        @endcan
        @endif

        @if(auth()->user()->canAny(['bitacora.ver','reportes.generar']))
        <span class="nav-section-label">Auditoría</span>
        @can('bitacora.ver')
        <a href="{{ route('bitacora.index') }}" class="nav-item {{ request()->routeIs('bitacora.*') ? 'active' : '' }}">
            <i class="fas fa-clipboard-list"></i> Bitácora
        </a>
        @endcan
        @can('reportes.generar')
        <a href="#reportesMenu" class="nav-item {{ request()->is('reportes/*') ? 'active' : '' }}" onclick="toggleReportes(event)" id="reportesToggle">
            <i class="fas fa-file-pdf"></i> Reportes PDF
            <i class="fas fa-chevron-down" id="reportesChevron" style="margin-left:auto;font-size:10px;transition:transform 0.2s;"></i>
        </a>
        <div id="reportesMenu" style="display:{{ request()->is('reportes/*') ? 'block' : 'none' }};padding-left:14px;">
            <a href="{{ route('reportes.ejecutivo') }}" class="nav-item" style="font-size:12px;padding:7px 12px;" target="_blank">
                <i class="fas fa-chart-bar" style="font-size:11px;"></i> Ejecutivo
            </a>
            <a href="{{ route('reportes.activos') }}" class="nav-item" style="font-size:12px;padding:7px 12px;" target="_blank">
                <i class="fas fa-server" style="font-size:11px;"></i> Activos TI
            </a>
            <a href="{{ route('reportes.amenazas') }}" class="nav-item" style="font-size:12px;padding:7px 12px;" target="_blank">
                <i class="fas fa-biohazard" style="font-size:11px;"></i> Amenazas
            </a>
            <a href="{{ route('reportes.evaluaciones') }}" class="nav-item" style="font-size:12px;padding:7px 12px;" target="_blank">
                <i class="fas fa-search-plus" style="font-size:11px;"></i> Evaluaciones
            </a>
            <a href="{{ route('reportes.mitigacion') }}" class="nav-item" style="font-size:12px;padding:7px 12px;" target="_blank">
                <i class="fas fa-shield-virus" style="font-size:11px;"></i> Mitigación
            </a>
            <a href="{{ route('reportes.bitacora') }}" class="nav-item" style="font-size:12px;padding:7px 12px;" target="_blank">
                <i class="fas fa-clipboard-list" style="font-size:11px;"></i> Bitácora
            </a>
        </div>
        @endcan
        @endif

        @if(auth()->user()->canAny(['usuarios.ver','roles.ver','basedatos.ver']))
        <span class="nav-section-label">Administración</span>
        @can('usuarios.ver')
        <a href="{{ route('usuarios.index') }}" class="nav-item {{ request()->routeIs('usuarios.*') ? 'active' : '' }}">
            <i class="fas fa-users-cog"></i> Usuarios
        </a>
        @endcan
        @can('roles.ver')
        <a href="{{ route('roles.index') }}" class="nav-item {{ request()->routeIs('roles.*') ? 'active' : '' }}">
            <i class="fas fa-user-shield"></i> Control de Roles
        </a>
        @endcan
        @can('basedatos.ver')
        <a href="{{ route('respaldos.index') }}" class="nav-item {{ request()->routeIs('respaldos.*') ? 'active' : '' }}">
            <i class="fas fa-database"></i> Respaldo BD
        </a>
        @endcan
        @endif
    </nav>

    {{-- Logout --}}
    <div class="sidebar-bottom">
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="logout-btn">
                <i class="fas fa-sign-out-alt"></i> Cerrar sesión
            </button>
        </form>
    </div>

</aside>

<div class="app-wrapper">
    <header class="topbar">
        <button type="button" class="sidebar-toggle-btn" id="sidebarToggle" aria-label="Abrir menú de navegación" onclick="toggleSidebar(true)">
            <i class="fas fa-bars"></i>
        </button>

        <div class="topbar-left">
            @yield('topbar-left')
        </div>

        <div class="topbar-search">
            <i class="fas fa-search topbar-search-icon"></i>
            <input type="text" id="globalSearch" placeholder="Buscar en el sistema..." autocomplete="off">
            <span class="search-shortcut-badge">Ctrl K</span>
        </div>

        <div class="topbar-right">
            <span class="topbar-date">{{ now()->format('d M Y') }}</span>
            <button id="themeToggle" class="notif-btn" onclick="toggleTheme()" title="Cambiar tema" aria-label="Cambiar tema claro/oscuro" style="cursor:pointer;border:none;font-family:inherit;"></button>
            <a href="{{ route('bitacora.index') }}" class="notif-btn" title="Bitácora de auditoría" aria-label="Ver bitácora de auditoría">
                <i class="fas fa-bell" aria-hidden="true"></i>
            </a>
            @yield('topbar-right')
        </div>
    </header>

    <main class="app-content" id="main-content" role="main">
        @if(session('success'))
        <div class="alert alert-success"><i class="fas fa-check-circle"></i><span>{{ session('success') }}</span></div>
        @endif
        @if(session('error'))
        <div class="alert alert-error"><i class="fas fa-exclamation-circle"></i><span>{{ session('error') }}</span></div>
        @endif
        @if(session('warning'))
        <div class="alert alert-warning"><i class="fas fa-exclamation-triangle"></i><span>{{ session('warning') }}</span></div>
        @endif

        @yield('content')
    </main>

    <footer class="statusbar">
        <span><span class="statusbar-dot" style="background:#22c55e;"></span>Sistema operativo</span>
        <span><span class="statusbar-dot" style="background:#22c55e;"></span>BD conectada</span>
        <span style="margin-left:auto;">ISO 27001 · RiskGuard TI v2.0 · {{ auth()->user()->getRoleNames()->first() ?? 'Sin rol' }}</span>
    </footer>
</div>

@stack('scripts')
<script>
/* ── Mobile Sidebar Drawer ── */
function toggleSidebar(forceState) {
    var body = document.body;
    var isOpen = body.classList.contains('sidebar-open');
    var shouldOpen = forceState !== undefined ? forceState : !isOpen;
    if (shouldOpen) {
        body.classList.add('sidebar-open');
    } else {
        body.classList.remove('sidebar-open');
    }
}

// Close drawer on Escape key
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape' && document.body.classList.contains('sidebar-open')) {
        toggleSidebar(false);
    }
    // Global search hotkey Ctrl+K / Cmd+K
    if ((e.ctrlKey || e.metaKey) && (e.key === 'k' || e.key === 'K')) {
        e.preventDefault();
        var searchInput = document.getElementById('globalSearch');
        if (searchInput) {
            searchInput.focus();
            searchInput.select();
        }
    }
});

/* ── Theme Switcher ── */
function toggleTheme() {
    var curr = document.documentElement.getAttribute('data-theme');
    var next = curr === 'dark' ? 'light' : 'dark';
    document.documentElement.setAttribute('data-theme', next);
    localStorage.setItem('rg-theme', next);
    updateThemeIcon(next);
}
var SVG_MOON = '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="currentColor"><path d="M21 12.79A9 9 0 1111.21 3a7 7 0 109.79 9.79z"/></svg>';
var SVG_SUN  = '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="currentColor"><circle cx="12" cy="12" r="5"/><line x1="12" y1="1" x2="12" y2="3" stroke="currentColor" stroke-width="2" stroke-linecap="round"/><line x1="12" y1="21" x2="12" y2="23" stroke="currentColor" stroke-width="2" stroke-linecap="round"/><line x1="4.22" y1="4.22" x2="5.64" y2="5.64" stroke="currentColor" stroke-width="2" stroke-linecap="round"/><line x1="18.36" y1="18.36" x2="19.78" y2="19.78" stroke="currentColor" stroke-width="2" stroke-linecap="round"/><line x1="1" y1="12" x2="3" y2="12" stroke="currentColor" stroke-width="2" stroke-linecap="round"/><line x1="21" y1="12" x2="23" y2="12" stroke="currentColor" stroke-width="2" stroke-linecap="round"/><line x1="4.22" y1="19.78" x2="5.64" y2="18.36" stroke="currentColor" stroke-width="2" stroke-linecap="round"/><line x1="18.36" y1="5.64" x2="19.78" y2="4.22" stroke="currentColor" stroke-width="2" stroke-linecap="round"/></svg>';
function updateThemeIcon(t) {
    var btn = document.getElementById('themeToggle');
    if (btn) btn.innerHTML = t === 'dark' ? SVG_SUN : SVG_MOON;
}
updateThemeIcon(document.documentElement.getAttribute('data-theme'));

/* ── Dropdown reportes ── */
function toggleReportes(e) {
    e.preventDefault();
    var menu = document.getElementById('reportesMenu');
    var chevron = document.getElementById('reportesChevron');
    if (!menu) return;
    var open = menu.style.display !== 'none';
    menu.style.display = open ? 'none' : 'block';
    if (chevron) chevron.style.transform = open ? '' : 'rotate(180deg)';
}

/* ── Animated number counters ── */
function animateCount(el) {
    var target = parseInt(el.textContent, 10);
    if (isNaN(target) || target === 0) return;
    var start = 0;
    var duration = 800;
    var startTime = null;
    function step(ts) {
        if (!startTime) startTime = ts;
        var progress = Math.min((ts - startTime) / duration, 1);
        // ease out expo
        var eased = progress === 1 ? 1 : 1 - Math.pow(2, -10 * progress);
        el.textContent = Math.round(eased * target);
        if (progress < 1) requestAnimationFrame(step);
        else el.textContent = target;
    }
    requestAnimationFrame(step);
}

// Run counters when stat-num elements enter viewport
document.addEventListener('DOMContentLoaded', function() {
    var nums = document.querySelectorAll('.stat-num');
    if ('IntersectionObserver' in window) {
        var io = new IntersectionObserver(function(entries) {
            entries.forEach(function(e) {
                if (e.isIntersecting) { animateCount(e.target); io.unobserve(e.target); }
            });
        }, { threshold: 0.4 });
        nums.forEach(function(n) { io.observe(n); });
    } else {
        nums.forEach(animateCount);
    }

    // Ripple on all .btn clicks
    document.querySelectorAll('.btn').forEach(function(btn) {
        btn.addEventListener('click', function(e) {
            var r = document.createElement('span');
            r.style.cssText = 'position:absolute;border-radius:50%;background:rgba(255,255,255,0.3);pointer-events:none;transform:scale(0);animation:btnRipple 0.5s ease-out forwards;';
            var rect = btn.getBoundingClientRect();
            var size = Math.max(rect.width, rect.height) * 1.5;
            r.style.width = r.style.height = size + 'px';
            r.style.left = (e.clientX - rect.left - size/2) + 'px';
            r.style.top  = (e.clientY - rect.top  - size/2) + 'px';
            if (!document.getElementById('rippleStyle')) {
                var s = document.createElement('style');
                s.id = 'rippleStyle';
                s.textContent = '@keyframes btnRipple{to{transform:scale(1);opacity:0}}';
                document.head.appendChild(s);
            }
            btn.appendChild(r);
            setTimeout(function() { r.remove(); }, 500);
        });
    });

    // Auto-dismiss alerts after 5s
    document.querySelectorAll('.alert').forEach(function(a) {
        setTimeout(function() {
            a.style.transition = 'opacity 0.4s, transform 0.4s';
            a.style.opacity = '0';
            a.style.transform = 'translateY(-8px)';
            setTimeout(function() { a.remove(); }, 400);
        }, 5000);
    });
});
</script>
</body>
</html>

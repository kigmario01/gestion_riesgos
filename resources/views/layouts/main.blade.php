<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'RiskGuard TI') — Gestión de Riesgos</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700,800&display=swap" rel="stylesheet">
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
        body { font-family: 'Inter', -apple-system, sans-serif; background: #f0f2f5; color: #1e293b; min-height: 100vh; display: flex; }

        /* ══ SIDEBAR ══ */
        .sidebar {
            width: 220px; height: 100vh;
            background: rgba(15, 17, 35, 0.82);
            backdrop-filter: blur(18px); -webkit-backdrop-filter: blur(18px);
            border-right: 1px solid rgba(255,255,255,0.06);
            display: flex; flex-direction: column;
            position: fixed; top: 0; left: 0; z-index: 200;
            box-shadow: 4px 0 32px rgba(0,0,0,0.35);
        }

        /* Header con logo y nombre app */
        .sidebar-header {
            padding: 20px 18px 16px;
            display: flex; align-items: center; gap: 11px;
            border-bottom: 1px solid rgba(255,255,255,0.06);
            flex-shrink: 0;
        }
        .sidebar-logo {
            width: 38px; height: 38px; flex-shrink: 0;
            background: linear-gradient(135deg, #4f8ef7 0%, #6366f1 100%);
            border-radius: 11px; display: flex; align-items: center; justify-content: center;
            color: #fff; font-size: 16px;
            box-shadow: 0 4px 14px rgba(99,102,241,0.45); text-decoration: none;
            transition: transform 0.15s;
        }
        .sidebar-logo:hover { transform: scale(1.06); }
        .sidebar-app-name {
            font-size: 13.5px; font-weight: 700; color: #fff;
            letter-spacing: 0.2px; line-height: 1.2;
        }
        .sidebar-app-sub {
            font-size: 10px; color: rgba(255,255,255,0.35); font-weight: 400;
        }

        /* Usuario */
        .sidebar-user {
            padding: 14px 18px;
            display: flex; align-items: center; gap: 10px;
            border-bottom: 1px solid rgba(255,255,255,0.06);
            flex-shrink: 0;
        }
        .sidebar-user-avatar {
            width: 34px; height: 34px; border-radius: 50%; flex-shrink: 0;
            background: linear-gradient(135deg, #4f8ef7, #8b5cf6);
            display: flex; align-items: center; justify-content: center;
            font-weight: 700; font-size: 11px; color: #fff;
            border: 2px solid rgba(255,255,255,0.15);
        }
        .sidebar-user-name {
            font-size: 12.5px; font-weight: 600; color: rgba(255,255,255,0.88);
            white-space: nowrap; overflow: hidden; text-overflow: ellipsis;
        }
        .sidebar-user-role {
            font-size: 10px; color: rgba(255,255,255,0.35);
        }

        /* Nav scrollable */
        .sidebar-nav {
            flex: 1; overflow-y: auto; overflow-x: hidden;
            padding: 10px 12px;
            scrollbar-width: thin;
            scrollbar-color: rgba(255,255,255,0.08) transparent;
        }
        .sidebar-nav::-webkit-scrollbar { width: 4px; }
        .sidebar-nav::-webkit-scrollbar-track { background: transparent; }
        .sidebar-nav::-webkit-scrollbar-thumb { background: rgba(255,255,255,0.08); border-radius: 4px; }

        /* Etiqueta de sección */
        .nav-section-label {
            font-size: 9.5px; font-weight: 700; letter-spacing: 1.2px;
            color: rgba(255,255,255,0.25); text-transform: uppercase;
            padding: 14px 8px 6px; display: block;
        }
        .nav-section-label:first-child { padding-top: 4px; }

        /* Item de navegación */
        .nav-item {
            display: flex; align-items: center; gap: 10px;
            padding: 9px 12px; border-radius: 10px;
            color: rgba(255,255,255,0.45); font-size: 13px; font-weight: 500;
            text-decoration: none; cursor: pointer;
            transition: all 0.15s; margin-bottom: 2px;
            white-space: nowrap;
        }
        .nav-item i { width: 16px; text-align: center; font-size: 13px; flex-shrink: 0; }
        .nav-item:hover {
            background: rgba(255,255,255,0.06);
            color: rgba(255,255,255,0.85);
        }
        .nav-item.active {
            background: rgba(79,142,247,0.18);
            color: #93c5fd;
            font-weight: 600;
        }
        .nav-item.active i { color: #4f8ef7; }

        /* Bottom: logout */
        .sidebar-bottom {
            padding: 12px;
            border-top: 1px solid rgba(255,255,255,0.06);
            flex-shrink: 0;
        }
        .logout-btn {
            display: flex; align-items: center; gap: 10px;
            width: 100%; padding: 9px 12px; border-radius: 10px;
            background: rgba(239,68,68,0.06); border: 1px solid rgba(239,68,68,0.12);
            color: rgba(252,165,165,0.55); font-size: 12.5px; font-weight: 500;
            cursor: pointer; font-family: inherit; transition: all 0.15s;
            text-align: left;
        }
        .logout-btn i { width: 16px; text-align: center; font-size: 13px; }
        .logout-btn:hover { background: rgba(239,68,68,0.14); color: #fca5a5; }

        /* ══ APP WRAPPER ══ */
        .app-wrapper { margin-left: 220px; flex: 1; min-height: 100vh; display: flex; flex-direction: column; }

        /* ══ TOPBAR ══ */
        .topbar {
            height: 62px; background: #fff; border-bottom: 1px solid #e8eaf0;
            padding: 0 22px; display: flex; align-items: center; gap: 14px;
            position: sticky; top: 0; z-index: 100;
        }
        .topbar-left { display: flex; align-items: center; gap: 10px; flex-shrink: 0; min-width: 0; }
        .topbar-icon {
            width: 34px; height: 34px; border-radius: 9px; background: #eff6ff;
            display: flex; align-items: center; justify-content: center;
            color: #4f8ef7; font-size: 13px; flex-shrink: 0;
        }
        .topbar-title { font-size: 14.5px; font-weight: 700; color: #1b1f3b; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }

        .topbar-search { flex: 1; max-width: 500px; position: relative; margin: 0 8px; }
        .topbar-search input {
            width: 100%; padding: 9px 14px 9px 38px;
            background: #f5f6fb; border: 1.5px solid #e8eaf0; border-radius: 10px;
            font-size: 13px; color: #374151; outline: none; font-family: inherit;
            transition: all 0.15s;
        }
        .topbar-search input:focus { border-color: #4f8ef7; background: #fff; box-shadow: 0 0 0 3px rgba(79,142,247,0.08); }
        .topbar-search input::placeholder { color: #9ca3af; }
        .topbar-search-icon { position: absolute; left: 12px; top: 50%; transform: translateY(-50%); color: #9ca3af; font-size: 12.5px; pointer-events: none; }

        .topbar-right { display: flex; align-items: center; gap: 8px; margin-left: auto; flex-shrink: 0; }
        .topbar-date { font-size: 11.5px; color: #94a3b8; }

        .notif-btn {
            width: 38px; height: 38px; border-radius: 10px;
            background: #f5f6fb; border: 1.5px solid #e8eaf0;
            color: #64748b; display: flex; align-items: center; justify-content: center;
            cursor: pointer; font-size: 14px; position: relative; text-decoration: none;
            transition: all 0.15s;
        }
        .notif-btn:hover { border-color: #4f8ef7; color: #4f8ef7; background: #eff6ff; }

        /* ══ CONTENT ══ */
        .app-content { padding: 22px 24px 40px; flex: 1; overflow-y: auto; }

        /* ══ PAGE HEADER ══ */
        .page-header { display: flex; align-items: flex-start; justify-content: space-between; gap: 14px; margin-bottom: 18px; }
        .page-header-left { display: flex; flex-direction: column; gap: 2px; }
        .page-title { font-size: 19px; font-weight: 800; color: #1b1f3b; display: flex; align-items: center; gap: 10px; }
        .page-subtitle { font-size: 12.5px; color: #94a3b8; }
        .page-actions { display: flex; align-items: center; gap: 8px; flex-shrink: 0; }

        /* ══ FILTER TABS ══ */
        .filter-tabs {
            display: flex; gap: 6px; padding: 5px;
            background: #fff; border-radius: 13px; border: 1px solid #e8eaf0;
            margin-bottom: 18px; overflow-x: auto; flex-wrap: nowrap;
        }
        .filter-tab {
            display: flex; align-items: center; gap: 7px;
            padding: 8px 16px; border-radius: 9px;
            font-size: 12.5px; font-weight: 500; color: #64748b;
            cursor: pointer; text-decoration: none; transition: all 0.15s;
            white-space: nowrap; border: none; background: transparent; font-family: inherit;
        }
        .filter-tab:hover { background: #f5f6fb; color: #374151; }
        .filter-tab.active { background: #4f8ef7; color: #fff; box-shadow: 0 3px 10px rgba(79,142,247,0.3); }
        .filter-tab.active-red   { background: #ef4444; color: #fff; box-shadow: 0 3px 10px rgba(239,68,68,0.3); }
        .filter-tab.active-orange{ background: #f97316; color: #fff; box-shadow: 0 3px 10px rgba(249,115,22,0.3); }
        .filter-tab.active-yellow{ background: #eab308; color: #fff; box-shadow: 0 3px 10px rgba(234,179,8,0.3); }
        .filter-tab.active-green { background: #22c55e; color: #fff; box-shadow: 0 3px 10px rgba(34,197,94,0.3); }
        .tab-count {
            min-width: 20px; height: 20px; border-radius: 5px; padding: 0 5px;
            display: inline-flex; align-items: center; justify-content: center;
            font-size: 10.5px; font-weight: 700;
            background: rgba(255,255,255,0.25);
        }
        .filter-tab:not(.active):not(.active-red):not(.active-orange):not(.active-yellow):not(.active-green) .tab-count {
            background: #f1f5f9; color: #475569;
        }

        /* ══ KANBAN BOARD ══ */
        .kanban-board { display: grid; grid-template-columns: repeat(4, 1fr); gap: 14px; align-items: start; }
        @media (max-width: 1200px) { .kanban-board { grid-template-columns: repeat(2, 1fr); } }
        .kanban-col { display: flex; flex-direction: column; gap: 10px; }
        .kanban-col-header {
            padding: 9px 14px; border-radius: 10px;
            display: flex; align-items: center; justify-content: space-between;
            font-size: 11.5px; font-weight: 700; letter-spacing: 0.5px; text-transform: uppercase;
        }
        .kch-critico { background: #fef2f2; color: #dc2626; }
        .kch-alto    { background: #fff7ed; color: #ea580c; }
        .kch-medio   { background: #fefce8; color: #ca8a04; }
        .kch-bajo    { background: #f0fdf4; color: #16a34a; }
        .kch-count { background: rgba(0,0,0,0.09); padding: 1px 7px; border-radius: 8px; font-size: 11px; }

        /* ══ RISK / TICKET CARD ══ */
        .risk-card {
            background: #fff; border-radius: 12px; border: 1px solid #e8eaf0;
            overflow: hidden; transition: box-shadow 0.2s, transform 0.15s;
            cursor: default;
        }
        .risk-card:hover { box-shadow: 0 8px 28px rgba(0,0,0,0.1); transform: translateY(-2px); }
        .risk-card-stripe { height: 3px; }
        .stripe-critico { background: linear-gradient(90deg, #ef4444, #dc2626); }
        .stripe-alto    { background: linear-gradient(90deg, #f97316, #ea580c); }
        .stripe-medio   { background: linear-gradient(90deg, #eab308, #ca8a04); }
        .stripe-bajo    { background: linear-gradient(90deg, #22c55e, #16a34a); }
        .risk-card-body { padding: 13px 15px; }
        .risk-card-top { display: flex; align-items: center; justify-content: space-between; margin-bottom: 9px; }
        .risk-card-tags { display: flex; align-items: center; gap: 5px; flex-wrap: wrap; }
        .rc-tag { font-size: 10px; font-weight: 700; padding: 2px 7px; border-radius: 5px; }
        .rc-tag-tipo { background: #eff6ff; color: #1d4ed8; }
        .rc-tag-critico { background: #fef2f2; color: #dc2626; }
        .rc-tag-alto    { background: #fff7ed; color: #ea580c; }
        .rc-tag-medio   { background: #fefce8; color: #ca8a04; }
        .rc-tag-bajo    { background: #f0fdf4; color: #16a34a; }
        .rc-gear { color: #d1d5db; font-size: 12.5px; cursor: pointer; transition: color 0.15s; }
        .rc-gear:hover { color: #64748b; }
        .risk-card-title { font-size: 13.5px; font-weight: 600; color: #1e293b; margin-bottom: 5px; line-height: 1.4; }
        .risk-card-path { font-size: 11px; color: #94a3b8; margin-bottom: 10px; display: flex; align-items: center; gap: 4px; }
        .risk-card-meta { display: flex; align-items: center; gap: 10px; font-size: 11px; color: #64748b; margin-bottom: 10px; flex-wrap: wrap; }
        .rc-meta-item { display: flex; align-items: center; gap: 4px; }
        .rc-dot { width: 6px; height: 6px; border-radius: 50%; flex-shrink: 0; }
        .rc-dot-green  { background: #22c55e; }
        .rc-dot-red    { background: #ef4444; }
        .rc-dot-yellow { background: #eab308; }
        .risk-card-footer { display: flex; align-items: center; justify-content: space-between; padding-top: 10px; border-top: 1px solid #f5f6fa; }
        .rc-assignee { display: flex; align-items: center; gap: 7px; }
        .rc-avatar { width: 26px; height: 26px; border-radius: 50%; background: #4f8ef7; display: flex; align-items: center; justify-content: center; font-size: 9px; font-weight: 700; color: #fff; flex-shrink: 0; }
        .rc-name { font-size: 12px; font-weight: 500; color: #374151; }
        .rc-dept { font-size: 10px; color: #94a3b8; }
        .rc-id { font-size: 10.5px; color: #94a3b8; background: #f5f6fb; padding: 2px 7px; border-radius: 6px; border: 1px solid #e8eaf0; font-family: monospace; }
        .rc-valor { width: 30px; height: 30px; border-radius: 8px; display: flex; align-items: center; justify-content: center; font-weight: 800; font-size: 14px; flex-shrink: 0; }
        .rcv-critico { background: #fef2f2; color: #dc2626; }
        .rcv-alto    { background: #fff7ed; color: #ea580c; }
        .rcv-medio   { background: #fefce8; color: #ca8a04; }
        .rcv-bajo    { background: #f0fdf4; color: #16a34a; }
        .rc-actions { display: flex; align-items: center; gap: 5px; }

        /* ══ STATS CARDS ══ */
        .stats-grid { display: grid; grid-template-columns: repeat(4, 1fr); gap: 14px; margin-bottom: 18px; }
        @media (max-width: 900px) { .stats-grid { grid-template-columns: repeat(2, 1fr); } }
        .stat-card { background: #fff; border-radius: 13px; border: 1px solid #e8eaf0; padding: 16px 18px; display: flex; align-items: center; gap: 14px; transition: box-shadow 0.15s, transform 0.15s; }
        .stat-card:hover { box-shadow: 0 6px 20px rgba(0,0,0,0.08); transform: translateY(-1px); }
        .stat-icon { width: 46px; height: 46px; border-radius: 12px; display: flex; align-items: center; justify-content: center; font-size: 18px; flex-shrink: 0; }
        .si-red    { background: #fef2f2; color: #ef4444; }
        .si-orange { background: #fff7ed; color: #f97316; }
        .si-yellow { background: #fefce8; color: #eab308; }
        .si-green  { background: #f0fdf4; color: #22c55e; }
        .si-blue   { background: #eff6ff; color: #4f8ef7; }
        .si-purple { background: #fdf4ff; color: #9333ea; }
        .si-slate  { background: #f8fafc; color: #64748b; }
        .si-indigo { background: #eef2ff; color: #6366f1; }
        .stat-num { font-size: 30px; font-weight: 800; color: #1b1f3b; line-height: 1; }
        .stat-lbl { font-size: 11.5px; color: #94a3b8; margin-top: 3px; }
        .stat-trend { font-size: 10.5px; font-weight: 600; display: flex; align-items: center; gap: 3px; margin-top: 4px; }
        .trend-up   { color: #ef4444; } .trend-down { color: #22c55e; } .trend-neutral { color: #94a3b8; }

        /* ══ PANELS ══ */
        .panel { background: #fff; border-radius: 13px; border: 1px solid #e8eaf0; overflow: hidden; margin-bottom: 18px; }
        .panel-header { padding: 14px 18px; border-bottom: 1px solid #f1f5f9; display: flex; align-items: center; justify-content: space-between; gap: 12px; }
        .panel-title { font-size: 13.5px; font-weight: 600; color: #1e293b; display: flex; align-items: center; gap: 8px; }
        .panel-title i { color: #4f8ef7; font-size: 13px; }
        .panel-subtitle { font-size: 12px; color: #94a3b8; }

        /* ══ TABLES ══ */
        .table { width: 100%; border-collapse: collapse; }
        .table th { padding: 10px 16px; text-align: left; font-size: 10.5px; font-weight: 600; color: #64748b; text-transform: uppercase; letter-spacing: 0.6px; background: #f8fafc; border-bottom: 1px solid #e8eaf0; }
        .table td { padding: 13px 16px; font-size: 13px; color: #374151; border-bottom: 1px solid #f5f6fa; vertical-align: middle; }
        .table tr:last-child td { border-bottom: none; }
        .table tr:hover td { background: #fafbff; }

        /* ══ BADGES ══ */
        .badge { display: inline-flex; align-items: center; gap: 4px; padding: 3px 10px; border-radius: 20px; font-size: 11px; font-weight: 600; }
        .badge-dot { width: 5px; height: 5px; border-radius: 50%; background: currentColor; }
        .badge-critico { background: #fef2f2; color: #dc2626; } .badge-alto { background: #fff7ed; color: #ea580c; }
        .badge-medio   { background: #fefce8; color: #ca8a04; } .badge-bajo  { background: #f0fdf4; color: #16a34a; }
        .badge-critica { background: #fef2f2; color: #dc2626; } .badge-alta  { background: #fff7ed; color: #ea580c; }
        .badge-media   { background: #fefce8; color: #ca8a04; } .badge-baja  { background: #f0fdf4; color: #16a34a; }
        .badge-activo  { background: #f0fdf4; color: #16a34a; } .badge-inactivo { background: #fef2f2; color: #dc2626; }
        .badge-en_mantenimiento { background: #eff6ff; color: #1d4ed8; }
        .badge-activa  { background: #f0fdf4; color: #16a34a; } .badge-inactiva { background: #f8fafc; color: #64748b; }
        .badge-accidental { background: #eff6ff; color: #1d4ed8; } .badge-deliberada { background: #fef2f2; color: #dc2626; }
        .badge-ambiental  { background: #f0fdf4; color: #16a34a; } .badge-tecnica { background: #fefce8; color: #ca8a04; }
        .badge-humana { background: #fdf4ff; color: #9333ea; }
        .badge-interno { background: #fff7ed; color: #ea580c; } .badge-externo { background: #fef2f2; color: #dc2626; }
        .badge-natural { background: #f0fdf4; color: #16a34a; }
        .badge-pendiente   { background: #f8fafc; color: #64748b; } .badge-en_progreso { background: #eff6ff; color: #1d4ed8; }
        .badge-completado  { background: #f0fdf4; color: #16a34a; } .badge-cancelado   { background: #fef2f2; color: #dc2626; }
        .badge-vencido     { background: #fff7ed; color: #ea580c; } .badge-urgente     { background: #fef2f2; color: #dc2626; }
        .badge-borrador    { background: #f8fafc; color: #64748b; } .badge-cerrada     { background: #eff6ff; color: #1d4ed8; }
        .badge-reevaluacion{ background: #fff7ed; color: #ea580c; }
        .badge-exitoso { background: #f0fdf4; color: #16a34a; } .badge-fallido { background: #fef2f2; color: #dc2626; }
        .badge-manual  { background: #f8fafc; color: #64748b; } .badge-automatico { background: #fdf4ff; color: #9333ea; }
        .badge-en_proceso { background: #eff6ff; color: #1d4ed8; }

        /* ══ BUTTONS ══ */
        .btn { display: inline-flex; align-items: center; gap: 6px; padding: 8px 16px; border-radius: 9px; font-size: 13px; font-weight: 500; cursor: pointer; border: none; text-decoration: none; transition: all 0.15s; white-space: nowrap; font-family: inherit; line-height: 1; }
        .btn-sm  { padding: 6px 13px; font-size: 12px; border-radius: 8px; }
        .btn-xs  { padding: 4px 9px; font-size: 11px; border-radius: 7px; }
        .btn-primary { background: #4f8ef7; color: #fff; } .btn-primary:hover { background: #3b7de8; box-shadow: 0 4px 12px rgba(79,142,247,0.3); }
        .btn-secondary { background: #1b1f3b; color: #fff; } .btn-secondary:hover { background: #111432; }
        .btn-outline { background: #fff; color: #475569; border: 1.5px solid #e8eaf0; } .btn-outline:hover { border-color: #4f8ef7; color: #4f8ef7; }
        .btn-success { background: #f0fdf4; color: #16a34a; border: 1px solid #bbf7d0; } .btn-success:hover { background: #dcfce7; }
        .btn-danger  { background: #fef2f2; color: #dc2626; border: 1px solid #fecaca; } .btn-danger:hover  { background: #fee2e2; }
        .btn-warning { background: #fffbeb; color: #b45309; border: 1px solid #fde68a; } .btn-warning:hover { background: #fef3c7; }
        .btn-ghost   { background: transparent; color: #64748b; } .btn-ghost:hover { background: #f5f6fb; color: #374151; }

        /* ══ ALERTS ══ */
        .alert { display: flex; align-items: flex-start; gap: 10px; padding: 12px 16px; border-radius: 10px; border: 1px solid; margin-bottom: 16px; font-size: 13px; font-weight: 500; }
        .alert i { margin-top: 1px; flex-shrink: 0; }
        .alert-success { background: #f0fdf4; border-color: #bbf7d0; color: #15803d; }
        .alert-error   { background: #fef2f2; border-color: #fecaca; color: #dc2626; }
        .alert-warning { background: #fffbeb; border-color: #fde68a; color: #b45309; }
        .alert-info    { background: #eff6ff; border-color: #bfdbfe; color: #1d4ed8; }

        /* ══ FORMS ══ */
        .form-card { background: #fff; border-radius: 14px; border: 1px solid #e8eaf0; overflow: hidden; max-width: 860px; }
        .form-header { padding: 22px 26px; border-bottom: 1px solid #f1f5f9; }
        .form-header h2 { font-size: 16px; font-weight: 700; color: #1b1f3b; display: flex; align-items: center; gap: 10px; }
        .form-header h2 i { color: #4f8ef7; }
        .form-header p { font-size: 12px; color: #94a3b8; margin-top: 5px; }
        .form-body { padding: 24px 26px; }
        .form-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 18px; }
        .form-group { display: flex; flex-direction: column; gap: 6px; }
        .form-group.full { grid-column: 1 / -1; }
        label { font-size: 12.5px; font-weight: 500; color: #374151; }
        label .req, label span.req { color: #ef4444; }
        input, select, textarea { padding: 10px 13px; border: 1.5px solid #e8eaf0; border-radius: 9px; font-size: 13px; color: #1e293b; font-family: inherit; outline: none; transition: border-color 0.15s, box-shadow 0.15s; background: #fff; width: 100%; }
        input:focus, select:focus, textarea:focus { border-color: #4f8ef7; box-shadow: 0 0 0 3px rgba(79,142,247,0.08); }
        textarea { resize: vertical; min-height: 85px; }
        .error-msg { font-size: 11.5px; color: #dc2626; margin-top: 2px; }
        .hint { font-size: 11px; color: #94a3b8; margin-top: 3px; }
        .form-footer { padding: 16px 26px; border-top: 1px solid #f1f5f9; display: flex; justify-content: flex-end; gap: 10px; background: #f8fafc; }

        /* ══ MISC ══ */
        .filter-bar { display: flex; gap: 10px; padding: 13px 18px; background: #f8fafc; border-bottom: 1px solid #f1f5f9; flex-wrap: wrap; align-items: center; }
        .filter-input { padding: 8px 12px; border: 1.5px solid #e8eaf0; border-radius: 9px; font-size: 13px; color: #374151; background: #fff; outline: none; font-family: inherit; transition: border-color 0.15s; }
        .filter-input:focus { border-color: #4f8ef7; }
        .empty-state { padding: 64px 20px; text-align: center; color: #94a3b8; }
        .empty-state i { font-size: 48px; margin-bottom: 16px; display: block; color: #cbd5e1; }
        .empty-state p { font-size: 14px; margin-bottom: 18px; }
        .actions { display: flex; gap: 5px; align-items: center; flex-wrap: wrap; }
        code.tag { background: #f1f5f9; color: #1e293b; padding: 2px 7px; border-radius: 5px; font-size: 12px; font-family: 'Cascadia Code', 'Fira Code', monospace; border: 1px solid #e8eaf0; }
        .detail-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 20px; padding: 20px 18px; }
        .detail-item { display: flex; flex-direction: column; gap: 5px; }
        .detail-label { font-size: 10.5px; font-weight: 600; color: #94a3b8; text-transform: uppercase; letter-spacing: 0.7px; }
        .detail-value { font-size: 13.5px; color: #1e293b; font-weight: 500; line-height: 1.4; }
        .text-block { padding: 16px 18px; border-top: 1px solid #f1f5f9; }
        .text-label { font-size: 10.5px; font-weight: 600; color: #94a3b8; text-transform: uppercase; letter-spacing: 0.7px; margin-bottom: 8px; }
        .text-content { font-size: 13px; color: #374151; line-height: 1.6; background: #f8fafc; padding: 12px; border-radius: 9px; border: 1px solid #f1f5f9; }
        .progress-track { height: 6px; background: #f1f5f9; border-radius: 3px; overflow: hidden; margin-top: 4px; }
        .progress-fill { height: 100%; border-radius: 3px; background: #4f8ef7; }
        .statusbar { background: #fff; border-top: 1px solid #e8eaf0; padding: 6px 24px; display: flex; align-items: center; gap: 18px; font-size: 11px; color: #94a3b8; }
        .statusbar-dot { width: 5px; height: 5px; border-radius: 50%; display: inline-block; margin-right: 4px; vertical-align: middle; }

        /* ══ CARD GRID (for activos, usuarios, roles) ══ */
        .card-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(300px, 1fr)); gap: 14px; }
        .item-card { background: #fff; border-radius: 13px; border: 1px solid #e8eaf0; overflow: hidden; transition: box-shadow 0.2s, transform 0.15s; }
        .item-card:hover { box-shadow: 0 6px 22px rgba(0,0,0,0.09); transform: translateY(-2px); }
        .item-card-header { padding: 16px 18px; border-bottom: 1px solid #f5f6fa; display: flex; align-items: center; gap: 13px; }
        .item-card-icon { width: 42px; height: 42px; border-radius: 11px; display: flex; align-items: center; justify-content: center; font-size: 17px; flex-shrink: 0; }
        .item-card-body { padding: 14px 18px; }
        .item-card-footer { padding: 12px 18px; background: #fafbff; border-top: 1px solid #f5f6fa; display: flex; align-items: center; justify-content: space-between; gap: 8px; }
        .item-card-name { font-size: 14.5px; font-weight: 700; color: #1b1f3b; }
        .item-card-sub { font-size: 11.5px; color: #94a3b8; margin-top: 2px; }
        .item-stat-row { display: flex; gap: 12px; margin-top: 12px; }
        .item-stat { flex: 1; background: #f5f6fb; border-radius: 8px; padding: 9px 12px; text-align: center; }
        .item-stat-num { font-size: 19px; font-weight: 700; color: #4f8ef7; }
        .item-stat-lbl { font-size: 9.5px; color: #94a3b8; text-transform: uppercase; letter-spacing: 0.5px; margin-top: 1px; }

        /* ══ SEARCH TABLE HIGHLIGHT ══ */
        .row-hidden { display: none; }

        /* ══ DARK MODE ══ */
        [data-theme="dark"] body { background:#0f1117; color:#e2e8f0; }
        [data-theme="dark"] .sidebar { background: rgba(10,11,22,0.88); border-right-color: rgba(255,255,255,0.05); }
        [data-theme="dark"] .topbar { background:#161b2e; border-bottom-color:#2a2f45; }
        [data-theme="dark"] .topbar-title { color:#e2e8f0; }
        [data-theme="dark"] .topbar-date { color:#64748b; }
        [data-theme="dark"] .topbar-search input { background:#1e2438; border-color:#2a2f45; color:#e2e8f0; }
        [data-theme="dark"] .topbar-search input::placeholder { color:#475569; }
        [data-theme="dark"] .topbar-icon { background:#1e2438; }
        [data-theme="dark"] .notif-btn { background:#1e2438; border-color:#2a2f45; color:#94a3b8; }
        [data-theme="dark"] .app-content { background:#0f1117; }
        [data-theme="dark"] .statusbar { background:#161b2e; border-top-color:#2a2f45; color:#64748b; }

        [data-theme="dark"] .panel { background:#1a1f2e !important; border-color:#2a2f45 !important; }
        [data-theme="dark"] .panel-header { border-bottom-color:#2a2f45 !important; }
        [data-theme="dark"] .panel-title { color:#e2e8f0 !important; }
        [data-theme="dark"] .panel-subtitle { color:#64748b !important; }

        [data-theme="dark"] .stat-card { background:#1a1f2e !important; border-color:#2a2f45 !important; }
        [data-theme="dark"] .stat-num { color:#e2e8f0; }
        [data-theme="dark"] .stat-lbl { color:#64748b; }

        [data-theme="dark"] .risk-card { background:#1a1f2e; border-color:#2a2f45; }
        [data-theme="dark"] .risk-card-title { color:#e2e8f0; }
        [data-theme="dark"] .risk-card-footer { border-top-color:#2a2f45; }
        [data-theme="dark"] .rc-id { background:#0f1117; border-color:#2a2f45; color:#94a3b8; }
        [data-theme="dark"] .rc-name { color:#cbd5e1; }

        [data-theme="dark"] .item-card { background:#1a1f2e; border-color:#2a2f45; }
        [data-theme="dark"] .item-card-header { border-bottom-color:#2a2f45; }
        [data-theme="dark"] .item-card-name { color:#e2e8f0; }
        [data-theme="dark"] .item-card-body { color:#cbd5e1; }
        [data-theme="dark"] .item-card-footer { background:#161b2e; border-top-color:#2a2f45; }
        [data-theme="dark"] .item-stat { background:#161b2e; }

        [data-theme="dark"] .table th { background:#161b2e; color:#64748b; border-bottom-color:#2a2f45; }
        [data-theme="dark"] .table td { color:#cbd5e1; border-bottom-color:#1e2438; }
        [data-theme="dark"] .table tr:hover td { background:#1e2438; }

        [data-theme="dark"] .filter-tabs { background:#1a1f2e; border-color:#2a2f45; }
        [data-theme="dark"] .filter-tab { color:#94a3b8; }
        [data-theme="dark"] .filter-tab:hover { background:#1e2438; color:#e2e8f0; }
        [data-theme="dark"] .filter-tab:not(.active):not(.active-red):not(.active-orange):not(.active-yellow):not(.active-green) .tab-count { background:#1e2438; color:#94a3b8; }

        [data-theme="dark"] .kch-critico { background:rgba(239,68,68,.15); }
        [data-theme="dark"] .kch-alto    { background:rgba(249,115,22,.15); }
        [data-theme="dark"] .kch-medio   { background:rgba(234,179,8,.15); }
        [data-theme="dark"] .kch-bajo    { background:rgba(34,197,94,.15); }

        [data-theme="dark"] .btn-outline { background:#1a1f2e; color:#94a3b8; border-color:#2a2f45; }
        [data-theme="dark"] .btn-outline:hover { border-color:#4f8ef7; color:#4f8ef7; background:#1e2438; }
        [data-theme="dark"] .btn-ghost { color:#94a3b8; }

        [data-theme="dark"] .form-card { background:#1a1f2e; border-color:#2a2f45; }
        [data-theme="dark"] .form-header { border-bottom-color:#2a2f45; }
        [data-theme="dark"] .form-header h2 { color:#e2e8f0; }
        [data-theme="dark"] .form-footer { background:#161b2e; border-top-color:#2a2f45; }
        [data-theme="dark"] input,[data-theme="dark"] select,[data-theme="dark"] textarea { background:#1e2438; border-color:#2a2f45; color:#e2e8f0; }
        [data-theme="dark"] label { color:#cbd5e1; }
        [data-theme="dark"] .hint { color:#64748b; }

        [data-theme="dark"] code.tag { background:#1e2438; color:#e2e8f0; border-color:#2a2f45; }
        [data-theme="dark"] .detail-value { color:#e2e8f0; }
        [data-theme="dark"] .detail-label { color:#64748b; }
        [data-theme="dark"] .text-content { background:#161b2e; border-color:#2a2f45; color:#cbd5e1; }
        [data-theme="dark"] .text-label { color:#64748b; }
        [data-theme="dark"] .filter-bar { background:#161b2e; border-bottom-color:#2a2f45; }
        [data-theme="dark"] .filter-input { background:#1e2438; border-color:#2a2f45; color:#e2e8f0; }
        [data-theme="dark"] .empty-state { color:#475569; }
        [data-theme="dark"] .empty-state i { color:#2a2f45; }
        [data-theme="dark"] .alert-error { background:#2d1515; border-color:#7f1d1d; color:#fca5a5; }
        [data-theme="dark"] .alert-success { background:#0d2318; border-color:#14532d; color:#86efac; }
        [data-theme="dark"] .alert-warning { background:#2d1f0a; border-color:#78350f; color:#fcd34d; }
        [data-theme="dark"] .alert-info { background:#0d1f3c; border-color:#1e3a5f; color:#93c5fd; }

        /* ── Roles ── */
        [data-theme="dark"] .role-card { background:#1a1f2e !important; border-color:#2a2f45 !important; }
        [data-theme="dark"] .role-card-header { border-bottom-color:#2a2f45 !important; }
        [data-theme="dark"] .role-name { color:#e2e8f0 !important; }
        [data-theme="dark"] .role-desc { color:#64748b !important; }
        [data-theme="dark"] .role-stats { border-bottom-color:#2a2f45 !important; }
        [data-theme="dark"] .role-stat { border-right-color:#2a2f45 !important; }
        [data-theme="dark"] .role-stat-label { color:#64748b !important; }
        [data-theme="dark"] .role-card-footer { background:#161b2e !important; border-top-color:#2a2f45 !important; }

        /* ── Roles show/edit ── */
        [data-theme="dark"] .role-header-section { background:#1a1f2e !important; border-color:#2a2f45 !important; }
        [data-theme="dark"] .stat-chip { background:#161b2e !important; border-color:#2a2f45 !important; color:#cbd5e1 !important; }
        [data-theme="dark"] .perm-module-header { background:#161b2e !important; border-color:#2a2f45 !important; color:#e2e8f0 !important; }
        [data-theme="dark"] .perm-module-body { background:#1a1f2e !important; border-color:#2a2f45 !important; }
        [data-theme="dark"] .perm-chip { background:#1e2438 !important; border-color:#2a2f45 !important; color:#94a3b8 !important; }
        [data-theme="dark"] .perm-has { background:#0d2318 !important; border-color:#14532d !important; color:#86efac !important; }
        [data-theme="dark"] .perm-not { background:#1e2438 !important; border-color:#2a2f45 !important; color:#475569 !important; }
        [data-theme="dark"] .module-block { border-color:#2a2f45 !important; }
        [data-theme="dark"] .module-header { background:#161b2e !important; color:#e2e8f0 !important; border-color:#2a2f45 !important; }
        [data-theme="dark"] .module-body { background:#1a1f2e !important; }
        [data-theme="dark"] .action-bar { background:#161b2e !important; border-top-color:#2a2f45 !important; }
        [data-theme="dark"] .warning-note { background:#2d1f0a !important; border-color:#78350f !important; color:#fcd34d !important; }
        [data-theme="dark"] .select-all-btn { background:#1e2438 !important; color:#94a3b8 !important; border-color:#2a2f45 !important; }

        /* ── Matriz ── */
        [data-theme="dark"] .matriz-wrap { background:#1a1f2e !important; border-color:#2a2f45 !important; }
        [data-theme="dark"] .matriz-title { color:#e2e8f0 !important; }
        [data-theme="dark"] .matriz-axis { color:#64748b !important; }
        [data-theme="dark"] .mc-bajo    { background:rgba(34,197,94,.15) !important; }
        [data-theme="dark"] .mc-medio   { background:rgba(234,179,8,.12) !important; }
        [data-theme="dark"] .mc-alto    { background:rgba(249,115,22,.15) !important; }
        [data-theme="dark"] .mc-critico { background:rgba(239,68,68,.15) !important; }
        [data-theme="dark"] .ley-item { color:#94a3b8 !important; }

        /* ── Usuarios ── */
        [data-theme="dark"] .profile-header { background:linear-gradient(135deg,#161b2e,#1a1f2e) !important; border-color:#2a2f45 !important; }

        /* ── Kanban empty placeholder ── */
        .kanban-empty { background:#f8fafc; border-radius:10px; border:1.5px dashed #e8eaf0; padding:24px 14px; text-align:center; color:#cbd5e1; font-size:11.5px; }
        [data-theme="dark"] .kanban-empty { background:#1e2438 !important; border-color:#2a2f45 !important; color:#475569 !important; }
    </style>
</head>
<body>

<aside class="sidebar">

    {{-- Header --}}
    <div class="sidebar-header">
        <a href="{{ route('dashboard') }}" class="sidebar-logo"><i class="fas fa-shield-alt"></i></a>
        <div>
            <div class="sidebar-app-name">RiskGuard TI</div>
            <div class="sidebar-app-sub">Gestión de Riesgos</div>
        </div>
    </div>

    {{-- Usuario --}}
    <div class="sidebar-user">
        <div class="sidebar-user-avatar">{{ strtoupper(substr(auth()->user()->name, 0, 2)) }}</div>
        <div style="min-width:0;">
            <div class="sidebar-user-name">{{ auth()->user()->name }}</div>
            <div class="sidebar-user-role">{{ auth()->user()->getRoleNames()->first() ?? 'Sin rol' }}</div>
        </div>
    </div>

    {{-- Navegación con scroll --}}
    <nav class="sidebar-nav">
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
            <i class="fas fa-chevron-down" id="reportesChevron" style="margin-left:auto;font-size:9px;transition:transform 0.2s;"></i>
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
        <div class="topbar-left">
            @yield('topbar-left')
        </div>

        <div class="topbar-search">
            <i class="fas fa-search topbar-search-icon"></i>
            <input type="text" id="globalSearch" placeholder="Buscar en el sistema..." autocomplete="off">
        </div>

        <div class="topbar-right">
            <span class="topbar-date">{{ now()->format('d M Y') }}</span>
            <button id="themeToggle" class="notif-btn" onclick="toggleTheme()" title="Modo oscuro" style="cursor:pointer;border:none;font-family:inherit;">
                <i class="fas fa-moon"></i>
            </button>
            <a href="{{ route('bitacora.index') }}" class="notif-btn" title="Bitácora de auditoría">
                <i class="fas fa-bell"></i>
            </a>
            @yield('topbar-right')
        </div>
    </header>

    <div class="app-content">
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
    </div>

    <footer class="statusbar">
        <span><span class="statusbar-dot" style="background:#22c55e;"></span>Sistema operativo</span>
        <span><span class="statusbar-dot" style="background:#22c55e;"></span>BD conectada</span>
        <span style="margin-left:auto;">ISO 27001 · RiskGuard TI v2.0 · {{ auth()->user()->getRoleNames()->first() ?? 'Sin rol' }}</span>
    </footer>
</div>

@stack('scripts')
<script>
function toggleTheme() {
    var curr = document.documentElement.getAttribute('data-theme');
    var next = curr === 'dark' ? 'light' : 'dark';
    document.documentElement.setAttribute('data-theme', next);
    localStorage.setItem('rg-theme', next);
    updateThemeIcon(next);
}
function updateThemeIcon(t) {
    var btn = document.getElementById('themeToggle');
    if (btn) btn.innerHTML = t === 'dark' ? '<i class="fas fa-sun"></i>' : '<i class="fas fa-moon"></i>';
}
updateThemeIcon(document.documentElement.getAttribute('data-theme'));

function toggleReportes(e) {
    e.preventDefault();
    var menu = document.getElementById('reportesMenu');
    var chevron = document.getElementById('reportesChevron');
    if (!menu) return;
    var open = menu.style.display !== 'none';
    menu.style.display = open ? 'none' : 'block';
    if (chevron) chevron.style.transform = open ? '' : 'rotate(180deg)';
}
</script>
</body>
</html>

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
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
        body { font-family: 'Inter', -apple-system, sans-serif; background: #f0f2f5; color: #1e293b; min-height: 100vh; display: flex; }

        /* ══ SIDEBAR (icon-only 68px) ══ */
        .sidebar {
            width: 68px; min-height: 100vh;
            background: #1b1f3b;
            display: flex; flex-direction: column; align-items: center;
            padding: 12px 0; position: fixed; top: 0; left: 0; z-index: 200;
        }
        .sidebar-logo {
            width: 44px; height: 44px;
            background: linear-gradient(135deg, #4f8ef7 0%, #6366f1 100%);
            border-radius: 13px; display: flex; align-items: center; justify-content: center;
            color: #fff; font-size: 18px; margin-bottom: 18px; flex-shrink: 0;
            box-shadow: 0 4px 16px rgba(99,102,241,0.45); text-decoration: none;
            transition: transform 0.15s;
        }
        .sidebar-logo:hover { transform: scale(1.06); }

        .sidebar-nav { flex: 1; display: flex; flex-direction: column; align-items: center; gap: 2px; width: 100%; padding: 0 10px; }
        .nav-sep { width: 36px; height: 1px; background: rgba(255,255,255,0.07); margin: 8px 0; }

        .nav-icon {
            width: 46px; height: 46px; border-radius: 13px;
            display: flex; align-items: center; justify-content: center;
            color: rgba(255,255,255,0.4); font-size: 15px; cursor: pointer;
            transition: all 0.15s; text-decoration: none; position: relative;
        }
        .nav-icon:hover { background: rgba(255,255,255,0.07); color: rgba(255,255,255,0.8); }
        .nav-icon.active { background: #4f8ef7; color: #fff; box-shadow: 0 4px 14px rgba(79,142,247,0.45); }
        .nav-icon.active-soft { background: rgba(79,142,247,0.15); color: #93c5fd; }

        .nav-icon::after {
            content: attr(data-tip);
            position: absolute; left: calc(100% + 12px); top: 50%; transform: translateY(-50%);
            background: #1b1f3b; color: #e2e8f0; font-size: 11.5px; font-weight: 500;
            padding: 6px 11px; border-radius: 8px; white-space: nowrap;
            pointer-events: none; opacity: 0; transition: opacity 0.15s;
            border: 1px solid rgba(255,255,255,0.08); z-index: 999;
            box-shadow: 0 4px 12px rgba(0,0,0,0.3);
        }
        .nav-icon:hover::after { opacity: 1; }

        .sidebar-bottom { display: flex; flex-direction: column; align-items: center; gap: 8px; padding-bottom: 6px; }
        .user-avatar-sm {
            width: 38px; height: 38px; border-radius: 50%;
            background: linear-gradient(135deg, #4f8ef7, #8b5cf6);
            display: flex; align-items: center; justify-content: center;
            font-weight: 700; font-size: 12px; color: #fff; cursor: pointer;
            border: 2px solid rgba(255,255,255,0.12); transition: all 0.15s;
            position: relative;
        }
        .user-avatar-sm::after {
            content: attr(data-tip);
            position: absolute; left: calc(100% + 12px); top: 50%; transform: translateY(-50%);
            background: #1b1f3b; color: #e2e8f0; font-size: 11.5px; font-weight: 500;
            padding: 6px 11px; border-radius: 8px; white-space: nowrap;
            pointer-events: none; opacity: 0; transition: opacity 0.15s;
            border: 1px solid rgba(255,255,255,0.08); z-index: 999;
        }
        .user-avatar-sm:hover::after { opacity: 1; }
        .user-avatar-sm:hover { border-color: rgba(255,255,255,0.3); }
        .logout-icon-btn {
            width: 38px; height: 38px; border-radius: 12px;
            background: rgba(239,68,68,0.08); border: 1px solid rgba(239,68,68,0.14);
            color: rgba(252,165,165,0.55); display: flex; align-items: center; justify-content: center;
            cursor: pointer; font-size: 14px; transition: all 0.15s;
            position: relative;
        }
        .logout-icon-btn::after {
            content: "Cerrar sesión";
            position: absolute; left: calc(100% + 12px); top: 50%; transform: translateY(-50%);
            background: #1b1f3b; color: #e2e8f0; font-size: 11.5px; font-weight: 500;
            padding: 6px 11px; border-radius: 8px; white-space: nowrap;
            pointer-events: none; opacity: 0; transition: opacity 0.15s;
            border: 1px solid rgba(255,255,255,0.08); z-index: 999;
        }
        .logout-icon-btn:hover { background: rgba(239,68,68,0.16); color: #fca5a5; }
        .logout-icon-btn:hover::after { opacity: 1; }

        /* ══ APP WRAPPER ══ */
        .app-wrapper { margin-left: 68px; flex: 1; min-height: 100vh; display: flex; flex-direction: column; }

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
        .app-content { padding: 22px 24px; flex: 1; }

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
    </style>
</head>
<body>

<aside class="sidebar">
    <a href="{{ route('dashboard') }}" class="sidebar-logo"><i class="fas fa-shield-alt"></i></a>

    <nav class="sidebar-nav">
        <a href="{{ route('dashboard') }}" class="nav-icon {{ request()->routeIs('dashboard') ? 'active' : '' }}" data-tip="Dashboard">
            <i class="fas fa-chart-pie"></i>
        </a>
        <a href="{{ route('matriz.index') }}" class="nav-icon {{ request()->routeIs('matriz.*') ? 'active' : '' }}" data-tip="Matriz de Riesgos">
            <i class="fas fa-th"></i>
        </a>

        <div class="nav-sep"></div>

        <a href="{{ route('activos.index') }}" class="nav-icon {{ request()->routeIs('activos.*') ? 'active' : '' }}" data-tip="Activos TI">
            <i class="fas fa-server"></i>
        </a>
        <a href="{{ route('amenazas.index') }}" class="nav-icon {{ request()->routeIs('amenazas.*') ? 'active' : '' }}" data-tip="Amenazas">
            <i class="fas fa-biohazard"></i>
        </a>
        <a href="{{ route('evaluaciones.index') }}" class="nav-icon {{ request()->routeIs('evaluaciones.index','evaluaciones.show','evaluaciones.edit') ? 'active' : '' }}" data-tip="Evaluaciones">
            <i class="fas fa-search-plus"></i>
        </a>
        <a href="{{ route('evaluaciones.create') }}" class="nav-icon {{ request()->routeIs('evaluaciones.create') ? 'active' : '' }}" data-tip="Cálculo de Riesgo">
            <i class="fas fa-calculator"></i>
        </a>
        <a href="{{ route('mitigacion.index') }}" class="nav-icon {{ request()->routeIs('mitigacion.*') ? 'active' : '' }}" data-tip="Mitigación">
            <i class="fas fa-shield-virus"></i>
        </a>

        <div class="nav-sep"></div>

        <a href="{{ route('bitacora.index') }}" class="nav-icon {{ request()->routeIs('bitacora.*') ? 'active' : '' }}" data-tip="Bitácora">
            <i class="fas fa-clipboard-list"></i>
        </a>

        <div class="nav-sep"></div>

        <a href="{{ route('usuarios.index') }}" class="nav-icon {{ request()->routeIs('usuarios.*') ? 'active' : '' }}" data-tip="Usuarios">
            <i class="fas fa-users-cog"></i>
        </a>
        <a href="{{ route('roles.index') }}" class="nav-icon {{ request()->routeIs('roles.*') ? 'active' : '' }}" data-tip="Control de Roles">
            <i class="fas fa-user-shield"></i>
        </a>
        <a href="{{ route('respaldos.index') }}" class="nav-icon {{ request()->routeIs('respaldos.*') ? 'active' : '' }}" data-tip="Respaldo BD">
            <i class="fas fa-database"></i>
        </a>
    </nav>

    <div class="sidebar-bottom">
        <div class="user-avatar-sm" data-tip="{{ auth()->user()->name }}">{{ strtoupper(substr(auth()->user()->name, 0, 2)) }}</div>
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="logout-icon-btn"><i class="fas fa-sign-out-alt"></i></button>
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
</body>
</html>

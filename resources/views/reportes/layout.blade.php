<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<style>
* { margin:0; padding:0; box-sizing:border-box; }
body { font-family: DejaVu Sans, sans-serif; font-size:11px; color:#1e293b; background:#fff; }

/* ── HEADER ── */
.rpt-header {
    background: linear-gradient(135deg, #1b1f3b 0%, #2d3561 100%);
    color:#fff; padding:18px 24px; margin-bottom:20px;
    display:table; width:100%;
}
.rpt-header-left { display:table-cell; vertical-align:middle; }
.rpt-logo {
    width:38px; height:38px; background:linear-gradient(135deg,#4f8ef7,#6366f1);
    border-radius:9px; display:inline-block; text-align:center; line-height:38px;
    font-size:18px; margin-right:12px; vertical-align:middle;
}
.rpt-title { font-size:18px; font-weight:700; letter-spacing:0.3px; vertical-align:middle; display:inline-block; }
.rpt-subtitle { font-size:11px; color:rgba(255,255,255,0.55); margin-top:3px; }
.rpt-header-right { display:table-cell; text-align:right; vertical-align:middle; font-size:10px; color:rgba(255,255,255,0.6); }
.rpt-header-right strong { display:block; font-size:12px; color:#fff; margin-bottom:2px; }

/* ── STATS ROW ── */
.stats-row { display:table; width:100%; margin-bottom:18px; border-collapse:separate; border-spacing:10px 0; }
.stat-box {
    display:table-cell; text-align:center; padding:14px 10px;
    border-radius:10px; border:1px solid #e8eaf0;
}
.stat-box .num { font-size:26px; font-weight:800; line-height:1; }
.stat-box .lbl { font-size:9px; color:#94a3b8; text-transform:uppercase; letter-spacing:0.5px; margin-top:4px; }
.sb-red    { background:#fef2f2; border-color:#fecaca; }
.sb-red .num { color:#dc2626; }
.sb-orange { background:#fff7ed; border-color:#fed7aa; }
.sb-orange .num { color:#ea580c; }
.sb-yellow { background:#fefce8; border-color:#fde68a; }
.sb-yellow .num { color:#ca8a04; }
.sb-green  { background:#f0fdf4; border-color:#bbf7d0; }
.sb-green .num { color:#16a34a; }
.sb-blue   { background:#eff6ff; border-color:#bfdbfe; }
.sb-blue .num { color:#1d4ed8; }
.sb-slate  { background:#f8fafc; border-color:#e2e8f0; }
.sb-slate .num { color:#475569; }

/* ── SECTION TITLE ── */
.section-title {
    font-size:12px; font-weight:700; color:#1b1f3b;
    border-left:3px solid #4f8ef7; padding-left:9px;
    margin-bottom:10px; margin-top:18px;
}

/* ── TABLE ── */
table.rpt { width:100%; border-collapse:collapse; margin-bottom:16px; }
table.rpt thead tr { background:#1b1f3b; color:#fff; }
table.rpt thead th { padding:8px 10px; font-size:9.5px; font-weight:600; text-align:left; letter-spacing:0.4px; text-transform:uppercase; }
table.rpt tbody tr:nth-child(even) { background:#f8fafc; }
table.rpt tbody tr:hover { background:#eff6ff; }
table.rpt tbody td { padding:7px 10px; font-size:10px; border-bottom:1px solid #f1f5f9; vertical-align:middle; }

/* ── BADGES ── */
.badge { display:inline-block; padding:2px 8px; border-radius:20px; font-size:9px; font-weight:700; }
.b-critico,.b-critica  { background:#fef2f2; color:#dc2626; }
.b-alto,.b-alta        { background:#fff7ed; color:#ea580c; }
.b-medio,.b-media      { background:#fefce8; color:#ca8a04; }
.b-bajo,.b-baja        { background:#f0fdf4; color:#16a34a; }
.b-activo,.b-activa    { background:#f0fdf4; color:#16a34a; }
.b-inactivo,.b-inactiva{ background:#fef2f2; color:#dc2626; }
.b-pendiente           { background:#f8fafc; color:#64748b; }
.b-en_progreso         { background:#eff6ff; color:#1d4ed8; }
.b-completado          { background:#f0fdf4; color:#16a34a; }
.b-cancelado           { background:#fef2f2; color:#dc2626; }
.b-vencido             { background:#fff7ed; color:#ea580c; }
.b-urgente             { background:#fef2f2; color:#dc2626; }
.b-en_mantenimiento    { background:#eff6ff; color:#1d4ed8; }
.b-accidental,.b-deliberada,.b-ambiental,.b-tecnica,.b-humana { background:#f8fafc; color:#475569; }

/* ── PROGRESS BAR ── */
.prog-wrap { background:#f1f5f9; border-radius:4px; height:8px; width:100%; }
.prog-fill  { height:8px; border-radius:4px; }
.prog-green  { background:#22c55e; }
.prog-blue   { background:#4f8ef7; }
.prog-orange { background:#f97316; }
.prog-red    { background:#ef4444; }

/* ── FOOTER ── */
.rpt-footer {
    position:fixed; bottom:0; left:0; right:0;
    border-top:1px solid #e8eaf0; padding:6px 24px;
    display:table; width:100%; font-size:9px; color:#94a3b8;
    background:#fff;
}
.rpt-footer-left  { display:table-cell; text-align:left; }
.rpt-footer-right { display:table-cell; text-align:right; }

/* ── NOTE BOX ── */
.note-box { background:#eff6ff; border:1px solid #bfdbfe; border-radius:8px; padding:10px 14px; margin-bottom:14px; font-size:10px; color:#1d4ed8; }

/* ── MATRIZ ── */
.mz-table { border-collapse:collapse; margin:0 auto; }
.mz-table td { width:52px; height:42px; text-align:center; font-size:11px; font-weight:700; border:2px solid #fff; border-radius:4px; }
.mz-bajo    { background:#d1fae5; color:#065f46; }
.mz-medio   { background:#fef9c3; color:#854d0e; }
.mz-alto    { background:#ffedd5; color:#9a3412; }
.mz-critico { background:#fee2e2; color:#991b1b; }
.mz-axis    { background:transparent; color:#64748b; font-size:9px; font-weight:600; border:none !important; }
</style>
</head>
<body>

<div class="rpt-header">
    <div class="rpt-header-left">
        <span class="rpt-logo">&#9737;</span>
        <span class="rpt-title">RiskGuard TI &mdash; @yield('rpt-titulo')</span>
        <div class="rpt-subtitle" style="margin-left:50px;">Sistema de Gestión de Riesgos &bull; ISO 27001</div>
    </div>
    <div class="rpt-header-right">
        <strong>Generado por</strong>
        {{ $generado_por }}<br>{{ $generado_en }}
    </div>
</div>

@yield('content')

<div class="rpt-footer">
    <div class="rpt-footer-left">RiskGuard TI &bull; Reporte Confidencial</div>
    <div class="rpt-footer-right">Generado el {{ $generado_en }}</div>
</div>

</body>
</html>

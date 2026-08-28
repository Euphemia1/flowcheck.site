<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FlowCheck — Workflow & Operations Platform for Procurement, Logistics & Supply Chain</title>
    <meta name="description" content="One platform for requests, approvals, procurement, logistics, expediting, and operations — built for supply chain, freight, transport and mining-scale organisations.">
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=space-grotesk:400,500,600,700&display=swap" rel="stylesheet"/>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        * { box-sizing: border-box; }
        body { background:#fff; color:#0f172a; font-family:'Space Grotesk',sans-serif; margin:0; }

        /* ── Nav ── */
        .nav-wrap { position:fixed; top:0; left:0; right:0; z-index:50; background:#fff; border-bottom:1px solid #e2e8f0; }
        .nav-inner { max-width:1280px; margin:0 auto; padding:0 24px; display:flex; align-items:center; justify-content:space-between; height:64px; }
        .nav-logo { display:flex; align-items:center; gap:10px; }
        .logo-box { width:32px; height:32px; background:#2563eb; border-radius:8px; display:flex; align-items:center; justify-content:center; flex-shrink:0; }
        .logo-text { font-size:18px; font-weight:800; color:#0f172a; letter-spacing:-0.4px; }
        .nav-links { display:flex; align-items:center; gap:2px; }
        .nav-link { display:flex; align-items:center; gap:4px; padding:8px 14px; font-size:14px; font-weight:500; color:#475569; border-radius:8px; text-decoration:none; transition:all .15s; }
        .nav-link:hover { color:#0f172a; background:#f1f5f9; }
        .nav-actions { display:flex; align-items:center; gap:12px; }
        .btn-login { font-size:14px; font-weight:600; color:#475569; text-decoration:none; padding:8px 12px; border-radius:8px; transition:all .15s; }
        .btn-login:hover { color:#0f172a; background:#f1f5f9; }
        .btn-cta { display:inline-flex; align-items:center; padding:10px 18px; background:#2563eb; color:#fff; font-size:14px; font-weight:700; border-radius:10px; text-decoration:none; transition:all .15s; }
        .btn-cta:hover { background:#1d4ed8; box-shadow:0 4px 16px rgba(37,99,235,.35); transform:translateY(-1px); }

        /* ── Sections ── */
        .section { padding:80px 0; }
        .section-inner { max-width:1280px; margin:0 auto; padding:0 24px; }
        .section-label { font-size:11px; font-weight:700; letter-spacing:1.5px; text-transform:uppercase; margin-bottom:12px; }
        .section-title { font-size:32px; font-weight:900; line-height:1.2; color:#0f172a; }
        .section-sub { font-size:16px; color:#64748b; line-height:1.7; margin-top:12px; }

        /* ── Hero ── */
        .hero-section { padding:112px 0 80px; background:linear-gradient(135deg, #f8faff 0%, #ffffff 40%, #f0f7ff 100%); }
        .hero-grid { display:grid; grid-template-columns:1fr 1fr; gap:56px; align-items:center; }
        .hero-h1 { font-size:52px; font-weight:900; line-height:1.08; color:#0f172a; letter-spacing:-1.5px; margin:0 0 20px; }
        .hero-sub { font-size:17px; color:#64748b; line-height:1.7; margin:0 0 32px; max-width:420px; }
        .hero-btns { display:flex; gap:12px; flex-wrap:wrap; margin-bottom:28px; }
        .btn-primary-lg { display:inline-flex; align-items:center; padding:13px 28px; background:#2563eb; color:#fff; font-size:14px; font-weight:700; border-radius:10px; text-decoration:none; transition:all .15s; }
        .btn-primary-lg:hover { background:#1d4ed8; box-shadow:0 6px 20px rgba(37,99,235,.35); transform:translateY(-1px); }
        .btn-outline-lg { display:inline-flex; align-items:center; padding:12px 28px; border:2px solid #e2e8f0; color:#0f172a; font-size:14px; font-weight:700; border-radius:10px; text-decoration:none; background:#fff; transition:all .15s; }
        .btn-outline-lg:hover { border-color:#94a3b8; background:#f8fafc; }
        .trust-checks { display:flex; flex-wrap:wrap; gap:20px; }
        .trust-check { display:flex; align-items:center; gap:7px; font-size:13px; color:#64748b; }
        .check-icon { color:#2563eb; flex-shrink:0; }

        /* Dashboard card */
        .dash-card { background:#fff; border-radius:20px; border:1px solid #e2e8f0; overflow:hidden; box-shadow:0 24px 80px rgba(15,23,42,.1), 0 4px 16px rgba(15,23,42,.06); }
        .dash-topbar { display:flex; align-items:center; justify-content:space-between; padding:12px 16px; border-bottom:1px solid #f1f5f9; }
        .dash-logo { display:flex; align-items:center; gap:8px; }
        .dash-logo-box { width:20px; height:20px; background:#2563eb; border-radius:5px; display:flex; align-items:center; justify-content:center; }
        .dash-topbar-icons { display:flex; gap:6px; }
        .dash-icon { width:28px; height:28px; background:#f1f5f9; border-radius:50%; display:flex; align-items:center; justify-content:center; }
        .dash-body { display:flex; height:280px; }
        .dash-sidebar { width:128px; background:#f8fafc; border-right:1px solid #f1f5f9; padding:10px 0; flex-shrink:0; }
        .dash-sidebar-active { display:flex; align-items:center; gap:7px; padding:8px 10px; background:#2563eb; border-radius:7px; margin:0 8px 2px; }
        .dash-sidebar-item { display:flex; align-items:center; gap:7px; padding:7px 10px; margin:0 8px 2px; border-radius:7px; }
        .dash-sidebar-item:hover { background:#f1f5f9; }
        .dash-main { flex:1; padding:14px; overflow:hidden; }
        .dash-main-title { font-size:12px; font-weight:700; color:#0f172a; margin-bottom:12px; }
        .dash-stats { display:grid; grid-template-columns:repeat(4,1fr); gap:8px; margin-bottom:12px; }
        .dash-stat { background:#fff; border:1px solid #f1f5f9; border-radius:10px; padding:10px; box-shadow:0 1px 3px rgba(0,0,0,.04); }
        .dash-stat-label { font-size:8.5px; color:#94a3b8; margin-bottom:4px; line-height:1.3; }
        .dash-stat-val { font-size:14px; font-weight:900; color:#0f172a; }
        .dash-stat-chg { font-size:8.5px; margin-top:3px; }
        .chg-green { color:#16a34a; }
        .chg-red { color:#dc2626; }
        .dash-charts { display:grid; grid-template-columns:1fr 1fr; gap:10px; }
        .dash-chart { background:#fff; border:1px solid #f1f5f9; border-radius:10px; padding:10px; box-shadow:0 1px 3px rgba(0,0,0,.04); }
        .dash-chart-title { font-size:9px; font-weight:600; color:#64748b; margin-bottom:8px; }
        .donut-wrap { display:flex; align-items:center; gap:10px; }
        .donut { width:60px; height:60px; border-radius:50%; background:conic-gradient(#2563eb 0deg 244deg,#f59e0b 244deg 290deg,#ef4444 290deg 360deg); display:flex; align-items:center; justify-content:center; flex-shrink:0; }
        .donut::after { content:''; width:40px; height:40px; background:#fff; border-radius:50%; display:block; }
        .donut-legend { display:flex; flex-direction:column; gap:4px; }
        .donut-row { display:flex; align-items:center; gap:5px; font-size:8.5px; color:#64748b; }
        .donut-dot { width:7px; height:7px; border-radius:50%; flex-shrink:0; display:inline-block; }

        /* ── Trust bar ── */
        .trust-bar { background:#f8fafc; border-top:1px solid #e2e8f0; border-bottom:1px solid #e2e8f0; padding:40px 0; }
        .trust-bar-label { font-size:11px; font-weight:700; letter-spacing:1.5px; text-transform:uppercase; color:#94a3b8; text-align:center; margin-bottom:28px; }
        .trust-logos { display:flex; flex-wrap:wrap; justify-content:center; align-items:center; gap:32px; }
        .trust-logo-item { display:flex; align-items:center; gap:7px; opacity:.5; filter:grayscale(1); transition:all .2s; text-decoration:none; }
        .trust-logo-item:hover { opacity:.8; filter:grayscale(0); }
        .trust-logo-name { font-size:13px; font-weight:800; color:#1e293b; letter-spacing:-.3px; }

        /* ── Problem ── */
        .problem-grid { display:grid; grid-template-columns:repeat(3,1fr); gap:40px; }
        .problem-item { text-align:center; padding:0 16px; }
        .problem-icon { width:52px; height:52px; border-radius:50%; display:flex; align-items:center; justify-content:center; margin:0 auto 16px; }
        .problem-title { font-size:15px; font-weight:700; color:#0f172a; margin:0 0 8px; }
        .problem-desc { font-size:13.5px; color:#64748b; line-height:1.6; margin:0; }

        /* ── Solution ── */
        .solution-section { background:#f8fafc; }
        .solution-grid { display:grid; grid-template-columns:1fr 1fr; gap:64px; align-items:center; }

        /* PR mockup */
        .pr-card { background:#fff; border-radius:18px; border:1px solid #e2e8f0; box-shadow:0 10px 40px rgba(15,23,42,.08); overflow:hidden; }
        .pr-breadcrumb { padding:14px 20px 12px; border-bottom:1px solid #f1f5f9; }
        .pr-back { font-size:12px; font-weight:600; color:#2563eb; }
        .pr-body { padding:20px; }
        .pr-header { display:flex; align-items:flex-start; justify-content:space-between; gap:12px; margin-bottom:16px; }
        .pr-title { font-size:14px; font-weight:700; color:#0f172a; margin:0 0 8px; }
        .pr-meta { display:flex; align-items:center; gap:8px; flex-wrap:wrap; }
        .pr-avatar { width:24px; height:24px; border-radius:50%; background:#dbeafe; display:flex; align-items:center; justify-content:center; font-size:10px; font-weight:700; color:#1d4ed8; flex-shrink:0; }
        .pr-meta-text { font-size:12px; color:#64748b; }
        .pr-badge-orange { background:#fff7ed; color:#c2410c; border:1px solid #fed7aa; font-size:11px; font-weight:700; padding:3px 10px; border-radius:20px; white-space:nowrap; flex-shrink:0; }
        .pr-amounts { display:grid; grid-template-columns:1fr 1fr; gap:12px; background:#f8fafc; border-radius:10px; padding:12px; margin-bottom:16px; }
        .pr-amount-label { font-size:10px; color:#94a3b8; margin-bottom:3px; }
        .pr-amount-val { font-size:14px; font-weight:700; color:#0f172a; }
        .pr-tabs { display:flex; gap:16px; border-bottom:1px solid #f1f5f9; margin-bottom:14px; }
        .pr-tab { font-size:12px; padding-bottom:8px; color:#94a3b8; border:none; background:none; cursor:pointer; }
        .pr-tab.active { color:#2563eb; border-bottom:2px solid #2563eb; font-weight:700; }
        .approval-section-label { font-size:10px; font-weight:700; text-transform:uppercase; letter-spacing:1px; color:#94a3b8; margin-bottom:8px; }
        .approval-row { display:flex; align-items:center; gap:10px; padding:8px 0; border-bottom:1px solid #f8fafc; }
        .approval-num { width:20px; height:20px; border-radius:50%; background:#f1f5f9; display:flex; align-items:center; justify-content:center; font-size:9px; font-weight:700; color:#64748b; flex-shrink:0; }
        .approval-info { flex:1; min-width:0; }
        .approval-role { font-size:11px; font-weight:600; color:#334155; }
        .approval-name { font-size:10px; color:#94a3b8; }
        .badge-green { background:#f0fdf4; color:#16a34a; padding:2px 9px; border-radius:20px; font-size:10px; font-weight:700; white-space:nowrap; }
        .badge-amber { background:#fffbeb; color:#d97706; padding:2px 9px; border-radius:20px; font-size:10px; font-weight:700; white-space:nowrap; }
        .badge-gray { background:#f8fafc; color:#94a3b8; padding:2px 9px; border-radius:20px; font-size:10px; font-weight:700; white-space:nowrap; }

        /* Solution right */
        .solution-title { font-size:38px; font-weight:900; line-height:1.1; color:#0f172a; margin:0 0 24px; letter-spacing:-.8px; }
        .feature-check-grid { display:grid; grid-template-columns:1fr 1fr; gap:12px; margin-bottom:32px; }
        .feature-check { display:flex; align-items:center; gap:8px; font-size:14px; font-weight:600; color:#334155; }
        .feature-check-icon { width:18px; height:18px; background:#dbeafe; border-radius:50%; display:flex; align-items:center; justify-content:center; flex-shrink:0; }

        /* ── How it works ── */
        .how-grid { display:grid; grid-template-columns:repeat(6,1fr); gap:16px; position:relative; }
        .how-connector { position:absolute; left:8.33%; right:8.33%; height:1px; background:linear-gradient(90deg,#e2e8f0,#93c5fd,#e2e8f0); top:26px; }
        .how-step { display:flex; flex-direction:column; align-items:center; text-align:center; position:relative; }
        .how-step-icon { width:52px; height:52px; background:linear-gradient(135deg,#eff6ff,#dbeafe); border:1.5px solid #bfdbfe; border-radius:14px; display:flex; align-items:center; justify-content:center; margin:0 auto 10px; position:relative; z-index:1; }
        .how-step-num { font-size:18px; font-weight:900; color:#1e40af; margin-bottom:4px; }
        .how-step-title { font-size:13px; font-weight:700; color:#0f172a; margin-bottom:4px; }
        .how-step-desc { font-size:11.5px; color:#64748b; line-height:1.5; }

        /* ── Stats band ── */
        .stats-band { background:linear-gradient(135deg,#f0fdf4 0%,#ecfdf5 100%); border-top:1px solid #bbf7d0; border-bottom:1px solid #bbf7d0; padding:56px 0; }
        .stats-grid { display:grid; grid-template-columns:repeat(4,1fr); gap:32px; max-width:1280px; margin:0 auto; padding:0 24px; }
        .stat-item { text-align:center; }
        .stat-number { font-size:42px; font-weight:900; color:#16a34a; line-height:1; margin-bottom:4px; }
        .stat-icon { font-size:22px; color:#22c55e; vertical-align:super; margin-left:4px; }
        .stat-label { font-size:14px; font-weight:600; color:#166534; }

        /* ── Everything you need ── */
        .feat-cols-grid { display:grid; grid-template-columns:repeat(4,1fr); gap:32px; }
        .feat-col-header { display:flex; align-items:center; gap:10px; margin-bottom:16px; }
        .feat-col-icon { width:36px; height:36px; border-radius:9px; display:flex; align-items:center; justify-content:center; flex-shrink:0; }
        .feat-col-name { font-size:14px; font-weight:700; color:#0f172a; }
        .feat-list { list-style:none; margin:0; padding:0; display:flex; flex-direction:column; gap:8px; }
        .feat-list li { display:flex; align-items:center; gap:8px; font-size:13.5px; color:#475569; line-height:1.4; }
        .feat-dot { width:5px; height:5px; border-radius:50%; flex-shrink:0; }

        /* ── Spotlight cards ── */
        .spotlight-grid { display:grid; grid-template-columns:repeat(3,1fr); gap:20px; }
        .spotlight-card { background:#fff; border:1px solid #e2e8f0; border-radius:18px; overflow:hidden; transition:all .2s; }
        .spotlight-card:hover { box-shadow:0 12px 48px rgba(15,23,42,.1); transform:translateY(-3px); }
        .spotlight-preview { padding:20px; background:#f8fafc; border-bottom:1px solid #f1f5f9; min-height:170px; display:flex; align-items:center; }
        .spotlight-label { padding:20px; }
        .spotlight-title { font-size:15px; font-weight:700; color:#0f172a; margin:0 0 4px; }
        .spotlight-desc { font-size:13px; color:#64748b; margin:0; line-height:1.5; }

        /* Workflow mini mockup */
        .mini-card { background:#fff; border:1px solid #e8edf2; border-radius:12px; padding:14px; box-shadow:0 2px 8px rgba(0,0,0,.05); width:100%; }
        .mini-label { font-size:11px; font-weight:700; color:#334155; margin-bottom:10px; }
        .mini-approval { display:flex; align-items:center; gap:8px; margin-bottom:8px; }
        .mini-avatar { width:24px; height:24px; border-radius:50%; display:flex; align-items:center; justify-content:center; font-size:9px; font-weight:700; flex-shrink:0; }
        .mini-info { flex:1; min-width:0; }
        .mini-role { font-size:10px; font-weight:600; color:#334155; white-space:nowrap; overflow:hidden; text-overflow:ellipsis; }
        .mini-name { font-size:9px; color:#94a3b8; }
        .mini-badge { font-size:10px; font-weight:600; padding:2px 8px; border-radius:10px; white-space:nowrap; }
        .mini-progress { display:flex; gap:4px; margin-top:10px; }
        .mini-prog-bar { flex:1; height:4px; border-radius:2px; }

        /* Budget mini mockup */
        .budget-dept { font-size:11px; font-weight:700; color:#334155; margin-bottom:6px; }
        .budget-row { display:flex; justify-content:space-between; align-items:flex-end; margin-bottom:10px; }
        .budget-total { font-size:16px; font-weight:900; color:#0f172a; }
        .budget-total-label { font-size:9px; color:#94a3b8; }
        .budget-spent { font-size:14px; font-weight:700; color:#2563eb; text-align:right; }
        .budget-spent-label { font-size:9px; color:#94a3b8; text-align:right; }
        .budget-bar-bg { width:100%; height:8px; background:#e2e8f0; border-radius:4px; }
        .budget-bar-fill { height:8px; background:linear-gradient(90deg,#2563eb,#60a5fa); border-radius:4px; }
        .budget-pct { font-size:9px; color:#94a3b8; text-align:right; margin-top:3px; }

        /* Analytics mini mockup */
        .analytics-total { font-size:22px; font-weight:900; color:#0f172a; }
        .analytics-chg { font-size:10px; color:#16a34a; margin-bottom:12px; }
        .bar-chart { display:flex; align-items:flex-end; gap:4px; height:44px; }
        .bar-item { flex:1; border-radius:2px 2px 0 0; min-width:0; }

        /* ── Testimonials ── */
        .testimonial-grid { display:grid; grid-template-columns:repeat(3,1fr); gap:20px; }
        .testimonial-card { background:#fff; border:1px solid #e2e8f0; border-radius:18px; padding:28px; border-top:3px solid transparent; }
        .testimonial-card.c-blue { border-top-color:#2563eb; }
        .testimonial-card.c-violet { border-top-color:#7c3aed; }
        .testimonial-card.c-emerald { border-top-color:#059669; }
        .stars { display:flex; gap:2px; margin-bottom:16px; }
        .star { color:#f59e0b; font-size:16px; }
        .testimonial-quote { font-size:14px; color:#334155; font-weight:500; line-height:1.7; margin:0 0 20px; }
        .testimonial-author { display:flex; align-items:center; gap:10px; }
        .author-avatar { width:36px; height:36px; border-radius:50%; display:flex; align-items:center; justify-content:center; font-size:12px; font-weight:700; color:#fff; flex-shrink:0; }
        .author-name { font-size:13px; font-weight:700; color:#0f172a; }
        .author-org { font-size:12px; color:#94a3b8; }


        /* ── FAQ ── */
        .faq-section { background:#fff; }
        .faq-header { display:flex; align-items:flex-start; justify-content:space-between; gap:24px; margin-bottom:48px; }
        .faq-view-all { font-size:14px; font-weight:600; color:#2563eb; text-decoration:none; display:flex; align-items:center; gap:4px; white-space:nowrap; padding-top:8px; }
        .faq-view-all:hover { color:#1d4ed8; }
        .faq-grid { display:grid; grid-template-columns:1fr 1fr; gap:0 48px; }
        .faq-row { border-bottom:1px solid #e2e8f0; padding:16px 0; }
        .faq-btn { width:100%; display:flex; align-items:center; justify-content:space-between; gap:12px; text-align:left; background:none; border:none; cursor:pointer; padding:0; }
        .faq-q { font-size:14px; font-weight:600; color:#0f172a; margin:0; }
        .faq-icon { width:20px; height:20px; flex-shrink:0; color:#94a3b8; transition:transform .2s; }
        .faq-a { font-size:13.5px; color:#64748b; line-height:1.7; padding-top:10px; margin:0; }

        /* ── CTA band ── */
        .cta-section { background:linear-gradient(135deg,#1e40af 0%,#1e3a8a 50%,#312e81 100%); padding:80px 0; text-align:center; }
        .cta-title { font-size:40px; font-weight:900; color:#fff; margin:0 0 12px; letter-spacing:-.8px; }
        .cta-sub { font-size:16px; color:#93c5fd; margin:0 0 40px; line-height:1.6; }
        .cta-btns { display:flex; justify-content:center; gap:16px; flex-wrap:wrap; }
        .cta-btn-white { display:inline-flex; align-items:center; padding:14px 32px; background:#fff; color:#1d4ed8; font-size:14px; font-weight:700; border-radius:12px; text-decoration:none; transition:all .15s; box-shadow:0 4px 14px rgba(0,0,0,.2); }
        .cta-btn-white:hover { background:#eff6ff; transform:translateY(-1px); }
        .cta-btn-ghost { display:inline-flex; align-items:center; padding:13px 32px; border:2px solid rgba(255,255,255,.3); color:#fff; font-size:14px; font-weight:700; border-radius:12px; text-decoration:none; transition:all .15s; }
        .cta-btn-ghost:hover { background:rgba(255,255,255,.1); border-color:rgba(255,255,255,.5); }

        /* ── Footer ── */
        .footer-section { background:#0c1a33; padding:56px 0 32px; }
        .footer-grid { display:grid; grid-template-columns:2fr 1fr 1fr 1fr 1fr; gap:40px; margin-bottom:48px; }
        .footer-brand-desc { font-size:13.5px; color:#cbd5e1; line-height:1.7; margin:12px 0 20px; }
        .footer-socials { display:flex; gap:8px; }
        .footer-social { width:32px; height:32px; background:#1e3a5f; border-radius:8px; display:flex; align-items:center; justify-content:center; text-decoration:none; color:#cbd5e1; font-size:11px; font-weight:700; transition:all .15s; }
        .footer-social:hover { background:#2563eb; color:#fff; }
        .footer-col-title { font-size:13px; font-weight:700; color:#ffffff; margin:0 0 16px; letter-spacing:.3px; }
        .footer-col-links { list-style:none; margin:0; padding:0; display:flex; flex-direction:column; gap:10px; }
        .footer-col-links a { font-size:13px; color:#cbd5e1; text-decoration:none; transition:color .15s; display:block; }
        .footer-col-links a:hover { color:#ffffff; }
        .footer-bottom { border-top:1px solid #1e3a5f; padding-top:24px; display:flex; align-items:center; justify-content:space-between; gap:16px; flex-wrap:wrap; }
        .footer-copy { font-size:13px; color:#94a3b8; }
        .footer-legal { display:flex; gap:24px; }
        .footer-legal a { font-size:13px; color:#94a3b8; text-decoration:none; transition:color .15s; }
        .footer-legal a:hover { color:#cbd5e1; }

        /* ── Problem grid (4-up) ── */
        .problem-grid-4 { grid-template-columns:repeat(4,1fr); }

        /* ── Workflow compare diagram ── */
        .workflow-compare-grid { display:grid; grid-template-columns:1fr 1fr; gap:24px; align-items:stretch; }
        .workflow-panel { border-radius:18px; border:1px solid; padding:28px 24px 24px; display:flex; flex-direction:column; }
        .workflow-panel-bad { background:#fef2f2; border-color:#fecaca; }
        .workflow-panel-good { background:#f0fdf4; border-color:#bbf7d0; }
        .workflow-panel-header { display:block; width:fit-content; margin:0 auto 24px; font-size:12px; font-weight:700; padding:6px 16px; border-radius:20px; }
        .workflow-header-bad { background:#fee2e2; color:#dc2626; }
        .workflow-header-good { background:#dcfce7; color:#16a34a; }
        .workflow-row { display:flex; align-items:flex-start; justify-content:center; gap:6px; flex-wrap:wrap; }
        .workflow-row-single { flex-wrap:wrap; }
        .workflow-node { display:flex; flex-direction:column; align-items:center; gap:6px; width:76px; flex-shrink:0; }
        .workflow-node-icon { width:40px; height:40px; border-radius:50%; background:#fff; border:1.5px solid; display:flex; align-items:center; justify-content:center; flex-shrink:0; }
        .workflow-node-bad { border-color:#fca5a5; color:#dc2626; }
        .workflow-node-good { border-color:#86efac; color:#16a34a; }
        .workflow-node-label { font-size:10.5px; font-weight:600; color:#334155; text-align:center; line-height:1.3; }
        .workflow-chevron { color:#cbd5e1; font-size:16px; font-weight:700; margin-top:12px; flex-shrink:0; }
        .workflow-converge { display:flex; flex-direction:column; align-items:center; gap:4px; margin-top:14px; }
        .workflow-arrow-down { color:#dc2626; font-size:16px; font-weight:700; }
        .workflow-footer-note { text-align:center; font-size:12.5px; font-weight:600; margin:auto 0 0; padding-top:16px; margin-top:20px; border-top:1px dashed; }
        .workflow-footer-bad { color:#dc2626; border-color:#fecaca; }
        .workflow-footer-good { color:#16a34a; border-color:#bbf7d0; }

        /* ── Module grid ── */
        .module-grid { display:grid; grid-template-columns:repeat(3,1fr); gap:20px; }
        .capability-card { background:#fff; border:1px solid #e2e8f0; border-radius:16px; padding:22px; }
        .capability-icon { width:40px; height:40px; border-radius:10px; display:flex; align-items:center; justify-content:center; margin-bottom:14px; }
        .capability-title { font-size:15px; font-weight:700; color:#0f172a; margin:0 0 6px; }
        .capability-desc { font-size:13px; color:#64748b; line-height:1.6; margin:0; }
        .module-tags { display:flex; flex-wrap:wrap; gap:6px; margin-top:14px; }
        .module-tag { font-size:11px; font-weight:600; padding:4px 10px; border-radius:20px; background:#f1f5f9; color:#475569; }
        .module-note { text-align:center; font-size:14px; color:#64748b; margin:32px 0 0; }
        .module-note strong { color:#0f172a; }

        /* ── Management overview panel ── */
        .mgmt-card { background:#fff; border-radius:20px; border:1px solid #e2e8f0; padding:20px; box-shadow:0 24px 80px rgba(15,23,42,.1), 0 4px 16px rgba(15,23,42,.06); }
        .mgmt-card-header { display:flex; align-items:center; justify-content:space-between; margin-bottom:16px; }
        .mgmt-card-title { font-size:14px; font-weight:700; color:#0f172a; }
        .mgmt-card-period { font-size:12px; color:#94a3b8; }
        .mgmt-grid { display:grid; grid-template-columns:repeat(3,1fr); gap:10px; }
        .mgmt-stat { background:#f8fafc; border:1px solid #f1f5f9; border-radius:10px; padding:12px; }

        /* Responsive */
        @media (max-width:1024px) {
            .hero-grid, .solution-grid { grid-template-columns:1fr; }
            .how-grid { grid-template-columns:repeat(3,1fr); }
            .how-connector { display:none; }
            .feat-cols-grid { grid-template-columns:repeat(2,1fr); }
            .footer-grid { grid-template-columns:1fr 1fr; }
            .problem-grid-4 { grid-template-columns:repeat(2,1fr); }
            .workflow-compare-grid { grid-template-columns:1fr; }
            .module-grid { grid-template-columns:repeat(2,1fr); }
            .mgmt-grid { grid-template-columns:repeat(3,1fr); }
        }
        @media (max-width:768px) {
            .hero-h1 { font-size:34px; letter-spacing:-0.8px; }
            .hero-sub { font-size:15px; }
            .section { padding:56px 0; }
            .section-inner { padding:0 16px; }
            .hero-section { padding:84px 0 56px; }
            .hero-grid { grid-template-columns:1fr; gap:32px; }
            .problem-grid { grid-template-columns:1fr; gap:28px; }
            .solution-grid { grid-template-columns:1fr; gap:32px; }
            .testimonial-grid, .spotlight-grid { grid-template-columns:1fr; }
            .feature-check-grid { grid-template-columns:1fr; }
            .faq-grid { grid-template-columns:1fr; }
            .stats-grid { grid-template-columns:1fr 1fr; gap:20px; }
            .stat-number { font-size:34px; }
            .feat-cols-grid { grid-template-columns:1fr; }
            .how-grid { grid-template-columns:repeat(2,1fr); gap:20px; }
            .footer-grid { grid-template-columns:1fr; gap:28px; }
            .module-grid { grid-template-columns:1fr; }
            .mgmt-grid { grid-template-columns:repeat(2,1fr); }
            .workflow-node { width:64px; }
            .workflow-chevron { display:none; }
            .nav-links { display:none; }
            .hamburger { display:flex !important; }
            .btn-login { display:none; }
            .btn-cta { padding:8px 14px; font-size:13px; }
            /* Dashboard card on mobile */
            .dash-stats { grid-template-columns:repeat(2,1fr); }
            .dash-sidebar { width:100px; }
            .dash-stat-val { font-size:11px; }
            .dash-chart { padding:8px; }
            /* Mobile menu: visibility stays controlled by Alpine's x-show="open" */
        }
        /* Hamburger hidden by default */
        .hamburger { display:none; background:none; border:none; cursor:pointer; padding:8px; border-radius:8px; align-items:center; justify-content:center; transition:background .15s; }
        .hamburger:hover { background:#f1f5f9; }
        /* Mobile dropdown */
        .mobile-menu { position:fixed; top:64px; left:0; right:0; background:#fff; border-bottom:2px solid #e2e8f0; z-index:49; padding:12px 16px 20px; box-shadow:0 8px 24px rgba(0,0,0,.08); }
        .mobile-menu a { display:block; padding:13px 12px; font-size:15px; font-weight:600; color:#334155; text-decoration:none; border-radius:10px; transition:background .15s; }
        .mobile-menu a:hover { background:#f1f5f9; color:#0f172a; }
        .mobile-menu-divider { height:1px; background:#f1f5f9; margin:8px 0; }
        .mobile-menu-cta { display:block; text-align:center; padding:13px; background:#2563eb; color:#fff !important; border-radius:12px; font-size:15px; font-weight:700; text-decoration:none; margin-top:10px; }
    </style>
</head>
<body>

{{-- ── Navigation ── --}}
<div x-data="{ open: false }">
<nav class="nav-wrap">
    <div class="nav-inner">
        <div class="nav-logo">
            <div class="logo-box">
                <svg width="16" height="16" fill="none" stroke="#fff" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"/></svg>
            </div>
            <span class="logo-text">FlowCheck</span>
        </div>
        <div class="nav-links">
            @foreach([['Product',true],['Solutions',true],['Resources',true],['About Us',false]] as [$l,$a])
            <a href="#" class="nav-link">
                {{ $l }}
                @if($a)<svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="color:#94a3b8"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>@endif
            </a>
            @endforeach
        </div>
        <div class="nav-actions">
            <a href="{{ route('login') }}" class="btn-login">Log in</a>
            <a href="{{ route('login') }}" class="btn-cta">Start Free Trial</a>
            {{-- Hamburger (mobile only) --}}
            <button class="hamburger" @click="open = !open" aria-label="Toggle menu">
                <svg x-show="!open" width="22" height="22" fill="none" stroke="#334155" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/></svg>
                <svg x-show="open" width="22" height="22" fill="none" stroke="#334155" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
        </div>
    </div>
</nav>
{{-- Mobile dropdown menu --}}
<div class="mobile-menu" x-show="open" @click.outside="open = false" x-transition style="display:none">
    @foreach(['Features','How It Works','Impact','About Us'] as $item)
    <a href="#{{ strtolower(str_replace(' ','-',$item)) }}">{{ $item }}</a>
    @endforeach
    <div class="mobile-menu-divider"></div>
    <a href="{{ route('login') }}" style="padding:13px 12px;font-size:15px;font-weight:600;color:#334155;display:block;text-decoration:none;border-radius:10px">Log in</a>
    <a href="{{ route('login') }}" class="mobile-menu-cta">Start Free Trial</a>
</div>
</div>

{{-- ── Hero ── --}}
<section class="hero-section">
    <div class="section-inner">
        <div class="hero-grid">
            <div>
                <h1 class="hero-h1">Operations,<br><span style="color:#2563eb">under control.</span></h1>
                <p class="hero-sub">One workflow platform for requests, approvals, procurement, logistics, expediting and operations — built for supply chain, freight, transport and mining-scale organisations.</p>
                <div class="hero-btns">
                    <a href="{{ route('login') }}" class="btn-primary-lg">Start Free Trial</a>
                    <a href="#how-it-works" class="btn-outline-lg">See How It Works</a>
                </div>
                <div class="trust-checks">
                    @foreach(['No credit card required','Easy setup','Cancel anytime'] as $t)
                    <span class="trust-check">
                        <svg class="check-icon" width="16" height="16" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/></svg>
                        {{ $t }}
                    </span>
                    @endforeach
                </div>
            </div>

            <div style="overflow-x:auto;-webkit-overflow-scrolling:touch;">
                <div class="dash-card" style="min-width:340px">
                    <div class="dash-topbar">
                        <div class="dash-logo">
                            <div class="dash-logo-box">
                                <svg width="12" height="12" fill="none" stroke="#fff" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 12l2 2 4-4"/></svg>
                            </div>
                            <span style="font-size:12px;font-weight:700;color:#0f172a">FlowCheck</span>
                        </div>
                        <div class="dash-topbar-icons">
                            <div class="dash-icon"><svg width="14" height="14" fill="none" stroke="#94a3b8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/></svg></div>
                            <div class="dash-icon"><svg width="14" height="14" fill="none" stroke="#94a3b8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg></div>
                        </div>
                    </div>
                    <div class="dash-body">
                        <div class="dash-sidebar">
                            <div class="dash-sidebar-active">
                                <svg width="12" height="12" fill="none" stroke="#fff" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                                <span style="font-size:11px;font-weight:600;color:#fff">Dashboard</span>
                            </div>
                            @foreach([
                                ['Requests','M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2'],
                                ['Approvals','M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z'],
                                ['Procurement','M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z'],
                                ['Logistics','M3 16V8a1 1 0 011-1h9v9H4a1 1 0 01-1-1zm10-6h3.5l3.5 3.5V16h-7v-6zM7 19a2 2 0 100-4 2 2 0 000 4zm10 0a2 2 0 100-4 2 2 0 000 4z'],
                                ['Expediting','M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z'],
                                ['Operations','M13 10V3L4 14h7v7l9-11h-7z'],
                                ['Reports','M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z'],
                                ['Admin','M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z M15 12a3 3 0 11-6 0 3 3 0 016 0z'],
                            ] as [$name,$path])
                            <div class="dash-sidebar-item">
                                <svg width="12" height="12" fill="none" stroke="#94a3b8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="{{ $path }}"/></svg>
                                <span style="font-size:11px;color:#64748b">{{ $name }}</span>
                            </div>
                            @endforeach
                        </div>
                        <div class="dash-main">
                            <div class="dash-main-title">Dashboard</div>
                            <div class="dash-stats">
                                @foreach([['Open Requests','18','+5 new today',true],['Pending Approvals','9','+2 require action',false],['Active Shipments','24','↑ 6 in transit',true],['Total Spend','$312,480','↑ This month',true]] as [$l,$v,$c,$pos])
                                <div class="dash-stat">
                                    <div class="dash-stat-label">{{ $l }}</div>
                                    <div class="dash-stat-val">{{ $v }}</div>
                                    <div class="dash-stat-chg {{ $pos?'chg-green':'chg-red' }}">{{ $c }}</div>
                                </div>
                                @endforeach
                            </div>
                            <div class="dash-charts">
                                <div class="dash-chart">
                                    <div class="dash-chart-title">Workflow Status</div>
                                    <div class="donut-wrap">
                                        <div class="donut" style="background:conic-gradient(#2563eb 0deg 221deg,#f59e0b 221deg 332deg,#ef4444 332deg 360deg)"></div>
                                        <div class="donut-legend">
                                            <div class="donut-row"><span class="donut-dot" style="background:#2563eb"></span>Completed 24</div>
                                            <div class="donut-row"><span class="donut-dot" style="background:#f59e0b"></span>In Progress 12</div>
                                            <div class="donut-row"><span class="donut-dot" style="background:#ef4444"></span>Delayed 3</div>
                                        </div>
                                    </div>
                                </div>
                                <div class="dash-chart">
                                    <div class="dash-chart-title">Spend Overview</div>
                                    <svg viewBox="0 0 110 52" style="width:100%;height:48px">
                                        <defs><linearGradient id="sg" x1="0" y1="0" x2="0" y2="1"><stop offset="0%" stop-color="#2563eb" stop-opacity=".2"/><stop offset="100%" stop-color="#2563eb" stop-opacity="0"/></linearGradient></defs>
                                        <path d="M0 48 L18 38 L36 42 L55 28 L73 18 L91 9 L110 4" fill="none" stroke="#2563eb" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                        <path d="M0 48 L18 38 L36 42 L55 28 L73 18 L91 9 L110 4 L110 52 L0 52Z" fill="url(#sg)"/>
                                        <text x="0" y="52" font-size="6" fill="#94a3b8">Jan</text><text x="20" y="52" font-size="6" fill="#94a3b8">Feb</text><text x="40" y="52" font-size="6" fill="#94a3b8">Mar</text><text x="60" y="52" font-size="6" fill="#94a3b8">Apr</text><text x="80" y="52" font-size="6" fill="#94a3b8">May</text><text x="99" y="52" font-size="6" fill="#94a3b8">Jun</text>
                                    </svg>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- ── Problem ── --}}
<section class="section" id="features">
    <div class="section-inner">
        <h2 class="section-title" style="text-align:center;margin-bottom:48px">Your operation runs across four different<br>tools — and none of them talk to each other.</h2>
        <div class="problem-grid problem-grid-4">
            @foreach([
                ['Requests & Approvals','Requests come through email, WhatsApp, paper or conversations, with no clear record of who needs to act.','M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z','#eff6ff','#2563eb'],
                ['Procurement','Quotes, vendor information and purchase orders are scattered across spreadsheets, email and paper files.','M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z','#f5f3ff','#7c3aed'],
                ['Logistics','Shipments, transport and deliveries are tracked by phone calls and radio, with no visibility until something goes wrong.','M3 16V8a1 1 0 011-1h9v9H4a1 1 0 01-1-1zm10-6h3.5l3.5 3.5V16h-7v-6zM7 19a2 2 0 100-4 2 2 0 000 4zm10 0a2 2 0 100-4 2 2 0 000 4z','#fff7ed','#ea580c'],
                ['Expediting & Operations','Delayed orders, fuel, assets and maintenance are managed separately, so nothing gets flagged until it becomes urgent.','M9 14l6-6m-5.5.5h.01m4.99 5h.01M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16l3.5-2 3.5 2 3.5-2 3.5 2z','#fefce8','#ca8a04'],
            ] as [$title,$desc,$icon,$bg,$color])
            <div class="problem-item">
                <div class="problem-icon" style="background:{{ $bg }}">
                    <svg width="24" height="24" fill="none" stroke="{{ $color }}" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $icon }}"/></svg>
                </div>
                <h3 class="problem-title">{{ $title }}</h3>
                <p class="problem-desc">{{ $desc }}</p>
            </div>
            @endforeach
        </div>
    </div>
</section>

{{-- ── Current Process vs FlowCheck ── --}}
<section class="section" style="background:#f8fafc">
    <div class="section-inner">
        <h2 class="section-title" style="text-align:center;margin-bottom:48px">From scattered operations to<br>one controlled workflow.</h2>
        <div class="workflow-compare-grid">
            <div class="workflow-panel workflow-panel-bad">
                <span class="workflow-panel-header workflow-header-bad">Current Process</span>
                <div class="workflow-row">
                    @foreach([
                        ['WhatsApp','M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z'],
                        ['Spreadsheet','M4 4h16v16H4V4zm0 5.333h16M4 14.667h16M9.333 4v16M14.667 4v16'],
                        ['Email','M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z'],
                        ['Manager Approval','M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z'],
                    ] as [$label,$icon])
                    <div class="workflow-node">
                        <div class="workflow-node-icon workflow-node-bad"><svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="{{ $icon }}"/></svg></div>
                        <span class="workflow-node-label">{{ $label }}</span>
                    </div>
                    @if(!$loop->last)<span class="workflow-chevron">›</span>@endif
                    @endforeach
                </div>
                <div class="workflow-row" style="margin-top:24px">
                    @foreach([
                        ['Supplier Quotation','M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z'],
                        ['Purchase Order','M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z'],
                        ['Delivery','M3 16V8a1 1 0 011-1h9v9H4a1 1 0 01-1-1zm10-6h3.5l3.5 3.5V16h-7v-6zM7 19a2 2 0 100-4 2 2 0 000 4zm10 0a2 2 0 100-4 2 2 0 000 4z'],
                        ['Invoice','M9 14l6-6m-5.5.5h.01m4.99 5h.01M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16l3.5-2 3.5 2 3.5-2 3.5 2z'],
                    ] as [$label,$icon])
                    <div class="workflow-node">
                        <div class="workflow-node-icon workflow-node-bad"><svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="{{ $icon }}"/></svg></div>
                        <span class="workflow-node-label">{{ $label }}</span>
                    </div>
                    @if(!$loop->last)<span class="workflow-chevron">›</span>@endif
                    @endforeach
                </div>
                <div class="workflow-converge">
                    <span class="workflow-arrow-down">↓</span>
                    <div class="workflow-node">
                        <div class="workflow-node-icon workflow-node-bad"><svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M4 21h16M5 10h1M9 10h1M14 10h1M18 10h1M4 10l8-6 8 6M6 10v8M10 10v8M14 10v8M18 10v8"/></svg></div>
                        <span class="workflow-node-label">Head Office</span>
                    </div>
                </div>
                <p class="workflow-footer-note workflow-footer-bad">Hard to track. Easy to lose. No clear visibility.</p>
            </div>

            <div class="workflow-panel workflow-panel-good">
                <span class="workflow-panel-header workflow-header-good">With FlowCheck</span>
                <div class="workflow-row workflow-row-single">
                    @foreach([
                        ['Request','M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2'],
                        ['Approval','M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z'],
                        ['Procurement','M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z'],
                        ['Purchase Order','M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z'],
                        ['Logistics','M3 16V8a1 1 0 011-1h9v9H4a1 1 0 01-1-1zm10-6h3.5l3.5 3.5V16h-7v-6zM7 19a2 2 0 100-4 2 2 0 000 4zm10 0a2 2 0 100-4 2 2 0 000 4z'],
                        ['Delivery','M9 14l6-6m-5.5.5h.01m4.99 5h.01M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16l3.5-2 3.5 2 3.5-2 3.5 2z'],
                        ['Reporting','M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z'],
                    ] as [$label,$icon])
                    <div class="workflow-node">
                        <div class="workflow-node-icon workflow-node-good"><svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="{{ $icon }}"/></svg></div>
                        <span class="workflow-node-label">{{ $label }}</span>
                    </div>
                    @if(!$loop->last)<span class="workflow-chevron">›</span>@endif
                    @endforeach
                </div>
                <p class="workflow-footer-note workflow-footer-good">
                    <svg width="14" height="14" fill="none" stroke="#16a34a" viewBox="0 0 24 24" style="vertical-align:-2px;margin-right:4px"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                    Every purchase has a clear status, owner and history from request to payment.
                </p>
            </div>
        </div>
    </div>
</section>

{{-- ── How It Works ── --}}
<section class="section" style="background:#fff" id="how-it-works">
    <div class="section-inner">
        <h2 class="section-title" style="text-align:center;margin-bottom:48px">One workflow from request to delivery.</h2>
        <div class="how-grid">
            <div class="how-connector"></div>
            @foreach([
                ['1','Request','Employee or site submits a request.','M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2'],
                ['2','Approval','The request automatically moves through the required approval levels.','M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z'],
                ['3','Procurement','Procurement sources, quotes and selects a vendor.','M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z'],
                ['4','Purchase Order','An approved request becomes a purchase order.','M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z'],
                ['5','Logistics & Delivery','Shipments and transport are tracked through to proof of delivery.','M3 16V8a1 1 0 011-1h9v9H4a1 1 0 01-1-1zm10-6h3.5l3.5 3.5V16h-7v-6zM7 19a2 2 0 100-4 2 2 0 000 4zm10 0a2 2 0 100-4 2 2 0 000 4z'],
                ['6','Reporting','Management sees spending, activity, delays and outstanding actions.','M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z'],
            ] as [$num,$title,$desc,$icon])
            <div class="how-step">
                <div class="how-step-icon">
                    <svg width="22" height="22" fill="none" stroke="#2563eb" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="{{ $icon }}"/></svg>
                </div>
                <div class="how-step-num">{{ $num }}</div>
                <div class="how-step-title">{{ $title }}</div>
                <p class="how-step-desc">{{ $desc }}</p>
            </div>
            @endforeach
        </div>
    </div>
</section>

{{-- ── Stats Band ── --}}
<div class="stats-band" id="impact">
    <div class="stats-grid">
        @foreach([['80%','Faster approval cycles','↑'],['100%','Approval visibility','✓'],['25%','Reduction in off-process spending','↓'],['<1 Day','Average setup time','⚡']] as [$s,$l,$i])
        <div class="stat-item">
            <div class="stat-number">{{ $s }}<span class="stat-icon">{{ $i }}</span></div>
            <div class="stat-label">{{ $l }}</div>
        </div>
        @endforeach
    </div>
</div>

{{-- ── Platform Modules ── --}}
<section class="section" style="background:#fff">
    <div class="section-inner">
        <h2 class="section-title" style="text-align:center;margin-bottom:48px">One platform, built around<br>how your operation actually runs.</h2>
        <div class="module-grid">
            @foreach([
                ['Workflows','Every request, approval, task and exception in one auditable trail — no more chasing status across email and chat.',['Requests','Approvals','Tasks','Exceptions'],'M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2','#dbeafe','#1d4ed8'],
                ['Procurement','From purchase request to RFQ, vendor selection, purchase order and invoice — fully tracked end to end.',['Purchase Requests','RFQs','Vendors','Purchase Orders','Invoices'],'M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z','#ede9fe','#7c3aed'],
                ['Logistics','Track shipments, deliveries and transport in real time, with proof of delivery captured at the point of handover.',['Shipments','Deliveries','Transport','Proof of Delivery'],'M3 16V8a1 1 0 011-1h9v9H4a1 1 0 01-1-1zm10-6h3.5l3.5 3.5V16h-7v-6zM7 19a2 2 0 100-4 2 2 0 000 4zm10 0a2 2 0 100-4 2 2 0 000 4z','#dcfce7','#16a34a'],
                ['Expediting','Surface open and delayed orders automatically, so nothing slips through without a follow-up or escalation.',['Open Orders','Supplier Follow-ups','Delayed Orders','Escalations'],'M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z','#fff7ed','#ea580c'],
                ['Operations','Manage fuel, assets, maintenance and operational spend alongside the workflows that depend on them.',['Fuel','Assets','Maintenance','Operational Expenses'],'M13 10V3L4 14h7v7l9-11h-7z','#fef3c7','#d97706'],
                ['Reporting','Real-time visibility into spend, supplier and delivery performance, and a complete audit trail for every action.',['Spend','Supplier Performance','Delivery Performance','Workflow Performance','Audit Trail'],'M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z','#fefce8','#ca8a04'],
            ] as [$title,$desc,$tags,$icon,$bg,$color])
            <div class="capability-card">
                <div class="capability-icon" style="background:{{ $bg }}">
                    <svg width="20" height="20" fill="none" stroke="{{ $color }}" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="{{ $icon }}"/></svg>
                </div>
                <h3 class="capability-title">{{ $title }}</h3>
                <p class="capability-desc">{{ $desc }}</p>
                <div class="module-tags">
                    @foreach($tags as $tag)
                    <span class="module-tag">{{ $tag }}</span>
                    @endforeach
                </div>
            </div>
            @endforeach
        </div>
        <p class="module-note">Plus <strong>Administration</strong> — Users, Roles, Departments, Approval Rules and Integrations — to configure it all your way.</p>
    </div>
</section>

{{-- ── What Happens When Someone Needs To Buy Something ── --}}
<section class="section solution-section">
    <div class="section-inner">
        <div class="solution-grid">
            <div>
                <div class="pr-card">
                    <div class="pr-breadcrumb"><span class="pr-back">← Back to requests</span></div>
                    <div class="pr-body">
                        <div class="pr-header">
                            <div>
                                <p class="pr-title">Purchase Request #PR-2024-0156</p>
                                <div class="pr-meta">
                                    <div class="pr-avatar">JC</div>
                                    <span class="pr-meta-text">Jane Cooper</span>
                                    <span style="color:#cbd5e1;font-size:12px">·</span>
                                    <span class="pr-meta-text">Marketing Department</span>
                                </div>
                            </div>
                            <span class="pr-badge-orange">⚡ Pending Approval</span>
                        </div>
                        <div class="pr-amounts">
                            <div><div class="pr-amount-label">Request</div><div class="pr-amount-val" style="font-size:13px">50 promotional banners</div></div>
                            <div><div class="pr-amount-label">Estimated Cost</div><div class="pr-amount-val">$2,450.00</div></div>
                        </div>
                        <div class="pr-tabs">
                            <button class="pr-tab active">Details</button>
                            <button class="pr-tab">Items (3)</button>
                            <button class="pr-tab">Approvals</button>
                            <button class="pr-tab">History</button>
                        </div>
                        <p class="approval-section-label">Approval Workflow</p>
                        @foreach([['1','Submitted by Employee','May 15, 9:10 AM','green'],['2','Manager Review','May 15, 10:20 AM','green'],['3','Procurement Requesting Quotes','May 16, 8:15 AM','amber'],['4','Supplier Selected','May 17, 2:30 PM','gray'],['5','Purchase Order Created','May 17, 3:45 PM','gray'],['6','Goods Received','May 24, 11:30 AM','gray'],['7','Invoice Matched','May 25, 9:00 AM','gray']] as [$n,$role,$name,$s])
                        <div class="approval-row">
                            <div class="approval-num">{{ $n }}</div>
                            <div class="approval-info"><div class="approval-role">{{ $role }}</div><div class="approval-name">{{ $name }}</div></div>
                            @if($s==='green')<span class="badge-green">✓</span>
                            @elseif($s==='amber')<span class="badge-amber">Pending</span>
                            @else<span class="badge-gray">Waiting</span>@endif
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
            <div>
                <h2 class="solution-title">See a workflow<br>in action.</h2>
                <p class="section-sub" style="margin-bottom:28px;max-width:440px">Whether it's a purchase request, a shipment or a maintenance job, every request gets the same clear, trackable journey.</p>
                <div class="feature-check-grid">
                    @foreach(['Clear status at every step','No chasing or follow-ups','Complete audit trail','No duplicated data entry','Works across procurement, logistics and operations','Faster from request to completion'] as $feat)
                    <div class="feature-check">
                        <div class="feature-check-icon">
                            <svg width="10" height="10" fill="#2563eb" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/></svg>
                        </div>
                        {{ $feat }}
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</section>

{{-- ── Know What Is Happening With Your Money ── --}}
<section class="section" style="background:#f8fafc">
    <div class="section-inner">
        <div class="solution-grid" style="align-items:center">
            <div>
                <h2 class="solution-title" style="font-size:34px">Know what is happening<br>across your operation.</h2>
                <p class="section-sub" style="margin-bottom:28px;max-width:440px">Management gets real-time visibility into requests, procurement, logistics and operational spend — without asking for another spreadsheet.</p>
                <a href="#how-it-works" class="btn-outline-lg">See How It Works</a>
            </div>
            <div>
                <div class="mgmt-card">
                    <div class="mgmt-card-header">
                        <span class="mgmt-card-title">Management Overview</span>
                        <span class="mgmt-card-period">This Month ⌄</span>
                    </div>
                    <div class="mgmt-grid">
                        @foreach([['Pending Requests','12','+4 new today',true],['Awaiting Approval','8','+3 require action',false],['Active Shipments','24','↑ 6 in transit',true],['Total Spend','$312,480','This month',null],['On-Time Deliveries','94%','↑ 3pts',true]] as [$l,$v,$c,$pos])
                        <div class="mgmt-stat">
                            <div class="dash-stat-label">{{ $l }}</div>
                            <div class="dash-stat-val">{{ $v }}</div>
                            @if(!is_null($pos))
                            <div class="dash-stat-chg {{ $pos?'chg-green':'chg-red' }}">{{ $c }}</div>
                            @else
                            <div class="dash-stat-chg" style="color:#94a3b8">{{ $c }}</div>
                            @endif
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- ── FAQ ── --}}
<section class="section faq-section">
    <div class="section-inner" style="max-width:900px">
        <div class="faq-header">
            <h2 class="section-title">Frequently asked<br>questions</h2>
            <a href="#" class="faq-view-all">View all FAQs <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg></a>
        </div>
        <div class="faq-grid">
            @foreach([
                ['How does FlowCheck handle approvals?','Requests are automatically routed through your organisation\'s approval chain — by department, budget threshold or role — so the right person is notified at the right time.'],
                ['Can FlowCheck manage logistics and shipments as well as procurement?','Yes. Shipments, deliveries, transport and proof of delivery are tracked in the same workflow as procurement, so nothing lives in a separate system.'],
                ['How does expediting work?','Open and delayed orders are surfaced automatically, with supplier follow-ups and escalations built into the workflow so nothing is missed.'],
                ['Can we track fuel, assets and maintenance?','Yes. Operational costs like fuel, assets and maintenance are logged and reported alongside your procurement and logistics spend.'],
                ['Can I create different approval workflows for different departments or sites?','Yes. Each department, site or cost centre can have its own multi-level approval chain, configured to match how your organisation actually works.'],
                ['Can procurement manage supplier quotations and RFQs?','Procurement can issue RFQs, collect and compare supplier quotations, and convert the winning quote into a purchase order — all in one place.'],
                ['Can finance match invoices against purchase orders and deliveries?','Yes. FlowCheck matches invoices against purchase orders and goods received, flagging any mismatches automatically.'],
                ['Can management see spend and performance across the whole operation?','Management gets a real-time overview of requests, procurement, logistics, supplier and delivery performance — without waiting on a report.'],
                ['Can FlowCheck work with our existing processes?','FlowCheck is configurable to your existing approval structure, workflows and integrations, so you don\'t need to change how your teams already work to get started.'],
            ] as $faq)
            <div class="faq-row" x-data="{ open: false }">
                <button class="faq-btn" @click="open = !open">
                    <span class="faq-q">{{ $faq[0] }}</span>
                    <svg class="faq-icon" :style="open ? 'transform:rotate(45deg)' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                </button>
                <div x-show="open" x-collapse>
                    <p class="faq-a">{{ $faq[1] }}</p>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

{{-- ── CTA Band ── --}}
<section class="cta-section">
    <div class="section-inner">
        <h2 class="cta-title">Bring procurement, logistics and<br>operations into one workflow.</h2>
        <p class="cta-sub">Stop chasing requests, shipments, approvals and invoices across different systems and tools.</p>
        <div class="cta-btns">
            <a href="{{ route('login') }}" class="cta-btn-white">Start Free Trial</a>
            <a href="#" class="cta-btn-ghost">Book a Demo</a>
        </div>
    </div>
</section>

{{-- ── Footer ── --}}
<footer class="footer-section">
    <div class="section-inner">
        <div class="footer-grid">
            <div>
                <div style="display:flex;align-items:center;gap:10px">
                    <div class="logo-box"><svg width="16" height="16" fill="none" stroke="#fff" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"/></svg></div>
                    <span style="font-size:17px;font-weight:800;color:#f1f5f9;letter-spacing:-.3px">FlowCheck</span>
                </div>
                <p class="footer-brand-desc">The workflow and operations platform for procurement, logistics and supply chain teams.</p>
                <div class="footer-socials">
                    <a href="#" class="footer-social">in</a>
                    <a href="#" class="footer-social">tw</a>
                    <a href="#" class="footer-social">yt</a>
                </div>
            </div>
            @foreach([
                ['Product',['Features','Pricing','Integrations','Changelog']],
                ['Solutions',['Shipping & Freight','Mining & Resources','Supply Chain','Transport & Fleet']],
                ['Resources',['Blog','Templates','Guides','Help Center']],
                ['Company',['About Us','Careers','Contact','Privacy Policy']],
            ] as [$col,$links])
            <div>
                <h4 class="footer-col-title">{{ $col }}</h4>
                <ul class="footer-col-links">
                    @foreach($links as $link)
                    <li><a href="#">{{ $link }}</a></li>
                    @endforeach
                </ul>
            </div>
            @endforeach
        </div>
        <div class="footer-bottom">
            <span class="footer-copy">© {{ date('Y') }} FlowCheck. All rights reserved.</span>
            <div class="footer-legal">
                <a href="#">Privacy Policy</a>
                <a href="#">Terms of Service</a>
            </div>
        </div>
    </div>
</footer>

</body>
</html>

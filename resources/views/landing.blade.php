<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FlowCheck — Procurement Management for SMEs & Institutions</title>
    <meta name="description" content="Replace spreadsheets, WhatsApp approvals, and email chains with a structured procurement workflow that gives finance complete visibility.">
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700,800,900&display=swap" rel="stylesheet"/>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        * { box-sizing: border-box; }
        body { background:#fff; color:#0f172a; font-family:'Figtree',sans-serif; margin:0; }

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

        /* ── Pricing ── */
        .pricing-section { background:#f8fafc; }
        .pricing-grid { display:grid; grid-template-columns:repeat(3,1fr); gap:24px; max-width:960px; margin:0 auto; }
        .pricing-card { background:#fff; border:1px solid #e2e8f0; border-radius:20px; padding:28px; }
        .pricing-card.popular { background:linear-gradient(160deg,#1d4ed8 0%,#1e3a8a 60%,#312e81 100%); border-color:#3b82f6; box-shadow:0 20px 60px rgba(37,99,235,.25); position:relative; }
        .popular-badge { position:absolute; top:-14px; left:50%; transform:translateX(-50%); background:#f59e0b; color:#78350f; font-size:11px; font-weight:700; padding:4px 16px; border-radius:20px; white-space:nowrap; letter-spacing:.5px; text-transform:uppercase; }
        .plan-name { font-size:11px; font-weight:700; text-transform:uppercase; letter-spacing:1.5px; color:#94a3b8; margin-bottom:12px; }
        .plan-name.white { color:#bfdbfe; }
        .plan-price { font-size:40px; font-weight:900; color:#0f172a; margin-bottom:4px; line-height:1; }
        .plan-price.white { color:#fff; }
        .plan-sub { font-size:13px; color:#94a3b8; margin-bottom:24px; }
        .plan-sub.white { color:#93c5fd; }
        .plan-btn { display:block; text-align:center; padding:11px; font-size:14px; font-weight:700; border-radius:12px; text-decoration:none; margin-bottom:28px; border:2px solid #e2e8f0; color:#0f172a; background:#fff; transition:all .15s; }
        .plan-btn:hover { border-color:#94a3b8; background:#f8fafc; }
        .plan-btn.white-btn { background:#fff; color:#1d4ed8; border-color:transparent; }
        .plan-btn.white-btn:hover { background:#eff6ff; }
        .plan-list { list-style:none; margin:0; padding:0; display:flex; flex-direction:column; gap:10px; }
        .plan-list li { display:flex; align-items:flex-start; gap:9px; font-size:13px; color:#475569; }
        .plan-list li.white { color:#bfdbfe; }
        .plan-check { width:16px; height:16px; border-radius:50%; background:#dcfce7; display:flex; align-items:center; justify-content:center; flex-shrink:0; margin-top:1px; }
        .plan-check.blue { background:rgba(255,255,255,.2); }

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

        /* Responsive */
        @media (max-width:1024px) {
            .hero-grid, .solution-grid { grid-template-columns:1fr; }
            .how-grid { grid-template-columns:repeat(3,1fr); }
            .how-connector { display:none; }
            .feat-cols-grid { grid-template-columns:repeat(2,1fr); }
            .footer-grid { grid-template-columns:1fr 1fr; }
        }
        @media (max-width:768px) {
            .hero-h1 { font-size:38px; }
            .problem-grid, .testimonial-grid, .pricing-grid, .spotlight-grid { grid-template-columns:1fr; }
            .feature-check-grid { grid-template-columns:1fr; }
            .faq-grid { grid-template-columns:1fr; }
            .stats-grid { grid-template-columns:1fr 1fr; }
            .nav-links { display:none; }
        }
    </style>
</head>
<body>

{{-- ── Navigation ── --}}
<nav class="nav-wrap">
    <div class="nav-inner">
        <div class="nav-logo">
            <div class="logo-box">
                <svg width="16" height="16" fill="none" stroke="#fff" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"/></svg>
            </div>
            <span class="logo-text">FlowCheck</span>
        </div>
        <div class="nav-links">
            @foreach([['Product',true],['Solutions',true],['Resources',true],['Pricing',false],['About Us',false]] as [$l,$a])
            <a href="{{ $l==='Pricing'?'#pricing':'#' }}" class="nav-link">
                {{ $l }}
                @if($a)<svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="color:#94a3b8"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>@endif
            </a>
            @endforeach
        </div>
        <div class="nav-actions">
            <a href="{{ route('login') }}" class="btn-login">Log in</a>
            <a href="{{ route('login') }}" class="btn-cta">Start Free Trial</a>
        </div>
    </div>
</nav>

{{-- ── Hero ── --}}
<section class="hero-section">
    <div class="section-inner">
        <div class="hero-grid">
            <div>
                <h1 class="hero-h1">Take control of<br>every purchase<br>request.</h1>
                <p class="hero-sub">Replace spreadsheets, WhatsApp approvals, and email chains with a structured procurement workflow that gives finance complete visibility.</p>
                <div class="hero-btns">
                    <a href="{{ route('login') }}" class="btn-primary-lg">Start Free Trial</a>
                    <a href="#how-it-works" class="btn-outline-lg">Book a Demo</a>
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

            <div>
                <div class="dash-card">
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
                                ['Vendors','M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z'],
                                ['Purch. Orders','M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z'],
                                ['Invoices','M9 14l6-6m-5.5.5h.01m4.99 5h.01M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16l3.5-2 3.5 2 3.5-2 3.5 2z'],
                                ['Reports','M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z'],
                                ['Settings','M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z M15 12a3 3 0 11-6 0 3 3 0 016 0z'],
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
                                @foreach([['Total Requests','128','+12% this month',true],['Pending Approvals','34','+45% this month',false],['Approved','94','+10% this month',true],['Total Spend','$256,430','+40% this month',true]] as [$l,$v,$c,$pos])
                                <div class="dash-stat">
                                    <div class="dash-stat-label">{{ $l }}</div>
                                    <div class="dash-stat-val">{{ $v }}</div>
                                    <div class="dash-stat-chg {{ $pos?'chg-green':'chg-red' }}">{{ $c }}</div>
                                </div>
                                @endforeach
                            </div>
                            <div class="dash-charts">
                                <div class="dash-chart">
                                    <div class="dash-chart-title">Request Status</div>
                                    <div class="donut-wrap">
                                        <div class="donut"></div>
                                        <div class="donut-legend">
                                            <div class="donut-row"><span class="donut-dot" style="background:#2563eb"></span>Approved 94</div>
                                            <div class="donut-row"><span class="donut-dot" style="background:#f59e0b"></span>Pending 34</div>
                                            <div class="donut-row"><span class="donut-dot" style="background:#ef4444"></span>Rejected 12</div>
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

{{-- ── Trust Bar ── --}}
<div class="trust-bar">
    <div class="section-inner">
        <p class="trust-bar-label">Trusted by procurement teams at</p>
        <div class="trust-logos">
            @foreach([['UNICEF','M12 2L2 7l10 5 10-5-10-5zM2 17l10 5 10-5M2 12l10 5 10-5'],['Save the Children','M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z'],['World Vision','M15 12a3 3 0 11-6 0 3 3 0 016 0z M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z'],['PLAN International','M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z'],['IRC','M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z'],['CARE','M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z'],['OXFAM','M21 12a9 9 0 11-18 0 9 9 0 0118 0z']] as [$name,$icon])
            <a href="#" class="trust-logo-item">
                <svg width="16" height="16" fill="none" stroke="#1e293b" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="{{ $icon }}"/></svg>
                <span class="trust-logo-name">{{ $name }}</span>
            </a>
            @endforeach
        </div>
    </div>
</div>

{{-- ── Problem ── --}}
<section class="section" id="features">
    <div class="section-inner">
        <h2 class="section-title" style="text-align:center;margin-bottom:48px">Procurement breaks down when processes live everywhere.</h2>
        <div class="problem-grid">
            @foreach([
                ['No Visibility','Requests disappear in chats and inboxes.','M15 12a3 3 0 11-6 0 3 3 0 016 0z M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z','#fef2f2','#dc2626'],
                ['No Control','Budgets are exceeded before finance can intervene.','M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z','#fff7ed','#ea580c'],
                ['No Accountability','No clear record of who approved what.','M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z','#fefce8','#ca8a04'],
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

{{-- ── Solution ── --}}
<section class="section solution-section">
    <div class="section-inner">
        <div class="solution-grid">
            <div>
                <div class="pr-card">
                    <div class="pr-breadcrumb"><span class="pr-back">← Back to requests</span></div>
                    <div class="pr-body">
                        <div class="pr-header">
                            <div>
                                <p class="pr-title">Purchase Request #PR-2024-1024</p>
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
                            <div><div class="pr-amount-label">Amount</div><div class="pr-amount-val">$2,450.00 <span style="font-size:11px;color:#94a3b8;font-weight:400">USD</span></div></div>
                            <div><div class="pr-amount-label">Date</div><div class="pr-amount-val" style="font-size:13px">May 15, 2024</div></div>
                        </div>
                        <div class="pr-tabs">
                            <button class="pr-tab active">Details</button>
                            <button class="pr-tab">Items (3)</button>
                            <button class="pr-tab">Approvals</button>
                            <button class="pr-tab">History</button>
                        </div>
                        <p class="approval-section-label">Approval Workflow</p>
                        @foreach([['1','Department Manager','Robert Fox','green'],['2','Finance Manager','Leslie Alexander','amber'],['3','Procurement Head','Gary','gray']] as [$n,$role,$name,$s])
                        <div class="approval-row">
                            <div class="approval-num">{{ $n }}</div>
                            <div class="approval-info"><div class="approval-role">{{ $role }}</div><div class="approval-name">{{ $name }}</div></div>
                            @if($s==='green')<span class="badge-green">Approved</span>
                            @elseif($s==='amber')<span class="badge-amber">Pending</span>
                            @else<span class="badge-gray">Waiting</span>@endif
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
            <div>
                <h2 class="solution-title">One workflow<br>from request<br>to payment.</h2>
                <div class="feature-check-grid">
                    @foreach(['Purchase Requests','Purchase Orders','Approval Routing','Invoice Matching','Vendor Sourcing','Reporting'] as $feat)
                    <div class="feature-check">
                        <div class="feature-check-icon">
                            <svg width="10" height="10" fill="#2563eb" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/></svg>
                        </div>
                        {{ $feat }}
                    </div>
                    @endforeach
                </div>
                <a href="{{ route('login') }}" class="btn-primary-lg" style="display:inline-flex;align-items:center;gap:8px">
                    See the Platform
                    <svg width="14" height="14" fill="none" stroke="#fff" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                </a>
            </div>
        </div>
    </div>
</section>

{{-- ── How It Works ── --}}
<section class="section" style="background:#fff" id="how-it-works">
    <div class="section-inner">
        <h2 class="section-title" style="text-align:center;margin-bottom:48px">How FlowCheck works</h2>
        <div class="how-grid">
            <div class="how-connector"></div>
            @foreach([
                ['1','Request','Employees submit requests.','M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2'],
                ['2','Review','Approvers are notified automatically.','M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z'],
                ['3','Vendor Selection','Collect and compare quotes.','M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z'],
                ['4','Purchase Order','Generate approved POs.','M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z'],
                ['5','Invoice Matching','Verify spending against approvals.','M9 14l6-6m-5.5.5h.01m4.99 5h.01M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16l3.5-2 3.5 2 3.5-2 3.5 2z'],
                ['6','Reporting','Track budgets and spending.','M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z'],
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

{{-- ── Everything You Need ── --}}
<section class="section" style="background:#fff">
    <div class="section-inner">
        <h2 class="section-title" style="text-align:center;margin-bottom:48px">Everything you need in one platform</h2>
        <div class="feat-cols-grid">
            @php
            $featCols = [
                ['Governance & Control','M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z',['Approval Workflows','Budget Controls','Audit Trail','Role Permissions'],'#dbeafe','#1d4ed8','#1d4ed8'],
                ['Purchasing','M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z',['Purchase Requests','RFQs','Purchase Orders','Invoice Matching'],'#dcfce7','#16a34a','#16a34a'],
                ['Vendor Management','M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z',['Vendor Database','Performance Tracking','Document Storage'],'#ede9fe','#7c3aed','#7c3aed'],
                ['Reporting & Analytics','M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z',['Spend Analytics','Department Reports','Exportable Data'],'#fef3c7','#d97706','#d97706'],
            ];
            @endphp
            @foreach($featCols as [$colTitle,$colIcon,$items,$iconBg,$iconColor,$dotColor])
            <div>
                <div class="feat-col-header">
                    <div class="feat-col-icon" style="background:{{ $iconBg }}">
                        <svg width="18" height="18" fill="none" stroke="{{ $iconColor }}" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="{{ $colIcon }}"/></svg>
                    </div>
                    <span class="feat-col-name">{{ $colTitle }}</span>
                </div>
                <ul class="feat-list">
                    @foreach($items as $item)
                    <li>
                        <span class="feat-dot" style="background:{{ $dotColor }}"></span>
                        {{ $item }}
                    </li>
                    @endforeach
                </ul>
            </div>
            @endforeach
        </div>
    </div>
</section>

{{-- ── Feature Spotlights ── --}}
<section class="section" style="background:#f8fafc">
    <div class="section-inner">
        <h2 class="section-title" style="text-align:center;margin-bottom:48px">Powerful features. Simple experience.</h2>
        <div class="spotlight-grid">

            {{-- Approval Workflows --}}
            <div class="spotlight-card">
                <div class="spotlight-preview">
                    <div class="mini-card">
                        <div class="mini-label">Approval Workflow</div>
                        @foreach([['Robert Fox','Department Manager','RF','#dbeafe','#1d4ed8','green'],['Leslie Alexander','Finance Manager','LA','#ede9fe','#7c3aed','amber']] as [$name,$role,$init,$bg,$color,$s])
                        <div class="mini-approval">
                            <div class="mini-avatar" style="background:{{ $bg }};color:{{ $color }}">{{ $init }}</div>
                            <div class="mini-info"><div class="mini-role">{{ $role }}</div><div class="mini-name">{{ $name }}</div></div>
                            @if($s==='green')<span class="mini-badge" style="background:#f0fdf4;color:#16a34a">Approved</span>
                            @else<span class="mini-badge" style="background:#fffbeb;color:#d97706">Pending</span>@endif
                        </div>
                        @endforeach
                        <div class="mini-progress">
                            <div class="mini-prog-bar" style="background:#2563eb"></div>
                            <div class="mini-prog-bar" style="background:#fbbf24"></div>
                            <div class="mini-prog-bar" style="background:#e2e8f0"></div>
                        </div>
                    </div>
                </div>
                <div class="spotlight-label">
                    <h3 class="spotlight-title">Approval Workflows</h3>
                    <p class="spotlight-desc">Route requests automatically through your org structure.</p>
                </div>
            </div>

            {{-- Budget Controls --}}
            <div class="spotlight-card">
                <div class="spotlight-preview">
                    <div class="mini-card">
                        <div class="budget-dept">Marketing Department</div>
                        <div class="budget-row">
                            <div><div class="budget-total">$25,000.00</div><div class="budget-total-label">Total Budget</div></div>
                            <div><div class="budget-spent">$19,750.00</div><div class="budget-spent-label">Spent</div></div>
                        </div>
                        <div class="budget-bar-bg"><div class="budget-bar-fill" style="width:79%"></div></div>
                        <div class="budget-pct">79%</div>
                    </div>
                </div>
                <div class="spotlight-label">
                    <h3 class="spotlight-title">Budget Controls</h3>
                    <p class="spotlight-desc">Prevent unauthorized spending before it happens.</p>
                </div>
            </div>

            {{-- Spend Analytics --}}
            <div class="spotlight-card">
                <div class="spotlight-preview">
                    <div class="mini-card">
                        <div style="font-size:10px;font-weight:600;color:#64748b;margin-bottom:2px">Total Spend</div>
                        <div class="analytics-total">$256,430</div>
                        <div class="analytics-chg">↑ 10% vs last month</div>
                        <div class="bar-chart">
                            @foreach([30,45,35,60,50,75,65,80,55,70,85,90] as $h)
                            <div class="bar-item" style="height:{{ $h }}%;background:{{ $loop->index > 8 ? '#2563eb' : '#bfdbfe' }};border-radius:2px 2px 0 0"></div>
                            @endforeach
                        </div>
                    </div>
                </div>
                <div class="spotlight-label">
                    <h3 class="spotlight-title">Spend Analytics</h3>
                    <p class="spotlight-desc">Understand spending patterns across your organisation.</p>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- ── Testimonials ── --}}
<section class="section" style="background:#fff">
    <div class="section-inner">
        <h2 class="section-title" style="text-align:center;margin-bottom:48px">Loved by procurement teams</h2>
        <div class="testimonial-grid">
            @foreach([
                ['"FlowCheck reduced our approval time from 5 days to less than 24 hours."','Operations Manager','NGO Organization','OM','#2563eb','c-blue'],
                ['"We finally have complete visibility over our budgets and spending."','Finance Director','International School','FD','#7c3aed','c-violet'],
                ['"The audit trail has made our compliance process smooth and stress-free."','Procurement Lead','Healthcare Nonprofit','PL','#059669','c-emerald'],
            ] as [$q,$role,$org,$init,$avatarBg,$cls])
            <div class="testimonial-card {{ $cls }}">
                <div class="stars">@for($i=0;$i<5;$i++)<span class="star">★</span>@endfor</div>
                <p class="testimonial-quote">{{ $q }}</p>
                <div class="testimonial-author">
                    <div class="author-avatar" style="background:{{ $avatarBg }}">{{ $init }}</div>
                    <div>
                        <div class="author-name">{{ $role }}</div>
                        <div class="author-org">{{ $org }}</div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

{{-- ── Pricing ── --}}
<section class="section pricing-section" id="pricing">
    <div class="section-inner">
        <h2 class="section-title" style="text-align:center;margin-bottom:8px">Simple, transparent pricing</h2>
        <p class="section-sub" style="text-align:center;margin-bottom:56px">Start free. Scale as you grow. No hidden fees.</p>
        <div class="pricing-grid">
            <div class="pricing-card">
                <div class="plan-name">Starter</div>
                <div class="plan-price">Free</div>
                <div class="plan-sub">For small teams getting started</div>
                <a href="{{ route('login') }}" class="plan-btn">Get Started Free</a>
                <ul class="plan-list">
                    @foreach(['Up to 5 users','Purchase requests & approvals','Basic vendor list','Email notifications','30-day audit log'] as $f)
                    <li>
                        <div class="plan-check"><svg width="9" height="9" fill="#16a34a" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/></svg></div>
                        {{ $f }}
                    </li>
                    @endforeach
                </ul>
            </div>
            <div class="pricing-card popular">
                <div class="popular-badge">Most Popular</div>
                <div class="plan-name white">Professional</div>
                <div class="plan-price white">ZMW 2,500</div>
                <div class="plan-sub white">per month · up to 25 users</div>
                <a href="{{ route('login') }}" class="plan-btn white-btn">Start Free Trial</a>
                <ul class="plan-list">
                    @foreach(['Everything in Starter','Up to 25 users','Full RFQ & PO management','3-way invoice matching','Budget tracking & alerts','Contract management','Full audit trail','Priority support'] as $f)
                    <li class="white">
                        <div class="plan-check blue"><svg width="9" height="9" fill="#fff" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/></svg></div>
                        {{ $f }}
                    </li>
                    @endforeach
                </ul>
            </div>
            <div class="pricing-card">
                <div class="plan-name">Enterprise</div>
                <div class="plan-price">Custom</div>
                <div class="plan-sub">For large organisations & institutions</div>
                <a href="#" class="plan-btn">Contact Sales</a>
                <ul class="plan-list">
                    @foreach(['Unlimited users','Everything in Professional','Tenders & BOQ management','Custom approval workflows','Dedicated onboarding','SSO & advanced security','Custom reporting','SLA support'] as $f)
                    <li>
                        <div class="plan-check"><svg width="9" height="9" fill="#16a34a" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/></svg></div>
                        {{ $f }}
                    </li>
                    @endforeach
                </ul>
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
                ['How long does setup take?','Most teams are live within one working day. Our onboarding guides you through importing vendors, configuring workflows, and inviting your team — no IT support needed.'],
                ['Do we need procurement expertise?','No. FlowCheck is designed for finance and operations teams. The interface is intuitive enough that any team member can raise a request on day one.'],
                ['Can approvals match our organizational structure?','Yes. FlowCheck supports multi-level, role-based approval chains — configurable per department, cost centre, or spend threshold.'],
                ['Can we integrate with existing systems?','FlowCheck connects with accounting tools and ERP systems. Our API is available on Professional and Enterprise plans.'],
                ['Is our data secure?','Your data is encrypted in transit and at rest. Role-based access ensures users only see what they\'re permitted to see.'],
                ['Can we upgrade or downgrade later?','Absolutely. Change your plan at any time from your organisation settings — no penalties or lock-in contracts.'],
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
        <h2 class="cta-title">Bring order to procurement.</h2>
        <p class="cta-sub">Stop managing purchases through spreadsheets and chat messages.</p>
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
                <p class="footer-brand-desc">The modern procurement platform for control, visibility, and compliance.</p>
                <div class="footer-socials">
                    <a href="#" class="footer-social">in</a>
                    <a href="#" class="footer-social">tw</a>
                    <a href="#" class="footer-social">yt</a>
                </div>
            </div>
            @foreach([
                ['Product',['Features','Pricing','Integrations','Changelog']],
                ['Solutions',['NGOs','Education','Healthcare','Manufacturing']],
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
            <span class="footer-copy">© 2025 FlowCheck. All rights reserved.</span>
            <div class="footer-legal">
                <a href="#">Privacy Policy</a>
                <a href="#">Terms of Service</a>
            </div>
        </div>
    </div>
</footer>

</body>
</html>

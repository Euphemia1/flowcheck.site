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
        body { background: #fff; color: #0f172a; }

        .nav-border { border-bottom: 1px solid #e2e8f0; }

        .btn-primary { background: #2563eb; color: #fff; transition: background .15s, box-shadow .15s; }
        .btn-primary:hover { background: #1d4ed8; box-shadow: 0 4px 16px rgba(37,99,235,.3); }

        .btn-outline { border: 1.5px solid #cbd5e1; color: #0f172a; background: #fff; transition: all .15s; }
        .btn-outline:hover { border-color: #94a3b8; background: #f8fafc; }

        .hero-card-shadow { box-shadow: 0 24px 80px rgba(0,0,0,.13), 0 4px 18px rgba(0,0,0,.07); }

        .trust-item { opacity: .45; filter: grayscale(1); transition: all .2s; }
        .trust-item:hover { opacity: .75; filter: grayscale(0); }

        .problem-icon-wrap { background: #eff6ff; border-radius: 50%; width: 52px; height: 52px; display: flex; align-items: center; justify-content: center; }

        .workflow-step-icon { width: 52px; height: 52px; background: #eff6ff; border-radius: 12px; display: flex; align-items: center; justify-content: center; margin: 0 auto 12px; }

        .stat-band { background: linear-gradient(135deg, #f0fdf4 0%, #ecfdf5 100%); }

        .feature-spot-card { background: #fff; border: 1px solid #e2e8f0; border-radius: 16px; transition: all .2s; }
        .feature-spot-card:hover { box-shadow: 0 10px 40px rgba(0,0,0,.09); transform: translateY(-3px); }

        .testimonial-card { background: #fff; border: 1px solid #e2e8f0; border-radius: 16px; }

        .faq-row { border-bottom: 1px solid #e2e8f0; }

        .cta-band { background: linear-gradient(135deg, #1e40af 0%, #1e3a8a 50%, #312e81 100%); }

        .footer-dark { background: #0c1a33; }

        /* Donut chart */
        .donut-ring {
            border-radius: 50%;
            background: conic-gradient(#2563eb 0deg 244deg, #f59e0b 244deg 290deg, #ef4444 290deg 360deg);
            display: flex; align-items: center; justify-content: center;
        }
        .donut-ring::after {
            content: '';
            width: 58px; height: 58px;
            background: #fff;
            border-radius: 50%;
        }

        .status-badge-orange { background: #fff7ed; color: #c2410c; border: 1px solid #fed7aa; font-size: 11px; font-weight: 600; padding: 2px 8px; border-radius: 20px; white-space: nowrap; }
        .approval-row { display: flex; align-items: center; gap: 10px; padding: 6px 0; border-bottom: 1px solid #f1f5f9; font-size: 12px; }
        .badge-approved { background: #f0fdf4; color: #16a34a; padding: 1px 8px; border-radius: 20px; font-size: 11px; font-weight: 600; white-space: nowrap; }
        .badge-pending-s { background: #fff7ed; color: #d97706; padding: 1px 8px; border-radius: 20px; font-size: 11px; font-weight: 600; white-space: nowrap; }
        .badge-waiting { background: #f8fafc; color: #94a3b8; padding: 1px 8px; border-radius: 20px; font-size: 11px; font-weight: 600; white-space: nowrap; }
    </style>
</head>
<body class="font-sans antialiased">

{{-- ── Navigation ── --}}
<nav class="fixed top-0 inset-x-0 z-50 bg-white nav-border">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between h-16">

            {{-- Logo --}}
            <div class="flex items-center gap-2.5">
                <div class="w-8 h-8 bg-blue-600 rounded-lg flex items-center justify-center">
                    <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"/>
                    </svg>
                </div>
                <span class="text-lg font-bold text-slate-900 tracking-tight">FlowCheck</span>
            </div>

            {{-- Nav Links --}}
            <div class="hidden md:flex items-center gap-1">
                @foreach([['Product',true],['Solutions',true],['Resources',true],['Pricing',false],['About Us',false]] as [$label,$hasArrow])
                <a href="{{ $label === 'Pricing' ? '#pricing' : '#' }}" class="flex items-center gap-1 px-4 py-2 text-sm text-slate-600 hover:text-slate-900 rounded-lg hover:bg-slate-50 transition font-medium">
                    {{ $label }}
                    @if($hasArrow)
                    <svg class="w-3.5 h-3.5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                    @endif
                </a>
                @endforeach
            </div>

            {{-- Auth CTAs --}}
            <div class="flex items-center gap-3">
                <a href="{{ route('login') }}" class="hidden sm:block text-sm font-semibold text-slate-600 hover:text-slate-900 px-3 py-2 rounded-lg hover:bg-slate-50 transition">Log in</a>
                <a href="{{ route('login') }}" class="btn-primary inline-flex items-center px-4 py-2.5 text-sm font-bold rounded-lg">Start Free Trial</a>
            </div>
        </div>
    </div>
</nav>

{{-- ── Hero ── --}}
<section class="pt-28 pb-20 overflow-hidden bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid lg:grid-cols-2 gap-12 items-center">

            {{-- Left: Copy --}}
            <div>
                <h1 class="text-5xl lg:text-[56px] font-black leading-[1.08] text-slate-900 mb-6 tracking-tight">
                    Take control of<br>every purchase<br>request.
                </h1>
                <p class="text-lg text-slate-500 leading-relaxed mb-8 max-w-md">
                    Replace spreadsheets, WhatsApp approvals, and email chains with a structured procurement workflow that gives finance complete visibility.
                </p>
                <div class="flex flex-wrap gap-3 mb-8">
                    <a href="{{ route('login') }}" class="btn-primary inline-flex items-center px-6 py-3 text-sm font-bold rounded-lg">Start Free Trial</a>
                    <a href="#how-it-works" class="btn-outline inline-flex items-center px-6 py-3 text-sm font-bold rounded-lg">Book a Demo</a>
                </div>
                <div class="flex flex-wrap gap-6 text-sm text-slate-500">
                    @foreach(['No credit card required','Easy setup','Cancel anytime'] as $t)
                    <span class="flex items-center gap-1.5">
                        <svg class="w-4 h-4 text-blue-600 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/></svg>
                        {{ $t }}
                    </span>
                    @endforeach
                </div>
            </div>

            {{-- Right: Dashboard Mockup --}}
            <div class="relative lg:pl-4">
                <div class="bg-white rounded-2xl hero-card-shadow border border-slate-200 overflow-hidden">
                    {{-- App top bar --}}
                    <div class="flex items-center justify-between px-4 py-3 border-b border-slate-100 bg-white">
                        <div class="flex items-center gap-2">
                            <div class="w-5 h-5 bg-blue-600 rounded flex items-center justify-center">
                                <svg class="w-3 h-3 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 12l2 2 4-4"/></svg>
                            </div>
                            <span class="text-xs font-bold text-slate-800">FlowCheck</span>
                        </div>
                        <div class="flex items-center gap-2">
                            <div class="w-7 h-7 bg-slate-100 rounded-full flex items-center justify-center">
                                <svg class="w-3.5 h-3.5 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/></svg>
                            </div>
                            <div class="w-7 h-7 bg-slate-100 rounded-full flex items-center justify-center">
                                <svg class="w-3.5 h-3.5 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                            </div>
                        </div>
                    </div>

                    <div class="flex" style="min-height:290px">
                        {{-- Sidebar --}}
                        <div class="w-36 bg-slate-50 border-r border-slate-100 py-3 flex-shrink-0">
                            <div class="px-3 mb-1">
                                <div class="flex items-center gap-2 px-2 py-1.5 bg-blue-600 rounded-md">
                                    <svg class="w-3 h-3 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                                    <span class="text-xs font-semibold text-white">Dashboard</span>
                                </div>
                            </div>
                            @foreach([
                                ['Requests','M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2'],
                                ['Approvals','M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z'],
                                ['Vendors','M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z'],
                                ['Purchase Orders','M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z'],
                                ['Invoices','M9 14l6-6m-5.5.5h.01m4.99 5h.01M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16l3.5-2 3.5 2 3.5-2 3.5 2z'],
                                ['Reports','M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z'],
                                ['Settings','M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z M15 12a3 3 0 11-6 0 3 3 0 016 0z'],
                            ] as [$name,$path])
                            <div class="px-3 mb-0.5">
                                <div class="flex items-center gap-2 px-2 py-1.5 rounded-md">
                                    <svg class="w-3 h-3 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="{{ $path }}"/></svg>
                                    <span class="text-xs text-slate-500">{{ $name }}</span>
                                </div>
                            </div>
                            @endforeach
                        </div>

                        {{-- Main content --}}
                        <div class="flex-1 p-4 overflow-hidden">
                            <div class="text-xs font-bold text-slate-800 mb-3">Dashboard</div>

                            {{-- Stat cards --}}
                            <div class="grid grid-cols-4 gap-2 mb-4">
                                @foreach([
                                    ['Total Requests','128','+12% this month','text-emerald-600'],
                                    ['Pending Approvals','34','+45% this month','text-red-500'],
                                    ['Approved','94','+10% this month','text-emerald-600'],
                                    ['Total Spend','$256,430','+40% this month','text-emerald-600'],
                                ] as [$label,$val,$change,$cc])
                                <div class="bg-white border border-slate-100 rounded-lg p-2.5 shadow-sm">
                                    <div class="text-[9px] text-slate-400 mb-1 leading-tight">{{ $label }}</div>
                                    <div class="text-sm font-black text-slate-900">{{ $val }}</div>
                                    <div class="text-[9px] {{ $cc }} mt-0.5">{{ $change }}</div>
                                </div>
                                @endforeach
                            </div>

                            {{-- Charts row --}}
                            <div class="grid grid-cols-2 gap-3">
                                {{-- Donut --}}
                                <div class="bg-white border border-slate-100 rounded-lg p-3 shadow-sm">
                                    <div class="text-[9px] font-semibold text-slate-600 mb-2">Request Status</div>
                                    <div class="flex items-center gap-3">
                                        <div class="donut-ring flex-shrink-0" style="width:64px;height:64px;min-width:64px"></div>
                                        <div class="space-y-1.5">
                                            <div class="flex items-center gap-1.5 text-[9px] text-slate-600"><span class="w-2 h-2 rounded-full bg-blue-600 flex-shrink-0 inline-block"></span> Approved 94</div>
                                            <div class="flex items-center gap-1.5 text-[9px] text-slate-600"><span class="w-2 h-2 rounded-full bg-amber-400 flex-shrink-0 inline-block"></span> Pending 34</div>
                                            <div class="flex items-center gap-1.5 text-[9px] text-slate-600"><span class="w-2 h-2 rounded-full bg-red-400 flex-shrink-0 inline-block"></span> Rejected 12</div>
                                        </div>
                                    </div>
                                </div>

                                {{-- Line chart --}}
                                <div class="bg-white border border-slate-100 rounded-lg p-3 shadow-sm">
                                    <div class="text-[9px] font-semibold text-slate-600 mb-2">Spend Overview</div>
                                    <svg viewBox="0 0 120 55" class="w-full" style="height:52px">
                                        <defs>
                                            <linearGradient id="sg" x1="0" y1="0" x2="0" y2="1">
                                                <stop offset="0%" stop-color="#2563eb" stop-opacity=".18"/>
                                                <stop offset="100%" stop-color="#2563eb" stop-opacity="0"/>
                                            </linearGradient>
                                        </defs>
                                        <path d="M0 50 L20 40 L40 44 L60 30 L80 20 L100 10 L120 5" fill="none" stroke="#2563eb" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                        <path d="M0 50 L20 40 L40 44 L60 30 L80 20 L100 10 L120 5 L120 55 L0 55Z" fill="url(#sg)"/>
                                        <text x="0" y="54" font-size="6.5" fill="#94a3b8">Jan</text>
                                        <text x="22" y="54" font-size="6.5" fill="#94a3b8">Feb</text>
                                        <text x="44" y="54" font-size="6.5" fill="#94a3b8">Mar</text>
                                        <text x="66" y="54" font-size="6.5" fill="#94a3b8">Apr</text>
                                        <text x="88" y="54" font-size="6.5" fill="#94a3b8">May</text>
                                        <text x="109" y="54" font-size="6.5" fill="#94a3b8">Jun</text>
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
<section class="py-12 border-t border-b border-slate-100 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <p class="text-center text-xs font-semibold text-slate-400 uppercase tracking-widest mb-8">Trusted by procurement teams at</p>
        <div class="flex flex-wrap justify-center items-center gap-10 lg:gap-14">
            @foreach([
                ['UNICEF','M12 2L2 7l10 5 10-5-10-5zM2 17l10 5 10-5M2 12l10 5 10-5'],
                ['Save the Children','M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z'],
                ['World Vision','M15 12a3 3 0 11-6 0 3 3 0 016 0z M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z'],
                ['PLAN International','M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z'],
                ['IRC','M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z'],
                ['CARE','M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z'],
                ['OXFAM','M21 12a9 9 0 11-18 0 9 9 0 0118 0z'],
            ] as [$name,$icon])
            <div class="trust-item flex items-center gap-2 cursor-default">
                <svg class="w-4 h-4 text-slate-700" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="{{ $icon }}"/></svg>
                <span class="text-sm font-bold text-slate-700 tracking-tight">{{ $name }}</span>
            </div>
            @endforeach
        </div>
    </div>
</section>

{{-- ── Problem Section ── --}}
<section class="py-20 bg-white" id="features">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-14">
            <h2 class="text-3xl font-black text-slate-900">Procurement breaks down when processes<br class="hidden md:block"> live everywhere.</h2>
        </div>
        <div class="grid md:grid-cols-3 gap-10">
            @foreach([
                ['No Visibility','Requests disappear in chats and inboxes.','M15 12a3 3 0 11-6 0 3 3 0 016 0z M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z'],
                ['No Control','Budgets are exceeded before finance can intervene.','M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z'],
                ['No Accountability','No clear record of who approved what.','M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z'],
            ] as [$title,$desc,$icon])
            <div class="text-center px-4">
                <div class="problem-icon-wrap mx-auto mb-5">
                    <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="{{ $icon }}"/></svg>
                </div>
                <h3 class="text-base font-bold text-slate-900 mb-2">{{ $title }}</h3>
                <p class="text-sm text-slate-500 leading-relaxed">{{ $desc }}</p>
            </div>
            @endforeach
        </div>
    </div>
</section>

{{-- ── Solution Section ── --}}
<section class="py-20 bg-slate-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid lg:grid-cols-2 gap-16 items-center">

            {{-- PR Mockup --}}
            <div>
                <div class="bg-white rounded-2xl border border-slate-200 shadow-lg overflow-hidden">
                    <div class="px-5 pt-4 pb-3 border-b border-slate-100">
                        <span class="text-xs text-blue-600 font-semibold cursor-default">← Back to requests</span>
                    </div>
                    <div class="p-5">
                        <div class="flex items-start justify-between mb-4 gap-3">
                            <div class="min-w-0">
                                <div class="text-sm font-bold text-slate-900">Purchase Request #PR-2024-1024</div>
                                <div class="flex items-center gap-2 mt-1.5 flex-wrap">
                                    <div class="w-6 h-6 rounded-full bg-blue-100 flex items-center justify-center text-[10px] font-bold text-blue-700 flex-shrink-0">JC</div>
                                    <span class="text-xs text-slate-500">Jane Cooper</span>
                                    <span class="text-xs text-slate-300">·</span>
                                    <span class="text-xs text-slate-500">Marketing Department</span>
                                </div>
                            </div>
                            <span class="status-badge-orange flex-shrink-0">⚡ Pending Approval</span>
                        </div>

                        <div class="grid grid-cols-2 gap-4 mb-4 p-3 bg-slate-50 rounded-xl">
                            <div>
                                <div class="text-[10px] text-slate-400 mb-0.5">Amount</div>
                                <div class="text-sm font-bold text-slate-900">$2,450.00 <span class="text-xs font-normal text-slate-400">USD</span></div>
                            </div>
                            <div>
                                <div class="text-[10px] text-slate-400 mb-0.5">Date</div>
                                <div class="text-sm font-semibold text-slate-700">May 15, 2024</div>
                            </div>
                        </div>

                        <div class="flex gap-4 border-b border-slate-100 mb-4">
                            @foreach(['Details','Items (3)','Approvals','History'] as $tab)
                            <button class="text-xs pb-2 {{ $loop->first ? 'text-blue-600 border-b-2 border-blue-600 font-semibold' : 'text-slate-400' }}">{{ $tab }}</button>
                            @endforeach
                        </div>

                        <div class="text-[10px] font-semibold text-slate-500 uppercase tracking-wider mb-2">Approval Workflow</div>
                        <div>
                            @foreach([
                                ['1','Department Manager','Robert Fox','approved'],
                                ['2','Finance Manager','Leslie Alexander','pending'],
                                ['3','Procurement Head','Gary','waiting'],
                            ] as [$n,$role,$name,$status])
                            <div class="approval-row">
                                <div class="w-5 h-5 rounded-full bg-slate-100 flex items-center justify-center text-[9px] font-bold text-slate-500 flex-shrink-0">{{ $n }}</div>
                                <div class="flex-1 min-w-0">
                                    <div class="text-[11px] font-medium text-slate-700 truncate">{{ $role }}</div>
                                    <div class="text-[10px] text-slate-400">{{ $name }}</div>
                                </div>
                                @if($status === 'approved')
                                <span class="badge-approved">Approved</span>
                                @elseif($status === 'pending')
                                <span class="badge-pending-s">Pending</span>
                                @else
                                <span class="badge-waiting">Waiting</span>
                                @endif
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>

            {{-- Right copy --}}
            <div>
                <h2 class="text-4xl font-black text-slate-900 leading-tight mb-6">One workflow<br>from request<br>to payment.</h2>
                <div class="grid grid-cols-2 gap-3 mb-8">
                    @foreach(['Purchase Requests','Purchase Orders','Approval Routing','Invoice Matching','Vendor Sourcing','Reporting'] as $feat)
                    <div class="flex items-center gap-2 text-sm text-slate-700 font-medium">
                        <svg class="w-4 h-4 text-blue-600 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/></svg>
                        {{ $feat }}
                    </div>
                    @endforeach
                </div>
                <a href="{{ route('login') }}" class="btn-primary inline-flex items-center gap-2 px-6 py-3 text-sm font-bold rounded-lg">
                    See the Platform
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                </a>
            </div>
        </div>
    </div>
</section>

{{-- ── How It Works ── --}}
<section class="py-20 bg-white" id="how-it-works">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-14">
            <h2 class="text-3xl font-black text-slate-900">How FlowCheck works</h2>
        </div>
        <div class="relative">
            <div class="hidden lg:block absolute left-[8.33%] right-[8.33%] h-px bg-gradient-to-r from-slate-100 via-blue-200 to-slate-100" style="top:26px"></div>
            <div class="grid grid-cols-2 lg:grid-cols-6 gap-6">
                @foreach([
                    ['1','Request','Employees submit requests.','M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2'],
                    ['2','Review','Approvers are notified automatically.','M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z'],
                    ['3','Vendor Selection','Collect and compare quotes.','M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z'],
                    ['4','Purchase Order','Generate approved POs.','M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z'],
                    ['5','Invoice Matching','Verify spending against approvals.','M9 14l6-6m-5.5.5h.01m4.99 5h.01M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16l3.5-2 3.5 2 3.5-2 3.5 2z'],
                    ['6','Reporting','Track budgets and spending.','M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z'],
                ] as [$num,$title,$desc,$icon])
                <div class="flex flex-col items-center text-center relative">
                    <div class="workflow-step-icon relative z-10">
                        <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="{{ $icon }}"/></svg>
                    </div>
                    <div class="text-lg font-black text-slate-900 mb-1">{{ $num }}</div>
                    <div class="text-sm font-bold text-slate-800 mb-1">{{ $title }}</div>
                    <p class="text-xs text-slate-500 leading-relaxed">{{ $desc }}</p>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</section>

{{-- ── Stats Band ── --}}
<section class="py-14 stat-band" id="impact">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-2 lg:grid-cols-4 gap-8">
            @foreach([
                ['80%','Faster approval cycles','↑'],
                ['100%','Approval visibility','✓'],
                ['25%','Reduction in off-process spending','↓'],
                ['<1 Day','Average setup time','⚡'],
            ] as [$stat,$label,$icon])
            <div class="text-center">
                <div class="flex items-start justify-center gap-1.5 mb-1">
                    <span class="text-4xl font-black text-emerald-600 leading-tight">{{ $stat }}</span>
                    <span class="text-emerald-500 text-xl font-bold mt-1 leading-tight">{{ $icon }}</span>
                </div>
                <div class="text-sm font-semibold text-slate-700">{{ $label }}</div>
            </div>
            @endforeach
        </div>
    </div>
</section>

{{-- ── Everything You Need ── --}}
<section class="py-20 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-14">
            <h2 class="text-3xl font-black text-slate-900">Everything you need in one platform</h2>
        </div>
        <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-8">
            @foreach([
                ['Governance & Control','M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z',['Approval Workflows','Budget Controls','Audit Trail','Role Permissions']],
                ['Purchasing','M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z',['Purchase Requests','RFQs','Purchase Orders','Invoice Matching']],
                ['Vendor Management','M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z',['Vendor Database','Performance Tracking','Document Storage']],
                ['Reporting & Analytics','M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z',['Spend Analytics','Department Reports','Exportable Data']],
            ] as [$colTitle,$colIcon,$items])
            <div>
                <div class="flex items-center gap-2.5 mb-4">
                    <div class="w-9 h-9 bg-blue-50 rounded-lg flex items-center justify-center flex-shrink-0">
                        <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="{{ $colIcon }}"/></svg>
                    </div>
                    <h3 class="text-sm font-bold text-slate-900">{{ $colTitle }}</h3>
                </div>
                <ul class="space-y-2.5">
                    @foreach($items as $item)
                    <li class="flex items-center gap-2 text-sm text-slate-600">
                        <svg class="w-3.5 h-3.5 text-blue-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"/></svg>
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
<section class="py-20 bg-slate-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-14">
            <h2 class="text-3xl font-black text-slate-900">Powerful features. Simple experience.</h2>
        </div>
        <div class="grid md:grid-cols-3 gap-6">

            {{-- Approval Workflows --}}
            <div class="feature-spot-card overflow-hidden">
                <div class="p-5 bg-slate-50 border-b border-slate-100" style="height:170px">
                    <div class="bg-white rounded-xl border border-slate-200 p-4 shadow-sm">
                        <div class="text-xs font-semibold text-slate-700 mb-3">Approval Workflow</div>
                        @foreach([['Department Manager','Robert Fox','approved'],['Finance Manager','Leslie Alexander','pending']] as [$r,$n,$s])
                        <div class="flex items-center gap-2 mb-2">
                            <div class="w-6 h-6 rounded-full bg-blue-100 flex items-center justify-center text-[9px] font-bold text-blue-700 flex-shrink-0">{{ strtoupper(substr($n,0,1)) }}</div>
                            <div class="flex-1 min-w-0">
                                <div class="text-[10px] font-medium text-slate-700 truncate">{{ $r }}</div>
                                <div class="text-[9px] text-slate-400">{{ $n }}</div>
                            </div>
                            @if($s === 'approved')
                            <span class="badge-approved">Approved</span>
                            @else
                            <span class="badge-pending-s">Pending</span>
                            @endif
                        </div>
                        @endforeach
                        <div class="mt-3 flex items-center gap-1.5">
                            <div class="flex-1 h-1 bg-blue-600 rounded-full"></div>
                            <div class="flex-1 h-1 bg-amber-300 rounded-full"></div>
                            <div class="flex-1 h-1 bg-slate-200 rounded-full"></div>
                        </div>
                    </div>
                </div>
                <div class="p-5">
                    <h3 class="text-base font-bold text-slate-900 mb-1">Approval Workflows</h3>
                    <p class="text-sm text-slate-500">Route requests automatically through your org structure.</p>
                </div>
            </div>

            {{-- Budget Controls --}}
            <div class="feature-spot-card overflow-hidden">
                <div class="p-5 bg-slate-50 border-b border-slate-100" style="height:170px">
                    <div class="bg-white rounded-xl border border-slate-200 p-4 shadow-sm">
                        <div class="text-xs font-semibold text-slate-700 mb-1">Marketing Department</div>
                        <div class="flex items-end justify-between mb-3">
                            <div>
                                <div class="text-base font-black text-slate-900">$25,000.00</div>
                                <div class="text-[10px] text-slate-400">Total Budget</div>
                            </div>
                            <div class="text-right">
                                <div class="text-sm font-bold text-blue-600">$19,750.00</div>
                                <div class="text-[10px] text-slate-400">Spent</div>
                            </div>
                        </div>
                        <div class="w-full bg-slate-100 rounded-full h-2 mb-1">
                            <div class="bg-blue-600 h-2 rounded-full" style="width:79%"></div>
                        </div>
                        <div class="text-[10px] text-slate-400 text-right">79%</div>
                    </div>
                </div>
                <div class="p-5">
                    <h3 class="text-base font-bold text-slate-900 mb-1">Budget Controls</h3>
                    <p class="text-sm text-slate-500">Prevent unauthorized spending before it happens.</p>
                </div>
            </div>

            {{-- Spend Analytics --}}
            <div class="feature-spot-card overflow-hidden">
                <div class="p-5 bg-slate-50 border-b border-slate-100" style="height:170px">
                    <div class="bg-white rounded-xl border border-slate-200 p-4 shadow-sm">
                        <div class="text-xs font-semibold text-slate-700 mb-0.5">Total Spend</div>
                        <div class="text-xl font-black text-slate-900">$256,430</div>
                        <div class="text-[10px] text-emerald-600 mb-3">↑ 10% vs last month</div>
                        <div class="flex items-end gap-1 h-10">
                            @foreach([30,45,35,60,50,75,65,80,55,70,85,90] as $h)
                            <div class="flex-1 bg-blue-600 rounded-sm" style="height:{{ $h }}%;opacity:{{ $loop->index > 8 ? '1' : '0.45' }}"></div>
                            @endforeach
                        </div>
                    </div>
                </div>
                <div class="p-5">
                    <h3 class="text-base font-bold text-slate-900 mb-1">Spend Analytics</h3>
                    <p class="text-sm text-slate-500">Understand spending patterns across your organisation.</p>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- ── Testimonials ── --}}
<section class="py-20 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-14">
            <h2 class="text-3xl font-black text-slate-900">Loved by procurement teams</h2>
        </div>
        <div class="grid md:grid-cols-3 gap-6">
            @foreach([
                ['"FlowCheck reduced our approval time from 5 days to less than 24 hours."','Operations Manager','NGO Organization','OM','bg-blue-600'],
                ['"We finally have complete visibility over our budgets and spending."','Finance Director','International School','FD','bg-violet-600'],
                ['"The audit trail has made our compliance process smooth and stress-free."','Procurement Lead','Healthcare Nonprofit','PL','bg-emerald-600'],
            ] as [$quote,$role,$org,$initials,$avatarBg])
            <div class="testimonial-card p-7">
                <div class="flex mb-5">
                    @for($i=0;$i<5;$i++)
                    <svg class="w-4 h-4 text-amber-400" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                    @endfor
                </div>
                <p class="text-slate-700 leading-relaxed mb-6 font-medium text-sm">{{ $quote }}</p>
                <div class="flex items-center gap-3">
                    <div class="w-9 h-9 {{ $avatarBg }} rounded-full flex items-center justify-center text-xs font-bold text-white flex-shrink-0">{{ $initials }}</div>
                    <div>
                        <div class="text-sm font-semibold text-slate-900">{{ $role }}</div>
                        <div class="text-xs text-slate-500">{{ $org }}</div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

{{-- ── Pricing ── --}}
<section class="py-20 bg-slate-50" id="pricing">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-14">
            <h2 class="text-3xl font-black text-slate-900 mb-3">Simple, transparent pricing</h2>
            <p class="text-slate-500 text-base">Start free. Scale as you grow. No hidden fees.</p>
        </div>
        <div class="grid md:grid-cols-3 gap-6 max-w-5xl mx-auto">

            {{-- Starter --}}
            <div class="bg-white border border-slate-200 rounded-2xl p-7">
                <div class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-3">Starter</div>
                <div class="mb-1"><span class="text-4xl font-black text-slate-900">Free</span></div>
                <p class="text-sm text-slate-500 mb-6">For small teams getting started</p>
                <a href="{{ route('login') }}" class="btn-outline block text-center py-2.5 text-sm font-bold rounded-xl mb-7">Get Started Free</a>
                <ul class="space-y-3">
                    @foreach(['Up to 5 users','Purchase requests & approvals','Basic vendor list','Email notifications','30-day audit log'] as $f)
                    <li class="flex items-center gap-2.5 text-sm text-slate-600">
                        <svg class="w-4 h-4 text-emerald-500 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/></svg>
                        {{ $f }}
                    </li>
                    @endforeach
                </ul>
            </div>

            {{-- Professional --}}
            <div class="bg-blue-700 border border-blue-600 rounded-2xl p-7 relative shadow-xl shadow-blue-600/20">
                <div class="absolute -top-3.5 left-1/2 -translate-x-1/2">
                    <span class="bg-amber-400 text-amber-900 text-xs font-bold px-4 py-1 rounded-full uppercase tracking-wide">Most Popular</span>
                </div>
                <div class="text-xs font-bold text-blue-200 uppercase tracking-wider mb-3">Professional</div>
                <div class="mb-1"><span class="text-3xl font-black text-white">ZMW 2,500</span></div>
                <p class="text-sm text-blue-200 mb-6">per month · up to 25 users</p>
                <a href="{{ route('login') }}" class="block text-center py-2.5 text-sm font-bold rounded-xl mb-7 bg-white text-blue-700 hover:bg-blue-50 transition">Start Free Trial</a>
                <ul class="space-y-3">
                    @foreach(['Everything in Starter','Up to 25 users','Full RFQ & PO management','3-way invoice matching','Budget tracking & alerts','Contract management','Full audit trail','Priority support'] as $f)
                    <li class="flex items-center gap-2.5 text-sm text-blue-100">
                        <svg class="w-4 h-4 text-blue-300 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/></svg>
                        {{ $f }}
                    </li>
                    @endforeach
                </ul>
            </div>

            {{-- Enterprise --}}
            <div class="bg-white border border-slate-200 rounded-2xl p-7">
                <div class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-3">Enterprise</div>
                <div class="mb-1"><span class="text-4xl font-black text-slate-900">Custom</span></div>
                <p class="text-sm text-slate-500 mb-6">For large organisations & institutions</p>
                <a href="#" class="btn-outline block text-center py-2.5 text-sm font-bold rounded-xl mb-7">Contact Sales</a>
                <ul class="space-y-3">
                    @foreach(['Unlimited users','Everything in Professional','Tenders & BOQ management','Custom approval workflows','Dedicated onboarding','SSO & advanced security','Custom reporting','SLA support'] as $f)
                    <li class="flex items-center gap-2.5 text-sm text-slate-600">
                        <svg class="w-4 h-4 text-emerald-500 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/></svg>
                        {{ $f }}
                    </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
</section>

{{-- ── FAQ ── --}}
<section class="py-20 bg-white">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-start justify-between mb-12 gap-6">
            <h2 class="text-3xl font-black text-slate-900">Frequently asked<br>questions</h2>
            <a href="#" class="text-sm font-semibold text-blue-600 hover:text-blue-700 flex items-center gap-1 mt-2 whitespace-nowrap">
                View all FAQs
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
            </a>
        </div>
        <div class="grid md:grid-cols-2 gap-x-14">
            @foreach([
                ['How long does setup take?','Most teams are live within one working day. Our onboarding guides you through importing vendors, configuring workflows, and inviting your team — no IT support needed.'],
                ['Do we need procurement expertise?','No. FlowCheck is designed for finance and operations teams. The interface is intuitive enough that any team member can raise a request on day one.'],
                ['Can approvals match our organizational structure?','Yes. FlowCheck supports multi-level, role-based approval chains — configurable per department, cost centre, or spend threshold.'],
                ['Can we integrate with existing systems?','FlowCheck connects with accounting tools and ERP systems. Our API is available on Professional and Enterprise plans.'],
                ['Is our data secure?','Your data is encrypted in transit and at rest. Role-based access ensures users only see what they\'re permitted to see.'],
                ['Can we upgrade or downgrade later?','Absolutely. Change your plan at any time from your organisation settings — no penalties or lock-in contracts.'],
            ] as $faq)
            <div class="faq-row py-4" x-data="{ open: false }">
                <button class="w-full flex items-center justify-between gap-4 text-left" @click="open = !open">
                    <span class="text-sm font-semibold text-slate-900">{{ $faq[0] }}</span>
                    <svg class="w-4 h-4 text-slate-400 flex-shrink-0 transition-transform duration-200" :class="open ? 'rotate-45' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                </button>
                <div x-show="open" x-collapse class="pt-3">
                    <p class="text-sm text-slate-500 leading-relaxed">{{ $faq[1] }}</p>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

{{-- ── CTA Band ── --}}
<section class="cta-band py-20">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <h2 class="text-4xl font-black text-white mb-4">Bring order to procurement.</h2>
        <p class="text-blue-200 text-base mb-10 leading-relaxed">Stop managing purchases through spreadsheets and chat messages.</p>
        <div class="flex flex-wrap justify-center gap-4">
            <a href="{{ route('login') }}" class="inline-flex items-center px-7 py-3.5 bg-white text-blue-700 text-sm font-bold rounded-xl hover:bg-blue-50 transition shadow-lg">Start Free Trial</a>
            <a href="#" class="inline-flex items-center px-7 py-3.5 border-2 border-white/30 text-white text-sm font-bold rounded-xl hover:bg-white/10 transition">Book a Demo</a>
        </div>
    </div>
</section>

{{-- ── Footer ── --}}
<footer class="footer-dark pt-14 pb-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-2 md:grid-cols-6 gap-10 mb-12">
            <div class="col-span-2">
                <div class="flex items-center gap-2.5 mb-4">
                    <div class="w-8 h-8 bg-blue-600 rounded-lg flex items-center justify-center">
                        <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"/></svg>
                    </div>
                    <span class="font-bold text-white text-lg">FlowCheck</span>
                </div>
                <p class="text-sm text-slate-400 leading-relaxed mb-5">The modern procurement platform for control, visibility, and compliance.</p>
                <div class="flex gap-2">
                    @foreach(['in','tw','yt'] as $s)
                    <a href="#" class="w-8 h-8 bg-slate-700 rounded-lg flex items-center justify-center text-slate-400 hover:text-white hover:bg-slate-600 transition text-xs font-bold">{{ $s }}</a>
                    @endforeach
                </div>
            </div>
            @foreach([
                ['Product',['Features','Pricing','Integrations','Changelog']],
                ['Solutions',['NGOs','Education','Healthcare','Manufacturing']],
                ['Resources',['Blog','Templates','Guides','Help Center']],
                ['Company',['About Us','Careers','Contact','Privacy Policy']],
            ] as [$col,$links])
            <div>
                <h4 class="text-sm font-semibold text-white mb-4">{{ $col }}</h4>
                <ul class="space-y-3">
                    @foreach($links as $link)
                    <li><a href="#" class="text-sm text-slate-400 hover:text-white transition">{{ $link }}</a></li>
                    @endforeach
                </ul>
            </div>
            @endforeach
        </div>
        <div class="border-t border-white/5 pt-8 flex flex-col sm:flex-row items-center justify-between gap-4">
            <p class="text-sm text-slate-500">© 2025 FlowCheck. All rights reserved.</p>
            <div class="flex gap-6">
                <a href="#" class="text-sm text-slate-500 hover:text-white transition">Privacy Policy</a>
                <a href="#" class="text-sm text-slate-500 hover:text-white transition">Terms of Service</a>
            </div>
        </div>
    </div>
</footer>

</body>
</html>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FlowCheck — Procurement Management for SMEs & Institutions</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700,800,900&display=swap" rel="stylesheet"/>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        .gradient-text { background: linear-gradient(135deg, #60a5fa 0%, #a78bfa 100%); -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text; }
        .hero-glow { background: radial-gradient(ellipse 80% 50% at 50% -10%, rgba(59,130,246,0.15) 0%, transparent 70%); }
        .card-glow:hover { box-shadow: 0 0 0 1px rgba(99,102,241,0.3), 0 8px 32px rgba(99,102,241,0.1); }
        .stat-card { background: linear-gradient(135deg, rgba(255,255,255,0.05) 0%, rgba(255,255,255,0.02) 100%); }
    </style>
</head>
<body class="font-sans antialiased bg-gray-950 text-white">

{{-- ── Navigation ── --}}
<nav class="fixed top-0 inset-x-0 z-50 bg-gray-950/80 backdrop-blur-md border-b border-white/5">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between h-16">
            <div class="flex items-center gap-2.5">
                <div class="w-8 h-8 bg-blue-600 rounded-lg flex items-center justify-center">
                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"/>
                    </svg>
                </div>
                <span class="text-xl font-bold text-white">FlowCheck</span>
            </div>
            <div class="hidden md:flex items-center gap-8">
                <a href="#features" class="text-sm text-gray-400 hover:text-white transition">Features</a>
                <a href="#how-it-works" class="text-sm text-gray-400 hover:text-white transition">How It Works</a>
                <a href="#impact" class="text-sm text-gray-400 hover:text-white transition">Impact</a>
                <a href="#" class="text-sm text-gray-400 hover:text-white transition">About Us</a>
            </div>
            <div class="flex items-center gap-4">
                <a href="{{ route('login') }}" class="text-sm text-gray-300 hover:text-white font-medium transition">Sign In</a>
                <a href="{{ route('login') }}" class="px-4 py-2 bg-blue-600 text-white text-sm font-semibold rounded-lg hover:bg-blue-500 transition">Start Free Trial</a>
            </div>
        </div>
    </div>
</nav>

{{-- ── Hero ── --}}
<section class="relative pt-32 pb-24 overflow-hidden hero-glow">
    <div class="absolute inset-0 bg-[radial-gradient(ellipse_80%_60%_at_50%_-20%,rgba(59,130,246,0.12),transparent)]"></div>
    <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16">
            <div class="inline-flex items-center gap-2 px-3 py-1.5 bg-blue-950/60 border border-blue-500/20 rounded-full text-xs text-blue-400 font-medium mb-8">
                <span class="w-1.5 h-1.5 bg-blue-400 rounded-full animate-pulse"></span>
                Procurement Intelligence for SMEs & Institutions
            </div>
            <h1 class="text-5xl sm:text-6xl lg:text-7xl font-black leading-[1.05] mb-6 tracking-tight">
                Take Control of<br>
                <span class="gradient-text">Every Purchase.</span><br>
                Every Approval.
            </h1>
            <p class="text-lg text-gray-400 max-w-2xl mx-auto mb-10 leading-relaxed">
                FlowCheck transforms messy procurement — scattered emails, lost approvals, and untracked spending — into a structured, visible workflow your whole organisation can rely on.
            </p>
            <div class="flex flex-wrap justify-center gap-4 mb-12">
                <a href="{{ route('login') }}" class="inline-flex items-center gap-2 px-7 py-3.5 bg-blue-600 text-white font-semibold rounded-xl hover:bg-blue-500 transition shadow-lg shadow-blue-600/20">
                    Start Free Trial
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                </a>
                <a href="#how-it-works" class="px-7 py-3.5 border border-white/10 text-white font-semibold rounded-xl hover:bg-white/5 transition">See How It Works</a>
            </div>
            <div class="flex flex-wrap justify-center gap-8 text-sm text-gray-500">
                @foreach(['No credit card required', 'Setup in under a day', 'Built for African & emerging markets'] as $trust)
                <span class="flex items-center gap-1.5">
                    <svg class="w-4 h-4 text-green-500 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/></svg>
                    {{ $trust }}
                </span>
                @endforeach
            </div>
        </div>

        {{-- Dashboard Preview --}}
        <div class="relative mx-auto max-w-4xl">
            <div class="absolute inset-0 bg-gradient-to-b from-transparent via-transparent to-gray-950 z-10 pointer-events-none" style="top:60%"></div>
            <div class="bg-gray-900 rounded-2xl border border-white/10 overflow-hidden shadow-2xl shadow-black/60">
                {{-- App header bar --}}
                <div class="flex items-center gap-2 px-4 py-3 bg-gray-800/50 border-b border-white/5">
                    <div class="w-3 h-3 rounded-full bg-red-500/70"></div>
                    <div class="w-3 h-3 rounded-full bg-yellow-500/70"></div>
                    <div class="w-3 h-3 rounded-full bg-green-500/70"></div>
                    <span class="ml-4 text-xs text-gray-500">flowcheck.site / dashboard</span>
                </div>
                <div class="p-6 grid grid-cols-3 gap-4">
                    {{-- PR Card --}}
                    <div class="col-span-2 bg-gray-800/60 rounded-xl p-5 border border-white/5">
                        <div class="flex items-center justify-between mb-4">
                            <span class="text-xs font-semibold text-gray-300">Purchase Request</span>
                            <span class="text-xs text-gray-500">PR-2025-0042</span>
                        </div>
                        <div class="flex items-center gap-3 mb-4">
                            <div class="w-9 h-9 bg-blue-600 rounded-full flex items-center justify-center text-xs font-bold">JO</div>
                            <div>
                                <div class="text-sm font-semibold text-white">James Okafor</div>
                                <div class="text-xs text-gray-400">Operations Team · Lusaka HQ</div>
                            </div>
                            <span class="ml-auto px-2.5 py-1 bg-yellow-500/10 text-yellow-400 text-xs font-semibold rounded-full border border-yellow-500/20">Pending Approval</span>
                        </div>
                        <div class="flex items-center gap-2 mb-4">
                            <div class="flex-1 h-1.5 bg-blue-600 rounded-full"></div>
                            <div class="flex-1 h-1.5 bg-gray-700 rounded-full"></div>
                            <div class="flex-1 h-1.5 bg-gray-700 rounded-full"></div>
                        </div>
                        <div class="flex gap-2 text-xs text-gray-400 mb-4">
                            <span class="text-blue-400 font-medium">① Manager Review</span>
                            <span>→ ② Finance</span>
                            <span>→ ③ Final Approval</span>
                        </div>
                        <div class="flex gap-2">
                            <button class="flex-1 py-2 bg-blue-600 text-white text-xs font-semibold rounded-lg">Approve</button>
                            <button class="flex-1 py-2 border border-gray-600 text-gray-300 text-xs font-semibold rounded-lg">Reject</button>
                        </div>
                    </div>
                    {{-- Stats --}}
                    <div class="flex flex-col gap-3">
                        <div class="bg-gray-800/60 rounded-xl p-4 border border-white/5">
                            <div class="text-xs text-gray-400 mb-1">Open PRs</div>
                            <div class="text-2xl font-bold text-white">34</div>
                            <div class="text-xs text-green-400 mt-1">+8 this week</div>
                        </div>
                        <div class="bg-gray-800/60 rounded-xl p-4 border border-white/5">
                            <div class="text-xs text-gray-400 mb-1">Budget Used</div>
                            <div class="text-2xl font-bold text-white">82%</div>
                            <div class="text-xs text-gray-500 mt-1">of monthly</div>
                        </div>
                        <div class="bg-gray-800/60 rounded-xl p-4 border border-white/5">
                            <div class="text-xs text-gray-400 mb-1">Avg. Approval</div>
                            <div class="text-2xl font-bold text-white">4h</div>
                            <div class="text-xs text-green-400 mt-1">↓ from 3 days</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- ── Trust Bar ── --}}
<section class="py-10 border-y border-white/5 bg-gray-900/30">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <p class="text-center text-xs text-gray-600 uppercase tracking-widest mb-6">Trusted across industries</p>
        <div class="flex flex-wrap justify-center gap-10">
            @foreach([
                ['Construction','M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-2 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4'],
                ['Manufacturing','M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z M15 12a3 3 0 11-6 0 3 3 0 016 0z'],
                ['Healthcare','M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z'],
                ['NGOs','M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z'],
                ['Government','M8 14v3m4-3v3m4-3v3M3 21h18M3 10h18M3 7l9-4 9 4M4 10h16v11H4V10z'],
                ['Retail','M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z'],
                ['Logistics','M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4'],
            ] as [$name, $path])
            <div class="flex flex-col items-center gap-2 text-gray-600 hover:text-gray-400 transition">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="{{ $path }}"/></svg>
                <span class="text-xs font-medium">{{ $name }}</span>
            </div>
            @endforeach
        </div>
    </div>
</section>

{{-- ── Problem Section ── --}}
<section class="py-24" id="features">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid lg:grid-cols-2 gap-16 items-start">
            <div>
                <span class="text-xs font-semibold text-blue-400 uppercase tracking-widest mb-4 block">The Problem</span>
                <h2 class="text-4xl font-black text-white leading-tight mb-6">
                    Procurement Breaks Down<br>Under Complexity
                </h2>
                <p class="text-gray-400 leading-relaxed mb-8">
                    For SMEs and institutions, procurement is often a patchwork of WhatsApp messages, spreadsheets, and verbal approvals. This creates delays, fraud risk, and total loss of visibility into where money goes.
                </p>
                <div class="space-y-4">
                    @foreach([
                        ['Approval Delays', 'Requests sit in inboxes for days. No one knows who to chase.'],
                        ['Zero Spend Visibility', 'Finance can\'t see committed spend until invoices arrive — too late.'],
                        ['Compliance Risk', 'No audit trail means no accountability when something goes wrong.'],
                        ['Vendor Disorganisation', 'Quotes from multiple vendors in email threads, impossible to compare.'],
                    ] as [$title, $desc])
                    <div class="flex gap-4 p-4 bg-gray-900/60 rounded-xl border border-white/5">
                        <div class="w-2 h-2 mt-2 rounded-full bg-red-500 flex-shrink-0"></div>
                        <div>
                            <div class="text-sm font-semibold text-white mb-0.5">{{ $title }}</div>
                            <div class="text-sm text-gray-400">{{ $desc }}</div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
            <div>
                <span class="text-xs font-semibold text-green-400 uppercase tracking-widest mb-4 block">The FlowCheck Difference</span>
                <h2 class="text-4xl font-black text-white leading-tight mb-6">
                    Structured. Tracked.<br>In Control.
                </h2>
                <p class="text-gray-400 leading-relaxed mb-8">
                    FlowCheck gives every team member a clear, structured way to request, approve, and track purchases — with full visibility for finance and management at every step.
                </p>
                <div class="space-y-4">
                    @foreach([
                        ['Instant Approval Workflows', 'Multi-step approvals routed automatically by department and spend threshold.'],
                        ['Real-Time Budget Tracking', 'See committed vs actual spend the moment a request is raised.'],
                        ['Full Audit Trail', 'Every action logged — who approved, when, and why.'],
                        ['Vendor Comparison Tools', 'Collect and compare quotes side-by-side in one place.'],
                    ] as [$title, $desc])
                    <div class="flex gap-4 p-4 bg-gray-900/60 rounded-xl border border-green-500/10">
                        <div class="w-2 h-2 mt-2 rounded-full bg-green-500 flex-shrink-0"></div>
                        <div>
                            <div class="text-sm font-semibold text-white mb-0.5">{{ $title }}</div>
                            <div class="text-sm text-gray-400">{{ $desc }}</div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</section>

{{-- ── How It Works ── --}}
<section class="py-24 bg-gray-900/40 border-y border-white/5" id="how-it-works">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16">
            <span class="text-xs font-semibold text-blue-400 uppercase tracking-widest mb-4 block">How FlowCheck Works</span>
            <h2 class="text-4xl font-black text-white mb-4">From Request to Delivery.<br>Every Step Tracked.</h2>
            <p class="text-gray-400 max-w-xl mx-auto">A single platform that handles every stage of your procurement cycle — no gaps, no confusion.</p>
        </div>
        <div class="relative">
            {{-- Connector line --}}
            <div class="hidden lg:block absolute top-10 left-[12%] right-[12%] h-px bg-gradient-to-r from-transparent via-blue-500/30 to-transparent"></div>
            <div class="grid lg:grid-cols-5 gap-6">
                @foreach([
                    ['01', 'Request', 'Any team member raises a purchase request with items, cost, and justification.', 'M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2'],
                    ['02', 'Review & Approve', 'Routed automatically to the right approvers — manager, finance, or executive.', 'M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z'],
                    ['03', 'Vendor & RFQ', 'Send RFQs to multiple vendors, collect quotes, and compare side-by-side.', 'M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z'],
                    ['04', 'Purchase Order', 'Auto-generate a PO once approved. Send directly to vendor from the platform.', 'M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z'],
                    ['05', 'Receive & Match', 'Goods received, GRN captured, invoice matched 3-way. Payment authorised.', 'M5 13l4 4L19 7'],
                ] as [$num, $title, $desc, $icon])
                <div class="relative flex flex-col items-center text-center p-6 bg-gray-900 rounded-2xl border border-white/5 card-glow transition">
                    <div class="w-12 h-12 bg-blue-600/10 border border-blue-500/20 rounded-xl flex items-center justify-center mb-4">
                        <svg class="w-5 h-5 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $icon }}"/></svg>
                    </div>
                    <div class="text-xs font-bold text-blue-500 mb-2">{{ $num }}</div>
                    <h3 class="text-sm font-bold text-white mb-2">{{ $title }}</h3>
                    <p class="text-xs text-gray-400 leading-relaxed">{{ $desc }}</p>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</section>

{{-- ── Impact Stats ── --}}
<section class="py-24" id="impact">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16">
            <span class="text-xs font-semibold text-blue-400 uppercase tracking-widest mb-4 block">Measurable Impact</span>
            <h2 class="text-4xl font-black text-white mb-4">What FlowCheck Delivers</h2>
            <p class="text-gray-400 max-w-xl mx-auto">Organisations using FlowCheck report significant improvements in procurement speed, compliance, and cost control.</p>
        </div>
        <div class="grid md:grid-cols-3 gap-6 mb-12">
            @foreach([
                ['10×', 'Faster Approvals', 'Average approval cycle drops from days to hours once workflows are configured.'],
                ['100%', 'Audit Coverage', 'Every request, approval, and change is logged — full accountability at all times.'],
                ['15–25%', 'Cost Savings', 'Competitive vendor quoting and budget controls reduce maverick spending.'],
            ] as [$stat, $label, $desc])
            <div class="stat-card border border-white/5 rounded-2xl p-8 text-center">
                <div class="text-5xl font-black gradient-text mb-2">{{ $stat }}</div>
                <div class="text-base font-bold text-white mb-3">{{ $label }}</div>
                <p class="text-sm text-gray-400 leading-relaxed">{{ $desc }}</p>
            </div>
            @endforeach
        </div>
        <div class="grid md:grid-cols-2 gap-6">
            @foreach([
                ['Built for Emerging Markets', 'FlowCheck is designed for the realities of African business — inconsistent vendor records, multi-currency needs, mobile-first users, and compliance with local procurement rules.'],
                ['No IT Department Required', 'Setup takes less than a day. Your team can configure workflows, add vendors, and start raising requests without any technical support.'],
            ] as [$title, $desc])
            <div class="p-8 bg-gray-900/60 rounded-2xl border border-white/5">
                <h3 class="text-lg font-bold text-white mb-3">{{ $title }}</h3>
                <p class="text-gray-400 leading-relaxed text-sm">{{ $desc }}</p>
            </div>
            @endforeach
        </div>
    </div>
</section>

{{-- ── Feature Grid ── --}}
<section class="py-24 bg-gray-900/40 border-y border-white/5">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16">
            <span class="text-xs font-semibold text-blue-400 uppercase tracking-widest mb-4 block">Everything You Need</span>
            <h2 class="text-4xl font-black text-white mb-4">Built for Complex Procurement</h2>
            <p class="text-gray-400 max-w-xl mx-auto">Whether you're a 10-person SME or a 500-person institution, FlowCheck handles your full procurement cycle.</p>
        </div>
        <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-5">
            @foreach([
                ['Purchase Requests', 'Structured digital request forms with item details, justification, and cost estimates.', 'M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2', 'blue'],
                ['Multi-Level Approvals', 'Custom approval chains by department, spend amount, or request type.', 'M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z', 'green'],
                ['RFQ & Vendor Quotes', 'Send requests for quotations to multiple vendors and compare responses.', 'M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z', 'purple'],
                ['Purchase Orders', 'Auto-generate and send POs to vendors once approved. Track delivery status.', 'M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z', 'orange'],
                ['Budget Management', 'Set budgets per department, track spend in real time, and flag overruns early.', 'M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z', 'cyan'],
                ['3-Way Invoice Matching', 'Match PO, GRN, and invoice automatically. Only pay what was ordered and received.', 'M9 14l6-6m-5.5.5h.01m4.99 5h.01M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16l3.5-2 3.5 2 3.5-2 3.5 2zM10 8.5a.5.5 0 11-1 0 .5.5 0 011 0zm5 5a.5.5 0 11-1 0 .5.5 0 011 0z', 'red'],
                ['Vendor Management', 'Central vendor database with performance history, compliance status, and contacts.', 'M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z', 'indigo'],
                ['Audit Trail & Reports', 'Full log of every action. Export reports for auditors, boards, or grant reporting.', 'M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z', 'yellow'],
                ['Contract Tracking', 'Store and track supplier contracts with expiry alerts and renewal reminders.', 'M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z', 'pink'],
            ] as [$title, $desc, $icon, $color])
            @php
            $colors = [
                'blue' => ['bg' => 'bg-blue-900/40', 'icon' => 'text-blue-400', 'border' => 'border-blue-500/10'],
                'green' => ['bg' => 'bg-green-900/40', 'icon' => 'text-green-400', 'border' => 'border-green-500/10'],
                'purple' => ['bg' => 'bg-purple-900/40', 'icon' => 'text-purple-400', 'border' => 'border-purple-500/10'],
                'orange' => ['bg' => 'bg-orange-900/40', 'icon' => 'text-orange-400', 'border' => 'border-orange-500/10'],
                'cyan' => ['bg' => 'bg-cyan-900/40', 'icon' => 'text-cyan-400', 'border' => 'border-cyan-500/10'],
                'red' => ['bg' => 'bg-red-900/40', 'icon' => 'text-red-400', 'border' => 'border-red-500/10'],
                'indigo' => ['bg' => 'bg-indigo-900/40', 'icon' => 'text-indigo-400', 'border' => 'border-indigo-500/10'],
                'yellow' => ['bg' => 'bg-yellow-900/40', 'icon' => 'text-yellow-400', 'border' => 'border-yellow-500/10'],
                'pink' => ['bg' => 'bg-pink-900/40', 'icon' => 'text-pink-400', 'border' => 'border-pink-500/10'],
            ];
            $c = $colors[$color];
            @endphp
            <div class="p-6 bg-gray-900 rounded-2xl border border-white/5 card-glow transition">
                <div class="w-10 h-10 {{ $c['bg'] }} rounded-xl flex items-center justify-center mb-4">
                    <svg class="w-5 h-5 {{ $c['icon'] }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $icon }}"/></svg>
                </div>
                <h3 class="text-sm font-bold text-white mb-2">{{ $title }}</h3>
                <p class="text-xs text-gray-400 leading-relaxed">{{ $desc }}</p>
            </div>
            @endforeach
        </div>
    </div>
</section>

{{-- ── FAQ ── --}}
<section class="py-24 bg-gray-900/40 border-y border-white/5">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <h2 class="text-4xl font-black text-white text-center mb-12">Frequently Asked Questions</h2>
        <div class="grid md:grid-cols-2 gap-4">
            @foreach([
                ['How long does setup take?','Most teams are live within one working day. Our onboarding flow guides you through importing vendors, configuring workflows, and inviting your team.'],
                ['Can approvals match our org structure?','Yes. FlowCheck supports multi-level, role-based approval chains — configurable per department, cost centre, or spend threshold.'],
                ['Do we need technical skills?','No. FlowCheck is built for operations and finance teams. No coding or IT support required.'],
                ['Is it suitable for NGOs and donor-funded projects?','Yes. FlowCheck\'s audit trail and reporting features are designed to meet donor compliance requirements.'],
                ['Is our data secure?','Bank-level encryption, role-based access, and a full audit trail keep your data safe. Hosted on secure cloud infrastructure.'],
                ['Can we upgrade or downgrade later?','Absolutely. Change your plan at any time from your organisation settings — no penalties.'],
            ] as $faq)
            <div class="bg-gray-900 rounded-xl border border-white/5 overflow-hidden" x-data="{ open: false }">
                <button class="w-full flex items-center justify-between p-5 text-left" @click="open = !open">
                    <span class="text-sm font-semibold text-white">{{ $faq[0] }}</span>
                    <svg class="w-5 h-5 text-gray-500 flex-shrink-0 transition-transform" :class="open ? 'rotate-90' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                </button>
                <div x-show="open" x-collapse class="px-5 pb-5">
                    <p class="text-sm text-gray-400 leading-relaxed">{{ $faq[1] }}</p>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

{{-- ── Final CTA ── --}}
<section class="py-24">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-gradient-to-br from-blue-600/10 via-gray-900 to-purple-600/10 border border-white/10 rounded-3xl p-12 text-center">
            <div class="w-16 h-16 bg-blue-600 rounded-2xl flex items-center justify-center mx-auto mb-8">
                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                </svg>
            </div>
            <h2 class="text-4xl font-black text-white mb-4">Ready to Bring Structure<br>to Your Procurement?</h2>
            <p class="text-gray-400 mb-10 leading-relaxed max-w-xl mx-auto">Join SMEs and institutions that have replaced spreadsheets and WhatsApp chains with a system that actually works.</p>
            <div class="flex flex-wrap justify-center gap-4 mb-8">
                <a href="{{ route('login') }}" class="px-8 py-4 bg-blue-600 text-white font-bold rounded-xl hover:bg-blue-500 transition shadow-lg shadow-blue-600/20">Start Free Trial</a>
                <a href="#" class="px-8 py-4 border border-white/10 text-white font-bold rounded-xl hover:bg-white/5 transition">Book a Demo</a>
            </div>
            <div class="flex flex-wrap justify-center gap-8 text-sm text-gray-500">
                @foreach(['No contracts','Cancel anytime','Your data stays secure'] as $t)
                <span class="flex items-center gap-2">
                    <svg class="w-4 h-4 text-green-400 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/></svg>
                    {{ $t }}
                </span>
                @endforeach
            </div>
        </div>
    </div>
</section>

{{-- ── Footer ── --}}
<footer class="border-t border-white/5 pt-16 pb-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-2 md:grid-cols-5 gap-10 mb-12">
            <div class="col-span-2 md:col-span-1">
                <div class="flex items-center gap-2 mb-4">
                    <div class="w-8 h-8 bg-blue-600 rounded-lg flex items-center justify-center">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"/></svg>
                    </div>
                    <span class="font-bold text-white">FlowCheck</span>
                </div>
                <p class="text-sm text-gray-500 mb-5 leading-relaxed">Procurement management built for SMEs & institutions.</p>
                <div class="flex gap-2">
                    @foreach(['in','tw','yt'] as $s)
                    <a href="#" class="w-8 h-8 bg-gray-800 rounded-lg flex items-center justify-center text-gray-500 hover:text-white hover:bg-gray-700 transition text-xs font-bold">{{ $s }}</a>
                    @endforeach
                </div>
            </div>
            @foreach([
                ['Product', ['Features','How It Works','Pricing','Changelog']],
                ['Resources', ['Help Center','Guides','Templates','API Docs']],
                ['Company', ['About Us','Careers','Blog','Contact']],
            ] as [$col, $links])
            <div>
                <h4 class="text-sm font-semibold text-white mb-4">{{ $col }}</h4>
                <ul class="space-y-3">
                    @foreach($links as $link)
                    <li><a href="#" class="text-sm text-gray-500 hover:text-white transition">{{ $link }}</a></li>
                    @endforeach
                </ul>
            </div>
            @endforeach
            <div>
                <h4 class="text-sm font-semibold text-white mb-4">Stay in the loop</h4>
                <p class="text-sm text-gray-500 mb-4 leading-relaxed">Procurement tips and product updates to your inbox.</p>
                <div class="flex gap-2">
                    <input type="email" placeholder="Enter your email" class="flex-1 px-3 py-2 bg-gray-800 border border-gray-700 rounded-lg text-sm text-white placeholder-gray-600 focus:outline-none focus:border-blue-500">
                    <button class="w-9 h-9 bg-blue-600 rounded-lg flex items-center justify-center hover:bg-blue-500 transition flex-shrink-0">
                        <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/></svg>
                    </button>
                </div>
            </div>
        </div>
        <div class="border-t border-white/5 pt-8 flex flex-col sm:flex-row items-center justify-between gap-4">
            <p class="text-sm text-gray-600">© 2025 FlowCheck. All rights reserved.</p>
            <div class="flex gap-6">
                <a href="#" class="text-sm text-gray-600 hover:text-white transition">Privacy Policy</a>
                <a href="#" class="text-sm text-gray-600 hover:text-white transition">Terms of Service</a>
            </div>
        </div>
    </div>
</footer>

</body>
</html>

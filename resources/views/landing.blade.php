<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FlowCheck — Procurement Management Platform</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700,800&display=swap" rel="stylesheet"/>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased text-gray-900 bg-white">

{{-- ── Navigation ── --}}
<nav class="fixed top-0 inset-x-0 z-50 bg-white border-b border-gray-100">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between h-16">
            <div class="flex items-center gap-2">
                <div class="w-8 h-8 bg-blue-600 rounded-lg flex items-center justify-center">
                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"/>
                    </svg>
                </div>
                <span class="text-xl font-bold text-gray-900">FlowCheck</span>
            </div>
            <div class="hidden md:flex items-center gap-8">
                <a href="#" class="text-sm text-gray-600 hover:text-gray-900 flex items-center gap-1">Product
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                </a>
                <a href="#how-it-works" class="text-sm text-gray-600 hover:text-gray-900">How It Works</a>
                <a href="#pricing" class="text-sm text-gray-600 hover:text-gray-900">Pricing</a>
                <a href="#" class="text-sm text-gray-600 hover:text-gray-900 flex items-center gap-1">Resources
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                </a>
                <a href="#" class="text-sm text-gray-600 hover:text-gray-900">About Us</a>
            </div>
            <div class="flex items-center gap-4">
                <a href="{{ route('login') }}" class="text-sm text-gray-600 hover:text-gray-900 font-medium">Sign In</a>
                <a href="{{ route('login') }}" class="px-4 py-2 bg-blue-600 text-white text-sm font-semibold rounded-lg hover:bg-blue-700 transition">Start Free Trial</a>
            </div>
        </div>
    </div>
</nav>

{{-- ── Hero ── --}}
<section class="pt-28 pb-20 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid lg:grid-cols-2 gap-16 items-center">
            {{-- Left copy --}}
            <div>
                <span class="inline-block px-3 py-1 bg-blue-50 text-blue-700 text-xs font-semibold rounded-full mb-6 border border-blue-100">Modern Procurement. Total Control.</span>
                <h1 class="text-5xl font-extrabold text-gray-900 leading-tight mb-6">
                    Streamline Procurement.<br>
                    <span class="text-blue-600">Control Spending.</span><br>
                    Scale With Confidence.
                </h1>
                <p class="text-lg text-gray-500 mb-8 leading-relaxed">
                    Replace spreadsheets, approval bottlenecks, and scattered vendor communication with one streamlined procurement platform.
                </p>
                <div class="flex flex-wrap gap-4 mb-8">
                    <a href="{{ route('login') }}" class="inline-flex items-center gap-2 px-6 py-3 bg-blue-600 text-white font-semibold rounded-lg hover:bg-blue-700 transition shadow-sm">
                        Start Free Trial
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                    </a>
                    <a href="#" class="px-6 py-3 border border-gray-300 text-gray-700 font-semibold rounded-lg hover:bg-gray-50 transition">Book a Demo</a>
                </div>
                <div class="flex flex-wrap gap-6 text-sm text-gray-500">
                    @foreach(['No credit card required', 'Setup in minutes', 'Enterprise-grade security'] as $trust)
                    <span class="flex items-center gap-1.5">
                        <svg class="w-4 h-4 text-green-500 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/></svg>
                        {{ $trust }}
                    </span>
                    @endforeach
                </div>
            </div>

            {{-- Right: UI Mockup --}}
            <div class="relative">
                {{-- Purchase Request Card --}}
                <div class="bg-white rounded-2xl shadow-xl border border-gray-100 p-6 mb-4">
                    <div class="flex items-center justify-between mb-4">
                        <span class="font-semibold text-gray-900 text-sm">Purchase Request</span>
                        <div class="flex items-center gap-3">
                            <span class="text-xs text-gray-400">PR-2025-0042</span>
                            <span class="text-gray-400 text-lg leading-none">···</span>
                        </div>
                    </div>
                    <div class="flex items-center gap-3 mb-5">
                        <div class="w-10 h-10 bg-blue-100 rounded-full flex items-center justify-center flex-shrink-0">
                            <span class="text-blue-600 font-bold text-xs">JO</span>
                        </div>
                        <div class="flex-1 min-w-0">
                            <div class="font-semibold text-sm text-gray-900">James Okafor</div>
                            <div class="text-xs text-gray-400">Operations Team</div>
                        </div>
                        <span class="px-2.5 py-1 bg-yellow-50 text-yellow-700 text-xs font-semibold rounded-full border border-yellow-200 whitespace-nowrap">Pending Approval</span>
                    </div>
                    <div class="grid grid-cols-2 gap-4 mb-5 text-sm">
                        <div>
                            <div class="text-xs text-gray-400 mb-0.5">Total Amount</div>
                            <div class="font-semibold text-gray-900">—</div>
                        </div>
                        <div>
                            <div class="text-xs text-gray-400 mb-0.5">Department</div>
                            <div class="font-semibold text-gray-900">Operations</div>
                        </div>
                    </div>
                    {{-- Steps --}}
                    <div class="flex items-center gap-2 mb-5">
                        <div class="flex flex-col items-center gap-1">
                            <div class="w-7 h-7 rounded-full bg-blue-600 flex items-center justify-center text-white text-xs font-bold">1</div>
                            <span class="text-xs text-blue-600 font-medium whitespace-nowrap">Manager Review</span>
                        </div>
                        <div class="flex-1 h-px bg-gray-200 mb-4"></div>
                        <div class="flex flex-col items-center gap-1">
                            <div class="w-7 h-7 rounded-full bg-gray-100 flex items-center justify-center text-gray-400 text-xs font-bold">2</div>
                            <span class="text-xs text-gray-400 whitespace-nowrap">Finance Review</span>
                        </div>
                        <div class="flex-1 h-px bg-gray-200 mb-4"></div>
                        <div class="flex flex-col items-center gap-1">
                            <div class="w-7 h-7 rounded-full bg-gray-100 flex items-center justify-center text-gray-400 text-xs font-bold">3</div>
                            <span class="text-xs text-gray-400 whitespace-nowrap">Final Approval</span>
                        </div>
                    </div>
                    <div class="flex gap-3">
                        <button class="flex-1 py-2 bg-blue-600 text-white text-sm font-semibold rounded-lg hover:bg-blue-700 transition">Approve</button>
                        <button class="flex-1 py-2 border border-gray-300 text-gray-600 text-sm font-semibold rounded-lg hover:bg-gray-50 transition">Reject</button>
                    </div>
                </div>
                {{-- Stats Row --}}
                <div class="grid grid-cols-3 gap-3">
                    <div class="bg-white rounded-xl border border-gray-100 shadow-sm p-4">
                        <div class="text-xs text-gray-400 mb-1">Open POs</div>
                        <div class="text-2xl font-bold text-gray-900">34</div>
                        <div class="text-xs text-green-500 mt-1 font-medium">+8 this week</div>
                    </div>
                    <div class="bg-white rounded-xl border border-gray-100 shadow-sm p-4">
                        <div class="text-xs text-gray-400 mb-2">Spend This Month</div>
                        <div class="flex items-center gap-2">
                            <svg class="w-10 h-10 flex-shrink-0" viewBox="0 0 36 36">
                                <circle cx="18" cy="18" r="14" fill="none" stroke="#e5e7eb" stroke-width="4"/>
                                <circle cx="18" cy="18" r="14" fill="none" stroke="#3b82f6" stroke-width="4"
                                    stroke-dasharray="72 88" stroke-dashoffset="22" stroke-linecap="round"/>
                            </svg>
                            <div>
                                <div class="text-lg font-bold text-gray-900 leading-none">82%</div>
                                <div class="text-xs text-gray-400">of budget</div>
                            </div>
                        </div>
                    </div>
                    <div class="bg-white rounded-xl border border-gray-100 shadow-sm p-4">
                        <div class="text-xs text-gray-400 mb-1">Invoice Matching</div>
                        <div class="text-2xl font-bold text-gray-900">12</div>
                        <div class="text-xs text-gray-400 mt-1">To review</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- ── Trust Bar ── --}}
<section class="py-10 border-y border-gray-100 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <p class="text-center text-sm text-gray-500 mb-6">Trusted by procurement and operations teams in every industry</p>
        <div class="flex flex-wrap justify-center gap-10">
            @foreach([
                ['Construction', 'M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-2 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4'],
                ['Manufacturing', 'M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z M15 12a3 3 0 11-6 0 3 3 0 016 0z'],
                ['Healthcare', 'M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z'],
                ['Retail', 'M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z'],
                ['Logistics', 'M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4'],
                ['NGOs', 'M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z'],
                ['Government', 'M8 14v3m4-3v3m4-3v3M3 21h18M3 10h18M3 7l9-4 9 4M4 10h16v11H4V10z'],
            ] as [$name, $path])
            <div class="flex flex-col items-center gap-2 text-gray-400 hover:text-gray-600 transition">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="{{ $path }}"/></svg>
                <span class="text-xs font-medium">{{ $name }}</span>
            </div>
            @endforeach
        </div>
    </div>
</section>

{{-- ── Problem Section (dark) ── --}}
<section class="py-20 bg-gray-900">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-14">
            <h2 class="text-3xl font-bold text-white mb-4">Procurement Shouldn't Live in Spreadsheets</h2>
            <p class="text-gray-400 max-w-2xl mx-auto">FlowCheck centralizes approvals, purchasing, vendors, and spend visibility into one streamlined workflow.</p>
        </div>
        <div class="grid md:grid-cols-3 gap-5">
            @foreach([
                ['title'=>'Approval Delays','desc'=>'Automated multi-step approval workflows.','color'=>'text-blue-400','bg'=>'bg-blue-900','path'=>'M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z'],
                ['title'=>'Poor Spend Visibility','desc'=>'Track purchasing and budgets in real time.','color'=>'text-green-400','bg'=>'bg-green-900','path'=>'M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z'],
                ['title'=>'Vendor Chaos','desc'=>'Centralized supplier records and history.','color'=>'text-purple-400','bg'=>'bg-purple-900','path'=>'M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z'],
                ['title'=>'Invoice Errors','desc'=>'3-way matching for invoices, POs, and goods received.','color'=>'text-orange-400','bg'=>'bg-orange-900','path'=>'M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z'],
                ['title'=>'Compliance Risks','desc'=>'Full audit trails for every approval and transaction.','color'=>'text-red-400','bg'=>'bg-red-900','path'=>'M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z'],
                ['title'=>'Scattered Communication','desc'=>'Keep requests, approvals, and vendor updates in one place.','color'=>'text-cyan-400','bg'=>'bg-cyan-900','path'=>'M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z'],
            ] as $f)
            <div class="bg-gray-800 rounded-xl p-6 flex gap-4 hover:bg-gray-750 transition">
                <div class="flex-shrink-0 w-10 h-10 {{ $f['bg'] }} bg-opacity-50 rounded-lg flex items-center justify-center">
                    <svg class="w-5 h-5 {{ $f['color'] }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $f['path'] }}"/>
                    </svg>
                </div>
                <div>
                    <h3 class="font-semibold text-white mb-1 text-sm">{{ $f['title'] }}</h3>
                    <p class="text-sm text-gray-400 leading-relaxed">{{ $f['desc'] }}</p>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

{{-- ── Pricing ── --}}
<section id="pricing" class="py-20 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-14">
            <h2 class="text-3xl font-bold text-gray-900 mb-4">Simple, Scalable Pricing</h2>
            <p class="text-gray-500">Choose the plan that fits your procurement workflow.</p>
        </div>
        <div class="grid md:grid-cols-3 gap-8 items-start">
            {{-- Starter --}}
            <div class="border border-gray-200 rounded-2xl p-8 hover:border-gray-300 transition">
                <h3 class="text-xl font-bold text-gray-900 mb-1">Starter</h3>
                <p class="text-sm text-gray-500 mb-8">For small teams getting organized.</p>
                <ul class="space-y-3 mb-10">
                    @foreach(['Up to 5 users','Purchase requests','Basic approval workflows','Vendor records','Email notifications','Audit history'] as $feat)
                    <li class="flex items-center gap-2 text-sm text-gray-600">
                        <svg class="w-4 h-4 text-green-500 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/></svg>
                        {{ $feat }}
                    </li>
                    @endforeach
                </ul>
                <a href="{{ route('login') }}" class="block w-full py-3 border border-gray-300 text-gray-700 font-semibold rounded-lg text-center hover:bg-gray-50 transition text-sm">Start Free Trial</a>
            </div>

            {{-- Growth (Most Popular) --}}
            <div class="border-2 border-blue-600 rounded-2xl p-8 relative shadow-lg">
                <div class="absolute -top-4 left-1/2 -translate-x-1/2 whitespace-nowrap">
                    <span class="px-4 py-1.5 bg-blue-600 text-white text-xs font-semibold rounded-full">Most Popular</span>
                </div>
                <h3 class="text-xl font-bold text-gray-900 mb-1">Growth</h3>
                <p class="text-sm text-blue-600 font-semibold mb-8">Everything in Starter, plus:</p>
                <ul class="space-y-3 mb-10">
                    @foreach(['Unlimited workflows','Budget controls','Invoice matching','Advanced analytics','Priority support','Custom approval chains','Vendor performance tracking'] as $feat)
                    <li class="flex items-center gap-2 text-sm text-gray-600">
                        <svg class="w-4 h-4 text-green-500 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/></svg>
                        {{ $feat }}
                    </li>
                    @endforeach
                </ul>
                <a href="{{ route('login') }}" class="block w-full py-3 bg-blue-600 text-white font-semibold rounded-lg text-center hover:bg-blue-700 transition text-sm">Start Free Trial</a>
            </div>

            {{-- Enterprise --}}
            <div class="border border-gray-200 rounded-2xl p-8 hover:border-gray-300 transition">
                <h3 class="text-xl font-bold text-gray-900 mb-1">Enterprise</h3>
                <p class="text-sm text-blue-600 font-semibold mb-8">Everything in Growth, plus:</p>
                <ul class="space-y-3 mb-10">
                    @foreach(['SSO & advanced permissions','ERP integrations','Multi-entity management','Dedicated onboarding','SLA support','API access','Custom compliance workflows','Advanced reporting'] as $feat)
                    <li class="flex items-center gap-2 text-sm text-gray-600">
                        <svg class="w-4 h-4 text-green-500 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/></svg>
                        {{ $feat }}
                    </li>
                    @endforeach
                </ul>
                <a href="#" class="block w-full py-3 border border-gray-300 text-gray-700 font-semibold rounded-lg text-center hover:bg-gray-50 transition text-sm">Contact Sales</a>
            </div>
        </div>
    </div>
</section>

{{-- ── FAQ ── --}}
<section class="py-20 bg-gray-50" x-data="{ open: null }">
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
        <h2 class="text-3xl font-bold text-gray-900 text-center mb-12">Frequently Asked Questions</h2>
        <div class="grid md:grid-cols-2 gap-4">
            @foreach([
                ['q'=>'How long does setup take?','a'=>'Most teams are up and running within a day. Our onboarding wizard guides you through importing vendors, configuring workflows, and inviting your team.'],
                ['q'=>'Can approvals match our company structure?','a'=>'Yes. FlowCheck supports multi-level, role-based approval chains — you can define different workflows per department or spend threshold.'],
                ['q'=>'Do we need technical skills?','a'=>'No. FlowCheck is designed for operations and finance teams. Setup requires no coding or IT support.'],
                ['q'=>'Can we integrate with existing tools?','a'=>'We offer integrations with accounting systems and ERPs. Our API also allows custom integrations with your existing stack.'],
                ['q'=>'Is our data secure?','a'=>'FlowCheck uses bank-level encryption, role-based access controls, and full audit trails to keep your procurement data secure.'],
                ['q'=>'Can we upgrade later?','a'=>'Absolutely. You can upgrade or downgrade your plan at any time from your organisation settings.'],
            ] as $i => $faq)
            <div class="bg-white rounded-xl border border-gray-200 overflow-hidden" x-data="{ open: false }">
                <button class="w-full flex items-center justify-between p-5 text-left" @click="open = !open">
                    <span class="text-sm font-semibold text-gray-900">{{ $faq['q'] }}</span>
                    <svg class="w-5 h-5 text-gray-400 flex-shrink-0 transition-transform" :class="open ? 'rotate-90' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                </button>
                <div x-show="open" x-collapse class="px-5 pb-5">
                    <p class="text-sm text-gray-500 leading-relaxed">{{ $faq['a'] }}</p>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

{{-- ── Final CTA ── --}}
<section class="py-20 bg-gray-900">
    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <div class="w-16 h-16 bg-blue-600 rounded-2xl flex items-center justify-center mx-auto mb-8">
            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
            </svg>
        </div>
        <h2 class="text-3xl font-bold text-white mb-4">Bring Structure to Procurement.</h2>
        <p class="text-gray-400 mb-10 leading-relaxed">Eliminate approval delays, improve visibility,<br>and control spending from one platform.</p>
        <div class="flex flex-wrap justify-center gap-4 mb-8">
            <a href="{{ route('login') }}" class="px-6 py-3 bg-blue-600 text-white font-semibold rounded-lg hover:bg-blue-700 transition">Start Free Trial</a>
            <a href="#" class="px-6 py-3 border border-gray-600 text-white font-semibold rounded-lg hover:bg-gray-800 transition">Book a Demo</a>
        </div>
        <div class="flex flex-wrap justify-center gap-8 text-sm text-gray-400">
            @foreach(['No contracts','Cancel anytime','Your data stays secure'] as $t)
            <span class="flex items-center gap-2">
                <svg class="w-4 h-4 text-green-400 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/></svg>
                {{ $t }}
            </span>
            @endforeach
        </div>
    </div>
</section>

{{-- ── Footer ── --}}
<footer class="bg-gray-900 border-t border-gray-800 pt-16 pb-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-2 md:grid-cols-5 gap-10 mb-12">
            <div class="col-span-2 md:col-span-1">
                <div class="flex items-center gap-2 mb-4">
                    <div class="w-8 h-8 bg-blue-600 rounded-lg flex items-center justify-center">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"/></svg>
                    </div>
                    <span class="font-bold text-white">FlowCheck</span>
                </div>
                <p class="text-sm text-gray-400 mb-5 leading-relaxed">Modern procurement management for growing teams.</p>
                <div class="flex gap-2">
                    @foreach(['in','tw','yt'] as $s)
                    <a href="#" class="w-8 h-8 bg-gray-800 rounded-lg flex items-center justify-center text-gray-400 hover:text-white hover:bg-gray-700 transition text-xs font-bold">{{ $s }}</a>
                    @endforeach
                </div>
            </div>
            @foreach([
                ['Product', ['Features','How It Works','Pricing','Updates']],
                ['Resources', ['Help Center','Guides','Templates','API Docs']],
                ['Company', ['About Us','Careers','Blog','Contact']],
            ] as [$col, $links])
            <div>
                <h4 class="text-sm font-semibold text-white mb-4">{{ $col }}</h4>
                <ul class="space-y-3">
                    @foreach($links as $link)
                    <li><a href="#" class="text-sm text-gray-400 hover:text-white transition">{{ $link }}</a></li>
                    @endforeach
                </ul>
            </div>
            @endforeach
            <div>
                <h4 class="text-sm font-semibold text-white mb-4">Stay in the loop</h4>
                <p class="text-sm text-gray-400 mb-4 leading-relaxed">Get procurement tips and product updates delivered to your inbox.</p>
                <div class="flex gap-2">
                    <input type="email" placeholder="Enter your email" class="flex-1 px-3 py-2 bg-gray-800 border border-gray-700 rounded-lg text-sm text-white placeholder-gray-500 focus:outline-none focus:border-blue-500">
                    <button class="w-9 h-9 bg-blue-600 rounded-lg flex items-center justify-center hover:bg-blue-700 transition flex-shrink-0">
                        <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/></svg>
                    </button>
                </div>
            </div>
        </div>
        <div class="border-t border-gray-800 pt-8 flex flex-col sm:flex-row items-center justify-between gap-4">
            <p class="text-sm text-gray-500">© 2025 FlowCheck. All rights reserved.</p>
            <div class="flex gap-6">
                <a href="#" class="text-sm text-gray-500 hover:text-white transition">Privacy Policy</a>
                <a href="#" class="text-sm text-gray-500 hover:text-white transition">Terms of Service</a>
            </div>
        </div>
    </div>
</footer>

</body>
</html>

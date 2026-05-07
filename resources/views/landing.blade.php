<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FlowCheck — Procurement Management Platform</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: { brand: '#1d4ed8' }
                }
            }
        }
    </script>
    <style>
        .gradient-hero { background: linear-gradient(135deg, #1e3a8a 0%, #1d4ed8 50%, #2563eb 100%); }
        .feature-card:hover { transform: translateY(-4px); transition: all 0.2s; }
    </style>
</head>
<body class="bg-white text-gray-900 antialiased">

    {{-- NAV --}}
    <nav class="fixed top-0 left-0 right-0 z-50 bg-white/95 backdrop-blur border-b border-gray-100">
        <div class="max-w-6xl mx-auto px-6 flex items-center justify-between h-16">
            <div class="flex items-center gap-2">
                <div class="w-8 h-8 bg-blue-700 rounded-lg flex items-center justify-center">
                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/></svg>
                </div>
                <span class="text-lg font-bold text-gray-900">FlowCheck</span>
            </div>
            <div class="hidden md:flex items-center gap-8 text-sm font-medium text-gray-600">
                <a href="#features" class="hover:text-blue-700">Features</a>
                <a href="#how-it-works" class="hover:text-blue-700">How It Works</a>
                <a href="#pricing" class="hover:text-blue-700">Pricing</a>
            </div>
            <div class="flex items-center gap-3">
                <a href="{{ route('login') }}" class="text-sm font-medium text-gray-600 hover:text-gray-900">Sign In</a>
                <a href="{{ route('login') }}" class="px-4 py-2 bg-blue-700 text-white text-sm font-medium rounded-lg hover:bg-blue-800">Get Started</a>
            </div>
        </div>
    </nav>

    {{-- HERO --}}
    <section class="gradient-hero pt-32 pb-24 px-6">
        <div class="max-w-6xl mx-auto text-center">
            <span class="inline-flex items-center gap-2 px-3 py-1 bg-blue-500/20 text-blue-100 text-xs font-medium rounded-full mb-6 border border-blue-400/30">
                <span class="w-1.5 h-1.5 bg-green-400 rounded-full"></span>
                ZPPA & SI 68 Compliant · Built for Zambian Organisations
            </span>
            <h1 class="text-4xl md:text-6xl font-bold text-white leading-tight mb-6">
                Streamline Procurement.<br>
                <span class="text-blue-300">Control Every Kwacha.</span>
            </h1>
            <p class="text-xl text-blue-100 max-w-2xl mx-auto mb-10">
                FlowCheck automates your entire procurement process — from purchase requests to vendor payments — with full audit trails and approval workflows.
            </p>
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <a href="{{ route('login') }}" class="px-8 py-4 bg-white text-blue-700 font-semibold rounded-xl hover:bg-blue-50 text-lg">
                    Start Free Trial
                </a>
                <a href="#how-it-works" class="px-8 py-4 border border-white/30 text-white font-semibold rounded-xl hover:bg-white/10 text-lg">
                    See How It Works
                </a>
            </div>
            <p class="text-blue-200 text-sm mt-6">No credit card required · Cancel anytime · Your data stays yours</p>
        </div>

        {{-- Hero UI mockup --}}
        <div class="max-w-4xl mx-auto mt-16">
            <div class="bg-white rounded-2xl shadow-2xl overflow-hidden border border-blue-100">
                <div class="bg-gray-50 border-b border-gray-200 px-4 py-3 flex items-center gap-2">
                    <div class="w-3 h-3 rounded-full bg-red-400"></div>
                    <div class="w-3 h-3 rounded-full bg-yellow-400"></div>
                    <div class="w-3 h-3 rounded-full bg-green-400"></div>
                    <span class="ml-4 text-xs text-gray-400">FlowCheck — Dashboard</span>
                </div>
                <div class="p-6 grid grid-cols-2 md:grid-cols-4 gap-4">
                    <div class="bg-blue-50 rounded-xl p-4 text-center">
                        <p class="text-2xl font-bold text-blue-700">ZMW 2.4M</p>
                        <p class="text-xs text-gray-500 mt-1">Total Spend YTD</p>
                    </div>
                    <div class="bg-amber-50 rounded-xl p-4 text-center">
                        <p class="text-2xl font-bold text-amber-600">12</p>
                        <p class="text-xs text-gray-500 mt-1">Pending Approvals</p>
                    </div>
                    <div class="bg-green-50 rounded-xl p-4 text-center">
                        <p class="text-2xl font-bold text-green-700">34</p>
                        <p class="text-xs text-gray-500 mt-1">Open POs</p>
                    </div>
                    <div class="bg-purple-50 rounded-xl p-4 text-center">
                        <p class="text-2xl font-bold text-purple-700">8</p>
                        <p class="text-xs text-gray-500 mt-1">Pending Invoices</p>
                    </div>
                </div>
                <div class="px-6 pb-6">
                    <div class="bg-gray-50 rounded-xl p-4 border border-gray-200">
                        <div class="flex items-center justify-between mb-3">
                            <span class="text-sm font-semibold text-gray-700">Recent Purchase Requests</span>
                            <span class="text-xs text-blue-700">View all</span>
                        </div>
                        @foreach([['PR-2025-00124','Office Supplies & Equipment','ZMW 45,000','under_review'],['PR-2025-00123','Site Safety Gear','ZMW 128,500','approved'],['PR-2025-00122','Concrete & Aggregates','ZMW 890,000','pending']] as $row)
                        <div class="flex items-center justify-between py-2 border-b border-gray-100 last:border-0">
                            <div>
                                <p class="text-xs font-medium text-gray-800">{{ $row[0] }} — {{ $row[1] }}</p>
                            </div>
                            <div class="flex items-center gap-3">
                                <span class="text-xs text-gray-500">{{ $row[2] }}</span>
                                <span class="text-xs px-2 py-0.5 rounded-full font-medium {{ $row[3]==='approved'?'bg-green-50 text-green-700':($row[3]==='under_review'?'bg-blue-50 text-blue-700':'bg-amber-50 text-amber-700') }}">
                                    {{ ucwords(str_replace('_',' ',$row[3])) }}
                                </span>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- LOGOS / TRUST --}}
    <section class="py-12 bg-gray-50 border-y border-gray-100">
        <div class="max-w-4xl mx-auto px-6 text-center">
            <p class="text-sm text-gray-400 font-medium uppercase tracking-widest mb-8">Trusted by procurement teams across Zambia</p>
            <div class="flex flex-wrap justify-center gap-8 text-gray-400 font-semibold text-sm">
                <span>Construction Companies</span>
                <span>·</span>
                <span>Government Agencies</span>
                <span>·</span>
                <span>NGOs & INGOs</span>
                <span>·</span>
                <span>Mining & Energy</span>
                <span>·</span>
                <span>Healthcare</span>
            </div>
        </div>
    </section>

    {{-- FEATURES --}}
    <section id="features" class="py-24 px-6">
        <div class="max-w-6xl mx-auto">
            <div class="text-center mb-16">
                <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">Everything Your Procurement Team Needs</h2>
                <p class="text-lg text-gray-500 max-w-xl mx-auto">One platform to manage the full procurement lifecycle — no spreadsheets, no lost approvals.</p>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                @foreach([
                    ['Purchase Requests','From raise to approval in minutes. Role-based workflows route each request to the right approvers automatically.','blue','M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4'],
                    ['Purchase Orders','Create POs directly from approved PRs or RFQs. PDF generation, vendor email, and full audit trail included.','green','M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z'],
                    ['Vendor Management','Maintain a verified vendor registry with ZPPA registration numbers, ratings, and performance history.','purple','M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z'],
                    ['3-Way Invoice Matching','Automatically match invoices against POs and GRNs with 5% tolerance. Flags discrepancies before payment.','amber','M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 11h.01M12 11h.01M15 11h.01M4 19h16a2 2 0 002-2V7a2 2 0 00-2-2H4a2 2 0 00-2 2v10a2 2 0 002 2z'],
                    ['BOQ & Tenders','Built for construction — ZPPA-compliant Bills of Quantities, tender management, and contractor bid evaluation.','red','M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-2 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4'],
                    ['Reports & Audit Trail','Every action logged. Export spend by department, vendor performance, invoice aging, and full audit reports to Excel.','indigo','M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z'],
                ] as $f)
                <div class="feature-card bg-white rounded-2xl border border-gray-200 p-6 hover:shadow-lg">
                    <div class="w-12 h-12 bg-{{ $f[2] }}-50 rounded-xl flex items-center justify-center mb-4">
                        <svg class="w-6 h-6 text-{{ $f[2] }}-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $f[3] }}"/></svg>
                    </div>
                    <h3 class="text-base font-semibold text-gray-900 mb-2">{{ $f[0] }}</h3>
                    <p class="text-sm text-gray-500 leading-relaxed">{{ $f[1] }}</p>
                </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- HOW IT WORKS --}}
    <section id="how-it-works" class="py-24 px-6 bg-gray-50">
        <div class="max-w-4xl mx-auto">
            <div class="text-center mb-16">
                <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">How FlowCheck Works</h2>
                <p class="text-lg text-gray-500">The full procurement cycle, automated.</p>
            </div>
            <div class="space-y-6">
                @foreach([
                    ['01','Raise a Purchase Request','A staff member submits a PR with items, quantities, and estimated cost. It routes automatically to their department head.'],
                    ['02','Multi-Step Approval','Configured workflows route the PR through the right approvers — department head, procurement manager, CFO — based on amount and department.'],
                    ['03','Issue RFQ or Create PO','Once approved, procurement issues an RFQ to shortlisted vendors or creates a PO directly. Vendors are notified automatically.'],
                    ['04','Receive Goods (GRN)','When goods arrive, the store keeper records a Goods Received Note against the PO. The system tracks partial and full receipts.'],
                    ['05','3-Way Invoice Match','Vendor invoices are matched against the PO and GRN automatically. Only matched invoices proceed to payment approval.'],
                    ['06','Pay & Close','CFO approves the payment. The full audit trail — every action, every change — is available for compliance reporting.'],
                ] as $step)
                <div class="flex gap-6 bg-white rounded-2xl p-6 border border-gray-200">
                    <div class="w-12 h-12 bg-blue-700 rounded-xl flex items-center justify-center text-white font-bold text-sm flex-shrink-0">{{ $step[0] }}</div>
                    <div>
                        <h3 class="font-semibold text-gray-900 mb-1">{{ $step[1] }}</h3>
                        <p class="text-sm text-gray-500">{{ $step[2] }}</p>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- PRICING --}}
    <section id="pricing" class="py-24 px-6">
        <div class="max-w-5xl mx-auto">
            <div class="text-center mb-16">
                <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">Simple, Transparent Pricing</h2>
                <p class="text-lg text-gray-500">All prices in Zambian Kwacha. No hidden fees.</p>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                @foreach([
                    ['Starter','ZMW 2,500','/month','For small teams getting started','gray',false,['Up to 5 users','Up to 10 vendors','Purchase Requests & POs','Basic approval workflows','Audit trail','Email notifications']],
                    ['Professional','ZMW 6,500','/month','For growing procurement teams','blue',true,['Up to 25 users','Unlimited vendors','All modules included','Custom approval workflows','BOQ & Tender management','Excel & PDF exports','Priority support']],
                    ['Enterprise','Custom','pricing','For large organisations','gray',false,['Unlimited users','Unlimited vendors','All Professional features','SSO integration','Dedicated account manager','Custom integrations (ZPPA, ZIPPS)','SLA guarantee']],
                ] as $plan)
                <div class="rounded-2xl border {{ $plan[5] ? 'border-blue-500 ring-2 ring-blue-200' : 'border-gray-200' }} p-8 relative">
                    @if($plan[5])
                    <div class="absolute -top-3 left-1/2 -translate-x-1/2 px-4 py-1 bg-blue-700 text-white text-xs font-semibold rounded-full">Most Popular</div>
                    @endif
                    <h3 class="text-lg font-bold text-gray-900 mb-1">{{ $plan[0] }}</h3>
                    <p class="text-sm text-gray-500 mb-4">{{ $plan[3] }}</p>
                    <div class="mb-6">
                        <span class="text-3xl font-bold text-gray-900">{{ $plan[1] }}</span>
                        <span class="text-gray-500 text-sm">{{ $plan[2] }}</span>
                    </div>
                    <ul class="space-y-3 mb-8">
                        @foreach($plan[6] as $feature)
                        <li class="flex items-center gap-2 text-sm text-gray-600">
                            <svg class="w-4 h-4 text-green-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                            {{ $feature }}
                        </li>
                        @endforeach
                    </ul>
                    <a href="{{ route('login') }}" class="block w-full py-3 text-center text-sm font-semibold rounded-xl {{ $plan[5] ? 'bg-blue-700 text-white hover:bg-blue-800' : 'border border-gray-300 text-gray-700 hover:bg-gray-50' }}">
                        {{ $plan[0] === 'Enterprise' ? 'Contact Sales' : 'Get Started' }}
                    </a>
                </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- CTA --}}
    <section class="py-24 px-6 gradient-hero">
        <div class="max-w-3xl mx-auto text-center">
            <h2 class="text-3xl md:text-4xl font-bold text-white mb-4">Ready to Take Control of Your Procurement?</h2>
            <p class="text-xl text-blue-100 mb-10">Stop relying on email chains and manual spreadsheets. FlowCheck gives your team structure, visibility, and compliance from day one.</p>
            <a href="{{ route('login') }}" class="inline-block px-10 py-4 bg-white text-blue-700 font-bold text-lg rounded-xl hover:bg-blue-50">
                Start Free Trial — No Credit Card
            </a>
        </div>
    </section>

    {{-- FOOTER --}}
    <footer class="bg-gray-900 text-gray-400 py-12 px-6">
        <div class="max-w-6xl mx-auto">
            <div class="flex flex-col md:flex-row justify-between items-start gap-8 mb-10">
                <div>
                    <div class="flex items-center gap-2 mb-3">
                        <div class="w-8 h-8 bg-blue-600 rounded-lg flex items-center justify-center">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/></svg>
                        </div>
                        <span class="text-white font-bold text-lg">FlowCheck</span>
                    </div>
                    <p class="text-sm max-w-xs">Procurement management built for Zambian organisations. ZPPA compliant. SI 68 ready.</p>
                </div>
                <div class="grid grid-cols-2 gap-8 text-sm">
                    <div>
                        <p class="text-white font-semibold mb-3">Product</p>
                        <ul class="space-y-2">
                            <li><a href="#features" class="hover:text-white">Features</a></li>
                            <li><a href="#pricing" class="hover:text-white">Pricing</a></li>
                            <li><a href="{{ route('login') }}" class="hover:text-white">Sign In</a></li>
                        </ul>
                    </div>
                    <div>
                        <p class="text-white font-semibold mb-3">Contact</p>
                        <ul class="space-y-2">
                            <li><a href="mailto:hello@flowcheck.ai" class="hover:text-white">hello@flowcheck.ai</a></li>
                            <li><a href="mailto:sales@flowcheck.ai" class="hover:text-white">sales@flowcheck.ai</a></li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="border-t border-gray-800 pt-6 flex flex-col md:flex-row justify-between items-center gap-2 text-xs">
                <p>&copy; {{ date('Y') }} FlowCheck. All rights reserved.</p>
                <p>SI 68 Compliant Procurement · Built in Zambia 🇿🇲</p>
            </div>
        </div>
    </footer>

</body>
</html>

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Dashboard
        </h2>
    </x-slot>

    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
        <!-- Stats Cards -->
        <div class="bg-white rounded-lg shadow p-6">
            <h3 class="text-gray-600 text-sm font-medium">Pending PRs</h3>
            <p class="text-3xl font-bold text-blue-600 mt-2">{{ $pendingPrs }}</p>
        </div>

        <div class="bg-white rounded-lg shadow p-6">
            <h3 class="text-gray-600 text-sm font-medium">Total Spend</h3>
            <p class="text-3xl font-bold text-green-600 mt-2">ZMW {{ number_format($totalSpend, 2) }}</p>
        </div>

        <div class="bg-white rounded-lg shadow p-6">
            <h3 class="text-gray-600 text-sm font-medium">Pending Invoices</h3>
            <p class="text-3xl font-bold text-yellow-600 mt-2">{{ $pendingInvoices }}</p>
        </div>

        <div class="bg-white rounded-lg shadow p-6">
            <h3 class="text-gray-600 text-sm font-medium">Approved Vendors</h3>
            <p class="text-3xl font-bold text-purple-600 mt-2">{{ $vendors }}</p>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- PR Status Chart -->
        <div class="bg-white rounded-lg shadow p-6">
            <h3 class="text-lg font-semibold text-gray-800 mb-4">PR Status Breakdown</h3>
            <canvas id="prStatusChart"></canvas>
        </div>

        <!-- Spend by Department -->
        <div class="bg-white rounded-lg shadow p-6">
            <h3 class="text-lg font-semibold text-gray-800 mb-4">Spend by Department</h3>
            <div class="space-y-4">
                @foreach($spendByDepartment as $dept)
                    <div>
                        <div class="flex justify-between mb-1">
                            <span class="text-sm font-medium text-gray-700">{{ $dept['name'] }}</span>
                            <span class="text-sm font-medium text-gray-700">ZMW {{ number_format($dept['spend'], 2) }}</span>
                        </div>
                        <div class="w-full bg-gray-200 rounded-full h-2">
                            <div class="bg-blue-600 h-2 rounded-full" style="width: {{ min(($dept['spend'] / $totalSpend * 100), 100) }}%"></div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    @push('scripts')
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <script>
            const ctx = document.getElementById('prStatusChart').getContext('2d');
            new Chart(ctx, {
                type: 'doughnut',
                data: {
                    labels: @json($prsByStatus->pluck('status')->toArray()),
                    datasets: [{
                        data: @json($prsByStatus->pluck('count')->toArray()),
                        backgroundColor: [
                            '#3b82f6',
                            '#10b981',
                            '#f59e0b',
                            '#ef4444',
                            '#6b7280',
                        ]
                    }]
                }
            });
        </script>
    @endpush
</x-app-layout>

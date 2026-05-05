<nav class="bg-white border-b border-gray-100">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <!-- Logo -->
                <div class="flex-shrink-0 flex items-center">
                    <a href="{{ route('app.dashboard') }}" class="text-2xl font-bold text-blue-600">
                        FlowCheck
                    </a>
                </div>

                <!-- Navigation Links -->
                <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
                    <a href="{{ route('app.dashboard') }}" class="inline-flex items-center px-1 pt-1 border-b-2 border-blue-600 text-sm font-medium leading-5 text-blue-700">
                        Dashboard
                    </a>
                    <a href="{{ route('purchase-requests.index') }}" class="inline-flex items-center px-1 pt-1 border-b-2 border-transparent text-sm font-medium leading-5 text-gray-600 hover:text-gray-800 hover:border-gray-300 transition">
                        Purchase Requests
                    </a>
                    <a href="{{ route('vendors.index') }}" class="inline-flex items-center px-1 pt-1 border-b-2 border-transparent text-sm font-medium leading-5 text-gray-600 hover:text-gray-800 hover:border-gray-300 transition">
                        Vendors
                    </a>
                    <a href="{{ route('invoices.index') }}" class="inline-flex items-center px-1 pt-1 border-b-2 border-transparent text-sm font-medium leading-5 text-gray-600 hover:text-gray-800 hover:border-gray-300 transition">
                        Invoices
                    </a>
                </div>
            </div>

            <!-- Settings Dropdown -->
            <div class="hidden sm:flex sm:items-center sm:ml-6">
                <div class="ml-3 relative">
                    <div class="font-medium text-sm text-gray-700">
                        {{ Auth::user()->name }}
                    </div>
                    <form method="POST" action="{{ route('logout') }}" class="mt-2">
                        @csrf
                        <button type="submit" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                            Sign Out
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</nav>

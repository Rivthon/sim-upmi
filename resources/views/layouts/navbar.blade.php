<nav class="bg-white border-b shadow-sm">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16 items-center">
            <!-- Logo -->
            <div class="flex-shrink-0">
                <a href="{{ url('/') }}" class="text-xl font-bold text-indigo-600">SIM UPMI</a>
            </div>

            <!-- Desktop Menu -->
            <div class="hidden md:flex space-x-6 items-center">
                <a href="{{ route('admin.dashboard') }}" class="text-gray-700 hover:text-indigo-600">Dashboard</a>
                {{-- Tambah menu lain jika perlu --}}
                <span class="text-sm text-gray-600">{{ Auth::user()->name }}</span>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button class="text-sm text-red-600 hover:underline">Logout</button>
                </form>
            </div>

            <!-- Mobile Menu Button -->
            <div class="md:hidden">
                <button id="menu-toggle" class="text-gray-700 focus:outline-none">
                    <!-- Icon -->
                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                </button>
            </div>
        </div>

        <!-- Mobile Menu Dropdown -->
        <div id="mobile-menu" class="hidden md:hidden mt-2 space-y-2 pb-4 border-t pt-2">
            <a href="{{ route('dashboard.upmi') }}" class="block text-gray-700 hover:text-indigo-600">Dashboard</a>
            <span class="block text-sm text-gray-600">{{ Auth::user()->name }}</span>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button class="block text-sm text-red-600 hover:underline">Logout</button>
            </form>
        </div>
    </div>
</nav>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        const toggleBtn = document.getElementById("menu-toggle");
        const mobileMenu = document.getElementById("mobile-menu");

        toggleBtn.addEventListener("click", () => {
            mobileMenu.classList.toggle("hidden");
        });
    });
</script>

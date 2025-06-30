<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SIM UPMI | Dashboard User</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        /* Optional: Custom scrollbar styling for a cleaner look */
        ::-webkit-scrollbar {
            width: 8px;
            height: 8px;
        }
        ::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 10px;
        }
        ::-webkit-scrollbar-thumb {
            background: #cbd5e1; /* gray-400 */
            border-radius: 10px;
        }
        ::-webkit-scrollbar-thumb:hover {
            background: #a0aec0; /* gray-500 */
        }
    </style>
<link rel="stylesheet" href="https://unpkg.com/trix@2.0.0/dist/trix.css">

<script src="https://unpkg.com/trix@2.0.0/dist/trix.umd.min.js"></script>
</head>
<body class="bg-gray-100 font-sans antialiased">

{{-- Main Layout Container --}}
<div x-data="{ sidebarOpen: window.innerWidth >= 768 }" class="flex min-h-screen">

    {{-- Sidebar --}}
    <div x-cloak
         :class="{ 'sidebar-mobile-open': sidebarOpen, 'sidebar-mobile-closed': !sidebarOpen }"
         class="fixed inset-y-0 left-0 bg-white border-r border-gray-200 w-64 flex flex-col z-40 {{-- Increased z-index for sidebar --}}
                transform transition-transform duration-300 ease-in-out md:static md:translate-x-0 md:shadow-none">
        
        {{-- Sidebar Header with Close Button for Mobile --}}
        <div class="flex items-center justify-between p-5 border-b border-gray-200">
            <div class="text-2xl font-extrabold text-blue-600">
                UPMI User
            </div>
            {{-- Close button for mobile sidebar (only visible on mobile, positioned inside sidebar header) --}}
            <button @click="sidebarOpen = false" class="md:hidden text-gray-500 hover:text-gray-700 focus:outline-none p-1 rounded-md transition-colors">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
            </button>
        </div>

        {{-- Sidebar Navigation --}}
        <nav class="flex-1 p-4 space-y-2 overflow-y-auto">
            {{-- Dashboard --}}
            <a href="{{ route('user.dashboard') }}"
               class="flex items-center px-4 py-2 rounded-lg text-base font-medium
                      {{ request()->routeIs('user.dashboard') ? 'bg-blue-500 text-white shadow-md' : 'text-gray-700 hover:bg-gray-100 hover:text-blue-600' }}
                      transition duration-200 ease-in-out">
                <svg class="w-5 h-5 mr-3" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z"></path></svg>
                Dashboard
            </a>

            {{-- Upload Dokumen --}}


            {{-- Mengisi Survey --}}
            <a href="{{ route('user.survey.index') }}" {{-- Asumsi rute untuk daftar survey yang bisa diisi user --}}
               class="flex items-center px-4 py-2 rounded-lg text-base font-medium
                      {{ request()->routeIs('user.survey.*') ? 'bg-blue-500 text-white shadow-md' : 'text-gray-700 hover:bg-gray-100 hover:text-blue-600' }}
                      transition duration-200 ease-in-out">
                <svg class="w-5 h-5 mr-3" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm-1-12a1 1 0 10-2 0v4a1 1 0 00.293.707L7.5 11.586l.707.707A1 1 0 009 12.586l2.293-2.293A1 1 0 0012.586 9l-.707-.707a1 1 0 00-1.414 0L10 9.586V7a1 1 0 10-2 0z" clip-rule="evenodd"></path></svg>
                Mengisi Survey
            </a>
                        {{-- Upload Dokumen --}}
            <a href="{{ route('user.dokumen.index') }}" {{-- Asumsi rute untuk upload dokumen oleh user --}}
               class="flex items-center px-4 py-2 rounded-lg text-base font-medium
                      {{ request()->routeIs('user.dokumen.*') ? 'bg-blue-500 text-white shadow-md' : 'text-gray-700 hover:bg-gray-100 hover:text-blue-600' }}
                      transition duration-200 ease-in-out">
                <svg class="w-5 h-5 mr-3" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M3 17a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm3.293-7.707a1 1 0 011.414 0L9 10.586V3a1 1 0 112 0v7.586l1.293-1.293a1 1 0 111.414 1.414l-3 3a1 1 0 01-1.414 0l-3-3a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
                Upload Dokumen
            </a>
        </nav>

        {{-- Logout Button --}}
        <div class="p-4 border-t border-gray-200 mt-auto">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit"
                        class="w-full flex items-center justify-center px-4 py-2 text-red-600 bg-red-50 hover:bg-red-100 rounded-lg font-semibold
                               transition duration-200 ease-in-out transform hover:scale-95 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                    Keluar
                </button>
            </form>
        </div>
    </div>

    {{-- Main Content Area --}}
    <div class="flex-1 flex flex-col overflow-hidden"> {{-- Hapus ml-64/ml-0 dari sini --}}
        <header class="bg-white shadow-sm px-6 py-4 flex items-center justify-between border-b border-gray-200 z-10">
            {{-- Tombol Toggle Sidebar --}}
            <div class="flex items-center">
                <button @click="sidebarOpen = !sidebarOpen" class="text-gray-600 focus:outline-none focus:ring-2 focus:ring-blue-500 rounded-md p-1 transition-all duration-200 hover:bg-gray-100 mr-4">
                    <svg class="w-7 h-7" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" stroke-linecap="round" stroke-linejoin="round">
                        <path x-show="!sidebarOpen" d="M4 6h16M4 12h16M4 18h16"/>
                        <path x-show="sidebarOpen" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
                <h1 class="text-2xl font-bold text-gray-800">Dashboard User</h1>
            </div>

            {{-- User Info & Dropdown --}}
            <div class="relative" x-data="{ dropdownOpen: false }">
                <div class="flex items-center space-x-3 cursor-pointer" @click="dropdownOpen = !dropdownOpen">
                    <span class="text-md font-medium text-gray-700 hidden sm:block">{{ Auth::user()->name ?? 'Pengguna' }}</span>
                    <img class="h-9 w-9 rounded-full object-cover border-2 border-blue-400" src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name ?? 'P A') }}&background=3182CE&color=ffffff&size=128" alt="User Avatar">
                    <svg class="w-4 h-4 text-gray-500 transform transition-transform" :class="{ 'rotate-180': dropdownOpen }" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                </div>

                {{-- Dropdown Menu --}}
                <div x-show="dropdownOpen" @click.away="dropdownOpen = false" x-transition:enter="transition ease-out duration-100" x-transition:enter-start="transform opacity-0 scale-95" x-transition:enter-end="transform opacity-100 scale-100" x-transition:leave="transition ease-in duration-75" x-transition:leave-start="transform opacity-100 scale-100" x-transition:leave-end="transform opacity-0 scale-95" class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg py-1 z-20">
                    <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Profil</a>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-gray-100">
                            Keluar
                        </button>
                    </form>
                </div>
            </div>
        </header>

        <main class="flex-1 p-6 bg-gray-100 overflow-y-auto">
            @yield('content')
        </main>

        {{-- Footer --}}
        <footer class="bg-white border-t border-gray-200 p-4 text-center text-gray-600 text-sm shadow-inner">
            &copy; 2025 SIM UPMI. All rights reserved.
        </footer>
    </div>
</div>

<script>
    // Adjust sidebar state on resize
    window.addEventListener('resize', () => {
        const sidebarState = document.querySelector('[x-data]').__x.$data.sidebarOpen;
        if (window.innerWidth >= 768) {
            if (!sidebarState) {
                document.querySelector('[x-data]').__x.$data.sidebarOpen = true; // Force open on desktop if closed
            }
        } else {
            // No automatic change on mobile resize, user needs to manually close it
            // or if desktop was shrunk, it will become fixed and closed by default
        }
    });

    // Ensure initial state is correct on load for mobile
    document.addEventListener('DOMContentLoaded', () => {
        if (window.innerWidth < 768) {
            document.querySelector('[x-data]').__x.$data.sidebarOpen = false; // Ensure closed on mobile load
        }
    });
</script>
@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const unitSelect = document.getElementById('unit');
    const subUnitWrapper = document.getElementById('sub-unit-wrapper');

    console.log("Script loaded");

    if (!unitSelect) {
        console.error("Element #unit not found");
        return;
    }

    unitSelect.addEventListener('change', function () {
        console.log("Selected:", this.value);
        if (this.value === 'Tendik') {
            subUnitWrapper.classList.remove('hidden');
        } else {
            subUnitWrapper.classList.add('hidden');
            document.getElementById('sub_unit').value = '';
        }
    });

    // Trigger on load
    if (unitSelect.value === 'Tendik') {
        subUnitWrapper.classList.remove('hidden');
    }
});
</script>
@endpush
<script src="https://cdn.ckeditor.com/ckeditor5/39.0.1/classic/ckeditor.js"></script>
<script>
    ClassicEditor
        .create( document.querySelector( '#narasi' ) )
        .catch( error => {
            console.error( error );
        } );
</script>
    @stack('scripts')
</body>
</html>
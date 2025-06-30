<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'UPMI STIKes Bogor Husada' }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;700;800&family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <style>
        /* Custom Font Definitions */
        @layer base {
            html {
                scroll-behavior: smooth; /* Smooth scroll for anchor links */
            }
            body {
                font-family: 'Poppins', sans-serif;
            }
            h1, h2, h3, h4, h5, h6 { /* Added h6 for completeness */
                font-family: 'Montserrat', sans-serif;
            }
        }

        /* You can define more animations here if needed,
           like fadeIn, slideInUp, pulseEffect from welcome page */
    </style>
</head>
<body class="bg-gray-50 text-gray-800 antialiased min-h-screen flex flex-col">

    {{-- Navbar --}}
    <header class="bg-white shadow-md sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-6 py-4 flex justify-between items-center">
            <div class="flex items-center space-x-3">
                <img src="https://www.sbh.ac.id/dashboard_assets/assets/img/logo/logo_sbh_panjang.png" alt="Logo STIKes" class="h-10 w-auto">
                <div>
                    <h1 class="text-xl md:text-2xl font-extrabold text-blue-700">UPMI</h1>
                    </div>
            </div>
            <nav class="hidden md:flex items-center space-x-8 text-lg font-medium"> {{-- Increased font size to lg --}}
                <a href="/" class="text-gray-700 hover:text-blue-600 transition duration-300">Beranda</a>
                
                {{-- Dropdown "Tentang" --}}
                <div x-data="{ open: false }" @click.away="open = false" class="relative">
                    <button @click="open = !open" class="flex items-center text-gray-700 hover:text-blue-600 transition duration-300 focus:outline-none">
                        Tentang UPMI
                        <svg class="w-4 h-4 ml-1 transform transition-transform duration-200" :class="{ 'rotate-180': open }" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                    </button>
                    <div x-show="open" x-transition:enter="transition ease-out duration-100" x-transition:enter-start="transform opacity-0 scale-95" x-transition:enter-end="transform opacity-100 scale-100" x-transition:leave="transition ease-in duration-75" x-transition:leave-start="transform opacity-100 scale-100" x-transition:leave-end="transform opacity-0 scale-95" class="absolute left-1/2 -translate-x-1/2 mt-3 w-48 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5 z-20">
                        <div class="py-1" role="menu" aria-orientation="vertical" aria-labelledby="options-menu">
                            <a href="/#tentang-profil" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 hover:text-blue-600 transition duration-300" role="menuitem">Profil</a>
                            <a href="/#tentang-visimisi" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 hover:text-blue-600 transition duration-300" role="menuitem">Visi Misi</a>
                            <a href="/#tentang-struktur" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 hover:text-blue-600 transition duration-300" role="menuitem">Struktur Organisasi</a>
                        </div>
                    </div>
                </div>

                <a href="/dokumen-publik" class="text-gray-700 hover:text-blue-600 transition duration-300">Dokumen</a>
                <a href="/berita-publik" class="text-gray-700 hover:text-blue-600 transition duration-300">Berita</a> {{-- Added Berita Link --}}
                <a href="/#kontak" class="text-gray-700 hover:text-blue-600 transition duration-300">Kontak</a>
            </nav>
            {{-- Tombol Login untuk Desktop --}}
            <a href="/login" class="hidden md:inline-flex items-center bg-blue-600 hover:bg-blue-700 text-white px-5 py-2.5 rounded-lg font-semibold shadow-md transition duration-300 ease-in-out transform hover:-translate-y-1">
                <svg class="inline-block w-5 h-5 mr-1 -mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"></path></svg>
                Login Admin
            </a>
            
            {{-- Hamburger menu for mobile --}}
            <button class="md:hidden text-gray-600 hover:text-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500 rounded-md p-2"
                    @click="mobileMenuOpen = true" x-data="{ mobileMenuOpen: false }">
                <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path></svg>
            </button>
        </div>

        {{-- Mobile Menu --}}
        <div x-show="mobileMenuOpen"
             @click.away="mobileMenuOpen = false"
             x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 -translate-y-4" x-transition:enter-end="opacity-100 translate-y-0"
             x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100 translate-y-0" x-transition:leave-end="opacity-0 -translate-y-4"
             class="md:hidden bg-white shadow-lg py-4 border-t border-gray-200 absolute w-full left-0 z-40">
            <nav class="flex flex-col space-y-2 px-6 text-base font-medium">
                <a href="/" @click="mobileMenuOpen = false" class="block py-2 text-gray-700 hover:bg-gray-100 hover:text-blue-600 transition duration-300 rounded-md">Beranda</a>
                
                {{-- Mobile Dropdown "Tentang" --}}
                <div x-data="{ subOpen: false }" class="relative">
                    <button @click="subOpen = !subOpen" class="flex items-center justify-between w-full py-2 text-gray-700 hover:bg-gray-100 hover:text-blue-600 transition duration-300 rounded-md focus:outline-none">
                        Tentang UPMI
                        <svg class="w-4 h-4 transform transition-transform duration-200" :class="{ 'rotate-180': subOpen }" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                    </button>
                    <div x-show="subOpen" x-transition:enter="transition ease-out duration-100" x-transition:enter-start="transform opacity-0 scale-95" x-transition:enter-end="transform opacity-100 scale-100" x-transition:leave="transition ease-in duration-75" x-transition:leave-start="transform opacity-100 scale-100" x-transition:leave-end="transform opacity-0 scale-95" class="py-1 pl-4 space-y-1">
                        <a href="/#tentang-profil" @click="mobileMenuOpen = false; subOpen = false;" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 hover:text-blue-600 transition duration-300 rounded-md">Profil</a>
                        <a href="/#tentang-visimisi" @click="mobileMenuOpen = false; subOpen = false;" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 hover:text-blue-600 transition duration-300 rounded-md">Visi Misi</a>
                        <a href="/#tentang-struktur" @click="mobileMenuOpen = false; subOpen = false;" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 hover:text-blue-600 transition duration-300 rounded-md">Struktur Organisasi</a>
                    </div>
                </div>

                <a href="/dokumen-publik" @click="mobileMenuOpen = false" class="block py-2 text-gray-700 hover:bg-gray-100 hover:text-blue-600 transition duration-300 rounded-md">Dokumen</a>
                <a href="/berita-publik" @click="mobileMenuOpen = false" class="block py-2 text-gray-700 hover:bg-gray-100 hover:text-blue-600 transition duration-300 rounded-md">Berita</a> {{-- Added Berita Link --}}
                <a href="/#kontak" @click="mobileMenuOpen = false" class="block py-2 text-gray-700 hover:bg-gray-100 hover:text-blue-600 transition duration-300 rounded-md">Kontak</a>
                <a href="/login" @click="mobileMenuOpen = false" class="block py-2 text-blue-600 hover:bg-blue-50 transition duration-300 rounded-md mt-2 border-t border-gray-200 pt-3">Login Admin</a>
            </nav>
        </div>
    </header>

    {{-- Konten --}}
    <main class="flex-1 py-12 px-4 md:px-6"> {{-- flex-1 to push footer to bottom --}}
        @yield('content')
    </main>

    {{-- Footer --}}
    <footer class="bg-gray-800 text-white py-6 text-center text-sm">
        <div class="max-w-7xl mx-auto px-6"> {{-- Added max-w and px for consistency --}}
            <p>&copy; {{ date('Y') }} UPMI STIKes Bogor Husada. Hak Cipta Dilindungi.</p>
            <p class="mt-1 text-gray-400">Dikelola oleh Tim ICT.</p>
        </div>
    </footer>

    <script>
        // Smooth scroll for dropdown links in mobile menu
        // (This JS is more relevant for the main welcome page,
        // but here it's just a placeholder for consistency)
        document.querySelectorAll('a[href^="/#tentang-"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                // Check if the current path is '/' before attempting to scroll
                if (window.location.pathname === '/') {
                    e.preventDefault();
                    document.querySelector(this.getAttribute('href').substring(1)).scrollIntoView({ // Remove '/'
                        behavior: 'smooth'
                    });
                } else {
                    // Allow default navigation to the root then anchor
                    // The #anchor will be handled by the browser naturally
                }

                // Close the dropdown after clicking a link (Alpine.js handles mobile menu)
                const dropdown = this.closest('[x-data="{ open: false }"]'); // Desktop dropdown
                if (dropdown && dropdown.__x) { // Check if Alpine.js is initialized
                    dropdown.__x.$data.open = false;
                }
                const mobileDropdown = this.closest('[x-data="{ subOpen: false }"]'); // Mobile dropdown
                if (mobileDropdown && mobileDropdown.__x) {
                    mobileDropdown.__x.$data.subOpen = false;
                    const topMenu = mobileDropdown.closest('[x-data="{ mobileMenuOpen: false }"]');
                    if (topMenu && topMenu.__x) {
                        topMenu.__x.$data.mobileMenuOpen = false;
                    }
                }
            });
        });
    </script>
</body>
</html>
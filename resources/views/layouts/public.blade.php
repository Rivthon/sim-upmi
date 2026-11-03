<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'UPMI STIKes Bogor Husada')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        html { scroll-behavior: smooth; }
        body { font-family: 'Inter', sans-serif; }
        .glass {
            background: rgba(255, 255, 255, 0.72);
            border: 1px solid rgba(255, 255, 255, 0.78);
            box-shadow: 0 16px 48px rgba(15, 23, 42, 0.10);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
        }
        .glass-dark {
            background: rgba(15, 23, 42, 0.72);
            border: 1px solid rgba(255, 255, 255, 0.16);
            box-shadow: 0 18px 54px rgba(2, 6, 23, 0.24);
            backdrop-filter: blur(14px);
            -webkit-backdrop-filter: blur(14px);
        }
        @media (max-width: 768px) {
            .glass, .glass-dark {
                backdrop-filter: blur(8px);
                -webkit-backdrop-filter: blur(8px);
                box-shadow: 0 12px 32px rgba(15, 23, 42, 0.08);
            }
        }
    </style>
</head>
<body class="min-h-screen bg-[#eef6f8] text-slate-800 antialiased">
    <div class="fixed inset-0 -z-10">
        <div class="absolute inset-0 bg-[linear-gradient(115deg,#f8fafc_0%,#e0f2fe_42%,#ecfeff_100%)]"></div>
        <div class="absolute inset-0 bg-[radial-gradient(circle_at_15%_10%,rgba(20,184,166,.24),transparent_28%),radial-gradient(circle_at_82%_18%,rgba(59,130,246,.22),transparent_26%),radial-gradient(circle_at_50%_88%,rgba(244,114,182,.12),transparent_28%)]"></div>
    </div>

    <header x-data="{ open: false }" class="sticky top-0 z-50 px-4 py-4">
        <div class="glass mx-auto flex max-w-7xl items-center justify-between rounded-2xl px-5 py-3">
            <a href="{{ route('home') }}" class="flex items-center gap-3">
                <span class="flex h-12 w-12 items-center justify-center rounded-2xl bg-white/80 ring-1 ring-white/80">
                    <img src="{{ asset('path/logo.png') }}" alt="Logo STIKes Bogor Husada" class="h-9 w-9 object-contain">
                </span>
                <span>
                    <span class="block text-lg font-extrabold tracking-wide text-slate-950">UPMI</span>
                    <span class="block text-xs font-semibold uppercase tracking-[0.18em] text-teal-700">STIKes Bogor Husada</span>
                </span>
            </a>

            <nav class="hidden items-center gap-7 text-sm font-semibold text-slate-700 md:flex">
                <a href="{{ route('home') }}" class="hover:text-teal-700">Beranda</a>
                <a href="{{ route('home') }}#tentang" class="hover:text-teal-700">Tentang</a>
                <a href="{{ route('dokumen.publik.index') }}" class="hover:text-teal-700">Dokumen</a>
                <a href="{{ route('berita.publik.index') }}" class="hover:text-teal-700">Berita</a>
                <a href="{{ route('home') }}#kontak" class="hover:text-teal-700">Kontak</a>
            </nav>

            <a href="{{ route('login') }}" class="hidden rounded-full bg-slate-950 px-5 py-2.5 text-sm font-bold text-white shadow-lg shadow-slate-900/20 hover:bg-teal-700 md:inline-flex">
                Login
            </a>

            <button type="button" @click="open = !open" class="rounded-xl bg-white/70 p-2 text-slate-800 ring-1 ring-white/80 md:hidden">
                <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 7h16M4 12h16M4 17h16"/>
                </svg>
            </button>
        </div>

        <div x-show="open" x-transition class="glass mx-auto mt-3 max-w-7xl rounded-2xl p-4 md:hidden">
            <nav class="grid gap-2 text-sm font-semibold text-slate-700">
                <a @click="open = false" href="{{ route('home') }}" class="rounded-xl px-3 py-2 hover:bg-white/70">Beranda</a>
                <a @click="open = false" href="{{ route('home') }}#tentang" class="rounded-xl px-3 py-2 hover:bg-white/70">Tentang</a>
                <a @click="open = false" href="{{ route('dokumen.publik.index') }}" class="rounded-xl px-3 py-2 hover:bg-white/70">Dokumen</a>
                <a @click="open = false" href="{{ route('berita.publik.index') }}" class="rounded-xl px-3 py-2 hover:bg-white/70">Berita</a>
                <a @click="open = false" href="{{ route('home') }}#kontak" class="rounded-xl px-3 py-2 hover:bg-white/70">Kontak</a>
                <a href="{{ route('login') }}" class="mt-2 rounded-xl bg-slate-950 px-3 py-3 text-center text-white">Login</a>
            </nav>
        </div>
    </header>

    <main class="min-h-[calc(100vh-11rem)] px-4 py-10 md:py-14">
        @yield('content')
    </main>

    <footer class="px-4 pb-6">
        <div class="glass-dark mx-auto flex max-w-7xl flex-col justify-between gap-3 rounded-2xl px-6 py-5 text-sm text-cyan-50/80 md:flex-row md:items-center">
            <p>&copy; {{ date('Y') }} UPMI STIKes Bogor Husada. Hak Cipta Dilindungi.</p>
            <p>Dikelola oleh Tim ICT.</p>
        </div>
    </footer>
    @stack('scripts')
</body>
</html>

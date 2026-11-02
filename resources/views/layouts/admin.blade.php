<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'SIM UPMI | Admin')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://unpkg.com/trix@2.0.0/dist/trix.css">
    <style>
        body { font-family: 'Inter', sans-serif; }
        [x-cloak] { display: none !important; }
        .admin-glass {
            background: rgba(255, 255, 255, 0.78);
            border: 1px solid rgba(255, 255, 255, 0.78);
            box-shadow: 0 18px 50px rgba(15, 23, 42, 0.10);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
        }
        ::-webkit-scrollbar { width: 8px; height: 8px; }
        ::-webkit-scrollbar-track { background: rgba(226, 232, 240, .65); }
        ::-webkit-scrollbar-thumb { background: #94a3b8; border-radius: 999px; }
        ::-webkit-scrollbar-thumb:hover { background: #64748b; }
    </style>
</head>
<body class="bg-[#eef6f8] text-slate-800 antialiased">
    <div class="fixed inset-0 -z-10">
        <div class="absolute inset-0 bg-[linear-gradient(115deg,#f8fafc_0%,#e0f2fe_42%,#ecfeff_100%)]"></div>
        <div class="absolute inset-0 bg-[radial-gradient(circle_at_15%_10%,rgba(20,184,166,.18),transparent_28%),radial-gradient(circle_at_82%_18%,rgba(59,130,246,.18),transparent_26%),radial-gradient(circle_at_50%_88%,rgba(244,114,182,.10),transparent_28%)]"></div>
    </div>

    <div x-data="{ sidebarOpen: window.innerWidth >= 768 }" class="flex min-h-screen">
        <aside x-cloak
               :class="{ '-translate-x-full': !sidebarOpen && window.innerWidth < 768 }"
               class="fixed inset-y-0 left-0 z-30 w-72 transform border-r border-white/70 bg-slate-950 text-white shadow-2xl shadow-slate-900/20 transition-transform duration-300 ease-in-out md:static md:translate-x-0">
            @include('layouts.sidebar')
        </aside>

        <div x-cloak
             x-show="sidebarOpen && window.innerWidth < 768"
             @click="sidebarOpen = false"
             class="fixed inset-0 z-20 bg-slate-950/50 backdrop-blur-sm md:hidden"></div>

        <div class="flex min-w-0 flex-1 flex-col">
            <header class="sticky top-0 z-10 px-4 py-4 md:px-6">
                <div class="admin-glass flex items-center justify-between rounded-2xl px-4 py-3">
                    <div class="flex min-w-0 items-center gap-3">
                        <button @click="sidebarOpen = !sidebarOpen" class="rounded-xl bg-white/70 p-2 text-slate-700 ring-1 ring-white/80 transition hover:bg-white focus:outline-none focus:ring-2 focus:ring-teal-500">
                            <svg class="h-6 w-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path x-show="!sidebarOpen" stroke-linecap="round" stroke-linejoin="round" d="M4 7h16M4 12h16M4 17h16"/>
                                <path x-show="sidebarOpen" stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                        </button>
                        <div class="min-w-0">
                            <p class="text-xs font-extrabold uppercase tracking-[0.18em] text-teal-700">Admin Panel</p>
                            <h1 class="truncate text-xl font-extrabold text-slate-950 md:text-2xl">@yield('title', 'Dashboard Admin')</h1>
                        </div>
                    </div>

                    <div class="flex items-center gap-3">
                        @php($unreadNotifications = \App\Models\AppNotification::where('user_id', Auth::id())->whereNull('read_at')->count())
                        <a href="{{ route('admin.notifications.index') }}" class="relative rounded-2xl bg-white/65 p-3 text-slate-700 ring-1 ring-white/80 transition hover:bg-white">
                            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.4-1.4A2 2 0 0118 14.2V11a6 6 0 10-12 0v3.2a2 2 0 01-.6 1.4L4 17h5m2 0a2 2 0 104 0"/>
                            </svg>
                            @if ($unreadNotifications > 0)
                                <span class="absolute -right-1 -top-1 rounded-full bg-red-600 px-1.5 py-0.5 text-[10px] font-bold text-white">{{ $unreadNotifications }}</span>
                            @endif
                        </a>

                    <div class="relative" x-data="{ dropdownOpen: false }">
                        <button type="button" class="flex items-center gap-3 rounded-2xl bg-white/65 px-3 py-2 ring-1 ring-white/80 transition hover:bg-white" @click="dropdownOpen = !dropdownOpen">
                            <span class="hidden text-sm font-bold text-slate-700 sm:block">{{ Auth::user()->name ?? 'Pengguna' }}</span>
                            <img class="h-10 w-10 rounded-2xl object-cover ring-2 ring-teal-100" src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name ?? 'P A') }}&background=0f766e&color=ffffff&size=128" alt="User Avatar">
                            <svg class="h-4 w-4 text-slate-500 transition" :class="{ 'rotate-180': dropdownOpen }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </button>

                        <div x-show="dropdownOpen" x-cloak @click.away="dropdownOpen = false" x-transition class="admin-glass absolute right-0 mt-3 w-52 rounded-2xl p-2">
                            <a href="{{ route('admin.profile.edit') }}" class="block rounded-xl px-4 py-2.5 text-sm font-semibold text-slate-700 hover:bg-white/75">Profil</a>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="block w-full rounded-xl px-4 py-2.5 text-left text-sm font-semibold text-red-600 hover:bg-red-50">
                                    Keluar
                                </button>
                            </form>
                        </div>
                    </div>
                    </div>
                </div>
            </header>

            <main class="flex-1 px-4 pb-8 md:px-6">
                @yield('content')
            </main>

            <footer class="px-4 pb-5 md:px-6">
                <div class="admin-glass rounded-2xl px-5 py-4 text-center text-sm font-medium text-slate-500">
                    &copy; {{ date('Y') }} SIM UPMI. All rights reserved.
                </div>
            </footer>
        </div>
    </div>

    <script src="https://unpkg.com/trix@2.0.0/dist/trix.umd.min.js"></script>
    <script src="https://cdn.ckeditor.com/ckeditor5/39.0.1/classic/ckeditor.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const narasiEditor = document.querySelector('#narasi');
        if (narasiEditor && window.ClassicEditor) {
            ClassicEditor.create(narasiEditor).catch(error => console.error(error));
        }
    </script>
    @stack('scripts')
</body>
</html>

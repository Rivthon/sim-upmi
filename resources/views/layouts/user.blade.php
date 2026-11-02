<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'SIM UPMI | User')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; }
        [x-cloak] { display: none !important; }
        .user-glass {
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
@php
    $menuGroups = [
        [
            'label' => 'Utama',
            'icon' => 'M3 12l7-7 7 7M5 10v9h10v-9',
            'items' => [
                ['route' => 'user.dashboard', 'match' => 'user.dashboard', 'label' => 'Dashboard', 'icon' => 'M3 12l7-7 7 7M5 10v9h10v-9'],
            ],
        ],
        [
            'label' => 'Survey',
            'icon' => 'M9 5h6M9 12h6M9 19h6M5 5h.01M5 12h.01M5 19h.01',
            'items' => [
                ['route' => 'user.survey.index', 'match' => 'user.survey.*', 'label' => 'Mengisi Survey', 'icon' => 'M9 5h6M9 12h6M9 19h6M5 5h.01M5 12h.01M5 19h.01'],
            ],
        ],
        [
            'label' => 'Dokumen',
            'icon' => 'M7 3h7l5 5v13H7a2 2 0 01-2-2V5a2 2 0 012-2z',
            'items' => [
                ['route' => 'user.dokumen.index', 'match' => 'user.dokumen.*', 'label' => 'Upload Dokumen', 'icon' => 'M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4-4m0 0l-4 4m4-4v12'],
            ],
        ],
    ];

    $activeGroupIndex = collect($menuGroups)->search(
        fn ($group) => collect($group['items'])->contains(fn ($item) => request()->routeIs($item['match']))
    );
@endphp

<div class="fixed inset-0 -z-10">
    <div class="absolute inset-0 bg-[linear-gradient(115deg,#f8fafc_0%,#e0f2fe_42%,#ecfeff_100%)]"></div>
    <div class="absolute inset-0 bg-[radial-gradient(circle_at_15%_10%,rgba(20,184,166,.18),transparent_28%),radial-gradient(circle_at_82%_18%,rgba(59,130,246,.18),transparent_26%),radial-gradient(circle_at_50%_88%,rgba(244,114,182,.10),transparent_28%)]"></div>
</div>

<div x-data="{ sidebarOpen: window.innerWidth >= 768 }" class="flex min-h-screen">
    <aside x-cloak
           :class="{ '-translate-x-full': !sidebarOpen && window.innerWidth < 768 }"
           class="fixed inset-y-0 left-0 z-30 flex w-72 transform flex-col border-r border-white/70 bg-slate-950 text-white shadow-2xl shadow-slate-900/20 transition-transform duration-300 ease-in-out md:static md:translate-x-0">
        <div class="flex items-center justify-between border-b border-white/10 p-5">
            <a href="{{ route('user.dashboard') }}" class="flex items-center gap-3">
                <span class="flex h-12 w-12 items-center justify-center rounded-2xl bg-white">
                    <img src="{{ asset('path/logo.png') }}" alt="Logo UPMI" class="h-8 w-8 object-contain">
                </span>
                <span>
                    <span class="block text-xl font-extrabold tracking-wide">SIM UPMI</span>
                    <span class="block text-xs font-bold uppercase tracking-[0.18em] text-teal-200">User Portal</span>
                </span>
            </a>
            <button @click="sidebarOpen = false" class="rounded-xl p-2 text-slate-300 hover:bg-white/10 hover:text-white md:hidden">
                <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>

        <nav x-data="{ openGroup: {{ $activeGroupIndex === false ? 'null' : $activeGroupIndex }} }" class="flex-1 space-y-2 overflow-y-auto p-4">
            @foreach ($menuGroups as $group)
                @php($groupIndex = $loop->index)
                <div class="rounded-2xl border"
                     :class="openGroup === {{ $groupIndex }} ? 'border-teal-400/45 bg-teal-500/12' : 'border-transparent'">
                    <button type="button"
                            @click="openGroup = openGroup === {{ $groupIndex }} ? null : {{ $groupIndex }}"
                            class="group flex w-full items-center justify-between gap-3 rounded-2xl px-4 py-3 text-sm font-extrabold text-slate-300 transition hover:bg-white/10 hover:text-white"
                            :class="openGroup === {{ $groupIndex }} ? 'bg-teal-500/18 text-white' : ''">
                        <span class="flex min-w-0 items-center gap-3">
                            <span class="flex h-9 w-9 shrink-0 items-center justify-center rounded-xl bg-white/10 text-teal-100 transition group-hover:bg-teal-500 group-hover:text-white"
                                  :class="openGroup === {{ $groupIndex }} ? 'bg-teal-400 text-slate-950 shadow-lg shadow-teal-950/20' : ''">
                                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $group['icon'] }}"/>
                                </svg>
                            </span>
                            <span class="truncate">{{ $group['label'] }}</span>
                        </span>
                        <svg class="h-4 w-4 shrink-0 text-slate-400 transition-transform" :class="{ 'rotate-180 text-white': openGroup === {{ $groupIndex }} }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                        </svg>
                    </button>

                    <div x-show="openGroup === {{ $groupIndex }}" x-transition class="space-y-1 px-2 pb-2">
                        @foreach ($group['items'] as $menu)
                            @php($active = request()->routeIs($menu['match']))
                            <a href="{{ route($menu['route']) }}"
                               class="group relative flex items-center gap-3 rounded-xl px-3 py-2.5 text-sm font-bold transition
                                      {{ $active ? 'bg-white text-slate-950 shadow-lg shadow-black/20' : 'text-slate-300 hover:bg-white/10 hover:text-white' }}">
                                @if ($active)
                                    <span class="absolute left-0 top-2 h-7 w-1 rounded-full bg-teal-500"></span>
                                @endif
                                <span class="flex h-8 w-8 shrink-0 items-center justify-center rounded-lg transition {{ $active ? 'bg-teal-500 text-white' : 'bg-white/10 text-teal-100 group-hover:bg-teal-500 group-hover:text-white' }}">
                                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $menu['icon'] }}"/>
                                    </svg>
                                </span>
                                <span class="truncate">{{ $menu['label'] }}</span>
                            </a>
                        @endforeach
                    </div>
                </div>
            @endforeach
        </nav>

        <div class="border-t border-white/10 p-4">
            <div class="mb-4 rounded-2xl bg-white/10 p-4">
                <p class="text-sm font-bold text-white">{{ Auth::user()->name ?? 'Pengguna' }}</p>
                <p class="mt-1 truncate text-xs text-slate-300">{{ Auth::user()->email ?? '-' }}</p>
            </div>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="flex w-full items-center justify-center gap-2 rounded-2xl bg-red-500/12 px-4 py-3 text-sm font-extrabold text-red-100 transition hover:bg-red-500 hover:text-white">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                    </svg>
                    Keluar
                </button>
            </form>
        </div>
    </aside>

    <div x-cloak
         x-show="sidebarOpen && window.innerWidth < 768"
         @click="sidebarOpen = false"
         class="fixed inset-0 z-20 bg-slate-950/50 backdrop-blur-sm md:hidden"></div>

    <div class="flex min-w-0 flex-1 flex-col">
        <header class="sticky top-0 z-10 px-4 py-4 md:px-6">
            <div class="user-glass flex items-center justify-between rounded-2xl px-4 py-3">
                <div class="flex min-w-0 items-center gap-3">
                    <button @click="sidebarOpen = !sidebarOpen" class="rounded-xl bg-white/70 p-2 text-slate-700 ring-1 ring-white/80 transition hover:bg-white focus:outline-none focus:ring-2 focus:ring-teal-500">
                        <svg class="h-6 w-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path x-show="!sidebarOpen" stroke-linecap="round" stroke-linejoin="round" d="M4 7h16M4 12h16M4 17h16"/>
                            <path x-show="sidebarOpen" stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                    <div class="min-w-0">
                        <p class="text-xs font-extrabold uppercase tracking-[0.18em] text-teal-700">User Portal</p>
                        <h1 class="truncate text-xl font-extrabold text-slate-950 md:text-2xl">@yield('title', 'Dashboard User')</h1>
                    </div>
                </div>

                <div class="relative" x-data="{ dropdownOpen: false }">
                    <button type="button" class="flex items-center gap-3 rounded-2xl bg-white/65 px-3 py-2 ring-1 ring-white/80 transition hover:bg-white" @click="dropdownOpen = !dropdownOpen">
                        <span class="hidden text-sm font-bold text-slate-700 sm:block">{{ Auth::user()->name ?? 'Pengguna' }}</span>
                        <img class="h-10 w-10 rounded-2xl object-cover ring-2 ring-teal-100" src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name ?? 'P A') }}&background=0f766e&color=ffffff&size=128" alt="User Avatar">
                        <svg class="h-4 w-4 text-slate-500 transition" :class="{ 'rotate-180': dropdownOpen }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </button>

                    <div x-show="dropdownOpen" x-cloak @click.away="dropdownOpen = false" x-transition class="user-glass absolute right-0 mt-3 w-52 rounded-2xl p-2">
                        <a href="{{ route('user.profile.edit') }}" class="block rounded-xl px-4 py-2.5 text-sm font-semibold text-slate-700 hover:bg-white/75">Profil</a>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="block w-full rounded-xl px-4 py-2.5 text-left text-sm font-semibold text-red-600 hover:bg-red-50">Keluar</button>
                        </form>
                    </div>
                </div>
            </div>
        </header>

        <main class="flex-1 px-4 pb-8 md:px-6">
            @yield('content')
        </main>

        <footer class="px-4 pb-5 md:px-6">
            <div class="user-glass rounded-2xl px-5 py-4 text-center text-sm font-medium text-slate-500">
                &copy; {{ date('Y') }} SIM UPMI. All rights reserved.
            </div>
        </footer>
    </div>
</div>

@stack('scripts')
</body>
</html>

@php
    $menuGroups = [
        [
            'label' => 'Utama',
            'icon' => 'M3 12l7-7 7 7M5 10v9h10v-9',
            'items' => [
                ['route' => 'admin.dashboard', 'match' => 'admin.dashboard', 'label' => 'Dashboard', 'icon' => 'M3 12l7-7 7 7M5 10v9h10v-9'],
                ['route' => 'admin.notifications.index', 'match' => 'admin.notifications.*', 'label' => 'Notifikasi', 'icon' => 'M15 17h5l-1.4-1.4A2 2 0 0118 14.2V11a6 6 0 10-12 0v3.2a2 2 0 01-.6 1.4L4 17h5m2 0a2 2 0 104 0'],
            ],
        ],
        [
            'label' => 'Website',
            'icon' => 'M4 5h16M4 12h16M4 19h10',
            'items' => [
                ['route' => 'admin.site-content.index', 'match' => 'admin.site-content.*', 'label' => 'Edit Web', 'icon' => 'M4 5h16M4 12h16M4 19h10M17 16l3 3m0 0l-3 3m3-3H9'],
                ['route' => 'admin.berita.index', 'match' => 'admin.berita.*', 'label' => 'Manajemen Berita', 'icon' => 'M4 5h16v14H4zM8 9h8M8 13h5'],
            ],
        ],
        [
            'label' => 'Dokumen Mutu',
            'icon' => 'M7 3h7l5 5v13H7a2 2 0 01-2-2V5a2 2 0 012-2z',
            'items' => [
                ['route' => 'admin.dokumen.index', 'match' => 'admin.dokumen.*', 'label' => 'Semua Dokumen', 'icon' => 'M7 3h7l5 5v13H7a2 2 0 01-2-2V5a2 2 0 012-2z'],
                ['route' => 'admin.kategori.index', 'match' => 'admin.kategori.*', 'label' => 'Kategori Dokumen', 'icon' => 'M4 6h16M4 12h16M4 18h10'],
                ['route' => 'admin.subkategori.index', 'match' => 'admin.subkategori.*', 'label' => 'Sub Kategori', 'icon' => 'M4 6h16M7 12h13M10 18h10'],
            ],
        ],
        [
            'label' => 'AMI & SPMI',
            'icon' => 'M9 12l2 2 4-4M12 22a10 10 0 110-20 10 10 0 010 20z',
            'items' => [
                ['route' => 'admin.quality-standards.index', 'match' => 'admin.quality-standards.*', 'label' => 'Standar Mutu', 'icon' => 'M5 5h14M5 12h14M5 19h14'],
                ['route' => 'admin.quality-indicators.index', 'match' => 'admin.quality-indicators.*', 'label' => 'Indikator Mutu', 'icon' => 'M4 19V5m5 14V9m5 10V7m5 12V3'],
                ['route' => 'admin.ppepp-monitorings.index', 'match' => 'admin.ppepp-monitorings.*', 'label' => 'Monitoring PPEPP', 'icon' => 'M12 6v6l4 2M5 3h14v18H5z'],
                ['route' => 'admin.quality-risks.index', 'match' => 'admin.quality-risks.*', 'label' => 'Risiko Mutu', 'icon' => 'M12 9v4m0 4h.01M10.3 3.9L2.5 18a2 2 0 001.7 3h15.6a2 2 0 001.7-3L13.7 3.9a2 2 0 00-3.4 0z'],
                ['route' => 'admin.unit-monitorings.index', 'match' => 'admin.unit-monitorings.*', 'label' => 'Monev Unit', 'icon' => 'M4 19V5m5 14V9m5 10V7m5 12V3'],
                ['route' => 'admin.accreditations.index', 'match' => 'admin.accreditations.*', 'label' => 'Akreditasi', 'icon' => 'M12 3l7 4v5c0 5-3 8-7 9-4-1-7-4-7-9V7l7-4z'],
                ['route' => 'admin.recommendations.index', 'match' => 'admin.recommendations.*', 'label' => 'Rekomendasi', 'icon' => 'M9 12l2 2 4-4M5 7h14M5 17h14'],
                ['route' => 'admin.ami.index', 'match' => 'admin.ami.*', 'label' => 'Jadwal AMI', 'icon' => 'M8 7V3m8 4V3M5 11h14M5 21h14a2 2 0 002-2V7H3v12a2 2 0 002 2z'],
                ['route' => 'admin.ami-follow-up.index', 'match' => 'admin.ami-follow-up.*', 'label' => 'Tindak Lanjut AMI', 'icon' => 'M9 12l2 2 4-4M5 7h14M5 17h14'],
                ['route' => 'admin.pelaporan.index', 'match' => 'admin.pelaporan.*', 'label' => 'Pelaporan SPMI', 'icon' => 'M8 7h8M8 11h8M8 15h5M5 3h14v18H5z'],
                ['route' => 'admin.management-reviews.index', 'match' => 'admin.management-reviews.*', 'label' => 'RTM', 'icon' => 'M7 8h10M7 12h6M5 4h14v16H5z'],
                ['route' => 'admin.capas.index', 'match' => 'admin.capas.*', 'label' => 'CAPA', 'icon' => 'M9 12l2 2 4-4M4 6h16M4 18h16'],
                ['route' => 'admin.quality-calendars.index', 'match' => 'admin.quality-calendars.*', 'label' => 'Kalender Mutu', 'icon' => 'M8 7V3m8 4V3M5 11h14M5 21h14a2 2 0 002-2V7H3v12a2 2 0 002 2z'],
                ['route' => 'admin.executive-reports.index', 'match' => 'admin.executive-reports.*', 'label' => 'Laporan Eksekutif', 'icon' => 'M4 19V5m5 14V9m5 10V7m5 12V3'],
            ],
        ],
        [
            'label' => 'Survey',
            'icon' => 'M9 5h6M9 12h6M9 19h6M5 5h.01M5 12h.01M5 19h.01',
            'items' => [
                ['route' => 'admin.survey.index', 'match' => 'admin.survey.*', 'label' => 'Manajemen Survey', 'icon' => 'M9 5h6M9 12h6M9 19h6M5 5h.01M5 12h.01M5 19h.01'],
            ],
        ],
        [
            'label' => 'Sistem',
            'icon' => 'M12 6v6l4 2M5 3h14v18H5z',
            'items' => [
                ['route' => 'admin.user.index', 'match' => 'admin.user.*', 'label' => 'Manajemen User', 'icon' => 'M16 14a4 4 0 10-8 0M4 21a8 8 0 0116 0'],
                ['route' => 'admin.activity-log.index', 'match' => 'admin.activity-log.*', 'label' => 'Audit Trail', 'icon' => 'M9 12h6M9 16h6M7 4h10a2 2 0 012 2v14H5V6a2 2 0 012-2z'],
                ['route' => 'admin.backup-restore.index', 'match' => 'admin.backup-restore.*', 'label' => 'Backup / Restore', 'icon' => 'M4 7a4 4 0 014-4h8a4 4 0 014 4v10a4 4 0 01-4 4H8a4 4 0 01-4-4V7zm4 5h8M8 16h5'],
            ],
        ],
    ];

    $activeGroupIndex = collect($menuGroups)->search(
        fn ($group) => collect($group['items'])->contains(fn ($item) => request()->routeIs($item['match']))
    );
@endphp

<div class="flex items-center justify-between border-b border-white/10 p-5">
    <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3">
        <span class="flex h-12 w-12 items-center justify-center rounded-2xl bg-white">
            <img src="{{ asset('path/logo.png') }}" alt="Logo UPMI" class="h-8 w-8 object-contain">
        </span>
        <span>
            <span class="block text-xl font-extrabold tracking-wide">SIM UPMI</span>
            <span class="block text-xs font-bold uppercase tracking-[0.18em] text-teal-200">Admin Suite</span>
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

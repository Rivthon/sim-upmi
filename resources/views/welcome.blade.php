<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Unit Penjaminan Mutu Internal | STIKes Bogor Husada</title>
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
        .shine {
            position: relative;
            overflow: hidden;
        }
        .shine::before {
            content: "";
            position: absolute;
            inset: 0;
            background: linear-gradient(135deg, rgba(255,255,255,.78), rgba(255,255,255,0) 42%);
            pointer-events: none;
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
        <div class="absolute inset-0 bg-[radial-gradient(circle_at_15%_10%,rgba(20,184,166,.26),transparent_28%),radial-gradient(circle_at_82%_18%,rgba(59,130,246,.24),transparent_26%),radial-gradient(circle_at_50%_88%,rgba(244,114,182,.14),transparent_28%)]"></div>
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
                <a href="#beranda" class="hover:text-teal-700">Beranda</a>
                <a href="#tentang" class="hover:text-teal-700">Tentang</a>
                <a href="#layanan" class="hover:text-teal-700">Layanan</a>
                <a href="#dokumen" class="hover:text-teal-700">Dokumen</a>
                <a href="#berita" class="hover:text-teal-700">Berita</a>
                <a href="#kontak" class="hover:text-teal-700">Kontak</a>
            </nav>

            <div class="hidden items-center gap-3 md:flex">
                <a href="{{ route('dokumen.publik.index') }}" class="rounded-full border border-white/80 bg-white/50 px-4 py-2 text-sm font-bold text-slate-700 hover:bg-white">
                    Dokumen Publik
                </a>
                <a href="{{ route('login') }}" class="rounded-full bg-slate-950 px-5 py-2.5 text-sm font-bold text-white shadow-lg shadow-slate-900/20 hover:bg-teal-700">
                    Login
                </a>
            </div>

            <button type="button" @click="open = !open" class="rounded-xl bg-white/70 p-2 text-slate-800 ring-1 ring-white/80 md:hidden">
                <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 7h16M4 12h16M4 17h16"/>
                </svg>
            </button>
        </div>

        <div x-show="open" x-transition class="glass mx-auto mt-3 max-w-7xl rounded-2xl p-4 md:hidden">
            <nav class="grid gap-2 text-sm font-semibold text-slate-700">
                <a @click="open = false" href="#beranda" class="rounded-xl px-3 py-2 hover:bg-white/70">Beranda</a>
                <a @click="open = false" href="#tentang" class="rounded-xl px-3 py-2 hover:bg-white/70">Tentang</a>
                <a @click="open = false" href="#layanan" class="rounded-xl px-3 py-2 hover:bg-white/70">Layanan</a>
                <a @click="open = false" href="#dokumen" class="rounded-xl px-3 py-2 hover:bg-white/70">Dokumen</a>
                <a @click="open = false" href="#berita" class="rounded-xl px-3 py-2 hover:bg-white/70">Berita</a>
                <a @click="open = false" href="#kontak" class="rounded-xl px-3 py-2 hover:bg-white/70">Kontak</a>
                <a href="{{ route('login') }}" class="mt-2 rounded-xl bg-slate-950 px-3 py-3 text-center text-white">Login</a>
            </nav>
        </div>
    </header>

    <main>
        <section id="beranda" class="px-4 pb-16 pt-8 md:pb-24 md:pt-14">
            <div class="mx-auto grid max-w-7xl items-center gap-8 lg:grid-cols-[1.08fr_.92fr]">
                <div class="glass shine rounded-[2rem] p-7 md:p-10 lg:p-12">
                    <div class="relative">
                        <span class="inline-flex rounded-full border border-teal-200 bg-white/60 px-4 py-2 text-xs font-extrabold uppercase tracking-[0.2em] text-teal-700">
                            {{ $hero['subtitle'] }}
                        </span>
                        <h1 class="mt-7 max-w-4xl text-4xl font-extrabold leading-tight text-slate-950 md:text-6xl">
                            {{ $hero['title'] }}
                        </h1>
                        <p class="mt-6 max-w-2xl text-base leading-8 text-slate-600 md:text-lg">
                            {{ $hero['body'] }}
                        </p>
                        <div class="mt-8 flex flex-col gap-3 sm:flex-row">
                            <a href="{{ $hero['button_url'] ?? route('dokumen.publik.index') }}" class="rounded-full bg-teal-600 px-6 py-3 text-center text-sm font-extrabold text-white shadow-xl shadow-teal-700/20 hover:bg-teal-700">
                                {{ $hero['button_label'] ?? 'Jelajahi Dokumen' }}
                            </a>
                            <a href="#layanan" class="rounded-full border border-white/90 bg-white/55 px-6 py-3 text-center text-sm font-extrabold text-slate-800 hover:bg-white">
                                Lihat Layanan
                            </a>
                        </div>
                    </div>
                </div>

                <div class="glass-dark shine rounded-[2rem] p-7 text-white md:p-9">
                    <div class="relative">
                        <div class="flex items-center justify-between gap-4">
                            <div>
                                <p class="text-sm font-semibold uppercase tracking-[0.2em] text-cyan-100">Quality Hub</p>
                                <h2 class="mt-2 text-2xl font-extrabold">UPMI Dashboard</h2>
                            </div>
                            <img src="{{ asset('path/logo.png') }}" alt="Logo" class="h-16 w-16 rounded-2xl bg-white/90 p-2">
                        </div>

                        <div class="mt-8 grid gap-4">
                            <div class="rounded-2xl border border-white/15 bg-white/10 p-5">
                                <p class="text-sm text-cyan-100">Fokus utama</p>
                                <p class="mt-2 text-xl font-bold">Dokumen, AMI, Survey, Pelaporan</p>
                            </div>
                            <div class="grid grid-cols-2 gap-4">
                                <div class="rounded-2xl border border-white/15 bg-white/10 p-5">
                                    <p class="text-3xl font-extrabold">PPEPP</p>
                                    <p class="mt-1 text-sm text-cyan-100">Siklus mutu</p>
                                </div>
                                <div class="rounded-2xl border border-white/15 bg-white/10 p-5">
                                    <p class="text-3xl font-extrabold">2040</p>
                                    <p class="mt-1 text-sm text-cyan-100">Visi institusi</p>
                                </div>
                            </div>
                            <div class="rounded-2xl bg-white p-5 text-slate-900">
                                <p class="text-sm font-semibold text-slate-500">Portal akses</p>
                                <div class="mt-3 flex items-center justify-between gap-4">
                                    <span class="text-lg font-extrabold">SIM UPMI</span>
                                    <a href="{{ route('login') }}" class="rounded-full bg-slate-950 px-4 py-2 text-sm font-bold text-white">Masuk</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section id="tentang" class="px-4 py-16">
            <div class="mx-auto max-w-7xl">
                <div class="grid gap-6 lg:grid-cols-[.82fr_1.18fr]">
                    <div class="glass rounded-[1.75rem] p-7 md:p-9">
                        <p class="text-sm font-extrabold uppercase tracking-[0.2em] text-teal-700">{{ $about['subtitle'] }}</p>
                        <h2 class="mt-4 text-3xl font-extrabold text-slate-950 md:text-4xl">{{ $about['title'] }}</h2>
                    </div>
                    <div class="glass rounded-[1.75rem] p-7 md:p-9">
                        <p class="leading-8 text-slate-600">
                            {{ $about['body'] }}
                        </p>
                        <div class="mt-6 grid gap-4 md:grid-cols-3">
                            <div class="rounded-2xl bg-white/55 p-4 ring-1 ring-white/70">
                                <p class="font-extrabold text-slate-950">Transparan</p>
                                <p class="mt-1 text-sm text-slate-600">Data dan dokumen mudah ditelusuri.</p>
                            </div>
                            <div class="rounded-2xl bg-white/55 p-4 ring-1 ring-white/70">
                                <p class="font-extrabold text-slate-950">Terukur</p>
                                <p class="mt-1 text-sm text-slate-600">Survey dan pelaporan terdokumentasi.</p>
                            </div>
                            <div class="rounded-2xl bg-white/55 p-4 ring-1 ring-white/70">
                                <p class="font-extrabold text-slate-950">Berkelanjutan</p>
                                <p class="mt-1 text-sm text-slate-600">Mendukung siklus PPEPP.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section id="layanan" class="px-4 py-16">
            <div class="mx-auto max-w-7xl">
                <div class="mb-8">
                    <p class="text-sm font-extrabold uppercase tracking-[0.2em] text-teal-700">Layanan</p>
                    <h2 class="mt-3 text-3xl font-extrabold text-slate-950 md:text-4xl">Layanan utama UPMI</h2>
                </div>

                <div class="grid gap-5 md:grid-cols-3">
                    @foreach ($services as $layanan)
                        <div class="glass shine rounded-[1.5rem] p-6 transition duration-300 hover:-translate-y-1">
                            <div class="relative">
                                @if (! empty($layanan['image_path']))
                                    <img src="{{ asset('storage/' . $layanan['image_path']) }}" alt="{{ $layanan['title'] }}" class="h-32 w-full rounded-2xl object-cover">
                                @else
                                    <span class="flex h-12 w-12 items-center justify-center rounded-2xl bg-teal-600 text-white">
                                        <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7 4h10a2 2 0 012 2v12a2 2 0 01-2 2H7a2 2 0 01-2-2V6a2 2 0 012-2z"/>
                                        </svg>
                                    </span>
                                @endif
                                <h3 class="mt-5 text-xl font-extrabold text-slate-950">{{ $layanan['title'] }}</h3>
                                @if (! empty($layanan['body']))
                                    <p class="mt-3 leading-7 text-slate-600">{{ $layanan['body'] }}</p>
                                @endif
                                @if (! empty($layanan['button_label']) && ! empty($layanan['button_url']))
                                    <a href="{{ $layanan['button_url'] }}" class="mt-5 inline-flex font-extrabold text-teal-700 hover:text-slate-950">{{ $layanan['button_label'] }}</a>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>

        <section id="dokumen" class="px-4 py-16">
            <div class="mx-auto max-w-7xl">
                <div class="glass-dark rounded-[2rem] p-7 text-white md:p-10">
                    <div class="grid gap-8 lg:grid-cols-[.9fr_1.1fr] lg:items-center">
                        <div>
                            <p class="text-sm font-extrabold uppercase tracking-[0.2em] text-cyan-100">{{ $documentIntro['subtitle'] }}</p>
                            <h2 class="mt-4 text-3xl font-extrabold md:text-4xl">{{ $documentIntro['title'] }}</h2>
                            <p class="mt-4 leading-8 text-cyan-50/85">{{ $documentIntro['body'] }}</p>
                            <a href="{{ $documentIntro['button_url'] ?? route('dokumen.publik.index') }}" class="mt-7 inline-flex rounded-full bg-white px-6 py-3 text-sm font-extrabold text-slate-950 hover:bg-cyan-50">
                                {{ $documentIntro['button_label'] ?? 'Buka Dokumen Publik' }}
                            </a>
                        </div>
                        <div class="grid gap-4 sm:grid-cols-3">
                            @foreach ($documents as $dokumen)
                                <div class="rounded-2xl border border-white/15 bg-white/10 p-5">
                                    @if (! empty($dokumen['image_path']))
                                        <img src="{{ asset('storage/' . $dokumen['image_path']) }}" alt="{{ $dokumen['title'] }}" class="h-24 w-full rounded-xl object-cover">
                                    @else
                                        <div class="flex h-11 w-11 items-center justify-center rounded-xl bg-white/15">
                                            <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 3h7l5 5v13H7a2 2 0 01-2-2V5a2 2 0 012-2z"/>
                                            </svg>
                                        </div>
                                    @endif
                                    <p class="mt-5 font-extrabold">{{ $dokumen['title'] }}</p>
                                    @if (! empty($dokumen['body']))
                                        <p class="mt-2 text-sm leading-6 text-cyan-50/75">{{ $dokumen['body'] }}</p>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section id="berita" class="px-4 py-16">
            <div class="mx-auto max-w-7xl">
                <div class="mb-8 flex flex-col justify-between gap-4 md:flex-row md:items-end">
                    <div>
                        <p class="text-sm font-extrabold uppercase tracking-[0.2em] text-teal-700">Berita</p>
                        <h2 class="mt-3 text-3xl font-extrabold text-slate-950 md:text-4xl">Kabar terbaru UPMI</h2>
                    </div>
                    <a href="{{ route('berita.publik.index') }}" class="rounded-full border border-white/90 bg-white/60 px-5 py-3 text-sm font-extrabold text-slate-800 hover:bg-white">
                        Semua Berita
                    </a>
                </div>

                <div class="grid gap-6 md:grid-cols-3">
                    @forelse ($beritas->take(3) as $berita)
                        <article class="glass overflow-hidden rounded-[1.5rem] transition duration-300 hover:-translate-y-1">
                            @if ($berita->gambar)
                                <img src="{{ asset('storage/' . $berita->gambar) }}" alt="{{ $berita->judul }}" class="h-52 w-full object-cover">
                            @else
                                <div class="flex h-52 items-center justify-center bg-white/35 text-slate-400">
                                    <svg class="h-14 w-14" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4-4a2 2 0 012.8 0l1.2 1.2 2-2a2 2 0 012.8 0L20 14M4 6a2 2 0 012-2h12a2 2 0 012 2v12a2 2 0 01-2 2H6a2 2 0 01-2-2V6z"/>
                                    </svg>
                                </div>
                            @endif
                            <div class="p-6">
                                <p class="text-xs font-bold uppercase tracking-[0.18em] text-teal-700">{{ $berita->created_at->format('d M Y') }}</p>
                                <h3 class="mt-3 text-xl font-extrabold leading-snug text-slate-950">{{ \Illuminate\Support\Str::limit($berita->judul, 62) }}</h3>
                                <p class="mt-3 leading-7 text-slate-600">{{ \Illuminate\Support\Str::limit(strip_tags($berita->narasi), 120) }}</p>
                                <a href="{{ route('berita.publik.show', $berita->slug) }}" class="mt-5 inline-flex font-extrabold text-teal-700 hover:text-slate-950">Baca Selengkapnya</a>
                            </div>
                        </article>
                    @empty
                        <div class="glass rounded-[1.5rem] p-8 text-center md:col-span-3">
                            <p class="font-semibold text-slate-600">Belum ada berita terbaru yang tersedia.</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </section>

        <section id="kontak" class="px-4 py-16">
            <div class="glass mx-auto max-w-5xl rounded-[2rem] p-8 text-center md:p-12">
                <p class="text-sm font-extrabold uppercase tracking-[0.2em] text-teal-700">{{ $contact['subtitle'] }}</p>
                <h2 class="mt-4 text-3xl font-extrabold text-slate-950 md:text-5xl">{{ $contact['title'] }}</h2>
                <p class="mx-auto mt-5 max-w-2xl leading-8 text-slate-600">{{ $contact['body'] }}</p>
                <a href="{{ $contact['button_url'] ?? 'mailto:upmi@stikesbogorhusada.ac.id' }}" class="mt-8 inline-flex rounded-full bg-slate-950 px-7 py-3 text-sm font-extrabold text-white hover:bg-teal-700">{{ $contact['button_label'] ?? 'Hubungi UPMI' }}</a>
                <p class="mt-6 text-sm text-slate-500">Jl. Sholeh Iskandar No.4, Kedungbadak, Tanah Sereal, Kota Bogor</p>
            </div>
        </section>
    </main>

    <footer class="px-4 pb-6">
        <div class="glass-dark mx-auto flex max-w-7xl flex-col justify-between gap-3 rounded-2xl px-6 py-5 text-sm text-cyan-50/80 md:flex-row md:items-center">
            <p>&copy; {{ date('Y') }} UPMI STIKes Bogor Husada. Hak Cipta Dilindungi.</p>
            <p>Dikelola oleh Tim ICT.</p>
        </div>
    </footer>
</body>
</html>

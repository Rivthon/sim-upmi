<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'SIM UPMI STIKes Bogor Husada') }}</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <style>
        body { font-family: 'Inter', sans-serif; }
        .glass {
            background: rgba(255, 255, 255, 0.74);
            border: 1px solid rgba(255, 255, 255, 0.78);
            box-shadow: 0 24px 70px rgba(15, 23, 42, 0.14);
            backdrop-filter: blur(14px);
            -webkit-backdrop-filter: blur(14px);
        }
    </style>
</head>
<body class="min-h-screen bg-[#eef6f8] text-slate-900 antialiased">
    <div class="fixed inset-0 -z-10">
        <div class="absolute inset-0 bg-[linear-gradient(115deg,#f8fafc_0%,#e0f2fe_42%,#ecfeff_100%)]"></div>
        <div class="absolute inset-0 bg-[radial-gradient(circle_at_18%_12%,rgba(20,184,166,.25),transparent_28%),radial-gradient(circle_at_82%_18%,rgba(59,130,246,.22),transparent_26%),radial-gradient(circle_at_50%_88%,rgba(244,114,182,.12),transparent_28%)]"></div>
    </div>

    <main class="flex min-h-screen items-center justify-center px-4 py-10">
        <div class="grid w-full max-w-5xl overflow-hidden rounded-[2rem] lg:grid-cols-[.95fr_1.05fr]">
            <section class="hidden bg-slate-950/85 p-10 text-white backdrop-blur-xl lg:block">
                <a href="{{ route('home') }}" class="inline-flex items-center gap-3">
                    <span class="flex h-14 w-14 items-center justify-center rounded-2xl bg-white">
                        <img src="{{ asset('path/logo.png') }}" alt="Logo STIKes Bogor Husada" class="h-10 w-10 object-contain">
                    </span>
                    <span>
                        <span class="block text-2xl font-extrabold">SIM UPMI</span>
                        <span class="text-sm font-semibold uppercase tracking-[0.18em] text-cyan-100">Quality Portal</span>
                    </span>
                </a>

                <div class="mt-20">
                    <p class="text-sm font-bold uppercase tracking-[0.22em] text-teal-200">STIKes Bogor Husada</p>
                    <h1 class="mt-4 text-4xl font-extrabold leading-tight">Kelola mutu kampus dengan akses yang rapi dan aman.</h1>
                    <p class="mt-5 leading-8 text-cyan-50/80">Masuk untuk mengelola dokumen mutu, audit internal, pelaporan SPMI, survey, dan aktivitas penjaminan mutu.</p>
                </div>

                <div class="mt-12 grid gap-3">
                    <div class="rounded-2xl border border-white/15 bg-white/10 p-4">
                        <p class="font-bold">Dokumen Mutu</p>
                        <p class="mt-1 text-sm text-cyan-50/75">Upload, revisi, dan akses dokumen lebih terkontrol.</p>
                    </div>
                    <div class="rounded-2xl border border-white/15 bg-white/10 p-4">
                        <p class="font-bold">Audit Trail</p>
                        <p class="mt-1 text-sm text-cyan-50/75">Aktivitas penting tercatat untuk akuntabilitas.</p>
                    </div>
                </div>
            </section>

            <section class="glass p-7 sm:p-10">
                {{ $slot }}
            </section>
        </div>
    </main>
</body>
</html>

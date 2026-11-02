@extends(auth()->user()?->hasRole('admin-upmi') ? 'layouts.admin' : 'layouts.user')

@section('title', 'Edit Profil')

@section('content')
@php
    $isAdminProfile = auth()->user()?->hasRole('admin-upmi');
    $glassClass = $isAdminProfile ? 'admin-glass' : 'user-glass';
    $dashboardRoute = $isAdminProfile ? 'admin.dashboard' : 'user.dashboard';
    $profileUpdateRoute = $isAdminProfile ? 'admin.profile.update' : 'user.profile.update';
    $profileDestroyRoute = $isAdminProfile ? 'admin.profile.destroy' : 'user.profile.destroy';
@endphp

<div class="mx-auto max-w-6xl">
    <section class="{{ $glassClass }} overflow-hidden rounded-[1.75rem] p-6 md:p-8">
        <div class="flex flex-col justify-between gap-5 lg:flex-row lg:items-center">
            <div class="flex items-center gap-4">
                <img class="h-16 w-16 rounded-2xl object-cover ring-4 ring-white/80" src="https://ui-avatars.com/api/?name={{ urlencode($user->name ?? 'P A') }}&background=0f766e&color=ffffff&size=160" alt="Avatar {{ $user->name }}">
                <div>
                    <p class="text-sm font-extrabold uppercase tracking-[0.2em] text-teal-700">Akun Pengguna</p>
                    <h2 class="mt-2 text-3xl font-extrabold text-slate-950 md:text-4xl">Edit Profil</h2>
                    <p class="mt-2 max-w-2xl leading-7 text-slate-600">Kelola informasi akun, email, dan password yang dipakai untuk masuk ke SIM UPMI.</p>
                </div>
            </div>
            <a href="{{ route($dashboardRoute) }}" class="inline-flex items-center justify-center gap-2 rounded-2xl bg-white/70 px-5 py-3 text-sm font-extrabold text-slate-700 ring-1 ring-white transition hover:bg-white hover:text-teal-700">
                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
                Dashboard
            </a>
        </div>
    </section>

    @if (session('status') === 'profile-updated')
        <div class="mt-5 rounded-2xl border border-green-200 bg-green-50 px-5 py-4 font-semibold text-green-700">
            Profil berhasil diperbarui.
        </div>
    @endif

    @if (session('status') === 'password-updated')
        <div class="mt-5 rounded-2xl border border-green-200 bg-green-50 px-5 py-4 font-semibold text-green-700">
            Password berhasil diperbarui.
        </div>
    @endif

    <div class="mt-6 grid gap-6 lg:grid-cols-[1.1fr_.9fr]">
        <section class="{{ $glassClass }} rounded-[1.5rem] p-6 md:p-8">
            <div class="mb-6">
                <p class="text-sm font-extrabold uppercase tracking-[0.16em] text-teal-700">Identitas</p>
                <h3 class="mt-2 text-2xl font-extrabold text-slate-950">Informasi Profil</h3>
            </div>

            <form method="POST" action="{{ route($profileUpdateRoute) }}" class="space-y-5">
                @csrf
                @method('PATCH')

                <div>
                    <label for="name" class="mb-2 block text-sm font-extrabold text-slate-700">Nama</label>
                    <input id="name" name="name" type="text" value="{{ old('name', $user->name) }}" autocomplete="name" class="block w-full rounded-2xl border border-white/70 bg-white/75 px-4 py-3 text-sm font-semibold text-slate-800 shadow-sm outline-none transition focus:border-teal-400 focus:ring-4 focus:ring-teal-500/10 @error('name') border-red-300 @enderror" required autofocus>
                    @error('name') <p class="mt-2 text-xs font-bold text-red-600">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label for="email" class="mb-2 block text-sm font-extrabold text-slate-700">Email</label>
                    <input id="email" name="email" type="email" value="{{ old('email', $user->email) }}" autocomplete="username" class="block w-full rounded-2xl border border-white/70 bg-white/75 px-4 py-3 text-sm font-semibold text-slate-800 shadow-sm outline-none transition focus:border-teal-400 focus:ring-4 focus:ring-teal-500/10 @error('email') border-red-300 @enderror" required>
                    @error('email') <p class="mt-2 text-xs font-bold text-red-600">{{ $message }}</p> @enderror
                </div>

                <button type="submit" class="inline-flex items-center justify-center gap-2 rounded-2xl bg-slate-950 px-5 py-3 text-sm font-extrabold text-white shadow-lg shadow-slate-900/20 transition hover:bg-teal-700">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                    </svg>
                    Simpan Profil
                </button>
            </form>
        </section>

        <section class="{{ $glassClass }} rounded-[1.5rem] p-6 md:p-8">
            <div class="mb-6">
                <p class="text-sm font-extrabold uppercase tracking-[0.16em] text-teal-700">Keamanan</p>
                <h3 class="mt-2 text-2xl font-extrabold text-slate-950">Ubah Password</h3>
            </div>

            <form method="POST" action="{{ route('password.update') }}" class="space-y-5">
                @csrf
                @method('PUT')

                <div>
                    <label for="update_password_current_password" class="mb-2 block text-sm font-extrabold text-slate-700">Password Saat Ini</label>
                    <input id="update_password_current_password" name="current_password" type="password" autocomplete="current-password" class="block w-full rounded-2xl border border-white/70 bg-white/75 px-4 py-3 text-sm font-semibold text-slate-800 shadow-sm outline-none transition focus:border-teal-400 focus:ring-4 focus:ring-teal-500/10 @if ($errors->updatePassword->has('current_password')) border-red-300 @endif">
                    @foreach ($errors->updatePassword->get('current_password') as $message)
                        <p class="mt-2 text-xs font-bold text-red-600">{{ $message }}</p>
                    @endforeach
                </div>

                <div>
                    <label for="update_password_password" class="mb-2 block text-sm font-extrabold text-slate-700">Password Baru</label>
                    <input id="update_password_password" name="password" type="password" autocomplete="new-password" class="block w-full rounded-2xl border border-white/70 bg-white/75 px-4 py-3 text-sm font-semibold text-slate-800 shadow-sm outline-none transition focus:border-teal-400 focus:ring-4 focus:ring-teal-500/10 @if ($errors->updatePassword->has('password')) border-red-300 @endif">
                    @foreach ($errors->updatePassword->get('password') as $message)
                        <p class="mt-2 text-xs font-bold text-red-600">{{ $message }}</p>
                    @endforeach
                </div>

                <div>
                    <label for="update_password_password_confirmation" class="mb-2 block text-sm font-extrabold text-slate-700">Konfirmasi Password Baru</label>
                    <input id="update_password_password_confirmation" name="password_confirmation" type="password" autocomplete="new-password" class="block w-full rounded-2xl border border-white/70 bg-white/75 px-4 py-3 text-sm font-semibold text-slate-800 shadow-sm outline-none transition focus:border-teal-400 focus:ring-4 focus:ring-teal-500/10 @if ($errors->updatePassword->has('password_confirmation')) border-red-300 @endif">
                    @foreach ($errors->updatePassword->get('password_confirmation') as $message)
                        <p class="mt-2 text-xs font-bold text-red-600">{{ $message }}</p>
                    @endforeach
                </div>

                <button type="submit" class="inline-flex items-center justify-center gap-2 rounded-2xl bg-slate-950 px-5 py-3 text-sm font-extrabold text-white shadow-lg shadow-slate-900/20 transition hover:bg-teal-700">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4"/>
                    </svg>
                    Update Password
                </button>
            </form>
        </section>
    </div>

    <section class="{{ $glassClass }} mt-6 rounded-[1.5rem] p-6 md:p-8">
        <div class="flex flex-col justify-between gap-5 md:flex-row md:items-center">
            <div>
                <p class="text-sm font-extrabold uppercase tracking-[0.16em] text-red-600">Zona Berisiko</p>
                <h3 class="mt-2 text-2xl font-extrabold text-slate-950">Hapus Akun</h3>
                <p class="mt-2 max-w-2xl text-sm leading-6 text-slate-600">Aksi ini akan menghapus akun yang sedang login. Gunakan hanya jika benar-benar diperlukan.</p>
            </div>
            <details class="w-full md:w-auto">
                <summary class="inline-flex w-full cursor-pointer items-center justify-center rounded-2xl bg-red-50 px-5 py-3 text-sm font-extrabold text-red-700 ring-1 ring-red-100 transition hover:bg-red-600 hover:text-white md:w-auto">
                    Hapus Akun
                </summary>
                <form method="POST" action="{{ route($profileDestroyRoute) }}" class="mt-4 min-w-[280px] rounded-2xl border border-red-100 bg-red-50 p-4">
                    @csrf
                    @method('DELETE')
                    <label for="delete_password" class="mb-2 block text-sm font-extrabold text-red-800">Konfirmasi Password</label>
                    <input id="delete_password" name="password" type="password" class="block w-full rounded-2xl border border-red-100 bg-white px-4 py-3 text-sm font-semibold text-slate-800 outline-none focus:border-red-300 focus:ring-4 focus:ring-red-500/10" placeholder="Password akun">
                    @foreach ($errors->userDeletion->get('password') as $message)
                        <p class="mt-2 text-xs font-bold text-red-600">{{ $message }}</p>
                    @endforeach
                    <button type="submit" class="mt-4 w-full rounded-2xl bg-red-600 px-5 py-3 text-sm font-extrabold text-white transition hover:bg-red-700" onclick="return confirm('Yakin ingin menghapus akun ini?');">
                        Konfirmasi Hapus
                    </button>
                </form>
            </details>
        </div>
    </section>
</div>
@endsection

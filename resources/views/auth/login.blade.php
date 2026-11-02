<x-guest-layout>
    <div class="mb-8 text-center">
        <div class="mx-auto mb-5 flex h-20 w-20 items-center justify-center rounded-3xl bg-white/80 shadow-lg ring-1 ring-white">
            <img src="{{ asset('path/logo.png') }}" alt="Logo STIKes" class="h-14 w-14 object-contain">
        </div>
        <p class="text-xs font-extrabold uppercase tracking-[0.22em] text-teal-700">Admin Portal</p>
        <h2 class="mt-3 text-3xl font-extrabold text-slate-950">Login UPMI</h2>
        <p class="mt-2 text-sm font-medium text-slate-500">STIKes Bogor Husada</p>
    </div>

    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <div class="mb-5">
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="mt-2 w-full rounded-2xl border-white/80 bg-white/80 px-4 py-3 shadow-sm focus:border-teal-500 focus:ring-teal-500" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div class="mb-6">
            <x-input-label for="password" :value="__('Password')" />
            <x-text-input id="password" class="mt-2 w-full rounded-2xl border-white/80 bg-white/80 px-4 py-3 shadow-sm focus:border-teal-500 focus:ring-teal-500"
                            type="password"
                            name="password"
                            required autocomplete="current-password" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <div class="mb-6 flex items-center justify-between">
            <label for="remember_me" class="inline-flex items-center">
                <input id="remember_me" type="checkbox" class="h-4 w-4 rounded border-slate-300 text-teal-600 focus:ring-teal-500" name="remember">
                <span class="ml-2 text-sm text-slate-600">{{ __('Ingat Saya') }}</span>
            </label>

            <!-- @if (Route::has('password.request'))
                <a class="text-sm text-blue-600 hover:text-blue-800 hover:underline transition duration-200" href="{{ route('password.request') }}"> {{-- Perbarui styling link --}}
                    {{ __('Lupa Password?') }}
                </a>
            @endif -->
        </div>

        <button type="submit" class="mt-2 flex w-full items-center justify-center rounded-2xl bg-slate-950 px-5 py-3.5 text-sm font-extrabold text-white shadow-xl shadow-slate-900/20 transition hover:bg-teal-700 focus:outline-none focus:ring-2 focus:ring-teal-500 focus:ring-offset-2">
            {{ __('Masuk') }}
        </button>
    </form>

    <p class="mt-8 text-center text-sm text-slate-500">
        Belum punya akun? Silakan hubungi <span class="font-semibold text-teal-700">Admin UPMI</span>.
    </p>
</x-guest-layout>

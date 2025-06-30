<x-guest-layout>
    <div class="text-center mb-8">
        <img src="{{ asset('path/logo.png') }}"  alt="Logo STIKes" class="h-20 w-auto mx-auto mb-4">
        <h2 class="text-3xl font-extrabold text-gray-900">Login UPMI</h2>
        <p class="text-md text-gray-600 mt-1">STIKes Bogor Husada</p>
    </div>

    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <div class="mb-5"> {{-- Tambah mb-5 --}}
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div class="mb-6"> {{-- Ganti mt-4 jadi mb-6 --}}
            <x-input-label for="password" :value="__('Password')" />
            <x-text-input id="password" class="mt-1 w-full"
                            type="password"
                            name="password"
                            required autocomplete="current-password" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <div class="flex items-center justify-between mb-6"> {{-- Ganti block mt-4 jadi flex items-center justify-between mb-6 --}}
            <label for="remember_me" class="inline-flex items-center">
                <input id="remember_me" type="checkbox" class="h-4 w-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500" name="remember"> {{-- Perbarui styling checkbox --}}
                <span class="ml-2 text-sm text-gray-700">{{ __('Ingat Saya') }}</span> {{-- Ganti ms-2 jadi ml-2 dan teks --}}
            </label>

            <!-- @if (Route::has('password.request'))
                <a class="text-sm text-blue-600 hover:text-blue-800 hover:underline transition duration-200" href="{{ route('password.request') }}"> {{-- Perbarui styling link --}}
                    {{ __('Lupa Password?') }}
                </a>
            @endif -->
        </div>

        <x-primary-button class="mt-4"> {{-- Hapus ms-3 dan ubah styling di komponen --}}
            {{ __('Masuk') }}
        </x-primary-button>
    </form>

    <p class="text-center text-sm text-gray-600 mt-8"> {{-- Tambah mt-8 --}}
        Belum punya akun? Silakan hubungi <span class="font-medium text-blue-600">Admin UPMI</span>.
    </p>
</x-guest-layout>
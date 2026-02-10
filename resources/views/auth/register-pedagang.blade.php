<x-guest-layout>
    <div class="bg-white rounded-lg shadow-md p-8">
        <!-- Header -->
        <div class="mb-8 text-center">
            <h2 class="text-3xl font-black text-orange-500 mb-2">Daftar Pedagang</h2>
            <p class="text-gray-600 font-semibold">Step 1 dari 2 - Buat Akun Anda</p>
        </div>

    <form method="POST" action="{{ route('register-pedagang.store') }}">
        @csrf

        <!-- Nama Lengkap -->
        <div class="mb-6">
            <x-input-label for="nama" :value="__('Nama Lengkap')" />
            <x-text-input 
                id="nama" 
                class="block mt-2 w-full" 
                type="text" 
                name="nama" 
                :value="old('nama')" 
                required 
                autofocus 
                autocomplete="name"
                placeholder="Masukkan nama lengkap Anda"
            />
            <x-input-error :messages="$errors->get('nama')" class="mt-2" />
        </div>

        <!-- Email -->
        <div class="mb-6">
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input 
                id="email" 
                class="block mt-2 w-full" 
                type="email" 
                name="email" 
                :value="old('email')" 
                required 
                autocomplete="username"
                placeholder="contoh@email.com"
            />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
            <p class="mt-1 text-[10px] text-gray-500">Email akan digunakan untuk login dan verifikasi</p>
        </div>

        <!-- Password -->
        <div class="mb-6">
            <x-input-label for="password" :value="__('Password')" />
            <x-text-input 
                id="password" 
                class="block mt-2 w-full" 
                type="password" 
                name="password" 
                required 
                autocomplete="new-password"
                placeholder="Minimal 8 karakter"
            />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div class="mb-8">
            <x-input-label for="password_confirmation" :value="__('Konfirmasi Password')" />
            <x-text-input 
                id="password_confirmation" 
                class="block mt-2 w-full" 
                type="password" 
                name="password_confirmation" 
                required 
                autocomplete="new-password"
                placeholder="Ulangi password Anda"
            />
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <!-- Info -->
        <div class="mb-8 p-4 bg-blue-50 border border-blue-200 rounded-lg">
            <p class="text-blue-700 text-sm font-semibold">ℹ️ Informasi Pendaftaran Pedagang</p>
            <ul class="mt-3 text-blue-600 text-xs space-y-2 list-disc list-inside">
                <li>Setelah akun dibuat, Anda harus mengisi profil toko dan lokasi</li>
                <li>Lokasi harus berada dalam radius 20 KM dari pusat Tasikmalaya</li>
                <li>Unggah bukti pembayaran pendaftaran (transfer bank)</li>
                <li>Tunggu verifikasi admin untuk aktivasi akun</li>
            </ul>
        </div>

        <!-- Submit Button -->
        <x-primary-button class="w-full justify-center bg-orange-500 hover:bg-orange-600 py-3">
            {{ __('Lanjut ke Step 2') }}
        </x-primary-button>
        </form>

        <!-- Divider -->
        <div class="relative my-6">
            <div class="absolute inset-0 flex items-center">
                <div class="w-full border-t border-gray-200"></div>
            </div>
            <div class="relative flex justify-center text-sm">
                <span class="px-2 bg-white text-gray-500">ATAU</span>
            </div>
        </div>

        <!-- Links -->
        <div class="text-center space-y-4">
            <p class="text-gray-600 text-sm">
                Ingin daftar sebagai pembeli? 
                <a href="{{ route('register.pembeli') }}" class="text-orange-500 hover:text-orange-600 font-bold">
                    Klik di sini
                </a>
            </p>
            <p class="text-gray-600 text-sm">
                Sudah punya akun? 
                <a href="{{ route('login') }}" class="text-orange-500 hover:text-orange-600 font-bold">
                    Masuk di sini
                </a>
            </p>
        </div>
    </div>
</x-guest-layout>

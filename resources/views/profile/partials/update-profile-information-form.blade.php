<section>
    <header class="mb-6">
        <h2 class="text-xl font-bold text-gray-800">
            {{ __('Informasi Profil') }}
        </h2>
        <p class="mt-1 text-sm text-gray-500">
            {{ __("Perbarui nama akun dan alamat email Anda.") }}
        </p>
    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form id="profile-update-form" method="post" action="{{ route('profile.update') }}" class="mt-6 space-y-6">
        @csrf
        @method('patch')

        <div class="space-y-2">
            <x-input-label for="nama" :value="__('Nama Lengkap')" class="font-semibold text-gray-700" />
            <x-text-input id="nama" name="nama" type="text" class="mt-1 block w-full border-gray-200 focus:border-orange-500 focus:ring-orange-500 rounded-2xl shadow-sm" :value="old('nama', $user->nama)" required autofocus autocomplete="name" />
            <x-input-error class="mt-2" :messages="$errors->get('nama')" />
        </div>

        <div class="space-y-2">
            <x-input-label for="email" :value="__('Alamat Email')" class="font-semibold text-gray-700" />
            <x-text-input id="email" name="email" type="email" class="mt-1 block w-full border-gray-200 focus:border-orange-500 focus:ring-orange-500 rounded-2xl shadow-sm" :value="old('email', $user->email)" required autocomplete="username" />
            <x-input-error class="mt-2" :messages="$errors->get('email')" />

            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                <div class="mt-2 p-3 bg-orange-50 rounded-xl border border-orange-100">
                    <p class="text-sm text-orange-800">
                        {{ __('Email Anda belum diverifikasi.') }}
                        <button form="send-verification" class="underline font-bold hover:text-orange-600 focus:outline-none">
                            {{ __('Klik di sini untuk mengirim ulang email verifikasi.') }}
                        </button>
                    </p>
                </div>
            @endif
        </div>

        <div class="flex items-center gap-4">
            <button type="button" onclick="confirmUpdate()" class="px-8 py-3 bg-orange-500 hover:bg-orange-600 text-white font-bold rounded-2xl shadow-lg shadow-orange-200 transition-all active:scale-95">
                {{ __('Simpan Perubahan') }}
            </button>

            @if (session('status') === 'profile-updated')
                <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 3000)"
                   class="text-sm text-green-600 font-bold flex items-center">
                   <svg class="w-5 h-5 mr-1" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
                   {{ __('Berhasil diperbarui!') }}
                </p>
            @endif
        </div>
    </form>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        function confirmUpdate() {
            Swal.fire({
                title: 'Simpan Perubahan?',
                text: "Apakah Anda yakin ingin memperbarui data profil Anda?",
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#f97316', // Warna Orange-500
                cancelButtonColor: '#6b7280',
                confirmButtonText: 'Ya, Simpan!',
                cancelButtonText: 'Batal',
                border: 'none',
                borderRadius: '2rem', // Menyesuaikan dengan gaya JajanYuk
                customClass: {
                    popup: 'rounded-[2rem]',
                    confirmButton: 'rounded-xl px-6 py-3 font-bold',
                    cancelButton: 'rounded-xl px-6 py-3 font-bold'
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('profile-update-form').submit();
                }
            })
        }
    </script>
</section>
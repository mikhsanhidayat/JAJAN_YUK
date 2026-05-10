<section>
    <header class="mb-6">
        <h2 class="text-xl font-bold text-gray-800">
            {{ __('Keamanan Kata Sandi') }}
        </h2>
        <p class="mt-1 text-sm text-gray-500">
            {{ __('Gunakan kata sandi yang kuat untuk menjaga keamanan akun Anda.') }}
        </p>
    </header>

    <form id="password-update-form" method="post" action="{{ route('password.update') }}" class="mt-6 space-y-6">
        @csrf
        @method('put')

        <div class="space-y-2" x-data="{ show: false }">
            <x-input-label for="update_password_current_password" :value="__('Kata Sandi Saat Ini')" class="font-semibold text-gray-700" />
            <div class="relative">
                <x-text-input id="update_password_current_password" name="current_password" ::type="show ? 'text' : 'password'" class="mt-1 block w-full border-gray-200 focus:border-orange-500 focus:ring-orange-500 rounded-2xl shadow-sm pr-10" autocomplete="current-password" />
                <button type="button" @click="show = !show" class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-400 hover:text-orange-500">
                    <svg x-show="!show" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" /></svg>
                    <svg x-show="show" style="display: none;" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.542-7a10.025 10.025 0 014.132-5.411m0 0L21 21m-2.105-2.105a10.048 10.048 0 002.647-3.411c-1.274-4.057-5.064-7-9.542-7-1.274 0-2.483.257-3.582.721m0 0L12 12" /></svg>
                </button>
            </div>
            <x-input-error :messages="$errors->updatePassword->get('current_password')" class="mt-2" />
        </div>

        <div class="space-y-2" x-data="{ show: false }">
            <x-input-label for="update_password_password" :value="__('Kata Sandi Baru')" class="font-semibold text-gray-700" />
            <div class="relative">
                <x-text-input id="update_password_password" name="password" ::type="show ? 'text' : 'password'" class="mt-1 block w-full border-gray-200 focus:border-orange-500 focus:ring-orange-500 rounded-2xl shadow-sm pr-10" autocomplete="new-password" />
                <button type="button" @click="show = !show" class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-400 hover:text-orange-500">
                    <svg x-show="!show" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" /></svg>
                    <svg x-show="show" style="display: none;" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.542-7a10.025 10.025 0 014.132-5.411m0 0L21 21m-2.105-2.105a10.048 10.048 0 002.647-3.411c-1.274-4.057-5.064-7-9.542-7-1.274 0-2.483.257-3.582.721m0 0L12 12" /></svg>
                </button>
            </div>
            <x-input-error :messages="$errors->updatePassword->get('password')" class="mt-2" />
        </div>

        <div class="space-y-2" x-data="{ show: false }">
            <x-input-label for="update_password_password_confirmation" :value="__('Konfirmasi Kata Sandi Baru')" class="font-semibold text-gray-700" />
            <div class="relative">
                <x-text-input id="update_password_password_confirmation" name="password_confirmation" ::type="show ? 'text' : 'password'" class="mt-1 block w-full border-gray-200 focus:border-orange-500 focus:ring-orange-500 rounded-2xl shadow-sm pr-10" autocomplete="new-password" />
                <button type="button" @click="show = !show" class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-400 hover:text-orange-500">
                    <svg x-show="!show" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" /></svg>
                    <svg x-show="show" style="display: none;" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.542-7a10.025 10.025 0 014.132-5.411m0 0L21 21m-2.105-2.105a10.048 10.048 0 002.647-3.411c-1.274-4.057-5.064-7-9.542-7-1.274 0-2.483.257-3.582.721m0 0L12 12" /></svg>
                </button>
            </div>
            <x-input-error :messages="$errors->updatePassword->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="flex items-center gap-4">
            <button type="button" onclick="confirmPasswordUpdate()" class="px-8 py-3 bg-orange-500 hover:bg-orange-600 text-white font-bold rounded-2xl shadow-lg shadow-orange-200 transition-all active:scale-95">
                {{ __('Simpan Kata Sandi') }}
            </button>

            @if (session('status') === 'password-updated')
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
        function confirmPasswordUpdate() {
            const currentPassword = document.getElementById('update_password_current_password').value;
            const newPassword = document.getElementById('update_password_password').value;
            const confirmPassword = document.getElementById('update_password_password_confirmation').value;

            // Validasi: Cek apakah ada field yang kosong
            if (!currentPassword || !newPassword || !confirmPassword) {
                Swal.fire({
                    title: 'Input Belum Lengkap!',
                    text: 'Anda belum mengisi salah satu inputan. Mohon lengkapi semua field.',
                    icon: 'warning',
                    confirmButtonColor: '#f97316',
                    confirmButtonText: 'Lengkapi Sekarang',
                    customClass: {
                        popup: 'rounded-[2rem]',
                        confirmButton: 'rounded-xl px-6 py-3 font-bold'
                    }
                });
                return;
            }

            // Validasi: Cek kesesuaian kata sandi baru
            if (newPassword !== confirmPassword) {
                Swal.fire({
                    title: 'Konfirmasi Tidak Sesuai!',
                    text: 'Konfirmasi kata sandi baru tidak sesuai dengan kata sandi yang Anda masukkan.',
                    icon: 'error',
                    confirmButtonColor: '#f97316',
                    confirmButtonText: 'Periksa Kembali',
                    customClass: {
                        popup: 'rounded-[2rem]',
                        confirmButton: 'rounded-xl px-6 py-3 font-bold'
                    }
                });
                return;
            }

            // Modal Konfirmasi
            Swal.fire({
                title: 'Perbarui Kata Sandi?',
                text: "Pastikan Anda mengingat kata sandi baru yang akan disimpan.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#f97316',
                cancelButtonColor: '#6b7280',
                confirmButtonText: 'Ya, Perbarui!',
                cancelButtonText: 'Batal',
                customClass: {
                    popup: 'rounded-[2rem]',
                    confirmButton: 'rounded-xl px-6 py-3 font-bold',
                    cancelButton: 'rounded-xl px-6 py-3 font-bold'
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('password-update-form').submit();
                }
            })
        }
    </script>

    @if ($errors->updatePassword->any())
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                let errorMessage = '{{ $errors->updatePassword->first() }}';
                
                // Kustomisasi pesan jika password saat ini salah
                if (errorMessage.toLowerCase().includes('current password') || errorMessage.toLowerCase().includes('kata sandi saat ini')) {
                    errorMessage = 'Kata sandi saat ini yang Anda masukkan tidak sesuai.';
                }

                Swal.fire({
                    title: 'Gagal Memperbarui!',
                    text: errorMessage,
                    icon: 'error',
                    confirmButtonColor: '#f97316',
                    confirmButtonText: 'Perbaiki',
                    customClass: {
                        popup: 'rounded-[2rem]',
                        confirmButton: 'rounded-xl px-6 py-3 font-bold'
                    }
                });
            });
        </script>
    @endif
</section>
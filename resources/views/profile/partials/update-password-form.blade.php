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

        <div class="space-y-2">
            <x-input-label for="update_password_current_password" :value="__('Kata Sandi Saat Ini')" class="font-semibold text-gray-700" />
            <x-text-input id="update_password_current_password" name="current_password" type="password" class="mt-1 block w-full border-gray-200 focus:border-orange-500 focus:ring-orange-500 rounded-2xl shadow-sm" autocomplete="current-password" />
            <x-input-error :messages="$errors->updatePassword->get('current_password')" class="mt-2" />
        </div>

        <div class="space-y-2">
            <x-input-label for="update_password_password" :value="__('Kata Sandi Baru')" class="font-semibold text-gray-700" />
            <x-text-input id="update_password_password" name="password" type="password" class="mt-1 block w-full border-gray-200 focus:border-orange-500 focus:ring-orange-500 rounded-2xl shadow-sm" autocomplete="new-password" />
            <x-input-error :messages="$errors->updatePassword->get('password')" class="mt-2" />
        </div>

        <div class="space-y-2">
            <x-input-label for="update_password_password_confirmation" :value="__('Konfirmasi Kata Sandi Baru')" class="font-semibold text-gray-700" />
            <x-text-input id="update_password_password_confirmation" name="password_confirmation" type="password" class="mt-1 block w-full border-gray-200 focus:border-orange-500 focus:ring-orange-500 rounded-2xl shadow-sm" autocomplete="new-password" />
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
            Swal.fire({
                title: 'Perbarui Kata Sandi?',
                text: "Pastikan Anda mengingat kata sandi baru yang akan disimpan.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#f97316', // Warna oranye khas JajanYuk
                cancelButtonColor: '#6b7280',
                confirmButtonText: 'Ya, Perbarui!',
                cancelButtonText: 'Batal',
                customClass: {
                    popup: 'rounded-[2rem]', // Menyesuaikan kelengkungan kartu dashboard
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
</section>
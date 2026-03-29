<section class="space-y-6">
    <header>
        <h2 class="text-xl font-bold text-red-600">
            {{ __('Hapus Akun') }}
        </h2>
        <p class="mt-1 text-sm text-gray-500">
            {{ __('Setelah akun dihapus, semua data akan hilang permanen. Harap unduh data penting sebelum melanjutkan.') }}
        </p>
    </header>

    <button 
        x-data="" 
        x-on:click.prevent="confirmAccountDeletion"
        class="px-6 py-3 bg-red-50 text-red-600 border border-red-200 font-bold rounded-2xl hover:bg-red-600 hover:text-white transition-all active:scale-95"
    >
        {{ __('Hapus Akun Saya') }}
    </button>

    <x-modal name="confirm-user-deletion" :show="$errors->userDeletion->isNotEmpty()" focusable>
        <form method="post" action="{{ route('profile.destroy') }}" class="p-8 bg-white rounded-[2rem]">
            @csrf
            @method('delete')

            <h2 class="text-2xl font-black text-gray-800">
                {{ __('Apakah Anda yakin?') }}
            </h2>

            <p class="mt-3 text-sm text-gray-500 leading-relaxed">
                {{ __('Tindakan ini tidak dapat dibatalkan. Masukkan kata sandi Anda untuk mengonfirmasi penghapusan akun secara permanen.') }}
            </p>

            <div class="mt-6">
                <x-input-label for="password" value="{{ __('Password') }}" class="sr-only" />
                <x-text-input
                    id="password"
                    name="password"
                    type="password"
                    class="mt-1 block w-full border-gray-200 focus:border-red-500 focus:ring-red-500 rounded-2xl py-3"
                    placeholder="{{ __('Masukkan Kata Sandi Anda') }}"
                />
                <x-input-error :messages="$errors->userDeletion->get('password')" class="mt-2" />
            </div>

            <div class="mt-8 flex justify-end gap-3">
                <button type="button" x-on:click="$dispatch('close')" class="px-6 py-3 bg-gray-100 text-gray-600 font-bold rounded-2xl hover:bg-gray-200 transition-all">
                    {{ __('Batal') }}
                </button>

                <button type="submit" class="px-6 py-3 bg-red-600 text-white font-bold rounded-2xl shadow-lg shadow-red-200 hover:bg-red-700 transition-all active:scale-95">
                    {{ __('Ya, Hapus Akun') }}
                </button>
            </div>
        </form>
    </x-modal>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        function confirmAccountDeletion() {
            Swal.fire({
                title: 'Hapus Akun Permanen?',
                text: "Anda akan kehilangan akses ke seluruh layanan JajanYuk. Tindakan ini tidak bisa dibatalkan!",
                icon: 'error',
                showCancelButton: true,
                confirmButtonColor: '#dc2626', // Warna Merah (Red-600)
                cancelButtonColor: '#6b7280',
                confirmButtonText: 'Ya, Lanjutkan',
                cancelButtonText: 'Batal',
                customClass: {
                    popup: 'rounded-[2rem]', // Menyesuaikan kelengkungan desain dashboard
                    confirmButton: 'rounded-xl px-6 py-3 font-bold',
                    cancelButton: 'rounded-xl px-6 py-3 font-bold'
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    // Jika dikonfirmasi, buka modal asli Laravel Breeze untuk input password
                    window.dispatchEvent(new CustomEvent('open-modal', { detail: 'confirm-user-deletion' }));
                }
            })
        }
    </script>
</section>
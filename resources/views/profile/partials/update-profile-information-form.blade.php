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

    <form id="profile-update-form" method="post" action="{{ route('profile.update') }}" class="mt-6 space-y-6" enctype="multipart/form-data">
        @csrf
        @method('patch')

        <!-- Profile Photo Section -->
        <div class="flex flex-col items-center sm:flex-row sm:items-center gap-6 pb-6 border-b border-gray-50">
            <div class="relative group">
                <div class="w-24 h-24 sm:w-28 sm:h-28 rounded-[2rem] overflow-hidden border-4 border-white shadow-xl shadow-orange-100 ring-1 ring-orange-50 bg-gray-50">
                    <img id="photo-preview" 
                        src="{{ $user->foto_profil ? asset('storage/' . $user->foto_profil) : 'https://ui-avatars.com/api/?name=' . urlencode($user->nama) . '&background=fff7ed&color=f97316&bold=true' }}" 
                        class="w-full h-full object-cover transition-transform group-hover:scale-110 duration-500">
                </div>
                <label for="foto_profil" class="absolute -bottom-2 -right-2 bg-orange-500 hover:bg-orange-600 text-white p-2.5 rounded-2xl shadow-lg cursor-pointer transition-all active:scale-90 ring-4 ring-white">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                    <input type="file" id="foto_profil" name="foto_profil" class="hidden" accept="image/*" onchange="previewImage(this)">
                </label>
            </div>
            <div>
                <h4 class="text-sm font-bold text-gray-800">Foto Profil</h4>
                <p class="text-[11px] text-gray-500 mt-1 max-w-[200px]">Format: JPG, PNG, atau GIF. Maksimal 2MB.</p>
                <button type="button" onclick="document.getElementById('foto_profil').click()" class="mt-3 text-[11px] font-bold text-orange-500 hover:text-orange-600 uppercase tracking-widest">Ganti Foto</button>
            </div>
        </div>

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
        // Simpan nilai awal untuk deteksi perubahan
        const initialValues = {
            nama: document.getElementById('nama').value,
            email: document.getElementById('email').value,
            photo: null
        };

        function previewImage(input) {
            const preview = document.getElementById('photo-preview');
            if (input.files && input.files[0]) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    preview.src = e.target.result;
                    initialValues.photo = e.target.result; // Mark as changed
                }
                reader.readAsDataURL(input.files[0]);
            }
        }

        function confirmUpdate() {
            const currentNama = document.getElementById('nama').value.trim();
            const currentEmail = document.getElementById('email').value.trim();

            // Validasi: Cek apakah inputan kosong
            if (!currentNama || !currentEmail) {
                Swal.fire({
                    title: 'Input Kosong!',
                    text: 'Semua field harus diisi.',
                    icon: 'warning',
                    confirmButtonColor: '#f97316',
                    confirmButtonText: 'Mengerti',
                    customClass: {
                        popup: 'rounded-[2rem]',
                        confirmButton: 'rounded-xl px-6 py-3 font-bold'
                    }
                });
                return;
            }

            // Validasi: Cek apakah ada perubahan
            if (currentNama === initialValues.nama && currentEmail === initialValues.email && initialValues.photo === null) {
                Swal.fire({
                    title: 'Tidak Ada Perubahan',
                    text: 'Anda belum mengubah apapun pada data profil.',
                    icon: 'info',
                    confirmButtonColor: '#f97316',
                    confirmButtonText: 'Oke',
                    customClass: {
                        popup: 'rounded-[2rem]',
                        confirmButton: 'rounded-xl px-6 py-3 font-bold'
                    }
                });
                return;
            }

            // Modal Konfirmasi
            Swal.fire({
                title: 'Simpan Perubahan?',
                text: "Apakah Anda yakin ingin memperbarui data profil Anda?",
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#f97316', 
                cancelButtonColor: '#6b7280',
                confirmButtonText: 'Ya, Simpan!',
                cancelButtonText: 'Batal',
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

    @if ($errors->any())
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                Swal.fire({
                    title: 'Terjadi Kesalahan!',
                    text: '{{ $errors->first() }}',
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
<x-guest-layout>
    <div class="bg-white rounded-lg shadow-md p-8">
        <!-- Header -->
        <div class="mb-8 text-center">
            <h2 class="text-4xl font-black text-orange-500 mb-2">🎉 JajanYuk</h2>
            <p class="text-gray-600 text-lg font-semibold">Pilih jenis akun yang ingin kamu buat</p>
            <p class="text-gray-500 text-sm mt-2">Nikmati pengalaman jajanan lokal terbaik di Tasikmalaya</p>
        </div>

        <!-- Error Messages -->
        @if ($errors->any())
            <div class="mb-6 p-4 bg-red-50 border border-red-200 rounded-lg">
                <p class="text-red-600 font-semibold">⚠️ Ada kesalahan:</p>
                <ul class="mt-2 list-disc list-inside text-red-600 text-sm">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- Role Selection Cards -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
            <!-- Pembeli Card -->
            <a href="{{ route('register.pembeli') }}" class="group">
                <div class="p-8 border-2 border-gray-200 rounded-xl text-center hover:border-orange-500 hover:bg-orange-50 transition-all duration-300 h-full flex flex-col justify-between shadow-sm hover:shadow-lg">
                    <div>
                        <div class="mb-4 text-6xl">🛍️</div>
                        <h3 class="text-2xl font-bold text-gray-800 group-hover:text-orange-600 mb-2">Pembeli</h3>
                        <p class="text-gray-600 text-sm mb-4">Cari dan nikmati jajanan dari pedagang terdekat</p>
                    </div>
                    
                    <ul class="mt-6 text-left text-gray-600 text-sm space-y-3 mb-6">
                        <li class="flex items-start">
                            <span class="text-orange-500 mr-2 font-bold">✓</span>
                            <span>Gratis (tanpa biaya)</span>
                        </li>
                        <li class="flex items-start">
                            <span class="text-orange-500 mr-2 font-bold">✓</span>
                            <span>Akses langsung ke Dashboard</span>
                        </li>
                        <li class="flex items-start">
                            <span class="text-orange-500 mr-2 font-bold">✓</span>
                            <span>Lihat pedagang di sekitar Tasikmalaya</span>
                        </li>
                        <li class="flex items-start">
                            <span class="text-orange-500 mr-2 font-bold">✓</span>
                            <span>Filter jajanan berdasarkan kategori</span>
                        </li>
                    </ul>

                    <button type="button" class="w-full bg-orange-500 hover:bg-orange-600 text-white font-bold py-3 px-4 rounded-lg transition-colors duration-200">
                        Daftar sebagai Pembeli →
                    </button>
                </div>
            </a>

            <!-- Pedagang Card -->
            <a href="{{ route('register-pedagang') }}" class="group">
                <div class="p-8 border-2 border-gray-200 rounded-xl text-center hover:border-green-500 hover:bg-green-50 transition-all duration-300 h-full flex flex-col justify-between shadow-sm hover:shadow-lg">
                    <div>
                        <div class="mb-4 text-6xl">🛒</div>
                        <h3 class="text-2xl font-bold text-gray-800 group-hover:text-green-600 mb-2">Pedagang</h3>
                        <p class="text-gray-600 text-sm mb-4">Jual jajananmu ke ribuan pembeli Tasikmalaya</p>
                    </div>
                    
                    <ul class="mt-6 text-left text-gray-600 text-sm space-y-3 mb-6">
                        <li class="flex items-start">
                            <span class="text-green-500 mr-2 font-bold">✓</span>
                            <span>Pendaftaran diperlukan verifikasi</span>
                        </li>
                        <li class="flex items-start">
                            <span class="text-green-500 mr-2 font-bold">✓</span>
                            <span>Lokasi harus di Tasikmalaya</span>
                        </li>
                        <li class="flex items-start">
                            <span class="text-green-500 mr-2 font-bold">✓</span>
                            <span>Unggah bukti pembayaran</span>
                        </li>
                        <li class="flex items-start">
                            <span class="text-green-500 mr-2 font-bold">✓</span>
                            <span>Kelola menu dan kategori jajanan</span>
                        </li>
                    </ul>

                    <button type="button" class="w-full bg-green-500 hover:bg-green-600 text-white font-bold py-3 px-4 rounded-lg transition-colors duration-200">
                        Daftar sebagai Pedagang →
                    </button>
                </div>
            </a>
        </div>

        <!-- Divider -->
        <div class="relative mb-8">
            <div class="absolute inset-0 flex items-center">
                <div class="w-full border-t border-gray-200"></div>
            </div>
            <div class="relative flex justify-center text-sm">
                <span class="px-2 bg-white text-gray-600">ATAU</span>
            </div>
        </div>

        <!-- Link ke Login -->
        <div class="text-center">
            <p class="text-gray-700 font-semibold mb-3">
                Sudah punya akun?
            </p>
            <a href="{{ route('login') }}" class="inline-block px-8 py-3 border-2 border-gray-300 hover:border-orange-500 text-gray-700 hover:text-orange-600 font-bold rounded-lg transition-colors duration-200">
                Masuk di sini
            </a>
        </div>
    </div>
</x-guest-layout>

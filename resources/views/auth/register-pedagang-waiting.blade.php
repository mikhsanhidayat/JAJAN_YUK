<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-gray-800 leading-tight">
            {{ __('✅ Menunggu Verifikasi') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <!-- Success Alert -->
            <div class="mb-6 p-6 bg-green-50 border border-green-200 rounded-lg">
                <div class="flex items-start">
                    <div class="flex-shrink-0">
                        <svg class="h-8 w-8 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <div class="ml-4">
                        <h3 class="text-lg font-bold text-green-700 mb-1">Pendaftaran Anda Diterima!</h3>
                        <p class="text-green-600 text-sm">Data Anda sedang menunggu verifikasi dari tim admin kami. Kami akan memproses dalam waktu 1-2 hari kerja.</p>
                    </div>
                </div>
            </div>

            <!-- Status Card -->
            <div class="bg-white rounded-lg shadow-sm p-6 mb-6 border border-gray-200">
                <h3 class="text-lg font-bold text-gray-800 mb-4">📊 Status Pendaftaran Anda</h3>
                
                <div class="space-y-4">
                    <!-- Payment Status -->
                    <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                        <div class="flex items-center">
                            <span class="text-2xl mr-3">💳</span>
                            <div>
                                <p class="font-semibold text-gray-800">Status Pembayaran</p>
                                <p class="text-gray-600 text-sm">Bukti transfer sudah dikirimkan</p>
                            </div>
                        </div>
                        <span class="px-3 py-1 bg-yellow-100 text-yellow-800 text-xs font-semibold rounded-full">
                            Menunggu
                        </span>
                    </div>

                    <!-- Admin Verification Status -->
                    <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                        <div class="flex items-center">
                            <span class="text-2xl mr-3">👤</span>
                            <div>
                                <p class="font-semibold text-gray-800">Verifikasi Admin</p>
                                <p class="text-gray-600 text-sm">Menunggu admin mengecek dokumen Anda</p>
                            </div>
                        </div>
                        <span class="px-3 py-1 bg-yellow-100 text-yellow-800 text-xs font-semibold rounded-full">
                            Pending
                        </span>
                    </div>

                    <!-- Activation Status -->
                    <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                        <div class="flex items-center">
                            <span class="text-2xl mr-3">🟢</span>
                            <div>
                                <p class="font-semibold text-gray-800">Status Toko</p>
                                <p class="text-gray-600 text-sm">Akan aktif setelah diverifikasi</p>
                            </div>
                        </div>
                        <span class="px-3 py-1 bg-red-100 text-red-800 text-xs font-semibold rounded-full">
                            Tidak Aktif
                        </span>
                    </div>
                </div>
            </div>

            <!-- Info Box -->
            <div class="bg-white rounded-lg shadow-sm p-6 mb-6 border border-blue-200 bg-blue-50">
                <h3 class="font-semibold text-blue-700 mb-3">ℹ️ Apa yang Terjadi Selanjutnya?</h3>
                <ol class="space-y-2 text-blue-600 text-sm list-decimal list-inside">
                    <li>Admin akan memeriksa bukti pembayaran Anda dalam waktu 1-2 hari kerja</li>
                    <li>Admin akan memverifikasi informasi lokasi dan foto gerobak Anda</li>
                    <li>Jika semuanya valid, akun Anda akan diaktifkan otomatis</li>
                    <li>Setelah diaktifkan, toko Anda akan muncul di peta untuk pembeli di sekitar Tasikmalaya</li>
                    <li>Anda dapat menambahkan menu jajanan setelah toko aktif</li>
                </ol>
            </div>

            <!-- Pedagang Info Card -->
            <div class="bg-white rounded-lg shadow-sm p-6 mb-6 border border-gray-200">
                <h3 class="text-lg font-bold text-gray-800 mb-4">🏪 Informasi Toko Anda</h3>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <p class="text-gray-600 text-sm font-semibold">Nama Toko</p>
                        <p class="text-gray-800">{{ $pedagang->nama_toko }}</p>
                    </div>
                    
                    @if($pedagang->jenis_jajanan)
                    <div>
                        <p class="text-gray-600 text-sm font-semibold">Jenis Jajanan</p>
                        <p class="text-gray-800">{{ $pedagang->jenis_jajanan }}</p>
                    </div>
                    @endif
                    
                    <div>
                        <p class="text-gray-600 text-sm font-semibold">Lokasi</p>
                        <p class="text-gray-800 text-sm">
                            Lat: {{ $pedagang->latitude }}<br>
                            Lng: {{ $pedagang->longitude }}
                        </p>
                    </div>
                    
                    @if($pedagang->foto_gerobak)
                    <div>
                        <p class="text-gray-600 text-sm font-semibold">Foto Gerobak</p>
                        <p class="text-gray-800 text-sm">
                            <a href="{{ Storage::url($pedagang->foto_gerobak) }}" target="_blank" class="text-orange-500 hover:text-orange-600 font-semibold">Lihat Foto</a>
                        </p>
                    </div>
                    @endif
            </div>

            <!-- Contact Info -->
            <div class="bg-white rounded-lg shadow-sm p-6 mb-8 border border-gray-200">
                <h3 class="font-semibold text-gray-800 mb-3 text-lg">📞 Butuh Bantuan?</h3>
                <p class="text-gray-600 text-sm mb-4">Jika ada pertanyaan atau butuh bantuan, silakan hubungi kami:</p>
                <ul class="text-sm text-gray-700 space-y-2">
                    <li class="flex items-center"><span class="mr-2">📧</span> Email: support@jajanyuk.com</li>
                    <li class="flex items-center"><span class="mr-2">📱</span> WhatsApp: +62 XXX XXXX XXXX</li>
                    <li class="flex items-center"><span class="mr-2">⏰</span> Jam Operasional: 09:00 - 17:00 (Senin-Jumat)</li>
                </ul>
            </div>

            <!-- Action Buttons -->
            <div class="flex items-center justify-between gap-4 pt-6 border-t border-gray-200">
                <a href="{{ route('dashboard') }}" class="flex-1 px-6 py-3 bg-blue-500 hover:bg-blue-600 text-white font-semibold rounded-lg transition text-center">
                    📊 Ke Dashboard
                </a>
                <form method="POST" action="{{ route('logout') }}" class="flex-1">
                    @csrf
                    <button type="submit" class="w-full px-6 py-3 bg-red-500 hover:bg-red-600 text-white font-semibold rounded-lg transition">
                        🚪 Logout
                    </button>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>

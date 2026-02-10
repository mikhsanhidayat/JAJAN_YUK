<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Detail Verifikasi - ') . $pedagang->nama_toko }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    
                    <!-- Header -->
                    <div class="mb-6 pb-6 border-b border-gray-200">
                        <div class="flex items-start justify-between">
                            <div>
                                <h1 class="text-3xl font-bold text-gray-800">{{ $pedagang->nama_toko }}</h1>
                                <p class="text-gray-600 text-sm mt-1">{{ $pedagang->user->nama }} ({{ $pedagang->user->email }})</p>
                            </div>
                            <span class="px-4 py-2 bg-yellow-100 text-yellow-800 text-sm font-semibold rounded-full">
                                ⏳ Menunggu Verifikasi
                            </span>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                        <!-- Data Toko -->
                        <div class="bg-gray-50 p-4 rounded-lg">
                            <h3 class="font-bold text-gray-800 mb-3">📋 Data Toko</h3>
                            <div class="space-y-2 text-sm">
                                <div>
                                    <p class="text-gray-500 font-semibold">Nama Toko</p>
                                    <p class="text-gray-800">{{ $pedagang->nama_toko }}</p>
                                </div>
                                <div>
                                    <p class="text-gray-500 font-semibold">Jenis Jajanan</p>
                                    <p class="text-gray-800">{{ $pedagang->jenis_jajanan ?? '-' }}</p>
                                </div>
                                <div>
                                    <p class="text-gray-500 font-semibold">Tanggal Daftar</p>
                                    <p class="text-gray-800">{{ $pedagang->created_at->format('d M Y H:i') }}</p>
                                </div>
                            </div>
                        </div>

                        <!-- Lokasi -->
                        <div class="bg-gray-50 p-4 rounded-lg">
                            <h3 class="font-bold text-gray-800 mb-3">📍 Lokasi</h3>
                            <div class="space-y-2 text-sm">
                                <div>
                                    <p class="text-gray-500 font-semibold">Latitude</p>
                                    <p class="text-gray-800 font-mono">{{ $pedagang->latitude }}</p>
                                </div>
                                <div>
                                    <p class="text-gray-500 font-semibold">Longitude</p>
                                    <p class="text-gray-800 font-mono">{{ $pedagang->longitude }}</p>
                                </div>
                                <div>
                                    <p class="text-gray-500 font-semibold">Dalam Radius</p>
                                    <p class="text-green-600 font-semibold">✓ Ya</p>
                                </div>
                            </div>
                        </div>

                        <!-- Status -->
                        <div class="bg-gray-50 p-4 rounded-lg">
                            <h3 class="font-bold text-gray-800 mb-3">🔔 Status</h3>
                            <div class="space-y-2 text-sm">
                                <div>
                                    <p class="text-gray-500 font-semibold">Pembayaran</p>
                                    <p class="text-orange-600 font-semibold">{{ ucfirst($pedagang->payment_status) }}</p>
                                </div>
                                <div>
                                    <p class="text-gray-500 font-semibold">Verifikasi Admin</p>
                                    <p class="text-orange-600 font-semibold">{{ ucfirst($pedagang->admin_status) }}</p>
                                </div>
                                <div>
                                    <p class="text-gray-500 font-semibold">Status Toko</p>
                                    <p class="text-red-600 font-semibold">🔴 Tidak Aktif</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Foto Gerobak -->
                    @if($pedagang->foto_gerobak)
                    <div class="mb-6 p-4 bg-gray-50 rounded-lg">
                        <h3 class="font-bold text-gray-800 mb-3">📸 Foto Gerobak</h3>
                        <img 
                            src="{{ Storage::url($pedagang->foto_gerobak) }}" 
                            alt="Foto Gerobak {{ $pedagang->nama_toko }}" 
                            class="w-full max-h-96 object-cover rounded-lg"
                        >
                    </div>
                    @endif

                    <!-- Bukti Pembayaran -->
                    @if($pedagang->bukti_pembayaran)
                    <div class="mb-6 p-4 bg-gray-50 rounded-lg">
                        <h3 class="font-bold text-gray-800 mb-3">💳 Bukti Pembayaran</h3>
                        <img 
                            src="{{ Storage::url($pedagang->bukti_pembayaran) }}" 
                            alt="Bukti Pembayaran {{ $pedagang->nama_toko }}" 
                            class="w-full max-h-96 object-cover rounded-lg"
                        >
                    </div>
                    @endif

                    <!-- Catatan Verifikasi -->
                    <div class="mb-6 p-4 bg-blue-50 border border-blue-200 rounded-lg">
                        <h3 class="font-bold text-blue-700 mb-2">📝 Checklist Verifikasi</h3>
                        <ul class="space-y-2 text-sm text-blue-600">
                            <li class="flex items-center">
                                <span class="text-green-600 mr-2">✓</span> Email dan nomor telepon valid
                            </li>
                            <li class="flex items-center">
                                <span class="text-green-600 mr-2">✓</span> Foto gerobak/toko jelas dan sesuai
                            </li>
                            <li class="flex items-center">
                                <span class="text-green-600 mr-2">✓</span> Lokasi berada dalam radius Tasikmalaya
                            </li>
                            <li class="flex items-center">
                                <span class="text-green-600 mr-2">✓</span> Bukti pembayaran valid dan terverifikasi
                            </li>
                            <li class="flex items-center">
                                <span class="text-green-600 mr-2">✓</span> Data toko lengkap dan akurat
                            </li>
                        </ul>
                    </div>

                    <!-- Action Buttons -->
                    <div class="flex gap-4 pt-6 border-t border-gray-200">
                        <form method="POST" action="{{ route('admin.verifikasi.approve', $pedagang->id) }}" class="flex-1" onsubmit="return confirm('Setujui pendaftaran pedagang ini?');">
                            @csrf
                            <button type="submit" class="w-full px-6 py-3 bg-green-500 hover:bg-green-600 text-white font-bold rounded-lg transition">
                                ✓ Setujui Pendaftaran
                            </button>
                        </form>

                        <button 
                            type="button" 
                            onclick="document.getElementById('rejectForm').classList.remove('hidden')"
                            class="flex-1 px-6 py-3 bg-red-500 hover:bg-red-600 text-white font-bold rounded-lg transition"
                        >
                            ✕ Tolak Pendaftaran
                        </button>

                        <a href="{{ route('admin.verifikasi.index') }}" class="flex-1 px-6 py-3 bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold rounded-lg transition text-center">
                            ← Kembali
                        </a>
                    </div>

                    <!-- Reject Form (Hidden) -->
                    <div id="rejectForm" class="hidden mt-6 p-6 bg-red-50 border border-red-200 rounded-lg">
                        <h3 class="text-lg font-bold text-red-700 mb-4">Tolak Pendaftaran</h3>
                        
                        <form method="POST" action="{{ route('admin.verifikasi.reject', $pedagang->id) }}" onsubmit="return confirm('Yakin ingin menolak pendaftaran ini?');">
                            @csrf
                            <div class="mb-4">
                                <label for="reject_reason" class="block text-gray-700 text-sm font-semibold mb-2">Alasan Penolakan</label>
                                <textarea 
                                    id="reject_reason" 
                                    name="reject_reason" 
                                    rows="4" 
                                    class="w-full border border-red-300 rounded-lg px-4 py-2 text-gray-700 focus:outline-none focus:ring-2 focus:ring-red-500"
                                    placeholder="Jelaskan alasan penolakan (foto tidak jelas, lokasi di luar jangkauan, bukti pembayaran tidak valid, dll)"
                                    required
                                ></textarea>
                                <x-input-error :messages="$errors->get('reject_reason')" class="mt-2" />
                            </div>

                            <div class="flex gap-3">
                                <button 
                                    type="button" 
                                    onclick="document.getElementById('rejectForm').classList.add('hidden')"
                                    class="flex-1 px-4 py-2 bg-gray-300 hover:bg-gray-400 text-gray-800 font-semibold rounded-lg transition"
                                >
                                    Batal
                                </button>
                                <button 
                                    type="submit" 
                                    class="flex-1 px-4 py-2 bg-red-500 hover:bg-red-600 text-white font-semibold rounded-lg transition"
                                >
                                    Tolak Pendaftaran
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

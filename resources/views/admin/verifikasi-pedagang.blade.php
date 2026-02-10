<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Admin - Verifikasi Pedagang') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Tabs -->
            <div class="mb-6 border-b border-gray-200">
                <div class="flex space-x-8">
                    <button 
                        id="waitingTab" 
                        class="py-4 px-1 border-b-2 border-orange-500 text-orange-600 font-semibold"
                    >
                        Menunggu Verifikasi ({{ $pedagangsWaiting->total() }})
                    </button>
                    <button 
                        id="approvedTab" 
                        class="py-4 px-1 border-b-2 border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 font-semibold"
                    >
                        Sudah Disetujui ({{ $pedagangsApproved->total() }})
                    </button>
                </div>
            </div>

            <!-- Waiting Verification Tab -->
            <div id="waitingContent" class="space-y-4">
                @if($pedagangsWaiting->count() > 0)
                    @foreach($pedagangsWaiting as $pedagang)
                        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border-l-4 border-yellow-500">
                            <div class="p-6 text-gray-900">
                                <div class="flex items-start justify-between">
                                    <div class="flex-grow">
                                        <!-- Header -->
                                        <div class="flex items-center mb-4">
                                            <div>
                                                <h3 class="text-lg font-bold text-gray-800">{{ $pedagang->nama_toko }}</h3>
                                                <p class="text-gray-600 text-sm">{{ $pedagang->user->nama }} ({{ $pedagang->user->email }})</p>
                                            </div>
                                            <span class="ml-auto px-3 py-1 bg-yellow-100 text-yellow-800 text-xs font-semibold rounded-full">
                                                Pending
                                            </span>
                                        </div>

                                        <!-- Info Grid -->
                                        <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-4">
                                            <div>
                                                <p class="text-gray-600 text-xs font-semibold">Jenis Jajanan</p>
                                                <p class="text-gray-800">{{ $pedagang->jenis_jajanan ?? '-' }}</p>
                                            </div>
                                            <div>
                                                <p class="text-gray-600 text-xs font-semibold">Status Pembayaran</p>
                                                <p class="text-gray-800 font-semibold">{{ ucfirst($pedagang->payment_status) }}</p>
                                            </div>
                                            <div>
                                                <p class="text-gray-600 text-xs font-semibold">Lokasi</p>
                                                <p class="text-gray-800 text-xs">{{ $pedagang->latitude }}, {{ $pedagang->longitude }}</p>
                                            </div>
                                            <div>
                                                <p class="text-gray-600 text-xs font-semibold">Tanggal Daftar</p>
                                                <p class="text-gray-800">{{ $pedagang->created_at->format('d M Y') }}</p>
                                            </div>
                                        </div>

                                        <!-- Files -->
                                        <div class="grid grid-cols-2 gap-4 mb-4">
                                            @if($pedagang->foto_gerobak)
                                            <div>
                                                <p class="text-gray-600 text-xs font-semibold mb-1">Foto Gerobak</p>
                                                <a href="{{ Storage::url($pedagang->foto_gerobak) }}" target="_blank" class="text-blue-500 hover:text-blue-700 text-sm font-semibold">
                                                    👁️ Lihat Foto
                                                </a>
                                            </div>
                                            @endif
                                            @if($pedagang->bukti_pembayaran)
                                            <div>
                                                <p class="text-gray-600 text-xs font-semibold mb-1">Bukti Pembayaran</p>
                                                <a href="{{ Storage::url($pedagang->bukti_pembayaran) }}" target="_blank" class="text-blue-500 hover:text-blue-700 text-sm font-semibold">
                                                    👁️ Lihat Bukti
                                                </a>
                                            </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>

                                <!-- Action Buttons -->
                                <div class="flex gap-3 pt-4 border-t border-gray-200 mt-4">
                                    <a href="{{ route('admin.verifikasi.show', $pedagang->id) }}" class="px-4 py-2 bg-blue-500 hover:bg-blue-600 text-white text-sm font-semibold rounded-lg transition">
                                        👁️ Lihat Detail
                                    </a>
                                    
                                    <form method="POST" action="{{ route('admin.verifikasi.approve', $pedagang->id) }}" class="inline" onsubmit="return confirm('Setujui pendaftaran pedagang ini?');">
                                        @csrf
                                        <button type="submit" class="px-4 py-2 bg-green-500 hover:bg-green-600 text-white text-sm font-semibold rounded-lg transition">
                                            ✓ Setujui
                                        </button>
                                    </form>

                                    <a href="#" class="px-4 py-2 bg-red-500 hover:bg-red-600 text-white text-sm font-semibold rounded-lg transition" onclick="openRejectModal({{ $pedagang->id }})">
                                        ✕ Tolak
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforeach

                    <!-- Pagination -->
                    <div class="mt-6">
                        {{ $pedagangsWaiting->links() }}
                    </div>
                @else
                    <div class="bg-gray-50 border border-gray-200 rounded-lg p-8 text-center">
                        <p class="text-gray-600 font-semibold">✓ Tidak ada pedagang yang menunggu verifikasi</p>
                    </div>
                @endif
            </div>

            <!-- Approved Tab (Hidden by default) -->
            <div id="approvedContent" class="hidden space-y-4">
                @if($pedagangsApproved->count() > 0)
                    @foreach($pedagangsApproved as $pedagang)
                        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border-l-4 border-green-500">
                            <div class="p-6 text-gray-900">
                                <div class="flex items-start justify-between">
                                    <div class="flex-grow">
                                        <!-- Header -->
                                        <div class="flex items-center mb-4">
                                            <div>
                                                <h3 class="text-lg font-bold text-gray-800">{{ $pedagang->nama_toko }}</h3>
                                                <p class="text-gray-600 text-sm">{{ $pedagang->user->nama }} ({{ $pedagang->user->email }})</p>
                                            </div>
                                            <span class="ml-auto px-3 py-1 {{ $pedagang->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }} text-xs font-semibold rounded-full">
                                                {{ $pedagang->is_active ? '🟢 Aktif' : '🔴 Tidak Aktif' }}
                                            </span>
                                        </div>

                                        <!-- Info Grid -->
                                        <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-4">
                                            <div>
                                                <p class="text-gray-600 text-xs font-semibold">Jenis Jajanan</p>
                                                <p class="text-gray-800">{{ $pedagang->jenis_jajanan ?? '-' }}</p>
                                            </div>
                                            <div>
                                                <p class="text-gray-600 text-xs font-semibold">Status Pembayaran</p>
                                                <p class="text-gray-800 font-semibold">✓ Paid</p>
                                            </div>
                                            <div>
                                                <p class="text-gray-600 text-xs font-semibold">Disetujui</p>
                                                <p class="text-gray-800">{{ $pedagang->updated_at->format('d M Y') }}</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Action Buttons -->
                                <div class="flex gap-3 pt-4 border-t border-gray-200 mt-4">
                                    @if($pedagang->is_active)
                                        <form method="POST" action="{{ route('admin.verifikasi.deactivate', $pedagang->id) }}" class="inline" onsubmit="return confirm('Nonaktifkan pedagang ini?');">
                                            @csrf
                                            <button type="submit" class="px-4 py-2 bg-orange-500 hover:bg-orange-600 text-white text-sm font-semibold rounded-lg transition">
                                                🔴 Nonaktifkan
                                            </button>
                                        </form>
                                    @else
                                        <form method="POST" action="{{ route('admin.verifikasi.reactivate', $pedagang->id) }}" class="inline" onsubmit="return confirm('Aktifkan kembali pedagang ini?');">
                                            @csrf
                                            <button type="submit" class="px-4 py-2 bg-green-500 hover:bg-green-600 text-white text-sm font-semibold rounded-lg transition">
                                                🟢 Aktifkan
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach

                    <!-- Pagination -->
                    <div class="mt-6">
                        {{ $pedagangsApproved->links() }}
                    </div>
                @else
                    <div class="bg-gray-50 border border-gray-200 rounded-lg p-8 text-center">
                        <p class="text-gray-600 font-semibold">Tidak ada pedagang yang sudah disetujui</p>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Reject Modal -->
    <div id="rejectModal" class="hidden fixed inset-0 bg-gray-800 bg-opacity-50 z-50 flex items-center justify-center">
        <div class="bg-white rounded-lg p-6 max-w-md mx-auto">
            <h3 class="text-xl font-bold text-gray-800 mb-4">Tolak Pendaftaran</h3>
            
            <form id="rejectForm" method="POST" action="" onsubmit="return confirm('Yakin ingin menolak pendaftaran ini?');">
                @csrf
                <div class="mb-4">
                    <label for="reject_reason" class="block text-gray-600 text-sm font-semibold mb-2">Alasan Penolakan</label>
                    <textarea 
                        id="reject_reason" 
                        name="reject_reason" 
                        rows="4" 
                        class="w-full border border-gray-300 rounded-lg px-3 py-2 text-gray-700 focus:outline-none focus:ring-2 focus:ring-red-500"
                        placeholder="Jelaskan alasan penolakan..."
                        required
                    ></textarea>
                </div>

                <div class="flex gap-3">
                    <button type="button" onclick="closeRejectModal()" class="flex-1 px-4 py-2 bg-gray-300 hover:bg-gray-400 text-gray-800 font-semibold rounded-lg transition">
                        Batal
                    </button>
                    <button type="submit" class="flex-1 px-4 py-2 bg-red-500 hover:bg-red-600 text-white font-semibold rounded-lg transition">
                        Tolak
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function openRejectModal(pedagangId) {
            const form = document.getElementById('rejectForm');
            form.action = `/admin/verifikasi-pedagang/${pedagangId}/reject`;
            document.getElementById('rejectModal').classList.remove('hidden');
        }

        function closeRejectModal() {
            document.getElementById('rejectModal').classList.add('hidden');
        }

        // Tab switching
        document.getElementById('waitingTab').addEventListener('click', function() {
            document.getElementById('waitingContent').classList.remove('hidden');
            document.getElementById('approvedContent').classList.add('hidden');
            
            document.getElementById('waitingTab').classList.add('border-orange-500', 'text-orange-600');
            document.getElementById('waitingTab').classList.remove('border-transparent', 'text-gray-500');
            
            document.getElementById('approvedTab').classList.add('border-transparent', 'text-gray-500');
            document.getElementById('approvedTab').classList.remove('border-orange-500', 'text-orange-600');
        });

        document.getElementById('approvedTab').addEventListener('click', function() {
            document.getElementById('waitingContent').classList.add('hidden');
            document.getElementById('approvedContent').classList.remove('hidden');
            
            document.getElementById('approvedTab').classList.add('border-orange-500', 'text-orange-600');
            document.getElementById('approvedTab').classList.remove('border-transparent', 'text-gray-500');
            
            document.getElementById('waitingTab').classList.add('border-transparent', 'text-gray-500');
            document.getElementById('waitingTab').classList.remove('border-orange-500', 'text-orange-600');
        });

        // Close modal when clicking outside
        document.getElementById('rejectModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeRejectModal();
            }
        });
    </script>
</x-app-layout>

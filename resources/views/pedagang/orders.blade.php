<x-app-layout>
    <div class="py-12 bg-gray-50 min-h-screen">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
            <div class="mb-8 flex items-center justify-between">
                <div>
                    <h2 class="text-3xl font-black text-gray-800 tracking-tight">Kelola Pesanan</h2>
                    <p class="text-gray-500 font-medium uppercase tracking-widest text-[10px] mt-1">Pantau dan Update Status Jajanan Pembeli</p>
                </div>
                <div class="bg-white px-6 py-3 rounded-2xl shadow-sm border border-gray-100 flex items-center gap-3">
                    <div class="w-3 h-3 bg-green-500 rounded-full animate-pulse"></div>
                    <span class="text-sm font-bold text-gray-700">Toko Aktif</span>
                </div>
            </div>

            @if($orders->isEmpty())
                <div class="bg-white rounded-[2rem] p-12 text-center shadow-sm border border-gray-100">
                    <div class="bg-blue-50 w-20 h-20 rounded-full flex items-center justify-center mx-auto mb-6">
                        <span class="text-4xl">👨‍🍳</span>
                    </div>
                    <h3 class="text-xl font-bold text-gray-800 mb-2">Belum ada pesanan masuk</h3>
                    <p class="text-gray-500 text-sm">Pesanan dari pembeli akan muncul di sini secara otomatis.</p>
                </div>
            @else
                <div class="grid grid-cols-1 gap-6">
                    @foreach($orders as $order)
                        <div class="bg-white rounded-[2rem] shadow-sm border border-gray-100 overflow-hidden group">
                            <div class="p-6">
                                <div class="flex flex-wrap items-center justify-between gap-4 mb-6">
                                    <div class="flex items-center gap-4">
                                        <div class="w-12 h-12 bg-blue-50 rounded-2xl flex items-center justify-center overflow-hidden">
                                            @if($order->user->foto_profil)
                                                <img src="{{ asset('storage/' . $order->user->foto_profil) }}" class="w-full h-full object-cover">
                                            @else
                                                <span class="text-2xl">👤</span>
                                            @endif
                                        </div>
                                        <div>
                                            <h3 class="font-black text-gray-800 text-lg">{{ $order->user->nama }}</h3>
                                            <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">ID: {{ $order->external_id }}</p>
                                        </div>
                                    </div>
                                    <div class="flex items-center gap-3">
                                        <div class="text-right mr-4">
                                            <p class="text-[10px] text-gray-400 font-bold uppercase tracking-widest">Rencana Ambil</p>
                                            <p class="font-black text-gray-800 text-lg">{{ \Carbon\Carbon::parse($order->waktu_pengambilan)->format('H:i') }} WIB</p>
                                        </div>
                                        <div class="bg-orange-50 border border-orange-100 px-4 py-2 rounded-2xl text-center">
                                            <p class="text-[10px] text-orange-400 font-bold uppercase tracking-widest">Kode Ambil</p>
                                            <p class="text-xl font-black text-orange-600">{{ $order->kode_pengambilan }}</p>
                                        </div>
                                    </div>
                                </div>

                                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                                    {{-- Rincian Item --}}
                                    <div class="space-y-4">
                                        <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-2 border-b border-gray-50 pb-2">Rincian Pesanan</p>
                                        @foreach($order->details as $detail)
                                            <div class="flex items-center justify-between">
                                                <div class="flex items-center gap-3">
                                                    <span class="w-6 h-6 bg-gray-100 rounded-lg flex items-center justify-center text-[10px] font-bold text-gray-600">{{ $detail->jumlah }}x</span>
                                                    <p class="font-bold text-gray-800 text-sm">{{ $detail->nama_produk_history }}</p>
                                                </div>
                                                <p class="font-bold text-gray-800 text-sm">Rp {{ number_format($detail->subtotal, 0, ',', '.') }}</p>
                                            </div>
                                        @endforeach
                                        <div class="pt-4 border-t border-gray-50 flex justify-between items-center">
                                            <p class="font-black text-gray-800">Total Pendapatan</p>
                                            <p class="font-black text-orange-600 text-xl">Rp {{ number_format($order->total_harga, 0, ',', '.') }}</p>
                                        </div>
                                        @if($order->catatan)
                                            <div class="bg-yellow-50 p-4 rounded-2xl">
                                                <p class="text-[10px] font-bold text-yellow-600 uppercase tracking-widest mb-1">Catatan Pembeli</p>
                                                <p class="text-sm text-yellow-800 italic">"{{ $order->catatan }}"</p>
                                            </div>
                                        @endif
                                    </div>

                                    {{-- Kontrol Status --}}
                                    <div class="bg-gray-50 rounded-[2rem] p-6">
                                        <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-4">Update Status Pesanan</p>
                                        
                                        <form action="{{ route('orders.updateStatus', $order) }}" method="POST" class="space-y-4">
                                            @csrf
                                            @method('PATCH')
                                            
                                            <div class="grid grid-cols-2 gap-2">
                                                @php
                                                    $statuses = [
                                                        'menunggu_pembayaran' => ['label' => 'Menunggu Bayar', 'color' => 'yellow'],
                                                        'diproses' => ['label' => 'Diproses', 'color' => 'blue'],
                                                        'siap_diambil' => ['label' => 'Siap Diambil', 'color' => 'green'],
                                                        'selesai' => ['label' => 'Selesai', 'color' => 'gray'],
                                                        'dibatalkan' => ['label' => 'Dibatalkan', 'color' => 'red'],
                                                    ];
                                                @endphp

                                                @foreach($statuses as $value => $info)
                                                    <button type="submit" name="order_status" value="{{ $value }}" 
                                                        class="flex flex-col items-center justify-center p-3 rounded-2xl transition-all border-2 {{ $order->order_status === $value ? 'border-'.$info['color'].'-500 bg-'.$info['color'].'-50 shadow-sm' : 'border-transparent bg-white hover:border-gray-200' }}">
                                                        <span class="text-[10px] font-black uppercase tracking-tighter text-{{ $info['color'] }}-600">{{ $info['label'] }}</span>
                                                        @if($order->order_status === $value)
                                                            <svg class="w-4 h-4 text-{{ $info['color'] }}-500 mt-1" fill="currentColor" viewBox="0 0 20 20">
                                                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                                            </svg>
                                                        @endif
                                                    </button>
                                                @endforeach
                                            </div>
                                        </form>

                                        <div class="mt-6 pt-6 border-t border-gray-200">
                                            <div class="flex items-center justify-between text-[10px] font-bold uppercase tracking-widest text-gray-400">
                                                <span>Status Pembayaran</span>
                                                <span class="px-2 py-1 rounded bg-{{ $order->payment_status === 'paid' ? 'green' : 'yellow' }}-100 text-{{ $order->payment_status === 'paid' ? 'green' : 'yellow' }}-700">
                                                    {{ strtoupper($order->payment_status) }}
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
</x-app-layout>

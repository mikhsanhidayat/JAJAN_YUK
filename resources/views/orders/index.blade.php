<x-app-layout>

    @include('layouts.header', [
        'title' => 'Pesanan Saya',
        'subtitle' => 'Lihat riwayat dan pantau status pesanan jajanan Kamu'
    ])
    <div class="py-12 bg-gray-50 min-h-screen">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">

            @if($orders->isEmpty())
                <div class="bg-white rounded-[2rem] p-12 text-center shadow-sm border border-gray-100">
                    <div class="bg-orange-50 w-20 h-20 rounded-full flex items-center justify-center mx-auto mb-6">
                        <span class="text-4xl">🛍️</span>
                    </div>
                    <h3 class="text-xl font-bold text-gray-800 mb-2">Belum ada pesanan</h3>
                    <p class="text-gray-500 text-sm mb-8">Yuk, cari jajanan favoritmu sekarang!</p>
                    <a href="{{ route('dashboard') }}" class="bg-orange-500 hover:bg-orange-600 text-white px-8 py-3 rounded-2xl font-bold shadow-lg shadow-orange-200 transition-all active:scale-95 inline-block">
                        Cari Jajanan
                    </a>
                </div>
            @else
                <div class="space-y-6">
                    @foreach($orders as $order)
                        <div class="bg-white rounded-[2rem] shadow-sm border border-gray-100 overflow-hidden group hover:shadow-md transition-shadow">
                            <div class="p-6">
                                <div class="flex flex-wrap items-center justify-between gap-4 mb-6">
                                    <div class="flex items-center gap-4">
                                        <div class="w-12 h-12 bg-orange-100 rounded-2xl flex items-center justify-center text-2xl">
                                            🏪
                                        </div>
                                        <div>
                                            <h3 class="font-black text-gray-800 text-lg">{{ $order->pedagang->nama_toko }}</h3>
                                            <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">{{ $order->created_at->format('d M Y, H:i') }}</p>
                                        </div>
                                    </div>
                                    <div class="flex flex-col items-end gap-2">
                                        @php
                                            $statusClasses = [
                                                'menunggu_pembayaran' => 'bg-yellow-100 text-yellow-700',
                                                'diproses' => 'bg-blue-100 text-blue-700',
                                                'siap_diambil' => 'bg-green-100 text-green-700',
                                                'selesai' => 'bg-gray-100 text-gray-700',
                                                'dibatalkan' => 'bg-red-100 text-red-700',
                                            ];
                                            $statusLabel = str_replace('_', ' ', $order->order_status);
                                        @endphp
                                        <span class="px-4 py-1.5 rounded-full text-[10px] font-black uppercase tracking-wider {{ $statusClasses[$order->order_status] ?? 'bg-gray-100 text-gray-700' }}">
                                            {{ $statusLabel }}
                                        </span>
                                        <div class="bg-orange-50 border border-orange-100 px-3 py-1 rounded-xl">
                                            <p class="text-[9px] text-orange-400 font-bold uppercase tracking-tighter">Kode Ambil</p>
                                            <p class="text-sm font-black text-orange-600">{{ $order->kode_pengambilan }}</p>
                                        </div>
                                    </div>
                                </div>

                                <div class="space-y-4 mb-6">
                                    @foreach($order->details as $detail)
                                        <div class="flex items-center justify-between py-3 border-b border-gray-50 last:border-0">
                                            <div class="flex items-center gap-3">
                                                <div class="w-10 h-10 rounded-xl overflow-hidden bg-gray-100">
                                                    @if($detail->menu && $detail->menu->foto_produk)
                                                        <img src="{{ asset('storage/' . $detail->menu->foto_produk) }}" class="w-full h-full object-cover">
                                                    @else
                                                        <div class="w-full h-full flex items-center justify-center text-xs">🥘</div>
                                                    @endif
                                                </div>
                                                <div>
                                                    <p class="font-bold text-gray-800 text-sm">{{ $detail->nama_produk_history }}</p>
                                                    <p class="text-gray-400 text-xs">{{ $detail->jumlah }} x Rp {{ number_format($detail->harga_satuan, 0, ',', '.') }}</p>
                                                </div>
                                            </div>
                                            <p class="font-black text-gray-800 text-sm">Rp {{ number_format($detail->subtotal, 0, ',', '.') }}</p>
                                        </div>
                                    @endforeach
                                </div>

                                @if($order->catatan)
                                    <div class="bg-gray-50 p-4 rounded-2xl mb-6">
                                        <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-1">Catatan</p>
                                        <p class="text-sm text-gray-600 italic">"{{ $order->catatan }}"</p>
                                    </div>
                                @endif

                                <div class="flex items-center justify-between pt-6 border-t border-gray-100">
                                    <div>
                                        <p class="text-[10px] text-gray-400 font-bold uppercase tracking-widest">Rencana Ambil</p>
                                        <p class="font-bold text-gray-800">{{ \Carbon\Carbon::parse($order->waktu_pengambilan)->format('H:i') }} WIB</p>
                                    </div>
                                    <div class="text-right">
                                        <p class="text-[10px] text-gray-400 font-bold uppercase tracking-widest">Total Bayar</p>
                                        <p class="text-2xl font-black text-orange-600">Rp {{ number_format($order->total_harga, 0, ',', '.') }}</p>
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

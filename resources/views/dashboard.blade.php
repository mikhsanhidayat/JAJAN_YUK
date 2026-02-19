<x-app-layout >
    <div class="relative h-screen w-full overflow-hidden bg-gray-50">
        
        <div class="absolute top-0 left-0 right-0 z-[1000] bg-white/90 backdrop-blur-md shadow-sm border-b border-gray-100">
            <div class="flex items-center justify-between px-6 py-3">
                <div>
                    <h1 class="text-[#ff6b35] font-black text-xl tracking-tight">JajanYuk</h1>
                    <p class="text-[10px] text-gray-500 font-medium uppercase tracking-widest">Tasikmalaya Street Food</p>
                </div>
                <div class="p-2 bg-orange-50 rounded-full text-[#ff6b35]">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h7" />
                    </svg>
                </div>
            </div>
        </div>

        <div id="map" class="absolute inset-0 z-0"></div>

        <button class="absolute top-24 right-4 z-[1000] bg-white p-3 rounded-full shadow-xl text-gray-700 hover:text-orange-500 transition-all active:scale-90">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
            </svg>
        </button>

        <div class="absolute bottom-0 left-0 right-0 z-[1000] bg-gradient-to-t from-black/70 via-black/20 to-transparent pt-20 pb-6 px-4">
            
            <div class="max-w-6xl mx-auto space-y-6">
                
                <div class="relative max-w-2xl mx-auto group">
                    <span class="absolute left-5 top-1/2 -translate-y-1/2 text-gray-400 group-focus-within:text-orange-500 transition-colors">
                        🔍
                    </span>
                    <input type="text" placeholder="Cari jajanan favoritmu..." 
                        class="w-full pl-14 pr-6 py-4 rounded-full border-none shadow-2xl focus:ring-2 focus:ring-orange-500 text-sm bg-white/95 backdrop-blur-sm">
                </div>

                <div class="space-y-4">
                    <div class="flex items-center justify-between px-2">
                        <h3 class="text-white font-bold text-lg shadow-sm">Top Rated Street Food</h3>
                        <button class="text-white/80 text-xs font-semibold hover:text-white underline decoration-orange-500 underline-offset-4">Lihat Semua</button>
                    </div>

                    <div class="flex gap-4 overflow-x-auto pb-4 no-scrollbar scroll-smooth">
                        @forelse($menus ?? [] as $menu)
                        <div class="min-w-[300px] bg-white rounded-[2rem] shadow-2xl overflow-hidden group cursor-pointer border border-white/20 transition-transform hover:scale-[1.02]">
                            <div class="relative h-44 overflow-hidden">
                                <img src="{{ Str::startsWith($menu->foto_produk, 'http') ? $menu->foto_produk : asset('storage/' . $menu->foto_produk) }}" 
                                     class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700">
                                <div class="absolute top-4 right-4 bg-orange-500/90 backdrop-blur-sm text-white text-[10px] font-black px-3 py-1 rounded-full shadow-lg">
                                    ★ 4.8
                                </div>
                            </div>

                            <div class="p-5">
                                <h4 class="font-bold text-gray-800 text-base truncate">{{ $menu->nama_produk }}</h4>
                                <p class="text-gray-400 text-[11px] font-medium mb-4">{{ $menu->pedagang->nama_toko }}</p>
                                
                                <div class="flex justify-between items-center border-t border-gray-50 pt-3">
                                    <span class="text-orange-600 font-black text-lg">
                                        <small class="text-[10px] font-normal text-gray-400">Rp</small> 
                                        {{ number_format($menu->harga_minimal, 0, ',', '.') }}
                                    </span>
                                    <button class="bg-orange-500 hover:bg-orange-600 text-white px-6 py-2 rounded-xl text-[11px] font-bold shadow-lg shadow-orange-200 transition-all active:scale-90">
                                        ORDER
                                    </button>
                                </div>
                            </div>
                        </div>
                        @empty
                        <div class="bg-white/10 backdrop-blur-md p-10 rounded-3xl w-full text-center text-white border border-white/10">
                            Data jajanan belum tersedia di area ini
                        </div>
                        @endforelse
                    </div>
                </div>

            </div>
        </div>

    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var map = L.map('map', { zoomControl: false }).setView([-7.3274, 108.2207], 15);
            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png').addTo(map);

            @foreach ($menus->unique('pedagang_id') as $m)
                var customIcon = L.divIcon({
                    className: 'custom-div-icon',
                    html: "<div class='bg-orange-500 p-2 rounded-full border-2 border-white shadow-xl text-xl flex items-center justify-center animate-bounce'>🍢</div>",
                    iconSize: [42, 42],
                    iconAnchor: [21, 42]
                });

                L.marker([{{ $m->pedagang->latitude }}, {{ $m->pedagang->longitude }}], { icon: customIcon })
                    .addTo(map)
                    .bindPopup("<div class='p-2'><b>{{ $m->pedagang->nama_toko }}</b></div>");
            @endforeach
        });
    </script>

    <style>
        /* Menghilangkan scrollbar tapi tetap bisa di-scroll */
        .no-scrollbar::-webkit-scrollbar { display: none; }
        .no-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }
        
        /* Memastikan leaflet tidak menutupi UI kita */
        .leaflet-container { z-index: 0 !important; }
        .leaflet-control-container { display: none; } /* Sembunyikan kontrol bawaan agar clean */
        
        /* Custom Marker */
        .custom-div-icon { background: none !important; border: none !important; }
    </style>
</x-app-layout>
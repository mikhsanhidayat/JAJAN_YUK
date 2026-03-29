<x-app-layout>

    @if(session('success'))
<div id="alert-success" class="mb-6 flex items-center p-4 bg-green-50 border-l-4 border-green-500 rounded-2xl shadow-sm animate-bounce">
    <div class="flex-shrink-0 text-green-500">
        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
        </svg>
    </div>
    <div class="ml-3">
        <p class="text-xs font-bold text-green-800 uppercase tracking-tight">{{ session('success') }}</p>
    </div>
    <button onclick="document.getElementById('alert-success').remove()" class="ml-auto text-green-500 hover:text-green-700">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
    </button>
</div>
@endif

@if(session('error'))
<div id="alert-error" class="mb-6 flex items-center p-4 bg-red-50 border-l-4 border-red-500 rounded-2xl shadow-sm">
    <div class="flex-shrink-0 text-red-500">
        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
        </svg>
    </div>
    <div class="ml-3">
        <p class="text-xs font-bold text-red-800 uppercase tracking-tight">{{ session('error') }}</p>
    </div>
    <button onclick="document.getElementById('alert-error').remove()" class="ml-auto text-red-500 hover:text-red-700">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
    </button>
</div>
@endif


    <div class="relative h-screen w-full overflow-hidden bg-gray-50">
        
        <div class="absolute top-0 left-0 right-0 z-[1000] bg-white/90 backdrop-blur-md shadow-sm border-b border-gray-100">
            <div class="flex items-center justify-between px-6 py-3">
                <div>
                    <h1 class="text-[#ff6b35] font-black text-xl tracking-tight">JajanYuk</h1>
                    <p class="text-[10px] text-gray-500 font-medium uppercase tracking-widest">Tasikmalaya Street Food</p>
                </div>
                {{-- name user tampil jika sudah login --}}
                <div>
                    @auth
                        <span class="text-gray-700 text-sm font-medium">Halo, {{ Auth::user()->nama }}!</span>
                    @endauth
                </div>
                
                {{-- register and login ada jika belum ada user yang masuk --}}
                @guest
                <div class="flex items-center gap-4 ml-[1000px]     ">
                    <a href="{{ route('login') }}" class="text-gray-700 hover:text-orange-500 transition-colors text-sm font-medium">Login</a>
                    <a href="{{ route('register') }}" class="bg-orange-500 hover:bg-orange-600 text-white px-4 py-2 rounded-full text-sm font-bold shadow-lg transition-all active:scale-95">Register</a>
                </div>
                {{-- logout --}}
                
                @endguest

                @auth
                <div class="flex items-center gap-4  ml-[1000px] ">
                    {{-- daftar pedagang --}}
                    <a href="{{ route('pedagang.index') }}" class="text-gray-700 hover:text-orange-500 transition-colors text-sm font-medium">Daftar Pedagang</a>
                    <a href="{{ route('profile.edit') }}" class="text-gray-700 hover:text-orange-500 transition-colors text-sm font-medium">Profile</a>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-full text-sm font-bold shadow-lg transition-all active:scale-95">
                            Logout
                        </button>
                    </form>
                </div>
                @endauth

               
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

        <div class="absolute bottom-0 left-0 right-0 z-[1000] bg-gradient-to-t from-black/80 via-black/40 to-transparent pt-12 pb-4 px-4">
    <div class="max-w-5xl mx-auto space-y-4">
        
        <div class="relative max-w-lg mx-auto group">
            <span class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-400 group-focus-within:text-orange-500 transition-colors text-sm">
                🔍
            </span>
            <input type="text" placeholder="Cari jajanan..." 
                class="w-full pl-11 pr-4 py-2.5 rounded-full border-none shadow-xl focus:ring-2 focus:ring-orange-500 text-xs bg-white/95 backdrop-blur-sm">
        </div>

        <div class="space-y-3">
            <div class="flex items-center justify-between px-1">
                <h3 class="text-white font-bold text-base shadow-sm">Top Rated Street Food</h3>
                <button class="text-white/80 text-[10px] font-semibold hover:text-white underline decoration-orange-500 underline-offset-4">Lihat Semua</button>
            </div>

            <div class="gap-3 overflow-x-auto pb-3 no-scrollbar flex justify-center scroll-smooth">
                @forelse($menus ?? [] as $menu)
                <div class="min-w-[220px] bg-white rounded-[1.5rem] shadow-xl overflow-hidden group cursor-pointer border border-white/20 transition-transform hover:scale-[1.02]">
                    <div class="relative h-32 overflow-hidden">
                        <img src="{{ Str::startsWith($menu->foto_produk, 'http') ? $menu->foto_produk : asset('storage/' . $menu->foto_produk) }}" 
                             class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700">
                        <div class="absolute top-2 right-2 bg-orange-500/90 backdrop-blur-sm text-white text-[9px] font-black px-2 py-0.5 rounded-full shadow-lg">
                            ★ 4.8
                        </div>
                    </div>

                    <div class="p-3">
                        <h4 class="font-bold text-gray-800 text-sm truncate">{{ $menu->nama_produk }}</h4>
                        <p class="text-gray-400 text-[10px] font-medium mb-3">{{ $menu->pedagang->nama_toko }}</p>
                        
                        <div class="flex justify-between items-center border-t border-gray-50 pt-2">
                            <span class="text-orange-600 font-black text-base">
                                <small class="text-[9px] font-normal text-gray-400">Rp</small> 
                                {{ number_format($menu->harga_minimal, 0, ',', '.') }}
                            </span>
                            <button class="bg-orange-500 hover:bg-orange-600 text-white px-4 py-1.5 rounded-lg text-[9px] font-bold shadow-md shadow-orange-200 transition-all active:scale-90 uppercase">
                                Order
                            </button>
                        </div>
                    </div>
                </div>
                @empty
                <div class="bg-white/10 backdrop-blur-md p-6 rounded-2xl w-full text-center text-white border border-white/10 text-xs">
                    Data jajanan belum tersedia
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
        .leaflet-control-container { display: none; } /* Semkontrol bawaan agar clean */
        
        /* Custom Marker */
        .custom-div-icon { background: none !important; border: none !important; }
    </style>
</x-app-layout>
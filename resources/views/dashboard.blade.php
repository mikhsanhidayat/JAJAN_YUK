<x-app-layout>

    @if (session('success'))
        <div id="alert-success"
            class="mb-6 flex items-center p-4 bg-green-50 border-l-4 border-green-500 rounded-2xl shadow-sm animate-bounce">
            <div class="flex-shrink-0 text-green-500">
                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd"
                        d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                        clip-rule="evenodd"></path>
                </svg>
            </div>
            <div class="ml-3">
                <p class="text-xs font-bold text-green-800 uppercase tracking-tight">{{ session('success') }}</p>
            </div>
            <button onclick="document.getElementById('alert-success').remove()"
                class="ml-auto text-green-500 hover:text-green-700">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12">
                    </path>
                </svg>
            </button>
        </div>
    @endif

    @if (session('error'))
        <div id="alert-error"
            class="mb-6 flex items-center p-4 bg-red-50 border-l-4 border-red-500 rounded-2xl shadow-sm">
            <div class="flex-shrink-0 text-red-500">
                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd"
                        d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"
                        clip-rule="evenodd"></path>
                </svg>
            </div>
            <div class="ml-3">
                <p class="text-xs font-bold text-red-800 uppercase tracking-tight">{{ session('error') }}</p>
            </div>
            <button onclick="document.getElementById('alert-error').remove()"
                class="ml-auto text-red-500 hover:text-red-700">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12">
                    </path>
                </svg>
            </button>
        </div>
    @endif


    <div class="relative h-screen w-full overflow-hidden bg-gray-50">

        <div
            class="absolute top-0 left-0 right-0 z-[1000] bg-white/90 backdrop-blur-md shadow-sm border-b border-gray-100">
            <div class="flex items-center justify-between px-6 py-3">
                <div>
                    <h1 class="text-[#ff6b35] font-black text-xl tracking-tight">JajanYuk</h1>
                    <p class="text-[10px] text-gray-500 font-medium uppercase tracking-widest">Tasikmalaya Street Food
                    </p>
                </div>

                <div class="pl-4">
                    @auth
                        <span class="text-gray-700 text-sm font-medium">Halo, {{ Auth::user()->nama }}!</span>
                        <span
                            class="ml-2 text-xs font-bold text-gray-500 uppercase tracking-widest">({{ Auth::user()->role }})</span>
                    @endauth
                </div>

                @guest
                    <div class="flex items-center gap-4 ml-auto">
                        <a href="{{ route('login') }}"
                            class="text-gray-700 hover:text-orange-500 transition-colors text-sm font-medium">Login</a>
                        <a href="{{ route('register') }}"
                            class="bg-orange-500 hover:bg-orange-600 text-white px-4 py-2 rounded-full text-sm font-bold shadow-lg transition-all active:scale-95">Register</a>
                    </div>
                @endguest

                @auth
                    <div class="flex items-center gap-4 ml-auto">
                        @if (auth()->user()->role === 'pedagang')
                            @php
                                $hasPendingVerif = auth()->user()->hasPendingVerification();
                                $canToggleJualan = auth()->user()->pedagang && auth()->user()->pedagang->verified_user;
                            @endphp

                            <div
                                class="flex items-center space-x-3 bg-white px-4 py-2 rounded-2xl shadow-sm border border-orange-100">
                                <div class="text-right">
                                    <p id="gps-text"
                                        class="text-[9px] font-bold uppercase {{ auth()->user()->pedagangAktif() ? 'text-green-500' : 'text-red-500' }}">
                                        {{ auth()->user()->pedagangAktif() ? 'ONLINE' : 'OFFLINE' }}
                                    </p>
                                    <p class="text-[9px] text-gray-400 font-bold uppercase">Status Jualan</p>
                                </div>

                                <label class="relative inline-flex items-center cursor-pointer">
                                    <input type="checkbox" id="gps-switch" class="sr-only peer"
                                        {{ auth()->user()->pedagangAktif() ? 'checked' : '' }}
                                        {{ $canToggleJualan ? '' : 'disabled' }}>
                                    <div
                                        class="w-11 h-6 bg-gray-200 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-green-500">
                                    </div>
                                </label>
                            </div>
                           

                            @if (!auth()->user()->sudahMenjadiPedagang())
                                <a href="{{ route('pedagang.index') }}"
                                    class="text-gray-700 hover:text-orange-500 transition-colors text-sm font-medium">
                                    Daftar Pedagang
                                </a>
                            @endif

                            <a href="{{ route('menu.index') }}"
                                class="text-gray-700 hover:text-orange-500 transition-colors text-sm font-medium">
                                Menu
                            </a>

                            @if (!auth()->user()->pedagangAktif())
                                {{-- muncul hanya jika verified user yang ada di table pedagang false atau 0 --}}
                                @if (auth()->user()->pedagang && !auth()->user()->pedagang->verified_user)
                                    <a href="{{ route('verifikasi.create') }}"
                                        class="bg-[#ff6b35] hover:bg-[#e85a2a] text-white font-bold py-2 px-4 rounded-full shadow-lg transition-all active:scale-95 text-sm">
                                        Verifikasi Akun
                                    </a>
                                @endif
                            @endif
                        @endif

                        @if (auth()->user()->role === 'admin')
                            <a href="{{ route('verifikasi.index') }}"
                                class="bg-[#ff6b35] hover:bg-[#e85a2a] text-white font-bold py-2 px-4 rounded-full shadow-lg transition-all active:scale-95 text-sm">
                                Verifikasi
                            </a>
                        @endif

                        <a href="{{ route('profile.edit') }}"
                            class="text-gray-700 hover:text-orange-500 transition-colors text-sm font-medium">Profile</a>

                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit"
                                class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-full text-sm font-bold shadow-lg transition-all active:scale-95">
                                Logout
                            </button>
                        </form>
                    </div>
                @endauth
            </div>
        </div>

        <div id="map" class="absolute inset-0 z-0"></div>

        <button
            class="absolute top-24 right-4 z-[1000] bg-white p-3 rounded-full shadow-xl text-gray-700 hover:text-orange-500 transition-all active:scale-90">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
            </svg>
        </button>

        <div
            class="absolute bottom-0 left-0 right-0 z-[1000] bg-gradient-to-t from-black/80 via-black/40 to-transparent pt-12 pb-4 px-4">
            <div class="max-w-5xl mx-auto space-y-4">

                <div class="relative max-w-lg mx-auto group">
                    <span
                        class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-400 group-focus-within:text-orange-500 transition-colors text-sm">
                        🔍
                    </span>
                    <input type="text" placeholder="Cari jajanan..."
                        class="w-full pl-11 pr-4 py-2.5 rounded-full border-none shadow-xl focus:ring-2 focus:ring-orange-500 text-xs bg-white/95 backdrop-blur-sm">
                </div>

                <div class="space-y-3">
                    <div class="flex items-center justify-between px-1">
                        <h3 class="text-white font-bold text-base shadow-sm">Top Rated Street Food</h3>
                        <button
                            class="text-white/80 text-[10px] font-semibold hover:text-white underline decoration-orange-500 underline-offset-4">Lihat
                            Semua</button>
                    </div>

                    <div id="menu-list"
                        class="gap-3 overflow-x-auto pb-3 no-scrollbar flex justify-center scroll-smooth">
                        {{-- Data akan diisi oleh renderMenuCards --}}
                    </div>
                </div>
            </div>
        </div>

    </div>

    <script>
        let map;
        let markers = [];
        let watchId = null;
        const storageBase = '{{ asset('storage') }}';
        window.currentUser = @json(Auth::user());

        // Koordinat Batas Kota Tasikmalaya (Approximate Bounding Box)
        const TASIK_BOUNDS = {
            latMin: -7.4200,
            latMax: -7.2600,
            lngMin: 108.1500,
            lngMax: 108.2800
        };

        document.addEventListener('DOMContentLoaded', function() {
            map = L.map('map', {
                zoomControl: false
            }).setView([-7.3274, 108.2207], 14);
            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png').addTo(map);

            loadMapData();
            loadMenuData();
        });

        // Cek apakah lokasi ada di Tasik
        function isInsideTasikmalaya(lat, lng) {
            return lat >= TASIK_BOUNDS.latMin &&
                lat <= TASIK_BOUNDS.latMax &&
                lng >= TASIK_BOUNDS.lngMin &&
                lng <= TASIK_BOUNDS.lngMax;
        }

        function loadMapData() {
            markers.forEach(marker => map.removeLayer(marker));
            markers = [];

            fetch('/api/pedagang-aktif')
                .then(response => response.json())
                .then(data => {
                    data.forEach(pedagang => {
                        if (pedagang.latitude && pedagang.longitude) {
                            const gerobakImage = pedagang.foto_gerobak ?
                                (pedagang.foto_gerobak.startsWith('http') ?
                                    pedagang.foto_gerobak :
                                    `${storageBase}/${pedagang.foto_gerobak}`) :
                                null;

                            const iconHtml = gerobakImage ?
                                `<div class='marker-gerobak'><img src='${gerobakImage}' alt='${pedagang.nama_toko}' /></div>` :
                                "<div class='bg-orange-500 p-2 rounded-full border-2 border-white shadow-xl text-xl flex items-center justify-center animate-bounce'>🍢</div>";

                            var customIcon = L.divIcon({
                                className: 'custom-div-icon',
                                html: iconHtml,
                                iconSize: [50, 50],
                                iconAnchor: [25, 50],
                                popupAnchor: [0, -45]
                            });

                            var marker = L.marker([pedagang.latitude, pedagang.longitude], {
                                    icon: customIcon
                                })
                                .addTo(map)
                                .bindPopup(
                                    `<div class='p-2'><b>${pedagang.nama_toko}</b><br><small>${pedagang.jenis_jajanan}</small></div>`
                                    );

                            markers.push(marker);
                        }
                    });
                });
        }

        function loadMenuData() {
            fetch('/api/menus-aktif')
                .then(response => response.json())
                .then(data => {
                    renderMenuCards(data);
                });
        }

        function renderMenuCards(menus) {
    const menuList = document.getElementById('menu-list');
    if (!menuList) return;

    if (!menus.length) {
        menuList.innerHTML = `<div class="bg-white/10 backdrop-blur-md p-6 rounded-2xl w-full text-center text-white border border-white/10 text-xs">Data jajanan belum tersedia</div>`;
        return;
    }

    const userRole = window.currentUser ? window.currentUser.role : 'guest';

    menuList.innerHTML = menus.map(menu => {
        const imageUrl = menu.foto_produk && menu.foto_produk.startsWith('http') ?
            menu.foto_produk :
            `${storageBase}/${menu.foto_produk}`;

        const commonButtonClasses = 'px-4 py-1.5 rounded-lg text-[9px] font-bold transition-all uppercase';
        let buttonHtml = '';

        if (userRole === 'pembeli') {
            buttonHtml = `<button onclick="handleOrder(${menu.id})" class="bg-orange-500 hover:bg-orange-600 text-white ${commonButtonClasses} shadow-md shadow-orange-200 active:scale-90">Order</button>`;
        } else {
            buttonHtml = `<button onclick="handleRestrictedOrder('${userRole}')" class="bg-gray-300 cursor-not-allowed text-gray-500 ${commonButtonClasses} shadow-none">Order</button>`;
        }

        return `
            <div class="min-w-[220px] bg-white rounded-[1.5rem] shadow-xl overflow-hidden group cursor-pointer border border-white/20 transition-transform hover:scale-[1.02]">
                <div class="relative h-32 overflow-hidden">
                    <img src="${imageUrl}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700">
                    <div class="absolute top-2 right-2 bg-orange-500/90 backdrop-blur-sm text-white text-[9px] font-black px-2 py-0.5 rounded-full shadow-lg">★ 4.8</div>
                </div>
                <div class="p-3">
                    <h4 class="font-bold text-gray-800 text-sm truncate">${menu.nama_produk}</h4>
                    <p class="text-gray-400 text-[10px] font-medium mb-3">${menu.pedagang?.nama_toko || ''}</p>
                    <div class="flex justify-between items-center border-t border-gray-50 pt-2">
                        <span class="text-orange-600 font-black text-base"><small class="text-[9px] font-normal text-gray-400">Rp</small> ${new Intl.NumberFormat('id-ID').format(menu.harga_minimal)}</span>
                        ${buttonHtml}
                    </div>
                </div>
            </div>`;
    }).join('');
}

// 2. Fungsi untuk menangani klik pada tombol yang dibatasi
function handleRestrictedOrder(role) {
    if (role === 'guest') {
        alert("Ingin jajan? Yuk, login atau daftar akun pembeli terlebih dahulu!");
        // Atau arahkan ke login: window.location.href = '/login';
    } else if (role === 'pedagang') {
        alert("Akun pedagang hanya untuk berjualan. Silakan gunakan akun pembeli untuk melakukan pemesanan.");
    }
}

// 3. Fungsi order (untuk nanti jika backend sudah siap)
function handleOrder(menuId) {
    console.log("Memproses order untuk menu ID: " + menuId);
    // Logika transaksi Anda nanti di sini
}

        const gpsSwitch = document.getElementById('gps-switch');
        if (gpsSwitch) {
            gpsSwitch.addEventListener('change', function() {
                if (this.checked) {
                    startTracking();
                } else {
                    stopTracking();
                }
            });
        }

        function startTracking() {
            if (!navigator.geolocation) {
                alert("GPS tidak didukung!");
                gpsSwitch.checked = false;
                return;
            }

            watchId = navigator.geolocation.watchPosition(
                (position) => {
                    const lat = position.coords.latitude;
                    const lng = position.coords.longitude;

                    // Validasi Lokasi Tasikmalaya
                    if (!isInsideTasikmalaya(lat, lng)) {
                        alert(
                            "Maaf, lokasi Anda berada di luar jangkauan Kota Tasikmalaya. Status jualan dinonaktifkan.");
                        stopTracking(); // Matikan tracking otomatis
                        gpsSwitch.checked = false;
                        return;
                    }

                    const coords = {
                        latitude: lat,
                        longitude: lng,
                        is_active: 1
                    };

                    axios.post('/update-lokasi-pedagang', coords)
                        .then(res => {
                            updateUI(true);
                            loadMapData();
                            loadMenuData();
                        })
                        .catch(err => {
                            gpsSwitch.checked = false;
                            updateUI(false);
                        });
                },
                (error) => {
                    gpsSwitch.checked = false;
                    updateUI(false);
                    alert("Gagal mengambil lokasi. Pastikan GPS aktif.");
                }, {
                    enableHighAccuracy: true
                }
            );
        }

        function stopTracking() {
            if (watchId) {
                navigator.geolocation.clearWatch(watchId);
                watchId = null;
            }

            axios.post('/update-lokasi-pedagang', {
                is_active: 0,
                latitude: null,
                longitude: null
            }).then(() => {
                updateUI(false);
                loadMapData();
                loadMenuData();
            });
        }

        function updateUI(isActive) {
            const text = document.getElementById('gps-text');
            if (isActive) {
                text.innerText = "ONLINE";
                text.classList.replace('text-red-500', 'text-green-500');
            } else {
                text.innerText = "OFFLINE";
                text.classList.replace('text-green-500', 'text-red-500');
            }
        }

        // Jalankan pembaruan data setiap 5 atau 10 detik
        setInterval(function() {
            loadMapData(); // Mengambil posisi terbaru pedagang dan memperbarui marker
            console.log("Menyinkronkan lokasi pedagang...");
        }, 10000); // 10000 ms = 10 detik
    </script>

    <style>
        .no-scrollbar::-webkit-scrollbar {
            display: none;
        }

        .no-scrollbar {
            -ms-overflow-style: none;
            scrollbar-width: none;
        }

        .leaflet-container {
            z-index: 0 !important;
        }

        .leaflet-control-container {
            display: none;
        }

        .custom-div-icon {
            background: none !important;
            border: none !important;
        }

        .marker-gerobak img {
            width: 48px;
            height: 48px;
            object-fit: cover;
            border-radius: 9999px;
            border: 2px solid white;
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.18);
        }
    </style>
</x-app-layout>

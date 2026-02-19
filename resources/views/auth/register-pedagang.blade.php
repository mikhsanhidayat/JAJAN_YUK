<x-guest-layout>
    <div class="max-w-2xl mx-auto bg-white p-8 rounded-lg shadow mt-10">
        <h2 class="text-2xl font-bold text-orange-500 mb-6 text-center">Registrasi Pedagang</h2>
        
        <form method="POST" action="{{ route('register-pedagang.store') }}" enctype="multipart/form-data">
            @csrf
            <div class="space-y-4">
                <h3 class="font-semibold border-b pb-2">Data Akun</h3>
                <x-text-input name="nama" placeholder="Nama Lengkap" class="w-full" required />
                <x-text-input name="email" type="email" placeholder="Email" class="w-full" required />
                <x-text-input name="password" type="password" placeholder="Password" class="w-full" required />
                <x-text-input name="password_confirmation" type="password" placeholder="Konfirmasi Password" class="w-full" required />

                <h3 class="font-semibold border-b pb-2 mt-6">Data Toko</h3>
                <x-text-input name="nama_toko" placeholder="Nama Toko" class="w-full" required />
                
                <div class="grid grid-cols-2 gap-4">
                    <x-text-input id="lat" name="latitude" placeholder="Lat" readonly required />
                    <x-text-input id="lng" name="longitude" placeholder="Lng" readonly required />
                </div>
                
                <div id="map" class="h-40 w-full rounded border"></div>
                <p class="text-xs text-gray-500">* Klik peta untuk menentukan lokasi jualan</p>

                <input type="file" name="bukti_pembayaran" class="block w-full text-sm mt-4" required>
            </div>

            <x-primary-button class="w-full mt-8 justify-center bg-orange-500">
                Daftar & Login
            </x-primary-button>
        </form>
    </div>

    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <script>
        var map = L.map('map').setView([-7.3274, 108.2207], 13);
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png').addTo(map);
        var marker;
        map.on('click', function(e) {
            if(marker) map.removeLayer(marker);
            marker = L.marker(e.latlng).addTo(map);
            document.getElementById('lat').value = e.latlng.lat;
            document.getElementById('lng').value = e.latlng.lng;
        });
    </script>
</x-guest-layout>
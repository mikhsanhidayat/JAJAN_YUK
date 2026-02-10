<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <div>
                <h2 class="font-semibold text-2xl text-gray-800 leading-tight">
                    {{ __('Lengkapi Profil Toko') }}
                </h2>
                <p class="text-sm text-gray-500 mt-1">Step 2 dari 2 - Profil Toko & Lokasi</p>
            </div>
            <div class="text-sm text-gray-600">
                <span>Progres: 60%</span>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <!-- Progress Bar -->
            <div class="mb-6 bg-white rounded-lg shadow-sm p-6">
                <div class="flex justify-between text-sm text-gray-600 mb-2">
                    <span class="font-semibold">Step 2: Profil Toko & Lokasi</span>
                    <span>60% Selesai</span>
                </div>
                <div class="w-full bg-gray-200 rounded-full h-2">
                    <div class="bg-orange-500 h-2 rounded-full transition-all" style="width: 60%"></div>
                </div>
            </div>

                    <form method="POST" action="{{ route('register-pedagang.profile.store') }}" enctype="multipart/form-data" id="profileForm">
                        @csrf

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Nama Toko -->
                            <div class="md:col-span-1">
                                <x-input-label for="nama_toko" :value="__('Nama Toko')" />
                                <x-text-input 
                                    id="nama_toko" 
                                    class="block mt-1 w-full" 
                                    type="text" 
                                    name="nama_toko" 
                                    :value="old('nama_toko', $pedagang->nama_toko ?? '')" 
                                    required
                                    placeholder="Contoh: Toko Jajanan Ibu Siti"
                                />
                                <x-input-error :messages="$errors->get('nama_toko')" class="mt-2" />
                            </div>

                            <!-- Jenis Jajanan -->
                            <div class="md:col-span-1">
                                <x-input-label for="jenis_jajanan" :value="__('Jenis Jajanan (Opsional)')" />
                                <x-text-input 
                                    id="jenis_jajanan" 
                                    class="block mt-1 w-full" 
                                    type="text" 
                                    name="jenis_jajanan" 
                                    :value="old('jenis_jajanan', $pedagang->jenis_jajanan ?? '')" 
                                    placeholder="Contoh: Bakso, Lumpia, Tahu Goreng"
                                />
                                <x-input-error :messages="$errors->get('jenis_jajanan')" class="mt-2" />
                            </div>
                        </div>

                        <!-- Foto Gerobak -->
                        <div class="mt-6">
                            <x-input-label for="foto_gerobak" :value="__('Foto Gerobak/Toko')" />
                            <div class="mt-2 flex items-center justify-center w-full">
                                <label for="foto_gerobak" class="flex flex-col items-center justify-center w-full h-32 border-2 border-dashed border-orange-300 rounded-lg cursor-pointer hover:bg-orange-50 transition">
                                    <div class="flex flex-col items-center justify-center pt-5 pb-6">
                                        <svg class="w-8 h-8 mb-2 text-orange-500" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 16">
                                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 13h3a3 3 0 0 0 0-6h-.025A5.56 5.56 0 0 0 16 5.5a5.5 5.5 0 0 0-11 .5H2a3 3 0 0 0 0 6h3m0 0H3m10 0H9m4 5H9a1 1 0 0 0-1 1v3a1 1 0 0 0 1 1h4a1 1 0 0 0 1-1v-3a1 1 0 0 0-1-1Z"/>
                                        </svg>
                                        <p class="mb-2 text-sm text-gray-500"><span class="font-semibold">Klik untuk unggah</span></p>
                                        <p class="text-xs text-gray-500">PNG, JPG, JPEG (Max 2MB)</p>
                                    </div>
                                    <input id="foto_gerobak" type="file" name="foto_gerobak" class="hidden" accept="image/*" required onchange="previewImage(this, 'gerobakPreview')" />
                                </label>
                            </div>
                            <div id="gerobakPreview" class="mt-2"></div>
                            <x-input-error :messages="$errors->get('foto_gerobak')" class="mt-2" />
                        </div>

                        <!-- Peta untuk Geofencing -->
                        <div class="mt-6">
                            <x-input-label :value="__('Tentukan Lokasi Jualan Anda')" />
                            <p class="text-gray-600 text-sm mt-1 mb-3">Klik pada peta untuk menentukan lokasi toko. Lokasi harus dalam radius 20 KM dari pusat Tasikmalaya.</p>
                            
                            <div id="map" class="w-full h-96 border border-gray-300 rounded-lg mb-3"></div>

                            <!-- Koordinat Input (Hidden) -->
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <x-input-label for="latitude" :value="__('Latitude')" />
                                    <x-text-input 
                                        id="latitude" 
                                        class="block mt-1 w-full" 
                                        type="text" 
                                        name="latitude" 
                                        :value="old('latitude', $pedagang->latitude ?? '')" 
                                        readonly
                                        required
                                    />
                                    <x-input-error :messages="$errors->get('latitude')" class="mt-2" />
                                </div>
                                <div>
                                    <x-input-label for="longitude" :value="__('Longitude')" />
                                    <x-text-input 
                                        id="longitude" 
                                        class="block mt-1 w-full" 
                                        type="text" 
                                        name="longitude" 
                                        :value="old('longitude', $pedagang->longitude ?? '')" 
                                        readonly
                                        required
                                    />
                                    <x-input-error :messages="$errors->get('longitude')" class="mt-2" />
                                </div>
                            </div>

                            <!-- Status Geofencing -->
                            <div id="geofenceStatus" class="mt-3 p-3 rounded-lg hidden">
                                <!-- Akan diisi oleh JavaScript -->
                            </div>
                        </div>

                        <!-- Bukti Pembayaran -->
                        <div class="mt-6">
                            <x-input-label for="bukti_pembayaran" :value="__('Bukti Pembayaran Pendaftaran')" />
                            <p class="text-gray-600 text-sm mt-1 mb-3">Upload screenshot/foto bukti transfer pendaftaran sebagai bukti pembayaran.</p>
                            
                            <div class="mt-2 flex items-center justify-center w-full">
                                <label for="bukti_pembayaran" class="flex flex-col items-center justify-center w-full h-32 border-2 border-dashed border-green-300 rounded-lg cursor-pointer hover:bg-green-50 transition">
                                    <div class="flex flex-col items-center justify-center pt-5 pb-6">
                                        <svg class="w-8 h-8 mb-2 text-green-500" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 16">
                                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 13h3a3 3 0 0 0 0-6h-.025A5.56 5.56 0 0 0 16 5.5a5.5 5.5 0 0 0-11 .5H2a3 3 0 0 0 0 6h3m0 0H3m10 0H9m4 5H9a1 1 0 0 0-1 1v3a1 1 0 0 0 1 1h4a1 1 0 0 0 1-1v-3a1 1 0 0 0-1-1Z"/>
                                        </svg>
                                        <p class="mb-2 text-sm text-gray-500"><span class="font-semibold">Klik untuk unggah</span></p>
                                        <p class="text-xs text-gray-500">PNG, JPG, JPEG (Max 2MB)</p>
                                    </div>
                                    <input id="bukti_pembayaran" type="file" name="bukti_pembayaran" class="hidden" accept="image/*" required onchange="previewImage(this, 'buktiPreview')" />
                                </label>
                            </div>
                            <div id="buktiPreview" class="mt-2"></div>
                            <x-input-error :messages="$errors->get('bukti_pembayaran')" class="mt-2" />
                        </div>

                    <!-- Buttons -->
                    <div class="flex items-center justify-between mt-8 pt-6 border-t border-gray-200">
                        <a href="{{ route('dashboard') }}" class="px-6 py-2 text-gray-700 hover:text-orange-600 font-semibold transition">
                            ← Batal
                        </a>

                        <x-primary-button id="submitBtn" class="px-6 py-3 bg-orange-500 hover:bg-orange-600 font-semibold">
                            {{ __('Selesaikan Pendaftaran') }}
                        </x-primary-button>
                    </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Leaflet CSS & JS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.9.4/leaflet.min.css" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.9.4/leaflet.min.js"></script>

    <script>
        // Geofencing Configuration
        const TASIKMALAYA_LAT = -7.3581;
        const TASIKMALAYA_LNG = 108.2186;
        const RADIUS_KM = 20;
        const EARTH_RADIUS_KM = 6371;

        let map;
        let marker;
        let radiusCircle;

        // Initialize Map
        function initMap() {
            map = L.map('map').setView([TASIKMALAYA_LAT, TASIKMALAYA_LNG], 12);
            
            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '© OpenStreetMap contributors',
                maxZoom: 19
            }).addTo(map);

            // Draw radius circle
            radiusCircle = L.circle(
                [TASIKMALAYA_LAT, TASIKMALAYA_LNG],
                {
                    radius: RADIUS_KM * 1000, // Convert to meters
                    color: '#22c55e',
                    weight: 2,
                    opacity: 0.5,
                    fillOpacity: 0.1
                }
            ).addTo(map);

            // Add center marker
            L.marker([TASIKMALAYA_LAT, TASIKMALAYA_LNG], {
                title: 'Pusat Tasikmalaya'
            }).addTo(map).bindPopup('Pusat Kota Tasikmalaya');

            // Click handler
            map.on('click', onMapClick);

            // Load existing location if available
            const lat = document.getElementById('latitude').value;
            const lng = document.getElementById('longitude').value;
            if (lat && lng) {
                addMarker(lat, lng);
            }
        }

        // Calculate distance between two points
        function calculateDistance(lat1, lng1, lat2, lng2) {
            const dLat = ((lat2 - lat1) * Math.PI) / 180;
            const dLng = ((lng2 - lng1) * Math.PI) / 180;
            const a = 
                Math.sin(dLat / 2) * Math.sin(dLat / 2) +
                Math.cos((lat1 * Math.PI) / 180) *
                Math.cos((lat2 * Math.PI) / 180) *
                Math.sin(dLng / 2) *
                Math.sin(dLng / 2);
            const c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1 - a));
            return EARTH_RADIUS_KM * c;
        }

        // On map click
        function onMapClick(e) {
            addMarker(e.latlng.lat, e.latlng.lng);
        }

        // Add/Update marker
        function addMarker(lat, lng) {
            const distance = calculateDistance(lat, lng, TASIKMALAYA_LAT, TASIKMALAYA_LNG);
            
            // Update input fields
            document.getElementById('latitude').value = lat.toFixed(8);
            document.getElementById('longitude').value = lng.toFixed(8);

            // Remove old marker
            if (marker) {
                map.removeLayer(marker);
            }

            // Add new marker
            marker = L.marker([lat, lng], {
                draggable: true
            }).addTo(map).bindPopup(`
                <div class="text-sm">
                    <p><strong>Jarak:</strong> ${distance.toFixed(2)} KM</p>
                    <p><strong>Lat:</strong> ${lat.toFixed(6)}</p>
                    <p><strong>Lng:</strong> ${lng.toFixed(6)}</p>
                </div>
            `).openPopup();

            // Drag handler
            marker.on('drag', function(e) {
                const newLat = e.target.getLatLng().lat;
                const newLng = e.target.getLatLng().lng;
                const newDistance = calculateDistance(newLat, newLng, TASIKMALAYA_LAT, TASIKMALAYA_LNG);
                
                document.getElementById('latitude').value = newLat.toFixed(8);
                document.getElementById('longitude').value = newLng.toFixed(8);
                
                updateGeofenceStatus(newDistance);
            });

            // Update geofence status
            updateGeofenceStatus(distance);
        }

        // Update geofence status display
        function updateGeofenceStatus(distance) {
            const statusDiv = document.getElementById('geofenceStatus');
            
            if (distance <= RADIUS_KM) {
                statusDiv.className = 'mt-3 p-3 rounded-lg bg-green-50 border border-green-200';
                statusDiv.innerHTML = `
                    <p class="text-green-700 font-semibold">✓ Lokasi Valid</p>
                    <p class="text-green-600 text-sm">Lokasi Anda berada dalam jangkauan (${distance.toFixed(2)} KM dari pusat Tasikmalaya)</p>
                `;
                document.getElementById('submitBtn').disabled = false;
            } else {
                statusDiv.className = 'mt-3 p-3 rounded-lg bg-red-50 border border-red-200 hidden';
                statusDiv.innerHTML = `
                    <p class="text-red-700 font-semibold">✗ Lokasi Tidak Valid</p>
                    <p class="text-red-600 text-sm">Lokasi Anda berada di luar jangkauan (${distance.toFixed(2)} KM dari pusat Tasikmalaya). Maksimal jangkauan: ${RADIUS_KM} KM.</p>
                `;
                document.getElementById('submitBtn').disabled = true;
            }
        }

        // Preview image
        function previewImage(input, previewId) {
            const preview = document.getElementById(previewId);
            preview.innerHTML = '';
            
            if (input.files && input.files[0]) {
                const file = input.files[0];
                const reader = new FileReader();
                
                reader.onload = function(e) {
                    const img = document.createElement('img');
                    img.src = e.target.result;
                    img.className = 'w-full h-auto rounded-lg max-h-48 object-cover';
                    preview.appendChild(img);
                };
                
                reader.readAsDataURL(file);
            }
        }

        // Initialize on page load
        document.addEventListener('DOMContentLoaded', function() {
            initMap();
        });
    </script>
</x-app-layout>

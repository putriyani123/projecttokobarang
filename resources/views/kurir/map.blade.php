<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Peta Pengiriman - Pesanan #{{ $transaction->id }}</title>
    
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin=""/>
    <link rel="stylesheet" href="https://unpkg.com/leaflet-routing-machine@latest/dist/leaflet-routing-machine.css" />

    <style>
        body { font-family: 'Poppins', sans-serif; background-color: #f3f4f6; }
        #map { height: calc(100vh - 180px); width: 100%; border-radius: 12px; z-index: 1; }
        /* Sembunyikan panel instruksi teks (belok kiri/kanan) agar map bersih ala gojek */
        .leaflet-routing-container { display: none !important; }
    </style>
</head>
<body class="flex flex-col h-screen">

    <!-- Header -->
    <div class="bg-pink-700 text-white p-4 shadow-md flex justify-between items-center">
        <div>
            <h1 class="text-lg font-bold">Pesanan #{{ $transaction->id }}</h1>
            <p class="text-xs text-pink-200">Customer: {{ $transaction->user->name ?? 'Anonim' }}</p>
        </div>
        <a href="{{ route('kurir.dashboard') }}" class="bg-pink-800 hover:bg-pink-900 px-4 py-2 rounded-lg text-sm font-semibold transition">
            Kembali
        </a>
    </div>

    <!-- Info Alamat -->
    <div class="bg-white p-4 shadow-sm z-10">
        <h2 class="text-xs font-bold text-gray-500 uppercase tracking-wider mb-1">Alamat Tujuan:</h2>
        <p class="text-sm font-semibold text-gray-800">
            {{ $transaction->address->detail_address ?? '' }},
            {{ $transaction->address->village ?? '' }},
            {{ $transaction->address->district ?? '' }},
            {{ $transaction->address->city ?? '' }},
            {{ $transaction->address->province ?? '' }}
        </p>
        
        @php
            $rawAddress = ($transaction->address->detail_address ?? '') . ', ' . ($transaction->address->village ?? '') . ', ' . ($transaction->address->district ?? '') . ', ' . ($transaction->address->city ?? '') . ', ' . ($transaction->address->province ?? '');
            $fullAddress = urlencode($rawAddress);
        @endphp
        
        <div class="mt-3 flex gap-2">
            <a href="https://www.google.com/maps/search/?api=1&query={{ $fullAddress }}" target="_blank" class="flex-1 bg-blue-600 hover:bg-blue-700 text-white text-center py-2 rounded-lg text-sm font-semibold transition shadow-sm flex items-center justify-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-geo-alt-fill" viewBox="0 0 16 16">
                  <path d="M8 16s6-5.686 6-10A6 6 0 0 0 2 6c0 4.314 6 10 6 10m0-7a3 3 0 1 1 0-6 3 3 0 0 1 0 6"/>
                </svg>
                Buka di Google Maps
            </a>
        </div>
    </div>

    <!-- Map Container -->
    <div class="p-4 flex-1 flex flex-col relative">
        <div id="location-warning" class="hidden bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg mb-3 shadow-sm text-sm font-semibold flex justify-between items-center">
            <span>Akses Lokasi Diblokir! Mohon izinkan akses lokasi (GPS) pada browser Anda.</span>
            <button id="btn-simulate" class="bg-red-600 hover:bg-red-700 text-white px-3 py-1.5 rounded-lg text-xs transition">Simulasikan (Tes)</button>
        </div>
        <div id="map" class="shadow-md border border-gray-200 flex-1 w-full relative"></div>
    </div>

    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
    <script src="https://unpkg.com/leaflet-routing-machine@latest/dist/leaflet-routing-machine.js"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            var map = L.map('map').setView([-6.200000, 106.816666], 13);

            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                maxZoom: 19,
                attribution: '&copy; OpenStreetMap'
            }).addTo(map);

            var courierIcon = L.icon({
                iconUrl: 'https://cdn-icons-png.flaticon.com/512/3097/3097180.png', // Ikon motor kurir
                iconSize: [40, 40],
                iconAnchor: [20, 40],
                popupAnchor: [0, -40]
            });

            var destIcon = L.icon({
                iconUrl: 'https://cdn-icons-png.flaticon.com/512/2555/2555529.png', // Ikon rumah
                iconSize: [40, 40],
                iconAnchor: [20, 40],
                popupAnchor: [0, -40]
            });

            var destLatLng = null;
            var routingControl = null;
            var courierMarker = null;

            @php
                $rawAddress = '';
                $fallbackAddress = '';
                if($transaction->address) {
                    $rawAddress = ($transaction->address->detail_address ?? '') . ', ' . ($transaction->address->village ?? '') . ', ' . ($transaction->address->district ?? '') . ', ' . ($transaction->address->city ?? '') . ', ' . ($transaction->address->province ?? '');
                    $fallbackAddress = ($transaction->address->district ?? '') . ', ' . ($transaction->address->city ?? '') . ', ' . ($transaction->address->province ?? '');
                }
            @endphp
            
            var addressQuery = "{{ $rawAddress }}";
            var fallbackQuery = "{{ $fallbackAddress }}";

            function updateRouteKurir(lat, lng) {
                if (destLatLng) {
                    if (!routingControl) {
                        routingControl = L.Routing.control({
                            waypoints: [ L.latLng(lat, lng), destLatLng ],
                            lineOptions: { styles: [{color: '#2563EB', opacity: 0.8, weight: 6}] },
                            createMarker: function() { return null; },
                            fitSelectedRoutes: true,
                            show: false
                        }).addTo(map);
                    } else {
                        routingControl.setWaypoints([ L.latLng(lat, lng), destLatLng ]);
                    }
                }
            }

            function geocodeAddress(query, isFallback = false) {
                if (query.trim() !== "") {
                    fetch('https://nominatim.openstreetmap.org/search?format=json&q=' + encodeURIComponent(query))
                        .then(res => res.json())
                        .then(data => {
                            if (data && data.length > 0) {
                                destLatLng = L.latLng(data[0].lat, data[0].lon);
                                L.marker(destLatLng, {icon: destIcon}).addTo(map).bindPopup('Tujuan: {{ $transaction->user->name ?? "Pelanggan" }}').openPopup();
                                
                                if (courierMarker) {
                                    updateRouteKurir(courierMarker.getLatLng().lat, courierMarker.getLatLng().lng);
                                } else {
                                    map.setView(destLatLng, 13);
                                }
                            } else if (!isFallback && fallbackQuery.trim() !== "") {
                                geocodeAddress(fallbackQuery, true);
                            } else {
                                console.log("Alamat tidak ditemukan oleh geocoder.");
                            }
                        })
                        .catch(err => console.error("Geocoding error", err));
                }
            }
            geocodeAddress(addressQuery);

            if (navigator.geolocation) {
                navigator.geolocation.watchPosition(function(position) {
                    var lat = position.coords.latitude;
                    var lng = position.coords.longitude;
                    var latlng = [lat, lng];

                    if (!courierMarker) {
                        courierMarker = L.marker(latlng, {icon: courierIcon}).addTo(map)
                            .bindPopup('Lokasi Saya (Kurir)');
                    } else {
                        courierMarker.setLatLng(latlng);
                    }

                    if (destLatLng) {
                        updateRouteKurir(lat, lng);
                    } else {
                        map.setView(latlng, 15);
                    }

                    // Update to server
                    fetch('{{ route("kurir.update_location") }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({
                            latitude: lat,
                            longitude: lng
                        })
                    }).catch(error => console.error('Error updating location:', error));
                    
                }, function(error) {
                    console.error("Geolocation error: ", error);
                    document.getElementById('location-warning').classList.remove('hidden');
                }, {
                    enableHighAccuracy: true,
                    maximumAge: 10000,
                    timeout: 10000
                });
            }

            // SIMULASI PERGERAKAN JIKA DIBLOKIR
            document.getElementById('btn-simulate').addEventListener('click', function() {
                this.innerHTML = "Sedang Jalan...";
                this.disabled = true;

                // Mulai dari titik agak jauh dari tujuan
                var currentLat = destLatLng ? destLatLng.lat - 0.02 : -6.22;
                var currentLng = destLatLng ? destLatLng.lng - 0.02 : 106.80;

                setInterval(function() {
                    // Bergerak perlahan mendekati tujuan
                    if (destLatLng) {
                        currentLat += (destLatLng.lat - currentLat) * 0.1;
                        currentLng += (destLatLng.lng - currentLng) * 0.1;
                    } else {
                        currentLat += 0.001;
                        currentLng += 0.001;
                    }

                    var latlng = [currentLat, currentLng];

                    if (!courierMarker) {
                        courierMarker = L.marker(latlng, {icon: courierIcon}).addTo(map)
                            .bindPopup('Lokasi Saya (Kurir)');
                    } else {
                        courierMarker.setLatLng(latlng);
                    }

                    if (destLatLng) {
                        if (!routingControl) {
                            routingControl = L.Routing.control({
                                waypoints: [ L.latLng(currentLat, currentLng), destLatLng ],
                                lineOptions: { styles: [{color: '#2563EB', opacity: 0.8, weight: 6}] },
                                createMarker: function() { return null; },
                                fitSelectedRoutes: true,
                                show: false
                            }).addTo(map);
                        } else {
                            routingControl.setWaypoints([ L.latLng(currentLat, currentLng), destLatLng ]);
                        }
                    } else {
                        map.setView(latlng, 15);
                    }

                    // Update server
                    fetch('{{ route("kurir.update_location") }}', {
                        method: 'POST',
                        headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
                        body: JSON.stringify({ latitude: currentLat, longitude: currentLng })
                    });
                }, 3000); // Update tiap 3 detik saat simulasi
            });

        });
    </script>
</body>
</html>

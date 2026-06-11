<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Pesanan #{{ $transaction->midtrans_order_id ?? $transaction->id }} - GlowBeauty</title>

    <script src="https://cdn.tailwindcss.com"></script>

    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,600;0,700;1,400&family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin=""/>
    <link rel="stylesheet" href="https://unpkg.com/leaflet-routing-machine@latest/dist/leaflet-routing-machine.css" />

    <style>
        .leaflet-routing-container { display: none !important; }
        body {
            font-family: 'Poppins', sans-serif;
            background: radial-gradient(circle at top, #fff1f7 0%, #ffffff 70%);
            color: #2d1b22;
        }

        h1, h2, h3, .serif-font {
            font-family: 'Playfair Display', serif;
        }

        .btn-primary {
            background: linear-gradient(135deg, #ff6fa9, #ff2e7e);
            color: white;
            box-shadow: 0 4px 15px rgba(255, 46, 126, 0.25);
            transition: all 0.3s ease;
        }

        .btn-primary:hover {
            box-shadow: 0 6px 20px rgba(255, 46, 126, 0.45);
            transform: translateY(-2px);
        }
    </style>
</head>

<body class="flex flex-col min-h-screen pb-12">

    <!-- Navbar -->
    <nav class="bg-white/70 backdrop-blur-md border-b border-pink-100/50 sticky top-0 z-50">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-3 md:py-4 flex justify-between items-center">
            <div class="flex items-center gap-2 md:gap-3">
                <span class="text-xl md:text-2xl">📦</span>
                <h1 class="text-lg md:text-xl font-bold serif-font text-gray-800">
                    Detail Pesanan
                </h1>
            </div>

            <a href="{{ url('/transactions') }}"
               class="text-xs font-bold text-pink-500 hover:text-pink-600 transition flex items-center gap-1.5">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Riwayat Pesanan
            </a>
        </div>
    </nav>

    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 mt-10 flex-grow w-full">

        @if(session('success'))
        <div class="mb-6 bg-green-50 border border-green-200 text-green-700 p-4 rounded-2xl flex items-center text-sm shadow-sm">
            <svg class="w-5 h-5 mr-3 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
            </svg>
            <span class="font-semibold">{{ session('success') }}</span>
        </div>
        @endif

        @if(session('error'))
        <div class="mb-6 bg-red-50 border border-red-200 text-red-700 p-4 rounded-2xl flex items-center text-sm shadow-sm">
            <svg class="w-5 h-5 mr-3 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
            </svg>
            <span class="font-semibold">{{ session('error') }}</span>
        </div>
        @endif

        <div class="bg-white/80 backdrop-blur rounded-3xl border border-pink-100/50 shadow overflow-hidden">
            <!-- Header -->
            <div class="bg-pink-50/20 border-b border-pink-50/40 px-6 py-5 flex flex-col sm:flex-row justify-between sm:items-center gap-4">
                <div>
                    <div class="text-xs text-gray-400 font-semibold uppercase tracking-wider">ID Transaksi</div>
                    <div class="text-base font-bold text-gray-800 mt-0.5">
                        {{ $transaction->midtrans_order_id ?? 'TRX-'.$transaction->id }}
                    </div>
                    <div class="text-[11px] text-gray-400 mt-1">
                        Dibuat pada: {{ $transaction->created_at->format('d M Y H:i') }}
                    </div>
                </div>

                <div>
                    @if($transaction->status == 'pending')
                        <span class="bg-yellow-100 text-yellow-600 px-4 py-2 rounded-full text-xs font-bold uppercase tracking-wider">
                            PENDING
                        </span>
                    @elseif($transaction->status == 'paid')
                        <span class="bg-pink-100 text-pink-600 px-4 py-2 rounded-full text-xs font-bold uppercase tracking-wider">
                            DIPROSES (LUNAS)
                        </span>
                    @elseif($transaction->status == 'assigned')
                        <span class="bg-indigo-100 text-indigo-700 px-4 py-2 rounded-full text-xs font-bold uppercase tracking-wider">
                            MENUNGGU KURIR
                        </span>
                    @elseif($transaction->status == 'courier_accepted')
                        <span class="bg-yellow-100 text-yellow-700 px-4 py-2 rounded-full text-xs font-bold uppercase tracking-wider">
                            KURIR OTW PICKUP
                        </span>
                    @elseif($transaction->status == 'admin_handed_over')
                        <span class="bg-orange-100 text-orange-700 px-4 py-2 rounded-full text-xs font-bold uppercase tracking-wider">
                            MENUNGGU KURIR AMBIL
                        </span>
                    @elseif($transaction->status == 'confirmed')
                        <span class="bg-purple-100 text-purple-700 px-4 py-2 rounded-full text-xs font-bold uppercase tracking-wider">
                            DITERIMA (PACKING)
                        </span>
                    @elseif($transaction->status == 'shipped')
                        <span class="bg-blue-100 text-blue-700 px-4 py-2 rounded-full text-xs font-bold uppercase tracking-wider">
                            DIKIRIM
                        </span>
                    @elseif($transaction->status == 'delivered')
                        <span class="bg-emerald-100 text-emerald-700 px-4 py-2 rounded-full text-xs font-bold uppercase tracking-wider">
                            TERKIRIM
                        </span>
                    @elseif($transaction->status == 'completed')
                        <span class="bg-green-100 text-green-700 px-4 py-2 rounded-full text-xs font-bold uppercase tracking-wider">
                            SELESAI
                        </span>
                    @elseif($transaction->status == 'returned')
                        <span class="bg-red-100 text-red-600 px-4 py-2 rounded-full text-xs font-bold uppercase tracking-wider">
                            DIKEMBALIKAN
                        </span>
                    @else
                        <span class="bg-red-100 text-red-600 px-4 py-2 rounded-full text-xs font-bold uppercase tracking-wider">
                            GAGAL
                        </span>
                    @endif

                    <div class="mt-4 flex gap-2 justify-start sm:justify-end">
                        <a href="{{ route('transaction.single.pdf', $transaction->id) }}" class="bg-white hover:bg-pink-50 text-pink-600 border border-pink-200 px-3 py-1.5 rounded-xl text-[11px] font-bold uppercase tracking-wider flex items-center gap-1.5 shadow-sm transition">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path></svg>
                            Cetak PDF
                        </a>
                        <a href="{{ route('transaction.single.excel', $transaction->id) }}" class="bg-white hover:bg-emerald-50 text-emerald-600 border border-emerald-200 px-3 py-1.5 rounded-xl text-[11px] font-bold uppercase tracking-wider flex items-center gap-1.5 shadow-sm transition">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                            Cetak Excel
                        </a>
                    </div>
                </div>
            </div>

            <!-- Detail Pelanggan & Alamat -->
            <div class="px-6 py-5 border-b border-pink-50/40 bg-pink-50/5 grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <h3 class="text-xs font-bold uppercase text-pink-600 tracking-wider mb-2">Informasi Pemesan</h3>
                    <p class="text-sm font-semibold text-gray-800">{{ $transaction->user->name ?? 'Guest' }}</p>
                    <p class="text-xs text-gray-500 mt-0.5">{{ $transaction->user->email ?? '-' }}</p>
                </div>
                <div>
                    <h3 class="text-xs font-bold uppercase text-pink-600 tracking-wider mb-2">Alamat Pengiriman</h3>
                    @if($transaction->address)
                        <p class="text-xs text-gray-700 font-semibold mb-0.5">{{ $transaction->user->name ?? 'Guest' }} (-)</p>
                        <p class="text-xs text-gray-500 leading-relaxed">{{ $transaction->address->detail_address ?? '' }}, {{ $transaction->address->village ?? '' }}, {{ $transaction->address->district ?? '' }}, {{ $transaction->address->city ?? '' }}, {{ $transaction->address->province ?? '' }}</p>
                    @else
                        <p class="text-xs text-gray-400">Tidak ada informasi alamat.</p>
                    @endif
                </div>
            </div>

            <!-- Body (Itemized List) -->
            <div class="px-6 py-6 space-y-6">
                <h3 class="text-xs font-bold uppercase text-pink-600 tracking-wider">Daftar Barang Belanja</h3>

                @foreach($transaction->items as $item)
                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 py-4 border-b border-pink-100/30 last:border-b-0">
                    <div class="flex items-start gap-4">
                        @if(isset($item->product->image))
                            <img src="{{ asset('storage/' . $item->product->image) }}"
                                 class="w-16 h-16 rounded-xl object-cover border flex-shrink-0">
                        @endif

                        <div>
                            <div class="font-bold text-sm text-gray-800">
                                {{ $item->product->name ?? 'Produk dihapus' }}
                            </div>

                            <div class="text-xs text-gray-400 mt-1">
                                {{ $item->qty }} x Rp {{ number_format($item->price,0,',','.') }}
                            </div>

                            @if($item->box_color || $item->greeting_card || $item->custom_message)
                                <div class="bg-pink-50/50 border border-pink-100/20 rounded-xl p-2.5 mt-2 text-[11px] text-gray-600 max-w-md">
                                    @if($item->box_color) <p class="mb-0.5"><strong>Gift Box:</strong> {{ $item->box_color }}</p> @endif
                                    @if($item->greeting_card) <p class="mb-0.5"><strong>Kartu:</strong> {{ $item->greeting_card }}</p> @endif
                                    @if($item->custom_message) <p class="italic mt-1 text-gray-500 font-medium">"{{ $item->custom_message }}"</p> @endif
                                </div>
                            @endif
                        </div>
                    </div>

                    <div class="flex items-center justify-between sm:justify-end gap-6 w-full sm:w-auto">
                        <div class="font-bold text-pink-600 text-sm">
                            Rp {{ number_format($item->price * $item->qty,0,',','.') }}
                        </div>

                        <!-- Item Action / Status Badge -->
                        <div class="flex items-center gap-2">
                            @if(auth()->check() && auth()->id() === $transaction->user_id && $transaction->status == 'delivered')
                                @if($item->status == 'pending')
                                    <div class="flex gap-1.5">
                                        <form action="{{ route('user.item.return', $item->id) }}" method="POST" class="inline">
                                            @csrf
                                            <button type="submit" onclick="return confirm('Apakah Anda yakin ingin mengembalikan produk ini?')" class="bg-red-50 hover:bg-red-100 text-red-600 border border-red-200 font-semibold px-2.5 py-1.5 rounded-lg text-[10px] uppercase tracking-wider transition duration-150">
                                                Kembalikan
                                            </button>
                                        </form>
                                        <form action="{{ route('user.item.received', $item->id) }}" method="POST" class="inline">
                                            @csrf
                                            <button type="submit" class="bg-green-50 hover:bg-green-100 text-green-700 border border-green-200 font-semibold px-2.5 py-1.5 rounded-lg text-[10px] uppercase tracking-wider transition duration-150">
                                                Diterima
                                            </button>
                                        </form>
                                    </div>
                                @elseif($item->status == 'completed')
                                    <span class="bg-green-100 text-green-700 border border-green-200 px-2.5 py-1 rounded-lg text-[10px] font-bold uppercase">
                                        Diterima
                                    </span>
                                @elseif($item->status == 'returned')
                                    <span class="bg-red-100 text-red-600 border border-red-200 px-2.5 py-1 rounded-lg text-[10px] font-bold uppercase">
                                        Dikembalikan
                                    </span>
                                @endif
                            @else
                                @if($transaction->status == 'shipped')
                                    <span class="bg-blue-50 text-blue-600 border border-blue-200 px-2.5 py-1 rounded-lg text-[10px] font-bold uppercase">
                                        Sedang Diantar
                                    </span>
                                @elseif($item->status == 'completed')
                                    <span class="bg-green-100 text-green-700 border border-green-200 px-2.5 py-1 rounded-lg text-[10px] font-bold uppercase">
                                        Diterima
                                    </span>
                                @elseif($item->status == 'returned')
                                    <span class="bg-red-100 text-red-600 border border-red-200 px-2.5 py-1 rounded-lg text-[10px] font-bold uppercase">
                                        Dikembalikan
                                    </span>
                                @endif
                            @endif
                        </div>
                    </div>
                </div>
                @endforeach

                @if($transaction->courier_id || $transaction->tracking_number || $transaction->delivery_date || $transaction->proof_of_delivery)
                    <div class="mt-5 pt-5 border-t border-pink-50/40 space-y-3 bg-pink-50/10 p-5 rounded-2xl">
                        <h4 class="text-xs font-bold uppercase tracking-wider text-pink-600">Info Pengiriman</h4>
                        
                        @if($transaction->courier_id)
                            <div class="text-xs text-gray-600 flex items-center gap-2">
                                <span>🛵</span> 
                                <span>Kurir:</span> 
                                <strong class="text-gray-800">{{ $transaction->courier->name }}</strong>
                                <span class="text-gray-500 italic">({{ $transaction->courier->base_address ?? 'Wilayah belum diatur' }})</span>
                            </div>
                        @endif

                        @if($transaction->tracking_number)
                            <div class="text-xs text-gray-600 flex items-center gap-2">
                                <span>🚚</span> 
                                <span>No. Resi:</span> 
                                <strong class="text-gray-800 font-mono bg-white px-2 py-0.5 rounded border border-pink-100">{{ $transaction->tracking_number }}</strong>
                            </div>
                        @endif
                        
                        @if($transaction->delivery_date)
                            <div class="text-xs text-gray-600 flex items-center gap-2">
                                <span>📅</span> 
                                <span>Rencana Kirim:</span> 
                                <span class="text-gray-800 font-semibold">{{ \Carbon\Carbon::parse($transaction->delivery_date)->translatedFormat('d F Y') }}</span>
                            </div>
                        @endif

                        @if($transaction->proof_of_delivery)
                            <div class="text-xs text-gray-600 space-y-2">
                                <div class="flex items-center gap-2">
                                    <span>📷</span> 
                                    <span>Bukti Penerimaan:</span>
                                </div>
                                <div class="pl-6">
                                    <img src="{{ Storage::url($transaction->proof_of_delivery) }}" class="w-32 h-32 object-cover rounded-xl border border-pink-100 hover:scale-105 transition duration-200 cursor-pointer shadow-sm" onclick="window.open('{{ Storage::url($transaction->proof_of_delivery) }}')">
                                </div>
                            </div>
                        @endif
                    </div>
                @endif

                @if(in_array($transaction->status, ['assigned', 'courier_accepted', 'admin_handed_over', 'shipped']) && $transaction->courier_id)
                    <div class="mt-5 pt-5 border-t border-pink-50/40 space-y-3 bg-pink-50/10 p-5 rounded-2xl">
                        <h4 class="text-xs font-bold uppercase tracking-wider text-pink-600 mb-3">Lacak Kurir (Real-Time)</h4>
                        <div id="courier-map" style="height: 300px; border-radius: 12px; z-index: 1;"></div>
                    </div>
                @endif
            </div>

            <!-- Footer -->
            <div class="bg-pink-50/10 border-t border-pink-50/30 px-6 py-5 flex flex-col sm:flex-row justify-between sm:items-center gap-4">
                <div class="flex justify-between items-center flex-grow sm:flex-grow-0 sm:gap-6">
                    <span class="text-xs font-bold text-gray-500 uppercase">
                        Total Belanja
                    </span>
                    <span class="text-2xl font-extrabold text-pink-600">
                        Rp {{ number_format($transaction->total_price,0,',','.') }}
                    </span>
                </div>

                @if(auth()->check() && auth()->user()->role === 'admin' && $transaction->status == 'paid')
                    <form action="{{ route('admin.accept', $transaction->id) }}" method="POST" class="w-full sm:w-auto flex flex-col sm:flex-row gap-2">
                        @csrf
                        <select name="courier_id" required class="text-xs border border-pink-200 rounded-xl px-4 py-3 text-gray-700 bg-white shadow-sm focus:ring-pink-500 focus:border-pink-500">
                            <option value="">Pilih Kurir...</option>
                            @foreach($couriers as $courier)
                                <option value="{{ $courier->id }}">{{ $courier->name }}</option>
                            @endforeach
                        </select>
                        <button type="submit" class="w-full sm:w-auto bg-pink-600 hover:bg-pink-700 text-white font-bold px-5 py-3 rounded-xl text-xs uppercase tracking-wider transition duration-200">
                            Tugaskan Kurir
                        </button>
                    </form>
                @elseif(auth()->check() && auth()->user()->role === 'admin' && $transaction->status == 'courier_accepted')
                    <form action="{{ route('admin.handover', $transaction->id) }}" method="POST" class="w-full sm:w-auto">
                        @csrf
                        <button type="submit" class="w-full sm:w-auto bg-green-600 hover:bg-green-700 text-white font-bold px-5 py-3 rounded-xl text-xs uppercase tracking-wider transition duration-200">
                            Serahkan Barang ke Kurir
                        </button>
                    </form>
                @endif

                @if(auth()->check() && auth()->id() === $transaction->user_id && $transaction->status == 'delivered')
                    <div class="flex gap-2.5 w-full sm:w-auto">
                        <form action="{{ route('user.return', $transaction->id) }}" method="POST" class="w-1/2 sm:w-auto">
                            @csrf
                            <button type="submit" onclick="return confirm('Apakah Anda yakin ingin mengembalikan semua produk dalam pesanan ini?')" class="w-full bg-red-500 hover:bg-red-600 text-white font-bold px-4 py-3 rounded-xl text-xs uppercase tracking-wider transition duration-200">
                                Kembalikan Semua
                            </button>
                        </form>
                        <form action="{{ route('user.received', $transaction->id) }}" method="POST" class="w-1/2 sm:w-auto">
                            @csrf
                            <button type="submit" class="w-full bg-green-600 hover:bg-green-700 text-white font-bold px-4 py-3 rounded-xl text-xs uppercase tracking-wider transition duration-200">
                                Semua Diterima
                            </button>
                        </form>
                    </div>
                @elseif(auth()->check() && auth()->id() === $transaction->user_id && $transaction->status == 'shipped')
                    <div class="flex gap-2.5 w-full sm:w-auto">
                        <div class="w-full bg-blue-50 text-blue-600 border border-blue-200 font-bold px-4 py-3 rounded-xl text-xs uppercase tracking-wider text-center">
                            Pesanan Sedang Diantar Kurir
                        </div>
                    </div>
                @endif
            </div>
        </div>

    </div>

    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
    <script src="https://unpkg.com/leaflet-routing-machine@latest/dist/leaflet-routing-machine.js"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            var mapElement = document.getElementById('courier-map');
            if (mapElement) {
                var map = L.map('courier-map').setView([-6.200000, 106.816666], 13); // Default Jakarta

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

                var courierMarker = null;
                var routingControl = null;
                var destLatLng = null;

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
                
                function updateRoute(courierLat, courierLng) {
                    if (destLatLng) {
                        if (!routingControl) {
                            routingControl = L.Routing.control({
                                waypoints: [
                                    L.latLng(courierLat, courierLng),
                                    destLatLng
                                ],
                                lineOptions: {
                                    styles: [{color: '#2563EB', opacity: 0.8, weight: 6}] // Warna biru rute ala gojek
                                },
                                createMarker: function() { return null; }, 
                                fitSelectedRoutes: true,
                                show: false
                            }).addTo(map);
                        } else {
                            routingControl.setWaypoints([
                                L.latLng(courierLat, courierLng),
                                destLatLng
                            ]);
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
                                    L.marker(destLatLng, {icon: destIcon}).addTo(map).bindPopup('Lokasi Pengiriman: Rumah Anda').openPopup();
                                    if (courierMarker) {
                                        updateRoute(courierMarker.getLatLng().lat, courierMarker.getLatLng().lng);
                                    } else {
                                        map.setView(destLatLng, 13);
                                    }
                                } else if (!isFallback && fallbackQuery.trim() !== "") {
                                    console.log("Geocoding failed for full address, trying fallback:", fallbackQuery);
                                    geocodeAddress(fallbackQuery, true);
                                }
                            })
                            .catch(err => console.error("Geocoding error", err));
                    }
                }

                geocodeAddress(addressQuery);

                function fetchCourierLocation() {
                    fetch('{{ route("transaction.courier_location", $transaction->id) }}')
                        .then(response => {
                            if (!response.ok) {
                                throw new Error('Network response was not ok');
                            }
                            return response.json();
                        })
                        .then(data => {
                            if (data.latitude && data.longitude) {
                                var latlng = [data.latitude, data.longitude];
                                
                                if (!courierMarker) {
                                    courierMarker = L.marker(latlng, {icon: courierIcon}).addTo(map)
                                        .bindPopup('Lokasi Kurir').openPopup();
                                } else {
                                    courierMarker.setLatLng(latlng);
                                }

                                if (destLatLng) {
                                    updateRoute(data.latitude, data.longitude);
                                } else {
                                    map.setView(latlng, 15);
                                }
                            }
                        })
                        .catch(error => console.error('Error fetching courier location:', error));
                }

                // Initial fetch
                fetchCourierLocation();

                // Update location every 10 seconds
                setInterval(fetchCourierLocation, 10000);
            }
        });
    </script>
</body>
</html>

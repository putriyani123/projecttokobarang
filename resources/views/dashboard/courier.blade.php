<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Kurir</title>

    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body{
            background: #fff8f9;
            font-family: 'Poppins', sans-serif;
        }

        .card-hover{
            transition: 0.3s;
        }

        .card-hover:hover{
            transform: translateY(-5px);
        }

        @media(max-width:767px){
            .courier-sidebar{
                position:fixed;
                left:0;
                top:0;
                height:100vh;
                z-index:50;
                transform:translateX(-100%);
                transition:transform 0.3s cubic-bezier(0.16,1,0.3,1);
            }
            .courier-sidebar.open{
                transform:translateX(0);
            }
            /* Hide desktop table on mobile */
            .desktop-table { display: none !important; }
        }

        /* Hide mobile cards on desktop */
        @media(min-width:768px){
            .mobile-cards { display: none !important; }
        }

        .courier-overlay{
            display:none;
            position:fixed;
            inset:0;
            background:rgba(0,0,0,0.4);
            z-index:45;
            backdrop-filter:blur(3px);
        }

        .courier-overlay.active{
            display:block;
        }
    </style>
</head>
<body>

<div class="courier-overlay" id="courier-overlay"></div>

<div class="flex min-h-screen">

    <!-- Sidebar -->
    <aside class="w-64 bg-pink-950 text-white p-6 courier-sidebar" id="courier-sidebar">
        
        <h2 class="text-3xl font-bold mb-10 text-pink-100">
            🚚 Kurir Panel
        </h2>

        <nav class="space-y-3">

            <a href="/kurir/dashboard"
               class="block px-4 py-3 rounded-lg bg-pink-700 font-semibold shadow-sm">
                Dashboard
            </a>

            <a href="/transactions"
               class="block px-4 py-3 rounded-lg hover:bg-pink-800 transition">
                Data Pesanan
            </a>

            <a href="/logout"
               class="block px-4 py-3 rounded-lg hover:bg-pink-900 transition">
                Logout
            </a>

        </nav>
    </aside>

    <!-- Main -->
    <main class="flex-1 p-4 md:p-8">

        <!-- Header -->
        <div class="flex justify-between items-center mb-8">

            <div class="flex items-center gap-3">
                <button id="courier-burger" class="md:hidden w-10 h-10 rounded-xl bg-pink-100 flex items-center justify-center text-pink-600">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round">
                        <line x1="3" y1="6" x2="21" y2="6"/>
                        <line x1="3" y1="12" x2="21" y2="12"/>
                        <line x1="3" y1="18" x2="21" y2="18"/>
                    </svg>
                </button>
                <div>
                    <h1 class="text-2xl md:text-4xl font-bold text-gray-800">
                        Dashboard Kurir
                    </h1>
                    <p class="text-gray-500 mt-1 text-sm">
                        Selamat datang, {{ auth()->user()->name }}
                    </p>
                </div>
            </div>

            <div class="bg-white px-3 py-2 md:px-5 md:py-3 rounded-xl shadow border border-pink-100">
                <p class="text-xs text-gray-400">Status</p>
                <p class="font-bold text-pink-600 text-sm md:text-base">Kurir Aktif</p>
            </div>

        </div>

        <!-- Session Messages and Validation Errors -->
        @if(session('success'))
            <div class="bg-green-100 border border-green-200 text-green-700 px-4 py-3 rounded-xl mb-6 shadow-sm">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="bg-red-100 border border-red-200 text-red-700 px-4 py-3 rounded-xl mb-6 shadow-sm">
                {{ session('error') }}
            </div>
        @endif

        @if($errors->any())
            <div class="bg-red-100 border border-red-200 text-red-700 px-4 py-3 rounded-xl mb-6 shadow-sm">
                <ul class="list-disc list-inside text-sm">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- Cards -->
        <div class="grid grid-cols-2 md:grid-cols-2 xl:grid-cols-4 gap-3 md:gap-6 mb-6 md:mb-10">

            <!-- Card 1 -->
            <div class="bg-white rounded-xl md:rounded-2xl shadow-sm border border-pink-100/50 p-3 md:p-6 card-hover border-l-4 border-pink-300">
                <div class="flex justify-between items-center">
                    <div>
                        <p class="text-gray-400 text-[10px] md:text-xs font-semibold uppercase tracking-wider mb-1 md:mb-2">
                            Tugas Baru
                        </p>
                        <h2 class="text-2xl md:text-4xl font-bold text-gray-800">
                            {{ $newTasks }}
                        </h2>
                    </div>
                    <div class="text-3xl md:text-5xl">
                        📦
                    </div>
                </div>
            </div>

            <!-- Card 2 -->
            <div class="bg-white rounded-xl md:rounded-2xl shadow-sm border border-pink-100/50 p-3 md:p-6 card-hover border-l-4 border-pink-500">
                <div class="flex justify-between items-center">
                    <div>
                        <p class="text-gray-400 text-[10px] md:text-xs font-semibold uppercase tracking-wider mb-1 md:mb-2">
                            Sedang Dikirim
                        </p>
                        <h2 class="text-2xl md:text-4xl font-bold text-gray-800">
                            {{ $shippingOrders }}
                        </h2>
                    </div>
                    <div class="text-3xl md:text-5xl">
                        🚚
                    </div>
                </div>
            </div>

            <!-- Card 3 -->
            <div class="bg-white rounded-xl md:rounded-2xl shadow-sm border border-pink-100/50 p-3 md:p-6 card-hover border-l-4 border-pink-600">
                <div class="flex justify-between items-center">
                    <div>
                        <p class="text-gray-400 text-[10px] md:text-xs font-semibold uppercase tracking-wider mb-1 md:mb-2">
                            Pesanan Selesai
                        </p>
                        <h2 class="text-2xl md:text-4xl font-bold text-gray-800">
                            {{ $completedOrders }}
                        </h2>
                    </div>
                    <div class="text-3xl md:text-5xl">
                        ✅
                    </div>
                </div>
            </div>

            <!-- Card 4 -->
            <div class="bg-white rounded-xl md:rounded-2xl shadow-sm border border-pink-100/50 p-3 md:p-6 card-hover border-l-4 border-pink-400">
                <div class="flex justify-between items-center">
                    <div>
                        <p class="text-gray-400 text-[10px] md:text-xs font-semibold uppercase tracking-wider mb-1 md:mb-2">
                            Total Pesanan
                        </p>
                        <h2 class="text-2xl md:text-4xl font-bold text-gray-800">
                            {{ $totalOrders }}
                        </h2>
                    </div>
                    <div class="text-3xl md:text-5xl">
                        📋
                    </div>
                </div>
            </div>

        </div>

        <!-- ============ MOBILE CARD LIST ============ -->
        <div class="mobile-cards space-y-3">
            <h2 class="text-lg font-bold text-gray-800 mb-2">📋 Pesanan Terbaru</h2>

            @forelse($recentTransactions as $trx)
            <div class="bg-white rounded-xl shadow-sm border border-pink-100/50 p-4">
                <!-- Top row: ID + Status -->
                <div class="flex justify-between items-center mb-2">
                    <span class="font-bold text-pink-600 text-sm">#{{ $trx->id }}</span>
                    @if($trx->status == 'assigned')
                        <span class="bg-indigo-100 text-indigo-700 px-2 py-0.5 rounded-full text-xs font-semibold">Tugas Baru</span>
                    @elseif($trx->status == 'courier_accepted')
                        <span class="bg-yellow-100 text-yellow-700 px-2 py-0.5 rounded-full text-xs font-semibold">Menunggu Admin</span>
                    @elseif($trx->status == 'admin_handed_over')
                        <span class="bg-orange-100 text-orange-700 px-2 py-0.5 rounded-full text-xs font-semibold">Siap Diambil</span>
                    @elseif($trx->status == 'shipped')
                        <span class="bg-blue-100 text-blue-700 px-2 py-0.5 rounded-full text-xs font-semibold">Dikirim</span>
                    @elseif($trx->status == 'completed')
                        <span class="bg-green-100 text-green-700 px-2 py-0.5 rounded-full text-xs font-semibold">Selesai</span>
                    @endif
                </div>

                <!-- Customer & Total -->
                <div class="flex justify-between items-center mb-1">
                    <p class="text-sm font-semibold text-gray-700">👤 {{ $trx->user->name ?? '-' }}</p>
                    <p class="text-sm font-bold text-pink-600">Rp {{ number_format($trx->total_price,0,',','.') }}</p>
                </div>

                <!-- Address -->
                <p class="text-xs text-gray-400 mb-3 leading-relaxed">
                    📍 @if($trx->address)
                        {{ $trx->address->detail_address }}, {{ $trx->address->village }}, {{ $trx->address->district }}, {{ $trx->address->city }}, {{ $trx->address->province }}
                    @else
                        Alamat belum diisi
                    @endif
                </p>

                <!-- Actions -->
                @if($trx->status == 'assigned')
                    <form action="{{ route('kurir.accept_task', $trx->id) }}" method="POST">
                        @csrf
                        <button class="w-full bg-indigo-600 hover:bg-indigo-700 text-white py-2.5 rounded-lg font-semibold transition text-sm">Terima Tugas</button>
                    </form>
                @elseif($trx->status == 'admin_handed_over')
                    <form action="{{ route('kurir.pickup', $trx->id) }}" method="POST">
                        @csrf
                        <button class="w-full bg-orange-600 hover:bg-orange-700 text-white py-2.5 rounded-lg font-semibold transition text-sm">Konfirmasi Barang Diambil</button>
                    </form>
                @elseif($trx->status == 'shipped')
                    <div class="space-y-2">
                        <a href="{{ route('kurir.delivery_map', $trx->id) }}" class="block w-full bg-blue-600 hover:bg-blue-700 text-white py-2.5 rounded-lg font-semibold transition text-center text-sm">🗺️ Buka Map Antar</a>
                        <form action="{{ route('kurir.complete', $trx->id) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <input type="file" name="proof" required class="mb-2 text-xs w-full border border-gray-200 rounded-lg p-1.5">
                            <button class="w-full bg-emerald-600 hover:bg-emerald-700 text-white py-2.5 rounded-lg font-semibold transition text-sm">✅ Selesaikan</button>
                        </form>
                    </div>
                @endif
            </div>
            @empty
            <div class="bg-white rounded-xl p-8 text-center text-gray-400 text-sm">
                Belum ada pesanan.
            </div>
            @endforelse
        </div>

        <!-- ============ DESKTOP TABLE ============ -->
        <div class="bg-white rounded-2xl shadow overflow-hidden desktop-table">

            <div class="p-6 border-b">
                <h2 class="text-2xl font-bold text-gray-800">
                    Pesanan Terbaru
                </h2>
            </div>

            <div class="overflow-x-auto">

                <table class="w-full">

                    <thead class="bg-pink-50">
                        <tr class="text-left text-pink-600 font-bold">
                            <th class="p-4">ID</th>
                            <th class="p-4">Customer</th>
                            <th class="p-4">Alamat</th>
                            <th class="p-4">Total</th>
                            <th class="p-4">Status</th>
                            <th class="p-4">Aksi</th>
                        </tr>
                    </thead>

                    <tbody>

                        @forelse($recentTransactions as $trx)

                        <tr class="border-b border-pink-100 hover:bg-pink-50/20">

                            <td class="p-4 font-semibold text-pink-600">
                                #{{ $trx->id }}
                            </td>

                            <td class="p-4">
                                {{ $trx->user->name ?? '-' }}
                            </td>

                            <td class="p-4 text-xs max-w-xs">
                                @if($trx->address)
                                    {{ $trx->address->detail_address }}, {{ $trx->address->village }}, {{ $trx->address->district }}, {{ $trx->address->city }}, {{ $trx->address->province }}
                                @else
                                    -
                                @endif
                            </td>

                            <td class="p-4 font-bold text-pink-600">
                                Rp {{ number_format($trx->total_price,0,',','.') }}
                            </td>

                             <td class="p-4">
                                @if($trx->status == 'assigned')
                                    <span class="bg-indigo-100 text-indigo-700 px-3 py-1 rounded-full text-sm font-semibold">Tugas Baru</span>
                                @elseif($trx->status == 'courier_accepted')
                                    <span class="bg-yellow-100 text-yellow-700 px-3 py-1 rounded-full text-sm font-semibold">Menunggu Admin</span>
                                @elseif($trx->status == 'admin_handed_over')
                                    <span class="bg-orange-100 text-orange-700 px-3 py-1 rounded-full text-sm font-semibold">Barang Siap Diambil</span>
                                @elseif($trx->status == 'shipped')
                                    <span class="bg-blue-100 text-blue-700 px-3 py-1 rounded-full text-sm font-semibold">Dikirim</span>
                                @elseif($trx->status == 'completed')
                                    <span class="bg-green-100 text-green-700 px-3 py-1 rounded-full text-sm font-semibold">Selesai</span>
                                @endif
                            </td>

                            <td class="p-4">
                                @if($trx->status == 'assigned')
                                    <form action="{{ route('kurir.accept_task', $trx->id) }}" method="POST">
                                        @csrf
                                        <button class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-lg font-semibold transition">Terima Tugas</button>
                                    </form>
                                @elseif($trx->status == 'admin_handed_over')
                                    <form action="{{ route('kurir.pickup', $trx->id) }}" method="POST">
                                        @csrf
                                        <button class="bg-orange-600 hover:bg-orange-700 text-white px-4 py-2 rounded-lg font-semibold transition">Konfirmasi Barang Diambil</button>
                                    </form>
                                @elseif($trx->status == 'shipped')
                                    <div class="flex flex-col gap-2">
                                        <a href="{{ route('kurir.delivery_map', $trx->id) }}" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg font-semibold transition text-center text-sm shadow-sm">Buka Map Antar</a>
                                        <form action="{{ route('kurir.complete', $trx->id) }}" method="POST" enctype="multipart/form-data">
                                            @csrf
                                            <input type="file" name="proof" required class="mb-2 text-sm w-full">
                                            <button class="bg-emerald-600 hover:bg-emerald-700 text-white px-4 py-2 rounded-lg font-semibold transition shadow-sm w-full text-sm">Selesaikan</button>
                                        </form>
                                    </div>
                                @else
                                    <span class="text-gray-400 text-xs">-</span>
                                @endif
                            </td>

                        </tr>

                        @empty

                        <tr>
                            <td colspan="6" class="text-center p-10 text-gray-500">
                                Belum ada pesanan.
                            </td>
                        </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>

        </div>

    </main>

</div>

<script>
    const courierBurger = document.getElementById('courier-burger');
    const courierSidebar = document.getElementById('courier-sidebar');
    const courierOverlay = document.getElementById('courier-overlay');

    function toggleCourierSidebar() {
        courierSidebar.classList.toggle('open');
        courierOverlay.classList.toggle('active');
    }

    courierBurger.addEventListener('click', toggleCourierSidebar);
    courierOverlay.addEventListener('click', toggleCourierSidebar);

    // KURIR LOCATION TRACKING
    function updateLocation() {
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(function(position) {
                const lat = position.coords.latitude;
                const lng = position.coords.longitude;

                fetch('/kurir/update-location', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        latitude: lat,
                        longitude: lng
                    })
                })
                .then(response => response.json())
                .then(data => console.log('Location updated'))
                .catch(error => console.error('Error updating location:', error));
            });
        }
    }

    // Update location every 15 seconds
    setInterval(updateLocation, 15000);
    // Initial call
    updateLocation();
</script>

</body>
</html>
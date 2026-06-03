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
    <main class="flex-1 p-8">

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

            <div class="bg-white px-5 py-3 rounded-xl shadow border border-pink-100">
                <p class="text-xs text-gray-400">Status</p>
                <p class="font-bold text-pink-600">Kurir Aktif</p>
            </div>

        </div>

        <!-- Cards -->
        <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-6 mb-10">

            <!-- Card 1 -->
            <div class="bg-white rounded-2xl shadow-sm border border-pink-100/50 p-6 card-hover border-l-4 border-pink-300">

                <div class="flex justify-between items-center">
                    <div>
                        <p class="text-gray-400 text-xs font-semibold uppercase tracking-wider mb-2">
                            Siap Dikirim
                        </p>

                        <h2 class="text-4xl font-bold text-gray-800">
                            {{ $readyToShip }}
                        </h2>
                    </div>

                    <div class="text-5xl">
                        📦
                    </div>
                </div>

            </div>

            <!-- Card 2 -->
            <div class="bg-white rounded-2xl shadow-sm border border-pink-100/50 p-6 card-hover border-l-4 border-pink-500">

                <div class="flex justify-between items-center">
                    <div>
                        <p class="text-gray-400 text-xs font-semibold uppercase tracking-wider mb-2">
                            Sedang Dikirim
                        </p>

                        <h2 class="text-4xl font-bold text-gray-800">
                            {{ $shippingOrders }}
                        </h2>
                    </div>

                    <div class="text-5xl">
                        🚚
                    </div>
                </div>

            </div>

            <!-- Card 3 -->
            <div class="bg-white rounded-2xl shadow-sm border border-pink-100/50 p-6 card-hover border-l-4 border-pink-600">

                <div class="flex justify-between items-center">
                    <div>
                        <p class="text-gray-400 text-xs font-semibold uppercase tracking-wider mb-2">
                            Pesanan Selesai
                        </p>

                        <h2 class="text-4xl font-bold text-gray-800">
                            {{ $completedOrders }}
                        </h2>
                    </div>

                    <div class="text-5xl">
                        ✅
                    </div>
                </div>

            </div>

            <!-- Card 4 -->
            <div class="bg-white rounded-2xl shadow-sm border border-pink-100/50 p-6 card-hover border-l-4 border-pink-400">

                <div class="flex justify-between items-center">
                    <div>
                        <p class="text-gray-400 text-xs font-semibold uppercase tracking-wider mb-2">
                            Total Pesanan
                        </p>

                        <h2 class="text-4xl font-bold text-gray-800">
                            {{ $totalOrders }}
                        </h2>
                    </div>

                    <div class="text-5xl">
                        📋
                    </div>
                </div>

            </div>

        </div>

        <!-- Table -->
        <div class="bg-white rounded-2xl shadow overflow-hidden">

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

                            <td class="p-4">
                                {{ $trx->address->address ?? '-' }}
                            </td>

                            <td class="p-4 font-bold text-pink-600">
                                Rp {{ number_format($trx->total_price,0,',','.') }}
                            </td>

                             <td class="p-4">

                                @if($trx->status == 'confirmed')

                                    <span class="bg-yellow-100 text-yellow-700 px-3 py-1 rounded-full text-sm font-semibold">
                                        Siap Dikirim
                                    </span>

                                @elseif($trx->status == 'shipped')

                                    <span class="bg-blue-100 text-blue-700 px-3 py-1 rounded-full text-sm font-semibold">
                                        Dikirim
                                    </span>

                                @elseif($trx->status == 'delivered')

                                    <span class="bg-emerald-100 text-emerald-700 px-3 py-1 rounded-full text-sm font-semibold">
                                        Terkirim
                                    </span>

                                @elseif($trx->status == 'completed')

                                    <span class="bg-green-100 text-green-700 px-3 py-1 rounded-full text-sm font-semibold">
                                        Selesai
                                    </span>

                                @endif

                            </td>

                            <td class="p-4">

                                @if($trx->status == 'confirmed')

                                <form action="{{ route('kurir.ship', $trx->id) }}" method="POST">

                                    @csrf

                                    <button class="bg-pink-600 hover:bg-pink-700 text-white px-4 py-2 rounded-lg font-semibold transition">
                                        Kirim
                                    </button>

                                </form>

                                @elseif($trx->status == 'shipped')

                                <form action="{{ route('kurir.complete', $trx->id) }}"
                                      method="POST"
                                      enctype="multipart/form-data">

                                    @csrf

                                    <input type="file"
                                           name="proof"
                                           required
                                           class="mb-2 text-sm">

                                    <button class="bg-emerald-600 hover:bg-emerald-700 text-white px-4 py-2 rounded-lg font-semibold transition shadow-sm">
                                        Selesaikan
                                    </button>

                                </form>

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
</script>

</body>
</html>
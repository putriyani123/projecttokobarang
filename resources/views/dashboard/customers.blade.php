<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Pelanggan - Cosmetic-store</title>

    <script src="https://cdn.tailwindcss.com"></script>

    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,600;0,700;1,400&family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #fff8f9;
            color: #2d1b22;
        }

        h1, h2, h3, h4, .serif-font {
            font-family: 'Playfair Display', serif;
        }

        ::-webkit-scrollbar {
            width: 6px;
            height: 6px;
        }

        ::-webkit-scrollbar-track {
            background: transparent;
        }

        ::-webkit-scrollbar-thumb {
            background: #ff8fab;
            border-radius: 10px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: #ff5d8f;
        }

        .sidebar-bg {
            background-color: #ffffff;
            border-right: 1px solid #fde7ee;
        }

        .table-row-hover {
            transition: all 0.2s ease;
        }

        .table-row-hover:hover {
            background-color: #fff0f3;
        }

        .btn-primary {
            background: linear-gradient(135deg, #ff6fa9, #ff2e7e);
            color: white;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(255, 46, 126, 0.2);
        }

        .btn-primary:hover {
            box-shadow: 0 6px 20px rgba(255, 46, 126, 0.35);
            transform: translateY(-2px);
        }
    </style>
</head>

<body class="min-h-screen flex overflow-hidden">

    <!-- Sidebar -->
    <aside class="w-64 sidebar-bg text-[#3f312b] min-h-screen flex-col hidden md:flex fixed h-full z-20">

        <div class="p-8 border-b border-pink-100">

            <h2 class="text-2xl font-bold serif-font flex items-center gap-3 text-pink-600">

                <div class="w-10 h-10 rounded-xl bg-pink-100 flex items-center justify-center text-pink-500 shadow-sm">
                    <span class="text-xl">🎁</span>
                </div>

                HampersKu

            </h2>

        </div>

        <nav class="flex-1 px-5 py-6 space-y-2 overflow-y-auto">

            <a href="/"
               class="flex items-center gap-3 px-4 py-3.5 rounded-xl text-sm font-semibold transition-all text-gray-500 hover:text-pink-600 hover:bg-pink-50">
                Kembali ke Toko
            </a>

            <div class="pt-4 pb-2">
                <p class="px-4 text-xs font-bold uppercase tracking-wider text-pink-400">
                    Menu Admin
                </p>
            </div>

            <a href="/admin/dashboard"
               class="flex items-center gap-3 px-4 py-3.5 rounded-xl text-sm font-semibold transition-all text-gray-500 hover:text-pink-600 hover:bg-pink-50">
                Dashboard
            </a>

            <a href="/products"
               class="flex items-center gap-3 px-4 py-3.5 rounded-xl text-sm font-semibold transition-all text-gray-500 hover:text-pink-600 hover:bg-pink-50">
                Kelola Produk
            </a>

            <a href="/categories"
               class="flex items-center gap-3 px-4 py-3.5 rounded-xl text-sm font-semibold transition-all text-gray-500 hover:text-pink-600 hover:bg-pink-50">
                Kategori
            </a>

            <a href="/transactions"
               class="flex items-center gap-3 px-4 py-3.5 rounded-xl text-sm font-semibold transition-all text-gray-500 hover:text-pink-600 hover:bg-pink-50">
                Transaksi
            </a>

            <a href="/admin/customers"
               class="flex items-center gap-3 px-4 py-3.5 btn-primary rounded-xl text-sm font-bold transition-all shadow-md">
                Data Pelanggan
            </a>

        </nav>

    </aside>

    <!-- Main -->
    <main class="flex-1 md:ml-64 relative z-10 flex flex-col h-screen overflow-y-auto">

        <!-- Header -->
        <header class="bg-white/80 backdrop-blur-md sticky top-0 z-30 px-8 py-5 flex items-center justify-between border-b border-pink-100">

            <div>

                <h1 class="text-2xl font-bold text-gray-800 serif-font">
                    Data Pelanggan
                </h1>

                <p class="text-sm text-gray-500 mt-0.5">
                    Daftar pengguna terdaftar dan riwayat belanja mereka
                </p>

            </div>

            <div class="flex items-center gap-5">

                <div class="text-right hidden sm:block">

                    <p class="text-sm font-bold text-gray-800">
                        {{ auth()->user()->name }}
                    </p>

                    <p class="text-xs text-pink-500 font-bold tracking-widest uppercase">
                        Admin
                    </p>

                </div>

                <div class="w-10 h-10 rounded-full bg-pink-100 text-pink-600 flex items-center justify-center font-bold text-lg border-2 border-white shadow-sm">
                    {{ substr(auth()->user()->name, 0, 1) }}
                </div>

            </div>

        </header>

        <!-- Content -->
        <div class="px-6 py-8 w-full max-w-7xl mx-auto space-y-8 flex-1">

            <div class="bg-white rounded-2xl border border-pink-100 shadow-sm overflow-hidden">

                <!-- SEARCH -->
                <div class="px-6 pt-6">

                    <form method="GET" action="" class="flex flex-col sm:flex-row gap-4">

                        <div class="relative flex-1">

                            <input
                                type="text"
                                name="search"
                                value="{{ request('search') }}"
                                placeholder="Cari nama pelanggan atau email..."
                                class="w-full pl-12 pr-4 py-3 rounded-2xl border border-pink-100 bg-pink-50/10 focus:outline-none focus:ring-2 focus:ring-pink-400 text-sm font-medium text-gray-800"
                            >

                            <svg class="w-5 h-5 absolute left-4 top-1/2 -translate-y-1/2 text-pink-500"
                                 fill="none"
                                 stroke="currentColor"
                                 viewBox="0 0 24 24">

                                <path stroke-linecap="round"
                                      stroke-linejoin="round"
                                      stroke-width="2"
                                      d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z">
                                </path>

                            </svg>

                        </div>

                        <button type="submit"
                                class="btn-primary px-6 py-3 rounded-2xl text-sm font-bold shadow-md">

                            Cari

                        </button>

                    </form>

                </div>

                <!-- HEADER TABLE -->
                <div class="px-6 py-5 flex items-center justify-between border-b border-pink-100">

                    <div>

                        <h3 class="text-xl font-bold text-gray-800 serif-font">
                            Daftar Pengguna
                        </h3>

                        <p class="text-sm font-medium text-gray-500 mt-1">
                            Total: {{ count($customers) }} pelanggan terdaftar
                        </p>

                    </div>

                </div>

                <!-- TABLE -->
                <div class="overflow-x-auto">

                    <table class="w-full text-left">

                        <thead class="bg-pink-50/30">

                            <tr class="text-xs font-bold tracking-wide text-pink-600 uppercase">

                                <th class="px-6 py-4">
                                    Nama Pelanggan
                                </th>

                                <th class="px-6 py-4">
                                    Produk yang Dibeli
                                </th>

                                <th class="px-6 py-4 text-center">
                                    Jumlah Pesanan
                                </th>

                                <th class="px-6 py-4">
                                    Total Belanja
                                </th>

                                <th class="px-6 py-4 text-right">
                                    Bergabung
                                </th>

                            </tr>

                        </thead>

                        <tbody class="divide-y divide-pink-100/50">

                            @forelse($customers as $customer)

                            @php
                                $totalPesanan = $customer->transactions->count();
                                $totalBelanja = $customer->transactions->sum('total_price');
                            @endphp

                            <tr class="table-row-hover">

                                <td class="px-6 py-4">

                                    <div class="flex items-center gap-3">

                                        <div class="w-10 h-10 rounded-xl bg-pink-100 flex items-center justify-center text-pink-600 font-bold text-lg shadow-sm">
                                            {{ strtoupper(substr($customer->name, 0, 1)) }}
                                        </div>

                                        <div>

                                            <div class="font-bold text-gray-800">
                                                {{ $customer->name }}
                                            </div>

                                            <div class="text-sm text-gray-500">
                                                {{ $customer->email }}
                                            </div>

                                        </div>

                                    </div>

                                </td>

                                <td class="px-6 py-4">

                                    <div class="flex gap-2 overflow-x-auto pb-2">

                                        @php $shownProducts = []; @endphp

                                        @foreach($customer->transactions as $trx)

                                            @foreach($trx->items as $item)

                                                @if($item->product && !in_array($item->product->id, $shownProducts))

                                                    @php
                                                        $shownProducts[] = $item->product->id;
                                                    @endphp

                                                    <div class="flex-shrink-0 text-center w-14">

                                                        <img src="{{ $item->product->image ? asset('storage/'.$item->product->image) : 'https://via.placeholder.com/150' }}"
                                                             class="w-10 h-10 rounded-xl object-cover shadow-sm mx-auto border border-pink-100">

                                                        <p class="text-[9px] font-bold text-gray-500 mt-1 truncate">
                                                            {{ $item->product->name }}
                                                        </p>

                                                    </div>

                                                @endif

                                            @endforeach

                                        @endforeach

                                    </div>

                                </td>

                                <td class="px-6 py-4 text-center">

                                    <span class="inline-flex items-center justify-center w-8 h-8 rounded-full bg-pink-100 text-pink-600 font-bold shadow-sm">
                                        {{ $totalPesanan }}
                                    </span>

                                </td>

                                <td class="px-6 py-4">

                                    <span class="font-bold text-pink-600">
                                        Rp {{ number_format($totalBelanja, 0, ',', '.') }}
                                    </span>

                                </td>

                                <td class="px-6 py-4 text-right text-sm font-semibold text-gray-500">

                                    {{ $customer->created_at->format('d M Y') }}

                                </td>

                            </tr>

                            @empty

                            <tr>

                                <td colspan="5" class="px-6 py-12 text-center">

                                    <div class="text-pink-500 mb-2 text-4xl">
                                         👥
                                     </div>

                                     <p class="text-gray-500 font-medium">
                                         Belum ada pelanggan terdaftar.
                                     </p>

                                </td>

                            </tr>

                            @endforelse

                        </tbody>

                    </table>

                </div>

            </div>

        </div>

    </main>

</body>
</html>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Pelanggan - Cosmetic Store</title>

    <script src="https://cdn.tailwindcss.com"></script>

    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;600;700&family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <style>
        body{
            font-family:'Poppins',sans-serif;
            background:#fff8f8;
            color:#3f312b;
        }

        h1,h2,h3,h4,.serif-font{
            font-family:'Playfair Display',serif;
        }

        .glass-panel{
            background:rgba(255,255,255,0.92);
            backdrop-filter:blur(18px);
            border:1px solid #fde7ee;
            box-shadow:0 8px 30px rgba(0,0,0,0.03);
        }

        .btn-primary{
            background:linear-gradient(135deg,#ff8fab,#ff5d8f);
            color:white;
            transition:0.3s ease;
            box-shadow:0 8px 20px rgba(255,93,143,0.25);
        }

        .btn-primary:hover{
            transform:translateY(-2px);
            box-shadow:0 12px 25px rgba(255,93,143,0.35);
        }

        .card-hover{
            transition:0.3s ease;
        }

        .card-hover:hover{
            transform:translateY(-4px);
            box-shadow:0 12px 30px rgba(0,0,0,0.06);
        }

        .mobile-menu{
            max-height:0;
            overflow:hidden;
            transition:max-height 0.4s cubic-bezier(0.16,1,0.3,1);
        }

        .mobile-menu.open{
            max-height:400px;
        }

        .burger-line{
            display:block;
            width:20px;
            height:2.5px;
            background:linear-gradient(135deg,#ff8fab,#ff5d8f);
            border-radius:999px;
            transition:0.3s ease;
        }
    </style>
</head>

<body class="min-h-screen pb-20">

<!-- NAVBAR -->
<nav class="glass-panel sticky top-0 z-50">
    <div class="max-w-7xl mx-auto px-5">
        <div class="flex justify-between h-16 md:h-20 items-center">

            <!-- LOGO -->
            <div class="flex items-center gap-3">

                <div class="w-10 h-10 md:w-11 md:h-11 rounded-2xl bg-pink-100 flex items-center justify-center text-pink-500 shadow-sm flex-shrink-0">
                    💄
                </div>

                <div>
                    <h1 class="text-base md:text-lg font-bold text-pink-600 serif-font">
                        Cosmetic Store
                    </h1>

                    <p class="text-[9px] md:text-[11px] text-gray-400 font-medium">
                        Beauty & Skincare
                    </p>
                </div>

            </div>

            <!-- MENU -->
            <div class="hidden md:flex items-center gap-2 bg-white p-1 rounded-2xl border border-pink-100">

                <a href="/user/dashboard"
                   class="px-5 py-2 rounded-xl bg-pink-50 text-pink-600 text-sm font-bold">
                    Beranda
                </a>

                <a href="/products"
                   class="px-5 py-2 rounded-xl text-sm font-semibold text-gray-500 hover:bg-pink-50 hover:text-pink-600 transition">
                    Produk
                </a>

                <a href="/transactions"
                   class="px-5 py-2 rounded-xl text-sm font-semibold text-gray-500 hover:bg-pink-50 hover:text-pink-600 transition">
                    Pesanan
                </a>

                <a href="/profile"
                   class="px-5 py-2 rounded-xl text-sm font-semibold text-gray-500 hover:bg-pink-50 hover:text-pink-600 transition">
                    Profil
                </a>

            </div>

            <!-- HAMBURGER MOBILE -->
            <button id="user-burger" class="md:hidden flex flex-col gap-[5px] p-2 rounded-xl hover:bg-pink-50 transition">
                <span class="burger-line"></span>
                <span class="burger-line"></span>
                <span class="burger-line"></span>
            </button>

            <!-- PROFILE -->
            <div class="flex items-center gap-4">

                <div class="hidden sm:block text-right">
                    <p class="text-sm font-bold text-gray-800">
                        {{ auth()->user()->name }}
                    </p>

                    <p class="text-[11px] text-pink-500 font-semibold">
                        Beauty Member
                    </p>
                </div>

                <div class="relative group">

                    <div class="w-11 h-11 rounded-full bg-gradient-to-r from-pink-400 to-pink-500 text-white flex items-center justify-center font-bold shadow-lg cursor-pointer">
                        {{ substr(auth()->user()->name,0,1) }}
                    </div>

                    <!-- DROPDOWN -->
                    <div class="absolute right-0 mt-3 w-52 bg-white rounded-2xl border border-pink-100 shadow-xl opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-300">

                        <div class="p-2">

                            <a href="/profile"
                               class="block px-4 py-3 rounded-xl text-sm text-gray-600 hover:bg-pink-50 hover:text-pink-600 font-medium transition">
                                👤 Profil Saya
                            </a>

                            <a href="/addresses"
                               class="block px-4 py-3 rounded-xl text-sm text-gray-600 hover:bg-pink-50 hover:text-pink-600 font-medium transition">
                                📍 Alamat Saya
                            </a>

                            <a href="/cart"
                               class="block px-4 py-3 rounded-xl text-sm text-gray-600 hover:bg-pink-50 hover:text-pink-600 font-medium transition">
                                🛒 Keranjang
                            </a>

                            <div class="border-t border-pink-100 my-1"></div>

                            <a href="/logout"
                               class="block px-4 py-3 rounded-xl text-sm font-bold text-red-500 hover:bg-red-50 transition">
                                Logout
                            </a>

                        </div>

                    </div>

                </div>

            </div>

        </div>
    </div>
</nav>

<!-- MOBILE MENU -->
<div class="mobile-menu md:hidden" id="user-mobile-menu">
    <div class="glass-panel border-t-0 px-5 pb-5">
        <div class="bg-white rounded-2xl border border-pink-100 p-2 space-y-1">
            <a href="/user/dashboard" class="block px-4 py-3 rounded-xl bg-pink-50 text-pink-600 text-sm font-bold">🏠 Beranda</a>
            <a href="/products" class="block px-4 py-3 rounded-xl text-sm font-semibold text-gray-600 hover:bg-pink-50 hover:text-pink-600 transition">💄 Produk</a>
            <a href="/transactions" class="block px-4 py-3 rounded-xl text-sm font-semibold text-gray-600 hover:bg-pink-50 hover:text-pink-600 transition">🛍️ Pesanan</a>
            <a href="/profile" class="block px-4 py-3 rounded-xl text-sm font-semibold text-gray-600 hover:bg-pink-50 hover:text-pink-600 transition">👤 Profil Saya</a>
            <a href="/addresses" class="block px-4 py-3 rounded-xl text-sm font-semibold text-gray-600 hover:bg-pink-50 hover:text-pink-600 transition">📍 Alamat Saya</a>
            <a href="/cart" class="block px-4 py-3 rounded-xl text-sm font-semibold text-gray-600 hover:bg-pink-50 hover:text-pink-600 transition">🛒 Keranjang</a>
            <div class="border-t border-pink-100 my-1"></div>
            <a href="/logout" class="block px-4 py-3 rounded-xl text-sm font-bold text-red-500 hover:bg-red-50 transition">🚪 Logout</a>
        </div>
    </div>
</div>

<!-- MAIN -->
<main class="max-w-7xl mx-auto px-5 mt-8">

    <!-- DISCOUNT BANNER -->
    @if(isset($promoBannerActive) && $promoBannerActive)
    <div class="bg-gradient-to-r from-pink-500 via-rose-500 to-pink-600 rounded-[25px] p-6 mb-8 text-white shadow-lg relative overflow-hidden flex flex-col md:flex-row items-center justify-between">
        <div class="absolute top-0 right-0 w-64 h-64 bg-white opacity-10 rounded-full blur-3xl transform translate-x-1/2 -translate-y-1/2"></div>
        <div class="relative z-10 flex items-center gap-4">
            <div class="w-14 h-14 bg-white/20 rounded-2xl flex flex-col items-center justify-center backdrop-blur-sm border border-white/30">
                @if($globalDiscount > 0)
                    <span class="text-xs font-bold text-white uppercase tracking-wider mb-0.5">DISC</span>
                    <span class="text-xl font-extrabold text-white leading-none">{{ rtrim(rtrim(number_format($globalDiscount, 2), '0'), '.') }}%</span>
                @else
                    <span class="text-3xl">🎉</span>
                @endif
            </div>
            <div>
                <h3 class="text-xl font-bold serif-font mb-1 text-white">{{ $promoTitle }}</h3>
                <p class="text-pink-100 text-sm">{{ $promoDescription }}</p>
            </div>
        </div>
        <div class="relative z-10 mt-4 md:mt-0">
            <a href="/products" class="px-6 py-3 bg-white text-pink-600 font-bold rounded-xl text-sm shadow-md hover:bg-pink-50 transition block text-center">
                Lihat Promo 🛍️
            </a>
        </div>
    </div>
    @endif

    <!-- HERO -->
    <div class="bg-white rounded-[35px] border border-pink-100 p-8 md:p-12 shadow-sm overflow-hidden relative mb-8">

        <div class="absolute top-0 right-0 w-72 h-72 bg-pink-100 rounded-full blur-3xl opacity-40"></div>

        <div class="relative z-10 flex flex-col lg:flex-row items-center justify-between gap-10">

            <!-- LEFT -->
            <div class="max-w-2xl">

                <span class="inline-flex items-center px-4 py-2 rounded-full bg-pink-50 text-pink-500 text-xs font-bold mb-5">
                    ✨ Welcome Back Beauty Lovers
                </span>

                <h1 class="text-3xl md:text-5xl font-bold leading-tight text-gray-800 serif-font mb-5">
                    Temukan Produk
                    <span class="text-pink-500">
                        Skincare & Makeup
                    </span>
                    Favoritmu 💄
                </h1>

                <p class="text-gray-500 leading-relaxed text-sm md:text-base mb-8 max-w-xl">
                    Jelajahi berbagai produk kecantikan premium mulai dari skincare,
                    serum, sunscreen, makeup hingga bodycare terbaik untuk tampil lebih percaya diri setiap hari.
                </p>

                <div class="flex flex-wrap gap-4">

                    <a href="/products"
                       class="px-7 py-4 rounded-2xl btn-primary text-sm font-bold">
                        Belanja Sekarang →
                    </a>

                    <a href="/transactions"
                       class="px-7 py-4 rounded-2xl border border-pink-200 text-pink-500 text-sm font-bold hover:bg-pink-50 transition">
                        Lihat Pesanan
                    </a>

                </div>

            </div>

            <!-- RIGHT STATS -->
            <div class="grid grid-cols-1 gap-4 w-full lg:w-[320px]">

                <!-- CARD 1 -->
                <div class="bg-[#fff6f8] rounded-3xl p-5 border border-pink-100 flex items-center gap-4 card-hover">

                    <div class="w-14 h-14 rounded-2xl bg-pink-100 flex items-center justify-center text-2xl">
                        💰
                    </div>

                    <div>
                        <p class="text-xs font-semibold text-gray-400 mb-1">
                            Total Belanja
                        </p>

                        <h3 class="text-xl font-bold text-gray-800">
                            Rp {{ number_format($totalSpent,0,',','.') }}
                        </h3>
                    </div>

                </div>

                <!-- CARD 2 -->
                <div class="bg-[#fff6f8] rounded-3xl p-5 border border-pink-100 flex items-center gap-4 card-hover">

                    <div class="w-14 h-14 rounded-2xl bg-pink-100 flex items-center justify-center text-2xl">
                        🛍️
                    </div>

                    <div>
                        <p class="text-xs font-semibold text-gray-400 mb-1">
                            Total Pesanan
                        </p>

                        <h3 class="text-xl font-bold text-gray-800">
                            {{ number_format($totalOrders) }} Order
                        </h3>
                    </div>

                </div>

            </div>

        </div>

    </div>

    <!-- CONTENT -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

        <!-- LEFT -->
        <div class="lg:col-span-2">

            <div class="flex items-center justify-between mb-5">

                <h2 class="text-2xl font-bold text-gray-800 serif-font">
                    Pesanan Terbaru
                </h2>

                <a href="/transactions"
                   class="text-sm font-bold text-pink-500 hover:text-pink-600">
                    Lihat Semua →
                </a>

            </div>

            <div class="space-y-5">

                @forelse($recentTransactions as $trx)

                <div class="bg-white rounded-3xl border border-pink-100 p-6 shadow-sm card-hover">

                    <div class="flex flex-col md:flex-row md:items-center justify-between gap-5 border-b border-pink-50 pb-5 mb-5">

                        <div class="flex items-center gap-4">

                            <div class="w-14 h-14 rounded-2xl bg-pink-50 flex items-center justify-center text-2xl">
                                🛒
                            </div>

                            <div>

                                <p class="text-xs text-gray-400 font-semibold mb-1">
                                    {{ $trx->created_at->format('d M Y') }}
                                </p>

                                <h3 class="font-bold text-gray-800">
                                    {{ $trx->midtrans_order_id ?? 'TRX-'.$trx->id }}
                                </h3>

                            </div>

                        </div>

                        <div class="text-right">

                            <p class="text-xs text-gray-400 font-semibold mb-1">
                                Total
                            </p>

                            <h3 class="text-lg font-bold text-pink-500">
                                Rp {{ number_format($trx->total_price,0,',','.') }}
                            </h3>

                        </div>

                    </div>

                    <!-- STATUS -->
                    <div class="flex items-center justify-between flex-wrap gap-4">

                        <div>

                            @if($trx->status == 'pending')

                            <span class="px-4 py-2 rounded-xl bg-yellow-100 text-yellow-700 text-xs font-bold">
                                MENUNGGU PEMBAYARAN
                            </span>

                            @elseif($trx->status == 'paid')

                            <span class="px-4 py-2 rounded-xl bg-pink-100 text-pink-600 text-xs font-bold">
                                LUNAS (MENUNGGU KONFIRMASI)
                            </span>

                            @elseif($trx->status == 'confirmed')

                            <span class="px-4 py-2 rounded-xl bg-purple-100 text-purple-700 text-xs font-bold">
                                DITERIMA ADMIN (PROSES PACKING)
                            </span>

                            @elseif($trx->status == 'shipped')

                            <span class="px-4 py-2 rounded-xl bg-blue-100 text-blue-700 text-xs font-bold">
                                DIKIRIM
                            </span>

                            @elseif($trx->status == 'completed')

                            <span class="px-4 py-2 rounded-xl bg-green-100 text-green-700 text-xs font-bold">
                                SELESAI
                            </span>

                            @elseif($trx->status == 'returned')

                            <span class="px-4 py-2 rounded-xl bg-red-100 text-red-700 text-xs font-bold">
                                DIKEMBALIKAN
                            </span>

                            @else

                            <span class="px-4 py-2 rounded-xl bg-red-100 text-red-700 text-xs font-bold">
                                DIBATALKAN
                            </span>

                            @endif

                        </div>

                        <a href="{{ route('transaction.show', $trx->id) }}"
                           class="text-sm font-bold text-pink-500 hover:underline">
                            Detail Pesanan
                        </a>

                    </div>

                </div>

                @empty

                <div class="bg-white rounded-3xl border border-pink-100 p-12 text-center">

                    <div class="text-6xl mb-5">
                        💄
                    </div>

                    <h3 class="text-2xl font-bold text-gray-800 serif-font mb-3">
                        Belum Ada Pesanan
                    </h3>

                    <p class="text-gray-500 mb-7">
                        Yuk mulai belanja skincare dan makeup favoritmu sekarang.
                    </p>

                    <a href="/products"
                       class="inline-flex px-7 py-3 rounded-2xl btn-primary text-sm font-bold">
                        Mulai Belanja
                    </a>

                </div>

                @endforelse

            </div>

        </div>

        <!-- RIGHT -->
        <div>

            <h2 class="text-2xl font-bold text-gray-800 serif-font mb-5">
                Menu Cepat
            </h2>

            <div class="space-y-5">

                 <!-- PROFILE -->
                <a href="/profile"
                   class="block bg-white rounded-3xl border border-pink-100 p-6 shadow-sm card-hover">

                    <div class="w-14 h-14 rounded-2xl bg-pink-100 flex items-center justify-center text-2xl mb-4">
                        👤
                    </div>

                    <h3 class="text-lg font-bold text-gray-800 mb-2">
                        Profil Saya
                    </h3>

                    <p class="text-sm text-gray-500 leading-relaxed">
                        Lihat info akun, ubah nama, email, dan kata sandi kamu.
                    </p>

                </a>

                <!-- ADDRESS -->
                <a href="/addresses"
                   class="block bg-white rounded-3xl border border-pink-100 p-6 shadow-sm card-hover">

                    <div class="w-14 h-14 rounded-2xl bg-pink-100 flex items-center justify-center text-2xl mb-4">
                        📍
                    </div>

                    <h3 class="text-lg font-bold text-gray-800 mb-2">
                        Alamat Saya
                    </h3>

                    <p class="text-sm text-gray-500 leading-relaxed">
                        Kelola alamat pengiriman produk kosmetik kamu.
                    </p>

                </a>

                <!-- CART -->
                <a href="/cart"
                   class="block bg-white rounded-3xl border border-pink-100 p-6 shadow-sm card-hover">

                    <div class="w-14 h-14 rounded-2xl bg-pink-100 flex items-center justify-center text-2xl mb-4">
                        🛒
                    </div>

                    <h3 class="text-lg font-bold text-gray-800 mb-2">
                        Keranjang
                    </h3>

                    <p class="text-sm text-gray-500 leading-relaxed">
                        Lihat produk skincare & makeup yang sudah kamu pilih.
                    </p>

                </a>

            </div>

        </div>

    </div>

</main>

<script>
    const userBurger = document.getElementById('user-burger');
    const userMobileMenu = document.getElementById('user-mobile-menu');

    userBurger.addEventListener('click', () => {
        userMobileMenu.classList.toggle('open');
    });

    // Close menu when clicking a link
    userMobileMenu.querySelectorAll('a').forEach(link => {
        link.addEventListener('click', () => {
            userMobileMenu.classList.remove('open');
        });
    });
</script>

</body>
</html>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - BeautyCosmetic</title>

    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>

    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@600;700&family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <style>

        *{
            margin:0;
            padding:0;
            box-sizing:border-box;
        }

        body{
            font-family:'Poppins',sans-serif;
            background:#fffafb;
            color:#2d1b22;
            overflow:hidden;
        }

        h1,h2,h3,.serif{
            font-family:'Playfair Display',serif;
        }

        ::-webkit-scrollbar{
            width:5px;
        }

        ::-webkit-scrollbar-thumb{
            background:#ff0080;
            border-radius:999px;
        }

        .sidebar{
            width:280px;
            height:100vh;
            position:fixed;
            left:0;
            top:0;
            background:#fff;
            border-right:1px solid #f7dfe8;
            z-index:50;
        }

        .menu{
            transition:.3s ease;
        }

        .menu:hover{
            background:#fff2f7;
            color:#ff0080;
            transform:translateX(4px);
        }

        .menu.active{
            background:linear-gradient(135deg,#ff66b2,#ff0080);
            color:white;
            box-shadow:0 10px 25px rgba(255,0,128,0.20);
        }

        .main{
            margin-left:280px;
            height:100vh;
            overflow-y:auto;
        }

        .topbar{
            background:white;
            border-bottom:1px solid #f7dfe8;
            position:sticky;
            top:0;
            z-index:40;
        }

        .card{
            background:white;
            border:1px solid #fbe4ee;
            box-shadow:0 8px 30px rgba(255,0,128,0.04);
            transition:.3s ease;
            position:relative;
            overflow:hidden;
        }

        .card:hover{
            transform:translateY(-4px);
            box-shadow:0 15px 35px rgba(255,0,128,0.08);
        }

        .wave{
            position:absolute;
            bottom:-8px;
            left:0;
            width:100%;
            opacity:.10;
        }

        .pink-icon{
            background:linear-gradient(135deg,#ff66b2,#ff0080);
            box-shadow:0 10px 25px rgba(255,0,128,0.22);
        }

        .soft-icon{
            background:linear-gradient(135deg,#ffc2d1,#ff8fab);
            box-shadow:0 10px 25px rgba(255,143,171,0.20);
        }

        .dark-icon{
            background:linear-gradient(135deg,#5a3042,#2d1b22);
            box-shadow:0 10px 25px rgba(74,44,58,0.18);
        }

        .table-box{
            background:white;
            border:1px solid #fbe4ee;
            box-shadow:0 8px 30px rgba(255,0,128,0.04);
        }

        .table-row{
            transition:.3s ease;
        }

        .table-row:hover{
            background:#fff8fb;
        }

        .status-paid{
            background:#ecfdf3;
            color:#16a34a;
        }

        .status-pending{
            background:#fff7ed;
            color:#ea580c;
        }

        .status-failed{
            background:#fef2f2;
            color:#dc2626;
        }

        /* ====== CHART SECTION ====== */
        .chart-grid{
            display:grid;
            grid-template-columns:1fr 1fr;
            gap:24px;
        }

        .chart-card{
            background:white;
            border:1px solid #fbe4ee;
            border-radius:28px;
            box-shadow:0 8px 30px rgba(255,0,128,0.05);
            padding:28px;
            position:relative;
            overflow:hidden;
            transition:.3s ease;
        }

        .chart-card:hover{
            transform:translateY(-4px);
            box-shadow:0 15px 35px rgba(255,0,128,0.10);
        }

        .chart-card.full-width{
            grid-column:1/-1;
        }

        .chart-title{
            font-family:'Playfair Display',serif;
            font-size:1.25rem;
            font-weight:700;
            color:#241526;
            margin-bottom:4px;
        }

        .chart-subtitle{
            font-size:0.75rem;
            color:#9ca3af;
            letter-spacing:.05em;
            margin-bottom:24px;
        }

        .chart-badge{
            display:inline-flex;
            align-items:center;
            gap:6px;
            background:#fff0f6;
            color:#ff0080;
            font-size:11px;
            font-weight:700;
            letter-spacing:.05em;
            padding:4px 12px;
            border-radius:999px;
            margin-bottom:18px;
        }

        .chart-wrapper{
            position:relative;
            width:100%;
        }

        @media(max-width:767px){
            .chart-grid{
                grid-template-columns:1fr;
            }
            .chart-card.full-width{
                grid-column:1;
            }
        }

        @media(max-width:767px){
            .main{
                margin-left:0 !important;
            }
            .sidebar{
                transform:translateX(-100%);
                transition:transform 0.3s cubic-bezier(0.16,1,0.3,1);
            }
            .sidebar.open{
                transform:translateX(0);
            }
            .topbar h1{
                font-size:1.3rem;
            }
            .topbar{
                padding:1rem 1.2rem;
            }
            .p-8{
                padding:1rem;
            }
        }

        .sidebar-overlay{
            display:none;
            position:fixed;
            inset:0;
            background:rgba(0,0,0,0.4);
            z-index:45;
            backdrop-filter:blur(3px);
        }

        .sidebar-overlay.active{
            display:block;
        }

    </style>

</head>

<body>

<div class="sidebar-overlay" id="sidebar-overlay"></div>

<!-- SIDEBAR -->
<aside class="sidebar flex flex-col" id="admin-sidebar">

    <div class="p-7 border-b border-pink-100">

        <div class="flex items-center gap-4">

            <div class="w-12 h-12 rounded-2xl bg-gradient-to-br from-pink-400 to-rose-500 flex items-center justify-center text-white text-xl shadow-lg">
                💄
            </div>

            <h2 class="text-2xl font-bold serif text-pink-600">
                BeautyCosmetic
            </h2>

        </div>

    </div>

    <div class="flex-1 p-5 space-y-2 overflow-y-auto">

        <a href="/" class="menu flex items-center gap-3 px-4 py-3 rounded-2xl text-sm font-medium text-gray-700">
            🏠 Kembali ke Toko
        </a>

        <div class="pt-3 pb-1">

            <p class="text-[11px] uppercase tracking-[2px] font-bold text-pink-400 px-4">
                Menu Admin
            </p>

        </div>

        <a href="/admin/dashboard"
           class="menu active flex items-center gap-3 px-4 py-3 rounded-2xl text-sm font-semibold">

            📊 Dashboard

        </a>

        <a href="/products"
           class="menu flex items-center gap-3 px-4 py-3 rounded-2xl text-sm font-medium text-gray-700">

            💋 Kelola Produk

        </a>

        <a href="/categories"
           class="menu flex items-center gap-3 px-4 py-3 rounded-2xl text-sm font-medium text-gray-700">

            🧴 Kategori Produk

        </a>

        <a href="/transactions"
           class="menu flex items-center gap-3 px-4 py-3 rounded-2xl text-sm font-medium text-gray-700">

            🛒 Transaksi

        </a>

        <a href="/admin/customers"
           class="menu flex items-center gap-3 px-4 py-3 rounded-2xl text-sm font-medium text-gray-700">

            👩 Pelanggan

        </a>

        <a href="/admin/couriers"
           class="menu flex items-center gap-3 px-4 py-3 rounded-2xl text-sm font-medium text-gray-700">

            🚚 Kelola Kurir

        </a>

        <a href="/profile"
           class="menu flex items-center gap-3 px-4 py-3 rounded-2xl text-sm font-medium text-gray-700">

            👤 Profil Saya

        </a>

        <a href="/admin/settings"
           class="menu flex items-center gap-3 px-4 py-3 rounded-2xl text-sm font-medium text-gray-700">

            ⚙️ Pengaturan

        </a>

    </div>

    <div class="p-5 border-t border-pink-100">

        <a href="/logout"
           class="flex items-center justify-center py-3 rounded-2xl bg-red-50 text-red-500 hover:bg-red-500 hover:text-white transition font-semibold text-sm">

            Logout

        </a>

    </div>

</aside>



<!-- MAIN -->
<main class="main">

    <!-- TOPBAR -->
    <header class="topbar px-8 py-5 flex items-center justify-between">

        <div class="flex items-center">

            <button id="admin-burger" class="md:hidden w-10 h-10 rounded-xl bg-pink-50 flex items-center justify-center text-pink-600 mr-3">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round">
                    <line x1="3" y1="6" x2="21" y2="6"/>
                    <line x1="3" y1="12" x2="21" y2="12"/>
                    <line x1="3" y1="18" x2="21" y2="18"/>
                </svg>
            </button>

        <div>

            <h1 class="text-3xl font-bold serif text-[#241526]">
                Dashboard Cosmetic Store
            </h1>

            <p class="text-gray-400 mt-1 text-sm">
                Pantau penjualan produk kecantikan Anda hari ini
            </p>

        </div>

        </div>

        <div class="flex items-center gap-4">

            <div class="text-right">

                <p class="font-semibold text-sm text-[#241526]">
                    {{ auth()->user()->name }}
                </p>

                <p class="text-pink-500 font-bold text-[11px] uppercase tracking-[2px] mt-1">
                    ADMIN
                </p>

            </div>

            <div class="w-12 h-12 rounded-full bg-pink-50 border border-pink-100 flex items-center justify-center text-pink-600 text-lg font-bold">
                {{ substr(auth()->user()->name,0,1) }}
            </div>

        </div>

    </header>



    <!-- CONTENT -->
    <div class="p-8 space-y-7">

        <!-- CARDS -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

            <!-- CARD -->
            <div class="card rounded-[28px] p-6">

                <div class="w-14 h-14 rounded-[20px] pink-icon flex items-center justify-center text-white text-xl mb-6">
                    💰
                </div>

                <p class="text-gray-500 uppercase tracking-[2px] text-xs font-semibold">
                    TOTAL PENDAPATAN
                </p>

                <h2 class="text-3xl serif font-bold text-pink-600 mt-2">
                    Rp {{ number_format($totalSales,0,',','.') }}
                </h2>

                <svg class="wave" viewBox="0 0 500 150" preserveAspectRatio="none">
                    <path d="M0.00,49.98 C150.00,150.00 349.20,-49.98 500.00,49.98 L500.00,150.00 L0.00,150.00 Z" fill="#ff0080"></path>
                </svg>

            </div>

            <!-- CARD -->
            <div class="card rounded-[28px] p-6">

                <div class="w-14 h-14 rounded-[20px] pink-icon flex items-center justify-center text-white text-xl mb-6">
                    👩
                </div>

                <p class="text-gray-500 uppercase tracking-[2px] text-xs font-semibold">
                    TOTAL PELANGGAN
                </p>

                <h2 class="text-3xl serif font-bold text-pink-600 mt-2">
                    {{ number_format($totalUsers) }}
                </h2>

                <svg class="wave" viewBox="0 0 500 150" preserveAspectRatio="none">
                    <path d="M0.00,49.98 C150.00,150.00 349.20,-49.98 500.00,49.98 L500.00,150.00 L0.00,150.00 Z" fill="#ff0080"></path>
                </svg>

            </div>

            <!-- CARD -->
            <div class="card rounded-[28px] p-6">

                <div class="w-14 h-14 rounded-[20px] pink-icon flex items-center justify-center text-white text-xl mb-6">
                    💄
                </div>

                <p class="text-gray-500 uppercase tracking-[2px] text-xs font-semibold">
                    TOTAL PRODUK
                </p>

                <h2 class="text-3xl serif font-bold text-pink-600 mt-2">
                    {{ number_format($totalProducts) }}
                </h2>

                <svg class="wave" viewBox="0 0 500 150" preserveAspectRatio="none">
                    <path d="M0.00,49.98 C150.00,150.00 349.20,-49.98 500.00,49.98 L500.00,150.00 L0.00,150.00 Z" fill="#ff0080"></path>
                </svg>

            </div>

        </div>



        <!-- ===== CHARTS ===== -->
        <div class="chart-grid">

            <!-- Grafik 1: Pendapatan Bulanan -->
            <div class="chart-card full-width">
                <span class="chart-badge">📈 TREN PENJUALAN</span>
                <div class="chart-title">Pendapatan 6 Bulan Terakhir</div>
                <div class="chart-subtitle">TOTAL PENDAPATAN BERDASARKAN BULAN (STATUS LUNAS)</div>
                <div class="chart-wrapper" style="height:280px">
                    <canvas id="chartRevenue"></canvas>
                </div>
            </div>

            <!-- Grafik 2: Status Transaksi -->
            <div class="chart-card">
                <span class="chart-badge">🥧 DISTRIBUSI STATUS</span>
                <div class="chart-title">Status Transaksi</div>
                <div class="chart-subtitle">PROPORSI SETIAP STATUS PESANAN</div>
                <div class="chart-wrapper" style="height:260px;display:flex;align-items:center;justify-content:center;">
                    <canvas id="chartStatus"></canvas>
                </div>
            </div>

            <!-- Grafik 3: Produk Terlaris -->
            <div class="chart-card">
                <span class="chart-badge">🏆 TOP PRODUK</span>
                <div class="chart-title">Produk Terlaris</div>
                <div class="chart-subtitle">BERDASARKAN JUMLAH UNIT TERJUAL</div>
                <div class="chart-wrapper" style="height:260px">
                    <canvas id="chartTopProducts"></canvas>
                </div>
            </div>

        </div>

        <!-- TABLE -->
        <div class="table-box rounded-[28px] overflow-hidden">

            <div class="px-7 py-5 border-b border-pink-100 flex items-center justify-between">

                <h2 class="text-2xl font-bold serif text-[#241526]">
                    Transaksi Terbaru
                </h2>

                <a href="/transactions"
                   class="text-pink-500 hover:text-pink-600 transition font-semibold text-sm">

                    Lihat Semua →

                </a>

            </div>

            <div class="overflow-x-auto">

                <table class="w-full">

                    <thead class="bg-[#fff7fb]">

                    <tr class="text-left text-xs uppercase tracking-[2px] text-gray-500">

                        <th class="px-7 py-5">ID</th>
                        <th class="px-7 py-5">Pelanggan</th>
                        <th class="px-7 py-5">Total</th>
                        <th class="px-7 py-5">Status</th>
                        <th class="px-7 py-5">Tanggal</th>
                        <th class="px-7 py-5 text-right">Aksi</th>

                    </tr>

                    </thead>

                    <tbody>

                    @forelse($recentTransactions as $trx)

                        <tr class="table-row border-b border-pink-50">

                            <td class="px-7 py-5 font-bold text-base text-pink-600 hover:text-pink-700 hover:underline">
                                <a href="{{ route('transaction.show', $trx->id) }}">
                                    {{ $trx->midtrans_order_id ?? 'TRX-'.$trx->id }}
                                </a>
                            </td>

                            <td class="px-7 py-5">

                                <div class="font-semibold text-base text-[#241526]">
                                    {{ $trx->user->name ?? 'Guest' }}
                                </div>

                                <div class="text-gray-400 text-xs mt-1">
                                    {{ $trx->user->email ?? '-' }}
                                </div>

                            </td>

                            <td class="px-7 py-5 font-bold text-pink-600 text-lg">
                                Rp {{ number_format($trx->total_price,0,',','.') }}
                            </td>

                            <td class="px-7 py-5">

                                @if($trx->status == 'pending')
                                    <span class="status-pending px-3 py-2 rounded-xl text-xs font-bold">
                                        PENDING
                                    </span>
                                @elseif($trx->status == 'paid')
                                    <span class="status-paid px-3 py-2 rounded-xl text-xs font-bold">
                                        LUNAS (BARU)
                                    </span>
                                @elseif($trx->status == 'confirmed')
                                    <span class="px-3 py-2 rounded-xl text-xs font-bold bg-purple-50 text-purple-600">
                                        DITERIMA (PACKING)
                                    </span>
                                @elseif($trx->status == 'shipped')
                                    <span class="px-3 py-2 rounded-xl text-xs font-bold bg-blue-50 text-blue-600">
                                        DIKIRIM
                                    </span>
                                @elseif($trx->status == 'completed')
                                    <span class="status-paid px-3 py-2 rounded-xl text-xs font-bold bg-green-50 text-green-600">
                                        SELESAI
                                    </span>
                                @elseif($trx->status == 'returned')
                                    <span class="status-failed px-3 py-2 rounded-xl text-xs font-bold bg-red-50 text-red-600">
                                        DIKEMBALIKAN
                                    </span>
                                @else
                                    <span class="status-failed px-3 py-2 rounded-xl text-xs font-bold">
                                        GAGAL
                                    </span>
                                @endif

                            </td>

                            <td class="px-7 py-5 text-gray-400 text-sm font-medium">
                                {{ $trx->created_at->format('d M Y') }}
                            </td>

                            <td class="px-7 py-5 text-right font-medium">
                                @if($trx->status == 'paid')
                                    <form action="{{ route('admin.accept', $trx->id) }}" method="POST" class="inline">
                                        @csrf
                                        <button type="submit" class="bg-pink-600 hover:bg-pink-700 text-white font-bold px-4 py-2 rounded-xl text-xs uppercase tracking-wider transition duration-200">
                                            Terima
                                        </button>
                                    </form>
                                @else
                                    <span class="text-gray-400 text-xs">-</span>
                                @endif
                            </td>

                        </tr>

                    @empty

                        <tr>

                            <td colspan="6" class="text-center py-20">

                                <div class="text-6xl mb-4">
                                    🛍️
                                </div>

                                <p class="text-gray-400 text-base">
                                    Belum ada transaksi
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

<script>
    // ===== SIDEBAR TOGGLE =====
    const burger = document.getElementById('admin-burger');
    const sidebar = document.getElementById('admin-sidebar');
    const overlay = document.getElementById('sidebar-overlay');

    function toggleSidebar() {
        sidebar.classList.toggle('open');
        overlay.classList.toggle('active');
        document.body.style.overflow = sidebar.classList.contains('open') ? 'hidden' : '';
    }

    burger.addEventListener('click', toggleSidebar);
    overlay.addEventListener('click', toggleSidebar);

    // ===== CHART.JS DEFAULTS =====
    Chart.defaults.font.family = "'Poppins', sans-serif";
    Chart.defaults.color = '#9ca3af';

    // ===== GRAFIK 1: PENDAPATAN BULANAN =====
    const revenueLabels = @json($monthlySales->pluck('label'));
    const revenueData   = @json($monthlySales->pluck('total'));

    new Chart(document.getElementById('chartRevenue'), {
        type: 'line',
        data: {
            labels: revenueLabels,
            datasets: [{
                label: 'Pendapatan (Rp)',
                data: revenueData,
                fill: true,
                backgroundColor: (ctx) => {
                    const gradient = ctx.chart.ctx.createLinearGradient(0, 0, 0, 280);
                    gradient.addColorStop(0, 'rgba(255,0,128,0.25)');
                    gradient.addColorStop(1, 'rgba(255,0,128,0)');
                    return gradient;
                },
                borderColor: '#ff0080',
                borderWidth: 3,
                pointBackgroundColor: '#ff0080',
                pointBorderColor: '#fff',
                pointBorderWidth: 2,
                pointRadius: 6,
                pointHoverRadius: 9,
                tension: 0.45,
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { display: false },
                tooltip: {
                    backgroundColor: '#2d1b22',
                    titleColor: '#ff66b2',
                    bodyColor: '#fff',
                    padding: 14,
                    cornerRadius: 14,
                    callbacks: {
                        label: (ctx) => ' Rp ' + ctx.parsed.y.toLocaleString('id-ID')
                    }
                }
            },
            scales: {
                x: {
                    grid: { display: false },
                    ticks: { font: { size: 12 } }
                },
                y: {
                    beginAtZero: true,
                    grid: { color: 'rgba(255,0,128,0.07)', drawBorder: false },
                    ticks: {
                        font: { size: 11 },
                        callback: (v) => 'Rp ' + v.toLocaleString('id-ID')
                    }
                }
            }
        }
    });

    // ===== GRAFIK 2: STATUS TRANSAKSI =====
    const statusLabels = @json($statusDisplay);
    const statusData   = @json($statusData->values());

    new Chart(document.getElementById('chartStatus'), {
        type: 'doughnut',
        data: {
            labels: statusLabels,
            datasets: [{
                data: statusData,
                backgroundColor: ['#ff0080','#ffb3d0','#ff66b2','#5a3042','#ffc2d1','#ef4444'],
                borderColor: '#fff',
                borderWidth: 3,
                hoverOffset: 10,
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            cutout: '68%',
            plugins: {
                legend: {
                    position: 'bottom',
                    labels: {
                        padding: 18,
                        usePointStyle: true,
                        pointStyleWidth: 10,
                        font: { size: 12 },
                    }
                },
                tooltip: {
                    backgroundColor: '#2d1b22',
                    titleColor: '#ff66b2',
                    bodyColor: '#fff',
                    padding: 12,
                    cornerRadius: 12,
                }
            }
        }
    });

    // ===== GRAFIK 3: PRODUK TERLARIS =====
    const productLabels = @json($topProducts->pluck('name'));
    const productData   = @json($topProducts->pluck('total_sold'));

    new Chart(document.getElementById('chartTopProducts'), {
        type: 'bar',
        data: {
            labels: productLabels,
            datasets: [{
                label: 'Unit Terjual',
                data: productData,
                backgroundColor: [
                    'rgba(255,0,128,0.85)',
                    'rgba(255,111,169,0.80)',
                    'rgba(255,143,171,0.75)',
                    'rgba(90,48,66,0.70)',
                    'rgba(255,194,209,0.80)',
                ],
                borderRadius: 12,
                borderSkipped: false,
                hoverBackgroundColor: '#ff0080',
            }]
        },
        options: {
            indexAxis: 'y',
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { display: false },
                tooltip: {
                    backgroundColor: '#2d1b22',
                    titleColor: '#ff66b2',
                    bodyColor: '#fff',
                    padding: 12,
                    cornerRadius: 12,
                    callbacks: {
                        label: (ctx) => ' ' + ctx.parsed.x + ' unit terjual'
                    }
                }
            },
            scales: {
                x: {
                    beginAtZero: true,
                    grid: { color: 'rgba(255,0,128,0.07)', drawBorder: false },
                    ticks: { font: { size: 11 }, stepSize: 1 }
                },
                y: {
                    grid: { display: false },
                    ticks: {
                        font: { size: 12, weight: '600' },
                        color: '#241526',
                        callback: function(val) {
                            const lbl = this.getLabelForValue(val);
                            return lbl.length > 20 ? lbl.substring(0, 18) + '…' : lbl;
                        }
                    }
                }
            }
        }
    });
</script>

</body>
</html>

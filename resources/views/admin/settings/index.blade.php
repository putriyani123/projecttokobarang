<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pengaturan Promo - Cosmetic-store</title>

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
        
        /* Toggle Switch Custom */
        .toggle-checkbox:checked {
            right: 0;
            border-color: #ff2e7e;
        }
        .toggle-checkbox:checked + .toggle-label {
            background-color: #ff2e7e;
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

                BeautyCosmetic

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
               class="flex items-center gap-3 px-4 py-3.5 rounded-xl text-sm font-semibold transition-all text-gray-500 hover:text-pink-600 hover:bg-pink-50">
                Data Pelanggan
            </a>
            
            <a href="/admin/couriers"
               class="flex items-center gap-3 px-4 py-3.5 rounded-xl text-sm font-semibold transition-all text-gray-500 hover:text-pink-600 hover:bg-pink-50">
                Kelola Kurir
            </a>
            
            <a href="/admin/settings"
               class="flex items-center gap-3 px-4 py-3.5 btn-primary rounded-xl text-sm font-bold transition-all shadow-md">
                Pengaturan
            </a>

        </nav>

    </aside>

    <!-- Main -->
    <main class="flex-1 md:ml-64 relative z-10 flex flex-col h-screen overflow-y-auto">

        <!-- Header -->
        <header class="bg-white/80 backdrop-blur-md sticky top-0 z-30 px-8 py-5 flex items-center justify-between border-b border-pink-100">

            <div>

                <h1 class="text-2xl font-bold text-gray-800 serif-font">
                    Pengaturan Toko
                </h1>

                <p class="text-sm text-gray-500 mt-0.5">
                    Kelola konfigurasi global seperti banner promosi
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
        <div class="px-6 py-8 w-full max-w-4xl space-y-8 flex-1">

            <div class="bg-white rounded-2xl border border-pink-100 shadow-sm overflow-hidden p-8">
                
                @if(session('success'))
                    <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-xl mb-6 font-medium text-sm">
                        {{ session('success') }}
                    </div>
                @endif
                
                <h3 class="text-xl font-bold text-gray-800 serif-font mb-2">Banner Promo User Dashboard</h3>
                <p class="text-sm text-gray-500 mb-6">Atur apakah Anda ingin menampilkan banner khusus di dashboard pelanggan dan atur pesannya di sini.</p>
                
                <form action="{{ route('admin.settings.update') }}" method="POST">
                    @csrf
                    
                    <div class="mb-8 p-5 bg-pink-50/50 rounded-xl border border-pink-100">
                        <div class="flex items-center">
                            <div class="relative inline-block w-12 mr-4 align-middle select-none transition duration-200 ease-in">
                                <input type="checkbox" name="promo_banner_active" id="promo_banner_active" value="1" {{ (isset($settings['promo_banner_active']) && $settings['promo_banner_active'] == '1') ? 'checked' : '' }} class="toggle-checkbox absolute block w-6 h-6 rounded-full bg-white border-4 border-gray-300 appearance-none cursor-pointer z-10 transition-all duration-300" style="top: 2px; right: {{ (isset($settings['promo_banner_active']) && $settings['promo_banner_active'] == '1') ? '0' : '24px' }};"/>
                                <label for="promo_banner_active" class="toggle-label block overflow-hidden h-7 rounded-full bg-gray-300 cursor-pointer transition-colors duration-300"></label>
                            </div>
                            <label for="promo_banner_active" class="text-base font-bold text-gray-800">Tampilkan Banner Diskon</label>
                        </div>
                        <p class="text-xs text-gray-500 mt-2 ml-16 mb-6">Jika diaktifkan, pelanggan akan melihat notifikasi promo saat membuka dashboard mereka.</p>

                        <div class="ml-16">
                            <label class="block text-sm font-bold text-gray-700 mb-2">Persentase Diskon Global (%)</label>
                            <input type="number" name="global_discount_percentage" class="w-full sm:w-1/3 px-4 py-3 rounded-xl border border-pink-100 focus:outline-none focus:ring-2 focus:ring-pink-400 text-sm font-medium text-gray-800" value="{{ $settings['global_discount_percentage'] ?? '0' }}" min="0" max="100" step="0.01" placeholder="Misal: 10">
                            <p class="text-xs text-gray-500 mt-2">Diskon ini akan dipotong otomatis dari total pembelanjaan pelanggan saat checkout jika banner sedang aktif.</p>
                        </div>
                    </div>

                    <div class="space-y-6">
                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-2">Judul Promo</label>
                            <input type="text" name="promo_title" class="w-full px-4 py-3 rounded-xl border border-pink-100 focus:outline-none focus:ring-2 focus:ring-pink-400 text-sm font-medium text-gray-800" value="{{ $settings['promo_title'] ?? 'Promo Spesial Menantimu!' }}" placeholder="Misal: Promo Spesial Akhir Bulan!">
                        </div>
                        
                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-2">Pesan Promo</label>
                            <textarea name="promo_description" rows="3" class="w-full px-4 py-3 rounded-xl border border-pink-100 focus:outline-none focus:ring-2 focus:ring-pink-400 text-sm font-medium text-gray-800" placeholder="Jelaskan detail promosi... ">{{ $settings['promo_description'] ?? 'Sedang ada diskon potongan harga untuk produk kosmetik pilihan. Yuk klaim sekarang sebelum kehabisan!' }}</textarea>
                        </div>
                    </div>
                    
                    <div class="mt-8 pt-6 border-t border-gray-100 flex justify-end">
                        <button type="submit" class="btn-primary px-8 py-3 rounded-xl font-bold shadow-lg">Simpan Pengaturan</button>
                    </div>
                </form>

            </div>

        </div>

    </main>
    
    <script>
        // Custom toggle behavior fix
        document.getElementById('promo_banner_active').addEventListener('change', function() {
            if(this.checked) {
                this.style.right = '0';
                this.style.borderColor = '#ff2e7e';
                this.nextElementSibling.style.backgroundColor = '#ff2e7e';
            } else {
                this.style.right = '24px';
                this.style.borderColor = '#d1d5db';
                this.nextElementSibling.style.backgroundColor = '#d1d5db';
            }
        });
        
        // Initial state
        window.addEventListener('DOMContentLoaded', () => {
            const toggle = document.getElementById('promo_banner_active');
            if(toggle.checked) {
                toggle.style.right = '0';
                toggle.style.borderColor = '#ff2e7e';
                toggle.nextElementSibling.style.backgroundColor = '#ff2e7e';
            }
        });
    </script>
</body>
</html>

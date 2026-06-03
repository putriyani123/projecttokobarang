<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil Saya - BeautyCosmetic</title>

    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;600;700&family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <style>
        *{ margin:0; padding:0; box-sizing:border-box; }

        body{
            font-family:'Poppins',sans-serif;
            background:#fff8f8;
            color:#3f312b;
            min-height:100vh;
        }

        h1,h2,h3,h4,.serif{
            font-family:'Playfair Display',serif;
        }

        /* NAVBAR */
        .glass-panel{
            background:rgba(255,255,255,0.95);
            backdrop-filter:blur(18px);
            border-bottom:1px solid #fde7ee;
            box-shadow:0 2px 20px rgba(255,46,126,0.05);
        }

        .burger-line{
            display:block;
            width:20px;
            height:2.5px;
            background:linear-gradient(135deg,#ff8fab,#ff5d8f);
            border-radius:999px;
            transition:0.3s ease;
        }

        .mobile-menu{
            max-height:0;
            overflow:hidden;
            transition:max-height 0.4s cubic-bezier(0.16,1,0.3,1);
        }
        .mobile-menu.open{ max-height:400px; }

        /* PROFILE HERO */
        .profile-hero{
            background:linear-gradient(135deg,#fff0f6 0%,#ffe4ef 50%,#ffd6e7 100%);
            border-radius:32px;
            border:1px solid #fbc8da;
            position:relative;
            overflow:hidden;
        }

        .profile-hero::before{
            content:'';
            position:absolute;
            top:-60px;
            right:-60px;
            width:250px;
            height:250px;
            background:radial-gradient(circle,rgba(255,46,126,0.12) 0%,transparent 70%);
            border-radius:50%;
        }

        .profile-hero::after{
            content:'';
            position:absolute;
            bottom:-40px;
            left:-40px;
            width:180px;
            height:180px;
            background:radial-gradient(circle,rgba(255,111,169,0.10) 0%,transparent 70%);
            border-radius:50%;
        }

        .avatar-ring{
            background:linear-gradient(135deg,#ff6fa9,#ff2e7e);
            padding:4px;
            border-radius:50%;
            box-shadow:0 12px 35px rgba(255,46,126,0.35);
        }

        .avatar-inner{
            background:white;
            border-radius:50%;
            width:100%;
            height:100%;
            display:flex;
            align-items:center;
            justify-content:center;
        }

        /* CARD */
        .section-card{
            background:white;
            border:1px solid #fbe4ee;
            border-radius:28px;
            box-shadow:0 8px 30px rgba(255,46,126,0.04);
            transition:0.3s ease;
        }

        .section-card:hover{
            box-shadow:0 15px 40px rgba(255,46,126,0.08);
        }

        /* TABS */
        .tab-btn{
            padding:10px 22px;
            border-radius:14px;
            font-size:0.85rem;
            font-weight:600;
            color:#9ca3af;
            transition:0.25s ease;
            cursor:pointer;
            border:none;
            background:transparent;
        }

        .tab-btn.active{
            background:linear-gradient(135deg,#ff6fa9,#ff2e7e);
            color:white;
            box-shadow:0 8px 20px rgba(255,46,126,0.28);
        }

        .tab-btn:not(.active):hover{
            background:#fff0f6;
            color:#ff2e7e;
        }

        .tab-panel{ display:none; }
        .tab-panel.active{ display:block; }

        /* FORM */
        .form-label{
            display:block;
            font-size:0.75rem;
            font-weight:700;
            color:#9ca3af;
            letter-spacing:.08em;
            text-transform:uppercase;
            margin-bottom:8px;
        }

        .form-input{
            width:100%;
            padding:14px 18px;
            border:1.5px solid #fbe4ee;
            border-radius:16px;
            font-size:0.92rem;
            font-family:'Poppins',sans-serif;
            color:#2d1b22;
            background:#fdfcfd;
            transition:0.25s ease;
            outline:none;
        }

        .form-input:focus{
            border-color:#ff6fa9;
            background:white;
            box-shadow:0 0 0 4px rgba(255,46,126,0.08);
        }

        .form-input:disabled{
            background:#f9f0f4;
            color:#9ca3af;
            cursor:not-allowed;
        }

        /* BUTTONS */
        .btn-primary{
            background:linear-gradient(135deg,#ff6fa9,#ff2e7e);
            color:white;
            font-weight:700;
            font-size:0.88rem;
            padding:14px 32px;
            border-radius:16px;
            border:none;
            cursor:pointer;
            transition:0.3s ease;
            box-shadow:0 8px 22px rgba(255,46,126,0.28);
            font-family:'Poppins',sans-serif;
        }

        .btn-primary:hover{
            transform:translateY(-2px);
            box-shadow:0 14px 30px rgba(255,46,126,0.38);
        }

        .btn-secondary{
            background:#fff0f6;
            color:#ff2e7e;
            font-weight:700;
            font-size:0.88rem;
            padding:14px 32px;
            border-radius:16px;
            border:1.5px solid #fbc8da;
            cursor:pointer;
            transition:0.3s ease;
            font-family:'Poppins',sans-serif;
        }

        .btn-secondary:hover{
            background:#ffd6e7;
            border-color:#ff6fa9;
        }

        /* STAT BADGE */
        .stat-badge{
            background:linear-gradient(135deg,#fff0f6,#ffd6e7);
            border:1px solid #fbc8da;
            border-radius:20px;
            padding:16px 20px;
            text-align:center;
        }

        /* ALERT */
        .alert-success{
            background:#ecfdf3;
            border:1px solid #bbf7d0;
            color:#16a34a;
            border-radius:16px;
            padding:14px 18px;
            font-size:0.88rem;
            font-weight:600;
            display:flex;
            align-items:center;
            gap:10px;
        }

        .alert-error{
            background:#fef2f2;
            border:1px solid #fecaca;
            color:#dc2626;
            border-radius:16px;
            padding:14px 18px;
            font-size:0.88rem;
            font-weight:600;
            display:flex;
            align-items:center;
            gap:10px;
        }

        /* ROLE BADGE */
        .role-badge{
            display:inline-flex;
            align-items:center;
            gap:6px;
            padding:5px 14px;
            border-radius:999px;
            font-size:0.7rem;
            font-weight:800;
            letter-spacing:.1em;
            text-transform:uppercase;
        }

        .role-user{ background:#fff0f6; color:#ff2e7e; border:1px solid #fbc8da; }
        .role-admin{ background:#f3e8ff; color:#7c3aed; border:1px solid #d8b4fe; }
        .role-kurir{ background:#ecfdf3; color:#16a34a; border:1px solid #bbf7d0; }

        /* MEMBER CARD */
        .member-card{
            background:linear-gradient(135deg,#ff6fa9 0%,#ff2e7e 60%,#c2185b 100%);
            border-radius:24px;
            padding:28px;
            color:white;
            position:relative;
            overflow:hidden;
        }

        .member-card::before{
            content:'';
            position:absolute;
            top:-30px;
            right:-30px;
            width:160px;
            height:160px;
            background:rgba(255,255,255,0.12);
            border-radius:50%;
        }

        .member-card::after{
            content:'';
            position:absolute;
            bottom:-20px;
            left:-20px;
            width:100px;
            height:100px;
            background:rgba(255,255,255,0.08);
            border-radius:50%;
        }

        /* INFO ROW */
        .info-row{
            display:flex;
            align-items:center;
            padding:16px 0;
            border-bottom:1px solid #fbe4ee;
            gap:16px;
        }

        .info-row:last-child{ border-bottom:none; }

        .info-icon{
            width:42px;
            height:42px;
            border-radius:14px;
            background:#fff0f6;
            display:flex;
            align-items:center;
            justify-content:center;
            flex-shrink:0;
            font-size:1.1rem;
        }

        @media(max-width:767px){
            .profile-hero{ border-radius:20px; }
        }
    </style>
</head>
<body>

<!-- NAVBAR -->
<nav class="glass-panel sticky top-0 z-50">
    <div class="max-w-6xl mx-auto px-5">
        <div class="flex justify-between h-20 items-center">

            <!-- LOGO -->
            <a href="/" class="flex items-center gap-3">
                <div class="w-11 h-11 rounded-2xl bg-pink-100 flex items-center justify-center text-pink-500 shadow-sm">
                    💄
                </div>
                <div>
                    <p class="text-lg font-bold text-pink-600 serif">BeautyCosmetic</p>
                    <p class="text-[11px] text-gray-400 font-medium">Beauty & Skincare</p>
                </div>
            </a>

            <!-- DESKTOP NAV -->
            <div class="hidden md:flex items-center gap-2 bg-white p-1 rounded-2xl border border-pink-100">
                <a href="/user/dashboard" class="px-5 py-2 rounded-xl text-sm font-semibold text-gray-500 hover:bg-pink-50 hover:text-pink-600 transition">Beranda</a>
                <a href="/products"       class="px-5 py-2 rounded-xl text-sm font-semibold text-gray-500 hover:bg-pink-50 hover:text-pink-600 transition">Produk</a>
                <a href="/transactions"   class="px-5 py-2 rounded-xl text-sm font-semibold text-gray-500 hover:bg-pink-50 hover:text-pink-600 transition">Pesanan</a>
                <a href="/profile"        class="px-5 py-2 rounded-xl bg-pink-50 text-pink-600 text-sm font-bold">Profil</a>
            </div>

            <!-- HAMBURGER MOBILE -->
            <button id="burger-btn" class="md:hidden flex flex-col gap-[5px] p-2 rounded-xl hover:bg-pink-50 transition">
                <span class="burger-line"></span>
                <span class="burger-line"></span>
                <span class="burger-line"></span>
            </button>

            <!-- USER -->
            <div class="hidden md:flex items-center gap-3">
                <div class="text-right">
                    <p class="text-sm font-bold text-gray-800">{{ auth()->user()->name }}</p>
                    <p class="text-[11px] text-pink-500 font-semibold">Beauty Member</p>
                </div>
                <div class="w-10 h-10 rounded-full bg-gradient-to-br from-pink-400 to-rose-500 text-white flex items-center justify-center font-bold text-sm shadow-lg">
                    {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                </div>
            </div>

        </div>
    </div>
</nav>

<!-- MOBILE MENU -->
<div class="mobile-menu md:hidden bg-white border-b border-pink-100" id="mobile-menu">
    <div class="px-5 pb-4 space-y-1">
        <a href="/user/dashboard" class="block px-4 py-3 rounded-xl text-sm font-semibold text-gray-600 hover:bg-pink-50 hover:text-pink-600 transition">🏠 Beranda</a>
        <a href="/products"       class="block px-4 py-3 rounded-xl text-sm font-semibold text-gray-600 hover:bg-pink-50 hover:text-pink-600 transition">💄 Produk</a>
        <a href="/transactions"   class="block px-4 py-3 rounded-xl text-sm font-semibold text-gray-600 hover:bg-pink-50 hover:text-pink-600 transition">🛍️ Pesanan</a>
        <a href="/profile"        class="block px-4 py-3 rounded-xl bg-pink-50 text-pink-600 text-sm font-bold">👤 Profil</a>
        <div class="border-t border-pink-100 my-1"></div>
        <a href="/logout" class="block px-4 py-3 rounded-xl text-sm font-bold text-red-500 hover:bg-red-50 transition">🚪 Logout</a>
    </div>
</div>


<!-- MAIN -->
<main class="max-w-6xl mx-auto px-5 py-10 space-y-8">

    <!-- FLASH MESSAGES -->
    @if(session('success'))
    <div class="alert-success">
        <span class="text-lg">✅</span>
        {{ session('success') }}
    </div>
    @endif

    @if(session('error'))
    <div class="alert-error">
        <span class="text-lg">❌</span>
        {{ session('error') }}
    </div>
    @endif

    @if($errors->any())
    <div class="alert-error flex-col items-start gap-1">
        <div class="flex items-center gap-2"><span class="text-lg">❌</span><strong>Terdapat kesalahan:</strong></div>
        <ul class="list-disc list-inside ml-7 mt-1 space-y-1">
            @foreach($errors->all() as $e)
            <li class="text-sm">{{ $e }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <!-- PROFILE HERO -->
    <div class="profile-hero p-8 md:p-10">
        <div class="relative z-10 flex flex-col md:flex-row items-center md:items-start gap-8">

            <!-- AVATAR -->
            <div class="flex-shrink-0">
                <div class="avatar-ring w-28 h-28 md:w-32 md:h-32">
                    <div class="avatar-inner">
                        <span class="text-4xl md:text-5xl font-bold text-pink-500 serif">
                            {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                        </span>
                    </div>
                </div>
            </div>

            <!-- INFO -->
            <div class="flex-1 text-center md:text-left">

                <div class="flex flex-col md:flex-row md:items-center gap-3 mb-2">
                    <h1 class="text-3xl md:text-4xl font-bold text-gray-800 serif">
                        {{ auth()->user()->name }}
                    </h1>
                    <span class="role-badge role-{{ auth()->user()->role }} self-center md:self-auto">
                        @if(auth()->user()->role == 'admin') 👑 Admin
                        @elseif(auth()->user()->role == 'kurir') 🚚 Kurir
                        @else ✨ Member
                        @endif
                    </span>
                </div>

                <p class="text-gray-500 text-sm mb-1">
                    <span class="mr-2">📧</span>{{ auth()->user()->email }}
                </p>

                <p class="text-gray-400 text-xs mb-6">
                    Bergabung sejak {{ auth()->user()->created_at->translatedFormat('d F Y') }}
                </p>

                <!-- STATS -->
                <div class="flex flex-wrap justify-center md:justify-start gap-4">
                    <div class="stat-badge">
                        <p class="text-2xl font-bold text-pink-600 serif">{{ $totalOrders }}</p>
                        <p class="text-xs text-gray-500 font-semibold mt-1">Total Pesanan</p>
                    </div>
                    <div class="stat-badge">
                        <p class="text-2xl font-bold text-pink-600 serif">Rp {{ number_format($totalSpent,0,',','.') }}</p>
                        <p class="text-xs text-gray-500 font-semibold mt-1">Total Belanja</p>
                    </div>
                    <div class="stat-badge">
                        <p class="text-2xl font-bold text-pink-600 serif">{{ $totalAddresses }}</p>
                        <p class="text-xs text-gray-500 font-semibold mt-1">Alamat Tersimpan</p>
                    </div>
                </div>

            </div>

        </div>
    </div>

    <!-- CONTENT GRID -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

        <!-- LEFT: MEMBER CARD + QUICK LINKS -->
        <div class="space-y-6">

            <!-- MEMBER CARD -->
            <div class="member-card">
                <div class="relative z-10">
                    <p class="text-white/70 text-xs font-bold tracking-widest uppercase mb-1">Beauty Member Card</p>
                    <p class="text-2xl font-bold serif mb-5">BeautyCosmetic</p>
                    <div class="text-white/80 text-sm font-mono mb-5 tracking-widest">
                        ✦ {{ str_pad(auth()->user()->id, 8, '0', STR_PAD_LEFT) }} ✦
                    </div>
                    <div>
                        <p class="text-white/60 text-[11px] uppercase tracking-widest">Nama Pemegang</p>
                        <p class="font-bold text-lg">{{ auth()->user()->name }}</p>
                    </div>
                </div>
            </div>

            <!-- QUICK LINKS -->
            <div class="section-card p-6 space-y-2">
                <h3 class="text-base font-bold text-gray-800 serif mb-4">Menu Cepat</h3>

                <a href="/transactions" class="flex items-center gap-3 px-4 py-3 rounded-2xl hover:bg-pink-50 transition group">
                    <div class="w-10 h-10 rounded-xl bg-pink-50 flex items-center justify-center text-lg group-hover:bg-pink-100 transition">🛍️</div>
                    <div>
                        <p class="text-sm font-semibold text-gray-700">Riwayat Pesanan</p>
                        <p class="text-xs text-gray-400">Lihat semua pesanan</p>
                    </div>
                    <span class="ml-auto text-pink-400 text-sm">→</span>
                </a>

                <a href="/addresses" class="flex items-center gap-3 px-4 py-3 rounded-2xl hover:bg-pink-50 transition group">
                    <div class="w-10 h-10 rounded-xl bg-pink-50 flex items-center justify-center text-lg group-hover:bg-pink-100 transition">📍</div>
                    <div>
                        <p class="text-sm font-semibold text-gray-700">Alamat Saya</p>
                        <p class="text-xs text-gray-400">Kelola alamat pengiriman</p>
                    </div>
                    <span class="ml-auto text-pink-400 text-sm">→</span>
                </a>

                <a href="/cart" class="flex items-center gap-3 px-4 py-3 rounded-2xl hover:bg-pink-50 transition group">
                    <div class="w-10 h-10 rounded-xl bg-pink-50 flex items-center justify-center text-lg group-hover:bg-pink-100 transition">🛒</div>
                    <div>
                        <p class="text-sm font-semibold text-gray-700">Keranjang</p>
                        <p class="text-xs text-gray-400">Lihat keranjang belanja</p>
                    </div>
                    <span class="ml-auto text-pink-400 text-sm">→</span>
                </a>

                <div class="border-t border-pink-100 pt-2 mt-2">
                    <a href="/logout" class="flex items-center gap-3 px-4 py-3 rounded-2xl hover:bg-red-50 transition group">
                        <div class="w-10 h-10 rounded-xl bg-red-50 flex items-center justify-center text-lg group-hover:bg-red-100 transition">🚪</div>
                        <p class="text-sm font-bold text-red-500">Logout</p>
                    </a>
                </div>

            </div>

        </div>

        <!-- RIGHT: TABS FORM -->
        <div class="lg:col-span-2">

            <div class="section-card overflow-hidden">

                <!-- TAB HEADER -->
                <div class="px-7 pt-7 pb-0">
                    <div class="flex items-center gap-2 bg-pink-50 p-1.5 rounded-2xl border border-pink-100 w-fit mb-7">
                        <button class="tab-btn active" data-tab="info" id="tab-info">👤 Informasi</button>
                        <button class="tab-btn" data-tab="edit" id="tab-edit">✏️ Edit Profil</button>
                        <button class="tab-btn" data-tab="password" id="tab-password">🔒 Kata Sandi</button>
                    </div>
                </div>

                <!-- TAB: INFORMASI -->
                <div class="tab-panel active px-7 pb-7" id="panel-info">

                    <h2 class="text-xl font-bold text-gray-800 serif mb-6">Informasi Akun</h2>

                    <div class="info-row">
                        <div class="info-icon">👤</div>
                        <div class="flex-1">
                            <p class="text-xs text-gray-400 font-semibold uppercase tracking-widest mb-1">Nama Lengkap</p>
                            <p class="font-semibold text-gray-800">{{ auth()->user()->name }}</p>
                        </div>
                    </div>

                    <div class="info-row">
                        <div class="info-icon">📧</div>
                        <div class="flex-1">
                            <p class="text-xs text-gray-400 font-semibold uppercase tracking-widest mb-1">Email</p>
                            <p class="font-semibold text-gray-800">{{ auth()->user()->email }}</p>
                        </div>
                    </div>

                    <div class="info-row">
                        <div class="info-icon">🎭</div>
                        <div class="flex-1">
                            <p class="text-xs text-gray-400 font-semibold uppercase tracking-widest mb-1">Role</p>
                            <span class="role-badge role-{{ auth()->user()->role }}">
                                @if(auth()->user()->role == 'admin') 👑 Admin
                                @elseif(auth()->user()->role == 'kurir') 🚚 Kurir
                                @else ✨ Beauty Member
                                @endif
                            </span>
                        </div>
                    </div>

                    <div class="info-row">
                        <div class="info-icon">📅</div>
                        <div class="flex-1">
                            <p class="text-xs text-gray-400 font-semibold uppercase tracking-widest mb-1">Bergabung Sejak</p>
                            <p class="font-semibold text-gray-800">{{ auth()->user()->created_at->translatedFormat('d F Y, H:i') }}</p>
                        </div>
                    </div>

                    <div class="info-row">
                        <div class="info-icon">🛍️</div>
                        <div class="flex-1">
                            <p class="text-xs text-gray-400 font-semibold uppercase tracking-widest mb-1">Total Pesanan</p>
                            <p class="font-semibold text-gray-800">{{ $totalOrders }} pesanan</p>
                        </div>
                    </div>

                    <div class="info-row">
                        <div class="info-icon">💰</div>
                        <div class="flex-1">
                            <p class="text-xs text-gray-400 font-semibold uppercase tracking-widest mb-1">Total Belanja</p>
                            <p class="font-bold text-pink-600 text-lg">Rp {{ number_format($totalSpent,0,',','.') }}</p>
                        </div>
                    </div>

                    <div class="mt-6">
                        <button onclick="switchTab('edit')" class="btn-primary">
                            ✏️ Edit Profil Saya
                        </button>
                    </div>

                </div>

                <!-- TAB: EDIT PROFIL -->
                <div class="tab-panel px-7 pb-7" id="panel-edit">

                    <h2 class="text-xl font-bold text-gray-800 serif mb-2">Edit Profil</h2>
                    <p class="text-sm text-gray-400 mb-7">Perbarui informasi nama dan email akun Anda.</p>

                    <form action="/profile/update" method="POST" id="form-edit">
                        @csrf
                        @method('PUT')

                        <div class="space-y-5">

                            <div>
                                <label class="form-label">Nama Lengkap</label>
                                <input type="text"
                                       name="name"
                                       id="input-name"
                                       class="form-input"
                                       value="{{ old('name', auth()->user()->name) }}"
                                       placeholder="Masukkan nama lengkap"
                                       required>
                            </div>

                            <div>
                                <label class="form-label">Alamat Email</label>
                                <input type="email"
                                       name="email"
                                       id="input-email"
                                       class="form-input"
                                       value="{{ old('email', auth()->user()->email) }}"
                                       placeholder="Masukkan email"
                                       required>
                            </div>

                        </div>

                        <div class="flex flex-wrap gap-3 mt-8">
                            <button type="submit" class="btn-primary">
                                💾 Simpan Perubahan
                            </button>
                            <button type="button" onclick="switchTab('info')" class="btn-secondary">
                                Batal
                            </button>
                        </div>

                    </form>

                </div>

                <!-- TAB: KATA SANDI -->
                <div class="tab-panel px-7 pb-7" id="panel-password">

                    <h2 class="text-xl font-bold text-gray-800 serif mb-2">Ganti Kata Sandi</h2>
                    <p class="text-sm text-gray-400 mb-7">Pastikan kata sandi baru minimal 8 karakter.</p>

                    <form action="/profile/password" method="POST" id="form-password">
                        @csrf
                        @method('PUT')

                        <div class="space-y-5">

                            <div>
                                <label class="form-label">Kata Sandi Saat Ini</label>
                                <div class="relative">
                                    <input type="password"
                                           name="current_password"
                                           id="pwd-current"
                                           class="form-input pr-12"
                                           placeholder="••••••••"
                                           required>
                                    <button type="button" onclick="togglePwd('pwd-current', this)"
                                            class="absolute right-4 top-1/2 -translate-y-1/2 text-gray-400 hover:text-pink-500 transition text-lg">
                                        👁
                                    </button>
                                </div>
                            </div>

                            <div>
                                <label class="form-label">Kata Sandi Baru</label>
                                <div class="relative">
                                    <input type="password"
                                           name="password"
                                           id="pwd-new"
                                           class="form-input pr-12"
                                           placeholder="••••••••"
                                           required minlength="8">
                                    <button type="button" onclick="togglePwd('pwd-new', this)"
                                            class="absolute right-4 top-1/2 -translate-y-1/2 text-gray-400 hover:text-pink-500 transition text-lg">
                                        👁
                                    </button>
                                </div>
                            </div>

                            <div>
                                <label class="form-label">Konfirmasi Kata Sandi Baru</label>
                                <div class="relative">
                                    <input type="password"
                                           name="password_confirmation"
                                           id="pwd-confirm"
                                           class="form-input pr-12"
                                           placeholder="••••••••"
                                           required minlength="8">
                                    <button type="button" onclick="togglePwd('pwd-confirm', this)"
                                            class="absolute right-4 top-1/2 -translate-y-1/2 text-gray-400 hover:text-pink-500 transition text-lg">
                                        👁
                                    </button>
                                </div>
                                <!-- PASSWORD MATCH HINT -->
                                <p id="pwd-match-hint" class="text-xs mt-2 font-semibold hidden"></p>
                            </div>

                            <!-- STRENGTH BAR -->
                            <div>
                                <p class="text-xs text-gray-400 font-semibold uppercase tracking-widest mb-2">Kekuatan Kata Sandi</p>
                                <div class="flex gap-1.5">
                                    <div class="h-2 flex-1 rounded-full bg-pink-100 transition-all duration-300" id="str-1"></div>
                                    <div class="h-2 flex-1 rounded-full bg-pink-100 transition-all duration-300" id="str-2"></div>
                                    <div class="h-2 flex-1 rounded-full bg-pink-100 transition-all duration-300" id="str-3"></div>
                                    <div class="h-2 flex-1 rounded-full bg-pink-100 transition-all duration-300" id="str-4"></div>
                                </div>
                                <p id="str-label" class="text-xs mt-1.5 font-semibold text-gray-400"></p>
                            </div>

                        </div>

                        <div class="flex flex-wrap gap-3 mt-8">
                            <button type="submit" class="btn-primary">
                                🔒 Perbarui Kata Sandi
                            </button>
                            <button type="button" onclick="switchTab('info')" class="btn-secondary">
                                Batal
                            </button>
                        </div>

                    </form>

                </div>

            </div>

        </div>

    </div>

</main>

<script>
    // ======= MOBILE MENU =======
    document.getElementById('burger-btn').addEventListener('click', () => {
        document.getElementById('mobile-menu').classList.toggle('open');
    });

    // ======= TABS =======
    function switchTab(name) {
        document.querySelectorAll('.tab-btn').forEach(b => b.classList.remove('active'));
        document.querySelectorAll('.tab-panel').forEach(p => p.classList.remove('active'));
        document.getElementById('tab-' + name).classList.add('active');
        document.getElementById('panel-' + name).classList.add('active');
    }

    document.querySelectorAll('.tab-btn').forEach(btn => {
        btn.addEventListener('click', () => switchTab(btn.dataset.tab));
    });

    // Auto-open tab based on session
    @if(session('tab'))
        switchTab('{{ session("tab") }}');
    @endif

    // ======= TOGGLE PASSWORD =======
    function togglePwd(id, btn) {
        const input = document.getElementById(id);
        const isText = input.type === 'text';
        input.type = isText ? 'password' : 'text';
        btn.textContent = isText ? '👁' : '🙈';
    }

    // ======= PASSWORD STRENGTH =======
    document.getElementById('pwd-new').addEventListener('input', function () {
        const val = this.value;
        const bars = [document.getElementById('str-1'), document.getElementById('str-2'),
                      document.getElementById('str-3'), document.getElementById('str-4')];
        const label = document.getElementById('str-label');

        bars.forEach(b => b.style.background = '#fce7f3');

        let score = 0;
        if (val.length >= 8) score++;
        if (/[A-Z]/.test(val)) score++;
        if (/[0-9]/.test(val)) score++;
        if (/[^A-Za-z0-9]/.test(val)) score++;

        const colors = ['#ef4444','#f97316','#eab308','#22c55e'];
        const labels = ['Sangat Lemah','Lemah','Cukup Kuat','Sangat Kuat'];

        for (let i = 0; i < score; i++) {
            bars[i].style.background = colors[score - 1];
        }

        label.textContent = val.length ? labels[score - 1] : '';
        label.style.color = score ? colors[score - 1] : '#9ca3af';
    });

    // ======= PASSWORD MATCH =======
    function checkMatch() {
        const p1 = document.getElementById('pwd-new').value;
        const p2 = document.getElementById('pwd-confirm').value;
        const hint = document.getElementById('pwd-match-hint');
        if (!p2) { hint.classList.add('hidden'); return; }
        hint.classList.remove('hidden');
        if (p1 === p2) {
            hint.textContent = '✅ Kata sandi cocok';
            hint.style.color = '#16a34a';
        } else {
            hint.textContent = '❌ Kata sandi tidak cocok';
            hint.style.color = '#dc2626';
        }
    }

    document.getElementById('pwd-new').addEventListener('input', checkMatch);
    document.getElementById('pwd-confirm').addEventListener('input', checkMatch);
</script>

</body>
</html>

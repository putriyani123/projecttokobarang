<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Alamat - GlowBeauty</title>

    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,600;0,700;1,400&family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background: radial-gradient(circle at top, #fff1f7 0%, #ffffff 70%);
            color: #2d1b22;
        }
        h1, h2, h3, .serif-font {
            font-family: 'Playfair Display', serif;
        }
        .glass-card {
            background: rgba(255,255,255,0.85);
            backdrop-filter: blur(12px);
            border: 1px solid rgba(255,182,193,0.3);
        }
        .input-focus:focus {
            border-color: #ff6fa9;
            box-shadow: 0 0 0 3px rgba(255,111,169,0.15);
        }
        .address-card {
            transition: all 0.3s ease;
        }
        .address-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 12px 30px rgba(255,46,126,0.12);
        }
        .btn-primary-custom {
            background: linear-gradient(135deg, #ff6fa9, #ff2e7e);
            color: white;
            box-shadow: 0 4px 15px rgba(255,46,126,0.25);
            transition: all 0.3s ease;
        }
        .btn-primary-custom:hover {
            box-shadow: 0 6px 20px rgba(255,46,126,0.45);
            transform: translateY(-2px);
        }
        select {
            appearance: none;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' fill='%23ff6fa9' viewBox='0 0 16 16'%3E%3Cpath d='M7.247 11.14L2.451 5.658C1.885 5.013 2.345 4 3.204 4h9.592a1 1 0 01.753 1.659l-4.796 5.48a1 1 0 01-1.506 0z'/%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-position: right 12px center;
            background-size: 12px;
        }
    </style>
</head>

<body class="min-h-screen pb-12">

    <!-- Navbar -->
    <nav class="bg-white/70 backdrop-blur-md border-b border-pink-100/50 sticky top-0 z-50">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-3 md:py-4 flex justify-between items-center">
            <div class="flex items-center gap-2 md:gap-3">
                <span class="text-xl md:text-2xl">📍</span>
                <div>
                    <h1 class="text-lg md:text-xl font-bold serif-font text-gray-800">Data Alamat</h1>
                    <p class="text-[11px] text-gray-400 font-medium">Tambah dan kelola alamat pengiriman kamu</p>
                </div>
            </div>

            <a href="javascript:history.back()"
               class="text-xs font-bold text-pink-500 hover:text-pink-600 transition flex items-center gap-1.5">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Kembali
            </a>
        </div>
    </nav>

    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 mt-8">

        {{-- SUCCESS / ERROR MESSAGES --}}
        @if(session('success'))
        <div class="mb-6 bg-green-50 border border-green-200 text-green-700 p-4 rounded-2xl flex items-center text-sm shadow-sm">
            <svg class="w-5 h-5 mr-3 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
            </svg>
            <span class="font-semibold">{{ session('success') }}</span>
        </div>
        @endif

        @if($errors->any())
        <div class="mb-6 bg-red-50 border border-red-200 text-red-700 p-4 rounded-2xl text-sm shadow-sm">
            <ul class="list-disc list-inside space-y-1">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        {{-- LAYOUT 2 KOLOM: FORM (KIRI) + DAFTAR ALAMAT (KANAN) --}}
        <div class="grid grid-cols-1 lg:grid-cols-5 gap-6 items-start">

            {{-- KOLOM KIRI: FORM TAMBAH ALAMAT --}}
            <div class="lg:col-span-3">
                <div class="glass-card rounded-3xl shadow-lg overflow-hidden">
                    <div class="bg-gradient-to-r from-pink-50 to-white border-b border-pink-100/40 px-6 py-4">
                        <h2 class="text-base font-bold serif-font text-gray-800 flex items-center gap-2">
                            <svg class="w-5 h-5 text-pink-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                            </svg>
                            Tambah Alamat Baru
                        </h2>
                    </div>

                    <form action="/addresses" method="POST" class="px-6 py-6">
                        @csrf

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            {{-- PROVINSI --}}
                            <div>
                                <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-1.5">Provinsi</label>
                                <select id="province" name="province" class="w-full border border-pink-200/60 rounded-xl px-4 py-2.5 text-sm text-gray-700 bg-white input-focus outline-none transition pr-8" required>
                                    <option value="">Pilih Provinsi</option>
                                </select>
                            </div>

                            {{-- KOTA --}}
                            <div>
                                <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-1.5">Kabupaten / Kota</label>
                                <select id="city" name="city" class="w-full border border-pink-200/60 rounded-xl px-4 py-2.5 text-sm text-gray-700 bg-white input-focus outline-none transition pr-8" required>
                                    <option value="">Pilih Kabupaten / Kota</option>
                                </select>
                            </div>

                            {{-- KECAMATAN --}}
                            <div>
                                <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-1.5">Kecamatan</label>
                                <select id="district" name="district" class="w-full border border-pink-200/60 rounded-xl px-4 py-2.5 text-sm text-gray-700 bg-white input-focus outline-none transition pr-8" required>
                                    <option value="">Pilih Kecamatan</option>
                                </select>
                            </div>

                            {{-- KELURAHAN --}}
                            <div>
                                <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-1.5">Kelurahan / Desa</label>
                                <select id="village" name="village" class="w-full border border-pink-200/60 rounded-xl px-4 py-2.5 text-sm text-gray-700 bg-white input-focus outline-none transition pr-8" required>
                                    <option value="">Pilih Kelurahan / Desa</option>
                                </select>
                            </div>
                        </div>

                        {{-- DETAIL ALAMAT --}}
                        <div class="mt-4">
                            <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-1.5">Detail Alamat</label>
                            <textarea name="detail_address" rows="2" placeholder="Contoh: Jl. Mawar No. 10, RT 05/RW 03, Depan Minimarket" class="w-full border border-pink-200/60 rounded-xl px-4 py-2.5 text-sm text-gray-700 bg-white input-focus outline-none transition resize-none" required></textarea>
                        </div>

                        <button type="submit" class="mt-5 w-full btn-primary-custom font-bold py-3 rounded-xl text-sm uppercase tracking-wider">
                            💾 Simpan Alamat
                        </button>
                    </form>
                </div>
            </div>

            {{-- KOLOM KANAN: DAFTAR ALAMAT TERSIMPAN --}}
            <div class="lg:col-span-2">
                <div class="flex items-center gap-2 mb-4">
                    <svg class="w-4 h-4 text-pink-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                    </svg>
                    <h3 class="text-xs font-bold uppercase text-pink-600 tracking-wider">
                        Alamat Tersimpan ({{ count($data) }})
                    </h3>
                </div>

                @if(count($data) > 0)
                <div class="space-y-3 max-h-[520px] overflow-y-auto pr-1" style="scrollbar-width: thin; scrollbar-color: #f9a8d4 transparent;">
                    @foreach($data as $item)
                    <div class="address-card glass-card rounded-2xl shadow-sm overflow-hidden">
                        <div class="p-4">
                            {{-- HEADER: PROVINSI + ID --}}
                            <div class="flex items-center justify-between mb-2">
                                <span class="bg-pink-100 text-pink-600 px-2.5 py-0.5 rounded-full text-[10px] font-bold uppercase tracking-wider">
                                    {{ $item->province }}
                                </span>
                                <span class="text-[10px] text-gray-400 font-medium">#{{ $item->id }}</span>
                            </div>

                            {{-- KOTA & KECAMATAN --}}
                            <h4 class="text-sm font-bold text-gray-800 leading-tight">
                                {{ $item->city }}, {{ $item->district }}
                            </h4>
                            <p class="text-[11px] text-gray-400 mb-2">Kel. {{ $item->village }}</p>

                            {{-- DETAIL ALAMAT --}}
                            <div class="bg-pink-50/50 border border-pink-100/30 rounded-lg p-2.5 mb-3">
                                <p class="text-[11px] text-gray-600 leading-relaxed">
                                    📌 {{ $item->detail_address }}
                                </p>
                            </div>

                            {{-- HAPUS --}}
                            <form action="/addresses/{{ $item->id }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" onclick="return confirm('Apakah Anda yakin ingin menghapus alamat ini?')" class="w-full bg-white hover:bg-red-50 text-red-500 border border-red-200 font-semibold py-1.5 rounded-lg text-[10px] uppercase tracking-wider transition flex items-center justify-center gap-1">
                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                    </svg>
                                    Hapus
                                </button>
                            </form>
                        </div>
                    </div>
                    @endforeach
                </div>
                @else
                <div class="text-center py-10 glass-card rounded-2xl">
                    <div class="text-3xl mb-2">🏠</div>
                    <p class="text-xs text-gray-400 font-medium">Belum ada alamat tersimpan.</p>
                    <p class="text-[11px] text-gray-300 mt-0.5">Tambahkan alamat baru di sebelah kiri.</p>
                </div>
                @endif
            </div>

        </div>{{-- end grid --}}

    </div>

<!-- SCRIPT WILAYAH API -->
<script>
// GET PROVINSI ON LOAD
document.addEventListener('DOMContentLoaded', async function () {
    try {
        const response = await fetch('/proxy/wilayah/provinces.json');
        const data = await response.json();

        const provinceSelect = document.getElementById('province');

        data.data.forEach(prov => {
            provinceSelect.innerHTML += `<option value="${prov.name}" data-code="${prov.code}">${prov.name}</option>`;
        });
    } catch (error) {
        console.error('Error fetching provinces:', error);
    }
});

// PROVINSI → KOTA
document.getElementById('province').addEventListener('change', async function() {
    const citySelect = document.getElementById('city');
    const districtSelect = document.getElementById('district');
    const villageSelect = document.getElementById('village');

    citySelect.innerHTML = '<option value="">Pilih Kabupaten / Kota</option>';
    districtSelect.innerHTML = '<option value="">Pilih Kecamatan</option>';
    villageSelect.innerHTML = '<option value="">Pilih Kelurahan / Desa</option>';

    const selectedOption = this.options[this.selectedIndex];
    const code = selectedOption.getAttribute('data-code');

    if (code) {
        try {
            const response = await fetch(`/proxy/wilayah/regencies/${code}.json`);
            const data = await response.json();

            data.data.forEach(city => {
                citySelect.innerHTML += `<option value="${city.name}" data-code="${city.code}">${city.name}</option>`;
            });
        } catch (error) {
            console.error('Error fetching cities:', error);
        }
    }
});

// KOTA → KECAMATAN
document.getElementById('city').addEventListener('change', async function() {
    const districtSelect = document.getElementById('district');
    const villageSelect = document.getElementById('village');

    districtSelect.innerHTML = '<option value="">Pilih Kecamatan</option>';
    villageSelect.innerHTML = '<option value="">Pilih Kelurahan / Desa</option>';

    const selectedOption = this.options[this.selectedIndex];
    const code = selectedOption.getAttribute('data-code');

    if (code) {
        try {
            const response = await fetch(`/proxy/wilayah/districts/${code}.json`);
            const data = await response.json();

            data.data.forEach(district => {
                districtSelect.innerHTML += `<option value="${district.name}" data-code="${district.code}">${district.name}</option>`;
            });
        } catch (error) {
            console.error('Error fetching districts:', error);
        }
    }
});

// KECAMATAN → DESA
document.getElementById('district').addEventListener('change', async function() {
    const villageSelect = document.getElementById('village');
    villageSelect.innerHTML = '<option value="">Pilih Kelurahan / Desa</option>';

    const selectedOption = this.options[this.selectedIndex];
    const code = selectedOption.getAttribute('data-code');

    if (code) {
        try {
            const response = await fetch(`/proxy/wilayah/villages/${code}.json`);
            const data = await response.json();

            data.data.forEach(village => {
                villageSelect.innerHTML += `<option value="${village.name}" data-code="${village.code}">${village.name}</option>`;
            });
        } catch (error) {
            console.error('Error fetching villages:', error);
        }
    }
});
</script>

</body>
</html>
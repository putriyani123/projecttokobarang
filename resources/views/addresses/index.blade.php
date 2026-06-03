<!DOCTYPE html>
<html>
<head>
    <title>Alamat</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            background: #6b7796;
        }
        .card {
            border-radius: 15px;
        }
        .form-control, .form-select {
            border-radius: 10px;
        }
        .btn {
            border-radius: 10px;
        }
    </style>
</head>
<body>

<div class="container mt-5">

    <!-- TITLE + BUTTON HOME -->
    <div class="mb-4 d-flex justify-content-between align-items-center">
        <div>
            <h3 class="fw-bold">📍 Data Alamat</h3>
            <p class="text-muted">Tambah dan kelola alamat kamu</p>
        </div>
<a href="javascript:history.back()" class="btn btn-secondary shadow-sm fw-bold">
    ⬅ Kembali
</a>
    </div>

    <!-- FORM -->
    <div class="card shadow-sm mb-4">
        <div class="card-body">

            <h5 class="mb-3">Tambah Alamat</h5>

            <form action="/addresses" method="POST">
                @csrf

                <div class="row">

                    <div class="col-md-6 mb-3">
                        <label>Provinsi</label>
                        <select id="province" name="province" class="form-select">
                            <option value="">Pilih Provinsi</option>
                        </select>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label>Kabupaten / Kota</label>
                        <select id="city" name="city" class="form-select">
                            <option value="">Pilih Kabupaten / Kota</option>
                        </select>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label>Kecamatan</label>
                        <select id="district" name="district" class="form-select">
                            <option value="">Pilih Kecamatan</option>
                        </select>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label>Kelurahan / Desa</label>
                        <select id="village" name="village" class="form-select">
                            <option value="">Pilih Kelurahan / Desa</option>
                        </select>
                    </div>

                    <div class="col-12 mb-3">
                        <label>Detail Alamat</label>
                        <textarea name="detail_address" class="form-control" rows="3"></textarea>
                    </div>

                </div>

                <button class="btn btn-primary w-100">Simpan Alamat</button>

            </form>
        </div>
    </div>

    <!-- LIST -->
    <div class="row">
        @foreach($data as $item)
        <div class="col-md-6">
            <div class="card shadow-sm mb-3">
                <div class="card-body">

                    <h6 class="fw-bold text-primary">
                        {{ $item->province }}
                    </h6>

                    <p class="mb-1">
                        {{ $item->city }}, {{ $item->district }}
                    </p>

                    <p class="mb-2 text-muted">
                        {{ $item->village }}
                    </p>

                    <p class="small">
                        {{ $item->detail_address }}
                    </p>

                    <form action="/addresses/{{ $item->id }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-outline-danger btn-sm w-100">
                            Hapus
                        </button>
                    </form>

                </div>
            </div>
        </div>
        @endforeach
    </div>

</div>

<!-- SCRIPT -->
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
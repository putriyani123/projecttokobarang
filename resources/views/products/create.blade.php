<!DOCTYPE html>
<html>
<head>
    <title>Tambah Produk</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body { 
            background: linear-gradient(135deg, #7587c2, #597ea3);
            font-family: 'Segoe UI', sans-serif;
        }

        .header-box {
            background: white;
            padding: 20px;
            border-radius: 18px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.05);
            margin-bottom: 20px;
        }

        .card {
            border-radius: 20px;
            border: none;
            box-shadow: 0 10px 30px rgba(0,0,0,0.05);
        }

        .form-control, .form-select {
            border-radius: 12px;
            height: 45px;
        }

        .btn {
            border-radius: 12px;
            padding: 10px;
            font-weight: 600;
        }

        .btn-primary {
            background: linear-gradient(45deg, #4f46e5, #6366f1);
            border: none;
        }

        .btn-primary:hover {
            transform: scale(1.01);
        }

        .btn-secondary {
            border-radius: 12px;
        }

        .preview-img {
            width: 100%;
            height: 220px;
            object-fit: cover;
            border-radius: 15px;
            display: none;
            margin-top: 15px;
            box-shadow: 0 10px 25px rgba(0,0,0,0.1);
        }

        label {
            font-weight: 600;
            margin-bottom: 5px;
        }

        .subtitle {
            color: #64748b;
            font-size: 14px;
        }
    </style>
</head>
<body>

<div class="container mt-5">

    <!-- HEADER -->
    <div class="header-box">
        <h3 class="fw-bold mb-1">➕ Tambah Produk</h3>
        <p class="subtitle mb-0">Masukkan data produk baru ke dalam sistem</p>
    </div>

    <!-- FORM -->
    <div class="card">
        <div class="card-body">

            <form action="/products" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="row">

                    <div class="col-md-6 mb-3">
                        <label>Nama Produk</label>
                        <input type="text" name="name" class="form-control" placeholder="Contoh: Lipstik Matte">
                    </div>

                    <div class="col-md-3 mb-3">
                        <label>Harga</label>
                        <input type="number" name="price" class="form-control" placeholder="Rp 0">
                    </div>

                    <div class="col-md-3 mb-3">
                        <label>Diskon (%)</label>
                        <input type="number" name="discount" class="form-control" placeholder="0" min="0" max="100" step="0.01" value="0">
                    </div>

                    <div class="col-md-3 mb-3">
                        <label>Stock</label>
                        <input type="number" name="stock" class="form-control" placeholder="0">
                    </div>

                    <div class="col-12 mb-3">
                        <label>Kategori</label>
                        <select name="category_id" class="form-select">
                            <option value="">-- pilih kategori --</option>
                            @foreach($categories as $c)
                                <option value="{{ $c->id }}">{{ $c->name }}</option>
                            @endforeach
                        </select>
                    </div>


                    <!-- FOTO -->
                    <div class="col-12 mb-3">
                        <label>Foto Produk</label>
                        <input type="file" name="image" class="form-control" onchange="previewImage(event)">
                        <img id="preview" class="preview-img">
                    </div>

                </div>

                <button class="btn btn-primary w-100">
                    💾 Simpan Produk
                </button>

                <a href="/products" class="btn btn-secondary w-100 mt-2">
                    ← Kembali
                </a>

            </form>

        </div>
    </div>

</div>

<script>
function previewImage(event) {
    const input = event.target;
    const preview = document.getElementById('preview');

    if (input.files && input.files[0]) {
        preview.src = URL.createObjectURL(input.files[0]);
        preview.style.display = 'block';
    }
}

function togglePreorderDays() {
    const isPreorder = document.getElementById('is_preorder').value;
    const container = document.getElementById('preorder_days_container');
    if (isPreorder == '1') {
        container.style.display = 'block';
    } else {
        container.style.display = 'none';
    }
}
</script>

</body>
</html>
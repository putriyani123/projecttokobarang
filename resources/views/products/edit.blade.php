<!DOCTYPE html>
<html>
<head>
    <title>Edit Produk</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body { 
            background: linear-gradient(135deg, #606d99, #5e81a5);
            font-family: 'Segoe UI', sans-serif;
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

        textarea.form-control {
            height: auto;
        }

        .btn {
            border-radius: 12px;
        }

        .btn-primary {
            background: linear-gradient(45deg, #4f46e5, #6366f1);
            border: none;
        }

        .header-box {
            background: white;
            padding: 25px;
            border-radius: 20px;
            box-shadow: 0 8px 25px rgba(0,0,0,0.05);
        }

        .preview-img {
            width: 100%;
            height: 220px;
            object-fit: cover;
            border-radius: 15px;
            margin-bottom: 15px;
        }

        .old-img {
            font-size: 13px;
            color: #64748b;
        }
    </style>
</head>
<body>

<div class="container mt-5">

    <!-- HEADER -->
    <div class="header-box mb-4">
        <h3 class="fw-bold mb-1">✏️ Edit Produk</h3>
        <p class="text-muted mb-0">Update data produk kamu</p>
    </div>

    <!-- FORM -->
    <div class="card">
        <div class="card-body">

            <form action="/products/{{ $product->id }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="row">

                    <!-- GAMBAR LAMA -->
                    <div class="col-12 mb-3">
                        <label>Gambar Saat Ini</label>
                        <div>
                            @if($product->image)
                                <img src="{{ asset('storage/' . $product->image) }}" class="preview-img">
                            @else
                                <img src="https://via.placeholder.com/300x200?text=No+Image" class="preview-img">
                            @endif
                        </div>
                        <small class="old-img">Jika tidak diganti, gambar tetap yang lama</small>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label>Nama Produk</label>
                        <input type="text" name="name" class="form-control" value="{{ $product->name }}">
                    </div>

                    <div class="col-md-3 mb-3">
                        <label>Harga</label>
                        <input type="number" name="price" class="form-control" value="{{ $product->price }}">
                    </div>

                    <div class="col-md-3 mb-3">
                        <label>Diskon (%)</label>
                        <input type="number" name="discount" class="form-control" value="{{ $product->discount ?? 0 }}" min="0" max="100" step="0.01">
                    </div>

                    <div class="col-md-3 mb-3">
                        <label>Stock</label>
                        <input type="number" name="stock" class="form-control" value="{{ $product->stock }}">
                    </div>

                    <div class="col-12 mb-3">
                        <label>Kategori</label>
                        <select name="category_id" class="form-select">
                            @foreach($categories as $c)
                                <option value="{{ $c->id }}"
                                    {{ $product->category_id == $c->id ? 'selected' : '' }}>
                                    {{ $c->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                   

                    <div class="col-12 mb-3">
                        <label>Ganti Foto (opsional)</label>
                        <input type="file" name="image" class="form-control">
                    </div>

                </div>

                <button class="btn btn-primary w-100">
                    💾 Update Produk
                </button>

                <a href="/products" class="btn btn-secondary w-100 mt-2">
                    ← Kembali
                </a>

            </form>

        </div>
    </div>

</div>

<script>
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
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kategori</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body { 
            background: linear-gradient(135deg, #fff1f7, #ffffff);
            font-family: 'Segoe UI', sans-serif;
            color: #2d1b22;
        }

        .container-box {
            max-width: 950px;
            margin: auto;
        }

        .header-box {
            background: white;
            padding: 20px;
            border-radius: 18px;
            box-shadow: 0 10px 30px rgba(255, 46, 126, 0.05);
            border: 1px solid #ffe3ee;
            margin-bottom: 20px;
        }

        .subtitle {
            color: #8b6b71;
            font-size: 14px;
        }

        .category-card {
            background: white;
            border-radius: 16px;
            padding: 20px;
            border: 1px solid #ffe3ee;
            box-shadow: 0 8px 20px rgba(255, 46, 126, 0.04);
            transition: 0.3s ease;
            height: 100%;
        }

        .category-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 12px 25px rgba(255, 46, 126, 0.10);
        }

        .form-control {
            border-radius: 12px;
            height: 42px;
            border: 1px solid #ffd5e3;
            background-color: #fffafc;
            color: #2d1b22;
            font-weight: 500;
        }

        .form-control:focus {
            border-color: #ff6fa9;
            box-shadow: 0 0 0 0.25rem rgba(255, 111, 169, 0.15);
            background-color: #ffffff;
        }

        .btn {
            border-radius: 12px;
            font-weight: 600;
        }

        .btn-primary {
            background: linear-gradient(135deg, #ff6fa9, #ff2e7e);
            border: none;
        }

        .btn-primary:hover {
            background: linear-gradient(135deg, #ff2e7e, #db2777);
        }

        .btn-warning {
            background: linear-gradient(135deg, #ff85b6, #ff2e7e);
            border: none;
            color: white;
        }

        .btn-warning:hover {
            background: linear-gradient(135deg, #ff2e7e, #db2777);
            color: white;
        }

        .btn-danger {
            background: transparent;
            border: 1px solid #ef4444;
            color: #ef4444;
        }

        .btn-danger:hover {
            background: #ef4444;
            color: white;
        }

        .btn-home {
            background: #ff2e7e;
            color: white;
            border-radius: 12px;
            padding: 8px 14px;
            text-decoration: none;
            font-size: 14px;
        }

        .btn-home:hover {
            background: #db2777;
            color: white;
        }

        .empty {
            text-align: center;
            padding: 40px;
            color: #ff85b6;
            font-weight: 600;
        }
    </style>
</head>
<body>

<div class="container mt-5 container-box">

    <!-- HEADER -->
    <div class="header-box d-flex justify-content-between align-items-center">

        <div>
            <h3 class="fw-bold mb-1">📂 Kategori</h3>
            <p class="subtitle mb-0">Kelola data kategori produk</p>
        </div>

        <div class="d-flex gap-2">

            <a href="javascript:history.back()" class="btn btn-secondary shadow-sm fw-bold">
    ⬅ Kembali
</a>

            <!-- tambah kategori -->
            <a href="/categories/create" class="btn btn-primary">
                + Tambah
            </a>

        </div>

    </div>

    <!-- LIST -->
    <div class="row g-3">

        @forelse($data as $item)
        <div class="col-12 col-sm-6 col-md-4">

            <div class="category-card">

                <form action="/categories/{{ $item->id }}" method="POST">
                    @csrf
                    @method('PUT')

                    <label class="fw-bold mb-1">Nama Kategori</label>

                    <input type="text" name="name" value="{{ $item->name }}" class="form-control mb-3">

                    <button class="btn btn-warning w-100 mb-2">
                        ✏️ Update
                    </button>
                </form>

                <form action="/categories/{{ $item->id }}" method="POST">
                    @csrf
                    @method('DELETE')

                    <button class="btn btn-danger w-100">
                        🗑 Hapus
                    </button>
                </form>

            </div>

        </div>
        @empty

        <div class="empty">
            📭 Belum ada kategori
        </div>

        @endforelse

    </div>

</div>

</body>
</html>
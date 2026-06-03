<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Kategori</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body { 
            background: linear-gradient(135deg, #fff1f7, #ffffff);
            font-family: 'Segoe UI', sans-serif;
            color: #2d1b22;
        }

        /* 🔥 DIBUAT LEBIH LEBAR */
        .container-box {
            max-width: 900px;
            margin: auto;
        }

        .header-box {
            background: white;
            padding: 20px;
            border-radius: 16px;
            box-shadow: 0 10px 25px rgba(255, 46, 126, 0.05);
            border: 1px solid #ffe3ee;
            margin-bottom: 15px;
        }

        .card {
            border-radius: 16px;
            border: 1px solid #ffe3ee;
            box-shadow: 0 10px 25px rgba(255, 46, 126, 0.05);
        }

        .form-control {
            border-radius: 12px;
            height: 45px;
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

        label {
            font-weight: 600;
            font-size: 14px;
            margin-bottom: 6px;
            color: #2d1b22;
        }

        .btn {
            border-radius: 12px;
            font-weight: 600;
            padding: 10px;
        }

        .btn-primary {
            background: linear-gradient(135deg, #ff6fa9, #ff2e7e);
            border: none;
        }

        .btn-primary:hover {
            background: linear-gradient(135deg, #ff2e7e, #db2777);
        }

        .btn-secondary {
            border-radius: 12px;
            background-color: #6c757d;
            border: none;
        }

        .subtitle {
            color: #8b6b71;
            font-size: 13px;
        }
    </style>
</head>
<body>

<div class="container mt-5 container-box">

    <!-- HEADER -->
    <div class="header-box">
        <h4 class="fw-bold mb-1">📂 Tambah Kategori</h4>
        <p class="subtitle mb-0">Masukkan kategori baru untuk produk</p>
    </div>

    <!-- FORM -->
    <div class="card">
        <div class="card-body p-4">

            <form action="/categories" method="POST">
                @csrf

                <div class="mb-3">
                    <label>Nama Kategori</label>
                    <input type="text" name="name" class="form-control" placeholder="Contoh: Kosmetik">
                </div>

                <button class="btn btn-primary w-100">
                    💾 Simpan
                </button>

                <a href="/categories" class="btn btn-secondary w-100 mt-2">
                    ← Kembali
                </a>

            </form>

        </div>
    </div>

</div>

</body>
</html>
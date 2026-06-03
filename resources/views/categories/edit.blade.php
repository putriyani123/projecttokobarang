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
        .card { 
            border-radius: 15px; 
            border: 1px solid #ffe3ee;
            box-shadow: 0 10px 25px rgba(255, 46, 126, 0.05);
        }
        .btn { 
            border-radius: 10px; 
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
        .form-control {
            border: 1px solid #ffd5e3;
            background-color: #fffafc;
        }
        .form-control:focus {
            border-color: #ff6fa9;
            box-shadow: 0 0 0 0.25rem rgba(255, 111, 169, 0.15);
        }
    </style>
</head>
<body>

<div class="container mt-5">

    <!-- HEADER -->
    <div class="mb-4">
        <h3 class="fw-bold">📂 Manajemen Kategori</h3>
        <p class="text-muted">Kelola kategori dengan mudah</p>
    </div>

    <!-- TAMBAH -->
    <div class="card mb-4 shadow-sm">
        <div class="card-body">
            <form action="/categories" method="POST" class="d-flex gap-2">
                @csrf
                <input type="text" name="name" class="form-control" placeholder="Nama kategori" required>
                <button class="btn btn-primary">Tambah</button>
            </form>
        </div>
    </div>

    <!-- LIST -->
    <div class="card shadow-sm">
        <div class="card-body">

            @foreach($data as $item)
            <div class="d-flex justify-content-between align-items-center border-bottom py-3">

                <div>
                    <strong>{{ $item->name }}</strong>
                </div>

                <div class="d-flex gap-2">

                    <!-- BUTTON EDIT -->
                    <button 
                        class="btn btn-warning btn-sm"
                        data-bs-toggle="modal"
                        data-bs-target="#editModal{{ $item->id }}">
                        Edit
                    </button>

                    <!-- DELETE -->
                    <form action="/categories/{{ $item->id }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-outline-danger btn-sm"
                            onclick="return confirm('Yakin hapus?')">
                            Hapus
                        </button>
                    </form>

                </div>

            </div>

            <!-- MODAL EDIT -->
            <div class="modal fade" id="editModal{{ $item->id }}" tabindex="-1">
                <div class="modal-dialog">
                    <div class="modal-content">

                        <form action="/categories/{{ $item->id }}" method="POST">
                            @csrf
                            @method('PUT')

                            <div class="modal-header">
                                <h5 class="modal-title">Edit Kategori</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                            </div>

                            <div class="modal-body">
                                <input type="text" name="name"
                                    value="{{ $item->name }}"
                                    class="form-control"
                                    required>
                            </div>

                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                    Batal
                                </button>
                                <button class="btn btn-primary">
                                    Simpan
                                </button>
                            </div>

                        </form>

                    </div>
                </div>
            </div>

            @endforeach

        </div>
    </div>

</div>

<!-- BOOTSTRAP JS (WAJIB untuk modal) -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
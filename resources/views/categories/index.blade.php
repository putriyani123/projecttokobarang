<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kategori</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <style>
        body {
            background: linear-gradient(135deg, #fff1f7, #ffffff);
            font-family: 'Poppins', sans-serif;
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

        .card {
            border-radius: 20px;
            border: 1px solid #ffe3ee;
            box-shadow: 0 8px 30px rgba(255, 46, 126, 0.05);
        }

        .card-body h4 {
            color: #2d1b22;
            font-weight: 700;
        }

        .btn {
            border-radius: 12px;
            font-weight: 600;
        }

        .btn-primary {
            background: linear-gradient(135deg, #ff6fa9, #ff2e7e);
            border: none;
            box-shadow: 0 4px 15px rgba(255, 46, 126, 0.2);
        }

        .btn-primary:hover {
            background: linear-gradient(135deg, #ff5094, #e61a67);
            box-shadow: 0 6px 20px rgba(255, 46, 126, 0.3);
        }

        .btn-warning {
            background: linear-gradient(135deg, #fbbf24, #f59e0b);
            border: none;
            color: white;
            font-size: 12px;
        }

        .btn-warning:hover {
            background: linear-gradient(135deg, #f59e0b, #d97706);
            color: white;
        }

        .btn-danger {
            background: transparent;
            border: 1.5px solid #ef4444;
            color: #ef4444;
            font-size: 12px;
        }

        .btn-danger:hover {
            background: #ef4444;
            color: white;
        }

        .form-control {
            border: 1px solid #ffd5e3;
            border-radius: 12px;
            background-color: #fffafc;
            font-size: 14px;
        }

        .form-control:focus {
            border-color: #ff6fa9;
            box-shadow: 0 0 0 0.25rem rgba(255, 111, 169, 0.15);
            background-color: #ffffff;
        }

        .table {
            --bs-table-bg: transparent;
            border-color: #ffe3ee;
            font-size: 14px;
        }

        .table thead th {
            background-color: #fff0f5 !important;
            color: #ff2e7e !important;
            font-weight: 700;
            font-size: 13px;
            border-bottom: 2px solid #ffe3ee !important;
            white-space: nowrap;
        }

        .table tbody td {
            vertical-align: middle;
            color: #2d1b22;
        }

        .table-responsive {
            border-radius: 16px;
            overflow: hidden;
        }

        .modal-content {
            border-radius: 20px;
            border: 1px solid #ffe3ee;
        }

        /* Mobile overrides */
        @media (max-width: 767.98px) {
            .container {
                padding-left: 12px;
                padding-right: 12px;
            }
            h3 {
                font-size: 1.3rem;
            }
            .table {
                font-size: 13px;
            }
            .table thead th {
                font-size: 12px;
                padding: 8px 6px;
            }
            .table tbody td {
                padding: 8px 6px;
                font-size: 13px;
            }
        }
    </style>
</head>
<body>

<div class="container mt-4 mt-md-5 mb-5 container-box">

    <!-- HEADER -->
    <div class="header-box d-flex justify-content-between align-items-center">

        <div>
            <h3 class="fw-bold mb-1">📂 Kategori</h3>
            <p class="subtitle mb-0">Kelola data kategori produk</p>
        </div>

        <div class="d-flex gap-2">
            <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#modalTambahKategori">
                ➕ Tambah
            </button>
            <a href="javascript:history.back()" class="btn btn-secondary btn-sm shadow-sm fw-bold">
                ⬅ Kembali
            </a>
        </div>

    </div>

    {{-- ALERT --}}
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif

    <!-- TABLE KATEGORI -->
    <div class="card">
        <div class="card-body">

            <h4 class="mb-3">List Kategori</h4>

            <div class="table-responsive">
            <table class="table table-bordered mb-0">

                <thead>
                    <tr>
                        <th style="width: 60px;">No</th>
                        <th>Nama Kategori</th>
                        <th style="width: 180px;">Aksi</th>
                    </tr>
                </thead>

                <tbody>

                    @forelse($data as $item)

                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td class="fw-semibold">{{ $item->name }}</td>
                            <td>
                                <div class="d-flex gap-1">
                                    {{-- Tombol Edit --}}
                                    <button
                                        class="btn btn-warning btn-sm"
                                        data-bs-toggle="modal"
                                        data-bs-target="#modalEditKategori{{ $item->id }}"
                                    >
                                        ✏️ Edit
                                    </button>

                                    {{-- Tombol Hapus --}}
                                    <form action="/categories/{{ $item->id }}" method="POST">
                                        @csrf
                                        @method('DELETE')

                                        <button
                                            class="btn btn-danger btn-sm"
                                            onclick="return confirm('Hapus kategori ini?')"
                                        >
                                            🗑 Hapus
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>

                    @empty

                        <tr>
                            <td colspan="3" class="text-center text-muted py-4">
                                📭 Belum ada kategori
                            </td>
                        </tr>

                    @endforelse

                </tbody>

            </table>
            </div>

        </div>
    </div>

</div>


{{-- MODAL TAMBAH KATEGORI --}}
<div class="modal fade" id="modalTambahKategori" tabindex="-1" aria-labelledby="modalTambahKategoriLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header border-0 pb-0">
                <h5 class="modal-title fw-bold" id="modalTambahKategoriLabel">➕ Tambah Kategori</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body pt-2">
                <p class="text-muted mb-3" style="font-size: 13px;">Masukkan kategori baru untuk produk</p>

                <form action="/categories" method="POST">
                    @csrf

                    <div class="mb-3">
                        <label class="form-label fw-semibold" style="font-size:13px;">Nama Kategori</label>
                        <input
                            type="text"
                            name="name"
                            class="form-control"
                            placeholder="Contoh: Kosmetik"
                            required
                        >
                    </div>

                    <button class="btn btn-primary w-100 mt-2">
                        💾 Simpan
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>


{{-- MODAL EDIT KATEGORI (per item) --}}
@foreach($data as $item)
<div class="modal fade" id="modalEditKategori{{ $item->id }}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header border-0 pb-0">
                <h5 class="modal-title fw-bold">✏️ Edit Kategori</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body pt-2">
                <p class="text-muted mb-3" style="font-size: 13px;">Ubah nama kategori</p>

                <form action="/categories/{{ $item->id }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label class="form-label fw-semibold" style="font-size:13px;">Nama Kategori</label>
                        <input
                            type="text"
                            name="name"
                            class="form-control"
                            value="{{ $item->name }}"
                            required
                        >
                    </div>

                    <button class="btn btn-primary w-100 mt-2">
                        💾 Update
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endforeach


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
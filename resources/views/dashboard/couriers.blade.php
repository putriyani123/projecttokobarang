<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Kurir</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body{
            background: linear-gradient(135deg, #fff1f7, #ffffff);
            font-family: 'Poppins', sans-serif;
            color: #2d1b22;
        }

        .card{
            border-radius:20px;
            border: 1px solid #ffe3ee;
            box-shadow: 0 8px 30px rgba(255, 46, 126, 0.05);
        }

        .card-body h4 {
            color: #2d1b22;
            font-weight: 700;
        }

        .btn{
            border-radius:12px;
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

        /* Mobile overrides */
        @media (max-width: 767.98px) {
            .container {
                padding-left: 12px;
                padding-right: 12px;
            }
            h2 {
                font-size: 1.3rem;
                font-weight: 700;
            }
            h4 {
                font-size: 1.1rem;
            }
            .card-body {
                padding: 16px;
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

<div class="container mt-4 mt-md-5 mb-5">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>💌 Data Kurir</h2>

        <a href="/admin/dashboard" class="btn btn-secondary btn-sm">
            ⬅ Kembali
        </a>
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


    {{-- TAMBAH KURIR --}}
    <div class="card mb-4">
        <div class="card-body">

            <h4 class="mb-3">Tambah Kurir</h4>

            <form method="POST" action="{{ route('admin.couriers.store') }}">
                @csrf

                <div class="row">

                    <div class="col-12 col-md-4 mb-3">
                        <label class="form-label fw-semibold" style="font-size:13px;">Nama Kurir</label>
                        <input
                            type="text"
                            name="name"
                            class="form-control"
                            placeholder="Nama Kurir"
                            required
                        >
                    </div>

                    <div class="col-12 col-md-4 mb-3">
                        <label class="form-label fw-semibold" style="font-size:13px;">Email</label>
                        <input
                            type="email"
                            name="email"
                            class="form-control"
                            placeholder="Email"
                            required
                        >
                    </div>

                    <div class="col-12 col-md-4 mb-3">
                        <label class="form-label fw-semibold" style="font-size:13px;">Password</label>
                        <input
                            type="password"
                            name="password"
                            class="form-control"
                            placeholder="Password"
                            required
                        >
                    </div>

                </div>

                <button class="btn btn-primary w-100 w-md-auto">
                    ➕ Tambah Kurir
                </button>

            </form>

        </div>
    </div>


    {{-- TABLE KURIR --}}
    <div class="card">
        <div class="card-body">

            <h4 class="mb-3">List Kurir</h4>

            <div class="table-responsive">
            <table class="table table-bordered mb-0">

                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama</th>
                        <th>Email</th>
                        <th>Aksi</th>
                    </tr>
                </thead>

                <tbody>

                    @forelse($couriers as $courier)

                        <tr>

                            <td>{{ $loop->iteration }}</td>

                            <td class="fw-semibold">{{ $courier->name }}</td>

                            <td>{{ $courier->email }}</td>

                            <td>

                                <form
                                    action="{{ route('admin.couriers.delete', $courier->id) }}"
                                    method="POST"
                                >
                                    @csrf
                                    @method('DELETE')

                                    <button
                                        class="btn btn-danger btn-sm"
                                        onclick="return confirm('Hapus kurir ini?')"
                                    >
                                        🗑 Hapus
                                    </button>

                                </form>

                            </td>

                        </tr>

                    @empty

                        <tr>
                            <td colspan="4" class="text-center text-muted py-4">
                                📭 Belum ada kurir
                            </td>
                        </tr>

                    @endforelse

                </tbody>

            </table>
            </div>

        </div>
    </div>

</div>

</body>
</html>
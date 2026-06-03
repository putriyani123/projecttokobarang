<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Produk Cosmetic Store</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>

        body{
            background:
            linear-gradient(135deg,#fff1f7,#ffffff);

            font-family:'Segoe UI',sans-serif;

            color:#2d1b22;
        }

        .header-box{
            background:#ffffff;

            padding:25px;

            border-radius:24px;

            box-shadow:
            0 10px 30px rgba(255, 46, 126, 0.05);

            border:1px solid #ffe3ee;
        }

        .title{
            font-size:30px;
            font-weight:800;
            color:#2d1b22;
        }

        .subtitle{
            color:#8b6b71;
            font-size:14px;
        }

        .search-box{
            position:relative;
            width:100%;
            max-width:320px;
        }

        .search-input{
            width:100%;

            border:none;

            background:#fff5f8;

            padding:14px 20px 14px 50px;

            border-radius:16px;

            font-size:14px;

            outline:none;

            transition:.3s ease;

            border:1px solid transparent;
        }

        .search-input:focus{
            border-color:#ff6fa9;

            box-shadow:
            0 0 0 4px rgba(255, 111, 169, 0.15);
        }

        .search-icon{
            position:absolute;

            top:50%;
            left:18px;

            transform:translateY(-50%);

            font-size:16px;

            color:#ff2e7e;
        }

        .card{
            border-radius:22px;

            border:none;

            overflow:hidden;

            transition:.35s ease;

            background:#ffffff;

            box-shadow:
            0 10px 25px rgba(255, 46, 126, 0.05);
        }

        .card:hover{
            transform:translateY(-8px);

            box-shadow:
            0 20px 40px rgba(255, 46, 126, 0.15);
        }

        .img-wrapper{
            position:relative;
            overflow:hidden;
        }

        .product-img{
            height:250px;
            width:100%;
            object-fit:cover;

            transition:.4s ease;
        }

        .card:hover .product-img{
            transform:scale(1.05);
        }

        .stock-badge{
            position:absolute;

            top:14px;
            right:14px;

            background:
            linear-gradient(135deg,#ff2e7e,#ff6fa9);

            color:white;

            font-size:11px;

            padding:6px 12px;

            border-radius:30px;

            font-weight:600;

            box-shadow:
            0 5px 15px rgba(255, 46, 126, 0.25);
        }

        .card-body{
            padding:22px;
        }

        .product-name{
            font-size:20px;
            font-weight:700;
            color:#2d1b22;
        }

        .price{
            font-size:22px;
            font-weight:800;
            color:#ff2e7e;
            margin-top:5px;
        }

        .category{
            display:inline-block;

            background:#ffe3ee;

            color:#ff2e7e;

            font-size:11px;

            padding:6px 14px;

            border-radius:30px;

            margin-top:10px;

            font-weight:700;
        }

        .detail-box{
            background:#fff5f8;

            border-left:4px solid #ff2e7e;

            padding:14px;

            border-radius:14px;

            font-size:13px;

            color:#5b4b50;

            margin-top:16px;
        }

        .divider{
            border-top:1px dashed #ffd5e3;
            margin:18px 0;
        }

        .btn{
            border-radius:12px;
            font-size:13px;
            padding:10px;
            font-weight:700;
        }

        .btn-primary{
            background:
            linear-gradient(135deg,#ff6fa9,#ff2e7e);

            border:none;
        }

        .btn-success{
            background:
            linear-gradient(135deg,#16a34a,#22c55e);

            border:none;
        }

        .btn-warning{
            background:
            linear-gradient(135deg,#ff6fa9,#db2777);

            border:none;

            color:white;
        }

        .btn-outline-primary{
            border:1px solid #ff2e7e;
            color:#ff2e7e;
        }

        .btn-outline-primary:hover{
            background:#ff2e7e;
            color:white;
            border-color:#ff2e7e;
        }

        .btn-outline-danger{
            border:1px solid #ef4444;
            color:#ef4444;
        }

        .btn-outline-danger:hover{
            background:#ef4444;
            color:white;
        }

        .empty-box{
            background:white;

            border-radius:25px;

            padding:60px;

            text-align:center;

            display:none;

            box-shadow:
            0 10px 25px rgba(255, 46, 126, 0.04);
        }

        /* Responsive / Mobile styling overrides */
        @media (max-width: 767.98px) {
            .container {
                padding-top: 1.5rem !important;
                padding-bottom: 1.5rem !important;
            }
            .header-box {
                padding: 18px;
                border-radius: 18px;
                margin-bottom: 2rem !important;
            }
            .title {
                font-size: 22px;
            }
            .subtitle {
                font-size: 12px;
            }
            .search-box {
                max-width: 100%;
            }
            .product-img {
                height: 140px;
            }
            .card-body {
                padding: 12px;
            }
            .product-name {
                font-size: 14px;
                line-height: 1.3;
                height: 36px;
                display: -webkit-box;
                -webkit-line-clamp: 2;
                -webkit-box-orient: vertical;
                overflow: hidden;
                margin-bottom: 4px;
                font-weight: 700;
            }
            .price {
                font-size: 16px;
                margin-top: 2px;
                font-weight: 800;
            }
            .category {
                font-size: 10px;
                padding: 4px 8px;
                margin-top: 4px;
            }
            .detail-box {
                display: none; /* Hide descriptions to keep cards compact and aligned */
            }
            .stock-badge {
                top: 8px;
                right: 8px;
                font-size: 10px;
                padding: 4px 8px;
            }
            .btn {
                font-size: 12px;
                padding: 8px 10px;
                border-radius: 8px;
            }
            .divider {
                margin: 8px 0;
            }
            .empty-box {
                padding: 40px 20px;
                border-radius: 18px;
            }
        }

    </style>

</head>

<body>

<div class="container py-5">

    <!-- HEADER -->
    <div class="header-box mb-5">

        <div class="d-flex justify-content-between align-items-center flex-wrap gap-4">

            <div>

                <h1 class="title">
                    💄 Data Produk Cosmetic
                </h1>

                <p class="subtitle mb-0">
                    List semua produk kecantikan terbaik untuk skincare harian
                </p>

            </div>

            <div class="search-box">

                <span class="search-icon">
                    🔍
                </span>

                <input type="text"
                       id="searchInput"
                       class="search-input"
                       placeholder="Cari produk skincare...">

            </div>

        </div>

        <div class="d-flex gap-2 mt-4 flex-wrap">

            <a href="javascript:history.back()"
               class="btn btn-secondary">

                ⬅ Kembali

            </a>

            <a href="/cart"
               class="btn btn-warning">

                🛒 Keranjang

            </a>

            @if(auth()->check() && auth()->user()->role === 'admin')

            <a href="/products/create"
               class="btn btn-primary">

                + Tambah Produk

            </a>

            @endif

        </div>

    </d    <!-- PRODUCT LIST -->
    <div class="row g-2 g-md-4" id="productContainer">

        @foreach($data as $item)

        @php

            $name = strtolower($item->name);
            $desc = '';

            if(str_contains($name, 'sunscreen')) {
                $desc = '☀️ Melindungi kulit dari sinar UV dan menjaga kelembapan kulit.';
            } elseif(str_contains($name, 'serum')) {
                $desc = '✨ Mencerahkan kulit dan membantu memperbaiki skin barrier.';
            } elseif(str_contains($name, 'lip')) {
                $desc = '💋 Membuat bibir lebih lembab dan sehat alami.';
            } elseif(str_contains($name, 'masker')) {
                $desc = '🧖‍♀️ Membersihkan pori-pori dan mengangkat kotoran.';
            } elseif(str_contains($name, 'toner')) {
                $desc = '💧 Menyeimbangkan pH kulit sebelum skincare.';
            } else {
                $desc = '💄 Produk kecantikan premium untuk perawatan kulit harian.';
            }

        @endphp

        <div class="col-6 col-md-4 product-item">

            <div class="card h-100">

                <div class="img-wrapper">

                    @if($item->image)

                    <a href="/products/{{ $item->id }}">
                        <img src="{{ asset('storage/' . $item->image) }}"
                             class="product-img">
                    </a>

                    @else

                    <a href="/products/{{ $item->id }}">
                        <img src="https://via.placeholder.com/300x200?text=No+Image"
                             class="product-img">
                    </a>

                    @endif

                    <div class="stock-badge">
                        Stock {{ $item->stock }}
                    </div>

                </div>

                <div class="card-body d-flex flex-column">

                    <h5 class="product-name">
                        <a href="/products/{{ $item->id }}" class="text-decoration-none text-dark hover-pink">
                            {{ $item->name }}
                        </a>
                    </h5>

                    <div class="price">
                        Rp {{ number_format($item->price,0,',','.') }}
                    </div>

                    <span class="category">
                        {{ $item->category->name ?? '-' }}
                    </span>

                    <div class="detail-box">
                        {{ $desc }}
                    </div>

                    <div class="divider"></div>

                    @if(auth()->check() && auth()->user()->role === 'admin')

                    <div class="d-flex flex-column flex-md-row gap-1 gap-md-2 mb-3">

                        <a href="/products/{{ $item->id }}/edit"
                           class="btn btn-warning w-100">

                            Edit

                        </a>

                        <form action="/products/{{ $item->id }}"
                              method="POST"
                              class="w-100">

                            @csrf
                            @method('DELETE')

                            <button class="btn btn-outline-danger w-100">
                                Hapus
                            </button>

                        </form>

                    </div>

                    @endif

                    <!-- Quantity Input -->
                    <div class="mb-2 d-flex align-items-center justify-content-between gap-1 flex-wrap">
                        <div class="d-flex align-items-center gap-1">
                            <label for="qty_{{ $item->id }}" class="form-label mb-0 text-muted d-none d-sm-inline" style="font-size: 0.75rem;">Qty:</label>
                            <input type="number" id="qty_{{ $item->id }}" value="{{ $item->stock > 0 ? 1 : 0 }}" min="{{ $item->stock > 0 ? 1 : 0 }}" max="{{ $item->stock }}" class="form-control form-control-sm text-center py-0 px-1" style="width: 50px; font-size: 0.8rem; font-weight: bold; height: 26px;" oninput="document.getElementById('hidden_qty_{{ $item->id }}').value = this.value" {{ $item->stock == 0 ? 'disabled' : '' }}>
                        </div>
                        @if($item->stock > 0)
                            <span class="text-muted" style="font-size: 0.7rem; font-weight: 500;">Sisa: {{ $item->stock }}</span>
                        @else
                            <span class="text-danger fw-bold" style="font-size: 0.7rem;">Habis</span>
                        @endif
                    </div>

                    <div class="d-flex flex-column flex-md-row gap-2 mt-auto">

                        <form action="/cart/add"
                              method="POST"
                              class="w-100 w-md-50">

                            @csrf

                            <input type="hidden"
                                   name="product_id"
                                   value="{{ $item->id }}">

                            <input type="hidden"
                                   id="hidden_qty_{{ $item->id }}"
                                   name="qty"
                                   value="{{ $item->stock > 0 ? 1 : 0 }}">

                            <button class="btn btn-outline-primary w-100" {{ $item->stock == 0 ? 'disabled' : '' }}>
                                + Keranjang
                            </button>

                        </form>

                        <button onclick="checkout({{ $item->id }}, {{ $item->discounted_price }}, document.getElementById('qty_{{ $item->id }}').value)"
                                class="btn btn-success w-100 w-md-50" {{ $item->stock == 0 ? 'disabled' : '' }}>

                            Beli

                        </button>

                    </div>

                </div>

            </div>

        </div>

        @endforeach

    </div>

    <!-- EMPTY -->
    <div class="empty-box" id="emptyBox">

        <h3 class="fw-bold">
            😢 Produk tidak ditemukan
        </h3>

        <p class="text-muted mt-2">
            Coba cari dengan kata kunci lain
        </p>

    </div>

</div>



<!-- MIDTRANS -->
<script src="https://app.sandbox.midtrans.com/snap/snap.js"
data-client-key="{{ config('midtrans.clientKey') }}">
</script>

<script>

function checkout(productId, price, qty = 1) {

    qty = parseInt(qty);
    const totalPrice = price * qty;

    fetch('/checkout', {

        method:'POST',

        headers:{
            'Content-Type':'application/json',
            'X-CSRF-TOKEN':'{{ csrf_token() }}'
        },

        body:JSON.stringify({

            address_id:1,

            total:totalPrice,

            items:[
                {
                    id:productId,
                    qty:qty,
                    price:price
                }
            ]

        })

    })

    .then(res => res.json())

    .then(data => {

        if(!data.snap_token){

            alert('Checkout gagal');

            return;
        }

        snap.pay(data.snap_token, {

            onSuccess:() => window.location.href='/payment-success',

            onPending:() => window.location.href='/transactions',

            onError:() => alert('Pembayaran gagal!'),

            onClose:() => window.location.href='/transactions'

        });

    });

}



/* SEARCH */

const searchInput = document.getElementById('searchInput');

searchInput.addEventListener('keyup', function(){

    let keyword = this.value.toLowerCase();

    let items = document.querySelectorAll('.product-item');

    let visible = 0;

    items.forEach(item => {

        let text = item.innerText.toLowerCase();

        if(text.includes(keyword)){

            item.style.display = 'block';

            visible++;

        } else {

            item.style.display = 'none';

        }

    });

    if(visible == 0){

        document.getElementById('emptyBox').style.display = 'block';

    } else {

        document.getElementById('emptyBox').style.display = 'none';

    }

});

</script>

</body>
</html>
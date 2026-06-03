<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Keranjang Belanja - GlowBeauty</title>
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
        .btn-primary {
            background: linear-gradient(135deg, #ff6fa9, #ff2e7e);
            color: white;
            box-shadow: 0 4px 15px rgba(255, 46, 126, 0.25);
            transition: all 0.3s ease;
        }
        .btn-primary:hover {
            box-shadow: 0 6px 20px rgba(255, 46, 126, 0.45);
            transform: translateY(-2px);
        }
    </style>
</head>
<body class="flex flex-col min-h-screen">

    <!-- NAVBAR -->
    <div class="bg-white/70 backdrop-blur-md border-b border-pink-100/50 shadow-sm sticky top-0 z-50">
        <div class="container mx-auto px-4 py-4 flex justify-between items-center max-w-6xl">
            <a href="/" class="serif-font font-bold text-2xl text-pink-600 flex items-center gap-2 hover:opacity-85 transition">
                GlowBeauty
            </a>
            <a href="/" class="text-xs font-bold text-pink-500 hover:text-pink-600 flex items-center gap-1.5 transition">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                Kembali Belanja
            </a>
        </div>
    </div>

    <!-- CONTENT -->
    <div class="flex-grow container mx-auto px-4 py-12 max-w-6xl">
        <h2 class="text-3xl md:text-4xl font-bold mb-8 serif-font text-gray-800">Keranjang Belanja</h2>

        @if(session('success'))
            <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-2xl relative mb-6 text-sm">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-2xl relative mb-6 text-sm">
                {{ session('error') }}
            </div>
        @endif

        <div class="flex flex-col lg:flex-row gap-8">
            <!-- CART ITEMS -->
            <div class="w-full lg:w-2/3">
                @php 
                    $totalPrice = 0; 
                    $hasPreorder = false;
                @endphp

                @if($cart && $cart->items->count() > 0)
                    @foreach($cart->items as $item)
                        @php 
                            $totalPrice += ($item->product->price * $item->qty); 
                            if($item->product->is_preorder) $hasPreorder = true;
                        @endphp
                        <div class="bg-white/80 backdrop-blur rounded-2xl shadow-sm border border-pink-100/50 p-6 mb-4 flex flex-col sm:flex-row gap-6">
                            <!-- Image -->
                            <div class="w-full sm:w-32 h-32 rounded-xl bg-pink-50/50 overflow-hidden flex-shrink-0 flex items-center justify-center border border-pink-100/20">
                                @if($item->product->image)
                                    <img src="{{ Storage::url($item->product->image) }}" class="w-full h-full object-cover">
                                @else
                                    <div class="text-4xl">💄</div>
                                @endif
                            </div>

                            <!-- Details -->
                            <div class="flex-grow flex flex-col">
                                <div class="flex justify-between items-start mb-2 gap-4">
                                    <h3 class="text-lg font-bold serif-font text-gray-800 flex items-center gap-2">
                                        {{ $item->product->name }}
                                    </h3>
                                    <div class="text-right">
                                        <div class="font-bold text-pink-600 whitespace-nowrap text-base">Rp {{ number_format($item->product->price, 0, ',', '.') }}</div>
                                    </div>
                                </div>
                                
                                @if($item->box_color || $item->greeting_card)
                                    <div class="bg-pink-50/30 border border-pink-100/30 rounded-xl p-3 mb-4 text-xs text-gray-600">
                                        @if($item->box_color) <p class="mb-0.5"><strong>Gift Box:</strong> {{ $item->box_color }}</p> @endif
                                        @if($item->greeting_card) <p class="mb-0.5"><strong>Kartu:</strong> {{ $item->greeting_card }}</p> @endif
                                        @if($item->custom_message) <p class="italic mt-1 text-gray-500 font-medium">"{{ $item->custom_message }}"</p> @endif
                                    </div>
                                @endif

                                @if($item->product->is_preorder)
                                    <div class="text-[11px] font-bold text-rose-500 mb-4 tracking-wide uppercase flex items-center gap-1">
                                        ⏱️ Pre-Order (Estimasi {{ $item->product->preorder_days }} hari)
                                    </div>
                                @endif

                                <div class="flex items-center justify-between mt-auto pt-4 border-t border-pink-50/40">
                                    <form action="/cart/update/{{ $item->id }}" method="POST" class="flex items-center gap-2">
                                        @csrf
                                        <input type="number" name="qty" value="{{ $item->qty }}" min="1" max="{{ $item->product->stock }}" class="w-16 text-center border border-pink-100 rounded-lg py-1 text-sm font-bold bg-white focus:outline-none focus:ring-1 focus:ring-pink-500">
                                        <button type="submit" class="text-xs font-bold text-pink-500 hover:text-pink-600 transition">Update</button>
                                    </form>

                                    <form action="/cart/remove/{{ $item->id }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-xs font-bold text-gray-400 hover:text-red-500 transition flex items-center gap-1">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                            Hapus
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @else
                    <div class="bg-white/80 backdrop-blur rounded-3xl shadow-sm border border-pink-100/50 p-12 text-center">
                        <div class="text-6xl mb-4">🛍️</div>
                        <h3 class="text-2xl font-bold mb-2 serif-font">Keranjang Kosong</h3>
                        <p class="text-gray-500 text-xs mb-6 max-w-xs mx-auto">Anda belum menambahkan kosmetik apapun ke keranjang belanja Anda.</p>
                        <a href="/" class="btn-primary px-8 py-3 rounded-full font-bold inline-block text-xs">Cari Kosmetik</a>
                    </div>
                @endif
            </div>

            <!-- SUMMARY -->
            <div class="w-full lg:w-1/3">
                <div class="bg-white/80 backdrop-blur rounded-3xl shadow-sm border border-pink-100/50 p-6 sticky top-24">
                    <h3 class="text-xl font-bold mb-6 serif-font text-gray-800">Ringkasan Belanja</h3>
                    
                    @php
                        $promoBannerActive = \App\Models\Setting::where('key', 'promo_banner_active')->value('value') == '1';
                        $globalDiscount = \App\Models\Setting::where('key', 'global_discount_percentage')->value('value') ?? 0;
                        $discountAmount = 0;
                        
                        if ($promoBannerActive && $globalDiscount > 0) {
                            $discountAmount = $totalPrice * ($globalDiscount / 100);
                        }
                        
                        $finalPrice = $totalPrice - $discountAmount;
                    @endphp

                    <div class="flex justify-between mb-4 text-sm text-gray-500 font-medium">
                        <span>Subtotal Harga</span>
                        <span class="font-bold text-gray-800 text-base">Rp {{ number_format($totalPrice, 0, ',', '.') }}</span>
                    </div>

                    @if($discountAmount > 0)
                    <div class="flex justify-between mb-4 text-sm text-pink-500 font-medium bg-pink-50 p-3 rounded-xl border border-pink-100">
                        <span>Diskon Promo ({{ rtrim(rtrim(number_format($globalDiscount, 2), '0'), '.') }}%)</span>
                        <span class="font-bold text-pink-600 text-base">-Rp {{ number_format($discountAmount, 0, ',', '.') }}</span>
                    </div>
                    @endif

                    <div class="flex justify-between mb-4 text-lg text-gray-800 font-bold border-t border-pink-50 pt-4">
                        <span>Total Bayar</span>
                        <span class="font-extrabold text-pink-600 text-xl">Rp {{ number_format($finalPrice, 0, ',', '.') }}</span>
                    </div>

                    @if($hasPreorder)
                        <hr class="border-pink-50 my-4">
                        <div class="mb-4">
                            <label class="block text-xs font-bold uppercase tracking-wider mb-2 text-gray-500">Pilih Tanggal Pengiriman (Pre-Order)</label>
                            <input type="date" id="delivery_date" class="w-full px-4 py-2 text-sm border border-pink-100 rounded-xl focus:outline-none focus:ring-2 focus:ring-pink-500 bg-white">
                            <p class="text-[10px] text-gray-400 mt-1.5 leading-relaxed">Keranjang Anda berisi produk pre-order. Silakan tentukan tanggal pengiriman yang diinginkan.</p>
                        </div>
                    @endif

                    <hr class="border-pink-50 my-6">

                    @if($cart && $cart->items->count() > 0)
                        <button onclick="checkoutCart()" class="w-full btn-primary py-4 rounded-xl font-bold text-sm text-center shadow-lg uppercase tracking-wider">
                            Checkout Sekarang
                        </button>
                    @else
                        <button class="w-full bg-gray-100 text-gray-400 py-4 rounded-xl font-bold text-sm text-center cursor-not-allowed uppercase tracking-wider" disabled>
                            Checkout Sekarang
                        </button>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Midtrans Snap -->
    <script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ config('midtrans.clientKey') }}"></script>
    
    <script>
    function checkoutCart() {
        const payload = {
            address_id: 1 // Default
        };

        @if($hasPreorder)
        const dateInput = document.getElementById('delivery_date').value;
        if(!dateInput) {
            alert('Mohon pilih tanggal pengiriman untuk produk Pre-Order Anda.');
            return;
        }
        payload.delivery_date = dateInput;
        @endif

        fetch('/cart/checkout', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify(payload)
        })
        .then(res => res.json())
        .then(data => {
            if(data.snap_token) {
                snap.pay(data.snap_token, {
                    onSuccess: function(result) {
                        window.location.href = '/payment-success';
                    },
                    onPending: function(result) {
                        window.location.href = '/transactions';
                    },
                    onError: function(result) {
                        alert('Pembayaran gagal!');
                    },
                    onClose: function() {
                        window.location.href = '/transactions'
                    }
                });
            } else {
                alert(data.error || 'Terjadi kesalahan saat checkout.');
            }
        })
        .catch(err => {
            console.error(err);
            alert('Checkout gagal! Pastikan server berjalan dengan baik.');
        });
    }
    </script>
</body>
</html>

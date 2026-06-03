<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $product->name }} - GlowBeauty</title>
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

        /* Custom Radio Button for Colors */
        .color-radio {
            display: none;
        }
        .color-label {
            display: inline-block;
            width: 40px;
            height: 40px;
            border-radius: 50%;
            cursor: pointer;
            border: 2px solid transparent;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
            transition: all 0.2s;
        }
        .color-radio:checked + .color-label {
            border-color: #ff2e7e;
            transform: scale(1.1);
            box-shadow: 0 4px 10px rgba(255,46,126,0.3);
        }

        /* Custom Radio for Cards */
        .card-radio {
            display: none;
        }
        .card-label {
            display: block;
            border: 2px solid #f3e8ee;
            border-radius: 0.75rem;
            padding: 1rem;
            cursor: pointer;
            transition: all 0.2s;
            text-align: center;
            background: rgba(255, 255, 255, 0.6);
        }
        .card-radio:checked + .card-label {
            border-color: #ff2e7e;
            background-color: rgba(255, 46, 126, 0.05);
            box-shadow: 0 4px 15px rgba(255, 105, 180, 0.08);
        }
    </style>
</head>
<body class="flex flex-col min-h-screen">

    <!-- NAVBAR -->
    <div class="bg-white/70 backdrop-blur-md border-b border-pink-100/50 shadow-sm sticky top-0 z-50">
        <div class="container mx-auto px-4 py-4 flex justify-between items-center max-w-6xl">
            <a href="/" class="serif-font font-bold text-2xl text-pink-600 flex items-center gap-2 hover:opacity-85 transition">
                <svg class="w-6 h-6 text-pink-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                GlowBeauty
            </a>
            <div class="flex items-center gap-4">
                @auth
                    <a href="/cart" class="w-10 h-10 rounded-full flex items-center justify-center bg-pink-50 hover:bg-pink-100 transition relative">
                        <span class="text-xl">🛒</span>
                        @php
                            $cart = \App\Models\Cart::where('user_id', auth()->id())->first();
                            $cartCount = $cart ? $cart->items()->sum('qty') : 0;
                        @endphp
                        @if($cartCount > 0)
                            <span class="absolute -top-1 -right-1 bg-pink-600 text-white text-[10px] font-bold w-5 h-5 rounded-full flex items-center justify-center border-2 border-white">
                                {{ $cartCount }}
                            </span>
                        @endif
                    </a>
                @endauth
            </div>
        </div>
    </div>

    <!-- MAIN CONTENT -->
    <div class="flex-grow container mx-auto px-4 py-6 md:py-12 max-w-6xl">
        <div class="bg-white/80 backdrop-blur-md rounded-3xl shadow-xl border border-pink-100/50 overflow-hidden flex flex-col md:flex-row">
            
            <!-- IMAGE SECTION -->
            <div class="w-full md:w-1/2 bg-gradient-to-tr from-pink-50 to-pink-100/30 relative p-6 sm:p-8 flex items-center justify-center min-h-[300px] md:min-h-[350px]">
                @if($product->image)
                    <img src="{{ Storage::url($product->image) }}" class="rounded-2xl shadow-lg w-full h-auto object-cover max-h-[400px] md:max-h-[500px]" alt="{{ $product->name }}">
                @else
                    <div class="w-40 h-40 md:w-48 md:h-48 rounded-full bg-pink-100/50 flex items-center justify-center text-6xl md:text-7xl shadow-inner">
                        💄
                    </div>
                @endif

                @if($product->is_preorder)
                    <div class="absolute top-4 left-4 md:top-6 md:left-6 bg-gradient-to-r from-pink-600 to-rose-500 text-white font-bold px-3 py-1.5 md:px-4 md:py-2 rounded-full shadow-md text-[10px] md:text-xs tracking-wider uppercase">
                        PO {{ $product->preorder_days }} Hari
                    </div>
                @endif
            </div>

            <!-- DETAILS SECTION -->
            <div class="w-full md:w-1/2 p-6 sm:p-8 md:p-12">
                <div class="text-xs text-pink-500 font-bold tracking-widest uppercase mb-2">
                    {{ $product->category->name ?? 'Cosmetics' }}
                </div>
                <h1 class="text-2xl sm:text-3xl md:text-4xl lg:text-5xl font-bold text-gray-800 mb-4 serif-font leading-tight">{{ $product->name }}</h1>
                
                <!-- Ratings display to look real -->
                <div class="flex items-center gap-2 mb-6">
                    <div class="flex text-amber-400 text-sm">★★★★★</div>
                    <span class="text-xs font-bold text-gray-700">4.9</span>
                    <span class="text-xs text-gray-400 font-semibold">(124+ ulasan)</span>
                </div>

                <div class="text-2xl md:text-3xl font-extrabold text-pink-600 mb-6">
                    Rp {{ number_format($product->price, 0, ',', '.') }}
                </div>
                
                <p class="text-gray-500 text-sm leading-relaxed mb-8">
                    {{ $product->description }}
                </p>

                <hr class="border-pink-50 mb-8">

                <form action="/cart/add" method="POST">
                    @csrf
                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                    
                    @if($product->is_custom)
                        <div class="mb-8">
                            <h3 class="text-xl font-bold mb-4 serif-font text-gray-800">Custom Kemasan Kado Premium</h3>
                            
                            <!-- Box Color -->
                            <div class="mb-6">
                                <label class="block text-xs font-bold uppercase tracking-wider mb-3 text-gray-500">Pilih Warna Gift Box</label>
                                <div class="flex gap-4">
                                    <input type="radio" name="box_color" id="color_gold" value="Gold Premium" class="color-radio" checked>
                                    <label for="color_gold" class="color-label bg-amber-400 border border-white" title="Gold Premium"></label>
                                    
                                    <input type="radio" name="box_color" id="color_rose" value="Rose Pink" class="color-radio">
                                    <label for="color_rose" class="color-label bg-pink-300 border border-white" title="Rose Pink"></label>

                                    <input type="radio" name="box_color" id="color_black" value="Elegant Black" class="color-radio">
                                    <label for="color_black" class="color-label bg-gray-900 border border-white" title="Elegant Black"></label>
                                </div>
                            </div>

                            <!-- Greeting Card -->
                            <div class="mb-6">
                                <label class="block text-xs font-bold uppercase tracking-wider mb-3 text-gray-500">Pilih Kartu Ucapan</label>
                                <div class="grid grid-cols-2 md:grid-cols-3 gap-3">
                                    <div>
                                        <input type="radio" name="greeting_card" id="card_hbd" value="Happy Birthday" class="card-radio" checked>
                                        <label for="card_hbd" class="card-label text-xs font-medium text-gray-700">🎂 <br><span class="inline-block mt-1 font-bold">Ulang Tahun</span></label>
                                    </div>
                                    <div>
                                        <input type="radio" name="greeting_card" id="card_grad" value="Happy Graduation" class="card-radio">
                                        <label for="card_grad" class="card-label text-xs font-medium text-gray-700">🎓 <br><span class="inline-block mt-1 font-bold">Wisuda</span></label>
                                    </div>
                                    <div>
                                        <input type="radio" name="greeting_card" id="card_wedding" value="Happy Wedding" class="card-radio">
                                        <label for="card_wedding" class="card-label text-xs font-medium text-gray-700">💍 <br><span class="inline-block mt-1 font-bold">Pernikahan</span></label>
                                    </div>
                                    <div>
                                        <input type="radio" name="greeting_card" id="card_baby" value="Welcome Baby" class="card-radio">
                                        <label for="card_baby" class="card-label text-xs font-medium text-gray-700">🍼 <br><span class="inline-block mt-1 font-bold">Kelahiran</span></label>
                                    </div>
                                    <div>
                                        <input type="radio" name="greeting_card" id="card_blank" value="Blank Card" class="card-radio">
                                        <label for="card_blank" class="card-label text-xs font-medium text-gray-700">📝 <br><span class="inline-block mt-1 font-bold">Kartu Polos</span></label>
                                    </div>
                                </div>
                            </div>

                            <!-- Custom Message -->
                            <div class="mb-6">
                                <label class="block text-xs font-bold uppercase tracking-wider mb-2 text-gray-500">Pesan Custom (Maks 150 Karakter)</label>
                                <textarea name="custom_message" rows="3" maxlength="150" placeholder="Tulis ucapan personal Anda di sini..." class="w-full px-4 py-3 rounded-xl border border-pink-100 focus:outline-none focus:ring-2 focus:ring-pink-500 bg-white/50 text-sm"></textarea>
                            </div>
                        </div>
                    @endif

                    <!-- Quantity -->
                    <div class="mb-8">
                        <label class="block text-xs font-bold uppercase tracking-wider mb-2 text-gray-500">Jumlah</label>
                        <div class="flex items-center gap-4">
                            <input type="number" name="qty" value="1" min="1" max="{{ $product->stock }}" class="w-24 px-4 py-3 rounded-xl border border-pink-100 text-center text-lg font-bold focus:outline-none focus:ring-2 focus:ring-pink-500 bg-white/50">
                            @if($product->stock > 0)
                                <span class="text-xs text-gray-400 font-semibold">Tersisa: {{ $product->stock }} unit</span>
                            @else
                                <span class="text-xs text-red-500 font-bold">Stok habis!</span>
                            @endif
                        </div>
                    </div>

                    @auth
                        @if($product->stock > 0)
                            <button type="submit" class="w-full py-4 btn-primary font-bold rounded-xl text-sm flex items-center justify-center gap-2">
                                <span class="text-lg">🛒</span>
                                Tambahkan ke Keranjang
                            </button>

                            <button type="button" onclick="buyNow({{ $product->id }}, {{ $product->discounted_price }})" class="w-full mt-3 py-4 bg-emerald-600 hover:bg-emerald-700 text-white font-bold rounded-xl text-sm flex items-center justify-center gap-2 shadow-lg transition duration-200">
                                <span class="text-lg">⚡</span>
                                Beli Sekarang
                            </button>
                        @else
                            <button class="w-full py-4 bg-gray-200 text-gray-400 font-bold rounded-xl text-sm cursor-not-allowed" disabled>
                                Stok Habis
                            </button>
                        @endif
                    @else
                        <a href="/login" class="block w-full py-4 text-center border-2 border-pink-500 text-pink-500 font-bold rounded-xl text-sm hover:bg-pink-500 hover:text-white transition">
                            Login untuk Membeli
                        </a>
                    @endauth
                </form>

            </div>
        </div>
    </div>

    <!-- Midtrans Snap -->
    <script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ config('midtrans.clientKey') }}"></script>

    <script>
    function buyNow(productId, price) {
        // Ambil qty
        const qtyInput = document.getElementsByName('qty')[0];
        const qty = qtyInput ? parseInt(qtyInput.value) : 1;

        // Ambil custom options
        let boxColor = null;
        let greetingCard = null;
        let customMessage = null;

        const boxColorActive = document.querySelector('input[name="box_color"]:checked');
        if (boxColorActive) boxColor = boxColorActive.value;

        const greetingCardActive = document.querySelector('input[name="greeting_card"]:checked');
        if (greetingCardActive) greetingCard = greetingCardActive.value;

        const customMessageActive = document.querySelector('textarea[name="custom_message"]');
        if (customMessageActive) customMessage = customMessageActive.value;

        const totalPrice = price * qty;

        fetch('/checkout', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({
                address_id: 1, // Default
                total: totalPrice,
                items: [
                    {
                        id: productId,
                        qty: qty,
                        price: price,
                        box_color: boxColor,
                        greeting_card: greetingCard,
                        custom_message: customMessage
                    }
                ]
            })
        })
        .then(res => res.json())
        .then(data => {
            if (!data.snap_token) {
                alert(data.error || 'Checkout gagal');
                return;
            }
            snap.pay(data.snap_token, {
                onSuccess: () => window.location.href = '/payment-success',
                onPending: () => window.location.href = '/transactions',
                onError: () => alert('Pembayaran gagal!'),
                onClose: () => window.location.href = '/transactions'
            });
        })
        .catch(err => {
            console.error(err);
            alert('Terjadi kesalahan saat checkout.');
        });
    }
    </script>

</body>
</html>

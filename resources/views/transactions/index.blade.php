<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Riwayat Transaksi - GlowBeauty</title>

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

<body class="flex flex-col min-h-screen pb-12">

    <!-- Navbar -->
    <nav class="bg-white/70 backdrop-blur-md border-b border-pink-100/50 sticky top-0 z-50">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-3 md:py-4 flex justify-between items-center">

            <div class="flex items-center gap-2 md:gap-3">
                <span class="text-xl md:text-2xl">📦</span>
                <h1 class="text-lg md:text-xl font-bold serif-font text-gray-800">
                    Riwayat Pesanan
                </h1>
            </div>

            <a href="javascript:history.back()"
               class="text-xs font-bold text-pink-500 hover:text-pink-600 transition flex items-center gap-1.5">

                <svg class="w-4 h-4"
                     fill="none"
                     stroke="currentColor"
                     viewBox="0 0 24 24">

                    <path stroke-linecap="round"
                          stroke-linejoin="round"
                          stroke-width="2"
                          d="M10 19l-7-7m0 0l7-7m-7 7h18">
                    </path>
                </svg>

                Kembali
            </a>

        </div>
    </nav>

    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 mt-10 flex-grow w-full">

        <!-- BUTTON PDF EXCEL -->
        <div class="flex flex-wrap gap-4 mb-8">

            <a href="{{ url('/transactions/pdf') }}"
               class="bg-red-500 hover:bg-red-600 text-white px-5 py-3 rounded-2xl text-xs font-bold shadow-lg transition duration-300">

                📄 Cetak PDF
            </a>

            <a href="{{ url('/transactions/excel') }}"
               class="bg-green-500 hover:bg-green-600 text-white px-5 py-3 rounded-2xl text-xs font-bold shadow-lg transition duration-300">

                📊 Export Excel
            </a>

        </div>

        @if(session('success'))

        <div class="mb-6 bg-green-50 border border-green-200 text-green-700 p-4 rounded-2xl flex items-center text-sm shadow-sm">

            <svg class="w-5 h-5 mr-3 flex-shrink-0"
                 fill="currentColor"
                 viewBox="0 0 20 20">

                <path fill-rule="evenodd"
                      d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                      clip-rule="evenodd">
                </path>

            </svg>

            <span class="font-semibold">
                {{ session('success') }}
            </span>

        </div>

        @endif

        @if($transactions->isEmpty())

            <div class="bg-white/80 backdrop-blur rounded-3xl p-12 text-center border border-pink-100/50 shadow-sm mt-10">

                <div class="inline-flex items-center justify-center w-20 h-20 bg-pink-50 rounded-full mb-6">
                    <span class="text-4xl">🛍️</span>
                </div>

                <h2 class="text-2xl font-bold text-gray-800 mb-2 serif-font">
                    Belum Ada Transaksi
                </h2>

                <p class="text-gray-500 text-xs mb-8 max-w-xs mx-auto">
                    Anda belum pernah melakukan pembelian produk kecantikan.
                </p>

                <a href="/"
                   class="btn-primary inline-block font-bold py-3 px-8 rounded-full text-xs tracking-wider uppercase shadow-lg">

                    Lihat Katalog Produk
                </a>

            </div>

        @else

            <div class="space-y-6">

                @foreach($transactions as $trx)

                <div class="bg-white/80 backdrop-blur rounded-3xl border border-pink-100/50 shadow overflow-hidden">

                    <!-- Header -->
                    <div class="bg-pink-50/20 border-b border-pink-50/40 px-6 py-4 flex justify-between items-center">

                        <div>

                             <div class="text-xs font-bold text-pink-600 hover:text-pink-700 hover:underline">
                                 <a href="{{ route('transaction.show', $trx->id) }}">
                                     Order: {{ $trx->midtrans_order_id ?? 'TRX-'.$trx->id }}
                                 </a>
                             </div>

                            <div class="text-[11px] text-gray-400 mt-1">
                                {{ $trx->created_at->format('d M Y H:i') }}
                            </div>

                        </div>

                        <div>

                             @if($trx->status == 'pending')
                                 <span class="bg-yellow-100 text-yellow-600 px-4 py-2 rounded-full text-xs font-bold uppercase">
                                     PENDING
                                 </span>
                             @elseif($trx->status == 'paid')
                                 <span class="bg-pink-100 text-pink-600 px-4 py-2 rounded-full text-xs font-bold uppercase">
                                     DIPROSES (LUNAS)
                                 </span>
                             @elseif($trx->status == 'confirmed')
                                 <span class="bg-yellow-100 text-yellow-700 px-4 py-2 rounded-full text-xs font-bold uppercase tracking-wider">
                                     SIAP DIKIRIM
                                 </span>
                             @elseif($trx->status == 'shipped')
                                 <span class="bg-blue-100 text-blue-700 px-4 py-2 rounded-full text-xs font-bold uppercase">
                                     DIKIRIM
                                 </span>
                             @elseif($trx->status == 'delivered')
                                 <span class="bg-emerald-100 text-emerald-700 px-4 py-2 rounded-full text-xs font-bold uppercase">
                                     TERKIRIM
                                 </span>
                             @elseif($trx->status == 'completed')
                                 <span class="bg-green-100 text-green-700 px-4 py-2 rounded-full text-xs font-bold uppercase">
                                     SELESAI
                                 </span>
                             @elseif($trx->status == 'returned')
                                 <span class="bg-red-100 text-red-600 px-4 py-2 rounded-full text-xs font-bold uppercase">
                                     DIKEMBALIKAN
                                 </span>
                             @else
                                 <span class="bg-red-100 text-red-600 px-4 py-2 rounded-full text-xs font-bold uppercase">
                                     GAGAL
                                 </span>
                             @endif
                         </div>

                     </div>

                     <!-- Body -->
                     <div class="px-6 py-6 space-y-5">

                         @foreach($trx->items as $item)

                         <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 py-4 border-b border-pink-100/30 last:border-b-0">

                             <div class="flex items-start gap-4">

                                 @if(isset($item->product->image))
                                     <img src="{{ asset('storage/' . $item->product->image) }}"
                                          class="w-14 h-14 rounded-xl object-cover border flex-shrink-0">
                                 @endif

                                 <div>
                                     <div class="font-bold text-sm text-gray-800">
                                         {{ $item->product->name ?? 'Produk dihapus' }}
                                     </div>

                                     <div class="text-xs text-gray-400 mt-1">
                                         {{ $item->qty }} x Rp {{ number_format($item->price,0,',','.') }}
                                     </div>

                                     @if($item->box_color || $item->greeting_card || $item->custom_message)
                                         <div class="bg-pink-50/50 border border-pink-100/20 rounded-xl p-2.5 mt-2 text-[11px] text-gray-600 max-w-md">
                                             @if($item->box_color) <p class="mb-0.5"><strong>Gift Box:</strong> {{ $item->box_color }}</p> @endif
                                             @if($item->greeting_card) <p class="mb-0.5"><strong>Kartu:</strong> {{ $item->greeting_card }}</p> @endif
                                             @if($item->custom_message) <p class="italic mt-1 text-gray-500 font-medium">"{{ $item->custom_message }}"</p> @endif
                                         </div>
                                     @endif
                                 </div>

                             </div>

                             <div class="flex items-center justify-between sm:justify-end gap-6 w-full sm:w-auto">
                                 <div class="font-bold text-pink-600 text-sm">
                                     Rp {{ number_format($item->price * $item->qty,0,',','.') }}
                                 </div>

                                 <!-- Item Action / Status Badge -->
                                 <div class="flex items-center gap-2">
                                     @if(auth()->check() && auth()->id() === $trx->user_id && $trx->status == 'delivered')
                                         @if($item->status == 'pending')
                                             <div class="flex gap-1.5">
                                                 <form action="{{ route('user.item.return', $item->id) }}" method="POST" class="inline">
                                                     @csrf
                                                     <button type="submit" onclick="return confirm('Apakah Anda yakin ingin mengembalikan produk ini?')" class="bg-red-50 hover:bg-red-100 text-red-600 border border-red-200 font-semibold px-2.5 py-1.5 rounded-lg text-[10px] uppercase tracking-wider transition duration-150">
                                                         Kembalikan
                                                     </button>
                                                 </form>
                                                 <form action="{{ route('user.item.received', $item->id) }}" method="POST" class="inline">
                                                     @csrf
                                                     <button type="submit" class="bg-green-50 hover:bg-green-100 text-green-700 border border-green-200 font-semibold px-2.5 py-1.5 rounded-lg text-[10px] uppercase tracking-wider transition duration-150">
                                                         Diterima
                                                     </button>
                                                 </form>
                                             </div>
                                         @elseif($item->status == 'completed')
                                             <span class="bg-green-100 text-green-700 border border-green-200 px-2.5 py-1 rounded-lg text-[10px] font-bold uppercase">
                                                 Diterima
                                             </span>
                                         @elseif($item->status == 'returned')
                                             <span class="bg-red-100 text-red-600 border border-red-200 px-2.5 py-1 rounded-lg text-[10px] font-bold uppercase">
                                                 Dikembalikan
                                             </span>
                                         @endif
                                     @else
                                         @if($trx->status == 'shipped')
                                             <span class="bg-blue-50 text-blue-600 border border-blue-200 px-2.5 py-1 rounded-lg text-[10px] font-bold uppercase">
                                                 Sedang Diantar
                                             </span>
                                         @elseif($item->status == 'completed')
                                             <span class="bg-green-100 text-green-700 border border-green-200 px-2.5 py-1 rounded-lg text-[10px] font-bold uppercase">
                                                 Diterima
                                             </span>
                                         @elseif($item->status == 'returned')
                                             <span class="bg-red-100 text-red-600 border border-red-200 px-2.5 py-1 rounded-lg text-[10px] font-bold uppercase">
                                                 Dikembalikan
                                             </span>
                                         @endif
                                     @endif
                                 </div>
                             </div>

                         </div>

                         @endforeach

                         @if($trx->tracking_number || $trx->delivery_date || $trx->proof_of_delivery)
                             <div class="mt-5 pt-5 border-t border-pink-50/40 space-y-3 bg-pink-50/10 -mx-6 -mb-6 p-6">
                                 <h4 class="text-xs font-bold uppercase tracking-wider text-pink-600">Info Pengiriman</h4>
                                 
                                 @if($trx->tracking_number)
                                     <div class="text-xs text-gray-600 flex items-center gap-2">
                                         <span>🚚</span> 
                                         <span>No. Resi:</span> 
                                         <strong class="text-gray-800 font-mono bg-white px-2 py-0.5 rounded border border-pink-100">{{ $trx->tracking_number }}</strong>
                                     </div>
                                 @endif
                                 
                                 @if($trx->delivery_date)
                                     <div class="text-xs text-gray-600 flex items-center gap-2">
                                         <span>📅</span> 
                                         <span>Rencana Kirim:</span> 
                                         <span class="text-gray-800 font-semibold">{{ \Carbon\Carbon::parse($trx->delivery_date)->translatedFormat('d F Y') }}</span>
                                     </div>
                                 @endif

                                 @if($trx->proof_of_delivery)
                                     <div class="text-xs text-gray-600 space-y-2">
                                         <div class="flex items-center gap-2">
                                             <span>📷</span> 
                                             <span>Bukti Penerimaan:</span>
                                         </div>
                                         <div class="pl-6">
                                             <img src="{{ Storage::url($trx->proof_of_delivery) }}" class="w-32 h-32 object-cover rounded-xl border border-pink-100 hover:scale-105 transition duration-200 cursor-pointer shadow-sm" onclick="window.open('{{ Storage::url($trx->proof_of_delivery) }}')">
                                         </div>
                                     </div>
                                 @endif
                             </div>
                         @endif

                     </div>

                     <!-- Footer -->
                     <div class="bg-pink-50/10 border-t border-pink-50/30 px-6 py-4 flex flex-col sm:flex-row justify-between sm:items-center gap-4">

                         <div class="flex justify-between items-center flex-grow sm:flex-grow-0 sm:gap-6">
                             <span class="text-xs font-bold text-gray-500 uppercase">
                                 Total
                             </span>
                             <span class="text-xl font-extrabold text-pink-600">
                                 Rp {{ number_format($trx->total_price,0,',','.') }}
                             </span>
                         </div>

                         @if(auth()->check() && auth()->user()->role === 'admin' && $trx->status == 'paid')
                             <form action="{{ route('admin.accept', $trx->id) }}" method="POST" class="w-full sm:w-auto">
                                 @csrf
                                 <button type="submit" class="w-full bg-pink-600 hover:bg-pink-700 text-white font-bold px-5 py-2.5 rounded-xl text-xs uppercase tracking-wider transition duration-200">
                                     Terima & Konfirmasi Pesanan
                                 </button>
                             </form>
                         @endif

                         @if(auth()->check() && auth()->id() === $trx->user_id && $trx->status == 'delivered')
                             <div class="flex gap-2 w-full sm:w-auto">
                                 <form action="{{ route('user.return', $trx->id) }}" method="POST" class="w-1/2 sm:w-auto">
                                     @csrf
                                     <button type="submit" onclick="return confirm('Apakah Anda yakin ingin mengembalikan semua pesanan ini?')" class="w-full bg-red-500 hover:bg-red-600 text-white font-bold px-4 py-2.5 rounded-xl text-xs uppercase tracking-wider transition duration-200">
                                         Kembalikan Semua
                                     </button>
                                 </form>
                                 <form action="{{ route('user.received', $trx->id) }}" method="POST" class="w-1/2 sm:w-auto">
                                     @csrf
                                     <button type="submit" class="w-full bg-green-600 hover:bg-green-700 text-white font-bold px-4 py-2.5 rounded-xl text-xs uppercase tracking-wider transition duration-200">
                                         Semua Diterima
                                     </button>
                                 </form>
                             </div>
                         @elseif(auth()->check() && auth()->id() === $trx->user_id && $trx->status == 'shipped')
                             <div class="flex gap-2 w-full sm:w-auto">
                                 <div class="w-full bg-blue-50 text-blue-600 border border-blue-200 font-bold px-4 py-2.5 rounded-xl text-xs uppercase tracking-wider text-center">
                                     Pesanan Sedang Diantar Kurir
                                 </div>
                             </div>
                         @endif

                    </div>

                </div>

                @endforeach

            </div>

        @endif

    </div>

</body>
</html>
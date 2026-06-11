<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\TransactionItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Midtrans\Config;
use Midtrans\Snap;
use Midtrans\Notification;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\TransactionsExport;
use App\Exports\TransactionSingleExport;
use Barryvdh\DomPDF\Facade\Pdf;

class TransactionController extends Controller
{
    public function checkout(Request $request)
    {
        $request->validate([
            'address_id' => 'nullable',
            'items' => 'required|array'
        ]);

        Config::$serverKey = config('midtrans.serverKey');
        Config::$isProduction = config('midtrans.isProduction');
        Config::$isSanitized = true;
        Config::$is3ds = true;

        $total = 0;
        $items_midtrans = [];

        foreach ($request->items as $item) {

            $product = Product::findOrFail($item['id']);

            $price = max(0, (int)$product->price);
            $qty   = max(1, (int)$item['qty']);

            $subtotal = $price * $qty;
            $total += $subtotal;

            $items_midtrans[] = [
                'id' => $product->id,
                'price' => $price,
                'quantity' => $qty,
                'name' => substr($product->name, 0, 50)
            ];
        }

        $promoBannerActive = \App\Models\Setting::where('key', 'promo_banner_active')->value('value') == '1';
        $globalDiscount = \App\Models\Setting::where('key', 'global_discount_percentage')->value('value') ?? 0;
        
        if ($promoBannerActive && $globalDiscount > 0) {
            $discountAmount = (int)($total * ($globalDiscount / 100));
            if ($discountAmount > 0) {
                $total -= $discountAmount;
                
                $items_midtrans[] = [
                    'id' => 'DISC-GLOBAL',
                    'price' => -$discountAmount,
                    'quantity' => 1,
                    'name' => 'Diskon Promo (' . rtrim(rtrim(number_format($globalDiscount, 2), '0'), '.') . '%)'
                ];
            }
        }

        $addressId = $request->address_id;
        if (!$addressId) {
            if (auth()->check()) {
                $latestAddress = \App\Models\Address::where('user_id', auth()->id())->latest()->first();
                if ($latestAddress) {
                    $addressId = $latestAddress->id;
                } else {
                    return response()->json(['error' => 'Silakan tambah alamat pengiriman terlebih dahulu.'], 400);
                }
            } else {
                // For guest, we might need a default or error. Since we only support authenticated users for addresses:
                return response()->json(['error' => 'Silakan login dan tambah alamat pengiriman.'], 400);
            }
        }

        foreach ($request->items as $item) {
            $product = Product::findOrFail($item['id']);
            $qty   = max(1, (int)$item['qty']);
            if ($qty > $product->stock) {
                return response()->json(['error' => 'Maaf, stok ' . $product->name . ' tidak mencukupi (Sisa: ' . $product->stock . ')'], 400);
            }
        }

        $transaction = Transaction::create([
            'user_id' => auth()->id(), // 🔥 Simpan ID user yang login
            'address_id' => $addressId,
            'total_price' => $total,
            'status' => 'pending',
            'midtrans_order_id' => 'ORDER-' . uniqid(),
            'tracking_number' => 'TB-' . date('Ymd') . '-' . strtoupper(Str::random(6)),
            'delivery_date' => $request->delivery_date
        ]);

        foreach ($request->items as $item) {

            $product = Product::findOrFail($item['id']);

            $price = max(0, (int)$product->price);
            $qty   = max(1, (int)$item['qty']);

            TransactionItem::create([
                'transaction_id' => $transaction->id,
                'product_id' => $product->id,
                'qty' => $qty,
                'price' => $price,
                'box_color' => $item['box_color'] ?? null,
                'greeting_card' => $item['greeting_card'] ?? null,
                'custom_message' => $item['custom_message'] ?? null
            ]);

            $product->stock -= $qty;
            $product->save();
        }

        $params = [
            'transaction_details' => [
                'order_id' => $transaction->midtrans_order_id,
                'gross_amount' => (int)$total,
            ],
            'item_details' => $items_midtrans,
            'customer_details' => [
                'first_name' => auth()->check() ? auth()->user()->name : 'Guest',
                'email' => auth()->check() ? auth()->user()->email : 'guest@mail.com',
            ],
        ];

        $snapToken = Snap::getSnapToken($params);

        return response()->json([
            'snap_token' => $snapToken
        ]);
    }

    // 🔥 CALLBACK MIDTRANS
    public function callback(Request $request)
    {
        Config::$serverKey = config('midtrans.serverKey');
        Config::$isProduction = config('midtrans.isProduction');
        Config::$isSanitized = true;
        Config::$is3ds = true;

        $notif = new Notification();

        $transactionStatus = $notif->transaction_status;
        $orderId = $notif->order_id;
        $fraudStatus = $notif->fraud_status;

        $transaction = Transaction::where('midtrans_order_id', $orderId)->first();

        if (!$transaction) {
            return response()->json(['message' => 'Transaction not found'], 404);
        }

        if ($transactionStatus == 'capture') {
            if ($fraudStatus == 'challenge') {
                $transaction->status = 'pending';
            } else {
                $transaction->status = 'paid';
            }
        } elseif ($transactionStatus == 'settlement') {
            $transaction->status = 'paid';
        } elseif ($transactionStatus == 'pending') {
            $transaction->status = 'pending';
        } elseif (in_array($transactionStatus, ['deny', 'expire', 'cancel'])) {
            $transaction->status = 'failed';
        }

        $transaction->save();

        return response()->json(['message' => 'OK']);
    }

    // ✅ TAMBAHAN WAJIB (BIAR MUNCUL DI RIWAYAT)
    public function index()
    {
        $query = Transaction::with(['items.product'])->orderBy('id', 'desc');

        // Jika yang login bukan admin, hanya tampilkan transaksi miliknya
        if (auth()->check() && auth()->user()->role !== 'admin') {
            $query->where('user_id', auth()->id());
        }

        $transactions = $query->get();

        return view('transactions.index', compact('transactions'));
    }

    public function items()
{
    return $this->hasMany(TransactionItem::class);
}
public function userTransactions()
{
    $data = Transaction::where('user_id', auth()->id())
        ->latest()
        ->get();

    return view('user.transactions', compact('data'));
}
public function exportExcel()
{
    return Excel::download(new TransactionsExport, 'transactions.xlsx');
}
public function exportPdf()
{
    $transactions = \App\Models\Transaction::all();

    $pdf = Pdf::loadView('admin.transactions.pdf', compact('transactions'));

    return $pdf->download('transactions.pdf');
}

public function exportSinglePdf($id)
{
    $transaction = Transaction::with(['user', 'address', 'items.product'])->findOrFail($id);

    // Access control
    $user = auth()->user();
    if ($user->role !== 'admin' && $user->role !== 'kurir' && $transaction->user_id !== $user->id) {
        abort(403, 'Akses ditolak.');
    }

    $pdf = Pdf::loadView('transactions.export_pdf', compact('transaction'));

    return $pdf->download('Invoice_' . ($transaction->midtrans_order_id ?? $transaction->id) . '.pdf');
}

public function exportSingleExcel($id)
{
    $transaction = Transaction::with(['user', 'address', 'items.product'])->findOrFail($id);

    // Access control
    $user = auth()->user();
    if ($user->role !== 'admin' && $user->role !== 'kurir' && $transaction->user_id !== $user->id) {
        abort(403, 'Akses ditolak.');
    }

    return Excel::download(new TransactionSingleExport($transaction), 'Invoice_' . ($transaction->midtrans_order_id ?? $transaction->id) . '.xlsx');
}

    public function confirmReceived($id)
    {
        $transaction = Transaction::where('user_id', auth()->id())->findOrFail($id);

        if ($transaction->status === 'shipped' || $transaction->status === 'delivered') {
            $transaction->status = 'completed';
            $transaction->save();

            // Mark all pending items in this transaction as completed
            $transaction->items()->where('status', 'pending')->update(['status' => 'completed']);

            return redirect()->back()->with('success', 'Terima kasih! Pesanan Anda telah selesai.');
        }

        return redirect()->back()->with('error', 'Status pesanan tidak valid.');
    }

    public function returnOrder($id)
    {
        $transaction = Transaction::where('user_id', auth()->id())->findOrFail($id);

        if ($transaction->status === 'shipped' || $transaction->status === 'delivered') {
            $transaction->status = 'returned';
            $transaction->save();

            // Mark all pending items in this transaction as returned
            $transaction->items()->where('status', 'pending')->update(['status' => 'returned']);

            return redirect()->back()->with('success', 'Permintaan pengembalian pesanan berhasil diproses.');
        }

        return redirect()->back()->with('error', 'Status pesanan tidak valid.');
    }

    public function confirmItemReceived($id)
    {
        $item = TransactionItem::findOrFail($id);
        $transaction = $item->transaction;

        // Verify the transaction belongs to the logged-in user
        if ($transaction->user_id !== auth()->id()) {
            return redirect()->back()->with('error', 'Akses ditolak.');
        }

        if ($transaction->status === 'shipped' || $transaction->status === 'delivered') {
            $item->status = 'completed';
            $item->save();

            // Check if all items are processed (completed or returned)
            $allProcessed = !$transaction->items()->where('status', 'pending')->exists();
            if ($allProcessed) {
                // If there's at least one completed item, mark transaction as completed.
                // If all items are returned, mark transaction as returned.
                $hasCompleted = $transaction->items()->where('status', 'completed')->exists();
                if ($hasCompleted) {
                    $transaction->status = 'completed';
                } else {
                    $transaction->status = 'returned';
                }
                $transaction->save();
            }

            return redirect()->back()->with('success', 'Terima kasih! Produk telah diterima.');
        }

        return redirect()->back()->with('error', 'Status pesanan tidak valid.');
    }

    public function returnItem($id)
    {
        $item = TransactionItem::findOrFail($id);
        $transaction = $item->transaction;

        // Verify the transaction belongs to the logged-in user
        if ($transaction->user_id !== auth()->id()) {
            return redirect()->back()->with('error', 'Akses ditolak.');
        }

        if ($transaction->status === 'shipped' || $transaction->status === 'delivered') {
            $item->status = 'returned';
            $item->save();

            // Check if all items are processed (completed or returned)
            $allProcessed = !$transaction->items()->where('status', 'pending')->exists();
            if ($allProcessed) {
                $hasCompleted = $transaction->items()->where('status', 'completed')->exists();
                if ($hasCompleted) {
                    $transaction->status = 'completed';
                } else {
                    $transaction->status = 'returned';
                }
                $transaction->save();
            }

            return redirect()->back()->with('success', 'Permintaan pengembalian produk berhasil diproses.');
        }

        return redirect()->back()->with('error', 'Status pesanan tidak valid.');
    }

    public function show($id)
    {
        $transaction = Transaction::with(['user', 'address', 'items.product'])->findOrFail($id);

        // Access control: only owner, admin, or courier can view
        $user = auth()->user();
        if ($user->role !== 'admin' && $user->role !== 'kurir' && $transaction->user_id !== $user->id) {
            abort(403, 'Akses ditolak.');
        }

        $couriers = \App\Models\User::where('role', 'kurir')->get();

        return view('transactions.show', compact('transaction', 'couriers'));
    }

    public function getCourierLocation($id)
    {
        $transaction = Transaction::with('courier')->findOrFail($id);

        // Access control
        $user = auth()->user();
        if ($user->role !== 'admin' && $user->role !== 'kurir' && $transaction->user_id !== $user->id) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        if (!$transaction->courier) {
            return response()->json(['error' => 'Courier not assigned yet'], 404);
        }

        return response()->json([
            'latitude' => $transaction->courier->latitude,
            'longitude' => $transaction->courier->longitude,
            'updated_at' => $transaction->courier->updated_at,
        ]);
    }
}
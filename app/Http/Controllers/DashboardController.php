<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Models\Product;
use App\Models\User;
use App\Models\Transaction;

class DashboardController extends Controller
{
    // =========================
    // DASHBOARD ADMIN
    // =========================
    public function adminDashboard()
    {
        $totalSales = Transaction::whereIn('status', ['paid', 'confirmed', 'assigned', 'courier_accepted', 'admin_handed_over', 'shipped', 'delivered', 'completed'])
                                ->sum('total_price');

        $totalUsers = User::where('role', 'user')
                        ->count();

        $totalProducts = Product::count();
        
        $recentTransactions = Transaction::with(['user', 'items.product'])
                                        ->latest()
                                        ->take(5)
                                        ->get();

        // === GRAFIK 1: Pendapatan 6 Bulan Terakhir ===
        $monthlySales = collect();
        for ($i = 5; $i >= 0; $i--) {
            $month = now()->subMonths($i);
            $total = Transaction::whereIn('status', ['paid', 'confirmed', 'assigned', 'courier_accepted', 'admin_handed_over', 'shipped', 'delivered', 'completed'])
                ->whereYear('created_at', $month->year)
                ->whereMonth('created_at', $month->month)
                ->sum('total_price');
            $monthlySales->push([
                'label' => $month->translatedFormat('M Y'),
                'total' => (int) $total,
            ]);
        }

        // === GRAFIK 2: Distribusi Status Transaksi ===
        $statusCounts = Transaction::select('status', DB::raw('count(*) as total'))
            ->groupBy('status')
            ->pluck('total', 'status');

        $statusCountsMapped = [
            'paid' => ($statusCounts->get('paid', 0)
                + $statusCounts->get('confirmed', 0)
                + $statusCounts->get('assigned', 0)
                + $statusCounts->get('courier_accepted', 0)
                + $statusCounts->get('admin_handed_over', 0)),
            'pending' => $statusCounts->get('pending', 0),
            'failed' => $statusCounts->get('failed', 0),
            'shipped' => ($statusCounts->get('shipped', 0) + $statusCounts->get('delivered', 0)),
            'completed' => $statusCounts->get('completed', 0),
            'returned' => $statusCounts->get('returned', 0),
        ];

        $statusLabels  = ['paid', 'pending', 'failed', 'shipped', 'completed', 'returned'];
        $statusData    = collect($statusLabels)->map(fn($s) => $statusCountsMapped[$s] ?? 0);
        $statusDisplay = ['Lunas', 'Pending', 'Gagal', 'Dikirim', 'Selesai', 'Dikembalikan'];

        // === GRAFIK 3: Produk Terlaris ===
        $topProducts = DB::table('transaction_items')
            ->join('products', 'transaction_items.product_id', '=', 'products.id')
            ->join('transactions', 'transaction_items.transaction_id', '=', 'transactions.id')
            ->whereIn('transactions.status', ['paid', 'confirmed', 'assigned', 'courier_accepted', 'admin_handed_over', 'shipped', 'delivered', 'completed'])
            ->select('products.name', DB::raw('SUM(transaction_items.qty) as total_sold'))
            ->groupBy('products.id', 'products.name')
            ->orderByDesc('total_sold')
            ->limit(5)
            ->get();

        // === AMBIL DATA KURIR ===
        $couriers = User::where('role', 'kurir')->get();

        return view(
            'dashboard.admin',
            compact(
                'totalSales',
                'totalUsers',
                'totalProducts',
                'recentTransactions',
                'monthlySales',
                'statusData',
                'statusDisplay',
                'topProducts',
                'couriers'
            )
        );
    }

    // =========================
    // ASSIGN ORDER TO COURIER (Admin)
    // =========================
    public function acceptOrder(Request $request, $id)
    {
        $transaction = Transaction::findOrFail($id);

        $request->validate([
            'courier_id' => 'required|exists:users,id'
        ]);

        if ($transaction->status === 'paid' || $transaction->status === 'confirmed') {
            $transaction->status = 'assigned';
            $transaction->courier_id = $request->courier_id;
            $transaction->save();

            return redirect()->back()->with(
                'success',
                'Pesanan berhasil ditugaskan ke kurir.'
            );
        }

        return redirect()->back()->with(
            'error',
            'Status pesanan tidak valid untuk dikonfirmasi.'
        );
    }

    // =========================
    // HANDOVER ORDER TO COURIER (Admin)
    // =========================
    public function handoverToCourier($id)
    {
        $transaction = Transaction::findOrFail($id);

        if ($transaction->status === 'courier_accepted') {
            $transaction->status = 'admin_handed_over';
            $transaction->save();

            return redirect()->back()->with(
                'success',
                'Barang telah diserahkan ke kurir (menunggu konfirmasi kurir).'
            );
        }

        return redirect()->back()->with(
            'error',
            'Status pesanan tidak valid untuk diserahkan.'
        );
    }

    // =========================
    // CUSTOMERS
    // =========================
    public function customers()
    {
        $customers = User::where('role', 'user')
                        ->latest()
                        ->get();

        return view(
            'dashboard.customers',
            compact('customers')
        );
    }

    // =========================
    // COURIERS
    // =========================
    public function couriers()
    {
        $couriers = User::where('role', 'kurir')
                        ->latest()
                        ->get();

        return view(
            'dashboard.couriers',
            compact('couriers')
        );
    }

    // =========================
    // STORE COURIER
    // =========================
    public function storeCourier(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6',
            'base_address' => 'required|string'
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'role' => 'kurir',
            'base_address' => $request->base_address
        ]);

        return redirect()->back()->with(
            'success',
            'Kurir berhasil ditambahkan.'
        );
    }

    // =========================
    // DELETE COURIER
    // =========================
    public function deleteCourier($id)
    {
        $courier = User::findOrFail($id);

        if ($courier->role === 'kurir') {

            $courier->delete();

            return redirect()->back()->with(
                'success',
                'Kurir berhasil dihapus.'
            );
        }

        return redirect()->back()->with(
            'error',
            'User ini bukan kurir.'
        );
    }

    // =========================
    // DASHBOARD USER
    // =========================
    public function userDashboard()
    {
        $user = auth()->user();
        
        $totalSpent = Transaction::where('user_id', $user->id)
                                ->whereIn('status', ['paid', 'confirmed', 'assigned', 'courier_accepted', 'admin_handed_over', 'shipped', 'delivered', 'completed'])
                                ->sum('total_price');
                                
        $totalOrders = Transaction::where('user_id', $user->id)
                                ->count();
        
        $recentTransactions = Transaction::with(['items.product'])
                                        ->where('user_id', $user->id)
                                        ->latest()
                                        ->take(3)
                                        ->get();

        $promoBannerActive = \App\Models\Setting::where('key', 'promo_banner_active')->value('value') == '1';
        $promoTitle = \App\Models\Setting::where('key', 'promo_title')->value('value') ?? 'Promo Spesial Menantimu!';
        $promoDescription = \App\Models\Setting::where('key', 'promo_description')->value('value') ?? 'Sedang ada diskon potongan harga untuk produk kosmetik pilihan. Yuk klaim sekarang sebelum kehabisan!';
        $globalDiscount = \App\Models\Setting::where('key', 'global_discount_percentage')->value('value') ?? 0;

        return view(
            'dashboard.user',
            compact(
                'totalSpent',
                'totalOrders',
                'recentTransactions',
                'promoBannerActive',
                'promoTitle',
                'promoDescription',
                'globalDiscount'
            )
        );
    }

    // =========================
    // DASHBOARD KURIR
    // =========================
    public function courierDashboard()
    {
        $courierId = auth()->id();

        // Pesanan baru ditugaskan
        $newTasks = Transaction::where('courier_id', $courierId)->where('status', 'assigned')->count();

        // Pesanan siap diambil di admin (menunggu admin serahkan)
        $readyToShip = Transaction::where('courier_id', $courierId)->where('status', 'courier_accepted')->count();

        // Pesanan sudah diserahkan admin, menunggu konfirmasi pickup kurir
        $waitingPickup = Transaction::where('courier_id', $courierId)->where('status', 'admin_handed_over')->count();
        
        // Pesanan sedang dikirim
        $shippingOrders = Transaction::where('courier_id', $courierId)->where('status', 'shipped')->count();

        // Pesanan selesai
        $completedOrders = Transaction::where('courier_id', $courierId)->where('status', 'completed')->count();
        
        // Total semua pesanan
        $totalOrders = Transaction::where('courier_id', $courierId)->count();
        
        // Data transaksi terbaru
        $recentTransactions = Transaction::with(['user', 'address'])
                                        ->where('courier_id', $courierId)
                                        ->whereIn('status', ['assigned', 'courier_accepted', 'admin_handed_over', 'shipped', 'completed'])
                                        ->latest()
                                        ->take(15)
                                        ->get();
        return view(
            'dashboard.courier',
            compact(
                'newTasks',
                'readyToShip',
                'waitingPickup',
                'shippingOrders',
                'completedOrders',
                'totalOrders',
                'recentTransactions'
            )
        );
    }

    // =========================
    // COURIER PICKUP ORDER
    // =========================
    public function pickupOrder($id)
    {
        $transaction = Transaction::where('courier_id', auth()->id())->findOrFail($id);

        if ($transaction->status === 'admin_handed_over') {
            $transaction->status = 'shipped';
            $transaction->save();

            return redirect()->back()->with(
                'success',
                'Barang telah diambil! Silakan mulai pengantaran ke pelanggan.'
            );
        }

        return redirect()->back()->with(
            'error',
            'Pesanan tidak valid untuk di-pickup.'
        );
    }
    public function acceptTask($id)
    {
        $transaction = Transaction::where('courier_id', auth()->id())->findOrFail($id);

        if ($transaction->status === 'assigned') {
            $transaction->status = 'courier_accepted';
            $transaction->save();

            return redirect()->back()->with(
                'success',
                'Tugas diterima! Silakan ambil barang di Admin.'
            );
        }

        return redirect()->back()->with(
            'error',
            'Tugas tidak valid.'
        );
    }

    // =========================
    // SHIP ORDER
    // =========================
    public function shipOrder($id)
    {
        $transaction = Transaction::findOrFail($id);
        
        if ($transaction->status === 'confirmed') {

            $transaction->status = 'shipped';

            $transaction->save();

            return redirect()->back()->with(
                'success',
                'Status pesanan berhasil diubah menjadi Sedang Dikirim.'
            );
        }

        return redirect()->back()->with(
            'error',
            'Pesanan ini tidak valid untuk dikirim.'
        );
    }

    // =========================
    // COMPLETE ORDER
    // =========================
    public function completeOrder(Request $request, $id)
{
    $transaction = Transaction::findOrFail($id);

    $request->validate([
        'proof' => 'required|image|mimes:jpg,jpeg,png|max:2048'
    ]);

    $path = $request->file('proof')->store('proofs', 'public');

    $transaction->status = 'completed';

    $transaction->proof_of_delivery = $path;

    $transaction->save();

    return back()->with('success', 'Pesanan selesai.');
}
}
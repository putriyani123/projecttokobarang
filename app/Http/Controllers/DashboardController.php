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
        $totalSales = Transaction::where('status', 'paid')
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
            $total = Transaction::where('status', 'paid')
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

        $statusLabels  = ['paid', 'pending', 'failed', 'shipped', 'completed', 'returned'];
        $statusData    = collect($statusLabels)->map(fn($s) => $statusCounts->get($s, 0));
        $statusDisplay = ['Lunas', 'Pending', 'Gagal', 'Dikirim', 'Selesai', 'Dikembalikan'];

        // === GRAFIK 3: Produk Terlaris ===
        $topProducts = DB::table('transaction_items')
            ->join('products', 'transaction_items.product_id', '=', 'products.id')
            ->join('transactions', 'transaction_items.transaction_id', '=', 'transactions.id')
            ->where('transactions.status', 'paid')
            ->select('products.name', DB::raw('SUM(transaction_items.qty) as total_sold'))
            ->groupBy('products.id', 'products.name')
            ->orderByDesc('total_sold')
            ->limit(5)
            ->get();

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
                'topProducts'
            )
        );
    }

    // =========================
    // ACCEPT ORDER (Admin)
    // =========================
    public function acceptOrder($id)
    {
        $transaction = Transaction::findOrFail($id);

        if ($transaction->status === 'paid') {
            $transaction->status = 'confirmed';
            $transaction->save();

            return redirect()->back()->with(
                'success',
                'Pesanan berhasil diterima dan siap dikirim oleh kurir!'
            );
        }

        return redirect()->back()->with(
            'error',
            'Status pesanan tidak valid untuk dikonfirmasi.'
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
            'password' => 'required|min:6'
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'role' => 'kurir'
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
                                ->where('status', 'paid')
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
        // Pesanan siap dikirim
        $readyToShip = Transaction::where('status', 'confirmed')
                                ->count();
        
        // Pesanan sedang dikirim
        $shippingOrders = Transaction::where('status', 'shipped')
                                    ->count();

        // Pesanan selesai
        $completedOrders = Transaction::where('status', 'completed')
                                    ->count();
        
        // Total semua pesanan
        $totalOrders = Transaction::count();
        
        // Data transaksi terbaru
        $recentTransactions = Transaction::with(['user', 'address'])
                                        ->latest()
                                        ->take(15)
                                        ->get();
return view(
    'dashboard.courier',
    compact(
        'readyToShip',
        'shippingOrders',
        'completedOrders',
        'totalOrders',
        'recentTransactions'
    )
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
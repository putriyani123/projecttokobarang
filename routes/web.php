<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\AddressController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\MidtransController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\KurirController;
use App\Http\Controllers\ProfileController;

// =============================
// WILAYAH.ID PROXY
// =============================
Route::get('/proxy/wilayah/{endpoint}', function ($endpoint) {
    try {
        $response = \Illuminate\Support\Facades\Http::get('https://wilayah.id/api/' . $endpoint);
        return response($response->body(), 200)->header('Content-Type', 'application/json');
    } catch (\Exception $e) {
        return response()->json(['error' => $e->getMessage()], 500);
    }
})->where('endpoint', '.*');


// =============================
// HALAMAN AWAL
// =============================
Route::get('/', function () {
    $products = \App\Models\Product::with('category')->latest()->take(6)->get();
    return view('home', compact('products'));
});


// =============================
// SETUP ADMIN
// =============================
Route::get('/setup-admin', function () {
    try {

        \Illuminate\Support\Facades\Artisan::call('migrate', ['--force' => true]);

        \App\Models\User::where('email', 'admin@gmail.com')->delete();

        $user = \App\Models\User::create([
            'name' => 'Admin System',
            'email' => 'admin@gmail.com',
            'password' => \Illuminate\Support\Facades\Hash::make('password'),
            'role' => 'admin'
        ]);

        return 'Sistem telah di-reset ulang! Admin berhasil dibuat';

    } catch (\Exception $e) {

        return 'Error: ' . $e->getMessage();
    }
});


// =============================
// MAGIC LOGIN ADMIN
// =============================
Route::get('/magic-login', function () {

    $admin = \App\Models\User::where('email', 'admin@gmail.com')->first();

    if ($admin) {

        \Illuminate\Support\Facades\Auth::login($admin);

        return redirect('/admin/dashboard');
    }

    return 'Admin belum dibuat';
});


// =============================
// SETUP KURIR
// =============================
Route::get('/setup-kurir', function () {

    try {

        \App\Models\User::where('email', 'kurir@gmail.com')->delete();

        $user = \App\Models\User::create([

            'name' => 'Kurir Express',

            'email' => 'kurir@gmail.com',

            'password' => \Illuminate\Support\Facades\Hash::make('password'),

            'role' => 'kurir'
        ]);

        return 'Akun kurir berhasil dibuat!';

    } catch (\Exception $e) {

        return 'Error: ' . $e->getMessage();
    }
});


// =============================
// MAGIC LOGIN KURIR
// =============================
Route::get('/magic-login-kurir', function () {

    $kurir = \App\Models\User::where('email', 'kurir@gmail.com')->first();

    if ($kurir) {

        \Illuminate\Support\Facades\Auth::login($kurir);

        return redirect('/kurir/dashboard');
    }

    return 'Kurir belum dibuat';
});


// =============================
// CRUD
// =============================
Route::resource('categories', CategoryController::class);
Route::resource('products', ProductController::class);
Route::resource('addresses', AddressController::class);


// =============================
// CHECKOUT
// =============================
Route::post('/checkout', [TransactionController::class,'checkout'])->name('checkout');


// =============================
// RIWAYAT TRANSAKSI
// =============================
Route::get('/transactions', function () {

    $data = \App\Models\Transaction::with('items.product')
        ->latest()
        ->get();

    return view('transactions.index', compact('data'));

})->name('transactions');


// =============================
// MIDTRANS CALLBACK
// =============================
Route::post('/midtrans/callback', [MidtransController::class,'callback']);

Route::post('/midtrans/callback', [TransactionController::class, 'callback']);

Route::get('/payment-success', function () {

    $trx = \App\Models\Transaction::latest()->first();

    if ($trx) {

        $trx->status = 'paid';

        $trx->save();

        return redirect()->route('transaction.show', $trx->id);
    }

    return redirect('/transactions');
});

Route::post('/cart/checkout', [CheckoutController::class, 'checkout'])->middleware('auth');


// =============================
// DASHBOARD ADMIN
// =============================
Route::middleware(['auth', 'role:admin'])->group(function () {

    Route::get('/admin/dashboard', [
        DashboardController::class,
        'adminDashboard'
    ])->name('admin.dashboard');

    // Terima/konfirmasi pesanan (pilih kurir)
    Route::post('/admin/transaction/{id}/accept', [
        DashboardController::class,
        'acceptOrder'
    ])->name('admin.accept');

    // Serahkan barang ke kurir
    Route::post('/admin/transaction/{id}/handover', [
        DashboardController::class,
        'handoverToCourier'
    ])->name('admin.handover');

    // KELOLA PENGATURAN TOKO (BANNER PROMO)
    Route::get('/admin/settings', [
        \App\Http\Controllers\SettingController::class,
        'index'
    ])->name('admin.settings.index');

    Route::post('/admin/settings/update', [
        \App\Http\Controllers\SettingController::class,
        'update'
    ])->name('admin.settings.update');

    // TAMBAHAN DATA CUSTOMER
    Route::get('/admin/customers', [
        DashboardController::class,
        'customers'
    ])->name('admin.customers');



    // =========================
    // KELOLA KURIR
    // =========================

    // Halaman kurir
    Route::get('/admin/couriers', [
        DashboardController::class,
        'couriers'
    ])->name('admin.couriers');

    // Tambah kurir
    Route::post('/admin/couriers', [
        DashboardController::class,
        'storeCourier'
    ])->name('admin.couriers.store');

    // Hapus kurir
    Route::delete('/admin/couriers/{id}', [
        DashboardController::class,
        'deleteCourier'
    ])->name('admin.couriers.delete');

});


// =============================
// DASHBOARD USER
// =============================
Route::middleware(['auth', 'role:user'])->group(function () {

    Route::get('/user/dashboard', [
        DashboardController::class,
        'userDashboard'
    ])->name('user.dashboard');
});


// =============================
// DASHBOARD KURIR
// =============================
Route::middleware(['auth', 'role:kurir'])->group(function () {

    Route::get('/kurir/dashboard', [
        DashboardController::class,
        'courierDashboard'
    ])->name('kurir.dashboard');

    Route::post('/kurir/transaction/{id}/ship', [
        DashboardController::class,
        'shipOrder'
    ])->name('kurir.ship');

    // Kurir terima tugas
    Route::post('/kurir/transaction/{id}/accept-task', [
        DashboardController::class,
        'acceptTask'
    ])->name('kurir.accept_task');

    // Kurir konfirmasi ambil barang
    Route::post('/kurir/transaction/{id}/pickup', [
        DashboardController::class,
        'pickupOrder'
    ])->name('kurir.pickup');

    // TAMBAHAN SELESAIKAN PESANAN
    Route::post('/kurir/transaction/{id}/complete', [
        KurirController::class,
        'complete'
    ])->name('kurir.complete');

    // Update lokasi kurir
    Route::post('/kurir/update-location', [
        KurirController::class,
        'updateLocation'
    ])->name('kurir.update_location');

    // Halaman Map Kurir
    Route::get('/kurir/transaction/{id}/map', [
        KurirController::class,
        'deliveryMap'
    ])->name('kurir.delivery_map');
});


// =============================
// TRANSACTION
// =============================
Route::get('/transactions', [TransactionController::class, 'index']);
Route::get('/transaction/{id}', [TransactionController::class, 'show'])->name('transaction.show')->middleware('auth');
Route::get('/transaction/{id}/courier-location', [TransactionController::class, 'getCourierLocation'])->name('transaction.courier_location')->middleware('auth');
Route::get('/transaction/{id}/pdf', [TransactionController::class, 'exportSinglePdf'])->name('transaction.single.pdf')->middleware('auth');
Route::get('/transaction/{id}/excel', [TransactionController::class, 'exportSingleExcel'])->name('transaction.single.excel')->middleware('auth');

Route::post('/user/transaction/{id}/received', [TransactionController::class, 'confirmReceived'])->name('user.received')->middleware('auth');
Route::post('/user/transaction/{id}/return', [TransactionController::class, 'returnOrder'])->name('user.return')->middleware('auth');

Route::post('/user/transaction-item/{id}/received', [TransactionController::class, 'confirmItemReceived'])->name('user.item.received')->middleware('auth');
Route::post('/user/transaction-item/{id}/return', [TransactionController::class, 'returnItem'])->name('user.item.return')->middleware('auth');

Route::post('/checkout', [TransactionController::class, 'checkout']);

Route::post('/midtrans/callback', [TransactionController::class, 'callback']);


// =============================
// AUTH
// =============================
Route::get('/login', [AuthController::class, 'loginForm'])->name('login');

Route::post('/login', [AuthController::class, 'login']);

Route::get('/register', [AuthController::class, 'registerForm']);

Route::post('/register', [AuthController::class, 'register']);

Route::get('/captcha/refresh', [AuthController::class, 'refreshCaptcha'])->name('captcha.refresh');

Route::get('/logout', [AuthController::class, 'logout']);

// =============================
// GOOGLE OAUTH
// =============================
Route::get('/auth/google', [AuthController::class, 'redirectToGoogle'])->name('auth.google');

Route::get('/auth/google/call-back', [AuthController::class, 'handleGoogleCallback'])->name('auth.google.call-back');

Route::get('/auth/google/call-back', [AuthController::class, 'handleGoogleCallback']);


// =============================
// CART
// =============================
Route::middleware(['auth'])->group(function () {

    Route::get('/cart', [\App\Http\Controllers\CartController::class, 'index']);

    Route::post('/cart/add', [\App\Http\Controllers\CartController::class, 'add']);

    Route::post('/cart/update/{id}', [\App\Http\Controllers\CartController::class, 'update']);

    Route::delete('/cart/remove/{id}', [\App\Http\Controllers\CartController::class, 'remove']);

});
Route::get('/transactions/pdf', [TransactionController::class, 'exportPdf']);
Route::get('/transactions/excel', [TransactionController::class, 'exportExcel']);


// =============================
// PROFILE
// =============================
Route::middleware(['auth'])->group(function () {

    Route::get('/profile', [ProfileController::class, 'show'])->name('profile');

    Route::put('/profile/update', [ProfileController::class, 'update'])->name('profile.update');

    Route::put('/profile/password', [ProfileController::class, 'updatePassword'])->name('profile.password');

});
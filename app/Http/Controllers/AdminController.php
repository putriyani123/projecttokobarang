<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\User;
use App\Models\Transaction;

class AdminController extends Controller
{
    public function index()
    {
        return view('admin.dashboard', [
            'totalProduk' => Product::count(),
            'totalUser' => User::where('role','user')->count(),
            'totalTransaksi' => Transaction::count(),
        ]);
    }
}
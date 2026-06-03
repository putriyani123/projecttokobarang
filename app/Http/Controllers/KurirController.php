<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaction;

class KurirController extends Controller
{
    public function complete(Request $request, $id)
    {
        $request->validate([
            'proof' => 'required|image|mimes:jpg,jpeg,png|max:2048'
        ]);

        $trx = Transaction::findOrFail($id);

        // Upload foto
        $proofPath = $request->file('proof')->store('proofs', 'public');

        // Update transaksi menjadi delivered (Diterima oleh pelanggan, tapi belum dikonfirmasi selesai oleh pelanggan)
        $trx->status = 'delivered';
        $trx->proof_of_delivery = $proofPath;
        $trx->save();

        return redirect()->back()->with('success', 'Pesanan berhasil diselesaikan!');
    }
}
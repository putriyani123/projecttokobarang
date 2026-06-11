<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaction;

class KurirController extends Controller
{
    public function complete(Request $request, $id)
    {
        $request->validate([
            'proof' => 'required|image|mimes:jpg,jpeg,png|max:10240'
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

    public function updateLocation(Request $request)
    {
        $request->validate([
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
        ]);

        $user = auth()->user();
        $user->latitude = $request->latitude;
        $user->longitude = $request->longitude;
        $user->save();

        return response()->json(['status' => 'success']);
    }

    public function deliveryMap($id)
    {
        $transaction = Transaction::with(['user', 'address'])->findOrFail($id);

        if ($transaction->courier_id !== auth()->id()) {
            abort(403, 'Akses ditolak.');
        }

        return view('kurir.map', compact('transaction'));
    }
}
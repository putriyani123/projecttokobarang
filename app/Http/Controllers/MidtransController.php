<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaction;

class MidtransController extends Controller
{
    public function callback(Request $request)
    {
        $serverKey = config('midtrans.serverKey');

        $hashed = hash("sha512",
            $request->order_id .
            $request->status_code .
            $request->gross_amount .
            $serverKey
        );

        if ($hashed != $request->signature_key) {
            return response()->json(['message'=>'Invalid'],403);
        }

        $trx = Transaction::where('midtrans_order_id', $request->order_id)->first();

        if (!$trx) return;

        if ($request->transaction_status == 'settlement') {
            $trx->status = 'paid';
        } elseif ($request->transaction_status == 'pending') {
            $trx->status = 'pending';
        } else {
            $trx->status = 'failed';
        }

        $trx->save();
    }
}
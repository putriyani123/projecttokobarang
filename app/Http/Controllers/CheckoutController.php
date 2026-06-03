<?php

namespace App\Http\Controllers;
use App\Models\Checkout;
use Illuminate\Http\Request;
use Midtrans\Snap;

class CheckoutController extends Controller
{
  public function checkout(Request $request)
{
    $cart = \App\Models\Cart::with('items.product')
        ->where('user_id', auth()->id())
        ->first();

    if (!$cart || $cart->items->isEmpty()) {
        return response()->json(['error' => 'Cart kosong'], 400);
    }

    \Midtrans\Config::$serverKey = config('midtrans.serverKey');
    \Midtrans\Config::$isProduction = config('midtrans.isProduction');
    \Midtrans\Config::$isSanitized = true;
    \Midtrans\Config::$is3ds = true;

    $total = 0;
    $items_midtrans = [];

    foreach ($cart->items as $item) {
        $price = max(0, (int)$item->product->price);
        $qty   = max(1, (int)$item->qty);

        $total += $price * $qty;

        $items_midtrans[] = [
            'id' => $item->product->id,
            'price' => $price,
            'quantity' => $qty,
            'name' => substr($item->product->name, 0, 50)
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

    $transaction = \App\Models\Transaction::create([
        'user_id' => auth()->id(),
        'address_id' => $request->address_id ?? 1, // Default address for now
        'total_price' => $total,
        'status' => 'pending',
        'midtrans_order_id' => 'CART-' . uniqid(),
        'delivery_date' => $request->delivery_date
    ]);

    foreach ($cart->items as $item) {
        \App\Models\TransactionItem::create([
            'transaction_id' => $transaction->id,
            'product_id' => $item->product_id,
            'qty' => $item->qty,
            'price' => $item->product->price,
            'box_color' => $item->box_color,
            'greeting_card' => $item->greeting_card,
            'custom_message' => $item->custom_message
        ]);
    }

    // Kosongkan cart
    \App\Models\CartItem::where('cart_id', $cart->id)->delete();

    $params = [
        'transaction_details' => [
            'order_id' => $transaction->midtrans_order_id,
            'gross_amount' => (int)$total,
        ],
        'item_details' => $items_midtrans,
        'customer_details' => [
            'first_name' => auth()->user()->name,
            'email' => auth()->user()->email,
        ],
    ];

    $snapToken = Snap::getSnapToken($params);

    return response()->json([
        'snap_token' => $snapToken
    ]);
}
}
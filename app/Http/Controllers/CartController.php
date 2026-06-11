<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Product;

class CartController extends Controller
{
    public function index()
    {
        $cart = Cart::with('items.product')->firstOrCreate(
            ['user_id' => auth()->id()]
        );
        $addresses = \App\Models\Address::where('user_id', auth()->id())->get();
        return view('cart.index', compact('cart', 'addresses'));
    }

    public function add(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'qty' => 'required|integer|min:1',
            'box_color' => 'nullable|string',
            'greeting_card' => 'nullable|string',
            'custom_message' => 'nullable|string'
        ]);

        $product = Product::findOrFail($request->product_id);

        $cart = Cart::firstOrCreate(['user_id' => auth()->id()]);

        // Cek total qty produk ini di keranjang user (untuk menghitung jika ada custom_message/warna box berbeda tapi produk sama)
        $currentTotalQtyInCart = CartItem::where('cart_id', $cart->id)
                                         ->where('product_id', $product->id)
                                         ->sum('qty');

        if ($currentTotalQtyInCart + $request->qty > $product->stock) {
            return back()->with('error', 'Maaf, stok produk tidak mencukupi. Sisa stok: ' . $product->stock);
        }

        // Find existing item with the exact same custom options
        $cartItem = CartItem::where('cart_id', $cart->id)
                            ->where('product_id', $request->product_id)
                            ->where('box_color', $request->box_color)
                            ->where('greeting_card', $request->greeting_card)
                            ->where('custom_message', $request->custom_message)
                            ->first();

        if ($cartItem) {
            $cartItem->qty += $request->qty;
            $cartItem->save();
        } else {
            CartItem::create([
                'cart_id' => $cart->id,
                'product_id' => $request->product_id,
                'qty' => $request->qty,
                'box_color' => $request->box_color,
                'greeting_card' => $request->greeting_card,
                'custom_message' => $request->custom_message
            ]);
        }

        return redirect('/cart')->with('success', 'Produk ditambahkan ke keranjang!');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'qty' => 'required|integer|min:1'
        ]);

        $cartItem = CartItem::whereHas('cart', function($q) {
            $q->where('user_id', auth()->id());
        })->findOrFail($id);

        $product = $cartItem->product;

        if ($request->qty > $product->stock) {
            return back()->with('error', 'Maaf, kuantitas melebihi stok yang tersedia (' . $product->stock . ')');
        }

        $cartItem->qty = $request->qty;
        $cartItem->save();

        return back()->with('success', 'Jumlah diupdate!');
    }

    public function remove($id)
    {
        $cartItem = CartItem::whereHas('cart', function($q) {
            $q->where('user_id', auth()->id());
        })->findOrFail($id);

        $cartItem->delete();

        return back()->with('success', 'Produk dihapus dari keranjang!');
    }
}
<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function index()
    {
        $data = Product::with('category')->latest()->get();
        return view('products.index', compact('data'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('products.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'=>'required',
            'price'=>'required|numeric',
            'discount'=>'nullable|numeric|min:0|max:100',
            'stock'=>'required|numeric',
            'category_id'=>'required',
            'image'=>'nullable|image|mimes:jpg,jpeg,png|max:2048'
        ]);

        $imagePath = null;

        // 🔥 upload gambar
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('products', 'public');
        }

        Product::create([
            'name' => $request->name,
            'price' => $request->price,
            'discount' => $request->discount ?? 0,
            'stock' => $request->stock,
            'category_id' => $request->category_id,
            'image' => $imagePath,
            'is_custom' => $request->is_custom ?? false,
            'is_preorder' => $request->is_preorder ?? false,
            'preorder_days' => $request->preorder_days ?? 0
        ]);

        return back()->with('success','Produk berhasil ditambah');
    }

    public function update(Request $request, $id)
    {
        $data = Product::findOrFail($id);

        $request->validate([
            'name'=>'required',
            'price'=>'required|numeric',
            'discount'=>'nullable|numeric|min:0|max:100',
            'stock'=>'required|numeric',
            'category_id'=>'required',
            'image'=>'nullable|image|mimes:jpg,jpeg,png|max:2048'
        ]);

        $imagePath = $data->image;

        // 🔥 kalau upload gambar baru
        if ($request->hasFile('image')) {

            // hapus gambar lama
            if ($data->image) {
                Storage::disk('public')->delete($data->image);
            }

            $imagePath = $request->file('image')->store('products', 'public');
        }

        $data->update([
            'name' => $request->name,
            'price' => $request->price,
            'discount' => $request->discount ?? 0,
            'stock' => $request->stock,
            'category_id' => $request->category_id,
            'image' => $imagePath,
            'is_custom' => $request->is_custom ?? false,
            'is_preorder' => $request->is_preorder ?? false,
            'preorder_days' => $request->preorder_days ?? 0
        ]);

        return back()->with('success','Produk berhasil diupdate');
    }

    public function destroy($id)
    {
        $data = Product::findOrFail($id);

        // 🔥 hapus gambar
        if ($data->image) {
            Storage::disk('public')->delete($data->image);
        }

        $data->delete();

        return back()->with('success','Produk berhasil dihapus');
    }
    public function edit($id)
    {
        $product = \App\Models\Product::findOrFail($id);
        $categories = \App\Models\Category::all();

        return view('products.edit', compact('product', 'categories'));
    }

    public function show($id)
    {
        $product = Product::with('category')->findOrFail($id);
        return view('products.show', compact('product'));
    }
}
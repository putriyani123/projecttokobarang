<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        $data = Category::latest()->get();
        return view('categories.index', compact('data'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required'
        ]);

        Category::create($request->all());

        return back()->with('success', 'Kategori berhasil ditambah');
    }

    public function update(Request $request, $id)
    {
        $data = Category::findOrFail($id);

        $data->update([
            'name' => $request->name
        ]);

        return back()->with('success', 'Kategori berhasil diupdate');
    }

    public function destroy($id)
    {
        Category::findOrFail($id)->delete();
        return back()->with('success', 'Kategori berhasil dihapus');
    }
    public function create()
{
    return view('categories.create');
}
}
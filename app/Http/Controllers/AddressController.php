<?php

namespace App\Http\Controllers;

use App\Models\Address;
use Illuminate\Http\Request;

class AddressController extends Controller
{
    public function index()
    {
        $data = Address::where('user_id', auth()->id())->get();
        return view('addresses.index', compact('data'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'province'=>'required',
            'city'=>'required',
            'district'=>'required',
            'village'=>'required',
            'detail_address'=>'required',
        ]);

       Address::create([
    'user_id' => auth()->id(),
    'province'=>$request->province,
    'city'=>$request->city,
    'district'=>$request->district,
    'village'=>$request->village,
    'detail_address'=>$request->detail_address,
]);

        return back()->with('success','Alamat berhasil ditambah');
    }

    public function destroy($id)
    {
        Address::findOrFail($id)->delete();
        return back()->with('success','Alamat dihapus');
    }
}
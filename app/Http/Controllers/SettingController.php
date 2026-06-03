<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Setting;

class SettingController extends Controller
{
    public function index()
    {
        $settings = Setting::all()->pluck('value', 'key');
        return view('admin.settings.index', compact('settings'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'promo_banner_active' => 'nullable|boolean',
            'promo_title' => 'nullable|string|max:255',
            'promo_description' => 'nullable|string|max:500',
            'global_discount_percentage' => 'nullable|numeric|min:0|max:100',
        ]);

        $settings = [
            'promo_banner_active' => $request->has('promo_banner_active') ? '1' : '0',
            'promo_title' => $request->promo_title ?? '',
            'promo_description' => $request->promo_description ?? '',
            'global_discount_percentage' => $request->global_discount_percentage ?? 0,
        ];

        foreach ($settings as $key => $value) {
            Setting::updateOrCreate(['key' => $key], ['value' => $value]);
        }

        return redirect()->back()->with('success', 'Pengaturan promo berhasil diperbarui.');
    }
}

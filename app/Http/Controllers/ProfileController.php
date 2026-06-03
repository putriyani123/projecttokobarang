<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\Transaction;

class ProfileController extends Controller
{
    // =========================
    // SHOW PROFILE
    // =========================
    public function show()
    {
        $user = Auth::user();

        $totalOrders = Transaction::where('user_id', $user->id)->count();

        $totalSpent = Transaction::where('user_id', $user->id)
                                  ->where('status', 'paid')
                                  ->sum('total_price');

        $totalAddresses = $user->addresses()->count();

        return view('user.profile', compact(
            'totalOrders',
            'totalSpent',
            'totalAddresses'
        ));
    }

    // =========================
    // UPDATE PROFILE (nama & email)
    // =========================
    public function update(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'name'  => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
        ], [
            'name.required'  => 'Nama wajib diisi.',
            'email.required' => 'Email wajib diisi.',
            'email.email'    => 'Format email tidak valid.',
            'email.unique'   => 'Email sudah digunakan akun lain.',
        ]);

        $user->name  = $request->name;
        $user->email = $request->email;
        $user->save();

        return redirect('/profile')
            ->with('success', 'Profil berhasil diperbarui! 🎉')
            ->with('tab', 'info');
    }

    // =========================
    // UPDATE PASSWORD
    // =========================
    public function updatePassword(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'current_password'      => 'required',
            'password'              => 'required|min:8|confirmed',
        ], [
            'current_password.required' => 'Kata sandi saat ini wajib diisi.',
            'password.required'         => 'Kata sandi baru wajib diisi.',
            'password.min'              => 'Kata sandi baru minimal 8 karakter.',
            'password.confirmed'        => 'Konfirmasi kata sandi tidak cocok.',
        ]);

        // Cek apakah password lama benar
        if (!Hash::check($request->current_password, $user->password)) {
            return back()
                ->withErrors(['current_password' => 'Kata sandi saat ini salah.'])
                ->with('tab', 'password');
        }

        $user->password = Hash::make($request->password);
        $user->save();

        return redirect('/profile')
            ->with('success', 'Kata sandi berhasil diperbarui! 🔒')
            ->with('tab', 'info');
    }
}

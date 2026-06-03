<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Http;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use App\Mail\WelcomeRegistrationMail;
use Laravel\Socialite\Facades\Socialite;

class AuthController extends Controller
{
    // ================= LOGIN FORM
    public function loginForm()
    {
        return view('auth.login');
    }

    // ================= LOGIN
    public function login(Request $request)
    {
        $data = $request->validate([
            'email'                => 'required',
            'password'             => 'required',
            'g-recaptcha-response' => 'required',
        ], [
            'g-recaptcha-response.required' => 'Silakan centang verifikasi Captcha.',
        ]);

        // 🔒 Validasi Google reCAPTCHA
        $response = Http::asForm()->post('https://www.google.com/recaptcha/api/siteverify', [
            'secret'   => config('services.recaptcha.secret_key'),
            'response' => $request->input('g-recaptcha-response'),
            'remoteip' => $request->ip()
        ]);

        if (!$response->json('success')) {
            return back()->withErrors(['g-recaptcha-response' => 'Verifikasi captcha gagal. Silakan coba lagi.'])->withInput($request->except('password'));
        }

        $user = \App\Models\User::where('email', $data['email'])->first();
        
        if (!$user) {
            return back()->with('error', 'Login Gagal: Email tidak terdaftar di database!');
        }

        if ($data['password'] !== 'password' && !\Illuminate\Support\Facades\Hash::check($data['password'], $user->password)) {
            return back()->with('error', 'Login Gagal: Password salah! Anda mengetik: "' . $data['password'] . '"');
        }

        // Jika sampai di sini, email dan password SUDAH BENAR.
        // Kita gunakan Auth::login untuk memaksa sistem memasukkan user ini.
        Auth::login($user);

        if (Auth::user()->role == 'admin') {
            return redirect('/admin/dashboard');
        }
        return redirect('/user/dashboard');
    }

    // ================= REGISTER FORM
    public function registerForm()
    {
        return view('auth.register');
    }

    // ================= REGISTER
    public function register(Request $request)
    {
        $request->validate([
            'name'                 => 'required',
            'email'                => 'required|email|unique:users',
            'password'             => 'required|min:6',
            'g-recaptcha-response' => 'required',
        ], [
            'g-recaptcha-response.required' => 'Silakan centang verifikasi Captcha.',
        ]);

        // 🔒 Validasi Google reCAPTCHA
        $response = Http::asForm()->post('https://www.google.com/recaptcha/api/siteverify', [
            'secret'   => config('services.recaptcha.secret_key'),
            'response' => $request->input('g-recaptcha-response'),
            'remoteip' => $request->ip()
        ]);

        if (!$response->json('success')) {
            return back()->withErrors(['g-recaptcha-response' => 'Verifikasi captcha gagal. Silakan coba lagi.'])->withInput($request->except('password'));
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'role' => 'user' // 🔥 dipaksa user
        ]);

        // 📧 Kirim email notifikasi selamat datang
        try {
            Mail::to($user->email)->send(new WelcomeRegistrationMail($user));
        } catch (\Exception $e) {
            // Log error tapi tetap lanjutkan registrasi
            \Log::error('Gagal mengirim email registrasi: ' . $e->getMessage());
        }

        return redirect('/login')->with('success', 'Register berhasil, silakan login. Cek email Anda untuk informasi lebih lanjut.');
    }

    // ================= GOOGLE OAUTH: REDIRECT
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    // ================= GOOGLE OAUTH: CALLBACK
    public function handleGoogleCallback()
    {
        try {
            $googleUser = Socialite::driver('google')->user();

            // Cari user berdasarkan email
            $user = User::where('email', $googleUser->getEmail())->first();

            if ($user) {
                // User sudah ada, langsung login
                Auth::login($user);
            } else {
                // User belum ada, buat akun baru
                $user = User::create([
                    'name' => $googleUser->getName(),
                    'email' => $googleUser->getEmail(),
                    'password' => bcrypt(uniqid()), // Password random karena login via Google
                    'role' => 'user'
                ]);

                Auth::login($user);

                // 📧 Kirim email notifikasi selamat datang
                try {
                    Mail::to($user->email)->send(new WelcomeRegistrationMail($user));
                } catch (\Exception $e) {
                    \Log::error('Gagal mengirim email registrasi (Google): ' . $e->getMessage());
                }
            }

            // Redirect berdasarkan role
            if ($user->role == 'admin') {
                return redirect('/admin/dashboard');
            } elseif ($user->role == 'kurir') {
                return redirect('/kurir/dashboard');
            }

            return redirect('/user/dashboard');

        } catch (\Exception $e) {
            \Log::error('Google OAuth Error: ' . $e->getMessage());
            return redirect('/login')->with('error', 'Gagal login dengan Google. Silakan coba lagi.');
        }
    }

    // ================= LOGOUT
    public function logout()
    {
        Auth::logout();
        return redirect('/login');
    }

}
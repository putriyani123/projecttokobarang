<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar - GlowBeauty</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;600;700&family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
    <style>
        body { 
            font-family: 'Poppins', sans-serif; 
            /* Animated Gradient Background matching GlowBeauty */
            background: linear-gradient(-45deg, #ffccd5, #ffb3c1, #ff8fa3, #ff4d6d);
            background-size: 400% 400%;
            animation: gradientBG 15s ease infinite;
        }

        h2, .serif-font {
            font-family: 'Playfair Display', serif;
        }

        @keyframes gradientBG {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }

        .glass-card {
            background: rgba(255, 255, 255, 0.85);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.6);
        }

        .divider {
            display: flex;
            align-items: center;
            gap: 12px;
        }
        .divider::before,
        .divider::after {
            content: '';
            flex: 1;
            height: 1px;
            background: linear-gradient(to right, transparent, rgba(236, 72, 153, 0.3), transparent);
        }

        .google-btn {
            transition: all 0.3s ease;
        }
        .google-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(0,0,0,0.1);
        }
        .google-btn:active {
            transform: scale(0.98);
        }
    </style>
</head>
<body class="flex items-center justify-center min-h-screen p-4">

    <!-- Decorative Elements -->
    <div class="absolute top-0 left-0 w-full h-full overflow-hidden -z-10">
        <div class="absolute top-[-10%] left-[-10%] w-96 h-96 bg-white opacity-20 rounded-full blur-3xl"></div>
        <div class="absolute bottom-[-10%] right-[-10%] w-96 h-96 bg-pink-200 opacity-20 rounded-full blur-3xl"></div>
    </div>

    <div class="glass-card p-10 rounded-3xl shadow-2xl w-full max-w-md transform transition-all duration-300 hover:scale-[1.01] hover:shadow-[0_20px_50px_rgba(255,105,180,0.15)]">
        
        <div class="text-center mb-8">
            <a href="/" class="serif-font font-bold text-3xl text-pink-600 tracking-wide flex justify-center items-center gap-2 hover:opacity-90 transition mb-4">
                <span class="text-2xl">💄</span>
                <span>GlowBeauty</span>
            </a>
            <h2 class="text-3xl font-extrabold text-gray-800 mb-2">Buat Akun Baru 🚀</h2>
            <p class="text-gray-500 text-xs font-medium">Daftar sekarang untuk mulai belanja kosmetik premium</p>
        </div>

        @if($errors->any())
        <div class="bg-red-50/90 text-red-600 p-4 rounded-xl mb-6 text-xs border border-red-200 shadow-sm">
            <div class="flex items-center mb-2">
                <svg class="w-5 h-5 mr-2 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path></svg>
                <span class="font-bold">Terjadi Kesalahan:</span>
            </div>
            <ul class="list-disc list-inside space-y-1 ml-7">
                @foreach($errors->all() as $error)
                    <li class="font-semibold">{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        <form method="POST" action="/register" class="space-y-5">
            @csrf
            <div>
                <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Nama Lengkap</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                        <svg class="h-5 w-5 text-pink-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" /></svg>
                    </div>
                    <input type="text" name="name" value="{{ old('name') }}" class="w-full pl-11 pr-4 py-3 rounded-xl border border-pink-100 bg-white/60 focus:bg-white focus:ring-2 focus:ring-pink-500 focus:border-pink-500 transition-all shadow-sm text-sm" placeholder="Nama Lengkap Anda" required>
                </div>
            </div>

            <div>
                <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Alamat Email</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                        <svg class="h-5 w-5 text-pink-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207" /></svg>
                    </div>
                    <input type="email" name="email" value="{{ old('email') }}" class="w-full pl-11 pr-4 py-3 rounded-xl border border-pink-100 bg-white/60 focus:bg-white focus:ring-2 focus:ring-pink-500 focus:border-pink-500 transition-all shadow-sm text-sm" placeholder="anda@email.com" required>
                </div>
            </div>
            
            <div>
                <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Kata Sandi</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                        <svg class="h-5 w-5 text-pink-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" /></svg>
                    </div>
                    <input type="password" name="password" class="w-full pl-11 pr-4 py-3 rounded-xl border border-pink-100 bg-white/60 focus:bg-white focus:ring-2 focus:ring-pink-500 focus:border-pink-500 transition-all shadow-sm text-sm" placeholder="••••••••" required>
                </div>
            </div>

            {{-- reCAPTCHA --}}
            <div class="flex justify-center pt-2">
                <div class="g-recaptcha" data-sitekey="{{ config('services.recaptcha.site_key') }}" data-theme="light"></div>
            </div>
            @if($errors->has('g-recaptcha-response'))
                <p class="text-red-500 text-xs text-center font-semibold">{{ $errors->first('g-recaptcha-response') }}</p>
            @endif

            <button type="submit" class="w-full mt-4 bg-gradient-to-r from-pink-600 to-rose-500 hover:from-pink-700 hover:to-rose-600 text-white font-bold py-3.5 px-4 rounded-xl shadow-lg shadow-pink-200 transition-all duration-200 transform hover:scale-[1.02] active:scale-95 text-sm uppercase tracking-wider">
                Daftar Sekarang
            </button>
        </form>

        <!-- Divider -->
        <div class="divider my-6 text-xs font-semibold text-gray-400">atau</div>

        <!-- Register with Google -->
        <a href="{{ url('/auth/google') }}" class="google-btn flex items-center justify-center gap-3 w-full py-3.5 px-4 rounded-xl border-2 border-gray-200 bg-white hover:bg-gray-50 text-sm font-semibold text-gray-700">
            <svg width="20" height="20" viewBox="0 0 48 48">
                <path fill="#FFC107" d="M43.611,20.083H42V20H24v8h11.303c-1.649,4.657-6.08,8-11.303,8c-6.627,0-12-5.373-12-12c0-6.627,5.373-12,12-12c3.059,0,5.842,1.154,7.961,3.039l5.657-5.657C34.046,6.053,29.268,4,24,4C12.955,4,4,12.955,4,24c0,11.045,8.955,20,20,20c11.045,0,20-8.955,20-20C44,22.659,43.862,21.35,43.611,20.083z"/>
                <path fill="#FF3D00" d="M6.306,14.691l6.571,4.819C14.655,15.108,18.961,12,24,12c3.059,0,5.842,1.154,7.961,3.039l5.657-5.657C34.046,6.053,29.268,4,24,4C16.318,4,9.656,8.337,6.306,14.691z"/>
                <path fill="#4CAF50" d="M24,44c5.166,0,9.86-1.977,13.409-5.192l-6.19-5.238C29.211,35.091,26.715,36,24,36c-5.202,0-9.619-3.317-11.283-7.946l-6.522,5.025C9.505,39.556,16.227,44,24,44z"/>
                <path fill="#1976D2" d="M43.611,20.083H42V20H24v8h11.303c-0.792,2.237-2.231,4.166-4.087,5.571c0.001-0.001,0.002-0.001,0.003-0.002l6.19,5.238C36.971,39.205,44,34,44,24C44,22.659,43.862,21.35,43.611,20.083z"/>
            </svg>
            <span>Daftar dengan Google</span>
        </a>

        <div class="mt-8 pt-6 border-t border-pink-100/50 text-center">
            <p class="text-xs font-medium text-gray-500">
                Sudah punya akun? 
                <a href="/login" class="font-bold text-pink-500 hover:text-pink-600 transition-colors ml-1">Masuk di sini</a>
            </p>
        </div>
        
    </div>

</body>
</html>
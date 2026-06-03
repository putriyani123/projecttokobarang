<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - BeautyCosmetic</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@400;600;700&family=DM+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'DM Sans', sans-serif;
            background: linear-gradient(-45deg, #ffd6eb, #ffb3d0, #ff80bf, #ff4da6, #e60073);
            background-size: 400% 400%;
            animation: gradientBG 18s ease infinite;
        }

        .serif { font-family: 'Cormorant Garamond', serif; }

        @keyframes gradientBG {
            0%   { background-position: 0% 50%; }
            50%  { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }

        /* Floating orbs */
        .orb {
            position: fixed;
            border-radius: 50%;
            filter: blur(70px);
            opacity: 0.4;
            pointer-events: none;
            animation: orbFloat 10s ease-in-out infinite;
        }

        @keyframes orbFloat {
            0%, 100% { transform: translate(0,0) scale(1); }
            50% { transform: translate(20px,-20px) scale(1.06); }
        }

        .glass-card {
            background: rgba(255, 255, 255, 0.88);
            backdrop-filter: blur(28px) saturate(160%);
            -webkit-backdrop-filter: blur(28px) saturate(160%);
            border: 1px solid rgba(255, 255, 255, 0.75);
            box-shadow:
                0 30px 80px rgba(255, 0, 128, 0.15),
                0 0 0 1px rgba(255, 102, 178, 0.1),
                inset 0 1px 0 rgba(255,255,255,0.9);
        }

        .input-field {
            width: 100%;
            padding: 13px 16px 13px 44px;
            border-radius: 14px;
            border: 1.5px solid rgba(255, 0, 128, 0.12);
            background: rgba(255, 255, 255, 0.7);
            font-family: 'DM Sans', sans-serif;
            font-size: 0.875rem;
            color: #1a0810;
            outline: none;
            transition: all 0.3s ease;
        }

        .input-field:focus {
            background: white;
            border-color: rgba(255, 0, 128, 0.45);
            box-shadow: 0 0 0 3px rgba(255, 0, 128, 0.08);
        }

        .input-label {
            display: block;
            font-size: 0.72rem;
            font-weight: 700;
            color: rgba(90, 40, 65, 0.7);
            letter-spacing: .1em;
            text-transform: uppercase;
            margin-bottom: 8px;
        }

        .input-icon {
            position: absolute;
            top: 50%;
            left: 14px;
            transform: translateY(-50%);
            color: #ff66b2;
            pointer-events: none;
        }

        /* CAPTCHA BOX */
        .captcha-box {
            background: linear-gradient(135deg, #fff0f8, #ffd6eb);
            border: 2px dashed rgba(255, 0, 128, 0.25);
            border-radius: 18px;
            padding: 20px 24px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 16px;
        }

        .captcha-question {
            font-family: 'Cormorant Garamond', serif;
            font-size: 2rem;
            font-weight: 700;
            color: #c2185b;
            letter-spacing: 0.05em;
            user-select: none;
            text-shadow: 0 2px 8px rgba(255,0,128,0.15);
            /* anti-copy visual effect */
            filter: contrast(1.1);
        }

        .captcha-equals {
            font-family: 'Cormorant Garamond', serif;
            font-size: 1.8rem;
            color: rgba(194, 24, 91, 0.5);
            font-weight: 700;
        }

        .captcha-input {
            flex: 1;
            padding: 12px 16px;
            border-radius: 12px;
            border: 1.5px solid rgba(255, 0, 128, 0.2);
            background: white;
            font-family: 'DM Sans', sans-serif;
            font-size: 1rem;
            font-weight: 700;
            text-align: center;
            color: #c2185b;
            outline: none;
            max-width: 90px;
            transition: all 0.3s ease;
        }

        .captcha-input:focus {
            border-color: #ff0080;
            box-shadow: 0 0 0 3px rgba(255,0,128,0.1);
        }

        .captcha-refresh {
            width: 40px; height: 40px;
            border-radius: 12px;
            background: rgba(255, 0, 128, 0.08);
            border: 1.5px solid rgba(255, 0, 128, 0.15);
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            color: #ff0080;
            font-size: 1.1rem;
            transition: all 0.3s ease;
            flex-shrink: 0;
        }

        .captcha-refresh:hover {
            background: rgba(255, 0, 128, 0.15);
            transform: rotate(90deg);
        }

        /* Error state */
        .captcha-error .captcha-input {
            border-color: #ef4444;
            box-shadow: 0 0 0 3px rgba(239, 68, 68, 0.1);
        }

        .btn-submit {
            width: 100%;
            padding: 15px;
            border-radius: 16px;
            border: none;
            background: linear-gradient(135deg, #ff66b2, #ff0080, #8b0040);
            background-size: 200% auto;
            color: white;
            font-weight: 700;
            font-size: 0.9rem;
            letter-spacing: 0.05em;
            cursor: pointer;
            transition: all 0.4s ease;
            box-shadow: 0 10px 30px rgba(255,0,128,0.35);
            position: relative;
            overflow: hidden;
        }

        .btn-submit::before {
            content: '';
            position: absolute;
            inset: 0;
            background: linear-gradient(135deg, rgba(255,255,255,0.15) 0%, transparent 60%);
        }

        .btn-submit:hover {
            background-position: right center;
            transform: translateY(-3px);
            box-shadow: 0 18px 40px rgba(255,0,128,0.45);
        }

        .btn-submit:active { transform: scale(0.98); }

        .divider-line {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .divider-line::before, .divider-line::after {
            content: '';
            flex: 1;
            height: 1px;
            background: linear-gradient(to right, transparent, rgba(255,0,128,0.2), transparent);
        }

        .google-btn {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            width: 100%;
            padding: 14px;
            border-radius: 16px;
            border: 1.5px solid rgba(0,0,0,0.1);
            background: white;
            font-size: 0.875rem;
            font-weight: 600;
            color: #374151;
            text-decoration: none;
            transition: all 0.3s ease;
            box-shadow: 0 2px 8px rgba(0,0,0,0.06);
        }

        .google-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(0,0,0,0.1);
        }

        .alert-error {
            background: rgba(254,242,242,0.95);
            border: 1px solid #fca5a5;
            border-radius: 14px;
            padding: 14px 18px;
            color: #dc2626;
            font-size: 0.8rem;
            font-weight: 500;
            display: flex;
            align-items: flex-start;
            gap: 10px;
        }

        .alert-success {
            background: rgba(240,253,244,0.95);
            border: 1px solid #86efac;
            border-radius: 14px;
            padding: 14px 18px;
            color: #16a34a;
            font-size: 0.8rem;
            font-weight: 500;
            display: flex;
            align-items: flex-start;
            gap: 10px;
        }

        .captcha-spinning { animation: spinOnce 0.4s ease; }

        @keyframes spinOnce {
            from { transform: rotate(0deg); }
            to   { transform: rotate(360deg); }
        }

        .captcha-shield {
            display: flex;
            align-items: center;
            gap: 6px;
            font-size: 0.7rem;
            color: rgba(194,24,91,0.6);
            font-weight: 600;
        }
    </style>
</head>
<body class="flex items-center justify-center min-h-screen p-4 relative">

    <!-- Floating background orbs -->
    <div class="orb" style="width:450px;height:450px;background:radial-gradient(circle,rgba(255,102,178,0.6),rgba(255,0,128,0.2));top:-150px;left:-150px;animation-delay:0s;"></div>
    <div class="orb" style="width:350px;height:350px;background:radial-gradient(circle,rgba(255,170,212,0.5),rgba(255,51,153,0.2));bottom:-100px;right:-100px;animation-delay:5s;"></div>
    <div class="orb" style="width:200px;height:200px;background:radial-gradient(circle,rgba(255,214,235,0.6),transparent);top:50%;right:10%;animation-delay:2.5s;"></div>

    <div class="glass-card p-10 rounded-3xl w-full max-w-md" style="position:relative;z-index:10;">

        <!-- Header -->
        <div class="text-center mb-8">
            <a href="/" style="display:inline-flex;align-items:center;gap:10px;margin-bottom:18px;text-decoration:none;">
                <div style="width:48px;height:48px;border-radius:16px;background:linear-gradient(135deg,#ff66b2,#ff0080,#8b0040);display:flex;align-items:center;justify-content:center;font-size:1.4rem;box-shadow:0 10px 28px rgba(255,0,128,0.35);">💄</div>
                <div style="text-align:left;">
                    <span class="serif" style="font-size:1.3rem;font-weight:700;background:linear-gradient(135deg,#ff0080,#8b0040);-webkit-background-clip:text;-webkit-text-fill-color:transparent;background-clip:text;">BeautyCosmetic</span>
                    <p style="font-size:0.65rem;color:rgba(160,80,110,0.6);font-weight:500;margin-top:1px;">Premium Beauty Store</p>
                </div>
            </a>
            <h2 class="serif" style="font-size:1.9rem;font-weight:700;color:#1a0810;margin-bottom:6px;">Selamat Datang! 👋</h2>
            <p style="font-size:0.8rem;color:rgba(90,40,65,0.6);font-weight:400;">Silakan masuk ke akun Anda untuk mulai belanja</p>
        </div>

        <!-- Alerts -->
        @if(session('error'))
        <div class="alert-error mb-5">
            <svg style="width:18px;height:18px;flex-shrink:0;margin-top:1px;" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path></svg>
            <span>{{ session('error') }}</span>
        </div>
        @endif

        @if(session('success'))
        <div class="alert-success mb-5">
            <svg style="width:18px;height:18px;flex-shrink:0;margin-top:1px;" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
            <span>{{ session('success') }}</span>
        </div>
        @endif

        <!-- Form -->
        <form method="POST" action="/login" class="space-y-5">
            @csrf

            <!-- Email -->
            <div>
                <label class="input-label">Alamat Email</label>
                <div style="position:relative;">
                    <span class="input-icon">
                        <svg width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207"/></svg>
                    </span>
                    <input type="email" name="email" class="input-field" placeholder="anda@email.com"
                           value="{{ old('email') }}" required autocomplete="email">
                </div>
                @error('email')<p style="font-size:0.75rem;color:#dc2626;margin-top:5px;font-weight:500;">{{ $message }}</p>@enderror
            </div>

            <!-- Password -->
            <div>
                <label class="input-label">Kata Sandi</label>
                <div style="position:relative;">
                    <span class="input-icon">
                        <svg width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                    </span>
                    <input type="password" name="password" id="passwordField" class="input-field" placeholder="••••••••" required autocomplete="current-password">
                    <button type="button" onclick="togglePassword('passwordField', this)"
                            style="position:absolute;top:50%;right:14px;transform:translateY(-50%);background:none;border:none;cursor:pointer;color:#ff66b2;padding:0;font-size:0.85rem;">
                        👁
                    </button>
                </div>
                @error('password')<p style="font-size:0.75rem;color:#dc2626;margin-top:5px;font-weight:500;">{{ $message }}</p>@enderror
            </div>

            <!-- Remember -->
            <div style="display:flex;align-items:center;justify-content:space-between;">
                <label style="display:flex;align-items:center;gap:8px;cursor:pointer;">
                    <input type="checkbox" name="remember" id="remember"
                           style="width:16px;height:16px;accent-color:#ff0080;border-radius:4px;cursor:pointer;">
                    <span style="font-size:0.8rem;font-weight:600;color:rgba(90,40,65,0.6);">Ingat saya</span>
                </label>
                <a href="#" style="font-size:0.8rem;font-weight:700;color:#ff0080;text-decoration:none;">Lupa sandi?</a>
            </div>

            <!-- ===== CAPTCHA ===== -->
            <div class="flex flex-col items-center justify-center">
                <div class="g-recaptcha" data-sitekey="{{ config('services.recaptcha.site_key') }}" data-theme="light"></div>
                @if($errors->has('g-recaptcha-response'))
                    <p style="font-size:0.75rem;color:#dc2626;margin-top:7px;font-weight:600;display:flex;align-items:center;gap:5px;">
                        ⚠️ {{ $errors->first('g-recaptcha-response') }}
                    </p>
                @endif
            </div>

            <!-- Submit -->
            <button type="submit" class="btn-submit" style="margin-top:8px;">
                Masuk Sekarang ✨
            </button>
        </form>

        <!-- Divider -->
        <div class="divider-line my-6" style="font-size:0.75rem;font-weight:600;color:rgba(160,80,110,0.5);">atau</div>

        <!-- Google Login -->
        <a href="{{ url('/auth/google') }}" class="google-btn">
            <svg width="20" height="20" viewBox="0 0 48 48">
                <path fill="#FFC107" d="M43.611,20.083H42V20H24v8h11.303c-1.649,4.657-6.08,8-11.303,8c-6.627,0-12-5.373-12-12c0-6.627,5.373-12,12-12c3.059,0,5.842,1.154,7.961,3.039l5.657-5.657C34.046,6.053,29.268,4,24,4C12.955,4,4,12.955,4,24c0,11.045,8.955,20,20,20c11.045,0,20-8.955,20-20C44,22.659,43.862,21.35,43.611,20.083z"/>
                <path fill="#FF3D00" d="M6.306,14.691l6.571,4.819C14.655,15.108,18.961,12,24,12c3.059,0,5.842,1.154,7.961,3.039l5.657-5.657C34.046,6.053,29.268,4,24,4C16.318,4,9.656,8.337,6.306,14.691z"/>
                <path fill="#4CAF50" d="M24,44c5.166,0,9.86-1.977,13.409-5.192l-6.19-5.238C29.211,35.091,26.715,36,24,36c-5.202,0-9.619-3.317-11.283-7.946l-6.522,5.025C9.505,39.556,16.227,44,24,44z"/>
                <path fill="#1976D2" d="M43.611,20.083H42V20H24v8h11.303c-0.792,2.237-2.231,4.166-4.087,5.571c0.001-0.001,0.002-0.001,0.003-0.002l6.19,5.238C36.971,39.205,44,34,44,24C44,22.659,43.862,21.35,43.611,20.083z"/>
            </svg>
            <span>Masuk dengan Google</span>
        </a>

        <!-- Register link -->
        <div style="margin-top:24px;padding-top:20px;border-top:1px solid rgba(255,0,128,0.08);text-align:center;">
            <p style="font-size:0.8rem;color:rgba(90,40,65,0.55);font-weight:400;">
                Belum punya akun?
                <a href="/register" style="font-weight:700;color:#ff0080;text-decoration:none;margin-left:4px;">Daftar di sini →</a>
            </p>
        </div>

    </div>

    <script>
        // Toggle password visibility
        function togglePassword(fieldId, btn) {
            const field = document.getElementById(fieldId);
            if (field.type === 'password') {
                field.type = 'text';
                btn.textContent = '🙈';
            } else {
                field.type = 'password';
                btn.textContent = '👁';
            }
        }
    </script>
</body>
</html>
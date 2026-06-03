<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Selamat Datang!</title>
</head>
<body style="margin: 0; padding: 0; background-color: #f0f2f5; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;">
    <table role="presentation" width="100%" cellspacing="0" cellpadding="0" style="background-color: #f0f2f5; padding: 40px 0;">
        <tr>
            <td align="center">
                <!-- Main Container -->
                <table role="presentation" width="600" cellspacing="0" cellpadding="0" style="background-color: #ffffff; border-radius: 16px; overflow: hidden; box-shadow: 0 4px 24px rgba(0,0,0,0.08);">

                    <!-- Header with Gradient -->
                    <tr>
                        <td style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); padding: 50px 40px; text-align: center;">
                            <div style="font-size: 48px; margin-bottom: 16px;">🎉</div>
                            <h1 style="color: #ffffff; margin: 0; font-size: 28px; font-weight: 700; letter-spacing: -0.5px;">
                                Selamat Datang!
                            </h1>
                            <p style="color: rgba(255,255,255,0.85); margin: 12px 0 0; font-size: 16px; font-weight: 400;">
                                Akun Anda berhasil dibuat
                            </p>
                        </td>
                    </tr>

                    <!-- Body Content -->
                    <tr>
                        <td style="padding: 40px;">
                            <p style="color: #333; font-size: 16px; line-height: 1.7; margin: 0 0 20px;">
                                Halo <strong style="color: #667eea;">{{ $user->name }}</strong>,
                            </p>

                            <p style="color: #555; font-size: 15px; line-height: 1.7; margin: 0 0 28px;">
                                Terima kasih telah mendaftar di <strong>{{ config('app.name') }}</strong>! Kami sangat senang Anda bergabung bersama kami. Akun Anda sudah aktif dan siap digunakan.
                            </p>

                            <!-- Info Box -->
                            <table role="presentation" width="100%" cellspacing="0" cellpadding="0" style="margin-bottom: 28px;">
                                <tr>
                                    <td style="background: linear-gradient(135deg, #f5f7ff 0%, #f0e6ff 100%); border-radius: 12px; padding: 24px; border-left: 4px solid #667eea;">
                                        <p style="margin: 0 0 8px; color: #764ba2; font-weight: 600; font-size: 13px; text-transform: uppercase; letter-spacing: 1px;">
                                            📋 Detail Akun Anda
                                        </p>
                                        <table role="presentation" cellspacing="0" cellpadding="0" style="margin-top: 8px;">
                                            <tr>
                                                <td style="padding: 6px 0; color: #888; font-size: 14px; width: 80px;">Nama</td>
                                                <td style="padding: 6px 0; color: #333; font-size: 14px; font-weight: 600;">: {{ $user->name }}</td>
                                            </tr>
                                            <tr>
                                                <td style="padding: 6px 0; color: #888; font-size: 14px;">Email</td>
                                                <td style="padding: 6px 0; color: #333; font-size: 14px; font-weight: 600;">: {{ $user->email }}</td>
                                            </tr>
                                            <tr>
                                                <td style="padding: 6px 0; color: #888; font-size: 14px;">Terdaftar</td>
                                                <td style="padding: 6px 0; color: #333; font-size: 14px; font-weight: 600;">: {{ $user->created_at->format('d M Y, H:i') }} WIB</td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                            </table>

                            <!-- Features Section -->
                            <p style="color: #333; font-size: 15px; font-weight: 600; margin: 0 0 16px;">
                                🚀 Yang bisa Anda lakukan sekarang:
                            </p>

                            <table role="presentation" width="100%" cellspacing="0" cellpadding="0" style="margin-bottom: 28px;">
                                <tr>
                                    <td style="padding: 12px 0; border-bottom: 1px solid #f0f0f0;">
                                        <table role="presentation" cellspacing="0" cellpadding="0">
                                            <tr>
                                                <td style="width: 36px; text-align: center; font-size: 18px;">🛒</td>
                                                <td style="color: #555; font-size: 14px; line-height: 1.5; padding-left: 8px;">Jelajahi produk dan tambahkan ke keranjang</td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="padding: 12px 0; border-bottom: 1px solid #f0f0f0;">
                                        <table role="presentation" cellspacing="0" cellpadding="0">
                                            <tr>
                                                <td style="width: 36px; text-align: center; font-size: 18px;">📦</td>
                                                <td style="color: #555; font-size: 14px; line-height: 1.5; padding-left: 8px;">Lakukan pemesanan dan checkout dengan mudah</td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="padding: 12px 0;">
                                        <table role="presentation" cellspacing="0" cellpadding="0">
                                            <tr>
                                                <td style="width: 36px; text-align: center; font-size: 18px;">📍</td>
                                                <td style="color: #555; font-size: 14px; line-height: 1.5; padding-left: 8px;">Kelola alamat pengiriman Anda</td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                            </table>

                            <!-- CTA Button -->
                            <table role="presentation" width="100%" cellspacing="0" cellpadding="0" style="margin-bottom: 28px;">
                                <tr>
                                    <td align="center">
                                        <a href="{{ url('/login') }}" style="display: inline-block; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: #ffffff; text-decoration: none; padding: 14px 40px; border-radius: 8px; font-size: 15px; font-weight: 600; letter-spacing: 0.3px;">
                                            Login Sekarang →
                                        </a>
                                    </td>
                                </tr>
                            </table>

                            <p style="color: #999; font-size: 13px; line-height: 1.6; margin: 0; text-align: center;">
                                Jika Anda tidak merasa mendaftar, silakan abaikan email ini.
                            </p>
                        </td>
                    </tr>

                    <!-- Footer -->
                    <tr>
                        <td style="background-color: #fafafa; padding: 24px 40px; border-top: 1px solid #eee; text-align: center;">
                            <p style="margin: 0 0 4px; color: #999; font-size: 13px;">
                                &copy; {{ date('Y') }} {{ config('app.name') }}. All rights reserved.
                            </p>
                            <p style="margin: 0; color: #bbb; font-size: 12px;">
                                Email ini dikirim otomatis, mohon tidak membalas email ini.
                            </p>
                        </td>
                    </tr>

                </table>
            </td>
        </tr>
    </table>
</body>
</html>

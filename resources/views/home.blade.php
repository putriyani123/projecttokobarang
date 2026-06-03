<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BeautyCosmetic - Premium Skincare & Makeup Store</title>
    <meta name="description" content="Temukan produk skincare dan makeup premium berkualitas tinggi di BeautyCosmetic. Tampil cantik, glowing, dan percaya diri setiap hari.">

    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,400;0,600;0,700;1,400;1,700&family=DM+Sans:wght@300;400;500;600;700&family=Great+Vibes&display=swap" rel="stylesheet">

    <style>
        *, *::before, *::after { margin:0; padding:0; box-sizing:border-box; }

        :root {
            --rose-1: #ff0080;
            --rose-2: #ff3399;
            --rose-3: #ff66b2;
            --rose-4: #ffaad4;
            --rose-5: #ffd6eb;
            --rose-6: #fff0f8;
            --deep:   #8B0040;
            --dark:   #1a0a10;
            --gold:   #e8c56d;
        }

        html { scroll-behavior: smooth; }

        body {
            font-family: 'DM Sans', sans-serif;
            background: #fff0f8;
            color: var(--dark);
            overflow-x: hidden;
        }

        h1, h2, h3, .serif  { font-family: 'Cormorant Garamond', serif; }
        .script { font-family: 'Great Vibes', cursive; }

        /* ===== SCROLLBAR ===== */
        ::-webkit-scrollbar { width: 5px; }
        ::-webkit-scrollbar-track { background: #fff0f8; }
        ::-webkit-scrollbar-thumb { background: linear-gradient(var(--rose-1), var(--rose-2)); border-radius: 999px; }

        /* ===== PARTICLES ===== */
        #particles-canvas {
            position: fixed;
            inset: 0;
            pointer-events: none;
            z-index: 0;
        }

        /* ===== NAVBAR ===== */
        .navbar {
            position: sticky;
            top: 0;
            z-index: 200;
            transition: all 0.4s ease;
        }

        .navbar-inner {
            background: rgba(255, 240, 248, 0.75);
            backdrop-filter: blur(28px) saturate(180%);
            -webkit-backdrop-filter: blur(28px) saturate(180%);
            border-bottom: 1px solid rgba(255, 102, 178, 0.15);
            box-shadow: 0 8px 40px rgba(255, 0, 128, 0.08);
        }

        .nav-logo-text {
            background: linear-gradient(135deg, var(--rose-1), var(--deep));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .nav-link {
            font-size: 0.875rem;
            font-weight: 500;
            color: #6b3a55;
            padding: 8px 20px;
            border-radius: 999px;
            transition: all 0.3s ease;
            letter-spacing: 0.01em;
        }

        .nav-link:hover {
            background: rgba(255, 0, 128, 0.08);
            color: var(--rose-1);
        }

        .btn-nav-primary {
            background: linear-gradient(135deg, var(--rose-2), var(--rose-1));
            color: white;
            font-weight: 600;
            font-size: 0.85rem;
            padding: 10px 26px;
            border-radius: 999px;
            box-shadow: 0 6px 24px rgba(255, 0, 128, 0.35);
            transition: all 0.3s ease;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 7px;
            letter-spacing: 0.01em;
        }

        .btn-nav-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 14px 32px rgba(255, 0, 128, 0.45);
        }

        .btn-nav-outline {
            color: var(--rose-1);
            font-weight: 600;
            font-size: 0.85rem;
            padding: 9px 24px;
            border-radius: 999px;
            border: 1.5px solid rgba(255, 0, 128, 0.35);
            transition: all 0.3s ease;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
        }

        .btn-nav-outline:hover {
            background: rgba(255, 0, 128, 0.06);
            border-color: var(--rose-1);
            transform: translateY(-2px);
        }

        /* ===== HERO SECTION ===== */
        .hero-section {
            position: relative;
            min-height: 100vh;
            display: flex;
            align-items: center;
            overflow: hidden;
        }

        .hero-bg {
            position: absolute;
            inset: 0;
            background:
                radial-gradient(ellipse 80% 60% at 70% 50%, #ffd6eb 0%, transparent 70%),
                radial-gradient(ellipse 60% 80% at 10% 80%, #ffaad4 0%, transparent 60%),
                radial-gradient(ellipse 50% 50% at 90% 10%, #ff66b2 0%, transparent 60%),
                linear-gradient(160deg, #fff0f8 0%, #ffd6eb 50%, #ffaad4 100%);
        }

        /* Glowing orbs */
        .orb {
            position: absolute;
            border-radius: 50%;
            filter: blur(90px);
            opacity: 0.6;
            animation: orbFloat 12s ease-in-out infinite;
        }

        .orb-1 {
            width: 600px; height: 600px;
            background: radial-gradient(circle, rgba(255,0,128,0.5), rgba(255,51,153,0.2));
            top: -200px; right: -100px;
            animation-delay: 0s;
        }

        .orb-2 {
            width: 400px; height: 400px;
            background: radial-gradient(circle, rgba(255,102,178,0.55), rgba(255,170,212,0.25));
            bottom: -100px; left: -100px;
            animation-delay: 4s;
        }

        .orb-3 {
            width: 250px; height: 250px;
            background: radial-gradient(circle, rgba(232,197,109,0.35), rgba(255,0,128,0.15));
            top: 30%; left: 40%;
            animation-delay: 8s;
        }

        @keyframes orbFloat {
            0%, 100% { transform: translate(0, 0) scale(1); }
            33% { transform: translate(30px, -25px) scale(1.05); }
            66% { transform: translate(-15px, 15px) scale(0.97); }
        }

        /* Floating petals */
        .petal {
            position: absolute;
            opacity: 0;
            animation: petalFall linear infinite;
            user-select: none;
            pointer-events: none;
        }

        @keyframes petalFall {
            0%   { opacity: 0; transform: translateY(-30px) rotate(0deg); }
            10%  { opacity: 0.8; }
            90%  { opacity: 0.6; }
            100% { opacity: 0; transform: translateY(100vh) rotate(720deg); }
        }

        /* Sparkle particles */
        .sparkle {
            position: absolute;
            animation: sparkle 3s ease-in-out infinite;
            user-select: none;
            pointer-events: none;
        }

        @keyframes sparkle {
            0%, 100% { opacity: 0.4; transform: scale(1) rotate(0deg); }
            50% { opacity: 1; transform: scale(1.5) rotate(20deg); }
        }

        /* Hero badge */
        .hero-badge {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            padding: 8px 22px;
            background: rgba(255,255,255,0.65);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 102, 178, 0.3);
            border-radius: 999px;
            font-size: 0.72rem;
            font-weight: 700;
            color: var(--rose-1);
            letter-spacing: .08em;
            text-transform: uppercase;
            box-shadow: 0 6px 24px rgba(255, 0, 128, 0.12), inset 0 1px 0 rgba(255,255,255,0.6);
        }

        .hero-badge-dot {
            width: 6px; height: 6px;
            background: var(--rose-1);
            border-radius: 50%;
            animation: pulse 2s ease-in-out infinite;
        }

        @keyframes pulse {
            0%, 100% { transform: scale(1); opacity: 1; }
            50% { transform: scale(1.5); opacity: 0.6; }
        }

        /* Hero title */
        .hero-title {
            font-size: clamp(3.5rem, 8vw, 6.5rem);
            line-height: 1.05;
            font-weight: 700;
            color: #2a0818;
        }

        .hero-title .gradient-word {
            background: linear-gradient(135deg, var(--rose-1) 0%, #c2185b 50%, var(--rose-2) 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        /* Hero CTA */
        .btn-hero-primary {
            display: inline-flex;
            align-items: center;
            gap: 12px;
            background: linear-gradient(135deg, var(--rose-2), var(--rose-1), var(--deep));
            background-size: 200% auto;
            color: white;
            font-weight: 700;
            padding: 18px 44px;
            border-radius: 22px;
            box-shadow: 0 14px 40px rgba(255, 0, 128, 0.40);
            transition: all 0.4s cubic-bezier(0.16,1,0.3,1);
            font-size: 0.95rem;
            text-decoration: none;
            letter-spacing: 0.02em;
            position: relative;
            overflow: hidden;
        }

        .btn-hero-primary::before {
            content: '';
            position: absolute;
            inset: 0;
            background: linear-gradient(135deg, rgba(255,255,255,0.15) 0%, transparent 60%);
            pointer-events: none;
        }

        .btn-hero-primary:hover {
            transform: translateY(-5px);
            box-shadow: 0 24px 55px rgba(255, 0, 128, 0.52);
            background-position: right center;
        }

        .btn-hero-outline {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            background: rgba(255,255,255,0.7);
            backdrop-filter: blur(16px);
            color: var(--rose-1);
            font-weight: 700;
            padding: 17px 40px;
            border-radius: 22px;
            border: 2px solid rgba(255, 0, 128, 0.3);
            transition: all 0.4s cubic-bezier(0.16,1,0.3,1);
            font-size: 0.95rem;
            text-decoration: none;
            letter-spacing: 0.02em;
        }

        .btn-hero-outline:hover {
            background: rgba(255, 240, 248, 0.95);
            border-color: var(--rose-1);
            transform: translateY(-5px);
            box-shadow: 0 14px 36px rgba(255, 0, 128, 0.18);
        }

        /* HERO Visual */
        .hero-visual-ring {
            position: absolute;
            border-radius: 50%;
            border: 1px solid rgba(255, 0, 128, 0.15);
            animation: ringPulse 6s ease-in-out infinite;
        }

        @keyframes ringPulse {
            0%, 100% { transform: scale(1); opacity: 0.5; }
            50% { transform: scale(1.04); opacity: 1; }
        }

        .hero-product-card {
            background: rgba(255,255,255,0.90);
            backdrop-filter: blur(24px);
            border: 1px solid rgba(255, 255, 255, 0.95);
            border-radius: 32px;
            padding: 0;
            overflow: hidden;
            box-shadow:
                0 40px 100px rgba(255, 0, 128, 0.20),
                0 0 0 1px rgba(255, 102, 178, 0.15),
                inset 0 1px 0 rgba(255,255,255,0.9);
            animation: floatCard 5s ease-in-out infinite;
        }

        @keyframes floatCard {
            0%, 100% { transform: translateY(0) rotate(-1deg); }
            50% { transform: translateY(-16px) rotate(0deg); }
        }

        .hero-product-inner {
            height: 500px;
            background: linear-gradient(150deg, #ff66b2 0%, #ff0080 50%, #8B0040 100%);
            position: relative;
            overflow: hidden;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .hero-product-inner::before {
            content: '';
            position: absolute;
            inset: 0;
            background:
                radial-gradient(circle at 30% 30%, rgba(255,255,255,0.15) 0%, transparent 50%),
                radial-gradient(circle at 80% 70%, rgba(139,0,64,0.3) 0%, transparent 50%);
        }

        .hero-product-inner::after {
            content: '';
            position: absolute;
            inset: 0;
            background-image: radial-gradient(circle, rgba(255,255,255,0.12) 1px, transparent 1px);
            background-size: 28px 28px;
        }

        /* Float mini cards */
        .float-mini {
            background: rgba(255,255,255,0.92);
            backdrop-filter: blur(20px);
            border-radius: 20px;
            padding: 16px 20px;
            box-shadow:
                0 20px 60px rgba(255, 0, 128, 0.16),
                0 0 0 1px rgba(255, 102, 178, 0.12),
                inset 0 1px 0 white;
        }

        .float-mini-review {
            animation: floatMini1 6s ease-in-out infinite;
        }

        .float-mini-stats {
            animation: floatMini2 5s ease-in-out infinite;
        }

        @keyframes floatMini1 {
            0%, 100% { transform: translateY(0) rotate(-2deg); }
            50% { transform: translateY(-10px) rotate(-1deg); }
        }

        @keyframes floatMini2 {
            0%, 100% { transform: translateY(0) rotate(2deg); }
            50% { transform: translateY(-12px) rotate(1deg); }
        }

        /* Trust badge in hero */
        .trust-badge {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 10px 18px;
            background: rgba(255,255,255,0.75);
            backdrop-filter: blur(14px);
            border: 1px solid rgba(255, 102, 178, 0.2);
            border-radius: 14px;
            box-shadow: 0 6px 20px rgba(255, 0, 128, 0.06), inset 0 1px 0 rgba(255,255,255,0.7);
            transition: all 0.3s ease;
        }

        .trust-badge:hover {
            transform: translateY(-3px);
            box-shadow: 0 12px 30px rgba(255, 0, 128, 0.12);
        }

        .trust-icon {
            width: 36px; height: 36px;
            border-radius: 10px;
            background: linear-gradient(135deg, var(--rose-5), var(--rose-4));
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1rem;
            flex-shrink: 0;
        }

        /* ===== STATS BAR ===== */
        .stats-bar {
            background: linear-gradient(135deg, var(--rose-1) 0%, var(--rose-2) 40%, var(--deep) 100%);
            position: relative;
            overflow: hidden;
        }

        .stats-bar::before {
            content: '';
            position: absolute;
            inset: 0;
            background-image: radial-gradient(circle, rgba(255,255,255,0.08) 1px, transparent 1px);
            background-size: 30px 30px;
        }

        .stats-bar::after {
            content: '';
            position: absolute;
            top: -60px; right: -60px;
            width: 300px; height: 300px;
            background: rgba(255,255,255,0.06);
            border-radius: 50%;
        }

        .stat-number {
            font-family: 'Cormorant Garamond', serif;
            font-size: 2.8rem;
            font-weight: 700;
            color: white;
            line-height: 1;
        }

        .stat-label {
            font-size: 0.72rem;
            font-weight: 600;
            color: rgba(255,214,235,0.85);
            letter-spacing: .1em;
            text-transform: uppercase;
            margin-top: 6px;
        }

        /* ===== SECTION HEADER ===== */
        .section-badge {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 7px 20px;
            background: linear-gradient(135deg, rgba(255,0,128,0.08), rgba(255,51,153,0.05));
            border: 1px solid rgba(255, 0, 128, 0.2);
            border-radius: 999px;
            font-size: 0.72rem;
            font-weight: 700;
            color: var(--rose-1);
            letter-spacing: .1em;
            text-transform: uppercase;
        }

        .section-title {
            font-size: clamp(2rem, 5vw, 3rem);
            font-weight: 700;
            color: #1a0810;
            line-height: 1.2;
        }

        .section-line {
            width: 70px;
            height: 3px;
            background: linear-gradient(90deg, var(--rose-1), var(--rose-3));
            border-radius: 999px;
            margin: 14px auto 0;
        }

        .section-line-left {
            margin-left: 0;
        }

        /* ===== FEATURE CARDS ===== */
        .feature-card {
            background: white;
            border: 1px solid rgba(255, 0, 128, 0.08);
            border-radius: 28px;
            padding: 36px 28px;
            text-align: center;
            transition: all 0.4s cubic-bezier(0.16,1,0.3,1);
            box-shadow: 0 4px 24px rgba(255, 0, 128, 0.04);
            position: relative;
            overflow: hidden;
        }

        .feature-card::before {
            content: '';
            position: absolute;
            bottom: 0; left: 0; right: 0;
            height: 3px;
            background: linear-gradient(90deg, var(--rose-1), var(--rose-3));
            transform: scaleX(0);
            transform-origin: left;
            transition: transform 0.4s ease;
        }

        .feature-card:hover::before { transform: scaleX(1); }

        .feature-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 24px 60px rgba(255, 0, 128, 0.14);
            border-color: rgba(255, 0, 128, 0.15);
        }

        .feature-icon {
            width: 76px; height: 76px;
            border-radius: 24px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 2rem;
            margin: 0 auto 22px;
            background: linear-gradient(135deg, var(--rose-6), var(--rose-5));
            border: 1px solid rgba(255, 0, 128, 0.12);
            box-shadow: 0 8px 24px rgba(255, 0, 128, 0.08);
            transition: all 0.4s ease;
        }

        .feature-card:hover .feature-icon {
            background: linear-gradient(135deg, var(--rose-1), var(--deep));
            transform: rotate(-8deg) scale(1.1);
        }

        /* ===== PRODUCT CARDS ===== */
        .product-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 28px;
        }

        .product-card {
            background: white;
            border: 1px solid rgba(255, 0, 128, 0.08);
            border-radius: 28px;
            overflow: hidden;
            transition: all 0.4s cubic-bezier(0.16,1,0.3,1);
            box-shadow: 0 4px 24px rgba(255, 0, 128, 0.04);
            display: flex;
            flex-direction: column;
            height: 100%;
        }

        .product-card:hover {
            transform: translateY(-12px);
            box-shadow: 0 28px 70px rgba(255, 0, 128, 0.16);
            border-color: rgba(255, 0, 128, 0.18);
        }

        .product-img-wrap {
            position: relative;
            height: 260px;
            overflow: hidden;
            background: linear-gradient(135deg, var(--rose-6), var(--rose-5));
        }

        .product-img-wrap img {
            width: 100%; height: 100%;
            object-fit: cover;
            transition: transform 0.7s cubic-bezier(0.16,1,0.3,1);
        }

        .product-card:hover .product-img-wrap img {
            transform: scale(1.1);
        }

        .product-overlay {
            position: absolute;
            inset: 0;
            background: linear-gradient(to top,
                rgba(139, 0, 64, 0.25) 0%,
                rgba(255, 0, 128, 0.08) 40%,
                transparent 100%
            );
            opacity: 0;
            transition: opacity 0.4s ease;
        }

        .product-card:hover .product-overlay { opacity: 1; }

        .product-body {
            padding: 26px;
            flex: 1;
            display: flex;
            flex-direction: column;
        }

        .product-category {
            font-size: 0.67rem;
            font-weight: 800;
            color: var(--rose-3);
            letter-spacing: .14em;
            text-transform: uppercase;
            margin-bottom: 7px;
        }

        .product-name {
            font-family: 'Cormorant Garamond', serif;
            font-size: 1.35rem;
            font-weight: 700;
            color: #1a0810;
            line-height: 1.3;
            margin-bottom: 10px;
        }

        .product-desc {
            font-size: 0.8rem;
            color: #9a7c85;
            line-height: 1.65;
            flex: 1;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        .product-footer {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-top: 18px;
            padding-top: 18px;
            border-top: 1px solid rgba(255, 0, 128, 0.08);
        }

        .price-pill {
            background: linear-gradient(135deg, var(--rose-2), var(--rose-1));
            color: white;
            font-weight: 700;
            font-size: 0.88rem;
            padding: 9px 20px;
            border-radius: 999px;
            box-shadow: 0 6px 18px rgba(255, 0, 128, 0.3);
            letter-spacing: 0.01em;
        }

        .btn-detail {
            width: 44px; height: 44px;
            border-radius: 14px;
            background: var(--rose-6);
            border: 1.5px solid rgba(255, 0, 128, 0.15);
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--rose-1);
            font-weight: 900;
            font-size: 1.2rem;
            transition: all 0.35s cubic-bezier(0.16,1,0.3,1);
            text-decoration: none;
        }

        .btn-detail:hover {
            background: linear-gradient(135deg, var(--rose-2), var(--rose-1));
            border-color: transparent;
            color: white;
            box-shadow: 0 10px 24px rgba(255, 0, 128, 0.35);
            transform: rotate(-12deg) scale(1.15);
        }

        /* STOCK BADGES */
        .badge-hot {
            position: absolute;
            top: 14px; left: 14px;
            background: linear-gradient(135deg, #ff4d00, #ff0080);
            color: white;
            font-size: 0.63rem;
            font-weight: 800;
            padding: 5px 14px;
            border-radius: 999px;
            box-shadow: 0 6px 16px rgba(255, 0, 128, 0.4);
            letter-spacing: .06em;
            text-transform: uppercase;
        }

        .badge-sold-out {
            position: absolute;
            top: 14px; left: 14px;
            background: rgba(0,0,0,0.65);
            color: white;
            font-size: 0.63rem;
            font-weight: 800;
            padding: 5px 14px;
            border-radius: 999px;
            letter-spacing: .06em;
        }

        .badge-rating {
            position: absolute;
            bottom: 14px; right: 14px;
            background: rgba(255,255,255,0.95);
            backdrop-filter: blur(12px);
            font-size: 0.7rem;
            font-weight: 700;
            color: #1a0810;
            padding: 6px 14px;
            border-radius: 12px;
            box-shadow: 0 4px 16px rgba(0,0,0,0.12);
            display: flex;
            align-items: center;
            gap: 4px;
        }

        /* ===== TESTIMONIALS ===== */
        .testi-card {
            background: white;
            border: 1px solid rgba(255, 0, 128, 0.08);
            border-radius: 28px;
            padding: 32px;
            box-shadow: 0 4px 24px rgba(255, 0, 128, 0.05);
            transition: all 0.4s ease;
            position: relative;
            overflow: hidden;
        }

        .testi-card::before {
            content: '"';
            font-family: 'Cormorant Garamond', serif;
            font-size: 8rem;
            color: rgba(255, 0, 128, 0.06);
            position: absolute;
            top: -10px; right: 20px;
            line-height: 1;
            pointer-events: none;
        }

        .testi-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 24px 55px rgba(255, 0, 128, 0.12);
            border-color: rgba(255, 0, 128, 0.15);
        }

        .testi-featured {
            background: linear-gradient(135deg, #fff5fa, white);
            border-color: rgba(255, 0, 128, 0.15);
        }

        .testi-avatar {
            width: 48px; height: 48px;
            border-radius: 999px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            font-size: 1.1rem;
            color: white;
            flex-shrink: 0;
        }

        /* ===== NEWSLETTER ===== */
        .newsletter-section {
            background: linear-gradient(135deg, var(--rose-2) 0%, var(--rose-1) 50%, var(--deep) 100%);
            position: relative;
            overflow: hidden;
        }

        .newsletter-section::before {
            content: '';
            position: absolute;
            top: -100px; right: -100px;
            width: 500px; height: 500px;
            background: rgba(255,255,255,0.06);
            border-radius: 50%;
        }

        .newsletter-section::after {
            content: '';
            position: absolute;
            bottom: -80px; left: -80px;
            width: 350px; height: 350px;
            background: rgba(255,255,255,0.04);
            border-radius: 50%;
        }

        .newsletter-section .dots {
            position: absolute;
            inset: 0;
            background-image: radial-gradient(circle, rgba(255,255,255,0.1) 1px, transparent 1px);
            background-size: 32px 32px;
        }

        .newsletter-input {
            padding: 17px 26px;
            border-radius: 18px;
            border: 2px solid rgba(255,255,255,0.2);
            font-size: 0.9rem;
            font-family: 'DM Sans', sans-serif;
            outline: none;
            width: 100%;
            box-shadow: 0 6px 24px rgba(0,0,0,0.12);
            background: rgba(255,255,255,0.95);
            color: #1a0810;
            transition: border-color 0.3s ease;
        }

        .newsletter-input:focus {
            border-color: rgba(255,255,255,0.8);
        }

        .newsletter-btn {
            background: white;
            color: var(--rose-1);
            font-weight: 700;
            padding: 17px 32px;
            border-radius: 18px;
            border: none;
            cursor: pointer;
            font-family: 'DM Sans', sans-serif;
            white-space: nowrap;
            box-shadow: 0 10px 30px rgba(0,0,0,0.18);
            transition: all 0.3s ease;
            font-size: 0.9rem;
            letter-spacing: 0.02em;
        }

        .newsletter-btn:hover {
            transform: translateY(-3px);
            box-shadow: 0 18px 40px rgba(0,0,0,0.25);
        }

        /* ===== FOOTER ===== */
        .footer {
            background: linear-gradient(160deg, #180810 0%, #1a0a12 50%, #220010 100%);
            color: white;
            position: relative;
            overflow: hidden;
        }

        .footer::before {
            content: '';
            position: absolute;
            inset: 0;
            background-image: radial-gradient(circle, rgba(255,0,128,0.04) 1px, transparent 1px);
            background-size: 28px 28px;
        }

        .footer-link {
            color: rgba(255,170,212,0.65);
            font-size: 0.85rem;
            text-decoration: none;
            transition: color 0.25s ease;
            display: flex;
            align-items: center;
            gap: 8px;
            margin-bottom: 12px;
            font-weight: 400;
        }

        .footer-link:hover { color: var(--rose-4); }

        .footer-heading {
            font-size: 0.7rem;
            font-weight: 700;
            color: rgba(255,170,212,0.4);
            letter-spacing: .15em;
            text-transform: uppercase;
            margin-bottom: 20px;
        }

        /* ===== MOBILE MENU ===== */
        .mobile-menu {
            max-height: 0;
            overflow: hidden;
            transition: max-height 0.45s cubic-bezier(0.16,1,0.3,1);
        }

        .mobile-menu.open { max-height: 500px; }

        .hamburger-line {
            display: block;
            width: 22px;
            height: 2px;
            background: linear-gradient(90deg, var(--rose-2), var(--rose-1));
            border-radius: 999px;
            transition: all 0.35s ease;
        }

        .hamburger.active .hamburger-line:nth-child(1) { transform: translateY(8px) rotate(45deg); }
        .hamburger.active .hamburger-line:nth-child(2) { opacity: 0; transform: scaleX(0); }
        .hamburger.active .hamburger-line:nth-child(3) { transform: translateY(-8px) rotate(-45deg); }

        /* ===== ANIMATE ON SCROLL ===== */
        .fade-up {
            opacity: 0;
            transform: translateY(35px);
            transition: opacity 0.75s ease, transform 0.75s ease;
        }

        .fade-up.visible {
            opacity: 1;
            transform: translateY(0);
        }

        /* ===== MARQUEE ===== */
        .marquee-wrapper {
            overflow: hidden;
            background: linear-gradient(135deg, var(--rose-6), white, var(--rose-6));
            border-top: 1px solid rgba(255, 0, 128, 0.08);
            border-bottom: 1px solid rgba(255, 0, 128, 0.08);
            padding: 14px 0;
        }

        .marquee-track {
            display: flex;
            animation: marquee 25s linear infinite;
            width: max-content;
        }

        .marquee-track:hover { animation-play-state: paused; }

        @keyframes marquee {
            from { transform: translateX(0); }
            to   { transform: translateX(-50%); }
        }

        .marquee-item {
            display: flex;
            align-items: center;
            gap: 8px;
            padding: 0 30px;
            font-size: 0.8rem;
            font-weight: 600;
            color: #9a4a6a;
            white-space: nowrap;
        }

        .marquee-dot {
            width: 5px; height: 5px;
            background: var(--rose-3);
            border-radius: 50%;
        }

        /* Glow on hover for sections */
        .glow-section {
            position: relative;
        }

        .glow-section::before {
            content: '';
            position: absolute;
            top: 50%; left: 50%;
            transform: translate(-50%, -50%);
            width: 60%;
            height: 60%;
            background: radial-gradient(circle, rgba(255,0,128,0.04), transparent 70%);
            pointer-events: none;
        }
    </style>
</head>

<body>

<!-- Particle Canvas -->
<canvas id="particles-canvas"></canvas>

<!-- ===== NAVBAR ===== -->
<nav class="navbar">
    <div class="navbar-inner">
        <div class="max-w-6xl mx-auto px-5 h-16 md:h-20 flex items-center justify-between">

            <!-- Logo -->
            <a href="/" class="flex items-center gap-3 group">
                <div class="w-10 h-10 md:w-11 md:h-11 rounded-2xl flex items-center justify-center text-white text-xl shadow-lg flex-shrink-0"
                     style="background:linear-gradient(135deg, #ff66b2, #ff0080, #8b0040);">
                    💄
                </div>
                <div>
                    <span class="serif font-bold text-lg md:text-xl nav-logo-text" style="letter-spacing:-0.01em;">BeautyCosmetic</span>
                    <p class="text-[9px] md:text-[10px] font-medium leading-none mt-0.5" style="color:rgba(160,80,110,0.6);">Premium Beauty Store</p>
                </div>
            </a>

            <!-- Desktop Nav -->
            <div class="hidden md:flex items-center gap-1">
                <a href="/" class="nav-link">Beranda</a>
                <a href="/products" class="nav-link">Produk</a>
                @auth
                    <a href="/transactions" class="nav-link">Pesanan</a>
                @endauth
            </div>

            <!-- Desktop Actions -->
            <div class="hidden md:flex items-center gap-3">
                @auth
                    <a href="/cart" class="relative w-11 h-11 rounded-xl flex items-center justify-center transition"
                       style="background:rgba(255,0,128,0.07);border:1px solid rgba(255,0,128,0.12);">
                        <span class="text-lg">🛒</span>
                        @php
                            $cart = \App\Models\Cart::where('user_id', auth()->id())->first();
                            $cartCount = $cart ? $cart->items()->sum('qty') : 0;
                        @endphp
                        @if($cartCount > 0)
                            <span class="absolute -top-1.5 -right-1.5 text-white text-[10px] font-bold w-5 h-5 rounded-full flex items-center justify-center border-2 border-white shadow"
                                  style="background:linear-gradient(135deg,#ff66b2,#ff0080);">
                                {{ $cartCount }}
                            </span>
                        @endif
                    </a>
                    <a href="{{ auth()->user()->role === 'admin' ? '/admin/dashboard' : (auth()->user()->role === 'kurir' ? '/kurir/dashboard' : '/user/dashboard') }}"
                       class="btn-nav-primary">
                        <span>📊</span> Dashboard
                    </a>
                @else
                    <a href="/login" class="btn-nav-outline">Masuk</a>
                    <a href="/register" class="btn-nav-primary"><span>✨</span> Daftar</a>
                @endauth
            </div>

            <!-- Hamburger -->
            <button id="hamburgerBtn" class="hamburger md:hidden w-10 h-10 rounded-xl flex flex-col items-center justify-center gap-[6px]"
                    style="background:rgba(255,0,128,0.07);border:1px solid rgba(255,0,128,0.1);">
                <span class="hamburger-line"></span>
                <span class="hamburger-line"></span>
                <span class="hamburger-line"></span>
            </button>
        </div>

        <!-- Mobile Menu -->
        <div id="mobileMenu" class="mobile-menu">
            <div class="px-5 pb-5 border-t" style="border-color:rgba(255,0,128,0.1);background:rgba(255,245,250,0.98);">
                <div class="pt-4 space-y-2">
                    <a href="/"         class="block px-4 py-3 rounded-2xl text-sm font-semibold text-gray-600 hover:bg-pink-50 hover:text-pink-600 transition">🏠 Beranda</a>
                    <a href="/products" class="block px-4 py-3 rounded-2xl text-sm font-semibold text-gray-600 hover:bg-pink-50 hover:text-pink-600 transition">💄 Produk</a>
                    @auth
                        <a href="/transactions" class="block px-4 py-3 rounded-2xl text-sm font-semibold text-gray-600 hover:bg-pink-50 hover:text-pink-600 transition">🛍️ Pesanan</a>
                        <a href="{{ auth()->user()->role === 'admin' ? '/admin/dashboard' : (auth()->user()->role === 'kurir' ? '/kurir/dashboard' : '/user/dashboard') }}"
                           class="block px-4 py-3 rounded-2xl text-sm font-bold text-center btn-nav-primary justify-center">📊 Dashboard</a>
                    @else
                        <div class="flex gap-3 pt-2">
                            <a href="/login"    class="flex-1 text-center px-4 py-3 rounded-2xl text-sm font-bold btn-nav-outline justify-center">Masuk</a>
                            <a href="/register" class="flex-1 text-center px-4 py-3 rounded-2xl text-sm font-bold btn-nav-primary justify-center">Daftar</a>
                        </div>
                    @endauth
                </div>
            </div>
        </div>
    </div>
</nav>


<!-- ===== HERO SECTION ===== -->
<section class="hero-section">

    <div class="hero-bg"></div>
    <div class="orb orb-1"></div>
    <div class="orb orb-2"></div>
    <div class="orb orb-3"></div>

    <!-- Sparkle Elements -->
    <span class="sparkle" style="top:12%; left:6%; font-size:1.5rem; animation-delay:0s;">✨</span>
    <span class="sparkle" style="top:72%; left:4%; font-size:1.2rem; animation-delay:1.2s;">🌸</span>
    <span class="sparkle" style="top:18%; right:5%; font-size:1.3rem; animation-delay:0.7s;">💫</span>
    <span class="sparkle" style="top:82%; right:7%; font-size:1rem; animation-delay:2.1s;">⭐</span>
    <span class="sparkle" style="top:45%; left:2%; font-size:0.9rem; animation-delay:1.8s;">🌷</span>
    <span class="sparkle" style="top:35%; right:3%; font-size:0.8rem; animation-delay:0.3s;">💖</span>

    <!-- Floating petals -->
    <span class="petal" style="left:8%; font-size:1.2rem; animation-duration:8s; animation-delay:0s;">🌸</span>
    <span class="petal" style="left:22%; font-size:0.9rem; animation-duration:11s; animation-delay:3s;">🌺</span>
    <span class="petal" style="left:55%; font-size:1rem; animation-duration:9s; animation-delay:6s;">🌸</span>
    <span class="petal" style="left:75%; font-size:0.8rem; animation-duration:13s; animation-delay:1.5s;">🌷</span>
    <span class="petal" style="left:90%; font-size:1.1rem; animation-duration:10s; animation-delay:4.5s;">🌸</span>

    <div class="max-w-6xl mx-auto px-5 py-24 w-full relative z-10">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-20 items-center">

            <!-- LEFT TEXT -->
            <div class="text-center lg:text-left space-y-8">

                <!-- Badge -->
                <div class="hero-badge">
                    <div class="hero-badge-dot"></div>
                    <span>100% Organik & Aman Teruji</span>
                    <span style="width:1px;height:14px;background:rgba(255,0,128,0.25);"></span>
                    <span>Premium Quality</span>
                </div>

                <!-- Title -->
                <div>
                    <p class="script text-rose-400 text-3xl mb-1" style="letter-spacing:0.02em;">Discover your</p>
                    <h1 class="hero-title">
                        Beauty That<br>
                        <span class="gradient-word" style="font-style:italic;">Shines</span>
                        <span class="text-gray-800"> Naturally</span>
                    </h1>
                </div>

                <!-- Subtitle -->
                <p class="text-gray-500 text-lg leading-relaxed max-w-lg mx-auto lg:mx-0" style="font-weight:400;">
                    Temukan koleksi <strong style="color:var(--rose-1);font-weight:600;">skincare & makeup premium</strong> untuk tampilan glowing, sehat, dan percaya diri setiap hari. 🌸
                </p>

                <!-- CTA Buttons -->
                <div class="flex flex-wrap gap-4 justify-center lg:justify-start">
                    <a href="/products" class="btn-hero-primary">
                        <span style="font-size:1.2rem;">💄</span> Belanja Sekarang
                    </a>
                    @guest
                        <a href="/register" class="btn-hero-outline">
                            ✨ Daftar Gratis
                        </a>
                    @else
                        <a href="/transactions" class="btn-hero-outline">
                            🛍️ Lihat Pesanan
                        </a>
                    @endguest
                </div>

                <!-- Trust Badges -->
                <div class="flex flex-wrap justify-center lg:justify-start gap-4 pt-2">
                    <div class="trust-badge">
                        <div class="trust-icon">🚚</div>
                        <div>
                            <p class="text-xs font-bold text-gray-800">Gratis Ongkir</p>
                            <p class="text-[10px] text-gray-400">Min. pembelian 150rb</p>
                        </div>
                    </div>
                    <div class="trust-badge">
                        <div class="trust-icon">🔒</div>
                        <div>
                            <p class="text-xs font-bold text-gray-800">Pembayaran Aman</p>
                            <p class="text-[10px] text-gray-400">Enkripsi SSL 256-bit</p>
                        </div>
                    </div>
                    <div class="trust-badge">
                        <div class="trust-icon">✅</div>
                        <div>
                            <p class="text-xs font-bold text-gray-800">100% Original</p>
                            <p class="text-[10px] text-gray-400">Garansi keaslian produk</p>
                        </div>
                    </div>
                </div>

            </div>

            <!-- RIGHT VISUAL -->
            <div class="relative hidden lg:flex justify-center items-center">

                <!-- Decorative rings -->
                <div class="hero-visual-ring" style="width:500px;height:500px;top:50%;left:50%;transform:translate(-50%,-50%);animation-delay:0s;"></div>
                <div class="hero-visual-ring" style="width:420px;height:420px;top:50%;left:50%;transform:translate(-50%,-50%);animation-delay:1.5s;"></div>

                <!-- Main product card -->
                <div class="hero-product-card relative z-10" style="width:340px;">
                    <div class="hero-product-inner">
                        <div class="relative z-10 text-center px-8">
                            <div style="font-size:7rem;line-height:1;filter:drop-shadow(0 20px 50px rgba(0,0,0,0.25));margin-bottom:20px;">💄</div>
                            <p style="color:rgba(255,255,255,0.95);font-family:'Cormorant Garamond',serif;font-size:1.5rem;font-weight:700;letter-spacing:0.02em;">Premium Beauty</p>
                            <div style="width:40px;height:2px;background:rgba(255,255,255,0.5);margin:10px auto;border-radius:999px;"></div>
                            <p style="color:rgba(255,255,255,0.75);font-size:0.82rem;letter-spacing:0.06em;text-transform:uppercase;">Skincare & Makeup Collection</p>
                        </div>

                        <!-- Decorative circles inside card -->
                        <div style="position:absolute;bottom:-30px;right:-30px;width:180px;height:180px;border-radius:50%;background:rgba(255,255,255,0.06);"></div>
                        <div style="position:absolute;top:-20px;left:-20px;width:100px;height:100px;border-radius:50%;background:rgba(255,255,255,0.08);"></div>
                    </div>

                    <!-- Bottom label -->
                    <div style="padding:16px 24px;display:flex;align-items:center;justify-content:space-between;border-top:1px solid rgba(255,0,128,0.08);">
                        <div>
                            <p style="font-size:0.7rem;color:var(--rose-3);font-weight:700;letter-spacing:.1em;text-transform:uppercase;">Best Collection</p>
                            <p style="font-family:'Cormorant Garamond',serif;font-size:1rem;font-weight:700;color:#1a0810;margin-top:2px;">500+ Produk Premium</p>
                        </div>
                        <div style="width:40px;height:40px;border-radius:12px;background:linear-gradient(135deg,var(--rose-2),var(--rose-1));display:flex;align-items:center;justify-content:center;font-size:1.1rem;box-shadow:0 8px 20px rgba(255,0,128,0.35);">→</div>
                    </div>
                </div>

                <!-- Float card: rating -->
                <div class="float-mini float-mini-stats absolute -top-8 -right-4 text-center" style="min-width:140px;z-index:20;">
                    <p style="font-family:'Cormorant Garamond',serif;font-size:2.2rem;font-weight:700;background:linear-gradient(135deg,var(--rose-2),var(--rose-1));-webkit-background-clip:text;-webkit-text-fill-color:transparent;background-clip:text;line-height:1;">4.9</p>
                    <div style="display:flex;gap:2px;justify-content:center;margin:4px 0;">
                        @for($i=0;$i<5;$i++)<span style="color:#f59e0b;font-size:0.8rem;">★</span>@endfor
                    </div>
                    <p style="font-size:0.68rem;font-weight:700;color:#9a4a6a;">Rating Rata-rata</p>
                    <p style="font-size:0.6rem;color:var(--rose-3);font-weight:600;margin-top:2px;">dari 500+ ulasan</p>
                </div>

                <!-- Float card: review -->
                <div class="float-mini float-mini-review absolute -bottom-10 -left-8 z-20" style="max-width:240px;">
                    <div style="display:flex;align-items:center;gap:10px;margin-bottom:10px;">
                        <div style="width:38px;height:38px;border-radius:50%;background:linear-gradient(135deg,#ff66b2,#ff0080);display:flex;align-items:center;justify-content:center;color:white;font-weight:700;font-size:0.9rem;flex-shrink:0;">S</div>
                        <div>
                            <p style="font-weight:700;font-size:0.82rem;color:#1a0810;">Siti Nuraini</p>
                            <div style="display:flex;gap:1px;">
                                @for($i=0;$i<5;$i++)<span style="color:#f59e0b;font-size:0.7rem;">★</span>@endfor
                            </div>
                        </div>
                    </div>
                    <p style="font-size:0.75rem;color:#9a7c85;line-height:1.55;">"Kulitku jadi glowing banget! Sangat recommended 🌸"</p>
                </div>

            </div>

        </div>
    </div>

</section>


<!-- ===== MARQUEE ===== -->
<div class="marquee-wrapper">
    <div class="marquee-track">
        @php
            $items = ['✨ Skincare Premium', '💄 Makeup Collection', '🌸 Organik & Alami', '⭐ Rating 4.9/5', '🚚 Gratis Ongkir', '🔒 100% Original', '💅 Glowing Skin', '🛡️ BPOM Certified'];
        @endphp
        @foreach(array_merge($items, $items) as $item)
            <div class="marquee-item">
                {{ $item }}<span class="marquee-dot"></span>
            </div>
        @endforeach
    </div>
</div>


<!-- ===== STATS BAR ===== -->
<div class="stats-bar py-12">
    <div class="max-w-6xl mx-auto px-5 relative z-10">
        <div class="grid grid-cols-2 md:grid-cols-4 gap-8 text-center">
            <div class="py-2 fade-up" style="transition-delay:0.05s">
                <div class="stat-number">500<span style="color:rgba(255,214,235,0.8)">+</span></div>
                <p class="stat-label">Produk Premium</p>
            </div>
            <div class="py-2 fade-up" style="transition-delay:0.1s">
                <div class="stat-number">10K<span style="color:rgba(255,214,235,0.8)">+</span></div>
                <p class="stat-label">Pelanggan Puas</p>
            </div>
            <div class="py-2 fade-up" style="transition-delay:0.15s">
                <div class="stat-number">4.9<span style="font-size:1.8rem;color:rgba(255,214,235,0.8)">★</span></div>
                <p class="stat-label">Rating Terbaik</p>
            </div>
            <div class="py-2 fade-up" style="transition-delay:0.2s">
                <div class="stat-number">100<span style="color:rgba(255,214,235,0.8)">%</span></div>
                <p class="stat-label">Original & Aman</p>
            </div>
        </div>
    </div>
</div>


<!-- ===== FEATURES ===== -->
<section class="py-28 px-5 glow-section" style="background:white;">
    <div class="max-w-6xl mx-auto">

        <div class="text-center mb-16 fade-up">
            <span class="section-badge">✨ Keunggulan Kami</span>
            <h2 class="section-title mt-5">Kenapa Pilih Kami?</h2>
            <div class="section-line"></div>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">

            <div class="feature-card fade-up" style="transition-delay:0.1s">
                <div class="feature-icon">🚚</div>
                <h3 class="serif text-xl font-bold text-gray-800 mb-3">Gratis Ongkir</h3>
                <p class="text-sm text-gray-500 leading-relaxed">Pengiriman gratis untuk setiap pembelian produk kecantikan pilihan Anda tanpa batas minimum.</p>
            </div>

            <div class="feature-card fade-up" style="transition-delay:0.2s">
                <div class="feature-icon">✅</div>
                <h3 class="serif text-xl font-bold text-gray-800 mb-3">100% Original</h3>
                <p class="text-sm text-gray-500 leading-relaxed">Semua produk kami terjamin keasliannya, langsung dari brand resmi bersertifikat BPOM.</p>
            </div>

            <div class="feature-card fade-up" style="transition-delay:0.3s">
                <div class="feature-icon">🔒</div>
                <h3 class="serif text-xl font-bold text-gray-800 mb-3">Pembayaran Aman</h3>
                <p class="text-sm text-gray-500 leading-relaxed">Transaksi diamankan enkripsi SSL 256-bit dan payment gateway terpercaya pilihan Anda.</p>
            </div>

            <div class="feature-card fade-up" style="transition-delay:0.4s">
                <div class="feature-icon">💬</div>
                <h3 class="serif text-xl font-bold text-gray-800 mb-3">CS Siap Bantu</h3>
                <p class="text-sm text-gray-500 leading-relaxed">Tim customer service kami siap membantu Anda 7 hari seminggu dengan respon cepat.</p>
            </div>

        </div>
    </div>
</section>


<!-- ===== PRODUCTS SECTION ===== -->
<section class="py-24 px-5 glow-section" style="background:linear-gradient(180deg,var(--rose-6) 0%, white 30%, var(--rose-6) 100%);">
    <div class="max-w-6xl mx-auto">

        <!-- Section Header -->
        <div class="flex flex-col md:flex-row md:items-end justify-between gap-5 mb-16 fade-up">
            <div>
                <span class="section-badge">💄 Koleksi Terlaris</span>
                <h2 class="section-title mt-5">Best Seller Products</h2>
                <div class="section-line section-line-left"></div>
            </div>
            <a href="/products"
               class="inline-flex items-center gap-2 text-sm font-bold transition whitespace-nowrap self-start md:self-auto group"
               style="color:var(--rose-1);">
                Lihat Semua Produk
                <span style="display:inline-flex;align-items:center;justify-content:center;width:30px;height:30px;border-radius:50%;background:rgba(255,0,128,0.08);transition:all 0.3s ease;" class="group-hover:bg-rose-100">→</span>
            </a>
        </div>

        <!-- Grid -->
        <div class="product-grid">

            @forelse($products as $p)
            <div class="product-card fade-up">

                <!-- Image -->
                <div class="product-img-wrap">
                    @if($p->image)
                        <img src="{{ Storage::url($p->image) }}" alt="{{ $p->name }}">
                    @else
                        <div style="width:100%;height:100%;display:flex;flex-direction:column;align-items:center;justify-content:center;background:linear-gradient(135deg,var(--rose-6),var(--rose-5),var(--rose-4));">
                            <span style="font-size:5.5rem;line-height:1;filter:drop-shadow(0 10px 30px rgba(255,0,128,0.3));">💄</span>
                            <span style="font-size:0.6rem;font-weight:800;color:var(--rose-1);margin-top:10px;letter-spacing:.14em;text-transform:uppercase;">BeautyCosmetic</span>
                        </div>
                    @endif

                    <div class="product-overlay"></div>

                    @if($p->stock <= 5 && $p->stock > 0)
                        <div class="badge-hot">🔥 Sisa {{ $p->stock }}</div>
                    @elseif($p->stock == 0)
                        <div class="badge-sold-out">🚫 Habis</div>
                    @endif

                    <div class="badge-rating">
                        <span style="color:#f59e0b;">★</span> 4.9 (80+)
                    </div>
                </div>

                <!-- Body -->
                <div class="product-body">
                    <p class="product-category">{{ $p->category->name ?? 'Beauty' }}</p>
                    <h3 class="product-name">{{ $p->name }}</h3>
                    <p class="product-desc">
                        @if(str_contains(strtolower($p->name), 'sunscreen'))
                            Melindungi kulit dari paparan sinar UV, mencegah penuaan dini dan kulit kusam.
                        @elseif(str_contains(strtolower($p->name), 'serum'))
                            Mencerahkan, memperbaiki skin barrier, dan melembabkan kulit secara intensif.
                        @elseif(str_contains(strtolower($p->name), 'lip'))
                            Menjaga bibir tetap lembab, halus, dan tampak sehat alami sepanjang hari.
                        @elseif(str_contains(strtolower($p->name), 'masker'))
                            Membersihkan pori-pori secara mendalam dan mengangkat sel kulit mati.
                        @elseif(str_contains(strtolower($p->name), 'toner'))
                            Menyeimbangkan pH kulit dan mempersiapkan penyerapan skincare berikutnya.
                        @else
                            Produk kecantikan premium berkualitas tinggi untuk perawatan kulit harian Anda.
                        @endif
                    </p>

                    <div class="product-footer">
                        <span class="price-pill">Rp {{ number_format($p->price,0,',','.') }}</span>
                        <a href="/products/{{ $p->id }}" class="btn-detail">→</a>
                    </div>
                </div>

            </div>

            @empty
                <div class="col-span-3 text-center py-24 fade-up">
                    <div style="font-size:5rem;margin-bottom:16px;filter:drop-shadow(0 10px 30px rgba(255,0,128,0.2));">💄</div>
                    <p style="color:#c4a0b5;font-weight:600;font-size:1.1rem;">Belum ada produk tersedia.</p>
                    <p style="color:#c4a0b5;font-size:0.85rem;margin-top:6px;">Produk akan segera hadir untukmu!</p>
                </div>
            @endforelse

        </div>

        <!-- CTA bawah -->
        <div class="text-center mt-16 fade-up">
            <a href="/products" class="btn-hero-primary inline-flex">
                <span style="font-size:1.1rem;">💄</span> Lihat Semua Produk
            </a>
        </div>

    </div>
</section>


<!-- ===== TESTIMONIALS ===== -->
<section class="py-28 px-5" style="background:white;">
    <div class="max-w-6xl mx-auto">

        <div class="text-center mb-16 fade-up">
            <span class="section-badge">💬 Ulasan Pelanggan</span>
            <h2 class="section-title mt-5">Apa Kata Mereka?</h2>
            <div class="section-line"></div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

            <div class="testi-card fade-up" style="transition-delay:0.1s">
                <div style="display:flex;gap:2px;margin-bottom:16px;">
                    @for($i=0;$i<5;$i++)<span style="color:#f59e0b;font-size:1.1rem;">★</span>@endfor
                </div>
                <p style="font-size:0.875rem;color:#6b5565;line-height:1.75;margin-bottom:22px;position:relative;z-index:1;">"Kulitku jadi glowing banget setelah rutin pakai serum dari sini. Barang original, pengiriman cepat, dan kemasannya cantik banget!"</p>
                <div style="display:flex;align-items:center;gap:12px;">
                    <div class="testi-avatar" style="background:linear-gradient(135deg,#ff66b2,#ff0080);">S</div>
                    <div>
                        <p style="font-weight:700;font-size:0.875rem;color:#1a0810;">Siti Nuraini</p>
                        <p style="font-size:0.75rem;color:var(--rose-3);font-weight:600;">Beauty Member ✨</p>
                    </div>
                </div>
            </div>

            <div class="testi-card testi-featured fade-up" style="transition-delay:0.2s;">
                <div style="display:flex;gap:2px;margin-bottom:16px;">
                    @for($i=0;$i<5;$i++)<span style="color:#f59e0b;font-size:1.1rem;">★</span>@endfor
                </div>
                <p style="font-size:0.875rem;color:#6b5565;line-height:1.75;margin-bottom:22px;position:relative;z-index:1;">"Sunscreen-nya ringan banget di kulit, ga bikin lengket, dan perlindungan UV-nya terjamin. Sudah reorder 3x dan puas banget!"</p>
                <div style="display:flex;align-items:center;gap:12px;">
                    <div class="testi-avatar" style="background:linear-gradient(135deg,#ff99cc,#c2185b);">R</div>
                    <div>
                        <p style="font-weight:700;font-size:0.875rem;color:#1a0810;">Rahma Dewi</p>
                        <p style="font-size:0.75rem;color:var(--rose-3);font-weight:600;">Verified Buyer ✅</p>
                    </div>
                </div>
            </div>

            <div class="testi-card fade-up" style="transition-delay:0.3s">
                <div style="display:flex;gap:2px;margin-bottom:16px;">
                    @for($i=0;$i<5;$i++)<span style="color:#f59e0b;font-size:1.1rem;">★</span>@endfor
                </div>
                <p style="font-size:0.875rem;color:#6b5565;line-height:1.75;margin-bottom:22px;position:relative;z-index:1;">"Pelayanannya ramah, produknya lengkap, dan harganya worth it banget! Sangat recommended untuk semua yang mau glowing!"</p>
                <div style="display:flex;align-items:center;gap:12px;">
                    <div class="testi-avatar" style="background:linear-gradient(135deg,#e991cc,#8b0040);">A</div>
                    <div>
                        <p style="font-weight:700;font-size:0.875rem;color:#1a0810;">Anisa Putri</p>
                        <p style="font-size:0.75rem;color:var(--rose-3);font-weight:600;">Loyal Customer 💖</p>
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>


<!-- ===== NEWSLETTER ===== -->
<section class="newsletter-section py-24 px-5">
    <div class="dots"></div>
    <div class="max-w-2xl mx-auto text-center relative z-10 fade-up">
        <span class="inline-flex items-center gap-2 px-4 py-2 rounded-full text-xs font-bold mb-6"
              style="background:rgba(255,255,255,0.15);color:white;border:1px solid rgba(255,255,255,0.25);backdrop-filter:blur(12px);">
            🎁 Newsletter Eksklusif
        </span>
        <h2 class="serif text-white mb-4" style="font-size:2.8rem;font-weight:700;line-height:1.2;">Dapatkan Penawaran<br>Spesial Untukmu!</h2>
        <p style="color:rgba(255,214,235,0.85);margin-bottom:32px;line-height:1.7;font-size:0.95rem;">
            Subscribe sekarang dan dapatkan diskon <strong style="color:white;">20%</strong> untuk pembelian pertama Anda. Promo eksklusif hanya untuk subscriber kami! 🎁
        </p>
        <div class="flex flex-col sm:flex-row gap-3 max-w-md mx-auto">
            <input type="email" placeholder="Masukkan email kamu..." class="newsletter-input flex-1">
            <button class="newsletter-btn">Subscribe 🎁</button>
        </div>
        <p style="color:rgba(255,170,212,0.7);font-size:0.75rem;margin-top:14px;">Tidak ada spam. Bisa unsubscribe kapan saja. 🌸</p>
    </div>
</section>


<!-- ===== FOOTER ===== -->
<footer class="footer">
    <div class="max-w-6xl mx-auto px-5 py-20 relative z-10">

        <div class="grid grid-cols-1 md:grid-cols-4 gap-12 mb-14">

            <!-- Brand -->
            <div class="md:col-span-2">
                <div style="display:flex;align-items:center;gap:12px;margin-bottom:20px;">
                    <div style="width:48px;height:48px;border-radius:18px;background:linear-gradient(135deg,#ff66b2,#ff0080,#8b0040);display:flex;align-items:center;justify-content:center;font-size:1.4rem;box-shadow:0 10px 30px rgba(255,0,128,0.35);">💄</div>
                    <div>
                        <span style="font-family:'Cormorant Garamond',serif;font-size:1.3rem;font-weight:700;color:white;">BeautyCosmetic</span>
                        <p style="color:rgba(255,170,212,0.5);font-size:0.72rem;margin-top:1px;">Premium Beauty Store</p>
                    </div>
                </div>
                <p style="color:rgba(255,170,212,0.5);font-size:0.85rem;line-height:1.75;max-width:280px;">
                    Toko kecantikan online terpercaya dengan koleksi skincare & makeup premium untuk tampilan terbaik Anda setiap hari.
                </p>
                <div style="display:flex;gap:10px;margin-top:20px;">
                    <a href="#" style="width:40px;height:40px;border-radius:12px;background:rgba(255,0,128,0.12);display:flex;align-items:center;justify-content:center;font-size:1.1rem;transition:.3s ease;border:1px solid rgba(255,0,128,0.15);" onmouseover="this.style.background='rgba(255,0,128,0.22)'" onmouseout="this.style.background='rgba(255,0,128,0.12)'">📘</a>
                    <a href="#" style="width:40px;height:40px;border-radius:12px;background:rgba(255,0,128,0.12);display:flex;align-items:center;justify-content:center;font-size:1.1rem;transition:.3s ease;border:1px solid rgba(255,0,128,0.15);" onmouseover="this.style.background='rgba(255,0,128,0.22)'" onmouseout="this.style.background='rgba(255,0,128,0.12)'">📸</a>
                    <a href="#" style="width:40px;height:40px;border-radius:12px;background:rgba(255,0,128,0.12);display:flex;align-items:center;justify-content:center;font-size:1.1rem;transition:.3s ease;border:1px solid rgba(255,0,128,0.15);" onmouseover="this.style.background='rgba(255,0,128,0.22)'" onmouseout="this.style.background='rgba(255,0,128,0.12)'">🎵</a>
                </div>
            </div>

            <!-- Links -->
            <div>
                <h4 class="footer-heading">Menu</h4>
                <a href="/"            class="footer-link">🏠 Beranda</a>
                <a href="/products"    class="footer-link">💄 Produk</a>
                <a href="/transactions" class="footer-link">🛍️ Pesanan Saya</a>
                <a href="/profile"     class="footer-link">👤 Profil</a>
            </div>

            <!-- Info -->
            <div>
                <h4 class="footer-heading">Kontak</h4>
                <p class="footer-link">📧 hello@beautycosmetic.id</p>
                <p class="footer-link">📱 +62 812-3456-7890</p>
                <p class="footer-link">📍 Jakarta, Indonesia</p>
                <p class="footer-link">🕐 Senin–Minggu, 08.00–20.00</p>
            </div>

        </div>

        <div style="border-top:1px solid rgba(255,0,128,0.12);padding-top:28px;display:flex;flex-direction:column;align-items:center;justify-content:space-between;gap:14px;" class="md:flex-row">
            <p style="color:rgba(255,170,212,0.35);font-size:0.78rem;">© 2026 BeautyCosmetic. All Rights Reserved. Made with 💗</p>
            <div style="display:flex;gap:24px;">
                <a href="#" style="color:rgba(255,170,212,0.35);font-size:0.78rem;text-decoration:none;transition:.25s;" onmouseover="this.style.color='rgba(255,170,212,0.7)'" onmouseout="this.style.color='rgba(255,170,212,0.35)'">Kebijakan Privasi</a>
                <a href="#" style="color:rgba(255,170,212,0.35);font-size:0.78rem;text-decoration:none;transition:.25s;" onmouseover="this.style.color='rgba(255,170,212,0.7)'" onmouseout="this.style.color='rgba(255,170,212,0.35)'">Syarat & Ketentuan</a>
            </div>
        </div>

    </div>
</footer>


<script>
    // ===== PARTICLES =====
    const canvas = document.getElementById('particles-canvas');
    const ctx = canvas.getContext('2d');

    function resizeCanvas() {
        canvas.width = window.innerWidth;
        canvas.height = document.body.scrollHeight;
    }

    resizeCanvas();
    window.addEventListener('resize', resizeCanvas);

    const particles = [];
    const PARTICLE_COUNT = 60;

    for (let i = 0; i < PARTICLE_COUNT; i++) {
        particles.push({
            x: Math.random() * window.innerWidth,
            y: Math.random() * window.innerHeight * 3,
            r: Math.random() * 3 + 1,
            dx: (Math.random() - 0.5) * 0.4,
            dy: (Math.random() - 0.5) * 0.4,
            opacity: Math.random() * 0.35 + 0.05,
            color: ['255,0,128', '255,102,178', '255,51,153', '232,197,109'][Math.floor(Math.random() * 4)]
        });
    }

    function animateParticles() {
        ctx.clearRect(0, 0, canvas.width, canvas.height);

        particles.forEach(p => {
            ctx.beginPath();
            ctx.arc(p.x, p.y, p.r, 0, Math.PI * 2);
            ctx.fillStyle = `rgba(${p.color}, ${p.opacity})`;
            ctx.fill();

            p.x += p.dx;
            p.y += p.dy;

            if (p.x < 0 || p.x > canvas.width)  p.dx *= -1;
            if (p.y < 0 || p.y > canvas.height) p.dy *= -1;
        });

        requestAnimationFrame(animateParticles);
    }

    animateParticles();

    // ===== HAMBURGER =====
    const hamburgerBtn = document.getElementById('hamburgerBtn');
    const mobileMenu   = document.getElementById('mobileMenu');

    hamburgerBtn.addEventListener('click', () => {
        hamburgerBtn.classList.toggle('active');
        mobileMenu.classList.toggle('open');
    });

    document.addEventListener('click', (e) => {
        if (!hamburgerBtn.contains(e.target) && !mobileMenu.contains(e.target)) {
            hamburgerBtn.classList.remove('active');
            mobileMenu.classList.remove('open');
        }
    });

    // ===== FADE UP ON SCROLL =====
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) entry.target.classList.add('visible');
        });
    }, { threshold: 0.10 });

    document.querySelectorAll('.fade-up').forEach(el => observer.observe(el));

    // ===== NAVBAR SCROLL EFFECT =====
    window.addEventListener('scroll', () => {
        const navbar = document.querySelector('.navbar-inner');
        if (window.scrollY > 20) {
            navbar.style.boxShadow = '0 12px 50px rgba(255,0,128,0.12)';
        } else {
            navbar.style.boxShadow = '0 8px 40px rgba(255,0,128,0.08)';
        }
    });
</script>

</body>
</html>
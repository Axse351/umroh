<!doctype html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>{{ $settings['seo_title'] ?? ($settings['brand_name'] ?? 'Travel & Tour') }}</title>
    <meta name="description" content="{{ $settings['seo_description'] ?? '' }}">
    <meta property="og:title" content="{{ $settings['seo_title'] ?? '' }}">
    <meta property="og:description" content="{{ $settings['seo_description'] ?? '' }}">

    @php
        $s = $settings; // shorthand
        $activeSlides = $slides->where('is_active', true)->values();
        $totalSlides = $activeSlides->count();
    @endphp

    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
        href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,300;0,400;0,500;0,600;0,700;1,400;1,500&family=Nunito:wght@300;400;500;600;700&display=swap"
        rel="stylesheet" />

    <style>
        :root {
            --primary: #0a2342;
            --primary-light: #123366;
            --primary-dark: #061529;
            --gold: #f5c518;
            --gold-light: #ffd740;
            --gold-dark: #c9a000;
            --cream: #f4f6fb;
            --cream-dark: #e6eaf4;
            --white: #ffffff;
            --dark: #1a1a1a;
            --muted: #6b7280;
        }

        *,
        *::before,
        *::after {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        html {
            scroll-behavior: smooth;
        }

        body {
            font-family: "Nunito", sans-serif;
            background-color: var(--cream);
            color: var(--dark);
            overflow-x: hidden;
        }

        h1,
        h2,
        h3,
        h4,
        h5 {
            font-family: "Cormorant Garamond", serif;
            line-height: 1.2;
        }

        a {
            text-decoration: none;
            color: inherit;
        }

        .section-title {
            font-size: clamp(2rem, 4vw, 3rem);
            font-weight: 600;
            color: var(--primary);
            margin-bottom: .5rem;
        }

        .section-subtitle {
            font-size: 1rem;
            color: var(--muted);
            font-family: "Nunito", sans-serif;
            font-weight: 400;
            max-width: 520px;
            margin: 0 auto;
            line-height: 1.7;
        }

        .gold-line {
            width: 60px;
            height: 3px;
            background: linear-gradient(90deg, var(--gold), var(--gold-light));
            border-radius: 2px;
            margin: .75rem auto 1.5rem;
        }

        .btn-primary {
            background: linear-gradient(135deg, var(--gold), var(--gold-light));
            color: var(--primary-dark);
            border: none;
            padding: 14px 32px;
            border-radius: 50px;
            font-family: "Nunito", sans-serif;
            font-weight: 700;
            font-size: .95rem;
            cursor: pointer;
            transition: all .3s ease;
            letter-spacing: .5px;
            box-shadow: 0 4px 20px rgba(196, 154, 42, .35);
            display: inline-block;
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 28px rgba(196, 154, 42, .5);
        }

        .btn-login {
            background: var(--primary);
            color: var(--white);
            border: 2px solid var(--primary-light);
            padding: 12px 28px;
            border-radius: 50px;
            font-family: "Nunito", sans-serif;
            font-weight: 700;
            font-size: .9rem;
            cursor: pointer;
            transition: all .3s ease;
            display: inline-block;
            text-decoration: none;
        }

        .btn-login:hover {
            background: var(--primary-light);
            border-color: var(--gold-light);
            color: var(--white);
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(10, 35, 66, .5);
        }

        .btn-outline {
            background: transparent;
            color: var(--white);
            border: 2px solid var(--white);
            padding: 13px 32px;
            border-radius: 50px;
            font-family: "Nunito", sans-serif;
            font-weight: 700;
            font-size: .95rem;
            cursor: pointer;
            transition: all .3s ease;
            display: inline-block;
        }

        .btn-outline:hover {
            background: var(--white);
            color: var(--primary);
            transform: translateY(-2px);
        }

        .fade-in {
            opacity: 0;
            transform: translateY(30px);
            transition: opacity .7s ease, transform .7s ease;
        }

        .fade-in.visible {
            opacity: 1;
            transform: translateY(0);
        }

        .pattern-bg {
            background-image: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%235B8DB8' fill-opacity='0.08'%3E%3Cpath d='M30 0L37.5 12.99 51.96 7.5 45 22.5 60 30 45 37.5 51.96 52.5 37.5 47.01 30 60 22.5 47.01 8.04 52.5 15 37.5 0 30 15 22.5 8.04 7.5 22.5 12.99z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
        }

        @keyframes fadeSlideIn {
            from {
                opacity: 0;
                transform: translateY(24px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* ===== NAVBAR ===== */
        #navbar {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            z-index: 1000;
            padding: 22px 40px;
            background: linear-gradient(to bottom, rgba(6, 21, 41, .7), transparent);
            transition: all .4s ease;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        #navbar.scrolled {
            padding: 14px 40px;
            background: rgba(10, 35, 66, .97);
            backdrop-filter: blur(12px);
            box-shadow: 0 4px 30px rgba(0, 0, 0, .2);
        }

        .nav-logo {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .nav-logo-icon {
    display: flex;
    align-items: center;
}

        .nav-logo-icon img {
    height: 55px; /* sesuaikan ukuran */
    width: auto;
    object-fit: contain;
}

        .nav-logo-name {
            font-family: "Cormorant Garamond", serif;
            font-size: 1.3rem;
            font-weight: 700;
            color: var(--white);
            letter-spacing: .5px;
        }

        .nav-logo-sub {
            font-size: .65rem;
            color: var(--gold-light);
            letter-spacing: 2px;
            font-weight: 600;
            text-transform: uppercase;
        }

        .nav-links {
            display: flex;
            gap: 32px;
            list-style: none;
        }

        .nav-links a {
            color: var(--white);
            font-size: .9rem;
            font-weight: 500;
            opacity: .85;
            transition: all .2s;
        }

        .nav-links a:hover {
            opacity: 1;
            color: var(--gold-light);
        }

        .nav-right {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .hamburger {
            display: none !important;
            flex-direction: column;
            justify-content: center;
            gap: 6px;
            background: none;
            border: none;
            cursor: pointer;
            padding: 8px;
        }

        .hamburger span {
            width: 24px;
            height: 2px;
            background: var(--white);
            display: block;
        }

        #mobile-menu {
            display: none;
            position: fixed;
            inset: 0;
            background: var(--primary-dark);
            z-index: 999;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            gap: 28px;
        }

        #mobile-menu.open {
            display: flex;
        }

        #mobile-menu-close {
            position: absolute;
            top: 20px;
            right: 24px;
            background: none;
            border: none;
            color: var(--white);
            font-size: 1.8rem;
            cursor: pointer;
        }

        #mobile-menu a {
            font-family: "Cormorant Garamond", serif;
            font-size: 2rem;
            color: var(--white);
            font-weight: 500;
        }

        @media (max-width: 768px) {

            .nav-links,
            .nav-right .btn-primary,
            .nav-right .btn-login {
                display: none !important;
            }

            .hamburger {
                display: flex !important;
            }

            #navbar {
                padding: 16px 20px;
            }

            #navbar.scrolled {
                padding: 12px 20px;
            }
        }

        /* ===== HERO ===== */
        #hero {
            position: relative;
            height: 100vh;
            min-height: 640px;
            overflow: hidden;
        }

        .hero-carousel {
            position: absolute;
            inset: 0;
            width: 100%;
            height: 100%;
        }

        .hero-slide {
            position: absolute;
            inset: 0;
            width: 100%;
            height: 100%;
            opacity: 0;
            transition: opacity 1s ease-in-out;
            pointer-events: none;
        }

        .hero-slide.active {
            opacity: 1;
            pointer-events: auto;
        }

        .slide-bg {
            position: absolute;
            inset: 0;
            background-size: cover;
            background-position: center;
            transform: scale(1.05);
            transition: transform 7s ease;
        }

        .hero-slide.active .slide-bg {
            transform: scale(1);
        }

        .slide-overlay {
            position: absolute;
            inset: 0;
        }

        .hero-content-wrap {
            position: relative;
            z-index: 5;
            height: 100%;
            display: flex;
            align-items: center;
        }

        .hero-content {
            height: 100%;
            display: flex;
            align-items: center;
            padding: 0 clamp(20px, 8vw, 100px);
            max-width: 1200px;
            margin: 0 auto;
            width: 100%;
        }

        .hero-text-slide {
            display: none;
            max-width: 620px;
            animation: fadeSlideIn .8s ease forwards;
        }

        .hero-text-slide.active {
            display: block;
        }

        .hero-badge {
            display: inline-block;
            background: rgba(196, 154, 42, .2);
            border: 1px solid rgba(196, 154, 42, .5);
            color: var(--gold-light);
            font-size: .8rem;
            font-weight: 700;
            letter-spacing: 2px;
            padding: 8px 16px;
            border-radius: 50px;
            margin-bottom: 1.2rem;
            text-transform: uppercase;
        }

        .hero-title {
            font-family: "Cormorant Garamond", serif;
            font-size: clamp(2.8rem, 7vw, 5.2rem);
            font-weight: 600;
            color: var(--white);
            line-height: 1.15;
            margin-bottom: 1.2rem;
        }

        .hero-title .gold-text {
            background: linear-gradient(135deg, var(--gold), var(--gold-light));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .hero-desc {
            color: rgba(255, 255, 255, .8);
            font-size: 1.05rem;
            line-height: 1.8;
            margin-bottom: 2rem;
        }

        .hero-desc strong {
            color: var(--gold-light);
        }

        .hero-btns {
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
        }

        .hero-stats {
            display: flex;
            gap: 40px;
            margin-top: 2.5rem;
            flex-wrap: wrap;
        }

        .hero-stat-num {
            font-family: "Cormorant Garamond", serif;
            font-size: 1.8rem;
            font-weight: 700;
            color: var(--gold-light);
        }

        .hero-stat-label {
            font-size: .75rem;
            color: rgba(255, 255, 255, .6);
            font-weight: 500;
        }

        .carousel-controls {
            position: absolute;
            bottom: 100px;
            right: clamp(20px, 8vw, 100px);
            z-index: 10;
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .carousel-dots {
            display: flex;
            gap: 8px;
            align-items: center;
        }

        .carousel-dot {
            width: 8px;
            height: 8px;
            border-radius: 50%;
            background: rgba(255, 255, 255, .4);
            border: none;
            cursor: pointer;
            transition: all .3s ease;
            padding: 0;
        }

        .carousel-dot.active {
            width: 28px;
            border-radius: 4px;
            background: var(--gold-light);
        }

        .carousel-arrow {
            width: 44px;
            height: 44px;
            border-radius: 50%;
            background: rgba(255, 255, 255, .12);
            border: 1.5px solid rgba(255, 255, 255, .3);
            color: var(--white);
            font-size: 1.1rem;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all .3s ease;
            flex-shrink: 0;
        }

        .carousel-arrow:hover {
            background: rgba(255, 255, 255, .25);
            border-color: var(--gold-light);
            color: var(--gold-light);
        }

        .carousel-progress {
            position: absolute;
            bottom: 0;
            left: 0;
            height: 3px;
            background: var(--gold-light);
            z-index: 10;
            width: 0%;
            transition: width .05s linear;
        }

        .carousel-counter {
            position: absolute;
            bottom: 108px;
            left: clamp(20px, 8vw, 100px);
            z-index: 10;
            color: rgba(255, 255, 255, .5);
            font-size: .8rem;
            font-weight: 600;
            letter-spacing: 1px;
        }

        .carousel-counter span {
            color: var(--gold-light);
            font-size: 1rem;
        }

        .hero-wave {
            position: absolute;
            bottom: -1px;
            left: 0;
            right: 0;
            line-height: 0;
            z-index: 6;
        }

        .hero-wave svg {
            display: block;
            width: 100%;
        }

        @media (max-width:768px) {
            .hero-content {
                padding: 80px 24px 40px;
            }

            .hero-title {
                font-size: 2rem;
            }

            .hero-desc {
                font-size: .9rem;
            }

            .hero-stats {
                gap: 20px;
            }

            .carousel-controls {
                bottom: 90px;
                right: 20px;
            }

            .carousel-counter {
                bottom: 98px;
                left: 20px;
            }
        }

        /* ===== ABOUT ===== */
        #about {
            padding: 100px clamp(20px, 8vw, 100px);
        }

        .about-inner {
            max-width: 1200px;
            margin: 0 auto;
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 80px;
            align-items: center;
        }

        .about-img-wrap {
            position: relative;
        }

        .about-img {
            border-radius: 24px 80px 24px 80px;
            background: center/cover no-repeat;
            height: 460px;
            overflow: hidden;
            background-color: var(--primary);
        }

        .about-badge-card {
            position: absolute;
            bottom: 30px;
            right: -20px;
            background: var(--white);
            border-radius: 16px;
            padding: 16px 24px;
            box-shadow: 0 8px 40px rgba(0, 0, 0, .12);
            border: 2px solid var(--gold-light);
        }

        .about-badge-num {
            font-family: "Cormorant Garamond", serif;
            font-size: 1.8rem;
            font-weight: 700;
            color: var(--primary);
        }

        .about-badge-label {
            font-size: .78rem;
            color: var(--muted);
            font-weight: 600;
            letter-spacing: 1px;
        }

        .about-eyebrow {
            color: var(--gold);
            font-size: .85rem;
            font-weight: 700;
            letter-spacing: 2.5px;
            text-transform: uppercase;
            margin-bottom: 12px;
        }

        .about-highlights {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 16px;
        }

        .highlight-card {
            background: var(--cream);
            border: 1px solid var(--cream-dark);
            border-radius: 12px;
            padding: 16px;
            transition: all .3s ease;
        }

        .highlight-card:hover {
            border-color: var(--gold);
            background: var(--white);
        }

        .highlight-title {
            font-weight: 700;
            font-size: .9rem;
            color: var(--primary);
            margin-bottom: 2px;
        }

        .highlight-desc {
            font-size: .8rem;
            color: var(--muted);
        }

        @media (max-width:768px) {
            #about {
                padding: 60px 24px;
            }

            .about-inner {
                grid-template-columns: 1fr;
                gap: 40px;
            }

            .about-img-wrap {
                display: none;
            }
        }

        /* ===== PACKAGES ===== */
        #packages {
            padding: 100px clamp(20px, 8vw, 100px);
            background: linear-gradient(180deg, var(--primary-dark) 0%, var(--primary) 100%);
            position: relative;
            overflow: hidden;
        }

        #packages .pattern-bg {
            position: absolute;
            inset: 0;
            opacity: .5;
        }

        #packages .inner {
            position: relative;
            z-index: 1;
            max-width: 1200px;
            margin: 0 auto;
        }

        .pkg-eyebrow {
            color: var(--gold-light);
            font-size: .85rem;
            font-weight: 700;
            letter-spacing: 2.5px;
            text-transform: uppercase;
            margin-bottom: 12px;
        }

        .pkg-title {
            font-family: "Cormorant Garamond", serif;
            font-size: clamp(2rem, 4vw, 3rem);
            font-weight: 600;
            color: var(--white);
            margin-bottom: .5rem;
        }

        .pkg-subtitle {
            color: rgba(255, 255, 255, .65);
            max-width: 500px;
            margin: 0 auto;
            line-height: 1.7;
        }

        .tab-switcher {
            display: flex;
            justify-content: center;
            margin-bottom: 50px;
        }

        .tab-wrap {
            background: rgba(255, 255, 255, .1);
            border-radius: 50px;
            padding: 6px;
            display: flex;
            gap: 4px;
        }

        .tab-btn {
            padding: 12px 36px;
            border-radius: 50px;
            border: none;
            cursor: pointer;
            font-family: "Nunito", sans-serif;
            font-weight: 700;
            font-size: .95rem;
            transition: all .3s ease;
            background: transparent;
            color: rgba(255, 255, 255, .7);
        }

        .tab-btn.active {
            background: linear-gradient(135deg, var(--gold), var(--gold-light));
            color: var(--primary-dark);
            box-shadow: 0 4px 16px rgba(196, 154, 42, .4);
        }

        .pkg-section {
            display: none;
        }

        .pkg-section.active-section {
            display: block;
        }

        .pkg-grid {
            display: grid;
            gap: 24px;
        }

        .pkg-grid.col3 {
            grid-template-columns: repeat(3, 1fr);
        }

        .pkg-grid.col2 {
            grid-template-columns: repeat(2, 1fr);
            max-width: 800px;
            margin: 0 auto;
        }

        .pkg-grid.col1 {
            grid-template-columns: 1fr;
            max-width: 400px;
            margin: 0 auto;
        }

        .pkg-card {
            background: rgba(255, 255, 255, .07);
            border: 1px solid rgba(255, 255, 255, .15);
            border-radius: 20px;
            padding: 32px 28px;
            position: relative;
            transition: transform .3s ease;
        }

        .pkg-card:hover {
            transform: scale(1.04) !important;
        }

        .pkg-card.featured {
            background: linear-gradient(160deg, #ffffff, #fffbf0);
            border: 2px solid var(--gold-light);
            transform: scale(1.03);
        }

        .pkg-badge {
            position: absolute;
            top: -14px;
            left: 50%;
            transform: translateX(-50%);
            background: linear-gradient(135deg, var(--gold), var(--gold-light));
            color: var(--primary-dark);
            font-size: .75rem;
            font-weight: 800;
            padding: 6px 20px;
            border-radius: 50px;
            letter-spacing: 1px;
            white-space: nowrap;
        }

        .pkg-name {
            font-size: .8rem;
            font-weight: 700;
            letter-spacing: 1.5px;
            text-transform: uppercase;
            margin-bottom: 8px;
            color: var(--gold-light);
        }

        .pkg-card.featured .pkg-name {
            color: var(--gold);
        }

        .pkg-price {
            font-family: "Cormorant Garamond", serif;
            font-size: clamp(1.5rem, 3vw, 2rem);
            font-weight: 700;
            color: var(--white);
            margin-bottom: 4px;
        }

        .pkg-card.featured .pkg-price {
            color: var(--primary);
        }

        .pkg-per {
            font-size: .8rem;
            color: rgba(255, 255, 255, .5);
            margin-bottom: 6px;
        }

        .pkg-card.featured .pkg-per {
            color: var(--muted);
        }

        .pkg-chips {
            display: flex;
            gap: 8px;
            margin-bottom: 24px;
            flex-wrap: wrap;
        }

        .pkg-chip {
            background: rgba(255, 255, 255, .1);
            color: rgba(255, 255, 255, .8);
            font-size: .75rem;
            font-weight: 600;
            padding: 4px 12px;
            border-radius: 50px;
        }

        .pkg-card.featured .pkg-chip {
            background: var(--cream-dark);
            color: var(--primary);
        }

        .pkg-features-list {
            border-top: 1px solid rgba(255, 255, 255, .1);
            padding-top: 20px;
            margin-bottom: 28px;
        }

        .pkg-card.featured .pkg-features-list {
            border-color: var(--cream-dark);
        }

        .pkg-feature {
            display: flex;
            align-items: flex-start;
            gap: 10px;
            margin-bottom: 10px;
        }

        .pkg-check {
            color: var(--gold-light);
            font-weight: 700;
            font-size: .85rem;
            margin-top: 1px;
            flex-shrink: 0;
        }

        .pkg-feature-text {
            font-size: .85rem;
            color: rgba(255, 255, 255, .75);
            line-height: 1.5;
        }

        .pkg-card.featured .pkg-feature-text {
            color: var(--dark);
        }

        .pkg-cta {
            width: 100%;
            padding: 14px;
            border-radius: 50px;
            font-family: "Nunito", sans-serif;
            font-weight: 700;
            font-size: .9rem;
            cursor: pointer;
            transition: all .3s ease;
            background: transparent;
            color: var(--white);
            border: 2px solid rgba(255, 255, 255, .4);
        }

        .pkg-card.featured .pkg-cta {
            background: linear-gradient(135deg, var(--gold), var(--gold-light));
            color: var(--primary-dark);
            border: none;
        }

        .pkg-cta:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(0, 0, 0, .2);
        }

        @media (max-width:768px) {
            #packages {
                padding: 60px 24px;
            }

            .pkg-grid.col3,
            .pkg-grid.col2 {
                grid-template-columns: 1fr;
            }
        }

        /* ===== FEATURES ===== */
        #features {
            padding: 100px clamp(20px, 8vw, 100px);
            background: var(--white);
        }

        .feat-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 28px;
        }

        .feat-card {
            padding: 32px 28px;
            border-radius: 16px;
            border: 1px solid var(--cream-dark);
            background: var(--cream);
            transition: all .3s ease;
        }

        .feat-card:hover {
            background: var(--white);
            border-color: var(--gold);
            transform: translateY(-6px);
            box-shadow: 0 16px 40px rgba(0, 0, 0, .08);
        }

        .feat-title {
            font-family: "Cormorant Garamond", serif;
            font-size: 1.25rem;
            font-weight: 600;
            color: var(--primary);
            margin-bottom: 10px;
        }

        .feat-desc {
            font-size: .875rem;
            color: var(--muted);
            line-height: 1.75;
        }

        @media (max-width:768px) {
            #features {
                padding: 60px 24px;
            }

            .feat-grid {
                grid-template-columns: 1fr;
            }
        }

        @media (min-width:769px) and (max-width:1024px) {
            .feat-grid {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        /* ===== STATS ===== */
        #stats {
            background: linear-gradient(135deg, var(--primary), var(--primary-dark));
            padding: 70px clamp(20px, 8vw, 100px);
            position: relative;
            overflow: hidden;
        }

        .stats-inner {
            max-width: 1200px;
            margin: 0 auto;
            position: relative;
            z-index: 1;
        }

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 24px;
        }

        .stat-item {
            text-align: center;
        }

        .stat-num {
            font-family: "Cormorant Garamond", serif;
            font-size: 2.5rem;
            font-weight: 700;
            color: var(--gold-light);
            line-height: 1;
        }

        .stat-label {
            font-size: .85rem;
            color: rgba(255, 255, 255, .65);
            font-weight: 500;
            margin-top: 6px;
        }

        @media (max-width:768px) {
            .stats-grid {
                grid-template-columns: repeat(2, 1fr);
                gap: 32px 16px;
            }

            .stat-num {
                font-size: 2rem;
            }
        }

        /* ===== TESTIMONIALS ===== */
        #testimonials {
            padding: 100px clamp(20px, 8vw, 100px);
            background: var(--cream);
        }

        .testi-card {
            background: var(--white);
            border-radius: 24px;
            padding: 48px 56px;
            box-shadow: 0 16px 60px rgba(0, 0, 0, .07);
            border: 1px solid var(--cream-dark);
            max-width: 760px;
            margin: 0 auto 40px;
            position: relative;
            overflow: hidden;
        }

        .testi-quote-deco {
            position: absolute;
            top: 20px;
            right: 28px;
            font-family: "Cormorant Garamond", serif;
            font-size: 8rem;
            color: rgba(196, 154, 42, .07);
            font-weight: 700;
            line-height: 1;
        }

        .testi-stars {
            display: flex;
            gap: 4px;
            margin-bottom: 20px;
        }

        .testi-star {
            color: var(--gold-light);
            font-size: 1.1rem;
        }

        .testi-text {
            font-family: "Cormorant Garamond", serif;
            font-size: 1.25rem;
            font-style: italic;
            color: var(--dark);
            line-height: 1.8;
            margin-bottom: 28px;
        }

        .testi-author {
            display: flex;
            align-items: center;
            gap: 16px;
        }

        .testi-avatar {
            width: 52px;
            height: 52px;
            border-radius: 50%;
            background: linear-gradient(135deg, var(--primary), var(--primary-light));
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--white);
            font-weight: 700;
            font-size: 1rem;
            flex-shrink: 0;
        }

        .testi-name {
            font-weight: 700;
            color: var(--primary);
            font-size: 1rem;
        }

        .testi-meta {
            font-size: .8rem;
            color: var(--muted);
        }

        .testi-dots {
            display: flex;
            justify-content: center;
            gap: 10px;
            margin-bottom: 40px;
        }

        .testi-dot {
            width: 10px;
            height: 10px;
            border-radius: 5px;
            border: none;
            cursor: pointer;
            background: var(--cream-dark);
            transition: all .3s ease;
        }

        .testi-dot.active {
            width: 28px;
            background: linear-gradient(90deg, var(--gold), var(--gold-light));
        }

        .testi-thumbs {
            display: flex;
            gap: 12px;
            justify-content: center;
            flex-wrap: wrap;
        }

        .testi-thumb {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 12px 20px;
            border-radius: 50px;
            background: transparent;
            border: 1.5px solid var(--cream-dark);
            cursor: pointer;
            transition: all .3s ease;
        }

        .testi-thumb.active {
            background: var(--white);
            border-color: var(--gold);
            box-shadow: 0 4px 16px rgba(0, 0, 0, .08);
        }

        .testi-thumb-avatar {
            width: 32px;
            height: 32px;
            border-radius: 50%;
            background: var(--cream-dark);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: .7rem;
            font-weight: 700;
            color: var(--muted);
        }

        .testi-thumb.active .testi-thumb-avatar {
            background: linear-gradient(135deg, var(--primary), var(--primary-light));
            color: var(--white);
        }

        .testi-thumb-name {
            font-size: .8rem;
            font-weight: 700;
            color: var(--muted);
        }

        .testi-thumb.active .testi-thumb-name {
            color: var(--primary);
        }

        .testi-thumb-city {
            font-size: .7rem;
            color: var(--muted);
        }

        @media (max-width:768px) {
            #testimonials {
                padding: 60px 24px;
            }

            .testi-card {
                padding: 28px 24px;
            }
        }

        /* ===== CONTACT ===== */
        #contact {
            padding: 100px clamp(20px, 8vw, 100px);
            background: var(--white);
        }

        .contact-grid {
            max-width: 1200px;
            margin: 0 auto;
            display: grid;
            grid-template-columns: 1fr 1.5fr;
            gap: 60px;
            align-items: start;
        }

        .contact-info-title {
            font-family: "Cormorant Garamond", serif;
            font-size: 1.6rem;
            font-weight: 600;
            color: var(--primary);
            margin-bottom: 12px;
        }

        .contact-info-desc {
            color: var(--muted);
            line-height: 1.8;
            font-size: .9rem;
        }

        .contact-items {
            display: flex;
            flex-direction: column;
            gap: 16px;
            margin-top: 36px;
        }

        .contact-item {
            display: flex;
            align-items: center;
            gap: 16px;
            padding: 16px 20px;
            border-radius: 12px;
            background: var(--cream);
            border: 1px solid var(--cream-dark);
        }

        .contact-icon {
            width: 44px;
            height: 44px;
            border-radius: 12px;
            background: linear-gradient(135deg, rgba(11, 77, 46, .08), rgba(11, 77, 46, .15));
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.2rem;
            flex-shrink: 0;
        }

        .contact-label {
            font-size: .75rem;
            color: var(--muted);
            font-weight: 600;
        }

        .contact-value {
            font-weight: 600;
            color: var(--primary);
            font-size: .9rem;
        }

        .wa-cta {
            width: 100%;
            padding: 16px;
            border-radius: 12px;
            background: #25d366;
            border: none;
            font-family: "Nunito", sans-serif;
            font-weight: 700;
            font-size: .95rem;
            color: var(--white);
            cursor: pointer;
            transition: all .3s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            margin-top: 28px;
        }

        .wa-cta:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 24px rgba(37, 211, 102, .4);
        }

        .form-box {
            background: var(--cream);
            border-radius: 20px;
            padding: 40px;
            border: 1px solid var(--cream-dark);
        }

        .form-title {
            font-family: "Cormorant Garamond", serif;
            font-size: 1.5rem;
            font-weight: 600;
            color: var(--primary);
            margin-bottom: 24px;
        }

        .form-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 16px;
            margin-bottom: 16px;
        }

        .form-group {
            margin-bottom: 16px;
        }

        .form-label {
            font-size: .8rem;
            font-weight: 700;
            color: var(--primary);
            display: block;
            margin-bottom: 6px;
        }

        .form-input {
            width: 100%;
            padding: 14px 18px;
            border-radius: 10px;
            border: 1.5px solid var(--cream-dark);
            font-family: "Nunito", sans-serif;
            font-size: .9rem;
            background: var(--white);
            color: var(--dark);
            outline: none;
            transition: border-color .2s ease;
        }

        .form-input:focus {
            border-color: var(--gold);
        }

        textarea.form-input {
            height: 100px;
            resize: vertical;
        }

        .form-submit {
            width: 100%;
            font-size: .95rem;
            margin-bottom: 0;
        }

        .form-privacy {
            font-size: .75rem;
            color: var(--muted);
            text-align: center;
            margin-top: 12px;
        }

        .form-success {
            text-align: center;
            padding: 40px 0;
            display: none;
        }

        .form-success.show {
            display: block;
        }

        .form-main.hidden {
            display: none;
        }

        .success-title {
            font-family: "Cormorant Garamond", serif;
            color: var(--primary);
            font-size: 1.5rem;
            margin-bottom: 12px;
        }

        .success-msg {
            color: var(--muted);
        }

        @media (max-width:768px) {
            #contact {
                padding: 60px 24px;
            }

            .contact-grid {
                grid-template-columns: 1fr;
                gap: 40px;
            }

            .form-row {
                grid-template-columns: 1fr;
            }

            .form-box {
                padding: 24px 20px;
            }
        }

        /* ===== FOOTER ===== */
        footer {
            background: linear-gradient(160deg, var(--primary-dark), #020d1a);
            padding: 70px clamp(20px, 8vw, 100px) 30px;
            position: relative;
            overflow: hidden;
        }

        .footer-inner {
            max-width: 1200px;
            margin: 0 auto;
            position: relative;
            z-index: 1;
        }

        .footer-grid {
            display: grid;
            grid-template-columns: 1.4fr 1fr 1fr 1fr;
            gap: 50px;
            margin-bottom: 50px;
        }

        .footer-brand-logo {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-bottom: 20px;
        }

        .footer-brand-icon {
            width: 44px;
            height: 44px;
            border-radius: 50%;
            background: linear-gradient(135deg, var(--gold), var(--gold-light));
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 20px;
            overflow: hidden;
        }

        .footer-brand-icon img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .footer-brand-name {
            font-family: "Cormorant Garamond", serif;
            font-size: 1.3rem;
            font-weight: 700;
            color: var(--white);
        }

        .footer-brand-sub {
            font-size: .65rem;
            color: var(--gold-light);
            letter-spacing: 2px;
            font-weight: 600;
            text-transform: uppercase;
        }

        .footer-brand-desc {
            color: rgba(255, 255, 255, .5);
            font-size: .85rem;
            line-height: 1.8;
            margin-bottom: 24px;
        }

        .footer-badges {
            display: flex;
            gap: 10px;
        }

        .footer-badge {
            background: rgba(255, 255, 255, .08);
            border: 1px solid rgba(255, 255, 255, .12);
            color: rgba(255, 255, 255, .6);
            font-size: .65rem;
            font-weight: 700;
            padding: 6px 10px;
            border-radius: 6px;
        }

        .footer-col-title {
            color: var(--gold-light);
            font-size: .8rem;
            font-weight: 700;
            letter-spacing: 1.5px;
            text-transform: uppercase;
            margin-bottom: 20px;
        }

        .footer-col ul {
            list-style: none;
        }

        .footer-col ul li {
            margin-bottom: 10px;
        }

        .footer-col ul li a {
            color: rgba(255, 255, 255, .5);
            font-size: .85rem;
            transition: color .2s;
        }

        .footer-col ul li a:hover {
            color: var(--gold-light);
        }

        .footer-bottom {
            border-top: 1px solid rgba(255, 255, 255, .08);
            padding-top: 28px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 12px;
        }

        .footer-copy {
            color: rgba(255, 255, 255, .35);
            font-size: .8rem;
        }

        @media (max-width:768px) {
            .footer-grid {
                grid-template-columns: 1fr 1fr;
                gap: 32px;
            }

            .footer-brand {
                grid-column: 1 / -1;
            }
        }

        /* ===== FLOATING WA ===== */
        #wa-float {
            position: fixed;
            bottom: 32px;
            right: 32px;
            width: 60px;
            height: 60px;
            border-radius: 50%;
            background: #f0ba48;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.7rem;
            box-shadow: 0 6px 24px rgba(255, 235, 124, .79);
            z-index: 900;
            transition: transform .2s ease, box-shadow .2s ease;
            text-decoration: none;
        }

        #wa-float:hover {
            transform: scale(1.1);
        }

        @media (max-width:768px) {
            #wa-float {
                bottom: 24px;
                right: 20px;
                width: 52px;
                height: 52px;
                font-size: 1.4rem;
            }
        }
    </style>
</head>

<body>

    {{-- ===== NAVBAR ===== --}}
    <nav id="navbar">
       <div class="nav-logo">
    <div class="nav-logo-icon">
        @if (!empty($s['brand_logo']))
            <img src="{{ Storage::url($s['brand_logo']) }}" alt="{{ $s['brand_name'] ?? 'Logo' }}">
        @else
            <img src="{{ asset('assets/img/logo.png') }}" alt="{{ $s['brand_name'] ?? 'Logo' }}">
        @endif
    </div>
</div>
        <ul class="nav-links">
            <li><a href="#hero">Beranda</a></li>
            <li><a href="#about">Tentang Kami</a></li>
            <li><a href="#packages">Paket</a></li>
            <li><a href="#features">Keunggulan</a></li>
            <li><a href="#testimonials">Testimoni</a></li>
            <li><a href="#contact">Kontak</a></li>
        </ul>
        <div class="nav-right">
            <a href="{{ route('login') }}" class="btn-login">🔐 Login</a>
            <button class="btn-primary"
                onclick="document.querySelector('#contact').scrollIntoView({behavior:'smooth'})">
                Konsultasi Gratis
            </button>
        </div>
        <button class="hamburger" id="hamburger-btn" aria-label="Buka menu">
            <span></span><span></span><span></span>
        </button>
    </nav>

    {{-- Mobile Menu --}}
    <div id="mobile-menu">
        <button id="mobile-menu-close">✕</button>
        <a href="#hero" onclick="closeMobileMenu()">Beranda</a>
        <a href="#about" onclick="closeMobileMenu()">Tentang Kami</a>
        <a href="#packages" onclick="closeMobileMenu()">Paket</a>
        <a href="#features" onclick="closeMobileMenu()">Keunggulan</a>
        <a href="#testimonials" onclick="closeMobileMenu()">Testimoni</a>
        <a href="#contact" onclick="closeMobileMenu()">Kontak</a>
        <a href="{{ route('login') }}" class="btn-login" style="margin-top:8px;">🔐 Login</a>
        <button class="btn-primary"
            onclick="closeMobileMenu(); document.querySelector('#contact').scrollIntoView({behavior:'smooth'})">
            Konsultasi Gratis
        </button>
    </div>

    {{-- ===== HERO CAROUSEL ===== --}}
    <section id="hero">

        {{-- Background Slides --}}
        <div class="hero-carousel">
            @if ($totalSlides > 0)
                @foreach ($activeSlides as $i => $slide)
                    @php
                        $bgStyle = 'background-color:' . ($slide->bg_color ?: '#0a2342') . ';';
                        if ($slide->image) {
                            $bgStyle .= 'background-image:url(' . Storage::url($slide->image) . ');';
                        }
                        $overlayColor = $slide->overlay_color ?: '#061529';
                        $overlayStyle = "background: linear-gradient(to right, {$overlayColor}ee 0%, {$overlayColor}a0 50%, {$overlayColor}33 100%);";
                    @endphp
                    <div class="hero-slide {{ $i === 0 ? 'active' : '' }}">
                        <div class="slide-bg" style="{{ $bgStyle }}"></div>
                        <div class="slide-overlay" style="{{ $overlayStyle }}"></div>
                    </div>
                @endforeach
            @else
                {{-- Fallback slide --}}
                <div class="hero-slide active">
                    <div class="slide-bg" style="background-color:#0a2342;"></div>
                    <div class="slide-overlay"
                        style="background:linear-gradient(to right, rgba(6,21,41,0.9) 0%, rgba(6,21,41,0.65) 50%, rgba(0,0,0,0.2) 100%);">
                    </div>
                </div>
            @endif
        </div>

        {{-- Content Slides --}}
        <div class="hero-content-wrap">
            <div class="hero-content">
                @if ($totalSlides > 0)
                    @foreach ($activeSlides as $i => $slide)
                        @php
                            $slideStats = is_array($slide->stats)
                                ? $slide->stats
                                : json_decode($slide->stats ?? '[]', true) ?? [];
                        @endphp
                        <div class="hero-text-slide {{ $i === 0 ? 'active' : '' }}"
                            id="text-slide-{{ $i }}">
                            <div class="hero-badge">✦ {{ $slide->badge }} ✦</div>
                            <h1 class="hero-title">{!! $slide->title !!}</h1>
                            <p class="hero-desc">{!! $slide->description !!}</p>
                            <div class="hero-btns">
                                @if ($slide->btn_primary_text)
                                    <button class="btn-primary"
                                        onclick="document.querySelector('#packages').scrollIntoView({behavior:'smooth'})">
                                        {{ $slide->btn_primary_text }} ✦
                                    </button>
                                @endif
                                @if ($slide->btn_secondary_text)
                                    <button class="btn-outline"
                                        onclick="document.querySelector('#contact').scrollIntoView({behavior:'smooth'})">
                                        {{ $slide->btn_secondary_text }}
                                    </button>
                                @endif
                            </div>
                            @if (count($slideStats) > 0)
                                <div class="hero-stats">
                                    @foreach ($slideStats as $stat)
                                        <div>
                                            <div class="hero-stat-num">{{ $stat['num'] ?? '' }}</div>
                                            <div class="hero-stat-label">{{ $stat['label'] ?? '' }}</div>
                                        </div>
                                    @endforeach
                                </div>
                            @endif
                        </div>
                    @endforeach
                @else
                    {{-- Fallback content --}}
                    <div class="hero-text-slide active">
                        <div class="hero-badge">✦ Perjalanan Suci Menuju Tanah Haram ✦</div>
                        <h1 class="hero-title">Wujudkan Impian <span class="gold-text">Ibadah Umroh</span> &amp; Haji
                            Anda</h1>
                        <p class="hero-desc">Kami hadir membimbing perjalanan ibadah Anda dengan pelayanan terbaik.</p>
                        <div class="hero-btns">
                            <button class="btn-primary"
                                onclick="document.querySelector('#packages').scrollIntoView({behavior:'smooth'})">Lihat
                                Paket ✦</button>
                            <button class="btn-outline"
                                onclick="document.querySelector('#contact').scrollIntoView({behavior:'smooth'})">Hubungi
                                Kami</button>
                        </div>
                    </div>
                @endif
            </div>
        </div>

        {{-- Slide Counter --}}
        <div class="carousel-counter">
            <span id="slide-current">1</span> / {{ max($totalSlides, 1) }}
        </div>

        {{-- Controls --}}
        @if ($totalSlides > 1)
            <div class="carousel-controls">
                <button class="carousel-arrow" id="prev-btn" aria-label="Sebelumnya">&#8592;</button>
                <div class="carousel-dots" id="carousel-dots">
                    @for ($i = 0; $i < $totalSlides; $i++)
                        <button class="carousel-dot {{ $i === 0 ? 'active' : '' }}"
                            data-idx="{{ $i }}"></button>
                    @endfor
                </div>
                <button class="carousel-arrow" id="next-btn" aria-label="Berikutnya">&#8594;</button>
            </div>
        @endif

        <div class="carousel-progress" id="carousel-progress"></div>

        <div class="hero-wave">
            <svg viewBox="0 0 1440 80" xmlns="http://www.w3.org/2000/svg">
                <path d="M0,40 C240,80 480,0 720,40 C960,80 1200,0 1440,40 L1440,80 L0,80 Z" fill="#F4F6FB" />
            </svg>
        </div>
    </section>

    {{-- ===== ABOUT ===== --}}
    <section id="about">
        <div class="about-inner">
            <div class="about-img-wrap fade-in">
                <div class="about-img"
                    style="{{ !empty($s['about_image']) ? 'background-image:url(' . Storage::url($s['about_image']) . ');' : '' }}">
                </div>
                <div class="about-badge-card">
                    <div class="about-badge-num">{{ $s['about_badge_num'] ?? '15+' }}</div>
                    <div class="about-badge-label">{{ $s['about_badge_label'] ?? 'TAHUN AMANAH' }}</div>
                </div>
            </div>
            <div>
                <div class="about-eyebrow fade-in">✦ Tentang Kami</div>
                <h2 class="section-title fade-in" style="text-align:left;margin-bottom:8px">
                    {{ $s['about_title'] ?? 'Mitra Ibadah Terpercaya Sejak ' . ($s['brand_since'] ?? '2009') }}
                </h2>
                <div class="gold-line fade-in" style="margin:0 0 24px"></div>
                <p style="color:var(--muted);line-height:1.9;margin-bottom:20px" class="fade-in">
                    {{ $s['about_text1'] ?? '' }}
                </p>
                <p style="color:var(--muted);line-height:1.9;margin-bottom:36px" class="fade-in">
                    {{ $s['about_text2'] ?? '' }}
                </p>
                <div class="about-highlights fade-in">
                    <div class="highlight-card">
                        <div class="highlight-title">Izin Resmi</div>
                        <div class="highlight-desc">Berizin Kemenag RI &amp; IATA</div>
                    </div>
                    <div class="highlight-card">
                        <div class="highlight-title">Jadwal Fleksibel</div>
                        <div class="highlight-desc">Tersedia sepanjang tahun</div>
                    </div>
                    <div class="highlight-card">
                        <div class="highlight-title">Pembimbing Berpengalaman</div>
                        <div class="highlight-desc">Ustadz &amp; Muthawif profesional</div>
                    </div>
                    <div class="highlight-card">
                        <div class="highlight-title">Asuransi Penuh</div>
                        <div class="highlight-desc">Dilindungi asuransi jiwa</div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- ===== PACKAGES ===== --}}
    <section id="packages">
        <div class="pattern-bg"></div>
        <div class="inner">
            <div style="text-align:center;margin-bottom:20px" class="fade-in">
                <div class="pkg-eyebrow">✦ Pilih Perjalanan Anda</div>
                <h2 class="pkg-title">Paket Ibadah Terbaik</h2>
                <div
                    style="width:60px;height:3px;background:linear-gradient(90deg,var(--gold),var(--gold-light));border-radius:2px;margin:.75rem auto 1.5rem;">
                </div>
                <p class="pkg-subtitle">Pilih paket yang sesuai kebutuhan dan anggaran Anda. Semua paket tersedia
                    dengan pembimbing profesional.</p>
            </div>
            <div class="tab-switcher fade-in">
                <div class="tab-wrap">
                    <button class="tab-btn active" data-tab="umroh" onclick="switchTab('umroh')">Umroh</button>
                    <button class="tab-btn" data-tab="haji" onclick="switchTab('haji')">Haji</button>
                </div>
            </div>

            {{-- UMROH Packages --}}
            <div id="pkg-umroh" class="pkg-section active-section">
                @php
                    $umrohActive = $umroh->where('is_active', true);
                    $uCount = $umrohActive->count();
                    $uCols = $uCount >= 3 ? 'col3' : ($uCount === 2 ? 'col2' : 'col1');
                @endphp
                <div class="pkg-grid {{ $uCols }}">
                    @forelse($umrohActive as $pkg)
                        @php
                            $features = is_array($pkg->features)
                                ? $pkg->features
                                : json_decode($pkg->features ?? '[]', true) ?? [];
                        @endphp
                        <div class="pkg-card {{ $pkg->is_featured ? 'featured' : '' }} fade-in visible">
                            @if ($pkg->badge)
                                <div class="pkg-badge">★ {{ $pkg->badge }}</div>
                            @endif
                            <div class="pkg-name">{{ $pkg->name }}</div>
                            <div class="pkg-price">{{ $pkg->price }}</div>
                            <div class="pkg-per">per jamaah</div>
                            <div class="pkg-chips">
                                <span class="pkg-chip">✈ {{ $pkg->duration }}</span>
                                <span class="pkg-chip">🏨 {{ $pkg->hotel }}</span>
                            </div>
                            <div class="pkg-features-list">
                                @foreach ($features as $f)
                                    <div class="pkg-feature">
                                        <span class="pkg-check">✓</span>
                                        <span class="pkg-feature-text">{{ $f }}</span>
                                    </div>
                                @endforeach
                            </div>
                            <button class="pkg-cta"
                                onclick="document.querySelector('#contact').scrollIntoView({behavior:'smooth'})">
                                Daftar Sekarang →
                            </button>
                        </div>
                    @empty
                        <div class="text-center py-5" style="color:rgba(255,255,255,.5);grid-column:1/-1">
                            Paket Umroh belum tersedia.
                        </div>
                    @endforelse
                </div>
            </div>

            {{-- HAJI Packages --}}
            <div id="pkg-haji" class="pkg-section">
                @php
                    $hajiActive = $haji->where('is_active', true);
                    $hCount = $hajiActive->count();
                    $hCols = $hCount >= 3 ? 'col3' : ($hCount === 2 ? 'col2' : 'col1');
                @endphp
                <div class="pkg-grid {{ $hCols }}">
                    @forelse($hajiActive as $pkg)
                        @php
                            $features = is_array($pkg->features)
                                ? $pkg->features
                                : json_decode($pkg->features ?? '[]', true) ?? [];
                        @endphp
                        <div class="pkg-card {{ $pkg->is_featured ? 'featured' : '' }} fade-in visible">
                            @if ($pkg->badge)
                                <div class="pkg-badge">★ {{ $pkg->badge }}</div>
                            @endif
                            <div class="pkg-name">{{ $pkg->name }}</div>
                            <div class="pkg-price">{{ $pkg->price }}</div>
                            <div class="pkg-per">per jamaah</div>
                            <div class="pkg-chips">
                                <span class="pkg-chip">✈ {{ $pkg->duration }}</span>
                                <span class="pkg-chip">🏨 {{ $pkg->hotel }}</span>
                            </div>
                            <div class="pkg-features-list">
                                @foreach ($features as $f)
                                    <div class="pkg-feature">
                                        <span class="pkg-check">✓</span>
                                        <span class="pkg-feature-text">{{ $f }}</span>
                                    </div>
                                @endforeach
                            </div>
                            <button class="pkg-cta"
                                onclick="document.querySelector('#contact').scrollIntoView({behavior:'smooth'})">
                                Daftar Sekarang →
                            </button>
                        </div>
                    @empty
                        <div class="text-center py-5" style="color:rgba(255,255,255,.5);grid-column:1/-1">
                            Paket Haji belum tersedia.
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </section>

    {{-- ===== FEATURES ===== --}}
    <section id="features">
        <div style="max-width:1200px;margin:0 auto">
            <div style="text-align:center;margin-bottom:60px" class="fade-in">
                <div
                    style="color:var(--gold);font-size:.85rem;font-weight:700;letter-spacing:2.5px;text-transform:uppercase;margin-bottom:12px;">
                    ✦ Mengapa Kami</div>
                <h2 class="section-title">Keunggulan {{ $s['brand_name'] ?? 'Kami' }}</h2>
                <div class="gold-line"></div>
                <p class="section-subtitle">Kami tidak hanya mengantar perjalanan — kami memastikan setiap momen ibadah
                    Anda bermakna dan tak terlupakan.</p>
            </div>
            <div class="feat-grid">
                <div class="feat-card fade-in">
                    <h3 class="feat-title">Manasik Intensif</h3>
                    <p class="feat-desc">Program manasik lengkap sebelum keberangkatan, dipandu ustadz berpengalaman
                        agar ibadah Anda sah dan sempurna.</p>
                </div>
                <div class="feat-card fade-in">
                    <h3 class="feat-title">Penerbangan Langsung</h3>
                    <p class="feat-desc">Penerbangan langsung (direct flight) dari kota Anda ke Jeddah/Madinah dengan
                        maskapai premium terpilih.</p>
                </div>
                <div class="feat-card fade-in">
                    <h3 class="feat-title">Hotel Strategis</h3>
                    <p class="feat-desc">Akomodasi di hotel berbintang yang berlokasi sangat dekat dengan Masjidil
                        Haram dan Masjid Nabawi.</p>
                </div>
                <div class="feat-card fade-in">
                    <h3 class="feat-title">Grup Kecil &amp; Kondusif</h3>
                    <p class="feat-desc">Rasio muthawif yang ideal, maksimal 25 jamaah per pembimbing, sehingga ibadah
                        lebih terfokus dan khusyu.</p>
                </div>
                <div class="feat-card fade-in">
                    <h3 class="feat-title">Kesehatan Terjamin</h3>
                    <p class="feat-desc">Tim kesehatan &amp; dokter pendamping selama perjalanan. Klinik 24 jam siap
                        membantu kondisi darurat.</p>
                </div>
                <div class="feat-card fade-in">
                    <h3 class="feat-title">Dukungan 24/7</h3>
                    <p class="feat-desc">Customer service siap membantu Anda dan keluarga di tanah air kapan pun
                        dibutuhkan selama perjalanan.</p>
                </div>
            </div>
        </div>
    </section>

    {{-- ===== STATS ===== --}}
    <section id="stats">
        <div class="pattern-bg" style="position:absolute;inset:0"></div>
        <div class="stats-inner">
            <div class="stats-grid">
                @for ($i = 1; $i <= 4; $i++)
                    @if (!empty($s['stat' . $i . '_num']))
                        <div class="stat-item">
                            <div class="stat-num">{{ $s['stat' . $i . '_num'] }}</div>
                            <div class="stat-label">{{ $s['stat' . $i . '_label'] ?? '' }}</div>
                        </div>
                    @endif
                @endfor
            </div>
        </div>
    </section>

    {{-- ===== TESTIMONIALS ===== --}}
    <section id="testimonials">
        <div style="max-width:1200px;margin:0 auto">
            <div style="text-align:center;margin-bottom:60px" class="fade-in">
                <div
                    style="color:var(--gold);font-size:.85rem;font-weight:700;letter-spacing:2.5px;text-transform:uppercase;margin-bottom:12px;">
                    ✦ Kata Mereka</div>
                <h2 class="section-title">Testimoni Jamaah Kami</h2>
                <div class="gold-line"></div>
                <p class="section-subtitle">Kepercayaan dan kebahagiaan jamaah adalah motivasi terbesar kami untuk
                    terus berkembang.</p>
            </div>
            <div class="fade-in">
                <div class="testi-card">
                    <div class="testi-quote-deco">"</div>
                    <div class="testi-stars" id="testi-stars"></div>
                    <p class="testi-text" id="testi-text"></p>
                    <div class="testi-author">
                        <div class="testi-avatar" id="testi-avatar"></div>
                        <div>
                            <div class="testi-name" id="testi-name"></div>
                            <div class="testi-meta" id="testi-meta"></div>
                        </div>
                    </div>
                </div>
                <div class="testi-dots" id="testi-dots"></div>
                <div class="testi-thumbs" id="testi-thumbs"></div>
            </div>
        </div>
    </section>

    {{-- ===== CONTACT ===== --}}
    <section id="contact">
        <div style="max-width:1200px;margin:0 auto">
            <div style="text-align:center;margin-bottom:60px" class="fade-in">
                <div
                    style="color:var(--gold);font-size:.85rem;font-weight:700;letter-spacing:2.5px;text-transform:uppercase;margin-bottom:12px;">
                    ✦ Hubungi Kami</div>
                <h2 class="section-title">Konsultasi &amp; Pendaftaran</h2>
                <div class="gold-line"></div>
                <p class="section-subtitle">Hubungi kami sekarang dan dapatkan konsultasi gratis bersama tim kami yang
                    berpengalaman.</p>
            </div>
            <div class="contact-grid">
                <div>
                    <div class="fade-in">
                        <h3 class="contact-info-title">Siap Membantu Perjalanan Anda</h3>
                        <p class="contact-info-desc">Tim kami siap menjawab semua pertanyaan dan membantu Anda memilih
                            paket yang paling sesuai. Konsultasi gratis, tanpa biaya!</p>
                    </div>
                    <div class="contact-items">
                        @if (!empty($s['contact_phone']))
                            <div class="contact-item fade-in">
                                <div class="contact-icon">📞</div>
                                <div>
                                    <div class="contact-label">Telepon</div>
                                    <div class="contact-value">{{ $s['contact_phone'] }}</div>
                                </div>
                            </div>
                        @endif
                        @if (!empty($s['contact_wa']))
                            <div class="contact-item fade-in">
                                <div class="contact-icon">📱</div>
                                <div>
                                    <div class="contact-label">WhatsApp</div>
                                    <div class="contact-value">{{ $s['contact_wa'] }}</div>
                                </div>
                            </div>
                        @endif
                        @if (!empty($s['contact_email']))
                            <div class="contact-item fade-in">
                                <div class="contact-icon">✉️</div>
                                <div>
                                    <div class="contact-label">Email</div>
                                    <div class="contact-value">{{ $s['contact_email'] }}</div>
                                </div>
                            </div>
                        @endif
                        @if (!empty($s['contact_address']))
                            <div class="contact-item fade-in">
                                <div class="contact-icon">📍</div>
                                <div>
                                    <div class="contact-label">Alamat</div>
                                    <div class="contact-value">{{ $s['contact_address'] }}</div>
                                </div>
                            </div>
                        @endif
                    </div>
                    @if (!empty($s['contact_wa_link']))
                        <button class="wa-cta fade-in"
                            onclick="window.open('https://wa.me/{{ $s['contact_wa_link'] }}','_blank')">
                            💬 Chat WhatsApp Sekarang
                        </button>
                    @endif
                </div>
                <div class="form-box fade-in">
                    <div class="form-success" id="form-success">
                        <div style="font-size:3rem;margin-bottom:16px">✅</div>
                        <h3 class="success-title">Pesan Terkirim!</h3>
                        <p class="success-msg">Tim kami akan menghubungi Anda dalam 1×24 jam. Jazakallah khair!</p>
                    </div>
                    <div class="form-main" id="form-main">
                        <h3 class="form-title">Form Pendaftaran &amp; Konsultasi</h3>
                        <div class="form-row">
                            <div><label class="form-label">Nama Lengkap *</label><input id="f-name"
                                    class="form-input" type="text" placeholder="Nama Anda" /></div>
                            <div><label class="form-label">No. HP / WhatsApp *</label><input id="f-phone"
                                    class="form-input" type="text" placeholder="08xx-xxxx-xxxx" /></div>
                        </div>
                        <div class="form-group"><label class="form-label">Email</label><input id="f-email"
                                class="form-input" type="email" placeholder="email@anda.com" /></div>
                        <div class="form-group">
                            <label class="form-label">Paket yang Diminati</label>
                            <select id="f-package" class="form-input" style="cursor:pointer">
                                <option value="">Pilih Paket...</option>
                                @foreach ($umroh->where('is_active', true) as $pkg)
                                    <option>{{ $pkg->name }}</option>
                                @endforeach
                                @foreach ($haji->where('is_active', true) as $pkg)
                                    <option>{{ $pkg->name }}</option>
                                @endforeach
                                <option>Konsultasi Umum</option>
                            </select>
                        </div>
                        <div class="form-group"><label class="form-label">Pesan / Pertanyaan</label>
                            <textarea id="f-message" class="form-input" placeholder="Tuliskan pertanyaan atau kebutuhan Anda..."></textarea>
                        </div>
                        <button class="btn-primary form-submit" onclick="submitForm()">Kirim Pesan Sekarang ✦</button>
                        <p class="form-privacy">🔒 Data Anda aman dan tidak akan dibagikan ke pihak ketiga.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- ===== FOOTER ===== --}}
    <footer>
        <div class="pattern-bg" style="position:absolute;inset:0;opacity:.4;pointer-events:none"></div>
        <div class="footer-inner">
            <div class="footer-grid">
                <div class="footer-brand">
                    <div class="footer-brand-logo">
                        <div class="footer-brand-icon">
                            @if (!empty($s['brand_logo']))
                                <img src="{{ Storage::url($s['brand_logo']) }}" alt="{{ $s['brand_name'] ?? '' }}">
                            @else
                                ☪
                            @endif
                        </div>
                        <div>
                            <div class="footer-brand-name">{{ $s['brand_name'] ?? 'GENMIM' }}</div>
                            <div class="footer-brand-sub">{{ $s['brand_tagline'] ?? 'Travel & Tour' }}</div>
                        </div>
                    </div>
                    <p class="footer-brand-desc">
                        Mitra perjalanan ibadah Anda sejak {{ $s['brand_since'] ?? '2009' }}.
                        Berizin resmi Kementerian Agama RI dan anggota HIMPUH.
                    </p>
                    <div class="footer-badges">
                        <span class="footer-badge">HIMPUH</span>
                        <span class="footer-badge">IATA</span>
                        <span class="footer-badge">KEMENAG</span>
                    </div>
                </div>
                <div class="footer-col">
                    <h4 class="footer-col-title">Layanan</h4>
                    <ul>
                        @foreach ($umroh->where('is_active', true) as $pkg)
                            <li><a href="#packages" onclick="switchTab('umroh')">{{ $pkg->name }}</a></li>
                        @endforeach
                        @foreach ($haji->where('is_active', true) as $pkg)
                            <li><a href="#packages" onclick="switchTab('haji')">{{ $pkg->name }}</a></li>
                        @endforeach
                    </ul>
                </div>
                <div class="footer-col">
                    <h4 class="footer-col-title">Informasi</h4>
                    <ul>
                        <li><a href="#about">Tentang Kami</a></li>
                        <li><a href="#features">Keunggulan Kami</a></li>
                        <li><a href="#testimonials">Testimoni</a></li>
                        <li><a href="#">Syarat &amp; Ketentuan</a></li>
                        <li><a href="#">Kebijakan Privasi</a></li>
                    </ul>
                </div>
                <div class="footer-col">
                    <h4 class="footer-col-title">Kontak</h4>
                    <ul>
                        @if (!empty($s['contact_phone']))
                            <li><a href="tel:{{ $s['contact_phone'] }}">{{ $s['contact_phone'] }}</a></li>
                        @endif
                        @if (!empty($s['contact_wa']))
                            <li><a href="https://wa.me/{{ $s['contact_wa_link'] ?? '' }}"
                                    target="_blank">{{ $s['contact_wa'] }}</a></li>
                        @endif
                        @if (!empty($s['contact_email']))
                            <li><a href="mailto:{{ $s['contact_email'] }}">{{ $s['contact_email'] }}</a></li>
                        @endif
                        @if (!empty($s['contact_address']))
                            <li><a href="#">{{ $s['contact_address'] }}</a></li>
                        @endif
                    </ul>
                </div>
            </div>
            <div class="footer-bottom">
                <div class="footer-copy">© <span id="year"></span> {{ $s['brand_name'] ?? 'GENMIM' }}
                    {{ $s['brand_tagline'] ?? 'Travel & Tour' }}. Hak Cipta Dilindungi.</div>
                <div class="footer-copy">Berizin Resmi Kemenag RI</div>
            </div>
        </div>
    </footer>

    @if (!empty($s['contact_wa_link']))
        <a id="wa-float" href="https://wa.me/{{ $s['contact_wa_link'] }}" target="_blank"
            rel="noopener noreferrer" title="Chat WhatsApp">💬</a>
    @endif

    <script>
        /* ===== Year ===== */
        document.getElementById("year").textContent = new Date().getFullYear();

        /* ===== Navbar scroll ===== */
        const navbar = document.getElementById("navbar");
        window.addEventListener("scroll", () => {
            navbar.classList.toggle("scrolled", window.scrollY > 60);
        });

        /* ===== Mobile menu ===== */
        document.getElementById("hamburger-btn").addEventListener("click", () => {
            document.getElementById("mobile-menu").classList.add("open");
        });
        document.getElementById("mobile-menu-close").addEventListener("click", closeMobileMenu);

        function closeMobileMenu() {
            document.getElementById("mobile-menu").classList.remove("open");
        }

        /* ===== Fade-in observer ===== */
        const fadeObserver = new IntersectionObserver((entries) => {
            entries.forEach((entry) => {
                if (entry.isIntersecting) {
                    const els = entry.target.classList.contains("fade-in") ?
                        [entry.target] :
                        entry.target.querySelectorAll(".fade-in");
                    els.forEach((el, i) => setTimeout(() => el.classList.add("visible"), i * 120));
                    fadeObserver.unobserve(entry.target);
                }
            });
        }, {
            threshold: 0.1
        });
        document.querySelectorAll("section").forEach(s => fadeObserver.observe(s));
        document.querySelectorAll(".fade-in").forEach(el => fadeObserver.observe(el));

        /* ===================================================
           HERO CAROUSEL
        =================================================== */
        const TOTAL_SLIDES = {{ max($totalSlides, 1) }};
        const AUTO_PLAY_DURATION = 6000;
        let currentSlide = 0;
        let autoPlayTimeout = null;
        let isPaused = false;

        const bgSlides = document.querySelectorAll(".hero-slide");
        const txtSlides = document.querySelectorAll(".hero-text-slide");
        const dots = document.querySelectorAll(".carousel-dot");
        const counter = document.getElementById("slide-current");
        const progressBar = document.getElementById("carousel-progress");

        function goToSlide(idx) {
            if (TOTAL_SLIDES <= 1) return;
            bgSlides[currentSlide]?.classList.remove("active");
            txtSlides[currentSlide]?.classList.remove("active");
            dots[currentSlide]?.classList.remove("active");

            currentSlide = (idx + TOTAL_SLIDES) % TOTAL_SLIDES;

            bgSlides[currentSlide]?.classList.add("active");
            txtSlides[currentSlide]?.classList.add("active");
            dots[currentSlide]?.classList.add("active");
            if (counter) counter.textContent = currentSlide + 1;
            resetProgress();
        }

        function resetProgress() {
            if (!progressBar) return;
            clearTimeout(autoPlayTimeout);
            progressBar.style.transition = "none";
            progressBar.style.width = "0%";
            setTimeout(() => {
                progressBar.style.transition = "width " + AUTO_PLAY_DURATION + "ms linear";
                progressBar.style.width = "100%";
            }, 30);
            if (!isPaused && TOTAL_SLIDES > 1) {
                autoPlayTimeout = setTimeout(() => goToSlide(currentSlide + 1), AUTO_PLAY_DURATION);
            }
        }

        document.getElementById("next-btn")?.addEventListener("click", () => goToSlide(currentSlide + 1));
        document.getElementById("prev-btn")?.addEventListener("click", () => goToSlide(currentSlide - 1));
        dots.forEach(dot => {
            dot.addEventListener("click", () => goToSlide(parseInt(dot.dataset.idx)));
        });

        const heroEl = document.getElementById("hero");
        heroEl.addEventListener("mouseenter", () => {
            isPaused = true;
            clearTimeout(autoPlayTimeout);
            if (progressBar) {
                const computed = getComputedStyle(progressBar).width;
                progressBar.style.transition = "none";
                progressBar.style.width = computed;
            }
        });
        heroEl.addEventListener("mouseleave", () => {
            isPaused = false;
            resetProgress();
        });

        let touchStartX = 0;
        heroEl.addEventListener("touchstart", e => {
            touchStartX = e.touches[0].clientX;
        }, {
            passive: true
        });
        heroEl.addEventListener("touchend", e => {
            const diff = touchStartX - e.changedTouches[0].clientX;
            if (Math.abs(diff) > 50) {
                diff > 0 ? goToSlide(currentSlide + 1) : goToSlide(currentSlide - 1);
            }
        }, {
            passive: true
        });

        resetProgress();

        /* ===================================================
           PACKAGES TAB
        =================================================== */
        function switchTab(tab) {
            document.querySelectorAll(".tab-btn").forEach(b => b.classList.toggle("active", b.dataset.tab === tab));
            document.getElementById("pkg-umroh").classList.toggle("active-section", tab === "umroh");
            document.getElementById("pkg-haji").classList.toggle("active-section", tab === "haji");
        }

        /* ===================================================
           TESTIMONIALS
        =================================================== */
        const testimonials = [{
                name: "Bapak Ahmad Fauzi",
                city: "Jakarta",
                package: "Paket Umroh Reguler",
                rating: 5,
                initials: "AF",
                text: "Alhamdulillah, pengalaman umroh bersama {{ $s['brand_name'] ?? 'kami' }} sungguh luar biasa. Semua fasilitas sesuai janji, hotel sangat dekat Masjidil Haram. Muthawif sangat sabar membimbing kami. Insya Allah akan kembali lagi."
            },
            {
                name: "Ibu Siti Rahayu",
                city: "Surabaya",
                package: "Paket Umroh Hemat",
                rating: 5,
                initials: "SR",
                text: "Pelayanan sangat memuaskan! Dari pendaftaran hingga kepulangan, tim sangat profesional dan responsif. Harga terjangkau tapi kualitas tidak mengecewakan. Sangat direkomendasikan untuk keluarga!"
            },
            {
                name: "Bapak Hendra Wijaya",
                city: "Bandung",
                package: "Paket Haji Furoda",
                rating: 5,
                initials: "HW",
                text: "Mimpi saya berangkat haji tahun ini terwujud. Tim sangat membantu proses dokumen yang rumit. Pembimbing haji kami sangat kompeten. Terima kasih banyak!"
            },
            {
                name: "Ibu Dewi Lestari",
                city: "Semarang",
                package: "Paket Umroh VIP",
                rating: 5,
                initials: "DL",
                text: "Sudah 3x umroh bersama sini dan selalu puas. Paket VIP kali ini benar-benar premium — hotel tower, muthawif pribadi, dan pelayanan concierge yang luar biasa. Ibadah makin khusyu dan nyaman."
            }
        ];
        let activeTestimonial = 0;

        function renderTestimonial(i) {
            const t = testimonials[i];
            document.getElementById("testi-stars").innerHTML = "★".repeat(t.rating).split("").map(() =>
                '<span class="testi-star">★</span>').join("");
            document.getElementById("testi-text").textContent = `"${t.text}"`;
            document.getElementById("testi-avatar").textContent = t.initials;
            document.getElementById("testi-name").textContent = t.name;
            document.getElementById("testi-meta").textContent = `${t.city} · ${t.package}`;
            document.querySelectorAll(".testi-dot").forEach((d, idx) => d.classList.toggle("active", idx === i));
            document.querySelectorAll(".testi-thumb").forEach((th, idx) => th.classList.toggle("active", idx === i));
        }

        function buildTestimonials() {
            document.getElementById("testi-dots").innerHTML = testimonials.map((_, i) =>
                `<button class="testi-dot" onclick="setTestimonial(${i})"></button>`).join("");
            document.getElementById("testi-thumbs").innerHTML = testimonials.map((t, i) => `
                <button class="testi-thumb" onclick="setTestimonial(${i})">
                    <div class="testi-thumb-avatar">${t.initials}</div>
                    <div><div class="testi-thumb-name">${t.name.split(" ")[1]}</div><div class="testi-thumb-city">${t.city}</div></div>
                </button>`).join("");
            renderTestimonial(0);
        }

        function setTestimonial(i) {
            activeTestimonial = i;
            renderTestimonial(i);
        }
        buildTestimonials();

        /* ===================================================
           CONTACT FORM
        =================================================== */
        function submitForm() {
            const name = document.getElementById("f-name").value.trim();
            const phone = document.getElementById("f-phone").value.trim();
            if (!name || !phone) {
                alert("Nama dan nomor HP wajib diisi.");
                return;
            }
            document.getElementById("form-main").classList.add("hidden");
            document.getElementById("form-success").classList.add("show");
            setTimeout(() => {
                document.getElementById("form-success").classList.remove("show");
                document.getElementById("form-main").classList.remove("hidden");
                ["f-name", "f-phone", "f-email", "f-message"].forEach(id => document.getElementById(id).value = "");
                document.getElementById("f-package").value = "";
            }, 5000);
        }
    </script>
</body>

</html>

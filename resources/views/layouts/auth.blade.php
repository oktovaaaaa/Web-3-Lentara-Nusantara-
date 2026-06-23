{{-- resources/views/layouts/auth.blade.php --}}
@php
    try {
        $islandImages = \App\Models\Island::query()
            ->where('is_active', true)
            ->orderBy('order')
            ->pluck('image_url')
            ->toArray();
    } catch (\Exception $e) {
        $islandImages = [];
    }

    if (empty($islandImages)) {
        $islandImages = [
            'https://images.unsplash.com/photo-1601058497548-f247dfe349d6?auto=format&fit=crop&q=80&w=1170',
            'https://images.unsplash.com/photo-1733039898491-b4f469c6cd1a?auto=format&fit=crop&q=80&w=1170',
            'https://images.unsplash.com/flagged/photo-1564134204899-4adebaf1adb3?auto=format&fit=crop&q=80&w=735',
            'https://images.unsplash.com/photo-1612091508912-2136973784c3?auto=format&fit=crop&q=80&w=1167',
            'https://images.unsplash.com/photo-1741272689174-f7f03b09a0ab?auto=format&fit=crop&q=80&w=1173',
            'https://images.unsplash.com/photo-1703769605297-cc74106244d9?auto=format&fit=crop&q=80&w=1184'
        ];
    }
@endphp
<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-theme="light">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    {{-- penting buat fetch POST --}}
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'Auth')</title>

    {{-- SET THEME PALING AWAL (default: light) --}}
    <script>
        (function () {
            const saved = localStorage.getItem('piforrr-theme') || 'light';
            document.documentElement.setAttribute('data-theme', saved);
        })();
    </script>

    {{-- Tailwind via CDN (tanpa Vite) --}}
    <script src="https://cdn.tailwindcss.com"></script>

    {{-- OPTIONAL: kalau kamu butuh warna theme dari navbar.css --}}
    <link rel="stylesheet" href="{{ asset('css/navbar.css') }}">

    <style>
        .auth-slideshow {
            position: fixed;
            inset: 0;
            z-index: 0;
            pointer-events: none;
            overflow: hidden;
        }
        .auth-slide {
            position: absolute;
            inset: 0;
            background-size: cover;
            background-position: center;
            opacity: 0;
            transition: opacity 2s ease-in-out, transform 8s ease-in-out;
            transform: scale(1.05);
            z-index: 0;
        }
        .auth-slide.active {
            opacity: 1;
            transform: scale(1);
            z-index: 1;
        }
        .auth-slideshow-overlay {
            position: absolute;
            inset: 0;
            background: radial-gradient(circle at center, rgba(11, 18, 32, 0.45) 0%, rgba(11, 18, 32, 0.85) 100%);
            z-index: 2;
        }
        html[data-theme="light"] .auth-slideshow-overlay {
            background: radial-gradient(circle at center, rgba(248, 250, 252, 0.45) 0%, rgba(248, 250, 252, 0.9) 100%);
        }
        /* Make container transparent to show slideshow */
        .auth-page {
            background: transparent !important;
        }
        /* Ensure banners and form stack correctly */
        .auth-banner {
            z-index: 1 !important;
        }
        .auth-center {
            z-index: 5 !important;
        }
        /* Lower opacity of old glow dots so they blend nicely with the photo bg */
        .auth-glow, .auth-grid {
            opacity: 0.15 !important;
        }
    </style>

    @stack('head')
</head>

<body class="antialiased min-h-screen bg-[var(--bg-body)] text-[var(--txt-body)]">
    
    <!-- STUNNING ROTATING SLIDESHOW BACKGROUND -->
    <div class="auth-slideshow" aria-hidden="true">
        @foreach($islandImages as $index => $img)
            <div class="auth-slide {{ $index === 0 ? 'active' : '' }}" style="background-image: url('{{ $img }}')"></div>
        @endforeach
        <div class="auth-slideshow-overlay"></div>
    </div>

    @yield('content')

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const slides = document.querySelectorAll('.auth-slide');
            if (slides.length <= 1) return;

            let currentIndex = 0;
            setInterval(function() {
                slides[currentIndex].classList.remove('active');
                currentIndex = (currentIndex + 1) % slides.length;
                slides[currentIndex].classList.add('active');
            }, 6000); // 6 seconds rotation
        });
    </script>

    @stack('scripts')
</body>
</html>

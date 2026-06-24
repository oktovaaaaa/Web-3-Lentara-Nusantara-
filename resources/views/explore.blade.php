{{-- resources/views/explore.blade.php --}}
@extends('layouts.app')

@section('title', 'Jelajah Destinasi Nusantara – Lentara')

@section('content')
    {{-- CSS Khusus untuk Halaman Jelajah (Meniru keselarasan tema premium dari homepage) --}}
    <style>
        /* Spacing atas agar tidak tertutup sticky navbar pill */
        .explore-page-section {
            position: relative;
            z-index: 10;
            padding-top: 8rem; /* 128px */
            padding-bottom: 4rem;
            background-color: var(--bg-body);
            color: var(--txt-body);
        }

        @media (max-width: 640px) {
            .explore-page-section {
                padding-top: 7rem;
                padding-bottom: 3rem;
            }
        }

        /* =========================================================
           NEON GRADIENT TITLE & DECORATION (Sesuai tema Beranda)
        ========================================================= */
        .neon-title {
            font-family: 'Cinzel', serif !important;
            letter-spacing: 0.04em;
            text-align: center !important;
            display: block !important;
            width: 100% !important;
            margin-left: auto !important;
            margin-right: auto !important;
            font-size: clamp(2rem, 4vw, 3rem);
            font-weight: 800;
            margin-bottom: 0.5rem;
            position: relative;
            background: linear-gradient(
                90deg,
                #ff6b00 0%,
                #ff8c42 25%,
                #ffaa6b 50%,
                #ff8c42 75%,
                #ff6b00 100%
            );
            background-size: 200% auto;
            background-clip: text;
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            animation: neon-glow 3s ease-in-out infinite;
        }

        .title-decoration {
            width: 120px;
            height: 4px;
            margin: 0.8rem auto 1.5rem;
            background: linear-gradient(90deg, transparent, #ff6b00, transparent);
            border-radius: 2px;
            position: relative;
        }

        .title-decoration::before,
        .title-decoration::after {
            content: '';
            position: absolute;
            width: 8px;
            height: 8px;
            background: #ff6b00;
            border-radius: 50%;
            top: 50%;
            transform: translateY(-50%);
            box-shadow: 0 0 12px #ff6b00;
        }

        .title-decoration::before {
            left: 0;
        }

        .title-decoration::after {
            right: 0;
        }

        .neon-subtitle {
            font-size: 1.1rem;
            color: var(--muted);
            max-width: 760px;
            margin: 0 auto 2rem;
            line-height: 1.6;
            text-align: center;
        }

        @keyframes neon-glow {
            0%, 100% {
                background-position: 0% 50%;
                text-shadow: 0 0 20px rgba(255, 107, 0, 0.3),
                             0 0 40px rgba(255, 140, 66, 0.2);
            }
            50% {
                background-position: 100% 50%;
                text-shadow: 0 0 30px rgba(255, 107, 0, 0.5),
                             0 0 60px rgba(255, 140, 66, 0.3);
            }
        }

        /* =========================================================
           SCROLL REVEAL ANIMATION SYSTEM
        ========================================================= */
        .scroll-reveal {
            opacity: 0;
            will-change: opacity, transform;
            transition-duration: 0.8s;
            transition-timing-function: cubic-bezier(0.16, 1, 0.3, 1);
            transition-property: opacity, transform;
        }

        .delay-100 { transition-delay: 100ms; }
        .delay-150 { transition-delay: 150ms; }
        .delay-200 { transition-delay: 200ms; }
        .delay-300 { transition-delay: 300ms; }

        .reveal-fade-up {
            transform: translateY(30px);
        }
        .reveal-fade-up.active {
            opacity: 1;
            transform: translateY(0);
        }

        .reveal-zoom-in {
            transform: scale(0.95) translateY(15px);
        }
        .reveal-zoom-in.active {
            opacity: 1;
            transform: scale(1) translateY(0);
        }
    </style>

    {{-- Wrapper utama halaman --}}
    <section class="explore-page-section px-4 sm:px-6">
        <div class="max-w-6xl mx-auto">
            @include('partials.nusantara-explorer')
        </div>
    </section>

    {{-- Script untuk Scroll Reveal (karena terpisah dari home.blade.php) --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const revealElements = document.querySelectorAll('.scroll-reveal');
            
            if ('IntersectionObserver' in window) {
                const observerOptions = {
                    root: null,
                    rootMargin: '0px',
                    threshold: 0.08
                };
                
                const revealObserver = new IntersectionObserver(function(entries, observer) {
                    entries.forEach(function(entry) {
                        if (entry.isIntersecting) {
                            entry.target.classList.add('active');
                        } else {
                            const bounding = entry.target.getBoundingClientRect();
                            if (bounding.top > window.innerHeight || bounding.bottom < 0) {
                                entry.target.classList.remove('active');
                            }
                        }
                    });
                }, observerOptions);
                
                revealElements.forEach(function(el) {
                    revealObserver.observe(el);
                });
            } else {
                revealElements.forEach(el => el.classList.add('active'));
            }
        });
    </script>
@endsection

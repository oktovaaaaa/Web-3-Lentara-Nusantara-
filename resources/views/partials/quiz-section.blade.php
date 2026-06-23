{{-- resources/views/partials/quiz-section.blade.php --}}
<link href="https://fonts.googleapis.com/css2?family=Cinzel:wght@600;700;900&family=Playfair+Display:ital,wght@0,500;0,600;0,700;1,400;1,500&display=swap" rel="stylesheet">

@php
  $quiz = $quiz ?? null;
@endphp

@if(!$quiz || $quiz->questions->count() === 0)
    <style>
        .empty-state-card {
            position: relative;
            max-width: 580px;
            margin: 2rem auto;
            padding: 3.5rem 2rem;
            border-radius: 24px;
            background: linear-gradient(145deg, 
                color-mix(in srgb, var(--card) 40%, transparent), 
                color-mix(in srgb, var(--card) 20%, transparent));
            border: 1px solid color-mix(in srgb, var(--line) 40%, transparent);
            box-shadow: 
                0 20px 40px rgba(0, 0, 0, 0.2), 
                inset 0 1px 0 rgba(255, 255, 255, 0.05);
            backdrop-filter: blur(8px);
            -webkit-backdrop-filter: blur(8px);
            overflow: hidden;
            text-align: center;
        }

        html[data-theme="dark"] .empty-state-card {
            background: linear-gradient(145deg, rgba(255, 255, 255, 0.02), rgba(255, 255, 255, 0.005));
            border-color: rgba(255, 255, 255, 0.05);
        }

        .empty-state-card::before {
            content: "";
            position: absolute;
            inset: 0;
            border-radius: inherit;
            padding: 1.5px;
            background: linear-gradient(135deg, rgba(249, 115, 22, 0.3), transparent 70%);
            -webkit-mask: linear-gradient(#fff 0 0) content-box, linear-gradient(#fff 0 0);
            -webkit-mask-composite: xor;
            mask-composite: exclude;
            pointer-events: none;
        }

        .empty-state-icon svg {
            color: var(--brand, #f97316);
            filter: drop-shadow(0 0 12px rgba(249, 115, 22, 0.4));
            animation: pulseGlow 3s infinite ease-in-out;
        }

        @keyframes pulseGlow {
            0%, 100% {
                transform: scale(1);
                filter: drop-shadow(0 0 8px rgba(249, 115, 22, 0.3));
            }
            50% {
                transform: scale(1.05);
                filter: drop-shadow(0 0 20px rgba(249, 115, 22, 0.6));
            }
        }

        .empty-state-title {
            font-family: 'Cinzel', serif !important;
            font-size: 1.35rem;
            font-weight: 700;
            margin: 1rem 0 0.5rem 0;
            color: var(--txt-body);
            letter-spacing: 0.02em;
        }

        .empty-state-desc {
            font-size: 0.95rem;
            line-height: 1.6;
            color: var(--muted);
            max-width: 420px;
            margin: 0 auto;
        }
    </style>

    <div class="empty-state-card scroll-reveal reveal-zoom-in">
        <div class="empty-state-icon">
            <svg class="w-16 h-16 mx-auto" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                <circle cx="12" cy="12" r="10" />
                <path d="M9.09 9a3 3 0 0 1 5.83 1c0 2-3 3-3 3" opacity="0.8" />
                <line x1="12" y1="17" x2="12.01" y2="17" />
            </svg>
        </div>
        <h3 class="empty-state-title">Kuis Budaya Belum Tersedia</h3>
        <p class="empty-state-desc">
            Kuis interaktif untuk menguji wawasan tentang budaya suku ini sedang dipersiapkan oleh tim admin.
        </p>
    </div>
@else
  @php
    // pastikan relasi terurut (kalau belum kamu handle di controller)
    $questions = $quiz->questions->sortBy('order')->values();
  @endphp

<div id="globalQuizWrap"
     class="quiz-container-wrap scroll-reveal reveal-zoom-in"
     style="position: relative;"
     data-total="{{ $questions->count() }}"
     data-sfx-correct="{{ asset('audio/benar.M4A') }}"
     data-sfx-wrong="{{ asset('audio/salah.M4A') }}">

    <!-- Traditional Indonesian Golden Corner Ornaments (outside the clipped card) -->
    <div class="q-corner q-corner-tl" aria-hidden="true">
      <svg width="100%" height="100%" viewBox="0 0 120 120" fill="none" xmlns="http://www.w3.org/2000/svg">
        <defs>
          <linearGradient id="gold-grad-tl" x1="0" y1="0" x2="100" y2="100" gradientUnits="userSpaceOnUse">
            <stop offset="0%" stop-color="#ffe082" />
            <stop offset="30%" stop-color="#ffc107" />
            <stop offset="70%" stop-color="#ff8f00" />
            <stop offset="100%" stop-color="#8d5000" />
          </linearGradient>
          
          <g id="branch-tl-group">
            <!-- Leaf 1 (first inner curl, curving down and left) -->
            <path d="M 22,14 C 20,24 10,26 6,20 C 3,15 6,10 11,8 C 16,6 20,10 22,14 Z" />
            
            <!-- Leaf 2 (first outer curl, curving up and left) -->
            <path d="M 16,11 C 18,3 28,-1 35,2 C 40,4 40,9 36,12 C 32,15 24,14 16,11 Z" />
            
            <!-- Leaf 3 (large middle lobe curving down and right) -->
            <path d="M 35,17 C 45,28 60,30 68,24 C 74,20 72,14 65,12 C 58,10 48,12 35,17 Z" />
            
            <!-- Leaf 4 (large middle lobe curving up and right) -->
            <path d="M 45,15 C 55,4 70,2 78,8 C 84,12 82,18 75,20 C 68,22 58,18 45,15 Z" />
            
            <!-- Leaf 5 (outer curl curving up and right) -->
            <path d="M 68,14 C 78,5 92,4 98,10 C 102,14 100,20 92,21 C 84,22 76,18 68,14 Z" />
            
            <!-- Leaf 6 (inner curl curving down and right) -->
            <path d="M 75,17 C 82,25 94,26 100,21 C 104,17 102,12 95,11 C 88,10 82,13 75,17 Z" />
            
            <!-- Leaf 7 (long elegant tip scrolling up and right) -->
            <path d="M 90,13 C 102,5 114,7 118,13 C 120,16 116,19 110,18 C 102,17 96,15 90,13 Z" />
            
            <!-- The main stem connecting everything -->
            <path d="M 12,12 C 30,16 55,20 75,15 C 85,12.5 95,9 105,10 C 110,10.5 112,12 112,14 C 112,16 108,18 102,17 C 90,15 78,18 68,21 C 48,27 28,22 12,12 Z" />
          </g>
          
          <g id="branch-tl-vertical">
            <use href="#branch-tl-group" transform="rotate(90 12 12)" />
          </g>
        </defs>
        
        <!-- 1. Mask Layer: Block card borders underneath -->
        <g fill="var(--card, #0c1524)" stroke="var(--card, #0c1524)" stroke-width="6" stroke-linejoin="round">
          <use href="#branch-tl-group" />
          <use href="#branch-tl-vertical" />
          <circle cx="12" cy="12" r="10" />
        </g>
        
        <!-- 2. Dark Outline Layer: Gives depth -->
        <g fill="none" stroke="#4e2b02" stroke-width="3" stroke-linejoin="round" stroke-linecap="round">
          <use href="#branch-tl-group" />
          <use href="#branch-tl-vertical" />
          <circle cx="12" cy="12" r="6" />
        </g>
        
        <!-- 3. Gold Body Layer: Filled with the gold gradient -->
        <g fill="url(#gold-grad-tl)" stroke="#5d3403" stroke-width="1.2" stroke-linejoin="round" stroke-linecap="round">
          <use href="#branch-tl-group" />
          <use href="#branch-tl-vertical" />
          <circle cx="12" cy="12" r="5.5" />
        </g>
        
        <!-- 4. Shiny Highlight Veins: White overlays for 3D depth -->
        <g stroke="#ffffff" stroke-width="1.0" stroke-linecap="round" fill="none" opacity="0.9">
          <!-- Horizontal Highlights -->
          <path d="M 18,12 C 22,8 28,6 32,5" />
          <path d="M 38,18 C 45,24 55,26 62,22" />
          <path d="M 48,13 C 55,6 65,4 72,7" stroke-width="1.2" />
          <path d="M 72,13 C 78,7 86,6 92,9" />
          <path d="M 78,18 C 84,22 90,23 94,20" stroke-width="0.8" />
          <path d="M 92,12 C 98,7 105,8 108,11" stroke-width="0.8" />
          
          <!-- Vertical Highlights (Rotated 90 degrees around 12,12) -->
          <g transform="rotate(90 12 12)">
            <path d="M 18,12 C 22,8 28,6 32,5" />
            <path d="M 38,18 C 45,24 55,26 62,22" />
            <path d="M 48,13 C 55,6 65,4 72,7" stroke-width="1.2" />
            <path d="M 72,13 C 78,7 86,6 92,9" />
            <path d="M 78,18 C 84,22 90,23 94,20" stroke-width="0.8" />
            <path d="M 92,12 C 98,7 105,8 108,11" stroke-width="0.8" />
          </g>
          
          <circle cx="11" cy="11" r="1.8" fill="#ffffff" stroke="none" />
        </g>
      </svg>
    </div>
    <div class="q-corner q-corner-tr" aria-hidden="true">
      <svg width="100%" height="100%" viewBox="0 0 120 120" fill="none" xmlns="http://www.w3.org/2000/svg">
        <defs>
          <linearGradient id="gold-grad-tr" x1="0" y1="0" x2="100" y2="100" gradientUnits="userSpaceOnUse">
            <stop offset="0%" stop-color="#ffe082" />
            <stop offset="30%" stop-color="#ffc107" />
            <stop offset="70%" stop-color="#ff8f00" />
            <stop offset="100%" stop-color="#8d5000" />
          </linearGradient>
          
          <g id="branch-tr-group">
            <path d="M 22,14 C 20,24 10,26 6,20 C 3,15 6,10 11,8 C 16,6 20,10 22,14 Z" />
            <path d="M 16,11 C 18,3 28,-1 35,2 C 40,4 40,9 36,12 C 32,15 24,14 16,11 Z" />
            <path d="M 35,17 C 45,28 60,30 68,24 C 74,20 72,14 65,12 C 58,10 48,12 35,17 Z" />
            <path d="M 45,15 C 55,4 70,2 78,8 C 84,12 82,18 75,20 C 68,22 58,18 45,15 Z" />
            <path d="M 68,14 C 78,5 92,4 98,10 C 102,14 100,20 92,21 C 84,22 76,18 68,14 Z" />
            <path d="M 75,17 C 82,25 94,26 100,21 C 104,17 102,12 95,11 C 88,10 82,13 75,17 Z" />
            <path d="M 90,13 C 102,5 114,7 118,13 C 120,16 116,19 110,18 C 102,17 96,15 90,13 Z" />
            <path d="M 12,12 C 30,16 55,20 75,15 C 85,12.5 95,9 105,10 C 110,10.5 112,12 112,14 C 112,16 108,18 102,17 C 90,15 78,18 68,21 C 48,27 28,22 12,12 Z" />
          </g>
          
          <g id="branch-tr-vertical">
            <use href="#branch-tr-group" transform="rotate(90 12 12)" />
          </g>
        </defs>
        
        <g fill="var(--card, #0c1524)" stroke="var(--card, #0c1524)" stroke-width="6" stroke-linejoin="round">
          <use href="#branch-tr-group" />
          <use href="#branch-tr-vertical" />
          <circle cx="12" cy="12" r="10" />
        </g>
        
        <g fill="none" stroke="#4e2b02" stroke-width="3" stroke-linejoin="round" stroke-linecap="round">
          <use href="#branch-tr-group" />
          <use href="#branch-tr-vertical" />
          <circle cx="12" cy="12" r="6" />
        </g>
        
        <g fill="url(#gold-grad-tr)" stroke="#5d3403" stroke-width="1.2" stroke-linejoin="round" stroke-linecap="round">
          <use href="#branch-tr-group" />
          <use href="#branch-tr-vertical" />
          <circle cx="12" cy="12" r="5.5" />
        </g>
        
        <g stroke="#ffffff" stroke-width="1.0" stroke-linecap="round" fill="none" opacity="0.9">
          <path d="M 18,12 C 22,8 28,6 32,5" />
          <path d="M 38,18 C 45,24 55,26 62,22" />
          <path d="M 48,13 C 55,6 65,4 72,7" stroke-width="1.2" />
          <path d="M 72,13 C 78,7 86,6 92,9" />
          <path d="M 78,18 C 84,22 90,23 94,20" stroke-width="0.8" />
          <path d="M 92,12 C 98,7 105,8 108,11" stroke-width="0.8" />
          
          <g transform="rotate(90 12 12)">
            <path d="M 18,12 C 22,8 28,6 32,5" />
            <path d="M 38,18 C 45,24 55,26 62,22" />
            <path d="M 48,13 C 55,6 65,4 72,7" stroke-width="1.2" />
            <path d="M 72,13 C 78,7 86,6 92,9" />
            <path d="M 78,18 C 84,22 90,23 94,20" stroke-width="0.8" />
            <path d="M 92,12 C 98,7 105,8 108,11" stroke-width="0.8" />
          </g>
          
          <circle cx="11" cy="11" r="1.8" fill="#ffffff" stroke="none" />
        </g>
      </svg>
    </div>
    <div class="q-corner q-corner-bl" aria-hidden="true">
      <svg width="100%" height="100%" viewBox="0 0 120 120" fill="none" xmlns="http://www.w3.org/2000/svg">
        <defs>
          <linearGradient id="gold-grad-bl" x1="0" y1="0" x2="100" y2="100" gradientUnits="userSpaceOnUse">
            <stop offset="0%" stop-color="#ffe082" />
            <stop offset="30%" stop-color="#ffc107" />
            <stop offset="70%" stop-color="#ff8f00" />
            <stop offset="100%" stop-color="#8d5000" />
          </linearGradient>
          
          <g id="branch-bl-group">
            <path d="M 22,14 C 20,24 10,26 6,20 C 3,15 6,10 11,8 C 16,6 20,10 22,14 Z" />
            <path d="M 16,11 C 18,3 28,-1 35,2 C 40,4 40,9 36,12 C 32,15 24,14 16,11 Z" />
            <path d="M 35,17 C 45,28 60,30 68,24 C 74,20 72,14 65,12 C 58,10 48,12 35,17 Z" />
            <path d="M 45,15 C 55,4 70,2 78,8 C 84,12 82,18 75,20 C 68,22 58,18 45,15 Z" />
            <path d="M 68,14 C 78,5 92,4 98,10 C 102,14 100,20 92,21 C 84,22 76,18 68,14 Z" />
            <path d="M 75,17 C 82,25 94,26 100,21 C 104,17 102,12 95,11 C 88,10 82,13 75,17 Z" />
            <path d="M 90,13 C 102,5 114,7 118,13 C 120,16 116,19 110,18 C 102,17 96,15 90,13 Z" />
            <path d="M 12,12 C 30,16 55,20 75,15 C 85,12.5 95,9 105,10 C 110,10.5 112,12 112,14 C 112,16 108,18 102,17 C 90,15 78,18 68,21 C 48,27 28,22 12,12 Z" />
          </g>
          
          <g id="branch-bl-vertical">
            <use href="#branch-bl-group" transform="rotate(90 12 12)" />
          </g>
        </defs>
        
        <g fill="var(--card, #0c1524)" stroke="var(--card, #0c1524)" stroke-width="6" stroke-linejoin="round">
          <use href="#branch-bl-group" />
          <use href="#branch-bl-vertical" />
          <circle cx="12" cy="12" r="10" />
        </g>
        
        <g fill="none" stroke="#4e2b02" stroke-width="3" stroke-linejoin="round" stroke-linecap="round">
          <use href="#branch-bl-group" />
          <use href="#branch-bl-vertical" />
          <circle cx="12" cy="12" r="6" />
        </g>
        
        <g fill="url(#gold-grad-bl)" stroke="#5d3403" stroke-width="1.2" stroke-linejoin="round" stroke-linecap="round">
          <use href="#branch-bl-group" />
          <use href="#branch-bl-vertical" />
          <circle cx="12" cy="12" r="5.5" />
        </g>
        
        <g stroke="#ffffff" stroke-width="1.0" stroke-linecap="round" fill="none" opacity="0.9">
          <path d="M 18,12 C 22,8 28,6 32,5" />
          <path d="M 38,18 C 45,24 55,26 62,22" />
          <path d="M 48,13 C 55,6 65,4 72,7" stroke-width="1.2" />
          <path d="M 72,13 C 78,7 86,6 92,9" />
          <path d="M 78,18 C 84,22 90,23 94,20" stroke-width="0.8" />
          <path d="M 92,12 C 98,7 105,8 108,11" stroke-width="0.8" />
          
          <g transform="rotate(90 12 12)">
            <path d="M 18,12 C 22,8 28,6 32,5" />
            <path d="M 38,18 C 45,24 55,26 62,22" />
            <path d="M 48,13 C 55,6 65,4 72,7" stroke-width="1.2" />
            <path d="M 72,13 C 78,7 86,6 92,9" />
            <path d="M 78,18 C 84,22 90,23 94,20" stroke-width="0.8" />
            <path d="M 92,12 C 98,7 105,8 108,11" stroke-width="0.8" />
          </g>
          
          <circle cx="11" cy="11" r="1.8" fill="#ffffff" stroke="none" />
        </g>
      </svg>
    </div>
    <div class="q-corner q-corner-br" aria-hidden="true">
      <svg width="100%" height="100%" viewBox="0 0 120 120" fill="none" xmlns="http://www.w3.org/2000/svg">
        <defs>
          <linearGradient id="gold-grad-br" x1="0" y1="0" x2="100" y2="100" gradientUnits="userSpaceOnUse">
            <stop offset="0%" stop-color="#ffe082" />
            <stop offset="30%" stop-color="#ffc107" />
            <stop offset="70%" stop-color="#ff8f00" />
            <stop offset="100%" stop-color="#8d5000" />
          </linearGradient>
          
          <g id="branch-br-group">
            <path d="M 22,14 C 20,24 10,26 6,20 C 3,15 6,10 11,8 C 16,6 20,10 22,14 Z" />
            <path d="M 16,11 C 18,3 28,-1 35,2 C 40,4 40,9 36,12 C 32,15 24,14 16,11 Z" />
            <path d="M 35,17 C 45,28 60,30 68,24 C 74,20 72,14 65,12 C 58,10 48,12 35,17 Z" />
            <path d="M 45,15 C 55,4 70,2 78,8 C 84,12 82,18 75,20 C 68,22 58,18 45,15 Z" />
            <path d="M 68,14 C 78,5 92,4 98,10 C 102,14 100,20 92,21 C 84,22 76,18 68,14 Z" />
            <path d="M 75,17 C 82,25 94,26 100,21 C 104,17 102,12 95,11 C 88,10 82,13 75,17 Z" />
            <path d="M 90,13 C 102,5 114,7 118,13 C 120,16 116,19 110,18 C 102,17 96,15 90,13 Z" />
            <path d="M 12,12 C 30,16 55,20 75,15 C 85,12.5 95,9 105,10 C 110,10.5 112,12 112,14 C 112,16 108,18 102,17 C 90,15 78,18 68,21 C 48,27 28,22 12,12 Z" />
          </g>
          
          <g id="branch-br-vertical">
            <use href="#branch-br-group" transform="rotate(90 12 12)" />
          </g>
        </defs>
        
        <g fill="var(--card, #0c1524)" stroke="var(--card, #0c1524)" stroke-width="6" stroke-linejoin="round">
          <use href="#branch-br-group" />
          <use href="#branch-br-vertical" />
          <circle cx="12" cy="12" r="10" />
        </g>
        
        <g fill="none" stroke="#4e2b02" stroke-width="3" stroke-linejoin="round" stroke-linecap="round">
          <use href="#branch-br-group" />
          <use href="#branch-br-vertical" />
          <circle cx="12" cy="12" r="6" />
        </g>
        
        <g fill="url(#gold-grad-br)" stroke="#5d3403" stroke-width="1.2" stroke-linejoin="round" stroke-linecap="round">
          <use href="#branch-br-group" />
          <use href="#branch-br-vertical" />
          <circle cx="12" cy="12" r="5.5" />
        </g>
        
        <g stroke="#ffffff" stroke-width="1.0" stroke-linecap="round" fill="none" opacity="0.9">
          <path d="M 18,12 C 22,8 28,6 32,5" />
          <path d="M 38,18 C 45,24 55,26 62,22" />
          <path d="M 48,13 C 55,6 65,4 72,7" stroke-width="1.2" />
          <path d="M 72,13 C 78,7 86,6 92,9" />
          <path d="M 78,18 C 84,22 90,23 94,20" stroke-width="0.8" />
          <path d="M 92,12 C 98,7 105,8 108,11" stroke-width="0.8" />
          
          <g transform="rotate(90 12 12)">
            <path d="M 18,12 C 22,8 28,6 32,5" />
            <path d="M 38,18 C 45,24 55,26 62,22" />
            <path d="M 48,13 C 55,6 65,4 72,7" stroke-width="1.2" />
            <path d="M 72,13 C 78,7 86,6 92,9" />
            <path d="M 78,18 C 84,22 90,23 94,20" stroke-width="0.8" />
            <path d="M 92,12 C 98,7 105,8 108,11" stroke-width="0.8" />
          </g>
          
          <circle cx="11" cy="11" r="1.8" fill="#ffffff" stroke="none" />
        </g>
      </svg>
    </div>





    <div class="quiz-neon-card">

    <!-- Traditional Indonesian Golden Corner Ornaments -->
    
    
    
    

    {{-- ================= HEADER / HUD ================= --}}
    <div class="quiz-header">
      <div class="quiz-header__center">
        <div class="quiz-title">{{ $quiz->title }}</div>

        {{-- ✅ Mode DIHAPUS sesuai request --}}
        <div class="quiz-hudline">
          <span class="hud-chip">
            Soal <b><span data-hud-q>1</span></b>/<span data-hud-total>{{ $questions->count() }}</span>
          </span>

          <span class="hud-dot" aria-hidden="true"></span>

          <span class="hud-chip">
            Benar <b><span data-hud-correct>0</span></b>/<span data-hud-total2>{{ $questions->count() }}</span>
          </span>
        </div>
      </div>

      <div class="quiz-score-badge" aria-label="Skor">
        <div class="quiz-score-label">Skor</div>
        <div class="quiz-score-value"><span data-mini-score>0</span>%</div>
      </div>
    </div>

    {{-- progress (JANGAN DIKURANGI) --}}
    <div class="quiz-progress">
      <div class="quiz-progress-bar" data-progressbar style="width:0%"></div>
      <div class="quiz-progress-glow"></div>
    </div>

    {{-- Elegant Gunungan / Tree of Life Traditional Divider --}}
    <div class="q-divider-container" aria-hidden="true">
      <span class="q-divider-line"></span>
      <div class="q-divider-center">
        <svg class="q-divider-gunungan" viewBox="0 0 64 64" fill="none" xmlns="http://www.w3.org/2000/svg">
          <path d="M32 4L14 44C14 48 20 52 32 52C44 52 50 48 50 44L32 4Z" fill="currentColor" fill-opacity="0.12"/>
          <path d="M32 4L14 44C14 48 20 52 32 52C44 52 50 48 50 44L32 4Z" stroke="currentColor" stroke-width="2" stroke-linejoin="round"/>
          <path d="M32 52V22" stroke="currentColor" stroke-width="2"/>
          <path d="M32 28C28 32 24 35 24 38" stroke="currentColor" stroke-width="1.5"/>
          <path d="M32 34C36 38 40 41 40 44" stroke="currentColor" stroke-width="1.5"/>
          <circle cx="32" cy="18" r="3.5" fill="currentColor"/>
        </svg>
      </div>
      <span class="q-divider-line"></span>
    </div>

    {{-- ================= BODY ================= --}}
    <div data-questions>
      @foreach($questions as $idx => $q)
        @php
          $opts = $q->options->sortBy('order')->values();
        @endphp

        <div class="quiz-question"
             data-qindex="{{ $idx }}"
             style="{{ $idx === 0 ? '' : 'display:none' }}">

          <div class="q-toprow">
            <div class="q-pill">
              Soal {{ $idx + 1 }} / {{ $questions->count() }}
            </div>
            <div class="q-status">
              <span data-status>Belum dijawab</span>
            </div>
          </div>

          @if($q->prompt_type === 'text')
            <h3 class="q-title">{{ $q->prompt_text }}</h3>
          @else
            <h3 class="q-title">Pilih jawaban yang benar dari gambar berikut:</h3>
            <img src="{{ asset('storage/'.$q->prompt_image) }}"
                 class="w-full max-w-md rounded-2xl border border-[var(--line)] mt-3"
                 alt="Soal gambar">
          @endif

          <div class="grid sm:grid-cols-2 gap-3 mt-4" data-options>
            @foreach($opts as $optIndex => $opt)
              @php $letter = chr(65 + $optIndex); @endphp

              <button type="button"
                      class="q-opt"
                      data-correct="{{ $opt->is_correct ? '1' : '0' }}"
                      aria-label="Opsi {{ $letter }}">

                <div class="q-opt__inner">
                  <div class="q-opt__badge">{{ $letter }}</div>

                  <div class="q-opt__content">
                    @if($opt->content_type === 'text')
                      <div class="q-opt__text">{{ $opt->content_text }}</div>
                    @else
                      <img src="{{ asset('storage/'.$opt->content_image) }}"
                           class="q-opt__img"
                           alt="Opsi gambar">
                    @endif
                  </div>

                  <div class="q-opt__mark" aria-hidden="true">
                    <span class="q-opt__mark-ok">✓</span>
                    <span class="q-opt__mark-no">✕</span>
                  </div>
                </div>
              </button>
            @endforeach
          </div>

          <div class="mt-4 q-feedback" data-feedback></div>

          @if($q->explanation)
            <div class="q-explain" data-explain style="display:none;">
              <!-- Mini gold corner details for explanation scroll -->
              <div class="q-explain-corner q-explain-corner-tr"></div>
              <div class="q-explain-corner q-explain-corner-br"></div>
              
              <div class="q-explain__title">Penjelasan</div>
              <div class="q-explain__text">{{ $q->explanation }}</div>
            </div>
          @endif

          <div class="mt-5 q-actions">
            <button type="button"
                    class="q-btn q-btn-ghost"
                    data-prev {{ $idx === 0 ? 'disabled' : '' }}>
              Sebelumnya
            </button>

            <button type="button"
                    class="q-btn q-btn-primary"
                    data-next
                    disabled>
              {{ $idx === $questions->count() - 1 ? 'Selesai' : 'Berikutnya' }}
            </button>
          </div>
        </div>
      @endforeach
    </div>

    {{-- ===== RESULT (dalam card) ===== --}}
    <div data-result style="display:none;">
      <div class="q-result">
        <div class="q-result__spark"></div>

        <div class="text-xs text-[var(--muted)]" style="font-family:'Cinzel', serif; letter-spacing:0.1em; color:#d97706;">Hasil Kuis</div>
        <div class="text-2xl sm:text-3xl font-extrabold mt-1" style="font-family:'Playfair Display', serif;">
          Skor Kamu: <span data-score>0</span>%
        </div>

        <div class="text-sm text-[var(--muted)] mt-2">
          Benar <b data-correct>0</b> dari <b data-total>0</b> soal.
        </div>

        <div class="mt-4 w-full max-w-md mx-auto">
          <div class="q-progress q-progress--big">
            <div data-scorebar class="q-progress__bar" style="width:0%"></div>
            <div class="q-progress__glow"></div>
          </div>
          <div class="mt-2 text-xs text-[var(--muted)]" data-rank>—</div>
        </div>

        <div class="mt-6 q-actions q-actions--center">
          <button type="button" data-restart-2 class="q-btn q-btn-primary">
            Main Lagi
          </button>
          <button type="button" data-back class="q-btn q-btn-ghost">
            Kembali
          </button>
        </div>
      </div>
    </div>

  </div>
  </div>

<style>
  /* =========================================================
     INDONESIAN CULTURAL GOLD & BRONZE BORDER SPIN
  ========================================================= */
  @property --neon-angle {
    syntax: "<angle>";
    inherits: false;
    initial-value: 0deg;
  }

  .quiz-neon-card{
    --quiz-accent: #d97706;    /* ROYAL GOLD */
    --quiz-accent-2: #7c2d12;  /* BRONZE / TERRACOTTA */
    --quiz-success: #065f46;   /* JADE GREEN */
    --quiz-danger: #991b1b;    /* BATIK CRIMSON */

    position:relative;
    border-radius:26px;
    padding: 24px; /* Standardized symmetrical padding */
    background:var(--card);
    
    /* Elegant manual batik (Kawung) watermark background pattern overlay */
    background-image: 
      radial-gradient(circle at center, color-mix(in oklab, var(--card) 91%, transparent) 0%, color-mix(in oklab, var(--card) 97%, transparent) 100%),
      url("data:image/svg+xml,%3Csvg width='40' height='40' viewBox='0 0 40 40' xmlns='http://www.w3.org/2000/svg'%3E%3Ccircle cx='0' cy='0' r='20' fill='none' stroke='%23d97706' stroke-width='0.75' stroke-opacity='0.05'/%3E%3Ccircle cx='40' cy='0' r='20' fill='none' stroke='%23d97706' stroke-width='0.75' stroke-opacity='0.05'/%3E%3Ccircle cx='0' cy='40' r='20' fill='none' stroke='%23d97706' stroke-width='0.75' stroke-opacity='0.05'/%3E%3Ccircle cx='40' cy='40' r='20' fill='none' stroke='%23d97706' stroke-width='0.75' stroke-opacity='0.05'/%3E%3Ccircle cx='20' cy='20' r='20' fill='none' stroke='%23d97706' stroke-width='0.75' stroke-opacity='0.05'/%3E%3Cpath d='M0,20 Q10,10 20,20 Q10,30 0,20' fill='none' stroke='%23d97706' stroke-width='0.75' stroke-opacity='0.08'/%3E%3Cpath d='M20,20 Q30,10 40,20 Q30,30 20,20' fill='none' stroke='%23d97706' stroke-width='0.75' stroke-opacity='0.08'/%3E%3Cpath d='M20,0 Q10,10 20,20 Q30,10 20,0' fill='none' stroke='%23d97706' stroke-width='0.75' stroke-opacity='0.08'/%3E%3Cpath d='M20,20 Q10,30 20,40 Q30,30 20,20' fill='none' stroke='%23d97706' stroke-width='0.75' stroke-opacity='0.08'/%3E%3C/svg%3E");
    background-size: cover, 40px 40px;
    box-shadow:
      0 0 0 1px rgba(255,255,255,.06),
      0 30px 60px rgba(0,0,0,.35);
    overflow:hidden;
    border: 1.5px solid var(--quiz-accent);
  }

  /* Traditional Gold Corner Accents */
  .q-corner {
    position: absolute !important;
    width: 100px;
    height: 100px;
    pointer-events: none;
    z-index: 10 !important;
    opacity: 0.98;
    filter: drop-shadow(0 2px 4px rgba(0,0,0,0.45));
  }
  .q-corner-tl { top: -10px; left: -10px; }
  .q-corner-tr { top: -10px; right: -10px; transform: scaleX(-1); }
  .q-corner-bl { bottom: -10px; left: -10px; transform: scaleY(-1); }
  .q-corner-br { bottom: -10px; right: -10px; transform: scale(-1); }

  .quiz-neon-card::before{
    content:"";
    position:absolute;
    inset:3px;
    border-radius:23px;
    border: 1px solid rgba(217, 119, 6, 0.22);
    pointer-events:none;
    z-index:0;
  }

  .quiz-neon-card > *{ position:relative; z-index:1; }

  /* =========================================================
     HEADER & HUD
  ========================================================= */
  .quiz-header{
    margin: -24px -24px 20px; /* Stretch to cover top/left/right padding of card */
    padding: 36px 24px 24px;  /* Symmetrical padding for header content */
    background-image: 
      linear-gradient(to bottom, rgba(15, 23, 42, 0.55), rgba(15, 23, 42, 0.8)),
      url("{{ asset('images/icon/footer.JPEG') }}");
    background-size: cover;
    background-position: center;
    border-bottom: 3.5px solid var(--quiz-accent);
    box-shadow: inset 0 -4px 10px rgba(0, 0, 0, 0.4);

    display:grid;
    grid-template-columns: 1fr auto 1fr;
    align-items:center;
    gap:12px;
    color: #fff;
  }

  .quiz-header__center{
    grid-column: 2;
    text-align:center;
    display:flex;
    flex-direction:column;
    align-items:center;
    gap:8px;
    min-width: 260px;
  }

  .quiz-title{
    font-family: 'Cinzel', serif;
    font-size:1.35rem;
    font-weight:900;
    letter-spacing: 0.02em;
    line-height:1.2;
    color: #fff !important; /* Ensure title is white on top of the batik pattern */
    text-shadow: 0 2px 4px rgba(0, 0, 0, 0.8);
  }

  .quiz-hudline{
    display:flex;
    align-items:center;
    justify-content:center;
    gap:10px;
    flex-wrap:wrap;
    color: #e5e7eb;
    font-size:.82rem;
  }

  .hud-chip{
    display:inline-flex;
    align-items:center;
    gap:6px;
    padding:6px 12px;
    border-radius:999px;
    background: rgba(15, 23, 42, 0.65) !important; /* Semi-transparent dark background for readability */
    border: 1px solid rgba(217, 119, 6, 0.4) !important;
    box-shadow: 0 6px 14px rgba(0,0,0,.3);
    color: #fff !important;
    font-weight: 500;
  }
  .hud-chip b{ color: var(--quiz-accent); font-weight: 900; }

  .hud-dot{
    width:6px;height:6px;border-radius:999px;
    background: rgba(217,119,6,.7);
    box-shadow: 0 0 0 4px rgba(217,119,6,.15);
  }

  /* Score badge: Royal Gold Plaque */
  .quiz-score-badge{
    grid-column: 3;
    justify-self:end;
    border-radius:14px;
    padding:10px 14px;
    text-align:center;
    color:#fff;
    background: linear-gradient(135deg, #d97706, #9a3412);
    box-shadow: 0 12px 24px rgba(217,119,6,.22);
    border: 1px solid rgba(255,255,255,.1);
    min-width: 92px;
  }
  .quiz-score-label{ font-family: 'Cinzel', serif; font-size:.78rem; opacity:.9; font-weight:700; letter-spacing: 0.05em; }
  .quiz-score-value{ font-family: 'Cinzel', serif; font-weight:900; font-size: 1.05rem; }

  /* =========================================================
     TRADITIONAL DIVIDER
  ========================================================= */
  .q-divider-container {
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 18px 0 14px;
    gap: 16px;
  }
  .q-divider-line {
    flex: 1;
    height: 1.5px;
    background: linear-gradient(90deg, transparent, rgba(217, 119, 6, 0.45), transparent);
  }
  .q-divider-center {
    color: var(--quiz-accent);
    display: flex;
    align-items: center;
    justify-content: center;
    filter: drop-shadow(0 0 6px rgba(217, 119, 6, 0.35));
  }
  .q-divider-gunungan {
    width: 36px;
    height: 36px;
    transition: transform 0.4s ease;
  }
  .quiz-neon-card:hover .q-divider-gunungan {
    transform: scale(1.08);
  }

  @media (max-width: 640px){
    .quiz-header{ grid-template-columns: 1fr auto; }
    .quiz-header__center{
      grid-column: 1 / -1;
      order: 1;
      min-width: unset;
    }
    .quiz-score-badge{
      grid-column: 2;
      order: 0;
      justify-self:end;
    }
  }

  /* =========================================================
     PROGRESS BAR
  ========================================================= */
  .quiz-progress{
    margin:14px 0 12px;
    height:10px;
    border-radius:999px;
    background: color-mix(in oklab, var(--bg-body) 78%, var(--card) 22%);
    border: 1px solid color-mix(in oklab, var(--line) 85%, transparent);
    overflow:hidden;
    position:relative;
  }
  .quiz-progress-bar{
    height:100%;
    width:0%;
    border-radius:999px;
    background: linear-gradient(90deg, var(--quiz-accent), #f59e0b);
    transition: width .45s ease;
    position:relative;
    overflow:hidden;
  }
  .quiz-progress-bar::after{
    content:"";
    position:absolute;
    inset:-40% -20%;
    background:
      linear-gradient(115deg,
        transparent 0%,
        rgba(255,255,255,.20) 18%,
        transparent 36%,
        rgba(255,255,255,.12) 52%,
        transparent 70%);
    transform: translateX(-60%);
    animation: quizShimmer 1.25s linear infinite;
    opacity:.75;
    pointer-events:none;
    mix-blend-mode: screen;
  }
  .quiz-progress-glow{
    position:absolute; inset:0;
    background:
      radial-gradient(circle at 40% 50%, rgba(217,119,6,.1), transparent 58%),
      radial-gradient(circle at 70% 50%, rgba(124,45,18,.08), transparent 58%);
    pointer-events:none;
    opacity:.75;
  }
  @keyframes quizShimmer{ to { transform: translateX(140%); } }

  /* =========================================================
     TOP ROW & TEXT
  ========================================================= */
  .q-toprow{
    display:flex;
    align-items:center;
    justify-content:space-between;
    gap:12px;
    margin-bottom: 12px;
  }
  .q-status{
    font-size:12px;
    color: var(--muted);
    padding: 6px 12px;
    border-radius: 999px;
    border: 1px solid rgba(217, 119, 6, 0.15);
    background: color-mix(in oklab, var(--bg-body) 70%, var(--card) 30%);
    white-space: nowrap;
    font-weight: 500;
  }

  .q-title {
    font-family: 'Playfair Display', serif;
    font-size: 1.15rem;
    line-height: 1.5;
    font-weight: 700;
    color: var(--txt-body);
    text-align: left;
  }

  /* =========================================================
     BUTTONS
  ========================================================= */
  .q-btn{
    font-family: 'Cinzel', serif;
    font-size: 0.85rem;
    letter-spacing: 0.05em;
    border-radius: 14px;
    padding: 12px 20px;
    font-weight: 700;
    border: 1px solid rgba(217, 119, 6, 0.25);
    transition: transform .14s ease, opacity .18s ease, box-shadow .18s ease, filter .18s ease;
    user-select:none;
  }
  .q-btn:active{ transform: translateY(1px); }
  .q-btn:disabled{ opacity:.45; cursor:not-allowed; }

  .q-btn-ghost{
    background: color-mix(in oklab, var(--card) 92%, transparent);
    color: var(--txt-body);
  }
  .q-btn-ghost:hover:not(:disabled){
    border-color: var(--quiz-accent);
    box-shadow: 0 0 0 4px rgba(217, 119, 6, .1);
  }

  .q-btn-primary{
    border: 1px solid rgba(255,255,255,0.15);
    color:#fff;
    background: linear-gradient(135deg, #d97706, #9a3412);
    box-shadow:
      0 12px 24px rgba(217,119,6,.2),
      0 0 0 1px rgba(255,255,255,.05);
  }
  .q-btn-primary:hover:not(:disabled){
    filter: brightness(1.08);
    box-shadow:
      0 14px 28px rgba(217,119,6,.28),
      0 0 0 1px rgba(255,255,255,.08);
  }

  .q-actions{
    display:flex;
    align-items:center;
    justify-content:space-between;
    gap:12px;
  }
  .q-actions--center{
    justify-content:center;
    flex-wrap:wrap;
  }

  /* =========================================================
     OPTIONS (Traditional plaque plates)
  ========================================================= */
  .q-opt{
    text-align:left;
    border-radius: 18px;
    border: 1px solid rgba(217, 119, 6, 0.2);
    background: color-mix(in oklab, var(--card) 95%, transparent);
    padding: 0;
    transition: transform .15s ease, box-shadow .18s ease, border-color .18s ease, filter .18s ease;
    position: relative;
    overflow:hidden;
  }
  .q-opt:hover{
    transform: translateY(-2px);
    box-shadow: 0 12px 24px rgba(217,119,6,.1);
    border-color: var(--quiz-accent);
    filter: brightness(1.02);
  }
  .q-opt.is-locked{ pointer-events:none; opacity:.94; }

  .q-opt__inner{display:flex;gap:12px;align-items:center;padding:14px;position:relative;}
  .q-opt__badge{
    width: 34px; height: 34px; border-radius: 12px;
    display:grid; place-items:center;
    font-family: 'Cinzel', serif;
    font-weight: 900;
    color: #fff;
    background: linear-gradient(135deg, #d97706, #9a3412);
    box-shadow: 0 6px 14px rgba(217,119,6,.2);
    border: 1px solid rgba(255,255,255,0.1);
    flex: 0 0 auto;
  }
  .q-opt__content{ flex:1 1 auto; min-width:0; }

  .q-opt__text{
    font-size:14px;font-weight:700;color:var(--txt-body);line-height:1.35;
    overflow-wrap:anywhere;
    word-break:break-word;
    white-space: normal;
  }
  .q-opt__img{
    width:100%;
    border-radius:14px;
    border:1px solid color-mix(in oklab, var(--line) 85%, transparent);
    display:block;
  }

  .q-opt::after{
    content:"";
    position:absolute; inset:0;
    background: radial-gradient(circle at top right, rgba(217,119,6,.08), transparent 55%);
    opacity:0;
    transition: opacity .18s ease;
    pointer-events:none;
  }
  .q-opt:hover::after{ opacity:1; }

  .q-opt__mark{
    flex: 0 0 auto;
    width: 30px;
    display:grid;
    place-items:center;
    opacity: 0;
    transform: translateX(6px);
    transition: all .18s ease;
    font-weight: 900;
  }
  .q-opt__mark-ok, .q-opt__mark-no{ display:none; font-size: 18px; }

  .q-opt.is-correct{
    border-color: var(--quiz-success);
    background: color-mix(in oklab, var(--card) 95%, var(--quiz-success) 4%);
    box-shadow: 0 0 0 4px rgba(6,95,70,.12), 0 18px 34px rgba(0,0,0,.1);
  }
  .q-opt.is-correct .q-opt__mark{ opacity:1; transform:translateX(0); color: var(--quiz-success); }
  .q-opt.is-correct .q-opt__mark-ok{ display:inline; }

  .q-opt.is-wrong{
    border-color: var(--quiz-danger);
    background: color-mix(in oklab, var(--card) 95%, var(--quiz-danger) 4%);
    box-shadow: 0 0 0 4px rgba(153,27,27,.08), 0 18px 34px rgba(0,0,0,.1);
  }
  .q-opt.is-wrong .q-opt__mark{ opacity:1; transform:translateX(0); color: var(--quiz-danger); }
  .q-opt.is-wrong .q-opt__mark-no{ display:inline; }

  /* =========================================================
     FEEDBACK & BADGES
  ========================================================= */
  .q-pill{
    font-size:12px;font-weight:800;padding:6px 12px;border-radius:999px;
    border:1px solid rgba(217, 119, 6, 0.15);
    background: color-mix(in oklab, var(--bg-body) 70%, var(--card) 30%);
    color: var(--txt-body);
    white-space:nowrap;
  }

  .q-feedback{
    font-weight:900;
    font-size:14px;
    min-height:20px;
    margin-top:14px;
    display:flex;
    align-items:center;
    justify-content: flex-start;
    gap:10px;
    flex-wrap: wrap;
  }
  .q-feedback .ok{ color: var(--quiz-success); }
  .q-feedback .no{ color: var(--quiz-danger); }
  .q-feedback .meta{ font-weight:700;color:var(--muted);font-size:12px; }

  .q-ico{
    width:18px;height:18px;
    display:inline-block;
    vertical-align:-3px;
  }

  /* =========================================================
     PENJELASAN (ROYAL DECREE PARCHMENT SCROLL STYLE)
  ========================================================= */
  @keyframes explainIn {
    from { opacity: 0; transform: translateY(10px); }
    to   { opacity: 1; transform: translateY(0); }
  }

  .q-explain{
    margin-top: 16px;
    border-radius: 18px;
    padding: 18px 20px;
    position: relative;
    overflow: hidden;

    /* Royal parchment tint */
    background: color-mix(in oklab, var(--card) 93%, #d97706 7%);
    border: 1px solid rgba(217, 119, 6, 0.25);
    box-shadow:
      0 12px 28px rgba(0,0,0,.15),
      0 0 0 1px rgba(255,255,255,.05);

    animation: explainIn .28s ease-out both;
  }

  /* Left vertical golden highlight bar */
  .q-explain::before{
    content:"";
    position:absolute;
    left:0; top:0; bottom:0;
    width: 4.5px;
    background: var(--quiz-accent);
  }

  /* Mini corner accents on explanation box */
  .q-explain-corner {
    position: absolute;
    width: 8px;
    height: 8px;
    border: 1px solid var(--quiz-accent);
    pointer-events: none;
    opacity: 0.7;
  }
  .q-explain-corner-tr { top: 8px; right: 8px; border-left: 0; border-bottom: 0; }
  .q-explain-corner-br { bottom: 8px; right: 8px; border-left: 0; border-top: 0; }

  .q-explain__title{
    display:flex;
    align-items:center;
    gap:10px;
    font-family: 'Cinzel', serif;
    font-size: 11px;
    font-weight: 900;
    letter-spacing: .06em;
    text-transform: uppercase;
    color: var(--quiz-accent);
    margin-bottom: 8px;
    position: relative;
    z-index: 1;
  }

  .q-explain__title::before{
    content:"i";
    width: 24px;
    height: 24px;
    border-radius: 999px;
    display:grid;
    place-items:center;
    font-family: 'Cinzel', serif;
    font-weight: 900;
    color: #fff;
    background: linear-gradient(135deg, #d97706, #9a3412);
    box-shadow: 0 6px 12px rgba(217,119,6,.15);
  }

  .q-explain__text{
    font-family: 'Playfair Display', serif;
    font-size: 13.5px;
    line-height: 1.7;
    color: var(--txt-body);
    position: relative;
    z-index: 1;
    text-align: left;
    
    overflow-wrap:anywhere;
    word-break:break-word;
    white-space: normal;
  }
  .q-explain__text strong{ color: var(--quiz-accent); }

  @keyframes quizIn { from{opacity:0; transform: translateY(10px);} to{opacity:1; transform: translateY(0);} }
  @keyframes pop { 0%{transform:scale(.98)} 60%{transform:scale(1.01)} 100%{transform:scale(1)} }
  .quiz-anim-in{ animation: quizIn .28s ease-out both; }
  .quiz-pop{ animation: pop .28s ease-out; }

  /* =========================================================
     RESULT / PEMENANG
  ========================================================= */
  .q-result{
    text-align:center;
    padding: 22px 6px 6px;
    animation: quizIn .28s ease-out both;
    position:relative;
    overflow:hidden;
    border-radius:18px;

    background: color-mix(in oklab, var(--card) 93%, #d97706 7%);
    border: 1px solid rgba(217, 119, 6, 0.25);
    box-shadow: 0 14px 30px rgba(0,0,0,.16);
  }

  .q-result__spark{ display:none; }

  /* progress result */
  .q-progress{
    margin: 0 auto;
    height: 12px;
    border-radius: 999px;
    background: color-mix(in oklab, var(--bg-body) 78%, var(--card) 22%);
    border: 1px solid color-mix(in oklab, var(--line) 85%, transparent);
    overflow:hidden;
    position:relative;
  }
  .q-progress__bar{
    height:100%;
    width:0%;
    border-radius:999px;
    background: linear-gradient(90deg, var(--quiz-accent), var(--quiz-accent-2));
    transition: width .45s ease;
    position:relative;
    overflow:hidden;
  }
  .q-progress__glow{
    position:absolute; inset:0;
    background:
      radial-gradient(circle at 40% 50%, rgba(217,119,6,.12), transparent 60%),
      radial-gradient(circle at 70% 50%, rgba(124,45,18,.08), transparent 60%);
    pointer-events:none;
    opacity:.75;
  }
  .q-progress--big{ height: 12px; }
</style>



  <script>
  (function(){
    const wrap = document.getElementById('globalQuizWrap');
    if(!wrap) return;

    // ===================== SFX (Correct / Wrong) =====================
    const sfxCorrectUrl = wrap.getAttribute('data-sfx-correct') || '';
    const sfxWrongUrl   = wrap.getAttribute('data-sfx-wrong') || '';

    const sfxCorrect = sfxCorrectUrl ? new Audio(sfxCorrectUrl) : null;
    const sfxWrong   = sfxWrongUrl ? new Audio(sfxWrongUrl) : null;

    if (sfxCorrect) sfxCorrect.volume = 0.9;
    if (sfxWrong)   sfxWrong.volume   = 0.9;

    function playSfx(aud){
      if(!aud) return;
      try {
        aud.pause();
        aud.currentTime = 0;
        const p = aud.play();
        if (p && typeof p.catch === 'function') p.catch(()=>{});
      } catch(e){}
    }

    const total = parseInt(wrap.getAttribute('data-total') || '0', 10);

    const questionsWrap = wrap.querySelector('[data-questions]');
    const resultWrap = wrap.querySelector('[data-result]');
    const items = Array.from(wrap.querySelectorAll('.quiz-question'));

    // HUD
    const hudQ = wrap.querySelector('[data-hud-q]');
    const hudTotal = wrap.querySelector('[data-hud-total]');
    const hudTotal2 = wrap.querySelector('[data-hud-total2]');
    const hudCorrect = wrap.querySelector('[data-hud-correct]');
    const miniScore = wrap.querySelector('[data-mini-score]');
    const progressBar = wrap.querySelector('[data-progressbar]');

    // Result nodes (FIX: SCOPE ke resultWrap, biar ga nabrak data-correct option)
    const rScore   = resultWrap?.querySelector('[data-score]');
    const rCorrect = resultWrap?.querySelector('[data-correct]');
    const rTotal   = resultWrap?.querySelector('[data-total]');
    const rRank    = resultWrap?.querySelector('[data-rank]');
    const scoreBar = resultWrap?.querySelector('[data-scorebar]');

    // Buttons
    const restartBtn2 = wrap.querySelector('[data-restart-2]');
    const backBtn = wrap.querySelector('[data-back]');

    // State
    let index = 0;
    let correctCount = 0;
    const answered = new Array(total).fill(false);

    function clamp(n,a,b){ return Math.max(a, Math.min(b,n)); }

    function computeScore(){
      return total ? Math.round((correctCount / total) * 100) : 0;
    }

    // ====== ICON SVG (tanpa emoji) ======
    const ICON = {
      trophy: `<svg class="q-ico" viewBox="0 0 24 24" fill="none" aria-hidden="true">
        <path d="M8 4h8v3a4 4 0 0 1-8 0V4Z" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
        <path d="M6 7H4a2 2 0 0 0 2 2" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
        <path d="M18 7h2a2 2 0 0 1-2 2" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
        <path d="M12 14v3" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
        <path d="M9 20h6" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
      </svg>`,
      spark: `<svg class="q-ico" viewBox="0 0 24 24" fill="none" aria-hidden="true">
        <path d="M12 2l1.2 5.2L18 9l-4.8 1.8L12 16l-1.2-5.2L6 9l4.8-1.8L12 2Z" stroke="currentColor" stroke-width="2" stroke-linejoin="round"/>
      </svg>`,
      check: `<svg class="q-ico" viewBox="0 0 24 24" fill="none" aria-hidden="true">
        <path d="M20 6L9 17l-5-5" stroke="currentColor" stroke-width="2.6" stroke-linecap="round" stroke-linejoin="round"/>
      </svg>`,
      x: `<svg class="q-ico" viewBox="0 0 24 24" fill="none" aria-hidden="true">
        <path d="M18 6L6 18M6 6l12 12" stroke="currentColor" stroke-width="2.6" stroke-linecap="round"/>
      </svg>`
    };

    function rankText(score){
      if (score >= 90) return `${ICON.trophy}<span><b>Hebat!</b> Kamu hampir sempurna.</span>`;
      if (score >= 75) return `${ICON.spark}<span><b>Keren!</b> Tinggal sedikit lagi.</span>`;
      if (score >= 50) return `${ICON.spark}<span><b>Bagus!</b> Coba ulang biar makin tinggi.</span>`;
      return `${ICON.spark}<span><b>Semangat!</b> Coba lagi, kamu pasti bisa.</span>`;
    }

    function updateHud(){
      const done = answered.filter(Boolean).length;
      const pct = total ? Math.round((done / total) * 100) : 0;

      hudQ.textContent = String(index + 1);
      hudTotal.textContent = String(total);
      hudTotal2.textContent = String(total);
      hudCorrect.textContent = String(correctCount);

      progressBar.style.width = pct + '%';

      const score = computeScore();
      miniScore.textContent = String(score);
    }

    function showQuestion(i){
      index = clamp(i, 0, total - 1);

      if (resultWrap) resultWrap.style.display = 'none';
      if (questionsWrap) questionsWrap.style.display = '';

      items.forEach((el, idx) => {
        el.style.display = (idx === index ? '' : 'none');
        if (idx === index) {
          el.classList.remove('quiz-anim-in');
          void el.offsetWidth;
          el.classList.add('quiz-anim-in');
        }
      });

      updateHud();
    }

    function showResult(){
      if (questionsWrap) questionsWrap.style.display = 'none';
      if (resultWrap) resultWrap.style.display = '';

      const score = computeScore();
      if (rScore) rScore.textContent = String(score);
      if (rCorrect) rCorrect.textContent = String(correctCount);
      if (rTotal) rTotal.textContent = String(total);

      if (rRank) rRank.innerHTML = rankText(score);

      if (scoreBar) scoreBar.style.width = score + '%';

      if (progressBar) progressBar.style.width = '100%';
      if (miniScore) miniScore.textContent = String(score);
    }

    function resetAll(){
      index = 0;
      correctCount = 0;
      for (let i=0;i<total;i++) answered[i] = false;

      items.forEach(box => {
        const feedback = box.querySelector('[data-feedback]');
        if (feedback) feedback.innerHTML = '';

        const explain = box.querySelector('[data-explain]');
        if (explain) explain.style.display = 'none';

        const status = box.querySelector('[data-status]');
        if (status) status.textContent = 'Belum dijawab';

        const nextBtn = box.querySelector('[data-next]');
        if (nextBtn) nextBtn.disabled = true;

        const opts = Array.from(box.querySelectorAll('.q-opt'));
        opts.forEach(b => b.classList.remove('is-correct','is-wrong','is-locked'));
      });

      updateHud();
      showQuestion(0);
    }

    // per question handlers
    items.forEach((box, idx) => {
      const feedback = box.querySelector('[data-feedback]');
      const explain  = box.querySelector('[data-explain]');
      const status   = box.querySelector('[data-status]');

      const opts = Array.from(box.querySelectorAll('.q-opt'));
      const prevBtn = box.querySelector('[data-prev]');
      const nextBtn = box.querySelector('[data-next]');

      function lockAll(){ opts.forEach(b => b.classList.add('is-locked')); }

      opts.forEach(btn => {
        btn.addEventListener('click', () => {
          if (answered[idx]) return;

          const isCorrect = btn.getAttribute('data-correct') === '1';
          answered[idx] = true;
          if (isCorrect) correctCount++;

          playSfx(isCorrect ? sfxCorrect : sfxWrong);

          opts.forEach(b => b.classList.remove('is-correct','is-wrong'));
          btn.classList.add(isCorrect ? 'is-correct' : 'is-wrong');

          const trueBtn = opts.find(b => b.getAttribute('data-correct') === '1');
          if (trueBtn) trueBtn.classList.add('is-correct');

          lockAll();

          if (feedback) {
            feedback.innerHTML = isCorrect
              ? `<span class="ok">${ICON.check}<span>Benar</span></span> <span class="meta">+1 poin</span>`
              : `<span class="no">${ICON.x}<span>Salah</span></span> <span class="meta">Baca penjelasan ya</span>`;
          }
          if (status) status.textContent = isCorrect ? 'Benar' : 'Salah';
          if (explain) explain.style.display = '';

          if (nextBtn) nextBtn.disabled = false;

          box.classList.add('quiz-pop');
          setTimeout(() => box.classList.remove('quiz-pop'), 300);

          updateHud();
        });
      });

      prevBtn?.addEventListener('click', () => showQuestion(idx - 1));

      nextBtn?.addEventListener('click', () => {
        if (idx >= total - 1) {
          const allAnswered = answered.every(Boolean);
          if (!allAnswered) return;
          return showResult();
        }
        showQuestion(idx + 1);
      });
    });

    restartBtn2?.addEventListener('click', resetAll);
    backBtn?.addEventListener('click', () => {
      if (questionsWrap) questionsWrap.style.display = '';
      if (resultWrap) resultWrap.style.display = 'none';
      showQuestion(index);
    });

    updateHud();
    showQuestion(0);
  })();
  </script>
@endif

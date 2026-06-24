{{-- resources/views/player/register.blade.php (contoh) --}}
@extends('layouts.auth')

@section('title', 'Daftar - Lentara Nusantara')
    <link rel="icon" type="image/png" href="{{ asset('images/icon/icon_lentara.PNG') }}">
    <link rel="shortcut icon" type="image/png" href="{{ asset('images/icon/icon_lentara.PNG') }}">
@section('content')
<div class="auth-page">

    {{-- TOP BANNER IMAGE --}}
    <div class="auth-banner auth-banner--top" aria-hidden="true">
        <img
            src="{{ asset('images/icon/footer.JPEG') }}"
            alt="Lentara Top Banner"
            class="auth-banner__img"
            loading="lazy"
        />
        <div class="auth-banner__overlay auth-banner__overlay--top"></div>
    </div>

    {{-- BOTTOM BANNER IMAGE --}}
    <div class="auth-banner auth-banner--bottom" aria-hidden="true">
        <div class="auth-banner__overlay auth-banner__overlay--bottom"></div>
        <img
            src="{{ asset('images/icon/footer.JPEG') }}"
            alt="Lentara Bottom Banner"
            class="auth-banner__img"
            loading="lazy"
        />
    </div>

    {{-- BACKGROUND GLOW / ORNAMENT --}}
    <div class="auth-bg" aria-hidden="true">
        <div class="auth-glow auth-glow--a"></div>
        <div class="auth-glow auth-glow--b"></div>
        <div class="auth-grid"></div>
    </div>

    {{-- CENTER WRAP --}}
    <div class="auth-center">
        <div class="auth-card" role="region" aria-label="Register Player">

            {{-- Header --}}
            <div class="auth-head">
                <div class="auth-badge" aria-hidden="true">
                    {{-- icon sama feel --}}
                    <svg viewBox="0 0 24 24" fill="none">
                        <path d="M12 2l7 4v6c0 5-3 9-7 10-4-1-7-5-7-10V6l7-4Z" stroke="currentColor" stroke-width="2" stroke-linejoin="round"/>
                        <path d="M9.5 12l1.7 1.8L14.7 10" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </div>

                <h1 class="auth-title">Daftar</h1>
                <p class="auth-subtitle">Buat akun dengan username dan PIN 4 digit</p>
            </div>

            {{-- Error Pop-up Modal --}}
            @if(session('error') || $errors->any())
                <div id="error-popup-modal" class="error-popup-overlay" role="dialog" aria-modal="true">
                    <div class="error-popup-card">
                        <div class="error-popup-icon">
                            <svg viewBox="0 0 24 24" fill="none" style="width: 32px; height: 32px; color: #ef4444;">
                                <path d="M12 9v4M12 17h.01M12 3a9 9 0 1 1-9 9 9 9 0 0 1 9-9Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                        </div>
                        <h2 class="error-popup-title">Autentikasi Gagal</h2>
                        <p class="error-popup-message">
                            @if(session('error'))
                                {{ session('error') }}
                            @else
                                {{ $errors->first() }}
                            @endif
                        </p>
                        <button type="button" class="error-popup-btn" onclick="closeErrorPopup()">Tutup</button>
                    </div>
                </div>
            @endif

            {{-- Form (FUNGSI TETAP PUNYA KAMU) --}}
            <form method="POST" action="{{ route('player.register.post') }}" class="auth-form">
                @csrf

                {{-- Username --}}
                <div class="auth-field">
                    <label class="auth-label" for="username">Username</label>
                    <div class="auth-inputWrap">
                        <span class="auth-ico" aria-hidden="true">
                            {{-- icon user --}}
                            <svg viewBox="0 0 24 24" fill="none">
                                <path d="M20 21a8 8 0 0 0-16 0" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                                <path d="M12 12a5 5 0 1 0-5-5 5 5 0 0 0 5 5Z" stroke="currentColor" stroke-width="2" stroke-linejoin="round"/>
                            </svg>
                        </span>
                        <input
                            id="username"
                            name="username"
                            value="{{ old('username') }}"
                            required
                            autofocus
                            placeholder=""
                            class="auth-input"
                            autocomplete="username"
                        >
                    </div>
                </div>

                {{-- PIN (4 digit) --}}
                <div class="auth-field">
                    <label class="auth-label" style="text-align: center; display: block; margin-bottom: 4px;">PIN (4 digit)</label>
                    <div class="pin-inputs-wrapper" style="display: flex; gap: 12px; justify-content: center; margin: 6px 0 10px;">
                        <input type="text" maxlength="1" pattern="[0-9]" inputmode="numeric" class="pin-box" required autocomplete="off">
                        <input type="text" maxlength="1" pattern="[0-9]" inputmode="numeric" class="pin-box" required autocomplete="off">
                        <input type="text" maxlength="1" pattern="[0-9]" inputmode="numeric" class="pin-box" required autocomplete="off">
                        <input type="text" maxlength="1" pattern="[0-9]" inputmode="numeric" class="pin-box" required autocomplete="off">
                    </div>
                    <input type="hidden" name="pin" id="compiled_pin">
                </div>

                {{-- Row --}}
                <div class="auth-row">
                    <a href="{{ route('player.login') }}" class="auth-back">Sudah punya akun? Masuk</a>
                    <a href="{{ route('home') }}" class="auth-back">← Kembali</a>
                </div>

                {{-- Button --}}
                <button type="submit" class="auth-btn">
                    <span class="auth-btn__shine" aria-hidden="true"></span>
                    <span class="auth-btn__text">Buat Akun</span>
                    <span class="auth-btn__icon" aria-hidden="true">
                        <svg viewBox="0 0 24 24" fill="none">
                            <path d="M10 17l5-5-5-5" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            <path d="M4 12h10" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                        </svg>
                    </span>
                </button>

                {{-- Divider --}}
                <div class="auth-divider">
                    <span>atau</span>
                </div>

                {{-- Google Signup Button --}}
                <a href="{{ route('player.login.google') }}" class="auth-btn-google">
                    <img src="https://www.svgrepo.com/show/475656/google-color.svg" alt="Google Logo" class="auth-btn-google__icon">
                    <span class="auth-btn-google__text">Daftar dengan Google</span>
                </a>

            </form>

        </div>
    </div>
</div>

<style>
/* =========================================================
   AUTH REGISTER — LENTARA THEME (INTERNAL CSS)
   (SAMA PERSIS DENGAN LOGIN ADMIN/PLAYER STYLE)
========================================================= */

/* fallback variable kalau navbar.css tidak ada */
html{
  --bg-body: #0b1220;
  --txt-body: rgba(226,232,240,.96);
  --muted: rgba(148,163,184,.92);
  --line: rgba(148,163,184,.20);
  --card: rgba(15,23,42,.74);

  --brand: #ff6b00;
  --brand2:#ff8c42;
  --brand3:#ffaa6b;
}

html[data-theme="light"]{
  --bg-body: #f8fafc;
  --txt-body: rgba(15,23,42,.95);
  --muted: rgba(71,85,105,.90);
  --line: rgba(15,23,42,.14);
  --card: rgba(255,255,255,.78);

  --brand: #ff6b00;
  --brand2:#ff8c42;
  --brand3:#ffaa6b;

    /* ✅ DANGER (light mode) */
  --danger-bg: rgba(239,68,68,.10);
  --danger-border: rgba(185,28,28,.28);
  --danger-text: rgba(127,29,29,.96); /* MERAH GELAP → KEBACA */
  --danger-dot: #dc2626;

}

.auth-page{
  min-height: 100vh;
  position: relative;
  overflow: hidden;
  background: var(--bg-body);
  color: var(--txt-body);
}

/* Banners */
.auth-banner{
  position: absolute;
  left: 0; right: 0;
  height: 64px;
  z-index: 0;
}
.auth-banner--top{ top: 0; }
.auth-banner--bottom{ bottom: 0; }

.auth-banner__img{
  width: 100%;
  height: 100%;
  object-fit: cover;
  display: block;
  opacity: .92;
  filter: saturate(1.04);
}

.auth-banner__overlay{
  position: absolute;
  inset: 0;
  pointer-events: none;
}
.auth-banner__overlay--top{
  background: linear-gradient(to bottom, rgba(0,0,0,.22), rgba(0,0,0,.06), transparent);
}
.auth-banner__overlay--bottom{
  background: linear-gradient(to top, rgba(0,0,0,.26), rgba(0,0,0,.08), transparent);
}

/* Background ornaments */
.auth-bg{
  position: absolute;
  inset: 0;
  z-index: 0;
  pointer-events: none;
}

.auth-glow{
  position: absolute;
  width: 520px;
  height: 520px;
  border-radius: 999px;
  filter: blur(60px);
  opacity: .28;
}
.auth-glow--a{
  top: -160px;
  left: -160px;
  background: radial-gradient(circle, rgba(255,107,0,.75), transparent 60%);
}
.auth-glow--b{
  bottom: -180px;
  right: -160px;
  background: radial-gradient(circle, rgba(255,140,66,.70), transparent 60%);
}

.auth-grid{
  position: absolute;
  inset: 0;
  opacity: .10;
  background-image:
    linear-gradient(to right, rgba(255,107,0,.18) 1px, transparent 1px),
    linear-gradient(to bottom, rgba(255,107,0,.14) 1px, transparent 1px);
  background-size: 44px 44px;
  mask-image: radial-gradient(circle at 50% 45%, #000 0%, rgba(0,0,0,.45) 45%, transparent 70%);
}

/* Center */
.auth-center{
  min-height: 100vh;
  display: flex;
  align-items: center;
  justify-content: center;
  padding: 22px;
  position: relative;
  z-index: 1;
}

/* Neon ring animation */
@property --auth-angle{
  syntax: "<angle>";
  inherits: false;
  initial-value: 0deg;
}

@keyframes authSpin { to { --auth-angle: 360deg; } }
@keyframes authTitleGlow { to { background-position: 200% center; } }

/* Card */
.auth-card{
  width: min(390px, 100%);
  border-radius: 20px;
  position: relative;
  overflow: hidden;
  background:
    linear-gradient(180deg,
      color-mix(in oklab, var(--card) 88%, transparent),
      color-mix(in oklab, var(--card) 95%, transparent)
    );
  border: 1px solid color-mix(in oklab, var(--line) 90%, transparent);
  box-shadow: 0 26px 90px rgba(0,0,0,.26);
  backdrop-filter: blur(14px);
  isolation: isolate;
}

/* Neon ring */
.auth-card::before{
  content:"";
  position:absolute;
  inset:0;
  border-radius: inherit;
  padding: 7px; /* KETEBALAN RING (ubah ini kalau mau lebih tebal/tipis) */
  pointer-events:none;
  z-index:0;

  background: conic-gradient(
    from var(--auth-angle),
    rgba(255,107,0,0) 0deg,
    rgba(255,107,0,.20) 28deg,
    #ff6b00 60deg,
    #22d3ee 120deg,
    #34d399 180deg,
    rgba(34,211,238,.18) 245deg,
    #ff8c42 315deg,
    rgba(255,107,0,0) 360deg
  );

  -webkit-mask:
    linear-gradient(#000 0 0) content-box,
    linear-gradient(#000 0 0);
  -webkit-mask-composite: xor;
  mask-composite: exclude;

  filter: blur(6px);
  opacity: .95;
  animation: authSpin 7.5s linear infinite;
}

/* ensure content above ring */
.auth-card > *{
  position: relative;
  z-index: 1;
}

/* Inner padding */
.auth-head{
  padding: 16px 20px 8px;
  text-align: center;
}

.auth-badge{
  width: 52px;
  height: 52px;
  margin: 0 auto 10px;
  border-radius: 16px;
  display: grid;
  place-items: center;
  color: #fff;
  background: linear-gradient(135deg, var(--brand), var(--brand2));
  box-shadow: 0 18px 40px rgba(0,0,0,.22), 0 0 22px rgba(255,107,0,.18);
}
.auth-badge svg{ width: 26px; height: 26px; opacity: .95; }

.auth-title{
  margin: 0;
  font-size: 1.55rem;
  font-weight: 950;
  letter-spacing: .01em;
  line-height: 1.1;
  background: linear-gradient(90deg, var(--brand), var(--brand2), var(--brand3), var(--brand2), var(--brand));
  background-size: 200% auto;
  -webkit-background-clip: text;
  background-clip: text;
  color: transparent;
  animation: authTitleGlow 5.2s linear infinite;
}

.auth-subtitle{
  margin: 8px 0 0;
  font-size: .82rem;
  color: color-mix(in oklab, var(--muted) 92%, transparent);
}

/* Error (THEME SAFE) */
.auth-error{
  margin: 0 22px 10px;
  padding: 10px 12px;
  border-radius: 14px;

  border: 1px solid var(--danger-border);
  background: var(--danger-bg);
  color: var(--danger-text);

  display: flex;
  gap: 10px;
  align-items: flex-start;
  font-size: .86rem;

  box-shadow: 0 10px 30px rgba(0,0,0,.06);
}

.auth-error__dot{
  width: 10px;
  height: 10px;
  border-radius: 999px;
  margin-top: 4px;
  background: var(--danger-dot);
  box-shadow: 0 0 14px rgba(239,68,68,.30);
}


/* Form */
.auth-form{
  padding: 8px 20px 18px;
  display: grid;
  gap: 10px;
}

.auth-field{ display: grid; gap: 8px; }
.auth-label{
  font-size: .86rem;
  font-weight: 850;
  color: color-mix(in oklab, var(--txt-body) 88%, transparent);
}

.auth-inputWrap{
  position: relative;
  border-radius: 16px;
  border: 1px solid rgba(255,107,0,.22);
  background: color-mix(in oklab, var(--bg-body) 86%, transparent);
  overflow: hidden;
  transition: border-color .2s ease, box-shadow .2s ease, transform .2s ease;
}

.auth-inputWrap:focus-within{
  border-color: rgba(255,107,0,.58);
  box-shadow: 0 0 0 4px rgba(255,107,0,.16);
  transform: translateY(-1px);
}

.auth-ico{
  position: absolute;
  left: 12px;
  top: 50%;
  transform: translateY(-50%);
  width: 34px;
  height: 34px;
  border-radius: 12px;
  display: grid;
  place-items: center;
  color: var(--brand2);
  background: rgba(255,107,0,.10);
  border: 1px solid rgba(255,107,0,.18);
}
.auth-ico svg{ width: 18px; height: 18px; opacity: .95; }

.auth-input{
  width: 100%;
  border: 0;
  outline: none;
  background: transparent;
  color: var(--txt-body);
  padding: 12px 12px 12px 54px;
  font-size: .92rem;
}
.auth-input::placeholder{
  color: color-mix(in oklab, var(--muted) 92%, transparent);
}

/* Row */
.auth-row{
  display:flex;
  align-items:center;
  justify-content: space-between;
  gap: 14px;
  margin-top: 2px;
  flex-wrap: wrap;
}

.auth-back{
  font-size: .82rem;
  font-weight: 950;
  color: var(--brand2);
  text-decoration: none;
  transition: filter .2s ease, transform .2s ease;
}
.auth-back:hover{
  filter: saturate(1.12);
  transform: translateY(-1px);
}

/* Button */
.auth-btn{
  margin-top: 6px;
  width: 100%;
  border: 0;
  cursor: pointer;
  border-radius: 999px;
  padding: 11px 14px;
  display:flex;
  align-items:center;
  justify-content:center;
  gap: 10px;

  background: linear-gradient(135deg, var(--brand), var(--brand2));
  color: #0b1220;
  font-weight: 950;
  letter-spacing: .01em;

  box-shadow: 0 18px 50px rgba(0,0,0,.22), 0 0 26px rgba(255,107,0,.16);
  position: relative;
  overflow: hidden;
  transition: transform .18s ease, box-shadow .18s ease, filter .18s ease;
}
.auth-btn:hover{
  transform: translateY(-2px);
  box-shadow: 0 24px 70px rgba(0,0,0,.26), 0 0 32px rgba(255,107,0,.20);
  filter: saturate(1.06);
}
.auth-btn:active{ transform: translateY(0px) scale(.99); }

.auth-btn__shine{
  position:absolute;
  inset:-2px;
  background: radial-gradient(220px 80px at 18% 0%, rgba(255,255,255,.40), transparent 60%);
  opacity: .0;
  transition: opacity .2s ease;
  pointer-events:none;
}
.auth-btn:hover .auth-btn__shine{ opacity: 1; }

.auth-btn__text{ font-size: .94rem; }
.auth-btn__icon{
  width: 22px;
  height: 22px;
  display:grid;
  place-items:center;
  border-radius: 999px;
  background: rgba(255,255,255,.30);
  border: 1px solid rgba(0,0,0,.08);
}
.auth-btn__icon svg{ width: 18px; height: 18px; color: rgba(2,6,23,.90); }

/* Divider */
.auth-divider {
  display: flex;
  align-items: center;
  text-align: center;
  margin: 6px 0;
  color: var(--muted);
  font-size: 0.8rem;
  font-weight: 700;
}
.auth-divider::before,
.auth-divider::after {
  content: '';
  flex: 1;
  border-bottom: 1px solid var(--line);
}
.auth-divider:not(:empty)::before {
  margin-right: .5em;
}
.auth-divider:not(:empty)::after {
  margin-left: .5em;
}

/* Google Button */
.auth-btn-google {
  display: flex;
  align-items: center;
  justify-content: center;
  gap: 12px;
  width: 100%;
  padding: 11px 14px;
  border-radius: 999px;
  border: 1px solid var(--line);
  background: color-mix(in oklab, var(--card) 95%, transparent);
  color: var(--txt-body) !important;
  font-size: 0.92rem;
  font-weight: 850;
  text-decoration: none;
  box-shadow: 0 4px 12px rgba(0,0,0,0.15);
  transition: background-color 0.2s ease, transform 0.2s ease, box-shadow 0.2s ease;
}
.auth-btn-google:hover {
  background: color-mix(in oklab, var(--card) 60%, var(--brand2) 10%);
  transform: translateY(-2px);
  box-shadow: 0 8px 20px rgba(0,0,0,0.25);
  border-color: rgba(255,107,0,0.4);
}
.auth-btn-google:active {
  transform: translateY(0);
}
.auth-btn-google__icon {
  width: 20px;
  height: 20px;
  object-fit: contain;
}

html[data-theme="light"] .auth-btn-google {
  background: rgba(255, 255, 255, 0.9);
  border-color: rgba(15,23,42,.14);
}
html[data-theme="light"] .auth-btn-google:hover {
  background: rgba(255, 255, 255, 1);
  border-color: rgba(255,107,0,0.4);
}

/* ==========================================
   PIN INPUTS (4 BOXES) & ERROR POPUP STYLES
   ========================================== */
.pin-box {
  width: 46px;
  height: 46px;
  border-radius: 12px;
  border: 1px solid rgba(255,107,0,.22);
  background: color-mix(in oklab, var(--bg-body) 86%, transparent);
  color: var(--txt-body);
  font-size: 1.4rem;
  font-weight: 800;
  text-align: center;
  outline: none;
  transition: border-color 0.2s ease, box-shadow 0.2s ease, transform 0.2s ease;
}

.pin-box:focus {
  border-color: rgba(255,107,0,.58);
  box-shadow: 0 0 0 4px rgba(255,107,0,.16);
  transform: translateY(-2px);
}

html[data-theme="light"] .pin-box {
  background: rgba(255, 255, 255, 0.92);
  border-color: rgba(255,107,0,.25);
  box-shadow: 0 4px 12px rgba(2,6,23,.04);
}

.error-popup-overlay {
  position: fixed;
  inset: 0;
  background: rgba(11, 18, 32, 0.76);
  backdrop-filter: blur(8px);
  display: flex;
  align-items: center;
  justify-content: center;
  z-index: 9999;
  animation: fadeInModal 0.25s ease-out;
}

.error-popup-card {
  width: min(380px, 90%);
  background: linear-gradient(180deg, rgba(15,23,42,.88), rgba(15,23,42,.96));
  border: 1px solid rgba(239, 68, 68, 0.25);
  border-radius: 24px;
  padding: 26px;
  text-align: center;
  box-shadow: 0 20px 60px rgba(0,0,0,0.5), 0 0 30px rgba(239, 68, 68, 0.1);
  transform: scale(0.9);
  animation: scaleInModal 0.3s cubic-bezier(0.34, 1.56, 0.64, 1) forwards;
}

.error-popup-icon {
  width: 60px;
  height: 60px;
  background: rgba(239, 68, 68, 0.1);
  border: 1px solid rgba(239, 68, 68, 0.2);
  border-radius: 50%;
  display: grid;
  place-items: center;
  margin: 0 auto 16px;
}

.error-popup-title {
  margin: 0 0 8px;
  font-size: 1.25rem;
  font-weight: 900;
  color: var(--txt-body);
}

.error-popup-message {
  margin: 0 0 22px;
  font-size: 0.9rem;
  color: var(--muted);
  line-height: 1.5;
}

.error-popup-btn {
  width: 100%;
  border: 0;
  background: linear-gradient(135deg, #ef4444, #b91c1c);
  color: white;
  font-weight: 950;
  padding: 11px 14px;
  border-radius: 999px;
  cursor: pointer;
  box-shadow: 0 8px 24px rgba(239, 68, 68, 0.25);
  transition: transform 0.2s ease, box-shadow 0.2s ease;
}

.error-popup-btn:hover {
  transform: translateY(-1px);
  box-shadow: 0 12px 30px rgba(239, 68, 68, 0.35);
}

@keyframes fadeInModal {
  from { opacity: 0; }
  to { opacity: 1; }
}

@keyframes scaleInModal {
  to { transform: scale(1); }
}

html[data-theme="light"] .error-popup-card {
  background: rgba(255, 255, 255, 0.95);
  border-color: rgba(239, 68, 68, 0.2);
  box-shadow: 0 20px 60px rgba(15,23,42,0.12), 0 0 30px rgba(239, 68, 68, 0.05);
}
</style>

<script>
function closeErrorPopup() {
  const modal = document.getElementById('error-popup-modal');
  if (modal) {
    modal.style.opacity = '0';
    modal.style.transition = 'opacity 0.2s ease';
    setTimeout(() => {
      modal.remove();
    }, 200);
  }
}

document.addEventListener('DOMContentLoaded', function() {
  const boxes = document.querySelectorAll('.pin-box');
  const compiledPinInput = document.getElementById('compiled_pin');

  if (boxes.length > 0 && compiledPinInput) {
    boxes.forEach((box, index) => {
      // Only allow numbers
      box.addEventListener('input', (e) => {
        box.value = box.value.replace(/[^0-9]/g, '');
        if (box.value.length === 1 && index < boxes.length - 1) {
          boxes[index + 1].focus();
        }
        updateCompiledPin();
      });

      // Handle backspace
      box.addEventListener('keydown', (e) => {
        if (e.key === 'Backspace' && box.value.length === 0 && index > 0) {
          boxes[index - 1].value = ''; // clear previous box too
          boxes[index - 1].focus();
          updateCompiledPin();
        }
      });
      
      // Handle paste
      box.addEventListener('paste', (e) => {
        e.preventDefault();
        const pastedData = e.clipboardData.getData('text').replace(/[^0-9]/g, '').slice(0, 4);
        for (let i = 0; i < pastedData.length; i++) {
          if (boxes[i]) {
            boxes[i].value = pastedData[i];
          }
        }
        updateCompiledPin();
        if (pastedData.length > 0) {
          const nextIndex = Math.min(pastedData.length, boxes.length - 1);
          boxes[nextIndex].focus();
        }
      });
    });

    function updateCompiledPin() {
      let compiled = '';
      boxes.forEach(box => {
        compiled += box.value;
      });
      compiledPinInput.value = compiled;
    }
  }
});
</script>
@endsection

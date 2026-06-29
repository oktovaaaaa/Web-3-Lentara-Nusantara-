{{-- resources/views/player/auth/google_complete.blade.php --}}
@extends('layouts.auth')

@section('title', 'Lengkapi Akun Google - Lentara Nusantara')

@section('content')
<div class="auth-page">
    {{-- BACKGROUND GLOW --}}
    <div class="auth-bg" aria-hidden="true">
        <div class="auth-glow auth-glow--a"></div>
        <div class="auth-glow auth-glow--b"></div>
        <div class="auth-grid"></div>
    </div>

    <div class="auth-center">
        <div class="auth-card" style="max-width: 440px;">
            <div class="auth-head" style="padding-bottom: 10px;">
                <div class="auth-badge" aria-hidden="true" style="background: linear-gradient(135deg, var(--brand), var(--brand2));">
                    <svg viewBox="0 0 24 24" fill="none" style="width: 26px; height: 26px; color: white;">
                        <path d="M12 2l7 4v6c0 5-3 9-7 10-4-1-7-5-7-10V6l7-4Z" stroke="currentColor" stroke-width="2" stroke-linejoin="round"/>
                        <path d="M9.5 12l1.7 1.8L14.7 10" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </div>
                <h1 class="auth-title">Amankan Akun</h1>
                <p class="auth-subtitle">Buat PIN 4 digit untuk mengamankan akun Google Anda</p>
            </div>

            {{-- Google User Info Card --}}
            <div style="margin: 10px 22px; padding: 12px; border-radius: 14px; background: rgba(255,107,0,0.06); border: 1px solid rgba(255,107,0,0.2); display: flex; align-items: center; gap: 12px;">
                <div style="width: 40px; height: 40px; border-radius: 50%; background: var(--brand); color: white; display: flex; align-items: center; justify-content: center; font-weight: 800; font-size: 1rem; flex-shrink: 0;">
                    {{ substr($nickname, 0, 1) }}
                </div>
                <div style="flex: 1; min-width: 0;">
                    <div style="font-size: 0.88rem; font-weight: 800; color: var(--txt-body);">{{ $nickname }}</div>
                    <div style="font-size: 0.75rem; color: var(--muted); overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">{{ $email }}</div>
                    <div style="font-size: 0.75rem; font-weight: 800; color: var(--brand2); margin-top: 2px;">Username: {{ old('username', $suggested_username) }}</div>
                </div>
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
                        <h2 class="error-popup-title">Pendaftaran Gagal</h2>
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

            <form method="POST" action="{{ route('player.google.complete.post') }}" class="auth-form">
                @csrf
                <input type="hidden" name="email" value="{{ $email }}">
                <input type="hidden" name="nickname" value="{{ $nickname }}">
                <input type="hidden" name="google_id" value="{{ $google_id }}">

                {{-- Username Input Field --}}
                <div class="auth-field">
                    <label class="auth-label" for="username">Username Akun Game</label>
                    <div class="auth-inputWrap">
                        <span class="auth-ico" aria-hidden="true">
                            <svg viewBox="0 0 24 24" fill="none">
                                <path d="M20 21a8 8 0 0 0-16 0" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                                <path d="M12 12a5 5 0 1 0-5-5 5 5 0 0 0 5 5Z" stroke="currentColor" stroke-width="2" stroke-linejoin="round"/>
                            </svg>
                        </span>
                        <input
                            id="username"
                            name="username"
                            value="{{ old('username', $suggested_username) }}"
                            required
                            placeholder="Tulis username Anda"
                            class="auth-input"
                            autocomplete="username"
                        >
                    </div>
                    <p style="font-size: 0.72rem; color: var(--muted); margin: 2px 0 0 4px;">Gunakan username ini & PIN 4-digit Anda jika ingin masuk manual tanpa Google.</p>
                </div>

                {{-- PIN (4 digit) --}}
                <div class="auth-field" style="margin-top: 4px;">
                    <label class="auth-label" style="text-align: center; display: block; margin-bottom: 4px;">PIN Keamanan (4 digit)</label>
                    <div class="pin-inputs-wrapper" style="display: flex; gap: 12px; justify-content: center; margin: 6px 0 10px;">
                        <input type="text" maxlength="1" pattern="[0-9]" inputmode="numeric" class="pin-box" required autocomplete="off">
                        <input type="text" maxlength="1" pattern="[0-9]" inputmode="numeric" class="pin-box" required autocomplete="off">
                        <input type="text" maxlength="1" pattern="[0-9]" inputmode="numeric" class="pin-box" required autocomplete="off">
                        <input type="text" maxlength="1" pattern="[0-9]" inputmode="numeric" class="pin-box" required autocomplete="off">
                    </div>
                    <input type="hidden" name="pin" id="compiled_pin">
                </div>

                {{-- Row --}}
                <div class="auth-row" style="margin-top: 5px;">
                    <a href="{{ route('player.login') }}" class="auth-back">← Batal</a>
                </div>

                {{-- Button --}}
                <button type="submit" class="auth-btn">
                    <span class="auth-btn__shine" aria-hidden="true"></span>
                    <span class="auth-btn__text">Lengkapi Pendaftaran</span>
                    <span class="auth-btn__icon" aria-hidden="true">
                        <svg viewBox="0 0 24 24" fill="none">
                            <path d="M10 17l5-5-5-5" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            <path d="M4 12h10" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                        </svg>
                    </span>
                </button>
            </form>
        </div>
    </div>
</div>

<style>
/* Same variables and core auth classes for styling */
html {
  --bg-body: #0b1220;
  --txt-body: rgba(226,232,240,.96);
  --muted: rgba(148,163,184,.92);
  --line: rgba(148,163,184,.20);
  --card: rgba(15,23,42,.74);
  --brand: #ff6b00;
  --brand2: #ff8c42;
  --brand3: #ffaa6b;
}

html[data-theme="light"] {
  --bg-body: #f8fafc;
  --txt-body: rgba(15,23,42,.95);
  --muted: rgba(71,85,105,.90);
  --line: rgba(15,23,42,.14);
  --card: rgba(255,255,255,.78);
  --brand: #ff6b00;
  --brand2: #ff8c42;
  --brand3: #ffaa6b;
  
  --danger-bg: rgba(239,68,68,.10);
  --danger-border: rgba(185,28,28,.28);
  --danger-text: rgba(127,29,29,.96);
  --danger-dot: #dc2626;
}

.auth-page {
  min-height: 100vh;
  position: relative;
  overflow: hidden;
  background: var(--bg-body);
  color: var(--txt-body);
}

.auth-bg {
  position: absolute;
  inset: 0;
  z-index: 0;
  pointer-events: none;
}

.auth-glow {
  position: absolute;
  width: 520px;
  height: 520px;
  border-radius: 999px;
  filter: blur(60px);
  opacity: .28;
}

.auth-glow--a {
  top: -160px;
  left: -160px;
  background: radial-gradient(circle, rgba(255,107,0,.75), transparent 60%);
}

.auth-glow--b {
  bottom: -180px;
  right: -160px;
  background: radial-gradient(circle, rgba(255,140,66,.70), transparent 60%);
}

.auth-grid {
  position: absolute;
  inset: 0;
  opacity: .10;
  background-image:
    linear-gradient(to right, rgba(255,107,0,.18) 1px, transparent 1px),
    linear-gradient(to bottom, rgba(255,107,0,.14) 1px, transparent 1px);
  background-size: 44px 44px;
}

.auth-center {
  min-height: 100vh;
  display: flex;
  align-items: center;
  justify-content: center;
  padding: 22px;
  position: relative;
  z-index: 1;
}

.auth-card {
  width: min(390px, 100%);
  border-radius: 20px;
  position: relative;
  overflow: hidden;
  background: linear-gradient(180deg, color-mix(in oklab, var(--card) 88%, transparent), color-mix(in oklab, var(--card) 95%, transparent));
  border: 1px solid var(--line);
  box-shadow: 0 26px 90px rgba(0,0,0,.26);
  backdrop-filter: blur(14px);
}

.auth-head {
  padding: 16px 20px 8px;
  text-align: center;
}

.auth-badge {
  width: 52px;
  height: 52px;
  margin: 0 auto 10px;
  border-radius: 16px;
  display: grid;
  place-items: center;
}

.auth-title {
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

@keyframes authTitleGlow { to { background-position: 200% center; } }

.auth-subtitle {
  margin: 8px 0 0;
  font-size: .82rem;
  color: color-mix(in oklab, var(--muted) 92%, transparent);
}

.auth-error {
  padding: 10px 12px;
  border-radius: 14px;
  border: 1px solid rgba(239,68,68,.45);
  background: rgba(239,68,68,.12);
  display: flex;
  gap: 10px;
  align-items: flex-start;
  color: color-mix(in oklab, #fecaca 88%, white);
  font-size: .86rem;
}

.auth-error__dot {
  width: 10px;
  height: 10px;
  border-radius: 999px;
  margin-top: 4px;
  background: #ef4444;
}

.auth-form {
  padding: 8px 20px 18px;
  display: grid;
  gap: 10px;
}

.auth-field { display: grid; gap: 8px; }
.auth-label {
  font-size: .86rem;
  font-weight: 850;
  color: color-mix(in oklab, var(--txt-body) 88%, transparent);
}

.auth-inputWrap {
  position: relative;
  border-radius: 16px;
  border: 1px solid rgba(255,107,0,.22);
  background: color-mix(in oklab, var(--bg-body) 86%, transparent);
  overflow: hidden;
  transition: border-color .2s ease, box-shadow .2s ease;
}

.auth-inputWrap:focus-within {
  border-color: rgba(255,107,0,.58);
  box-shadow: 0 0 0 4px rgba(255,107,0,.16);
}

.auth-ico {
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
.auth-ico svg { width: 18px; height: 18px; }

.auth-input {
  width: 100%;
  border: 0;
  outline: none;
  background: transparent;
  color: var(--txt-body);
  padding: 12px 12px 12px 54px;
  font-size: .92rem;
}

.auth-row {
  display: flex;
  align-items: center;
  justify-content: space-between;
  gap: 14px;
}

.auth-back {
  font-size: .82rem;
  font-weight: 950;
  color: var(--brand2);
  text-decoration: none;
}

.auth-btn {
  margin-top: 6px;
  width: 100%;
  border: 0;
  cursor: pointer;
  border-radius: 999px;
  padding: 11px 14px;
  display: flex;
  align-items: center;
  justify-content: center;
  gap: 10px;
  background: linear-gradient(135deg, var(--brand), var(--brand2));
  color: #0b1220;
  font-weight: 950;
  box-shadow: 0 18px 50px rgba(0,0,0,.22), 0 0 26px rgba(255,107,0,.16);
  position: relative;
  overflow: hidden;
  transition: transform .18s ease, box-shadow .18s ease;
}

.auth-btn:hover {
  transform: translateY(-2px);
  box-shadow: 0 24px 70px rgba(0,0,0,.26), 0 0 32px rgba(255,107,0,.20);
}

.auth-btn__shine {
  position: absolute;
  inset: -2px;
  background: radial-gradient(220px 80px at 18% 0%, rgba(255,255,255,.40), transparent 60%);
  opacity: 0;
  transition: opacity .2s ease;
}
.auth-btn:hover .auth-btn__shine { opacity: 1; }

.auth-btn__text { font-size: .94rem; }
.auth-btn__icon {
  width: 22px;
  height: 22px;
  display: grid;
  place-items: center;
  border-radius: 999px;
  background: rgba(255,255,255,.30);
  border: 1px solid rgba(0,0,0,.08);
}
.auth-btn__icon svg { width: 18px; height: 18px; color: rgba(2,6,23,.90); }

/* Light Mode specific details */
html[data-theme="light"] .auth-subtitle { color: rgba(30, 41, 59, .82); }
html[data-theme="light"] .auth-label { color: rgba(15, 23, 42, .92); }
html[data-theme="light"] .auth-inputWrap { background: rgba(255,255,255,.92); border-color: rgba(255,107,0,.25); }
html[data-theme="light"] .auth-input { color: rgba(15,23,42,.96); }
html[data-theme="light"] .auth-ico { color: rgba(180,65,14,.95); background: rgba(255,107,0,.10); border-color: rgba(255,107,0,.22); }
html[data-theme="light"] .auth-back { color: rgba(180,65,14,.95); }
html[data-theme="light"] .auth-error { background: var(--danger-bg); border-color: var(--danger-border); color: var(--danger-text); }
html[data-theme="light"] .auth-error__dot { background: var(--danger-dot); }

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
    // Focus first box
    boxes[0].focus();

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

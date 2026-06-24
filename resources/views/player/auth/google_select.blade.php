{{-- resources/views/player/auth/google_select.blade.php --}}
@extends('layouts.auth')

@section('title', 'Pilih Akun - Google Accounts')

@section('content')
<div class="auth-page">
    {{-- BACKGROUND GLOW --}}
    <div class="auth-bg" aria-hidden="true">
        <div class="auth-glow auth-glow--a"></div>
        <div class="auth-glow auth-glow--b"></div>
        <div class="auth-grid"></div>
    </div>

    <div class="auth-center">
        <div class="auth-card" style="max-width: 400px; padding: 24px;">
            <div class="auth-head" style="padding-bottom: 20px;">
                {{-- Google Color Icon --}}
                <img src="https://www.svgrepo.com/show/475656/google-color.svg" alt="Google" style="width: 44px; height: 44px; margin: 0 auto 12px; display: block;">
                <h1 class="auth-title" style="font-size: 1.4rem; background: none; -webkit-text-fill-color: var(--txt-body); color: var(--txt-body);">
                    Pilih akun
                </h1>
                <p class="auth-subtitle" style="font-size: 0.85rem;">untuk melanjutkan ke Lentara Nusantara</p>
            </div>

            <div class="google-accounts-list" style="display: grid; gap: 10px; padding: 10px 0 20px;">
                {{-- Account 1 --}}
                <a href="{{ route('player.login.google', ['account' => 'budi']) }}" class="google-account-item">
                    <div class="google-avatar" style="background: #ea4335;">B</div>
                    <div class="google-details">
                        <div class="google-name">Budi Santoso</div>
                        <div class="google-email">budi.santoso@gmail.com</div>
                    </div>
                </a>

                {{-- Account 2 --}}
                <a href="{{ route('player.login.google', ['account' => 'siti']) }}" class="google-account-item">
                    <div class="google-avatar" style="background: #4285f4;">S</div>
                    <div class="google-details">
                        <div class="google-name">Siti Rahma</div>
                        <div class="google-email">siti.rahma@gmail.com</div>
                    </div>
                </a>
            </div>

            <div style="border-top: 1px solid var(--line); padding-top: 15px; text-align: center;">
                <a href="{{ route('player.login') }}" class="auth-back" style="font-size: 0.8rem;">Batal</a>
            </div>
        </div>
    </div>
</div>

<style>
/* CSS fallback variables */
html {
  --bg-body: #0b1220;
  --txt-body: rgba(226,232,240,.96);
  --muted: rgba(148,163,184,.92);
  --line: rgba(148,163,184,.20);
  --card: rgba(15,23,42,.74);
  --brand: #ff6b00;
  --brand2: #ff8c42;
}

html[data-theme="light"] {
  --bg-body: #f8fafc;
  --txt-body: rgba(15,23,42,.95);
  --muted: rgba(71,85,105,.90);
  --line: rgba(15,23,42,.14);
  --card: rgba(255,255,255,.78);
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
  width: min(400px, 100%);
  border-radius: 24px;
  position: relative;
  overflow: hidden;
  background: linear-gradient(180deg, color-mix(in oklab, var(--card) 88%, transparent), color-mix(in oklab, var(--card) 95%, transparent));
  border: 1px solid var(--line);
  box-shadow: 0 26px 90px rgba(0,0,0,.26);
  backdrop-filter: blur(14px);
}

.google-account-item {
  display: flex;
  align-items: center;
  gap: 14px;
  padding: 12px 14px;
  border-radius: 14px;
  text-decoration: none;
  border: 1px solid transparent;
  transition: all 0.2s ease;
  background: rgba(255,255,255,0.02);
}

.google-account-item:hover {
  background: rgba(255, 107, 0, 0.08);
  border-color: rgba(255, 107, 0, 0.25);
  transform: translateY(-1px);
}

html[data-theme="light"] .google-account-item {
  background: rgba(0,0,0,0.02);
}

html[data-theme="light"] .google-account-item:hover {
  background: rgba(255, 107, 0, 0.06);
}

.google-avatar {
  width: 38px;
  height: 38px;
  border-radius: 50%;
  display: flex;
  align-items: center;
  justify-content: center;
  font-weight: 800;
  color: white;
  font-size: 1.1rem;
}

.google-details {
  flex: 1;
  min-width: 0;
}

.google-name {
  font-weight: 850;
  font-size: 0.9rem;
  color: var(--txt-body);
}

.google-email {
  font-size: 0.78rem;
  color: var(--muted);
  white-space: nowrap;
  overflow: hidden;
  text-overflow: ellipsis;
}

.auth-back {
  font-size: .82rem;
  font-weight: 950;
  color: var(--brand2);
  text-decoration: none;
  transition: filter .2s ease;
}

.auth-back:hover {
  filter: saturate(1.12);
}
</style>
@endsection

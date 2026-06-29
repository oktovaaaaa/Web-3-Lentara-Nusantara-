@extends('layouts.admin')

@section('title', 'Profil Administrator — Lentara Nusantara')
@section('page-title', 'Profil Administrator')

@section('content')
<style>
  .ap-wrap {
    max-width: 900px;
    margin: 0 auto;
    padding: 6px 0 24px;
    color: var(--txt-body);
    display: grid;
    gap: 24px;
  }

  .ap-card {
    border-radius: 20px;
    border: 1px solid rgba(148,163,184,.18);
    background: color-mix(in oklab, var(--card) 85%, transparent);
    backdrop-filter: blur(14px) saturate(140%);
    -webkit-backdrop-filter: blur(14px) saturate(140%);
    box-shadow: 0 18px 45px rgba(0,0,0,.10);
    overflow: hidden;
    padding: 24px;
  }
  html:not([data-theme="dark"]) .ap-card {
    background: #ffffff;
    border: 1px solid rgba(15,23,42,.12);
    box-shadow: 0 12px 32px rgba(15,23,42,.06);
  }

  .ap-card-head {
    display: flex;
    align-items: center;
    gap: 16px;
    margin-bottom: 24px;
    padding-bottom: 16px;
    border-bottom: 1px solid rgba(148,163,184,.14);
  }
  html:not([data-theme="dark"]) .ap-card-head {
    border-bottom: 1px solid rgba(15,23,42,.10);
  }

  .ap-icon-box {
    width: 48px;
    height: 48px;
    border-radius: 14px;
    display: grid;
    place-items: center;
    font-size: 24px;
    flex-shrink: 0;
  }
  .ap-icon-box.amber {
    background: rgba(249,115,22,.12);
    color: #f97316;
    border: 1px solid rgba(249,115,22,.25);
  }
  .ap-icon-box.rose {
    background: rgba(244,63,94,.12);
    color: #f43f5e;
    border: 1px solid rgba(244,63,94,.25);
  }

  .ap-card-title {
    margin: 0;
    font-size: 18px;
    font-weight: 950;
    color: var(--txt-body);
  }
  html:not([data-theme="dark"]) .ap-card-title {
    color: #0f172a;
  }

  .ap-card-sub {
    margin: 4px 0 0;
    font-size: 13px;
    font-weight: 700;
    color: var(--muted);
  }

  .ap-form {
    display: grid;
    gap: 18px;
  }

  .ap-field {
    display: grid;
    gap: 8px;
  }

  .ap-label {
    font-size: 12px;
    font-weight: 900;
    text-transform: uppercase;
    letter-spacing: .05em;
    color: color-mix(in oklab, var(--txt-body) 82%, transparent);
  }
  html:not([data-theme="dark"]) .ap-label {
    color: #475569;
  }

  .ap-input {
    width: 100%;
    padding: 12px 16px;
    border-radius: 14px;
    border: 1px solid rgba(148,163,184,.25);
    background: rgba(2,6,23,.30);
    color: var(--txt-body);
    font-size: 14px;
    font-weight: 800;
    outline: none;
    transition: border-color .15s ease, box-shadow .15s ease;
  }
  html:not([data-theme="dark"]) .ap-input {
    background: #f8fafc;
    border: 1px solid #cbd5e1;
    color: #0f172a;
  }
  .ap-input:focus {
    border-color: #f97316;
    box-shadow: 0 0 0 4px rgba(249,115,22,.15);
  }

  .ap-submit-wrap {
    display: flex;
    justify-content: flex-end;
    padding-top: 8px;
  }

  .ap-btn {
    padding: 12px 22px;
    border-radius: 14px;
    border: none;
    font-weight: 950;
    font-size: 14px;
    cursor: pointer;
    transition: transform .15s ease, filter .15s ease, box-shadow .15s ease;
    color: #ffffff;
    display: inline-flex;
    align-items: center;
    gap: 8px;
  }
  .ap-btn:hover {
    filter: brightness(1.08);
    transform: translateY(-2px);
  }
  .ap-btn:active {
    transform: translateY(0);
  }
  .ap-btn.amber {
    background: linear-gradient(135deg, #ea580c, #f97316);
    box-shadow: 0 10px 25px rgba(249,115,22,.30);
  }
  .ap-btn.rose {
    background: linear-gradient(135deg, #e11d48, #f43f5e);
    box-shadow: 0 10px 25px rgba(244,63,94,.30);
  }

  /* POPUP MODAL STYLES */
  .ap-modal-overlay {
    position: fixed;
    inset: 0;
    z-index: 9999;
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 20px;
    background: rgba(11, 18, 32, 0.75);
    backdrop-filter: blur(8px);
    animation: apFadeIn 0.25s ease-out forwards;
  }
  .ap-modal-content {
    background: #0f172a;
    border: 1px solid rgba(255,255,255,.15);
    border-radius: 24px;
    padding: 28px 24px;
    width: min(400px, 100%);
    text-align: center;
    box-shadow: 0 25px 50px -12px rgba(0,0,0,0.6);
    animation: apScaleIn 0.25s cubic-bezier(0.175, 0.885, 0.32, 1.275) forwards;
  }
  html:not([data-theme="dark"]) .ap-modal-content {
    background: #ffffff;
    border: 1px solid rgba(15,23,42,.12);
  }

  .ap-modal-icon {
    width: 64px;
    height: 64px;
    margin: 0 auto 16px;
    border-radius: 20px;
    display: grid;
    place-items: center;
    font-size: 32px;
  }
  .ap-modal-icon.success {
    background: rgba(34,197,94,.15);
    color: #22c55e;
    border: 1px solid rgba(34,197,94,.30);
  }
  .ap-modal-icon.error {
    background: rgba(239,68,68,.15);
    color: #ef4444;
    border: 1px solid rgba(239,68,68,.30);
  }

  .ap-modal-title {
    margin: 0 0 8px;
    font-size: 1.3rem;
    font-weight: 950;
    color: #ffffff;
  }
  html:not([data-theme="dark"]) .ap-modal-title {
    color: #0f172a;
  }

  .ap-modal-text {
    margin: 0 0 24px;
    font-size: 0.92rem;
    color: #94a3b8;
    line-height: 1.55;
    font-weight: 700;
  }
  html:not([data-theme="dark"]) .ap-modal-text {
    color: #64748b;
  }

  .ap-modal-btn {
    width: 100%;
    padding: 13px 20px;
    border-radius: 999px;
    border: 0;
    color: #ffffff;
    font-weight: 950;
    font-size: 0.92rem;
    cursor: pointer;
    transition: transform 0.15s ease, filter 0.15s ease;
  }
  .ap-modal-btn.success {
    background: linear-gradient(135deg, #16a34a, #22c55e);
    box-shadow: 0 10px 25px rgba(34,197,94,.35);
  }
  .ap-modal-btn.error {
    background: linear-gradient(135deg, #dc2626, #ef4444);
    box-shadow: 0 10px 25px rgba(239,68,68,.35);
  }
  .ap-modal-btn:hover {
    filter: brightness(1.08);
    transform: translateY(-2px);
  }

  @keyframes apFadeIn { from { opacity: 0; } to { opacity: 1; } }
  @keyframes apScaleIn { from { opacity: 0; transform: scale(0.85); } to { opacity: 1; transform: scale(1); } }
</style>

<div class="ap-wrap">

    {{-- POPUP MODAL SUCCESS PROFIL --}}
    @if(session('success'))
    <div id="ap-status-modal" class="ap-modal-overlay" role="dialog" aria-modal="true">
        <div class="ap-modal-content">
            <div class="ap-modal-icon success">
                <i class='bx bx-check-circle'></i>
            </div>
            <h3 class="ap-modal-title">Berhasil!</h3>
            <p class="ap-modal-text">{{ session('success') }}</p>
            <button type="button" class="ap-modal-btn success" onclick="closeApModal()">Selesai</button>
        </div>
    </div>
    @endif

    {{-- POPUP MODAL SUCCESS PASSWORD --}}
    @if(session('success_password'))
    <div id="ap-status-modal" class="ap-modal-overlay" role="dialog" aria-modal="true">
        <div class="ap-modal-content">
            <div class="ap-modal-icon success">
                <i class='bx bx-lock-open-alt'></i>
            </div>
            <h3 class="ap-modal-title">Password Diperbarui!</h3>
            <p class="ap-modal-text">{{ session('success_password') }}</p>
            <button type="button" class="ap-modal-btn success" onclick="closeApModal()">Selesai</button>
        </div>
    </div>
    @endif

    {{-- POPUP MODAL ERROR VALIDASI --}}
    @if($errors->any())
    <div id="ap-status-modal" class="ap-modal-overlay" role="dialog" aria-modal="true">
        <div class="ap-modal-content">
            <div class="ap-modal-icon error">
                <i class='bx bx-error-circle'></i>
            </div>
            <h3 class="ap-modal-title">Perhatian</h3>
            <p class="ap-modal-text">{{ $errors->first() }}</p>
            <button type="button" class="ap-modal-btn error" onclick="closeApModal()">Mengerti</button>
        </div>
    </div>
    @endif

    {{-- CARD 1: INFORMASI PROFIL --}}
    <div class="ap-card">
        <div class="ap-card-head">
            <div class="ap-icon-box amber">
                <i class='bx bx-user-circle'></i>
            </div>
            <div>
                <h3 class="ap-card-title">Informasi Akun Admin</h3>
                <p class="ap-card-sub">Perbarui data nama dan email administrator sistem</p>
            </div>
        </div>

        <form action="{{ route('admin.profile.update') }}" method="POST" class="ap-form">
            @csrf
            @method('PUT')

            <div class="ap-field">
                <label class="ap-label" for="name">Nama Administrator</label>
                <input type="text" id="name" name="name" value="{{ old('name', $user->name) }}" required class="ap-input">
            </div>

            <div class="ap-field">
                <label class="ap-label" for="email">Alamat Email</label>
                <input type="email" id="email" name="email" value="{{ old('email', $user->email) }}" required class="ap-input">
            </div>

            <div class="ap-submit-wrap">
                <button type="submit" class="ap-btn amber">
                    <i class='bx bx-save'></i>
                    <span>Simpan Perubahan</span>
                </button>
            </div>
        </form>
    </div>

    {{-- CARD 2: GANTI PASSWORD --}}
    <div class="ap-card">
        <div class="ap-card-head">
            <div class="ap-icon-box rose">
                <i class='bx bx-key'></i>
            </div>
            <div>
                <h3 class="ap-card-title">Ganti Password</h3>
                <p class="ap-card-sub">Pastikan menggunakan password yang kuat dan aman</p>
            </div>
        </div>

        <form action="{{ route('admin.profile.password.update') }}" method="POST" class="ap-form">
            @csrf
            @method('PUT')

            <div class="ap-field">
                <label class="ap-label" for="current_password">Password Saat Ini</label>
                <input type="password" id="current_password" name="current_password" required placeholder="••••••••" class="ap-input">
            </div>

            <div class="ap-field">
                <label class="ap-label" for="password">Password Baru</label>
                <input type="password" id="password" name="password" required placeholder="••••••••" class="ap-input">
            </div>

            <div class="ap-field">
                <label class="ap-label" for="password_confirmation">Konfirmasi Password Baru</label>
                <input type="password" id="password_confirmation" name="password_confirmation" required placeholder="••••••••" class="ap-input">
            </div>

            <div class="ap-submit-wrap">
                <button type="submit" class="ap-btn rose">
                    <i class='bx bx-check-shield'></i>
                    <span>Ubah Password</span>
                </button>
            </div>
        </form>
    </div>

</div>

<script>
function closeApModal() {
    const modal = document.getElementById('ap-status-modal');
    if (modal) {
        modal.style.opacity = '0';
        modal.style.transition = 'opacity 0.2s ease';
        setTimeout(() => modal.remove(), 200);
    }
}
</script>
@endsection

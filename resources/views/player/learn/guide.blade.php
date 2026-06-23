{{-- resources/views/player/learn/guide.blade.php (REPLACE FULL) --}}
<link rel="icon" type="image/png" href="{{ asset('images/icon/icon_lentara.png') }}">
<link rel="shortcut icon" type="image/png" href="{{ asset('images/icon/icon_lentara.png') }}">
@php
    $player = $player ?? (object)[
        'display_name' => 'Player',
        'nickname' => null,
        'avatar_key' => 1,
        'xp_total' => 0,
        'coins' => 0,
        'hearts' => 0,
        'hearts_max' => 5,
    ];

    $tierLabel = $tierLabel ?? '—';

    $nickname = (string)($player->nickname ?? $player->display_name ?? 'Player');
    $avatarKey = (int) ($player->avatar_key ?? 1);
    if ($avatarKey < 1 || $avatarKey > 5) $avatarKey = 1;
    $avatarUrl = asset('images/avatars/avatar-'.$avatarKey.'.png');

    $safeRoute = function($name, $params = []) {
        if (\Illuminate\Support\Facades\Route::has($name)) return route($name, $params);
        return '#';
    };

    // ✅ samakan icon key dengan partial sidebar (book/help/gear/trophy)
    $menu = [
        ['label'=>'Belajar','route'=>'game.learn','active'=>false,'icon'=>'book'],
        ['label'=>'Panduan','route'=>'game.guide','active'=>true,'icon'=>'help'],
        ['label'=>'Papan Peringkat','route'=>'game.leaderboard','active'=>false,'icon'=>'trophy'],
        ['label'=>'Profil','route'=>'player.profile','active'=>false,'icon'=>'gear'],
    ];
@endphp

<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Panduan — Lentara Nusantara</title>
    <link rel="icon" type="image/png" href="{{ asset('images/icon/icon_lentara.png') }}">
    <link rel="shortcut icon" type="image/png" href="{{ asset('images/icon/icon_lentara.png') }}">

    {{-- ✅ THEME CONNECT (SAMA DENGAN INDEX): localStorage piforrr-theme --}}
    <script>
        (function () {
            const saved = localStorage.getItem('piforrr-theme') || 'dark';
            document.documentElement.setAttribute('data-theme', saved);
        })();
    </script>

    <style>
        /* ====== THEME GLOBAL (LIGHT & DARK) ====== */
        :root{
          --bg-body: #fdfaf5;
          --txt-body: #0f172a;
          --card: #ffffff;
          --line: #e9e1d6;
          --muted: #616161;
          --brand: #b7410e;
          --brand-2: #f4c842;
          --shadow: 0 20px 50px rgba(0,0,0,.12);

          --danger:#ef4444;
          --ok:#22c55e;

          --nav-w: 280px;
          --nav-w-collapsed: 72px;
          --right-w: 320px;

          --r-xl: 22px;
          --r-lg: 18px;
          --r-md: 14px;
        }

        html[data-theme="dark"]{
          --bg-body: #020617;
          --txt-body: #e5e7eb;
          --card: #020617;
          --line: #1f2937;
          --muted: #9ca3af;
          --brand: #f97316;
          --brand-2: #fde68a;
          --shadow: 0 25px 60px rgba(0,0,0,.65);
        }

        *{ box-sizing:border-box; }
        html,body{ height:100%; }
        body{
            margin:0;
            font-family: ui-sans-serif, system-ui, -apple-system, Segoe UI, Roboto, Arial;
            background: var(--bg-body);
            color: var(--txt-body);
            overflow-x:hidden;
        }

        /* background glow halus */
        .bg{
            position:fixed; inset:0; pointer-events:none; z-index:0;
            background:
                radial-gradient(circle at 18% 12%, rgba(249,115,22,.14), transparent 42%),
                radial-gradient(circle at 78% 18%, rgba(249,115,22,.10), transparent 50%),
                radial-gradient(circle at 15% 85%, rgba(59,130,246,.08), transparent 45%),
                radial-gradient(circle at 85% 85%, rgba(34,197,94,.06), transparent 45%);
            opacity:.95;
        }
        html[data-theme="dark"] .bg{
            background:
                radial-gradient(circle at 18% 12%, rgba(249,115,22,.16), transparent 42%),
                radial-gradient(circle at 78% 18%, rgba(249,115,22,.12), transparent 52%),
                radial-gradient(circle at 15% 85%, rgba(59,130,246,.10), transparent 45%),
                radial-gradient(circle at 85% 85%, rgba(34,197,94,.08), transparent 45%);
        }

        /* ✅ override layout untuk guide: 3 kolom (sidebar + main + right) */
        .shell{
            position: relative;
            z-index: 1;
            display: grid;
            grid-template-columns: var(--nav-w) 1fr var(--right-w) !important;
            gap: 14px;
            padding: 14px;
            align-items: start;
        }
        body.nav-collapsed{ --nav-w: var(--nav-w-collapsed); }

        .card{
            background: color-mix(in oklab, var(--card) 94%, transparent);
            border: 1px solid var(--line);
            border-radius: var(--r-xl);
            box-shadow: var(--shadow);
            overflow:hidden;
        }

        /* ===== Main Guide ===== */
        .main{ min-width:0; position:relative; z-index:1; }

        /* ===== Right panel desktop ===== */
        .right{
            position: sticky;
            top: 14px;
            height: calc(100vh - 28px);
            display:grid;
            gap: 12px;
            align-content:start;
        }

        .right .card {
            background: color-mix(in oklab, var(--card) 95%, transparent);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border: 1px solid var(--line);
            position: relative;
            overflow: hidden;
            transition: all 0.3s ease;
        }
        .right .card::before {
            content: "";
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 4px;
            background: linear-gradient(90deg, var(--brand), var(--brand-2));
        }

        .panel-head{
            padding: 14px;
            border-bottom: 1px solid var(--line);
            display:flex;
            align-items:center;
            justify-content:space-between;
        }
        .panel-title{ margin:0; font-size: 16px; font-weight: 950; }

        .metrics{
            padding: 14px;
            display:flex;
            gap: 10px;
            flex-wrap:wrap;
        }

        .pill{
            display:inline-flex;
            align-items:center;
            gap: 8px;
            padding: 8px 12px;
            border-radius: 14px;
            font-weight: 950;
            font-size: 13px;
            transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
            cursor: default;
        }
        .pill svg{ width: 18px; height: 18px; }
        .pill:hover {
            transform: translateY(-2px);
        }
        .pill.xp {
            color: #3b82f6;
            background: rgba(59, 130, 246, 0.08);
            border: 1px solid rgba(59, 130, 246, 0.2);
            box-shadow: 0 4px 10px rgba(59, 130, 246, 0.06);
        }
        .pill.xp:hover {
            background: rgba(59, 130, 246, 0.12);
            border-color: rgba(59, 130, 246, 0.35);
            box-shadow: 0 4px 12px rgba(59, 130, 246, 0.15);
        }
        .pill.heart {
            color: var(--danger);
            background: rgba(239, 68, 68, 0.08);
            border: 1px solid rgba(239, 68, 68, 0.2);
            box-shadow: 0 4px 10px rgba(239, 68, 68, 0.06);
        }
        .pill.heart:hover {
            background: rgba(239, 68, 68, 0.12);
            border-color: rgba(239, 68, 68, 0.35);
            box-shadow: 0 4px 12px rgba(239, 68, 68, 0.15);
        }
        .pill.money {
            color: #eab308;
            background: rgba(234, 179, 8, 0.08);
            border: 1px solid rgba(234, 179, 8, 0.2);
            box-shadow: 0 4px 10px rgba(234, 179, 8, 0.06);
        }
        .pill.money:hover {
            background: rgba(234, 179, 8, 0.12);
            border-color: rgba(234, 179, 8, 0.35);
            box-shadow: 0 4px 12px rgba(234, 179, 8, 0.15);
        }

        .right-bottom{
            padding: 14px;
            border-top: 1px solid var(--line);
            display:grid;
            gap: 10px;
        }

        .profile-card {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 12px;
            background: color-mix(in oklab, var(--card) 95%, transparent);
            border: 1px solid var(--line);
            border-radius: 16px;
            margin-bottom: 8px;
            transition: all 0.2s ease;
        }
        .profile-card:hover {
            border-color: var(--brand);
            box-shadow: 0 4px 12px color-mix(in oklab, var(--brand) 8%, transparent);
        }
        .profile-avatar {
            width: 52px;
            height: 52px;
            border-radius: 14px;
            overflow: hidden;
            border: 2px solid var(--brand);
            background: var(--bg-body);
            box-shadow: 0 0 10px color-mix(in oklab, var(--brand) 25%, transparent);
            flex-shrink: 0;
        }
        .profile-avatar img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
        .profile-info {
            display: flex;
            flex-direction: column;
            gap: 2px;
            min-width: 0;
        }
        .profile-name {
            font-weight: 950;
            font-size: 15px;
            color: var(--txt-body);
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }
        .profile-tier {
            font-weight: 900;
            font-size: 11px;
            color: var(--muted);
        }
        .profile-tier span {
            color: var(--brand);
            font-weight: 950;
        }

        .btn {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 100%;
            height: 44px;
            border-radius: 14px;
            font-weight: 950;
            font-size: 14px;
            text-decoration: none;
            cursor: pointer;
            transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
            background: var(--brand);
            color: #ffffff;
            border: 1px solid var(--brand);
            box-shadow: 0 4px 12px color-mix(in oklab, var(--brand) 20%, transparent);
        }
        .btn:hover {
            transform: translateY(-2px);
            background: color-mix(in oklab, var(--brand) 85%, #fff);
            box-shadow: 0 6px 16px color-mix(in oklab, var(--brand) 30%, transparent);
        }

        .btn-logout {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 100%;
            height: 44px;
            border-radius: 14px;
            font-weight: 950;
            font-size: 14px;
            cursor: pointer;
            transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
            background: transparent;
            color: var(--txt-body);
            border: 1px solid var(--line);
        }
        .btn-logout:hover {
            transform: translateY(-2px);
            color: var(--danger);
            border-color: var(--danger);
            background: rgba(239, 68, 68, 0.06);
            box-shadow: 0 4px 12px rgba(239, 68, 68, 0.08);
        }

        .topbar{
            border-radius: var(--r-xl);
            border: 1px solid var(--line);
            background: color-mix(in oklab, var(--card) 92%, transparent);
            box-shadow: var(--shadow);
            padding: 14px;
            display:flex;
            align-items:center;
            justify-content:space-between;
            gap: 12px;
            margin-bottom: 14px;
        }

        .top-left{
            display:flex;
            align-items:center;
            gap: 12px;
            min-width:0;
        }

        .back{
            width: 42px; height: 42px;
            border-radius: 16px;
            border: 1px solid var(--line);
            background: color-mix(in oklab, var(--card) 92%, transparent);
            color: var(--txt-body);
            display:grid;
            place-items:center;
            text-decoration:none;
            flex:0 0 auto;
        }
        .back svg{ width:18px;height:18px; }

        .title{
            display:grid;
            gap: 2px;
            min-width:0;
        }
        .title .small{
            font-weight: 950;
            font-size: 12px;
            color: var(--muted);
            white-space:nowrap;
            overflow:hidden;
            text-overflow:ellipsis;
        }
        .title .big{
            font-weight: 950;
            font-size: 18px;
            white-space:nowrap;
            overflow:hidden;
            text-overflow:ellipsis;
        }

        .content-card{
            border-radius: var(--r-xl);
            border: 1px solid var(--line);
            background: color-mix(in oklab, var(--card) 92%, transparent);
            box-shadow: var(--shadow);
            padding: 16px;
        }

        .hint{
            font-weight: 900;
            color: var(--muted);
            line-height: 1.5;
            margin-top: 6px;
        }

        /* Q&A dropdown */
        .qa{ display:grid; gap:10px; margin-top:12px; }
        .qa-item{
            border-radius: 18px;
            border: 1px solid var(--line);
            background: color-mix(in oklab, var(--card) 92%, transparent);
            overflow:hidden;
        }
        .qa-q{
            width:100%;
            display:flex;
            align-items:center;
            justify-content:space-between;
            gap:12px;
            padding:12px 14px;
            cursor:pointer;
            background: transparent;
            border:0;
            color: var(--txt-body);
            font-weight:950;
            text-align:left;
        }
        .qa-q .left{
            display:flex; align-items:center; gap:10px;
            min-width:0;
        }
        .qa-q .left span:last-child{
            white-space:nowrap;
            overflow:hidden;
            text-overflow:ellipsis;
        }
        .qa-ico{
            width:34px;height:34px;border-radius:14px;
            display:grid;place-items:center;
            background: rgba(249,115,22,.12);
            border:1px solid color-mix(in oklab, var(--brand) 30%, var(--line));
            color: color-mix(in oklab, var(--brand) 88%, #fff);
            flex:0 0 auto;
        }
        .qa-ico svg{width:18px;height:18px;}
        .chev{ transition: transform .18s ease; opacity:.9; font-weight:950; }
        .qa-item.open .chev{ transform: rotate(180deg); }
        .qa-a{
            padding: 0 14px 14px;
            color: var(--muted);
            font-weight:900;
            line-height:1.6;
            display:none;
        }
        .qa-item.open .qa-a{ display:block; }

        /* mobile spacing */
        @media (max-width: 1024px){
            .shell{ grid-template-columns: 1fr !important; padding: 0 14px 14px; }
            .main{ padding-bottom: 14px; }
            .right{ display:none !important; }
        }
    </style>

    {{-- ✅ SIDEBAR CSS (INCLUDE) --}}
    @include('player.partials.learn-sidebar', ['mode' => 'css'])
</head>

<body>
<div class="bg" aria-hidden="true"></div>

{{-- ✅ MOBILE BAR + MOBILE DRAWER (INCLUDE) --}}
@include('player.partials.learn-sidebar', ['mode' => 'mobile'])

<div class="shell">
    {{-- ✅ DESKTOP SIDEBAR (INCLUDE) --}}
    @include('player.partials.learn-sidebar', ['mode' => 'desktop'])

    {{-- MAIN --}}
    <main class="main">
        <section class="topbar">
            <div class="top-left">
                <a class="back" href="{{ $safeRoute('game.learn') }}" aria-label="Kembali">
                    <svg viewBox="0 0 24 24" fill="none">
                        <path d="M15 18l-6-6 6-6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </a>
                <div class="title">
                    <div class="small">Panduan</div>
                    <div class="big">Lentara Nusantara</div>
                </div>
            </div>

            {{-- sengaja kosong: indikator XP/Hati/Uang sudah ada di bar atas (mobile) & panel lain --}}
            <div style="width:1px;height:1px;opacity:0;" aria-hidden="true"></div>
        </section>

        <section class="content-card">
            <div style="font-weight:950;font-size:18px;">FAQ Panduan</div>
            <div class="hint">
                Klik pertanyaan untuk membuka jawaban.
            </div>

            <div class="qa" id="qaRoot">

                <div class="qa-item">
                    <button class="qa-q" type="button">
                        <span class="left">
                            <span class="qa-ico" aria-hidden="true">
                                <svg viewBox="0 0 24 24" fill="none">
                                    <path d="M13 2s2 3 2 6-2 4-2 4 4-1 4-6 2-4 2-4-1 7-4 10-1 8-1 8-6-3-6-8 4-10 5-10Z" stroke="currentColor" stroke-width="2" stroke-linejoin="round"/>
                                </svg>
                            </span>
                            <span>Cara main & aturan XP itu gimana?</span>
                        </span>
                        <span class="chev">▾</span>
                    </button>
                    <div class="qa-a">
                        • Setiap soal benar memberi <b>2 XP</b>.<br>
                        • 1 level berisi <b>5 soal</b>.<br>
                        • Total maksimal XP per level: <b>10 XP</b> (5 benar × 2 XP).
                    </div>
                </div>

                <div class="qa-item">
                    <button class="qa-q" type="button">
                        <span class="left">
                            <span class="qa-ico" aria-hidden="true">
                                <svg viewBox="0 0 24 24" fill="none">
                                    <path d="M12 21s-7-4.6-9.2-9.1C1.4 8.9 3.4 6 6.6 6c1.8 0 3.1 1 3.9 2 0.8-1 2.1-2 3.9-2 3.2 0 5.2 2.9 3.8 5.9C19 16.4 12 21 12 21Z" stroke="currentColor" stroke-width="2" stroke-linejoin="round"/>
                                </svg>
                            </span>
                            <span>Aturan hearts berkurang & regen bagaimana?</span>
                        </span>
                        <span class="chev">▾</span>
                    </button>
                    <div class="qa-a">
                        • Jika jawaban salah, <b>hearts berkurang 1</b>.<br>
                        • Hearts <b>regen otomatis</b> dari server tiap <b>5 menit = 1 hati</b>.<br>
                        • Jika hearts habis (0), kamu <b>tidak bisa lanjut</b> sampai regen atau isi ulang.
                    </div>
                </div>

                <div class="qa-item">
                    <button class="qa-q" type="button">
                        <span class="left">
                            <span class="qa-ico" aria-hidden="true">
                                <svg viewBox="0 0 24 24" fill="none">
                                    <path d="M9 12l2 2 4-5" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                    <path d="M12 22c5.523 0 10-4.477 10-10S17.523 2 12 2 2 6.477 2 12s4.477 10 10 10Z" stroke="currentColor" stroke-width="2"/>
                                </svg>
                            </span>
                            <span>Syarat lulus level itu apa?</span>
                        </span>
                        <span class="chev">▾</span>
                    </button>
                    <div class="qa-a">
                        • Dari 5 soal, kamu harus benar minimal <b>3</b> untuk <b>lulus</b>.<br>
                        • Kalau gagal (benar &lt; 3), progress level <b>tidak disimpan</b> (sesuai flow kamu).
                    </div>
                </div>

                <div class="qa-item">
                    <button class="qa-q" type="button">
                        <span class="left">
                            <span class="qa-ico" aria-hidden="true">
                                <svg viewBox="0 0 24 24" fill="none">
                                    <path d="M8 21h8" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                                    <path d="M12 17a5 5 0 0 0 5-5V4H7v8a5 5 0 0 0 5 5Z" stroke="currentColor" stroke-width="2" stroke-linejoin="round"/>
                                    <path d="M17 6h3a2 2 0 0 1-2 3h-1" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                                    <path d="M7 6H4a2 2 0 0 0 2 3h1" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                                </svg>
                            </span>
                            <span>Reward selesai pulau itu dapat apa?</span>
                        </span>
                        <span class="chev">▾</span>
                    </button>
                    <div class="qa-a">
                        Jika semua level dalam 1 pulau selesai, pulau ditandai selesai dan kamu dapat reward <b>+20 coins</b>. Lalu pulau berikutnya terbuka.
                    </div>
                </div>

                <div class="qa-item">
                    <button class="qa-q" type="button">
                        <span class="left">
                            <span class="qa-ico" aria-hidden="true">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <circle cx="12" cy="12" r="8"/>
                                    <path d="M12 8v8M9 12h6"/>
                                </svg>
                            </span>
                            <span>Apakah hearts bisa diisi ulang dengan koin?</span>
                        </span>
                        <span class="chev">▾</span>
                    </button>
                    <div class="qa-a">
                        Bisa. Isi ulang hearts menjadi penuh dengan biaya <b>10 koin</b>.
                        Jika koin tidak cukup, kamu harus menunggu regen hearts.
                    </div>
                </div>

                <!-- ─── Game Storyline FAQ ──────────────────────────────── -->
                <div class="qa-item">
                    <button class="qa-q" type="button">
                        <span class="left">
                            <span class="qa-ico" aria-hidden="true">
                                <svg viewBox="0 0 24 24" fill="none">
                                    <path d="M4 6h16M4 10h12M4 14h8" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                                </svg>
                            </span>
                            <span>Apa itu Game Storyline & cara mainnya?</span>
                        </span>
                        <span class="chev">▾</span>
                    </button>
                    <div class="qa-a">
                        🎭 <b>Game Storyline</b> adalah mode cerita bergaya visual novel.<br><br>
                        • Layar menampilkan <b>dialog antar karakter</b> dengan ilustrasi dan latar belakang.<br>
                        • <b>Klik layar</b> atau tekan <b>Space/Enter</b> untuk lanjut ke dialog berikutnya.<br>
                        • Di beberapa titik cerita muncul <b>pilihan jawaban</b> — pilih yang benar untuk melanjutkan.<br>
                        • Jawaban <b>salah</b> akan mengurangi ❤️ satu hati dan kamu harus mencoba lagi.<br>
                        • Cerita selesai ketika semua dialog dan pilihan telah dijawab dengan benar.<br><br>
                        💡 <b>Tips:</b> Baca dialog dengan seksama karena jawaban pilihan selalu ada di teks cerita!
                    </div>
                </div>

                <!-- ─── Game Soal (Kuis) FAQ ──────────────────────────────── -->
                <div class="qa-item">
                    <button class="qa-q" type="button">
                        <span class="left">
                            <span class="qa-ico" aria-hidden="true">
                                <svg viewBox="0 0 24 24" fill="none">
                                    <path d="M12 22c5.523 0 10-4.477 10-10S17.523 2 12 2 2 6.477 2 12s4.477 10 10 10Z" stroke="currentColor" stroke-width="2"/>
                                    <path d="M9.09 9a3 3 0 0 1 5.83 1c0 2-3 3-3 3" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                                    <circle cx="12" cy="17" r="1" fill="currentColor"/>
                                </svg>
                            </span>
                            <span>Apa itu Game Soal (Kuis) & cara mainnya?</span>
                        </span>
                        <span class="chev">▾</span>
                    </button>
                    <div class="qa-a">
                        📝 <b>Game Soal</b> adalah mode kuis pilihan ganda tentang budaya Nusantara.<br><br>
                        • Setiap level berisi <b>5 soal</b> dengan 3-4 pilihan jawaban.<br>
                        • Pilih jawaban dengan <b>mengklik tombol pilihan</b>.<br>
                        • Jawaban <b>benar</b> → <b>+2 XP</b> dan lanjut ke soal berikutnya.<br>
                        • Jawaban <b>salah</b> → ❤️ berkurang 1, soal bisa dicoba ulang.<br>
                        • Selesaikan semua 5 soal untuk menyelesaikan level.<br>
                        • Skor maksimal: <b>10 XP</b> jika semua 5 soal dijawab benar.<br><br>
                        💡 <b>Tips:</b> Perhatikan kata kunci di soal — jawabannya sering tersembunyi di kalimat pertanyaan!
                    </div>
                </div>

                <!-- ─── Game 3D FAQ ──────────────────────────────── -->
                <div class="qa-item">
                    <button class="qa-q" type="button">
                        <span class="left">
                            <span class="qa-ico" aria-hidden="true">
                                <svg viewBox="0 0 24 24" fill="none">
                                    <path d="M12 2L2 7l10 5 10-5-10-5Z" stroke="currentColor" stroke-width="2" stroke-linejoin="round"/>
                                    <path d="M2 17l10 5 10-5" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                    <path d="M2 12l10 5 10-5" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                </svg>
                            </span>
                            <span>Apa itu Game Eksplorasi 3D & cara mainnya?</span>
                        </span>
                        <span class="chev">▾</span>
                    </button>
                    <div class="qa-a">
                        🗺️ <b>Game Eksplorasi 3D</b> adalah mode petualangan interaktif di desa budaya Aceh.<br><br>
                        <b>Cara Gerak:</b><br>
                        • <b>W / ↑</b> = Maju &nbsp; <b>S / ↓</b> = Mundur &nbsp; <b>A / ←</b> = Kiri &nbsp; <b>D / →</b> = Kanan<br>
                        • <b>Space</b> = Lompat<br>
                        • <b>Klik + Drag</b> mouse = Putar kamera<br>
                        • Di mobile: gunakan <b>joystick</b> di layar kiri bawah<br><br>
                        <b>Cara Bermain:</b><br>
                        • Cerita dimulai dengan <b>intro dialog</b> — baca dan klik Lanjut.<br>
                        • Jelajahi desa dan cari <b>4 barang budaya Aceh</b> yang tersebar di warung dan balai.<br>
                        • Dekati warung/balai lalu tekan <b>E</b> atau klik prompt yang muncul untuk memeriksa barang.<br>
                        • Pilih barang yang <b>sesuai dengan petunjuk</b> di panel kiri — jangan tertipu barang decoy!<br>
                        • Jawaban <b>salah</b> (barang bukan budaya Aceh) → ❤️ berkurang 1.<br>
                        • Setelah 4 barang terkumpul, temui <b>Laksamana Malahayati</b> di dermaga.<br>
                        • Jawab pertanyaan finalnya untuk menyelesaikan level.<br>
                        • Setelah level selesai, ada <b>outro cerita</b> — kapal berlayar membawa barang budaya ke pulau berikutnya!<br><br>
                        ⏱️ <b>Perhatikan timer!</b> Jika waktu habis, hati berkurang dan level diulang.<br>
                        🔇 <b>Tombol 🔊</b> di kanan bawah untuk menyalakan/mematikan musik pengiring.
                    </div>
                </div>

            </div>


        </section>
    </main>

    {{-- Right panel desktop --}}
    <aside class="right" aria-label="Panel Status Desktop">
        <section class="card">
            <div class="panel-head">
                <h3 class="panel-title">Status</h3>
            </div>

            <div class="metrics">
                <div class="pill xp" title="XP Total">
                    <svg viewBox="0 0 24 24" fill="none">
                        <path d="M13 2s2 3 2 6-2 4-2 4 4-1 4-6 2-4 2-4-1 7-4 10-1 8-1 8-6-3-6-8 4-10 5-10Z" stroke="currentColor" stroke-width="2" stroke-linejoin="round"/>
                    </svg>
                    <span>{{ (int)($player->xp_total ?? 0) }}</span>
                </div>

                <div class="pill heart" title="Hati">
                    <svg viewBox="0 0 24 24" fill="none">
                        <path d="M12 21s-7-4.6-9.2-9.1C1.4 8.9 3.4 6 6.6 6c1.8 0 3.1 1 3.9 2 0.8-1 2.1-2 3.9-2 3.2 0 5.2 2.9 3.8 5.9C19 16.4 12 21 12 21Z" stroke="currentColor" stroke-width="2" stroke-linejoin="round"/>
                    </svg>
                    <span id="heartsNowDesktop">{{ (int)($player->hearts ?? 0) }}</span>/<span>{{ (int)($player->hearts_max ?? 5) }}</span>
                </div>

                <div class="pill money" title="Koin">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <circle cx="12" cy="12" r="8"/>
                        <path d="M12 8v8M9 12h6"/>
                    </svg>
                    <span>{{ number_format((int)($player->coins ?? 0), 0, ',', '.') }}</span>
                </div>
            </div>

            <div class="right-bottom">
                <div class="profile-card">
                    <div class="profile-avatar">
                        <img src="{{ $avatarUrl }}" alt="Avatar" onerror="this.style.display='none'">
                    </div>
                    <div class="profile-info">
                        <div class="profile-name">{{ $nickname }}</div>
                        <div class="profile-tier">Tier: <span>{{ $tierLabel }}</span></div>
                    </div>
                </div>

                <a class="btn" href="{{ $safeRoute('player.profile') }}">Profil</a>

                @if(Route::has('player.logout'))
                    <form method="POST" action="{{ route('player.logout') }}">
                        @csrf
                        <button class="btn-logout" type="submit">Keluar</button>
                    </form>
                @endif
            </div>
        </section>
    </aside>
</div>

{{-- ✅ SIDEBAR JS (INCLUDE) --}}
@include('player.partials.learn-sidebar', ['mode' => 'scripts'])

<script>
(function(){
    // =========================================
    // FAQ DROPDOWN
    // =========================================
    const items = Array.from(document.querySelectorAll('.qa-item'));
    items.forEach(item => {
        const btn = item.querySelector('.qa-q');
        if(!btn) return;
        btn.addEventListener('click', () => {
            items.forEach(x => { if(x !== item) x.classList.remove('open'); });
            item.classList.toggle('open');
        });
    });
})();
</script>
</body>
</html>

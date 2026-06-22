{{-- resources/views/player/partials/learn-sidebar.blade.php (NEW) --}}
@php
    $mode = $mode ?? 'all'; // css | mobile | desktop | scripts | all
@endphp

@if($mode === 'css' || $mode === 'all')
<style>
    /* ===== Sidebar + Mobile Bar + Drawer (EXTRACTED) ===== */

    /* Cards */
    .card{
        background: color-mix(in oklab, var(--card) 94%, transparent);
        border: 1px solid var(--line);
        border-radius: var(--r-xl);
        box-shadow: var(--shadow);
        overflow:hidden;
    }

    /* Layout grid desktop */
    .shell{
        min-height:100vh;
        display:grid;
        grid-template-columns: var(--nav-w) 1fr var(--right-w);
        gap: 14px;
        padding: 14px;
    }

    /* Desktop collapse */
    body.nav-collapsed{ --nav-w: var(--nav-w-collapsed); }

    /* ===== Sidebar Desktop ===== */
    .nav{
        position: sticky;
        top: 14px;
        height: calc(100vh - 28px);
        display:flex;
        flex-direction:column;
        overflow:hidden;
    }

    .nav-head{
        padding: 12px;
        display:flex;
        align-items:center;
        gap: 10px;
        border-bottom: 1px solid var(--line);
        min-height: 66px;
    }

    .brand-box{
        width: 44px; height:44px;
        border-radius: 14px;
        border: 1px solid var(--line);
        background: var(--card);
        display:grid;
        place-items:center;
        overflow:hidden;
        flex: 0 0 auto;
    }
    .brand-box img{ width:100%; height:100%; object-fit:cover; display:block; }

    .brand-text{
        display:grid;
        gap: 2px;
        line-height:1.05;
        min-width:0;
    }
    .brand-title{ font-weight: 950; font-size: 14px; }
    .brand-sub{ font-weight: 900; font-size: 12px; color: var(--muted); }

    .nav-actions{ margin-left:auto; display:flex; gap: 8px; align-items:center; }

    .icon-btn{
        width: 42px; height: 42px;
        border-radius: 14px;
        border: 1px solid var(--line);
        background: color-mix(in oklab, var(--card) 92%, transparent);
        color: var(--txt-body);
        cursor:pointer;
        display:grid;
        place-items:center;
        transition: transform .12s ease;
    }
    .icon-btn:hover{ transform: translateY(-1px); }
    .icon-btn svg{ width: 18px; height: 18px; }

    .nav-menu{
        padding: 12px;
        display:grid;
        gap: 10px;
    }

    .nav-item{
        display:flex;
        align-items:center;
        gap: 12px;
        padding: 12px 12px;
        border-radius: 16px;
        text-decoration:none;
        color: var(--txt-body);
        font-weight: 950;
        border: 1px solid var(--line);
        background: color-mix(in oklab, var(--card) 92%, transparent);
    }
    .nav-item.is-active{
        border-color: var(--brand);
        background: color-mix(in oklab, var(--brand) 8%, var(--card));
    }
    .nav-item.is-active .nav-ico {
        color: var(--brand);
        border-color: var(--brand);
        background: color-mix(in oklab, var(--brand) 10%, var(--card));
    }

    .nav-ico{
        width: 40px; height: 40px;
        border-radius: 14px;
        border: 1px solid var(--line);
        background: color-mix(in oklab, var(--card) 92%, transparent);
        display:grid;
        place-items:center;
        flex: 0 0 auto;
        color: var(--muted);
        transition: all 0.2s ease;
    }
    .nav-ico svg{ width: 18px; height: 18px; }

    .nav-label{ white-space:nowrap; overflow:hidden; text-overflow:ellipsis; }

.nav-foot{
    margin-top:auto;
    padding: 12px;
    border-top: 1px solid var(--line);
    display:grid;
    gap: 10px;
}

/* ✅ logout button (mobile drawer) */
.nav-logout{
    width: 100%;
    display:inline-flex;
    align-items:center;
    justify-content:center;
    gap: 10px;
    padding: 12px;
    border-radius: 16px;
    border: 1px solid var(--line);
    background: color-mix(in oklab, var(--card) 92%, transparent);
    color: var(--txt-body);
    cursor: pointer;
    font-weight: 950;
}
.nav-logout svg{ width: 18px; height: 18px; }


    .theme-toggle{
        width:100%;
        display:flex;
        align-items:center;
        justify-content:space-between;
        gap:10px;
        padding: 12px;
        border-radius: 16px;
        border: 1px solid var(--line);
        background: color-mix(in oklab, var(--card) 92%, transparent);
        cursor:pointer;
        font-weight: 950;
        color: var(--txt-body);
    }
    .theme-left{ display:flex; align-items:center; gap: 10px; }
    .theme-left svg{ width: 18px; height: 18px; }

    /* ✅ COLLAPSED BEHAVIOR:
       - Tampilkan menu berupa icon saja ketika desktop sidebar di-collapse
       - Batasi selector agar mobile drawer (.nav-mobile) tidak ikut tersembunyi
    */
    /* ✅ COLLAPSED BEHAVIOR:
       - Tampilkan menu berupa icon saja ketika desktop sidebar di-collapse
       - Batasi selector agar mobile drawer (.nav-mobile) tidak ikut tersembunyi
    */
    body.nav-collapsed .nav {
        width: 72px;
    }
    body.nav-collapsed .nav .nav-head {
        padding: 12px 0;
        justify-content: center;
    }
    body.nav-collapsed .nav .brand-box,
    body.nav-collapsed .nav .brand-text,
    body.nav-collapsed .nav .nav-label {
        display: none !important;
    }
    body.nav-collapsed .nav .nav-actions {
        margin: 0;
        display: flex;
        justify-content: center;
        width: 100%;
    }
    body.nav-collapsed .nav .icon-btn {
        width: 48px;
        height: 48px;
        border-radius: 14px;
        border: 1px solid var(--line);
        background: color-mix(in oklab, var(--card) 92%, transparent);
        color: var(--txt-body);
        display: grid;
        place-items: center;
        transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
    }
    body.nav-collapsed .nav .icon-btn:hover {
        transform: translateY(-2px);
        border-color: var(--brand);
        box-shadow: 0 4px 12px color-mix(in oklab, var(--brand) 15%, transparent);
    }
    body.nav-collapsed .nav .nav-menu {
        padding: 16px 0;
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 12px;
        width: 100%;
    }
    body.nav-collapsed .nav .nav-item {
        width: 48px;
        height: 48px;
        padding: 0;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 14px;
        border: 1px solid var(--line);
        background: color-mix(in oklab, var(--card) 92%, transparent);
        color: var(--txt-body);
        transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
    }
    body.nav-collapsed .nav .nav-item:hover {
        transform: translateY(-2px);
        border-color: var(--brand);
        color: var(--brand);
        box-shadow: 0 4px 12px color-mix(in oklab, var(--brand) 15%, transparent);
    }
    body.nav-collapsed .nav .nav-item.is-active {
        border-color: var(--brand);
        background: color-mix(in oklab, var(--brand) 12%, transparent);
        box-shadow: 0 0 12px color-mix(in oklab, var(--brand) 25%, transparent);
        color: var(--brand);
    }
    body.nav-collapsed .nav .nav-ico {
        border: none !important;
        background: transparent !important;
        width: auto !important;
        height: auto !important;
        padding: 0 !important;
        margin: 0 !important;
        box-shadow: none !important;
        display: flex !important;
        align-items: center !important;
        justify-content: center !important;
        color: inherit;
    }
    body.nav-collapsed .nav .nav-ico svg {
        width: 22px;
        height: 22px;
        transition: transform 0.2s ease;
    }
    body.nav-collapsed .nav .nav-item:hover .nav-ico svg {
        transform: scale(1.1);
    }
    body.nav-collapsed .nav .nav-foot {
        padding: 16px 0;
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 12px;
        width: 100%;
    }
    body.nav-collapsed .nav .theme-toggle {
        width: 48px;
        height: 48px;
        padding: 0;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 14px;
        border: 1px solid var(--line);
        background: color-mix(in oklab, var(--card) 92%, transparent);
        color: var(--txt-body);
        transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
    }
    body.nav-collapsed .nav .theme-toggle:hover {
        transform: translateY(-2px);
        border-color: var(--brand);
        color: var(--brand);
        box-shadow: 0 4px 12px color-mix(in oklab, var(--brand) 15%, transparent);
    }
    body.nav-collapsed .nav .theme-toggle svg {
        width: 20px;
        height: 20px;
    }
    body.nav-collapsed .nav #themeLabelDesktop {
        display: none !important;
    }
    body.nav-collapsed .nav .theme-left span {
        display: none !important;
    }

    /* Mobile sticky topbar */
    .mobile-bar{
        display:none;
        position: sticky;
        top: 10px;
        z-index: 80;
        gap: 10px;
        align-items:center;
        justify-content:space-between;
        padding: 10px;
        margin: 10px 14px 12px;
        border-radius: var(--r-xl);
        border: 1px solid var(--line);
        background: color-mix(in oklab, var(--card) 92%, transparent);
        box-shadow: var(--shadow);
        backdrop-filter: blur(10px);
        -webkit-backdrop-filter: blur(10px);
    }
    .m-left{ display:flex; align-items:center; gap: 10px; min-width:0; }
    .hamburger{
        width: 44px; height: 44px;
        border-radius: 16px;
        border: 1px solid var(--line);
        background: color-mix(in oklab, var(--card) 92%, transparent);
        color: var(--txt-body);
        cursor:pointer;
        display:grid;
        place-items:center;
        flex:0 0 auto;
    }
    .hamburger svg{ width: 20px; height: 20px; }

    .m-title{
        display:grid;
        gap: 2px;
        min-width:0;
    }
    .m-title .tier{
        font-weight: 950;
        font-size: 12px;
        color: var(--muted);
        white-space:nowrap;
        overflow:hidden;
        text-overflow:ellipsis;
        max-width: 220px;
    }
    .m-title .name{
        font-weight: 950;
        font-size: 14px;
        white-space:nowrap;
        overflow:hidden;
        text-overflow:ellipsis;
        max-width: 220px;
    }

    .m-right{
        display:flex;
        align-items:center;
        gap: 8px;
        flex: 0 0 auto;
    }
    .m-pill{
        display:inline-flex;
        align-items:center;
        gap: 6px;
        padding: 8px 10px;
        border-radius: 16px;
        border: 1px solid var(--line);
        background: color-mix(in oklab, var(--card) 92%, transparent);
        font-weight: 950;
        font-size: 12px;
        line-height: 1;
    }
    .m-pill svg{ width: 16px; height: 16px; }
    .m-pill.heart{ color: var(--danger); }
    .m-pill.money{ color:#22c55e; }
    .m-pill.xp{ color:#3b82f6; }

    /* Drawer overlay + mobile nav (overlay, NOT pushing layout) */
    .overlay{
        position: fixed;
        inset:0;
        background: rgba(0,0,0,.55);
        display:none;
        z-index: 190;
    }
    .overlay.is-open{ display:block; }

    .nav-mobile{
        position: fixed;
        top:0; left:0;
        height:100vh;
        width: min(320px, 88vw);
        z-index: 200;
        transform: translateX(-105%);
        transition: transform .2s ease;
        background: var(--card);
        border-right: 1px solid var(--line);
        box-shadow: var(--shadow);
        display:flex;
        flex-direction:column;
    }
    .nav-mobile.is-open{ transform: translateX(0); }
    .nav-mobile .nav-head{ border-bottom:1px solid var(--line); }
    .nav-mobile .nav-item{ border:1px solid var(--line); background: color-mix(in oklab, var(--card) 92%, transparent); }
    .nav-mobile .nav-foot{ border-top:1px solid var(--line); }

    /* ✅ MOBILE FIX: satu kolom + sidebar/right benar-benar hilang */
    @media (max-width: 1024px){
        .shell{
            grid-template-columns: 1fr !important;
            padding: 0 14px 14px;
        }
        .nav{ display:none !important; }
        .right{ display:none !important; }
        .mobile-bar{ display:flex; }
    }
</style>
@endif

@if($mode === 'mobile' || $mode === 'all')
{{-- Mobile top sticky bar --}}
<div class="mobile-bar">
    <div class="m-left">
        <button class="hamburger" id="btnOpenMobileNav" aria-label="Buka menu">
            <svg viewBox="0 0 24 24" fill="none">
                <path d="M5 7h14M5 12h14M5 17h14" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
            </svg>
        </button>

        <div class="m-title">
            <div class="tier">Tier: {{ $tierLabel }}</div>
            <div class="name">Halo, {{ $nickname }}</div>
        </div>
    </div>

    <div class="m-right">
        <div class="m-pill xp" title="XP">
            <svg viewBox="0 0 24 24" fill="none">
                <path d="M13 2s2 3 2 6-2 4-2 4 4-1 4-6 2-4 2-4-1 7-4 10-1 8-1 8-6-3-6-8 4-10 5-10Z" stroke="currentColor" stroke-width="2" stroke-linejoin="round"/>
            </svg>
            <span>{{ (int)($player->xp_total ?? 0) }}</span>
        </div>

        <div class="m-pill heart" title="Hati">
            <svg viewBox="0 0 24 24" fill="none">
                <path d="M12 21s-7-4.6-9.2-9.1C1.4 8.9 3.4 6 6.6 6c1.8 0 3.1 1 3.9 2 0.8-1 2.1-2 3.9-2 3.2 0 5.2 2.9 3.8 5.9C19 16.4 12 21 12 21Z" stroke="currentColor" stroke-width="2" stroke-linejoin="round"/>
            </svg>
            <span id="heartsNowMobile">{{ (int)($player->hearts ?? 0) }}</span>/<span>{{ (int)($player->hearts_max ?? 5) }}</span>
        </div>

        <div class="m-pill money" title="Uang">
            <svg viewBox="0 0 24 24" fill="none">
                <path d="M3 7h18v10H3V7Z" stroke="currentColor" stroke-width="2" stroke-linejoin="round"/>
                <path d="M7 7V5h10v2" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                <path d="M12 10.5a1.5 1.5 0 1 0 0 3 1.5 1.5 0 0 0 0-3Z" stroke="currentColor" stroke-width="2"/>
            </svg>
            <span>{{ number_format((int)($player->coins ?? 0), 0, ',', '.') }}</span>
        </div>
    </div>
</div>

{{-- Mobile nav drawer --}}
<div class="overlay" id="mobileOverlay" aria-hidden="true"></div>

<aside class="nav-mobile" id="mobileNav" aria-label="Sidebar Mobile">
    <div class="nav-head">
        <div class="brand-box" aria-hidden="true">
            <img src="{{ asset('images/icon/icon_lentara.png') }}" alt="Lentara" onerror="this.style.display='none'">
        </div>
        <div class="brand-text">
            <div class="brand-title">Lentara Nusantara</div>
            <div class="brand-sub">Belajar budaya dengan game</div>
        </div>
        <div class="nav-actions">
            <button class="icon-btn" id="btnCloseMobileNav" aria-label="Tutup menu">
                <svg viewBox="0 0 24 24" fill="none">
                    <path d="M18 6L6 18M6 6l12 12" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                </svg>
            </button>
        </div>
    </div>

    <nav class="nav-menu">
        @foreach($menu as $m)
            <a class="nav-item {{ $m['active'] ? 'is-active' : '' }}" href="{{ $safeRoute($m['route']) }}">
                <span class="nav-ico" aria-hidden="true">
                    @if($m['icon']==='book')
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20V3H6.5a2.5 2.5 0 0 0-2.5 2.5v14Z" fill="currentColor" fill-opacity="0.12"/>
                            <path d="M6 6h10M6 10h10M6 14h6" opacity="0.6" />
                            <path d="M20 21H6.5A2.5 2.5 0 0 1 4 18.5" />
                        </svg>
                    @elseif($m['icon']==='help')
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <circle cx="12" cy="12" r="10" fill="currentColor" fill-opacity="0.1" />
                            <polygon points="16.24 7.76 14.12 14.12 7.76 16.24 9.88 9.88 16.24 7.76" fill="currentColor" fill-opacity="0.3" />
                            <circle cx="12" cy="12" r="1.5" fill="currentColor" />
                            <path d="M12 2v2M12 20v2M2 12h2M20 12h2" opacity="0.8" />
                        </svg>
                    @elseif($m['icon']==='gear')
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M12 22c5.523 0 10-4.477 10-10S17.523 2 12 2 2 6.477 2 12s4.477 10 10 10Z" fill="currentColor" fill-opacity="0.08" />
                            <path d="M18 19.5v-1a4 4 0 0 0-4-4H10a4 4 0 0 0-4 4v1" />
                            <circle cx="12" cy="8.5" r="3.5" fill="currentColor" fill-opacity="0.2" />
                        </svg>
                    @else
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M6 9H4.5a2.5 2.5 0 0 1 0-5H6" />
                            <path d="M18 9h1.5a2.5 2.5 0 0 0 0-5H18" />
                            <path d="M4 22h16" />
                            <path d="M10 14.66V17c0 .55-.45 1-1 1H4v2h16v-2h-5c-.55 0-1-.45-1-1v-2.34" />
                            <path d="M12 2a6 6 0 0 1 6 6v3.5c0 3.3-2.7 6-6 6s-6-2.7-6-6V8a6 6 0 0 1 6-6Z" fill="currentColor" fill-opacity="0.1" />
                            <polygon points="12 6 13.5 9 16.5 9.5 14.25 11.75 14.85 14.85 12 13.3 9.15 14.85 9.75 11.75 7.5 9.5 10.5 9 12 6" fill="currentColor" fill-opacity="0.5" stroke="none" />
                        </svg>
                    @endif
                </span>
                <span class="nav-label">{{ $m['label'] }}</span>
            </a>
        @endforeach
    </nav>

<div class="nav-foot">
    <button class="theme-toggle" type="button" id="themeToggleMobile">
        <span class="theme-left" id="themeIconMobile"></span>
        <span id="themeLabelMobile">Mode</span>
    </button>

    {{-- ✅ Logout di sidebar mobile --}}
    @if(\Illuminate\Support\Facades\Route::has('player.logout'))
        <form method="POST" action="{{ route('player.logout') }}">
            @csrf
            <button class="nav-logout" type="submit">
                <svg viewBox="0 0 24 24" fill="none" aria-hidden="true">
                    <path d="M10 17l-1 4h10l-1-4" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    <path d="M12 3v10" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                    <path d="M8 7l4-4 4 4" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
                <span>Keluar</span>
            </button>
        </form>
    @endif
</div>

</aside>
@endif

@if($mode === 'desktop' || $mode === 'all')
{{-- Desktop sidebar --}}
<aside class="card nav" aria-label="Sidebar Desktop">
    <div class="nav-head">
        <div class="brand-box" aria-hidden="true">
            <img src="{{ asset('images/icon/icon_lentara.png') }}" alt="Lentara" onerror="this.style.display='none'">
        </div>

        <div class="brand-text">
            <div class="brand-title">Lentara Nusantara</div>
            <div class="brand-sub">Belajar budaya</div>
        </div>

        <div class="nav-actions">
            {{-- ✅ tombol sesuai request: expanded = X, collapsed = ... --}}
            <button class="icon-btn" id="btnCollapseDesktop" aria-label="Buka/Tutup sidebar" title="Buka/Tutup">
                <span id="collapseIcon"></span>
            </button>
        </div>
    </div>

    <nav class="nav-menu" aria-label="Menu">
        @foreach($menu as $m)
            @if($m['route'] === 'player.profile')
                @continue
            @endif
            <a class="nav-item {{ $m['active'] ? 'is-active' : '' }}" href="{{ $safeRoute($m['route']) }}">
                <span class="nav-ico" aria-hidden="true">
                    @if($m['icon']==='book')
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20V3H6.5a2.5 2.5 0 0 0-2.5 2.5v14Z" fill="currentColor" fill-opacity="0.12"/>
                            <path d="M6 6h10M6 10h10M6 14h6" opacity="0.6" />
                            <path d="M20 21H6.5A2.5 2.5 0 0 1 4 18.5" />
                        </svg>
                    @elseif($m['icon']==='help')
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <circle cx="12" cy="12" r="10" fill="currentColor" fill-opacity="0.1" />
                            <polygon points="16.24 7.76 14.12 14.12 7.76 16.24 9.88 9.88 16.24 7.76" fill="currentColor" fill-opacity="0.3" />
                            <circle cx="12" cy="12" r="1.5" fill="currentColor" />
                            <path d="M12 2v2M12 20v2M2 12h2M20 12h2" opacity="0.8" />
                        </svg>
                    @elseif($m['icon']==='gear')
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M12 22c5.523 0 10-4.477 10-10S17.523 2 12 2 2 6.477 2 12s4.477 10 10 10Z" fill="currentColor" fill-opacity="0.08" />
                            <path d="M18 19.5v-1a4 4 0 0 0-4-4H10a4 4 0 0 0-4 4v1" />
                            <circle cx="12" cy="8.5" r="3.5" fill="currentColor" fill-opacity="0.2" />
                        </svg>
                    @else
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M6 9H4.5a2.5 2.5 0 0 1 0-5H6" />
                            <path d="M18 9h1.5a2.5 2.5 0 0 0 0-5H18" />
                            <path d="M4 22h16" />
                            <path d="M10 14.66V17c0 .55-.45 1-1 1H4v2h16v-2h-5c-.55 0-1-.45-1-1v-2.34" />
                            <path d="M12 2a6 6 0 0 1 6 6v3.5c0 3.3-2.7 6-6 6s-6-2.7-6-6V8a6 6 0 0 1 6-6Z" fill="currentColor" fill-opacity="0.1" />
                            <polygon points="12 6 13.5 9 16.5 9.5 14.25 11.75 14.85 14.85 12 13.3 9.15 14.85 9.75 11.75 7.5 9.5 10.5 9 12 6" fill="currentColor" fill-opacity="0.5" stroke="none" />
                        </svg>
                    @endif
                </span>
                <span class="nav-label">{{ $m['label'] }}</span>
            </a>
        @endforeach
    </nav>

    <div class="nav-foot">
        <button class="theme-toggle" type="button" id="themeToggleDesktop" aria-label="Ganti mode">
            <span class="theme-left" id="themeIconDesktop"></span>
            <span id="themeLabelDesktop">Mode</span>
        </button>
    </div>
</aside>
@endif

@if($mode === 'scripts' || $mode === 'all')
<script>
(function(){
    // =========================================
    // Theme sync (localStorage: piforrr-theme)
    // =========================================
    const sunSvg = `
        <svg viewBox="0 0 24 24" fill="none" aria-hidden="true">
          <path d="M12 18a6 6 0 1 0 0-12 6 6 0 0 0 0 12Z" stroke="currentColor" stroke-width="2"/>
          <path d="M12 2v2M12 20v2M4 12H2M22 12h-2M5 5l1.5 1.5M17.5 17.5L19 19M19 5l-1.5 1.5M6.5 17.5L5 19" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
        </svg>`;
    const moonSvg = `
        <svg viewBox="0 0 24 24" fill="none" aria-hidden="true">
          <path d="M21 14.5A8.5 8.5 0 0 1 9.5 3a7 7 0 1 0 11.5 11.5Z" stroke="currentColor" stroke-width="2" stroke-linejoin="round"/>
        </svg>`;

    function applyTheme(theme){
        const t = (theme === 'light') ? 'light' : 'dark';
        document.documentElement.setAttribute('data-theme', t);
        localStorage.setItem('piforrr-theme', t);

        const iconD = document.getElementById('themeIconDesktop');
        const iconM = document.getElementById('themeIconMobile');
        const labelD = document.getElementById('themeLabelDesktop');
        const labelM = document.getElementById('themeLabelMobile');

        const iconHtml = (t === 'dark')
            ? (moonSvg + '<span>Mode</span>')
            : (sunSvg + '<span>Mode</span>');

        if(iconD) iconD.innerHTML = iconHtml;
        if(iconM) iconM.innerHTML = iconHtml;

        if(labelD) labelD.textContent = (t === 'dark') ? 'Gelap' : 'Terang';
        if(labelM) labelM.textContent = (t === 'dark') ? 'Gelap' : 'Terang';
    }

    function toggleTheme(){
        const cur = document.documentElement.getAttribute('data-theme') || localStorage.getItem('piforrr-theme') || 'dark';
        applyTheme(cur === 'dark' ? 'light' : 'dark');
    }

    applyTheme(document.documentElement.getAttribute('data-theme') || localStorage.getItem('piforrr-theme') || 'dark');

    const tDesk = document.getElementById('themeToggleDesktop');
    const tMob  = document.getElementById('themeToggleMobile');
    if(tDesk) tDesk.addEventListener('click', toggleTheme);
    if(tMob)  tMob.addEventListener('click', toggleTheme);

    // =========================================
    // Desktop collapse sidebar (… / X)
    // =========================================
    const btnCollapse = document.getElementById('btnCollapseDesktop');
    const collapseIcon = document.getElementById('collapseIcon');

    function setCollapseIcon(){
        const collapsed = document.body.classList.contains('nav-collapsed');
        if(!collapseIcon) return;

        if(collapsed){
            collapseIcon.innerHTML = `
                <svg viewBox="0 0 24 24" fill="none" aria-hidden="true">
                    <path d="M6.5 12h.01M12 12h.01M17.5 12h.01" stroke="currentColor" stroke-width="3" stroke-linecap="round"/>
                </svg>`;
        }else{
            collapseIcon.innerHTML = `
                <svg viewBox="0 0 24 24" fill="none" aria-hidden="true">
                    <path d="M18 6L6 18M6 6l12 12" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                </svg>`;
        }
    }

    if(btnCollapse){
        const saved = localStorage.getItem('learn_nav_collapsed');
        if(saved === '1') document.body.classList.add('nav-collapsed');
        setCollapseIcon();

        btnCollapse.addEventListener('click', () => {
            document.body.classList.toggle('nav-collapsed');
            localStorage.setItem('learn_nav_collapsed', document.body.classList.contains('nav-collapsed') ? '1' : '0');
            setCollapseIcon();
        });
    }

    // =========================================
    // Mobile drawer
    // =========================================
    const btnOpen = document.getElementById('btnOpenMobileNav');
    const btnClose= document.getElementById('btnCloseMobileNav');
    const overlay = document.getElementById('mobileOverlay');
    const mnav    = document.getElementById('mobileNav');

    function openNav(){
        if(!mnav || !overlay) return;
        mnav.classList.add('is-open');
        overlay.classList.add('is-open');
        document.body.style.overflow = 'hidden';
    }
    function closeNav(){
        if(!mnav || !overlay) return;
        mnav.classList.remove('is-open');
        overlay.classList.remove('is-open');
        document.body.style.overflow = '';
    }
    if(btnOpen) btnOpen.addEventListener('click', openNav);
    if(btnClose) btnClose.addEventListener('click', closeNav);
    if(overlay) overlay.addEventListener('click', closeNav);
})();
</script>
@endif

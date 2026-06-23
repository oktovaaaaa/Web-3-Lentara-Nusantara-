{{-- resources/views/partials/nusantara-explorer.blade.php --}}
{{-- ================================================================
     JELAJAH DESTINASI NUSANTARA
     Peta Interaktif GPS + Rekomendasi Destinasi Budaya Terdekat
     Teknologi: Leaflet.js + OpenStreetMap + Overpass API (100% Gratis)
================================================================ --}}

<section id="explore-nusantara" class="py-12">

  {{-- Leaflet CSS --}}
  <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />

  <style>
    /* =============================================================
       EXPLORE NUSANTARA — PREMIUM CULTURAL THEME
    ============================================================= */
    @property --xp-neon-angle {
      syntax: "<angle>";
      inherits: false;
      initial-value: 0deg;
    }

    /* ===== SECTION TITLE (reuse neon-title dari home) ===== */
    #explore-nusantara .xp-subtitle {
      font-size: 1.05rem;
      color: var(--muted);
      max-width: 720px;
      margin: 0 auto 2.5rem;
      line-height: 1.7;
      text-align: center;
    }

    /* ===== MAIN WRAP ===== */
    #explore-nusantara .xp-wrap {
      max-width: 1200px;
      margin: 0 auto;
    }

    /* ===== GPS ACTIVATION CARD ===== */
    #explore-nusantara .xp-activate-card {
      position: relative;
      border-radius: 28px;
      padding: 3rem 2rem;
      text-align: center;
      overflow: hidden;
      margin-bottom: 2rem;
      background: linear-gradient(145deg,
        color-mix(in oklab, var(--card) 88%, transparent),
        color-mix(in oklab, var(--card) 75%, #f97316));
      border: 1px solid rgba(249, 115, 22, 0.25);
      box-shadow: 0 20px 60px rgba(0,0,0,0.3);
    }

    html[data-theme="dark"] #explore-nusantara .xp-activate-card {
      background: linear-gradient(145deg, #111827, #1a0f03);
      border-color: rgba(249,115,22,0.3);
    }
    html[data-theme="light"] #explore-nusantara .xp-activate-card {
      background: linear-gradient(145deg, #fff7ed, #fff);
      border-color: rgba(249,115,22,0.2);
    }

    /* neon border glow */
    #explore-nusantara .xp-activate-card::before {
      content: "";
      position: absolute;
      inset: -4px;
      border-radius: 32px;
      background: conic-gradient(from var(--xp-neon-angle),
        rgba(249,115,22,0) 0deg,
        rgba(249,115,22,0.5) 60deg,
        #f97316 120deg,
        #fbbf24 180deg,
        #f97316 240deg,
        rgba(249,115,22,0.5) 300deg,
        rgba(249,115,22,0) 360deg);
      -webkit-mask: linear-gradient(#000 0 0) content-box, linear-gradient(#000 0 0);
      -webkit-mask-composite: xor;
      mask-composite: exclude;
      filter: blur(8px);
      opacity: 0.6;
      animation: xp-neon-spin 8s linear infinite;
      pointer-events: none;
      z-index: 0;
    }
    @keyframes xp-neon-spin { to { --xp-neon-angle: 360deg; } }

    /* batik watermark bg */
    #explore-nusantara .xp-activate-card::after {
      content: "";
      position: absolute;
      inset: 0;
      background-image: url("{{ asset('images/icon/footer.JPEG') }}");
      background-size: cover;
      background-position: center;
      opacity: 0.06;
      pointer-events: none;
      z-index: 0;
      border-radius: 28px;
    }

    #explore-nusantara .xp-activate-card > * {
      position: relative;
      z-index: 1;
    }

    /* ===== ICON COMPASS ===== */
    #explore-nusantara .xp-compass-wrap {
      width: 90px;
      height: 90px;
      margin: 0 auto 1.5rem;
      position: relative;
    }

    #explore-nusantara .xp-compass-ring {
      width: 90px;
      height: 90px;
      border-radius: 50%;
      border: 2px solid rgba(249,115,22,0.4);
      display: flex;
      align-items: center;
      justify-content: center;
      background: rgba(249,115,22,0.12);
      animation: xp-pulse-ring 2.5s ease-in-out infinite;
    }
    @keyframes xp-pulse-ring {
      0%, 100% { box-shadow: 0 0 0 0 rgba(249,115,22,0.5), 0 0 0 10px rgba(249,115,22,0.15); }
      50% { box-shadow: 0 0 0 12px rgba(249,115,22,0.2), 0 0 0 24px rgba(249,115,22,0.05); }
    }

    /* ===== TITLE & DESC ===== */
    #explore-nusantara .xp-card-title {
      font-size: 1.7rem;
      font-weight: 900;
      margin-bottom: 0.7rem;
      background: linear-gradient(90deg, #f97316, #fbbf24);
      -webkit-background-clip: text;
      -webkit-text-fill-color: transparent;
      font-family: 'Cinzel', serif;
    }

    #explore-nusantara .xp-card-desc {
      color: var(--muted);
      font-size: 1rem;
      line-height: 1.65;
      max-width: 560px;
      margin: 0 auto 1.8rem;
    }

    /* ===== CTA BUTTON ===== */
    #explore-nusantara .xp-btn-gps {
      display: inline-flex;
      align-items: center;
      gap: 10px;
      padding: 16px 36px;
      border-radius: 999px;
      border: none;
      cursor: pointer;
      font-size: 1rem;
      font-weight: 900;
      color: white;
      background: linear-gradient(135deg, #f97316, #fb923c, #fbbf24);
      background-size: 200% auto;
      box-shadow: 0 8px 30px rgba(249,115,22,0.45);
      transition: all 0.3s ease;
      letter-spacing: 0.03em;
    }
    #explore-nusantara .xp-btn-gps:hover {
      transform: translateY(-3px) scale(1.03);
      box-shadow: 0 16px 40px rgba(249,115,22,0.55);
      background-position: right center;
    }
    #explore-nusantara .xp-btn-gps:disabled {
      opacity: 0.6;
      cursor: not-allowed;
      transform: none;
    }

    /* LOADING SPINNER */
    #explore-nusantara .xp-spinner {
      display: none;
      width: 18px;
      height: 18px;
      border: 3px solid rgba(255,255,255,0.3);
      border-top-color: #fff;
      border-radius: 50%;
      animation: xp-spin 0.8s linear infinite;
    }
    @keyframes xp-spin { to { transform: rotate(360deg); } }

    /* ===== STATUS CHIPS ===== */
    #explore-nusantara .xp-status-chips {
      display: flex;
      justify-content: center;
      gap: 12px;
      margin-top: 1.2rem;
      flex-wrap: wrap;
    }

    #explore-nusantara .xp-chip {
      display: inline-flex;
      align-items: center;
      gap: 6px;
      padding: 7px 14px;
      border-radius: 999px;
      font-size: 12px;
      font-weight: 800;
      border: 1px solid rgba(249,115,22,0.3);
      background: rgba(249,115,22,0.1);
      color: #f97316;
    }
    html[data-theme="light"] #explore-nusantara .xp-chip { color: #b45309; }

    #explore-nusantara .xp-chip-dot {
      width: 7px;
      height: 7px;
      border-radius: 50%;
      background: #f97316;
      animation: xp-dot-blink 1.8s ease-in-out infinite;
    }
    @keyframes xp-dot-blink { 0%,100% { opacity:1; } 50% { opacity:0.3; } }

    /* ===== MAIN EXPLORER PANEL (MAP + LIST) ===== */
    #explore-nusantara .xp-explorer {
      display: none; /* shown after GPS activated */
      gap: 24px;
    }
    #explore-nusantara .xp-explorer.is-visible {
      display: grid;
      grid-template-columns: 1fr 380px;
    }

    @media (max-width: 1024px) {
      #explore-nusantara .xp-explorer.is-visible {
        grid-template-columns: 1fr;
      }
    }

    /* ===== MAP CONTAINER ===== */
    #explore-nusantara .xp-map-card {
      border-radius: 24px;
      overflow: hidden;
      border: 1px solid rgba(249,115,22,0.2);
      box-shadow: 0 20px 50px rgba(0,0,0,0.35);
      position: relative;
    }

    #explore-nusantara .xp-map-header {
      display: flex;
      align-items: center;
      justify-content: space-between;
      gap: 12px;
      padding: 14px 18px;
      background: linear-gradient(90deg, rgba(249,115,22,0.15), transparent);
      border-bottom: 1px solid rgba(249,115,22,0.15);
    }
    html[data-theme="dark"] #explore-nusantara .xp-map-header {
      background: linear-gradient(90deg, rgba(249,115,22,0.12), rgba(17,24,39,0.9));
    }

    #explore-nusantara .xp-map-title-group {
      display: flex;
      align-items: center;
      gap: 10px;
    }

    #explore-nusantara .xp-map-title {
      font-size: 0.95rem;
      font-weight: 900;
      color: var(--txt-body);
    }

    #explore-nusantara .xp-map-coords {
      font-size: 11px;
      color: var(--muted);
      font-family: monospace;
      margin-top: 2px;
    }

    #explore-nusantara #xp-map {
      width: 100%;
      height: 480px;
      z-index: 1;
    }

    @media (max-width: 768px) {
      #explore-nusantara #xp-map { height: 340px; }
    }

    /* RADIUS SELECT */
    #explore-nusantara .xp-radius-select {
      background: rgba(249,115,22,0.15);
      border: 1px solid rgba(249,115,22,0.3);
      color: #f97316;
      font-size: 11px;
      font-weight: 800;
      padding: 6px 12px;
      border-radius: 999px;
      outline: none;
      cursor: pointer;
      transition: all 0.2s ease;
    }
    #explore-nusantara .xp-radius-select:hover {
      background: rgba(249,115,22,0.25);
      border-color: rgba(249,115,22,0.5);
    }
    html[data-theme="light"] #explore-nusantara .xp-radius-select {
      color: #b45309;
    }
    #explore-nusantara .xp-radius-select option {
      background: var(--card, #111827);
      color: var(--txt-body, #f3f4f6);
    }

    /* ===== DESTINASI LIST PANEL ===== */
    #explore-nusantara .xp-list-card {
      border-radius: 24px;
      overflow: hidden;
      border: 1px solid rgba(249,115,22,0.15);
      box-shadow: 0 20px 50px rgba(0,0,0,0.3);
      display: flex;
      flex-direction: column;
      background: linear-gradient(145deg,
        color-mix(in oklab, var(--card) 90%, transparent),
        color-mix(in oklab, var(--card) 80%, transparent));
    }
    html[data-theme="dark"] #explore-nusantara .xp-list-card {
      background: linear-gradient(145deg, #111827, #0f172a);
    }
    html[data-theme="light"] #explore-nusantara .xp-list-card {
      background: linear-gradient(145deg, #ffffff, #f8fafc);
    }

    /* LIST HEADER */
    #explore-nusantara .xp-list-header {
      padding: 16px 18px 0;
      flex-shrink: 0;
    }

    #explore-nusantara .xp-list-title {
      font-size: 1rem;
      font-weight: 900;
      color: var(--txt-body);
      margin-bottom: 12px;
    }

    /* FILTER TABS */
    #explore-nusantara .xp-tabs {
      display: flex;
      gap: 6px;
      flex-wrap: wrap;
      margin-bottom: 14px;
    }

    #explore-nusantara .xp-tab {
      padding: 6px 13px;
      border-radius: 999px;
      border: 1px solid rgba(249,115,22,0.2);
      background: transparent;
      font-size: 12px;
      font-weight: 800;
      color: var(--muted);
      cursor: pointer;
      transition: all 0.2s ease;
    }
    #explore-nusantara .xp-tab:hover {
      border-color: rgba(249,115,22,0.5);
      color: #f97316;
      background: rgba(249,115,22,0.08);
    }
    #explore-nusantara .xp-tab.is-active {
      background: rgba(249,115,22,0.18);
      border-color: #f97316;
      color: #f97316;
    }
    html[data-theme="light"] #explore-nusantara .xp-tab.is-active { color: #b45309; }

    /* LIST BODY (scrollable) */
    #explore-nusantara .xp-list-body {
      flex: 1;
      overflow-y: auto;
      padding: 0 14px 14px;
      max-height: 420px;
      scrollbar-width: thin;
      scrollbar-color: rgba(249,115,22,0.4) transparent;
    }
    #explore-nusantara .xp-list-body::-webkit-scrollbar { width: 5px; }
    #explore-nusantara .xp-list-body::-webkit-scrollbar-track { background: transparent; }
    #explore-nusantara .xp-list-body::-webkit-scrollbar-thumb {
      background: rgba(249,115,22,0.4);
      border-radius: 999px;
    }

    /* LOADING SKELETON */
    #explore-nusantara .xp-skeleton {
      padding: 20px 0;
      text-align: center;
      color: var(--muted);
      font-size: 0.9rem;
    }
    #explore-nusantara .xp-skel-bar {
      height: 12px;
      border-radius: 999px;
      background: linear-gradient(90deg,
        rgba(249,115,22,0.1) 25%,
        rgba(249,115,22,0.2) 50%,
        rgba(249,115,22,0.1) 75%);
      background-size: 200% 100%;
      animation: xp-shimmer 1.5s infinite;
      margin-bottom: 10px;
      border-radius: 999px;
    }
    @keyframes xp-shimmer {
      0% { background-position: 200% 0; }
      100% { background-position: -200% 0; }
    }

    /* DESTINATION ITEM CARD */
    #explore-nusantara .xp-dest-item {
      display: flex;
      align-items: flex-start;
      gap: 12px;
      padding: 13px 12px;
      border-radius: 16px;
      border: 1px solid transparent;
      cursor: pointer;
      transition: all 0.25s ease;
      margin-bottom: 8px;
    }
    html[data-theme="dark"] #explore-nusantara .xp-dest-item {
      background: rgba(255,255,255,0.04);
      border-color: rgba(255,255,255,0.07);
    }
    html[data-theme="light"] #explore-nusantara .xp-dest-item {
      background: rgba(0,0,0,0.02);
      border-color: rgba(0,0,0,0.06);
    }
    #explore-nusantara .xp-dest-item:hover {
      background: rgba(249,115,22,0.1);
      border-color: rgba(249,115,22,0.3);
      transform: translateX(4px);
    }
    #explore-nusantara .xp-dest-item:last-child { margin-bottom: 0; }

    /* Icon badge per kategori */
    #explore-nusantara .xp-dest-icon {
      width: 42px;
      height: 42px;
      border-radius: 12px;
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 18px;
      flex-shrink: 0;
    }
    .xp-cat-museum { background: rgba(249,115,22,0.2); border: 1px solid rgba(249,115,22,0.4); }
    .xp-cat-wisata  { background: rgba(251,191,36,0.2);  border: 1px solid rgba(251,191,36,0.4); }
    .xp-cat-kuliner { background: rgba(239,68,68,0.2);   border: 1px solid rgba(239,68,68,0.4); }

    #explore-nusantara .xp-dest-info { flex: 1; min-width: 0; }

    #explore-nusantara .xp-dest-name {
      font-size: 0.88rem;
      font-weight: 900;
      color: var(--txt-body);
      line-height: 1.3;
      white-space: nowrap;
      overflow: hidden;
      text-overflow: ellipsis;
      margin-bottom: 3px;
    }

    #explore-nusantara .xp-dest-meta {
      display: flex;
      align-items: center;
      gap: 8px;
      flex-wrap: wrap;
    }

    #explore-nusantara .xp-dest-dist {
      font-size: 11px;
      font-weight: 800;
      color: #f97316;
    }

    #explore-nusantara .xp-dest-cat {
      font-size: 10px;
      color: var(--muted);
      font-weight: 700;
      text-transform: uppercase;
      letter-spacing: 0.05em;
    }

    #explore-nusantara .xp-dest-rating {
      font-size: 11px;
      color: #fbbf24;
      font-weight: 700;
    }

    #explore-nusantara .xp-dest-food {
      font-size: 11px;
      color: var(--muted);
      margin-top: 3px;
      white-space: nowrap;
      overflow: hidden;
      text-overflow: ellipsis;
    }

    #explore-nusantara .xp-dest-openmap {
      display: inline-flex;
      align-items: center;
      justify-content: center;
      width: 32px;
      height: 32px;
      border-radius: 10px;
      border: 1px solid rgba(249,115,22,0.3);
      background: rgba(249,115,22,0.1);
      color: #f97316;
      flex-shrink: 0;
      text-decoration: none;
      transition: all 0.2s ease;
    }
    #explore-nusantara .xp-dest-openmap:hover {
      background: #f97316;
      color: white;
      border-color: #f97316;
    }

    /* EMPTY STATE */
    #explore-nusantara .xp-empty {
      text-align: center;
      padding: 2rem 1rem;
      color: var(--muted);
    }
    #explore-nusantara .xp-empty-icon { font-size: 2.5rem; margin-bottom: 0.5rem; }

    /* COUNT BADGE */
    #explore-nusantara .xp-count-badge {
      display: inline-flex;
      align-items: center;
      padding: 2px 8px;
      border-radius: 999px;
      font-size: 11px;
      font-weight: 900;
      background: rgba(249,115,22,0.2);
      color: #f97316;
      margin-left: 6px;
    }

    /* ===== ERROR CARD ===== */
    #explore-nusantara .xp-error-card {
      display: none;
      border-radius: 20px;
      padding: 1.8rem;
      margin-top: 1.2rem;
      text-align: center;
      background: rgba(239,68,68,0.1);
      border: 1px solid rgba(239,68,68,0.3);
    }
    #explore-nusantara .xp-error-card.is-visible { display: block; }

    /* ===== LEAFLET CUSTOM MARKERS ===== */
    .xp-marker-user {
      width: 20px;
      height: 20px;
      background: #3b82f6;
      border-radius: 50%;
      border: 3px solid white;
      box-shadow: 0 0 0 4px rgba(59,130,246,0.4), 0 4px 12px rgba(0,0,0,0.3);
    }
    .xp-marker-museum {
      width: 14px; height: 14px;
      background: #f97316;
      border-radius: 50%;
      border: 2px solid white;
      box-shadow: 0 2px 8px rgba(0,0,0,0.3);
    }
    .xp-marker-wisata {
      width: 14px; height: 14px;
      background: #fbbf24;
      border-radius: 50%;
      border: 2px solid white;
      box-shadow: 0 2px 8px rgba(0,0,0,0.3);
    }
    .xp-marker-kuliner {
      width: 14px; height: 14px;
      background: #ef4444;
      border-radius: 50%;
      border: 2px solid white;
      box-shadow: 0 2px 8px rgba(0,0,0,0.3);
    }
    .leaflet-popup-content-wrapper {
      border-radius: 16px !important;
      box-shadow: 0 10px 30px rgba(0,0,0,0.3) !important;
    }
    .leaflet-popup-content { margin: 14px 16px !important; font-size: 13px; }
    .xp-popup-name { font-weight: 900; font-size: 14px; margin-bottom: 4px; color: #111827; }
    .xp-popup-dist { color: #f97316; font-weight: 800; font-size: 12px; }
    .xp-popup-cat  { color: #6b7280; font-size: 11px; margin-top: 2px; }
    .xp-popup-food { color: #6b7280; font-size: 11px; margin-top: 2px; }
    .xp-popup-btn {
      display: inline-flex;
      align-items: center;
      gap: 5px;
      margin-top: 10px;
      padding: 7px 14px;
      border-radius: 10px;
      background: linear-gradient(135deg, #f97316, #fbbf24);
      color: white;
      font-size: 12px;
      font-weight: 800;
      text-decoration: none;
    }

    /* LEGEND */
    #explore-nusantara .xp-legend {
      display: flex;
      align-items: center;
      gap: 16px;
      flex-wrap: wrap;
      font-size: 12px;
      color: var(--muted);
      font-weight: 700;
      padding: 10px 18px;
      border-top: 1px solid rgba(249,115,22,0.1);
    }
    #explore-nusantara .xp-legend-item {
      display: flex;
      align-items: center;
      gap: 6px;
    }
    #explore-nusantara .xp-legend-dot {
      width: 10px;
      height: 10px;
      border-radius: 50%;
      border: 2px solid rgba(255,255,255,0.8);
      box-shadow: 0 1px 4px rgba(0,0,0,0.2);
    }

    /* RESPONSIVE */
    @media (max-width: 768px) {
      #explore-nusantara .xp-activate-card { padding: 2rem 1.25rem; }
      #explore-nusantara .xp-card-title { font-size: 1.4rem; }
      #explore-nusantara .xp-list-body { max-height: 320px; }
    }
  </style>

  <h2 class="neon-title scroll-reveal reveal-fade-up">Jelajah Destinasi Nusantara</h2>
  <div class="title-decoration scroll-reveal reveal-fade-up delay-100"></div>
  <p class="neon-subtitle scroll-reveal reveal-fade-up delay-150">
    Temukan museum, wisata budaya, dan kuliner tradisional Indonesia terdekat dari lokasimu secara realtime. 
    Aktifkan GPS dan mulai petualangan budaya Nusantara!
  </p>

  <div class="xp-wrap">

    {{-- ===== GPS ACTIVATION CARD ===== --}}
    <div class="xp-activate-card scroll-reveal reveal-fade-up delay-200" id="xpActivateCard">

      {{-- Kompas animasi --}}
      <div class="xp-compass-wrap">
        <div class="xp-compass-ring">
          <svg width="38" height="38" viewBox="0 0 24 24" fill="none" stroke="#f97316" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <circle cx="12" cy="12" r="10"/>
            <polygon points="16.24 7.76 14.12 14.12 7.76 16.24 9.88 9.88 16.24 7.76" fill="rgba(249,115,22,0.3)" stroke="#f97316"/>
          </svg>
        </div>
      </div>

      <h3 class="xp-card-title">Aktifkan Peta Destinasi</h3>
      <p class="xp-card-desc">
        Temukan museum, tempat wisata budaya, dan kuliner tradisional berkualitas tertinggi dalam radius <strong>5 km</strong> dari posisimu saat ini. Data destinasi diperbarui secara realtime dari basis data komunitas global.
      </p>

      {{-- CTA Button --}}
      <button id="xpBtnActivate" class="xp-btn-gps" type="button">
        <div id="xpSpinner" class="xp-spinner"></div>
        <svg id="xpBtnIcon" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
          <circle cx="12" cy="12" r="3"/>
          <path d="M12 2v3M12 19v3M2 12h3M19 12h3"/>
          <path d="m4.93 4.93 2.12 2.12M16.95 16.95l2.12 2.12M4.93 19.07l2.12-2.12M16.95 7.05l2.12-2.12"/>
        </svg>
        <span id="xpBtnText">Aktifkan GPS & Tampilkan Peta</span>
      </button>

      {{-- Status chips --}}
      <div class="xp-status-chips">
        <div class="xp-chip">
          <div class="xp-chip-dot"></div>
          Museum & Warisan
        </div>
        <div class="xp-chip">
          <div class="xp-chip-dot"></div>
          Wisata Budaya
        </div>
        <div class="xp-chip">
          <div class="xp-chip-dot"></div>
          Kuliner Tradisional
        </div>
      </div>

      {{-- Error message (hidden by default) --}}
      <div class="xp-error-card" id="xpErrorCard">
        <div style="font-size: 1.5rem; margin-bottom: 0.5rem;">⚠️</div>
        <div style="font-weight: 900; color: #ef4444; margin-bottom: 0.4rem;" id="xpErrorTitle">GPS Tidak Tersedia</div>
        <div style="font-size: 0.9rem; color: var(--muted);" id="xpErrorMsg">Pastikan izin lokasi browser diaktifkan, lalu coba lagi.</div>
      </div>
    </div>

    {{-- ===== MAIN EXPLORER PANEL (MAP + LIST) ===== --}}
    <div class="xp-explorer" id="xpExplorer">

      {{-- MAP SIDE --}}
      <div class="xp-map-card">
        <div class="xp-map-header">
          <div class="xp-map-title-group">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#f97316" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
              <polygon points="3 11 22 2 13 21 11 13 3 11"/>
            </svg>
            <div>
              <div class="xp-map-title">Peta Destinasi Nusantara</div>
              <div class="xp-map-coords" id="xpCoords">Memuat koordinat…</div>
            </div>
          </div>
          <div class="flex items-center gap-2">
            <label for="xpRadiusSelect" class="text-xs font-bold text-amber-500" style="color: #f97316;">Radius:</label>
            <select id="xpRadiusSelect" class="xp-radius-select">
              <option value="10000" selected>10 km</option>
              <option value="20000">20 km</option>
              <option value="30000">30 km</option>
              <option value="40000">40 km</option>
              <option value="50000">50 km</option>
            </select>
          </div>
        </div>

        <div id="xp-map"></div>

        <div class="xp-legend">
          <span style="font-weight: 800; color: var(--txt-body); margin-right: 4px;">Legenda:</span>
          <div class="xp-legend-item">
            <div class="xp-legend-dot" style="background:#3b82f6;"></div>
            <span>Lokasi Kamu</span>
          </div>
          <div class="xp-legend-item">
            <div class="xp-legend-dot" style="background:#f97316;"></div>
            <span>Museum</span>
          </div>
          <div class="xp-legend-item">
            <div class="xp-legend-dot" style="background:#fbbf24;"></div>
            <span>Wisata</span>
          </div>
          <div class="xp-legend-item">
            <div class="xp-legend-dot" style="background:#ef4444;"></div>
            <span>Kuliner</span>
          </div>
        </div>
      </div>

      {{-- LIST SIDE --}}
      <div class="xp-list-card">
        <div class="xp-list-header">
          <div class="xp-list-title">
            Destinasi Terdekat
            <span class="xp-count-badge" id="xpCount">0</span>
          </div>

          {{-- Filter tabs --}}
          <div class="xp-tabs">
            <button class="xp-tab is-active" data-filter="all" type="button">Semua</button>
            <button class="xp-tab" data-filter="museum" type="button">🏛️ Museum</button>
            <button class="xp-tab" data-filter="wisata" type="button">🎭 Wisata</button>
            <button class="xp-tab" data-filter="kuliner" type="button">🍽️ Kuliner</button>
          </div>
        </div>

        <div class="xp-list-body" id="xpDestList">
          {{-- Loading skeleton --}}
          <div class="xp-skeleton" id="xpSkeleton">
            <div style="font-size: 1.5rem; margin-bottom: 0.8rem;">🔍</div>
            <div style="font-weight: 700; margin-bottom: 0.5rem; color: var(--txt-body);">Mencari destinasi…</div>
            <div class="xp-skel-bar" style="width: 85%;"></div>
            <div class="xp-skel-bar" style="width: 70%;"></div>
            <div class="xp-skel-bar" style="width: 80%;"></div>
          </div>
        </div>
      </div>
    </div>

  </div>

  {{-- Leaflet JS --}}
  <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV/XN/WPeM=" crossorigin=""></script>

  <script>
  (() => {
    // =========================================================
    // GUARD: jangan double init
    // =========================================================
    if (window.__LENTARA_EXPLORER_INIT__) return;
    window.__LENTARA_EXPLORER_INIT__ = true;

    // =========================================================
    // DOM REFS
    // =========================================================
    const btnActivate   = document.getElementById('xpBtnActivate');
    const btnIcon       = document.getElementById('xpBtnIcon');
    const btnText       = document.getElementById('xpBtnText');
    const spinner       = document.getElementById('xpSpinner');
    const activateCard  = document.getElementById('xpActivateCard');
    const explorer      = document.getElementById('xpExplorer');
    const coordsEl      = document.getElementById('xpCoords');
    const destList      = document.getElementById('xpDestList');
    const skeleton      = document.getElementById('xpSkeleton');
    const countBadge    = document.getElementById('xpCount');
    const errorCard     = document.getElementById('xpErrorCard');
    const errorTitle    = document.getElementById('xpErrorTitle');
    const errorMsg      = document.getElementById('xpErrorMsg');

    // =========================================================
    // STATE
    // =========================================================
    let map = null;
    let userMarker = null;
    let radiusCircle = null;
    let destMarkers = [];
    let allDestinations = [];
    let activeFilter = 'all';
    let userLat = null, userLng = null;
    let watchId = null;
    let lastQueryLat = null, lastQueryLng = null;

    let SEARCH_RADIUS_M = 10000; // default 10km (adjustable 10-50km)

    function isBatakRegion(lat, lng) {
      // Koordinat wilayah Sumatera Utara / Toba / Samosir / Tapanuli
      return lat >= 1.0 && lat <= 3.5 && lng >= 98.0 && lng <= 100.0;
    }

    // =========================================================
    // HAVERSINE DISTANCE (meter)
    // =========================================================
    function haversine(lat1, lon1, lat2, lon2) {
      const R = 6371000;
      const dLat = (lat2 - lat1) * Math.PI / 180;
      const dLon = (lon2 - lon1) * Math.PI / 180;
      const a = Math.sin(dLat/2)**2 + Math.cos(lat1*Math.PI/180)*Math.cos(lat2*Math.PI/180)*Math.sin(dLon/2)**2;
      return R * 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1-a));
    }

    function fmtDist(m) {
      if (m < 1000) return Math.round(m) + ' m';
      return (m/1000).toFixed(1) + ' km';
    }

    // =========================================================
    // LEAFLET MAP INIT
    // =========================================================
    function initMap(lat, lng) {
      if (map) return;

      const isDark = document.documentElement.getAttribute('data-theme') === 'dark';

      map = L.map('xp-map', {
        zoomControl: true,
        scrollWheelZoom: false,
      }).setView([lat, lng], 14);

      // Tile layer — CartoDB Positron (terang) atau Dark Matter (gelap)
      const tileUrl = isDark
        ? 'https://{s}.basemaps.cartocdn.com/dark_all/{z}/{x}/{y}{r}.png'
        : 'https://{s}.basemaps.cartocdn.com/light_all/{z}/{x}/{y}{r}.png';

      L.tileLayer(tileUrl, {
        attribution: '&copy; <a href="https://openstreetmap.org/copyright">OpenStreetMap</a> contributors &copy; <a href="https://carto.com/attributions">CARTO</a>',
        subdomains: 'abcd',
        maxZoom: 19,
      }).addTo(map);

      placeUserMarker(lat, lng);
    }

    function placeUserMarker(lat, lng) {
      if (!map) return;

      // User marker (biru, pulsa)
      const userIcon = L.divIcon({
        className: '',
        html: '<div class="xp-marker-user"></div>',
        iconSize: [20, 20],
        iconAnchor: [10, 10],
      });

      if (userMarker) {
        userMarker.setLatLng([lat, lng]);
      } else {
        userMarker = L.marker([lat, lng], { icon: userIcon, zIndexOffset: 1000, draggable: true })
          .addTo(map)
          .bindPopup('<div class="xp-popup-name">📍 Lokasi Kamu (Geser pin untuk memindahkan)</div>');

        userMarker.on('dragend', async (e) => {
          const newLatLng = e.target.getLatLng();
          const newLat = newLatLng.lat;
          const newLng = newLatLng.lng;
          userLat = newLat;
          userLng = newLng;
          coordsEl.textContent = `${newLat.toFixed(5)}, ${newLng.toFixed(5)}`;
          if (radiusCircle) radiusCircle.setLatLng([newLat, newLng]);

          // Reverse geocode place name
          try {
            const geoUrl = `https://nominatim.openstreetmap.org/reverse?format=jsonv2&lat=${newLat}&lon=${newLng}`;
            const geoRes = await fetch(geoUrl);
            if (geoRes.ok) {
              const geoData = await geoRes.json();
              const placeName = geoData.display_name || geoData.name || '';
              if (placeName) {
                coordsEl.innerHTML = `📍 ${placeName} (${newLat.toFixed(5)}, ${newLng.toFixed(5)})`;
              }
            }
          } catch (err) {
            console.warn('Drag reverse geocoding failed:', err);
          }

          // Fetch new destinations
          skeleton.style.display = 'flex';
          const newDests = await fetchDestinations(newLat, newLng);
          allDestinations = newDests;
          skeleton.style.display = 'none';

          if (allDestinations.length === 0) {
            destList.innerHTML = `<div class="xp-empty"><div class="xp-empty-icon">🔍</div><div>Tidak ditemukan destinasi dalam radius</div></div>`;
            countBadge.textContent = '0';
          } else {
            renderList(allDestinations);
            renderMarkers(allDestinations);
          }
        });
      }

      if (radiusCircle) {
        radiusCircle.setLatLng([lat, lng]);
      } else {
        radiusCircle = L.circle([lat, lng], {
          radius: SEARCH_RADIUS_M,
          color: 'rgba(249,115,22,0.7)',
          fillColor: 'rgba(249,115,22,0.06)',
          fillOpacity: 1,
          weight: 1.5,
          dashArray: '6 4',
        }).addTo(map);
      }
    }

    // =========================================================
    // DETEKSI MAKANAN KHAS DARI NAMA TEMPAT
    // =========================================================
    const FOOD_KEYWORDS = [
      // Batak
      { k: ['batak','karo','toba','simalungun','dairi','pakpak','nias'], label: 'Masakan Batak' },
      { k: ['babi panggang','babi bakar','babi rica','babi goreng'], label: 'Babi Panggang Karo' },
      { k: ['arsik','ikan arsik','saksang','naniura','natinombur'], label: 'Masakan Tradisional Batak' },
      { k: ['lapo','lapo ni tondong','lapo tuak'], label: 'Lapo / Rumah Makan Batak' },
      // Padang/Minang
      { k: ['padang','minang','minangkabau'], label: 'Masakan Padang/Minang' },
      { k: ['rendang','gulai','pindang'], label: 'Rendang & Gulai' },
      // Jawa
      { k: ['jawa','jogja','yogya','solo','sunda','sate','gudeg','gado'], label: 'Masakan Jawa/Sunda' },
      { k: ['nasi goreng','mi goreng','mie goreng'], label: 'Nasi/Mie Goreng' },
      // Manado/Sulawesi
      { k: ['manado','sulawesi','rica','tinoransak','cakalang'], label: 'Masakan Manado' },
      // Aceh
      { k: ['aceh','mie aceh','nasi gurih'], label: 'Masakan Aceh' },
      // Betawi/DKI
      { k: ['betawi','ketoprak','kerak telor','gado-gado'], label: 'Masakan Betawi' },
      // Umum
      { k: ['warung','rumah makan','rm ','r.m.','nasi','bakso','soto','pempek','seafood laut'], label: 'Kuliner Tradisional' },
    ];

    function detectFoodLabel(name, cuisineTag) {
      if (cuisineTag) {
        const c = cuisineTag.toLowerCase();
        if (c.includes('batak') || c.includes('karo') || c.includes('toba')) return 'Masakan Batak';
        if (c.includes('padang') || c.includes('minang')) return 'Masakan Padang/Minang';
        if (c.includes('javanese') || c.includes('sundanese')) return 'Masakan Jawa/Sunda';
        if (c.includes('indonesian') || c.includes('local')) return 'Masakan Indonesia';
        return cuisineTag.replace(/_/g, ' ');
      }
      const nameLow = (name || '').toLowerCase();
      for (const entry of FOOD_KEYWORDS) {
        for (const kw of entry.k) {
          if (nameLow.includes(kw)) return entry.label;
        }
      }
      return null;
    }

    // =========================================================
    // LOCAL DB DESTINATIONS FETCH
    // =========================================================
    async function fetchDbDestinations(lat, lng) {
      const dbDests = [];
      try {
        const dbRes = await fetch('/api/destinations');
        if (dbRes.ok) {
          const dbData = await dbRes.json();
          dbData.forEach(dest => {
            const dist = haversine(lat, lng, dest.latitude, dest.longitude);
            if (dist <= SEARCH_RADIUS_M) {
              dbDests.push({
                id: dest.id,
                name: dest.name,
                lat: dest.latitude,
                lng: dest.longitude,
                dist: dist,
                cat: dest.category || 'wisata',
                rating: dest.rating,
                foodLabel: 'Destinasi Terdaftar Budaya',
                opening: null,
                phone: null,
                website: dest.pano_maps_url || null,
                addr: dest.location,
                is_db: true
              });
            }
          });
        }
      } catch (e) {
        console.warn('Failed to fetch local DB destinations:', e);
      }
      return dbDests;
    }

    // =========================================================
    // OVERPASS API — QUERY LUAS (SEMUA RESTORAN + WISATA + MUSEUM)
    // =========================================================
    async function fetchDestinations(lat, lng) {
      lastQueryLat = lat;
      lastQueryLng = lng;

      const dbDests = await fetchDbDestinations(lat, lng);

      // Query luas: SEMUA restoran tanpa filter cuisine + museum + wisata
      // Overpass union: node + way tiap kategori
      const query = `
[out:json][timeout:30];
(
  node["tourism"="museum"](around:${SEARCH_RADIUS_M},${lat},${lng});
  way["tourism"="museum"](around:${SEARCH_RADIUS_M},${lat},${lng});
  relation["tourism"="museum"](around:${SEARCH_RADIUS_M},${lat},${lng});

  node["historic"](around:${SEARCH_RADIUS_M},${lat},${lng});
  way["historic"](around:${SEARCH_RADIUS_M},${lat},${lng});

  node["tourism"~"^(attraction|artwork|gallery|viewpoint|theme_park|zoo|aquarium)$"](around:${SEARCH_RADIUS_M},${lat},${lng});
  way["tourism"~"^(attraction|gallery|theme_park|zoo)$"](around:${SEARCH_RADIUS_M},${lat},${lng});

  node["amenity"~"^(restaurant|cafe|fast_food|food_court|bar)$"](around:${SEARCH_RADIUS_M},${lat},${lng});
  way["amenity"~"^(restaurant|cafe|fast_food|food_court)$"](around:${SEARCH_RADIUS_M},${lat},${lng});
);
out center 100;
`;

      try {
        const res = await fetch('https://overpass-api.de/api/interpreter', {
          method: 'POST',
          body: 'data=' + encodeURIComponent(query),
          headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
          signal: AbortSignal.timeout(32000),
        });

        if (!res.ok) throw new Error(`Overpass HTTP ${res.status}`);

        const data = await res.json();
        console.log('[Explorer] Overpass elements:', data.elements.length);
        const osmDests = parseOverpassResults(data.elements, lat, lng);
        const merged = [...dbDests, ...osmDests];
        return merged.sort((a, b) => a.dist - b.dist).slice(0, 50);
      } catch (err) {
        console.warn('[Explorer] Overpass error:', err.message);
        // Fallback: coba Overpass mirror
        const osmDests = await fetchViaMirror(lat, lng);
        const merged = [...dbDests, ...osmDests];
        return merged.sort((a, b) => a.dist - b.dist).slice(0, 50);
      }
    }

    // Fallback: Overpass mirror lain
    async function fetchViaMirror(lat, lng) {
      const query = `[out:json][timeout:25];(node["amenity"~"^(restaurant|cafe|fast_food)$"](around:${SEARCH_RADIUS_M},${lat},${lng});way["amenity"~"^(restaurant|cafe)$"](around:${SEARCH_RADIUS_M},${lat},${lng});node["tourism"="museum"](around:${SEARCH_RADIUS_M},${lat},${lng});node["historic"](around:${SEARCH_RADIUS_M},${lat},${lng}););out center 80;`;
      try {
        const res = await fetch('https://maps.mail.ru/osm/tools/overpass/api/interpreter', {
          method: 'POST',
          body: 'data=' + encodeURIComponent(query),
          headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
          signal: AbortSignal.timeout(28000),
        });
        if (!res.ok) throw new Error('Mirror juga gagal');
        const data = await res.json();
        return parseOverpassResults(data.elements, lat, lng);
      } catch (e) {
        console.warn('[Explorer] Mirror error:', e.message);
        return [];
      }
    }

    function parseOverpassResults(elements, userLat, userLng) {
      const seen = new Set();
      const results = [];

      for (const el of elements) {
        // Coba semua varian nama
        const name = el.tags?.name
          || el.tags?.['name:id']
          || el.tags?.['name:en']
          || el.tags?.['name:local'];
        if (!name || name.trim() === '') continue;

        // Deduplicate berdasarkan koordinat round (hindari duplikat node+way)
        const lat = el.lat ?? el.center?.lat;
        const lng = el.lon ?? el.center?.lon;
        if (!lat || !lng) continue;

        const coordKey = `${lat.toFixed(4)},${lng.toFixed(4)}`;
        if (seen.has(coordKey)) continue;
        seen.add(coordKey);

        const dist = haversine(userLat, userLng, lat, lng);
        const cat  = classifyCategory(el.tags);

        // Rating: dari stars atau rating tag
        const ratingRaw = el.tags?.stars || el.tags?.['rating'] || el.tags?.['review:rating'] || null;
        const rating = ratingRaw ? parseFloat(ratingRaw) : null;

        // Makanan: deteksi dari nama + tag cuisine
        const rawCuisine = el.tags?.cuisine || null;
        let foodLabel = detectFoodLabel(name, rawCuisine);

        // Jika berada di wilayah Batak (Toba, Samosir, dll), rekomendasikan masakan khas Batak secara dinamis
        if (isBatakRegion(userLat, userLng) && cat === 'kuliner') {
          const nameLow = name.toLowerCase();
          if (nameLow.includes('lapo') || nameLow.includes('bpk') || nameLow.includes('babi') || nameLow.includes('panggang') || nameLow.includes('karo') || nameLow.includes('toba') || nameLow.includes('saksang') || nameLow.includes('arsik') || (rawCuisine && (rawCuisine.includes('batak') || rawCuisine.includes('karo') || rawCuisine.includes('toba')))) {
            foodLabel = 'Masakan Batak (Menu Khas: Babi Panggang Karo, Saksang, Naniura, Arsik Ikan Mas)';
          } else if (nameLow.includes('kopi') || nameLow.includes('cafe') || nameLow.includes('warkop') || nameLow.includes('bakmi') || nameLow.includes('mie') || nameLow.includes('gomak') || nameLow.includes('kedai')) {
            foodLabel = 'Kuliner Lokal Batak (Menu: Mie Gomak, Lappet, Kopi Sihiong)';
          } else if (nameLow.includes('warung') || nameLow.includes('rumah makan') || nameLow.includes('rm ') || nameLow.includes('r.m.')) {
            if (!nameLow.includes('padang') && !nameLow.includes('minang') && !nameLow.includes('rodabaru')) {
              foodLabel = 'Kuliner Tradisional Toba (Sedia: Arsik Ikan Mas, Mie Gomak, Lappet)';
            }
          } else {
            if (!nameLow.includes('padang') && !nameLow.includes('minang') && !nameLow.includes('rodabaru')) {
              foodLabel = 'Kuliner Lokal (Menu Khas Batak: Mie Gomak, Lappet, Arsik)';
            }
          }
        }

        const opening = el.tags?.opening_hours || null;
        const phone = el.tags?.phone || el.tags?.['contact:phone'] || null;
        const website = el.tags?.website || el.tags?.['contact:website'] || null;
        const addr = el.tags?.['addr:full'] || el.tags?.['addr:street'] || null;

        results.push({
          id: el.id,
          name: name.trim(),
          lat, lng, dist, cat,
          rating, foodLabel, opening, phone, website, addr,
          tags: el.tags,
        });
      }

      // Sort by distance, ambil maks 50 terdekat
      return results.sort((a, b) => a.dist - b.dist).slice(0, 50);
    }

    function classifyCategory(tags) {
      if (!tags) return 'wisata';
      if (tags.tourism === 'museum') return 'museum';
      if (tags.historic) return 'museum'; // monument, ruins, castle, dll → museum
      if (tags.amenity === 'restaurant' || tags.amenity === 'cafe'
        || tags.amenity === 'fast_food' || tags.amenity === 'food_court'
        || tags.amenity === 'bar') return 'kuliner';
      if (tags.tourism) return 'wisata';
      return 'wisata';
    }

    // =========================================================
    // RENDER MARKERS ON MAP
    // =========================================================
    function renderMarkers(destinations) {
      // Clear old markers
      destMarkers.forEach(m => map.removeLayer(m));
      destMarkers = [];

      destinations.forEach(dest => {
        const colorClass = dest.cat === 'museum' ? 'xp-marker-museum'
          : dest.cat === 'kuliner' ? 'xp-marker-kuliner'
          : 'xp-marker-wisata';

        const emoji = dest.cat === 'museum' ? '🏛️' : dest.cat === 'kuliner' ? '🍽️' : '🎭';

        const icon = L.divIcon({
          className: '',
          html: `<div class="${colorClass}"></div>`,
          iconSize: [14, 14],
          iconAnchor: [7, 7],
        });

        const popup = `
          <div class="xp-popup-name">${emoji} ${dest.name}</div>
          <div class="xp-popup-dist">📏 ${fmtDist(dest.dist)}</div>
          <div class="xp-popup-cat">${dest.cat.charAt(0).toUpperCase() + dest.cat.slice(1)}</div>
          ${dest.foodLabel ? `<div class="xp-popup-food">🍴 ${dest.foodLabel}</div>` : ''}
          ${dest.addr ? `<div class="xp-popup-cat">📍 ${dest.addr}</div>` : ''}
          ${dest.opening ? `<div class="xp-popup-cat">🕒 ${dest.opening}</div>` : ''}
          <a href="https://www.google.com/maps?q=${dest.lat},${dest.lng}" target="_blank" rel="noopener" class="xp-popup-btn">
            <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M18 13v6a2 2 0 01-2 2H5a2 2 0 01-2-2V8a2 2 0 012-2h6"/><polyline points="15 3 21 3 21 9"/><line x1="10" y1="14" x2="21" y2="3"/></svg>
            Buka di Maps
          </a>
        `;

        const marker = L.marker([dest.lat, dest.lng], { icon })
          .addTo(map)
          .bindPopup(popup, { maxWidth: 220 });

        // Click: highlight list item
        marker.on('click', () => {
          const item = document.querySelector(`[data-dest-id="${dest.id}"]`);
          if (item) {
            item.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
            item.style.background = 'rgba(249,115,22,0.2)';
            setTimeout(() => { item.style.background = ''; }, 1500);
          }
        });

        dest._marker = marker;
        destMarkers.push(marker);
      });
    }

    // =========================================================
    // RENDER DESTINATION LIST
    // =========================================================
    function renderList(destinations) {
      // Filter
      const filtered = activeFilter === 'all'
        ? destinations
        : destinations.filter(d => d.cat === activeFilter);

      countBadge.textContent = filtered.length;

      if (filtered.length === 0) {
        destList.innerHTML = `
          <div class="xp-empty">
            <div class="xp-empty-icon">🔍</div>
            <div style="font-weight:700;color:var(--txt-body);margin-bottom:4px;">Tidak ditemukan</div>
            <div style="font-size:0.85rem;">Coba filter lain atau perluas area pencarian</div>
          </div>
        `;
        return;
      }

      destList.innerHTML = filtered.map(dest => {
        const emoji = dest.cat === 'museum' ? '🏛️' : dest.cat === 'kuliner' ? '🍽️' : '🎭';
        const catLabel = dest.cat === 'museum' ? 'Museum' : dest.cat === 'kuliner' ? 'Kuliner' : 'Wisata';
        const iconClass = dest.cat === 'museum' ? 'xp-cat-museum' : dest.cat === 'kuliner' ? 'xp-cat-kuliner' : 'xp-cat-wisata';

        const starsHtml = dest.rating
          ? `<span class="xp-dest-rating">⭐ ${dest.rating.toFixed(1)}</span>`
          : '';

        const foodHtml = dest.foodLabel
          ? `<div class="xp-dest-food">🍴 ${dest.foodLabel}</div>`
          : '';

        const addrHtml = dest.addr
          ? `<div class="xp-dest-food" style="color:var(--muted);">📍 ${dest.addr}</div>`
          : '';

        return `
          <div class="xp-dest-item" data-dest-id="${dest.id}" data-lat="${dest.lat}" data-lng="${dest.lng}" onclick="window.__xpFlyTo(${dest.lat}, ${dest.lng}, ${dest.id})">
            <div class="xp-dest-icon ${iconClass}">${emoji}</div>
            <div class="xp-dest-info">
              <div class="xp-dest-name" title="${dest.name}">${dest.name}</div>
              <div class="xp-dest-meta">
                <span class="xp-dest-dist">📏 ${fmtDist(dest.dist)}</span>
                <span class="xp-dest-cat">${catLabel}</span>
                ${starsHtml}
              </div>
              ${foodHtml}
              ${addrHtml}
            </div>
            <a href="https://www.google.com/maps?q=${dest.lat},${dest.lng}" target="_blank" rel="noopener" class="xp-dest-openmap" title="Buka di Google Maps" onclick="event.stopPropagation()">
              <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                <path d="M18 13v6a2 2 0 01-2 2H5a2 2 0 01-2-2V8a2 2 0 012-2h6"/>
                <polyline points="15 3 21 3 21 9"/>
                <line x1="10" y1="14" x2="21" y2="3"/>
              </svg>
            </a>
          </div>
        `;
      }).join('');
    }

    // Global helper: fly to marker
    window.__xpFlyTo = function(lat, lng, destId) {
      if (!map) return;
      map.flyTo([lat, lng], 16, { duration: 1.0 });
      // Open popup after fly
      setTimeout(() => {
        const dest = allDestinations.find(d => d.id === destId);
        if (dest && dest._marker) dest._marker.openPopup();
      }, 1100);
    };

    // =========================================================
    // SHOW EXPLORER (after GPS obtained)
    // =========================================================
    async function showExplorer(lat, lng) {
      userLat = lat;
      userLng = lng;

      coordsEl.textContent = `${lat.toFixed(5)}, ${lng.toFixed(5)}`;

      // Reverse geocode place name to verify location exists
      try {
        const geoUrl = `https://nominatim.openstreetmap.org/reverse?format=jsonv2&lat=${lat}&lon=${lng}`;
        const geoRes = await fetch(geoUrl);
        if (geoRes.ok) {
          const geoData = await geoRes.json();
          const placeName = geoData.display_name || geoData.name || '';
          if (placeName) {
            coordsEl.innerHTML = `📍 ${placeName} (${lat.toFixed(5)}, ${lng.toFixed(5)})`;
          }
        }
      } catch (err) {
        console.warn('Reverse geocoding failed:', err);
      }

      // Show explorer panel
      explorer.classList.add('is-visible');

      // Init map if first time
      if (!map) {
        initMap(lat, lng);
      } else {
        placeUserMarker(lat, lng);
        map.setView([lat, lng], 14);
      }

      // Skeleton shown while fetching
      skeleton.style.display = 'flex';
      skeleton.style.flexDirection = 'column';
      skeleton.style.alignItems = 'center';

      // Fetch destinations
      const destinations = await fetchDestinations(lat, lng);
      allDestinations = destinations;

      // Remove skeleton
      skeleton.style.display = 'none';

      if (destinations.length === 0) {
        destList.innerHTML = `
          <div class="xp-empty">
            <div class="xp-empty-icon">🌏</div>
            <div style="font-weight:700;color:var(--txt-body);margin-bottom:4px;">Belum ada data destinasi</div>
            <div style="font-size:0.85rem;color:var(--muted);">Mungkin jaringan terbatas atau area ini belum terpetakan. Coba lagi nanti.</div>
          </div>
        `;
        countBadge.textContent = '0';
      } else {
        renderList(destinations);
        renderMarkers(destinations);
      }

      // Scroll to explorer
      setTimeout(() => {
        explorer.scrollIntoView({ behavior: 'smooth', block: 'start' });
      }, 300);
    }

    // =========================================================
    // GEOLOCATION
    // =========================================================
    function startLoading() {
      spinner.style.display = 'block';
      btnIcon.style.display = 'none';
      btnText.textContent = 'Mendeteksi lokasi…';
      btnActivate.disabled = true;
      errorCard.classList.remove('is-visible');
    }

    function stopLoading() {
      spinner.style.display = 'none';
      btnIcon.style.display = 'block';
      btnActivate.disabled = false;
    }

    function showError(title, msg) {
      stopLoading();
      errorTitle.textContent = title;
      errorMsg.textContent = msg;
      errorCard.classList.add('is-visible');
    }

    btnActivate.addEventListener('click', () => {
      if (!navigator.geolocation) {
        showError('GPS Tidak Didukung', 'Browser kamu tidak mendukung Geolocation API. Coba gunakan Chrome atau Firefox versi terbaru.');
        return;
      }

      startLoading();

      navigator.geolocation.getCurrentPosition(
        async (pos) => {
          stopLoading();
          btnText.textContent = 'GPS Aktif ✓';
          btnActivate.style.background = 'linear-gradient(135deg, #16a34a, #22c55e)';

          const { latitude: lat, longitude: lng } = pos.coords;
          await showExplorer(lat, lng);

          // Watch position for realtime updates
          if (watchId) navigator.geolocation.clearWatch(watchId);
          watchId = navigator.geolocation.watchPosition(
            async (newPos) => {
              const newLat = newPos.coords.latitude;
              const newLng = newPos.coords.longitude;
              userLat = newLat;
              userLng = newLng;
              coordsEl.textContent = `${newLat.toFixed(5)}, ${newLng.toFixed(5)}`;
              placeUserMarker(newLat, newLng);

              // Update distances on list
              allDestinations.forEach(d => {
                d.dist = haversine(newLat, newLng, d.lat, d.lng);
              });
              allDestinations.sort((a, b) => a.dist - b.dist);
              renderList(allDestinations);

              // Re-query if moved > 500m
              if (lastQueryLat !== null) {
                const moved = haversine(newLat, newLng, lastQueryLat, lastQueryLng);
                if (moved > 500) {
                  const newDests = await fetchDestinations(newLat, newLng);
                  allDestinations = newDests;
                  renderList(allDestinations);
                  renderMarkers(allDestinations);
                }
              }
            },
            null,
            { enableHighAccuracy: true, maximumAge: 10000 }
          );
        },
        (err) => {
          let title = 'Lokasi Tidak Tersedia';
          let msg = 'Terjadi kesalahan saat mengakses GPS.';
          if (err.code === 1) {
            title = 'Izin Ditolak';
            msg = 'Kamu menolak akses lokasi. Aktifkan izin lokasi di pengaturan browser lalu coba lagi.';
          } else if (err.code === 2) {
            title = 'Lokasi Tidak Tersedia';
            msg = 'GPS tidak bisa mendapatkan lokasi. Pastikan perangkat memiliki sinyal GPS yang baik.';
          } else if (err.code === 3) {
            title = 'Waktu Habis';
            msg = 'GPS memerlukan waktu terlalu lama. Pastikan GPS aktif dan coba lagi.';
          }
          showError(title, msg);
        },
        { enableHighAccuracy: true, timeout: 12000, maximumAge: 30000 }
      );
    });

    // =========================================================
    // RADIUS SELECT CHANGE
    // =========================================================
    const radiusSelect = document.getElementById('xpRadiusSelect');
    if (radiusSelect) {
      radiusSelect.addEventListener('change', async (e) => {
        SEARCH_RADIUS_M = parseInt(e.target.value, 10);
        if (radiusCircle) {
          radiusCircle.setRadius(SEARCH_RADIUS_M);
        }
        if (userLat !== null && userLng !== null) {
          skeleton.style.display = 'flex';
          const newDests = await fetchDestinations(userLat, userLng);
          allDestinations = newDests;
          skeleton.style.display = 'none';

          if (allDestinations.length === 0) {
            destList.innerHTML = `
              <div class="xp-empty">
                <div class="xp-empty-icon">🔍</div>
                <div style="font-weight:700;color:var(--txt-body);margin-bottom:4px;">Tidak ditemukan</div>
                <div style="font-size:0.85rem;">Coba filter lain atau perluas area pencarian</div>
              </div>
            `;
            countBadge.textContent = '0';
          } else {
            renderList(allDestinations);
            renderMarkers(allDestinations);
          }
        }
      });
    }

    // =========================================================
    // FILTER TABS
    // =========================================================
    document.querySelectorAll('#explore-nusantara .xp-tab').forEach(tab => {
      tab.addEventListener('click', () => {
        document.querySelectorAll('#explore-nusantara .xp-tab').forEach(t => t.classList.remove('is-active'));
        tab.classList.add('is-active');
        activeFilter = tab.dataset.filter;
        renderList(allDestinations);
      });
    });

    // =========================================================
    // THEME CHANGE → REMAP TILES
    // =========================================================
    const themeObserver = new MutationObserver(() => {
      if (!map) return;
      const isDark = document.documentElement.getAttribute('data-theme') === 'dark';
      const tileUrl = isDark
        ? 'https://{s}.basemaps.cartocdn.com/dark_all/{z}/{x}/{y}{r}.png'
        : 'https://{s}.basemaps.cartocdn.com/light_all/{z}/{x}/{y}{r}.png';
      map.eachLayer(layer => {
        if (layer instanceof L.TileLayer) map.removeLayer(layer);
      });
      L.tileLayer(tileUrl, {
        attribution: '&copy; OpenStreetMap contributors &copy; CARTO',
        subdomains: 'abcd',
        maxZoom: 19,
      }).addTo(map);
    });
    themeObserver.observe(document.documentElement, { attributes: true, attributeFilter: ['data-theme'] });

  })();
  </script>

</section>

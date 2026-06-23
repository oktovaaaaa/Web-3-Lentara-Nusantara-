{{-- resources/views/partials/camera-ar.blade.php --}}
<section id="camera-ar" class="py-12 bg-[var(--bg-body)]">
  <h2 class="neon-title scroll-reveal reveal-fade-up">AR Kamera Nusantara</h2>
  <div class="title-decoration scroll-reveal reveal-fade-up delay-100"></div>
  <p class="neon-subtitle scroll-reveal reveal-fade-up delay-150">
    Gunakan kamera untuk mengenal warisan budaya Nusantara secara visual melalui filter 3D bertema penutup kepala dan
    atribut tradisional dari berbagai daerah di Indonesia. Fitur ini menghadirkan pengalaman interaktif yang memadukan
    teknologi realitas tertambah dengan identitas budaya.
  </p>


  {{-- Importmap --}}
  <script type="importmap">
    {
      "imports": {
        "three": "https://unpkg.com/three@0.159.0/build/three.module.js",
        "three/addons/": "https://unpkg.com/three@0.159.0/examples/jsm/"
      }
    }
    </script>

  <style>
    /* =========================================================
           ORANGE NEON THEME - AR CAMERA
        ========================================================= */
    @property --neon-orange-angle {
      syntax: "<angle>";
      inherits: false;
      initial-value: 0deg;
    }

    /* ================= MAIN LAYOUT ================= */
    #camera-ar .ar-wrap {
      max-width: 1100px;
      margin: 0 auto;
    }

    #camera-ar .ar-grid {
      display: grid;
      grid-template-columns: 1.2fr 0.8fr;
      gap: 32px;
    }

    @media (max-width: 1024px) {
      #camera-ar .ar-grid {
        grid-template-columns: 1fr;
        gap: 24px;
      }
    }

    /* Traditional Gold Corner Accents */
    #camera-ar .q-corner {
      position: absolute !important;
      width: 60px;
      height: 60px;
      pointer-events: none;
      z-index: 10 !important;
      opacity: 0.95;
      filter: drop-shadow(0 2px 4px rgba(0, 0, 0, 0.3));
    }
    #camera-ar .q-corner-tl { top: -6px; left: -6px; }
    #camera-ar .q-corner-tr { top: -6px; right: -6px; transform: scaleX(-1); }

    /* ================= CARDS WITH ORANGE NEON ================= */
    #camera-ar .ar-card {
      position: relative;
      border-radius: 26px;
      padding: 20px;
      background: linear-gradient(145deg,
          color-mix(in oklab, var(--card) 85%, transparent),
          color-mix(in oklab, var(--card-bg-dark) 85%, transparent));
      overflow: hidden;
    }

    /* Dark/Light mode adjustment */
    html[data-theme="dark"] #camera-ar .ar-card {
      background: linear-gradient(145deg,
          rgba(31, 41, 55, 0.85),
          rgba(17, 24, 39, 0.85));
    }

    html[data-theme="light"] #camera-ar .ar-card {
      background: linear-gradient(145deg,
          rgba(255, 255, 255, 0.9),
          rgba(248, 250, 252, 0.9));
    }

    /* ORANGE NEON BORDER */
    #camera-ar .ar-card::before {
      content: "";
      position: absolute;
      inset: -4px;
      border-radius: 30px;
      padding: 8px;
      pointer-events: none;
      z-index: 0;

      background: conic-gradient(from var(--neon-orange-angle),
          rgba(249, 115, 22, 0) 0deg,
          rgba(249, 115, 22, 0.4) 45deg,
          #f97316 90deg,
          #fb923c 180deg,
          #f97316 270deg,
          rgba(249, 115, 22, 0.4) 315deg,
          rgba(249, 115, 22, 0) 360deg);

      -webkit-mask:
        linear-gradient(#000 0 0) content-box,
        linear-gradient(#000 0 0);
      -webkit-mask-composite: xor;
      mask-composite: exclude;

      filter: blur(8px);
      opacity: 0.7;
      animation: orange-neon-spin 8s linear infinite;
    }

    @keyframes orange-neon-spin {
      to {
        --neon-orange-angle: 360deg;
      }
    }

    #camera-ar .ar-card>* {
      position: relative;
      z-index: 1;
    }

    /* ================= CAMERA STAGE ================= */
    #camera-ar .stage {
      position: relative;
      width: 100%;
      aspect-ratio: 16/9;
      border-radius: 18px;
      overflow: hidden;
      border: 1px solid rgba(255, 255, 255, 0.1);
      background: linear-gradient(145deg,
          color-mix(in oklab, var(--card) 95%, transparent),
          color-mix(in oklab, var(--card-bg-dark) 95%, transparent));
      box-shadow: 0 20px 40px rgba(0, 0, 0, 0.3);
    }

    /* Dark/Light mode adjustment */
    html[data-theme="dark"] #camera-ar .stage {
      background: linear-gradient(145deg,
          rgba(17, 24, 39, 0.95),
          rgba(2, 6, 23, 0.95));
      border: 1px solid rgba(255, 255, 255, 0.1);
    }

    html[data-theme="light"] #camera-ar .stage {
      background: linear-gradient(145deg,
          rgba(248, 250, 252, 0.95),
          rgba(226, 232, 240, 0.95));
      border: 1px solid rgba(0, 0, 0, 0.1);
      box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
    }

    #camera-ar video {
      position: absolute;
      inset: 0;
      width: 100%;
      height: 100%;
      object-fit: cover;
      transform: scaleX(-1);
    }

    #camera-ar canvas.ar-three {
      position: absolute;
      inset: 0;
      width: 100%;
      height: 100%;
      pointer-events: none;
      transform: scaleX(-1);
    }

    /* ================= STAGE OVERLAY ================= */
    #camera-ar .stage-overlay {
      position: absolute;
      left: 16px;
      top: 16px;
      display: flex;
      gap: 12px;
      flex-wrap: wrap;
      z-index: 5;
    }

    #camera-ar .chip {
      display: inline-flex;
      align-items: center;
      gap: 8px;
      font-size: 12px;
      font-weight: 800;
      padding: 10px 16px;
      border-radius: 999px;
      border: 1px solid rgba(249, 115, 22, 0.3);
      background: color-mix(in oklab, var(--card) 85%, transparent);
      backdrop-filter: blur(12px);
      color: #ff8c42;
      box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
    }

    /* Dark/Light mode adjustment */
    html[data-theme="dark"] #camera-ar .chip {
      background: rgba(17, 24, 39, 0.85);
    }

    html[data-theme="light"] #camera-ar .chip {
      background: rgba(255, 255, 255, 0.85);
      border: 1px solid rgba(183, 65, 14, 0.3);
      color: #b7410e;
    }

    /* ================= WATERMARK TOP RIGHT (RESPONSIVE) ================= */
    /* Watermark Image Top Right */
    #camera-ar .wm-topright {
      position: absolute;
      right: 16px;
      top: 16px;
      z-index: 6;
      display: flex;
      align-items: center;
      gap: 10px;
      padding: 10px 14px;
      border-radius: 999px;
      background: color-mix(in oklab, var(--card) 85%, transparent);
      border: 1px solid rgba(249, 115, 22, 0.3);
      backdrop-filter: blur(12px);
      box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
      max-width: calc(100% - 24px);
    }

    /* Dark/Light mode adjustment */
    html[data-theme="dark"] #camera-ar .wm-topright {
      background: rgba(17, 24, 39, 0.85);
    }

    html[data-theme="light"] #camera-ar .wm-topright {
      background: rgba(255, 255, 255, 0.85);
      border: 1px solid rgba(183, 65, 14, 0.3);
    }

    #camera-ar .wm-topright img {
      width: 36px;
      height: 36px;
      object-fit: contain;
      filter: drop-shadow(0 4px 10px rgba(249, 115, 22, 0.4));
      flex: 0 0 auto;
    }

    #camera-ar .wm-topright span {
      font-size: 12px;
      font-weight: 900;
      letter-spacing: 0.04em;
      color: #f97316;
      white-space: nowrap;
    }

    /* Dark/Light mode adjustment */
    html[data-theme="light"] #camera-ar .wm-topright span {
      color: #b7410e;
    }

    /* ✅ MOBILE: hanya icon (tanpa tulisan), dan diperkecil supaya tidak menutupi konten */
    @media (max-width: 640px) {
      #camera-ar .wm-topright {
        right: 12px;
        top: 12px;
        padding: 8px 10px;
        gap: 8px;
      }

      #camera-ar .wm-topright img {
        width: 30px;
        height: 30px;
      }

      #camera-ar .wm-topright span {
        display: none !important;
      }
    }

    @media (max-width: 480px) {
      #camera-ar .wm-topright {
        right: 10px;
        top: 10px;
        padding: 7px 9px;
      }

      #camera-ar .wm-topright img {
        width: 28px;
        height: 28px;
      }
    }

    /* ================= BUTTONS ================= */
    #camera-ar .btn {
      width: 100%;
      border-radius: 16px;
      padding: 14px 16px;
      font-weight: 900;
      font-size: 15px;
      border: 0;
      color: white;
      background: linear-gradient(135deg, #f97316, #fb923c);
      box-shadow: 0 8px 24px rgba(249, 115, 22, 0.3);
      transition: all 0.3s ease;
      cursor: pointer;
    }

    #camera-ar .btn:hover {
      transform: translateY(-3px);
      filter: brightness(1.1);
      box-shadow: 0 12px 32px rgba(249, 115, 22, 0.4);
    }

    #camera-ar .btn:disabled {
      opacity: 0.5;
      cursor: not-allowed;
      transform: none;
      box-shadow: none;
    }

    #camera-ar .btn-secondary {
      background: color-mix(in oklab, var(--card) 10%, transparent);
      border: 1px solid rgba(249, 115, 22, 0.25);
      box-shadow: none;
      color: var(--txt-body);
    }

    /* Dark/Light mode adjustment */
    html[data-theme="dark"] #camera-ar .btn-secondary {
      background: rgba(255, 255, 255, 0.08);
      color: #e5e7eb;
    }

    html[data-theme="light"] #camera-ar .btn-secondary {
      background: rgba(0, 0, 0, 0.05);
      border: 1px solid rgba(183, 65, 14, 0.2);
      color: #0f172a;
    }

    #camera-ar .btn-secondary:hover {
      background: rgba(249, 115, 22, 0.15);
      border-color: rgba(249, 115, 22, 0.4);
    }

    /* ================= FILTER BAR ================= */
    #camera-ar .filter-bar {
      display: flex;
      gap: 14px;
      overflow: auto;
      padding: 12px 6px;
      scroll-snap-type: x mandatory;

      /* ===== Scrollbar ORANGE (Firefox) ===== */
      scrollbar-color: #f97316 rgba(249, 115, 22, .12);
      scrollbar-width: auto;
    }

    /* ===== Scrollbar ORANGE (Chrome/Edge/Safari) ===== */
    #camera-ar .filter-bar::-webkit-scrollbar {
      height: 12px;
      /* karena scroll horizontal */
    }

    #camera-ar .filter-bar::-webkit-scrollbar-track {
      background: rgba(249, 115, 22, .12);
      border-radius: 999px;
      border: 1px solid rgba(249, 115, 22, .18);
    }

    #camera-ar .filter-bar::-webkit-scrollbar-thumb {
      background: linear-gradient(90deg, #f97316, #fb923c);
      border-radius: 999px;
      border: 2px solid rgba(0, 0, 0, .18);
    }

    #camera-ar .filter-bar::-webkit-scrollbar-thumb:hover {
      background: linear-gradient(90deg, #fb923c, #f97316);
    }

    #camera-ar .filter-pill {
      scroll-snap-align: start;
      min-width: 100px;
      border-radius: 18px;
      border: 1px solid rgba(255, 255, 255, 0.1);
      background: color-mix(in oklab, var(--card) 5%, transparent);
      padding: 12px;
      display: flex;
      flex-direction: column;
      align-items: center;
      gap: 10px;
      cursor: pointer;
      transition: all 0.3s ease;
      user-select: none;
    }

    /* Dark/Light mode adjustment */
    html[data-theme="dark"] #camera-ar .filter-pill {
      background: rgba(255, 255, 255, 0.05);
      border: 1px solid rgba(255, 255, 255, 0.1);
    }

    html[data-theme="light"] #camera-ar .filter-pill {
      background: rgba(0, 0, 0, 0.02);
      border: 1px solid rgba(0, 0, 0, 0.08);
    }

    #camera-ar .filter-pill:hover {
      border-color: rgba(249, 115, 22, 0.4);
      background: rgba(249, 115, 22, 0.1);
      transform: translateY(-3px);
    }

    #camera-ar .filter-pill.is-active {
      border-color: #f97316;
      background: rgba(249, 115, 22, 0.15);
      box-shadow: 0 10px 25px rgba(249, 115, 22, 0.2);
    }

    #camera-ar .filter-icon {
      width: 52px;
      height: 52px;
      border-radius: 16px;
      border: 2px solid rgba(249, 115, 22, 0.3);
      background: color-mix(in oklab, var(--card) 80%, transparent);
      display: grid;
      place-items: center;
      overflow: hidden;
      transition: all 0.3s ease;
    }

    /* Dark/Light mode adjustment */
    html[data-theme="dark"] #camera-ar .filter-icon {
      background: rgba(17, 24, 39, 0.8);
    }

    html[data-theme="light"] #camera-ar .filter-icon {
      background: rgba(255, 255, 255, 0.8);
    }

    #camera-ar .filter-pill.is-active .filter-icon {
      border-color: #f97316;
      background: rgba(249, 115, 22, 0.2);
      box-shadow: 0 0 20px rgba(249, 115, 22, 0.3);
    }

    #camera-ar .filter-icon img {
      width: 32px;
      height: 32px;
      object-fit: contain;
      filter: drop-shadow(0 4px 8px rgba(0, 0, 0, 0.4));
    }

    #camera-ar .filter-name {
      font-size: 13px;
      font-weight: 900;
      color: var(--txt-body);
      text-align: center;
    }

    #camera-ar .filter-pill.is-active .filter-name {
      color: #f97316;
      text-shadow: 0 0 10px rgba(249, 115, 22, 0.5);
    }

    /* ================= PREVIEW SECTION ================= */
    #camera-ar .preview {
      width: 100%;
      border-radius: 18px;
      border: 1px solid color-mix(in oklab, var(--line) 50%, transparent);
      background: color-mix(in oklab, var(--card) 4%, transparent);
      overflow: hidden;
      min-height: 120px;
    }

    /* Dark/Light mode adjustment */
    html[data-theme="dark"] #camera-ar .preview {
      border: 1px solid rgba(255, 255, 255, 0.1);
      background: rgba(255, 255, 255, 0.04);
    }

    html[data-theme="light"] #camera-ar .preview {
      border: 1px solid rgba(0, 0, 0, 0.1);
      background: rgba(0, 0, 0, 0.02);
    }

    #camera-ar .preview img {
      width: 100%;
      height: auto;
      display: block;
    }

    /* ================= TYPOGRAPHY ================= */
    #camera-ar .muted {
      color: var(--muted);
      font-size: 13px;
      line-height: 1.6;
      margin: 0;
    }

    #camera-ar .section-title {
      font-size: 18px;
      font-weight: 900;
      color: var(--txt-body);
      margin-bottom: 16px;
      background: linear-gradient(90deg, #f97316, #fb923c);
      -webkit-background-clip: text;
      -webkit-text-fill-color: transparent;
    }

    /* Dark/Light mode adjustment for border */
    #camera-ar .border-t {
      border-top-color: color-mix(in oklab, var(--line) 50%, transparent);
    }

    /* ================= RESPONSIVE ================= */
    @media (max-width: 768px) {
      #camera-ar .ar-card {
        padding: 16px;
      }

      #camera-ar .stage-overlay {
        left: 12px;
        top: 12px;
      }

      #camera-ar .filter-pill {
        min-width: 88px;
        padding: 10px;
      }

      #camera-ar .filter-icon {
        width: 48px;
        height: 48px;
      }

      #camera-ar .btn {
        padding: 12px 14px;
        font-size: 14px;
      }
    }

    @media (max-width: 480px) {
      #camera-ar .ar-wrap {
        gap: 16px;
      }

      #camera-ar .stage {
        aspect-ratio: 4/3;
      }

      #camera-ar .chip {
        font-size: 11px;
        padding: 8px 12px;
      }
    }
  </style>

  <div class="ar-wrap">
    <div class="ar-card scroll-reveal reveal-fade-up delay-100 w-full relative">
      
      <!-- Batik Header Banner -->
      <div class="relative w-full h-16 rounded-2xl overflow-hidden mb-6 border border-amber-600/30 shadow-inner" style="background-color: #1a0f03;">
        <img src="{{ asset('images/icon/footer.JPEG') }}" class="w-full h-full object-cover opacity-90 object-center" alt="Corak Batik">
        <!-- Elegant Overlay to make the text/button legible and add depth -->
        <div class="absolute inset-0 bg-gradient-to-r from-black/50 via-transparent to-black/50"></div>
        <div class="absolute inset-0 bg-gradient-to-b from-transparent to-stone-950/30"></div>
        
        <!-- Ornate Gold Filigree Borders on the batik banner sides (matching Nusantara vibes) -->
        <div class="absolute inset-y-0 left-0 w-2 bg-gradient-to-r from-amber-500 to-transparent opacity-60"></div>
        <div class="absolute inset-y-0 right-0 w-2 bg-gradient-to-l from-amber-500 to-transparent opacity-60"></div>

        <!-- Title of the stage or a neat label on the left of the batik header -->
        <div class="absolute left-4 top-1/2 -translate-y-1/2 flex items-center gap-2">
          <span class="text-white font-serif font-bold tracking-widest text-sm uppercase drop-shadow-md">Lentara AR Nusantara</span>
        </div>

        <!-- Button Panduan overlaid on the batik header on the top-right -->
        <div style="position: absolute; right: 1rem; top: 50%; transform: translateY(-50%); z-index: 10;">
          <button id="btnOpenGuide" class="btn-secondary !w-auto !px-4 !py-2 flex items-center gap-2 rounded-xl cursor-pointer hover:bg-orange-500/20 bg-slate-900/60 backdrop-blur-md border border-orange-500/40 text-white hover:border-orange-400 transition-all duration-300" type="button">
            <svg class="w-4 h-4 text-orange-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            <span class="text-xs font-bold text-white">Panduan</span>
          </button>
        </div>
      </div>

      <div>
        {{-- CAMERA VIEW STAGE --}}
        <div class="stage" id="arStage">
          <video id="arVideo" playsinline muted autoplay></video>

          <div class="stage-overlay">
            <span class="chip" id="arStatus">Status: Siap</span>
            <span class="chip" id="arFilterName">Filter: Tidak ada</span>
          </div>

          {{-- Watermark Image Top Right --}}
          <div class="wm-topright" aria-label="Lentara Watermark">
            <img id="lentaraWatermarkImg" src="{{ asset('images/icon/icon_lentara.png') }}" alt="Lentara" loading="eager">
            <span>LENTARA AR</span>
          </div>
        </div>

        {{-- BUTTONS --}}
        <div class="mt-6 grid grid-cols-1 sm:grid-cols-3 gap-4">
          <button class="btn" id="btnStartCam" type="button">
            <span class="inline-flex items-center justify-center gap-2">
              <svg width="18" height="18" viewBox="0 0 24 24" fill="none" aria-hidden="true">
                <path d="M4 7a2 2 0 0 1 2-2h8a2 2 0 0 1 2 2v10a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V7Z" stroke="currentColor"
                  stroke-width="2" />
                <path d="M16 10l4-2v8l-4-2v-4Z" stroke="currentColor" stroke-width="2" stroke-linejoin="round" />
              </svg>
              <span>Mulai Kamera</span>
            </span>
          </button>

          <button class="btn btn-secondary" id="btnCapture" type="button" disabled>
            <span class="inline-flex items-center justify-center gap-2">
              <svg width="18" height="18" viewBox="0 0 24 24" fill="none" aria-hidden="true">
                <path d="M7 7l1.2-2h7.6L17 7h2a2 2 0 0 1 2 2v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V9a2 2 0 0 1 2-2h2Z"
                  stroke="currentColor" stroke-width="2" />
                <path d="M12 17a4 4 0 1 0 0-8 4 4 0 0 0 0 8Z" stroke="currentColor" stroke-width="2" />
              </svg>
              <span>Ambil Foto</span>
            </span>
          </button>

          <button class="btn btn-secondary" id="btnStopCam" type="button" disabled>
            <span class="inline-flex items-center justify-center gap-2">
              <svg width="18" height="18" viewBox="0 0 24 24" fill="none" aria-hidden="true">
                <path d="M7 7h10v10H7V7Z" stroke="currentColor" stroke-width="2" />
              </svg>
              <span>Hentikan</span>
            </span>
          </button>
        </div>

        {{-- FILTER BAR --}}
        <div class="mt-6 pt-4 border-t border-gray-800/40 dark:border-stone-800/40">
          <div class="flex items-center justify-between mb-3">
            <div class="section-title mb-0">Pilih Filter</div>
            <button class="btn-secondary !w-auto !px-4 !py-2" id="btnClearFilter" type="button">
              Bersihkan
            </button>
          </div>

          <div class="filter-bar mt-2" id="filterBar"></div>

          <div class="mt-4">
            <button class="btn btn-secondary" id="btnFlip" type="button" disabled>
              <span class="inline-flex items-center justify-center gap-2">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" aria-hidden="true">
                  <path d="M20 7h-6m6 0-2-2m2 2-2 2" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                    stroke-linejoin="round" />
                  <path d="M4 17h6m-6 0 2 2m-2-2 2-2" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                    stroke-linejoin="round" />
                  <path d="M18 9a7 7 0 0 0-12.3-4.7" stroke="currentColor" stroke-width="2" stroke-linecap="round" />
                  <path d="M6 15a7 7 0 0 0 12.3 4.7" stroke="currentColor" stroke-width="2" stroke-linecap="round" />
                </svg>
                <span>Ganti Kamera</span>
              </span>
            </button>
          </div>
        </div>

        {{-- HASIL CAPTURE (RIGHT UNDER THE FILTER) --}}
        <div class="mt-8 pt-6 border-t border-slate-200 dark:border-stone-850">
          <div class="flex flex-col items-center justify-center text-center">
            <div class="section-title mb-3">Hasil Capture</div>
            <div class="preview w-full max-w-lg min-h-[220px] flex items-center justify-center border border-slate-200 dark:border-stone-800/80 rounded-2xl bg-slate-50/50 dark:bg-stone-900/50 p-2 relative overflow-hidden">
              <img id="capturePreview" alt="Preview capture" src="" style="display:none; max-width: 100%; border-radius: 12px;" class="shadow-lg">
              <div id="captureEmpty" class="p-8 text-center muted flex flex-col items-center justify-center">
                <div class="mb-3 inline-flex justify-center text-slate-400 dark:text-stone-650">
                  <svg width="36" height="36" viewBox="0 0 24 24" fill="none" aria-hidden="true">
                    <path d="M7 7l1.2-2h7.6L17 7h2a2 2 0 0 1 2 2v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V9a2 2 0 0 1 2-2h2Z"
                      stroke="currentColor" stroke-width="2" />
                    <path d="M12 17a4 4 0 1 0 0-8 4 4 0 0 0 0 8Z" stroke="currentColor" stroke-width="2" />
                  </svg>
                </div>
                <div class="font-bold text-slate-600 dark:text-stone-400">Belum ada foto.</div>
                <div class="text-xs mt-1 text-slate-500 dark:text-stone-500">Klik tombol <strong>Ambil Foto</strong> untuk mengambil gambar.</div>
              </div>
            </div>

            <div class="mt-4 w-full max-w-lg">
              <a class="btn text-center bg-gradient-to-r from-amber-600 to-red-700 hover:from-amber-500 hover:to-red-650" id="btnDownload" href="#" download="lentara-ar.png"
                style="display:none; text-decoration: none;">
                <span class="inline-flex items-center justify-center gap-2 w-full">
                  <svg width="18" height="18" viewBox="0 0 24 24" fill="none" aria-hidden="true">
                    <path d="M12 3v10" stroke="currentColor" stroke-width="2" stroke-linecap="round" />
                    <path d="M8 11l4 4 4-4" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                      stroke-linejoin="round" />
                    <path d="M5 21h14" stroke="currentColor" stroke-width="2" stroke-linecap="round" />
                  </svg>
                  <span>Unduh Hasil Foto</span>
                </span>
              </a>
            </div>
          </div>
        </div>

      </div>
    </div>
  </div>

  <!-- Guide Popup Modal (Traditional Indonesian Gold Accent modal) -->
  <div id="guideModal" class="fixed inset-0 z-50 flex items-center justify-center opacity-0 pointer-events-none transition-all duration-300">
    <div id="guideModalBackdrop" class="absolute inset-0 bg-black/60 backdrop-blur-md"></div>
    <div class="bg-white dark:bg-stone-900 border-2 border-amber-600/85 rounded-[28px] max-w-md w-[calc(100vw-2rem)] p-6 relative z-10 shadow-2xl transform scale-95 transition-all duration-300">
      
      <!-- Ornate corner at the top left of modal -->
      <div class="q-corner q-corner-tl" aria-hidden="true" style="width: 50px; height: 50px; top: -6px; left: -6px;">
        <svg width="100%" height="100%" viewBox="0 0 120 120" fill="none" xmlns="http://www.w3.org/2000/svg">
          <use href="#branch-tl-group" />
          <use href="#branch-tl-vertical" />
          <g fill="none" stroke="#4e2b02" stroke-width="3" stroke-linejoin="round" stroke-linecap="round">
            <use href="#branch-tl-group" />
            <use href="#branch-tl-vertical" />
          </g>
          <g fill="url(#gold-grad-tl)" stroke="#5d3403" stroke-width="1.2" stroke-linejoin="round" stroke-linecap="round">
            <use href="#branch-tl-group" />
            <use href="#branch-tl-vertical" />
          </g>
        </svg>
      </div>

      <div class="flex items-center justify-between mb-4 pb-2 border-b border-amber-900/10 dark:border-amber-500/10">
        <h3 class="text-lg font-bold text-amber-700 dark:text-amber-400 font-serif tracking-wider">Panduan & Saran</h3>
        <button id="btnCloseGuide" class="w-8 h-8 rounded-full flex items-center justify-center bg-slate-100 hover:bg-slate-200 dark:bg-stone-800 dark:hover:bg-stone-700 text-slate-500 dark:text-stone-400 border border-slate-200 dark:border-stone-700 transition-all hover:scale-105" type="button">
          <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12" />
          </svg>
        </button>
      </div>

      <div class="space-y-4 text-sm text-slate-600 dark:text-stone-300">
        <div class="flex gap-3">
          <div class="flex-shrink-0 w-6 h-6 rounded-full bg-amber-100 dark:bg-amber-950/40 text-amber-700 dark:text-amber-400 flex items-center justify-center font-bold text-xs">1</div>
          <p class="leading-relaxed">Pilih salah satu <strong>Filter Tradisional</strong> pada daftar pilihan filter di bawah kamera sebelum Anda menyalakan kamera.</p>
        </div>
        <div class="flex gap-3">
          <div class="flex-shrink-0 w-6 h-6 rounded-full bg-amber-100 dark:bg-amber-950/40 text-amber-700 dark:text-amber-400 flex items-center justify-center font-bold text-xs">2</div>
          <p class="leading-relaxed">Klik tombol <strong>Mulai Kamera</strong>. Izinkan peramban (browser) untuk mengakses kamera perangkat Anda.</p>
        </div>
        <div class="flex gap-3">
          <div class="flex-shrink-0 w-6 h-6 rounded-full bg-amber-100 dark:bg-amber-950/40 text-amber-700 dark:text-amber-400 flex items-center justify-center font-bold text-xs">3</div>
          <p class="leading-relaxed">Pastikan area wajah Anda mendapatkan **pencahayaan yang cukup** dan menghadap tegak lurus ke arah kamera agar sistem pelacakan wajah bekerja optimal.</p>
        </div>
        <div class="flex gap-3">
          <div class="flex-shrink-0 w-6 h-6 rounded-full bg-amber-100 dark:bg-amber-950/40 text-amber-700 dark:text-amber-400 flex items-center justify-center font-bold text-xs">4</div>
          <p class="leading-relaxed">Gunakan tombol <strong>Ganti Kamera</strong> untuk beralih antara kamera depan dan kamera belakang (khusus perangkat seluler/mobile).</p>
        </div>
        <div class="flex gap-3">
          <div class="flex-shrink-0 w-6 h-6 rounded-full bg-amber-100 dark:bg-amber-950/40 text-amber-700 dark:text-amber-400 flex items-center justify-center font-bold text-xs">5</div>
          <p class="leading-relaxed">Tekan <strong>Ambil Foto</strong> untuk mengabadikan momen, lalu klik <strong>Unduh Hasil Foto</strong> di sisi kanan untuk menyimpannya.</p>
        </div>
      </div>
    </div>
  </div>

  <script type="module">
    (() => {
      // =========================
      // Guard: jangan init 2x
      // =========================
      if (window.__LENTARA_AR_INIT__) {
        console.warn('[LentaraAR] already initialized');
        return;
      }
      window.__LENTARA_AR_INIT__ = true;

      // =========================
      // DOM Elements (safe check)
      // =========================
      const els = {
        stage: document.getElementById('arStage'),
        video: document.getElementById('arVideo'),
        status: document.getElementById('arStatus'),
        filterName: document.getElementById('arFilterName'),
        btnStart: document.getElementById('btnStartCam'),
        btnStop: document.getElementById('btnStopCam'),
        btnCapture: document.getElementById('btnCapture'),
        btnFlip: document.getElementById('btnFlip'),
        btnClear: document.getElementById('btnClearFilter'),
        filterBar: document.getElementById('filterBar'),
        preview: document.getElementById('capturePreview'),
        empty: document.getElementById('captureEmpty'),
        btnDownload: document.getElementById('btnDownload'),
        wmImgEl: document.getElementById('lentaraWatermarkImg'),
      };

      const requiredIds = ['stage', 'video', 'status', 'filterName', 'btnStart', 'btnStop', 'btnCapture', 'btnFlip', 'btnClear', 'filterBar', 'preview', 'empty', 'btnDownload', 'wmImgEl'];
      for (const k of requiredIds) {
        if (!els[k]) {
          console.warn(`[LentaraAR] Missing element: ${k}. Pastikan partial ter-include dan id-nya benar.`);
          return;
        }
      }

      // =========================
      // Konfigurasi Filter
      // =========================
      const SCALE_ALL = 0.60;

      const FILTERS = [
        {
          key: "peci",
          label: "Peci",
          icon: "{{ asset('images/filters/icons/peci.PNG') }}",
          model: "{{ asset('models/filters/peci.glb') }}",
          scale: 12,
          offset: { x: 0, y: 12, z: -0.10 },
          rot: { x: 0, y: 0, z: 0 },
          anchor: "head",
        },
        {
          key: "tanjak_seri_megah",
          label: "Tanjak (Seri Megah)",
          icon: "{{ asset('images/filters/icons/tanjak seri megah.PNG') }}",
          model: "{{ asset('models/filters/tanjak_seri_megah.glb') }}",
          scale: 0.02,
          offset: { x: 0, y: 0.23, z: -0.13 },
          rot: { x: 0, y: 180, z: 0 },
          anchor: "forehead",
        },
        {
          key: "tanjak_lang",
          label: "Tanjak (Lang)",
          icon: "{{ asset('images/filters/icons/tanjak lang.PNG') }}",
          model: "{{ asset('models/filters/tanjak_lang.glb') }}",
          scale: 0.4,
          offset: { x: -1, y: 12, z: -0.33 },
          rot: { x: 0, y: 40, z: 0 },
          anchor: "head",
        },
        {
          key: "destar_merah",
          label: "Destar Merah",
          icon: "{{ asset('images/filters/icons/destar merah.PNG') }}",
          model: "{{ asset('models/filters/destar_merah.glb') }}",
          scale: 16,
          offset: { x: 0, y: 14, z: -0.22 },
          rot: { x: 0, y: 180, z: 0 },
          anchor: "head",
        },
        {
          key: "songkok_tradisional",
          label: "Songkok",
          icon: "{{ asset('images/filters/icons/peci.PNG') }}",
          model: "{{ asset('models/filters/songkok_tradisional.glb') }}",
          scale: 0.09,
          offset: { x: 0, y: 12, z: -0.20 },
          rot: { x: 0, y: 0, z: 0 },
          anchor: "head",
        },
        {
          key: "iket_adat_sunda",
          label: "Iket Sunda",
          icon: "{{ asset('images/filters/icons/iket sunda.PNG') }}",
          model: "{{ asset('models/filters/iket_adat_sunda.glb') }}",
          scale: 8,
          offset: { x: 0, y: 0.15, z: -0.90 },
          rot: { x: 0, y: 0, z: 0 },
          anchor: "head",
        },
        {
          key: "blangkon",
          label: "Blangkon",
          icon: "{{ asset('images/filters/icons/blangkon.PNG') }}",
          model: "{{ asset('models/filters/blangkon.glb') }}",
          scale: 1,
          offset: { x: 18, y: 24, z: 0 },
          rot: { x: 0, y: 0, z: 0 },
          anchor: "head",
        },
      ];

      // =========================
      // Settings / Debug
      // =========================
      const AR = { debug: false };
      window.LentaraAR = AR;

      // =========================
      // UI helpers
      // =========================
      const setStatus = (t) => (els.status.textContent = `Status: ${t}`);
      const setButtons = (running) => {
        els.btnStart.disabled = running;
        els.btnStop.disabled = !running;
        els.btnCapture.disabled = !running;
        els.btnFlip.disabled = !running;
      };

      // ---------- UI Filter Bar ----------
      let activeKey = null;
      let currentFilter = null;

      function syncActiveUI() {
        els.filterBar.querySelectorAll('.filter-pill').forEach(p => {
          p.classList.toggle('is-active', p.dataset.key === activeKey);
        });
        const name = activeKey ? (FILTERS.find(x => x.key === activeKey)?.label || activeKey) : "Tidak ada";
        els.filterName.textContent = `Filter: ${name}`;
      }

      function buildFilterBar() {
        els.filterBar.innerHTML = "";
        FILTERS.forEach(f => {
          const el = document.createElement('button');
          el.type = "button";
          el.className = "filter-pill";
          el.dataset.key = f.key;
          el.innerHTML = `
        <div class="filter-icon"><img src="${f.icon}" alt="${f.label}"></div>
        <div class="filter-name">${f.label}</div>
      `;
          el.addEventListener('click', () => setFilter(f.key));
          els.filterBar.appendChild(el);
        });
        syncActiveUI();
      }

      // =========================
      // Deps (dynamic import)
      // =========================
      let THREE = null;
      let GLTFLoader = null;
      let FilesetResolver = null;
      let FaceLandmarker = null;

      async function ensureDeps() {
        if (THREE && GLTFLoader && FilesetResolver && FaceLandmarker) return;

        setStatus("Memuat modul…");

        const threeNS = await import("https://esm.sh/three@0.159.0");
        THREE = threeNS;

        const loaderMod = await import("https://esm.sh/three@0.159.0/examples/jsm/loaders/GLTFLoader.js");
        GLTFLoader = loaderMod.GLTFLoader;

        const mp = await import("https://cdn.jsdelivr.net/npm/@mediapipe/tasks-vision@0.10.14/vision_bundle.mjs");
        FilesetResolver = mp.FilesetResolver;
        FaceLandmarker = mp.FaceLandmarker;

        setStatus("Modul siap");
      }

      // =========================
      // MediaPipe init
      // =========================
      let faceLandmarker = null;

      async function initFaceLandmarker() {
        if (faceLandmarker) return;

        await ensureDeps();
        setStatus("Memuat model wajah…");

        const vision = await FilesetResolver.forVisionTasks(
          "https://cdn.jsdelivr.net/npm/@mediapipe/tasks-vision@0.10.14/wasm"
        );

        faceLandmarker = await FaceLandmarker.createFromOptions(vision, {
          baseOptions: {
            modelAssetPath:
              "https://storage.googleapis.com/mediapipe-models/face_landmarker/face_landmarker/float16/1/face_landmarker.task",
          },
          outputFacialTransformationMatrixes: true,
          outputFaceLandmarks: true,
          runningMode: "VIDEO",
          numFaces: 1,
        });

        setStatus("Model wajah siap");
      }

      // =========================
      // Three scene
      // =========================
      let renderer = null, scene = null, cam3d = null, loader = null;
      let currentModel = null;
      let stream = null;
      let facingMode = "user";
      let rafId = null;

      let M, P, Q, S, EUL;

      function initThree() {
        if (renderer) return;

        scene = new THREE.Scene();

        const rect = els.stage.getBoundingClientRect();
        cam3d = new THREE.PerspectiveCamera(45, rect.width / rect.height, 0.01, 50);
        cam3d.position.set(0, 0, 2);

        renderer = new THREE.WebGLRenderer({
          alpha: true,
          antialias: true,
          preserveDrawingBuffer: true
        });
        renderer.setPixelRatio(Math.min(window.devicePixelRatio || 1, 2));
        renderer.setSize(rect.width, rect.height);

        renderer.domElement.classList.add("ar-three");
        els.stage.appendChild(renderer.domElement);

        // Lighting with theme consideration
        const isDark = document.documentElement.getAttribute('data-theme') === 'dark';
        const ambientIntensity = isDark ? 0.8 : 1.0;
        const directionalIntensity = isDark ? 0.9 : 1.2;

        scene.add(new THREE.HemisphereLight(0xffffff, 0x222233, ambientIntensity));
        const dir = new THREE.DirectionalLight(0xffffff, directionalIntensity);
        dir.position.set(1, 2, 2);
        scene.add(dir);

        loader = new GLTFLoader();

        M = new THREE.Matrix4();
        P = new THREE.Vector3();
        Q = new THREE.Quaternion();
        S = new THREE.Vector3();
        EUL = new THREE.Euler();

        window.addEventListener("resize", () => {
          if (!renderer || !cam3d) return;
          const r = els.stage.getBoundingClientRect();
          cam3d.aspect = r.width / r.height;
          cam3d.updateProjectionMatrix();
          renderer.setSize(r.width, r.height);
        }, { passive: true });
      }

      function loadModel(url) {
        return new Promise((resolve, reject) => {
          loader.load(url, (gltf) => resolve(gltf.scene), undefined, reject);
        });
      }

      async function setFilter(key) {
        activeKey = key;
        currentFilter = FILTERS.find(x => x.key === key) || null;
        syncActiveUI();

        if (!renderer) return;

        if (!currentFilter) {
          if (currentModel) scene.remove(currentModel);
          currentModel = null;
          return;
        }

        setStatus("Memuat model 3D…");
        try {
          const model = await loadModel(currentFilter.model);
          if (currentModel) scene.remove(currentModel);

          model.traverse(obj => {
            if (obj.isMesh) obj.frustumCulled = false;
          });

          currentModel = model;
          currentModel.matrixAutoUpdate = false;
          scene.add(currentModel);

          setStatus(stream ? "Berjalan" : "Siap (mulai kamera)");
        } catch (err) {
          console.error(err);
          setStatus("Gagal memuat model");
        }
      }

      // =========================
      // Anchor helpers
      // =========================
      function landmarkToPosition(lm) {
        const x = (lm.x - 0.5) * 2;
        const y = -(lm.y - 0.5) * 2;
        const z = -lm.z;
        return { x, y, z };
      }

      function applyPose(results) {
        if (!currentModel || !currentFilter) return;

        const fm = results?.facialTransformationMatrixes?.[0];
        if (!fm) {
          currentModel.visible = false;
          return;
        }

        M.fromArray(fm.data);
        M.decompose(P, Q, S);

        // Scale
        const s = currentFilter.scale ?? 1.0;
        S.set(s, s, s);

        // Anchor forehead (lebih stabil buat topi)
        if (currentFilter.anchor === "forehead") {
          const faceLm = results?.faceLandmarks?.[0];
          const lm = faceLm?.[151];
          if (lm) {
            const pos = landmarkToPosition(lm);
            P.x = pos.x;
            P.y = pos.y;
            P.z = pos.z;
          }
        }

        // Offset
        P.x += (currentFilter.offset?.x ?? 0);
        P.y += (currentFilter.offset?.y ?? 0);
        P.z += (currentFilter.offset?.z ?? 0);

        // Rot offset (deg)
        const rx = (currentFilter.rot?.x ?? 0) * Math.PI / 180;
        const ry = (currentFilter.rot?.y ?? 0) * Math.PI / 180;
        const rz = (currentFilter.rot?.z ?? 0) * Math.PI / 180;
        EUL.set(rx, ry, rz, 'XYZ');
        const qOffset = new THREE.Quaternion().setFromEuler(EUL);
        Q.multiply(qOffset);

        currentModel.visible = true;
        currentModel.matrix.compose(P, Q, S);

        if (AR.debug) {
          console.log('[AR]', currentFilter.key, 'P=', P, 'scale=', s);
        }
      }

      function loop() {
        if (!stream || !faceLandmarker || !renderer) return;

        const results = faceLandmarker.detectForVideo(els.video, performance.now());
        applyPose(results);

        renderer.render(scene, cam3d);
        rafId = requestAnimationFrame(loop);
      }

      // =========================
      // Camera start/stop
      // =========================
      async function requestStream() {
        try {
          return await navigator.mediaDevices.getUserMedia({
            video: { facingMode: { ideal: facingMode } },
            audio: false,
          });
        } catch (e1) {
          console.warn("[LentaraAR] facingMode failed, fallback", e1);
          return await navigator.mediaDevices.getUserMedia({ video: true, audio: false });
        }
      }

      async function startCamera() {
        try {
          if (!navigator.mediaDevices?.getUserMedia) {
            setStatus("Browser tidak support kamera");
            return;
          }

          setButtons(false);
          setStatus("Mempersiapkan…");

          await ensureDeps();
          initThree();
          await initFaceLandmarker();

          setStatus("Meminta akses kamera…");
          stream = await requestStream();

          els.video.srcObject = stream;

          await new Promise(res => {
            if (els.video.readyState >= 2) return res();
            els.video.onloadedmetadata = () => res();
          });

          await els.video.play();

          setButtons(true);
          setStatus("Berjalan");

          if (rafId) cancelAnimationFrame(rafId);
          rafId = requestAnimationFrame(loop);

        } catch (e) {
          console.error(e);
          setButtons(false);
          setStatus("Kamera ditolak / error");
        }
      }

      function stopCamera() {
        if (rafId) cancelAnimationFrame(rafId);
        rafId = null;

        if (stream) {
          stream.getTracks().forEach(t => t.stop());
          stream = null;
        }

        els.video.pause();
        els.video.srcObject = null;

        setButtons(false);
        setStatus("Berhenti");
      }

      // =========================
      // Watermark helper
      // =========================
      async function ensureWatermarkLoaded() {
        const img = els.wmImgEl;
        if (img.complete && img.naturalWidth > 0) return img;
        await new Promise((res, rej) => {
          img.onload = () => res();
          img.onerror = () => rej(new Error("Watermark image failed to load"));
        });
        return img;
      }

      function drawWatermark(ctx, w, h, wmImg) {
        const isDark = document.documentElement.getAttribute('data-theme') === 'dark';
        const pad = Math.round(Math.min(w, h) * 0.03);
        const wmW = Math.round(w * 0.14);
        const ratio = wmImg.naturalHeight / wmImg.naturalWidth;
        const wmH = Math.round(wmW * ratio);

        const x = w - pad - wmW;
        const y = pad;

        ctx.save();
        ctx.globalAlpha = 1.0;
        ctx.drawImage(wmImg, x, y, wmW, wmH);
        ctx.restore();
      }

      function roundRect(ctx, x, y, w, h, r) {
        const rr = Math.min(r, w / 2, h / 2);
        ctx.beginPath();
        ctx.moveTo(x + rr, y);
        ctx.arcTo(x + w, y, x + w, y + h, rr);
        ctx.arcTo(x + w, y + h, x, y + h, rr);
        ctx.arcTo(x, y + h, x, y, rr);
        ctx.arcTo(x, y, x + w, y, rr);
        ctx.closePath();
      }

      // =========================
      // Capture
      // =========================
      async function capture() {
        if (!renderer || !els.video.videoWidth) return;

        const w = els.video.videoWidth;
        const h = els.video.videoHeight;

        const c = document.createElement("canvas");
        c.width = w; c.height = h;
        const ctx = c.getContext("2d");

        // mirror video
        ctx.save();
        ctx.translate(w, 0);
        ctx.scale(-1, 1);
        ctx.drawImage(els.video, 0, 0, w, h);
        ctx.restore();

        // mirror 3D overlay
        ctx.save();
        ctx.translate(w, 0);
        ctx.scale(-1, 1);
        ctx.drawImage(renderer.domElement, 0, 0, w, h);
        ctx.restore();

        // watermark image baked on top-right
        try {
          const wmImg = await ensureWatermarkLoaded();
          drawWatermark(ctx, w, h, wmImg);
        } catch (e) {
          console.warn("[LentaraAR] watermark not applied:", e);
        }

        const url = c.toDataURL("image/png");
        els.preview.src = url;
        els.preview.style.display = "block";
        els.empty.style.display = "none";
        els.btnDownload.href = url;
        els.btnDownload.style.display = "inline-flex";
      }

      // =========================
      // Events
      // =========================
      els.btnStart.addEventListener("click", startCamera);
      els.btnStop.addEventListener("click", stopCamera);
      els.btnCapture.addEventListener("click", capture);

      els.btnClear.addEventListener("click", () => {
        activeKey = null;
        currentFilter = null;
        syncActiveUI();
        if (currentModel && scene) scene.remove(currentModel);
        currentModel = null;
      });

      els.btnFlip.addEventListener("click", async () => {
        facingMode = (facingMode === "user") ? "environment" : "user";
        stopCamera();
        await startCamera();
      });

      // Helper tuning dari console
      AR.tune = (key, patch) => {
        const f = FILTERS.find(x => x.key === key);
        if (!f) return console.warn('Filter not found:', key);
        if (patch.scale != null) f.scale = patch.scale;
        if (patch.anchor) f.anchor = patch.anchor;
        if (patch.offset) f.offset = { ...(f.offset || {}), ...patch.offset };
        if (patch.rot) f.rot = { ...(f.rot || {}), ...patch.rot };
        console.log('[LentaraAR] tuned:', key, f);
        if (activeKey === key) syncActiveUI();
      };

      // =========================
      // Theme Observation
      // =========================
      function observeThemeChanges() {
        const observer = new MutationObserver(function (mutations) {
          mutations.forEach(function (mutation) {
            if (mutation.attributeName === 'data-theme') {
              // Update lighting based on theme
              if (scene) {
                const isDark = document.documentElement.getAttribute('data-theme') === 'dark';
                const ambientIntensity = isDark ? 0.8 : 1.0;
                const directionalIntensity = isDark ? 0.9 : 1.2;

                // Update existing lights if they exist
                scene.traverse(child => {
                  if (child.isHemisphereLight) {
                    child.intensity = ambientIntensity;
                  }
                  if (child.isDirectionalLight) {
                    child.intensity = directionalIntensity;
                  }
                });
              }
            }
          });
        });

        observer.observe(document.documentElement, {
          attributes: true,
          attributeFilter: ['data-theme']
        });
      }

      // =========================
      // Init
      // =========================
      buildFilterBar();
      syncActiveUI();
      setButtons(false);
      setStatus("Siap");
      observeThemeChanges();
    })();


    document.addEventListener('DOMContentLoaded', function () {
      document.querySelectorAll('#testimoni .t-mini-quote-wrapper').forEach(w => {
        w.style.display = 'flex';
        w.style.flexDirection = 'column';
        w.style.alignItems = 'flex-start';
        w.style.textAlign = 'left';
        w.style.width = '100%';
      });

      document.querySelectorAll('#testimoni .t-mini-quote').forEach(q => {
        q.style.textAlign = 'left';
        q.style.marginLeft = '0';
        q.style.marginRight = '0';
        q.style.width = '100%';
        q.style.maxWidth = '100%';
        q.style.alignSelf = 'flex-start';
      });

      // ============================================
      // Guide Modal Pop-up Handlers
      // ============================================
      const btnOpenGuide = document.getElementById('btnOpenGuide');
      const btnCloseGuide = document.getElementById('btnCloseGuide');
      const guideModal = document.getElementById('guideModal');
      const guideModalBackdrop = document.getElementById('guideModalBackdrop');

      if (btnOpenGuide && btnCloseGuide && guideModal) {
        function openGuide() {
          guideModal.classList.remove('opacity-0', 'pointer-events-none');
          guideModal.classList.add('opacity-100', 'pointer-events-auto');
          const box = guideModal.querySelector('.transform');
          if (box) {
            box.classList.remove('scale-95');
            box.classList.add('scale-100');
          }
        }

        function closeGuide() {
          guideModal.classList.remove('opacity-100', 'pointer-events-auto');
          guideModal.classList.add('opacity-0', 'pointer-events-none');
          const box = guideModal.querySelector('.transform');
          if (box) {
            box.classList.remove('scale-100');
            box.classList.add('scale-95');
          }
        }

        btnOpenGuide.addEventListener('click', openGuide);
        btnCloseGuide.addEventListener('click', closeGuide);
        if (guideModalBackdrop) {
          guideModalBackdrop.addEventListener('click', closeGuide);
        }
      }
    });

  </script>

</section>
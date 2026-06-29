{{-- ================= TESTIMONI ================= --}}
<section id="testimoni" class="py-12">
    @php
        $testimonials = $testimonials ?? collect();
        $testimonialStats = $testimonialStats ?? ['counts'=>[1=>0,2=>0,3=>0,4=>0,5=>0],'total'=>0,'avg'=>0];

        $counts = $testimonialStats['counts'];
        $total  = (int) $testimonialStats['total'];
        $avg    = (float) $testimonialStats['avg'];

        // helper % bar
        $pct = function($n) use ($total) {
            return $total > 0 ? round(($n / $total) * 100) : 0;
        };

        // ===============================
        // MARQUEE DATA (TIDAK UBAH LOGIKA INTI)
        // Split selang-seling: index genap => atas, index ganjil => bawah
        // ===============================
        $items = $testimonials instanceof \Illuminate\Support\Collection
            ? $testimonials->values()
            : collect($testimonials)->values();

        $topRow = $items->filter(fn($v, $i) => $i % 2 === 0)->values();
        $botRow = $items->filter(fn($v, $i) => $i % 2 === 1)->values();

        // Threshold: kalau < 3 => TIDAK jalan (static)
        $shouldAnimate = $items->count() >= 3;

        // helper initial letter
        $initial = function($name) {
            $name = trim((string)$name);
            if ($name === '') return '?';
            $first = mb_substr($name, 0, 1, 'UTF-8');
            return mb_strtoupper($first, 'UTF-8');
        };

        // helper role (kalau field tidak ada, fallback)
        $roleText = function($t) {
            $role = $t->role ?? $t->occupation ?? $t->title ?? null;
            return $role ? (string)$role : 'Pengunjung';
        };

        // Helper untuk truncate teks dan cek apakah perlu "Baca selengkapnya"
        function needsReadMore($text, $maxLines = 3) {
            $lines = substr_count($text, "\n") + 1;
            $wordCount = str_word_count($text);
            return $lines > $maxLines || $wordCount > 50;
        }

        // Helper untuk truncate teks
        function truncateText($text, $maxLength = 150) {
            if (strlen($text) <= $maxLength) {
                return $text;
            }
            return substr($text, 0, $maxLength) . '...';
        }
    @endphp

    <style>
        /* =========================================================
           TESTIMONI THEME SAFE (LIGHT/DARK) + FIX OVERFLOW + NO CIRCLE STAR
        ========================================================= */

        .t-wrap { color: var(--txt-body); }

        .t-card {
            background: linear-gradient(145deg, var(--card), color-mix(in oklab, var(--card-bg-dark) 90%, transparent));
            border: 1px solid rgba(255, 107, 0, 0.2);
            box-shadow: 0 20px 50px rgba(0, 0, 0, 0.3);
            border-radius: 20px;
            padding: 1.5rem;
        }

        html[data-theme="dark"] .t-card {
            background: linear-gradient(145deg, #111827, #020617);
        }
        html[data-theme="light"] .t-card {
            background: linear-gradient(145deg, #ffffff, #f8fafc);
        }

        .t-soft {
            background: linear-gradient(145deg, var(--card), color-mix(in oklab, var(--card-bg-dark) 90%, transparent));
            border: 1px solid rgba(255, 107, 0, 0.1);
            border-radius: 16px;
            padding: 1.25rem;
        }

        html[data-theme="dark"] .t-soft { background: linear-gradient(145deg, #111827, #020617); }
        html[data-theme="light"] .t-soft { background: linear-gradient(145deg, #ffffff, #f8fafc); }

        .t-muted { color: var(--muted); }

        .t-input, .t-textarea {
            width: 100%;
            border-radius: 12px;
            border: 1px solid rgba(255, 107, 0, 0.2);
            background: color-mix(in oklab, var(--bg-body) 95%, transparent);
            color: var(--txt-body);
            padding: 12px 14px;
            outline: none;
            transition: border-color .18s ease, box-shadow .18s ease, transform .18s ease;
        }

        .t-textarea {
            resize: none;
            scrollbar-width: none;
            -ms-overflow-style: none;
        }
        .t-textarea::-webkit-scrollbar {
            display: none;
        }

        html[data-theme="dark"] .t-input,
        html[data-theme="dark"] .t-textarea { background: rgba(255, 255, 255, 0.05); }

        html[data-theme="light"] .t-input,
        html[data-theme="light"] .t-textarea { background: rgba(0, 0, 0, 0.02); }

        .t-input::placeholder, .t-textarea::placeholder { color: rgba(156, 163, 175, 0.7); }

        .t-input:focus, .t-textarea:focus {
            border-color: #ff6b00;
            box-shadow: 0 0 0 4px rgba(255, 107, 0, 0.2);
            transform: translateY(-1px);
        }

        /* ===============================
           RATING STARS (CLICK) - NO CIRCLE
        =============================== */
        .star-row {
            display: inline-flex;
            gap: 10px;
            align-items: center;
        }

        .star-btn {
            width: auto;
            height: auto;
            border: 0;
            background: transparent;
            padding: 0;
            cursor: pointer;
            user-select: none;
            line-height: 1;
        }

        .star-btn:focus { outline: none; }
        .star-btn:focus-visible {
            outline: 2px solid rgba(255,107,0,.55);
            outline-offset: 4px;
            border-radius: 10px;
        }

        .star {
            font-size: 28px;
            line-height: 1;
            color: rgba(156, 163, 175, 0.55);
            transition: transform .12s ease, color .18s ease, filter .18s ease;
            display: inline-block;
        }

        .star-btn:hover .star {
            transform: translateY(-1px) scale(1.08);
            filter: drop-shadow(0 10px 20px rgba(255,107,0,.25));
        }

        .star.is-on { color: #f59e0b; transform: scale(1.06); }

        /* Progress bars */
        .t-bar {
            height: 12px;
            border-radius: 999px;
            background: rgba(255, 107, 0, 0.1);
            overflow: hidden;
        }
        .t-bar > span {
            display: block;
            height: 100%;
            width: 0%;
            border-radius: 999px;
            background: linear-gradient(90deg, #f59e0b, #ff6b00);
            transition: width .5s ease;
        }

        .t-file {
            width: 100%;
            border-radius: 12px;
            border: 2px dashed rgba(255, 107, 0, 0.3);
            background: rgba(255, 107, 0, 0.05);
            color: var(--txt-body);
            padding: 12px 14px;
            transition: all .18s ease;
        }
        .t-file:hover {
            border-color: #ff6b00;
            background: rgba(255, 107, 0, 0.1);
        }

        .t-btn {
            border-radius: 14px;
            padding: 14px 20px;
            font-weight: 700;
            background: linear-gradient(135deg, #ff6b00, #ff8c42);
            color: white;
            border: 0;
            box-shadow: 0 18px 30px rgba(255, 107, 0, 0.25);
            transition: all .18s ease;
            font-size: 1rem;
        }
        .t-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 22px 35px rgba(255, 107, 0, 0.35);
            filter: brightness(1.1);
        }
        .t-btn:active { transform: translateY(0px); }

        .t-chip {
            font-size: 12px;
            padding: 6px 12px;
            border-radius: 999px;
            border: 1px solid rgba(255, 107, 0, 0.3);
            background: rgba(255, 107, 0, 0.1);
            color: #ff8c42;
            font-weight: 600;
        }

        /* =========================================================
           FIX OVERFLOW TEKS PANJANG
        ========================================================= */
        .t-name,
        .t-comment,
        .t-anywhere {
            overflow-wrap: anywhere;
            word-break: break-word;
        }
        .t-comment { white-space: pre-wrap; }

        /* =========================================================
           MODAL REPORT DARK MODE
        ========================================================= */
        html[data-theme="dark"] #reportModal .t-card{
            background: linear-gradient(145deg, #0b1220, #020617) !important;
            border: 1px solid rgba(255,107,0,.22) !important;
            box-shadow: 0 26px 70px rgba(0,0,0,.55) !important;
        }
        html[data-theme="dark"] #reportModal h3,
        html[data-theme="dark"] #reportModal label{
            color: rgba(255,255,255,.92) !important;
        }
        html[data-theme="dark"] #reportModal .t-muted{
            color: rgba(255,255,255,.62) !important;
        }
        #reportModal select.t-input{
            -webkit-appearance: none;
            -moz-appearance: none;
            appearance: none;
            background-clip: padding-box;
        }
        html[data-theme="dark"] #reportModal select.t-input{
            background-color: rgba(255,255,255,.06) !important;
            color: rgba(255,255,255,.92) !important;
            border-color: rgba(255,107,0,.28) !important;
        }
        html[data-theme="dark"] #reportModal select.t-input option{
            background-color: #0b1220 !important;
            color: rgba(255,255,255,.92) !important;
        }
        html[data-theme="dark"] #reportModal select.t-input option:checked,
        html[data-theme="dark"] #reportModal select.t-input option:hover{
            background-color: #111b2f !important;
            color: rgba(255,255,255,.95) !important;
        }
        html[data-theme="dark"] #reportModal select.t-input:focus{
            border-color: #ff6b00 !important;
            box-shadow: 0 0 0 4px rgba(255,107,0,.22) !important;
        }
        html[data-theme="dark"] #reportModal textarea.t-textarea{
            background-color: rgba(255,255,255,.06) !important;
            color: rgba(255,255,255,.92) !important;
            border-color: rgba(255,107,0,.22) !important;
        }
        html[data-theme="dark"] #reportModal textarea.t-textarea::placeholder{
            color: rgba(255,255,255,.45) !important;
        }
        html[data-theme="dark"] #reportModal button.t-input{
            background-color: rgba(255,255,255,.06) !important;
            color: rgba(255,255,255,.88) !important;
            border-color: rgba(255,107,0,.18) !important;
        }
        html[data-theme="dark"] #reportModal button.t-input:hover{
            background-color: rgba(255,255,255,.09) !important;
            border-color: rgba(255,107,0,.28) !important;
        }

        /* =========================================================
           MARQUEE
        ========================================================= */
        .t-marquee-wrap {
            margin-top: 10px;
            padding-top: 8px;
        }

        .t-marquee {
            position: relative;
            overflow: hidden;
            border-radius: 24px;
            background: transparent;
        }

        .t-marquee::before,
        .t-marquee::after{
            content:"";
            position:absolute;
            top:0;
            bottom:0;
            width: 90px;
            pointer-events:none;
            z-index: 5;
        }
        .t-marquee::before{
            left:0;
            background: linear-gradient(to right,
                color-mix(in oklab, var(--bg-body) 92%, transparent),
                transparent
            );
        }
        .t-marquee::after{
            right:0;
            background: linear-gradient(to left,
                color-mix(in oklab, var(--bg-body) 92%, transparent),
                transparent
            );
        }

        .t-lane { display:block; padding: 14px 0; }

        .t-track {
            display:flex;
            width:max-content;
            gap: 16px;
            padding: 0 12px;
            will-change: transform;
            transform: translateZ(0);
        }

        .t-track.is-left  { animation: tMarqueeLeft  var(--t-dur, 34s) linear infinite; }
        .t-track.is-right { animation: tMarqueeRight var(--t-dur, 34s) linear infinite; }

        @keyframes tMarqueeLeft {
            from { transform: translateX(0); }
            to   { transform: translateX(-50%); }
        }
        @keyframes tMarqueeRight {
            from { transform: translateX(-50%); }
            to   { transform: translateX(0); }
        }

        .t-mini-card{
            width: 520px;
            max-width: 78vw;
            border-radius: 20px;
            padding: 20px 20px 18px;
            border: 1px solid rgba(255, 107, 0, 0.15);
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.08);
            background: rgba(255, 255, 255, 0.7);
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
            text-align: left;
            transition: transform 0.3s cubic-bezier(0.34, 1.56, 0.64, 1), box-shadow 0.3s ease, border-color 0.3s ease;
        }
        .t-mini-card:hover {
            transform: translateY(-5px) scale(1.01);
            box-shadow: 0 20px 40px rgba(255, 107, 0, 0.12);
            border-color: rgba(255, 107, 0, 0.45);
        }
        html[data-theme="dark"] .t-mini-card{
            border: 1px solid rgba(255, 107, 0, 0.25);
            box-shadow: 0 20px 45px rgba(0, 0, 0, 0.4);
            background: rgba(30, 41, 59, 0.45);
        }
        html[data-theme="dark"] .t-mini-card:hover {
            box-shadow: 0 25px 50px rgba(255, 107, 0, 0.2);
            border-color: rgba(255, 107, 0, 0.6);
        }

        .t-mini-head{
            display:flex;
            align-items:flex-start;
            gap: 12px;
            justify-content: flex-start;
            text-align: left;
        }

        .t-avatar{
          width: 56px;
          height: 56px;
          border-radius: 999px;
          display:flex;
          align-items:center;
          justify-content:center;
          font-weight: 900;
          background: var(--brand);
          color: #ffffff;
          flex: 0 0 auto;
          box-shadow: 0 10px 22px rgba(249,115,22,.28);
          overflow:hidden;
        }

        #testimoni{ --brand: #f97316; }
        html[data-theme="dark"] #testimoni{ --brand: #f97316; }

        .t-avatar img{
            width: 100%;
            height: 100%;
            border-radius: 999px;
            object-fit: cover;
            display:block;
        }

        .t-mini-meta{ min-width:0; flex:1; text-align:left; }
        .t-mini-name{
            font-weight: 900;
            font-size: 16px;
            line-height: 1.15;
            color: rgba(15,23,42,.92);
            text-align:left;
        }
        html[data-theme="dark"] .t-mini-name{ color: rgba(255,255,255,.92); }

        .t-mini-role{
            margin-top: 2px;
            font-size: 12px;
            color: rgba(100,116,139,.9);
            font-weight: 600;
            text-align:left;
        }
        html[data-theme="dark"] .t-mini-role{ color: rgba(148,163,184,.9); }

        .t-mini-stars{
            margin-top: 6px;
            display:flex;
            gap: 2px;
            font-size: 14px;
            line-height: 1;
            justify-content: flex-start;
        }

        /* ===============================
   FIX FINAL: QUOTE FULL WIDTH & RATA KIRI
=============================== */
#testimoni .t-mini-quote{
  /* PENTING: jangan shrink ke konten */
  display: block !important;

  /* paksa isi lebar card */
  width: 100% !important;
  max-width: 100% !important;

  /* hilangkan efek "kotak di tengah" */
  margin: 10px 0 0 0 !important;

  /* teks */
  text-align: left !important;
  font-style: italic;
  line-height: 1.55;

  /* wrapping */
  white-space: pre-wrap;
  word-break: break-word;
  overflow-wrap: anywhere;

  /* clamp tetap jalan */
  display: -webkit-box !important;
  -webkit-line-clamp: 3;
  -webkit-box-orient: vertical;

  overflow: hidden;
}

        html[data-theme="dark"] .t-mini-quote{ color: rgba(226,232,240,.82); }

        .t-mini-foot{
            margin-top: 10px;
            display:flex;
            justify-content: space-between;
            align-items:center;
            gap: 10px;
            text-align: left;
        }
        .t-mini-date{
            font-size: 11px;
            color: rgba(100,116,139,.85);
            font-weight: 700;
        }
        html[data-theme="dark"] .t-mini-date{ color: rgba(148,163,184,.75); }

        .t-mini-report{
            display:inline-flex;
            align-items:center;
            gap: 8px;
            font-size: 11px;
            font-weight: 900;
            color: rgba(239,68,68,.95);
            text-decoration: none;
            user-select:none;
        }
        .t-mini-report:hover{ text-decoration: underline; }
        .t-mini-report svg{
            width: 16px;
            height: 16px;
            flex: 0 0 auto;
        }

        .t-track.is-static { animation: none !important; transform: translateX(0) !important; }

        @media (prefers-reduced-motion: reduce) {
            .t-track.is-left, .t-track.is-right { animation: none !important; }
        }

        @media (max-width: 640px){
            .t-marquee::before, .t-marquee::after{ width: 36px; }
            .t-lane{ padding: 10px 0; }
            .t-track{ gap: 12px; padding: 0 10px; }
            .t-mini-card{
                width: 88vw;
                max-width: 88vw;
                padding: 14px 14px 12px;
            }
            .t-avatar{ width: 52px; height: 52px; }
        }

        /* ===============================
           FORM GRID
        =============================== */
        .t-form-grid{
            display: grid;
            grid-template-columns: 1fr;
            gap: 14px;
        }
        @media (min-width: 768px){
            .t-form-grid{
                grid-template-columns: 1fr 1fr;
                gap: 14px;
            }
            .t-form-span-2{ grid-column: span 2 / span 2; }
        }

        /* ===============================
           ALERTS
        =============================== */
        .t-alert {
            border-radius: 16px;
            padding: 14px 16px;
            border: 1px solid transparent;
            font-size: 14px;
            font-weight: 900;
        }
        .t-alert-success{
            background: rgba(34, 197, 94, 0.14);
            border-color: rgba(34, 197, 94, 0.30);
            color: rgba(34, 197, 94, 0.95);
        }
        .t-alert-error{
            background: rgba(239, 68, 68, 0.12);
            border-color: rgba(239, 68, 68, 0.28);
            color: rgba(239, 68, 68, 0.95);
        }
        .t-alert-client{ display:none; }

        /* =========================================================
           NEON WRAPPER
        ========================================================= */
        @property --t-neon-angle {
            syntax: "<angle>";
            inherits: false;
            initial-value: 0deg;
        }

        .t-neon-shell{
            position: relative;
            border-radius: 22px;
        }

        .t-neon-glow{
            position: absolute;
            inset: -5px;
            border-radius: inherit;
            padding: 10px;
            z-index: 0;
            pointer-events: none;

            background: conic-gradient(from var(--t-neon-angle),
                    rgba(255, 107, 0, 0),
                    rgba(255, 140, 66, 0.18) 30deg,
                    rgba(255, 107, 0, 0.95) 80deg,
                    rgba(255, 170, 107, 0.9) 120deg,
                    rgba(255, 140, 66, 0.18) 180deg,
                    rgba(255, 107, 0, 0) 240deg,
                    rgba(255, 140, 66, 0.20) 300deg,
                    rgba(255, 107, 0, 0.95) 330deg,
                    rgba(255, 107, 0, 0) 360deg);

            -webkit-mask:
                linear-gradient(#000 0 0) content-box,
                linear-gradient(#000 0 0);
            -webkit-mask-composite: xor;
            mask-composite: exclude;

            filter: blur(4px);
            opacity: .90;
            animation: t-neon-spin 8s linear infinite;
        }

        @keyframes t-neon-spin{
            to { --t-neon-angle: 360deg; }
        }

        .t-neon-inner{
            position: relative;
            z-index: 1;
            border-radius: 20px;
        }

        @media (prefers-reduced-motion: reduce){
            .t-neon-glow{ animation: none !important; }
        }

        /* =========================================================
           ✅ FINAL OVERRIDE (INI YANG BENER)
           Paksa lane & track START KIRI (ANTI CSS EXTERNAL / AUTO-CENTER)
        ========================================================= */

        /* lane jadi flex supaya kita bisa kontrol posisi track */
        #testimoni .t-lane{
            display: flex !important;
            justify-content: flex-start !important;
            align-items: stretch !important;
        }

        /* track jangan pernah auto-center */
        #testimoni .t-track{
            justify-content: flex-start !important;
            margin-left: 0 !important;
            margin-right: 0 !important;
        }

        /* kalau ada global rule yang bikin max-width + auto margin, matikan */
        #testimoni .t-track,
        #testimoni .t-mini-card{
            margin: 0 !important;
        }

        /* pastikan teks card tetap left */
        #testimoni .t-mini-card,
        #testimoni .t-mini-card *{
            text-align: left !important;
        }
/* =========================================================
   FIX: neon shell & card harus sama tinggi (no empty space)
========================================================= */
#testimoni .t-neon-shell{
  display: flex !important;
  flex-direction: column !important;
  align-items: stretch !important;
}

/* inner card ikut nge-fill shell */
#testimoni .t-neon-inner{
  flex: 1 1 auto !important;
  width: 100% !important;
}

/* khusus card average (yang kanan) jangan "shrink" */
#testimoni .t-neon-inner.t-card{
  height: 100% !important;
}

/* kalau ada CSS luar yang bikin shell punya min-height, matiin */
#testimoni .t-neon-shell{
  min-height: 0 !important;
}

/* =========================================================
   TOMBOL BACA SELENGKAPNYA
========================================================= */
.t-read-more-btn {
    display: inline-block;
    margin-top: 8px;
    font-size: 11px;
    font-weight: 700;
    color: #ff6b00;
    background: rgba(255, 107, 0, 0.1);
    padding: 3px 8px;
    border-radius: 999px;
    border: 1px solid rgba(255, 107, 0, 0.2);
    cursor: pointer;
    transition: all 0.18s ease;
    user-select: none;
    text-decoration: none;
    text-align: left !important;
    float: left !important;
    clear: both !important;
}

.t-read-more-btn:hover {
    background: rgba(255, 107, 0, 0.15);
    transform: translateY(-1px);
    box-shadow: 0 4px 12px rgba(255, 107, 0, 0.15);
}

html[data-theme="dark"] .t-read-more-btn {
    color: #ff8c42;
    background: rgba(255, 107, 0, 0.15);
    border-color: rgba(255, 107, 0, 0.3);
}

/* =========================================================
   MODAL DETAIL TESTIMONI LENGKAP & STACKING OVERLAY
========================================================= */
html.testimonial-modal-open .site-header,
html.testimonial-modal-open .circle-logo-container {
    z-index: 10 !important;
}

.t-detail-modal {
    display: none;
    position: fixed;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: rgba(0, 0, 0, 0.75);
    backdrop-filter: blur(8px);
    z-index: 1000;
    align-items: center;
    justify-content: center;
    padding: 20px;
    animation: fadeIn 0.2s ease-out;
}

.t-status-modal {
    display: none;
    position: fixed;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: rgba(0, 0, 0, 0.75);
    backdrop-filter: blur(8px);
    z-index: 1100;
    align-items: center;
    justify-content: center;
    padding: 20px;
    animation: fadeIn 0.2s ease-out;
}
.t-status-modal.active {
    display: flex;
}

.t-status-content {
    background: rgba(255, 255, 255, 0.95);
    border-radius: 20px;
    padding: 24px;
    max-width: 400px;
    width: 100%;
    box-shadow: 0 30px 60px rgba(0, 0, 0, 0.4);
    border: 1px solid rgba(255, 107, 0, 0.2);
    animation: slideUp 0.3s ease-out;
    text-align: center !important;
}

html[data-theme="dark"] .t-status-content {
    background: rgba(17, 24, 39, 0.95);
    border-color: rgba(255, 107, 0, 0.3);
}

.t-detail-modal.active {
    display: flex;
}

.t-detail-content {
    background-color: var(--card, #ffffff);
    background-image: 
      radial-gradient(circle at center, color-mix(in oklab, var(--card, #ffffff) 92%, transparent) 0%, color-mix(in oklab, var(--card, #ffffff) 98%, transparent) 100%),
      url("data:image/svg+xml,%3Csvg width='40' height='40' viewBox='0 0 40 40' xmlns='http://www.w3.org/2000/svg'%3E%3Ccircle cx='0' cy='0' r='20' fill='none' stroke='%23ff6b00' stroke-width='0.75' stroke-opacity='0.06'/%3E%3Ccircle cx='40' cy='0' r='20' fill='none' stroke='%23ff6b00' stroke-width='0.75' stroke-opacity='0.06'/%3E%3Ccircle cx='0' cy='40' r='20' fill='none' stroke='%23ff6b00' stroke-width='0.75' stroke-opacity='0.06'/%3E%3Ccircle cx='40' cy='40' r='20' fill='none' stroke='%23ff6b00' stroke-width='0.75' stroke-opacity='0.06'/%3E%3Ccircle cx='20' cy='20' r='20' fill='none' stroke='%23ff6b00' stroke-width='0.75' stroke-opacity='0.06'/%3E%3Cpath d='M0,20 Q10,10 20,20 Q10,30 0,20' fill='none' stroke='%23ff6b00' stroke-width='0.75' stroke-opacity='0.09'/%3E%3Cpath d='M20,20 Q30,10 40,20 Q30,30 20,20' fill='none' stroke='%23ff6b00' stroke-width='0.75' stroke-opacity='0.09'/%3E%3Cpath d='M20,0 Q10,10 20,20 Q30,10 20,0' fill='none' stroke='%23ff6b00' stroke-width='0.75' stroke-opacity='0.09'/%3E%3Cpath d='M20,20 Q10,30 20,40 Q30,30 20,20' fill='none' stroke='%23ff6b00' stroke-width='0.75' stroke-opacity='0.09'/%3E%3C/svg%3E");
    background-size: cover, 40px 40px;
    border-radius: 24px;
    padding: 24px;
    max-width: 500px;
    width: 100%;
    max-height: 92vh;
    overflow-y: auto;
    scrollbar-width: none;
    -ms-overflow-style: none;
    box-shadow: 0 30px 60px rgba(0, 0, 0, 0.4);
    border: 1.5px solid rgba(255, 107, 0, 0.25);
    animation: slideUp 0.3s ease-out;
    text-align: left;
}

.t-detail-content::-webkit-scrollbar {
    display: none;
}

html[data-theme="dark"] .t-detail-content {
    background-color: #0c1524;
    background-image: 
      radial-gradient(circle at center, rgba(12, 21, 36, 0.92) 0%, rgba(12, 21, 36, 0.98) 100%),
      url("data:image/svg+xml,%3Csvg width='40' height='40' viewBox='0 0 40 40' xmlns='http://www.w3.org/2000/svg'%3E%3Ccircle cx='0' cy='0' r='20' fill='none' stroke='%23f97316' stroke-width='0.75' stroke-opacity='0.08'/%3E%3Ccircle cx='40' cy='0' r='20' fill='none' stroke='%23f97316' stroke-width='0.75' stroke-opacity='0.08'/%3E%3Ccircle cx='0' cy='40' r='20' fill='none' stroke='%23f97316' stroke-width='0.75' stroke-opacity='0.08'/%3E%3Ccircle cx='40' cy='40' r='20' fill='none' stroke='%23f97316' stroke-width='0.75' stroke-opacity='0.08'/%3E%3Ccircle cx='20' cy='20' r='20' fill='none' stroke='%23f97316' stroke-width='0.75' stroke-opacity='0.08'/%3E%3Cpath d='M0,20 Q10,10 20,20 Q10,30 0,20' fill='none' stroke='%23f97316' stroke-width='0.75' stroke-opacity='0.12'/%3E%3Cpath d='M20,20 Q30,10 40,20 Q30,30 20,20' fill='none' stroke='%23f97316' stroke-width='0.75' stroke-opacity='0.12'/%3E%3Cpath d='M20,0 Q10,10 20,20 Q30,10 20,0' fill='none' stroke='%23f97316' stroke-width='0.75' stroke-opacity='0.12'/%3E%3Cpath d='M20,20 Q10,30 20,40 Q30,30 20,20' fill='none' stroke='%23f97316' stroke-width='0.75' stroke-opacity='0.12'/%3E%3C/svg%3E");
    border-color: rgba(255, 107, 0, 0.35);
}

#testimonialFormModal .t-detail-content {
    max-height: 96vh !important;
    overflow: hidden !important;
    overflow-y: hidden !important;
    padding: 20px !important;
}

.t-detail-header {
    display: flex;
    align-items: center;
    gap: 12px;
    margin-bottom: 16px;
    padding-bottom: 16px;
    border-bottom: 1px solid rgba(255, 107, 0, 0.1);
}

.t-detail-avatar {
    width: 60px;
    height: 60px;
    border-radius: 50%;
    background: var(--brand);
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-weight: 900;
    font-size: 24px;
    flex-shrink: 0;
}

.t-detail-avatar img {
    width: 100%;
    height: 100%;
    border-radius: 50%;
    object-fit: cover;
}

.t-detail-info {
    flex: 1;
}

.t-detail-name {
    font-weight: 900;
    font-size: 18px;
    color: rgba(15, 23, 42, 0.95);
    margin-bottom: 4px;
}

html[data-theme="dark"] .t-detail-name {
    color: rgba(255, 255, 255, 0.95);
}

.t-detail-role {
    font-size: 13px;
    color: rgba(100, 116, 139, 0.9);
    font-weight: 600;
    margin-bottom: 6px;
}

html[data-theme="dark"] .t-detail-role {
    color: rgba(148, 163, 184, 0.9);
}

.t-detail-stars {
    display: flex;
    gap: 2px;
}

.t-detail-quote {
    font-size: 15px;
    line-height: 1.6;
    color: rgba(15, 23, 42, 0.85);
    white-space: pre-wrap;
    word-break: break-word;
    overflow-wrap: anywhere;
    font-style: italic;
    padding: 16px 0;
    border-bottom: 1px solid rgba(255, 107, 0, 0.1);
    margin-bottom: 16px;
    text-align: left !important;
}

html[data-theme="dark"] .t-detail-quote {
    color: rgba(226, 232, 240, 0.85);
}

.t-detail-footer {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-top: 16px;
}

.t-detail-date {
    font-size: 13px;
    color: rgba(100, 116, 139, 0.8);
    font-weight: 700;
}

html[data-theme="dark"] .t-detail-date {
    color: rgba(148, 163, 184, 0.8);
}

.t-detail-close {
    background: rgba(255, 107, 0, 0.1);
    color: #ff6b00;
    border: 1px solid rgba(255, 107, 0, 0.2);
    padding: 8px 16px;
    border-radius: 12px;
    font-weight: 700;
    cursor: pointer;
    transition: all 0.18s ease;
}

.t-detail-close:hover {
    background: rgba(255, 107, 0, 0.15);
    transform: translateY(-1px);
}

html[data-theme="dark"] .t-detail-close {
    color: #ff8c42;
    background: rgba(255, 107, 0, 0.15);
    border-color: rgba(255, 107, 0, 0.3);
}

@keyframes fadeIn {
    from { opacity: 0; }
    to { opacity: 1; }
}

@keyframes slideUp {
    from {
        opacity: 0;
        transform: translateY(20px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

/* =========================================================
   FIX: PAKSA RATA KIRI DESKRIPSI TESTIMONI
========================================================= */
#testimoni .t-mini-quote-wrapper {
    display: block !important;
    width: 100% !important;
    text-align: left !important;
    margin-top: 10px !important;
}

#testimoni .t-mini-quote {
    text-align: left !important;
    display: block !important;
    width: 100% !important;
    margin: 0 !important;
    padding: 0 !important;
    float: none !important;
    clear: both !important;
}

/* sembunyikan input file bawaan */
.t-file-native{
    position: absolute;
    left: -9999px;
    width: 1px;
    height: 1px;
    opacity: 0;
}

/* tombol custom */
.t-file-btn{
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 10px;

    width: 100%;
    border-radius: 12px;
    border: 2px dashed rgba(255, 107, 0, 0.35);
    background: rgba(255, 107, 0, 0.06);
    color: var(--txt-body);
    padding: 12px 14px;

    font-weight: 900;
    cursor: pointer;
    transition: all .18s ease;
    user-select: none;
}

.t-file-btn:hover{
    border-color: #ff6b00;
    background: rgba(255, 107, 0, 0.12);
    transform: translateY(-1px);
}

.t-file-name{
    margin-top: 8px;
    font-size: 12px;
    font-weight: 800;
    color: var(--muted);
    overflow-wrap: anywhere;
}


    </style>

    <div class="max-w-6xl mx-auto px-4">
        <div class="t-wrap">
            <h2 class="neon-title scroll-reveal reveal-fade-up">
                Testimoni Pengunjung
            </h2>
            <div class="title-decoration scroll-reveal reveal-fade-up delay-100"></div>
            <p class="neon-subtitle scroll-reveal reveal-fade-up delay-150">
Bagikan pengalamanmu menjelajahi budaya Nusantara melalui Lentara. Setiap masukan membantu kami menghadirkan konten yang lebih akurat, informatif, dan bermanfaat bagi semua.
                </p>

            {{-- ===== BUTTON UNTUK MEMBUKA MODAL FORM TESTIMONI ===== --}}
            <div class="text-center mt-6 mb-10 scroll-reveal reveal-fade-up delay-200">
                <button type="button" class="t-btn !px-8 !py-3.5" onclick="openTestimonialFormModal()">
                    Tambahkan Testimoni
                </button>
            </div>

            {{-- ===== MARQUEE ===== --}}
            <div class="t-marquee-wrap mb-10 scroll-reveal reveal-fade-up delay-100" id="testimonialMarqueeWrap">
                <div class="t-marquee">
                    @if($items->count() === 0)
                        <div class="t-muted text-center py-10">Belum ada testimoni. Jadilah yang pertama</div>
                    @else
                        {{-- Lane TOP --}}
                        <div class="t-lane">
                            <div class="t-track {{ $shouldAnimate ? 'is-right' : 'is-static' }}" style="--t-dur: 34s;">
                                @for($rep=0; $rep<2; $rep++)
                                    @foreach($topRow as $t)
                                        <div class="t-mini-card">
                                            <div class="t-mini-head">
                                                <div class="t-avatar" aria-hidden="true">
                                                    @if(!empty($t->photo))
                                                        <img src="{{ asset('storage/'.$t->photo) }}" alt="Avatar {{ $t->name }}">
                                                    @else
                                                        {{ $initial($t->name) }}
                                                    @endif
                                                </div>

                                                <div class="t-mini-meta">
                                                    <div class="t-mini-name t-anywhere">{{ $t->name }}</div>
                                                    <div class="t-mini-role">{{ $roleText($t) }}</div>

                                                    <div class="t-mini-stars" aria-label="Rating {{ $t->rating }} dari 5">
                                                        @for($i=1; $i<=5; $i++)
                                                            <span style="color: {{ $i <= (int)$t->rating ? '#f59e0b' : 'rgba(156, 163, 175, 0.35)' }};">★</span>
                                                        @endfor
                                                    </div>
                                                </div>
                                            </div>

                                            {{-- Deskripsi testimoni dengan fitur read more --}}
                                            <div class="t-mini-quote-wrapper">
                                                <div class="t-mini-quote" id="quote-{{ $t->id }}">
                                                    @php
                                                        $needsReadMore = needsReadMore($t->message);
                                                        $displayText = $needsReadMore ? truncateText($t->message, 120) : $t->message;
                                                    @endphp
                                                    {{ $displayText }}
                                                </div>

                                                @if($needsReadMore)
                                                    <a href="javascript:void(0)"
                                                       class="t-read-more-btn"
                                                       onclick="showFullTestimonial({{ json_encode([
                                                           'id' => $t->id,
                                                           'name' => $t->name,
                                                           'role' => $roleText($t),
                                                           'rating' => $t->rating,
                                                           'message' => $t->message,
                                                           'created_at' => $t->created_at?->translatedFormat('d M Y'),
                                                           'photo' => $t->photo,
                                                           'initial' => $initial($t->name)
                                                       ]) }})">
                                                        Baca selengkapnya
                                                    </a>
                                                @endif
                                            </div>

                                            <div class="t-mini-foot">
                                                <div class="t-mini-date">{{ $t->created_at?->translatedFormat('d M Y') }}</div>

                                                <a href="javascript:void(0)"
                                                   onclick="openReportModal('{{ route('testimonials.report', $t) }}')"
                                                   class="t-mini-report">
                                                    <svg viewBox="0 0 24 24" fill="none" aria-hidden="true">
                                                        <path d="M12 3.5L22 20.5H2L12 3.5Z" stroke="currentColor" stroke-width="2" stroke-linejoin="round"/>
                                                        <path d="M12 9V14" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                                                        <path d="M12 17.5H12.01" stroke="currentColor" stroke-width="3" stroke-linecap="round"/>
                                                    </svg>
                                                    <span>Laporkan</span>
                                                </a>
                                            </div>
                                        </div>
                                    @endforeach
                                @endfor
                            </div>
                        </div>

                        {{-- Lane BOTTOM --}}
                        <div class="t-lane">
                            <div class="t-track {{ $shouldAnimate ? 'is-left' : 'is-static' }}" style="--t-dur: 36s;">
                                @for($rep=0; $rep<2; $rep++)
                                    @foreach($botRow as $t)
                                        <div class="t-mini-card">
                                            <div class="t-mini-head">
                                                <div class="t-avatar" aria-hidden="true">
                                                    @if(!empty($t->photo))
                                                        <img src="{{ asset('storage/'.$t->photo) }}" alt="Avatar {{ $t->name }}">
                                                    @else
                                                        {{ $initial($t->name) }}
                                                    @endif
                                                </div>

                                                <div class="t-mini-meta">
                                                    <div class="t-mini-name t-anywhere">{{ $t->name }}</div>
                                                    <div class="t-mini-role">{{ $roleText($t) }}</div>

                                                    <div class="t-mini-stars" aria-label="Rating {{ $t->rating }} dari 5">
                                                        @for($i=1; $i<=5; $i++)
                                                            <span style="color: {{ $i <= (int)$t->rating ? '#f59e0b' : 'rgba(156, 163, 175, 0.35)' }};">★</span>
                                                        @endfor
                                                    </div>
                                                </div>
                                            </div>

                                            {{-- Deskripsi testimoni dengan fitur read more --}}
                                            <div class="t-mini-quote-wrapper">
                                                <div class="t-mini-quote" id="quote-{{ $t->id }}">
                                                    @php
                                                        $needsReadMore = needsReadMore($t->message);
                                                        $displayText = $needsReadMore ? truncateText($t->message, 120) : $t->message;
                                                    @endphp
                                                    {{ $displayText }}
                                                </div>

                                                @if($needsReadMore)
                                                    <a href="javascript:void(0)"
                                                       class="t-read-more-btn"
                                                       onclick="showFullTestimonial({{ json_encode([
                                                           'id' => $t->id,
                                                           'name' => $t->name,
                                                           'role' => $roleText($t),
                                                           'rating' => $t->rating,
                                                           'message' => $t->message,
                                                           'created_at' => $t->created_at?->translatedFormat('d M Y'),
                                                           'photo' => $t->photo,
                                                           'initial' => $initial($t->name)
                                                       ]) }})">
                                                        Baca selengkapnya
                                                    </a>
                                                @endif
                                            </div>

                                            <div class="t-mini-foot">
                                                <div class="t-mini-date">{{ $t->created_at?->translatedFormat('d M Y') }}</div>

                                                <a href="javascript:void(0)"
                                                   onclick="openReportModal('{{ route('testimonials.report', $t) }}')"
                                                   class="t-mini-report">
                                                    <svg viewBox="0 0 24 24" fill="none" aria-hidden="true">
                                                        <path d="M12 3.5L22 20.5H2L12 3.5Z" stroke="currentColor" stroke-width="2" stroke-linejoin="round"/>
                                                        <path d="M12 9V14" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                                                        <path d="M12 17.5H12.01" stroke="currentColor" stroke-width="3" stroke-linecap="round"/>
                                                    </svg>
                                                    <span>Laporkan</span>
                                                </a>
                                            </div>
                                        </div>
                                    @endforeach
                                @endfor
                            </div>
                        </div>
                    @endif
                </div>
            </div>

            {{-- ===== SUMMARY (MOVED TO BOTTOM) ===== --}}
            <div class="grid gap-6 lg:grid-cols-3 mt-12 mb-8 scroll-reveal reveal-fade-up delay-100" id="testimonialSummaryGrid">
                {{-- Left: distribution (NEON) --}}
                <div class="t-neon-shell lg:col-span-2">
                    <div class="t-neon-glow"></div>
                    <div class="t-neon-inner t-card">
                        <div class="flex items-center justify-between mb-4">
                            <div class="font-bold text-lg">Ringkasan Rating</div>
                            <div class="t-chip">{{ $total }} Rating</div>
                        </div>

                        @for($r = 5; $r >= 1; $r--)
                            @php $p = $pct($counts[$r]); @endphp
                            <div class="flex items-center gap-4 mb-4">
                                <div class="w-20 text-sm font-bold tracking-wide" style="color: #ff8c42;">
                                    {{ $r }} ★
                                </div>
                                <div class="flex-1 t-bar">
                                    <span style="width: {{ $p }}%"></span>
                                </div>
                                <div class="w-16 text-right text-sm font-semibold" style="color: #ff8c42;">
                                    {{ $counts[$r] }} ({{ $p }}%)
                                </div>
                            </div>
                        @endfor
                    </div>
                </div>

                {{-- Right: average (NEON) --}}
                <div class="t-neon-shell">
                    <div class="t-neon-glow"></div>
                    <div class="t-neon-inner t-card flex flex-col items-center justify-center text-center">
                        <div class="text-5xl font-extrabold" style="color: #ff6b00;">
                            {{ number_format($avg, 1) }}
                        </div>

                        <div class="mt-3 flex items-center justify-center gap-1">
                            @php
                                $full = (int) floor($avg);
                                $dec  = $avg - $full;
                                $half = $dec >= 0.5 ? 1 : 0;
                                $empty = 5 - $full - $half;
                                if ($empty < 0) $empty = 0;
                            @endphp

                            @for($i=0; $i < $full; $i++)
                                <span class="text-3xl" style="color:#f59e0b;">★</span>
                            @endfor

                            @if($half === 1)
                                <span class="text-3xl relative inline-block" aria-hidden="true" style="line-height:1;">
                                    <span style="color: rgba(156, 163, 175, 0.3);">★</span>
                                    <span style="position:absolute; left:0; top:0; width:50%; overflow:hidden; color:#f59e0b;">★</span>
                                </span>
                            @endif

                            @for($i=0; $i < $empty; $i++)
                                <span class="text-3xl" style="color: rgba(156, 163, 175, 0.3);">★</span>
                            @endfor
                        </div>

                        <div class="mt-2 t-muted text-sm">
                            Dari {{ $total }} rating
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

    {{-- ================= MODAL FORM TAMBAH TESTIMONI ================= --}}
    <div class="t-detail-modal" id="testimonialFormModal">
        <div class="t-detail-content !max-w-2xl relative overflow-hidden">
            {{-- Decorative Top Accent Glow --}}
            <div class="absolute -top-12 -left-12 w-40 h-40 bg-orange-500/10 rounded-full blur-2xl pointer-events-none"></div>
            <div class="absolute -bottom-12 -right-12 w-40 h-40 bg-amber-500/10 rounded-full blur-2xl pointer-events-none"></div>

            {{-- ===== BATIK HEADER BANNER MODAL ===== --}}
            <div class="relative w-full h-16 sm:h-18 rounded-2xl overflow-hidden mb-4 border border-amber-600/30 shadow-md relative z-10" style="background-color: #1a0f03;">
                <img src="{{ asset('images/icon/footer.JPEG') }}" class="w-full h-full object-cover opacity-90 object-center" alt="Corak Batik Nusantara">
                <div class="absolute inset-0 bg-gradient-to-r from-black/70 via-black/40 to-black/70"></div>
                
                <div class="absolute inset-y-0 left-0 w-2 bg-gradient-to-r from-amber-500 to-transparent opacity-70"></div>
                <div class="absolute inset-y-0 right-0 w-2 bg-gradient-to-l from-amber-500 to-transparent opacity-70"></div>

                <div class="absolute left-3.5 sm:left-5 top-1/2 -translate-y-1/2 flex items-center gap-3">
                    <div class="w-9 h-9 sm:w-10 sm:h-10 rounded-xl bg-gradient-to-br from-orange-500 to-amber-500 flex items-center justify-center text-white shadow-lg shadow-orange-500/30 border border-white/20 flex-shrink-0">
                        <svg class="w-4 h-4 sm:w-5 sm:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                        </svg>
                    </div>
                    <div>
                        <h3 class="font-extrabold text-base sm:text-xl tracking-tight text-white drop-shadow-md leading-tight">Tambahkan Testimoni</h3>
                        <p class="text-[11px] sm:text-xs text-amber-200/90 font-medium">Bagikan ulasan dan pengalamanmu bersama Lentara</p>
                    </div>
                </div>

                <button type="button" class="absolute right-3 sm:right-4 top-1/2 -translate-y-1/2 w-8 h-8 sm:w-9 sm:h-9 rounded-full bg-black/40 hover:bg-orange-500 text-white transition-all duration-200 flex items-center justify-center border border-white/20 focus:outline-none z-20 cursor-pointer" onclick="closeTestimonialFormModal()" aria-label="Tutup modal">&times;</button>
            </div>

            <div id="clientAlert" class="mb-3 t-alert t-alert-error t-alert-client" role="alert" aria-live="polite"></div>

            <form method="POST"
                  action="{{ route('testimonials.store') }}"
                  enctype="multipart/form-data"
                  class="space-y-3 relative z-10"
                  id="testimonialForm">
                @csrf

                <input type="text" name="website" value="" autocomplete="off" tabindex="-1"
                       style="position:absolute;left:-9999px;top:-9999px;height:1px;width:1px;opacity:0;">

                <div class="t-form-grid !gap-3">
                    <div class="t-form-span-2 bg-orange-500/5 dark:bg-orange-500/10 p-3 sm:p-3.5 rounded-xl border border-orange-500/15">
                        <div class="flex items-center justify-between mb-1">
                            <label class="text-xs sm:text-sm font-bold flex items-center gap-1.5">
                                <span>Rating Pengalaman</span>
                                <span class="text-red-500">*</span>
                            </label>
                            <span id="ratingText" class="text-xs font-bold text-amber-500 transition-all duration-200">Pilih bintang</span>
                        </div>
                        <input type="hidden" name="rating" id="ratingValue" value="{{ old('rating', 0) }}">

                        <div class="mt-1.5 star-row flex items-center gap-2" id="starRow" aria-label="Pilih rating bintang">
                            @for($i=1; $i<=5; $i++)
                                <button
                                    type="button"
                                    class="star-btn"
                                    data-star="{{ $i }}"
                                    aria-label="Pilih {{ $i }} bintang"
                                    title="Pilih {{ $i }} bintang"
                                >
                                    <span class="star">★</span>
                                </button>
                            @endfor
                        </div>
                    </div>

                    <div>
                        <label class="text-xs sm:text-sm font-bold block mb-1">Nama Lengkap <span class="text-red-500">*</span></label>
                        <input class="t-input !py-2 !px-3 text-xs sm:text-sm" name="name" value="{{ old('name') }}" placeholder="Tulis nama lengkapmu">
                    </div>

                    <div>
                        <label class="text-xs sm:text-sm font-bold block mb-1">Foto Profil <span class="t-muted text-[11px] font-normal">(Opsional, Max 5MB)</span></label>
                        <input id="photoInput" class="t-file t-file-native" type="file" name="photo" accept="image/png,image/jpeg,image/jpg">
                        <label for="photoInput" class="t-file-btn !py-2 !px-3 text-xs sm:text-sm">
                            <svg class="w-4 h-4 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>
                            <span>Pilih Foto Profil</span>
                        </label>
                        <div class="t-file-name truncate max-w-full text-[11px] mt-1" id="photoName">Belum ada foto dipilih</div>
                    </div>

                    <div class="t-form-span-2">
                        <label class="text-xs sm:text-sm font-bold block mb-1">Pesan Testimoni <span class="text-red-500">*</span></label>
                        <textarea class="t-textarea !py-2 !px-3 text-xs sm:text-sm" name="message" rows="2.5" placeholder="Tuliskan pengalaman, kesan, atau kritik saranmu menjelajahi Lentara Nusantara...">{{ old('message') }}</textarea>
                    </div>

                    <div class="t-form-span-2 flex items-center justify-end gap-3 mt-2 pt-2.5 border-t border-orange-500/10">
                        <button type="button" class="t-input !w-auto !px-5 !py-2 text-xs sm:text-sm font-bold cursor-pointer hover:bg-black/5 dark:hover:bg-white/10" onclick="closeTestimonialFormModal()">Batal</button>
                        <button class="t-btn !w-auto !px-7 !py-2 text-xs sm:text-sm flex items-center gap-2 cursor-pointer">
                            <span>Kirim Testimoni</span>
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                            </svg>
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    {{-- ================= MODAL DETAIL TESTIMONI ================= --}}
    <div class="t-detail-modal" id="testimonialDetailModal">
        <div class="t-detail-content">
            <div class="t-detail-header">
                <div class="t-detail-avatar" id="detailAvatar">
                    <!-- Avatar akan diisi oleh JavaScript -->
                </div>
                <div class="t-detail-info">
                    <div class="t-detail-name" id="detailName"></div>
                    <div class="t-detail-role" id="detailRole"></div>
                    <div class="t-detail-stars" id="detailStars">
                        <!-- Bintang rating akan diisi oleh JavaScript -->
                    </div>
                </div>
            </div>

            <div class="t-detail-quote" id="detailQuote"></div>

            <div class="t-detail-footer">
                <div class="t-detail-date" id="detailDate"></div>
                <button class="t-detail-close" onclick="closeTestimonialDetail()">Tutup</button>
            </div>
        </div>
    </div>

    {{-- ================= MODAL REPORT ================= --}}
    <div id="reportModal" class="fixed inset-0 z-50 hidden items-center justify-center bg-black/60 px-4" style="backdrop-filter: blur(4px);">
        <div class="t-card w-full max-w-md p-6"
             style="animation: scaleIn .18s ease-out;">
            <h3 class="text-lg font-extrabold mb-1">Laporkan Testimoni</h3>
            <p class="t-muted text-xs mb-4">Pilih alasan laporan. Admin akan meninjau laporan ini.</p>

            <form id="reportForm" method="POST">
                @csrf

                <label class="text-sm font-bold">Alasan</label>
                <select name="reason" required class="t-input mt-1 mb-3">
                    <option value="Spam">Spam</option>
                    <option value="Ujaran kebencian">Ujaran kebencian</option>
                    <option value="Tidak pantas">Tidak pantas</option>
                    <option value="Penipuan">Penipuan</option>
                    <option value="Lainnya">Lainnya</option>
                </select>

                <label class="text-sm font-bold">
                    Catatan tambahan <span class="t-muted text-xs">(opsional)</span>
                </label>
                <textarea name="note" rows="3" class="t-textarea mt-1"
                          placeholder="Tulis catatan tambahan bila perlu..."></textarea>

                <div class="mt-6 flex justify-end gap-3">
                    <button type="button" onclick="closeReportModal()"
                            class="t-input !w-auto !px-5 !py-2 font-bold">
                        Batal
                    </button>

                    <button class="t-btn !w-auto !px-5 !py-2">
                        Kirim Laporan
                    </button>
                </div>
            </form>
        </div>
    </div>

    {{-- ================= MODAL STATUS (AJAX SUCCESS/ERROR POPUP) ================= --}}
    <div class="t-status-modal" id="testimonialStatusModal">
        <div class="t-status-content">
            <div id="statusModalIcon" class="mx-auto w-16 h-16 rounded-full flex items-center justify-center mb-4 text-3xl">
                <!-- Icon will be filled by JS -->
            </div>
            <h3 id="statusModalTitle" class="text-xl font-extrabold mb-2" style="color: var(--txt-body);"></h3>
            <div id="statusModalMessage" class="t-muted text-sm mb-6 leading-relaxed"></div>
            <button type="button" onclick="closeStatusModal()" class="t-btn !w-auto !px-8 !py-2.5 mx-auto">
                Tutup
            </button>
        </div>
    </div>

    <script>
        function openReportModal(actionUrl) {
            const modal = document.getElementById('reportModal');
            const form  = document.getElementById('reportForm');
            form.action = actionUrl;
            modal.classList.remove('hidden');
            modal.classList.add('flex');
            document.documentElement.classList.add('testimonial-modal-open');
        }
        function closeReportModal() {
            const modal = document.getElementById('reportModal');
            modal.classList.add('hidden');
            modal.classList.remove('flex');
            document.documentElement.classList.remove('testimonial-modal-open');
        }
        document.getElementById('reportModal')?.addEventListener('click', (e) => {
            if (e.target.id === 'reportModal') closeReportModal();
        });

        document.getElementById('reportForm')?.addEventListener('submit', (e) => {
            e.preventDefault();
            const form = e.target;
            const submitBtn = form.querySelector('.t-btn');
            const originalBtnText = submitBtn.textContent;
            
            submitBtn.disabled = true;
            submitBtn.textContent = 'Mengirim Laporan...';

            const formData = new FormData(form);

            fetch(form.action, {
                method: 'POST',
                body: formData,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json'
                }
            })
            .then(async response => {
                const data = await response.json();
                
                if (response.ok && data.success) {
                    closeReportModal();
                    form.reset();
                    showStatusModal(true, 'Berhasil', data.message || 'Laporan berhasil dikirim!');
                } else {
                    if (data.errors) {
                        let errorMsg = '<ul class="list-disc list-inside text-left space-y-1 mt-2">';
                        for (const key in data.errors) {
                            data.errors[key].forEach(err => {
                                errorMsg += `<li>${err}</li>`;
                            });
                        }
                        errorMsg += '</ul>';
                        showStatusModal(false, 'Gagal Mengirim Laporan', errorMsg);
                    } else {
                        showStatusModal(false, 'Gagal Mengirim Laporan', data.message || 'Terjadi kesalahan saat mengirim laporan.');
                    }
                }
            })
            .catch(err => {
                console.error(err);
                showStatusModal(false, 'Error', 'Terjadi kesalahan koneksi saat mengirim laporan.');
            })
            .finally(() => {
                submitBtn.disabled = false;
                submitBtn.textContent = originalBtnText;
            });
        });

        // Fungsi untuk menampilkan detail lengkap testimoni
        function showFullTestimonial(testimonial) {
            const modal = document.getElementById('testimonialDetailModal');
            const avatar = document.getElementById('detailAvatar');
            const name = document.getElementById('detailName');
            const role = document.getElementById('detailRole');
            const stars = document.getElementById('detailStars');
            const quote = document.getElementById('detailQuote');
            const date = document.getElementById('detailDate');

            // Isi data testimoni ke modal
            name.textContent = testimonial.name;
            role.textContent = testimonial.role;
            quote.textContent = testimonial.message;
            date.textContent = testimonial.created_at;

            // Set avatar
            if (testimonial.photo) {
                avatar.innerHTML = `<img src="{{ asset('storage/') }}/${testimonial.photo}" alt="${testimonial.name}">`;
            } else {
                avatar.textContent = testimonial.initial;
            }

            // Set rating stars
            stars.innerHTML = '';
            const rating = parseInt(testimonial.rating);
            for (let i = 1; i <= 5; i++) {
                const star = document.createElement('span');
                star.textContent = '★';
                star.style.fontSize = '18px';
                star.style.color = i <= rating ? '#f59e0b' : 'rgba(156, 163, 175, 0.35)';
                stars.appendChild(star);
            }

            // Tampilkan modal
            modal.classList.add('active');
            document.body.style.overflow = 'hidden';
            document.documentElement.classList.add('testimonial-modal-open');
        }

        // Fungsi untuk menutup modal detail testimoni
        function closeTestimonialDetail() {
            const modal = document.getElementById('testimonialDetailModal');
            modal.classList.remove('active');
            document.body.style.overflow = '';
            document.documentElement.classList.remove('testimonial-modal-open');
        }

        // Tutup modal ketika klik di luar konten
        document.getElementById('testimonialDetailModal')?.addEventListener('click', (e) => {
            if (e.target.id === 'testimonialDetailModal') {
                closeTestimonialDetail();
            }
        });

        // Tutup modal dengan tombol ESC
        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape') {
                closeTestimonialDetail();
            }
        });

        // ============================================
        // SCRIPT UNTUK PAKSA RATA KIRI DESKRIPSI TESTIMONI
        // ============================================
        document.addEventListener('DOMContentLoaded', function() {
            // Paksa semua deskripsi testimoni rata kiri
            document.querySelectorAll('.t-mini-quote').forEach(quote => {
                quote.style.textAlign = 'left';
                quote.style.marginLeft = '0';
                quote.style.marginRight = '0';
                quote.style.paddingLeft = '0';
                quote.style.paddingRight = '0';
                quote.style.float = 'none';
                quote.style.clear = 'both';
                quote.style.display = 'block';
                quote.style.width = '100%';

                // Hapus inline style center jika ada
                const currentStyle = quote.getAttribute('style') || '';
                if (currentStyle.includes('center')) {
                    quote.setAttribute('style', currentStyle.replace(/text-align\s*:\s*center\s*[;!]?/gi, ''));
                }
            });

            // Paksa semua wrapper quote rata kiri
            document.querySelectorAll('.t-mini-quote-wrapper').forEach(wrapper => {
                wrapper.style.textAlign = 'left';
                wrapper.style.marginLeft = '0';
                wrapper.style.marginRight = '0';
                wrapper.style.paddingLeft = '0';
                wrapper.style.paddingRight = '0';
            });

            // Paksa tombol baca selengkapnya rata kiri
            document.querySelectorAll('.t-read-more-btn').forEach(btn => {
                btn.style.textAlign = 'left';
                btn.style.float = 'left';
                btn.style.clear = 'both';
                btn.style.marginLeft = '0';
            });
        });

        (function () {
            const row = document.getElementById('starRow');
            const input = document.getElementById('ratingValue');
            const form = document.getElementById('testimonialForm');
            const textarea = form?.querySelector('textarea[name="message"]');
            const nameInput = form?.querySelector('input[name="name"]');
            const alertBox = document.getElementById('clientAlert');
            const ratingTextEl = document.getElementById('ratingText');

            const ratingLabels = {
                1: 'Sangat Kecewa 🙁',
                2: 'Kurang Puas 😐',
                3: 'Cukup Baik 🙂',
                4: 'Sangat Bagus! 😊',
                5: 'Luar Biasa! 🌟'
            };

            if (!row || !input) return;

            function paint(v) {
                const stars = row.querySelectorAll('.star-btn .star');
                stars.forEach((el, idx) => {
                    const n = idx + 1;
                    el.classList.toggle('is-on', n <= v);
                });
                if (ratingTextEl) {
                    ratingTextEl.textContent = ratingLabels[v] || 'Pilih bintang';
                }
            }

            function showAlert(msg) {
                if (!alertBox) return;
                alertBox.textContent = msg;
                alertBox.style.display = 'block';
                alertBox.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
            }

            function hideAlert() {
                if (!alertBox) return;
                alertBox.textContent = '';
                alertBox.style.display = 'none';
            }

            const initial = parseInt(input.value || '0', 10);
            paint(initial);

            row.querySelectorAll('.star-btn').forEach(btn => {
                btn.addEventListener('click', () => {
                    const v = parseInt(btn.dataset.star, 10);
                    input.value = v;
                    paint(v);
                    hideAlert();
                });

                btn.addEventListener('mouseenter', () => {
                    const v = parseInt(btn.dataset.star, 10);
                    paint(v);
                });
            });

            row.addEventListener('mouseleave', () => {
                const v = parseInt(input.value || '0', 10);
                paint(v);
            });

            textarea?.addEventListener('input', () => {
                hideAlert();
                textarea.style.height = 'auto';
                textarea.style.height = textarea.scrollHeight + 'px';
            });
            nameInput?.addEventListener('input', () => hideAlert());

            // Custom Status Modal JS Functions
            window.showStatusModal = function(isSuccess, title, message) {
                const modal = document.getElementById('testimonialStatusModal');
                const iconDiv = document.getElementById('statusModalIcon');
                const titleEl = document.getElementById('statusModalTitle');
                const messageEl = document.getElementById('statusModalMessage');

                if (!modal || !iconDiv || !titleEl || !messageEl) return;

                titleEl.textContent = title;
                messageEl.innerHTML = message;

                if (isSuccess) {
                    iconDiv.innerHTML = `
                        <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round">
                            <polyline points="20 6 9 17 4 12"></polyline>
                        </svg>
                    `;
                    iconDiv.style.background = 'rgba(34, 197, 94, 0.15)';
                    iconDiv.style.color = '#22c55e';
                    iconDiv.style.border = '1px solid rgba(34, 197, 94, 0.3)';
                    titleEl.style.color = '#22c55e';
                } else {
                    iconDiv.innerHTML = `
                        <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round">
                            <line x1="18" y1="6" x2="6" y2="18"></line>
                            <line x1="6" y1="6" x2="18" y2="18"></line>
                        </svg>
                    `;
                    iconDiv.style.background = 'rgba(239, 68, 68, 0.15)';
                    iconDiv.style.color = '#ef4444';
                    iconDiv.style.border = '1px solid rgba(239, 68, 68, 0.3)';
                    titleEl.style.color = '#ef4444';
                }

                modal.classList.add('active');
                document.body.style.overflow = 'hidden';
            };

            window.openTestimonialFormModal = function() {
                const modal = document.getElementById('testimonialFormModal');
                if (modal) {
                    modal.classList.add('active');
                    document.body.style.overflow = 'hidden';
                    document.documentElement.classList.add('testimonial-modal-open');
                }
            };

            window.closeTestimonialFormModal = function() {
                const modal = document.getElementById('testimonialFormModal');
                if (modal) {
                    modal.classList.remove('active');
                    document.body.style.overflow = '';
                    document.documentElement.classList.remove('testimonial-modal-open');
                }
            };

            document.getElementById('testimonialFormModal')?.addEventListener('click', (e) => {
                if (e.target.id === 'testimonialFormModal') {
                    closeTestimonialFormModal();
                }
            });

            window.closeStatusModal = function() {
                const modal = document.getElementById('testimonialStatusModal');
                if (modal) modal.classList.remove('active');
                // Only remove overflow & class if no other modal active
                if (!document.querySelector('.t-detail-modal.active') && document.getElementById('reportModal')?.classList.contains('hidden')) {
                    document.body.style.overflow = '';
                    document.documentElement.classList.remove('testimonial-modal-open');
                }
            };

            document.getElementById('testimonialStatusModal')?.addEventListener('click', (e) => {
                if (e.target.id === 'testimonialStatusModal') {
                    closeStatusModal();
                }
            });

            form?.addEventListener('submit', (e) => {
                e.preventDefault();

                const v = parseInt(input.value || '0', 10);
                const msg = (textarea?.value || '').trim();
                const nm  = (nameInput?.value || '').trim();

                if (!v || v < 1) {
                    showStatusModal(false, 'Gagal', 'Silakan pilih rating bintang terlebih dahulu.');
                    return;
                }
                if (!nm) {
                    showStatusModal(false, 'Gagal', 'Silakan isi nama terlebih dahulu.');
                    return;
                }
                if (!msg) {
                    showStatusModal(false, 'Gagal', 'Silakan isi deskripsi/pesan testimoni terlebih dahulu.');
                    return;
                }

                // Client-side file size check during submission
                const fileInput = document.getElementById('photoInput');
                if (fileInput && fileInput.files && fileInput.files[0]) {
                    const file = fileInput.files[0];
                    if (file.size > 5 * 1024 * 1024) {
                        showStatusModal(false, 'Ukuran File Terlalu Besar', 'Gagal mengirim. Ukuran foto maksimal adalah 5MB. File yang Anda pilih berukuran <strong>' + (file.size / (1024 * 1024)).toFixed(2) + 'MB</strong>.');
                        return;
                    }
                }

                const submitBtn = form.querySelector('.t-btn');
                const originalBtnText = submitBtn.textContent;
                submitBtn.disabled = true;
                submitBtn.textContent = 'Mengirim...';

                const formData = new FormData(form);

                fetch(form.action, {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'Accept': 'application/json'
                    }
                })
                .then(async response => {
                    const data = await response.json();
                    
                    if (response.ok && data.success) {
                        closeTestimonialFormModal();
                        showStatusModal(true, 'Berhasil', data.message || 'Terima kasih atas testimoni Anda!');
                        form.reset();
                        input.value = 0;
                        paint(0);
                        const photoName = document.getElementById('photoName');
                        if (photoName) photoName.textContent = 'Belum ada foto dipilih';

                        // Fetch updated HTML dynamically to refresh marquee & summary without reloading
                        fetch(window.location.href)
                            .then(res => res.text())
                            .then(html => {
                                const parser = new DOMParser();
                                const doc = parser.parseFromString(html, 'text/html');
                                
                                // Replace summary grid
                                const newSummary = doc.getElementById('testimonialSummaryGrid');
                                const oldSummary = document.getElementById('testimonialSummaryGrid');
                                if (newSummary && oldSummary) {
                                    oldSummary.innerHTML = newSummary.innerHTML;
                                }
                                
                                // Replace marquee wrap
                                const newMarquee = doc.getElementById('testimonialMarqueeWrap');
                                const oldMarquee = document.getElementById('testimonialMarqueeWrap');
                                if (newMarquee && oldMarquee) {
                                    oldMarquee.innerHTML = newMarquee.innerHTML;
                                }
                            })
                            .catch(err => console.warn('[TESTIMONIAL] Gagal memperbarui daftar testimoni:', err));

                    } else {
                        if (data.errors) {
                            let errorMsg = '<ul class="list-disc list-inside text-left space-y-1 mt-2">';
                            for (const key in data.errors) {
                                data.errors[key].forEach(err => {
                                    errorMsg += `<li>${err}</li>`;
                                });
                            }
                            errorMsg += '</ul>';
                            showStatusModal(false, 'Gagal Mengirim', errorMsg);
                        } else {
                            showStatusModal(false, 'Gagal Mengirim', data.message || 'Terjadi kesalahan saat mengirim testimoni.');
                        }
                    }
                })
                .catch(err => {
                    console.error(err);
                    showStatusModal(false, 'Error', 'Terjadi kesalahan koneksi saat mengirim testimoni.');
                })
                .finally(() => {
                    submitBtn.disabled = false;
                    submitBtn.textContent = originalBtnText;
                });
            });
        })();

        const style = document.createElement('style');
        style.textContent = `
            @keyframes scaleIn {
                from { opacity:0; transform: scale(.94); }
                to   { opacity:1; transform: scale(1); }
            }

            /* CSS tambahan untuk override text-align center */
            #testimoni .t-mini-quote,
            #testimoni .t-mini-quote-wrapper {
                text-align: left !important;
            }
        `;
        document.head.appendChild(style);


        (function(){
            const input = document.getElementById('photoInput');
            const name  = document.getElementById('photoName');
            if(!input || !name) return;

            input.addEventListener('change', function(){
                const file = input.files && input.files[0];
                if (file) {
                    const allowedTypes = ['image/jpeg', 'image/jpg', 'image/png'];
                    if (!allowedTypes.includes(file.type)) {
                        showStatusModal(false, 'Format File Tidak Sesuai', 'Gagal memilih file. Format foto yang diperbolehkan hanya <strong>JPG, JPEG, atau PNG</strong>.');
                        input.value = '';
                        name.textContent = 'Belum ada foto dipilih';
                        return;
                    }
                    if (file.size > 5 * 1024 * 1024) {
                        showStatusModal(false, 'Ukuran File Terlalu Besar', 'Gagal memilih file. Ukuran foto maksimal adalah 5MB. File yang Anda pilih berukuran <strong>' + (file.size / (1024 * 1024)).toFixed(2) + 'MB</strong>.');
                        input.value = '';
                        name.textContent = 'Belum ada foto dipilih';
                        return;
                    }
                    name.textContent = file.name;
                } else {
                    name.textContent = 'Belum ada foto dipilih';
                }
            });
        })();

    </script>
</section>


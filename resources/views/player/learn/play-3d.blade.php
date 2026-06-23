{{-- resources/views/player/learn/play-3d.blade.php --}}
@php
    $player      = $player ?? (object)['xp_total'=>0,'coins'=>0,'hearts'=>5,'hearts_max'=>5,'nickname'=>'Player','avatar_key'=>1];
    $levelTitle  = $level->title ?? 'Eksplorasi 3D Budaya Aceh';
    $islandSlug  = $level->island?->slug ?? 'sumatera';
    $islandColors= $islandColors ?? [];
    $accent      = $islandColors[$islandSlug] ?? '#f97316';
    $islandLabel = strtoupper($level->island?->subtitle ?? $level->island?->name ?? 'PULAU');
    $nickname    = (string)($player->nickname ?? $player->display_name ?? 'Player');
    
    $deductUrl   = route('game.storyline.deduct-heart', $level->id);
    $completeUrl = route('game.storyline.complete', $level->id);
    $refillUrl   = route('game.hearts.refill');
    $learnUrl    = route('game.learn');
    $csrfToken   = csrf_token();
@endphp
<!doctype html>
<html lang="id">
<head>
    <script>
        window.onerror = function(message, source, lineno, colno, error) {
            const errorDiv = document.createElement('div');
            errorDiv.style.position = 'fixed';
            errorDiv.style.top = '10px';
            errorDiv.style.left = '10px';
            errorDiv.style.right = '10px';
            errorDiv.style.background = 'rgba(239, 68, 68, 0.95)';
            errorDiv.style.color = '#fff';
            errorDiv.style.padding = '16px';
            errorDiv.style.borderRadius = '8px';
            errorDiv.style.zIndex = '99999';
            errorDiv.style.fontFamily = 'monospace';
            errorDiv.style.fontSize = '12px';
            errorDiv.style.whiteSpace = 'pre-wrap';
            errorDiv.style.maxHeight = '80vh';
            errorDiv.style.overflowY = 'auto';
            errorDiv.style.boxShadow = '0 10px 25px rgba(0,0,0,0.5)';
            
            errorDiv.innerHTML = '<strong>[JS ERROR]</strong><br>' + message + 
                                 '<br><br><strong>Source:</strong> ' + source + ':' + lineno + ':' + colno +
                                 (error && error.stack ? '<br><br><strong>Stack Trace:</strong><br>' + error.stack : '');
                                 
            document.body.appendChild(errorDiv);
            return false;
        };
    </script>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>{{ $levelTitle }} — Lentara Nusantara</title>
    <link rel="icon" type="image/png" href="{{ asset('images/icon/icon_lentara.png') }}">
    <script>(function(){const t=localStorage.getItem('piforrr-theme')||'dark';document.documentElement.setAttribute('data-theme',t);})();</script>
    <!-- Three.js from CDN -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/three.js/r128/three.min.js"></script>
    <style>
        :root {
            --accent: {{ $accent }};
            --bg: #020617;
            --card: rgba(15, 23, 42, 0.85);
            --line: rgba(255, 255, 255, 0.12);
            --txt: #e5e7eb;
            --muted: #94a3b8;
            --danger: #ef4444;
            --ok: #22c55e;
        }
        *,*::before,*::after { box-sizing: border-box; margin: 0; padding: 0; }
        html, body { 
            height: 100%; 
            overflow: hidden; 
            font-family: ui-sans-serif,system-ui,-apple-system,BlinkMacSystemFont,Segoe UI,Roboto,Arial,sans-serif;
            background-color: #000;
            user-select: none;
            -webkit-user-select: none;
        }
        #gameCanvas {
            position: absolute;
            inset: 0;
            width: 100%;
            height: 100%;
            z-index: 1;
        }

        /* ═══════════════════════════
           HUD / OVERLAYS
        ═══════════════════════════ */
        #hud {
            position: absolute;
            inset: 0;
            z-index: 10;
            pointer-events: none;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            padding: 16px;
        }
        .interactive { pointer-events: auto; }

        /* TOP BAR */
        #hudTopbar {
            display: flex;
            align-items: center;
            justify-content: space-between;
            width: 100%;
            gap: 12px;
        }
        .hud-left { display: flex; align-items: center; gap: 12px; }
        .hud-back {
            width: 44px; height: 44px;
            border-radius: 999px;
            border: 2px solid rgba(255,255,255,.25);
            background: rgba(0,0,0,.45);
            backdrop-filter: blur(8px);
            color: #fff;
            display: grid; place-items: center;
            text-decoration: none;
            cursor: pointer;
            transition: border-color .15s, background .15s;
        }
        .hud-back:hover { border-color: var(--accent); background: rgba(0,0,0,.6); }
        .hud-back svg { width: 20px; height: 20px; }
        .hud-title { display: grid; gap: 2px; text-shadow: 0 2px 4px rgba(0,0,0,.8); }
        .hud-title .sm { font-size: 10px; font-weight: 900; color: rgba(255,255,255,.7); letter-spacing: .15em; }
        .hud-title .lg { font-size: 15px; font-weight: 950; color: #fff; }

        .hud-right { display: flex; align-items: center; gap: 8px; }
        .hud-pill {
            display: inline-flex; align-items: center; gap: 6px;
            padding: 8px 12px;
            border-radius: 999px;
            border: 2px solid rgba(255,255,255,.15);
            background: rgba(0,0,0,.45);
            backdrop-filter: blur(8px);
            font-weight: 950; font-size: 12px; color: #fff;
        }
        .hud-pill svg { width: 14px; height: 14px; }
        .hud-pill.heart { color: #f87171; border-color: rgba(239,68,68,.3); }
        .hud-pill.xp    { color: #60a5fa; border-color: rgba(59,130,246,.3); }
        .hud-pill.coin  { color: #fbbf24; border-color: rgba(245,158,11,.3); }

        /* QUEST BOX & CONTROLS INFO */
        #questPanel {
            position: absolute;
            top: 80px;
            left: 16px;
            width: min(280px, 90vw);
            background: var(--card);
            border: 1.5px solid var(--line);
            border-radius: 16px;
            padding: 12px;
            backdrop-filter: blur(12px);
            color: #fff;
            box-shadow: 0 8px 32px rgba(0,0,0,.5);
        }
        #questPanel h4 { font-size: 12px; font-weight: 950; color: var(--accent); text-transform: uppercase; margin-bottom: 6px; letter-spacing: .08em; }
        #questText { font-size: 13px; font-weight: 700; line-height: 1.4; }
        .quest-item-check { display: flex; align-items: center; gap: 6px; margin-top: 6px; font-size: 12px; color: var(--muted); }
        .quest-item-check.done { color: var(--ok); text-decoration: line-through; }
        
        #controlsPanel {
            position: absolute;
            top: 80px;
            right: 16px;
            background: rgba(0,0,0,.5);
            border-radius: 12px;
            padding: 8px 12px;
            color: rgba(255,255,255,.7);
            font-size: 11px;
            font-weight: 800;
            display: flex;
            flex-direction: column;
            gap: 4px;
            backdrop-filter: blur(4px);
        }
        .ctrl-row { display: flex; justify-content: space-between; gap: 14px; }
        .ctrl-row kbd { background: rgba(255,255,255,.2); padding: 1px 4px; border-radius: 4px; font-family: monospace; color: #fff; }

        /* MIDDLE MESSAGE POPUP */
        #dialogOverlay {
            position: absolute;
            bottom: 24px;
            left: 50%;
            transform: translateX(-50%);
            width: min(640px, 94vw);
            z-index: 15;
            display: none;
        }
        .dialog-box {
            background: rgba(8, 14, 36, 0.94);
            border: 2px solid var(--line);
            border-radius: 20px;
            padding: 18px;
            color: #fff;
            backdrop-filter: blur(16px);
            box-shadow: 0 12px 40px rgba(0,0,0,.7);
            position: relative;
        }
        .dialog-box::before {
            content: '';
            position: absolute; top: 0; left: 0; right: 0; height: 3px;
            background: linear-gradient(90deg, var(--accent), #fbcfe8);
        }
        .dialog-speaker {
            font-size: 12px; font-weight: 950; color: var(--accent); margin-bottom: 6px; text-transform: uppercase; letter-spacing: .05em;
        }
        .dialog-text {
            font-size: 14px; font-weight: 700; line-height: 1.5; color: rgba(255,255,255,.9);
        }
        .dialog-choices {
            display: grid; gap: 8px; margin-top: 12px;
        }
        .choice-btn {
            width: 100%;
            padding: 10px 14px;
            border-radius: 12px;
            border: 2px solid rgba(255,255,255,.2);
            background: rgba(255,255,255,.05);
            color: #fff;
            font-weight: 800; font-size: 13px; text-align: left;
            cursor: pointer;
            transition: all .15s ease;
        }
        .choice-btn:hover { border-color: var(--accent); background: rgba(255,255,255,.1); }
        .choice-btn.correct { border-color: var(--ok); background: rgba(34,197,94,.15); color: #86efac; }
        .choice-btn.wrong { border-color: var(--danger); background: rgba(239,68,68,.15); color: #fca5a5; }
        .dialog-btn-next {
            margin-top: 10px;
            padding: 6px 12px;
            border-radius: 8px;
            border: none;
            background: var(--accent);
            color: #000;
            font-weight: 900; font-size: 12px;
            float: right;
            cursor: pointer;
        }

        /* SOUND MUTE BUTTON */
        #btnMute {
            position: absolute;
            bottom: 24px;
            right: 24px;
            width: 48px; height: 48px;
            border-radius: 999px;
            border: 2px solid rgba(255,255,255,.2);
            background: rgba(0,0,0,.5);
            color: #fff;
            display: grid; place-items: center;
            cursor: pointer;
            z-index: 12;
            backdrop-filter: blur(8px);
            transition: all .2s;
        }
        #btnMute:hover { border-color: var(--accent); transform: scale(1.05); }

        /* VIRTUAL JOYSTICK FOR MOBILE */
        #joystickContainer {
            position: absolute;
            bottom: 24px;
            left: 24px;
            width: 100px;
            height: 100px;
            background: rgba(255,255,255,0.08);
            border: 2px solid rgba(255,255,255,0.2);
            border-radius: 999px;
            display: none; /* Only show on touch devices */
            place-items: center;
            touch-action: none;
            z-index: 12;
        }
        #joystickKnob {
            width: 44px;
            height: 44px;
            background: rgba(255,255,255,0.3);
            border: 1px solid rgba(255,255,255,0.6);
            border-radius: 999px;
            pointer-events: none;
            transition: transform 0.05s ease;
        }

        /* ═══════════════════════════
           MODALS (WIN, DEFEAT, EXIT)
        ═══════════════════════════ */
        .vn-modal-wrap {
            position: fixed; inset: 0; z-index: 100;
            display: flex; align-items: center; justify-content: center;
            padding: 20px;
            background: rgba(0,0,0,.85);
            backdrop-filter: blur(8px);
        }
        .vn-modal-wrap.hidden { display: none; }
        .vn-modal {
            width: min(440px, 94vw);
            border-radius: 28px;
            border: 2.5px solid var(--line);
            background: #0b1122;
            overflow: hidden;
            position: relative;
            box-shadow: 0 20px 50px rgba(0,0,0,.8);
        }
        .vn-modal::before {
            content: '';
            position: absolute; top: 0; left: 0; right: 0; height: 4px;
            background: linear-gradient(90deg, var(--accent), #fde68a);
        }
        .vn-modal-inner { padding: 32px 24px; text-align: center; }
        .vn-modal-emoji { font-size: 60px; line-height: 1; margin-bottom: 16px; }
        .vn-modal-title { font-size: 24px; font-weight: 1000; color: #fff; margin-bottom: 8px; }
        .vn-modal-sub   { font-size: 14px; color: var(--muted); margin-bottom: 22px; line-height: 1.6; }
        .vn-modal-stats { display: grid; grid-template-columns: 1fr 1fr; gap: 12px; margin-bottom: 22px; }
        .vn-modal-stat {
            border-radius: 16px; border: 1.5px solid var(--line);
            background: rgba(255,255,255,.03);
            padding: 12px;
            display: flex; flex-direction: column; align-items: center; gap: 4px;
        }
        .vn-modal-stat .sk { font-size: 10px; font-weight: 800; color: var(--muted); letter-spacing:.1em; }
        .vn-modal-stat .sv { font-size: 22px; font-weight: 950; color: #fff; }
        .vn-modal-actions { display: flex; flex-direction: column; gap: 10px; }
        .vn-modal-btn {
            padding: 14px;
            border-radius: 16px;
            border: 2px solid transparent;
            font-weight: 950; font-size: 15px;
            cursor: pointer;
            text-decoration: none;
            display: flex; align-items: center; justify-content: center;
            transition: all .2s;
        }
        .vn-modal-btn.primary { background: var(--accent); color: #0b1220; box-shadow: 0 10px 24px rgba(249,115,22,.2); }
        .vn-modal-btn.primary:hover { filter: brightness(1.1); transform: translateY(-1px); }
        .vn-modal-btn.ghost { background: rgba(255,255,255,.05); border-color: var(--line); color: #fff; }
        .vn-modal-btn.ghost:hover { background: rgba(255,255,255,.1); }
        .vn-modal-btn.danger { background: rgba(239,68,68,.12); border-color: rgba(239,68,68,.3); color: #f87171; }
        .vn-modal-btn.danger:hover { background: rgba(239,68,68,.2); }

        .hud-pill.timer { color: #f43f5e; border-color: rgba(244,63,94,.3); font-family: monospace; font-size: 14px; }
        .hud-pill.timer.low-time { animation: pulse-red 1s infinite alternate; }
        @keyframes pulse-red {
            0% { transform: scale(1); box-shadow: 0 0 0 rgba(244,63,94,0); }
            100% { transform: scale(1.08); box-shadow: 0 0 12px rgba(244,63,94,0.4); border-color: rgba(244,63,94,0.8); }
        }

        /* Stall Modal Custom Styling */
        #stallModal .vn-modal {
            border: 2px solid rgba(255, 255, 255, 0.15);
            background: rgba(11, 17, 34, 0.94);
            backdrop-filter: blur(20px);
        }
        #stallItemsGrid .choice-btn {
            background: rgba(255, 255, 255, 0.03);
            border: 1.5px solid rgba(255, 255, 255, 0.08);
            border-radius: 12px;
            transition: all 0.2s ease;
            cursor: pointer;
        }
        #stallItemsGrid .choice-btn:hover {
            background: rgba(249, 115, 22, 0.08);
            border-color: var(--accent);
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(249, 115, 22, 0.15);
        }

        /* Storyline Character overlay */
        .story-char-wrap {
            position: absolute;
            bottom: 160px;
            left: 25%;
            transform: translateX(-50%);
            pointer-events: none;
            z-index: 9999;
        }
        #storyChar {
            max-height: 55vh;
            max-width: 45vw;
            object-fit: contain;
            transition: opacity .35s ease, transform .35s ease;
            filter: drop-shadow(0 10px 30px rgba(0,0,0,.7));
            display: none;
        }

        @media (max-width: 640px) {
            #controlsPanel { display: none; }
            #joystickContainer { display: grid; }
            .hud-title .lg { font-size: 13px; }

            .story-char-wrap {
                left: 30%;
                bottom: 155px;
            }
            #storyChar {
                max-height: 60vh;
                max-width: 75vw;
            }
        }
    </style>
</head>
<body>

<canvas id="gameCanvas"></canvas>

<div id="hud">
    <!-- TOP BAR -->
    <div id="hudTopbar" class="interactive">
        <div class="hud-left">
            <button class="hud-back" id="btnExit" title="Keluar">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M15 18l-6-6 6-6"/>
                </svg>
            </button>
            <div class="hud-title">
                <div class="sm">{{ $islandLabel }}</div>
                <div class="lg">{{ $levelTitle }}</div>
            </div>
        </div>
        <div class="hud-right">
            <div class="hud-pill timer" id="timerPill" title="Sisa Waktu">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" style="width:14px;height:14px;margin-right:2px;">
                    <circle cx="12" cy="12" r="10"/>
                    <polyline points="12 6 12 12 16 14"/>
                </svg>
                <span id="timeLeft">01:30</span>
            </div>
            <div class="hud-pill xp" title="XP">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M13 2s2 3 2 6-2 4-2 4 4-1 4-6 2-4 2-4-1 7-4 10-1 8-1 8-6-3-6-8 4-10 5-10Z"/></svg>
                <span id="xpNum">{{ (int)$player->xp_total }}</span>
            </div>
            <div class="hud-pill coin" title="Koin">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><circle cx="12" cy="12" r="8"/><path d="M12 8v8M9 12h6" stroke-linecap="round"/></svg>
                <span id="coinNum">{{ (int)$player->coins }}</span>
            </div>
            <div class="hud-pill heart" title="Hati">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M12 21s-7-4.6-9.2-9.1C1.4 8.9 3.4 6 6.6 6c1.8 0 3.1 1 3.9 2 .8-1 2.1-2 3.9-2 3.2 0 5.2 2.9 3.8 5.9C19 16.4 12 21 12 21Z"/></svg>
                <span id="heartNum">{{ (int)$player->hearts }}</span>/<span>{{ (int)$player->hearts_max }}</span>
            </div>
        </div>
    </div>

    <!-- QUEST PANEL -->
    <div id="questPanel">
        <h4>Tugas Eksplorasi</h4>
        <div id="questText">Cari dan kumpulkan warisan budaya Aceh di sekitar desa!</div>
        <div class="quest-item-check" id="qItem0">☐ Mie Aceh (Kuliner)</div>
        <div class="quest-item-check" id="qItem1">☐ Kopi Gayo (Minuman)</div>
        <div class="quest-item-check" id="qItem2">☐ Pinto Aceh (Kerajinan)</div>
        <div class="quest-item-check" id="qItem3">☐ Rapa'i (Alat Musik)</div>
    </div>

    <!-- CONTROLS INFO (DESKTOP) -->
    <div id="controlsPanel">
        <div class="ctrl-row"><span>Gerak</span><kbd>W</kbd><kbd>A</kbd><kbd>S</kbd><kbd>D</kbd> / <kbd>↑</kbd></div>
        <div class="ctrl-row"><span>Kamera</span><span>Seret Mouse</span></div>
        <div class="ctrl-row"><span>Lompat</span><kbd>Spasi</kbd></div>
    </div>

    <!-- VIRTUAL JOYSTICK (MOBILE) -->
    <div id="joystickContainer" class="interactive">
        <div id="joystickKnob"></div>
    </div>

    <!-- INTERACTION PROMPT -->
    <div id="interactionPrompt" class="interactive" style="display:none; position: absolute; bottom: 120px; left: 50%; transform: translateX(-50%); z-index: 12;">
        <button id="btnInteract" style="
            background: var(--accent);
            color: #0b1220;
            border: none;
            border-radius: 999px;
            padding: 12px 24px;
            font-weight: 950;
            font-size: 14px;
            cursor: pointer;
            box-shadow: 0 8px 24px rgba(249,115,22,0.4);
            display: flex;
            align-items: center;
            gap: 8px;
            transition: transform 0.1s;
        ">
            <span style="background:rgba(0,0,0,0.15); padding: 2px 6px; border-radius: 4px; font-size:11px; font-family:monospace; display:var(--kbd-display, inline-block);">E</span>
            <span id="interactText">Periksa Barang</span>
        </button>
    </div>

    <!-- INTERACTIVE DIALOG OVERLAY -->
    <div id="dialogOverlay" class="interactive">
        <div class="dialog-box">
            <div class="dialog-speaker" id="dialogSpeaker">Laksamana Malahayati</div>
            <div class="dialog-text" id="dialogText">Selamat datang! Tolong kumpulkan barang pusaka kita sebelum melaut.</div>
            <div class="dialog-choices" id="dialogChoices"></div>
            <button class="dialog-btn-next" id="btnDialogNext" style="display:none;">Lanjut</button>
            <div style="clear:both;"></div>
        </div>
    </div>

    <!-- MUTE BUTTON -->
    <button id="btnMute" class="interactive" title="Musik Mulai">
        <svg id="svgSoundOn" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="width:20px;height:20px;">
            <polygon points="11 5 6 9 2 9 2 15 6 15 11 19 11 5"></polygon>
            <path d="M19.07 4.93a10 10 0 0 1 0 14.14M15.54 8.46a5 5 0 0 1 0 7.07"></path>
        </svg>
        <svg id="svgSoundOff" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="width:20px;height:20px;display:none;">
            <polygon points="11 5 6 9 2 9 2 15 6 15 11 19 11 5"></polygon>
            <line x1="23" y1="9" x2="17" y2="15"></line>
            <line x1="17" y1="9" x2="23" y2="15"></line>
        </svg>
    </button>
</div>

<!-- ─── INTRO / OUTRO STORYLINE OVERLAY ──────────────────────────────── -->
<div id="storyOverlay" style="
    position:fixed;inset:0;z-index:9999;
    display:flex;flex-direction:column;
    background:#000;
    font-family:ui-sans-serif,system-ui,-apple-system,Segoe UI,Roboto,Arial;
">
    <!-- Background image layer -->
    <div id="storyBg" style="
        position:absolute;inset:0;
        background-size:cover;background-position:center;
        transition:background-image 0.6s ease;
    "></div>
    <!-- Dark overlay -->
    <div style="position:absolute;inset:0;background:linear-gradient(to top,rgba(0,0,0,.88) 35%,rgba(0,0,0,.3) 100%);"></div>

    <!-- Character portrait -->
    <div class="story-char-wrap">
        <img id="storyChar" src="" alt="">
    </div>

    <!-- Dialog box -->
    <div style="
        position:absolute;bottom:0;left:0;right:0;
        background:linear-gradient(to top,rgba(2,6,23,.97),rgba(2,6,23,.88));
        border-top:1px solid rgba(255,255,255,.08);
        padding:20px 28px 28px;
        backdrop-filter:blur(12px);
    ">
        <!-- Speaker name -->
        <div id="storySpeaker" style="
            font-weight:950;font-size:14px;
            color:#f97316;letter-spacing:.06em;
            text-transform:uppercase;margin-bottom:8px;
        "></div>
        <!-- Dialog text -->
        <div id="storyText" style="
            font-size:clamp(14px,2.2vw,18px);
            font-weight:700;
            color:#e5e7eb;
            line-height:1.65;
            min-height:3.3em;
        "></div>
        <!-- Progress dots + next button -->
        <div style="display:flex;align-items:center;justify-content:space-between;margin-top:14px;">
            <div id="storyDots" style="display:flex;gap:6px;"></div>
            <button id="storyNext" style="
                padding:10px 24px;
                background:linear-gradient(135deg,#f97316,#ea580c);
                color:#fff;border:none;border-radius:12px;
                font-weight:950;font-size:14px;cursor:pointer;
                box-shadow:0 4px 14px rgba(249,115,22,.35);
                transition:transform .15s ease,box-shadow .15s ease;
            " onmouseover="this.style.transform='translateY(-2px)';this.style.boxShadow='0 6px 20px rgba(249,115,22,.5)'"
               onmouseout="this.style.transform='';this.style.boxShadow='0 4px 14px rgba(249,115,22,.35)'">
                Lanjut ▶
            </button>
        </div>
    </div>
</div>

<!-- MODAL: WIN -->
<div class="vn-modal-wrap interactive hidden" id="modalWin">
    <div class="vn-modal">
        <div class="vn-modal-inner">
            <div class="vn-modal-emoji">🏆</div>
            <div class="vn-modal-title">Ekspedisi Selesai!</div>
            <div class="vn-modal-sub">Kamu telah menyelesaikan Ekspedisi Budaya Aceh. Hebat! Pengetahuanmu tentang Serambi Mekkah bertambah!</div>
            <div class="vn-modal-stats">
                <div class="vn-modal-stat">
                    <span class="sk">XP DIDAPAT</span>
                    <span class="sv" id="winXp">+10</span>
                </div>
                <div class="vn-modal-stat">
                    <span class="sk">KOIN</span>
                    <span class="sv" id="winCoins">—</span>
                </div>
            </div>
            <div class="vn-modal-actions">
                <a class="vn-modal-btn primary" href="{{ route('game.learn') }}">Kembali ke Belajar</a>
            </div>
        </div>
    </div>
</div>

<!-- MODAL: HEARTS EMPTY -->
<div class="vn-modal-wrap interactive hidden" id="modalHeartEmpty">
    <div class="vn-modal">
        <div class="vn-modal-inner">
            <div class="vn-modal-emoji">💔</div>
            <div class="vn-modal-title">Hati Habis!</div>
            <div class="vn-modal-sub">Hati kamu habis. Isi ulang dengan 10 koin atau tunggu beberapa menit hingga hati terisi kembali secara otomatis.</div>
            <div class="vn-modal-actions">
                <button class="vn-modal-btn primary" id="btnRefillModal">Isi Ulang Hati (10 💰)</button>
                <a class="vn-modal-btn ghost" href="{{ route('game.learn') }}">Kembali ke Belajar</a>
            </div>
        </div>
    </div>
</div>

<!-- MODAL: EXIT CONFIRM -->
<div class="vn-modal-wrap interactive hidden" id="modalExit">
    <div class="vn-modal">
        <div class="vn-modal-inner">
            <div class="vn-modal-emoji">🚪</div>
            <div class="vn-modal-title">Keluar Ekspedisi?</div>
            <div class="vn-modal-sub">Kemajuan permainan kamu di level ini tidak akan disimpan. Kamu yakin ingin keluar?</div>
            <div class="vn-modal-actions">
                <a class="vn-modal-btn danger" href="{{ route('game.learn') }}">Ya, Keluar</a>
                <button class="vn-modal-btn ghost" id="btnStayModal">Kembali Main</button>
            </div>
        </div>
    </div>
</div>

<!-- MODAL: TIMEOUT -->
<div class="vn-modal-wrap interactive hidden" id="modalTimeout">
    <div class="vn-modal">
        <div class="vn-modal-inner">
            <div class="vn-modal-emoji">⏰</div>
            <div class="vn-modal-title">Waktu Habis!</div>
            <div class="vn-modal-sub">Kamu kehabisan waktu untuk mengumpulkan semua barang pusaka. Hati kamu berkurang 1.</div>
            <div class="vn-modal-actions">
                <button class="vn-modal-btn primary" id="btnRestartTimeout">Main Lagi</button>
                <a class="vn-modal-btn ghost" href="{{ route('game.learn') }}">Kembali ke Belajar</a>
            </div>
        </div>
    </div>
</div>

<!-- MODAL: STALL INTERACTION -->
<div class="vn-modal-wrap interactive hidden" id="stallModal">
    <div class="vn-modal" style="width: min(500px, 94vw);">
        <div class="vn-modal-inner" style="padding: 24px; text-align: center;">
            <div class="vn-modal-title" id="stallModalTitle" style="font-size: 20px; color: var(--accent); margin-bottom: 6px;">Kedai Mie Aceh</div>
            <div class="vn-modal-sub" id="stallModalSub" style="margin-bottom: 16px;">Pilih salah satu hidangan di warung ini untuk diperiksa secara detail:</div>
            
            <!-- Grid of choices -->
            <div id="stallItemsGrid" style="display: grid; grid-template-columns: 1fr; gap: 10px; margin-bottom: 20px; text-align: left;">
                <!-- Dynamically filled -->
            </div>
            
            <div class="vn-modal-actions">
                <button class="vn-modal-btn ghost" id="btnStallClose" style="width: 100%;">Tutup Menu</button>
            </div>
        </div>
    </div>
</div>

<!-- SFX: correct / wrong (same files as storyline) -->
<audio id="sfxCorrect" src="{{ asset('audio/benar.m4a') }}" preload="auto"></audio>
<audio id="sfxWrong"   src="{{ asset('audio/salah.m4a') }}" preload="auto"></audio>

<script>
(function () {
    // ─── LARAVEL PAYLOAD ──────────────────────────────────────────────
    const CSRF          = @json($csrfToken);
    const DEDUCT_URL    = @json($deductUrl);
    const COMPLETE_URL  = @json($completeUrl);
    const REFILL_URL    = @json($refillUrl);

    let hearts        = {{ (int)$player->hearts }};
    let heartsMax     = {{ (int)$player->hearts_max }};
    let xp            = {{ (int)$player->xp_total }};
    let coins         = {{ (int)$player->coins }};
    let isCompleted   = false;
    let timeLeft      = 90;
    let gameTimer     = null;
    let animFrameId   = null;   // requestAnimationFrame ID (for WebGL recovery)
    const mouse       = new THREE.Vector2();
    const raycaster   = new THREE.Raycaster();

    // ─── AUDIO SYNTHESIZER (BUNGONG JEUMPA MELODY) ─────────────────────
    let audioCtx = null;
    let mainOsc = null;
    let mainGain = null;
    let isMuted = false;        // Default: ON (musik langsung nyala saat user berinteraksi)
    let audioStarted = false;   // Sudah diinit belum?
    let nextNoteTime = 0;
    let noteIndex = 0;
    let schedulerTimer = null;

    // Frequencies: G3=196, A3=220, B3=247, C4=262, D4=294, E4=330, F4=349, G4=392, A4=440, B4=494, C5=523, D5=587, E5=659
    const bungongJeumpa = [
        { f: 392, d: 0.4 }, // Sol - Bun
        { f: 440, d: 0.4 }, // La  - gong
        { f: 523, d: 0.8 }, // Do  - jeum
        { f: 523, d: 0.4 }, // Do  - pa
        { f: 523, d: 0.4 }, // Do  - bun
        { f: 587, d: 0.4 }, // Re  - gong
        { f: 523, d: 0.4 }, // Do  - jeum
        { f: 440, d: 0.4 }, // La  - pa
        { f: 392, d: 0.8 }, // Sol
        { f: 0,   d: 0.2 }, // rest
        // Repeat
        { f: 392, d: 0.4 }, // Sol - Bun
        { f: 440, d: 0.4 }, // La  - gong
        { f: 523, d: 0.8 }, // Do  - jeum
        { f: 523, d: 0.4 }, // Do  - pa
        { f: 523, d: 0.4 }, // Do  - bun
        { f: 587, d: 0.4 }, // Re  - gong
        { f: 523, d: 0.4 }, // Do  - jeum
        { f: 440, d: 0.4 }, // La  - pa
        { f: 392, d: 0.8 }, // Sol
        { f: 0,   d: 0.4 }, // rest
        // Verse 2
        { f: 587, d: 0.4 }, // Re  - Puteh
        { f: 659, d: 0.4 }, // E5  - kun
        { f: 587, d: 0.4 }, // Re  - yeng
        { f: 523, d: 0.4 }, // Do  - meureu
        { f: 587, d: 0.8 }, // Re  - bok
        { f: 523, d: 0.4 }, // Do  - keu
        { f: 440, d: 0.4 }, // La  - lah
        { f: 523, d: 0.8 }, // Do  - tas
        { f: 0,   d: 0.4 }, // rest
    ];

    function initAudio() {
        if (audioStarted) {
            // Already running — just resume if suspended
            if (audioCtx && audioCtx.state === 'suspended') audioCtx.resume();
            return;
        }
        audioStarted = true;
        audioCtx = new (window.AudioContext || window.webkitAudioContext)();
        mainGain = audioCtx.createGain();
        mainGain.gain.setValueAtTime(0.12, audioCtx.currentTime);
        mainGain.connect(audioCtx.destination);
        startScheduler();
        // Update mute button icon to reflect music is ON
        const svgOn  = document.getElementById('svgSoundOn');
        const svgOff = document.getElementById('svgSoundOff');
        if (svgOn)  svgOn.style.display  = 'block';
        if (svgOff) svgOff.style.display = 'none';
        document.getElementById('btnMute').title = "Matikan Musik";
    }

    // ─── AUTO-START: init music on FIRST user interaction ────────────
    function onFirstInteraction() {
        if (audioStarted) return;
        initAudio();
        // Remove listeners after first fire
        ['click','keydown','touchstart'].forEach(ev =>
            document.removeEventListener(ev, onFirstInteraction, { once: true })
        );
    }
    document.addEventListener('click',      onFirstInteraction, { once: true });
    document.addEventListener('keydown',    onFirstInteraction, { once: true });
    document.addEventListener('touchstart', onFirstInteraction, { once: true, passive: true });

    function playNote(freq, start, duration) {
        if (freq === 0 || !audioCtx) return; // rest
        
        let osc = audioCtx.createOscillator();
        let gain = audioCtx.createGain();
        
        // Soft wooden pluck / kalimba synth: Triangle wave with envelope
        osc.type = 'triangle';
        osc.frequency.setValueAtTime(freq, start);
        
        // Use non-zero values for exponential ramps to prevent audio context failures
        gain.gain.setValueAtTime(0.0001, start);
        gain.gain.linearRampToValueAtTime(0.15, start + 0.02);
        gain.gain.exponentialRampToValueAtTime(0.0001, start + duration - 0.05);
        
        osc.connect(gain);
        gain.connect(mainGain);
        
        // Disconnect nodes on complete to prevent massive audio graph accumulation memory leak
        osc.onended = () => {
            osc.disconnect();
            gain.disconnect();
        };
        
        osc.start(start);
        osc.stop(start + duration);
    }

    function scheduler() {
        while (nextNoteTime < audioCtx.currentTime + 0.2) {
            let note = bungongJeumpa[noteIndex];
            if (!isMuted) {
                playNote(note.f, nextNoteTime, note.d);
            }
            nextNoteTime += note.d;
            noteIndex = (noteIndex + 1) % bungongJeumpa.length;
        }
        schedulerTimer = setTimeout(scheduler, 50);
    }

    function startScheduler() {
        nextNoteTime = audioCtx.currentTime;
        scheduler();
    }

    function toggleMute() {
        if (!audioCtx) {
            // First click on mute button itself — init audio
            initAudio();
        }
        isMuted = !isMuted;
        
        const svgOn = document.getElementById('svgSoundOn');
        const svgOff = document.getElementById('svgSoundOff');
        const btnMute = document.getElementById('btnMute');
        
        if (isMuted) {
            svgOn.style.display = 'none';
            svgOff.style.display = 'block';
            btnMute.title = "Nyalakan Musik";
        } else {
            if (audioCtx.state === 'suspended') {
                audioCtx.resume();
            }
            svgOn.style.display = 'block';
            svgOff.style.display = 'none';
            btnMute.title = "Matikan Musik";
        }
    }

    function playCorrectSound() {
        if (isMuted) return;
        try {
            const sfx = document.getElementById('sfxCorrect');
            sfx.currentTime = 0;
            sfx.play().catch(() => {});
        } catch(e) {}
    }

    function playWrongSound() {
        if (isMuted) return;
        try {
            const sfx = document.getElementById('sfxWrong');
            sfx.currentTime = 0;
            sfx.play().catch(() => {});
        } catch(e) {}
    }

    document.getElementById('btnMute').addEventListener('click', toggleMute);

    // ─── HUD UTILS ────────────────────────────────────────────────────
    const heartNumEl  = document.getElementById('heartNum');
    const xpNumEl     = document.getElementById('xpNum');
    const coinNumEl   = document.getElementById('coinNum');

    function updateHUD() {
        heartNumEl.textContent = hearts;
        xpNumEl.textContent    = xp;
        coinNumEl.textContent  = coins;
    }

    // ─── THREE.JS 3D SCENE SETUP ──────────────────────────────────────
    const canvas = document.getElementById('gameCanvas');
    const scene = new THREE.Scene();
    scene.background = new THREE.Color('#cbd5e1'); // Cloudy light blue-gray sky
    scene.fog = new THREE.FogExp2('#cbd5e1', 0.012);

    const camera = new THREE.PerspectiveCamera(60, window.innerWidth / window.innerHeight, 0.1, 1000);
    const renderer = new THREE.WebGLRenderer({ canvas: canvas, antialias: true });
    renderer.setSize(window.innerWidth, window.innerHeight);
    renderer.setPixelRatio(Math.min(window.devicePixelRatio, 2));
    renderer.shadowMap.enabled = true;
    renderer.shadowMap.type = THREE.PCFSoftShadowMap;

    // Lights (Bright daytime overcast/cloudy diffused light)
    const ambientLight = new THREE.AmbientLight('#ffffff', 0.70);
    scene.add(ambientLight);

    const dirLight = new THREE.DirectionalLight('#f8fafc', 0.65);
    dirLight.position.set(20, 45, 20);
    dirLight.castShadow = true;
    dirLight.shadow.mapSize.width = 1024;
    dirLight.shadow.mapSize.height = 1024;
    dirLight.shadow.camera.near = 0.5;
    dirLight.shadow.camera.far = 150;
    const dSide = 40;
    dirLight.shadow.camera.left = -dSide;
    dirLight.shadow.camera.right = dSide;
    dirLight.shadow.camera.top = dSide;
    dirLight.shadow.camera.bottom = -dSide;
    scene.add(dirLight);

    // ─── FLOATING LOW-POLY CLOUDS (Berawan) ───────────────────────────
    const cloudMat = new THREE.MeshStandardMaterial({ color: '#ffffff', roughness: 0.95, flatShading: true });
    function createCloud(cx, cy, cz, scale = 1) {
        const cloud = new THREE.Group();
        cloud.position.set(cx, cy, cz);
        cloud.scale.set(scale, scale, scale);

        const s1 = new THREE.Mesh(new THREE.SphereGeometry(1.2, 8, 8), cloudMat);
        s1.castShadow = true;
        cloud.add(s1);

        const s2 = new THREE.Mesh(new THREE.SphereGeometry(0.8, 8, 8), cloudMat);
        s2.position.set(-1.0, -0.2, 0);
        cloud.add(s2);

        const s3 = new THREE.Mesh(new THREE.SphereGeometry(0.85, 8, 8), cloudMat);
        s3.position.set(1.0, -0.2, 0);
        cloud.add(s3);

        const s4 = new THREE.Mesh(new THREE.SphereGeometry(0.7, 8, 8), cloudMat);
        s4.position.set(-0.5, 0.4, 0.4);
        cloud.add(s4);

        const s5 = new THREE.Mesh(new THREE.SphereGeometry(0.75, 8, 8), cloudMat);
        s5.position.set(0.5, 0.4, -0.4);
        cloud.add(s5);

        scene.add(cloud);
    }
    createCloud(-25, 20, -25, 2.0);
    createCloud(-15, 22, 15, 1.8);
    createCloud(20, 24, -20, 2.2);
    createCloud(25, 18, 25, 1.5);
    createCloud(-5, 25, -30, 2.5);
    createCloud(5, 21, 30, 1.7);
    createCloud(-30, 23, 10, 2.0);
    createCloud(30, 22, -5, 1.9);
    createCloud(0, 26, 0, 2.3);
    createCloud(-10, 19, -5, 1.6);

    // ─── PROCEDURAL 3D MODELS (LOW POLY) ──────────────────────────────
    
    // 1. Terrain / Island
    const terrainGroup = new THREE.Group();
    scene.add(terrainGroup);

    // Grass center
    const grassGeo = new THREE.CylinderGeometry(35, 36, 4, 16);
    const grassMat = new THREE.MeshStandardMaterial({ color: '#2d6a4f', roughness: 0.8, flatShading: true });
    const grassMesh = new THREE.Mesh(grassGeo, grassMat);
    grassMesh.position.y = -2;
    grassMesh.receiveShadow = true;
    terrainGroup.add(grassMesh);

    // Beach ring
    const beachGeo = new THREE.CylinderGeometry(40, 42, 3.8, 16);
    const beachMat = new THREE.MeshStandardMaterial({ color: '#e9c46a', roughness: 0.9, flatShading: true });
    const beachMesh = new THREE.Mesh(beachGeo, beachMat);
    beachMesh.position.y = -2.1;
    beachMesh.receiveShadow = true;
    terrainGroup.add(beachMesh);

    // Ocean plane
    const oceanGeo = new THREE.PlaneGeometry(300, 300, 24, 24);
    const oceanMat = new THREE.MeshStandardMaterial({ 
        color: '#0077b6', 
        transparent: true, 
        opacity: 0.8,
        roughness: 0.2, 
        flatShading: true 
    });
    const oceanMesh = new THREE.Mesh(oceanGeo, oceanMat);
    oceanMesh.rotation.x = -Math.PI / 2;
    oceanMesh.position.y = -2.8;
    scene.add(oceanMesh);

    // 2. traditional Rumoh Aceh (Stilt House)
    const houseGroup = new THREE.Group();
    houseGroup.position.set(0, 0, -12);
    scene.add(houseGroup);

    // Materials
    const darkWoodMat = new THREE.MeshStandardMaterial({ color: '#1c130c', roughness: 0.85 }); // Hampir hitam
    const blackWoodMat = new THREE.MeshStandardMaterial({ color: '#0c0c0c', roughness: 0.9 }); // Hitam tiang
    const goldMat = new THREE.MeshStandardMaterial({ color: '#d97706', roughness: 0.2, metalness: 0.8 }); // Emas ukiran
    const redMat = new THREE.MeshStandardMaterial({ color: '#991b1b', roughness: 0.6 }); // Merah ukiran
    const thatchMat = new THREE.MeshStandardMaterial({ color: '#4a3b32', roughness: 0.95, flatShading: true }); // Atap rumbia
    const stoneMat = new THREE.MeshStandardMaterial({ color: '#cbd5e1', roughness: 0.9 }); // Batu alas tiang

    // Pillars Grid (5x3 pillars = 15 pillars with stone bases)
    const pillarPositionsX = [-3.2, -1.6, 0, 1.6, 3.2];
    const pillarPositionsZ = [-2.0, 0, 2.0];
    
    pillarPositionsX.forEach(x => {
        pillarPositionsZ.forEach(z => {
            // Wood column
            const pillar = new THREE.Mesh(new THREE.CylinderGeometry(0.1, 0.1, 2.2), blackWoodMat);
            pillar.position.set(x, 1.1, z);
            pillar.castShadow = true;
            houseGroup.add(pillar);

            // Stone base (alas tiang)
            const base = new THREE.Mesh(new THREE.CylinderGeometry(0.18, 0.24, 0.25, 6), stoneMat);
            base.position.set(x, 0.125, z);
            base.receiveShadow = true;
            houseGroup.add(base);
        });
    });

    // Floor Base (Panggung)
    const floorGeo = new THREE.BoxGeometry(7.2, 0.2, 4.6);
    const floor = new THREE.Mesh(floorGeo, darkWoodMat);
    floor.position.y = 2.2;
    floor.receiveShadow = true;
    floor.castShadow = true;
    houseGroup.add(floor);

    // Walls (Dinding Hitam)
    const backWall = new THREE.Mesh(new THREE.BoxGeometry(7.2, 2, 0.15), darkWoodMat);
    backWall.position.set(0, 3.2, -2.2);
    backWall.castShadow = true;
    houseGroup.add(backWall);

    const leftWall = new THREE.Mesh(new THREE.BoxGeometry(0.15, 2, 4.4), darkWoodMat);
    leftWall.position.set(-3.52, 3.2, 0);
    leftWall.castShadow = true;
    houseGroup.add(leftWall);

    const rightWall = new THREE.Mesh(new THREE.BoxGeometry(0.15, 2, 4.4), darkWoodMat);
    rightWall.position.set(3.52, 3.2, 0);
    rightWall.castShadow = true;
    houseGroup.add(rightWall);

    // Front Wall (with door)
    const frontWallLeft = new THREE.Mesh(new THREE.BoxGeometry(2.6, 2, 0.15), darkWoodMat);
    frontWallLeft.position.set(-2.2, 3.2, 2.2);
    frontWallLeft.castShadow = true;
    houseGroup.add(frontWallLeft);

    const frontWallRight = new THREE.Mesh(new THREE.BoxGeometry(2.6, 2, 0.15), darkWoodMat);
    frontWallRight.position.set(2.2, 3.2, 2.2);
    frontWallRight.castShadow = true;
    houseGroup.add(frontWallRight);

    const frontWallTop = new THREE.Mesh(new THREE.BoxGeometry(2.0, 0.5, 0.15), darkWoodMat);
    frontWallTop.position.set(0, 3.95, 2.2);
    frontWallTop.castShadow = true;
    houseGroup.add(frontWallTop);

    // Traditional Ornaments (Carvings) on front wall
    // Gold stripe bottom
    const goldStripe = new THREE.Mesh(new THREE.BoxGeometry(7.0, 0.08, 0.18), goldMat);
    goldStripe.position.set(0, 2.35, 2.22);
    houseGroup.add(goldStripe);

    // Red stripe middle
    const redStripe = new THREE.Mesh(new THREE.BoxGeometry(7.0, 0.06, 0.18), redMat);
    redStripe.position.set(0, 3.0, 2.22);
    houseGroup.add(redStripe);

    // Gold stripe top
    const goldStripeTop = new THREE.Mesh(new THREE.BoxGeometry(7.0, 0.08, 0.18), goldMat);
    goldStripeTop.position.set(0, 4.1, 2.22);
    houseGroup.add(goldStripeTop);

    // Shutter windows (Red) slightly open
    for (let x = -2.6; x <= 2.6; x += 5.2) {
        const windowLeft = new THREE.Mesh(new THREE.BoxGeometry(0.35, 0.7, 0.04), redMat);
        windowLeft.position.set(x - 0.2, 3.2, 2.24);
        windowLeft.rotation.y = -0.5;
        houseGroup.add(windowLeft);

        const windowRight = new THREE.Mesh(new THREE.BoxGeometry(0.35, 0.7, 0.04), redMat);
        windowRight.position.set(x + 0.2, 3.2, 2.24);
        windowRight.rotation.y = 0.5;
        houseGroup.add(windowRight);
    }

    // Front Veranda Balustrade (Pagar teras)
    const verandaFloor = new THREE.Mesh(new THREE.BoxGeometry(7.2, 0.15, 0.6), darkWoodMat);
    verandaFloor.position.set(0, 2.2, 2.5);
    houseGroup.add(verandaFloor);

    // Railing
    const railTop = new THREE.Mesh(new THREE.BoxGeometry(7.2, 0.06, 0.06), blackWoodMat);
    railTop.position.set(0, 2.7, 2.78);
    houseGroup.add(railTop);

    for (let x = -3.4; x <= 3.4; x += 0.4) {
        if (Math.abs(x) < 0.6) continue; // Leave door entrance open
        const baluster = new THREE.Mesh(new THREE.CylinderGeometry(0.02, 0.02, 0.5), goldMat);
        baluster.position.set(x, 2.45, 2.78);
        houseGroup.add(baluster);
    }

    // Front Decorated Triangular Gable (Segitiga Sewe)
    const gableGroup = new THREE.Group();
    gableGroup.position.set(0, 4.2, 2.22);
    houseGroup.add(gableGroup);

    // Outer black triangle
    const mainGable = new THREE.Mesh(new THREE.ConeGeometry(3.6, 2.4, 4), darkWoodMat);
    mainGable.rotation.y = Math.PI / 4;
    mainGable.scale.set(1, 1, 0.05);
    mainGable.position.y = 1.2;
    mainGable.castShadow = true;
    gableGroup.add(mainGable);

    // Inside red triangle (slightly smaller)
    const redGable = new THREE.Mesh(new THREE.ConeGeometry(3.1, 2.0, 4), redMat);
    redGable.rotation.y = Math.PI / 4;
    redGable.scale.set(1, 1, 0.06);
    redGable.position.set(0, 1.0, 0.02);
    gableGroup.add(redGable);

    // Inside gold triangle (even smaller)
    const goldGable = new THREE.Mesh(new THREE.ConeGeometry(2.4, 1.5, 4), goldMat);
    goldGable.rotation.y = Math.PI / 4;
    goldGable.scale.set(1, 1, 0.07);
    goldGable.position.set(0, 0.75, 0.04);
    gableGroup.add(goldGable);

    // Roof (Two long slopes meeting at top)
    const roofGroup = new THREE.Group();
    roofGroup.position.set(0, 4.2, 0);
    houseGroup.add(roofGroup);

    // Left slope
    const roofLeft = new THREE.Mesh(new THREE.BoxGeometry(0.12, 3.6, 5.8), thatchMat);
    roofLeft.position.set(-1.45, 1.28, 0.2);
    roofLeft.rotation.z = -0.72;
    roofLeft.castShadow = true;
    roofGroup.add(roofLeft);

    // Right slope
    const roofRight = new THREE.Mesh(new THREE.BoxGeometry(0.12, 3.6, 5.8), thatchMat);
    roofRight.position.set(1.45, 1.28, 0.2);
    roofRight.rotation.z = 0.72;
    roofRight.castShadow = true;
    roofGroup.add(roofRight);

    // Roof Ridge Cap (Bubungan Emas)
    const ridgeCap = new THREE.Mesh(new THREE.CylinderGeometry(0.1, 0.1, 5.8), goldMat);
    ridgeCap.rotation.x = Math.PI / 2;
    ridgeCap.position.set(0, 2.65, 0.2);
    roofGroup.add(ridgeCap);

    // Stairs with Railings
    const stairGroup = new THREE.Group();
    stairGroup.position.set(0, 0, 2.8);
    houseGroup.add(stairGroup);

    // Left stair rail
    const leftRail = new THREE.Mesh(new THREE.BoxGeometry(0.08, 0.08, 3.2), blackWoodMat);
    leftRail.position.set(-0.55, 1.1, 1.1);
    leftRail.rotation.x = 0.78;
    stairGroup.add(leftRail);

    // Right stair rail
    const rightRail = new THREE.Mesh(new THREE.BoxGeometry(0.08, 0.08, 3.2), blackWoodMat);
    rightRail.position.set(0.55, 1.1, 1.1);
    rightRail.rotation.x = 0.78;
    stairGroup.add(rightRail);

    // Steps
    for (let i = 0; i < 5; i++) {
        const step = new THREE.Mesh(new THREE.BoxGeometry(1.0, 0.14, 0.35), darkWoodMat);
        step.position.set(0, 0.15 + (i * 0.44), 2.0 - (i * 0.45));
        step.castShadow = true;
        stairGroup.add(step);
    }

    // 3. Palm Trees (Coconut Trees)
    const treeMatTrunk = new THREE.MeshStandardMaterial({ color: '#593d25', roughness: 0.9 });
    const treeMatLeaves = new THREE.MeshStandardMaterial({ color: '#1b4332', roughness: 0.7, flatShading: true });

    function createPalmTree(x, z, scale = 1) {
        const tree = new THREE.Group();
        tree.position.set(x, 0, z);
        tree.scale.set(scale, scale, scale);
        
        let height = 7;
        let segments = 7;
        let currY = 0;
        
        // Curved trunk segments
        for (let i = 0; i < segments; i++) {
            const seg = new THREE.Mesh(new THREE.CylinderGeometry(0.2 - i*0.01, 0.23 - i*0.01, 1.2), treeMatTrunk);
            seg.position.set(Math.sin(i*0.2) * 0.2, currY + 0.6, 0);
            seg.rotation.z = -0.08 * i;
            seg.castShadow = true;
            tree.add(seg);
            currY += 1.1;
        }

        // Fronds (Leaves) at the top
        const leavesGroup = new THREE.Group();
        leavesGroup.position.set(Math.sin((segments-1)*0.2)*0.2, currY, 0);
        tree.add(leavesGroup);

        for (let i = 0; i < 8; i++) {
            const frond = new THREE.Mesh(new THREE.BoxGeometry(0.1, 0.1, 2.5), treeMatLeaves);
            frond.rotation.y = (Math.PI / 4) * i;
            frond.rotation.x = 0.2;
            frond.position.set(Math.sin((Math.PI/4)*i)*0.8, -0.2, Math.cos((Math.PI/4)*i)*0.8);
            leavesGroup.add(frond);
        }
        
        scene.add(tree);
    }

    createPalmTree(-12, -8, 1.2);
    createPalmTree(-14, -6, 0.95);
    createPalmTree(14, -12, 1.1);
    createPalmTree(16, -9, 0.8);
    createPalmTree(8, 16, 1.05);

    // Extra Palm Trees
    createPalmTree(-22, -18, 1.1);
    createPalmTree(-20, 18, 0.9);
    createPalmTree(22, -22, 1.15);
    createPalmTree(24, 15, 0.85);
    createPalmTree(10, -25, 1.0);
    createPalmTree(-8, -22, 0.95);

    // ─── BANANA TREES (Tropical foliage) ─────────────────────────────
    function createBananaTree(x, z, scale = 1) {
        const bTree = new THREE.Group();
        bTree.position.set(x, 0, z);
        bTree.scale.set(scale, scale, scale);

        const trunkMat = new THREE.MeshStandardMaterial({ color: '#4d7c0f', roughness: 0.9 });
        const leafMat = new THREE.MeshStandardMaterial({ color: '#22c55e', roughness: 0.8, flatShading: true });

        const trunk = new THREE.Mesh(new THREE.CylinderGeometry(0.1, 0.16, 3.0, 6), trunkMat);
        trunk.position.y = 1.5;
        trunk.castShadow = true;
        bTree.add(trunk);

        for (let i = 0; i < 5; i++) {
            const leafGroup = new THREE.Group();
            leafGroup.position.set(0, 2.8, 0);
            
            const ang = (Math.PI * 2 / 5) * i;
            leafGroup.rotation.y = ang;
            
            const leaf = new THREE.Mesh(new THREE.BoxGeometry(0.45, 0.015, 1.4), leafMat);
            leaf.position.set(0, -0.2, 0.6);
            leaf.rotation.x = 0.35;
            leaf.castShadow = true;
            leafGroup.add(leaf);
            bTree.add(leafGroup);
        }

        scene.add(bTree);
    }
    createBananaTree(-6, -10, 1.0);
    createBananaTree(-10, -16, 1.1);
    createBananaTree(18, -4, 0.95);
    createBananaTree(4, 14, 1.0);
    createBananaTree(-4, 20, 1.05);

    // ─── TERRAIN HILLS (Mounds) ───────────────────────────────────────
    const hill1 = new THREE.Mesh(new THREE.CylinderGeometry(2, 6, 1.2, 10), grassMat);
    hill1.position.set(-16, 0.5, -15);
    hill1.receiveShadow = true;
    hill1.castShadow = true;
    scene.add(hill1);

    const hill2 = new THREE.Mesh(new THREE.CylinderGeometry(1.5, 5, 1.0, 10), grassMat);
    hill2.position.set(18, 0.4, 14);
    hill2.receiveShadow = true;
    hill2.castShadow = true;
    scene.add(hill2);

    const hill3 = new THREE.Mesh(new THREE.CylinderGeometry(2.5, 7, 1.4, 10), grassMat);
    hill3.position.set(-18, 0.6, 15);
    hill3.receiveShadow = true;
    hill3.castShadow = true;
    scene.add(hill3);

    // ─── CLIMBABLE ROCK CLUSTERS (Batu Tanjakan) ──────────────────────
    function createRockCluster(x, z, scale = 1) {
        const cluster = new THREE.Group();
        cluster.position.set(x, 0.1, z);
        cluster.scale.set(scale, scale, scale);

        const rockMat = new THREE.MeshStandardMaterial({ color: '#64748b', roughness: 0.9, flatShading: true });

        const r1 = new THREE.Mesh(new THREE.DodecahedronGeometry(0.85), rockMat);
        r1.castShadow = true;
        r1.receiveShadow = true;
        cluster.add(r1);

        const r2 = new THREE.Mesh(new THREE.DodecahedronGeometry(0.55), rockMat);
        r2.position.set(0.65, -0.15, 0.4);
        r2.rotation.set(0.2, 0.5, 0.15);
        r2.castShadow = true;
        cluster.add(r2);

        const r3 = new THREE.Mesh(new THREE.DodecahedronGeometry(0.5), rockMat);
        r3.position.set(-0.55, -0.2, -0.3);
        r3.rotation.set(-0.35, 0.25, 0.45);
        r3.castShadow = true;
        r3.receiveShadow = true;
        cluster.add(r3);

        scene.add(cluster);
    }
    createRockCluster(-26, -12, 1.15);
    createRockCluster(24, -16, 1.0);
    createRockCluster(16, 10, 1.25);
    createRockCluster(-10, -18, 0.95);

    // ─── MARKET CARGO PROPS ───────────────────────────────────────────
    function createCargoPile(x, z, rotY = 0) {
        const pile = new THREE.Group();
        pile.position.set(x, 0, z);
        pile.rotation.y = rotY;

        const woodMatCargo = new THREE.MeshStandardMaterial({ color: '#543018', roughness: 0.95 });
        const burlapMat = new THREE.MeshStandardMaterial({ color: '#c27a38', roughness: 0.9 });
        const metalRingMat = new THREE.MeshStandardMaterial({ color: '#475569', roughness: 0.4, metalness: 0.7 });

        const crate1 = new THREE.Mesh(new THREE.BoxGeometry(0.6, 0.6, 0.6), woodMatCargo);
        crate1.position.set(-0.3, 0.3, -0.3);
        crate1.castShadow = true;
        crate1.receiveShadow = true;
        pile.add(crate1);

        const crate2 = new THREE.Mesh(new THREE.BoxGeometry(0.5, 0.5, 0.5), woodMatCargo);
        crate2.position.set(0.3, 0.25, 0.2);
        crate2.rotation.y = 0.5;
        crate2.castShadow = true;
        crate2.receiveShadow = true;
        pile.add(crate2);

        const crate3 = new THREE.Mesh(new THREE.BoxGeometry(0.45, 0.45, 0.45), woodMatCargo);
        crate3.position.set(-0.25, 0.8, -0.25);
        crate3.rotation.y = -0.3;
        crate3.castShadow = true;
        pile.add(crate3);

        const sack = new THREE.Group();
        sack.position.set(0.35, 0.3, -0.45);
        const sackBody = new THREE.Mesh(new THREE.CylinderGeometry(0.2, 0.23, 0.6, 8), burlapMat);
        sackBody.castShadow = true;
        sack.add(sackBody);
        const sackTie = new THREE.Mesh(new THREE.SphereGeometry(0.09, 6, 6), burlapMat);
        sackTie.position.y = 0.32;
        sack.add(sackTie);
        pile.add(sack);

        const barrel = new THREE.Group();
        barrel.position.set(-0.8, 0.4, 0.35);
        const barrelBody = new THREE.Mesh(new THREE.CylinderGeometry(0.28, 0.32, 0.8, 8), woodMatCargo);
        barrelBody.castShadow = true;
        barrel.add(barrelBody);
        const ring1 = new THREE.Mesh(new THREE.CylinderGeometry(0.325, 0.325, 0.02, 8), metalRingMat);
        ring1.position.y = 0.22;
        barrel.add(ring1);
        const ring2 = new THREE.Mesh(new THREE.CylinderGeometry(0.325, 0.325, 0.02, 8), metalRingMat);
        ring2.position.y = -0.22;
        barrel.add(ring2);
        pile.add(barrel);

        scene.add(pile);
    }
    createCargoPile(-14, 10, 0.5);
    createCargoPile(14, -6, -0.8);
    createCargoPile(-2.5, -12, 1.5);
    createCargoPile(-4, 26, 0.1);

    // Decorative fruit boxes at stalls
    const fruitMatRed = new THREE.MeshStandardMaterial({ color: '#dc2626', roughness: 0.3 });
    const fruitMatOrange = new THREE.MeshStandardMaterial({ color: '#ea580c', roughness: 0.4 });
    
    function createFruitCrate(x, y, z, parentGroup, colorType) {
        const crate = new THREE.Group();
        crate.position.set(x, y, z);
        
        const box = new THREE.Mesh(new THREE.BoxGeometry(0.32, 0.15, 0.42), new THREE.MeshStandardMaterial({ color: '#854d0e', roughness: 0.9 }));
        box.castShadow = true;
        crate.add(box);

        const mat = colorType === 'red' ? fruitMatRed : fruitMatOrange;
        for (let i = 0; i < 6; i++) {
            const fx = -0.1 + (i % 2) * 0.2;
            const fz = -0.15 + Math.floor(i / 2) * 0.15;
            const fruit = new THREE.Mesh(new THREE.SphereGeometry(0.06, 6, 6), mat);
            fruit.position.set(fx, 0.05, fz);
            crate.add(fruit);
        }
        parentGroup.add(crate);
    }

    // ─── CITIZENS (Working Warga) ─────────────────────────────────────
    function createCitizen(x, z, rotY, shirtColor = '#0284c7', pantsColor = '#334155', isWoman = false, activity = 'idle') {
        const citizen = new THREE.Group();
        citizen.position.set(x, 0.35, z);
        citizen.rotation.y = rotY;

        const citSkinMat = new THREE.MeshStandardMaterial({ color: '#ffedd5', roughness: 0.8 });
        const citShirtMat = new THREE.MeshStandardMaterial({ color: shirtColor, roughness: 0.7 });
        const citPantsMat = new THREE.MeshStandardMaterial({ color: pantsColor, roughness: 0.8 });
        const citHairMat = new THREE.MeshStandardMaterial({ color: '#1e1b4b', roughness: 0.9 });
        const citEyeMat = new THREE.MeshBasicMaterial({ color: '#0f172a' });

        // Torso
        let torso;
        if (isWoman) {
            torso = new THREE.Mesh(new THREE.CylinderGeometry(0.2, 0.35, 0.8, 8), citShirtMat);
        } else {
            torso = new THREE.Mesh(new THREE.CylinderGeometry(0.22, 0.22, 0.75, 8), citShirtMat);
        }
        torso.position.y = 0.5;
        torso.castShadow = true;
        citizen.add(torso);

        // Head
        const headGroup = new THREE.Group();
        headGroup.position.y = 1.05;
        citizen.add(headGroup);

        const headMesh = new THREE.Mesh(new THREE.SphereGeometry(0.2, 10, 10), citSkinMat);
        headMesh.castShadow = true;
        headGroup.add(headMesh);

        // Hair / Hijab / Peci
        if (isWoman) {
            const hijab = new THREE.Mesh(new THREE.SphereGeometry(0.21, 8, 8), new THREE.MeshStandardMaterial({ color: '#f1f5f9', roughness: 0.9 }));
            hijab.position.set(0, 0.01, -0.02);
            hijab.scale.set(1.02, 1.02, 1.05);
            headGroup.add(hijab);

            const hijabTail = new THREE.Mesh(new THREE.BoxGeometry(0.32, 0.45, 0.05), new THREE.MeshStandardMaterial({ color: '#f1f5f9', roughness: 0.9 }));
            hijabTail.position.set(0, -0.22, -0.12);
            hijabTail.rotation.x = 0.2;
            headGroup.add(hijabTail);
        } else {
            const hair = new THREE.Mesh(new THREE.SphereGeometry(0.19, 8, 8), citHairMat);
            hair.position.set(0, 0.02, -0.03);
            headGroup.add(hair);

            if (Math.random() > 0.5) {
                const peci = new THREE.Mesh(new THREE.CylinderGeometry(0.18, 0.18, 0.09, 8), new THREE.MeshStandardMaterial({ color: '#09090b', roughness: 0.9 }));
                peci.position.y = 0.15;
                headGroup.add(peci);
            } else {
                const band = new THREE.Mesh(new THREE.CylinderGeometry(0.2, 0.2, 0.04, 8), new THREE.MeshStandardMaterial({ color: '#b91c1c', roughness: 0.9 }));
                band.position.y = 0.06;
                headGroup.add(band);
            }
        }

        // Eyes
        const leftEye = new THREE.Mesh(new THREE.BoxGeometry(0.02, 0.02, 0.01), citEyeMat);
        leftEye.position.set(-0.06, 0.02, 0.18);
        headGroup.add(leftEye);

        const rightEye = new THREE.Mesh(new THREE.BoxGeometry(0.02, 0.02, 0.01), citEyeMat);
        rightEye.position.set(0.06, 0.02, 0.18);
        headGroup.add(rightEye);

        // Smile
        const smile = new THREE.Mesh(new THREE.BoxGeometry(0.04, 0.008, 0.01), new THREE.MeshBasicMaterial({ color: '#be123c' }));
        smile.position.set(0, -0.06, 0.18);
        headGroup.add(smile);

        // Limbs (Legs)
        if (!isWoman) {
            const leftLeg = new THREE.Mesh(new THREE.CylinderGeometry(0.07, 0.07, 0.45, 6), citPantsMat);
            leftLeg.position.set(-0.1, 0.18, 0);
            leftLeg.castShadow = true;
            citizen.add(leftLeg);

            const rightLeg = new THREE.Mesh(new THREE.CylinderGeometry(0.07, 0.07, 0.45, 6), citPantsMat);
            rightLeg.position.set(0.1, 0.18, 0);
            rightLeg.castShadow = true;
            citizen.add(rightLeg);
        } else {
            const skirtBottom = new THREE.Mesh(new THREE.CylinderGeometry(0.35, 0.4, 0.3, 8), citShirtMat);
            skirtBottom.position.y = 0.1;
            citizen.add(skirtBottom);
        }

        // Arms
        const leftArmGroup = new THREE.Group();
        leftArmGroup.position.set(-0.29, 0.7, 0);
        citizen.add(leftArmGroup);

        const leftArm = new THREE.Mesh(new THREE.CylinderGeometry(0.05, 0.05, 0.42, 6), citShirtMat);
        leftArm.position.y = -0.16;
        leftArm.castShadow = true;
        leftArmGroup.add(leftArm);

        const rightArmGroup = new THREE.Group();
        rightArmGroup.position.set(0.29, 0.7, 0);
        citizen.add(rightArmGroup);

        const rightArm = new THREE.Mesh(new THREE.CylinderGeometry(0.05, 0.05, 0.42, 6), citShirtMat);
        rightArm.position.y = -0.16;
        rightArm.castShadow = true;
        rightArmGroup.add(rightArm);

        if (activity === 'serve') {
            leftArmGroup.rotation.x = -Math.PI / 3;
            rightArmGroup.rotation.x = -Math.PI / 3;
        } else if (activity === 'carry') {
            leftArmGroup.rotation.x = -Math.PI / 2.5;
            leftArmGroup.rotation.y = 0.2;
            rightArmGroup.rotation.x = -Math.PI / 2.5;
            rightArmGroup.rotation.y = -0.2;

            const crate = new THREE.Mesh(new THREE.BoxGeometry(0.4, 0.28, 0.4), new THREE.MeshStandardMaterial({ color: '#78350f', roughness: 0.9 }));
            crate.position.set(0, 0.65, 0.35);
            crate.castShadow = true;
            citizen.add(crate);
        } else if (activity === 'drum') {
            citizen.position.y = 0.15;
            leftArmGroup.rotation.x = -Math.PI / 2.2;
            rightArmGroup.rotation.x = -Math.PI / 2.2;
            
            if (!isWoman) {
                const crossedLegL = new THREE.Mesh(new THREE.CylinderGeometry(0.07, 0.07, 0.4, 6), citPantsMat);
                crossedLegL.rotation.z = Math.PI / 2;
                crossedLegL.rotation.y = 0.5;
                crossedLegL.position.set(-0.15, 0.1, 0.15);
                citizen.add(crossedLegL);

                const crossedLegR = new THREE.Mesh(new THREE.CylinderGeometry(0.07, 0.07, 0.4, 6), citPantsMat);
                crossedLegR.rotation.z = -Math.PI / 2;
                crossedLegR.rotation.y = -0.5;
                crossedLegR.position.set(0.15, 0.1, 0.15);
                citizen.add(crossedLegR);
            }
        } else if (activity === 'wave') {
            rightArmGroup.rotation.x = -Math.PI + 0.5;
            rightArmGroup.rotation.z = -0.3;
        }

        scene.add(citizen);
        return citizen;
    }

    // Spawn working citizens around village
    createCitizen(-12, 13.0, 0, '#0284c7', '#334155', false, 'serve'); // Kopi Gayo Barista
    createCitizen(12, -5.0, Math.PI, '#b91c1c', '#1e293b', false, 'serve'); // Mie Aceh Cook
    createCitizen(8.8, 6.8, -1.8, '#d97706', '#0f172a', false, 'drum'); // Musician playing drum near Balai Musik
    createCitizen(-2.2, 25.5, 0.4, '#15803d', '#3f2723', false, 'carry'); // Cargo worker near dock
    createCitizen(-4.5, -7, 1.2, '#6d28d9', '#1e293b', false, 'wave'); // Chatting villager 1
    createCitizen(-5.5, -6.5, -1.2, '#db2777', '#f1f5f9', true, 'idle'); // Chatting villager 2 (Woman)

    // 4. Campfire (Music Stage Area)
    const fireGroup = new THREE.Group();
    fireGroup.position.set(-10, 0, 10);
    scene.add(fireGroup);

    // Stone ring
    const fireStoneMat = new THREE.MeshStandardMaterial({ color: '#475569', roughness: 0.95, flatShading: true });
    for (let i = 0; i < 8; i++) {
        const stone = new THREE.Mesh(new THREE.DodecahedronGeometry(0.28), fireStoneMat);
        const ang = (Math.PI / 4) * i;
        stone.position.set(Math.sin(ang)*0.85, 0.1, Math.cos(ang)*0.85);
        fireGroup.add(stone);
    }
    
    // Logs
    const logMat = new THREE.MeshStandardMaterial({ color: '#27170a', roughness: 0.9 });
    for (let i = 0; i < 3; i++) {
        const log = new THREE.Mesh(new THREE.CylinderGeometry(0.08, 0.08, 0.9), logMat);
        log.rotation.y = (Math.PI / 3) * i;
        log.rotation.x = 1.3;
        log.position.set(0, 0.1, 0);
        log.castShadow = true;
        fireGroup.add(log);
    }

    // Fire Light
    const fireLight = new THREE.PointLight('#f97316', 1.8, 8);
    fireLight.position.set(0, 0.6, 0);
    fireLight.castShadow = true;
    fireGroup.add(fireLight);

    // Animated Fire Particles
    const fireParticles = [];
    const particleMat = new THREE.MeshBasicMaterial({ color: '#f97316', transparent: true, opacity: 0.8 });
    for (let i = 0; i < 15; i++) {
        const p = new THREE.Mesh(new THREE.BoxGeometry(0.12, 0.12, 0.12), particleMat);
        p.position.set((Math.random() - 0.5)*0.3, 0.2 + Math.random()*0.8, (Math.random() - 0.5)*0.3);
        fireGroup.add(p);
        fireParticles.push({
            mesh: p,
            speedY: 0.01 + Math.random() * 0.015,
            wiggleSpeed: 2 + Math.random()*4,
            wiggleOffset: Math.random()*10,
            startY: 0.2
        });
    }

    // 5. Dock & Warship at Coast
    const dockGroup = new THREE.Group();
    dockGroup.position.set(0, -2.6, 32);
    scene.add(dockGroup);

    // Wooden planks for dock
    const dockMat = new THREE.MeshStandardMaterial({ color: '#3c2512', roughness: 0.9 });
    for (let i = 0; i < 8; i++) {
        const plank = new THREE.Mesh(new THREE.BoxGeometry(2.5, 0.12, 0.5), dockMat);
        plank.position.set(0, 0.8, -i * 0.6);
        plank.castShadow = true;
        plank.receiveShadow = true;
        dockGroup.add(plank);
    }
    // Dock pillars
    for (let i = 0; i < 4; i++) {
        const pil = new THREE.Mesh(new THREE.CylinderGeometry(0.1, 0.1, 2.5), dockMat);
        pil.position.set(i % 2 === 0 ? -1.2 : 1.2, 0, i < 2 ? 0 : -3.6);
        dockGroup.add(pil);
    }

    // Wooden low-poly Ship (Cakra Donya warship style representation)
    const shipGroup = new THREE.Group();
    shipGroup.position.set(-5, -0.6, 36);
    shipGroup.rotation.y = -0.5;
    scene.add(shipGroup);

    const shipMat = new THREE.MeshStandardMaterial({ color: '#3d1e03', roughness: 0.85, flatShading: true });
    const darkWoodMat2 = new THREE.MeshStandardMaterial({ color: '#271201', roughness: 0.9, flatShading: true });
    const goldMat2 = new THREE.MeshStandardMaterial({ color: '#d97706', roughness: 0.2, metalness: 0.8 });
    const ropeMat = new THREE.MeshStandardMaterial({ color: '#78350f', roughness: 0.95 });

    // 1. Hull - Segmented & Curved Planks
    // Lower Keel (dark base)
    const keel = new THREE.Mesh(new THREE.BoxGeometry(2.2, 0.5, 7.5), darkWoodMat2);
    keel.position.y = 0.25;
    keel.castShadow = true;
    keel.receiveShadow = true;
    shipGroup.add(keel);

    // Mid Hull (wider, medium brown wood)
    const midHull = new THREE.Mesh(new THREE.BoxGeometry(2.8, 0.6, 7.5), shipMat);
    midHull.position.y = 0.8;
    midHull.castShadow = true;
    midHull.receiveShadow = true;
    shipGroup.add(midHull);

    // Upper deck rails / panels
    const shipLeftRail = new THREE.Mesh(new THREE.BoxGeometry(0.12, 0.5, 7.5), darkWoodMat2);
    shipLeftRail.position.set(-1.34, 1.35, 0);
    shipLeftRail.castShadow = true;
    shipGroup.add(shipLeftRail);

    const shipRightRail = new THREE.Mesh(new THREE.BoxGeometry(0.12, 0.5, 7.5), darkWoodMat2);
    shipRightRail.position.set(1.34, 1.35, 0);
    shipRightRail.castShadow = true;
    shipGroup.add(shipRightRail);

    // Gold lining along rails
    const leftGoldLine = new THREE.Mesh(new THREE.BoxGeometry(0.04, 0.06, 7.5), goldMat2);
    leftGoldLine.position.set(-1.34, 1.61, 0);
    shipGroup.add(leftGoldLine);

    const rightGoldLine = new THREE.Mesh(new THREE.BoxGeometry(0.04, 0.06, 7.5), goldMat2);
    rightGoldLine.position.set(1.34, 1.61, 0);
    shipGroup.add(rightGoldLine);

    // 2. Bow (pointed front, layered look)
    // Bow wedge 1
    const bowWedge1 = new THREE.Mesh(new THREE.ConeGeometry(1.4, 2.5, 4), shipMat);
    bowWedge1.rotation.x = -Math.PI / 2;
    bowWedge1.position.set(0, 0.8, 4.8);
    bowWedge1.scale.set(1, 1, 0.4);
    bowWedge1.castShadow = true;
    shipGroup.add(bowWedge1);

    // Bow wedge 2 (upper pointed trim)
    const bowWedge2 = new THREE.Mesh(new THREE.ConeGeometry(1.5, 2.0, 4), darkWoodMat2);
    bowWedge2.rotation.x = -Math.PI / 2;
    bowWedge2.position.set(0, 1.25, 4.6);
    bowWedge2.scale.set(0.9, 1, 0.35);
    bowWedge2.castShadow = true;
    shipGroup.add(bowWedge2);

    // Bowsprit (front projecting beam)
    const bowsprit = new THREE.Mesh(new THREE.CylinderGeometry(0.08, 0.05, 3.0, 8), darkWoodMat2);
    bowsprit.rotation.x = Math.PI / 2 - 0.2; // tilted up
    bowsprit.position.set(0, 1.4, 5.2);
    bowsprit.castShadow = true;
    shipGroup.add(bowsprit);

    // Golden Dragon/Garuda Figurehead (Kepala Naga Cakra Donya style)
    const figurehead = new THREE.Group();
    figurehead.position.set(0, 1.5, 4.7);
    figurehead.rotation.x = -0.2;
    shipGroup.add(figurehead);

    const figBase = new THREE.Mesh(new THREE.BoxGeometry(0.24, 0.4, 0.4), goldMat2);
    figBase.castShadow = true;
    figurehead.add(figBase);

    const figSnout = new THREE.Mesh(new THREE.BoxGeometry(0.24, 0.16, 0.25), goldMat2);
    figSnout.position.set(0, 0.08, 0.25);
    figurehead.add(figSnout);

    const figCrest = new THREE.Mesh(new THREE.ConeGeometry(0.08, 0.35, 4), goldMat2);
    figCrest.position.set(0, 0.3, -0.05);
    figCrest.rotation.x = -0.4;
    figurehead.add(figCrest);

    // 3. Sterncastle (Raised Rear Deck & Cabin)
    const cabin = new THREE.Mesh(new THREE.BoxGeometry(2.5, 1.1, 2.2), shipMat);
    cabin.position.set(0, 1.6, -2.4);
    cabin.castShadow = true;
    shipGroup.add(cabin);

    // Cabin roof (curved sloping style)
    const cabinRoof = new THREE.Mesh(new THREE.BoxGeometry(2.7, 0.15, 2.5), new THREE.MeshStandardMaterial({ color: '#b91c1c', roughness: 0.9 }));
    cabinRoof.position.set(0, 2.2, -2.4);
    cabinRoof.rotation.x = 0.05;
    cabinRoof.castShadow = true;
    shipGroup.add(cabinRoof);

    // Gold trim on cabin roof edges
    const roofTrimLeft = new THREE.Mesh(new THREE.BoxGeometry(0.06, 0.2, 2.5), goldMat2);
    roofTrimLeft.position.set(-1.35, 2.2, -2.4);
    shipGroup.add(roofTrimLeft);

    const roofTrimRight = new THREE.Mesh(new THREE.BoxGeometry(0.06, 0.2, 2.5), goldMat2);
    roofTrimRight.position.set(1.35, 2.2, -2.4);
    shipGroup.add(roofTrimRight);

    // Window cutouts
    const windowL = new THREE.Mesh(new THREE.BoxGeometry(0.02, 0.4, 0.7), new THREE.MeshStandardMaterial({ color: '#1e293b', roughness: 0.1, metalness: 0.9 }));
    windowL.position.set(-1.26, 1.6, -2.4);
    shipGroup.add(windowL);

    const windowR = new THREE.Mesh(new THREE.BoxGeometry(0.02, 0.4, 0.7), new THREE.MeshStandardMaterial({ color: '#1e293b', roughness: 0.1, metalness: 0.9 }));
    windowR.position.set(1.26, 1.6, -2.4);
    shipGroup.add(windowR);

    // Rear railings
    const rearRail = new THREE.Mesh(new THREE.BoxGeometry(2.6, 0.3, 0.08), darkWoodMat2);
    rearRail.position.set(0, 1.35, -3.5);
    shipGroup.add(rearRail);

    // 4. Stern Lanterns
    function createLantern(lx, ly, lz) {
        const lantern = new THREE.Group();
        lantern.position.set(lx, ly, lz);

        const hook = new THREE.Mesh(new THREE.BoxGeometry(0.04, 0.2, 0.12), goldMat2);
        hook.position.y = 0.1;
        lantern.add(hook);

        const cap = new THREE.Mesh(new THREE.CylinderGeometry(0.08, 0.08, 0.03, 6), goldMat2);
        cap.position.y = 0.0;
        lantern.add(cap);

        const base = new THREE.Mesh(new THREE.CylinderGeometry(0.08, 0.08, 0.03, 6), goldMat2);
        base.position.y = -0.16;
        lantern.add(base);

        const core = new THREE.Mesh(new THREE.CylinderGeometry(0.055, 0.055, 0.13, 6), new THREE.MeshBasicMaterial({ color: '#fdba74' }));
        core.position.y = -0.08;
        lantern.add(core);

        shipGroup.add(lantern);
    }
    createLantern(-1.3, 1.6, -3.4);
    createLantern(1.3, 1.6, -3.4);

    // 5. Oars & Shield Emblems
    const oarZOffsets = [-1.5, 0.2, 1.9];
    for (let i = 0; i < 3; i++) {
        const oarL = new THREE.Group();
        oarL.position.set(-1.4, 0.6, oarZOffsets[i]);
        oarL.rotation.z = 0.7;
        oarL.rotation.y = 0.1;
        
        const shaftL = new THREE.Mesh(new THREE.CylinderGeometry(0.02, 0.02, 2.2, 6), darkWoodMat2);
        shaftL.position.y = -0.9;
        oarL.add(shaftL);
        
        const bladeL = new THREE.Mesh(new THREE.BoxGeometry(0.02, 0.4, 0.08), shipMat);
        bladeL.position.y = -1.9;
        oarL.add(bladeL);
        shipGroup.add(oarL);

        const oarR = new THREE.Group();
        oarR.position.set(1.4, 0.6, oarZOffsets[i]);
        oarR.rotation.z = -0.7;
        oarR.rotation.y = -0.1;
        
        const shaftR = new THREE.Mesh(new THREE.CylinderGeometry(0.02, 0.02, 2.2, 6), darkWoodMat2);
        shaftR.position.y = -0.9;
        oarR.add(shaftR);
        
        const bladeR = new THREE.Mesh(new THREE.BoxGeometry(0.02, 0.4, 0.08), shipMat);
        bladeR.position.y = -1.9;
        oarR.add(bladeR);
        shipGroup.add(oarR);
    }

    const shieldZOffsets = [-0.8, 1.0, 2.8];
    const shieldColors = ['#b91c1c', '#1e293b', '#b91c1c'];
    for (let i = 0; i < 3; i++) {
        const shieldMatL = new THREE.MeshStandardMaterial({ color: shieldColors[i], roughness: 0.5 });
        const shieldL = new THREE.Mesh(new THREE.CylinderGeometry(0.24, 0.24, 0.03, 8), shieldMatL);
        shieldL.rotation.z = Math.PI / 2;
        shieldL.position.set(-1.42, 1.35, shieldZOffsets[i]);
        shieldL.castShadow = true;
        shipGroup.add(shieldL);

        const emblemL = new THREE.Mesh(new THREE.ConeGeometry(0.06, 0.04, 5), goldMat2);
        emblemL.rotation.z = Math.PI / 2;
        emblemL.position.set(-1.44, 1.35, shieldZOffsets[i]);
        shipGroup.add(emblemL);

        const shieldMatR = new THREE.MeshStandardMaterial({ color: shieldColors[i], roughness: 0.5 });
        const shieldR = new THREE.Mesh(new THREE.CylinderGeometry(0.24, 0.24, 0.03, 8), shieldMatR);
        shieldR.rotation.z = Math.PI / 2;
        shieldR.position.set(1.42, 1.35, shieldZOffsets[i]);
        shieldR.castShadow = true;
        shipGroup.add(shieldR);

        const emblemR = new THREE.Mesh(new THREE.ConeGeometry(0.06, 0.04, 5), goldMat2);
        emblemR.rotation.z = -Math.PI / 2;
        emblemR.position.set(1.44, 1.35, shieldZOffsets[i]);
        shipGroup.add(emblemR);
    }

    // 6. Mast & Crossbeams
    const mast = new THREE.Mesh(new THREE.CylinderGeometry(0.12, 0.1, 6.5, 8), darkWoodMat2);
    mast.position.set(0, 4.0, 0);
    mast.castShadow = true;
    shipGroup.add(mast);

    const yardTop = new THREE.Mesh(new THREE.CylinderGeometry(0.04, 0.04, 3.2, 8), darkWoodMat2);
    yardTop.rotation.z = Math.PI / 2;
    yardTop.position.set(0, 6.3, 0);
    shipGroup.add(yardTop);

    const yardBottom = new THREE.Mesh(new THREE.CylinderGeometry(0.05, 0.05, 3.2, 8), darkWoodMat2);
    yardBottom.rotation.z = Math.PI / 2;
    yardBottom.position.set(0, 2.7, 0);
    shipGroup.add(yardBottom);

    // 7. Wind-Filled Curved Sail
    const sailMat = new THREE.MeshStandardMaterial({ color: '#f8fafc', roughness: 0.95, side: THREE.DoubleSide });
    const sailGeo = new THREE.CylinderGeometry(1.5, 1.5, 3.6, 12, 1, true, -Math.PI / 4, Math.PI / 2);
    const sail = new THREE.Mesh(sailGeo, sailMat);
    sail.rotation.x = Math.PI / 2;
    sail.rotation.z = Math.PI;
    sail.rotation.y = 0.25;
    sail.position.set(0, 4.5, 0.5);
    sail.scale.set(1, 1, 0.9);
    sail.castShadow = true;
    shipGroup.add(sail);

    // 8. Detailed Rigging
    const ropeFront = new THREE.Mesh(new THREE.CylinderGeometry(0.015, 0.015, 6.2, 4), ropeMat);
    ropeFront.position.set(0, 4.3, 2.4);
    ropeFront.rotation.x = 0.65;
    shipGroup.add(ropeFront);

    const ropeBack = new THREE.Mesh(new THREE.CylinderGeometry(0.015, 0.015, 5.0, 4), ropeMat);
    ropeBack.position.set(0, 4.5, -1.2);
    ropeBack.rotation.x = -0.8;
    shipGroup.add(ropeBack);

    // ─── STALLS & STRUCTURES SETUP ────────────────────────────────────
    function createWarung(x, z, title, color = '#5c4033') {
        const warung = new THREE.Group();
        warung.position.set(x, 0, z);
        
        const woodMat = new THREE.MeshStandardMaterial({ color: color, roughness: 0.9 });
        const roofMat = new THREE.MeshStandardMaterial({ color: '#7c2d12', roughness: 0.9, flatShading: true });
        
        // Counter table
        const table = new THREE.Mesh(new THREE.BoxGeometry(3, 1.0, 1.5), woodMat);
        table.position.y = 0.5;
        table.castShadow = true;
        table.receiveShadow = true;
        warung.add(table);
        
        // Pillars
        for (let px of [-1.3, 1.3]) {
            for (let pz of [-0.6, 0.6]) {
                const pillar = new THREE.Mesh(new THREE.CylinderGeometry(0.06, 0.06, 2.0), woodMat);
                pillar.position.set(px, 1.5, pz);
                pillar.castShadow = true;
                warung.add(pillar);
            }
        }
        
        // Sloped Canopy Roof
        const canopy = new THREE.Mesh(new THREE.BoxGeometry(3.4, 0.12, 1.8), roofMat);
        canopy.position.set(0, 2.4, 0);
        canopy.rotation.x = 0.15;
        canopy.castShadow = true;
        warung.add(canopy);
        
        scene.add(warung);
        return warung;
    }

    function createBalaiMusik(x, z) {
        const balai = new THREE.Group();
        balai.position.set(x, 0, z);
        
        const woodMat = new THREE.MeshStandardMaterial({ color: '#5d4037', roughness: 0.9 });
        
        // Low platform
        const platform = new THREE.Mesh(new THREE.BoxGeometry(3.5, 0.25, 3.5), woodMat);
        platform.position.y = 0.4;
        platform.castShadow = true;
        platform.receiveShadow = true;
        balai.add(platform);
        
        // Short pillars
        for (let px of [-1.5, 1.5]) {
            for (let pz of [-1.5, 1.5]) {
                const pil = new THREE.Mesh(new THREE.BoxGeometry(0.2, 0.4, 0.2), woodMat);
                pil.position.set(px, 0.2, pz);
                pil.receiveShadow = true;
                balai.add(pil);
            }
        }
        
        scene.add(balai);
        return balai;
    }

    function createCabinet(x, y, z, rotY = 0) {
        const cab = new THREE.Group();
        cab.position.set(x, y, z);
        cab.rotation.y = rotY;
        
        const woodMat = new THREE.MeshStandardMaterial({ color: '#1a0f00', roughness: 0.8 });
        const goldMat = new THREE.MeshStandardMaterial({ color: '#d97706', roughness: 0.2, metalness: 0.8 });
        
        const body = new THREE.Mesh(new THREE.BoxGeometry(1.6, 0.9, 0.8), woodMat);
        body.position.y = 0.45;
        body.castShadow = true;
        body.receiveShadow = true;
        cab.add(body);
        
        // Gold trims
        const trim = new THREE.Mesh(new THREE.BoxGeometry(1.64, 0.08, 0.84), goldMat);
        trim.position.y = 0.86;
        cab.add(trim);
        
        scene.add(cab);
        return cab;
    }

    const gayoStall = createWarung(-12, 12, "Warung Kopi Gayo", '#3e2723');
    createFruitCrate(-0.6, 1.05, 0.1, gayoStall, 'red');
    createFruitCrate(0.6, 1.05, 0.1, gayoStall, 'orange');

    const mieStall = createWarung(12, -4, "Kedai Mie Aceh", '#5d4037');
    createFruitCrate(-0.6, 1.05, 0.1, mieStall, 'red');
    createFruitCrate(0.6, 1.05, 0.1, mieStall, 'orange');

    createCabinet(-2.2, 0.0, -12.0); // Cabinet under the house
    createBalaiMusik(8, 6);

    // ─── STALLS/LOCATIONS CONFIG & DATA ──────────────────────────────
    const stallsList = [
        {
            id: "mie_aceh",
            name: "Kedai Mie Aceh",
            center: { x: 12.0, z: -4.0 },
            prompt: "Periksa Hidangan Kedai Mie Aceh",
            items: [
                { name: "Mie Aceh", label: "Hidangan Pertama (Mangkok Merah)", desc: "Mangkuk merah berisi mie kuning tebal beraroma rempah kari pedas." },
                { name: "Soto Ayam", label: "Hidangan Kedua (Mangkok Hijau)", desc: "Mangkuk hijau berisi sup kaldu kuning gurih dengan suwiran telur rebus." },
                { name: "Nasi Tumpeng", label: "Hidangan Ketiga (Tumpeng Kuning)", desc: "Nasi kuning kerucut berhias daun pisang dengan lauk pauk di sekelilingnya." },
                { name: "Piring Kosong", label: "Hidangan Keempat (Piring Kayu)", desc: "Piring kayu ceper kosong dengan sendok garpu perak." }
            ]
        },
        {
            id: "kopi_gayo",
            name: "Warung Kopi Gayo",
            center: { x: -12.0, z: 12.0 },
            prompt: "Periksa Minuman Warung Kopi Gayo",
            items: [
                { name: "Kopi Gayo", label: "Minuman Pertama (Cangkir Cokelat)", desc: "Cangkir keramik cokelat mengepulkan uap harum khas tanah Gayo." },
                { name: "Teh Manis", label: "Minuman Kedua (Gelas Bening)", desc: "Es teh manis segar berwarna cokelat keemasan dengan lemon." },
                { name: "Susu Segar", label: "Minuman Ketiga (Cangkir Kayu)", desc: "Susu putih hangat berbusa dalam cangkir kayu dengan sedotan merah." },
                { name: "Sirup Cocopandan", label: "Minuman Keempat (Gelas Merah)", desc: "Es sirup merah kelapa manis segar dalam gelas tinggi." }
            ]
        },
        {
            id: "pinto_aceh",
            name: "Meja Ukir Rumoh Aceh",
            center: { x: -2.2, z: -12.0 },
            prompt: "Periksa Barang Seni Meja Ukir",
            items: [
                { name: "Pinto Aceh", label: "Barang Pertama (Bros Emas)", desc: "Bros emas bermotif gerbang khas Aceh dengan batu ruby merah berkilau." },
                { name: "Cincin Perak", label: "Barang Kedua (Cincin Perak)", desc: "Cincin perak tebal berhias batu akik permata biru muda." },
                { name: "Piring Perunggu", label: "Barang Tiga (Piring Perunggu)", desc: "Piring pajangan bermotif lingkaran konsentris dari perunggu." },
                { name: "Batu Akik Biru", label: "Barang Empat (Alas Kayu)", desc: "Bongkahan batu mulia biru mengkilap di atas dudukan kayu." }
            ]
        },
        {
            id: "rapai",
            name: "Balai Musik Tradisional",
            center: { x: 8.0, z: 6.0 },
            prompt: "Periksa Alat Musik di Balai",
            items: [
                { name: "Rapa'i", label: "Alat Pertama (Rebana Merah)", desc: "Rebana bermuka kuning dengan kepingan logam kuningan pengiring tari." },
                { name: "Suling Bambu", label: "Alat Kedua (Bambu Cokelat)", desc: "Suling bambu tiup berlubang-lubang kecil berwarna cokelat." },
                { name: "Kendang Jawa", label: "Alat Ketiga (Gendang Kayu)", desc: "Gendang kayu dua sisi membran kulit khas Jawa." },
                { name: "Gong Emas", label: "Alat Keempat (Gong Kuningan)", desc: "Gong kuningan berpenyangga tiang kayu gelap." }
            ]
        }
    ];

    // ─── COLLECTIBLES & DECOYS SETUP ──────────────────────────────────
    const colTypes = [
        { name: "Mie Aceh", color: '#ef4444', detail: "Mie tebal kuning pedas khas Aceh dengan bumbu rempah kari yang kaya." },
        { name: "Kopi Gayo", color: '#78350f', detail: "Kopi arabika kelas dunia dari dataran tinggi Gayo yang beraroma harum rempah." },
        { name: "Pinto Aceh", color: '#fbbf24', detail: "Ukiran perhiasan tradisional bercorak gerbang kerajaan Aceh yang elok." },
        { name: "Rapa'i", color: '#c084fc', detail: "Rebana tradisional Aceh pengiring tari Seudati yang bermakna dakwah." }
    ];

    const interactiveObjects = [];
    const steamParticles = [];

    function addInteractive(group, name, isTarget, targetIdx, detailOrDesc, typeLabel) {
        scene.add(group);
        interactiveObjects.push({
            name: name,
            mesh: group,
            isTarget: isTarget,
            targetIdx: targetIdx,
            detail: isTarget ? detailOrDesc : "",
            description: !isTarget ? detailOrDesc : "",
            typeLabel: typeLabel,
            collected: false,
            alreadyInspected: false
        });
    }

    // Materials helper
    const celeryMat = new THREE.MeshStandardMaterial({ color: '#166534', roughness: 0.9 });

    // 1. Detailed Mie Aceh (Table at 12, -4)
    const mieGroup = new THREE.Group();
    mieGroup.position.set(12.2, 1.05, -4.0);
    const bowlMie = new THREE.Mesh(new THREE.CylinderGeometry(0.3, 0.2, 0.18, 16), new THREE.MeshStandardMaterial({ color: '#b91c1c', roughness: 0.15, metalness: 0.1 }));
    bowlMie.castShadow = true;
    mieGroup.add(bowlMie);

    const noodleMat = new THREE.MeshStandardMaterial({ color: '#fbbf24', roughness: 0.65 });
    for (let i = 0; i < 5; i++) {
        const noodleLoop = new THREE.Mesh(new THREE.TorusGeometry(0.16, 0.038, 8, 16), noodleMat);
        noodleLoop.rotation.set(Math.PI / 2 + (Math.random() - 0.5)*0.2, (Math.random() - 0.5)*0.3, Math.random() * Math.PI);
        noodleLoop.position.set((Math.random() - 0.5)*0.06, 0.05 + i * 0.015, (Math.random() - 0.5)*0.06);
        mieGroup.add(noodleLoop);
    }

    for (let i = 0; i < 6; i++) {
        const cel = new THREE.Mesh(new THREE.BoxGeometry(0.04, 0.005, 0.04), celeryMat);
        const ang = Math.random() * Math.PI * 2;
        const r = 0.06 + Math.random() * 0.1;
        cel.position.set(Math.sin(ang) * r, 0.09 + Math.random()*0.02, Math.cos(ang) * r);
        cel.rotation.set(Math.random()*0.3, Math.random()*Math.PI, Math.random()*0.3);
        mieGroup.add(cel);
    }

    const chiliMat = new THREE.MeshStandardMaterial({ color: '#b91c1c', roughness: 0.4 });
    for (let i = 0; i < 3; i++) {
        const chiRing = new THREE.Mesh(new THREE.TorusGeometry(0.04, 0.012, 4, 8), chiliMat);
        chiRing.rotation.set(Math.PI / 2 + (Math.random() - 0.5)*0.4, (Math.random() - 0.5)*0.4, Math.random()*Math.PI);
        chiRing.position.set((Math.random() - 0.5)*0.18, 0.11, (Math.random() - 0.5)*0.18);
        mieGroup.add(chiRing);
    }

    const meatMat = new THREE.MeshStandardMaterial({ color: '#451a03', roughness: 0.85 });
    for (let i = 0; i < 4; i++) {
        const meat = new THREE.Mesh(new THREE.DodecahedronGeometry(0.045), meatMat);
        meat.position.set((Math.random() - 0.5) * 0.16, 0.08, (Math.random() - 0.5) * 0.16);
        meat.rotation.set(Math.random() * Math.PI, Math.random() * Math.PI, 0);
        mieGroup.add(meat);
    }
    addInteractive(mieGroup, "Mie Aceh", true, 0, "Mie tebal kuning pedas khas Aceh dengan bumbu rempah kari yang kaya.", "Hidangan");

    // 2. Decoy Soto Ayam (Green bowl, yellow broth, chicken and egg)
    const sotoGroup = new THREE.Group();
    sotoGroup.position.set(11.5, 1.05, -4.3);
    const bowlSoto = new THREE.Mesh(new THREE.CylinderGeometry(0.3, 0.2, 0.18, 16), new THREE.MeshStandardMaterial({ color: '#15803d', roughness: 0.15, metalness: 0.1 }));
    bowlSoto.castShadow = true;
    sotoGroup.add(bowlSoto);

    const soup = new THREE.Mesh(new THREE.CylinderGeometry(0.27, 0.27, 0.02, 16), new THREE.MeshStandardMaterial({ 
        color: '#eab308', 
        transparent: true, 
        opacity: 0.65, 
        roughness: 0.1 
    }));
    soup.position.y = 0.06;
    sotoGroup.add(soup);

    const chickMat = new THREE.MeshStandardMaterial({ color: '#fef08a', roughness: 0.9 });
    for (let i = 0; i < 6; i++) {
        const shred = new THREE.Mesh(new THREE.CylinderGeometry(0.008, 0.008, 0.09, 4), chickMat);
        shred.rotation.set(Math.PI / 2 + (Math.random() - 0.5)*0.3, Math.random() * Math.PI, 0);
        shred.position.set((Math.random() - 0.5) * 0.18, 0.075, (Math.random() - 0.5) * 0.18);
        sotoGroup.add(shred);
    }

    const eggGroup = new THREE.Group();
    eggGroup.position.set(0.06, 0.07, 0.06);
    eggGroup.rotation.set(-0.2, 0.4, -0.1);
    const eggWhite = new THREE.Mesh(new THREE.SphereGeometry(0.07, 12, 12, 0, Math.PI * 2, 0, Math.PI / 2), new THREE.MeshStandardMaterial({ color: '#ffffff', roughness: 0.5 }));
    eggWhite.rotation.x = Math.PI / 2;
    eggGroup.add(eggWhite);
    const eggYolk = new THREE.Mesh(new THREE.SphereGeometry(0.038, 8, 8, 0, Math.PI * 2, 0, Math.PI / 2), new THREE.MeshStandardMaterial({ color: '#eab308', roughness: 0.7 }));
    eggYolk.rotation.x = Math.PI / 2;
    eggYolk.position.y = 0.002;
    eggGroup.add(eggYolk);
    sotoGroup.add(eggGroup);

    for (let i = 0; i < 5; i++) {
        const scal = new THREE.Mesh(new THREE.BoxGeometry(0.03, 0.005, 0.03), celeryMat);
        const ang = Math.random() * Math.PI * 2;
        const r = 0.08 + Math.random() * 0.1;
        scal.position.set(Math.sin(ang) * r, 0.07 + Math.random()*0.01, Math.cos(ang) * r);
        sotoGroup.add(scal);
    }
    addInteractive(sotoGroup, "Soto Ayam", false, -1, "Ini Soto Ayam hangat khas Jawa dengan kuah kuning, bukan Mie Aceh!", "Hidangan");

    // 3. Decoy Nasi Tumpeng (Plate, yellow cone, banana leaf cap, sides)
    const tumpengGroup = new THREE.Group();
    tumpengGroup.position.set(11.5, 1.05, -3.7);
    const plate = new THREE.Mesh(new THREE.CylinderGeometry(0.36, 0.36, 0.04, 16), new THREE.MeshStandardMaterial({ color: '#27170a', roughness: 0.85 }));
    plate.castShadow = true;
    tumpengGroup.add(plate);

    const leafLiner = new THREE.Mesh(new THREE.CylinderGeometry(0.34, 0.34, 0.008, 16), new THREE.MeshStandardMaterial({ color: '#166534', roughness: 0.9 }));
    leafLiner.position.y = 0.024;
    tumpengGroup.add(leafLiner);

    const rice = new THREE.Mesh(new THREE.ConeGeometry(0.2, 0.42, 10), new THREE.MeshStandardMaterial({ color: '#f59e0b', roughness: 0.85, flatShading: true }));
    rice.position.y = 0.22;
    rice.castShadow = true;
    tumpengGroup.add(rice);

    const leafCap = new THREE.Mesh(new THREE.ConeGeometry(0.065, 0.1, 8), new THREE.MeshStandardMaterial({ color: '#15803d', roughness: 0.9 }));
    leafCap.position.y = 0.41;
    tumpengGroup.add(leafCap);

    const tempeMat = new THREE.MeshStandardMaterial({ color: '#78350f', roughness: 0.9 });
    for (let i = 0; i < 3; i++) {
        const tCube = new THREE.Mesh(new THREE.BoxGeometry(0.07, 0.045, 0.07), tempeMat);
        const ang = 0.4 + i * 2.0;
        tCube.position.set(Math.sin(ang)*0.24, 0.045, Math.cos(ang)*0.24);
        tCube.rotation.set(0.1, Math.random()*Math.PI, 0.05);
        tumpengGroup.add(tCube);
    }
    const sambalG = new THREE.Mesh(new THREE.DodecahedronGeometry(0.045), chiliMat);
    sambalG.position.set(-0.2, 0.04, -0.1);
    tumpengGroup.add(sambalG);

    const cucumberGroup = new THREE.Group();
    cucumberGroup.position.set(0.18, 0.03, -0.15);
    cucumberGroup.rotation.set(0.15, -0.5, 0);
    const cucOuter = new THREE.Mesh(new THREE.CylinderGeometry(0.065, 0.065, 0.015, 8), new THREE.MeshStandardMaterial({ color: '#15803d', roughness: 0.8 }));
    cucumberGroup.add(cucOuter);
    const cucInner = new THREE.Mesh(new THREE.CylinderGeometry(0.05, 0.05, 0.018, 8), new THREE.MeshStandardMaterial({ color: '#bbf7d0', roughness: 0.7 }));
    cucumberGroup.add(cucInner);
    tumpengGroup.add(cucumberGroup);
    addInteractive(tumpengGroup, "Nasi Tumpeng", false, -1, "Ini Nasi Tumpeng kuning tumpuk khas Jawa, bukan Mie Aceh!", "Hidangan");

    // 4. Decoy Piring Kosong (with fork & spoon)
    const piringGroup = new THREE.Group();
    piringGroup.position.set(12.8, 1.05, -3.7);
    const piring = new THREE.Mesh(new THREE.CylinderGeometry(0.32, 0.3, 0.04, 10), new THREE.MeshStandardMaterial({ color: '#a8a29e', roughness: 0.9 }));
    piring.castShadow = true;
    piringGroup.add(piring);
    const spoonMat = new THREE.MeshStandardMaterial({ color: '#cbd5e1', roughness: 0.2, metalness: 0.9 });
    const spoonHandle = new THREE.Mesh(new THREE.CylinderGeometry(0.01, 0.01, 0.3), spoonMat);
    spoonHandle.position.set(-0.06, 0.03, 0);
    spoonHandle.rotation.z = Math.PI / 2;
    piringGroup.add(spoonHandle);
    const spoonHead = new THREE.Mesh(new THREE.BoxGeometry(0.04, 0.01, 0.07), spoonMat);
    spoonHead.position.set(-0.18, 0.035, 0);
    piringGroup.add(spoonHead);
    addInteractive(piringGroup, "Piring Kosong", false, -1, "Ini hanya piring kayu kosong, tidak ada makanannya!", "Hidangan");

    // 5. Detailed Kopi Gayo (Coffee Mug with steam particles)
    const kopiGroup = new THREE.Group();
    kopiGroup.position.set(-12.3, 1.25, 12.0);
    const mugColor = '#4a2c11';
    const mugMat = new THREE.MeshStandardMaterial({ color: mugColor, roughness: 0.15, metalness: 0.1 });
    const mugBody = new THREE.Mesh(new THREE.CylinderGeometry(0.18, 0.16, 0.36, 16), mugMat);
    mugBody.castShadow = true;
    kopiGroup.add(mugBody);

    const handle = new THREE.Mesh(new THREE.TorusGeometry(0.09, 0.024, 6, 12, Math.PI), mugMat);
    handle.position.set(-0.16, 0, 0);
    handle.rotation.z = Math.PI / 2;
    kopiGroup.add(handle);

    const coffeeLiquid = new THREE.Mesh(new THREE.CylinderGeometry(0.165, 0.165, 0.02, 16), new THREE.MeshStandardMaterial({ color: '#180800', roughness: 0.05, metalness: 0.15 }));
    coffeeLiquid.position.y = 0.165;
    kopiGroup.add(coffeeLiquid);

    const rim = new THREE.Mesh(new THREE.TorusGeometry(0.172, 0.008, 4, 16), mugMat);
    rim.rotation.x = Math.PI / 2;
    rim.position.y = 0.18;
    kopiGroup.add(rim);

    // Steam particles
    const steamMat = new THREE.MeshBasicMaterial({ color: '#ffffff', transparent: true, opacity: 0.35 });
    for (let i = 0; i < 3; i++) {
        const steam = new THREE.Mesh(new THREE.SphereGeometry(0.025, 4, 4), steamMat);
        steam.position.set((Math.random() - 0.5) * 0.1, 0.2 + i * 0.15, (Math.random() - 0.5) * 0.1);
        kopiGroup.add(steam);
        steamParticles.push({
            mesh: steam,
            speedY: 0.003 + Math.random() * 0.003,
            startY: 0.2,
            startX: steam.position.x
        });
    }
    addInteractive(kopiGroup, "Kopi Gayo", true, 1, "Kopi arabika kelas dunia dari dataran tinggi Gayo yang beraroma harum rempah.", "Minuman");

    // 6. Decoy Teh Manis (Glass, ice cubes, lemon slice)
    const tehGroup = new THREE.Group();
    tehGroup.position.set(-11.5, 1.15, 11.7);
    const glassMat = new THREE.MeshStandardMaterial({ 
        color: '#f8fafc', 
        transparent: true, 
        opacity: 0.35, 
        roughness: 0.05, 
        metalness: 0.1 
    });
    const glassBody = new THREE.Mesh(new THREE.CylinderGeometry(0.14, 0.11, 0.38, 12), glassMat);
    glassBody.castShadow = true;
    tehGroup.add(glassBody);

    const glassRim = new THREE.Mesh(new THREE.TorusGeometry(0.136, 0.005, 4, 12), glassMat);
    glassRim.rotation.x = Math.PI / 2;
    glassRim.position.y = 0.19;
    tehGroup.add(glassRim);

    const teaLiquid = new THREE.Mesh(new THREE.CylinderGeometry(0.13, 0.105, 0.32, 12), new THREE.MeshStandardMaterial({ 
        color: '#c2410c', 
        transparent: true, 
        opacity: 0.8,
        roughness: 0.1 
    }));
    teaLiquid.position.y = -0.02;
    tehGroup.add(teaLiquid);

    const iceMat = new THREE.MeshStandardMaterial({ 
        color: '#ffffff', 
        transparent: true, 
        opacity: 0.65, 
        roughness: 0.05, 
        metalness: 0.25 
    });
    for (let i = 0; i < 3; i++) {
        const ice = new THREE.Mesh(new THREE.BoxGeometry(0.065, 0.065, 0.065), iceMat);
        ice.position.set((i === 0 ? 0.03 : i === 1 ? -0.04 : 0.01), 0.03 + i * 0.06, (i === 0 ? -0.03 : i === 1 ? 0.02 : 0.04));
        ice.rotation.set(Math.random()*0.5, Math.random()*0.5, Math.random()*0.5);
        tehGroup.add(ice);
    }

    const lemonGroup = new THREE.Group();
    lemonGroup.position.set(0.13, 0.17, 0.0);
    lemonGroup.rotation.set(0.3, 0, 0.4);
    const lemonSkin = new THREE.Mesh(new THREE.CylinderGeometry(0.06, 0.06, 0.02, 10, 1, false, 0, Math.PI), new THREE.MeshStandardMaterial({ color: '#facc15', roughness: 0.6 }));
    lemonSkin.rotation.x = Math.PI / 2;
    lemonGroup.add(lemonSkin);
    const lemonFlesh = new THREE.Mesh(new THREE.CylinderGeometry(0.05, 0.05, 0.022, 10, 1, false, 0, Math.PI), new THREE.MeshStandardMaterial({ color: '#fef08a', roughness: 0.8 }));
    lemonFlesh.rotation.x = Math.PI / 2;
    lemonGroup.add(lemonFlesh);
    tehGroup.add(lemonGroup);
    addInteractive(tehGroup, "Teh Manis", false, -1, "Ini es teh manis segar dengan irisan lemon, bukan Kopi Gayo!", "Minuman");

    // 7. Decoy Susu Segar (Wooden mug, milk, straw)
    const susuGroup = new THREE.Group();
    susuGroup.position.set(-11.5, 1.15, 12.3);
    const mug = new THREE.Mesh(new THREE.CylinderGeometry(0.12, 0.12, 0.3, 8), new THREE.MeshStandardMaterial({ color: '#78350f', roughness: 0.8 }));
    mug.castShadow = true;
    susuGroup.add(mug);
    const milk = new THREE.Mesh(new THREE.CylinderGeometry(0.1, 0.1, 0.02, 8), new THREE.MeshStandardMaterial({ color: '#f8fafc', roughness: 0.5 }));
    milk.position.y = 0.14;
    susuGroup.add(milk);
    const straw = new THREE.Mesh(new THREE.CylinderGeometry(0.015, 0.015, 0.35), new THREE.MeshStandardMaterial({ color: '#ef4444' }));
    straw.position.set(0.04, 0.18, 0.04);
    straw.rotation.set(0.2, 0, -0.2);
    susuGroup.add(straw);
    addInteractive(susuGroup, "Susu Segar", false, -1, "Ini susu putih hangat dalam cangkir kayu, bukan Kopi Gayo!", "Minuman");

    // 8. Decoy Sirup Cocopandan (Red syrup, glass, ice cube)
    const sirupGroup = new THREE.Group();
    sirupGroup.position.set(-12.8, 1.15, 12.3);
    const glassSirup = new THREE.Mesh(new THREE.CylinderGeometry(0.1, 0.08, 0.35, 8), new THREE.MeshStandardMaterial({ color: '#ffffff', transparent: true, opacity: 0.25 }));
    glassSirup.castShadow = true;
    sirupGroup.add(glassSirup);
    const redLiquid = new THREE.Mesh(new THREE.CylinderGeometry(0.08, 0.07, 0.28, 8), new THREE.MeshStandardMaterial({ color: '#dc2626', roughness: 0.2 }));
    redLiquid.position.y = -0.03;
    sirupGroup.add(redLiquid);
    const iceSirup = new THREE.Mesh(new THREE.BoxGeometry(0.06, 0.06, 0.06), iceMat);
    iceSirup.position.set(0, 0.08, 0);
    sirupGroup.add(iceSirup);
    addInteractive(sirupGroup, "Sirup Cocopandan", false, -1, "Ini sirup merah cocopandan manis, bukan Kopi Gayo!", "Minuman");

    // 9. Detailed Pinto Aceh (Brooch base, center gem, arches)
    const pintoGroup = new THREE.Group();
    pintoGroup.position.set(-2.2, 1.05, -12.0);
    const basePinto = new THREE.Mesh(new THREE.CylinderGeometry(0.24, 0.24, 0.03, 8), goldMat);
    basePinto.castShadow = true;
    pintoGroup.add(basePinto);

    const innerRim = new THREE.Mesh(new THREE.TorusGeometry(0.18, 0.015, 4, 16), goldMat);
    innerRim.rotation.x = Math.PI / 2;
    innerRim.position.y = 0.016;
    pintoGroup.add(innerRim);

    for (let i = 0; i < 6; i++) {
        const arch = new THREE.Mesh(new THREE.TorusGeometry(0.09, 0.012, 4, 8, Math.PI), goldMat);
        arch.position.set(0, 0.02, 0);
        arch.rotation.y = (Math.PI / 3) * i;
        arch.rotation.x = -Math.PI / 2;
        pintoGroup.add(arch);
    }

    const gemMat = new THREE.MeshStandardMaterial({ color: '#dc2626', roughness: 0.1, metalness: 0.6 });
    const centerGem = new THREE.Mesh(new THREE.OctahedronGeometry(0.06), gemMat);
    centerGem.position.y = 0.06;
    pintoGroup.add(centerGem);

    for (let i = 0; i < 8; i++) {
        const bead = new THREE.Mesh(new THREE.SphereGeometry(0.018, 4, 4), goldMat);
        const ang = (Math.PI / 4) * i;
        bead.position.set(Math.sin(ang)*0.21, 0.015, Math.cos(ang)*0.21);
        pintoGroup.add(bead);
    }
    addInteractive(pintoGroup, "Pinto Aceh", true, 2, "Ukiran perhiasan tradisional bercorak gerbang kerajaan Aceh yang elok.", "Barang");

    // 10. Decoy Cincin Perak (Ring with blue gemstone)
    const ringGroup = new THREE.Group();
    ringGroup.position.set(-2.5, 0.95, -12.2);
    const ringSilv = new THREE.Mesh(new THREE.TorusGeometry(0.14, 0.03, 8, 16), new THREE.MeshStandardMaterial({ color: '#94a3b8', roughness: 0.2, metalness: 0.9 }));
    ringSilv.castShadow = true;
    ringGroup.add(ringSilv);
    const gem = new THREE.Mesh(new THREE.OctahedronGeometry(0.06), new THREE.MeshStandardMaterial({ color: '#06b6d4', roughness: 0.1 }));
    gem.position.y = 0.15;
    ringGroup.add(gem);
    addInteractive(ringGroup, "Cincin Perak", false, -1, "Ini cincin perak bermata biru, bukan Pinto Aceh!", "Barang");

    // 11. Decoy Piring Perunggu (Bronze plate with circles)
    const perungguGroup = new THREE.Group();
    perungguGroup.position.set(-1.9, 0.95, -11.8);
    const dish = new THREE.Mesh(new THREE.CylinderGeometry(0.22, 0.22, 0.02, 10), new THREE.MeshStandardMaterial({ color: '#b45309', roughness: 0.3, metalness: 0.7 }));
    dish.castShadow = true;
    perungguGroup.add(dish);
    const ringDecor = new THREE.Mesh(new THREE.TorusGeometry(0.14, 0.015, 4, 12), new THREE.MeshStandardMaterial({ color: '#78350f', roughness: 0.5 }));
    ringDecor.rotation.x = Math.PI / 2;
    ringDecor.position.y = 0.012;
    perungguGroup.add(ringDecor);
    addInteractive(perungguGroup, "Piring Perunggu", false, -1, "Ini piring hias perunggu kuno, bukan Pinto Aceh!", "Barang");

    // 12. Decoy Batu Akik Biru (Gem on stand)
    const akikGroup = new THREE.Group();
    akikGroup.position.set(-2.2, 0.95, -12.3);
    const stand = new THREE.Mesh(new THREE.CylinderGeometry(0.1, 0.12, 0.08, 8), new THREE.MeshStandardMaterial({ color: '#1e293b', roughness: 0.8 }));
    stand.castShadow = true;
    akikGroup.add(stand);
    const gemAkik = new THREE.Mesh(new THREE.OctahedronGeometry(0.12), new THREE.MeshStandardMaterial({ color: '#2563eb', roughness: 0.1, metalness: 0.7 }));
    gemAkik.position.y = 0.12;
    akikGroup.add(gemAkik);
    addInteractive(akikGroup, "Batu Akik Biru", false, -1, "Ini batu akik permata biru biasa, bukan perhiasan Pinto Aceh!", "Barang");

    // 13. Detailed Rapa'i (Red drum rim, yellow skin, gold side jingles)
    const rapaiGroup = new THREE.Group();
    rapaiGroup.position.set(8.0, 0.58, 6.0);
    const woodRimMat = new THREE.MeshStandardMaterial({ color: '#b91c1c', roughness: 0.4 });
    const outerRim = new THREE.Mesh(new THREE.CylinderGeometry(0.3, 0.3, 0.14, 16), woodRimMat);
    outerRim.castShadow = true;
    rapaiGroup.add(outerRim);

    const drumSkin = new THREE.Mesh(new THREE.CylinderGeometry(0.284, 0.284, 0.02, 16), new THREE.MeshStandardMaterial({ color: '#fef08a', roughness: 0.85 }));
    drumSkin.position.y = 0.07;
    rapaiGroup.add(drumSkin);

    const jingleMat = new THREE.MeshStandardMaterial({ color: '#eab308', roughness: 0.12, metalness: 0.9 });
    for (let i = 0; i < 3; i++) {
        const jingleGroup = new THREE.Group();
        const ang = (Math.PI * 2 / 3) * i;
        jingleGroup.position.set(Math.sin(ang) * 0.29, 0, Math.cos(ang) * 0.29);
        jingleGroup.rotation.y = -ang;
        
        const disc1 = new THREE.Mesh(new THREE.CylinderGeometry(0.045, 0.045, 0.005, 8), jingleMat);
        disc1.position.y = 0.02;
        disc1.rotation.z = Math.PI / 2;
        jingleGroup.add(disc1);
        
        const disc2 = new THREE.Mesh(new THREE.CylinderGeometry(0.045, 0.045, 0.005, 8), jingleMat);
        disc2.position.y = -0.02;
        disc2.rotation.z = Math.PI / 2;
        jingleGroup.add(disc2);
        
        rapaiGroup.add(jingleGroup);
    }

    const cordMat = new THREE.MeshStandardMaterial({ color: '#fde68a', roughness: 0.9 });
    for (let i = 0; i < 12; i++) {
        const cord = new THREE.Mesh(new THREE.CylinderGeometry(0.004, 0.004, 0.14), cordMat);
        const ang = (Math.PI / 6) * i;
        cord.position.set(Math.sin(ang)*0.292, 0, Math.cos(ang)*0.292);
        cord.rotation.z = (i % 2 === 0 ? 0.18 : -0.18);
        rapaiGroup.add(cord);
    }
    addInteractive(rapaiGroup, "Rapa'i", true, 3, "Rebana tradisional Aceh pengiring tari Seudati yang bermakna dakwah.", "Alat Musik");

    // 14. Decoy Suling Bambu (Bamboo flute with holes)
    const sulingGroup = new THREE.Group();
    sulingGroup.position.set(7.2, 0.55, 5.6);
    const pipe = new THREE.Mesh(new THREE.CylinderGeometry(0.02, 0.02, 0.6, 8), new THREE.MeshStandardMaterial({ color: '#d97706', roughness: 0.9 }));
    pipe.castShadow = true;
    pipe.rotation.z = Math.PI / 2;
    pipe.rotation.y = 0.3;
    sulingGroup.add(pipe);
    const holeMat = new THREE.MeshBasicMaterial({ color: '#1a0f00' });
    for (let i = 0; i < 5; i++) {
        const hole = new THREE.Mesh(new THREE.BoxGeometry(0.015, 0.005, 0.015), holeMat);
        hole.position.set(-0.15 + i * 0.08, 0.02, 0);
        sulingGroup.add(hole);
    }
    addInteractive(sulingGroup, "Suling Bambu", false, -1, "Ini suling bambu peniup melodi, bukan rebana Rapa'i!", "Alat Musik");

    // 15. Decoy Kendang Jawa
    const kendangGroup = new THREE.Group();
    kendangGroup.position.set(8.8, 0.6, 6.4);
    const bodyKendang = new THREE.Mesh(new THREE.CylinderGeometry(0.14, 0.18, 0.5, 10), new THREE.MeshStandardMaterial({ color: '#7c2d12', roughness: 0.8 }));
    bodyKendang.castShadow = true;
    bodyKendang.rotation.z = Math.PI / 2;
    bodyKendang.rotation.y = -0.4;
    kendangGroup.add(bodyKendang);
    const skinL = new THREE.Mesh(new THREE.CylinderGeometry(0.142, 0.142, 0.01, 10), new THREE.MeshStandardMaterial({ color: '#fef08a', roughness: 0.9 }));
    skinL.position.set(-0.25, 0, 0);
    skinL.rotation.z = Math.PI / 2;
    kendangGroup.add(skinL);
    addInteractive(kendangGroup, "Kendang Jawa", false, -1, "Ini kendang kayu double-sided khas Jawa, bukan rebana Rapa'i!", "Alat Musik");

    // 16. Decoy Gong Emas (Gong, frame, mallet)
    const gongGroup = new THREE.Group();
    gongGroup.position.set(8.0, 1.1, 5.0);
    const gongDisc = new THREE.Mesh(new THREE.CylinderGeometry(0.35, 0.35, 0.04, 12), new THREE.MeshStandardMaterial({ color: '#ca8a04', roughness: 0.2, metalness: 0.8 }));
    gongDisc.castShadow = true;
    gongDisc.rotation.x = Math.PI / 2;
    gongGroup.add(gongDisc);
    const frameLeft = new THREE.Mesh(new THREE.BoxGeometry(0.08, 1.2, 0.08), new THREE.MeshStandardMaterial({ color: '#451a03' }));
    frameLeft.position.set(-0.45, -0.4, 0);
    gongGroup.add(frameLeft);
    const frameRight = new THREE.Mesh(new THREE.BoxGeometry(0.08, 1.2, 0.08), new THREE.MeshStandardMaterial({ color: '#451a03' }));
    frameRight.position.set(0.45, -0.4, 0);
    gongGroup.add(frameRight);
    const frameTop = new THREE.Mesh(new THREE.BoxGeometry(1.0, 0.08, 0.08), new THREE.MeshStandardMaterial({ color: '#451a03' }));
    frameTop.position.set(0, 0.2, 0);
    gongGroup.add(frameTop);
    const malletStick = new THREE.Mesh(new THREE.CylinderGeometry(0.01, 0.01, 0.3), new THREE.MeshStandardMaterial({ color: '#b45309' }));
    malletStick.position.set(0.1, -0.45, 0.1);
    malletStick.rotation.z = 1.0;
    gongGroup.add(malletStick);
    const malletHead = new THREE.Mesh(new THREE.SphereGeometry(0.04, 8, 8), new THREE.MeshStandardMaterial({ color: '#ef4444' }));
    malletHead.position.set(0.2, -0.37, 0.1);
    gongGroup.add(malletHead);
    addInteractive(gongGroup, "Gong Emas", false, -1, "Ini gong gantung kuningan Jawa, bukan rebana Rapa'i!", "Alat Musik");

    // ─── NPC: LAKSAMANA MALAHAYATI ────────────────────────────────────
    const npcGroup = new THREE.Group();
    npcGroup.position.set(0.6, 0.44, 28); // Dock start
    scene.add(npcGroup);

    const npcRedMat = new THREE.MeshStandardMaterial({ color: '#b91c1c', roughness: 0.7 });
    const npcGoldMat = new THREE.MeshStandardMaterial({ color: '#d97706', roughness: 0.2, metalness: 0.7 });
    const skinMat = new THREE.MeshStandardMaterial({ color: '#ffedd5', roughness: 0.8 });
    const npcWhiteMat = new THREE.MeshStandardMaterial({ color: '#f8fafc', roughness: 0.9 });
    const npcJewelMat = new THREE.MeshStandardMaterial({ color: '#06b6d4', roughness: 0.1, metalness: 0.9 }); // Cyan sapphire
    const npcDarkWoodMat = new THREE.MeshStandardMaterial({ color: '#1c1917', roughness: 0.6 });

    // 1. Dress (Royal Baju Kurung)
    const bodyNpc = new THREE.Mesh(new THREE.CylinderGeometry(0.24, 0.44, 1.4, 10), npcRedMat);
    bodyNpc.position.y = 0.7;
    bodyNpc.castShadow = true;
    npcGroup.add(bodyNpc);

    // Collar trim (gold embroidery)
    const collarTrim = new THREE.Mesh(new THREE.CylinderGeometry(0.25, 0.26, 0.08, 10), npcGoldMat);
    collarTrim.position.y = 1.34;
    npcGroup.add(collarTrim);

    // Bottom hem trim (gold embroidery)
    const hemTrim = new THREE.Mesh(new THREE.CylinderGeometry(0.43, 0.45, 0.12, 10), npcGoldMat);
    hemTrim.position.y = 0.06;
    npcGroup.add(hemTrim);

    // Gold sash/belt
    const sashNpc = new THREE.Mesh(new THREE.CylinderGeometry(0.26, 0.28, 0.12, 10), npcGoldMat);
    sashNpc.position.y = 0.85;
    npcGroup.add(sashNpc);

    // 2. Head & Hijab/Veil
    const headNpc = new THREE.Mesh(new THREE.SphereGeometry(0.22, 12, 12), skinMat);
    headNpc.position.y = 1.55;
    headNpc.castShadow = true;
    npcGroup.add(headNpc);

    // White hijab wrap (under-veil around head)
    const hijabWrap = new THREE.Mesh(new THREE.SphereGeometry(0.23, 10, 10), npcWhiteMat);
    hijabWrap.position.set(0, 1.56, -0.02);
    hijabWrap.scale.set(1.02, 1.02, 1.05);
    npcGroup.add(hijabWrap);

    // Flowing veil cascading down the back
    const veilDrape = new THREE.Mesh(new THREE.BoxGeometry(0.38, 0.9, 0.06), npcWhiteMat);
    veilDrape.position.set(0, 1.1, -0.16);
    veilDrape.rotation.x = 0.15;
    veilDrape.castShadow = true;
    npcGroup.add(veilDrape);

    // 3. Detailed Royal Crown (Mahkota Aceh)
    const crownBase = new THREE.Mesh(new THREE.CylinderGeometry(0.22, 0.23, 0.08, 10), npcGoldMat);
    crownBase.position.y = 1.76;
    npcGroup.add(crownBase);

    // 5 pointed spikes for Acehnese crown
    const spikesNpc = [];
    const numSpikes = 5;
    for (let i = 0; i < numSpikes; i++) {
        const spike = new THREE.Mesh(new THREE.ConeGeometry(0.045, 0.22, 4), npcGoldMat);
        const ang = -Math.PI / 4 + (Math.PI / 8) * i; // semi-circle on front
        spike.position.set(Math.sin(ang) * 0.2, 1.84 + (i % 2 === 0 ? 0.02 : 0.06), Math.cos(ang) * 0.2);
        spike.rotation.y = ang;
        spike.rotation.x = 0.1;
        spike.rotation.z = -ang * 0.6;
        npcGroup.add(spike);
        spikesNpc.push(spike);

        // Gem on tip of each spike
        const gem = new THREE.Mesh(new THREE.SphereGeometry(0.02, 4, 4), npcJewelMat);
        gem.position.set(Math.sin(ang) * 0.21, 1.95 + (i % 2 === 0 ? 0.02 : 0.06), Math.cos(ang) * 0.21);
        npcGroup.add(gem);
    }

    // Crown Center Emblem Gem
    const npcCenterGem = new THREE.Mesh(new THREE.BoxGeometry(0.05, 0.05, 0.03), npcJewelMat);
    npcCenterGem.position.set(0, 1.78, 0.22);
    npcCenterGem.rotation.z = Math.PI / 4;
    npcGroup.add(npcCenterGem);

    // 4. Face Features
    // Eyes (white sclera + black pupil)
    const leftEyeWhiteNpc = new THREE.Mesh(new THREE.BoxGeometry(0.05, 0.035, 0.015), new THREE.MeshBasicMaterial({ color: '#ffffff' }));
    leftEyeWhiteNpc.position.set(-0.068, 1.57, 0.2);
    leftEyeWhiteNpc.rotation.y = -0.15;
    npcGroup.add(leftEyeWhiteNpc);

    const rightEyeWhiteNpc = new THREE.Mesh(new THREE.BoxGeometry(0.05, 0.035, 0.015), new THREE.MeshBasicMaterial({ color: '#ffffff' }));
    rightEyeWhiteNpc.position.set(0.068, 1.57, 0.2);
    rightEyeWhiteNpc.rotation.y = 0.15;
    npcGroup.add(rightEyeWhiteNpc);

    const leftPupilNpc = new THREE.Mesh(new THREE.BoxGeometry(0.022, 0.026, 0.015), new THREE.MeshBasicMaterial({ color: '#111827' }));
    leftPupilNpc.position.set(-0.068, 1.57, 0.21);
    leftPupilNpc.rotation.y = -0.15;
    npcGroup.add(leftPupilNpc);

    const rightPupilNpc = new THREE.Mesh(new THREE.BoxGeometry(0.022, 0.026, 0.015), new THREE.MeshBasicMaterial({ color: '#111827' }));
    rightPupilNpc.position.set(0.068, 1.57, 0.21);
    rightPupilNpc.rotation.y = 0.15;
    npcGroup.add(rightPupilNpc);

    // Eyebrows
    const leftEyebrowNpc = new THREE.Mesh(new THREE.BoxGeometry(0.05, 0.01, 0.015), new THREE.MeshBasicMaterial({ color: '#1e293b' }));
    leftEyebrowNpc.position.set(-0.068, 1.61, 0.2);
    leftEyebrowNpc.rotation.y = -0.15;
    leftEyebrowNpc.rotation.z = 0.12;
    npcGroup.add(leftEyebrowNpc);

    const rightEyebrowNpc = new THREE.Mesh(new THREE.BoxGeometry(0.05, 0.01, 0.015), new THREE.MeshBasicMaterial({ color: '#1e293b' }));
    rightEyebrowNpc.position.set(0.068, 1.61, 0.2);
    rightEyebrowNpc.rotation.y = 0.15;
    rightEyebrowNpc.rotation.z = -0.12;
    npcGroup.add(rightEyebrowNpc);

    // Nose
    const noseNpc = new THREE.Mesh(new THREE.BoxGeometry(0.02, 0.045, 0.025), skinMat);
    noseNpc.position.set(0, 1.53, 0.22);
    npcGroup.add(noseNpc);

    // Smile
    const smileNpc = new THREE.Mesh(new THREE.BoxGeometry(0.05, 0.01, 0.015), new THREE.MeshBasicMaterial({ color: '#991b1b' }));
    smileNpc.position.set(0, 1.46, 0.2);
    npcGroup.add(smileNpc);

    // 5. Segmented Arms & Royal Gold Bracelets
    // Left Arm
    const leftShoulderNpc = new THREE.Mesh(new THREE.SphereGeometry(0.08, 6, 6), npcRedMat);
    leftShoulderNpc.position.set(-0.31, 1.2, 0);
    npcGroup.add(leftShoulderNpc);

    const leftUpperArmNpc = new THREE.Mesh(new THREE.CylinderGeometry(0.06, 0.05, 0.35, 8), npcRedMat);
    leftUpperArmNpc.position.set(-0.35, 1.02, 0.06);
    leftUpperArmNpc.rotation.x = 0.3;
    leftUpperArmNpc.rotation.z = 0.15;
    leftUpperArmNpc.castShadow = true;
    npcGroup.add(leftUpperArmNpc);

    const leftForearmNpc = new THREE.Mesh(new THREE.CylinderGeometry(0.05, 0.045, 0.3, 8), skinMat);
    leftForearmNpc.position.set(-0.33, 0.82, 0.18);
    leftForearmNpc.rotation.x = 0.8;
    leftForearmNpc.rotation.z = 0.05;
    leftForearmNpc.castShadow = true;
    npcGroup.add(leftForearmNpc);

    const leftBraceletNpc = new THREE.Mesh(new THREE.CylinderGeometry(0.054, 0.054, 0.04, 8), npcGoldMat);
    leftBraceletNpc.position.set(-0.33, 0.85, 0.16);
    leftBraceletNpc.rotation.x = 0.8;
    npcGroup.add(leftBraceletNpc);

    const leftHandNpc = new THREE.Mesh(new THREE.SphereGeometry(0.05, 6, 6), skinMat);
    leftHandNpc.position.set(-0.31, 0.69, 0.28);
    npcGroup.add(leftHandNpc);

    // Right Arm (resting on Rencong hilt)
    const rightShoulderNpc = new THREE.Mesh(new THREE.SphereGeometry(0.08, 6, 6), npcRedMat);
    rightShoulderNpc.position.set(0.31, 1.2, 0);
    npcGroup.add(rightShoulderNpc);

    const rightUpperArmNpc = new THREE.Mesh(new THREE.CylinderGeometry(0.06, 0.05, 0.35, 8), npcRedMat);
    rightUpperArmNpc.position.set(0.34, 1.02, 0.06);
    rightUpperArmNpc.rotation.x = 0.3;
    rightUpperArmNpc.rotation.z = -0.15;
    rightUpperArmNpc.castShadow = true;
    npcGroup.add(rightUpperArmNpc);

    const rightForearmNpc = new THREE.Mesh(new THREE.CylinderGeometry(0.05, 0.045, 0.3, 8), skinMat);
    rightForearmNpc.position.set(0.31, 0.84, 0.2);
    rightForearmNpc.rotation.x = 0.9;
    rightForearmNpc.rotation.z = -0.2;
    rightForearmNpc.castShadow = true;
    npcGroup.add(rightForearmNpc);

    const rightBraceletNpc = new THREE.Mesh(new THREE.CylinderGeometry(0.054, 0.054, 0.04, 8), npcGoldMat);
    rightBraceletNpc.position.set(0.32, 0.87, 0.17);
    rightBraceletNpc.rotation.x = 0.9;
    npcGroup.add(rightBraceletNpc);

    const rightHandNpc = new THREE.Mesh(new THREE.SphereGeometry(0.05, 6, 6), skinMat);
    rightHandNpc.position.set(0.24, 0.72, 0.3);
    npcGroup.add(rightHandNpc);

    // 6. Highly Detailed Traditional Rencong (Tucked in waist sash)
    const rencongGroup = new THREE.Group();
    rencongGroup.position.set(0.12, 0.85, 0.23);
    rencongGroup.rotation.z = -0.7;
    rencongGroup.rotation.y = 0.15;
    npcGroup.add(rencongGroup);

    const sheathRencong = new THREE.Mesh(new THREE.BoxGeometry(0.05, 0.32, 0.024), new THREE.MeshStandardMaterial({ color: '#78350f', roughness: 0.8 }));
    sheathRencong.position.y = -0.12;
    sheathRencong.castShadow = true;
    rencongGroup.add(sheathRencong);

    const sheathTail = new THREE.Mesh(new THREE.BoxGeometry(0.05, 0.08, 0.05), new THREE.MeshStandardMaterial({ color: '#78350f', roughness: 0.8 }));
    sheathTail.position.set(0.02, -0.28, 0);
    sheathTail.rotation.z = -0.4;
    rencongGroup.add(sheathTail);

    const sheathBand1 = new THREE.Mesh(new THREE.BoxGeometry(0.054, 0.03, 0.028), npcGoldMat);
    sheathBand1.position.y = -0.04;
    rencongGroup.add(sheathBand1);

    const sheathBand2 = new THREE.Mesh(new THREE.BoxGeometry(0.054, 0.03, 0.028), npcGoldMat);
    sheathBand2.position.y = -0.2;
    rencongGroup.add(sheathBand2);

    const hiltRencong = new THREE.Mesh(new THREE.BoxGeometry(0.032, 0.08, 0.032), npcDarkWoodMat);
    hiltRencong.position.set(0, 0.04, 0);
    rencongGroup.add(hiltRencong);

    const hiltHorn = new THREE.Mesh(new THREE.BoxGeometry(0.032, 0.032, 0.12), npcDarkWoodMat);
    hiltHorn.position.set(0, 0.08, 0.045);
    hiltHorn.rotation.x = 0.25;
    rencongGroup.add(hiltHorn);

    const hiltCollar = new THREE.Mesh(new THREE.CylinderGeometry(0.022, 0.022, 0.02, 8), npcGoldMat);
    hiltCollar.position.y = 0.01;
    rencongGroup.add(hiltCollar);

    // ─── PLAYER AVATAR ────────────────────────────────────────────────
    const playerGroup = new THREE.Group();
    playerGroup.position.set(0, 0.35, 0); // Start center
    scene.add(playerGroup);

    const blueMat = new THREE.MeshStandardMaterial({ color: '#1d4ed8', roughness: 0.6 });
    const pantsMat = new THREE.MeshStandardMaterial({ color: '#475569', roughness: 0.8 });
    const bootMat = new THREE.MeshStandardMaterial({ color: '#292524', roughness: 0.8 });
    const backpackMat = new THREE.MeshStandardMaterial({ color: '#7c2d12', roughness: 0.9 });
    const beltMat = new THREE.MeshStandardMaterial({ color: '#1e293b', roughness: 0.5 });
    const eyeMat = new THREE.MeshBasicMaterial({ color: '#0f172a' });
    const hairMat = new THREE.MeshStandardMaterial({ color: '#1e1b4b', roughness: 0.9 });

    // Torso (Explorer vest)
    const torsoGroup = new THREE.Group();
    torsoGroup.position.y = 0.55;
    playerGroup.add(torsoGroup);

    const body = new THREE.Mesh(new THREE.CylinderGeometry(0.24, 0.24, 0.8, 10), blueMat);
    body.castShadow = true;
    body.receiveShadow = true;
    torsoGroup.add(body);

    // Explorer pockets
    const pocketL = new THREE.Mesh(new THREE.BoxGeometry(0.08, 0.08, 0.03), backpackMat);
    pocketL.position.set(-0.11, 0.04, 0.23);
    torsoGroup.add(pocketL);

    const pocketR = new THREE.Mesh(new THREE.BoxGeometry(0.08, 0.08, 0.03), backpackMat);
    pocketR.position.set(0.11, 0.04, 0.23);
    torsoGroup.add(pocketR);

    // Sash strap
    const sashTorso = new THREE.Mesh(new THREE.BoxGeometry(0.05, 0.86, 0.025), backpackMat);
    sashTorso.position.set(0, 0, 0.23);
    sashTorso.rotation.z = -0.4;
    torsoGroup.add(sashTorso);

    // Vest details (collar / open front decoration)
    const vestLeft = new THREE.Mesh(new THREE.BoxGeometry(0.06, 0.8, 0.04), goldMat);
    vestLeft.position.set(-0.1, 0, 0.23);
    torsoGroup.add(vestLeft);

    const vestRight = new THREE.Mesh(new THREE.BoxGeometry(0.06, 0.8, 0.04), goldMat);
    vestRight.position.set(0.1, 0, 0.23);
    torsoGroup.add(vestRight);

    // Vest gold buttons
    for (let i = 0; i < 3; i++) {
        const button = new THREE.Mesh(new THREE.SphereGeometry(0.022, 6, 6), goldMat);
        button.position.set(0, 0.2 - i * 0.16, 0.24);
        torsoGroup.add(button);
    }

    // Belt
    const belt = new THREE.Mesh(new THREE.CylinderGeometry(0.25, 0.25, 0.08, 10), beltMat);
    belt.position.y = -0.32;
    torsoGroup.add(belt);

    const buckle = new THREE.Mesh(new THREE.BoxGeometry(0.1, 0.1, 0.06), goldMat);
    buckle.position.set(0, -0.32, 0.23);
    torsoGroup.add(buckle);

    // Backpack
    const backpack = new THREE.Mesh(new THREE.BoxGeometry(0.36, 0.52, 0.2), backpackMat);
    backpack.position.set(0, 0.08, -0.2);
    backpack.castShadow = true;
    torsoGroup.add(backpack);

    const pocket = new THREE.Mesh(new THREE.BoxGeometry(0.24, 0.2, 0.06), backpackMat);
    pocket.position.set(0, -0.1, -0.26);
    torsoGroup.add(pocket);

    // Backpack shoulder straps
    const strapLeft = new THREE.Mesh(new THREE.BoxGeometry(0.04, 0.6, 0.02), backpackMat);
    strapLeft.position.set(-0.16, 0.1, 0.24);
    torsoGroup.add(strapLeft);

    const strapRight = new THREE.Mesh(new THREE.BoxGeometry(0.04, 0.6, 0.02), backpackMat);
    strapRight.position.set(0.16, 0.1, 0.24);
    torsoGroup.add(strapRight);

    // Rolled sleeping bag/bedroll
    const bedroll = new THREE.Mesh(new THREE.CylinderGeometry(0.08, 0.08, 0.42, 8), new THREE.MeshStandardMaterial({ color: '#16a34a', roughness: 0.9 }));
    bedroll.rotation.z = Math.PI / 2;
    bedroll.position.set(0, 0.38, -0.2);
    torsoGroup.add(bedroll);

    const bedrollStrapL = new THREE.Mesh(new THREE.BoxGeometry(0.02, 0.17, 0.17), backpackMat);
    bedrollStrapL.position.set(-0.12, 0.38, -0.2);
    torsoGroup.add(bedrollStrapL);

    const bedrollStrapR = new THREE.Mesh(new THREE.BoxGeometry(0.02, 0.17, 0.17), backpackMat);
    bedrollStrapR.position.set(0.12, 0.38, -0.2);
    torsoGroup.add(bedrollStrapR);

    // Head
    const headGroup = new THREE.Group();
    headGroup.position.y = 1.12;
    playerGroup.add(headGroup);

    const head = new THREE.Mesh(new THREE.SphereGeometry(0.22, 12, 12), skinMat);
    head.castShadow = true;
    headGroup.add(head);

    // Eyes (detailed whites + pupils)
    const leftEyeWhite = new THREE.Mesh(new THREE.BoxGeometry(0.05, 0.03, 0.015), new THREE.MeshBasicMaterial({ color: '#ffffff' }));
    leftEyeWhite.position.set(-0.07, 0.03, 0.19);
    leftEyeWhite.rotation.y = -0.15;
    headGroup.add(leftEyeWhite);

    const rightEyeWhite = new THREE.Mesh(new THREE.BoxGeometry(0.05, 0.03, 0.015), new THREE.MeshBasicMaterial({ color: '#ffffff' }));
    rightEyeWhite.position.set(0.07, 0.03, 0.19);
    rightEyeWhite.rotation.y = 0.15;
    headGroup.add(rightEyeWhite);

    const leftEye = new THREE.Mesh(new THREE.BoxGeometry(0.022, 0.022, 0.015), new THREE.MeshBasicMaterial({ color: '#2563eb' })); // Explorer blue eyes
    leftEye.position.set(-0.07, 0.03, 0.20);
    leftEye.rotation.y = -0.15;
    headGroup.add(leftEye);

    const rightEye = new THREE.Mesh(new THREE.BoxGeometry(0.022, 0.022, 0.015), new THREE.MeshBasicMaterial({ color: '#2563eb' }));
    rightEye.position.set(0.07, 0.03, 0.20);
    rightEye.rotation.y = 0.15;
    headGroup.add(rightEye);

    // Eyebrows
    const leftEyebrow = new THREE.Mesh(new THREE.BoxGeometry(0.05, 0.008, 0.015), new THREE.MeshBasicMaterial({ color: '#1e293b' }));
    leftEyebrow.position.set(-0.07, 0.07, 0.19);
    leftEyebrow.rotation.y = -0.15;
    headGroup.add(leftEyebrow);

    const rightEyebrow = new THREE.Mesh(new THREE.BoxGeometry(0.05, 0.008, 0.015), new THREE.MeshBasicMaterial({ color: '#1e293b' }));
    rightEyebrow.position.set(0.07, 0.07, 0.19);
    rightEyebrow.rotation.y = 0.15;
    headGroup.add(rightEyebrow);

    // Nose
    const nose = new THREE.Mesh(new THREE.BoxGeometry(0.02, 0.04, 0.02), skinMat);
    nose.position.set(0, -0.01, 0.21);
    headGroup.add(nose);

    // Smile
    const mouth = new THREE.Mesh(new THREE.BoxGeometry(0.06, 0.01, 0.015), new THREE.MeshBasicMaterial({ color: '#be123c' }));
    mouth.position.set(0, -0.07, 0.19);
    headGroup.add(mouth);

    // Hair
    const hairBack = new THREE.Mesh(new THREE.SphereGeometry(0.21, 8, 8), hairMat);
    hairBack.position.set(0, 0.03, -0.04);
    headGroup.add(hairBack);

    // Hair Bangs/Sideburns
    const hairBangs = new THREE.Mesh(new THREE.BoxGeometry(0.24, 0.06, 0.05), hairMat);
    hairBangs.position.set(0, 0.1, 0.18);
    headGroup.add(hairBangs);

    const leftSideburn = new THREE.Mesh(new THREE.BoxGeometry(0.03, 0.12, 0.04), hairMat);
    leftSideburn.position.set(-0.21, -0.05, 0.06);
    headGroup.add(leftSideburn);

    const rightSideburn = new THREE.Mesh(new THREE.BoxGeometry(0.03, 0.12, 0.04), hairMat);
    rightSideburn.position.set(0.21, -0.05, 0.06);
    headGroup.add(rightSideburn);

    // Detailed Kupiah Meukeutop (Traditional Aceh Hat)
    const hatGroup = new THREE.Group();
    hatGroup.position.y = 0.16;
    headGroup.add(hatGroup);

    // Base (black band)
    const hatBase = new THREE.Mesh(new THREE.CylinderGeometry(0.22, 0.22, 0.08, 10), new THREE.MeshStandardMaterial({ color: '#0f172a', roughness: 0.9 }));
    hatGroup.add(hatBase);

    // Middle (yellow pattern)
    const hatMid = new THREE.Mesh(new THREE.CylinderGeometry(0.2, 0.22, 0.06, 10), new THREE.MeshStandardMaterial({ color: '#d97706', roughness: 0.9 }));
    hatMid.position.y = 0.07;
    hatGroup.add(hatMid);

    // Middle Pattern Details (8 vertical stripes red/green)
    for (let i = 0; i < 8; i++) {
        const ang = (Math.PI / 4) * i;
        const colorStripe = i % 2 === 0 ? '#b91c1c' : '#16a34a';
        const stripe = new THREE.Mesh(new THREE.BoxGeometry(0.02, 0.06, 0.03), new THREE.MeshStandardMaterial({ color: colorStripe }));
        stripe.position.set(Math.sin(ang) * 0.21, 0.07, Math.cos(ang) * 0.21);
        stripe.rotation.y = -ang;
        hatGroup.add(stripe);
    }

    // Top (red cone with gold tip)
    const hatTop = new THREE.Mesh(new THREE.ConeGeometry(0.2, 0.2, 8), new THREE.MeshStandardMaterial({ color: '#b91c1c', roughness: 0.9 }));
    hatTop.position.y = 0.18;
    hatGroup.add(hatTop);

    // Gold wraps on red cone
    const hatWrapGold = new THREE.Mesh(new THREE.CylinderGeometry(0.12, 0.14, 0.02, 8), goldMat);
    hatWrapGold.position.y = 0.18;
    hatGroup.add(hatWrapGold);

    const hatTip = new THREE.Mesh(new THREE.SphereGeometry(0.04, 6, 6), goldMat);
    hatTip.position.y = 0.28;
    hatGroup.add(hatTip);

    // Legs (Pivot at hip)
    const leftLegGroup = new THREE.Group();
    leftLegGroup.position.set(-0.13, 0.25, 0);
    playerGroup.add(leftLegGroup);

    const leftLeg = new THREE.Mesh(new THREE.CylinderGeometry(0.08, 0.075, 0.45, 8), pantsMat);
    leftLeg.position.y = -0.15;
    leftLeg.castShadow = true;
    leftLegGroup.add(leftLeg);

    const leftBootCuff = new THREE.Mesh(new THREE.CylinderGeometry(0.085, 0.085, 0.06, 8), bootMat);
    leftBootCuff.position.y = -0.34;
    leftLegGroup.add(leftBootCuff);

    const leftBoot = new THREE.Mesh(new THREE.BoxGeometry(0.11, 0.09, 0.18), bootMat);
    leftBoot.position.set(0, -0.4, 0.04);
    leftBoot.castShadow = true;
    leftLegGroup.add(leftBoot);

    const leftBootSole = new THREE.Mesh(new THREE.BoxGeometry(0.12, 0.02, 0.19), new THREE.MeshStandardMaterial({ color: '#09090b', roughness: 0.9 }));
    leftBootSole.position.set(0, -0.45, 0.04);
    leftLegGroup.add(leftBootSole);

    const rightLegGroup = new THREE.Group();
    rightLegGroup.position.set(0.13, 0.25, 0);
    playerGroup.add(rightLegGroup);

    const rightLeg = new THREE.Mesh(new THREE.CylinderGeometry(0.08, 0.075, 0.45, 8), pantsMat);
    rightLeg.position.y = -0.15;
    rightLeg.castShadow = true;
    rightLegGroup.add(rightLeg);

    const rightBootCuff = new THREE.Mesh(new THREE.CylinderGeometry(0.085, 0.085, 0.06, 8), bootMat);
    rightBootCuff.position.y = -0.34;
    rightLegGroup.add(rightBootCuff);

    const rightBoot = new THREE.Mesh(new THREE.BoxGeometry(0.11, 0.09, 0.18), bootMat);
    rightBoot.position.set(0, -0.4, 0.04);
    rightBoot.castShadow = true;
    rightLegGroup.add(rightBoot);

    const rightBootSole = new THREE.Mesh(new THREE.BoxGeometry(0.12, 0.02, 0.19), new THREE.MeshStandardMaterial({ color: '#09090b', roughness: 0.9 }));
    rightBootSole.position.set(0, -0.45, 0.04);
    rightLegGroup.add(rightBootSole);

    // Arms (Pivot at shoulder)
    const leftArmGroup = new THREE.Group();
    leftArmGroup.position.set(-0.32, 0.75, 0);
    playerGroup.add(leftArmGroup);

    const leftUpperArm = new THREE.Mesh(new THREE.CylinderGeometry(0.065, 0.06, 0.22, 8), blueMat);
    leftUpperArm.position.y = -0.11;
    leftUpperArm.castShadow = true;
    leftArmGroup.add(leftUpperArm);

    const leftForearm = new THREE.Mesh(new THREE.CylinderGeometry(0.055, 0.05, 0.22, 8), skinMat);
    leftForearm.position.y = -0.32;
    leftForearm.castShadow = true;
    leftArmGroup.add(leftForearm);

    const leftWristBand = new THREE.Mesh(new THREE.CylinderGeometry(0.056, 0.056, 0.02, 8), goldMat);
    leftWristBand.position.y = -0.42;
    leftArmGroup.add(leftWristBand);

    const leftHand = new THREE.Mesh(new THREE.BoxGeometry(0.08, 0.08, 0.05), skinMat);
    leftHand.position.set(0, -0.47, 0);
    leftArmGroup.add(leftHand);

    const leftThumb = new THREE.Mesh(new THREE.BoxGeometry(0.024, 0.035, 0.024), skinMat);
    leftThumb.position.set(-0.045, -0.47, 0.01);
    leftArmGroup.add(leftThumb);

    const rightArmGroup = new THREE.Group();
    rightArmGroup.position.set(0.32, 0.75, 0);
    playerGroup.add(rightArmGroup);

    const rightUpperArm = new THREE.Mesh(new THREE.CylinderGeometry(0.065, 0.06, 0.22, 8), blueMat);
    rightUpperArm.position.y = -0.11;
    rightUpperArm.castShadow = true;
    rightArmGroup.add(rightUpperArm);

    const rightForearm = new THREE.Mesh(new THREE.CylinderGeometry(0.055, 0.05, 0.22, 8), skinMat);
    rightForearm.position.y = -0.32;
    rightForearm.castShadow = true;
    rightArmGroup.add(rightForearm);

    const rightWristBand = new THREE.Mesh(new THREE.CylinderGeometry(0.056, 0.056, 0.02, 8), goldMat);
    rightWristBand.position.y = -0.42;
    rightArmGroup.add(rightWristBand);

    const rightHand = new THREE.Mesh(new THREE.BoxGeometry(0.08, 0.08, 0.05), skinMat);
    rightHand.position.set(0, -0.47, 0);
    rightArmGroup.add(rightHand);

    const rightThumb = new THREE.Mesh(new THREE.BoxGeometry(0.024, 0.035, 0.024), skinMat);
    rightThumb.position.set(0.045, -0.47, 0.01);
    rightArmGroup.add(rightThumb);

    // ─── PLAYER CONTROLLER LOGIC ──────────────────────────────────────
    let moveDir = { w: false, a: false, s: false, d: false };
    let playerVelY = 0;
    let isGrounded = true;
    const gravity = -0.012;
    const jumpPower = 0.28;
    const moveSpeed = 0.15;
    let rotationAngle = 0;

    // Camera orbit parameters
    let cameraPitch = 0.35; // Angle looking down
    let cameraYaw = Math.PI; // Orbit angle
    const cameraRadius = 8.5;
    // (raycaster and mouse are declared globally in the IIFE)

    // Mouse drag & Raycast selection
    let isDragging = false;
    let prevMouseX = 0;
    let prevMouseY = 0;
    let clickStartX = 0;
    let clickStartY = 0;

    document.addEventListener('keydown', (e) => {
        if (awaitingInput || isCompleted) return;
        switch(e.code) {
            case 'KeyW': case 'ArrowUp':    moveDir.w = true; break;
            case 'KeyS': case 'ArrowDown':  moveDir.s = true; break;
            case 'KeyA': case 'ArrowLeft':  moveDir.a = true; break;
            case 'KeyD': case 'ArrowRight': moveDir.d = true; break;
            case 'KeyE':                    inspectObject(); break;
            case 'Space': 
                if (isGrounded) {
                    playerVelY = jumpPower;
                    isGrounded = false;
                }
                break;
        }
    });

    document.addEventListener('keyup', (e) => {
        switch(e.code) {
            case 'KeyW': case 'ArrowUp':    moveDir.w = false; break;
            case 'KeyS': case 'ArrowDown':  moveDir.s = false; break;
            case 'KeyA': case 'ArrowLeft':  moveDir.a = false; break;
            case 'KeyD': case 'ArrowRight': moveDir.d = false; break;
        }
    });

    window.addEventListener('mousedown', (e) => {
        if (e.target.closest('.interactive')) return;
        isDragging = true;
        prevMouseX = e.clientX;
        prevMouseY = e.clientY;
        clickStartX = e.clientX;
        clickStartY = e.clientY;
    });

    window.addEventListener('mousemove', (e) => {
        // Track mouse NDC coords for raycast hover check
        mouse.x = (e.clientX / window.innerWidth) * 2 - 1;
        mouse.y = -(e.clientY / window.innerHeight) * 2 + 1;

        if (!isDragging) return;
        if (prevMouseX === undefined || prevMouseY === undefined || isNaN(prevMouseX)) {
            prevMouseX = e.clientX;
            prevMouseY = e.clientY;
        }
        const deltaX = e.clientX - prevMouseX;
        const deltaY = e.clientY - prevMouseY;
        prevMouseX = e.clientX;
        prevMouseY = e.clientY;

        cameraYaw -= deltaX * 0.007;
        cameraPitch = Math.max(0.12, Math.min(1.2, cameraPitch + deltaY * 0.007));
    });

    window.addEventListener('mouseup', (e) => {
        isDragging = false;
        
        // If mouse moved less than 6px, check raycast click to select & inspect!
        const dx = e.clientX - clickStartX;
        const dy = e.clientY - clickStartY;
        if (Math.sqrt(dx*dx + dy*dy) < 6 && !e.target.closest('.interactive')) {
            checkRaycastInspection(e.clientX, e.clientY);
        }
    });

    // Touch support (Mobile)
    const joyContainer = document.getElementById('joystickContainer');
    const joyKnob = document.getElementById('joystickKnob');
    let joyActive = false;
    let joyStartPos = { x: 0, y: 0 };
    let joyMoveVector = { x: 0, y: 0 };
    let touchStartX = 0;
    let touchStartY = 0;

    window.addEventListener('touchstart', (e) => {
        const touch = e.touches[0];
        if (e.target.closest('#joystickContainer')) {
            joyActive = true;
            const rect = joyContainer.getBoundingClientRect();
            joyStartPos = { x: rect.left + rect.width/2, y: rect.top + rect.height/2 };
            handleJoystickMove(touch.clientX, touch.clientY);
        } else if (!e.target.closest('.interactive')) {
            isDragging = true;
            prevMouseX = touch.clientX;
            prevMouseY = touch.clientY;
            touchStartX = touch.clientX;
            touchStartY = touch.clientY;
        }
    });

    window.addEventListener('touchmove', (e) => {
        const touch = e.touches[0];
        if (joyActive) {
            handleJoystickMove(touch.clientX, touch.clientY);
        } else if (isDragging) {
            if (prevMouseX === undefined || prevMouseY === undefined || isNaN(prevMouseX)) {
                prevMouseX = touch.clientX;
                prevMouseY = touch.clientY;
            }
            const deltaX = touch.clientX - prevMouseX;
            const deltaY = touch.clientY - prevMouseY;
            prevMouseX = touch.clientX;
            prevMouseY = touch.clientY;

            cameraYaw -= deltaX * 0.01;
            cameraPitch = Math.max(0.12, Math.min(1.2, cameraPitch + deltaY * 0.01));
        }
    });

    window.addEventListener('touchend', (e) => {
        joyActive = false;
        isDragging = false;
        joyKnob.style.transform = `translate(0px, 0px)`;
        joyMoveVector = { x: 0, y: 0 };
        moveDir = { w: false, a: false, s: false, d: false };

        if (e.changedTouches && e.changedTouches.length > 0) {
            const touch = e.changedTouches[0];
            const dx = touch.clientX - touchStartX;
            const dy = touch.clientY - touchStartY;
            if (Math.sqrt(dx*dx + dy*dy) < 10 && !e.target.closest('.interactive')) {
                checkRaycastInspection(touch.clientX, touch.clientY);
            }
        }
    });

    function handleJoystickMove(clientX, clientY) {
        let dx = clientX - joyStartPos.x;
        let dy = clientY - joyStartPos.y;
        let dist = Math.sqrt(dx*dx + dy*dy);
        const maxDist = 40;
        
        if (dist > maxDist) {
            dx = (dx / dist) * maxDist;
            dy = (dy / dist) * maxDist;
            dist = maxDist;
        }
        
        joyKnob.style.transform = `translate(${dx}px, ${dy}px)`;
        
        // Normalize vector
        joyMoveVector = { x: dx / maxDist, y: -dy / maxDist };
        
        // Map to keyboard dirs
        moveDir.w = joyMoveVector.y > 0.35;
        moveDir.s = joyMoveVector.y < -0.35;
        moveDir.d = joyMoveVector.x > 0.35;
        moveDir.a = joyMoveVector.x < -0.35;
    }

    function getTerrainHeight(x, z) {
        let maxHeight = 0;
        const hillsList = [
            { x: -16, z: -15, rTop: 2, rBottom: 6, hMax: 1.1 },
            { x: 18, z: 14, rTop: 1.5, rBottom: 5, hMax: 0.9 },
            { x: -18, z: 15, rTop: 2.5, rBottom: 7, hMax: 1.3 }
        ];
        for (let hill of hillsList) {
            const d = Math.sqrt((x - hill.x)**2 + (z - hill.z)**2);
            if (d <= hill.rTop) {
                maxHeight = Math.max(maxHeight, hill.hMax);
            } else if (d < hill.rBottom) {
                const factor = 1 - (d - hill.rTop) / (hill.rBottom - hill.rTop);
                maxHeight = Math.max(maxHeight, hill.hMax * factor);
            }
        }
        return maxHeight;
    }

    // ─── COLLISION & BOUNDARIES ──────────────────────────────────────
    function checkCollisions(newX, newZ) {
        // Boundary Check (Stay on island)
        const distFromCenter = Math.sqrt(newX*newX + newZ*newZ);
        if (distFromCenter > 38) {
            return false;
        }

        // Stilt house pillars collision (5x3 grid relative to house at Z=-12)
        const pillarX = [-3.2, -1.6, 0, 1.6, 3.2];
        const pillarZ = [-14.0, -12.0, -10.0];
        for (let px of pillarX) {
            for (let pz of pillarZ) {
                const dist = Math.sqrt((newX - px)**2 + (newZ - pz)**2);
                if (dist < 0.4) return false;
            }
        }

        // Stairs collision
        if (newX > -0.7 && newX < 0.7 && newZ > -9.5 && newZ < -6.5) {
            return false;
        }

        // Warung Kopi Gayo collision
        if (newX > -13.6 && newX < -10.4 && newZ > 11.1 && newZ < 12.9) {
            return false;
        }

        // Warung Mie Aceh collision
        if (newX > 10.4 && newX < 13.6 && newZ > -4.9 && newZ < -3.1) {
            return false;
        }

        // Cabinet under house collision
        if (newX > -3.1 && newX < -1.3 && newZ > -12.5 && newZ < -11.5) {
            return false;
        }

        // Balai Musik collision
        if (newX > 6.0 && newX < 10.0 && newZ > 4.0 && newZ < 8.0) {
            return false;
        }

        // Fireplace collision (Radius 1.2 at X: -10, Z: 10)
        const distToFire = Math.sqrt((newX + 10)**2 + (newZ - 10)**2);
        if (distToFire < 1.35) {
            return false;
        }

        // Circular obstacle collisions (new trees, citizens, rocks, cargo)
        const obstacles = [
            // Original palm trees
            { x: -12, z: -8, r: 0.65 }, { x: -14, z: -6, r: 0.65 }, { x: 14, z: -12, r: 0.65 }, 
            { x: 16, z: -9, r: 0.65 }, { x: 8, z: 16, r: 0.65 },
            // New palm trees
            { x: -22, z: -18, r: 0.65 }, { x: -20, z: 18, r: 0.65 }, { x: 22, z: -22, r: 0.65 },
            { x: 24, z: 15, r: 0.65 }, { x: 10, z: -25, r: 0.65 }, { x: -8, z: -22, r: 0.65 },
            // Banana trees
            { x: -6, z: -10, r: 0.5 }, { x: -10, z: -16, r: 0.5 }, { x: 18, z: -4, r: 0.5 },
            { x: 4, z: 14, r: 0.5 }, { x: -4, z: 20, r: 0.5 },
            // Citizens & Workers
            { x: -2.2, z: 25.5, r: 0.5 }, { x: -4.5, z: -7.0, r: 0.5 }, { x: -5.5, z: -6.5, r: 0.5 },
            // Cargo Piles
            { x: -14, z: 10.0, r: 0.9 }, { x: 14, z: -6.0, r: 0.9 }, { x: -4, z: 26.0, r: 0.9 },
            // Rock Clusters
            { x: -26, z: -12.0, r: 1.2 }, { x: 24, z: -16.0, r: 1.2 }, { x: 16, z: 10.0, r: 1.2 },
            { x: -10, z: -18.0, r: 1.2 }
        ];
        for (let obs of obstacles) {
            const dist = Math.sqrt((newX - obs.x)**2 + (newZ - obs.z)**2);
            if (dist < obs.r) return false;
        }

        return true;
    }

    // ─── GAME STATE & FLOW ────────────────────────────────────────────
    let itemsCollected = 0;
    let awaitingInput = false;

    const dialogOverlay = document.getElementById('dialogOverlay');
    const dialogSpeaker = document.getElementById('dialogSpeaker');
    const dialogText    = document.getElementById('dialogText');
    const dialogChoices = document.getElementById('dialogChoices');
    const btnDialogNext = document.getElementById('btnDialogNext');
    const questTextEl   = document.getElementById('questText');

    const modalWin    = document.getElementById('modalWin');
    const modalHeart  = document.getElementById('modalHeartEmpty');
    const modalExit   = document.getElementById('modalExit');

    function showDialog(speaker, text, callback = null, choices = null) {
        awaitingInput = true;
        dialogSpeaker.textContent = speaker;
        dialogText.textContent = text;
        dialogOverlay.style.display = 'block';
        dialogChoices.innerHTML = '';
        btnDialogNext.style.display = 'none';

        if (choices) {
            btnDialogNext.style.display = 'none';
            choices.forEach(opt => {
                const btn = document.createElement('button');
                btn.className = 'choice-btn';
                btn.textContent = opt.text;
                btn.onclick = () => {
                    opt.callback(btn);
                };
                dialogChoices.appendChild(btn);
            });
        } else {
            btnDialogNext.style.display = 'block';
            btnDialogNext.onclick = () => {
                dialogOverlay.style.display = 'none';
                awaitingInput = false;
                if (callback) callback();
            };
        }
    }

    // ─── HIDDEN OBJECT INSPECTION LOGIC ────────────────────────────────
    let closestObject = null;
    let closestStall = null;
    let hoveredObject = null;
    
    function checkProximityAndPrompt() {
        if (isCompleted || awaitingInput || hearts <= 0) {
            document.getElementById('interactionPrompt').style.display = 'none';
            closestObject = null;
            closestStall = null;
            return;
        }
        
        // 1. Check proximity to stalls first (range 3.2)
        let nearestStall = null;
        let minStallDist = 3.2;
        
        stallsList.forEach(stall => {
            // Check if any items on this stall are not collected yet
            const hasUncollected = stall.items.some(item => {
                const matchedObj = interactiveObjects.find(o => o.name === item.name);
                return matchedObj && !matchedObj.collected;
            });
            if (!hasUncollected) return;
            
            const dist = Math.sqrt(
                (playerGroup.position.x - stall.center.x)**2 +
                (playerGroup.position.z - stall.center.z)**2
            );
            if (dist < minStallDist) {
                nearestStall = stall;
                minStallDist = dist;
            }
        });
        
        const promptEl = document.getElementById('interactionPrompt');
        const textEl   = document.getElementById('interactText');
        
        if (nearestStall) {
            closestStall = nearestStall;
            closestObject = null; // Stall takes precedence
            textEl.textContent = `Tekan E / Klik untuk Periksa ${nearestStall.name}`;
            promptEl.style.display = 'block';
            return;
        }
        
        closestStall = null;
        
        // 2. Fallback to individual items (range 2.2)
        let nearestObj = null;
        let minDist = 2.2;
        
        interactiveObjects.forEach(obj => {
            if (obj.collected) return;
            const dist = Math.sqrt(
                (playerGroup.position.x - obj.mesh.position.x)**2 +
                (playerGroup.position.z - obj.mesh.position.z)**2
            );
            if (dist < minDist) {
                nearestObj = obj;
                minDist = dist;
            }
        });
        
        if (nearestObj) {
            closestObject = nearestObj;
            textEl.textContent = `Tekan E / Klik untuk Periksa ${nearestObj.typeLabel}`;
            promptEl.style.display = 'block';
        } else {
            closestObject = null;
            promptEl.style.display = 'none';
        }
    }

    function checkHover() {
        if (awaitingInput || isCompleted || hearts <= 0) {
            if (hoveredObject) {
                hoveredObject.mesh.scale.set(1, 1, 1);
                hoveredObject = null;
            }
            document.getElementById('interactionPrompt').style.display = 'none';
            return;
        }
        
        raycaster.setFromCamera(mouse, camera);
        
        const targets = [];
        interactiveObjects.forEach(obj => {
            if (!obj.collected) {
                targets.push(obj.mesh);
            }
        });
        
        const intersects = raycaster.intersectObjects(targets, true);
        let found = null;
        
        if (intersects.length > 0) {
            let current = intersects[0].object;
            while (current) {
                const match = interactiveObjects.find(obj => obj.mesh === current);
                if (match) {
                    found = match;
                    break;
                }
                current = current.parent;
            }
        }
        
        const promptEl = document.getElementById('interactionPrompt');
        const textEl   = document.getElementById('interactText');
        
        if (found) {
            const dist = Math.sqrt(
                (playerGroup.position.x - found.mesh.position.x)**2 +
                (playerGroup.position.z - found.mesh.position.z)**2
            );
            
            if (dist < 5.0) {
                if (hoveredObject && hoveredObject !== found) {
                    hoveredObject.mesh.scale.set(1, 1, 1);
                }
                hoveredObject = found;
                hoveredObject.mesh.scale.set(1.22, 1.22, 1.22); // Highlight scale
                
                closestObject = found;
                closestStall = null; // Direct object hover takes precedence
                textEl.textContent = `Klik untuk Periksa ${found.typeLabel}`;
                promptEl.style.display = 'block';
                return;
            }
        }
        
        if (hoveredObject) {
            hoveredObject.mesh.scale.set(1, 1, 1);
            hoveredObject = null;
        }
        
        // Fallback to proximity (which checks stalls, then items)
        checkProximityAndPrompt();
    }

    function checkRaycastInspection(clientX, clientY) {
        if (awaitingInput || isCompleted || hearts <= 0) return;
        
        mouse.x = (clientX / window.innerWidth) * 2 - 1;
        mouse.y = -(clientY / window.innerHeight) * 2 + 1;
        
        raycaster.setFromCamera(mouse, camera);
        
        const targets = [];
        interactiveObjects.forEach(obj => {
            if (!obj.collected) {
                targets.push(obj.mesh);
            }
        });
        
        const intersects = raycaster.intersectObjects(targets, true);
        
        if (intersects.length > 0) {
            let hitObject = null;
            let current = intersects[0].object;
            
            while (current) {
                hitObject = interactiveObjects.find(obj => obj.mesh === current);
                if (hitObject) break;
                current = current.parent;
            }
            
            if (hitObject) {
                const dist = Math.sqrt(
                    (playerGroup.position.x - hitObject.mesh.position.x)**2 +
                    (playerGroup.position.z - hitObject.mesh.position.z)**2
                );
                
                if (dist < 5.0) {
                    closestObject = hitObject;
                    closestStall = null;
                    inspectObjectDirectly(hitObject);
                } else {
                    showDialog("Terlalu Jauh", `Dekati ${hitObject.name} terlebih dahulu untuk memeriksanya!`);
                }
            }
        }
    }

    function openStallModal(stall) {
        awaitingInput = true; // Pause timer and controls
        
        const modal = document.getElementById('stallModal');
        const titleEl = document.getElementById('stallModalTitle');
        const gridEl = document.getElementById('stallItemsGrid');
        
        titleEl.textContent = stall.name;
        gridEl.innerHTML = '';
        
        stall.items.forEach((item, index) => {
            const matchedObj = interactiveObjects.find(o => o.name === item.name);
            const isCollected = matchedObj ? matchedObj.collected : false;
            
            const btn = document.createElement('button');
            btn.className = 'choice-btn';
            btn.style.display = 'flex';
            btn.style.flexDirection = 'column';
            btn.style.gap = '4px';
            btn.style.padding = '12px';
            btn.style.height = 'auto';
            btn.style.width = '100%';
            
            if (isCollected) {
                btn.style.opacity = '0.5';
                btn.style.pointerEvents = 'none';
            }
            
            const numWords = ["Pertama", "Kedua", "Ketiga", "Keempat"];
            const labelStr = numWords[index] || (index + 1);
            
            btn.innerHTML = `
                <div style="font-weight: 950; font-size: 14px; color: #fff; display: flex; justify-content: space-between; width: 100%;">
                    <span>${item.label} ${isCollected ? '✓' : ''}</span>
                    <span style="color: var(--accent); font-size: 11px;">Pilihan ${labelStr}</span>
                </div>
                <div style="font-size: 12px; color: rgba(255,255,255,0.7); font-weight: 600; text-align: left;">${item.desc}</div>
            `;
            
            btn.onclick = () => {
                if (matchedObj) {
                    inspectObjectDirectly(matchedObj);
                }
            };
            
            gridEl.appendChild(btn);
        });
        
        modal.classList.remove('hidden');
    }

    async function inspectObjectDirectly(obj) {
        if (!obj || isCompleted || hearts <= 0) return;
        
        // Hide overlay and stall modal
        document.getElementById('interactionPrompt').style.display = 'none';
        document.getElementById('stallModal').classList.add('hidden');
        awaitingInput = false; // Reset to allow dialog overlays to handle state
        
        if (obj.isTarget) {
            // Correct target item
            playCorrectSound();
            obj.collected = true;
            scene.remove(obj.mesh);
            itemsCollected++;
            
            const checkEl = document.getElementById('qItem' + obj.targetIdx);
            checkEl.classList.add('done');
            checkEl.innerHTML = `✓ ${obj.name} (Terkumpul)`;
            
            showDialog("Pusaka Aceh Ditemukan!", `${obj.name}: ${obj.detail}`, () => {
                if (itemsCollected === 4) {
                    questTextEl.innerHTML = "Pergilah menemui Laksamana Malahayati di dermaga!";
                    questTextEl.style.color = '#60a5fa';
                } else {
                    questTextEl.innerHTML = `Barang terkumpul: ${itemsCollected}/4. Cari sisa barang!`;
                }
            });
        } else {
            // Decoy trap
            if (obj.alreadyInspected) {
                showDialog("Barang Sudah Diperiksa", `Ini adalah ${obj.name}. Kamu sudah tahu ini bukan barang yang dicari.`);
                return;
            }
            
            playWrongSound();
            obj.alreadyInspected = true;
            awaitingInput = true;
            
            try {
                const res = await fetch(DEDUCT_URL, {
                    method: 'POST',
                    headers: { 'X-CSRF-TOKEN': CSRF, 'Accept': 'application/json' },
                });
                const data = await res.json();
                if (data.ok) {
                    hearts = data.hearts;
                    coins  = data.coins;
                    xp     = data.xp_total;
                    updateHUD();
                    
                    if (data.out_of_hearts) {
                        setTimeout(() => {
                            dialogOverlay.style.display = 'none';
                            modalHeart.classList.remove('hidden');
                        }, 800);
                        showDialog("Salah Ambil!", `${obj.description} (Hati habis!)`);
                        return;
                    }
                }
            } catch(e) {}
            
            showDialog("Salah Ambil!", `${obj.description} Hati kamu berkurang 1!`);
        }
    }

    function inspectObject() {
        if (awaitingInput || isCompleted || hearts <= 0) return;
        
        if (closestStall) {
            openStallModal(closestStall);
        } else if (closestObject) {
            inspectObjectDirectly(closestObject);
        }
    }

    // Timer functions
    function startTimer() {
        if (gameTimer) clearInterval(gameTimer);
        gameTimer = setInterval(() => {
            if (awaitingInput || isCompleted || hearts <= 0) return;
            
            timeLeft--;
            if (timeLeft <= 0) {
                timeLeft = 0;
                clearInterval(gameTimer);
                handleTimeout();
            }
            updateTimerDisplay();
        }, 1000);
    }

    function updateTimerDisplay() {
        const timerPill = document.getElementById('timerPill');
        const timerVal = document.getElementById('timeLeft');
        
        const m = Math.floor(timeLeft / 60).toString().padStart(2, '0');
        const s = (timeLeft % 60).toString().padStart(2, '0');
        timerVal.textContent = `${m}:${s}`;
        
        if (timeLeft <= 20) {
            timerPill.classList.add('low-time');
        } else {
            timerPill.classList.remove('low-time');
        }
    }

    async function handleTimeout() {
        awaitingInput = true;
        try {
            const res = await fetch(DEDUCT_URL, {
                method: 'POST',
                headers: { 'X-CSRF-TOKEN': CSRF, 'Accept': 'application/json' },
            });
            const data = await res.json();
            if (data.ok) {
                hearts = data.hearts;
                coins  = data.coins;
                xp     = data.xp_total;
                updateHUD();
            }
        } catch(e) {}
        
        document.getElementById('modalTimeout').classList.remove('hidden');
    }

    function resetLevel() {
        playerGroup.position.set(0, 0.35, 0);
        playerVelY = 0;
        isGrounded = true;
        
        itemsCollected = 0;
        talkedToMalahayati = false;
        isWithinNPCRange = false;
        
        // Close stall menu overlay
        document.getElementById('stallModal').classList.add('hidden');
        
        interactiveObjects.forEach(obj => {
            obj.collected = false;
            obj.alreadyInspected = false;
            if (!obj.mesh.parent) {
                scene.add(obj.mesh);
            }
        });
        
        document.getElementById('qItem0').innerHTML = "☐ Mie Aceh (Kuliner)";
        document.getElementById('qItem1').innerHTML = "☐ Kopi Gayo (Minuman)";
        document.getElementById('qItem2').innerHTML = "☐ Pinto Aceh (Kerajinan)";
        document.getElementById('qItem3').innerHTML = "☐ Rapa'i (Alat Musik)";
        colTypes.forEach((t, i) => {
            document.getElementById('qItem' + i).classList.remove('done');
        });
        
        questTextEl.innerHTML = "Cari dan kumpulkan warisan budaya Aceh di sekitar desa!";
        questTextEl.style.color = '#fff';
        
        timeLeft = 90;
        updateTimerDisplay();
        startTimer();
        
        awaitingInput = false;
        
        document.getElementById('modalTimeout').classList.add('hidden');
        document.getElementById('modalHeartEmpty').classList.add('hidden');
    }

    let talkedToMalahayati = false;
    let isWithinNPCRange = false;

    function checkNPCOverlap() {
        const dist = Math.sqrt(
            (playerGroup.position.x - npcGroup.position.x)**2 +
            (playerGroup.position.z - npcGroup.position.z)**2
        );

        if (dist < 3) {
            if (!isWithinNPCRange && !awaitingInput) {
                isWithinNPCRange = true;
                if (itemsCollected < 4) {
                    showDialog("Laksamana Malahayati", "Halo penjelajah! Cepat carilah 4 warisan budaya Aceh di sekitar desa (Mie Aceh, Kopi Gayo, Pinto Aceh, Rapa'i) terlebih dahulu. Kapal kita akan berlayar setelah perbekalan lengkap!");
                } else if (!talkedToMalahayati) {
                    talkedToMalahayati = true;
                    triggerFinalQuiz();
                }
            }
        } else {
            isWithinNPCRange = false;
        }
    }

    function triggerFinalQuiz() {
        const choices = [
            {
                text: "Rencong",
                callback: (btn) => handleAnswer(btn, true)
            },
            {
                text: "Keris",
                callback: (btn) => handleAnswer(btn, false)
            },
            {
                text: "Mandau",
                callback: (btn) => handleAnswer(btn, false)
            }
        ];

        showDialog(
            "Laksamana Malahayati",
            "Bagus sekali! Semua perbekalan armada Inong Balee sudah siap. Sebelum kita berlayar, jawablah satu pertanyaanku: Apa nama senjata tradisional khas Aceh yang melambangkan keberanian, kepahlawanan, dan kesetiaan?",
            null,
            choices
        );
    }

    async function handleAnswer(btn, isCorrect) {
        dialogChoices.querySelectorAll('.choice-btn').forEach(b => b.disabled = true);

        if (isCorrect) {
            btn.classList.add('correct');
            setTimeout(async () => {
                dialogOverlay.style.display = 'none';
                awaitingInput = false;
                
                try {
                    const res = await fetch(COMPLETE_URL, {
                        method: 'POST',
                        headers: { 'X-CSRF-TOKEN': CSRF, 'Accept': 'application/json' },
                    });
                    const data = await res.json();
                    if (data.ok) {
                        xp    = data.xp_total;
                        coins = data.coins;
                        updateHUD();
                        document.getElementById('winXp').textContent    = '+' + data.xp_gained + ' XP';
                        document.getElementById('winCoins').textContent = data.island_completed_now
                            ? '+' + data.coins_rewarded + ' 🪙 (Pulau Selesai!)'
                            : coins + ' 🪙';
                    }
                } catch(e) {}

                isCompleted = true;

                // Play outro storyline THEN show win modal
                runStory(OUTRO_SLIDES, () => {
                    modalWin.classList.remove('hidden');
                });
            }, 1000);
        } else {
            btn.classList.add('wrong');
            
            try {
                const res = await fetch(DEDUCT_URL, {
                    method: 'POST',
                    headers: { 'X-CSRF-TOKEN': CSRF, 'Accept': 'application/json' },
                });
                const data = await res.json();
                if (data.ok) {
                    hearts = data.hearts;
                    coins  = data.coins;
                    xp     = data.xp_total;
                    updateHUD();
                    if (data.out_of_hearts) {
                        setTimeout(() => {
                            dialogOverlay.style.display = 'none';
                            modalHeart.classList.remove('hidden');
                        }, 800);
                        return;
                    }
                }
            } catch(e) {}

            setTimeout(() => {
                dialogChoices.querySelectorAll('.choice-btn').forEach(b => {
                    b.disabled = false;
                    b.classList.remove('wrong','correct');
                });
            }, 1000);
        }
    }

    // Refill hearts button handler
    document.getElementById('btnRefillModal').addEventListener('click', async () => {
        try {
            const res = await fetch(REFILL_URL, {
                method: 'POST',
                headers: { 'X-CSRF-TOKEN': CSRF, 'Accept': 'application/json' },
            });
            const data = await res.json();
            if (data.ok) {
                hearts = data.hearts; coins = data.coins; updateHUD();
                resetLevel();
            } else {
                alert(data.message || 'Koin tidak cukup.');
            }
        } catch(e) { alert('Gagal menghubungi server.'); }
    });

    document.getElementById('btnRestartTimeout').addEventListener('click', () => {
        if (hearts <= 0) {
            document.getElementById('modalTimeout').classList.remove('hidden');
            modalHeart.classList.remove('hidden');
        } else {
            resetLevel();
        }
    });

    // Exit modals
    document.getElementById('btnExit').addEventListener('click', () => {
        modalExit.classList.remove('hidden');
    });
    document.getElementById('btnStayModal').addEventListener('click', () => {
        modalExit.classList.add('hidden');
    });

    // Interaction Prompt & Stall Menu Click Listeners
    document.getElementById('btnInteract').addEventListener('click', () => {
        inspectObject();
    });
    document.getElementById('btnStallClose').addEventListener('click', () => {
        document.getElementById('stallModal').classList.add('hidden');
        awaitingInput = false;
    });

    // ─── GAME LOOP / ANIMATION ────────────────────────────────────────
    let clock = new THREE.Clock();
    let walkTimer = 0;

    function animate() {
        animFrameId = requestAnimationFrame(animate);

        // Prevent NaN propagation in camera angles or player positions causing render failures
        if (isNaN(cameraYaw) || typeof cameraYaw !== 'number') cameraYaw = Math.PI;
        if (isNaN(cameraPitch) || typeof cameraPitch !== 'number') cameraPitch = 0.35;
        if (isNaN(playerGroup.position.x) || isNaN(playerGroup.position.y) || isNaN(playerGroup.position.z)) {
            playerGroup.position.set(0, 0.35, 0);
        }

        let delta = clock.getDelta();
        let time = clock.getElapsedTime();

        // 1. Water animation
        const positionAttribute = oceanGeo.attributes.position;
        for (let i = 0; i < positionAttribute.count; i++) {
            const u = positionAttribute.getX(i);
            const v = positionAttribute.getY(i);
            // Height displacement
            const z = Math.sin(u * 0.1 + time) * 0.15 + Math.cos(v * 0.08 + time * 1.2) * 0.15;
            positionAttribute.setZ(i, z);
        }
        positionAttribute.needsUpdate = true;

        // 2. Rotate items (disabled for hidden object realism)

        // 3. Campfire particles
        fireParticles.forEach(p => {
            p.mesh.position.y += p.speedY;
            const wVal = Math.sin(time * p.wiggleSpeed + p.wiggleOffset) * 0.005;
            p.mesh.position.x += wVal;
            
            // Fade out as it rises
            const prog = (p.mesh.position.y - p.startY) / 1.1;
            p.mesh.scale.set(1 - prog, 1 - prog, 1 - prog);
            p.mesh.material.opacity = 0.8 * (1 - prog);

            if (p.mesh.position.y > p.startY + 1) {
                p.mesh.position.y = p.startY;
                p.mesh.position.x = (Math.random() - 0.5)*0.25;
                p.mesh.position.z = (Math.random() - 0.5)*0.25;
                p.mesh.scale.set(1, 1, 1);
            }
        });

        // 4. Ship rocking gently
        shipGroup.rotation.z = Math.sin(time * 1.5) * 0.02;
        shipGroup.position.y = -0.6 + Math.cos(time * 1.2) * 0.04;

        // 5. Player movement
        let isMoving = false;
        if (!awaitingInput && !isCompleted && hearts > 0) {
            let dx = 0;
            let dz = 0;

            // Movement relative to camera yaw
            if (moveDir.w) { dx -= Math.sin(cameraYaw); dz -= Math.cos(cameraYaw); isMoving = true; }
            if (moveDir.s) { dx += Math.sin(cameraYaw); dz += Math.cos(cameraYaw); isMoving = true; }
            if (moveDir.a) { dx -= Math.cos(cameraYaw); dz += Math.sin(cameraYaw); isMoving = true; }
            if (moveDir.d) { dx += Math.cos(cameraYaw); dz -= Math.sin(cameraYaw); isMoving = true; }

            // Normalize vector
            if (isMoving) {
                const len = Math.sqrt(dx*dx + dz*dz);
                dx = (dx / len) * moveSpeed;
                dz = (dz / len) * moveSpeed;

                const targetX = playerGroup.position.x + dx;
                const targetZ = playerGroup.position.z + dz;

                // Check collision before applying
                if (checkCollisions(targetX, targetZ)) {
                    playerGroup.position.x = targetX;
                    playerGroup.position.z = targetZ;
                    
                    // Rotate player to direction
                    rotationAngle = Math.atan2(dx, dz);
                    playerGroup.rotation.y = rotationAngle;
                }
            }

            // Slope/Terrain Height physics
            const terrainH = getTerrainHeight(playerGroup.position.x, playerGroup.position.z);
            if (isGrounded) {
                playerGroup.position.y = 0.35 + terrainH;
            } else {
                playerVelY += gravity;
                playerGroup.position.y += playerVelY;
                
                if (playerGroup.position.y <= 0.35 + terrainH) {
                    playerGroup.position.y = 0.35 + terrainH;
                    playerVelY = 0;
                    isGrounded = true;
                }
            }
        }

        // Walk Animation (Swing arms/legs from joint groups)
        if (isMoving && isGrounded) {
            walkTimer += delta * 12;
            const swing = Math.sin(walkTimer) * 0.5;
            leftLegGroup.rotation.x = swing;
            rightLegGroup.rotation.x = -swing;
            leftArmGroup.rotation.x = -swing * 0.8;
            rightArmGroup.rotation.x = swing * 0.8;
        } else {
            leftLegGroup.rotation.x = 0;
            rightLegGroup.rotation.x = 0;
            leftArmGroup.rotation.x = 0;
            rightArmGroup.rotation.x = 0;
        }

        // Camera Follow
        const targetCamX = playerGroup.position.x + Math.sin(cameraYaw) * cameraRadius * Math.cos(cameraPitch);
        const targetCamZ = playerGroup.position.z + Math.cos(cameraYaw) * cameraRadius * Math.cos(cameraPitch);
        const targetCamY = playerGroup.position.y + Math.sin(cameraPitch) * cameraRadius + 1.2;

        camera.position.x += (targetCamX - camera.position.x) * 0.15;
        camera.position.z += (targetCamZ - camera.position.z) * 0.15;
        camera.position.y += (targetCamY - camera.position.y) * 0.15;

        camera.lookAt(playerGroup.position.x, playerGroup.position.y + 0.8, playerGroup.position.z);

        // Quest and collision checks
        if (!isCompleted) {
            checkHover();
            checkNPCOverlap();
        }

        renderer.render(scene, camera);
    }

    // ─── RESIZE HANDLER ───────────────────────────────────────────────
    window.addEventListener('resize', () => {
        camera.aspect = window.innerWidth / window.innerHeight;
        camera.updateProjectionMatrix();
        renderer.setSize(window.innerWidth, window.innerHeight);
    });

    // ─── WEBGL CONTEXT LOST / BLANK SCREEN RECOVERY ───────────────────
    canvas.addEventListener('webglcontextlost', (e) => {
        e.preventDefault();
        console.warn('[3D Game] WebGL context lost – showing recovery overlay.');
        cancelAnimationFrame(animFrameId);
        // Show a recovery UI
        let overlay = document.getElementById('ctxLostOverlay');
        if (!overlay) {
            overlay = document.createElement('div');
            overlay.id = 'ctxLostOverlay';
            overlay.style.cssText = 'position:fixed;inset:0;display:flex;flex-direction:column;align-items:center;justify-content:center;background:rgba(2,6,23,0.92);z-index:99998;gap:16px;font-family:system-ui;color:#e5e7eb;';
            overlay.innerHTML = `
                <div style="font-size:48px;">⚠️</div>
                <div style="font-size:22px;font-weight:700;">Layar 3D Hilang</div>
                <div style="font-size:14px;color:#94a3b8;text-align:center;max-width:320px;">Koneksi grafis terputus. Klik tombol di bawah untuk memulihkan tampilan game.</div>
                <button onclick="location.reload()" style="margin-top:8px;padding:12px 28px;background:#f97316;color:#fff;border:none;border-radius:10px;font-size:16px;font-weight:700;cursor:pointer;">🔄 Muat Ulang Game</button>
            `;
            document.body.appendChild(overlay);
        }
        overlay.style.display = 'flex';
    }, false);

    canvas.addEventListener('webglcontextrestored', () => {
        console.log('[3D Game] WebGL context restored – restarting loop.');
        const overlay = document.getElementById('ctxLostOverlay');
        if (overlay) overlay.style.display = 'none';
        renderer.setSize(window.innerWidth, window.innerHeight);
        animate();
    }, false);

    // ─── VISIBILITY CHANGE: Resume audio when tab regains focus ───────
    document.addEventListener('visibilitychange', () => {
        if (document.visibilityState === 'visible') {
            if (audioCtx && audioCtx.state === 'suspended') audioCtx.resume();
        }
    });

    // ─── INTRO / OUTRO STORYLINE ENGINE ──────────────────────────────
    const INTRO_SLIDES = [
        {
            speaker: '— Narasi —',
            char: null,
            bg: "{{ asset('images/storylines/aceh/bg_aceh_beach.png') }}",
            text: 'Di tengah lautan Nusantara, sebuah perahu kecil terdampar di tepi pantai pulau yang asing...',
        },
        {
            speaker: 'Penjelajah',
            char: "{{ asset('images/storylines/aceh/jelajah_aceh/penjelajah_melihat_desa_dengan_teropong.png') }}",
            bg: "{{ asset('images/storylines/aceh/bg_aceh_beach.png') }}",
            text: '"Hei! Kita terdampar! Aku bisa melihat sebuah desa di sana. Ayo kita cari bantuan dan perbekalan!"',
        },
        {
            speaker: 'Laksamana Malahayati',
            char: "{{ asset('images/storylines/aceh/jelajah_aceh/laksamana_malahayati_menyambut_penjelajah.png') }}",
            bg: "{{ asset('images/storylines/aceh/bg_aceh_beach.png') }}",
            text: '"Selamat datang di tanah Aceh, penjelajah! Aku Laksamana Malahayati, komandan armada Inong Balee. Desa ini penuh dengan warisan budaya kami."',
        },
        {
            speaker: 'Penjelajah',
            char: "{{ asset('images/storylines/aceh/jelajah_aceh/penjelajah_berbicara_dengan_laksamana.png') }}",
            bg: "{{ asset('images/storylines/aceh/bg_aceh_beach.png') }}",
            text: '"Luar biasa! Kami butuh perbekalan untuk melanjutkan perjalanan. Bisakah kami membantu mengumpulkan sesuatu?"',
        },
        {
            speaker: 'Laksamana Malahayati',
            char: "{{ asset('images/storylines/aceh/jelajah_aceh/laksamana_berbicara_dengan_penjelajah.png') }}",
            bg: "{{ asset('images/storylines/aceh/bg_aceh_beach.png') }}",
            text: '"Tentu! Kami memerlukan 4 pusaka budaya Aceh — Mie Aceh dari kedai, Kopi Gayo dari warung, Pinto Aceh dari meja ukir, dan Rapa\'i dari balai musik. Kumpulkan semuanya dan kapal kami siap berlayar!"',
        },
        {
            speaker: 'Penjelajah',
            char: "{{ asset('images/storylines/aceh/jelajah_aceh/penjelajah_berbicara_dengan_laksamana.png') }}",
            bg: "{{ asset('images/storylines/aceh/bg_aceh_beach.png') }}",
            text: '"Baik! Aku akan menjelajahi desa ini. Tapi hati-hati — ada banyak barang mirip yang bukan budaya Aceh asli. Aku harus jeli!"',
        },
    ];

    const OUTRO_SLIDES = [
        {
            speaker: '— Narasi —',
            char: null,
            bg: "{{ asset('images/storylines/aceh/bg_aceh_port.png') }}",
            text: 'Semua pusaka budaya Aceh telah terkumpul. Penjelajah berlari menuju dermaga membawa bekal berharga itu...',
        },
        {
            speaker: 'Laksamana Malahayati',
            char: "{{ asset('images/storylines/aceh/jelajah_aceh/laksamana_berbicara_dengan_penjelajah.png') }}",
            bg: "{{ asset('images/storylines/aceh/bg_aceh_port.png') }}",
            text: '"Sempurna! Mie Aceh, Kopi Gayo, Pinto Aceh, dan Rapa\'i — semua ada! Armada Inong Balee siap berlayar!"',
        },
        {
            speaker: 'Penjelajah',
            char: "{{ asset('images/storylines/aceh/jelajah_aceh/penjelajah_membawa_barang.png') }}",
            bg: "{{ asset('images/storylines/aceh/bg_aceh_port.png') }}",
            text: '"Terima kasih Laksamana! Aku belajar banyak tentang kebudayaan Aceh yang kaya ini. Setiap barang punya makna tersendiri."',
        },
        {
            speaker: 'Laksamana Malahayati',
            char: "{{ asset('images/storylines/aceh/jelajah_aceh/laksamana_berbicara_dengan_penjelajah.png') }}",
            bg: "{{ asset('images/storylines/aceh/bg_aceh_port.png') }}",
            text: '"Itulah semangat Serambi Mekkah — kaya tradisi, teguh dalam jiwa. Bawalah ilmu ini dalam perjalananmu ke pulau-pulau berikutnya!"',
        },
        {
            speaker: '— Narasi —',
            char: null,
            bg: "{{ asset('images/storylines/aceh/bg_aceh_port.png') }}",
            text: 'Kapal Cakra Donya mengembangkan layarnya. Bersama angin laut Aceh, ekspedisi berlanjut menuju cakrawala baru Nusantara...',
        },
    ];

    let storyIndex = 0;
    let storySlides = [];
    let storyCallback = null;
    let storyTypeTimer = null;
    let storyTyping = false;

    const storyOverlay  = document.getElementById('storyOverlay');
    const storyBg       = document.getElementById('storyBg');
    const storyChar     = document.getElementById('storyChar');
    const storySpeaker  = document.getElementById('storySpeaker');
    const storyTextEl   = document.getElementById('storyText');
    const storyDots     = document.getElementById('storyDots');
    const storyNextBtn  = document.getElementById('storyNext');

    function storyType(text, cb) {
        clearTimeout(storyTypeTimer);
        storyTyping = true;
        storyTextEl.textContent = '';
        let i = 0;
        function tick() {
            if (i < text.length) {
                storyTextEl.textContent += text[i++];
                storyTypeTimer = setTimeout(tick, 22);
            } else {
                storyTyping = false;
                if (cb) cb();
            }
        }
        tick();
    }

    function storyRenderSlide(idx) {
        const slide = storySlides[idx];

        // Update dots
        storyDots.innerHTML = '';
        storySlides.forEach((_, i) => {
            const dot = document.createElement('div');
            dot.style.cssText = `width:8px;height:8px;border-radius:50%;background:${i === idx ? '#f97316' : 'rgba(255,255,255,.25)'};transition:background .2s ease;`;
            storyDots.appendChild(dot);
        });

        // Background
        if (slide.bg) {
            storyBg.style.backgroundImage = `url('${slide.bg}')`;
            storyBg.style.display = 'block';
        } else {
            storyBg.style.backgroundImage = '';
            storyBg.style.display = 'none';
        }

        // Character
        storyChar.style.opacity = '0';
        storyChar.style.transform = 'translateY(20px)';
        setTimeout(() => {
            if (slide.char) {
                storyChar.src = slide.char;
                storyChar.style.display = 'block';
                storyChar.style.opacity = '1';
                storyChar.style.transform = 'translateY(0)';
            } else {
                storyChar.style.display = 'none';
            }
        }, 200);

        storySpeaker.textContent = slide.speaker || '';

        // Typewriter
        storyType(slide.text, () => {
            // Change button text on last slide
            if (idx === storySlides.length - 1) {
                storyNextBtn.textContent = 'Mulai ▶';
            }
        });

        // Button label
        storyNextBtn.textContent = idx === storySlides.length - 1 ? 'Mulai ▶' : 'Lanjut ▶';
    }

    function storyAdvance() {
        if (storyTyping) {
            // Skip typewriter
            clearTimeout(storyTypeTimer);
            storyTyping = false;
            storyTextEl.textContent = storySlides[storyIndex].text;
            if (storyIndex === storySlides.length - 1) storyNextBtn.textContent = 'Mulai ▶';
            return;
        }
        storyIndex++;
        if (storyIndex < storySlides.length) {
            storyRenderSlide(storyIndex);
        } else {
            // Done
            storyOverlay.style.opacity = '0';
            storyOverlay.style.transition = 'opacity .5s ease';
            setTimeout(() => {
                storyOverlay.style.display = 'none';
                storyOverlay.style.opacity = '';
                storyOverlay.style.transition = '';
                if (storyCallback) storyCallback();
            }, 500);
        }
    }

    storyNextBtn.addEventListener('click', storyAdvance);
    document.addEventListener('keydown', (e) => {
        if (storyOverlay.style.display !== 'none' && ['Space','Enter','ArrowRight'].includes(e.code)) {
            e.preventDefault();
            storyAdvance();
        }
    });

    function runStory(slides, callback) {
        storySlides = slides;
        storyIndex = 0;
        storyCallback = callback;
        storyOverlay.style.display = 'flex';
        storyOverlay.style.opacity = '1';
        storyBg.style.backgroundImage = '';
        storyRenderSlide(0);
    }

    // Block game controls until intro is done
    awaitingInput = true;

    runStory(INTRO_SLIDES, () => {
        // Game starts after intro
        awaitingInput = false;
        updateHUD();
        updateTimerDisplay();
        startTimer();
    });

    // Start 3D render loop immediately (scene visible behind intro overlay)
    animFrameId = animate();


})();
</script>
</body>
</html>

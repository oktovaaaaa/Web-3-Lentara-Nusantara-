{{-- resources/views/player/learn/play-storyline.blade.php --}}
@php
    $player      = $player ?? (object)['xp_total'=>0,'coins'=>0,'hearts'=>5,'hearts_max'=>5,'nickname'=>'Player','avatar_key'=>1];
    $levelTitle  = $level->title ?? 'Storyline';
    $islandSlug  = $level->island?->slug ?? '';
    $islandColors= $islandColors ?? [];
    $accent      = $islandColors[$islandSlug] ?? '#f97316';
    $islandLabel = strtoupper($level->island?->subtitle ?? $level->island?->name ?? 'PULAU');
    $nickname    = (string)($player->nickname ?? $player->display_name ?? 'Player');
    $avatarKey   = (int)($player->avatar_key ?? 1);
    if ($avatarKey < 1 || $avatarKey > 5) $avatarKey = 1;
    $avatarUrl   = asset('images/avatars/avatar-'.$avatarKey.'.png');
    $tierLabel   = $tierLabel ?? '—';

    $stepsPayload = [];
    foreach ($steps as $s) {
        $stepsPayload[] = [
            'id'             => $s->id,
            'order'          => $s->order,
            'character_name' => $s->character_name,
            'dialogue_text'  => $s->dialogue_text,
            'background_path'=> $s->background_path ? asset($s->background_path) : null,
            'character_path' => $s->character_path  ? asset($s->character_path)  : null,
            'animation_type' => $s->animation_type ?? 'none',
            'options'        => $s->options ?? null,
        ];
    }

    $deductUrl   = route('game.storyline.deduct-heart', $level->id);
    $completeUrl = route('game.storyline.complete', $level->id);
    $refillUrl   = route('game.hearts.refill');
    $learnUrl    = route('game.learn');
    $sfxCorrect  = asset('audio/benar.M4A');
    $sfxWrong    = asset('audio/salah.M4A');
    $csrfToken   = csrf_token();
@endphp
<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $levelTitle }} — Lentara Nusantara</title>
    <link rel="icon" type="image/png" href="{{ asset('images/icon/icon_lentara.png') }}">
    <script>(function(){const t=localStorage.getItem('piforrr-theme')||'dark';document.documentElement.setAttribute('data-theme',t);})();</script>
    <style>
        :root {
            --accent: {{ $accent }};
            --bg: #020617;
            --card: #0f172a;
            --line: #1e293b;
            --txt: #e5e7eb;
            --muted: #6b7280;
            --danger: #ef4444;
            --ok: #22c55e;
        }
        html[data-theme="light"] {
            --bg: #fdfaf5;
            --card: #ffffff;
            --line: #e9e1d6;
            --txt: #0f172a;
            --muted: #616161;
        }
        *,*::before,*::after { box-sizing: border-box; margin: 0; padding: 0; }
        html, body { height: 100%; overflow: hidden; background: #000; font-family: ui-sans-serif,system-ui,-apple-system,Segoe UI,Roboto,Arial; }

        /* ═══════════════════════════
           VISUAL NOVEL STAGE
        ═══════════════════════════ */
        #vnStage {
            position: relative;
            width: 100vw;
            height: 100vh;
            overflow: hidden;
            background: #000;
        }

        /* Background layer with Ken Burns */
        #vnBg {
            position: absolute;
            inset: 0;
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            transition: background-image 0.6s ease;
        }

        @keyframes kenBurnsZoom {
            0%   { transform: scale(1)   translateX(0)    translateY(0); }
            100% { transform: scale(1.12) translateX(-2%)  translateY(-2%); }
        }
        @keyframes kenBurnsPan {
            0%   { transform: scale(1.08) translateX(0)    translateY(0); }
            100% { transform: scale(1.12) translateX(-3%)  translateY(-1%); }
        }

        .anim-zoom  { animation: kenBurnsZoom 8s ease-in-out infinite alternate; }
        .anim-pan   { animation: kenBurnsPan  8s ease-in-out infinite alternate; }

        /* Dark overlay */
        #vnOverlay {
            position: absolute;
            inset: 0;
            background: linear-gradient(to top, rgba(0,0,0,.80) 0%, rgba(0,0,0,.20) 60%, transparent 100%);
            pointer-events: none;
        }

        /* Shake animation */
        @keyframes stageShake {
            0%  { transform: scale(1.03) translateX(0) translateY(0) rotate(0deg); }
            15% { transform: scale(1.03) translateX(-12px) translateY(-2px) rotate(-0.5deg); }
            30% { transform: scale(1.03) translateX(12px) translateY(2px) rotate(0.5deg); }
            45% { transform: scale(1.03) translateX(-8px) translateY(-1px) rotate(-0.3deg); }
            60% { transform: scale(1.03) translateX(8px) translateY(1px) rotate(0.3deg); }
            75% { transform: scale(1.03) translateX(-4px) translateY(0) rotate(-0.1deg); }
            100%{ transform: scale(1) translateX(0) translateY(0) rotate(0); }
        }
        .shake-stage { animation: stageShake 0.45s cubic-bezier(.36,.07,.19,.97) both; transform-origin: center center; }

        /* Character sprite */
        #vnChar {
            position: absolute;
            bottom: 160px;
            left: 50%;
            transform: translateX(-50%);
            max-height: 55vh;
            max-width: 40vw;
            object-fit: contain;
            filter: drop-shadow(0 10px 30px rgba(0,0,0,.6));
            transition: opacity 0.4s ease, transform 0.4s ease;
        }
        #vnChar.hidden { opacity: 0; transform: translateX(-50%) translateY(20px); }

        /* TOP BAR */
        #vnTopbar {
            position: absolute;
            top: 0; left: 0; right: 0;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 14px 18px;
            background: linear-gradient(to bottom, rgba(0,0,0,.7), transparent);
            z-index: 20;
            gap: 14px;
        }
        .vn-top-left { display: flex; align-items: center; gap: 12px; }
        .vn-back {
            width: 44px; height: 44px;
            border-radius: 999px;
            border: 2px solid rgba(255,255,255,.25);
            background: rgba(0,0,0,.35);
            backdrop-filter: blur(8px);
            color: #fff;
            display: grid; place-items: center;
            text-decoration: none;
            cursor: pointer;
            flex: 0 0 auto;
            transition: border-color .15s;
        }
        .vn-back:hover { border-color: var(--accent); }
        .vn-back svg { width: 20px; height: 20px; }
        .vn-title { display: grid; gap: 2px; }
        .vn-title .sm { font-size: 11px; font-weight: 900; color: rgba(255,255,255,.6); letter-spacing: .12em; }
        .vn-title .lg { font-size: 16px; font-weight: 950; color: #fff; }

        .vn-top-right { display: flex; align-items: center; gap: 10px; }
        .vn-pill {
            display: inline-flex; align-items: center; gap: 7px;
            padding: 8px 12px;
            border-radius: 999px;
            border: 2px solid rgba(255,255,255,.2);
            background: rgba(0,0,0,.35);
            backdrop-filter: blur(8px);
            font-weight: 950; font-size: 13px; color: #fff;
        }
        .vn-pill svg { width: 16px; height: 16px; }
        .vn-pill.heart { color: #f87171; }
        .vn-pill.xp    { color: #60a5fa; }
        .vn-pill.coin  { color: #4ade80; }

        /* PROGRESS BAR */
        #vnProgress {
            position: absolute;
            top: 68px; left: 18px; right: 18px;
            height: 4px;
            border-radius: 999px;
            background: rgba(255,255,255,.15);
            z-index: 20;
            overflow: hidden;
        }
        #vnProgressFill {
            height: 100%;
            border-radius: inherit;
            background: var(--accent);
            width: 0%;
            transition: width .4s ease;
        }

        /* DIALOG BOX */
        #vnDialog {
            position: absolute;
            bottom: 0; left: 0; right: 0;
            z-index: 20;
            padding: 0 18px 18px;
        }
        .dialog-box {
            background: rgba(5,10,25,.88);
            backdrop-filter: blur(16px) saturate(140%);
            -webkit-backdrop-filter: blur(16px) saturate(140%);
            border: 1.5px solid rgba(255,255,255,.12);
            border-radius: 22px;
            padding: 18px 20px;
            position: relative;
            overflow: hidden;
        }
        .dialog-box::before {
            content: '';
            position: absolute;
            top: 0; left: 0; right: 0; height: 3px;
            background: linear-gradient(90deg, var(--accent), color-mix(in oklab, var(--accent) 60%, #fff));
        }

        #vnSpeaker {
            font-size: 13px; font-weight: 950; color: var(--accent);
            margin-bottom: 8px; letter-spacing: .05em;
        }
        #vnText {
            font-size: 15px; font-weight: 700;
            color: rgba(255,255,255,.92);
            line-height: 1.6;
            min-height: 48px;
        }

        /* Choices */
        #vnChoices {
            display: grid;
            gap: 10px;
            margin-top: 14px;
        }
        #vnChoices.hidden { display: none; }

        .choice-btn {
            padding: 12px 16px;
            border-radius: 16px;
            border: 2px solid rgba(255,255,255,.2);
            background: rgba(255,255,255,.06);
            color: rgba(255,255,255,.9);
            font-weight: 900; font-size: 14px;
            text-align: left;
            cursor: pointer;
            transition: all .2s ease;
        }
        .choice-btn:hover { border-color: var(--accent); background: rgba(255,255,255,.12); }
        .choice-btn.correct { border-color: #22c55e; background: rgba(34,197,94,.15); color: #86efac; }
        .choice-btn.wrong   { border-color: #ef4444; background: rgba(239,68,68,.15); color: #fca5a5; }
        .choice-btn:disabled { cursor: not-allowed; opacity: .7; }

        /* Continue hint */
        #vnContinueHint {
            font-size: 12px; font-weight: 900;
            color: rgba(255,255,255,.45);
            margin-top: 10px;
            text-align: right;
            animation: blink 1.4s ease infinite;
        }
        #vnContinueHint.hidden { display: none; }
        @keyframes blink { 0%,100%{opacity:1} 50%{opacity:.35} }

        /* MODAL overlay */
        .vn-modal-wrap {
            position: fixed; inset: 0; z-index: 100;
            display: flex; align-items: center; justify-content: center;
            padding: 20px;
            background: rgba(0,0,0,.82);
            backdrop-filter: blur(8px);
        }
        .vn-modal-wrap.hidden { display: none; }
        .vn-modal {
            width: min(480px, 94vw);
            border-radius: 28px;
            border: 2px solid rgba(255,255,255,.12);
            background: #0f172a;
            overflow: hidden;
            position: relative;
        }
        .vn-modal::before {
            content: '';
            position: absolute; top: 0; left: 0; right: 0; height: 4px;
            background: linear-gradient(90deg, var(--accent), #fde68a);
        }
        .vn-modal-inner { padding: 28px 24px; text-align: center; }
        .vn-modal-emoji { font-size: 56px; line-height: 1; margin-bottom: 14px; }
        .vn-modal-title { font-size: 22px; font-weight: 950; color: #fff; margin-bottom: 8px; }
        .vn-modal-sub   { font-size: 14px; color: rgba(255,255,255,.6); margin-bottom: 20px; line-height: 1.55; }
        .vn-modal-stats { display: grid; grid-template-columns: 1fr 1fr; gap: 10px; margin-bottom: 20px; }
        .vn-modal-stat {
            border-radius: 14px; border: 1.5px solid rgba(255,255,255,.1);
            background: rgba(255,255,255,.05);
            padding: 12px;
            display: flex; flex-direction: column; align-items: center; gap: 4px;
        }
        .vn-modal-stat .sk { font-size: 11px; font-weight: 800; color: rgba(255,255,255,.45); letter-spacing:.1em; }
        .vn-modal-stat .sv { font-size: 20px; font-weight: 950; color: #fff; }
        .vn-modal-actions { display: flex; flex-direction: column; gap: 10px; }
        .vn-modal-btn {
            padding: 14px;
            border-radius: 14px;
            border: 2px solid transparent;
            font-weight: 950; font-size: 15px;
            cursor: pointer;
            text-decoration: none;
            display: flex; align-items: center; justify-content: center;
            transition: all .2s ease;
        }
        .vn-modal-btn.primary { background: var(--accent); color: #0b1220; }
        .vn-modal-btn.primary:hover { filter: brightness(1.1); }
        .vn-modal-btn.ghost { background: rgba(255,255,255,.06); border-color: rgba(255,255,255,.18); color: #fff; }
        .vn-modal-btn.ghost:hover { background: rgba(255,255,255,.12); }
        .vn-modal-btn.danger { background: rgba(239,68,68,.15); border-color: rgba(239,68,68,.4); color: #f87171; }

        /* Feedback flash */
        #vnFeedback {
            position: absolute;
            top: 50%; left: 50%;
            transform: translate(-50%,-50%);
            z-index: 30;
            font-size: 28px; font-weight: 950;
            padding: 14px 28px;
            border-radius: 999px;
            background: rgba(0,0,0,.7);
            backdrop-filter: blur(8px);
            color: #fff;
            pointer-events: none;
            opacity: 0;
            transition: opacity .25s ease;
        }
        #vnFeedback.show { opacity: 1; }

        @media (max-width: 640px) {
            #vnChar { max-height: 40vh; max-width: 60vw; bottom: 200px; }
            #vnText { font-size: 13px; }
            .vn-title .lg { font-size: 14px; }
        }
    </style>
</head>
<body>

<div id="vnStage">
    <!-- Visual layers container (will shake on wrong answer) -->
    <div id="vnVisuals" style="position: absolute; inset: 0; pointer-events: none; z-index: 1;">
        <!-- Background -->
        <div id="vnBg"></div>
        <div id="vnOverlay"></div>

        <!-- Character sprite -->
        <img id="vnChar" src="" alt="" class="hidden">
    </div>

    <!-- TOP BAR -->
    <div id="vnTopbar">
        <div class="vn-top-left">
            <button class="vn-back" id="btnExit" title="Keluar">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M15 18l-6-6 6-6"/>
                </svg>
            </button>
            <div class="vn-title">
                <div class="sm">{{ $islandLabel }}</div>
                <div class="lg">{{ $levelTitle }}</div>
            </div>
        </div>
        <div class="vn-top-right">
            <div class="vn-pill xp" title="XP">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M13 2s2 3 2 6-2 4-2 4 4-1 4-6 2-4 2-4-1 7-4 10-1 8-1 8-6-3-6-8 4-10 5-10Z"/></svg>
                <span id="xpNum">{{ (int)$player->xp_total }}</span>
            </div>
            <div class="vn-pill coin" title="Koin">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="8"/><path d="M12 8v8M9 12h6" stroke-linecap="round"/></svg>
                <span id="coinNum">{{ (int)$player->coins }}</span>
            </div>
            <div class="vn-pill heart" title="Hati">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 21s-7-4.6-9.2-9.1C1.4 8.9 3.4 6 6.6 6c1.8 0 3.1 1 3.9 2 .8-1 2.1-2 3.9-2 3.2 0 5.2 2.9 3.8 5.9C19 16.4 12 21 12 21Z"/></svg>
                <span id="heartNum">{{ (int)$player->hearts }}</span>/<span>{{ (int)$player->hearts_max }}</span>
            </div>
        </div>
    </div>

    <!-- PROGRESS -->
    <div id="vnProgress"><div id="vnProgressFill"></div></div>

    <!-- FEEDBACK FLASH -->
    <div id="vnFeedback"></div>

    <!-- DIALOG -->
    <div id="vnDialog">
        <div class="dialog-box" id="dialogBox">
            <div id="vnSpeaker"></div>
            <div id="vnText"></div>
            <div id="vnChoices" class="hidden"></div>
            <div id="vnContinueHint">▸ Klik untuk lanjut</div>
        </div>
    </div>
</div>

<!-- MODAL: WIN -->
<div class="vn-modal-wrap hidden" id="modalWin">
    <div class="vn-modal">
        <div class="vn-modal-inner">
            <div class="vn-modal-emoji">🏆</div>
            <div class="vn-modal-title">Cerita Selesai!</div>
            <div class="vn-modal-sub">Kamu telah menyelesaikan Legenda Danau Toba. Hebat!</div>
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
<div class="vn-modal-wrap hidden" id="modalHeartEmpty">
    <div class="vn-modal">
        <div class="vn-modal-inner">
            <div class="vn-modal-emoji">💔</div>
            <div class="vn-modal-title">Hati Habis!</div>
            <div class="vn-modal-sub">Hati kamu habis. Isi ulang dengan 10 koin atau tunggu hati terisi kembali secara otomatis.</div>
            <div class="vn-modal-actions">
                <button class="vn-modal-btn primary" id="btnRefillModal">Isi Ulang Hati (10 💰)</button>
                <a class="vn-modal-btn ghost" href="{{ route('game.learn') }}">Kembali ke Belajar</a>
            </div>
        </div>
    </div>
</div>

<!-- MODAL: EXIT CONFIRM -->
<div class="vn-modal-wrap hidden" id="modalExit">
    <div class="vn-modal">
        <div class="vn-modal-inner">
            <div class="vn-modal-emoji">🚪</div>
            <div class="vn-modal-title">Keluar Cerita?</div>
            <div class="vn-modal-sub">Progress cerita akan hilang. Kamu bisa mengulang dari awal kapan saja.</div>
            <div class="vn-modal-actions">
                <a class="vn-modal-btn danger" href="{{ route('game.learn') }}">Ya, Keluar</a>
                <button class="vn-modal-btn ghost" id="btnStayModal">Lanjutkan Cerita</button>
            </div>
        </div>
    </div>
</div>

<audio id="sfxCorrect" src="{{ $sfxCorrect }}" preload="none"></audio>
<audio id="sfxWrong"   src="{{ $sfxWrong }}"   preload="none"></audio>

<script>
(function () {
    // ─── CONFIG ───────────────────────────────────────────────────────
    const STEPS         = @json($stepsPayload);
    const CSRF          = @json($csrfToken);
    const DEDUCT_URL    = @json($deductUrl);
    const COMPLETE_URL  = @json($completeUrl);
    const REFILL_URL    = @json($refillUrl);
    const TOTAL         = STEPS.length;

    let currentIndex  = 0;
    let isTyping      = false;
    let typeTimer     = null;
    let awaitingChoice= false;
    let hearts        = {{ (int)$player->hearts }};
    let heartsMax     = {{ (int)$player->hearts_max }};
    let xp            = {{ (int)$player->xp_total }};
    let coins         = {{ (int)$player->coins }};
    let isCompleted   = false;

    // ─── DOM ──────────────────────────────────────────────────────────
    const bg          = document.getElementById('vnBg');
    const charEl      = document.getElementById('vnChar');
    const speakerEl   = document.getElementById('vnSpeaker');
    const textEl      = document.getElementById('vnText');
    const choicesEl   = document.getElementById('vnChoices');
    const hintEl      = document.getElementById('vnContinueHint');
    const progressFill= document.getElementById('vnProgressFill');
    const heartNumEl  = document.getElementById('heartNum');
    const xpNumEl     = document.getElementById('xpNum');
    const coinNumEl   = document.getElementById('coinNum');
    const feedbackEl  = document.getElementById('vnFeedback');
    const stageEl     = document.getElementById('vnVisuals');
    const sfxOk       = document.getElementById('sfxCorrect');
    const sfxBad      = document.getElementById('sfxWrong');

    // Modals
    const modalWin    = document.getElementById('modalWin');
    const modalHeart  = document.getElementById('modalHeartEmpty');
    const modalExit   = document.getElementById('modalExit');

    // ─── UTILS ────────────────────────────────────────────────────────
    function playSound(el) {
        try { el.currentTime = 0; el.play().catch(() => {}); } catch(e) {}
    }

    function updateHUD() {
        heartNumEl.textContent = hearts;
        xpNumEl.textContent    = xp;
        coinNumEl.textContent  = coins;
    }

    function flashFeedback(msg, color) {
        feedbackEl.textContent = msg;
        feedbackEl.style.color = color;
        feedbackEl.classList.add('show');
        setTimeout(() => feedbackEl.classList.remove('show'), 1200);
    }

    function shakeStage() {
        stageEl.classList.add('shake-stage');
        stageEl.addEventListener('animationend', () => stageEl.classList.remove('shake-stage'), { once: true });
    }

    function setProgress(idx) {
        progressFill.style.width = (((idx + 1) / TOTAL) * 100).toFixed(1) + '%';
    }

    // ─── TYPEWRITER ───────────────────────────────────────────────────
    function typeText(text, cb) {
        clearTimeout(typeTimer);
        isTyping = true;
        textEl.textContent = '';
        let i = 0;
        const speed = 28; // ms per char
        function tick() {
            if (i < text.length) {
                textEl.textContent += text[i++];
                typeTimer = setTimeout(tick, speed);
            } else {
                isTyping = false;
                if (cb) cb();
            }
        }
        tick();
    }

    function finishTyping(text) {
        clearTimeout(typeTimer);
        textEl.textContent = text;
        isTyping = false;
    }

    // ─── RENDER STEP ─────────────────────────────────────────────────
    function renderStep(idx) {
        if (idx >= TOTAL) { finishStoryline(); return; }
        currentIndex   = idx;
        awaitingChoice = false;
        const step     = STEPS[idx];

        setProgress(idx);

        // Background
        if (step.background_path) {
            bg.style.backgroundImage = `url('${step.background_path}')`;
            bg.className = '';
            void bg.offsetWidth; // reflow
            if (step.animation_type === 'zoom') bg.classList.add('anim-zoom');
            else if (step.animation_type === 'fade') bg.classList.add('anim-pan');
        }

        // Shake stage
        if (step.animation_type === 'shake') shakeStage();

        // Character
        if (step.character_path) {
            charEl.classList.add('hidden');
            setTimeout(() => {
                charEl.src = step.character_path;
                charEl.alt = step.character_name || '';
                charEl.classList.remove('hidden');
            }, 350);
        } else {
            charEl.classList.add('hidden');
        }

        // Speaker
        speakerEl.textContent = step.character_name ? `★ ${step.character_name}` : '— Narasi —';

        // Choices
        choicesEl.innerHTML = '';
        choicesEl.classList.add('hidden');

        // Hint
        hintEl.classList.add('hidden');

        // Typewrite dialog
        typeText(step.dialogue_text, function () {
            if (step.options && step.options.length > 0) {
                awaitingChoice = true;
                renderChoices(step.options, idx);
            } else {
                hintEl.classList.remove('hidden');
            }
        });
    }

    // ─── CHOICES ─────────────────────────────────────────────────────
    function renderChoices(options, stepIdx) {
        choicesEl.classList.remove('hidden');
        choicesEl.innerHTML = '';
        options.forEach((opt, i) => {
            const btn = document.createElement('button');
            btn.className   = 'choice-btn';
            btn.textContent = opt.option_text;
            btn.dataset.correct = opt.is_correct ? '1' : '0';
            btn.addEventListener('click', () => handleChoice(btn, opt.is_correct, stepIdx));
            choicesEl.appendChild(btn);
        });
    }

    async function handleChoice(btn, isCorrect, stepIdx) {
        if (!awaitingChoice) return;
        awaitingChoice = false;

        // Disable all buttons
        choicesEl.querySelectorAll('.choice-btn').forEach(b => b.disabled = true);

        if (isCorrect) {
            btn.classList.add('correct');
            flashFeedback('✓ Benar!', '#4ade80');
            playSound(sfxOk);
            setTimeout(() => { choicesEl.classList.add('hidden'); hintEl.classList.remove('hidden'); }, 900);
        } else {
            btn.classList.add('wrong');
            shakeStage();
            flashFeedback('✗ Salah!', '#f87171');
            playSound(sfxBad);

            // Deduct heart via AJAX
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
                        setTimeout(() => showModal(modalHeart), 800);
                        return;
                    }
                }
            } catch(e) { /* ignore network errors */ }

            // Let player retry choices
            setTimeout(() => {
                choicesEl.querySelectorAll('.choice-btn').forEach(b => { b.disabled = false; b.classList.remove('wrong','correct'); });
                awaitingChoice = true;
            }, 900);
        }
    }

    // ─── COMPLETE ─────────────────────────────────────────────────────
    async function finishStoryline() {
        if (isCompleted) return;
        isCompleted = true;

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

        setTimeout(() => showModal(modalWin), 600);
    }

    // ─── MODALS ───────────────────────────────────────────────────────
    function showModal(el) { el.classList.remove('hidden'); }
    function hideModal(el) { el.classList.add('hidden'); }

    // Refill hearts
    document.getElementById('btnRefillModal').addEventListener('click', async () => {
        try {
            const res = await fetch(REFILL_URL, {
                method: 'POST',
                headers: { 'X-CSRF-TOKEN': CSRF, 'Accept': 'application/json' },
            });
            const data = await res.json();
            if (data.ok) {
                hearts = data.hearts; coins = data.coins; updateHUD();
                hideModal(modalHeart);
                // Re-render current step choices
                const step = STEPS[currentIndex];
                if (step.options) {
                    choicesEl.innerHTML = '';
                    renderChoices(step.options, currentIndex);
                    awaitingChoice = true;
                }
            } else {
                alert(data.message || 'Koin tidak cukup.');
            }
        } catch(e) { alert('Gagal menghubungi server.'); }
    });

    // Exit
    document.getElementById('btnExit').addEventListener('click', () => showModal(modalExit));
    document.getElementById('btnStayModal').addEventListener('click', () => hideModal(modalExit));

    // ─── ADVANCE ─────────────────────────────────────────────────────
    function advance() {
        if (awaitingChoice) return;
        if (isTyping) {
            finishTyping(STEPS[currentIndex].dialogue_text);
            const step = STEPS[currentIndex];
            if (step.options && step.options.length > 0) {
                awaitingChoice = true;
                renderChoices(step.options, currentIndex);
            } else {
                hintEl.classList.remove('hidden');
            }
            return;
        }
        if (hearts <= 0) { showModal(modalHeart); return; }
        renderStep(currentIndex + 1);
    }

    // Click to advance — but not on choices or buttons
    document.getElementById('vnStage').addEventListener('click', (e) => {
        if (e.target.closest('.choice-btn') || e.target.closest('.vn-back') || e.target.closest('.vn-modal-wrap')) return;
        advance();
    });

    // Keyboard
    document.addEventListener('keydown', (e) => {
        if (['Space','Enter','ArrowRight'].includes(e.code)) { e.preventDefault(); advance(); }
    });

    // ─── INIT ─────────────────────────────────────────────────────────
    updateHUD();
    renderStep(0);

})();
</script>
</body>
</html>

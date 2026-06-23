<div id="nusantara-widget" class="fixed bottom-4 right-4 z-50 font-sans">
    <!-- 1. Floating Medallion Toggle Button -->
    <button id="nusantara-toggle" class="flex items-center gap-3 shadow-lg hover:shadow-2xl
               transition-all duration-300 ease-out
               w-16 h-16 rounded-full justify-center
               sm:w-auto sm:px-5 sm:py-3 sm:rounded-2xl
               bg-gradient-to-r from-amber-800 via-red-800 to-amber-900
               text-white border-2 border-amber-500/80
               gold-glow relative cursor-pointer" aria-label="Buka Lentara AI">
        <!-- Glow effect inside -->
        <div
            class="absolute inset-0 rounded-full sm:rounded-2xl bg-gradient-to-r from-amber-500/10 to-orange-500/10 animate-pulse pointer-events-none">
        </div>

        <div class="flex items-center justify-center w-12 h-12 rounded-full
                    bg-amber-950/80 border border-amber-500/40 shadow-inner">
            <img src="{{ asset('images/icon/lentaraai.PNG') }}" alt="Lentara AI" class="w-10 h-10 object-contain"
                draggable="false" />
        </div>

        <div class="hidden sm:block flex-1 text-left">
            <div class="text-sm font-bold leading-tight font-serif text-amber-100">Lentara AI</div>
            <div class="text-[10px] text-amber-400 font-medium tracking-wide">
                Asisten Budaya
            </div>
        </div>

        <span class="hidden sm:inline-block ml-1 text-amber-400 text-lg font-bold hover:text-amber-300">✦</span>
    </button>

    <!-- 2. Chat Panel -->
    <div id="nusantara-panel" class="fixed bottom-4 right-4
               w-[calc(100vw-2rem)] max-w-md h-[32rem] sm:h-[36rem]
               rounded-[30px]
               shadow-2xl
               transform origin-bottom-right
               transition-all duration-300 ease-out
               opacity-0 translate-y-4 scale-95
               pointer-events-none
               border-2 border-amber-600/80" style="background: var(--card);">
        <!-- Traditional Gold Corners (TL and TR) -->
        <div class="q-corner q-corner-tl" aria-hidden="true">
            <svg width="100%" height="100%" viewBox="0 0 120 120" fill="none" xmlns="http://www.w3.org/2000/svg">
                <defs>
                    <linearGradient id="gold-grad-tl" x1="0" y1="0" x2="100" y2="100" gradientUnits="userSpaceOnUse">
                        <stop offset="0%" stop-color="#ffe082" />
                        <stop offset="30%" stop-color="#ffc107" />
                        <stop offset="70%" stop-color="#ff8f00" />
                        <stop offset="100%" stop-color="#8d5000" />
                    </linearGradient>
                    <g id="branch-tl-group">
                        <path d="M 22,14 C 20,24 10,26 6,20 C 3,15 6,10 11,8 C 16,6 20,10 22,14 Z" />
                        <path d="M 16,11 C 18,3 28,-1 35,2 C 40,4 40,9 36,12 C 32,15 24,14 16,11 Z" />
                        <path d="M 35,17 C 45,28 60,30 68,24 C 74,20 72,14 65,12 C 58,10 48,12 35,17 Z" />
                        <path d="M 45,15 C 55,4 70,2 78,8 C 84,12 82,18 75,20 C 68,22 58,18 45,15 Z" />
                        <path d="M 68,14 C 78,5 92,4 98,10 C 102,14 100,20 92,21 C 84,22 76,18 68,14 Z" />
                        <path d="M 75,17 C 82,25 94,26 100,21 C 104,17 102,12 95,11 C 88,10 82,13 75,17 Z" />
                        <path d="M 90,13 C 102,5 114,7 118,13 C 120,16 116,19 110,18 C 102,17 96,15 90,13 Z" />
                        <path
                            d="M 12,12 C 30,16 55,20 75,15 C 85,12.5 95,9 105,10 C 110,10.5 112,12 112,14 C 112,16 108,18 102,17 C 90,15 78,18 68,21 C 48,27 28,22 12,12 Z" />
                    </g>
                    <g id="branch-tl-vertical">
                        <use href="#branch-tl-group" transform="rotate(90 12 12)" />
                    </g>
                </defs>
                <g fill="var(--card)" stroke="var(--card)" stroke-width="6" stroke-linejoin="round">
                    <use href="#branch-tl-group" />
                    <use href="#branch-tl-vertical" />
                    <circle cx="12" cy="12" r="10" />
                </g>
                <g fill="none" stroke="#4e2b02" stroke-width="3" stroke-linejoin="round" stroke-linecap="round">
                    <use href="#branch-tl-group" />
                    <use href="#branch-tl-vertical" />
                    <circle cx="12" cy="12" r="6" />
                </g>
                <g fill="url(#gold-grad-tl)" stroke="#5d3403" stroke-width="1.2" stroke-linejoin="round"
                    stroke-linecap="round">
                    <use href="#branch-tl-group" />
                    <use href="#branch-tl-vertical" />
                    <circle cx="12" cy="12" r="5.5" />
                </g>
                <g stroke="#ffffff" stroke-width="1.0" stroke-linecap="round" fill="none" opacity="0.9">
                    <path d="M 18,12 C 22,8 28,6 32,5" />
                    <path d="M 38,18 C 45,24 55,26 62,22" />
                    <path d="M 48,13 C 55,6 65,4 72,7" stroke-width="1.2" />
                    <path d="M 72,13 C 78,7 86,6 92,9" />
                    <path d="M 78,18 C 84,22 90,23 94,20" stroke-width="0.8" />
                    <path d="M 92,12 C 98,7 105,8 108,11" stroke-width="0.8" />
                </g>
            </svg>
        </div>

        <div class="q-corner q-corner-tr" aria-hidden="true">
            <svg width="100%" height="100%" viewBox="0 0 120 120" fill="none" xmlns="http://www.w3.org/2000/svg">
                <g fill="var(--card)" stroke="var(--card)" stroke-width="6" stroke-linejoin="round">
                    <use href="#branch-tl-group" />
                    <use href="#branch-tl-vertical" />
                    <circle cx="12" cy="12" r="10" />
                </g>
                <g fill="none" stroke="#4e2b02" stroke-width="3" stroke-linejoin="round" stroke-linecap="round">
                    <use href="#branch-tl-group" />
                    <use href="#branch-tl-vertical" />
                    <circle cx="12" cy="12" r="6" />
                </g>
                <g fill="url(#gold-grad-tl)" stroke="#5d3403" stroke-width="1.2" stroke-linejoin="round"
                    stroke-linecap="round">
                    <use href="#branch-tl-group" />
                    <use href="#branch-tl-vertical" />
                    <circle cx="12" cy="12" r="5.5" />
                </g>
                <g stroke="#ffffff" stroke-width="1.0" stroke-linecap="round" fill="none" opacity="0.9">
                    <path d="M 18,12 C 22,8 28,6 32,5" />
                    <path d="M 38,18 C 45,24 55,26 62,22" />
                    <path d="M 48,13 C 55,6 65,4 72,7" stroke-width="1.2" />
                    <path d="M 72,13 C 78,7 86,6 92,9" />
                    <path d="M 78,18 C 84,22 90,23 94,20" stroke-width="0.8" />
                    <path d="M 92,12 C 98,7 105,8 108,11" stroke-width="0.8" />
                </g>
            </svg>
        </div>

        <!-- Inner wrapper to clip the contents inside the rounded panel -->
        <div id="nusantara-panel-inner" class="w-full h-full flex flex-col overflow-hidden rounded-[27px]">
            <!-- Header -->
            <div class="px-5 py-4 nusai-header relative z-10">
                <div class="flex items-center justify-between relative z-20">
                    <div class="flex items-center gap-3">
                        <div class="w-12 h-12 rounded-full
                                   bg-amber-950/40 backdrop-blur-sm flex items-center justify-center
                                   shadow-lg border border-amber-500/35 overflow-hidden">
                            <img src="{{ asset('images/icon/lentaraai.PNG') }}" alt="Lentara AI"
                                class="w-10 h-10 object-contain" draggable="false" />
                        </div>
                        <div>
                            <div class="font-bold text-amber-300 text-base font-serif tracking-wider">Lentara AI</div>
                            <div class="text-[10px] text-amber-100/90 tracking-wide font-sans">
                                Asisten Budaya Nusantara
                            </div>
                        </div>
                    </div>

                    <button id="nusantara-close"
                        class="w-8 h-8 rounded-full flex items-center justify-center
                               bg-black/30 hover:bg-black/50 text-amber-300 border border-amber-500/20 transition-all hover:scale-105"
                        aria-label="Tutup" type="button">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
            </div>

            <!-- Body chat -->
            <div class="flex flex-col flex-1 h-[calc(100%-4.5rem)] relative">
                <div id="nusantara-messages" class="flex-1 px-4 py-4 overflow-y-auto relative z-10
                           scrollbar-thin scrollbar-thumb-amber-500/30 scrollbar-track-transparent">
                    <!-- Pesan selamat datang -->
                    <div class="text-center mb-6 mt-4">
                        <div class="inline-flex flex-col items-center gap-3
                                   px-5 py-5 rounded-2xl
                                   max-w-xs mx-auto nusai-welcome border border-amber-500/10">
                            <div class="w-16 h-16 rounded-full flex items-center justify-center
                                       bg-gradient-to-br from-amber-800 to-red-900
                                       p-1 border border-amber-400/40 shadow-md">
                                <img src="{{ asset('images/icon/lentaraai.PNG') }}" alt="Lentara AI"
                                    class="w-full h-full object-contain" draggable="false" />
                            </div>
                            <div>
                                <div class="font-bold text-base text-amber-700 dark:text-amber-400 font-serif">
                                    Sampurasun! 👋
                                </div>
                                <div class="text-xs mt-1 text-slate-600 dark:text-slate-400 leading-relaxed">
                                    Saya <strong>Lentara AI</strong>. Tanyakan apa saja tentang kekayaan budaya,
                                    tradisi, kuliner khas atau sejarah kreatif Nusantara!
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Chat messages akan dimasukkan secara dinamis di sini -->
                </div>

                <!-- Form input -->
                <div
                    class="p-4 border-t border-amber-900/10 dark:border-amber-500/10 bg-slate-50/50 dark:bg-stone-900/50 backdrop-blur-md relative z-10">
                    <form id="nusantara-form" class="flex gap-2">
                        @csrf
                        <input type="hidden" id="chat-endpoint" value="{{ route('nusantara.chat') }}">

                        <div class="flex-1 relative">
                            <input id="nusantara-input" type="text" placeholder="Tulis pertanyaanmu..."
                                class="w-full text-xs px-4 py-3 rounded-xl
                                       focus:outline-none focus:ring-1 focus:ring-amber-500
                                       pr-10 bg-white dark:bg-stone-900 border border-slate-200 dark:border-stone-700
                                       text-slate-800 dark:text-slate-100 placeholder-slate-400 dark:placeholder-stone-500" autocomplete="off" />
                            <div
                                class="absolute right-3 top-1/2 transform -translate-y-1/2 text-slate-400 dark:text-stone-500">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M14.828 14.828a4 4 0 01-5.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                        </div>
                        <button type="submit" class="px-4 py-3 rounded-xl text-xs font-bold
                                   bg-gradient-to-r from-amber-600 to-red-700 hover:from-amber-500 hover:to-red-650
                                   text-white transition-all duration-200
                                   shadow-md hover:shadow-lg hover:-translate-y-0.5 active:translate-y-0
                                   flex items-center justify-center min-w-[44px]" id="send-button">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                    d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8" />
                            </svg>
                        </button>
                    </form>

                    <div
                        class="text-[10px] text-center mt-3 text-slate-500 dark:text-stone-400 flex items-center justify-center gap-1.5">
                        <div class="w-1.5 h-1.5 rounded-full bg-amber-500 animate-pulse"></div>
                        <span>Lentara AI • Asisten Budaya Digital</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    /* =========================================================
       TRADITIONAL NUSANTARA CHATBOT STYLES
       - Uses global theme tokens with custom cultural additions.
    ========================================================= */

    /* Glow effect for toggle */
    .gold-glow {
        box-shadow: 0 4px 20px rgba(180, 83, 9, 0.4), 0 0 0 1px rgba(251, 191, 36, 0.2);
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }

    .gold-glow:hover {
        box-shadow: 0 8px 30px rgba(180, 83, 9, 0.7), 0 0 15px rgba(251, 191, 36, 0.4);
        transform: translateY(-4px) scale(1.03);
    }

    /* Floating toggle keyframe */
    @keyframes floatToggle {

        0%,
        100% {
            transform: translateY(0);
        }

        50% {
            transform: translateY(-5px);
        }
    }

    #nusantara-toggle {
        animation: floatToggle 3s ease-in-out infinite;
    }

    #nusantara-toggle:hover {
        animation-play-state: paused;
    }

    /* Ornate Gold Corner Ornaments */
    .q-corner {
        position: absolute !important;
        width: 65px;
        height: 65px;
        pointer-events: none;
        z-index: 30 !important;
        opacity: 0.95;
        filter: drop-shadow(0 2px 4px rgba(0, 0, 0, 0.3));
    }

    .q-corner-tl {
        top: -6px;
        left: -6px;
    }

    .q-corner-tr {
        top: -6px;
        right: -6px;
        transform: scaleX(-1);
    }

    /* Header styling with repeating Kawung Batik Overlay */
    .nusai-header {
        position: relative;
        background: linear-gradient(135deg, #4a0404 0%, #781010 50%, #3d0202 100%);
        border-bottom: 2.5px solid #d97706;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
    }

    .nusai-header::before {
        content: "";
        position: absolute;
        inset: 0;
        opacity: 0.08;
        background-image: url("data:image/svg+xml,%3Csvg width='40' height='40' viewBox='0 0 40 40' xmlns='http://www.w3.org/2000/svg'%3E%3Ccircle cx='0' cy='0' r='20' fill='none' stroke='%23d97706' stroke-width='0.75' stroke-opacity='0.5'/%3E%3Ccircle cx='40' cy='0' r='20' fill='none' stroke='%23d97706' stroke-width='0.75' stroke-opacity='0.5'/%3E%3Ccircle cx='0' cy='40' r='20' fill='none' stroke='%23d97706' stroke-width='0.75' stroke-opacity='0.5'/%3E%3Ccircle cx='40' cy='40' r='20' fill='none' stroke='%23d97706' stroke-width='0.75' stroke-opacity='0.5'/%3E%3Ccircle cx='20' cy='20' r='20' fill='none' stroke='%23d97706' stroke-width='0.75' stroke-opacity='0.5'/%3E%3Cpath d='M0,20 Q10,10 20,20 Q10,30 0,20' fill='none' stroke='%23d97706' stroke-width='0.75' stroke-opacity='0.8'/%3E%3Cpath d='M20,20 Q30,10 40,20 Q30,30 20,20' fill='none' stroke='%23d97706' stroke-width='0.75' stroke-opacity='0.8'/%3E%3Cpath d='M20,0 Q10,10 20,20 Q30,10 20,0' fill='none' stroke='%23d97706' stroke-width='0.75' stroke-opacity='0.8'/%3E%3Cpath d='M20,20 Q10,30 20,40 Q30,30 20,20' fill='none' stroke='%23d97706' stroke-width='0.75' stroke-opacity='0.8'/%3E%3C/svg%3E");
        background-size: 40px 40px;
        pointer-events: none;
    }

    /* Message Area Background with Batik watermark */
    #nusantara-messages {
        background-color: var(--bg-body);
        background-image:
            radial-gradient(circle at center, rgba(255, 255, 255, 0) 0%, rgba(0, 0, 0, 0.03) 100%),
            url("data:image/svg+xml,%3Csvg width='40' height='40' viewBox='0 0 40 40' xmlns='http://www.w3.org/2000/svg'%3E%3Ccircle cx='0' cy='0' r='20' fill='none' stroke='%23d97706' stroke-width='0.75' stroke-opacity='0.05'/%3E%3Ccircle cx='40' cy='0' r='20' fill='none' stroke='%23d97706' stroke-width='0.75' stroke-opacity='0.05'/%3E%3Ccircle cx='0' cy='40' r='20' fill='none' stroke='%23d97706' stroke-width='0.75' stroke-opacity='0.05'/%3E%3Ccircle cx='40' cy='40' r='20' fill='none' stroke='%23d97706' stroke-width='0.75' stroke-opacity='0.05'/%3E%3Ccircle cx='20' cy='20' r='20' fill='none' stroke='%23d97706' stroke-width='0.75' stroke-opacity='0.05'/%3E%3Cpath d='M0,20 Q10,10 20,20 Q10,30 0,20' fill='none' stroke='%23d97706' stroke-width='0.75' stroke-opacity='0.06'/%3E%3Cpath d='M20,20 Q30,10 40,20 Q30,30 20,20' fill='none' stroke='%23d97706' stroke-width='0.75' stroke-opacity='0.06'/%3E%3Cpath d='M20,0 Q10,10 20,20 Q30,10 20,0' fill='none' stroke='%23d97706' stroke-width='0.75' stroke-opacity='0.06'/%3E%3Cpath d='M20,20 Q10,30 20,40 Q30,30 20,20' fill='none' stroke='%23d97706' stroke-width='0.75' stroke-opacity='0.06'/%3E%3C/svg%3E");
        background-size: cover, 40px 40px;
        box-shadow: inset 0 10px 20px rgba(0, 0, 0, 0.03), inset 0 -10px 20px rgba(0, 0, 0, 0.03);
    }

    /* Welcome Card */
    .nusai-welcome {
        background: linear-gradient(135deg, rgba(255, 253, 249, 0.95) 0%, rgba(245, 239, 230, 0.95) 100%);
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.04);
        backdrop-filter: blur(10px);
    }

    html[data-theme="dark"] .nusai-welcome {
        background: linear-gradient(135deg, rgba(15, 12, 10, 0.95) 0%, rgba(30, 25, 22, 0.95) 100%);
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.25);
    }

    /* Chat Bubbles */
    .user-bubble {
        background: linear-gradient(135deg, #7c2d12 0%, #b45309 100%);
        color: #ffffff;
        border-radius: 18px 18px 4px 18px;
        padding: 10px 14px;
        max-width: 82%;
        margin-left: auto;
        box-shadow: 0 4px 15px rgba(180, 83, 9, 0.2);
        border: 1px solid rgba(251, 191, 36, 0.35);
        font-size: 13px;
        line-height: 1.5;
    }

    .ai-bubble {
        background: #ffffff;
        color: #1e293b;
        border: 1px solid rgba(217, 119, 6, 0.15);
        border-left: 4px solid #b45309;
        border-radius: 18px 18px 18px 4px;
        padding: 10px 14px;
        max-width: 82%;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.04);
        font-size: 13px;
        line-height: 1.5;
        white-space: pre-line;
    }

    html[data-theme="dark"] .ai-bubble {
        background: #1c1917;
        color: #e5e7eb;
        border: 1px solid rgba(217, 119, 6, 0.22);
        border-left: 4px solid #f97316;
    }

    /* Time stamp */
    .message-time {
        font-size: 10px;
        opacity: 0.7;
        margin-top: 4px;
    }

    .user-bubble .message-time {
        text-align: right;
        color: rgba(255, 255, 255, 0.8);
    }

    .ai-bubble .message-time {
        color: #64748b;
    }

    html[data-theme="dark"] .ai-bubble .message-time {
        color: #a8a29e;
    }

    /* Scrollbar */
    .scrollbar-thin {
        scrollbar-width: thin;
    }

    .scrollbar-thin::-webkit-scrollbar {
        width: 5px;
    }

    .scrollbar-thin::-webkit-scrollbar-track {
        background: transparent;
    }

    .scrollbar-thin::-webkit-scrollbar-thumb {
        background: rgba(217, 119, 6, 0.25);
        border-radius: 3px;
    }

    .scrollbar-thin::-webkit-scrollbar-thumb:hover {
        background: rgba(217, 119, 6, 0.45);
    }

    /* Message animation */
    @keyframes messageIn {
        from {
            opacity: 0;
            transform: translateY(8px) scale(0.97);
        }

        to {
            opacity: 1;
            transform: translateY(0) scale(1);
        }
    }

    .message-in {
        animation: messageIn 0.25s ease-out;
    }

    /* Typing indicator */
    .typing-indicator {
        display: flex;
        align-items: center;
        gap: 4px;
        padding: 10px 14px;
        background: #ffffff;
        border-radius: 18px;
        width: fit-content;
        border: 1px solid rgba(217, 119, 6, 0.15);
        margin-left: 8px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.04);
        backdrop-filter: blur(10px);
    }

    html[data-theme="dark"] .typing-indicator {
        background: #1c1917;
        border: 1px solid rgba(217, 119, 6, 0.22);
    }

    .typing-dot {
        width: 5px;
        height: 5px;
        border-radius: 50%;
        background: #b45309;
        animation: typing 1.4s infinite ease-in-out;
    }

    html[data-theme="dark"] .typing-dot {
        background: #f97316;
    }

    .typing-dot:nth-child(1) {
        animation-delay: -0.32s;
    }

    .typing-dot:nth-child(2) {
        animation-delay: -0.16s;
    }

    .typing-dot:nth-child(3) {
        animation-delay: 0s;
    }

    @keyframes typing {

        0%,
        80%,
        100% {
            transform: scale(0.8);
            opacity: 0.5;
        }

        40% {
            transform: scale(1.2);
            opacity: 1;
        }
    }

    /* Spinner */
    .spinner {
        width: 14px;
        height: 14px;
        border: 2px solid rgba(255, 255, 255, 0.3);
        border-top: 2px solid #ffffff;
        border-radius: 50%;
        animation: spin 0.8s linear infinite;
    }

    @keyframes spin {
        0% {
            transform: rotate(0deg);
        }

        100% {
            transform: rotate(360deg);
        }
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const toggleBtn = document.getElementById('nusantara-toggle');
        const panel = document.getElementById('nusantara-panel');
        const closeBtn = document.getElementById('nusantara-close');
        const form = document.getElementById('nusantara-form');
        const input = document.getElementById('nusantara-input');
        const messagesBox = document.getElementById('nusantara-messages');
        const sendButton = document.getElementById('send-button');
        const chatEndpoint = document.getElementById('chat-endpoint').value;

        let isOpen = false;
        let chatHistory = [];
        const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');

        // Welcome message to history
        chatHistory.push({
            role: 'assistant',
            content: 'Halo! Saya Lentara AI, asisten digital khusus untuk membahas budaya dan kekayaan Indonesia. Ada yang bisa saya bantu?'
        });

        // Toggle panel
        function openPanel() {
            isOpen = true;
            // Fade out toggle button
            toggleBtn.classList.add('opacity-0', 'scale-75', 'pointer-events-none');

            // Show panel
            panel.classList.remove('opacity-0', 'translate-y-4', 'scale-95', 'pointer-events-none');
            panel.classList.add('opacity-100', 'translate-y-0', 'scale-100', 'pointer-events-auto');

            setTimeout(() => input?.focus(), 250);
            setTimeout(() => {
                messagesBox.scrollTop = messagesBox.scrollHeight;
            }, 100);
        }

        function closePanel() {
            isOpen = false;
            // Hide panel
            panel.classList.remove('opacity-100', 'translate-y-0', 'scale-100', 'pointer-events-auto');
            panel.classList.add('opacity-0', 'translate-y-4', 'scale-95', 'pointer-events-none');

            // Fade in toggle button
            setTimeout(() => {
                toggleBtn.classList.remove('opacity-0', 'scale-75', 'pointer-events-none');
            }, 150);
        }

        toggleBtn.addEventListener('click', openPanel);
        closeBtn.addEventListener('click', closePanel);

        // Form submit
        form.addEventListener('submit', async (e) => {
            e.preventDefault();
            const message = input.value.trim();
            if (!message) return;

            // Add user message to UI
            addMessage(message, 'user');

            // Add to history
            chatHistory.push({ role: 'user', content: message });

            input.value = '';
            input.disabled = true;
            sendButton.disabled = true;
            sendButton.innerHTML = '<div class="spinner"></div>';

            // Show typing indicator
            showTypingIndicator();

            try {
                const response = await fetch(chatEndpoint, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken,
                        'Accept': 'application/json',
                    },
                    body: JSON.stringify({
                        messages: chatHistory
                    })
                });

                const data = await response.json();
                removeTypingIndicator();

                if (response.ok && data.reply) {
                    // Add AI reply to UI
                    addMessage(data.reply, 'ai');

                    // Add to history
                    chatHistory.push({ role: 'assistant', content: data.reply });
                } else {
                    addMessage('Maaf ya, terjadi kendala koneksi dengan Lentara AI. Silakan coba lagi sebentar lagi.', 'ai');
                    console.error('API Error:', data);
                }

            } catch (error) {
                removeTypingIndicator();
                addMessage('Maaf, koneksi internet sedang bermasalah. Coba lagi ya.', 'ai');
                console.error('Fetch Error:', error);
            } finally {
                input.disabled = false;
                sendButton.disabled = false;
                sendButton.innerHTML = `
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                          d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/>
                </svg>
            `;
                input.focus();
            }
        });

        // Close on escape
        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape' && isOpen) {
                closePanel();
            }
        });

        // Click outside to close
        document.addEventListener('click', (e) => {
            if (isOpen &&
                !panel.contains(e.target) &&
                !toggleBtn.contains(e.target)) {
                closePanel();
            }
        });

        // Helper functions
        function addMessage(text, sender) {
            const messageDiv = document.createElement('div');
            messageDiv.className = `message-in flex ${sender === 'user' ? 'justify-end' : 'justify-start'} mb-4`;

            if (sender === 'user') {
                messageDiv.innerHTML = `
                <div class="user-bubble">
                    <div>${escapeHtml(text)}</div>
                    <div class="message-time">${getCurrentTime()}</div>
                </div>
            `;
            } else {
                messageDiv.innerHTML = `
                <div class="flex items-start gap-2.5 max-w-full">
                    <div class="w-9 h-9 rounded-full flex-shrink-0 mt-0.5
                               bg-gradient-to-br from-amber-800 to-red-900
                               p-0.5 border border-amber-400/30 flex items-center justify-center">
                        <img src="{{ asset('images/icon/lentaraai.PNG') }}"
                             alt="AI" class="w-7 h-7 object-contain">
                    </div>
                    <div class="ai-bubble">
                        <div>${escapeHtml(text)}</div>
                        <div class="message-time">${getCurrentTime()}</div>
                    </div>
                </div>
            `;
            }

            messagesBox.appendChild(messageDiv);
            messagesBox.scrollTop = messagesBox.scrollHeight;
        }

        function showTypingIndicator() {
            const typingDiv = document.createElement('div');
            typingDiv.className = 'typing-indicator mb-4 message-in';
            typingDiv.id = 'typing-indicator';
            typingDiv.innerHTML = `
            <div class="typing-dot"></div>
            <div class="typing-dot"></div>
            <div class="typing-dot"></div>
            <span class="text-[10px] ml-1.5 text-slate-500 dark:text-stone-400">
                Lentara AI sedang menulis...
            </span>
        `;
            messagesBox.appendChild(typingDiv);
            messagesBox.scrollTop = messagesBox.scrollHeight;
        }

        function removeTypingIndicator() {
            const typing = document.getElementById('typing-indicator');
            if (typing) typing.remove();
        }

        function getCurrentTime() {
            const now = new Date();
            return now.toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' });
        }

        function escapeHtml(text) {
            const div = document.createElement('div');
            div.textContent = text;
            // preserve line breaks
            return div.innerHTML.replace(/\n/g, '<br>');
        }
    });
</script>
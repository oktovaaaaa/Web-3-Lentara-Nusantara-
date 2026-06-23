{{-- resources/views/islands/partials/history.blade.php --}}

@php
    // ===============================
    // SAFETY DEFAULTS (JANGAN HAPUS)
    // ===============================
    $tribeKey               = $tribeKey ?? '';
    $currentTribeHistories  = $currentTribeHistories ?? collect();
    $historyFeatures        = $historyFeatures ?? collect();
@endphp

<section id="history" class="history-section py-12">
    <div class="history-container">
        {{-- HEADER TITLE: pakai sistem title global (SAMA seperti islands/home) --}}
        <div class="history-title-wrap">
            <h2 class="neon-title scroll-reveal reveal-fade-up">
                Sejarah Suku {{ $tribeKey !== '' ? $tribeKey : '—' }}
            </h2>
            <div class="title-decoration scroll-reveal reveal-fade-up delay-100"></div>

            <p class="neon-subtitle scroll-reveal reveal-fade-up delay-150">
                Timeline sejarah yang membentuk identitas budaya dan perjalanan Suku {{ $tribeKey !== '' ? $tribeKey : '—' }}.
            </p>
        </div>

        @if($currentTribeHistories->count())
            <div class="timeline scroll-reveal reveal-fade-up delay-200">
                @foreach($currentTribeHistories as $index => $item)
                    <div class="timeline-item">
                        <div class="timeline-card scroll-reveal reveal-fade-up" style="transition-delay: {{ ($loop->index % 3) * 120 + 100 }}ms">
                            <div class="timeline-card-glow"></div>

                            <div class="timeline-card-inner">
                                <div class="timeline-badge">
                                    {{ !empty($item->year_label) ? $item->year_label : 'Jejak Sejarah' }}
                                </div>

                                <h3 class="timeline-heading">
                                    {{ $item->title }}
                                </h3>

                                <p class="timeline-text">
                                    {{ $item->content }}
                                </p>

                                @if(!empty($item->more_link))
                                    <a href="{{ $item->more_link }}"
                                       target="_blank"
                                       rel="noopener"
                                       class="timeline-link">
                                        Lihat selengkapnya →
                                    </a>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <style>
                .empty-state-card {
                    position: relative;
                    max-width: 580px;
                    margin: 2rem auto;
                    padding: 3.5rem 2rem;
                    border-radius: 24px;
                    background: linear-gradient(145deg, 
                        color-mix(in srgb, var(--card) 40%, transparent), 
                        color-mix(in srgb, var(--card) 20%, transparent));
                    border: 1px solid color-mix(in srgb, var(--line) 40%, transparent);
                    box-shadow: 
                        0 20px 40px rgba(0, 0, 0, 0.2), 
                        inset 0 1px 0 rgba(255, 255, 255, 0.05);
                    backdrop-filter: blur(8px);
                    -webkit-backdrop-filter: blur(8px);
                    overflow: hidden;
                    text-align: center;
                }

                html[data-theme="dark"] .empty-state-card {
                    background: linear-gradient(145deg, rgba(255, 255, 255, 0.02), rgba(255, 255, 255, 0.005));
                    border-color: rgba(255, 255, 255, 0.05);
                }

                .empty-state-card::before {
                    content: "";
                    position: absolute;
                    inset: 0;
                    border-radius: inherit;
                    padding: 1.5px;
                    background: linear-gradient(135deg, rgba(249, 115, 22, 0.3), transparent 70%);
                    -webkit-mask: linear-gradient(#fff 0 0) content-box, linear-gradient(#fff 0 0);
                    -webkit-mask-composite: xor;
                    mask-composite: exclude;
                    pointer-events: none;
                }

                .empty-state-icon svg {
                    color: var(--brand, #f97316);
                    filter: drop-shadow(0 0 12px rgba(249, 115, 22, 0.4));
                    animation: pulseGlow 3s infinite ease-in-out;
                }

                @keyframes pulseGlow {
                    0%, 100% {
                        transform: scale(1);
                        filter: drop-shadow(0 0 8px rgba(249, 115, 22, 0.3));
                    }
                    50% {
                        transform: scale(1.05);
                        filter: drop-shadow(0 0 20px rgba(249, 115, 22, 0.6));
                    }
                }

                .empty-state-title {
                    font-family: 'Cinzel', serif !important;
                    font-size: 1.35rem;
                    font-weight: 700;
                    margin: 1rem 0 0.5rem 0;
                    color: var(--txt-body);
                    letter-spacing: 0.02em;
                }

                .empty-state-desc {
                    font-size: 0.95rem;
                    line-height: 1.6;
                    color: var(--muted);
                    max-width: 420px;
                    margin: 0 auto;
                }
            </style>

            <div class="empty-state-card scroll-reveal reveal-zoom-in">
                <div class="empty-state-icon">
                    <svg class="w-16 h-16 mx-auto" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                        <circle cx="12" cy="12" r="10" />
                        <polyline points="12 6 12 12 16 14" />
                        <path d="M12 2v2M12 20v2M4 12H2M22 12h-2" opacity="0.5" />
                    </svg>
                </div>
                <h3 class="empty-state-title">Sejarah Suku Belum Tersedia</h3>
                <p class="empty-state-desc">
                    Timeline sejarah yang membentuk identitas budaya dan perjalanan Suku {{ $tribeKey !== '' ? $tribeKey : 'suku' }} sedang disusun oleh admin.
                </p>
            </div>
        @endif

        {{-- OPTIONAL: Sejarah pulau-level dari features (kalau kamu pakai) --}}
        @if($historyFeatures->count())
            <div class="history-features space-y-3 mt-8">
                <h3 class="history-mini-title">Sejarah Pulau (Umum)</h3>
                <p class="history-mini-subtitle">
                    Ringkasan sejarah umum untuk pulau ini (opsional).
                </p>

                @foreach($historyFeatures as $f)
                    <div class="feature-card">
                        <h4>{{ $f->title }}</h4>
                        <p>{{ $f->content }}</p>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</section>

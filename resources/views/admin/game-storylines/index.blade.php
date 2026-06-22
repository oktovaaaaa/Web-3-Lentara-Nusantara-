{{-- resources/views/admin/game-storylines/index.blade.php --}}
@extends('layouts.admin')

@section('page-title', 'Kelola Storyline: ' . $level->title)
@section('content')

<style>
  .gl-wrap {
    max-width: 1200px;
    margin: 0 auto;
    padding: 6px 0 18px;
  }
  .gl-head {
    display: flex;
    align-items: flex-start;
    justify-content: space-between;
    gap: 12px;
    flex-wrap: wrap;
    margin: 6px 0 14px;
  }
  .gl-head h1 {
    margin: 0;
    font-size: 20px;
    font-weight: 1000;
    color: var(--txt-body);
  }
  .gl-head p {
    margin: 6px 0 0;
    color: var(--muted);
    font-size: 12px;
    font-weight: 800;
  }
  .gl-chip {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    padding: 8px 12px;
    border-radius: 999px;
    border: 1px solid var(--line);
    background: rgba(255, 255, 255, .02);
    color: var(--txt-body);
    font-weight: 1000;
    font-size: 12px;
  }
  .gl-grid {
    display: grid;
    grid-template-columns: 1fr 1.2fr;
    gap: 16px;
    align-items: start;
  }
  @media (max-width: 1024px) {
    .gl-grid { grid-template-columns: 1fr; }
  }
  .gl-card {
    border-radius: 18px;
    border: 1px solid rgba(148, 163, 184, .18);
    background: color-mix(in oklab, var(--card) 55%, transparent);
    backdrop-filter: blur(14px) saturate(140%);
    -webkit-backdrop-filter: blur(14px) saturate(140%);
    padding: 18px;
    color: var(--txt-body);
  }
  .gl-title {
    font-weight: 1000;
    margin: 0 0 10px 0;
    font-size: 16px;
  }
  .gl-sub {
    margin: -4px 0 12px 0;
    color: var(--muted);
    font-size: 12px;
    font-weight: 800;
  }
  .gl-field { margin-bottom: 12px; }
  .gl-label {
    display: block;
    font-size: 12px;
    font-weight: 1000;
    margin: 0 0 6px 2px;
    color: color-mix(in oklab, var(--txt-body) 82%, transparent);
  }
  .gl-input, .gl-select, .gl-textarea {
    width: 100%;
    padding: 10px 12px;
    border-radius: 12px;
    outline: none;
    border: 1px solid rgba(148, 163, 184, .22);
    background: color-mix(in oklab, var(--card) 35%, transparent);
    color: var(--txt-body);
    font-family: inherit;
    transition: all .2s ease;
  }
  .gl-textarea { height: 80px; resize: vertical; }
  .gl-input:focus, .gl-select:focus, .gl-textarea:focus {
    border-color: rgba(249, 115, 22, .55);
    box-shadow: 0 0 0 4px rgba(249, 115, 22, .14);
  }
  .gl-btn {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
    padding: 10px 14px;
    border-radius: 999px;
    font-weight: 1000;
    font-size: 12px;
    text-decoration: none;
    border: 1px solid rgba(148, 163, 184, .20);
    background: rgba(255, 255, 255, .03);
    color: var(--txt-body);
    cursor: pointer;
    transition: all .15s ease;
  }
  .gl-btn-primary {
    border-color: rgba(249, 115, 22, .30);
    background: linear-gradient(90deg, rgba(249, 115, 22, .95), rgba(251, 146, 60, .95));
    color: #0b1020;
  }
  .gl-btn-primary:hover { filter: brightness(1.05); }
  .gl-btn-ghost:hover {
    border-color: rgba(249, 115, 22, .38);
    background: rgba(249, 115, 22, .08);
  }
  .gl-btn-danger {
    border-color: rgba(239, 68, 68, .32);
    background: rgba(239, 68, 68, .10);
    color: rgba(254, 202, 202, .95);
  }
  .gl-btn-danger:hover { background: rgba(239, 68, 68, .14); }
  .gl-list { display: grid; gap: 12px; }
  .gl-item {
    padding: 14px;
    border-radius: 16px;
    border: 1px solid rgba(148, 163, 184, .16);
    background: color-mix(in oklab, var(--card) 42%, transparent);
  }
  .gl-item-top {
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    gap: 12px;
  }
  .gl-item-title { font-weight: 1000; font-size: 14px; }
  .gl-item-meta { font-size: 11px; color: var(--muted); margin-top: 4px; font-weight: 800; }
  .gl-item-dialogue {
    margin-top: 8px;
    padding: 10px;
    border-radius: 10px;
    background: rgba(255,255,255,.02);
    border: 1px dashed var(--line);
    font-size: 12px;
    line-height: 1.4;
    white-space: pre-wrap;
  }
  .gl-item-assets {
    display: flex;
    gap: 8px;
    margin-top: 8px;
    flex-wrap: wrap;
  }
  .asset-badge {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    padding: 4px 8px;
    border-radius: 6px;
    font-size: 10px;
    background: rgba(255,255,255,.05);
    border: 1px solid var(--line);
  }
  .asset-badge img {
    height: 16px; width: 16px; object-fit: cover; border-radius: 2px;
  }
  .gl-options-preview {
    margin-top: 10px;
    display: grid;
    gap: 6px;
    border-top: 1px solid var(--line);
    padding-top: 8px;
  }
  .opt-preview-item {
    font-size: 11px;
    display: flex;
    align-items: center;
    gap: 8px;
    font-weight: 800;
  }
  .opt-preview-item .dot {
    width: 8px; height: 8px; border-radius: 999px;
  }
  .opt-preview-item .dot.correct { background: #22c55e; }
  .opt-preview-item .dot.wrong { background: #ef4444; }
  
  .gl-actions {
    margin-top: 12px;
    display: flex;
    gap: 8px;
  }
  .gl-option-row {
    display: grid;
    grid-template-columns: 1fr auto;
    gap: 10px;
    align-items: center;
    margin-bottom: 6px;
  }
  .gl-option-correct {
    display: flex;
    align-items: center;
    gap: 6px;
    font-size: 11px;
    font-weight: 800;
  }
</style>

<div class="gl-wrap">
  <div class="gl-head">
    <div>
      <a href="{{ route('admin.game-levels.index') }}" class="gl-btn gl-btn-ghost" style="margin-bottom: 8px;">
        ← Kembali ke Level
      </a>
      <h1>Kelola Storyline: {{ $level->island->name }} — {{ $level->title }}</h1>
      <p>Kelola langkah cerita visual novel, dialog, aset, dan pertanyaan pilihan bercabang.</p>
    </div>
    <div class="gl-chip">
      <span>Total</span>
      <strong>{{ $steps->count() }}</strong>
      <span>Langkah</span>
    </div>
  </div>

  @if(session('success'))
    <div style="background: rgba(34,197,94,.1); border: 1px solid rgba(34,197,94,.3); color: #22c55e; padding: 12px; border-radius: 12px; margin-bottom: 14px; font-weight: 800; font-size: 13px;">
      {{ session('success') }}
    </div>
  @endif

  @if(session('error'))
    <div style="background: rgba(239,68,68,.1); border: 1px solid rgba(239,68,68,.3); color: #ef4444; padding: 12px; border-radius: 12px; margin-bottom: 14px; font-weight: 800; font-size: 13px;">
      {{ session('error') }}
    </div>
  @endif

  <div class="gl-grid">
    {{-- Form Tambah Langkah --}}
    <div class="gl-card">
      <h3 class="gl-title">Tambah Langkah Cerita</h3>
      <form method="POST" action="{{ route('admin.game-storylines.store', $level->id) }}" enctype="multipart/form-data">
        @csrf

        <div class="gl-field">
          <label class="gl-label">Urutan Tampil (Order)</label>
          <input type="number" name="order" class="gl-input" value="{{ $steps->max('order') + 1 }}" required min="1" />
        </div>

        <div class="gl-field">
          <label class="gl-label">Nama Karakter (Kosongkan jika Narator)</label>
          <input type="text" name="character_name" class="gl-input" placeholder="Contoh: Toba, Putri, atau dikosongkan..." />
        </div>

        <div class="gl-field">
          <label class="gl-label">Teks Dialog</label>
          <textarea name="dialogue_text" class="gl-textarea" required placeholder="Tulis dialogue teks di sini..."></textarea>
        </div>

        <div class="gl-field">
          <label class="gl-label">Jenis Animasi / Transisi</label>
          <select name="animation_type" class="gl-select">
            <option value="none">Tanpa Animasi (Normal)</option>
            <option value="zoom">Zoom-In (Ken Burns)</option>
            <option value="fade">Fade-In</option>
            <option value="shake">Layar Goyang (Shake)</option>
          </select>
        </div>

        <div class="gl-field">
          <label class="gl-label">Gambar Background (File / Path)</label>
          <input type="file" name="background" class="gl-input" accept="image/*" style="margin-bottom: 6px;" />
          <input type="text" name="background_path" class="gl-input" placeholder="Atau ketik path manual, cth: images/storylines/bg_lake.png" />
        </div>

        <div class="gl-field">
          <label class="gl-label">Sprite Karakter (File / Path)</label>
          <input type="file" name="character" class="gl-input" accept="image/*" style="margin-bottom: 6px;" />
          <input type="text" name="character_path" class="gl-input" placeholder="Atau ketik path manual, cth: images/storylines/char_toba.png" />
        </div>

        {{-- Section Pilihan Bercabang (Optional) --}}
        <div style="border-top: 1px solid var(--line); margin-top: 16px; padding-top: 12px;">
          <h4 class="gl-title" style="font-size: 13px; margin-bottom: 4px;">Pilihan Bercabang (Optional)</h4>
          <p class="gl-sub" style="margin-bottom: 10px;">Isi jika langkah cerita ini mewajibkan player memilih kelanjutan dialog. Hanya isi opsi correct untuk salah satunya.</p>
          
          @for($i = 1; $i <= 4; $i++)
            <div class="gl-option-row">
              <input type="text" name="option_{{ $i }}_text" class="gl-input" placeholder="Opsi Pilihan {{ $i }}..." />
              <label class="gl-option-correct">
                <input type="checkbox" name="option_{{ $i }}_correct" value="1" />
                Benar
              </label>
            </div>
          @endfor
        </div>

        <button class="gl-btn gl-btn-primary" type="submit" style="width: 100%; margin-top: 14px;">
          Simpan Langkah Cerita
        </button>
      </form>
    </div>

    {{-- Daftar Langkah --}}
    <div class="gl-card">
      <h3 class="gl-title">Langkah Cerita Saat Ini</h3>
      
      @if($steps->isEmpty())
        <div style="color: var(--muted); text-align: center; padding: 24px; font-weight: 800; font-size: 13px;">
          Belum ada langkah cerita. Silahkan tambahkan langkah pertama.
        </div>
      @else
        <div class="gl-list">
          @foreach($steps as $step)
            <div class="gl-item">
              <div class="gl-item-top">
                <div>
                  <span class="gl-chip" style="padding: 4px 8px; font-size: 10px;">
                    Langkah #{{ $step->order }}
                  </span>
                  @if($step->character_name)
                    <strong style="color: var(--brand); margin-left: 6px;">[{{ $step->character_name }}]</strong>
                  @else
                    <span style="color: var(--muted); margin-left: 6px;">[Narator]</span>
                  @endif
                </div>

                <div style="font-size: 11px; color: var(--muted); font-weight: 800;">
                  Animasi: <strong style="color:var(--txt-body)">{{ $step->animation_type }}</strong>
                </div>
              </div>

              <div class="gl-item-dialogue">{{ $step->dialogue_text }}</div>

              <div class="gl-item-assets">
                @if($step->background_path)
                  <span class="asset-badge" title="Background">
                    <img src="{{ asset($step->background_path) }}" alt="BG">
                    BG: {{ basename($step->background_path) }}
                  </span>
                @endif
                @if($step->character_path)
                  <span class="asset-badge" title="Character">
                    <img src="{{ asset($step->character_path) }}" alt="Char">
                    Karakter: {{ basename($step->character_path) }}
                  </span>
                @endif
              </div>

              @if($step->options)
                <div class="gl-options-preview">
                  <div style="font-size: 11px; font-weight: 1000; color: var(--brand);">Pertanyaan Opsi:</div>
                  @foreach($step->options as $opt)
                    <div class="opt-preview-item">
                      <i class="dot {{ $opt['is_correct'] ? 'correct' : 'wrong' }}"></i>
                      <span>{{ $opt['option_text'] }}</span>
                    </div>
                  @endforeach
                </div>
              @endif

              <div class="gl-actions">
                <a href="{{ route('admin.game-storylines.edit', [$level->id, $step->id]) }}" class="gl-btn gl-btn-ghost">
                  Edit
                </a>
                
                <form method="POST" action="{{ route('admin.game-storylines.destroy', [$level->id, $step->id]) }}" onsubmit="return confirm('Hapus langkah cerita ini?')">
                  @csrf
                  @method('DELETE')
                  <button type="submit" class="gl-btn gl-btn-danger">Hapus</button>
                </form>
              </div>
            </div>
          @endforeach
        </div>
      @endif
    </div>
  </div>
</div>

@endsection

{{-- resources/views/admin/game-storylines/edit.blade.php --}}
@extends('layouts.admin')

@section('page-title', 'Edit Langkah Cerita')
@section('content')

<style>
  .gl-wrap {
    max-width: 800px;
    margin: 0 auto;
    padding: 6px 0 18px;
  }
  .gl-head {
    margin: 6px 0 14px;
  }
  .gl-head h1 {
    margin: 0;
    font-size: 20px;
    font-weight: 1000;
    color: var(--txt-body);
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
  .preview-box {
    margin-top: 6px;
    padding: 10px;
    border-radius: 10px;
    background: rgba(255,255,255,.03);
    border: 1px solid var(--line);
    display: flex;
    align-items: center;
    gap: 12px;
  }
  .preview-box img {
    height: 48px; width: 48px; object-fit: cover; border-radius: 6px; border: 1px solid var(--line);
  }
</style>

<div class="gl-wrap">
  <div class="gl-head">
    <a href="{{ route('admin.game-storylines.index', $level->id) }}" class="gl-btn gl-btn-ghost" style="margin-bottom: 8px;">
      ← Kembali ke Storyline
    </a>
    <h1>Edit Langkah Cerita #{{ $step->order }}</h1>
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

  <div class="gl-card">
    <h3 class="gl-title">Form Edit Langkah</h3>
    
    <form method="POST" action="{{ route('admin.game-storylines.update', [$level->id, $step->id]) }}" enctype="multipart/form-data">
      @csrf
      @method('PUT')

      <div class="gl-field">
        <label class="gl-label">Urutan Tampil (Order)</label>
        <input type="number" name="order" class="gl-input" value="{{ old('order', $step->order) }}" required min="1" />
      </div>

      <div class="gl-field">
        <label class="gl-label">Nama Karakter (Kosongkan jika Narator)</label>
        <input type="text" name="character_name" class="gl-input" value="{{ old('character_name', $step->character_name) }}" placeholder="Contoh: Toba, Putri..." />
      </div>

      <div class="gl-field">
        <label class="gl-label">Teks Dialog</label>
        <textarea name="dialogue_text" class="gl-textarea" required>{{ old('dialogue_text', $step->dialogue_text) }}</textarea>
      </div>

      <div class="gl-field">
        <label class="gl-label">Jenis Animasi / Transisi</label>
        <select name="animation_type" class="gl-select">
          <option value="none" {{ $step->animation_type === 'none' ? 'selected' : '' }}>Tanpa Animasi (Normal)</option>
          <option value="zoom" {{ $step->animation_type === 'zoom' ? 'selected' : '' }}>Zoom-In (Ken Burns)</option>
          <option value="fade" {{ $step->animation_type === 'fade' ? 'selected' : '' }}>Fade-In</option>
          <option value="shake" {{ $step->animation_type === 'shake' ? 'selected' : '' }}>Layar Goyang (Shake)</option>
        </select>
      </div>

      {{-- Background Asset --}}
      <div class="gl-field">
        <label class="gl-label">Gambar Background (File / Path)</label>
        <input type="file" name="background" class="gl-input" accept="image/*" style="margin-bottom: 6px;" />
        <input type="text" name="background_path" class="gl-input" value="{{ old('background_path', $step->background_path) }}" placeholder="Atau ketik path manual..." />
        
        @if($step->background_path)
          <div class="preview-box">
            <img src="{{ asset($step->background_path) }}" alt="Preview BG">
            <div style="flex-grow: 1; font-size: 11px;">
              <div>File saat ini: <strong>{{ basename($step->background_path) }}</strong></div>
              <label style="display:flex; align-items:center; gap:6px; margin-top:4px; font-weight:800; cursor:pointer;">
                <input type="checkbox" name="remove_background" value="1">
                Hapus background ini
              </label>
            </div>
          </div>
        @endif
      </div>

      {{-- Character Asset --}}
      <div class="gl-field">
        <label class="gl-label">Sprite Karakter (File / Path)</label>
        <input type="file" name="character" class="gl-input" accept="image/*" style="margin-bottom: 6px;" />
        <input type="text" name="character_path" class="gl-input" value="{{ old('character_path', $step->character_path) }}" placeholder="Atau ketik path manual..." />
        
        @if($step->character_path)
          <div class="preview-box">
            <img src="{{ asset($step->character_path) }}" alt="Preview Char">
            <div style="flex-grow: 1; font-size: 11px;">
              <div>File saat ini: <strong>{{ basename($step->character_path) }}</strong></div>
              <label style="display:flex; align-items:center; gap:6px; margin-top:4px; font-weight:800; cursor:pointer;">
                <input type="checkbox" name="remove_character" value="1">
                Hapus karakter ini
              </label>
            </div>
          </div>
        @endif
      </div>

      {{-- Section Opsi Pilihan (Branching) --}}
      <div style="border-top: 1px solid var(--line); margin-top: 16px; padding-top: 12px;">
        <h4 class="gl-title" style="font-size: 13px; margin-bottom: 4px;">Pilihan Bercabang (Optional)</h4>
        <p class="gl-sub" style="margin-bottom: 10px;">Sunting atau tambahkan pilihan bercabang di bawah ini. Hanya centang "Benar" untuk satu opsi.</p>
        
        @for($i = 1; $i <= 4; $i++)
          @php
            $opt = null;
            if ($step->options && is_array($step->options) && isset($step->options[$i - 1])) {
                $opt = $step->options[$i - 1];
            }
            $optText = $opt ? $opt['option_text'] : '';
            $optCorrect = $opt ? $opt['is_correct'] : false;
          @endphp
          <div class="gl-option-row">
            <input type="text" name="option_{{ $i }}_text" class="gl-input" value="{{ old("option_{$i}_text", $optText) }}" placeholder="Opsi Pilihan {{ $i }}..." />
            <label class="gl-option-correct">
              <input type="checkbox" name="option_{{ $i }}_correct" value="1" {{ $optCorrect ? 'checked' : '' }} />
              Benar
            </label>
          </div>
        @endfor
      </div>

      <div style="margin-top: 18px; display:flex; gap:10px;">
        <button class="gl-btn gl-btn-primary" type="submit" style="flex-grow: 1;">
          Simpan Perubahan
        </button>
        <a href="{{ route('admin.game-storylines.index', $level->id) }}" class="gl-btn gl-btn-ghost">
          Batal
        </a>
      </div>
    </form>
  </div>
</div>

@endsection

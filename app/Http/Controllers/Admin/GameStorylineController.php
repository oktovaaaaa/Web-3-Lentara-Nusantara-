<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\GameLevel;
use App\Models\GameStorylineStep;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class GameStorylineController extends Controller
{
    public function index(GameLevel $level)
    {
        $steps = $level->storylineSteps()->orderBy('order')->get();
        return view('admin.game-storylines.index', compact('level', 'steps'));
    }

    public function store(Request $request, GameLevel $level)
    {
        $data = $request->validate([
            'character_name' => ['nullable', 'string', 'max:100'],
            'dialogue_text'   => ['required', 'string'],
            'order'           => ['required', 'integer', 'min:1'],
            'animation_type'  => ['required', 'in:none,zoom,shake,fade'],
            'background'      => ['nullable', 'image', 'max:2048'],
            'character'       => ['nullable', 'image', 'max:2048'],
            'background_path' => ['nullable', 'string', 'max:255'],
            'character_path'  => ['nullable', 'string', 'max:255'],
        ]);

        $data['game_level_id'] = $level->id;

        // Handle Background Upload
        if ($request->hasFile('background')) {
            $path = $request->file('background')->store('game/storylines/backgrounds', 'public');
            $data['background_path'] = 'storage/' . $path;
        }

        // Handle Character Upload
        if ($request->hasFile('character')) {
            $path = $request->file('character')->store('game/storylines/characters', 'public');
            $data['character_path'] = 'storage/' . $path;
        }

        // Parse Options (branching choices)
        $options = [];
        for ($i = 1; $i <= 4; $i++) {
            $optText = $request->input("option_{$i}_text");
            if (!empty($optText)) {
                $options[] = [
                    'option_text' => $optText,
                    'is_correct' => $request->boolean("option_{$i}_correct"),
                ];
            }
        }
        $data['options'] = !empty($options) ? $options : null;

        GameStorylineStep::create($data);

        return back()->with('success', 'Langkah cerita berhasil ditambahkan.');
    }

    public function edit(GameLevel $level, GameStorylineStep $step)
    {
        if ((int)$step->game_level_id !== (int)$level->id) abort(404);
        return view('admin.game-storylines.edit', compact('level', 'step'));
    }

    public function update(Request $request, GameLevel $level, GameStorylineStep $step)
    {
        if ((int)$step->game_level_id !== (int)$level->id) abort(404);

        $data = $request->validate([
            'character_name' => ['nullable', 'string', 'max:100'],
            'dialogue_text'   => ['required', 'string'],
            'order'           => ['required', 'integer', 'min:1'],
            'animation_type'  => ['required', 'in:none,zoom,shake,fade'],
            'background'      => ['nullable', 'image', 'max:2048'],
            'character'       => ['nullable', 'image', 'max:2048'],
            'background_path' => ['nullable', 'string', 'max:255'],
            'character_path'  => ['nullable', 'string', 'max:255'],
            'remove_background' => ['nullable', 'boolean'],
            'remove_character'  => ['nullable', 'boolean'],
        ]);

        // Remove background if requested
        if ($request->boolean('remove_background')) {
            $this->deleteFile($step->background_path);
            $data['background_path'] = null;
        }

        // Remove character if requested
        if ($request->boolean('remove_character')) {
            $this->deleteFile($step->character_path);
            $data['character_path'] = null;
        }

        // Update Background if uploaded
        if ($request->hasFile('background')) {
            $this->deleteFile($step->background_path);
            $path = $request->file('background')->store('game/storylines/backgrounds', 'public');
            $data['background_path'] = 'storage/' . $path;
        }

        // Update Character if uploaded
        if ($request->hasFile('character')) {
            $this->deleteFile($step->character_path);
            $path = $request->file('character')->store('game/storylines/characters', 'public');
            $data['character_path'] = 'storage/' . $path;
        }

        // Parse Options
        $options = [];
        for ($i = 1; $i <= 4; $i++) {
            $optText = $request->input("option_{$i}_text");
            if (!empty($optText)) {
                $options[] = [
                    'option_text' => $optText,
                    'is_correct' => $request->boolean("option_{$i}_correct"),
                ];
            }
        }
        $data['options'] = !empty($options) ? $options : null;

        $step->update($data);

        return redirect()
            ->route('admin.game-storylines.index', $level->id)
            ->with('success', 'Langkah cerita berhasil diupdate.');
    }

    public function destroy(GameLevel $level, GameStorylineStep $step)
    {
        if ((int)$step->game_level_id !== (int)$level->id) abort(404);

        $this->deleteFile($step->background_path);
        $this->deleteFile($step->character_path);

        $step->delete();

        return back()->with('success', 'Langkah cerita berhasil dihapus.');
    }

    private function deleteFile(?string $path): void
    {
        if (!$path) return;
        if (str_starts_with($path, 'storage/')) {
            $relative = substr($path, strlen('storage/'));
            Storage::disk('public')->delete($relative);
        }
    }
}

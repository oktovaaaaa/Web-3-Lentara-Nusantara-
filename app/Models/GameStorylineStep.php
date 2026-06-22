<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GameStorylineStep extends Model
{
    protected $fillable = [
        'game_level_id',
        'order',
        'character_name',
        'dialogue_text',
        'background_path',
        'character_path',
        'animation_type',
        'options',
    ];

    protected $casts = [
        'options' => 'array',
    ];

    public function level()
    {
        return $this->belongsTo(GameLevel::class, 'game_level_id');
    }
}

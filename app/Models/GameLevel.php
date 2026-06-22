<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GameLevel extends Model
{
    protected $fillable = [
        'island_id',
        'title',
        'order',
        'is_active',
        'time_limit_seconds',
        'level_type',
    ];

    public function island()
    {
        return $this->belongsTo(Island::class);
    }

    public function questions()
    {
        return $this->hasMany(GameQuestion::class, 'game_level_id');
    }

    public function storylineSteps()
    {
        return $this->hasMany(GameStorylineStep::class, 'game_level_id');
    }
}

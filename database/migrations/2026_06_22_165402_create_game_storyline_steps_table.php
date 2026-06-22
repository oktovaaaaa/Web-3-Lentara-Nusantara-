<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('game_storyline_steps', function (Blueprint $table) {
            $table->id();
            $table->foreignId('game_level_id')->constrained('game_levels')->cascadeOnDelete();
            $table->unsignedInteger('order')->default(1);
            $table->string('character_name')->nullable();
            $table->text('dialogue_text');
            $table->string('background_path')->nullable();
            $table->string('character_path')->nullable();
            $table->string('animation_type')->default('none'); // 'none', 'zoom', 'shake', 'fade'
            $table->json('options')->nullable(); // format: [{"option_text": "...", "is_correct": true}, ...]
            $table->timestamps();

            $table->index(['game_level_id', 'order']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('game_storyline_steps');
    }
};

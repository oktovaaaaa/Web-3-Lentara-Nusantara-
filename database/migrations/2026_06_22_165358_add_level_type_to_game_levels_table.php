<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('game_levels', function (Blueprint $table) {
            $table->string('level_type')->default('quiz'); // 'quiz' or 'storyline'
        });
    }

    public function down(): void
    {
        Schema::table('game_levels', function (Blueprint $table) {
            $table->dropColumn('level_type');
        });
    }
};

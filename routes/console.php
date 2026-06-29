<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;
use App\Jobs\GenerateWeeklyTribeFoodRecommendations;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

// Jalan tiap Senin jam 00:00
Schedule::job(new GenerateWeeklyTribeFoodRecommendations)
    ->weeklyOn(1, '00:00')
    ->withoutOverlapping();

Artisan::command('tribe:generate-food {--tribe=}', function () {
    $tribe = $this->option('tribe');
    if ($tribe) {
        $this->info("Memulai generasi rekomendasi makanan khusus suku [{$tribe}] via AI (Gemini) dan Wikipedia...");
    } else {
        $this->info('Memulai generasi rekomendasi makanan seluruh suku via AI (Gemini) dan Wikipedia...');
    }

    dispatch_sync(new GenerateWeeklyTribeFoodRecommendations($tribe));
    $this->info('Rekomendasi makanan suku berhasil diperbarui!');
})->purpose('Generate weekly tribe food recommendations immediately via AI');

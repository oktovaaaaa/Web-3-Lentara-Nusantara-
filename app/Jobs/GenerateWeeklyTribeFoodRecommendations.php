<?php

namespace App\Jobs;

use App\Models\Island;
use App\Models\TribeFoodRecommendation;
use App\Services\GeminiFoodRecommenderService;
use App\Services\WikiImageResolverService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Carbon;

class GenerateWeeklyTribeFoodRecommendations implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public ?string $targetTribe;

    public function __construct(?string $targetTribe = null)
    {
        $this->targetTribe = $targetTribe;
    }

    public function handle(
        GeminiFoodRecommenderService $gemini,
        WikiImageResolverService $wiki
    ): void {
        $now = now();
        $weekKey = Carbon::now()->format('o-\WW');

        $islands = Island::query()
            ->where('is_active', true)
            ->orderBy('order')
            ->get();

        foreach ($islands as $island) {
            $regionSlug = (string) $island->slug;
            $tribes = config('tribes.' . $regionSlug, []);

            if (empty($tribes)) {
                continue;
            }

            foreach ($tribes as $tribeKey) {
                $tribeKey = trim((string) $tribeKey);
                if ($tribeKey === '') continue;

                // Jika ada target suku spesifik, abaikan suku lain
                if ($this->targetTribe && strcasecmp($tribeKey, trim($this->targetTribe)) !== 0) {
                    continue;
                }

                try {
                    $items = $gemini->generateFoodsForTribe($tribeKey, $regionSlug);

                    $finalItems = [];
                    foreach ($items as $it) {
                        $name = trim((string)($it['name'] ?? ''));
                        if ($name === '') continue;

                        $resolved = $wiki->resolve($name, $tribeKey);

                        $imageUrl = $resolved['image_url'] ?? null;
                        $sources  = $resolved['sources'] ?? [];
                        $wikiUrl  = $resolved['wiki_url'] ?? null;

                        $summary = $resolved['wiki_summary']
                            ?? $resolved['summary']
                            ?? $resolved['extract']
                            ?? null;

                        if (!$imageUrl) {
                            $imageUrl = 'https://images.unsplash.com/photo-1540189549336-e6e99c3679fe?auto=format&fit=crop&q=80&w=1200';
                        }

                        $sources = is_array($sources) ? array_values(array_filter($sources)) : [];

                        if ($wikiUrl && is_string($wikiUrl)) {
                            array_unshift($sources, $wikiUrl);
                            $sources = array_values(array_unique(array_filter($sources)));
                        }

                        $finalItems[] = [
                            'name' => $name,
                            'description' => (string)($it['description'] ?? ''),
                            'price_range' => $it['price_range'] ?? null,
                            'rating_estimate' => $it['rating_estimate'] ?? null,
                            'region_hint' => $it['region_hint'] ?? null,
                            'where_to_find' => array_values(array_filter((array)($it['where_to_find'] ?? []))),
                            'tags' => array_values(array_filter((array)($it['tags'] ?? []))),
                            'category' => $it['category'] ?? null,
                            'image_url' => $imageUrl,
                            'sources' => $sources,
                            'wiki_url' => $wikiUrl,
                            'wiki_summary' => $summary,
                        ];
                    }

                    $payload = [
                        'island_slug' => $regionSlug,
                        'tribe_key' => $tribeKey,
                        'week_key' => $weekKey,
                        'generated_at' => $now->toISOString(),
                        'items' => array_slice($finalItems, 0, 10),
                    ];

                    TribeFoodRecommendation::updateOrCreate(
                        ['tribe_key' => $tribeKey, 'week_key' => $weekKey],
                        [
                            'region_slug' => $regionSlug,
                            'payload' => $payload,
                            'generated_at' => $now,
                        ]
                    );

                    sleep(2);
                } catch (\Exception $e) {
                    logger()->warning("Gagal membuat rekomendasi makanan untuk suku {$tribeKey}: " . $e->getMessage());
                }
            }
        }
    }
}

<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class WikiImageResolverService
{
    private array $fallbackImages = [
        'https://images.unsplash.com/photo-1540189549336-e6e99c3679fe?auto=format&fit=crop&q=80&w=800',
        'https://images.unsplash.com/photo-1569718212165-3a8278d5f624?auto=format&fit=crop&q=80&w=800',
        'https://images.unsplash.com/photo-1604382354936-07c5d9983bd3?auto=format&fit=crop&q=80&w=800',
        'https://images.unsplash.com/photo-1546069901-ba9599a7e63c?auto=format&fit=crop&q=80&w=800',
        'https://images.unsplash.com/photo-1603133872878-684f208fb84b?auto=format&fit=crop&q=80&w=800',
        'https://images.unsplash.com/photo-1534422298391-e4f8c172dddb?auto=format&fit=crop&q=80&w=800',
        'https://images.unsplash.com/photo-1555939594-58d7cb561ad1?auto=format&fit=crop&q=80&w=800',
        'https://images.unsplash.com/photo-1598515214211-89d3c73ae83b?auto=format&fit=crop&q=80&w=800',
        'https://images.unsplash.com/photo-1512621776951-a57141f2eefd?auto=format&fit=crop&q=80&w=800',
        'https://images.unsplash.com/photo-1544025162-d76694265947?auto=format&fit=crop&q=80&w=800',
    ];

    public function resolve(string $foodName, string $tribeKey = ''): array
    {
        $foodName = trim($foodName);
        $tribeKey = trim($tribeKey);

        if ($foodName === '') {
            return $this->fallback($foodName);
        }

        $searchVariants = array_values(array_unique(array_filter([
            $foodName,
            ($tribeKey !== '' ? ($foodName . ' ' . $tribeKey) : null),
            str_replace(['–', '—'], '-', $foodName),
        ])));

        foreach ($searchVariants as $q) {
            $data = $this->queryWikipedia($q);
            if ($data !== null) {
                return $data;
            }
        }

        return $this->fallback($foodName);
    }

    private function queryWikipedia(string $query): ?array
    {
        $query = trim($query);
        if ($query === '') return null;

        $search = Http::withOptions(['verify' => false])
            ->timeout(15)
            ->withHeaders([
                'Accept' => 'application/json',
                'User-Agent' => 'LentaraPiforrr/1.0 (contact: admin@localhost)',
            ])
            ->get("https://id.wikipedia.org/w/api.php", [
                'action'   => 'query',
                'list'     => 'search',
                'srsearch' => $query,
                'srlimit'  => 1,
                'format'   => 'json',
            ]);

        if (!$search->ok()) return null;

        $searchJson = $search->json();
        $pageId = data_get($searchJson, 'query.search.0.pageid');

        if (!$pageId) {
            return null;
        }

        $detail = Http::withOptions(['verify' => false])
            ->timeout(15)
            ->withHeaders([
                'Accept' => 'application/json',
                'User-Agent' => 'LentaraPiforrr/1.0 (contact: admin@localhost)',
            ])
            ->get("https://id.wikipedia.org/w/api.php", [
                'action'        => 'query',
                'pageids'       => $pageId,
                'prop'          => 'extracts|pageimages|info',
                'exintro'       => 1,
                'explaintext'   => 1,
                'inprop'        => 'url',
                'redirects'     => 1,
                'pithumbsize'   => 900,
                'format'        => 'json',
            ]);

        if (!$detail->ok()) return null;

        $json = $detail->json();
        $page = data_get($json, "query.pages.$pageId");

        if (!is_array($page)) return null;

        $fullUrl  = data_get($page, 'fullurl');
        $extract  = data_get($page, 'extract');
        $thumb    = data_get($page, 'thumbnail.source');

        $wikiUrl = is_string($fullUrl) && trim($fullUrl) !== '' ? trim($fullUrl) : null;
        $summary = is_string($extract) && trim($extract) !== '' ? trim($extract) : null;
        $imageUrl = is_string($thumb) && trim($thumb) !== '' ? trim($thumb) : null;

        if ($wikiUrl || $summary || $imageUrl) {
            return [
                'image_url'     => $imageUrl ?: $this->getDynamicFallback($query),
                'sources'       => $wikiUrl ? [$wikiUrl] : [],
                'wiki_url'      => $wikiUrl,
                'wiki_summary'  => $summary,
            ];
        }

        return null;
    }

    private function fallback(string $foodName = ''): array
    {
        return [
            'image_url'    => $this->getDynamicFallback($foodName),
            'sources'      => ['https://id.wikipedia.org/'],
            'wiki_url'     => null,
            'wiki_summary' => null,
        ];
    }

    private function getDynamicFallback(string $foodName): string
    {
        $hash = abs(crc32($foodName));
        $index = $hash % count($this->fallbackImages);
        return $this->fallbackImages[$index];
    }
}

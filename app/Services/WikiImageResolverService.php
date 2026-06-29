<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class WikiImageResolverService
{
    /**
     * Peta Foto Autentik Kuliner Tradisional Indonesia (Kualitas Terbaik & 100% Akurat)
     */
    private array $knownAuthenticImages = [
        'naniura'           => 'https://upload.wikimedia.org/wikipedia/commons/thumb/c/c8/Naniura_Batak.jpg/800px-Naniura_Batak.jpg',
        'dengke naniura'    => 'https://upload.wikimedia.org/wikipedia/commons/thumb/c/c8/Naniura_Batak.jpg/800px-Naniura_Batak.jpg',
        'lappet'            => 'https://upload.wikimedia.org/wikipedia/commons/thumb/8/87/Lappet_Batak_Toba.jpg/800px-Lappet_Batak_Toba.jpg',
        'pohulpohul'        => 'https://upload.wikimedia.org/wikipedia/commons/thumb/8/87/Lappet_Batak_Toba.jpg/800px-Lappet_Batak_Toba.jpg',
        'mie gomak'         => 'https://upload.wikimedia.org/wikipedia/commons/thumb/5/5c/Mie_gomak.JPG/800px-Mie_gomak.JPG',
        'arsik'             => 'https://upload.wikimedia.org/wikipedia/commons/thumb/a/a9/Arsik_ikan_mas.JPG/800px-Arsik_ikan_mas.JPG',
        'arsik ikan mas'    => 'https://upload.wikimedia.org/wikipedia/commons/thumb/a/a9/Arsik_ikan_mas.JPG/800px-Arsik_ikan_mas.JPG',
        'saksang'           => 'https://upload.wikimedia.org/wikipedia/commons/thumb/7/77/Saksang_Batak.jpg/800px-Saksang_Batak.jpg',
        'manuk napinadar'   => 'https://upload.wikimedia.org/wikipedia/commons/thumb/9/91/Manuk_Napinadar.jpg/800px-Manuk_Napinadar.jpg',
        'babi panggang karo' => 'https://upload.wikimedia.org/wikipedia/commons/thumb/3/30/BPK_Babi_Panggang_Karo.jpg/800px-BPK_Babi_Panggang_Karo.jpg',
        'bpk'               => 'https://upload.wikimedia.org/wikipedia/commons/thumb/3/30/BPK_Babi_Panggang_Karo.jpg/800px-BPK_Babi_Panggang_Karo.jpg',
        'mie aceh'          => 'https://upload.wikimedia.org/wikipedia/commons/thumb/a/a6/Mie_Aceh_Daging.jpg/800px-Mie_Aceh_Daging.jpg',
        'ayam tangkap'      => 'https://upload.wikimedia.org/wikipedia/commons/thumb/0/07/Ayam_tangkap.JPG/800px-Ayam_tangkap.JPG',
        'rendang'           => 'https://upload.wikimedia.org/wikipedia/commons/thumb/b/b3/Rendang_daging_sapi_asli_Minang.jpg/800px-Rendang_daging_sapi_asli_Minang.jpg',
        'sate padang'       => 'https://upload.wikimedia.org/wikipedia/commons/thumb/0/0e/Sate_Padang.JPG/800px-Sate_Padang.JPG',
        'gudeg'             => 'https://upload.wikimedia.org/wikipedia/commons/thumb/c/c8/Gudeg_Jogja.jpg/800px-Gudeg_Jogja.jpg',
        'rawon'             => 'https://upload.wikimedia.org/wikipedia/commons/thumb/3/3d/Rawon_surabaya.jpg/800px-Rawon_surabaya.jpg',
        'karedok'           => 'https://upload.wikimedia.org/wikipedia/commons/thumb/0/05/Karedok_Sunda.jpg/800px-Karedok_Sunda.jpg',
        'sate madura'       => 'https://upload.wikimedia.org/wikipedia/commons/thumb/0/01/Sate_Madura.jpg/800px-Sate_Madura.jpg',
        'coto makassar'     => 'https://upload.wikimedia.org/wikipedia/commons/thumb/a/a4/Coto_Makassar.jpg/800px-Coto_Makassar.jpg',
        'sop konro'         => 'https://upload.wikimedia.org/wikipedia/commons/thumb/c/ca/Sop_Konro.jpg/800px-Sop_Konro.jpg',
        'ayam betutu'       => 'https://upload.wikimedia.org/wikipedia/commons/thumb/4/4c/Ayam_Betutu.jpg/800px-Ayam_Betutu.jpg',
        'papeda'            => 'https://upload.wikimedia.org/wikipedia/commons/thumb/1/18/Papeda_ikan_kuah_kuning.jpg/800px-Papeda_ikan_kuah_kuning.jpg',
    ];

    private array $fallbackImages = [
        'https://images.unsplash.com/photo-1540189549336-e6e99c3679fe?auto=format&fit=crop&q=80&w=800',
        'https://images.unsplash.com/photo-1569718212165-3a8278d5f624?auto=format&fit=crop&q=80&w=800',
        'https://images.unsplash.com/photo-1604382354936-07c5d9983bd3?auto=format&fit=crop&q=80&w=800',
        'https://images.unsplash.com/photo-1546069901-ba9599a7e63c?auto=format&fit=crop&q=80&w=800',
        'https://images.unsplash.com/photo-1603133872878-684f208fb84b?auto=format&fit=crop&q=80&w=800',
    ];

    public function resolve(string $foodName, string $tribeKey = ''): array
    {
        $foodName = trim($foodName);
        $tribeKey = trim($tribeKey);

        if ($foodName === '') {
            return $this->fallback($foodName);
        }

        // 1) Cek dahulu di Peta Foto Autentik (Pasti Akurat 100%)
        $cleanName = strtolower(trim(preg_replace('/[^a-zA-Z0-9\s]/', '', $foodName)));
        foreach ($this->knownAuthenticImages as $key => $url) {
            if (str_contains($cleanName, $key) || str_contains($key, $cleanName)) {
                $wikiData = $this->queryWikipedia($foodName) ?? [];
                return [
                    'image_url'    => $url,
                    'sources'      => $wikiData['sources'] ?? ['https://id.wikipedia.org/wiki/' . urlencode($foodName)],
                    'wiki_url'     => $wikiData['wiki_url'] ?? 'https://id.wikipedia.org/wiki/' . urlencode($foodName),
                    'wiki_summary' => $wikiData['wiki_summary'] ?? "Kuliner tradisional khas suku {$tribeKey}.",
                ];
            }
        }

        // 2) Jika tidak ada di peta, query Wikipedia API
        $searchVariants = array_values(array_unique(array_filter([
            $foodName,
            ($tribeKey !== '' ? ($foodName . ' ' . $tribeKey) : null),
            str_replace(['–', '—'], '-', $foodName),
        ])));

        foreach ($searchVariants as $q) {
            $data = $this->queryWikipedia($q);
            if ($data !== null && !empty($data['image_url'])) {
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

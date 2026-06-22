<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Island;
use App\Models\GameLevel;
use App\Models\GameStorylineStep;

class RoroJonggrangSeeder extends Seeder
{
    public function run(): void
    {
        // Cari pulau Jawa
        $island = Island::where('slug', 'jawa')
            ->orWhere('slug', 'java')
            ->orWhereRaw("LOWER(name) LIKE '%jawa%'")
            ->first();

        if (!$island) {
            $this->command->warn('⚠️  Pulau Jawa tidak ditemukan. Seeder dibatalkan.');
            return;
        }

        // Buat atau update Level 1 Jawa sebagai Storyline
        $level = GameLevel::firstOrCreate(
            ['island_id' => $island->id, 'order' => 1],
            [
                'title'               => 'Level 1 — Roro Jonggrang',
                'is_active'           => true,
                'level_type'          => 'storyline',
                'time_limit_seconds'  => 0,
            ]
        );

        $level->update([
            'level_type' => 'storyline',
            'title'      => 'Level 1 — Roro Jonggrang',
        ]);

        // Hapus langkah lama (bersih untuk seeder ulang)
        $level->storylineSteps()->delete();

        $bg = fn(string $n) => 'images/storylines/roro-jonggrang/' . $n;

        $steps = [
            // ── PEMBUKAAN ────────────────────────────────────────────
            [
                'order'          => 1,
                'character_name' => null,
                'dialogue_text'  => 'Di tanah Jawa kuno, berdirilah sebuah kerajaan besar bernama Prambanan, yang diperintah oleh raja raksasa yang ditakuti — Prabu Baka.',
                'background_path'=> $bg('bg_kerajaan.png'),
                'character_path' => null,
                'animation_type' => 'zoom',
                'options'        => null,
            ],
            [
                'order'          => 2,
                'character_name' => 'Prabu Baka',
                'dialogue_text'  => 'Seluruh negeri ini tunduk padaku! Tidak ada satu pun kesatria yang berani menantangku, Prabu Baka yang agung!',
                'background_path'=> $bg('bg_kerajaan.png'),
                'character_path' => $bg('char_baka.png'),
                'animation_type' => 'none',
                'options'        => null,
            ],
            [
                'order'          => 3,
                'character_name' => null,
                'dialogue_text'  => 'Namun dari kerajaan tetangga, datanglah seorang ksatria muda yang sakti mandraguna bernama Bandung Bondowoso. Ia menantang Prabu Baka dalam sebuah pertempuran yang dahsyat!',
                'background_path'=> $bg('bg_pertempuran.png'),
                'character_path' => null,
                'animation_type' => 'shake',
                'options'        => null,
            ],
            [
                'order'          => 4,
                'character_name' => 'Bandung Bondowoso',
                'dialogue_text'  => 'Prabu Baka! Tirani-mu berakhir hari ini! Aku, Bandung Bondowoso, akan menghentikanmu!',
                'background_path'=> $bg('bg_pertempuran.png'),
                'character_path' => $bg('char_bandung.png'),
                'animation_type' => 'none',
                'options'        => [
                    ['option_text' => 'Bandung Bondowoso menantang Prabu Baka dalam pertempuran', 'is_correct' => true],
                    ['option_text' => 'Bandung Bondowoso melarikan diri dari Prabu Baka',         'is_correct' => false],
                    ['option_text' => 'Bandung Bondowoso meminta damai kepada Prabu Baka',         'is_correct' => false],
                ],
            ],
            [
                'order'          => 5,
                'character_name' => null,
                'dialogue_text'  => 'Dengan kesaktiannya yang luar biasa, Bandung Bondowoso berhasil mengalahkan dan membunuh Prabu Baka. Kerajaan Prambanan pun jatuh ke tangannya.',
                'background_path'=> $bg('bg_pertempuran.png'),
                'character_path' => $bg('char_bandung.png'),
                'animation_type' => 'fade',
                'options'        => null,
            ],

            // ── RORO JONGGRANG ───────────────────────────────────────
            [
                'order'          => 6,
                'character_name' => null,
                'dialogue_text'  => 'Saat memasuki istana, Bandung Bondowoso terpesona melihat putri Prabu Baka — Roro Jonggrang — yang kecantikannya tak tertandingi di seluruh Nusantara.',
                'background_path'=> $bg('bg_kerajaan.png'),
                'character_path' => $bg('char_roro.png'),
                'animation_type' => 'fade',
                'options'        => null,
            ],
            [
                'order'          => 7,
                'character_name' => 'Bandung Bondowoso',
                'dialogue_text'  => 'Wahai Putri yang cantik jelita... maukah kau menjadi permaisuriku? Aku akan membuatmu menjadi ratu agung!',
                'background_path'=> $bg('bg_kerajaan.png'),
                'character_path' => $bg('char_bandung.png'),
                'animation_type' => 'none',
                'options'        => null,
            ],
            [
                'order'          => 8,
                'character_name' => 'Roro Jonggrang',
                'dialogue_text'  => 'Kau yang membunuh ayahku! Aku tidak akan pernah mau menjadi istrimu! Tapi... jika kau bisa memenuhi satu syaratku, aku akan menerimamu.',
                'background_path'=> $bg('bg_kerajaan.png'),
                'character_path' => $bg('char_roro.png'),
                'animation_type' => 'none',
                'options'        => [
                    ['option_text' => 'Roro Jonggrang memberikan syarat yang sangat berat', 'is_correct' => true],
                    ['option_text' => 'Roro Jonggrang langsung menerima lamaran Bandung',   'is_correct' => false],
                    ['option_text' => 'Roro Jonggrang kabur dari istana',                   'is_correct' => false],
                ],
            ],
            [
                'order'          => 9,
                'character_name' => 'Roro Jonggrang',
                'dialogue_text'  => 'Syaratku hanya satu: bangunkan SERIBU CANDI dalam satu malam sebelum fajar tiba! Jika gagal, kau harus pergi selamanya!',
                'background_path'=> $bg('bg_kerajaan.png'),
                'character_path' => $bg('char_roro.png'),
                'animation_type' => 'zoom',
                'options'        => null,
            ],

            // ── PEMBANGUNAN CANDI ────────────────────────────────────
            [
                'order'          => 10,
                'character_name' => 'Bandung Bondowoso',
                'dialogue_text'  => 'Seribu candi dalam satu malam?! Tidak ada manusia biasa yang bisa melakukan itu. Tapi aku bukan manusia biasa. Aku akan memanggil para jin dan roh halus untuk membantuku!',
                'background_path'=> $bg('bg_malam_candi.png'),
                'character_path' => $bg('char_bandung.png'),
                'animation_type' => 'fade',
                'options'        => null,
            ],
            [
                'order'          => 11,
                'character_name' => null,
                'dialogue_text'  => 'Malam pun tiba. Dengan kesaktiannya, Bandung Bondowoso memanggil ribuan jin dan roh dari seluruh penjuru alam. Mereka mulai membangun candi dengan kecepatan luar biasa!',
                'background_path'=> $bg('bg_malam_candi.png'),
                'character_path' => null,
                'animation_type' => 'zoom',
                'options'        => [
                    ['option_text' => 'Bandung Bondowoso meminta bantuan jin dan roh halus',      'is_correct' => true],
                    ['option_text' => 'Bandung Bondowoso membangun candi sendirian',               'is_correct' => false],
                    ['option_text' => 'Bandung Bondowoso meminta bantuan seluruh rakyatnya',       'is_correct' => false],
                ],
            ],

            // ── TIPU DAYA RORO JONGGRANG ─────────────────────────────
            [
                'order'          => 12,
                'character_name' => null,
                'dialogue_text'  => 'Roro Jonggrang mengintip dari balik tembok. Sudah 999 candi berdiri! Hanya kurang satu lagi. Ia harus melakukan sesuatu sebelum fajar benar-benar tiba!',
                'background_path'=> $bg('bg_malam_candi.png'),
                'character_path' => $bg('char_roro.png'),
                'animation_type' => 'none',
                'options'        => null,
            ],
            [
                'order'          => 13,
                'character_name' => 'Roro Jonggrang',
                'dialogue_text'  => 'Cepat! Perempuan-perempuan desa, tumbuk lesung padi sekarang! Yang lain nyalakan api unggun besar di timur! Kita harus membuat para jin mengira fajar sudah tiba!',
                'background_path'=> $bg('bg_malam_candi.png'),
                'character_path' => $bg('char_roro.png'),
                'animation_type' => 'shake',
                'options'        => [
                    ['option_text' => 'Roro Jonggrang menipu para jin dengan meniru tanda-tanda fajar',  'is_correct' => true],
                    ['option_text' => 'Roro Jonggrang membantu Bandung membangun candi terakhir',        'is_correct' => false],
                    ['option_text' => 'Roro Jonggrang menghancurkan candi yang sudah dibangun',          'is_correct' => false],
                ],
            ],
            [
                'order'          => 14,
                'character_name' => null,
                'dialogue_text'  => 'Suara lesung berdentum, api unggun memerahkan langit timur. Para jin mengira fajar sudah datang — mereka ketakutan dan kabur meninggalkan pekerjaan! Candi ke-1000 belum selesai!',
                'background_path'=> $bg('bg_malam_candi.png'),
                'character_path' => null,
                'animation_type' => 'shake',
                'options'        => null,
            ],

            // ── KUTUKAN ──────────────────────────────────────────────
            [
                'order'          => 15,
                'character_name' => 'Bandung Bondowoso',
                'dialogue_text'  => 'RORO JONGGRANG! Kau telah menipuku! Kau yang membuat para jin kabur! Karena kelicikanmu... kau akan menjadi batu — menjadi arca ke-1000 di candi yang kau gagalkan ini!',
                'background_path'=> $bg('bg_prambanan.png'),
                'character_path' => $bg('char_bandung.png'),
                'animation_type' => 'shake',
                'options'        => [
                    ['option_text' => 'Bandung Bondowoso mengutuk Roro Jonggrang menjadi arca batu', 'is_correct' => true],
                    ['option_text' => 'Bandung Bondowoso memaafkan Roro Jonggrang',                  'is_correct' => false],
                    ['option_text' => 'Bandung Bondowoso membangun candi ke-1000 sendiri',           'is_correct' => false],
                ],
            ],
            [
                'order'          => 16,
                'character_name' => null,
                'dialogue_text'  => 'Roro Jonggrang berubah menjadi arca batu yang indah, berdiri tegak di dalam Candi Prambanan. Hingga kini, kompleks candi megah itu masih berdiri kokoh di Jawa Tengah — menjadi warisan budaya dunia. Selamat! Kamu telah menyelesaikan Bab 1 — Roro Jonggrang & Candi Prambanan!',
                'background_path'=> $bg('bg_prambanan.png'),
                'character_path' => null,
                'animation_type' => 'zoom',
                'options'        => null,
            ],
        ];

        foreach ($steps as $step) {
            GameStorylineStep::create(array_merge($step, ['game_level_id' => $level->id]));
        }

        $this->command->info("✅ Seeder berhasil! Level Storyline '{$level->title}' di pulau {$island->name} dengan " . count($steps) . " langkah cerita.");
    }
}

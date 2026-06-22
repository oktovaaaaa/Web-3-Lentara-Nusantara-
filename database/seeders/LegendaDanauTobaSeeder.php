<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Island;
use App\Models\GameLevel;
use App\Models\GameStorylineStep;

class LegendaDanauTobaSeeder extends Seeder
{
    public function run(): void
    {
        // Cari pulau Sumatera
        $island = Island::where('slug', 'sumatera')
            ->orWhere('slug', 'sumatra')
            ->orWhereRaw("LOWER(name) LIKE '%sumatera%'")
            ->orWhereRaw("LOWER(name) LIKE '%sumatra%'")
            ->first();

        if (!$island) {
            $this->command->warn('Pulau Sumatera tidak ditemukan. Seeder dibatalkan.');
            return;
        }

        // Buat atau update Level 1 Sumatera sebagai Storyline
        $level = GameLevel::firstOrCreate(
            ['island_id' => $island->id, 'order' => 1],
            [
                'title'      => 'Level 1 — Legenda Danau Toba',
                'is_active'  => true,
                'level_type' => 'storyline',
                'time_limit_seconds' => 0,
            ]
        );

        // Pastikan level_type di-set ke storyline
        $level->update(['level_type' => 'storyline', 'title' => 'Level 1 — Legenda Danau Toba']);

        // Hapus langkah lama jika ada (untuk seeder ulang yang bersih)
        $level->storylineSteps()->delete();

        $bg = fn(string $name) => 'images/storylines/toba/' . $name;

        // Langkah-langkah cerita
        $steps = [
            [
                'order'          => 1,
                'character_name' => null,
                'dialogue_text'  => 'Dahulu kala, di lembah hijau yang subur di tanah Sumatera, hiduplah seorang pemuda bernama Toba...',
                'background_path'=> $bg('bg_valley.png'),
                'character_path' => null,
                'animation_type' => 'zoom',
                'options'        => null,
            ],
            [
                'order'          => 2,
                'character_name' => 'Toba',
                'dialogue_text'  => 'Hidup sebagai petani memang berat, tapi aku bersyukur. Sungai ini selalu memberi ikan untuk makanku sehari-hari.',
                'background_path'=> $bg('bg_valley.png'),
                'character_path' => 'images/storylines/toba/char_toba.png',
                'animation_type' => 'fade',
                'options'        => null,
            ],
            [
                'order'          => 3,
                'character_name' => null,
                'dialogue_text'  => 'Suatu hari, Toba melempar jalanya ke sungai... dan menangkap seekor ikan mas yang sangat besar dan berkilauan!',
                'background_path'=> $bg('bg_valley.png'),
                'character_path' => 'images/storylines/toba/char_toba.png',
                'animation_type' => 'none',
                'options'        => null,
            ],
            [
                'order'          => 4,
                'character_name' => 'Toba',
                'dialogue_text'  => 'Ikan sebesar ini... belum pernah aku tangkap seumur hidupku! Aku mau membawanya pulang.',
                'background_path'=> $bg('bg_valley.png'),
                'character_path' => 'images/storylines/toba/char_toba.png',
                'animation_type' => 'none',
                'options'        => [
                    ['option_text' => 'Masak dan makan ikan itu sendirian', 'is_correct' => false],
                    ['option_text' => 'Membawa ikan pulang ke rumah', 'is_correct' => true],
                    ['option_text' => 'Melepaskan ikan ke sungai kembali', 'is_correct' => false],
                ],
            ],
            [
                'order'          => 5,
                'character_name' => null,
                'dialogue_text'  => 'Setibanya di rumah, terjadi keajaiban! Ikan emas itu berubah wujud menjadi seorang putri cantik jelita yang memancarkan cahaya keemasan...',
                'background_path'=> $bg('bg_cottage.png'),
                'character_path' => null,
                'animation_type' => 'zoom',
                'options'        => null,
            ],
            [
                'order'          => 6,
                'character_name' => 'Putri',
                'dialogue_text'  => 'Jangan takut, wahai pemuda baik hati. Aku adalah putri dari kerajaan ikan di sungai. Kau telah menyelamatkanku. Ijinkan aku tinggal di sini bersamamu.',
                'background_path'=> $bg('bg_cottage.png'),
                'character_path' => 'images/storylines/toba/char_putri.png',
                'animation_type' => 'fade',
                'options'        => null,
            ],
            [
                'order'          => 7,
                'character_name' => 'Toba',
                'dialogue_text'  => 'Tentu saja! Tapi aku mohon satu hal... jangan pernah ceritakan kepada siapapun bahwa kau dulunya adalah seekor ikan.',
                'background_path'=> $bg('bg_cottage.png'),
                'character_path' => 'images/storylines/toba/char_toba.png',
                'animation_type' => 'none',
                'options'        => [
                    ['option_text' => 'Putri setuju dan berjanji merahasiakannya', 'is_correct' => true],
                    ['option_text' => 'Putri menolak syarat Toba', 'is_correct' => false],
                    ['option_text' => 'Putri langsung bercerita ke tetangga', 'is_correct' => false],
                ],
            ],
            [
                'order'          => 8,
                'character_name' => null,
                'dialogue_text'  => 'Toba dan sang putri pun menikah. Mereka hidup bahagia dan dikaruniai seorang anak laki-laki yang nakal bernama Samosir.',
                'background_path'=> $bg('bg_cottage.png'),
                'character_path' => null,
                'animation_type' => 'fade',
                'options'        => null,
            ],
            [
                'order'          => 9,
                'character_name' => 'Samosir',
                'dialogue_text'  => 'Hehe! Aku Samosir! Aku lapar! Aku mau makanan Ayah! *merebut bekal makan siang Toba*',
                'background_path'=> $bg('bg_valley.png'),
                'character_path' => 'images/storylines/toba/char_samosir.png',
                'animation_type' => 'none',
                'options'        => null,
            ],
            [
                'order'          => 10,
                'character_name' => null,
                'dialogue_text'  => 'Toba yang kelelahan bekerja di sawah mendapati bekal makannya habis dimakan Samosir. Amarah Toba memuncak!',
                'background_path'=> $bg('bg_valley.png'),
                'character_path' => 'images/storylines/toba/char_toba.png',
                'animation_type' => 'shake',
                'options'        => null,
            ],
            [
                'order'          => 11,
                'character_name' => 'Toba',
                'dialogue_text'  => 'SAMOSIR! Dasar anak nakal! Kamu persis seperti ibumu — ANAK IKAN!',
                'background_path'=> $bg('bg_valley.png'),
                'character_path' => 'images/storylines/toba/char_toba.png',
                'animation_type' => 'shake',
                'options'        => [
                    ['option_text' => 'Ucapan Toba melanggar janji kepada istrinya', 'is_correct' => true],
                    ['option_text' => 'Ucapan Toba tidak bermasalah karena sudah lama', 'is_correct' => false],
                    ['option_text' => 'Samosir yang salah, bukan Toba', 'is_correct' => false],
                ],
            ],
            [
                'order'          => 12,
                'character_name' => 'Putri',
                'dialogue_text'  => 'Toba... kau telah mengingkari janjimu. Kini aku harus kembali ke asalku. Samosir, larilah kamu ke bukit tertinggi sekarang!',
                'background_path'=> $bg('bg_cottage.png'),
                'character_path' => 'images/storylines/toba/char_putri.png',
                'animation_type' => 'fade',
                'options'        => null,
            ],
            [
                'order'          => 13,
                'character_name' => null,
                'dialogue_text'  => 'Sang putri menghilang. Langit mendadak gelap gulita. Hujan deras mengguyur tanpa henti. Tanah terbelah dan air memancar dari dalam bumi!',
                'background_path'=> $bg('bg_storm.png'),
                'character_path' => null,
                'animation_type' => 'shake',
                'options'        => null,
            ],
            [
                'order'          => 14,
                'character_name' => null,
                'dialogue_text'  => 'Lembah tempat Toba tinggal perlahan terendam banjir yang semakin dalam dan dalam... hingga terbentuklah sebuah danau raksasa yang indah.',
                'background_path'=> $bg('bg_lake.png'),
                'character_path' => null,
                'animation_type' => 'zoom',
                'options'        => null,
            ],
            [
                'order'          => 15,
                'character_name' => null,
                'dialogue_text'  => 'Danau itu kemudian dikenal dengan nama... DANAU TOBA. Dan bukit tempat Samosir berlari selamat menjadi sebuah pulau di tengah danau, bernama Pulau Samosir.',
                'background_path'=> $bg('bg_lake.png'),
                'character_path' => null,
                'animation_type' => 'zoom',
                'options'        => [
                    ['option_text' => 'Pelanggaran janji Toba menyebabkan terbentuknya Danau Toba', 'is_correct' => true],
                    ['option_text' => 'Danau Toba terbentuk karena banjir biasa', 'is_correct' => false],
                    ['option_text' => 'Samosir yang menciptakan danau itu', 'is_correct' => false],
                ],
            ],
            [
                'order'          => 16,
                'character_name' => null,
                'dialogue_text'  => 'Legenda Danau Toba mengajarkan kita untuk selalu menepati janji dan menjaga kepercayaan orang-orang yang kita cintai. Selamat! Kamu telah menyelesaikan Bab 1 — Legenda Danau Toba!',
                'background_path'=> $bg('bg_lake.png'),
                'character_path' => null,
                'animation_type' => 'fade',
                'options'        => null,
            ],
        ];

        foreach ($steps as $step) {
            GameStorylineStep::create(array_merge($step, ['game_level_id' => $level->id]));
        }

        $this->command->info("✅ Seeder berhasil! Level Storyline '{$level->title}' di pulau {$island->name} dengan " . count($steps) . " langkah cerita.");
    }
}

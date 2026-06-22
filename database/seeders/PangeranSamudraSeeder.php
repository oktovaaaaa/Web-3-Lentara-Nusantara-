<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Island;
use App\Models\GameLevel;
use App\Models\GameStorylineStep;

class PangeranSamudraSeeder extends Seeder
{
    public function run(): void
    {
        // Cari pulau Kalimantan
        $island = Island::where('slug', 'kalimantan')
            ->orWhereRaw("LOWER(name) LIKE '%kalimantan%'")
            ->first();

        if (!$island) {
            $this->command->warn('⚠️ Pulau Kalimantan tidak ditemukan. Seeder dibatalkan.');
            return;
        }

        // Buat atau update Level 1 Kalimantan sebagai Storyline
        $level = GameLevel::firstOrCreate(
            ['island_id' => $island->id, 'order' => 1],
            [
                'title'      => 'Level 1 — Pangeran Samudra',
                'is_active'  => true,
                'level_type' => 'storyline',
                'time_limit_seconds' => 0,
            ]
        );

        $level->update([
            'level_type' => 'storyline',
            'title'      => 'Level 1 — Pangeran Samudra',
        ]);

        // Hapus langkah lama jika ada
        $level->storylineSteps()->delete();

        $bg = fn(string $name) => 'images/storylines/pangeran-samudra/' . $name;

        $steps = [
            [
                'order'          => 1,
                'character_name' => null,
                'dialogue_text'  => 'Di pedalaman Kalimantan Selatan pada abad ke-16, berdirilah Kerajaan Daha yang makmur. Pangeran Samudra adalah putra mahkota yang sah, pewaris takhta Daha.',
                'background_path'=> $bg('bg_kerajaan.png'),
                'character_path' => null,
                'animation_type' => 'zoom',
                'options'        => null,
            ],
            [
                'order'          => 2,
                'character_name' => 'Pangeran Tumenggung',
                'dialogue_text'  => 'Kerajaan ini harus menjadi milikku! Keponakanku, Samudra, terlalu lemah untuk memimpin Daha! Singkirkan dia dari takhta ini!',
                'background_path'=> $bg('bg_kerajaan.png'),
                'character_path' => $bg('char_tumenggung.png'),
                'animation_type' => 'none',
                'options'        => null,
            ],
            [
                'order'          => 3,
                'character_name' => 'Pangeran Samudra',
                'dialogue_text'  => 'Pamanku, Pangeran Tumenggung, telah merebut takhta Daha dan mengincar nyawaku. Apa yang harus aku lakukan untuk menyelamatkan takhta Daha yang sah?',
                'background_path'=> $bg('bg_kerajaan.png'),
                'character_path' => $bg('char_samudra.png'),
                'animation_type' => 'none',
                'options'        => [
                    ['option_text' => 'Melarikan diri secara diam-diam demi keselamatan dan menyusun rencana', 'is_correct' => true],
                    ['option_text' => 'Menyerang Pangeran Tumenggung langsung tanpa prajurit pendukung', 'is_correct' => false],
                    ['option_text' => 'Menyerahkan takhta Daha secara sukarela dan bersedia dihukum mati', 'is_correct' => false],
                ],
            ],
            [
                'order'          => 4,
                'character_name' => null,
                'dialogue_text'  => 'Pangeran Samudra memutuskan melarikan diri demi masa depan Daha. Ia menyusuri aliran Sungai Barito yang luas dan lebat dengan hutan belantara Kalimantan.',
                'background_path'=> $bg('bg_sungai.png'),
                'character_path' => null,
                'animation_type' => 'zoom',
                'options'        => null,
            ],
            [
                'order'          => 5,
                'character_name' => 'Pangeran Samudra',
                'dialogue_text'  => 'Mata-mata Pangeran Tumenggung tersebar di mana-mana. Aku harus menanggalkan jubah kebangsawananku ini agar tidak ada yang mengenalku.',
                'background_path'=> $bg('bg_sungai.png'),
                'character_path' => $bg('char_samudra.png'),
                'animation_type' => 'fade',
                'options'        => null,
            ],
            [
                'order'          => 6,
                'character_name' => 'Pangeran Samudra',
                'dialogue_text'  => 'Bagaimana cara terbaik agar aku bisa menyamar dengan aman di sepanjang Sungai Barito ini?',
                'background_path'=> $bg('bg_sungai.png'),
                'character_path' => $bg('char_samudra.png'),
                'animation_type' => 'none',
                'options'        => [
                    ['option_text' => 'Menyamar sebagai nelayan miskin yang mencari ikan', 'is_correct' => true],
                    ['option_text' => 'Tetap memakai mahkota emas Daha agar dikenal rakyat', 'is_correct' => false],
                    ['option_text' => 'Menyamar sebagai prajurit utusan Pangeran Tumenggung', 'is_correct' => false],
                ],
            ],
            [
                'order'          => 7,
                'character_name' => null,
                'dialogue_text'  => 'Dengan menyamar sebagai nelayan, Pangeran Samudra hanyut hingga ke muara Sungai Barito yang dihuni oleh masyarakat suku Banjar dan suku Dayak.',
                'background_path'=> $bg('bg_muara.png'),
                'character_path' => null,
                'animation_type' => 'fade',
                'options'        => null,
            ],
            [
                'order'          => 8,
                'character_name' => 'Patih Masih',
                'dialogue_text'  => 'Hei, anak muda! Aku adalah Patih Masih, kepala suku dan bandar di muara Barito ini. Aku melihat sorot mata kesatria di wajahmu yang lelah. Siapakah dirimu sebenarnya?',
                'background_path'=> $bg('bg_muara.png'),
                'character_path' => $bg('char_patih.png'),
                'animation_type' => 'fade',
                'options'        => null,
            ],
            [
                'order'          => 9,
                'character_name' => 'Pangeran Samudra',
                'dialogue_text'  => 'Patih Masih bertanya tentang asal-usulku. Haruskah aku mempercayainya dan menceritakan kebenaran pelarianku dari Kerajaan Daha?',
                'background_path'=> $bg('bg_muara.png'),
                'character_path' => $bg('char_samudra.png'),
                'animation_type' => 'none',
                'options'        => [
                    ['option_text' => 'Jujur menceritakan identitasku sebagai pewaris sah Daha yang melarikan diri', 'is_correct' => true],
                    ['option_text' => 'Berdusta bahwa aku adalah perampok sungai yang sedang dikejar warga', 'is_correct' => false],
                    ['option_text' => 'Melarikan diri kembali ke dalam hutan karena takut tertangkap', 'is_correct' => false],
                ],
            ],
            [
                'order'          => 10,
                'character_name' => 'Patih Masih',
                'dialogue_text'  => 'Hormat hamba, Pangeran! Kekejaman Pangeran Tumenggung sudah tidak bisa ditoleransi. Kami, masyarakat Banjar dan Dayak di muara ini, siap bersekutu melindungimu dan merebut kembali hakmu!',
                'background_path'=> $bg('bg_muara.png'),
                'character_path' => $bg('char_patih.png'),
                'animation_type' => 'zoom',
                'options'        => null,
            ],
            [
                'order'          => 11,
                'character_name' => null,
                'dialogue_text'  => 'Kabar mengenai keberadaan Pangeran Samudra di muara Barito akhirnya sampai ke telinga Pangeran Tumenggung. Pasukan Daha yang besar segera dikirim ke muara sungai untuk menumpas mereka!',
                'background_path'=> $bg('bg_konflik.png'),
                'character_path' => null,
                'animation_type' => 'shake',
                'options'        => null,
            ],
            [
                'order'          => 12,
                'character_name' => 'Patih Masih',
                'dialogue_text'  => 'Pasukan Pangeran Tumenggung sangat besar. Kita membutuhkan sekutu yang lebih kuat untuk menghadapi pasukan utama Daha. Apa langkah kita?',
                'background_path'=> $bg('bg_konflik.png'),
                'character_path' => $bg('char_patih.png'),
                'animation_type' => 'shake',
                'options'        => [
                    ['option_text' => 'Menggalang persatuan Banjar-Dayak dan meminta bantuan dari Kesultanan Demak', 'is_correct' => true],
                    ['option_text' => 'Menyerah kalah dan menyerahkan Pangeran Samudra kepada pamannya', 'is_correct' => false],
                    ['option_text' => 'Melarikan diri ke pulau lain dan membiarkan warga muara Barito diserang', 'is_correct' => false],
                ],
            ],
            [
                'order'          => 13,
                'character_name' => 'Patih Masih',
                'dialogue_text'  => 'Dengan dukungan penuh dari kami, kami mengangkatmu menjadi Raja di wilayah muara Sungai Barito ini! Wilayah ini kelak akan berkembang pesat dan dikenal sebagai Banjarmasin!',
                'background_path'=> $bg('bg_muara.png'),
                'character_path' => $bg('char_patih.png'),
                'animation_type' => 'zoom',
                'options'        => null,
            ],
            [
                'order'          => 14,
                'character_name' => 'Pangeran Samudra',
                'dialogue_text'  => 'Terima kasih rakyatku! Bersama Patih Masih dan persatuan Banjar-Dayak, kita akan menegakkan keadilan dan mendirikan Kesultanan Banjar yang berdaulat! Selamat! Kamu telah menyelesaikan Bab 3 — Pelarian Pangeran Samudra!',
                'background_path'=> $bg('bg_kerajaan.png'),
                'character_path' => $bg('char_samudra.png'),
                'animation_type' => 'fade',
                'options'        => null,
            ],
        ];

        foreach ($steps as $step) {
            GameStorylineStep::create(array_merge($step, ['game_level_id' => $level->id]));
        }

        $this->command->info("✅ Seeder Kalimantan Level 1 berhasil dijalankan dengan " . count($steps) . " langkah cerita.");
    }
}

<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Island;
use App\Models\TribeAboutPage;
use App\Models\TribeAboutItem;
use App\Models\TribePage;
use App\Models\HeritageItem;
use App\Models\IslandHistory;
use App\Models\Destination;

class BatakTribeSeeder extends Seeder
{
    public function run(): void
    {
        // Cari pulau Sumatera
        $island = Island::where('slug', 'sumatera')
            ->orWhere('slug', 'sumatra')
            ->first();

        if (!$island) {
            $this->command->error('Pulau Sumatera tidak ditemukan. Seeder Batak dibatalkan.');
            return;
        }

        $islandId = $island->id;
        $tribe = 'Batak';

        // 1. Seed TribeAboutPage
        TribeAboutPage::updateOrCreate(
            ['island_id' => $islandId, 'tribe_key' => $tribe],
            [
                'label_small' => 'MENGENAL SUKU BATAK',
                'hero_title' => 'Eksplorasi Suku Batak di Sumatera Utara',
                'hero_description' => 'Suku Batak merupakan salah satu suku bangsa terbesar di Indonesia yang mendiami sebagian besar wilayah Sumatera Utara. Terkenal dengan falsafah hidup yang kuat, marga yang lestari, dan warisan adat yang kaya.',
                'more_link' => 'https://id.wikipedia.org/wiki/Suku_Batak',
            ]
        );

        // Clear existing items to avoid duplicates
        TribeAboutItem::where('island_id', $islandId)->where('tribe_key', $tribe)->delete();

        // 2. Seed TribeAboutItem
        $aboutItems = [
            [
                'title' => 'Asal-Usul & Wilayah',
                'description' => 'Suku Batak secara historis terbagi dalam beberapa sub-suku seperti Batak Toba, Karo, Simalungun, Pakpak, Angkola, dan Mandailing. Mereka mendiami daerah pegunungan di sekitar Danau Toba hingga pesisir barat dan timur Sumatera Utara.',
                'points' => "Sub-suku Batak Toba\nSub-suku Batak Karo\nSub-suku Batak Simalungun\nSub-suku Batak Mandailing & Angkola\nSub-suku Batak Pakpak",
                'image' => 'https://images.unsplash.com/photo-1626266028886-c951167474a5?auto=format&fit=crop&q=80&w=600',
                'more_link' => 'https://id.wikipedia.org/wiki/Suku_Batak',
                'sort_order' => 1,
            ],
            [
                'title' => 'Sistem Marga (Kekerabatan)',
                'description' => 'Sistem kekerabatan patrilineal yang disebut Marga merupakan pilar identitas Suku Batak. Marga menentukan hubungan kekeluargaan, hukum adat perkawinan (exogami), serta tata cara adat dalam perhelatan besar.',
                'points' => "Garis keturunan Ayah (Patrilineal)\nLarangan menikah satu marga (Exogami)\nFalsafah Dalihan Na Tolu",
                'image' => 'https://images.unsplash.com/photo-1544005313-94ddf0286df2?auto=format&fit=crop&q=80&w=600',
                'more_link' => 'https://id.wikipedia.org/wiki/Marga_Batak',
                'sort_order' => 2,
            ],
            [
                'title' => 'Falsafah Dalihan Na Tolu',
                'description' => 'Dalihan Na Tolu merupakan kerangka sosial adat Batak yang mengatur interaksi kekerabatan melalui tiga tiang utama: Somba Marhula-hula (sembah/hormat kepada keluarga pihak istri), Elek Marboru (lemah lembut kepada keluarga pihak anak perempuan), dan Manat Mardongan Tubu (hati-hati/tenggang rasa kepada saudara semarga).',
                'points' => "Somba Marhula-hula (Hormat keluarga istri)\nElek Marboru (Mengayomi pihak Boru)\nManat Mardongan Tubu (Kompak dengan semarga)",
                'image' => 'https://images.unsplash.com/photo-1517486808906-6ca8b3f04846?auto=format&fit=crop&q=80&w=600',
                'more_link' => 'https://id.wikipedia.org/wiki/Dalihan_Na_Tolu',
                'sort_order' => 3,
            ]
        ];

        foreach ($aboutItems as $item) {
            TribeAboutItem::create(array_merge($item, ['island_id' => $islandId, 'tribe_key' => $tribe]));
        }

        // 3. Seed TribePage (for Heritage Header)
        TribePage::updateOrCreate(
            ['island_id' => $islandId, 'tribe_key' => $tribe],
            [
                'hero_title' => 'Warisan Luhur Kebudayaan Suku Batak',
                'hero_description' => 'Jelajahi keindahan arsitektur Rumah Bolon, keunikan Kain Tenun Ulos, hingga alat musik tradisional yang penuh dengan nilai spiritual dan adat.',
                'hero_image' => 'https://images.unsplash.com/photo-1601058497548-f247dfe349d6?auto=format&fit=crop&q=80&w=1200',
            ]
        );

        // Clear existing heritage items to avoid duplicates
        HeritageItem::where('island_id', $islandId)->where('tribe_key', $tribe)->delete();

        // 4. Seed HeritageItem
        $heritageItems = [
            // Pakaian Adat
            [
                'category' => 'pakaian',
                'title' => 'Kain Ulos',
                'description' => 'Kain tenun khas Batak yang melambangkan restu, kasih sayang, dan kehangatan. Setiap jenis Ulos (seperti Ulos Ragidup, Sadum, Ragi Hotang) memiliki makna simbolis tersendiri dan digunakan dalam upacara adat tertentu.',
                'location' => 'Tapanuli Utara',
                'detail_url' => 'https://id.wikipedia.org/wiki/Ulos',
                'image_path' => null,
                'sort_order' => 1,
            ],
            // Rumah Adat
            [
                'category' => 'rumah_tradisi',
                'title' => 'Rumah Bolon',
                'description' => 'Rumah panggung tradisional Batak dengan atap melengkung menyerupai tanduk kerbau. Konstruksinya tanpa paku, melambangkan gotong royong, keharmonisan alam, dan status sosial pemiliknya.',
                'location' => 'Samosir',
                'detail_url' => 'https://id.wikipedia.org/wiki/Rumah_Bolon',
                'image_path' => null,
                'sort_order' => 1,
            ],
            // Senjata & Alat Musik
            [
                'category' => 'senjata_alatmusik',
                'title' => 'Gondang Sabangunan',
                'description' => 'Ensembel musik tradisional Batak Toba yang terdiri dari seperangkat gendang (taganing), gong (ogung), dan alat tiup (sarune). Digunakan untuk ritual keagamaan purba dan pesta adat besar.',
                'location' => 'Humbang Hasundutan',
                'detail_url' => 'https://id.wikipedia.org/wiki/Gondang_Batak',
                'image_path' => null,
                'sort_order' => 1,
            ],
            [
                'category' => 'senjata_alatmusik',
                'title' => 'Piso Halasan',
                'description' => 'Senjata tradisional khas Batak Toba berupa pedang dengan gagang tanduk rusa dan sarung berhias ukiran perak. Melambangkan kebesaran, wewenang kepemimpinan, dan keadilan.',
                'location' => 'Toba',
                'detail_url' => 'https://id.wikipedia.org/wiki/Piso_Halasan',
                'image_path' => null,
                'sort_order' => 2,
            ]
        ];

        foreach ($heritageItems as $item) {
            HeritageItem::create(array_merge($item, ['island_id' => $islandId, 'tribe_key' => $tribe]));
        }

        // Clear existing histories to avoid duplicates
        IslandHistory::where('island_id', $islandId)->where('tribe', $tribe)->delete();

        // 5. Seed IslandHistory (Timeline)
        $histories = [
            [
                'year_label' => 'Era Prasejarah',
                'title' => 'Migrasi Leluhur Proto-Melayu',
                'content' => 'Leluhur suku Batak bermigrasi dari wilayah Asia Tenggara (Yunnan) sekitar 2500 tahun yang lalu, membawa kebudayaan batu (Megalitikum) dan menetap di daerah pegunungan Sumatera Utara.',
                'more_link' => 'https://id.wikipedia.org/wiki/Suku_Batak',
                'order' => 1,
            ],
            [
                'year_label' => 'Abad ke-13',
                'title' => 'Pengaruh Perdagangan Barus',
                'content' => 'Barus menjadi pelabuhan internasional pengekspor kapur barus dan kemenyan yang dihasilkan oleh masyarakat Batak di pedalaman. Terjadi asimilasi budaya dengan pedagang Tamil, Arab, dan Tiongkok.',
                'more_link' => 'https://id.wikipedia.org/wiki/Barus,_Tapanuli_Tengah',
                'order' => 2,
            ],
            [
                'year_label' => 'Tahun 1880-an',
                'title' => 'Kepemimpinan Raja Sisingamangaraja XII',
                'content' => 'Raja Sisingamangaraja XII, pemimpin spiritual dan politik Batak, memimpin perlawanan heroik melawan ekspansi kolonial Belanda di tanah Batak dalam Perang Toba (1878-1907).',
                'more_link' => 'https://id.wikipedia.org/wiki/Sisingamangaraja_XII',
                'order' => 3,
            ]
        ];

        foreach ($histories as $item) {
            IslandHistory::create(array_merge($item, ['island_id' => $islandId, 'tribe' => $tribe]));
        }

        // Clear existing destinations to avoid duplicates
        Destination::where('island_id', $islandId)->where('tribe_key', $tribe)->delete();

        // 6. Seed Destination (with beautiful panorama URLs)
        $destinations = [
            [
                'name' => 'Desa Wisata Tomok',
                'location' => 'Pulau Samosir, Danau Toba',
                'description' => 'Desa adat yang terkenal dengan makam batu Raja Sidabutar, pertunjukan boneka Sigale-gale yang mistis, dan jajaran rumah adat Bolon yang berusia ratusan tahun.',
                'image_url' => 'https://images.unsplash.com/photo-1542856391-010fb87dcfed?auto=format&fit=crop&q=80&w=800',
                'rating' => 4.8,
                'sort_order' => 1,
                'is_active' => true,
                'pano_embed_url' => 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3986.326284698547!2d98.8576402!3d2.6560946!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3031ddbaaaaaaaab%3A0x1111111111111111!2sMakam%20Raja%20Sidabutar!5e0!3m2!1sid!2sid!4v1700000000000',
                'pano_maps_url' => 'https://maps.app.goo.gl/uXj9C5w95X9Z5w9Z5',
                'pano_label' => '360° Makam Raja Sidabutar Tomok',
            ],
            [
                'name' => 'Bukit Holbung',
                'location' => 'Samosir, Sumatera Utara',
                'description' => 'Bukit sabana hijau nan eksotis yang menawarkan panorama 360 derajat Danau Toba dari ketinggian. Tempat ini sangat populer untuk berkemah dan menikmati matahari terbit.',
                'image_url' => 'https://images.unsplash.com/photo-1601058497548-f247dfe349d6?auto=format&fit=crop&q=80&w=800',
                'rating' => 4.9,
                'sort_order' => 2,
                'is_active' => true,
                'pano_embed_url' => 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3987.054321234567!2d98.6253456!3d2.456789!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3031cbaaaaaaaaab%3A0x2222222222222222!2sBukit%20Holbung!5e0!3m2!1sid!2sid!4v1700000000001',
                'pano_maps_url' => 'https://maps.app.goo.gl/zYx9C5w95X9Z5w9Z6',
                'pano_label' => '360° Pemandangan Indah Bukit Holbung',
            ]
        ];

        foreach ($destinations as $item) {
            Destination::create(array_merge($item, ['island_id' => $islandId, 'tribe_key' => $tribe]));
        }
    }
}

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
use App\Models\Quiz;
use App\Models\QuizQuestion;
use App\Models\QuizOption;

class AcehTribeSeeder extends Seeder
{
    public function run(): void
    {
        // Cari pulau Sumatera
        $island = Island::where('slug', 'sumatera')
            ->orWhere('slug', 'sumatra')
            ->first();

        if (!$island) {
            $this->command->error('Pulau Sumatera tidak ditemukan. Seeder Aceh dibatalkan.');
            return;
        }

        $islandId = $island->id;
        $tribe = 'Aceh';

        // 1. Seed TribeAboutPage
        TribeAboutPage::updateOrCreate(
            ['island_id' => $islandId, 'tribe_key' => $tribe],
            [
                'label_small' => 'MENGENAL SUKU ACEH',
                'hero_title' => 'Eksplorasi Kebudayaan Suku Aceh Serambi Mekkah',
                'hero_description' => 'Suku Aceh mendiami wilayah pesisir dan sebagian pedalaman provinsi Aceh di ujung utara pulau Sumatera. Dikenal dengan sejarah perlawanan yang gigih, ketaatan religiusitas Islam yang kuat, serta kekayaan adat istiadat yang memikat.',
                'more_link' => 'https://id.wikipedia.org/wiki/Suku_Aceh',
            ]
        );

        // Clear existing items to avoid duplicates
        TribeAboutItem::where('island_id', $islandId)->where('tribe_key', $tribe)->delete();

        // 2. Seed TribeAboutItem
        $aboutItems = [
            [
                'title' => 'Asal-Usul & Identitas',
                'description' => 'Suku Aceh terbentuk dari perpaduan berbagai latar belakang etnis seperti Dravida (India), Semit (Arab), Melayu, dan Tiongkok yang berasimilasi melalui perdagangan berabad-abad di Selat Malaka. Hal ini membentuk karakter fisik, kebudayaan, dan bahasa Aceh yang khas.',
                'points' => "Asimilasi multi-etnis bersejarah\nPusat perdagangan Selat Malaka\nBahasa Aceh sebagai bahasa ibu utama",
                'image' => 'https://images.unsplash.com/photo-1590523277543-a94d2e4eb00b?auto=format&fit=crop&q=80&w=600',
                'more_link' => 'https://id.wikipedia.org/wiki/Suku_Aceh',
                'sort_order' => 1,
            ],
            [
                'title' => 'Hukum Adat & Syariat',
                'description' => 'Kehidupan sosial masyarakat Suku Aceh dipandu oleh sinergi antara adat istiadat setempat dan Syariat Islam. Falsafah ini tercermin dalam pepatah terkenal: "Adat bak Po Teumeureuhom, Hukom bak Syiah Kuala" yang berarti hukum adat diatur oleh pemerintah dan hukum syariat diatur oleh ulama.',
                'points' => "Integrasi adat dan syariat Islam\nPeran penting Majelis Adat Aceh (MAA)\nSistem kepemimpinan Geuchik dan Imum Mukim",
                'image' => 'https://images.unsplash.com/photo-1540555700478-4be289fbecef?auto=format&fit=crop&q=80&w=600',
                'more_link' => 'https://id.wikipedia.org/wiki/Hukum_adat_Aceh',
                'sort_order' => 2,
            ],
            [
                'title' => 'Kesenian & Sastra Religius',
                'description' => 'Suku Aceh terkenal dengan tari-tarian kelompok yang sangat dinamis, presisi, dan sarat nilai religius seperti Tari Saman (ditetapkan UNESCO sebagai warisan budaya dunia), Tari Seudati, dan Tari Ranup lam Puan. Kesenian ini memadukan gerakan tubuh yang harmonis dengan syair-syair pujian keagamaan.',
                'points' => "Tari Saman (Warisan Budaya UNESCO)\nTari Seudati dan Ranup lam Puan\nSastra Hikayat Aceh bernada dakwah",
                'image' => 'https://images.unsplash.com/photo-1511671782779-c97d3d27a1d4?auto=format&fit=crop&q=80&w=600',
                'more_link' => 'https://id.wikipedia.org/wiki/Seni_budaya_Aceh',
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
                'hero_title' => 'Warisan Kebudayaan Megah Suku Aceh',
                'hero_description' => 'Jelajahi mahakarya arsitektur Rumoh Aceh yang sarat filosofi spiritual, kemegahan pakaian adat perkawinan, serta keunikan senjata tradisional Rencong peninggalan para pejuang.',
                'hero_image' => 'https://images.unsplash.com/photo-1599940824399-b87987ceb72a?auto=format&fit=crop&q=80&w=1200',
            ]
        );

        // Clear existing heritage items to avoid duplicates
        HeritageItem::where('island_id', $islandId)->where('tribe_key', $tribe)->delete();

        // 4. Seed HeritageItem (At least 4 items, NO food/makanan)
        $heritageItems = [
            [
                'category' => 'pakaian',
                'title' => 'Baju Adat Linto Baro & Daro Baro',
                'description' => 'Pakaian tradisional khas Suku Aceh yang melambangkan keanggunan, martabat, dan nilai keagamaan yang kuat. Busana Linto Baro dikenakan oleh pengantin pria dan dilengkapi dengan mahkota Meukeutop serta rencong, sedangkan Daro Baro dikenakan oleh pengantin wanita dengan perhiasan khas bernuansa emas.',
                'location' => 'Banda Aceh',
                'detail_url' => 'https://id.wikipedia.org/wiki/Pakaian_adat_Aceh',
                'image_path' => null,
                'sort_order' => 1,
            ],
            [
                'category' => 'rumah_tradisi',
                'title' => 'Rumoh Aceh',
                'description' => 'Rumah panggung tradisional kayu khas Aceh yang didesain tanpa menggunakan paku tunggal melainkan pasak kayu. Struktur arsitekturnya yang kokoh terbukti sangat lentur dan tahan terhadap guncangan gempa bumi. Selain itu, pintu masuknya sengaja didesain rendah agar setiap tamu membungkuk sebagai tanda penghormatan.',
                'location' => 'Aceh Besar',
                'detail_url' => 'https://id.wikipedia.org/wiki/Rumoh_Aceh',
                'image_path' => null,
                'sort_order' => 2,
            ],
            [
                'category' => 'senjata_alatmusik',
                'title' => 'Rencong',
                'description' => 'Senjata tajam tradisional legendaris khas Aceh yang memiliki bilah berbentuk huruf L dan hiasan ukiran kaligrafi Basmalah di gagang dan sarungnya. Rencong bukan hanya sekadar senjata bela diri, melainkan simbol kedaulatan, keperkasaan, dan kehormatan rakyat Aceh sejak masa Kesultanan.',
                'location' => 'Pidie',
                'detail_url' => 'https://id.wikipedia.org/wiki/Rencong',
                'image_path' => null,
                'sort_order' => 3,
            ],
            [
                'category' => 'senjata_alatmusik',
                'title' => 'Rapai',
                'description' => 'Alat musik perkusi pukul sejenis rebana tradisional Aceh yang diwariskan oleh ulama penyebar Islam, Syeikh Abdul Qadir Jaelani (Rapai). Rapai terbuat dari kayu pilihan dan kulit kambing, menghasilkan ketukan bersemangat yang sakral untuk mengiringi kesenian tradisional bernuansa dakwah.',
                'location' => 'Aceh Utara',
                'detail_url' => 'https://id.wikipedia.org/wiki/Rapai',
                'image_path' => null,
                'sort_order' => 4,
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
                'year_label' => 'Abad ke-16',
                'title' => 'Kejayaan Kesultanan Aceh Darussalam',
                'content' => 'Di bawah kekuasaan Sultan Iskandar Muda, Kesultanan Aceh mencapai puncak kejayaannya sebagai bandar perdagangan internasional yang besar, pusat penyebaran agama Islam di Asia Tenggara, dan kekuatan militer yang disegani di Selat Malaka.',
                'more_link' => 'https://id.wikipedia.org/wiki/Kesultanan_Aceh',
                'order' => 1,
            ],
            [
                'year_label' => 'Tahun 1873',
                'title' => 'Permulaan Perang Aceh melawan Kolonial Belanda',
                'content' => 'Belanda menyatakan perang terhadap Aceh, memicu perlawanan rakyat yang dipimpin pahlawan legendaris seperti Teuku Umar, Cut Nyak Dhien, dan Laksamana Malahayati. Ini menjadi perang terberat bagi Belanda di Indonesia.',
                'more_link' => 'https://id.wikipedia.org/wiki/Perang_Aceh',
                'order' => 2,
            ],
            [
                'year_label' => 'Tahun 1999',
                'title' => 'Penerapan Otonomi Khusus Syariat Islam',
                'content' => 'Aceh mendapatkan status Otonomi Khusus dari Republik Indonesia, yang memberikan kewenangan penuh untuk menerapkan syariat Islam serta melestarikan adat istiadat lokal.',
                'more_link' => 'https://id.wikipedia.org/wiki/Nanggroe_Aceh_Darussalam',
                'order' => 3,
            ],
            [
                'year_label' => 'Tahun 2004',
                'title' => 'Tragedi Gempa & Tsunami Samudra Hindia',
                'content' => 'Gempa bumi berskala 9,1 SR yang diikuti tsunami dahsyat meluluhlantakkan pesisir Aceh dan memakan ratusan ribu korban jiwa. Tragedi ini melahirkan kesepakatan damai Helsinki antara GAM dan RI.',
                'more_link' => 'https://id.wikipedia.org/wiki/Gempa_bumi_dan_tsunami_Samudra_Hindia_2004',
                'order' => 4,
            ]
        ];

        foreach ($histories as $item) {
            IslandHistory::create(array_merge($item, ['island_id' => $islandId, 'tribe' => $tribe]));
        }

        // Clear existing destinations to avoid duplicates
        Destination::where('island_id', $islandId)->where('tribe_key', $tribe)->delete();

        // 6. Seed Destination (At least 4 items, NO food/makanan, with 360° panorama urls)
        $destinations = [
            [
                'name' => 'Masjid Raya Baiturrahman',
                'location' => 'Banda Aceh',
                'description' => 'Masjid bersejarah peninggalan Kesultanan Aceh yang merupakan simbol religi, kebudayaan, dan perjuangan rakyat Aceh. Masjid dengan kubah hitam megah ini berdiri kokoh menyelamatkan banyak warga saat diterjang tsunami dahsyat tahun 2004.',
                'image_url' => 'https://images.unsplash.com/photo-1590523277543-a94d2e4eb00b?auto=format&fit=crop&q=80&w=800',
                'rating' => 4.9,
                'sort_order' => 1,
                'is_active' => true,
                'latitude' => 5.553609,
                'longitude' => 95.3168273,
                'pano_embed_url' => 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3971.0772275811776!2d95.3168273!3d5.553609!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3040375a226760df%3A0xccdb86a7d5b88ff9!2sMasjid%20Raya%20Baiturrahman!5e0!3m2!1sid!2sid!4v1700000000002',
                'pano_maps_url' => 'https://maps.app.goo.gl/K8x3B5w95X9Z5w9Z7',
                'pano_label' => '360° Masjid Raya Baiturrahman',
            ],
            [
                'name' => 'Museum Tsunami Aceh',
                'location' => 'Banda Aceh',
                'description' => 'Monumen bersejarah yang dirancang oleh arsitek Ridwan Kamil untuk mengenang bencana tsunami 2004. Desainnya menyerupai kapal raksasa dengan dinding bermotif tarian Saman, menyajikan lorong sempit berbisik yang sarat emosi serta ruang mitigasi bencana.',
                'image_url' => 'https://images.unsplash.com/photo-1542856391-010fb87dcfed?auto=format&fit=crop&q=80&w=800',
                'rating' => 4.8,
                'sort_order' => 2,
                'is_active' => true,
                'latitude' => 5.5489012,
                'longitude' => 95.3156789,
                'pano_embed_url' => 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3971.07923456789!2d95.3156789!3d5.5489012!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3040375a2f555555%3A0x2222222222222223!2sMuseum%20Tsunami%20Aceh!5e0!3m2!1sid!2sid!4v1700000000003',
                'pano_maps_url' => 'https://maps.app.goo.gl/L9x3B5w95X9Z5w9Z8',
                'pano_label' => '360° Museum Tsunami Aceh',
            ],
            [
                'name' => 'Pantai Lampuuk',
                'location' => 'Lhoknga, Aceh Besar',
                'description' => 'Pantai pasir putih eksotis dengan air laut jernih berwarna biru kehijauan, dikelilingi oleh barisan tebing kapur yang menjulang tinggi di sisi barat. Tempat wisata populer ini sangat ideal untuk berselancar, bermain air, dan menikmati keindahan matahari terbenam.',
                'image_url' => 'https://images.unsplash.com/photo-1507525428034-b723cf961d3e?auto=format&fit=crop&q=80&w=800',
                'rating' => 4.7,
                'sort_order' => 3,
                'is_active' => true,
                'latitude' => 5.489123,
                'longitude' => 95.2234567,
                'pano_embed_url' => 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3971.40123456789!2d95.2234567!3d5.489123!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x30403cbaaaaaaaaab%3A0x3333333333333333!2sPantai%20Lampuuk!5e0!3m2!1sid!2sid!4v1700000000004',
                'pano_maps_url' => 'https://maps.app.goo.gl/M9x3B5w95X9Z5w9Z9',
                'pano_label' => '360° Keindahan Pantai Lampuuk',
            ],
            [
                'name' => 'Benteng Indra Patra',
                'location' => 'Ladong, Aceh Besar',
                'description' => 'Kompleks benteng bersejarah peninggalan Kerajaan Hindu Lamuri pada abad ke-7. Benteng pertahanan yang terbuat dari susunan batu gunung ini kemudian digunakan kembali oleh pasukan Kesultanan Aceh Darussalam untuk memantau kapal musuh di perairan Selat Malaka.',
                'image_url' => 'https://images.unsplash.com/photo-1599940824399-b87987ceb72a?auto=format&fit=crop&q=80&w=800',
                'rating' => 4.6,
                'sort_order' => 4,
                'is_active' => true,
                'latitude' => 5.656123,
                'longitude' => 95.4456789,
                'pano_embed_url' => 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3970.80123456789!2d95.4456789!3d5.656123!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x30404dbaaaaaaaaab%3A0x4444444444444444!2sBenteng%20Indra%20Patra!5e0!3m2!1sid!2sid!4v1700000000005',
                'pano_maps_url' => 'https://maps.app.goo.gl/N9x3B5w95X9Z5w9Z0',
                'pano_label' => '360° Sejarah Benteng Indra Patra',
            ]
        ];

        foreach ($destinations as $item) {
            Destination::create(array_merge($item, ['island_id' => $islandId, 'tribe_key' => $tribe]));
        }

        // 7. Seed Quiz (At least 4 questions, NO food/makanan)
        $quiz = Quiz::updateOrCreate(
            ['scope' => 'tribe', 'island_id' => $islandId, 'tribe' => $tribe],
            [
                'title' => 'Kuis Kebudayaan Suku Aceh',
                'is_active' => true,
            ]
        );

        $quiz->questions()->delete(); // membersihkan pertanyaan lama agar bersih

        $questionsData = [
            [
                'prompt_type' => 'text',
                'prompt_text' => 'Apakah nama senjata tradisional khas Suku Aceh yang memiliki bilah melengkung menyerupai huruf L dan melambangkan kalimat Basmalah?',
                'explanation' => 'Rencong merupakan senjata tradisional legendaris khas Aceh yang bentuk gagang dan bilahnya melambangkan kaligrafi kalimat Basmalah.',
                'options' => [
                    ['content_text' => 'Keris', 'is_correct' => false],
                    ['content_text' => 'Rencong', 'is_correct' => true],
                    ['content_text' => 'Kujang', 'is_correct' => false],
                    ['content_text' => 'Mandau', 'is_correct' => false],
                ]
            ],
            [
                'prompt_type' => 'text',
                'prompt_text' => 'Rumah adat panggung khas Suku Aceh yang dibangun kokoh dengan struktur kayu tanpa menggunakan paku melainkan pasak kayu dinamakan...',
                'explanation' => 'Rumoh Aceh adalah rumah tradisional berbentuk panggung yang dirancang fleksibel sehingga sangat tahan terhadap guncangan gempa bumi.',
                'options' => [
                    ['content_text' => 'Rumah Bolon', 'is_correct' => false],
                    ['content_text' => 'Rumoh Aceh', 'is_correct' => true],
                    ['content_text' => 'Rumah Gadang', 'is_correct' => false],
                    ['content_text' => 'Rumah Joglo', 'is_correct' => false],
                ]
            ],
            [
                'prompt_type' => 'text',
                'prompt_text' => 'Di bawah kekuasaan sultan siapakah Kesultanan Aceh Darussalam mencapai puncak kejayaannya sebagai bandar perdagangan internasional pada abad ke-17?',
                'explanation' => 'Sultan Iskandar Muda memimpin Kesultanan Aceh mencapai era keemasan (1607-1636), menguasai perdagangan lada dan menjadi pusat penyebaran Islam.',
                'options' => [
                    ['content_text' => 'Sultan Ali Mughayat Syah', 'is_correct' => false],
                    ['content_text' => 'Sultan Iskandar Muda', 'is_correct' => true],
                    ['content_text' => 'Sultan Malik As-Saleh', 'is_correct' => false],
                    ['content_text' => 'Sultan Ageng Tirtayasa', 'is_correct' => false],
                ]
            ],
            [
                'prompt_type' => 'text',
                'prompt_text' => 'Alat musik perkusi pukul sejenis rebana tradisional khas Suku Aceh yang sering digunakan untuk mengiringi syair dakwah dinamakan...',
                'explanation' => 'Rapai adalah alat musik perkusi khas Aceh peninggalan ulama penyebar Islam Syeikh Rapai (Abdul Qadir Jaelani).',
                'options' => [
                    ['content_text' => 'Gamelan', 'is_correct' => false],
                    ['content_text' => 'Rapai', 'is_correct' => true],
                    ['content_text' => 'Tifa', 'is_correct' => false],
                    ['content_text' => 'Sasando', 'is_correct' => false],
                ]
            ],
            [
                'prompt_type' => 'text',
                'prompt_text' => 'Masjid bersejarah di pusat kota Banda Aceh yang tetap kokoh berdiri dan menjadi saksi bisu keajaiban saat dilanda gempa & tsunami tahun 2004 adalah...',
                'explanation' => 'Masjid Raya Baiturrahman peninggalan Kesultanan Aceh tetap berdiri megah saat tsunami melanda dan menjadi tempat perlindungan ribuan pengungsi.',
                'options' => [
                    ['content_text' => 'Masjid Agung Demak', 'is_correct' => false],
                    ['content_text' => 'Masjid Raya Baiturrahman', 'is_correct' => true],
                    ['content_text' => 'Masjid Menara Kudus', 'is_correct' => false],
                    ['content_text' => 'Masjid Istiqlal', 'is_correct' => false],
                ]
            ]
        ];

        foreach ($questionsData as $qIdx => $qData) {
            $question = QuizQuestion::create([
                'quiz_id' => $quiz->id,
                'prompt_type' => $qData['prompt_type'],
                'prompt_text' => $qData['prompt_text'],
                'explanation' => $qData['explanation'],
                'order' => $qIdx + 1,
            ]);

            foreach ($qData['options'] as $oIdx => $oData) {
                QuizOption::create([
                    'quiz_question_id' => $question->id,
                    'content_type' => 'text',
                    'content_text' => $oData['content_text'],
                    'is_correct' => $oData['is_correct'],
                    'order' => $oIdx + 1,
                ]);
            }
        }
    }
}

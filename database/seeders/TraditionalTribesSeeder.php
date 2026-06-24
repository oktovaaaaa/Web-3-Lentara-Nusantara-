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

class TraditionalTribesSeeder extends Seeder
{
    public function run(): void
    {
        $tribesData = [
            // =========================================================================
            // SUMATERA
            // =========================================================================
            [
                'island_slug' => 'sumatera',
                'tribe_key' => 'Minangkabau',
                'about_page' => [
                    'label_small' => 'MENGENAL SUKU MINANGKABAU',
                    'hero_title' => 'Eksplorasi Adat Suku Minangkabau di Sumatera Barat',
                    'hero_description' => 'Suku Minangkabau merupakan kelompok etnis unik yang menganut sistem kekerabatan matrilineal terbesar di dunia. Terkenal dengan filosofi "Alam Takambang Jadi Guru", tradisi merantau, serta kekayaan kuliner rendang yang mendunia.',
                    'more_link' => 'https://id.wikipedia.org/wiki/Suku_Minangkabau',
                ],
                'about_items' => [
                    [
                        'title' => 'Sistem Kekerabatan Matrilineal',
                        'description' => 'Garis keturunan dan warisan pusaka tinggi Suku Minangkabau diturunkan melalui pihak ibu. Hal ini memberikan kedudukan terhormat bagi kaum wanita (Bundo Kanduang) sebagai penjaga harta dan kehormatan keluarga.',
                        'points' => "Garis keturunan mengikuti Ibu\nWaris pusaka tinggi jatuh ke anak perempuan\nPeran sentral Bundo Kanduang dalam adat",
                        'image' => 'https://images.unsplash.com/photo-1540555700478-4be289fbecef?auto=format&fit=crop&q=80&w=600',
                        'more_link' => 'https://id.wikipedia.org/wiki/Matrilineal_di_Minangkabau',
                        'sort_order' => 1,
                    ],
                    [
                        'title' => 'Tradisi Merantau & Kewirausahaan',
                        'description' => 'Anak laki-laki Minangkabau didorong untuk pergi merantau guna menuntut ilmu dan mencari nafkah. Tradisi ini membentuk jiwa kemandirian yang kuat dan jaringan perdagangan Minang yang luas di seluruh Nusantara.',
                        'points' => "Filosofi kemandirian bagi kaum pria\nMembangun kedewasaan di tanah rantau\nJaringan perdagangan yang kuat",
                        'image' => 'https://images.unsplash.com/photo-1517486808906-6ca8b3f04846?auto=format&fit=crop&q=80&w=600',
                        'more_link' => 'https://id.wikipedia.org/wiki/Merantau',
                        'sort_order' => 2,
                    ]
                ],
                'heritage_page' => [
                    'hero_title' => 'Warisan Kebudayaan Luhur Suku Minangkabau',
                    'hero_description' => 'Jelajahi keindahan arsitektur Rumah Gadang dengan atap gonjong yang menyerupai tanduk kerbau, kemegahan kain Songket, serta tari-tarian tradisional bernuansa dinamis.',
                    'hero_image' => 'https://images.unsplash.com/photo-1599940824399-b87987ceb72a?auto=format&fit=crop&q=80&w=1200',
                ],
                'heritage_items' => [
                    [
                        'category' => 'pakaian',
                        'title' => 'Baju Limpapeh Rumah Nan Gadang',
                        'description' => 'Pakaian adat perempuan Minangkabau yang melambangkan kebesaran wanita dalam adat. Dilengkapi dengan tutup kepala berbentuk tanduk kerbau (Tingkuluak Kabau) yang melambangkan identitas rumah adat Minang.',
                        'location' => 'Padang',
                        'detail_url' => 'https://id.wikipedia.org/wiki/Pakaian_adat_Minangkabau',
                        'sort_order' => 1,
                    ],
                    [
                        'category' => 'rumah_tradisi',
                        'title' => 'Rumah Gadang',
                        'description' => 'Rumah tradisional Minangkabau berbentuk panggung dengan atap gonjong melengkung seperti tanduk kerbau. Didesain tahan gempa dengan tiang-tiang kayu miring bertumpu di atas batu pipih.',
                        'location' => 'Tanah Datar',
                        'detail_url' => 'https://id.wikipedia.org/wiki/Rumah_Gadang',
                        'sort_order' => 2,
                    ],
                    [
                        'category' => 'senjata_alatmusik',
                        'title' => 'Karih',
                        'description' => 'Senjata tradisional Minangkabau berupa keris tanpa lekukan dengan bilah belati berhias mewah. Karih diselipkan di pinggang sebagai perlambang kewibawaan dan kesatriaan bagi kaum pria.',
                        'location' => 'Bukittinggi',
                        'detail_url' => 'https://id.wikipedia.org/wiki/Keris_Minangkabau',
                        'sort_order' => 3,
                    ],
                    [
                        'category' => 'senjata_alatmusik',
                        'title' => 'Saluang',
                        'description' => 'Alat musik tiup tradisional khas Minangkabau sejenis seruling bambu dengan tiupan miring yang menghasilkan nada melankolis nan syahdu mengiringi pantun-pantun sastra Minang.',
                        'location' => 'Solok',
                        'detail_url' => 'https://id.wikipedia.org/wiki/Saluang',
                        'sort_order' => 4,
                    ]
                ],
                'history' => [
                    [
                        'year_label' => 'Abad ke-14',
                        'title' => 'Berdirinya Kerajaan Pagaruyung',
                        'content' => 'Raja Adityawarman mendirikan Kerajaan Pagaruyung di wilayah pedalaman Minangkabau, memadukan pengaruh Hindu-Buddha dengan kebudayaan asli setempat.',
                        'more_link' => 'https://id.wikipedia.org/wiki/Kerajaan_Pagaruyung',
                        'order' => 1,
                    ],
                    [
                        'year_label' => 'Tahun 1803-1838',
                        'title' => 'Perang Padri',
                        'content' => 'Perang saudara berdarah antara kaum ulama (Padri) dengan kaum adat Minangkabau yang berujung pada penyatuan melawan penjajah Belanda.',
                        'more_link' => 'https://id.wikipedia.org/wiki/Perang_Padri',
                        'order' => 2,
                    ]
                ],
                'destinations' => [
                    [
                        'name' => 'Istano Basa Pagaruyung',
                        'location' => 'Batusangkar, Tanah Datar',
                        'description' => 'Replika istana megah Kerajaan Pagaruyung yang menampilkan arsitektur Rumah Gadang tiga tingkat bertingkat gonjong sebelas, berhiaskan ukiran kayu motif flora Minangkabau yang sarat makna.',
                        'image_url' => 'https://images.unsplash.com/photo-1599940824399-b87987ceb72a?auto=format&fit=crop&q=80&w=800',
                        'rating' => 4.9,
                        'sort_order' => 1,
                        'is_active' => true,
                        'latitude' => -0.471167,
                        'longitude' => 100.621252,
                        'pano_embed_url' => 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3989.654321234567!2d100.621252!3d-0.471167!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2fd540aaaaaaaab%3A0x2222222222222221!2sIstano%20Basa%20Pagaruyung!5e0!3m2!1sid!2sid!4v1700000000010',
                        'pano_maps_url' => 'https://maps.app.goo.gl/uXj9C5w95X9Z5w9X1',
                        'pano_label' => '360° Istano Basa Pagaruyung',
                    ],
                    [
                        'name' => 'Lembah Harau',
                        'location' => 'Lima Puluh Kota, Sumatera Barat',
                        'description' => 'Cagar alam luar biasa yang diapit oleh tebing-tebing batu granit setinggi ratusan meter, lengkap dengan air terjun dan pemandangan persawahan hijau yang menawan.',
                        'image_url' => 'https://images.unsplash.com/photo-1542856391-010fb87dcfed?auto=format&fit=crop&q=80&w=800',
                        'rating' => 4.8,
                        'sort_order' => 2,
                        'is_active' => true,
                        'latitude' => -0.108343,
                        'longitude' => 100.672901,
                        'pano_embed_url' => 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3989.70123456789!2d100.672901!3d-0.108343!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2fd54dbaaaaaaaab%3A0x3333333333333331!2sLembah%20Harau!5e0!3m2!1sid!2sid!4v1700000000011',
                        'pano_maps_url' => 'https://maps.app.goo.gl/uXj9C5w95X9Z5w9X2',
                        'pano_label' => '360° Lembah Harau',
                    ]
                ],
                'quiz' => [
                    'title' => 'Kuis Kebudayaan Suku Minangkabau',
                    'questions' => [
                        [
                            'prompt_text' => 'Sistem kekerabatan yang dianut oleh suku Minangkabau yang menarik garis keturunan dari pihak ibu dinamakan...',
                            'explanation' => 'Matrilineal adalah sistem kekerabatan yang menarik garis keturunan dan hak waris dari pihak ibu.',
                            'options' => [
                                ['content_text' => 'Patrilineal', 'is_correct' => false],
                                ['content_text' => 'Matrilineal', 'is_correct' => true],
                                ['content_text' => 'Bilateral', 'is_correct' => false],
                                ['content_text' => 'Ambilineal', 'is_correct' => false],
                            ]
                        ],
                        [
                            'prompt_text' => 'Apakah nama rumah tradisional suku Minangkabau dengan atap gonjong yang melengkung menyerupai tanduk kerbau?',
                            'explanation' => 'Rumah Gadang memiliki atap berbentuk melengkung lancip (gonjong) yang diadaptasi dari bentuk tanduk kerbau.',
                            'options' => [
                                ['content_text' => 'Rumah Bolon', 'is_correct' => false],
                                ['content_text' => 'Rumah Joglo', 'is_correct' => false],
                                ['content_text' => 'Rumah Gadang', 'is_correct' => true],
                                ['content_text' => 'Rumah Tongkonan', 'is_correct' => false],
                            ]
                        ]
                    ]
                ]
            ],

            // =========================================================================
            // JAWA (JAWA, SUNDA, MADURA)
            // =========================================================================
            [
                'island_slug' => 'jawa',
                'tribe_key' => 'Jawa',
                'about_page' => [
                    'label_small' => 'MENGENAL SUKU JAWA',
                    'hero_title' => 'Eksplorasi Nilai Kebudayaan Luhur Suku Jawa',
                    'hero_description' => 'Suku Jawa merupakan kelompok suku bangsa terbesar di Indonesia yang mayoritas mendiami wilayah Jawa Tengah, DI Yogyakarta, dan Jawa Timur. Dikenal dengan karakter halus, tata krama berbahasa (Unggah-Ungguh), serta keragaman seni mistis tradisional.',
                    'more_link' => 'https://id.wikipedia.org/wiki/Suku_Jawa',
                ],
                'about_items' => [
                    [
                        'title' => 'Falsafah Hidup & Keselarasan Sosial',
                        'description' => 'Masyarakat Jawa sangat mengedepankan keselarasan, ketenangan batin, serta penghindaran konflik. Filosofi "Rukun Agawe Santosa, Crah Agawe Bubrah" (Rukun membawa kekuatan, perpecahan membawa kehancuran) memandu pola pikir kerukunan bertetangga.',
                        'points' => "Prinsip rukun dan tepo sliro (tenggang rasa)\nFalsafah ketenangan batin (Sumeleh)\nPenghindaran konflik secara verbal maupun aksi",
                        'image' => 'https://images.unsplash.com/photo-1601058497548-f247dfe349d6?auto=format&fit=crop&q=80&w=600',
                        'more_link' => 'https://id.wikipedia.org/wiki/Suku_Jawa',
                        'sort_order' => 1,
                    ]
                ],
                'heritage_page' => [
                    'hero_title' => 'Kekayaan Kebudayaan Agung Suku Jawa',
                    'hero_description' => 'Jelajahi keagungan arsitektur Rumah Joglo, pertunjukan seni Wayang Kulit yang sarat pesan moral filosofis, serta indahnya kain Batik tulis.',
                    'hero_image' => 'https://images.unsplash.com/photo-1733039898491-b4f469c6cd1a?auto=format&fit=crop&q=80&w=1200',
                ],
                'heritage_items' => [
                    [
                        'category' => 'rumah_tradisi',
                        'title' => 'Rumah Joglo',
                        'description' => 'Rumah tradisional Jawa yang memiliki tiang utama penopang atap (Soko Guru) tanpa paku besi. Desain atapnya menjulang melambangkan gunung suci sebagai tempat bersemayam para leluhur.',
                        'location' => 'Surakarta',
                        'detail_url' => 'https://id.wikipedia.org/wiki/Joglo',
                        'sort_order' => 1,
                    ],
                    [
                        'category' => 'senjata_alatmusik',
                        'title' => 'Gamelan Jawa',
                        'description' => 'Ensembel alat musik perkusi bernada pentatonis (Slendro dan Pelog) yang terdiri dari gong, saron, bonang, dan kendang, menghasilkan harmoni nada yang sangat tenang.',
                        'location' => 'Yogyakarta',
                        'detail_url' => 'https://id.wikipedia.org/wiki/Gamelan',
                        'sort_order' => 2,
                    ]
                ],
                'history' => [
                    [
                        'year_label' => 'Abad ke-14',
                        'title' => 'Kejayaan Kerajaan Majapahit',
                        'content' => 'Kerajaan Majapahit yang berpusat di Jawa Timur tumbuh menjadi imperium maritim terbesar di Asia Tenggara di bawah pimpinan Hayam Wuruk dan Mahapatih Gajah Mada.',
                        'more_link' => 'https://id.wikipedia.org/wiki/Majapahit',
                        'order' => 1,
                    ]
                ],
                'destinations' => [
                    [
                        'name' => 'Candi Borobudur',
                        'location' => 'Magelang, Jawa Tengah',
                        'description' => 'Candi Buddha terbesar di dunia yang dibangun pada masa Dinasti Syailendra. Bangunan megah ini dihiasi ribuan panel relief dan stupa batu berongga berisi patung Buddha.',
                        'image_url' => 'https://images.unsplash.com/photo-1733039898491-b4f469c6cd1a?auto=format&fit=crop&q=80&w=800',
                        'rating' => 4.9,
                        'sort_order' => 1,
                        'is_active' => true,
                        'latitude' => -7.607868,
                        'longitude' => 110.203749,
                        'pano_embed_url' => 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3980.123456789!2d110.203749!3d-7.607868!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e7a8aaaaaaaab%3A0x4444444444444445!2sCandi%20Borobudur!5e0!3m2!1sid!2sid!4v1700000000020',
                        'pano_maps_url' => 'https://maps.app.goo.gl/uXj9C5w95X9Z5w9X3',
                        'pano_label' => '360° Candi Borobudur',
                    ]
                ],
                'quiz' => [
                    'title' => 'Kuis Kebudayaan Suku Jawa',
                    'questions' => [
                        [
                            'prompt_text' => 'Tiang utama penyangga struktur atap pada rumah tradisional Joglo dinamakan...',
                            'explanation' => 'Soko Guru merupakan empat tiang penyangga utama yang memikul struktur atap tengah tumpang sari rumah Joglo.',
                            'options' => [
                                ['content_text' => 'Pendopo', 'is_correct' => false],
                                ['content_text' => 'Soko Guru', 'is_correct' => true],
                                ['content_text' => 'Gebyok', 'is_correct' => false],
                                ['content_text' => 'Soko Rawa', 'is_correct' => false],
                            ]
                        ]
                    ]
                ]
            ],
            [
                'island_slug' => 'jawa',
                'tribe_key' => 'Sunda',
                'about_page' => [
                    'label_small' => 'MENGENAL SUKU SUNDA',
                    'hero_title' => 'Pesona Budaya Suku Sunda di Jawa Barat',
                    'hero_description' => 'Suku Sunda mendiami Jawa Barat dan Banten, terkenal dengan tutur kata sopan (Someah), keindahan melodi musik bambu Angklung, serta falsafah hidup luhur "Silih Asih, Silih Asah, Silih Asuh".',
                    'more_link' => 'https://id.wikipedia.org/wiki/Suku_Sunda',
                ],
                'about_items' => [
                    [
                        'title' => 'Someah Hade ka Semah',
                        'description' => 'Prinsip kepribadian orang Sunda yang sangat ramah, murah senyum, sopan santun, dan sangat menghargai setiap tamu yang berkunjung ke wilayahnya.',
                        'points' => "Keramahtamahan sosial yang tulus\nToleransi kekeluargaan yang erat\nPenggunaan tutur bahasa halus (Sunda lemes)",
                        'image' => 'https://images.unsplash.com/photo-1540555700478-4be289fbecef?auto=format&fit=crop&q=80&w=600',
                        'more_link' => 'https://id.wikipedia.org/wiki/Suku_Sunda',
                        'sort_order' => 1,
                    ]
                ],
                'heritage_page' => [
                    'hero_title' => 'Warisan Kebudayaan Anggun Suku Sunda',
                    'hero_description' => 'Temukan kemerduan suara Angklung yang diakui UNESCO, kegagahan senjata Kujang, serta keanggunan busana kebaya Sunda.',
                    'hero_image' => 'https://images.unsplash.com/photo-1599940824399-b87987ceb72a?auto=format&fit=crop&q=80&w=1200',
                ],
                'heritage_items' => [
                    [
                        'category' => 'senjata_alatmusik',
                        'title' => 'Angklung',
                        'description' => 'Alat musik ganda bernada diatonal terbuat dari bambu. Dimainkan dengan cara digoyang sehingga tabung bambu membentur pipa penggetar dan memancarkan harmoni merdu.',
                        'location' => 'Bandung',
                        'detail_url' => 'https://id.wikipedia.org/wiki/Angklung',
                        'sort_order' => 1,
                    ],
                    [
                        'category' => 'senjata_alatmusik',
                        'title' => 'Kujang',
                        'description' => 'Senjata tajam pusaka tradisional Sunda dengan bentuk bilah eksotis berlubang kecil. Melambangkan kekuatan spiritual, kewibawaan, dan kemerdekaan berpikir para leluhur.',
                        'location' => 'Bogor',
                        'detail_url' => 'https://id.wikipedia.org/wiki/Kujang',
                        'sort_order' => 2,
                    ]
                ],
                'history' => [
                    [
                        'year_label' => 'Abad ke-4',
                        'title' => 'Berdirinya Kerajaan Tarumanagara',
                        'content' => 'Salah satu kerajaan Hindu tertua di Indonesia didirikan oleh dinasti Jayasinghawarman di wilayah aliran sungai Citarum Jawa Barat.',
                        'more_link' => 'https://id.wikipedia.org/wiki/Tarumanagara',
                        'order' => 1,
                    ]
                ],
                'destinations' => [
                    [
                        'name' => 'Kampung Naga',
                        'location' => 'Tasikmalaya, Jawa Barat',
                        'description' => 'Desa adat Sunda yang masih memegang teguh tradisi leluhur secara murni, hidup selaras alam tanpa listrik dan rumah panggung berdinding bambu berlapis ijuk.',
                        'image_url' => 'https://images.unsplash.com/photo-1542856391-010fb87dcfed?auto=format&fit=crop&q=80&w=800',
                        'rating' => 4.8,
                        'sort_order' => 1,
                        'is_active' => true,
                        'latitude' => -7.362946,
                        'longitude' => 108.082728,
                        'pano_embed_url' => 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3979.70123456789!2d108.082728!3d-7.362946!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e6f4dbaaaaaaaab%3A0x5555555555555556!2sKampung%20Naga!5e0!3m2!1sid!2sid!4v1700000000021',
                        'pano_maps_url' => 'https://maps.app.goo.gl/uXj9C5w95X9Z5w9X4',
                        'pano_label' => '360° Kampung Naga',
                    ]
                ],
                'quiz' => [
                    'title' => 'Kuis Kebudayaan Suku Sunda',
                    'questions' => [
                        [
                            'prompt_text' => 'Falsafah hidup luhur orang Sunda yang berarti saling mengasihi, saling mendidik/menajamkan pikiran, dan saling mengasuh dinamakan...',
                            'explanation' => 'Silih Asih, Silih Asah, Silih Asuh merupakan pilar kehidupan harmonis bersosialisasi adat Sunda.',
                            'options' => [
                                ['content_text' => 'Silih Asih, Silih Asah, Silih Asuh', 'is_correct' => true],
                                ['content_text' => 'Tepo Sliro', 'is_correct' => false],
                                ['content_text' => 'Dalihan Na Tolu', 'is_correct' => false],
                                ['content_text' => 'Bhineka Tunggal Ika', 'is_correct' => false],
                            ]
                        ]
                    ]
                ]
            ],
            [
                'island_slug' => 'jawa',
                'tribe_key' => 'Madura',
                'about_page' => [
                    'label_small' => 'MENGENAL SUKU MADURA',
                    'hero_title' => 'Karakter Gigih & Budaya Unik Suku Madura',
                    'hero_description' => 'Suku Madura mendiami Pulau Madura dan pesisir timur Jawa Timur. Terkenal sebagai pekerja keras yang gigih, memiliki jiwa sportivitas tinggi melalui tradisi Karapan Sapi, serta taat beragama Islam.',
                    'more_link' => 'https://id.wikipedia.org/wiki/Suku_Madura',
                ],
                'about_items' => [
                    [
                        'title' => 'Karakter Pekerja Keras & Solidaritas',
                        'description' => 'Masyarakat Madura dikenal dengan etos kerja tinggi dan semangat gotong royong yang kokoh. Rasa kesetiakawanan sosial sesama warga Madura sangat kuat terutama di tanah perantauan.',
                        'points' => "Etos kerja tinggi di berbagai sektor\nSolidaritas persaudaraan erat (Taretan Dhibi')\nPenghormatan tinggi kepada ulama dan orang tua",
                        'image' => 'https://images.unsplash.com/photo-1517486808906-6ca8b3f04846?auto=format&fit=crop&q=80&w=600',
                        'more_link' => 'https://id.wikipedia.org/wiki/Suku_Madura',
                        'sort_order' => 1,
                    ]
                ],
                'heritage_page' => [
                    'hero_title' => 'Warisan Kebudayaan Tangguh Suku Madura',
                    'hero_description' => 'Saksikan keberanian tradisi balap Karapan Sapi, kegagahan senjata tradisional Clurit, serta pakaian adat Pesa\'an merah putih yang ikonik.',
                    'hero_image' => 'https://images.unsplash.com/photo-1601058497548-f247dfe349d6?auto=format&fit=crop&q=80&w=1200',
                ],
                'heritage_items' => [
                    [
                        'category' => 'pakaian',
                        'title' => 'Pesa\'an',
                        'description' => 'Pakaian adat Madura berupa kaos garis horizontal merah-putih dengan celana kombor hitam longgar. Melambangkan jiwa pemberani, tegas, dan terbuka masyarakat Madura.',
                        'location' => 'Bangkalan',
                        'detail_url' => 'https://id.wikipedia.org/wiki/Pesa%27an',
                        'sort_order' => 1,
                    ],
                    [
                        'category' => 'senjata_alatmusik',
                        'title' => 'Clurit',
                        'description' => 'Senjata tajam melengkung berbentuk bulan sabit. Menjadi simbol kejantanan bagi kaum pria dan memiliki sejarah panjang sebagai alat pertanian sekaligus pertahanan diri.',
                        'location' => 'Sampang',
                        'detail_url' => 'https://id.wikipedia.org/wiki/Celurit',
                        'sort_order' => 2,
                    ]
                ],
                'history' => [
                    [
                        'year_label' => 'Tahun 1293',
                        'title' => 'Peran Raden Wijaya & Kadipaten Sumenep',
                        'content' => 'Bupati Sumenep Arya Wiraraja membantu Raden Wijaya mengatur siasat pendirian Kerajaan Majapahit dengan menampung pelarian prajurit Singasari di Madura.',
                        'more_link' => 'https://id.wikipedia.org/wiki/Arya_Wiraraja',
                        'order' => 1,
                    ]
                ],
                'destinations' => [
                    [
                        'name' => 'Keraton Sumenep',
                        'location' => 'Sumenep, Madura',
                        'description' => 'Satu-satunya kompleks istana kadipaten warisan sejarah di Jawa Timur yang masih berdiri utuh, memadukan arsitektur Islam Jawa, Tiongkok, dan Eropa.',
                        'image_url' => 'https://images.unsplash.com/photo-1599940824399-b87987ceb72a?auto=format&fit=crop&q=80&w=800',
                        'rating' => 4.7,
                        'sort_order' => 1,
                        'is_active' => true,
                        'latitude' => -7.009124,
                        'longitude' => 113.861724,
                        'pano_embed_url' => 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3979.99123456789!2d113.861724!3d-7.009124!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2dd5cbaaaaaaaab%3A0x6666666666666667!2sKeraton%20Sumenep!5e0!3m2!1sid!2sid!4v1700000000022',
                        'pano_maps_url' => 'https://maps.app.goo.gl/uXj9C5w95X9Z5w9X5',
                        'pano_label' => '360° Keraton Sumenep',
                    ]
                ],
                'quiz' => [
                    'title' => 'Kuis Kebudayaan Suku Madura',
                    'questions' => [
                        [
                            'prompt_text' => 'Pakaian tradisional suku Madura berupa kaos garis horizontal merah-putih dinamakan...',
                            'explanation' => 'Pesa\'an merupakan pakaian adat suku Madura yang bermotif garis merah-putih melambangkan keberanian dan ketegasan.',
                            'options' => [
                                ['content_text' => 'Surjan', 'is_correct' => false],
                                ['content_text' => 'Pesa\'an', 'is_correct' => true],
                                ['content_text' => 'Pangsi', 'is_correct' => false],
                                ['content_text' => 'Beskap', 'is_correct' => false],
                            ]
                        ]
                    ]
                ]
            ],

            // =========================================================================
            // KALIMANTAN (BANJAR, DAYAK, KUTAI)
            // =========================================================================
            [
                'island_slug' => 'kalimantan',
                'tribe_key' => 'Banjar',
                'about_page' => [
                    'label_small' => 'MENGENAL SUKU BANJAR',
                    'hero_title' => 'Kebudayaan Sungai Suku Banjar di Kalimantan Selatan',
                    'hero_description' => 'Suku Banjar mendiami wilayah pesisir dan aliran sungai Kalimantan Selatan. Terkenal sebagai suku pelaut dan pedagang sungai yang tangguh dengan identitas budaya terapung yang unik.',
                    'more_link' => 'https://id.wikipedia.org/wiki/Suku_Banjar',
                ],
                'about_items' => [
                    [
                        'title' => 'Kebudayaan Lahan Basah & Sungai',
                        'description' => 'Kehidupan sosial masyarakat Suku Banjar tumbuh di sepanjang sungai Barito, Martapura, dan negara. Budaya pasar terapung menjadi denyut nadi ekonomi ikonik yang bertahan ratusan tahun.',
                        'points' => "Ekonomi berbasis pasar terapung (Jukung)\nArsitektur pemukiman panggung tepi sungai\nBahasa Banjar yang berakar dari rumpun Melayu",
                        'image' => 'https://images.unsplash.com/photo-1542856391-010fb87dcfed?auto=format&fit=crop&q=80&w=600',
                        'more_link' => 'https://id.wikipedia.org/wiki/Suku_Banjar',
                        'sort_order' => 1,
                    ]
                ],
                'heritage_page' => [
                    'hero_title' => 'Warisan Seni Luhur Suku Banjar',
                    'hero_description' => 'Temukan keindahan Rumah Bubungan Tinggi, kemewahan kain sasirangan pewarna alam, serta pertunjukan musik tradisional Panting.',
                    'hero_image' => 'https://images.unsplash.com/flagged/photo-1564134204899-4adebaf1adb3?auto=format&fit=crop&q=80&w=1200',
                ],
                'heritage_items' => [
                    [
                        'category' => 'rumah_tradisi',
                        'title' => 'Rumah Bubungan Tinggi',
                        'description' => 'Tipe rumah adat Banjar paling utama dengan bentuk atap tajam curam. Menggunakan tiang kayu ulin raksasa sebagai pondasi penopang di wilayah rawa dan sungai.',
                        'location' => 'Banjarmasin',
                        'detail_url' => 'https://id.wikipedia.org/wiki/Rumah_Bubungan_Tinggi',
                        'sort_order' => 1,
                    ],
                    [
                        'category' => 'pakaian',
                        'title' => 'Kain Sasirangan',
                        'description' => 'Kain tenun adat Banjar yang dibuat lewat teknik jelujur, jelajah benang, dan pewarnaan alami. Awalnya dipakai sebagai sarana penyembuhan spiritual penyakit non-medis.',
                        'location' => 'Martapura',
                        'detail_url' => 'https://id.wikipedia.org/wiki/Sasirangan',
                        'sort_order' => 2,
                    ]
                ],
                'history' => [
                    [
                        'year_label' => 'Tahun 1526',
                        'title' => 'Berdirinya Kesultanan Banjar',
                        'content' => 'Pangeran Samudra memeluk Islam dan mendirikan Kesultanan Banjar di Banjarmasin dengan bantuan militer Kesultanan Demak Jawa.',
                        'more_link' => 'https://id.wikipedia.org/wiki/Kesultanan_Banjar',
                        'order' => 1,
                    ]
                ],
                'destinations' => [
                    [
                        'name' => 'Pasar Terapung Lok Baintan',
                        'location' => 'Sungai Tabuk, Banjar',
                        'description' => 'Pasar tradisional di atas perahu jukung tradisional yang telah ada sejak era Kesultanan Banjar. Transaksi jual beli hasil bumi dilakukan di atas riak air sungai Martapura.',
                        'image_url' => 'https://images.unsplash.com/photo-1542856391-010fb87dcfed?auto=format&fit=crop&q=80&w=800',
                        'rating' => 4.9,
                        'sort_order' => 1,
                        'is_active' => true,
                        'latitude' => -3.298246,
                        'longitude' => 114.654321,
                        'pano_embed_url' => 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3979.52123456789!2d114.654321!3d-3.298246!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2df5cbaaaaaaaab%3A0x7777777777777778!2sPasar%20Terapung%20Lok%20Baintan!5e0!3m2!1sid!2sid!4v1700000000030',
                        'pano_maps_url' => 'https://maps.app.goo.gl/uXj9C5w95X9Z5w9X6',
                        'pano_label' => '360° Lok Baintan',
                    ]
                ],
                'quiz' => [
                    'title' => 'Kuis Kebudayaan Suku Banjar',
                    'questions' => [
                        [
                            'prompt_text' => 'Kain adat khas suku Banjar yang awalnya digunakan untuk sarana pengobatan spiritual dinamakan...',
                            'explanation' => 'Sasirangan merupakan kain batik rintik tradisional Banjar yang awalnya dipercaya memiliki khasiat menyembuhkan penyakit.',
                            'options' => [
                                ['content_text' => 'Ulos', 'is_correct' => false],
                                ['content_text' => 'Sasirangan', 'is_correct' => true],
                                ['content_text' => 'Songket', 'is_correct' => false],
                                ['content_text' => 'Batik Tulis', 'is_correct' => false],
                            ]
                        ]
                    ]
                ]
            ],
            [
                'island_slug' => 'kalimantan',
                'tribe_key' => 'Dayak',
                'about_page' => [
                    'label_small' => 'MENGENAL SUKU DAYAK',
                    'hero_title' => 'Harmoni Jagat Raya Suku Dayak Kalimantan',
                    'hero_description' => 'Suku Dayak merupakan suku asli pedalaman rimba pulau Kalimantan. Hidup selaras dengan alam hutan hujan tropis, menjunjung tinggi persaudaraan adat di dalam Rumah Betang, serta menjaga kearifan mistis leluhur.',
                    'more_link' => 'https://id.wikipedia.org/wiki/Suku_Dayak',
                ],
                'about_items' => [
                    [
                        'title' => 'Falsafah Rumah Betang (Lamin)',
                        'description' => 'Rumah panggung komunal sepanjang ratusan meter yang dihuni puluhan kepala keluarga secara damai. Rumah Betang merupakan simbol toleransi tinggi, gotong royong tanpa sekat perbedaan agama dan strata.',
                        'points' => "Kehidupan komunal harmonis multi-keluarga\nKebersamaan adat yang sangat dijaga tinggi\nPenyelesaian konflik lewat musyawarah adat",
                        'image' => 'https://images.unsplash.com/photo-1540555700478-4be289fbecef?auto=format&fit=crop&q=80&w=600',
                        'more_link' => 'https://id.wikipedia.org/wiki/Rumah_Betang',
                        'sort_order' => 1,
                    ]
                ],
                'heritage_page' => [
                    'hero_title' => 'Warisan Karya Seni Agung Suku Dayak',
                    'hero_description' => 'Jelajahi keluhuran ukiran ornamen motif naga dan burung enggang, kemerduan petikan alat musik Sape, serta ketangguhan pusaka Mandau.',
                    'hero_image' => 'https://images.unsplash.com/flagged/photo-1564134204899-4adebaf1adb3?auto=format&fit=crop&q=80&w=1200',
                ],
                'heritage_items' => [
                    [
                        'category' => 'senjata_alatmusik',
                        'title' => 'Sape',
                        'description' => 'Alat musik petik tradisional Dayak yang terbuat dari kayu pilihan dengan ornamen ukiran elok. Menghasilkan alunan petikan nada lembut sakral bernuansa alam rimba.',
                        'location' => 'Kapuas Hulu',
                        'detail_url' => 'https://id.wikipedia.org/wiki/Sape',
                        'sort_order' => 1,
                    ],
                    [
                        'category' => 'senjata_alatmusik',
                        'title' => 'Mandau',
                        'description' => 'Senjata tajam tradisional Dayak berupa pedang bermata tunggal dengan gagang tanduk rusa berhias rambut kuda. Menjadi pusaka turun-temurun lambang keberanian kesatria.',
                        'location' => 'Katingan',
                        'detail_url' => 'https://id.wikipedia.org/wiki/Mandau',
                        'sort_order' => 2,
                    ]
                ],
                'history' => [
                    [
                        'year_label' => 'Era Purba',
                        'title' => 'Peradaban Hutan Kalimantan',
                        'content' => 'Leluhur suku Dayak telah menetap di pedalaman hutan hujan tropis Kalimantan selama ribuan tahun, mengembangkan kearifan pemanfaatan alam tanpa merusak hutan.',
                        'more_link' => 'https://id.wikipedia.org/wiki/Suku_Dayak',
                        'order' => 1,
                    ]
                ],
                'destinations' => [
                    [
                        'name' => 'Desa Adat Pampang',
                        'location' => 'Samarinda, Kalimantan Timur',
                        'description' => 'Desa budaya Suku Dayak Kenyah yang menampilkan arsitektur Rumah Lamin megah penuh ukiran khas, serta pertunjukan tari tradisional setiap akhir pekan.',
                        'image_url' => 'https://images.unsplash.com/photo-1542856391-010fb87dcfed?auto=format&fit=crop&q=80&w=800',
                        'rating' => 4.8,
                        'sort_order' => 1,
                        'is_active' => true,
                        'latitude' => -0.362912,
                        'longitude' => 117.203912,
                        'pano_embed_url' => 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3979.62123456789!2d117.203912!3d-0.362912!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2df5cbaaaaaaaab%3A0x8888888888888889!2sDesa%20Adat%20Pampang!5e0!3m2!1sid!2sid!4v1700000000031',
                        'pano_maps_url' => 'https://maps.app.goo.gl/uXj9C5w95X9Z5w9X7',
                        'pano_label' => '360° Desa Pampang',
                    ]
                ],
                'quiz' => [
                    'title' => 'Kuis Kebudayaan Suku Dayak',
                    'questions' => [
                        [
                            'prompt_text' => 'Alat musik petik tradisional khas Suku Dayak yang terbuat dari kayu berhias ukiran ornamen elok dinamakan...',
                            'explanation' => 'Sape merupakan alat musik petik dawai tradisional khas suku Dayak Kalimantan.',
                            'options' => [
                                ['content_text' => 'Sasando', 'is_correct' => false],
                                ['content_text' => 'Sape', 'is_correct' => true],
                                ['content_text' => 'Saluang', 'is_correct' => false],
                                ['content_text' => 'Panting', 'is_correct' => false],
                            ]
                        ]
                    ]
                ]
            ],
            [
                'island_slug' => 'kalimantan',
                'tribe_key' => 'Kutai',
                'about_page' => [
                    'label_small' => 'MENGENAL SUKU KUTAI',
                    'hero_title' => 'Identitas Kebudayaan Melayu-Kutai di Kalimantan Timur',
                    'hero_description' => 'Suku Kutai mendiami wilayah sepanjang sungai Mahakam, Kalimantan Timur. Merupakan keturunan berasimilasi dari etnis Melayu dan Dayak Purba yang hidup di bawah naungan Kesultanan Kutai Kartanegara.',
                    'more_link' => 'https://id.wikipedia.org/wiki/Suku_Kutai',
                ],
                'about_items' => [
                    [
                        'title' => 'Asimilasi Kebudayaan Pesisir',
                        'description' => 'Kebudayaan Suku Kutai sangat dipengaruhi oleh adat Melayu pesisir dan berakar pada Islam, namun masih melestarikan beberapa pengaruh upacara ritual Hindu kuno warisan Kerajaan Mulawarman.',
                        'points' => "Bahasa Kutai rumpun Melayu\nRitual adat Erau tahunan yang akbar\nPesta air Belimbur penyucian diri",
                        'image' => 'https://images.unsplash.com/photo-1517486808906-6ca8b3f04846?auto=format&fit=crop&q=80&w=600',
                        'more_link' => 'https://id.wikipedia.org/wiki/Suku_Kutai',
                        'sort_order' => 1,
                    ]
                ],
                'heritage_page' => [
                    'hero_title' => 'Karya Warisan Kesultanan Kutai',
                    'hero_description' => 'Eksplorasi kemegahan busana Kustim Kesultanan, tari-tarian mistis seperti tari Jepen Kutai, serta istana Kedaton yang melegenda.',
                    'hero_image' => 'https://images.unsplash.com/flagged/photo-1564134204899-4adebaf1adb3?auto=format&fit=crop&q=80&w=1200',
                ],
                'heritage_items' => [
                    [
                        'category' => 'pakaian',
                        'title' => 'Baju Kustim',
                        'description' => 'Pakaian adat Kesultanan Kutai Kartanegara berupa beludru hitam berhias sulaman benang emas megah. Dahulu dikenakan eksklusif oleh keluarga raja dan pembesar istana.',
                        'location' => 'Tenggarong',
                        'detail_url' => 'https://id.wikipedia.org/wiki/Pakaian_adat_Kutai',
                        'sort_order' => 1,
                    ]
                ],
                'history' => [
                    [
                        'year_label' => 'Abad ke-4',
                        'title' => 'Berdirinya Kerajaan Kutai Martadipura',
                        'content' => 'Kerajaan Hindu tertua di Nusantara didirikan oleh Raja Kudungga di hulu sungai Mahakam, dibuktikan dengan prasasti Yupa batu bertulis.',
                        'more_link' => 'https://id.wikipedia.org/wiki/Kerajaan_Kutai',
                        'order' => 1,
                    ]
                ],
                'destinations' => [
                    [
                        'name' => 'Museum Mulawarman',
                        'location' => 'Tenggarong, Kutai Kartanegara',
                        'description' => 'Bekas istana Kesultanan Kutai Kartanegara yang kini menyimpan koleksi barang antik kerajaan, singgasana megah, arca kuno, serta replika prasasti Yupa.',
                        'image_url' => 'https://images.unsplash.com/photo-1599940824399-b87987ceb72a?auto=format&fit=crop&q=80&w=800',
                        'rating' => 4.7,
                        'sort_order' => 1,
                        'is_active' => true,
                        'latitude' => -0.414321,
                        'longitude' => 116.989213,
                        'pano_embed_url' => 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3979.80123456789!2d116.989213!3d-0.414321!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2df5cbaaaaaaaab%3A0x9999999999999990!2sMuseum%20Mulawarman!5e0!3m2!1sid!2sid!4v1700000000032',
                        'pano_maps_url' => 'https://maps.app.goo.gl/uXj9C5w95X9Z5w9X8',
                        'pano_label' => '360° Museum Mulawarman',
                    ]
                ],
                'quiz' => [
                    'title' => 'Kuis Kebudayaan Suku Kutai',
                    'questions' => [
                        [
                            'prompt_text' => 'Prasasti batu bertulis peninggalan kerajaan Hindu tertua Kutai Martadipura dinamakan...',
                            'explanation' => 'Yupa merupakan tiang batu bertulis huruf Pallawa bahasa Sanskerta lambang upacara kurban.',
                            'options' => [
                                ['content_text' => 'Prasasti Ciaruteun', 'is_correct' => false],
                                ['content_text' => 'Yupa', 'is_correct' => true],
                                ['content_text' => 'Talang Tuo', 'is_correct' => false],
                                ['content_text' => 'Prasasti Tugu', 'is_correct' => false],
                            ]
                        ]
                    ]
                ]
            ],

            // =========================================================================
            // SULAWESI (BUGIS, MAKASSAR, TORAJA)
            // =========================================================================
            [
                'island_slug' => 'sulawesi',
                'tribe_key' => 'Bugis',
                'about_page' => [
                    'label_small' => 'MENGENAL SUKU BUGIS',
                    'hero_title' => 'Kesatria Samudra Suku Bugis di Sulawesi Selatan',
                    'hero_description' => 'Suku Bugis merupakan etnis pelaut ulung pendominasi Sulawesi Selatan. Dikenal dengan prinsip adat harga diri (Siri\' na Pesse\'), kapal layar Pinisi yang perkasa merajai laut dunia, serta warisan sastra terpanjang dunia La Galigo.',
                    'more_link' => 'https://id.wikipedia.org/wiki/Suku_Bugis',
                ],
                'about_items' => [
                    [
                        'title' => 'Falsafah Siri\' na Pesse',
                        'description' => 'Harga diri (Siri\') dan rasa empati kesetiakawanan (Pesse) merupakan pilar kepribadian utama suku Bugis. Menjaga Siri\' adalah kewajiban hidup mati yang menuntun kehormatan diri dan sosial keluarga.',
                        'points' => "Siri' (Harga diri moral tertinggi)\nPesse (Rasa empati senasib sepenanggungan)\nKeberanian merantau mengarungi samudra",
                        'image' => 'https://images.unsplash.com/photo-1540555700478-4be289fbecef?auto=format&fit=crop&q=80&w=600',
                        'more_link' => 'https://id.wikipedia.org/wiki/Siri%27',
                        'sort_order' => 1,
                    ]
                ],
                'heritage_page' => [
                    'hero_title' => 'Warisan Kebudayaan Agung Suku Bugis',
                    'hero_description' => 'Saksikan keanggunan tenun Sarung Sutera Sabbe, arsitektur Rumah Panggung Saoraja, kegagahan pusaka Badik, serta pembuatan Kapal Pinisi.',
                    'hero_image' => 'https://images.unsplash.com/photo-1612091508912-2136973784c3?auto=format&fit=crop&q=80&w=1200',
                ],
                'heritage_items' => [
                    [
                        'category' => 'senjata_alatmusik',
                        'title' => 'Kapal Pinisi',
                        'description' => 'Kapal layar kayu tradisional legendaris bersayap sekunar yang dirancang tanpa cetak biru dan paku besi. Diakui UNESCO sebagai Warisan Budaya Takbenda Dunia.',
                        'location' => 'Bulukumba',
                        'detail_url' => 'https://id.wikipedia.org/wiki/Pinisi',
                        'sort_order' => 1,
                    ],
                    [
                        'category' => 'pakaian',
                        'title' => 'Baju Bodo',
                        'description' => 'Busana adat wanita Bugis berbentuk segi empat longgar berlengan pendek, terbuat dari tenunan serat alam sutera. Dianggap sebagai salah satu pakaian tertua di dunia.',
                        'location' => 'Bone',
                        'detail_url' => 'https://id.wikipedia.org/wiki/Baju_Bodo',
                        'sort_order' => 2,
                    ]
                ],
                'history' => [
                    [
                        'year_label' => 'Abad ke-14',
                        'title' => 'Karya Sastra Epik Sureq Galigo',
                        'content' => 'Sureq Galigo atau La Galigo digubah, sebuah epos mitologi terpanjang dunia melebihi kitab Mahabharata dari India.',
                        'more_link' => 'https://id.wikipedia.org/wiki/La_Galigo',
                        'order' => 1,
                    ]
                ],
                'destinations' => [
                    [
                        'name' => 'Tanjung Bira (Pusat Kapal Pinisi)',
                        'location' => 'Bulukumba, Sulawesi Selatan',
                        'description' => 'Pesisir pantai putih elok yang terkenal sebagai tempat para pengrajin andal merakit struktur Kapal Pinisi kayu secara manual menggunakan keterampilan turun-temurun.',
                        'image_url' => 'https://images.unsplash.com/photo-1542856391-010fb87dcfed?auto=format&fit=crop&q=80&w=800',
                        'rating' => 4.9,
                        'sort_order' => 1,
                        'is_active' => true,
                        'latitude' => -5.614321,
                        'longitude' => 120.454321,
                        'pano_embed_url' => 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3978.20123456789!2d120.454321!3d-5.614321!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2db5cbaaaaaaaab%3A0x7777777777777790!2sTanjung%20Bira!5e0!3m2!1sid!2sid!4v1700000000040',
                        'pano_maps_url' => 'https://maps.app.goo.gl/uXj9C5w95X9Z5w9X9',
                        'pano_label' => '360° Tanjung Bira',
                    ]
                ],
                'quiz' => [
                    'title' => 'Kuis Kebudayaan Suku Bugis',
                    'questions' => [
                        [
                            'prompt_text' => 'Karya sastra epik terpanjang di dunia yang menjadi mitologi suci suku Bugis bernama...',
                            'explanation' => 'La Galigo atau Sureq Galigo merupakan manuskrip epik Bugis kuno terpanjang di dunia.',
                            'options' => [
                                ['content_text' => 'Negarakertagama', 'is_correct' => false],
                                ['content_text' => 'La Galigo', 'is_correct' => true],
                                ['content_text' => 'Mahabharata', 'is_correct' => false],
                                ['content_text' => 'Babad Tanah Jawi', 'is_correct' => false],
                            ]
                        ]
                    ]
                ]
            ],
            [
                'island_slug' => 'sulawesi',
                'tribe_key' => 'Makassar',
                'about_page' => [
                    'label_small' => 'MENGENAL SUKU MAKASSAR',
                    'hero_title' => 'Keberanian & Budaya Luhur Suku Makassar',
                    'hero_description' => 'Suku Makassar mendiami pesisir selatan Sulawesi Selatan, berkerabat dekat dengan Bugis. Terkenal sebagai suku pembangun kerajaan maritim Gowa-Tallo yang sangat berwibawa menentang monopoli barat.',
                    'more_link' => 'https://id.wikipedia.org/wiki/Suku_Makassar',
                ],
                'about_items' => [
                    [
                        'title' => 'Prinsip Keteguhan Jiwa Maritim',
                        'description' => 'Masyarakat Makassar memiliki falsafah pelaut pemberani "Sekali Layar Terkembang, Surut Pantang Biduk Rapat ke Pantai" yang mencerminkan keteguhan tekad berjuang hingga titik darah penghabisan.',
                        'points' => "Tekad membaja pantang mundur\nSejarah kejayaan pelabuhan perdagangan bebas Somba Opu\nKetaatan Islam berakar adat",
                        'image' => 'https://images.unsplash.com/photo-1517486808906-6ca8b3f04846?auto=format&fit=crop&q=80&w=600',
                        'more_link' => 'https://id.wikipedia.org/wiki/Suku_Makassar',
                        'sort_order' => 1,
                    ]
                ],
                'heritage_page' => [
                    'hero_title' => 'Warisan Kebudayaan Agung Suku Makassar',
                    'hero_description' => 'Eksplorasi kemegahan Benteng Somba Opu, keunikan pakaian adat perkawinan, tari kipas Pakarena yang magis, serta keberanian prajurit kerajaan Gowa.',
                    'hero_image' => 'https://images.unsplash.com/photo-1612091508912-2136973784c3?auto=format&fit=crop&q=80&w=1200',
                ],
                'heritage_items' => [
                    [
                        'category' => 'senjata_alatmusik',
                        'title' => 'Badik Lompo Battang',
                        'description' => 'Senjata tajam tradisional Makassar dengan bilah khas bermata satu dan hiasan ukiran pamor besi meliuk. Melambangkan pusaka kehormatan lelaki Makassar.',
                        'location' => 'Gowa',
                        'detail_url' => 'https://id.wikipedia.org/wiki/Badik',
                        'sort_order' => 1,
                    ]
                ],
                'history' => [
                    [
                        'year_label' => 'Abad ke-17',
                        'title' => 'Pemerintahan Sultan Hasanuddin',
                        'content' => 'Sultan Hasanuddin, Raja Gowa ke-16, dijuluki Belanda "Ayam Jantan dari Timur" memimpin pertempuran laut sengit mempertahankan kemerdekaan Selat Makassar.',
                        'more_link' => 'https://id.wikipedia.org/wiki/Sultan_Hasanuddin',
                        'order' => 1,
                    ]
                ],
                'destinations' => [
                    [
                        'name' => 'Benteng Fort Rotterdam',
                        'location' => 'Makassar',
                        'description' => 'Kompleks benteng kokoh batu karang peninggalan Kerajaan Gowa-Tallo abad ke-16 yang awalnya bernama Benteng Panyyua (Penyu) sebelum direbut Belanda.',
                        'image_url' => 'https://images.unsplash.com/photo-1599940824399-b87987ceb72a?auto=format&fit=crop&q=80&w=800',
                        'rating' => 4.8,
                        'sort_order' => 1,
                        'is_active' => true,
                        'latitude' => -5.133912,
                        'longitude' => 119.408912,
                        'pano_embed_url' => 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3978.89123456789!2d119.408912!3d-5.133912!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2db5cbaaaaaaaab%3A0x7777777777777791!2sFort%20Rotterdam!5e0!3m2!1sid!2sid!4v1700000000041',
                        'pano_maps_url' => 'https://maps.app.goo.gl/uXj9C5w95X9Z5w9Y0',
                        'pano_label' => '360° Fort Rotterdam',
                    ]
                ],
                'quiz' => [
                    'title' => 'Kuis Kebudayaan Suku Makassar',
                    'questions' => [
                        [
                            'prompt_text' => 'Apakah nama tari tradisional khas Makassar yang dimainkan berkelompok menggunakan kipas lipat dengan gerakan anggun melambangkan kesantunan wanita?',
                            'explanation' => 'Tari Pakarena merupakan tarian magis khas Makassar yang mengekspresikan karakter kelembutan wanita Makassar.',
                            'options' => [
                                ['content_text' => 'Tari Saman', 'is_correct' => false],
                                ['content_text' => 'Tari Pakarena', 'is_correct' => true],
                                ['content_text' => 'Tari Kecak', 'is_correct' => false],
                                ['content_text' => 'Tari Jaipong', 'is_correct' => false],
                            ]
                        ]
                    ]
                ]
            ],
            [
                'island_slug' => 'sulawesi',
                'tribe_key' => 'Toraja',
                'about_page' => [
                    'label_small' => 'MENGENAL SUKU TORAJA',
                    'hero_title' => 'Tradisi Sakral & Makam Tebing Suku Toraja',
                    'hero_description' => 'Suku Toraja mendiami daerah pegunungan Tana Toraja di Sulawesi Selatan. Sangat terkenal di dunia internasional karena upacara pemakaman adat Ramboe Solo, seni pahat batu tebing, serta filosofi arsitektur Rumah Tongkonan.',
                    'more_link' => 'https://id.wikipedia.org/wiki/Suku_Toraja',
                ],
                'about_items' => [
                    [
                        'title' => 'Upacara Pemakaman Rambu Solo\'',
                        'description' => 'Upacara pesta kematian akbar Ramboe Solo bertujuan mengantarkan arwah leluhur menuju alam keabadian (Puya). Upacara ini melibatkan ritual kurban kerbau lumpur belang (Tedong Bonga) berharga fantastis.',
                        'points' => "Ritual kematian terbesar di dunia\nPenyembelihan kerbau belang Tedong Bonga\nMakam gua tebing batu alam",
                        'image' => 'https://images.unsplash.com/photo-1540555700478-4be289fbecef?auto=format&fit=crop&q=80&w=600',
                        'more_link' => 'https://id.wikipedia.org/wiki/Rambu_Solo%27',
                        'sort_order' => 1,
                    ]
                ],
                'heritage_page' => [
                    'hero_title' => 'Karya Seni Agung Spiritual Toraja',
                    'hero_description' => 'Temukan kemegahan Rumah Tongkonan dengan hiasan susunan tanduk kerbau di tiang utama, seni ukir kayu bermotif simbolis, serta patung kayu Tau-Tau.',
                    'hero_image' => 'https://images.unsplash.com/photo-1612091508912-2136973784c3?auto=format&fit=crop&q=80&w=1200',
                ],
                'heritage_items' => [
                    [
                        'category' => 'rumah_tradisi',
                        'title' => 'Rumah Tongkonan',
                        'description' => 'Rumah adat kayu Toraja berbentuk panggung dengan atap melengkung menyerupai perahu. Bagian depan dihiasi tanduk kerbau lambang strata kehormatan pemilik.',
                        'location' => 'Tana Toraja',
                        'detail_url' => 'https://id.wikipedia.org/wiki/Tongkonan',
                        'sort_order' => 1,
                    ],
                    [
                        'category' => 'senjata_alatmusik',
                        'title' => 'Tau-Tau',
                        'description' => 'Patung pahatan kayu berwujud replika orang mati yang diletakkan di balkon dinding tebing makam gua batu sebagai pelindung arwah leluhur.',
                        'location' => 'Toraja Utara',
                        'detail_url' => 'https://id.wikipedia.org/wiki/Tau-tau',
                        'sort_order' => 2,
                    ]
                ],
                'history' => [
                    [
                        'year_label' => 'Abad ke-20',
                        'title' => 'Pengenalan Dunia Internasional',
                        'content' => 'Wilayah Tana Toraja mulai terbuka luas bagi penelitian etnografi dan pariwisata dunia semenjak kedatangan misionaris Eropa yang mendokumentasikan adat purba aluk to dolo.',
                        'more_link' => 'https://id.wikipedia.org/wiki/Suku_Toraja',
                        'order' => 1,
                    ]
                ],
                'destinations' => [
                    [
                        'name' => 'Situs Adat Kete Kesu',
                        'location' => 'Toraja Utara',
                        'description' => 'Desa adat purba Toraja berusia ratusan tahun yang menyajikan jajaran Tongkonan utuh berornamen elok, lumbung padi alang, serta makam tebing gantung kuno.',
                        'image_url' => 'https://images.unsplash.com/photo-1542856391-010fb87dcfed?auto=format&fit=crop&q=80&w=800',
                        'rating' => 4.9,
                        'sort_order' => 1,
                        'is_active' => true,
                        'latitude' => -3.024567,
                        'longitude' => 119.892456,
                        'pano_embed_url' => 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3978.70123456789!2d119.892456!3d-3.024567!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2db5cbaaaaaaaab%3A0x7777777777777792!2sKe%27te%20Kesu%27!5e0!3m2!1sid!2sid!4v1700000000042',
                        'pano_maps_url' => 'https://maps.app.goo.gl/uXj9C5w95X9Z5w9Y1',
                        'pano_label' => '360° Kete Kesu',
                    ]
                ],
                'quiz' => [
                    'title' => 'Kuis Kebudayaan Suku Toraja',
                    'questions' => [
                        [
                            'prompt_text' => 'Upacara adat pesta pemakaman kematian yang sangat megah di Tana Toraja dinamakan...',
                            'explanation' => 'Rambu Solo\' adalah upacara adat pemakaman akbar suku Toraja yang berlangsung berhari-hari.',
                            'options' => [
                                ['content_text' => 'Erau', 'is_correct' => false],
                                ['content_text' => 'Rambu Solo\'', 'is_correct' => true],
                                ['content_text' => 'Ma\'nene\'', 'is_correct' => false],
                                ['content_text' => 'Belimbur', 'is_correct' => false],
                            ]
                        ]
                    ]
                ]
            ],

            // =========================================================================
            // BALI & NUSA TENGGARA (BALI, SASAK, ATONI)
            // =========================================================================
            [
                'island_slug' => 'bali-nusa-tenggara',
                'tribe_key' => 'Bali',
                'about_page' => [
                    'label_small' => 'MENGENAL SUKU BALI',
                    'hero_title' => 'Seni Agung & Nilai Spiritual Suku Bali',
                    'hero_description' => 'Suku Bali mendiami Pulau Dewata Bali. Dikenal dengan corak kebudayaan Hindu Dharma yang kental, keindahan tari Kecak dan Barong, ritual ngaben, serta tata krama sosial berlandaskan konsep Tri Hita Karana.',
                    'more_link' => 'https://id.wikipedia.org/wiki/Suku_Bali',
                ],
                'about_items' => [
                    [
                        'title' => 'Filosofi Tri Hita Karana',
                        'description' => 'Prinsip keseimbangan hidup berlandaskan keharmonisan tiga hubungan: Parahyangan (hubungan manusia dengan Tuhan), Pawongan (hubungan manusia dengan sesama), dan Palemahan (hubungan manusia dengan alam sekitar).',
                        'points' => "Harmoni spiritual teologis\nKerukunan sosial kemanusiaan\nKelestarian alam ekologi (Subak)",
                        'image' => 'https://images.unsplash.com/photo-1540555700478-4be289fbecef?auto=format&fit=crop&q=80&w=600',
                        'more_link' => 'https://id.wikipedia.org/wiki/Tri_Hita_Karana',
                        'sort_order' => 1,
                    ]
                ],
                'heritage_page' => [
                    'hero_title' => 'Warisan Kebudayaan Agung Suku Bali',
                    'hero_description' => 'Eksplorasi kemegahan Pura Hindu kuno, keindahan seni pahat ukir emas, alunan gamelan Gong Kebyar, serta keanggunan kain tenun Endek.',
                    'hero_image' => 'https://images.unsplash.com/photo-1741272689174-f7f03b09a0ab?auto=format&fit=crop&q=80&w=1200',
                ],
                'heritage_items' => [
                    [
                        'category' => 'senjata_alatmusik',
                        'title' => 'Gamelan Gong Kebyar',
                        'description' => 'Ensembel perkusi perunggu Bali dengan gaya tiupan nada yang sangat dinamis, meledak-ledak, dan penuh energi mengiringi gerak tari dinamis.',
                        'location' => 'Gianyar',
                        'detail_url' => 'https://id.wikipedia.org/wiki/Gong_Kebyar',
                        'sort_order' => 1,
                    ]
                ],
                'history' => [
                    [
                        'year_label' => 'Abad ke-14',
                        'title' => 'Pengaruh Ekspansi Majapahit',
                        'content' => 'Kerajaan Majapahit memperluas pengaruh kekuasaan di Bali, memicu integrasi kebudayaan kraton Jawa Kuno dengan tradisi asli Bali Aga.',
                        'more_link' => 'https://id.wikipedia.org/wiki/Sejarah_Bali',
                        'order' => 1,
                    ]
                ],
                'destinations' => [
                    [
                        'name' => 'Pura Tanah Lot',
                        'location' => 'Tabanan, Bali',
                        'description' => 'Kuil suci Hindu Bali bersejarah yang berdiri kokoh di atas batu karang besar di tengah deburan ombak samudra, terkenal dengan pemandangan matahari terbenam.',
                        'image_url' => 'https://images.unsplash.com/photo-1741272689174-f7f03b09a0ab?auto=format&fit=crop&q=80&w=800',
                        'rating' => 4.9,
                        'sort_order' => 1,
                        'is_active' => true,
                        'latitude' => -8.621254,
                        'longitude' => 115.086254,
                        'pano_embed_url' => 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3979.70123456789!2d115.086254!3d-8.621254!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2dd6cbaaaaaaaab%3A0x7777777777777793!2sTanah%20Lot!5e0!3m2!1sid!2sid!4v1700000000050',
                        'pano_maps_url' => 'https://maps.app.goo.gl/uXj9C5w95X9Z5w9Y2',
                        'pano_label' => '360° Tanah Lot',
                    ]
                ],
                'quiz' => [
                    'title' => 'Kuis Kebudayaan Suku Bali',
                    'questions' => [
                        [
                            'prompt_text' => 'Falsafah hidup suku Bali yang mengajarkan keharmonisan hubungan manusia dengan Tuhan, sesama, dan alam alam dinamakan...',
                            'explanation' => 'Tri Hita Karana merupakan falsafah kearifan lokal Bali penuntun keharmonisan hidup.',
                            'options' => [
                                ['content_text' => 'Tri Kaya Parisudha', 'is_correct' => false],
                                ['content_text' => 'Tri Hita Karana', 'is_correct' => true],
                                ['content_text' => 'Tat Twam Asi', 'is_correct' => false],
                                ['content_text' => 'Tri Murti', 'is_correct' => false],
                            ]
                        ]
                    ]
                ]
            ],
            [
                'island_slug' => 'bali-nusa-tenggara',
                'tribe_key' => 'Sasak',
                'about_page' => [
                    'label_small' => 'MENGENAL SUKU SASAK',
                    'hero_title' => 'Kebudayaan Tradisional Suku Sasak Lombok',
                    'hero_description' => 'Suku Sasak mendiami Pulau Lombok, Nusa Tenggara Barat. Dikenal dengan adat tenun ikat Songket Sasak yang indah, rumah adat Bale Tani berlantai kotoran sapi, serta bela diri Presean yang berani.',
                    'more_link' => 'https://id.wikipedia.org/wiki/Suku_Sasak',
                ],
                'about_items' => [
                    [
                        'title' => 'Tradisi Menenun Ikat (Sakeco)',
                        'description' => 'Menenun kain Songket secara manual merupakan kewajiban bagi setiap gadis remaja suku Sasak sebelum diizinkan menikah. Kemahiran menenun diwariskan turun-temurun sebagai lambang kedewasaan wanita.',
                        'points' => "Tenunan ikat songket motif khas\nSimbol kemandirian wanita Sasak\nPenggunaan alat tenun kayu tradisional",
                        'image' => 'https://images.unsplash.com/photo-1517486808906-6ca8b3f04846?auto=format&fit=crop&q=80&w=600',
                        'more_link' => 'https://id.wikipedia.org/wiki/Kain_Tenun_Sasak',
                        'sort_order' => 1,
                    ]
                ],
                'heritage_page' => [
                    'hero_title' => 'Warisan Kebudayaan Luhur Suku Sasak',
                    'hero_description' => 'Kunjungi rumah adat Bale Tani berdinding tanah liat campur kotoran kerbau, pertunjukan tarung perisai Presean, serta alunan musik tradisional Gendang Beleq.',
                    'hero_image' => 'https://images.unsplash.com/photo-1741272689174-f7f03b09a0ab?auto=format&fit=crop&q=80&w=1200',
                ],
                'heritage_items' => [
                    [
                        'category' => 'rumah_tradisi',
                        'title' => 'Bale Tani',
                        'description' => 'Rumah tinggal adat Sasak dengan atap jerami alang-alang menyentuh rendah. Lantai tanah liatnya dilapisi gosokan kotoran sapi segar agar awet tahan retak dan menangkal nyamuk.',
                        'location' => 'Lombok Tengah',
                        'detail_url' => 'https://id.wikipedia.org/wiki/Rumah_adat_Sasak',
                        'sort_order' => 1,
                    ]
                ],
                'history' => [
                    [
                        'year_label' => 'Abad ke-17',
                        'title' => 'Berdirinya Kerajaan Selaparang',
                        'content' => 'Kerajaan Islam Selaparang tumbuh menjadi pusat kekuasaan maritim yang kuat di Lombok sebelum mendapat ekspansi militer Bali Karangasem.',
                        'more_link' => 'https://id.wikipedia.org/wiki/Kerajaan_Selaparang',
                        'order' => 1,
                    ]
                ],
                'destinations' => [
                    [
                        'name' => 'Desa Adat Sade',
                        'location' => 'Pujut, Lombok Tengah',
                        'description' => 'Dusun adat Suku Sasak yang masih melestarikan keaslian pemukiman Bale Tani, tradisi menenun songket, serta tarian khas penyambutan tamu.',
                        'image_url' => 'https://images.unsplash.com/photo-1542856391-010fb87dcfed?auto=format&fit=crop&q=80&w=800',
                        'rating' => 4.8,
                        'sort_order' => 1,
                        'is_active' => true,
                        'latitude' => -8.839124,
                        'longitude' => 116.292456,
                        'pano_embed_url' => 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3979.50123456789!2d116.292456!3d-8.839124!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2dd6dbaaaaaaaab%3A0x7777777777777794!2sDesa%20Adat%20Sade!5e0!3m2!1sid!2sid!4v1700000000051',
                        'pano_maps_url' => 'https://maps.app.goo.gl/uXj9C5w95X9Z5w9Y3',
                        'pano_label' => '360° Desa Sade',
                    ]
                ],
                'quiz' => [
                    'title' => 'Kuis Kebudayaan Suku Sasak',
                    'questions' => [
                        [
                            'prompt_text' => 'Bahan alami yang digunakan oleh masyarakat Sasak untuk mengepel lantai tanah rumah adat Bale Tani adalah...',
                            'explanation' => 'Kotoran kerbau atau sapi digunakan untuk melapisi lantai tanah liat agar lebih padat, bersih, dan menangkal serangga.',
                            'options' => [
                                ['content_text' => 'Tanah liat merah', 'is_correct' => false],
                                ['content_text' => 'Kotoran sapi/kerbau', 'is_correct' => true],
                                ['content_text' => 'Air garam hangat', 'is_correct' => false],
                                ['content_text' => 'Santan kelapa', 'is_correct' => false],
                            ]
                        ]
                    ]
                ]
            ],
            [
                'island_slug' => 'bali-nusa-tenggara',
                'tribe_key' => 'Atoni',
                'about_page' => [
                    'label_small' => 'MENGENAL SUKU ATONI',
                    'hero_title' => 'Budaya Bersahaja Suku Atoni di Pulau Timor',
                    'hero_description' => 'Suku Atoni (dikenal juga sebagai Suku Dawan) mendiami pedalaman bukit kering Pulau Timor, Nusa Tenggara Timur. Menjaga harmoni kehidupan bersahaja lewat adat pertimbangan alam serta tenunan ikat tenun motif geometris.',
                    'more_link' => 'https://id.wikipedia.org/wiki/Suku_Atoni',
                ],
                'about_items' => [
                    [
                        'title' => 'Kearifan Rumah Bulat Ume Khubu',
                        'description' => 'Masyarakat Atoni mendiami pemukiman rumah bulat beratap rumbia rapat hingga menyentuh tanah (Ume Khubu). Arsitekturnya didesain menyimpan kehangatan dari embusan angin bukit dingin Timor.',
                        'points' => "Rumah Ume Khubu tahan badai angin bukit\nSistem penyimpanan pangan gantung di atap\nSimbol perlindungan keluarga",
                        'image' => 'https://images.unsplash.com/photo-1540555700478-4be289fbecef?auto=format&fit=crop&q=80&w=600',
                        'more_link' => 'https://id.wikipedia.org/wiki/Suku_Atoni',
                        'sort_order' => 1,
                    ]
                ],
                'heritage_page' => [
                    'hero_title' => 'Karya Budaya Leluhur Atoni',
                    'hero_description' => 'Eksplorasi adat perkawinan Timor kuno, keindahan tenunan kain ikat motif burung, serta keunikan tarian perang Likurai.',
                    'hero_image' => 'https://images.unsplash.com/photo-1741272689174-f7f03b09a0ab?auto=format&fit=crop&q=80&w=1200',
                ],
                'heritage_items' => [
                    [
                        'category' => 'rumah_tradisi',
                        'title' => 'Ume Khubu',
                        'description' => 'Rumah tradisional bulat khas Atoni dengan tiang kayu berpusat tunggal dan atap jerami tebal menyentuh tanah tanpa jendela untuk menjaga suhu hangat.',
                        'location' => 'Kefamenanu',
                        'detail_url' => 'https://id.wikipedia.org/wiki/Suku_Atoni',
                        'sort_order' => 1,
                    ]
                ],
                'history' => [
                    [
                        'year_label' => 'Abad ke-16',
                        'title' => 'Kontak Perdagangan Kayu Cendana',
                        'content' => 'Leluhur Suku Atoni di pedalaman Timor bertransaksi dengan pedagang Portugis dan Belanda barter kayu cendana wangi bernilai tinggi.',
                        'more_link' => 'https://id.wikipedia.org/wiki/Suku_Atoni',
                        'order' => 1,
                    ]
                ],
                'destinations' => [
                    [
                        'name' => 'Kampung Adat Maslete',
                        'location' => 'Kefamenanu, Timor Tengah Utara',
                        'description' => 'Kompleks dusun adat suku Atoni yang mempertahankan deretan rumah bulat Ume Khubu dan tatanan batu ritual pemujaan roh leluhur.',
                        'image_url' => 'https://images.unsplash.com/photo-1542856391-010fb87dcfed?auto=format&fit=crop&q=80&w=800',
                        'rating' => 4.6,
                        'sort_order' => 1,
                        'is_active' => true,
                        'latitude' => -9.456123,
                        'longitude' => 124.456789,
                        'pano_embed_url' => 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3979.30123456789!2d124.456789!3d-9.456123!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2dd6dbaaaaaaaab%3A0x7777777777777795!2sKampung%20Maslete!5e0!3m2!1sid!2sid!4v1700000000052',
                        'pano_maps_url' => 'https://maps.app.goo.gl/uXj9C5w95X9Z5w9Y4',
                        'pano_label' => '360° Kampung Maslete',
                    ]
                ],
                'quiz' => [
                    'title' => 'Kuis Kebudayaan Suku Atoni',
                    'questions' => [
                        [
                            'prompt_text' => 'Rumah adat berbentuk bulat tanpa jendela milik suku Atoni di Timor dinamakan...',
                            'explanation' => 'Ume Khubu merupakan rumah bulat khas Timor untuk menghalau dingin pegunungan.',
                            'options' => [
                                ['content_text' => 'Bale Tani', 'is_correct' => false],
                                ['content_text' => 'Ume Khubu', 'is_correct' => true],
                                ['content_text' => 'Rumah Lamin', 'is_correct' => false],
                                ['content_text' => 'Rumah Bolon', 'is_correct' => false],
                            ]
                        ]
                    ]
                ]
            ],

            // =========================================================================
            // PAPUA & MALUKU (ASMAT, AMUNGME, AMBON)
            // =========================================================================
            [
                'island_slug' => 'papua-maluku',
                'tribe_key' => 'Asmat',
                'about_page' => [
                    'label_small' => 'MENGENAL SUKU ASMAT',
                    'hero_title' => 'Seni Ukir Mistis Suku Asmat di Papua Selatan',
                    'hero_description' => 'Suku Asmat mendiami pesisir berawa Papua Selatan. Terkenal secara internasional dengan mahakarya seni ukir kayu magis tanpa pola yang diukir langsung sebagai sarana komunikasi dengan arwah leluhur.',
                    'more_link' => 'https://id.wikipedia.org/wiki/Suku_Asmat',
                ],
                'about_items' => [
                    [
                        'title' => 'Filosofi Seni Pahat Ukir Kayu',
                        'description' => 'Bagi suku Asmat, memahat ukiran kayu bukan sekadar profesi seni melainkan panggilan sakral ritual keagamaan purba. Setiap pahatan tiang (Bis Pole) melambangkan arwah leluhur pelindung suku.',
                        'points' => "Seni ukir tanpa garis pola awal\nKoneksi spiritual leluhur lewat kayu\nPengakuan kurator seni rupa dunia",
                        'image' => 'https://images.unsplash.com/photo-1540555700478-4be289fbecef?auto=format&fit=crop&q=80&w=600',
                        'more_link' => 'https://id.wikipedia.org/wiki/Seni_ukir_Asmat',
                        'sort_order' => 1,
                    ]
                ],
                'heritage_page' => [
                    'hero_title' => 'Mahakarya Seni Budaya Suku Asmat',
                    'hero_description' => 'Temukan kemegahan Tiang Ritual Bis, rumah adat komunal khusus pria Jew, serta tabuhan alat musik perkusi kayu Tifa.',
                    'hero_image' => 'https://images.unsplash.com/photo-1703769605297-cc74106244d9?auto=format&fit=crop&q=80&w=1200',
                ],
                'heritage_items' => [
                    [
                        'category' => 'rumah_tradisi',
                        'title' => 'Rumah Jew (Rumah Bujang)',
                        'description' => 'Rumah panggung panjang komunal khusus pria dewasa Asmat. Berfungsi sebagai balai ritual keagamaan, musyawarah adat, dan tempat melatih kepemimpinan.',
                        'location' => 'Agats',
                        'detail_url' => 'https://id.wikipedia.org/wiki/Suku_Asmat',
                        'sort_order' => 1,
                    ],
                    [
                        'category' => 'senjata_alatmusik',
                        'title' => 'Tifa Asmat',
                        'description' => 'Alat musik perkusi pukul sejenis gendang tabung kayu panjang berhias ukiran, bermembrankan kulit biawak/ular laut yang direkatkan lem alami.',
                        'location' => 'Asmat',
                        'detail_url' => 'https://id.wikipedia.org/wiki/Tifa',
                        'sort_order' => 2,
                    ]
                ],
                'history' => [
                    [
                        'year_label' => 'Tahun 1961',
                        'title' => 'Hilangnya Michael Rockefeller',
                        'content' => 'Ekspedisi Michael Rockefeller, putra gubernur New York mengumpulkan seni ukir kayu Asmat berakhir misterius di perairan Asmat, memicu eksposur besar dunia.',
                        'more_link' => 'https://id.wikipedia.org/wiki/Michael_Rockefeller',
                        'order' => 1,
                    ]
                ],
                'destinations' => [
                    [
                        'name' => 'Taman Nasional Lorentz (Wilayah Asmat)',
                        'location' => 'Papua Selatan',
                        'description' => 'Taman nasional terbesar di Asia Tenggara yang membentang dari puncak bersalju abadi hingga hutan bakau pesisir yang dihuni suku Asmat.',
                        'image_url' => 'https://images.unsplash.com/photo-1542856391-010fb87dcfed?auto=format&fit=crop&q=80&w=800',
                        'rating' => 4.9,
                        'sort_order' => 1,
                        'is_active' => true,
                        'latitude' => -4.839124,
                        'longitude' => 137.924567,
                        'pano_embed_url' => 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3979.50123456789!2d137.924567!3d-4.839124!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2dd6dbaaaaaaaab%3A0x7777777777777796!2sTaman%20Nasional%20Lorentz!5e0!3m2!1sid!2sid!4v1700000000060',
                        'pano_maps_url' => 'https://maps.app.goo.gl/uXj9C5w95X9Z5w9Y5',
                        'pano_label' => '360° Lorentz',
                    ]
                ],
                'quiz' => [
                    'title' => 'Kuis Kebudayaan Suku Asmat',
                    'questions' => [
                        [
                            'prompt_text' => 'Rumah panggung tradisional khusus kaum pria suku Asmat sebagai pusat musyawarah adat dinamakan...',
                            'explanation' => 'Rumah Jew (Rumah Bujang) merupakan pusat adat dan spiritual khusus pria Asmat.',
                            'options' => [
                                ['content_text' => 'Tongkonan', 'is_correct' => false],
                                ['content_text' => 'Rumah Jew', 'is_correct' => true],
                                ['content_text' => 'Rumah Bolon', 'is_correct' => false],
                                ['content_text' => 'Ume Khubu', 'is_correct' => false],
                            ]
                        ]
                    ]
                ]
            ],
            [
                'island_slug' => 'papua-maluku',
                'tribe_key' => 'Amungme',
                'about_page' => [
                    'label_small' => 'MENGENAL SUKU AMUNGME',
                    'hero_title' => 'Kearifan Gunung Suku Amungme di Pegunungan Papua',
                    'hero_description' => 'Suku Amungme mendiami lereng-lereng gunung tinggi pegunungan tengah Papua, termasuk sekitar puncak bersalju Cartensz. Menganggap gunung sebagai kepala ibu suci leluhur yang wajib dijaga keasliannya.',
                    'more_link' => 'https://id.wikipedia.org/wiki/Suku_Amungme',
                ],
                'about_items' => [
                    [
                        'title' => 'Filosofi Suci Pegunungan',
                        'description' => 'Bagi Amungme, tanah, lembah, dan gunung tinggi adalah tubuh hidup dari ibu kandung leluhur mereka. Keyakinan kuat ini melahirkan perjuangan ekologis menjaga alam dari eksploitasi berlebihan.',
                        'points' => "Gunung sebagai kepala ibu suci leluhur\nHubungan mendalam dengan kelestarian alam\nTradisi pertanian ubi di lereng gunung",
                        'image' => 'https://images.unsplash.com/photo-1540555700478-4be289fbecef?auto=format&fit=crop&q=80&w=600',
                        'more_link' => 'https://id.wikipedia.org/wiki/Suku_Amungme',
                        'sort_order' => 1,
                    ]
                ],
                'heritage_page' => [
                    'hero_title' => 'Warisan Kebudayaan Leluhur Suku Amungme',
                    'hero_description' => 'Eksplorasi busana adat koteka dan sali, kerajinan rajutan tas Noken serat kayu alami, serta tradisi upacara Bakar Batu.',
                    'hero_image' => 'https://images.unsplash.com/photo-1703769605297-cc74106244d9?auto=format&fit=crop&q=80&w=1200',
                ],
                'heritage_items' => [
                    [
                        'category' => 'pakaian',
                        'title' => 'Noken',
                        'description' => 'Tas rajutan tangan tradisional Papua terbuat dari rajutan serat kulit kayu pohon. Dikalungkan di kepala wanita untuk mengangkut hasil kebun dan bayi, diakui sebagai warisan dunia UNESCO.',
                        'location' => 'Timika',
                        'detail_url' => 'https://id.wikipedia.org/wiki/Noken',
                        'sort_order' => 1,
                    ]
                ],
                'history' => [
                    [
                        'year_label' => 'Tahun 1967',
                        'title' => 'Dampak Eksploitasi Gunung Suci',
                        'content' => 'Pembukaan lahan pertambangan mineral raksasa di gunung suci mereka mengubah pola kehidupan sosial dan memicu perjuangan hak adat Suku Amungme.',
                        'more_link' => 'https://id.wikipedia.org/wiki/Suku_Amungme',
                        'order' => 1,
                    ]
                ],
                'destinations' => [
                    [
                        'name' => 'Puncak Jaya Wijaya (Carstensz Pyramid)',
                        'location' => 'Mimika, Papua Tengah',
                        'description' => 'Puncak tertinggi di Indonesia berselimutkan salju abadi khatulistiwa yang dianggap sakral oleh masyarakat suku Amungme.',
                        'image_url' => 'https://images.unsplash.com/photo-1542856391-010fb87dcfed?auto=format&fit=crop&q=80&w=800',
                        'rating' => 4.9,
                        'sort_order' => 1,
                        'is_active' => true,
                        'latitude' => -4.083333,
                        'longitude' => 137.183333,
                        'pano_embed_url' => 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3979.10123456789!2d137.183333!3d-4.083333!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2dd6dbaaaaaaaab%3A0x7777777777777797!2sPuncak%20Jaya!5e0!3m2!1sid!2sid!4v1700000000061',
                        'pano_maps_url' => 'https://maps.app.goo.gl/uXj9C5w95X9Z5w9Y6',
                        'pano_label' => '360° Puncak Jaya',
                    ]
                ],
                'quiz' => [
                    'title' => 'Kuis Kebudayaan Suku Amungme',
                    'questions' => [
                        [
                            'prompt_text' => 'Tas rajutan tradisional berbahan serat kulit kayu pohon khas Papua yang digantungkan di dahi kepala bernama...',
                            'explanation' => 'Noken merupakan tas rajut tradisional Papua warisan budaya kemanusiaan dunia UNESCO.',
                            'options' => [
                                ['content_text' => 'Sali', 'is_correct' => false],
                                ['content_text' => 'Noken', 'is_correct' => true],
                                ['content_text' => 'Sasirangan', 'is_correct' => false],
                                ['content_text' => 'Ulos', 'is_correct' => false],
                            ]
                        ]
                    ]
                ]
            ],
            [
                'island_slug' => 'papua-maluku',
                'tribe_key' => 'Ambon',
                'about_page' => [
                    'label_small' => 'MENGENAL SUKU AMBON',
                    'hero_title' => 'Eksotika Kebudayaan Suku Ambon Maluku',
                    'hero_description' => 'Suku Ambon mendiami kepulauan Maluku bagian tengah. Terkenal sebagai suku yang hangat, memiliki musikalitas vokal yang sangat tinggi, serta hidup harmonis lewat adat persaudaraan Pela Gandong.',
                    'more_link' => 'https://id.wikipedia.org/wiki/Suku_Ambon',
                ],
                'about_items' => [
                    [
                        'title' => 'Falsafah Kerukunan Pela Gandong',
                        'description' => 'Sistem ikatan persaudaraan adat Pela Gandong menyatukan desa-desa berlatar belakang agama Kristen dan Islam di Maluku. Adat ini mewajibkan saling membantu dalam pembangunan tempat ibadah dan pesta sosial.',
                        'points' => "Ikatan persaudaraan Kristen-Islam kokoh\nGotong royong sosial tanpa batas keyakinan\nPenyelesaian konflik lewat ikatan sumpah adat",
                        'image' => 'https://images.unsplash.com/photo-1517486808906-6ca8b3f04846?auto=format&fit=crop&q=80&w=600',
                        'more_link' => 'https://id.wikipedia.org/wiki/Pela_Gandong',
                        'sort_order' => 1,
                    ]
                ],
                'heritage_page' => [
                    'hero_title' => 'Warisan Seni Luhur Suku Ambon',
                    'hero_description' => 'Saksikan keanggunan baju Cele merah motif kotak-kotak, pukulan dinamis alat musik Totobuang dan Tifa, serta keindahan lagu-lagu tradisional Ambon.',
                    'hero_image' => 'https://images.unsplash.com/photo-1703769605297-cc74106244d9?auto=format&fit=crop&q=80&w=1200',
                ],
                'heritage_items' => [
                    [
                        'category' => 'pakaian',
                        'title' => 'Baju Cele',
                        'description' => 'Pakaian adat Ambon bercorak garis kotak-kotak merah perak yang dikenakan bersama kain kebaya putih berenda elok lambang keceriaan wanita Ambon.',
                        'location' => 'Ambon',
                        'detail_url' => 'https://id.wikipedia.org/wiki/Suku_Ambon',
                        'sort_order' => 1,
                    ]
                ],
                'history' => [
                    [
                        'year_label' => 'Abad ke-16',
                        'title' => 'Pusat Rempah Maluku',
                        'content' => 'Kepulauan Ambon menjadi pelabuhan perdagangan bebas cengkih dan pala dunia diperebutkan serakah imperium barat Portugis, Inggris, dan VOC Belanda.',
                        'more_link' => 'https://id.wikipedia.org/wiki/Kepulauan_Maluku',
                        'order' => 1,
                    ]
                ],
                'destinations' => [
                    [
                        'name' => 'Benteng Amsterdam Hila',
                        'location' => 'Leihitu, Ambon',
                        'description' => 'Benteng bersejarah peninggalan VOC Belanda di pesisir Ambon yang awalnya dibangun Portugis sebagai gudang rempah cengkih.',
                        'image_url' => 'https://images.unsplash.com/photo-1599940824399-b87987ceb72a?auto=format&fit=crop&q=80&w=800',
                        'rating' => 4.7,
                        'sort_order' => 1,
                        'is_active' => true,
                        'latitude' => -3.582456,
                        'longitude' => 128.082456,
                        'pano_embed_url' => 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3979.10123456789!2d128.082456!3d-3.582456!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2dd6dbaaaaaaaab%3A0x7777777777777798!2sBenteng%20Amsterdam!5e0!3m2!1sid!2sid!4v1700000000062',
                        'pano_maps_url' => 'https://maps.app.goo.gl/uXj9C5w95X9Z5w9Y7',
                        'pano_label' => '360° Benteng Amsterdam',
                    ]
                ],
                'quiz' => [
                    'title' => 'Kuis Kebudayaan Suku Ambon',
                    'questions' => [
                        [
                            'prompt_text' => 'Falsafah adat persaudaraan sosial yang menyatukan desa Kristen dan Islam di Maluku bernama...',
                            'explanation' => 'Pela Gandong merupakan tradisi persaudaraan suci perekat harmoni perdamaian Maluku.',
                            'options' => [
                                ['content_text' => 'Tri Hita Karana', 'is_correct' => false],
                                ['content_text' => 'Pela Gandong', 'is_correct' => true],
                                ['content_text' => 'Dalihan Na Tolu', 'is_correct' => false],
                                ['content_text' => 'Someah', 'is_correct' => false],
                            ]
                        ]
                    ]
                ]
            ]
        ];

        foreach ($tribesData as $data) {
            $island = Island::where('slug', $data['island_slug'])->first();
            if (!$island) {
                $this->command->warn("Pulau dengan slug {$data['island_slug']} tidak ditemukan. Suku {$data['tribe_key']} dilewati.");
                continue;
            }

            $islandId = $island->id;
            $tribe = $data['tribe_key'];

            // 1. TribeAboutPage
            TribeAboutPage::updateOrCreate(
                ['island_id' => $islandId, 'tribe_key' => $tribe],
                $data['about_page']
            );

            // Clear & Seed TribeAboutItem
            TribeAboutItem::where('island_id', $islandId)->where('tribe_key', $tribe)->delete();
            foreach ($data['about_items'] as $item) {
                TribeAboutItem::create(array_merge($item, [
                    'island_id' => $islandId,
                    'tribe_key' => $tribe
                ]));
            }

            // 3. TribePage (Heritage Header)
            TribePage::updateOrCreate(
                ['island_id' => $islandId, 'tribe_key' => $tribe],
                $data['heritage_page']
            );

            // Clear & Seed HeritageItem
            HeritageItem::where('island_id', $islandId)->where('tribe_key', $tribe)->delete();
            foreach ($data['heritage_items'] as $item) {
                HeritageItem::create(array_merge($item, [
                    'island_id' => $islandId,
                    'tribe_key' => $tribe
                ]));
            }

            // Clear & Seed IslandHistory
            IslandHistory::where('island_id', $islandId)->where('tribe', $tribe)->delete();
            foreach ($data['history'] as $item) {
                IslandHistory::create(array_merge($item, [
                    'island_id' => $islandId,
                    'tribe' => $tribe
                ]));
            }

            // Clear & Seed Destination
            Destination::where('island_id', $islandId)->where('tribe_key', $tribe)->delete();
            foreach ($data['destinations'] as $item) {
                Destination::create(array_merge($item, [
                    'island_id' => $islandId,
                    'tribe_key' => $tribe
                ]));
            }

            // Clear & Seed Quiz
            $quiz = Quiz::updateOrCreate(
                ['scope' => 'tribe', 'island_id' => $islandId, 'tribe' => $tribe],
                [
                    'title' => $data['quiz']['title'],
                    'is_active' => true,
                ]
            );

            $quiz->questions()->delete();
            foreach ($data['quiz']['questions'] as $qIdx => $qData) {
                $question = QuizQuestion::create([
                    'quiz_id' => $quiz->id,
                    'prompt_type' => 'text',
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

        $this->command->info('Data kebudayaan untuk 16 suku se-Indonesia berhasil disemai!');
    }
}

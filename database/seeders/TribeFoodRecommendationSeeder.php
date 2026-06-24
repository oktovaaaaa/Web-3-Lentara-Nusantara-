<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\TribeFoodRecommendation;
use Illuminate\Support\Carbon;

class TribeFoodRecommendationSeeder extends Seeder
{
    public function run(): void
    {
        $now = now();
        $weekKey = Carbon::now()->format('o-\WW');

        $foodsData = [
            // =========================================================================
            // SUMATERA
            // =========================================================================
            [
                'region_slug' => 'sumatera',
                'tribe_key' => 'Aceh',
                'items' => [
                    [
                        'name' => 'Mie Aceh',
                        'description' => 'Mie kuning tebal dengan bumbu rempah kari pedas khas Aceh, disajikan dengan daging sapi atau seafood.',
                        'price_range' => '25k–45k',
                        'rating_estimate' => 4.8,
                        'region_hint' => 'Aceh',
                        'where_to_find' => ['Banda Aceh', 'Pidie'],
                        'tags' => ['Pedas', 'Rempah', 'Mie'],
                        'category' => 'main_course',
                        'image_url' => 'https://images.unsplash.com/photo-1540189549336-e6e99c3679fe?auto=format&fit=crop&q=80&w=600',
                        'wiki_url' => 'https://id.wikipedia.org/wiki/Mie_Aceh',
                        'wiki_summary' => 'Mie aceh adalah masakan mie pedas khas Aceh di Indonesia. Mie kuning tebal dengan irisan daging sapi, daging kambing atau makanan laut disajikan dalam sup sejenis kari yang gurih dan pedas.'
                    ],
                    [
                        'name' => 'Ayam Tangkap',
                        'description' => 'Ayam goreng khas Aceh yang dimasak dengan daun temurui (daun kari) dan pandan yang digoreng kering aromatik.',
                        'price_range' => '40k–80k',
                        'rating_estimate' => 4.7,
                        'region_hint' => 'Aceh Besar',
                        'where_to_find' => ['Banda Aceh', 'Aceh Besar'],
                        'tags' => ['Ayam', 'Daun Kari', 'Goreng'],
                        'category' => 'main_course',
                        'image_url' => 'https://images.unsplash.com/photo-1540189549336-e6e99c3679fe?auto=format&fit=crop&q=80&w=600',
                        'wiki_url' => 'https://id.wikipedia.org/wiki/Ayam_tangkap',
                        'wiki_summary' => 'Ayam tangkap adalah masakan khas Aceh yang terbuat dari ayam yang digoreng dengan bumbu dan rempah-rempah khas.'
                    ]
                ]
            ],
            [
                'region_slug' => 'sumatera',
                'tribe_key' => 'Batak',
                'items' => [
                    [
                        'name' => 'Arsik Ikan Mas',
                        'description' => 'Masakan ikan mas tradisional Batak dibumbui rempah khas andaliman, kecombrang, dan asam gelugur.',
                        'price_range' => '35k–60k',
                        'rating_estimate' => 4.9,
                        'region_hint' => 'Toba',
                        'where_to_find' => ['Balige', 'Samosir'],
                        'tags' => ['Ikan', 'Andaliman', 'Pedas Getir'],
                        'category' => 'main_course',
                        'image_url' => 'https://images.unsplash.com/photo-1540189549336-e6e99c3679fe?auto=format&fit=crop&q=80&w=600',
                        'wiki_url' => 'https://id.wikipedia.org/wiki/Arsik',
                        'wiki_summary' => 'Arsik adalah salah satu masakan khas kawasan Tapanuli yang populer. Masakan ini menggunakan bahan utama ikan mas dengan bumbu andaliman.'
                    ],
                    [
                        'name' => 'Mie Gomak',
                        'description' => 'Mie tebal khas Batak (spaghetti Batak) berkuah santan kental berbumbu andaliman pedas getir.',
                        'price_range' => '15k–25k',
                        'rating_estimate' => 4.7,
                        'region_hint' => 'Tapanuli Utara',
                        'where_to_find' => ['Tarutung', 'Samosir'],
                        'tags' => ['Mie', 'Santan', 'Andaliman'],
                        'category' => 'main_course',
                        'image_url' => 'https://images.unsplash.com/photo-1540189549336-e6e99c3679fe?auto=format&fit=crop&q=80&w=600',
                        'wiki_url' => 'https://id.wikipedia.org/wiki/Mie_gomak',
                        'wiki_summary' => 'Mie gomak adalah makanan khas dari tanah Batak Toba. Mie ini dibuat dari mie lidi berukuran tebal mirip dengan spaghetti.'
                    ]
                ]
            ],
            [
                'region_slug' => 'sumatera',
                'tribe_key' => 'Minangkabau',
                'items' => [
                    [
                        'name' => 'Rendang Daging',
                        'description' => 'Olahan daging sapi yang dimasak perlahan dengan santan dan aneka rempah hingga berwarna cokelat gelap karamelisasi gurih.',
                        'price_range' => '25k–50k',
                        'rating_estimate' => 4.9,
                        'region_hint' => 'Sumatera Barat',
                        'where_to_find' => ['Payakumbuh', 'Padang'],
                        'tags' => ['Daging', 'Santan', 'Rempah'],
                        'category' => 'main_course',
                        'image_url' => 'https://images.unsplash.com/photo-1540189549336-e6e99c3679fe?auto=format&fit=crop&q=80&w=600',
                        'wiki_url' => 'https://id.wikipedia.org/wiki/Rendang',
                        'wiki_summary' => 'Rendang adalah masakan daging bercita rasa pedas yang menggunakan campuran dari berbagai bumbu dan rempah-rempah khas Minangkabau.'
                    ],
                    [
                        'name' => 'Sate Padang',
                        'description' => 'Sate lidah atau daging sapi dengan siraman kuah kental kuning kecokelatan beraroma kunyit, jahe, dan rempah pedas.',
                        'price_range' => '20k–35k',
                        'rating_estimate' => 4.8,
                        'region_hint' => 'Padang Panjang',
                        'where_to_find' => ['Padang Panjang', 'Padang'],
                        'tags' => ['Sate', 'Daging', 'Kuah Kental'],
                        'category' => 'main_course',
                        'image_url' => 'https://images.unsplash.com/photo-1540189549336-e6e99c3679fe?auto=format&fit=crop&q=80&w=600',
                        'wiki_url' => 'https://id.wikipedia.org/wiki/Sate_Padang',
                        'wiki_summary' => 'Sate Padang adalah sebutan untuk tiga jenis variasi sate di Sumatera Barat, yaitu Sate Padang, Sate Padang Panjang dan Sate Pariaman.'
                    ]
                ]
            ],

            // =========================================================================
            // JAWA (JAWA, SUNDA, MADURA)
            // =========================================================================
            [
                'region_slug' => 'jawa',
                'tribe_key' => 'Jawa',
                'items' => [
                    [
                        'name' => 'Gudeg Yogya',
                        'description' => 'Kuliner manis gurih berbahan nangka muda (gori) yang direbus berjam-jam dengan santan, gula merah, dan daun jati.',
                        'price_range' => '20k–45k',
                        'rating_estimate' => 4.8,
                        'region_hint' => 'Yogyakarta',
                        'where_to_find' => ['Yogyakarta', 'Solo'],
                        'tags' => ['Manis', 'Nangka Muda', 'Tradisional'],
                        'category' => 'main_course',
                        'image_url' => 'https://images.unsplash.com/photo-1540189549336-e6e99c3679fe?auto=format&fit=crop&q=80&w=600',
                        'wiki_url' => 'https://id.wikipedia.org/wiki/Gudeg',
                        'wiki_summary' => 'Gudeg adalah makanan khas Yogyakarta dan Jawa Tengah yang terbuat dari nangka muda yang dimasak dengan santan.'
                    ],
                    [
                        'name' => 'Rawon',
                        'description' => 'Sup daging sapi kuah hitam pekat aromatik dari biji kluwek, disajikan dengan kecambah pendek dan telur asin.',
                        'price_range' => '30k–50k',
                        'rating_estimate' => 4.9,
                        'region_hint' => 'Jawa Timur',
                        'where_to_find' => ['Surabaya', 'Malang'],
                        'tags' => ['Daging', 'Kluwek', 'Gurih'],
                        'category' => 'main_course',
                        'image_url' => 'https://images.unsplash.com/photo-1540189549336-e6e99c3679fe?auto=format&fit=crop&q=80&w=600',
                        'wiki_url' => 'https://id.wikipedia.org/wiki/Rawon',
                        'wiki_summary' => 'Rawon adalah sup daging sapi berkuah hitam khas Jawa Timur yang menggunakan campuran bumbu kluwek.'
                    ]
                ]
            ],
            [
                'region_slug' => 'jawa',
                'tribe_key' => 'Sunda',
                'items' => [
                    [
                        'name' => 'Karedok',
                        'description' => 'Sajian sayuran mentah segar (kacang panjang, kol, taoge, timun) disiram bumbu kacang kental kencur aromatik.',
                        'price_range' => '15k–25k',
                        'rating_estimate' => 4.7,
                        'region_hint' => 'Jawa Barat',
                        'where_to_find' => ['Bandung', 'Bogor'],
                        'tags' => ['Sayur', 'Kacang', 'Pedas Kencur'],
                        'category' => 'main_course',
                        'image_url' => 'https://images.unsplash.com/photo-1540189549336-e6e99c3679fe?auto=format&fit=crop&q=80&w=600',
                        'wiki_url' => 'https://id.wikipedia.org/wiki/Karedok',
                        'wiki_summary' => 'Karedok adalah salah satu makanan khas Sunda di Indonesia. Karedok dibuat dengan bahan-bahan sayuran mentah segar disiram saus kacang pedas.'
                    ],
                    [
                        'name' => 'Nasi Tutug Oncom',
                        'description' => 'Nasi hangat yang diaduk rata bersama oncom bakar bumbu kencur dan bawang, disajikan dengan lalap segar.',
                        'price_range' => '18k–30k',
                        'rating_estimate' => 4.8,
                        'region_hint' => 'Tasikmalaya',
                        'where_to_find' => ['Tasikmalaya', 'Bandung'],
                        'tags' => ['Nasi', 'Oncom', 'Tradisional'],
                        'category' => 'main_course',
                        'image_url' => 'https://images.unsplash.com/photo-1540189549336-e6e99c3679fe?auto=format&fit=crop&q=80&w=600',
                        'wiki_url' => 'https://id.wikipedia.org/wiki/Nasi_tutug_oncom',
                        'wiki_summary' => 'Nasi tutug oncom adalah makanan khas Sunda yang dibuat dari nasi yang diaduk dengan oncom goreng atau bakar.'
                    ]
                ]
            ],
            [
                'region_slug' => 'jawa',
                'tribe_key' => 'Madura',
                'items' => [
                    [
                        'name' => 'Sate Madura',
                        'description' => 'Sate ayam bakar khas Madura berlumurkan saus kacang halus manis manis-gurih dan kecap manis.',
                        'price_range' => '20k–35k',
                        'rating_estimate' => 4.8,
                        'region_hint' => 'Madura',
                        'where_to_find' => ['Bangkalan', 'Sampang'],
                        'tags' => ['Ayam', 'Bakar', 'Kacang'],
                        'category' => 'main_course',
                        'image_url' => 'https://images.unsplash.com/photo-1540189549336-e6e99c3679fe?auto=format&fit=crop&q=80&w=600',
                        'wiki_url' => 'https://id.wikipedia.org/wiki/Sate_Madura',
                        'wiki_summary' => 'Sate Madura adalah sate yang memiliki bumbu khas Madura terbuat dari kacang tanah tumbuk halus yang dimasak gurih manis.'
                    ],
                    [
                        'name' => 'Bebek Sinjay',
                        'description' => 'Bebek goreng garing khas Madura bertaburkan kremesan rempah gurih, disajikan dengan sambal pencit mangga muda asam pedas.',
                        'price_range' => '30k–45k',
                        'rating_estimate' => 4.9,
                        'region_hint' => 'Bangkalan',
                        'where_to_find' => ['Bangkalan', 'Surabaya'],
                        'tags' => ['Bebek', 'Goreng', 'Pedas Asam'],
                        'category' => 'main_course',
                        'image_url' => 'https://images.unsplash.com/photo-1540189549336-e6e99c3679fe?auto=format&fit=crop&q=80&w=600',
                        'wiki_url' => 'https://id.wikipedia.org/wiki/Suku_Madura',
                        'wiki_summary' => 'Bebek Sinjay adalah salah satu masakan kuliner bebek goreng paling terkenal dari pulau Madura.'
                    ]
                ]
            ],

            // =========================================================================
            // KALIMANTAN (BANJAR, DAYAK, KUTAI)
            // =========================================================================
            [
                'region_slug' => 'kalimantan',
                'tribe_key' => 'Banjar',
                'items' => [
                    [
                        'name' => 'Soto Banjar',
                        'description' => 'Soto ayam berkuah putih bening harum kayu manis, cengkih, dan kapulaga, dicampur suwiran bebek/ayam dan perkedel kentang.',
                        'price_range' => '22k–35k',
                        'rating_estimate' => 4.8,
                        'region_hint' => 'Banjarmasin',
                        'where_to_find' => ['Banjarmasin', 'Banjarbaru'],
                        'tags' => ['Ayam', 'Kuah Rempah', 'Soto'],
                        'category' => 'main_course',
                        'image_url' => 'https://images.unsplash.com/photo-1540189549336-e6e99c3679fe?auto=format&fit=crop&q=80&w=600',
                        'wiki_url' => 'https://id.wikipedia.org/wiki/Soto_Banjar',
                        'wiki_summary' => 'Soto Banjar adalah soto khas suku Banjar, Kalimantan Selatan dengan bahan utama ayam dan beraroma harum rempah-rempah.'
                    ]
                ]
            ],
            [
                'region_slug' => 'kalimantan',
                'tribe_key' => 'Dayak',
                'items' => [
                    [
                        'name' => 'Juhu Singkah Rotan',
                        'description' => 'Masakan sup tradisional Dayak menggunakan umbut rotan muda bertekstur lunak dengan cita rasa pahit gurih eksotis.',
                        'price_range' => '20k–35k',
                        'rating_estimate' => 4.6,
                        'region_hint' => 'Kalimantan Tengah',
                        'where_to_find' => ['Palangkaraya', 'Kapuas'],
                        'tags' => ['Sayur', 'Umbut Rotan', 'Pahit Gurih'],
                        'category' => 'main_course',
                        'image_url' => 'https://images.unsplash.com/photo-1540189549336-e6e99c3679fe?auto=format&fit=crop&q=80&w=600',
                        'wiki_url' => 'https://id.wikipedia.org/wiki/Juhu_singkah',
                        'wiki_summary' => 'Juhu singkah adalah masakan khas suku Dayak di Kalimantan Tengah, berbahan dasar umbut rotan muda.'
                    ]
                ]
            ],
            [
                'region_slug' => 'kalimantan',
                'tribe_key' => 'Kutai',
                'items' => [
                    [
                        'name' => 'Nasi Bekepor',
                        'description' => 'Nasi liwet khas Kutai yang dimasak bersama ikan asin, kemangi, cabe rawit, dan air jeruk nipis di kuali tanah liat.',
                        'price_range' => '20k–35k',
                        'rating_estimate' => 4.7,
                        'region_hint' => 'Kutai Kartanegara',
                        'where_to_find' => ['Tenggarong', 'Samarinda'],
                        'tags' => ['Nasi', 'Ikan Asin', 'Gurih Wangi'],
                        'category' => 'main_course',
                        'image_url' => 'https://images.unsplash.com/photo-1540189549336-e6e99c3679fe?auto=format&fit=crop&q=80&w=600',
                        'wiki_url' => 'https://id.wikipedia.org/wiki/Suku_Kutai',
                        'wiki_summary' => 'Nasi bekepor adalah kuliner khas Kutai peninggalan sejarah kesultanan Kutai Kartanegara.'
                    ]
                ]
            ],

            // =========================================================================
            // SULAWESI (BUGIS, MAKASSAR, TORAJA)
            // =========================================================================
            [
                'region_slug' => 'sulawesi',
                'tribe_key' => 'Bugis',
                'items' => [
                    [
                        'name' => 'Coto Makassar',
                        'description' => 'Sup jeroan dan daging sapi berkuah keruh gurih dari kacang tanah sangrai tumbuk kental dengan rempah sereh lengkuas.',
                        'price_range' => '20k–35k',
                        'rating_estimate' => 4.9,
                        'region_hint' => 'Makassar',
                        'where_to_find' => ['Makassar', 'Gowa'],
                        'tags' => ['Daging', 'Kacang', 'Kuah Kental'],
                        'category' => 'main_course',
                        'image_url' => 'https://images.unsplash.com/photo-1540189549336-e6e99c3679fe?auto=format&fit=crop&q=80&w=600',
                        'wiki_url' => 'https://id.wikipedia.org/wiki/Coto_Makassar',
                        'wiki_summary' => 'Coto Makassar atau Coto Mangkasara adalah makanan tradisional Makassar, Sulawesi Selatan. Makanan ini terbuat dari jeroan dan daging sapi yang direbus dalam air cucian beras dengan kacang tanah sangrai.'
                    ]
                ]
            ],
            [
                'region_slug' => 'sulawesi',
                'tribe_key' => 'Makassar',
                'items' => [
                    [
                        'name' => 'Sop Konro',
                        'description' => 'Sup iga sapi berdaging tebal khas Makassar berkuah hitam rempah dari buah kluwek wangi rempah kayu manis.',
                        'price_range' => '35k–60k',
                        'rating_estimate' => 4.9,
                        'region_hint' => 'Makassar',
                        'where_to_find' => ['Makassar', 'Maros'],
                        'tags' => ['Iga Sapi', 'Kluwek', 'Rempah'],
                        'category' => 'main_course',
                        'image_url' => 'https://images.unsplash.com/photo-1540189549336-e6e99c3679fe?auto=format&fit=crop&q=80&w=600',
                        'wiki_url' => 'https://id.wikipedia.org/wiki/Sop_konro',
                        'wiki_summary' => 'Sop konro adalah masakan sup iga sapi khas Indonesia yang berasal dari tradisi Makassar, Sulawesi Selatan.'
                    ]
                ]
            ],
            [
                'region_slug' => 'sulawesi',
                'tribe_key' => 'Toraja',
                'items' => [
                    [
                        'name' => 'Pa Piong',
                        'description' => 'Olahan daging babi, ayam, atau ikan yang dicampur sayur daun mayana parutan kelapa dimasak di bambu bakar.',
                        'price_range' => '30k–55k',
                        'rating_estimate' => 4.8,
                        'region_hint' => 'Tana Toraja',
                        'where_to_find' => ['Rantepao', 'Makale'],
                        'tags' => ['Daging', 'Bambu Bakar', 'Daun Mayana'],
                        'category' => 'main_course',
                        'image_url' => 'https://images.unsplash.com/photo-1540189549336-e6e99c3679fe?auto=format&fit=crop&q=80&w=600',
                        'wiki_url' => 'https://id.wikipedia.org/wiki/Suku_Toraja',
                        'wiki_summary' => 'Pa Piong adalah masakan tradisional suku Toraja yang dimasak menggunakan wadah tabung bambu yang dibakar di atas bara api.'
                    ]
                ]
            ],

            // =========================================================================
            // BALI & NUSA TENGGARA
            // =========================================================================
            [
                'region_slug' => 'bali-nusa-tenggara',
                'tribe_key' => 'Bali',
                'items' => [
                    [
                        'name' => 'Ayam Betutu',
                        'description' => 'Ayam utuh berisi rempah base genep pedas dibungkus pelepah pinang/daun pisang lalu dipanggang bara api.',
                        'price_range' => '45k–90k',
                        'rating_estimate' => 4.9,
                        'region_hint' => 'Gianyar',
                        'where_to_find' => ['Ubud', 'Denpasar'],
                        'tags' => ['Ayam', 'Base Genep', 'Pedas'],
                        'category' => 'main_course',
                        'image_url' => 'https://images.unsplash.com/photo-1540189549336-e6e99c3679fe?auto=format&fit=crop&q=80&w=600',
                        'wiki_url' => 'https://id.wikipedia.org/wiki/Betutu',
                        'wiki_summary' => 'Betutu adalah lauk yang terbuat dari ayam atau bebek yang utuh yang berisi bumbu, kemudian dipanggang dalam api sekam.'
                    ],
                    [
                        'name' => 'Sate Lilit Bali',
                        'description' => 'Sate cincang ikan atau ayam yang dicampur kelapa parut dan bumbu aromatik, dililitkan pada batang sereh/bambu.',
                        'price_range' => '20k–40k',
                        'rating_estimate' => 4.8,
                        'region_hint' => 'Bali',
                        'where_to_find' => ['Kuta', 'Sanur'],
                        'tags' => ['Sate', 'Cincang', 'Sereh'],
                        'category' => 'main_course',
                        'image_url' => 'https://images.unsplash.com/photo-1540189549336-e6e99c3679fe?auto=format&fit=crop&q=80&w=600',
                        'wiki_url' => 'https://id.wikipedia.org/wiki/Sate_lilit',
                        'wiki_summary' => 'Sate lilit adalah sebuah varian sate khas Bali. Sate ini dibuat dari daging babi, ikan, ayam, daging sapi, atau bahkan kura-kura yang dicincang halus.'
                    ]
                ]
            ],
            [
                'region_slug' => 'bali-nusa-tenggara',
                'tribe_key' => 'Sasak',
                'items' => [
                    [
                        'name' => 'Ayam Taliwang',
                        'description' => 'Ayam kampung muda dibakar kering dioles bumbu pedas cabe rawit kencur khas Lombok.',
                        'price_range' => '35k–65k',
                        'rating_estimate' => 4.8,
                        'region_hint' => 'Lombok',
                        'where_to_find' => ['Mataram', 'Sade'],
                        'tags' => ['Ayam', 'Bakar', 'Pedas Kencur'],
                        'category' => 'main_course',
                        'image_url' => 'https://images.unsplash.com/photo-1540189549336-e6e99c3679fe?auto=format&fit=crop&q=80&w=600',
                        'wiki_url' => 'https://id.wikipedia.org/wiki/Ayam_Taliwang',
                        'wiki_summary' => 'Ayam Taliwang adalah makanan khas yang berasal dari Taliwang, Sumbawa Barat, Nusa Tenggara Barat, berupa ayam bakar pedas.'
                    ]
                ]
            ],
            [
                'region_slug' => 'bali-nusa-tenggara',
                'tribe_key' => 'Atoni',
                'items' => [
                    [
                        'name' => 'Se\'i Sapi',
                        'description' => 'Daging sapi asap khas NTT yang diasap tipis menggunakan bara kayu kosambi wangi daun kosambi penyedap.',
                        'price_range' => '40k–75k',
                        'rating_estimate' => 4.9,
                        'region_hint' => 'Kupang',
                        'where_to_find' => ['Kupang', 'Soe'],
                        'tags' => ['Daging', 'Asap', 'Kosambi'],
                        'category' => 'main_course',
                        'image_url' => 'https://images.unsplash.com/photo-1540189549336-e6e99c3679fe?auto=format&fit=crop&q=80&w=600',
                        'wiki_url' => 'https://id.wikipedia.org/wiki/Se%27i',
                        'wiki_summary' => 'Se\'i adalah hidangan daging asap khas Provinsi Nusa Tenggara Timur yang dibuat menggunakan teknik pengasapan kayu kosambi.'
                    ]
                ]
            ],

            // =========================================================================
            // PAPUA & MALUKU
            // =========================================================================
            [
                'region_slug' => 'papua-maluku',
                'tribe_key' => 'Asmat',
                'items' => [
                    [
                        'name' => 'Papeda Papua',
                        'description' => 'Bubur sagu kental berlendir bening khas Papua, disajikan hangat dengan sup ikan kuah kuning andalannya.',
                        'price_range' => '15k–35k',
                        'rating_estimate' => 4.7,
                        'region_hint' => 'Papua',
                        'where_to_find' => ['Agats', 'Jayapura'],
                        'tags' => ['Sagu', 'Bubur Kental', 'Tradisional'],
                        'category' => 'main_course',
                        'image_url' => 'https://images.unsplash.com/photo-1540189549336-e6e99c3679fe?auto=format&fit=crop&q=80&w=600',
                        'wiki_url' => 'https://id.wikipedia.org/wiki/Papeda',
                        'wiki_summary' => 'Papeda adalah makanan berupa bubur sagu khas Papua dan Maluku yang biasanya disajikan dengan mubara atau ikan tongkol yang dibumbui dengan kunyit.'
                    ]
                ]
            ],
            [
                'region_slug' => 'papua-maluku',
                'tribe_key' => 'Amungme',
                'items' => [
                    [
                        'name' => 'Keladi Tumbuk',
                        'description' => 'Olahan keladi (talas) rebus ditumbuk halus dicampur parutan kelapa gurih disantap pengganti nasi.',
                        'price_range' => '10k–20k',
                        'rating_estimate' => 4.5,
                        'region_hint' => 'Pegunungan Papua',
                        'where_to_find' => ['Timika', 'Wamena'],
                        'tags' => ['Keladi', 'Tumbuk', 'Karbohidrat'],
                        'category' => 'main_course',
                        'image_url' => 'https://images.unsplash.com/photo-1540189549336-e6e99c3679fe?auto=format&fit=crop&q=80&w=600',
                        'wiki_url' => 'https://id.wikipedia.org/wiki/Suku_Amungme',
                        'wiki_summary' => 'Keladi tumbuk adalah makanan pokok alternatif suku pegunungan Amungme pengganti sagu di dataran rendah.'
                    ]
                ]
            ],
            [
                'region_slug' => 'papua-maluku',
                'tribe_key' => 'Ambon',
                'items' => [
                    [
                        'name' => 'Ikan Kuah Kuning Colo-Colo',
                        'description' => 'Sup ikan kakap/tongkol berkuah kunyit asam segar disajikan bersama sambal colo-colo cabe rawit tomat hijau jeruk nipis.',
                        'price_range' => '25k–45k',
                        'rating_estimate' => 4.8,
                        'region_hint' => 'Ambon',
                        'where_to_find' => ['Ambon', 'Banda Neira'],
                        'tags' => ['Ikan', 'Kunyit', 'Pedas Asam'],
                        'category' => 'main_course',
                        'image_url' => 'https://images.unsplash.com/photo-1540189549336-e6e99c3679fe?auto=format&fit=crop&q=80&w=600',
                        'wiki_url' => 'https://id.wikipedia.org/wiki/Colo-colo',
                        'wiki_summary' => 'Colo-colo adalah sambal khas daerah Maluku yang rasanya pedas asam segar, sangat populer disajikan bersama ikan bakar.'
                    ]
                ]
            ]
        ];

        foreach ($foodsData as $data) {
            $tribeKey = $data['tribe_key'];
            $regionSlug = $data['region_slug'];

            $finalItems = [];
            foreach ($data['items'] as $it) {
                $sources = isset($it['wiki_url']) ? [$it['wiki_url']] : [];
                $finalItems[] = [
                    'name' => $it['name'],
                    'description' => $it['description'],
                    'price_range' => $it['price_range'] ?? null,
                    'rating_estimate' => $it['rating_estimate'] ?? null,
                    'region_hint' => $it['region_hint'] ?? null,
                    'where_to_find' => $it['where_to_find'] ?? [],
                    'tags' => $it['tags'] ?? [],
                    'category' => $it['category'] ?? null,
                    'image_url' => $it['image_url'] ?? 'https://images.unsplash.com/photo-1540189549336-e6e99c3679fe?auto=format&fit=crop&q=80&w=1200',
                    'sources' => $sources,
                    'wiki_url' => $it['wiki_url'] ?? null,
                    'wiki_summary' => $it['wiki_summary'] ?? null,
                ];
            }

            $payload = [
                'island_slug' => $regionSlug,
                'tribe_key' => $tribeKey,
                'week_key' => $weekKey,
                'generated_at' => $now->toISOString(),
                'items' => $finalItems,
            ];

            TribeFoodRecommendation::updateOrCreate(
                ['tribe_key' => $tribeKey, 'week_key' => $weekKey],
                [
                    'region_slug' => $regionSlug,
                    'payload' => $payload,
                    'generated_at' => $now,
                ]
            );
        }

        $this->command->info('Rekomendasi makanan tradisional untuk 18 suku berhasil disemai!');
    }
}

<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        $this->call([
            IslandSeeder::class,
            AdminUserSeeder::class,
            LegendaDanauTobaSeeder::class, // ID 1 (Sumatera Level 1)
            AcehGame3DSeeder::class,       // ID 2 (Sumatera Level 2)
            RoroJonggrangSeeder::class,    // ID 3 (Jawa Level 1)
            PangeranSamudraSeeder::class,  // ID 4 (Kalimantan Level 1)
            BatakTribeSeeder::class,
            AcehTribeSeeder::class,
            TraditionalTribesSeeder::class,
            TribeFoodRecommendationSeeder::class,
        ]);
    }
}

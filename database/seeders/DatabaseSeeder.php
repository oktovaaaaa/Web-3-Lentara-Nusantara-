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
            LegendaDanauTobaSeeder::class,
            RoroJonggrangSeeder::class,
            PangeranSamudraSeeder::class,
            AcehGame3DSeeder::class,
            BatakTribeSeeder::class,
            AcehTribeSeeder::class,
            TraditionalTribesSeeder::class,
            TribeFoodRecommendationSeeder::class,
        ]);
    }
}

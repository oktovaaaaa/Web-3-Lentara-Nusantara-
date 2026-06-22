<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Island;
use App\Models\GameLevel;

class AcehGame3DSeeder extends Seeder
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
            $this->command->warn('⚠️ Pulau Sumatera tidak ditemukan. Seeder dibatalkan.');
            return;
        }

        // Buat atau update Level 2 Sumatera sebagai 3D Game
        $level = GameLevel::firstOrCreate(
            ['island_id' => $island->id, 'order' => 2],
            [
                'title'      => 'Level 2 — Ekspedisi Budaya Aceh',
                'is_active'  => true,
                'level_type' => 'game3d',
                'time_limit_seconds' => 0,
            ]
        );

        $level->update([
            'level_type' => 'game3d',
            'title'      => 'Level 2 — Ekspedisi Budaya Aceh',
            'is_active'  => true,
        ]);

        $this->command->info("✅ Seeder Sumatera Level 2 (3D Game) berhasil dijalankan: '{$level->title}'");
    }
}

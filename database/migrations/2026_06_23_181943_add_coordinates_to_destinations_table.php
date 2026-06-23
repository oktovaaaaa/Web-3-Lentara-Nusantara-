<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\Destination;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('destinations', function (Blueprint $table) {
            $table->decimal('latitude', 10, 8)->nullable()->after('pano_label');
            $table->decimal('longitude', 11, 8)->nullable()->after('latitude');
        });

        // Parse existing coordinates from pano_embed_url
        try {
            $destinations = Destination::all();
            foreach ($destinations as $dest) {
                $url = $dest->pano_embed_url;
                if ($url && preg_match('/!2d([0-9.-]+)!3d([0-9.-]+)/', $url, $matches)) {
                    $dest->latitude = (float) $matches[2];
                    $dest->longitude = (float) $matches[1];
                    $dest->save();
                }
            }
        } catch (\Throwable $e) {
            // Silently fail if model class doesn't exist or table has issues during early migration phase
            Log::warning("Failed to auto-populate coordinates: " . $e->getMessage());
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('destinations', function (Blueprint $table) {
            $table->dropColumn(['latitude', 'longitude']);
        });
    }
};

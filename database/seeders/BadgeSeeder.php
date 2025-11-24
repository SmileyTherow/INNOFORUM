<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class BadgeSeeder extends Seeder
{
    public function run()
    {
        $now = Carbon::now();

        $badges = [
            // like badges (Pencerah)
            ['name' => 'Pencerah Bronze', 'icon' => 'like_bronze.jpg', 'description' => 'Like terbanyak 100+'],
            ['name' => 'Pencerah Silver', 'icon' => 'like_silver.jpg', 'description' => 'Like terbanyak 500+'],
            ['name' => 'Pencerah Gold',   'icon' => 'like_gold.jpg',   'description' => 'Like terbanyak 1000+'],

            // responder badges (Penjawab)
            ['name' => 'Penjawab Bronze', 'icon' => 'responder_bronze.jpg', 'description' => 'Menjawab terbanyak 100+'],
            ['name' => 'Penjawab Silver', 'icon' => 'responder_silver.jpg', 'description' => 'Menjawab terbanyak 500+'],
            ['name' => 'Penjawab Gold',   'icon' => 'responder_gold.jpg',   'description' => 'Menjawab terbanyak 1000+'],
        ];

        foreach ($badges as $b) {
            DB::table('badges')->updateOrInsert(
                ['name' => $b['name']],
                [
                    'description' => $b['description'],
                    'icon' => $b['icon'],
                    'created_at' => $now,
                    'updated_at' => $now,
                ]
            );
        }
    }
}

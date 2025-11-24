<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BadgesTableSeeder extends Seeder
{
    public function run()
    {
        DB::table('badges')->insert([
            ['name' => 'Problem Solver', 'description' => 'Menyelesaikan 10 thread', 'icon' => null],
            ['name' => 'Active Helper', 'description' => 'Memberi 50 komentar', 'icon' => null],
        ]);
    }
}

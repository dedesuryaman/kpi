<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PerformanceIndicatorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('performance_indicators')->insert([
            [
                'name' => 'Attendance',
                'weight' => 20,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Productivity',
                'weight' => 25,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Quality',
                'weight' => 25,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Discipline',
                'weight' => 15,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Innovation',
                'weight' => 15,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}

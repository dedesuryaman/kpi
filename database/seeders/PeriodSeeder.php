<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PeriodSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('periods')->insert([
            [
                'name' => 'KPI Semester 1 2026',
                'start_date' => '2026-01-01',
                'end_date' => '2026-06-30',
                'status' => 'active',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'KPI Semester 2 2026',
                'start_date' => '2026-07-01',
                'end_date' => '2026-12-31',
                'status' => 'draft',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}

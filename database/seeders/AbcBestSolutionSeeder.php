<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AbcBestSolutionSeeder extends Seeder
{
    public function run(): void
    {
        $periodId = DB::table('periods')
            ->where('status', 'active')
            ->value('id');

        DB::table('abc_best_solutions')->insert([
            [
                'period_id' => $periodId,
                'best_weight_json' => json_encode([
                    'indicator_1' => 35.25,
                    'indicator_2' => 39.75,
                    'indicator_3' => 25.00,
                ]),
                'fitness_score' => 0.94572135,
                'generated_at' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);
    }
}

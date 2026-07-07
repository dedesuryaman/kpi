<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AbcPopulationSeeder extends Seeder
{
    public function run(): void
    {
        $periodId = DB::table('periods')
            ->where('status', 'active')
            ->value('id');

        DB::table('abc_populations')->insert([
            [
                'period_id' => $periodId,
                'food_source' => 1,
                'fitness' => 0.875421,
                'weight_json' => json_encode([
                    'indicator_1' => 35,
                    'indicator_2' => 40,
                    'indicator_3' => 25,
                ]),
                'status' => 'best',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'period_id' => $periodId,
                'food_source' => 2,
                'fitness' => 0.812354,
                'weight_json' => json_encode([
                    'indicator_1' => 30,
                    'indicator_2' => 45,
                    'indicator_3' => 25,
                ]),
                'status' => 'employed',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}

<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AbcHistorySeeder extends Seeder
{
    public function run(): void
    {
        $periodId = DB::table('periods')
            ->where('status', 'active')
            ->value('id');

        DB::table('abc_histories')->insert([
            [
                'period_id' => $periodId,

                'before_weight' => json_encode([
                    'indicator_1' => 40,
                    'indicator_2' => 35,
                    'indicator_3' => 25,
                ]),

                'after_weight' => json_encode([
                    'indicator_1' => 35.25,
                    'indicator_2' => 39.75,
                    'indicator_3' => 25.00,
                ]),

                'improvement_score' => 0.08754231,

                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);
    }
}

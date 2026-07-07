<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class KpiWeightHistorySeeder extends Seeder
{
    public function run(): void
    {
        $histories = [

            [
                'indicator' => 'Achievement of Work Targets',
                'old_weight' => 35,
                'new_weight' => 40,
                'algorithm' => 'Annual KPI Review',
            ],

            [
                'indicator' => 'Work Accuracy',
                'old_weight' => 35,
                'new_weight' => 40,
                'algorithm' => 'Quality Improvement Program',
            ],

            [
                'indicator' => 'SOP Compliance',
                'old_weight' => 40,
                'new_weight' => 50,
                'algorithm' => 'Risk Management Initiative',
            ],

            [
                'indicator' => 'Customer Satisfaction Score',
                'old_weight' => 40,
                'new_weight' => 50,
                'algorithm' => 'Customer Experience Strategy',
            ],

            [
                'indicator' => 'Training Completion',
                'old_weight' => 30,
                'new_weight' => 40,
                'algorithm' => 'Talent Development Program',
            ],

            [
                'indicator' => 'Safety Compliance',
                'old_weight' => 40,
                'new_weight' => 50,
                'algorithm' => 'HSE Compliance Enhancement',
            ],
        ];

        foreach ($histories as $history) {

            $indicatorId = DB::table('kpi_indicators')
                ->where('name', $history['indicator'])
                ->value('id');

            if (!$indicatorId) {
                continue;
            }

            DB::table('kpi_weight_histories')->insert([
                'indicator_id' => $indicatorId,
                'old_weight' => $history['old_weight'],
                'new_weight' => $history['new_weight'],
                'algorithm' => $history['algorithm'],
                'created_at' => now(),
            ]);
        }
    }
}

<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class KpiIndicatorSeeder extends Seeder
{
    public function run(): void
    {
        $masters = DB::table('kpi_masters')
            ->pluck('id', 'name');

        $indicators = [

            // ==================================================
            // ATTENDANCE
            // ==================================================
            [
                'kpi_master' => 'Attendance',
                'name' => 'Attendance',
                'description' => 'Measures employee attendance consistency during the evaluation period.',
                'weight' => 10,
                'measurement_type' => 'percentage',
            ],

            // ==================================================
            // PRODUCTIVITY
            // ==================================================
            [
                'kpi_master' => 'Productivity',
                'name' => 'Project Completion Timeliness',
                'description' => 'Measures employee ability to complete assigned projects according to the planned schedule.',
                'weight' => 20,
                'measurement_type' => 'percentage',
            ],

            [
                'kpi_master' => 'Productivity',
                'name' => 'Productivity',
                'description' => 'Measures employee productivity based on work targets and overall output.',
                'weight' => 15,
                'measurement_type' => 'percentage',
            ],

            // ==================================================
            // QUALITY
            // ==================================================
            [
                'kpi_master' => 'Quality',
                'name' => 'Work Quality',
                'description' => 'Measures the quality, accuracy, and completeness of work results.',
                'weight' => 20,
                'measurement_type' => 'percentage',
            ],

            [
                'kpi_master' => 'Quality',
                'name' => 'Customer Satisfaction',
                'description' => 'Measures customer satisfaction with services and work delivered by employees.',
                'weight' => 10,
                'measurement_type' => 'percentage',
            ],

            // ==================================================
            // DISCIPLINE
            // ==================================================
            [
                'kpi_master' => 'Discipline',
                'name' => 'Administrative Discipline',
                'description' => 'Measures employee compliance in documentation, reporting, and administrative procedures.',
                'weight' => 5,
                'measurement_type' => 'score',
            ],

            [
                'kpi_master' => 'Discipline',
                'name' => 'Team Collaboration',
                'description' => 'Measures employee ability to communicate and collaborate effectively within the team.',
                'weight' => 10,
                'measurement_type' => 'score',
            ],

            // ==================================================
            // INNOVATION
            // ==================================================
            [
                'kpi_master' => 'Innovation',
                'name' => 'Innovation',
                'description' => 'Measures employee contribution through creativity, innovation, and continuous improvement initiatives.',
                'weight' => 10,
                'measurement_type' => 'score',
            ],

        ];

        foreach ($indicators as $item) {

            DB::table('kpi_indicators')->updateOrInsert(

                [
                    'name' => $item['name'],
                ],

                [
                    'kpi_master_id'   => $masters[$item['kpi_master']],
                    'description'     => $item['description'],
                    'weight'          => $item['weight'],
                    'min_score'       => 0,
                    'max_score'       => 100,
                    'measurement_type' => $item['measurement_type'],
                    'is_active'       => true,
                    'created_at'      => now(),
                    'updated_at'      => now(),
                ]

            );
        }
    }
}

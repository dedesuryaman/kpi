<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class KpiTargetSeeder extends Seeder
{
    public function run(): void
    {
        $periodId = DB::table('periods')->value('id');

        $employees = DB::table('employees')->get();

        $targets = [

            // PRODUCTIVITY
            'Achievement of Work Targets' => 95,
            'Task Completion Timeliness' => 95,
            'Workload Utilization' => 90,

            // QUALITY
            'Work Accuracy' => 98,
            'Error Rate' => 5,
            'Rework Rate' => 3,

            // ATTENDANCE
            'Attendance Rate' => 100,
            'Punctuality' => 98,

            // COMPLIANCE
            'SOP Compliance' => 100,
            'Policy Compliance' => 100,

            // CUSTOMER
            'Customer Satisfaction Score' => 90,
            'Complaint Resolution Rate' => 95,

            // TEAMWORK
            'Cross Functional Collaboration' => 90,
            'Communication Effectiveness' => 90,

            // LEARNING
            'Training Completion' => 100,
            'Competency Improvement' => 85,

            // INNOVATION
            'Improvement Initiatives' => 3,
            'Innovation Implementation' => 2,

            // HSE
            'Safety Compliance' => 100,

            // FINANCIAL
            'Budget Compliance' => 95,
            'Cost Efficiency' => 90,
        ];

        foreach ($employees as $employee) {

            foreach ($targets as $indicatorName => $targetValue) {

                $indicatorId = DB::table('kpi_indicators')
                    ->where('name', $indicatorName)
                    ->value('id');

                if (!$indicatorId) {
                    continue;
                }

                DB::table('kpi_targets')->insert([
                    'employee_id' => $employee->id,
                    'indicator_id' => $indicatorId,
                    'target_value' => $targetValue,
                    'period_id' => $periodId,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }

        // foreach ($targets as $indicatorName => $targetValue) {

        //     $indicatorId = DB::table('kpi_indicators')
        //         ->where('name', $indicatorName)
        //         ->value('id');

        //     if (!$indicatorId) {
        //         continue;
        //     }

        //     DB::table('kpi_targets')->insert([
        //         'employee_id' => $employeeId,
        //         'indicator_id' => $indicatorId,
        //         'target_value' => $targetValue,
        //         'period_id' => $periodId,
        //         'created_at' => now(),
        //         'updated_at' => now(),
        //     ]);
        // }
    }
}

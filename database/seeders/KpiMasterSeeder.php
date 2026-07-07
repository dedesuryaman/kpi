<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class KpiMasterSeeder extends Seeder
{
    public function run(): void
    {
    //     $corporateDivision = DB::table('divisions')
    //         ->where('name', 'Corporate')
    //         ->value('id');

    //     $operationDivision = DB::table('divisions')
    //         ->where('name', 'Operations')
    //         ->value('id');

    //     $periodId = DB::table('periods')->value('id');

        $adminId = DB::table('users')
            ->where('email', 'hr.manager@example.com')
            ->value('id');

        // $masters = [

        //     [
        //         'division_id' => $corporateDivision,
        //         'name' => 'Financial Performance',
        //         'description' => 'Measures revenue achievement, profitability, budget compliance, and cost efficiency.',
        //     ],

        //     [
        //         'division_id' => $corporateDivision,
        //         'name' => 'Customer Satisfaction',
        //         'description' => 'Measures customer experience, complaint resolution, service responsiveness, and retention.',
        //     ],

        //     [
        //         'division_id' => $operationDivision,
        //         'name' => 'Productivity',
        //         'description' => 'Measures employee productivity, workload utilization, and achievement of assigned targets.',
        //     ],

        //     [
        //         'division_id' => $operationDivision,
        //         'name' => 'Quality',
        //         'description' => 'Measures work accuracy, error rate, quality standards compliance, and rework reduction.',
        //     ],

        //     [
        //         'division_id' => $corporateDivision,
        //         'name' => 'Compliance & Governance',
        //         'description' => 'Measures adherence to SOPs, internal policies, audit requirements, and corporate governance standards.',
        //     ],

        //     [
        //         'division_id' => $corporateDivision,
        //         'name' => 'Attendance & Discipline',
        //         'description' => 'Measures attendance consistency, punctuality, and compliance with company regulations.',
        //     ],

        //     [
        //         'division_id' => $corporateDivision,
        //         'name' => 'Teamwork & Collaboration',
        //         'description' => 'Measures cooperation, communication effectiveness, and contribution toward team objectives.',
        //     ],

        //     [
        //         'division_id' => $corporateDivision,
        //         'name' => 'Learning & Development',
        //         'description' => 'Measures training completion, competency growth, certification achievement, and knowledge sharing.',
        //     ],

        //     [
        //         'division_id' => $corporateDivision,
        //         'name' => 'Innovation & Improvement',
        //         'description' => 'Measures innovation initiatives, process improvements, and implementation of continuous improvement programs.',
        //     ],

        //     [
        //         'division_id' => $operationDivision,
        //         'name' => 'Health, Safety & Environment (HSE)',
        //         'description' => 'Measures workplace safety compliance, incident prevention, environmental awareness, and risk mitigation.',
        //     ],

        // ];

        $masters = [

            [
                'name' => 'Attendance',
                'description' => 'Measures employee attendance consistency, punctuality, and presence at work.',
            ],

            [
                'name' => 'Productivity',
                'description' => 'Measures output achievement, workload completion, and efficiency in performing tasks.',
            ],

            [
                'name' => 'Quality',
                'description' => 'Measures accuracy of work, error rate, and compliance with quality standards.',
            ],

            [
                'name' => 'Discipline',
                'description' => 'Measures adherence to company rules, SOP compliance, and behavioral discipline.',
            ],

            [
                'name' => 'Innovation',
                'description' => 'Measures ability to contribute new ideas, improvements, and creative problem solving.',
            ],

        ];


        foreach ($masters as $master) {

            DB::table('kpi_masters')->insert([
               // 'division_id' => $master['division_id'],
                //'period_id' => $periodId,
                'name' => $master['name'],
                'description' => $master['description'],
                'status' => 1,
                'created_by' => $adminId,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}

<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PositionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $positions = [
            [
                'name' => 'Director',
                'description' => 'Leads the company and is responsible for overall business strategy and organizational performance.',
            ],
            [
                'name' => 'Manager',
                'description' => 'Manages a department or team, ensuring operational targets and business objectives are achieved.',
            ],
            [
                'name' => 'Supervisor',
                'description' => 'Supervises daily team activities, monitors performance, and reports to the manager.',
            ],
            [
                'name' => 'Staff Unit',
                'description' => 'Performs operational and administrative tasks according to assigned responsibilities.',
            ],
            [
                'name' => 'HR Specialist',
                'description' => 'Handles recruitment, employee development, payroll support, and human resource administration.',
            ],
            [
                'name' => 'Finance Analyst',
                'description' => 'Analyzes financial data, prepares reports, and supports budgeting and forecasting activities.',
            ],
            [
                'name' => 'IT Support',
                'description' => 'Provides technical support, maintains IT infrastructure, and resolves hardware and software issues.',
            ],
            [
                'name' => 'Software Engineer',
                'description' => 'Designs, develops, tests, and maintains software applications and systems.',
            ],
            [
                'name' => 'Production Operator',
                'description' => 'Operates production equipment and ensures manufacturing processes run efficiently and safely.',
            ],
        ];

        foreach ($positions as &$position) {
            $position['created_at'] = now();
            $position['updated_at'] = now();
        }

        DB::table('positions')->insert($positions);
    }
}

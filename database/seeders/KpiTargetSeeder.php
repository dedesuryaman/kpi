<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Employee;
use App\Models\KpiIndicator;
use App\Models\KpiTarget;
use App\Models\Period;

class KpiTargetSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $period = Period::where('status', "active")->first();

        if (!$period) {
            $period = Period::first();
        }

        if (!$period) {
            $this->command->error('Period tidak ditemukan.');
            return;
        }

        $employees = Employee::take(20)->get();

        $indicators = KpiIndicator::all();

        foreach ($employees as $employee) {

            foreach ($indicators as $indicator) {

                KpiTarget::updateOrCreate(
                    [
                        'employee_id' => $employee->id,
                        'indicator_id' => $indicator->id,
                        'period_id' => $period->id,
                    ],
                    [
                        'target_value' => rand(80, 100),
                    ]
                );
            }
        }

        $this->command->info('KPI Target Seeder berhasil.');
    }
}

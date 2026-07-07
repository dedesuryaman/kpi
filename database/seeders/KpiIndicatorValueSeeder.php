<?php

namespace Database\Seeders;

use App\Models\Employee;
use App\Models\KpiIndicator;
use App\Models\KpiIndicatorValue;
use Illuminate\Database\Seeder;

class KpiIndicatorValueSeeder extends Seeder
{
    public function run(): void
    {
        $employees = Employee::all();
        $indicators = KpiIndicator::all();

        foreach ($employees as $employee) {

            foreach ($indicators as $indicator) {

                $target = rand(80, 100);
                $actual = rand(70, 110);

                $score = min(
                    round(($actual / $target) * 100, 2),
                    100
                );

                KpiIndicatorValue::create([
                    'employee_id'      => $employee->id,
                    'kpi_indicator_id' => $indicator->id,
                    'weight'           => 20,
                    'target_value'     => $target,
                    'actual_value'     => $actual,
                    'score'            => $score,
                    'remarks'          => 'Generated Seeder',
                ]);
            }
        }
    }
}

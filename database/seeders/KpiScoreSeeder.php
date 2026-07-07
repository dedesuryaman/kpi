<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class KpiScoreSeeder extends Seeder
{
    public function run(): void
    {
        $periodId = DB::table('periods')
            ->where('status', 'active')
            ->value('id');

        if (!$periodId) {
            $this->command->warn('No active period found.');
            return;
        }

        $assessorId = DB::table('users')->value('id');

        if (!$assessorId) {
            $this->command->warn('No assessor (user) found.');
            return;
        }

        $employees = DB::table('employees')
            ->limit(25)
            ->get();

        $indicators = DB::table('kpi_indicators')->get();

        if ($indicators->isEmpty()) {
            $this->command->warn('No KPI indicators found.');
            return;
        }

        DB::transaction(function () use (
            $employees,
            $indicators,
            $periodId,
            $assessorId
        ) {

            foreach ($employees as $employee) {

                foreach ($indicators as $indicator) {

                    $score = rand(50, 100);

                    $finalScore = round(
                        ($score * $indicator->weight) / 100,
                        2
                    );

                    $notes = match (true) {
                        $score >= 95 => 'Exceptional performance. Consistently exceeds KPI targets and serves as a role model.',
                        $score >= 90 => 'Excellent performance. Achieves KPI targets with high consistency and quality.',
                        $score >= 85 => 'Good performance. Meets expected KPI targets and performs reliably.',
                        $score >= 80 => 'Satisfactory performance. Meets most KPI expectations with room for improvement.',
                        default      => 'Performance requires improvement. Focus on achieving KPI targets consistently.',
                    };

                    DB::table('kpi_scores')->updateOrInsert(
                        [
                            'employee_id' => $employee->id,
                            'indicator_id' => $indicator->id,
                            'period_id'    => $periodId,
                        ],
                        [
                            'score'           => $score,
                            'final_score'     => $finalScore,
                            'assessor_id'     => $assessorId,
                            'assessment_date' => now()->copy()->subDays(rand(1, 30)),
                            'notes'           => $notes,
                            'created_at'      => now(),
                            'updated_at'      => now(),
                        ]
                    );
                }
            }
        });

        $this->command->info(
            "{$employees->count()} employees KPI scores generated successfully."
        );
    }
}

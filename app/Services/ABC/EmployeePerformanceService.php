<?php

namespace App\Services\ABC;

use App\Models\AbcResultDetail;
use App\Models\Employee;
use App\Models\EmployeePerformanceDetail;
use App\Models\EmployeePerformanceResult;
use App\Models\KpiScore;
use Illuminate\Support\Facades\DB;

class EmployeePerformanceService
{
    /**
     * Generate employee performance result.
     */
    public function generate(int $periodId): void
    {
        DB::transaction(function () use ($periodId) {

            EmployeePerformanceResult::where(
                'period_id',
                $periodId
            )->delete();

            $this->storeResults($periodId);

            $this->calculateGrades($periodId);

            $this->calculateRanks($periodId);
        });
    }


    private function storeResults(int $periodId): void
    {
        $weights = $this->getWeights($periodId);

        $employeeIds = KpiScore::where('period_id', $periodId)
            ->distinct()
            ->pluck('employee_id');

        $employees = Employee::whereIn('id', $employeeIds)
            ->orderBy('name')
            ->get();

        foreach ($employees as $employee) {

            $scores = KpiScore::query()
                ->join(
                    'kpi_indicators',
                    'kpi_scores.indicator_id',
                    '=',
                    'kpi_indicators.id'
                )
                ->where('kpi_scores.period_id', $periodId)
                ->where('kpi_scores.employee_id', $employee->id)
                ->groupBy('kpi_indicators.kpi_master_id')
                ->selectRaw("
                kpi_indicators.kpi_master_id,
                AVG(kpi_scores.score) AS average_score
            ")
                ->get()
                ->keyBy('kpi_master_id');

            if ($scores->isEmpty()) {
                continue;
            }

            $averageScore = round(
                $scores->avg('average_score'),
                2
            );

            $finalScore = 0;

            foreach ($weights as $masterId => $weight) {

                $score = $scores->get($masterId);

                if (!$score) {
                    continue;
                }

                $finalScore +=
                    $score->average_score * $weight;
            }

            $result = EmployeePerformanceResult::create([

                'period_id' => $periodId,

                'employee_id' => $employee->id,

                'average_score' => $averageScore,

                'final_score' => round($finalScore, 2),

            ]);

            $this->storeDetails(
                $result,
                $scores,
                $weights
            );
        }
    }

    private function storeDetails(
        EmployeePerformanceResult $result,
        $scores,
        array $weights
    ): void {

        $rows = [];

        foreach ($scores as $score) {

            $weight = $weights[$score->kpi_master_id] ?? 0;

            $rows[] = [
                'performance_result_id' => $result->id,
                'kpi_master_id'         => $score->kpi_master_id,
                'score'                 => round($score->average_score, 2),
                'weight'                => $weight * 100,
                'weighted_score'        => round(
                    $score->average_score * $weight,
                    2
                ),
                'created_at'            => now(),
                'updated_at'            => now(),
            ];
        }

        EmployeePerformanceDetail::insert($rows);
    }


    private function getWeights(int $periodId): array
    {
        return AbcResultDetail::query()
            ->join(
                'abc_results',
                'abc_results.id',
                '=',
                'abc_result_details.abc_result_id'
            )
            ->where(
                'abc_results.period_id',
                $periodId
            )
            ->where(
                'abc_results.is_best',
                true
            )
            ->pluck(
                'abc_result_details.weight',
                'abc_result_details.kpi_master_id'
            )
            ->toArray();
    }

    /**
     * Hitung grade.
     */
    private function calculateGrades(int $periodId): void
    {
        $results = EmployeePerformanceResult::where(
            'period_id',
            $periodId
        )->get();

        foreach ($results as $result) {

            $grade = match (true) {

                $result->final_score >= 90 => 'A',

                $result->final_score >= 80 => 'B',

                $result->final_score >= 70 => 'C',

                default => 'D',
            };

            $result->update([
                'grade' => $grade,
            ]);
        }
    }

    /**
     * Hitung ranking.
     */
    private function calculateRanks(int $periodId): void
    {
        $results = EmployeePerformanceResult::where(
            'period_id',
            $periodId
        )
            ->orderByDesc('final_score')
            ->orderByDesc('average_score')
            ->orderBy('employee_id')
            ->get();

        $rank = 1;

        foreach ($results as $result) {

            $result->update([
                'rank' => $rank++,
            ]);
        }
    }
}

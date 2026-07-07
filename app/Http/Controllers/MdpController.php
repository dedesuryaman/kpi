<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\EmployeePerformanceResult;
use App\Models\KpiScore;
use App\Models\MdpAnalysisResult;
use App\Models\Period;
use App\Services\MDP\MarkovDecisionProcess;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MdpController extends Controller
{
    /**
     * Halaman utama MDP
     */
    public function index()
    {
        $periods = Period::latest()->get();

        $results = MdpAnalysisResult::with('period')
            ->select('period_id')
            ->selectRaw('MAX(created_at) as created_at')
            ->selectRaw('COUNT(*) as total_employee')
            ->selectRaw('AVG(reward) as average_reward')
            ->groupBy('period_id')
            ->latest()
            ->get();

        return view('mdp.index', compact(
            'periods',
            'results'
        ));
    }

    /**
     * Jalankan MDP
     */
    public function run(Request $request)
    {
        $request->validate([
            'period_id' => ['required', 'exists:periods,id']
        ]);

        DB::beginTransaction();

        try {

            (new MarkovDecisionProcess())
                ->run($request->period_id);

            DB::commit();

            return redirect()
                ->route('mdp.show', $request->period_id)
                ->with('success', 'Markov Decision Process berhasil dijalankan.');
        } catch (\Throwable $e) {

            DB::rollBack();

            return back()
                ->withInput()
                ->withErrors([
                    'error' => $e->getMessage()
                ]);
        }
    }

    /**
     * Display MDP Analysis Detail
     */
    public function show($periodId)
    {
        $employees = Employee::all();

        $results = MdpAnalysisResult::with([
            'employee',
            'state',
            'action',
            'period'
        ])
            ->where('period_id', $periodId)
            ->orderByDesc('reward')
            ->get();

        abort_if(
            $results->isEmpty(),
            404,
            'MDP Analysis belum tersedia.'
        );

        /*
    |--------------------------------------------------------------------------
    | Summary
    |--------------------------------------------------------------------------
    */

        $summary = [
            'total_employee' => $results->count(),

            'average_reward' => round(
                $results->avg('reward'),
                2
            ),

            'promotion' => $results
                ->where('action.code', 'PROMOTION')
                ->count(),

            'bonus' => $results
                ->where('action.code', 'BONUS')
                ->count(),

            'coaching' => $results
                ->where('action.code', 'COACHING')
                ->count(),

            'warning' => $results
                ->where('action.code', 'WARNING')
                ->count(),
        ];

        /*
    |--------------------------------------------------------------------------
    | MDP Charts
    |--------------------------------------------------------------------------
    */

        $stateChart = $results
            ->groupBy(fn($row) => $row->state->name)
            ->map->count();

        $actionChart = $results
            ->groupBy(fn($row) => $row->action->name)
            ->map->count();

        $rewardChart = $results
            ->sortByDesc('reward')
            ->take(10)
            ->values();

        /*
    |--------------------------------------------------------------------------
    | KPI Distribution
    |--------------------------------------------------------------------------
    */

        $performance = EmployeePerformanceResult::where(
            'period_id',
            $periodId
        )->get();

        $excellent = $performance
            ->where('final_score', '>=', 90)
            ->count();

        $good = $performance
            ->whereBetween('final_score', [70, 89.99])
            ->count();

        $poor = $performance
            ->where('final_score', '<', 70)
            ->count();

        /*
    |--------------------------------------------------------------------------
    | Average KPI Indicator
    |--------------------------------------------------------------------------
    */

        $indicatorAverage = KpiScore::query()
            ->join(
                'kpi_indicators',
                'kpi_scores.indicator_id',
                '=',
                'kpi_indicators.id'
            )
            ->where('kpi_scores.period_id', $periodId)
            ->selectRaw('kpi_indicators.name, AVG(score) AS average_score')
            ->groupBy(
                'kpi_indicators.id',
                'kpi_indicators.name'
            )
            ->pluck(
                'average_score',
                'name'
            );

        /*
    |--------------------------------------------------------------------------
    | Average KPI Master
    |--------------------------------------------------------------------------
    */

        $masterAverage = KpiScore::query()
            ->join(
                'kpi_indicators',
                'kpi_scores.indicator_id',
                '=',
                'kpi_indicators.id'
            )
            ->join(
                'kpi_masters',
                'kpi_indicators.kpi_master_id',
                '=',
                'kpi_masters.id'
            )
            ->where('kpi_scores.period_id', $periodId)
            ->selectRaw('kpi_masters.name, AVG(score) AS average_score')
            ->groupBy(
                'kpi_masters.id',
                'kpi_masters.name'
            )
            ->pluck(
                'average_score',
                'name'
            );

        /*
    |--------------------------------------------------------------------------
    | View
    |--------------------------------------------------------------------------
    */

        return view('mdp.show', compact(
            'employees',
            'results',
            'summary',
            'stateChart',
            'actionChart',
            'rewardChart',

            'excellent',
            'good',
            'poor',

            'indicatorAverage',
            'masterAverage'
        ));
    }

    /**
     * Hapus hasil MDP
     */
    public function destroy($id)
    {
        $result = MdpAnalysisResult::findOrFail($id);

        $periodId = $result->period_id;

        MdpAnalysisResult::where(
            'period_id',
            $periodId
        )->delete();

        return redirect()
            ->route('mdp.index')
            ->with(
                'success',
                'Hasil analisis berhasil dihapus.'
            );
    }
}

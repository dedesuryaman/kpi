<?php

namespace App\Http\Controllers;

use App\Models\Department;
use Illuminate\Http\Request;
use App\Models\EmployeePerformanceResult;
use App\Models\Period;
use App\Models\PunishmentHistory;
use App\Models\RewardRecommendation;
use App\Models\User;
use Illuminate\Support\Facades\DB;


class RewardPunishmentController extends Controller
{


    public function index(Request $request)
    {
        $periods = Period::latest()->get();

        $periodId = $request->period_id
            ?? Period::where('status', 'active')->value('id');

        $results = EmployeePerformanceResult::query()
            ->with(['employee.department'])
            ->where('period_id', $periodId)
            ->get();

        $summary = [

            'total_employee' => $results->count(),

            'average_score' => round($results->avg('final_score'), 2),

            'reward' => $results->filter(function ($item) {
                return $item->final_score >= 90;
            })->count(),

            'punishment' => $results->filter(function ($item) {
                return $item->final_score < 60;
            })->count(),

            'normal' => $results->filter(function ($item) {
                return $item->final_score >= 60 &&
                    $item->final_score < 90;
            })->count(),

        ];

        $topReward = $results
            ->sortByDesc('final_score')
            ->take(10)
            ->values();

        $needCoaching = $results
            ->sortBy('final_score')
            ->take(10)
            ->values();

        $divisionSummary = DB::table('employee_performance_results')
            ->join('employees', 'employees.id', '=', 'employee_performance_results.employee_id')
            ->join('departments', 'departments.id', '=', 'employees.department_id')
            ->where('employee_performance_results.period_id', $periodId)
            ->groupBy('departments.id', 'departments.name')
            ->select(
                'departments.name',
                DB::raw('COUNT(*) as total_employee'),
                DB::raw('ROUND(AVG(employee_performance_results.final_score),2) as average_score')
            )
            ->orderByDesc('average_score')
            ->get();

        return view(
            'reward-punishment.index',
            compact(
                'periods',
                'periodId',
                'summary',
                'topReward',
                'needCoaching',
                'divisionSummary'
            )
        );
    }


    public function reward(Request $request)
    {
        $periods = Period::latest()->get();

        $periodId = $request->period_id
            ?? Period::where('status', 'active')->value('id');

        $departmentId = $request->department_id;


        $query = EmployeePerformanceResult::with([
            'employee.department',
            'latestRewardRecommendation',

        ])
            ->where('period_id', $periodId)
            ->where('final_score', '>=', 80);

        if ($departmentId) {
            $query->whereHas('employee', function ($q) use ($departmentId) {
                $q->where('department_id', $departmentId);
            });
        }

        $rewards = $query
            ->orderByDesc('final_score')
            ->orderBy('rank')
            ->get()
            ->map(function ($item) {

                $score = $item->final_score;

                if ($score >= 95) {

                    $recommendation = 'Promotion';
                    $badge = 'danger';
                } elseif ($score >= 90) {

                    $recommendation = 'Salary Increase';
                    $badge = 'success';
                } elseif ($score >= 85) {

                    $recommendation = 'Performance Bonus';
                    $badge = 'primary';
                } else {

                    $recommendation = 'Certificate';
                    $badge = 'warning';
                }

                $item->recommendation = $recommendation;
                $item->badge = $badge;

                $item->reason = match (true) {

                    $score >= 95 =>
                    'Outstanding performance, Grade A, and Top Performer.',

                    $score >= 90 =>
                    'Consistently exceeded KPI targets throughout the evaluation period.',

                    $score >= 85 =>
                    'Excellent performance with stable KPI achievement.',

                    default =>
                    'Good performance and eligible for recognition.',
                };

                $item->status = 'Draft';

                return $item;
            });

        $summary = [

            'promotion' => $rewards->where('recommendation', 'Promotion')->count(),

            'salary_increase' => $rewards->where('recommendation', 'Salary Increase')->count(),

            'bonus' => $rewards->where('recommendation', 'Performance Bonus')->count(),

            'certificate' => $rewards->where('recommendation', 'Certificate')->count(),

            'total' => $rewards->count(),

        ];


        $departments = Department::orderBy('name')->get();

        return view(
            'reward-punishment.reward',
            compact(
                'periods',
                'periodId',
                'departments',
                'departmentId',
                'summary',
                'rewards'
            )
        );
    }



    public function approve(Request $request, EmployeePerformanceResult $result)
    {
        $validated = $request->validate([
            'reward_type' => [
                'required',
                'in:Promotion,Salary Increase,Performance Bonus,Certificate'
            ],
            'effective_date' => [
                'required',
                'date'
            ],
            'approval_notes' => [
                'nullable',
                'string',
                'max:1000'
            ],
        ]);

        DB::transaction(function () use ($validated, $result) {

            RewardRecommendation::create([
                'performance_result_id' => $result->id,
                'period_id'             => $result->period_id, // jika ingin menyimpan period
                'reward_type'           => $validated['reward_type'],
                'status'                => RewardRecommendation::STATUS_APPROVED,
                'effective_date'        => $validated['effective_date'],
                'approval_notes'        => $validated['approval_notes'],
                'approved_by'           => auth()->id(),
                'approved_at'           => now(),
            ]);
        });
        // DB::transaction(function () use ($validated, $result) {

        //     RewardRecommendation::updateOrCreate(
        //         [
        //             'performance_result_id' => $result->id,
        //         ],
        //         [
        //             'reward_type'      => $validated['reward_type'],
        //             'status'           => RewardRecommendation::STATUS_APPROVED,
        //             'effective_date'   => $validated['effective_date'],
        //             'approval_notes'   => $validated['approval_notes'],
        //             'approved_by'      => auth()->id(),
        //             'approved_at'      => now(),
        //         ]
        //     );
        // });

        return redirect()
            ->route('reward-punishment.show', $result)
            ->with(
                'success',
                'Reward recommendation approved successfully.'
            );
    }



    public function reject(Request $request, EmployeePerformanceResult $result)
    {
        $validated = $request->validate([
            'approval_notes' => [
                'required',
                'string',
                'max:1000',
            ],
        ]);

        DB::transaction(function () use ($result, $validated) {

            $latestRecommendation = $result->latestRewardRecommendation;

            if (!$latestRecommendation) {

                DB::transaction(function () use ($result, $validated) {

                    RewardRecommendation::create([
                        'performance_result_id' => $result->id,
                        'reward_type'           => "", // atau default jika wajib
                        'effective_date'        => now(),
                        'status'                => RewardRecommendation::STATUS_REJECTED,
                        'approval_notes'        => $validated['approval_notes'],
                        'approved_by'           => auth()->id(),
                        'approved_at'           => now(),
                    ]);
                });


                return redirect()
                    ->route('reward-punishment.show', $result)
                    ->with(
                        'success',
                        'Reward recommendation rejected successfully.'
                    );

                // abort(404, 'Reward recommendation not found.');
            }

            RewardRecommendation::create([
                'performance_result_id' => $result->id,
                'reward_type'           => $latestRecommendation->reward_type,
                'effective_date'        => $latestRecommendation->effective_date,
                'status'                => RewardRecommendation::STATUS_REJECTED,
                'approval_notes'        => $validated['approval_notes'],
                'approved_by'           => auth()->id(),
                'approved_at'           => now(),
            ]);
        });

        return redirect()
            ->route('reward-punishment.show', $result)
            ->with(
                'success',
                'Reward recommendation rejected successfully.'
            );
    }

    public function print(EmployeePerformanceResult $result)
    {
        $result->load([
            'employee.department',
            'period',
            'details.kpiMaster'
        ]);

        return view(
            'reward-punishment.print',
            compact('result')
        );
    }



    public function punishment(Request $request)
    {
        $search       = trim($request->search);
        $departmentId = $request->department_id;
        $periodId     = $request->period_id;
        $status       = $request->status;

        $punishments = EmployeePerformanceResult::query()

            ->with([
                'employee.department',
                'employee.position',
                'period',

            ])

            ->where('approval_status', 'Approved')

            // hanya score rendah
            //->where('final_score', '<', 70)

            ->when($search, function ($query) use ($search) {

                $query->whereHas('employee', function ($employee) use ($search) {

                    $employee->where('name', 'like', "%{$search}%")
                        ->orWhere('employee_code', 'like', "%{$search}%");
                });
            })

            ->when($departmentId, function ($query) use ($departmentId) {

                $query->whereHas('employee', function ($employee) use ($departmentId) {

                    $employee->where('department_id', $departmentId);
                });
            })

            ->when($periodId, function ($query) use ($periodId) {

                $query->where('period_id', $periodId);
            })

            ->when($status, function ($query) use ($status) {

                $query->where('punishment_status', $status);
            })

            ->paginate(10)

            ->withQueryString();

        $departments = Department::orderBy('name')->get();
        $periods     = Period::latest()->get();

        $histories = PunishmentHistory::whereIn(
            'employee_id',
            $punishments->pluck('employee_id')
        )->whereIn(
            'period_id',
            $punishments->pluck('period_id')
        )->get()->keyBy(function ($item) {
            return $item->employee_id . '-' . $item->period_id;
        });
        $punishments->getCollection()->transform(function ($item) use ($histories) {

            $key = $item->employee_id . '-' . $item->period_id;

            $item->punishmentHistory = $histories->get($key);

            return $item;
        });

        return view(
            'reward-punishment.punishment',
            compact(
                'punishments',
                'departments',
                'periods'
            )
        );
    }

    public function review(EmployeePerformanceResult $result)
    {
        $result->load([
            'employee.department',
            'period',
            'abcResult',
            'mdpResult',
            'aiAnalysis',
        ]);


        $review = PunishmentHistory::firstOrNew([
            'employee_id' => $result->employee_id,
            'period_id' => $result->period_id,

        ]);

        return view(
            'reward-punishment.review',
            compact('result', 'review')
        );
    }


    public function storeReview(Request $request, EmployeePerformanceResult $result)
    {
        $request->validate([
            'type' => 'required',
            'severity' => 'required',
            'notes' => 'nullable'
        ]);

        PunishmentHistory::updateOrCreate(

            [
                'employee_id' => $result->employee_id,
                'period_id'   => $result->period_id,
            ],

            [
                'type'        => $request->type,
                'severity'    => $request->severity,
                'notes'       => $request->notes,
                'approved_by' => auth()->id(),
            ]

        );

        return redirect()
            ->route(
                'reward-punishment.punishment.review',
                $result->id
            )
            ->with('success', 'Punishment review saved.');
    }



    public function history() {}

    public function show(EmployeePerformanceResult $result)
    {
        $result->load([
            'employee.department',
            'employee.position',
            'period',
            'details.kpiMaster',
            'latestRewardRecommendation.approver',
            'aiAnalysis'
        ]);

        /*
    |--------------------------------------------------------------------------
    | Performance History
    |--------------------------------------------------------------------------
    */

        $history = EmployeePerformanceResult::query()
            ->with('period')
            ->where('employee_id', $result->employee_id)
            ->orderByDesc('period_id')
            ->get();


        /*
    |--------------------------------------------------------------------------
    | Department Ranking
    |--------------------------------------------------------------------------
    */

        $departmentRanking = EmployeePerformanceResult::query()
            ->join('employees', 'employees.id', '=', 'employee_performance_results.employee_id')
            ->where('employee_performance_results.period_id', $result->period_id)
            ->where('employees.department_id', $result->employee->department_id)
            ->orderByDesc('employee_performance_results.final_score')
            ->select(
                'employee_performance_results.*'
            )
            ->get();


        /*
    |--------------------------------------------------------------------------
    | KPI Summary
    |--------------------------------------------------------------------------
    */

        $kpiSummary = $result->details
            ->sortByDesc('weighted_score');

        /*
    |--------------------------------------------------------------------------
    | Overall KPI Statistics
    |--------------------------------------------------------------------------
    */

        $statistics = EmployeePerformanceResult::query()
            ->where('period_id', $result->period_id)
            ->selectRaw('
            AVG(final_score) as average_score,
            MAX(final_score) as highest_score,
            MIN(final_score) as lowest_score
        ')
            ->first();

        /*
    |--------------------------------------------------------------------------
    | Existing Recommendation
    |--------------------------------------------------------------------------
    */

        $recommendation = $result->rewardRecommendation;

        /*
    |--------------------------------------------------------------------------
    | Suggested Reward
    |--------------------------------------------------------------------------
    */

        $suggestedReward = match (true) {

            $result->final_score >= 95 =>
            'Promotion',

            $result->final_score >= 90 =>
            'Salary Increase',

            $result->final_score >= 85 =>
            'Performance Bonus',

            $result->final_score >= 80 =>
            'Certificate',

            default =>
            null,
        };

        return view(
            'reward-punishment.show',
            compact(
                'result',
                'history',
                'departmentRanking',
                'kpiSummary',
                'statistics',
                'recommendation',
                'suggestedReward'
            )
        );
    }

    public function xshow(EmployeePerformanceResult $result)
    {


        $result->load([
            'employee.department',
            'period',
            'details.kpiMaster',
            'rewardRecommendation.approver',
        ]);

        return view(
            'reward-punishment.show',
            compact('result')
        );
    }
}

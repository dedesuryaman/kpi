<?php

namespace App\Http\Controllers;

use App\Events\UserNotification;
use App\Models\AbcResult;
use App\Models\AnggaranRealisasi;
use App\Models\Department;
use App\Models\Employee;
use App\Models\EmployeePerformanceResult;
use App\Models\KpiMaster;
use App\Models\LaporanKendala;
use App\Models\MdpAnalysisResult;
use App\Models\SubPekerjaan;
use App\Models\Organization;
use App\Models\Pekerjaan;
use App\Models\User;
use App\Models\Project;
use App\Models\SubPekerjaanProgress;
use App\Models\SubKegiatanProgress;
use App\Models\PekerjaanProgress;
use App\Models\PengawasanHistories;
use App\Models\Period;
use App\Models\Position;
use App\Models\RewardRecommendation;
use App\Models\SubKegiatan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Carbon\Carbon;

class DashboardController extends Controller
{
	public function __construct()
	{

		$this->middleware('auth');
	}

	public function index(Request $request)
	{

		$user = auth()->user();


		if ($user->hasRole('super-admin')) {
			return $this->superadminDashboard();
		}

		if ($user->hasRole('hrd')) {
			return $this->hrdDashboard();
		}

		if ($user->hasRole('director')) {
			return $this->directorDashboard();
		}

		if ($user->hasRole('manager')) {
			return $this->managerDashboard();
		}

		if ($user->hasRole('supervisor')) {
			return $this->supervisorDashboard();
		}

		if ($user->hasRole('employee')) {
			return $this->employeeDashboard();
		}

		abort(403, 'Role tidak dikenali.');
	}

	private function superadminDashboard()
	{
		/*
        |--------------------------------------------------------------------------
        | Active Period
        |--------------------------------------------------------------------------
        */

		$activePeriod = Period::where('status', "active")->first();

		/*
        |--------------------------------------------------------------------------
        | Summary
        |--------------------------------------------------------------------------
        */

		$employeeCount = Employee::count();

		$departmentCount = Department::count();

		$positionCount = Position::count();

		$kpiMasterCount = KpiMaster::count();

		/*
        |--------------------------------------------------------------------------
        | Performance Result
        |--------------------------------------------------------------------------
        */

		$performanceQuery = EmployeePerformanceResult::query();

		if ($activePeriod) {
			$performanceQuery->where('period_id', $activePeriod->id);
		}

		$averageScore = (clone $performanceQuery)->avg('final_score') ?? 0;

		$highestScore = (clone $performanceQuery)->max('final_score') ?? 0;

		$lowestScore = (clone $performanceQuery)->min('final_score') ?? 0;

		$completedAssessment = (clone $performanceQuery)->count();

		$completionRate = $employeeCount > 0
			? round(($completedAssessment / $employeeCount) * 100, 1)
			: 0;

		/*
        |--------------------------------------------------------------------------
        | Reward Status
        |--------------------------------------------------------------------------
        */

		$pendingReward = RewardRecommendation::where('status', 'Pending')->count();

		$approvedReward = RewardRecommendation::where('status', 'Approved')->count();

		$rejectedReward = RewardRecommendation::where('status', 'Rejected')->count();

		$draftReward = RewardRecommendation::where('status', 'Draft')->count();

		/*
        |--------------------------------------------------------------------------
        | Grade Distribution
        |--------------------------------------------------------------------------
        */

		$gradeDistribution = EmployeePerformanceResult::select(
			'grade',
			DB::raw('COUNT(*) as total')
		)
			->when($activePeriod, function ($query) use ($activePeriod) {
				$query->where('period_id', $activePeriod->id);
			})
			->groupBy('grade')
			->pluck('total', 'grade');

		/*
        |--------------------------------------------------------------------------
        | Department Performance
        |--------------------------------------------------------------------------
        */

		$departmentPerformance = EmployeePerformanceResult::select(
			'departments.name',
			DB::raw('AVG(employee_performance_results.final_score) as average_score')
		)
			->join('employees', 'employees.id', '=', 'employee_performance_results.employee_id')
			->join('departments', 'departments.id', '=', 'employees.department_id')
			->when($activePeriod, function ($query) use ($activePeriod) {
				$query->where('employee_performance_results.period_id', $activePeriod->id);
			})
			->groupBy('departments.name')
			->orderByDesc('average_score')
			->get();

		/*
        |--------------------------------------------------------------------------
        | Monthly KPI Trend
        |--------------------------------------------------------------------------
        */

		$monthlyTrend = EmployeePerformanceResult::select(
			DB::raw('MONTH(created_at) as month'),
			DB::raw('AVG(final_score) as average_score')
		)
			->when($activePeriod, function ($query) use ($activePeriod) {
				$query->where('period_id', $activePeriod->id);
			})
			->groupBy(DB::raw('MONTH(created_at)'))
			->orderBy(DB::raw('MONTH(created_at)'))
			->get();

		/*
        |--------------------------------------------------------------------------
        | Top Performer
        |--------------------------------------------------------------------------
        */

		$topPerformers = EmployeePerformanceResult::with([
			'employee.department'
		])
			->when($activePeriod, function ($query) use ($activePeriod) {
				$query->where('period_id', $activePeriod->id);
			})
			->orderByDesc('final_score')
			->limit(10)
			->get();

		/*
        |--------------------------------------------------------------------------
        | Recent Reward Activity
        |--------------------------------------------------------------------------
        */

		$recentRewards = RewardRecommendation::with([
			'performanceResult.employee.department'
		])
			->latest()
			->take(10)
			->get();

		/*
        |--------------------------------------------------------------------------
        | Latest ABC
        |--------------------------------------------------------------------------
        */

		$latestABC = AbcResult::latest()->first();

		/*
        |--------------------------------------------------------------------------
        | Latest MDP
        |--------------------------------------------------------------------------
        */

		$latestMDP = MdpAnalysisResult::latest()->first();


		$kpiTrend = EmployeePerformanceResult::selectRaw('period_id, AVG(final_score) as score')
			->with('period')
			->groupBy('period_id')
			->orderBy('period_id')
			->get()
			->map(function ($item) {
				return [
					'label' => $item->period?->name ?? 'Unknown',
					'score' => round($item->score, 2),
				];
			});

		/*
        |--------------------------------------------------------------------------
        | Return View
        |--------------------------------------------------------------------------
        */

		return view('dashboard.super-admin', [

			'activePeriod' => $activePeriod,

			'employeeCount' => $employeeCount,
			'departmentCount' => $departmentCount,
			'positionCount' => $positionCount,
			'kpiMasterCount' => $kpiMasterCount,

			'averageScore' => round($averageScore, 2),
			'highestScore' => round($highestScore, 2),
			'lowestScore' => round($lowestScore, 2),
			'completedAssessment' => $completedAssessment,
			'completionRate' => $completionRate,

			'pendingReward' => $pendingReward,
			'approvedReward' => $approvedReward,
			'rejectedReward' => $rejectedReward,
			'draftReward' => $draftReward,

			'gradeDistribution' => $gradeDistribution,

			'departmentPerformance' => $departmentPerformance,

			'monthlyTrend' => $monthlyTrend,

			'topPerformers' => $topPerformers,

			'recentRewards' => $recentRewards,

			'latestABC' => $latestABC,

			'latestMDP' => $latestMDP,

			'kpiTrend' => $kpiTrend,

		]);
	}

	private function hrdDashboard()
	{
		// Query dashboard HRD

		// Periode Aktif
		$activePeriod = Period::where('status', 'active')->first();

		// Ringkasan
		$totalEmployees = Employee::count();

		$submitted = 0;
		$approved = 0;
		$rejected = 0;
		$pending = 0;

		if ($activePeriod) {
			$submitted = EmployeePerformanceResult::where('period_id', $activePeriod->id)
				->distinct('employee_id')
				->count('employee_id');

			$approved = EmployeePerformanceResult::where('period_id', $activePeriod->id)
				->where('approval_status', 'Approved')
				->count();

			$rejected = EmployeePerformanceResult::where('period_id', $activePeriod->id)
				->where('approval_status', 'Rejected')
				->count();

			$pending = EmployeePerformanceResult::where('period_id', $activePeriod->id)
				->where('approval_status', 'Pending')
				->count();
		}

		$notSubmitted = max($totalEmployees - $submitted, 0);

		// Reward
		$latestReward = RewardRecommendation::select(
			'performance_result_id',
			DB::raw('MAX(id) as latest_id')
		)
			->groupBy('performance_result_id');

		$rewardStatus = RewardRecommendation::joinSub($latestReward, 'latest', function ($join) {
			$join->on('reward_recommendations.id', '=', 'latest.latest_id');
		})
			->select('status', DB::raw('COUNT(*) as total'))
			->groupBy('status')
			->pluck('total', 'status');

		$rewardPending  = $rewardStatus['Pending'] ?? 0;
		$rewardApproved = $rewardStatus['Approved'] ?? 0;
		$rewardRejected = $rewardStatus['Rejected'] ?? 0;


		// Komposisi Karyawan
		$employmentStatus = Employee::select(
			'employment_status',
			DB::raw('COUNT(*) as total')
		)
			->groupBy('employment_status')
			->pluck('total', 'employment_status');

		// Department Performance
		$departmentPerformance = Department::select(
			'departments.name',
			DB::raw('COUNT(DISTINCT employees.id) as total_employee'),
			DB::raw('ROUND(AVG(employee_performance_results.final_score),2) as average_score')
		)
			->leftJoin('employees', 'employees.department_id', '=', 'departments.id')
			->leftJoin('employee_performance_results', function ($join) use ($activePeriod) {
				$join->on('employee_performance_results.employee_id', '=', 'employees.id');

				if ($activePeriod) {
					$join->where('employee_performance_results.period_id', $activePeriod->id);
				}
			})
			->groupBy('departments.id', 'departments.name')
			->get();

		// Top Performer
		$topPerformers = EmployeePerformanceResult::with([
			'employee.department'
		])
			->when($activePeriod, function ($query) use ($activePeriod) {
				$query->where('period_id', $activePeriod->id);
			})
			->orderByDesc('final_score')
			->take(10)
			->get();

		// Lowest Performer
		$lowestPerformers = EmployeePerformanceResult::with([
			'employee.department'
		])
			->when($activePeriod, function ($query) use ($activePeriod) {
				$query->where('period_id', $activePeriod->id);
			})
			->orderBy('final_score')
			->take(10)
			->get();

		// Waiting Approval
		$waitingApproval = EmployeePerformanceResult::with([
			'employee.department'
		])
			->when($activePeriod, function ($query) use ($activePeriod) {
				$query->where('period_id', $activePeriod->id);
			})
			->where('approval_status', 'Waiting')
			->latest()
			->take(10)
			->get();

		return view('dashboard.hrd', compact(
			'activePeriod',
			'totalEmployees',
			'submitted',
			'notSubmitted',
			'approved',
			'rejected',
			'pending',
			'rewardPending',
			'rewardApproved',
			'rewardRejected',
			'employmentStatus',
			'departmentPerformance',
			'topPerformers',
			'lowestPerformers',
			'waitingApproval'
		));
	}

	private function directorDashboard()
	{
		/*
        |--------------------------------------------------------------------------
        | Executive Cards
        |--------------------------------------------------------------------------
        */

		$companyScore = round(
			EmployeePerformanceResult::avg('final_score') ?? 0,
			2
		);

		$employeeCount = Employee::count();


		$latestRewards = RewardRecommendation::whereIn('id', function ($query) {
			$query->select(DB::raw('MAX(id)'))
				->from('reward_recommendations')
				->groupBy('performance_result_id');
		});


		$rewardApprovedCount = (clone $latestRewards)
			->where('status', 'Approved')
			->count();

		$rewardRejectedCount = (clone $latestRewards)
			->where('status', 'Rejected')
			->count();

		$rewardPendingCount = (clone $latestRewards)
			->where('status', 'Pending')
			->count();

		/*
        |--------------------------------------------------------------------------
        | Monthly Performance Trend
        |--------------------------------------------------------------------------
        */

		$monthly = EmployeePerformanceResult::select(
			DB::raw('MONTH(created_at) as month'),
			DB::raw('AVG(final_score) as score')
		)
			->groupBy('month')
			->orderBy('month')
			->get();

		$months = [];
		$scores = [];

		foreach ($monthly as $item) {

			$months[] = date('M', mktime(0, 0, 0, $item->month, 1));

			$scores[] = round($item->score, 2);
		}

		/*
        |--------------------------------------------------------------------------
        | Department Ranking
        |--------------------------------------------------------------------------
        */

		$departmentRanking = Department::leftJoin(
			'employees',
			'departments.id',
			'=',
			'employees.department_id'
		)
			->leftJoin(
				'employee_performance_results',
				'employees.id',
				'=',
				'employee_performance_results.employee_id'
			)
			->select(
				'departments.name',
				DB::raw('AVG(employee_performance_results.final_score) as score')
			)
			->groupBy('departments.id', 'departments.name')
			->orderByDesc('score')
			->get();

		$departmentLabels = $departmentRanking->pluck('name');

		$departmentScores = $departmentRanking
			->pluck('score')
			->map(fn($v) => round($v, 2));

		/*
        |--------------------------------------------------------------------------
        | Employee Distribution
        |--------------------------------------------------------------------------
        */

		$excellent = EmployeePerformanceResult::where('final_score', '>=', 90)->count();

		$good = EmployeePerformanceResult::whereBetween(
			'final_score',
			[75, 89.99]
		)->count();

		$average = EmployeePerformanceResult::whereBetween(
			'final_score',
			[60, 74.99]
		)->count();

		$poor = EmployeePerformanceResult::where(
			'final_score',
			'<',
			60
		)->count();

		/*
        |--------------------------------------------------------------------------
        | Top Employee
        |--------------------------------------------------------------------------
        */

		$topEmployees = EmployeePerformanceResult::with([
			'employee.department'
		])
			->orderByDesc('final_score')
			->limit(10)
			->get();

		/*
        |--------------------------------------------------------------------------
        | Need Improvement
        |--------------------------------------------------------------------------
        */

		$needImprovement = EmployeePerformanceResult::with([
			'employee.department'
		])
			->orderBy('final_score')
			->limit(10)
			->get();

		/*
        |--------------------------------------------------------------------------
        | Reward Recommendation
        |--------------------------------------------------------------------------
        */

		$rewardRecommendations = RewardRecommendation::with([
			'employee.department'
		])
			->latest()
			->limit(10)
			->get();

		return view('dashboard.director', compact(

			'companyScore',

			'employeeCount',

			'rewardApprovedCount',

			'rewardRejectedCount',

			'months',

			'scores',

			'departmentLabels',

			'departmentScores',

			'excellent',

			'good',

			'average',

			'poor',

			'topEmployees',

			'needImprovement',

			'rewardRecommendations'
		));
	}

	private function managerDashboard()
	{
		// Query dashboard Manager
		return view('dashboard.manager');
	}

	private function supervisorDashboard()
	{
		// Query dashboard Supervisor
		return view('dashboard.supervisor');
	}

	private function employeeDashboard()
	{
		// Query dashboard Employee
		return view('dashboard.employee');
	}
}

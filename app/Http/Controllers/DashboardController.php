<?php

namespace App\Http\Controllers;

use App\Events\UserNotification;
use App\Models\AnggaranRealisasi;
use App\Models\Department;
use App\Models\Employee;
use App\Models\EmployeePerformanceResult;
use App\Models\LaporanKendala;
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
			->where('approval_status', 'Pending')
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
		// Query dashboard Director
		return view('dashboard.director');
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

<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Helpers\ApiResponse;
use Illuminate\Support\Facades\Auth;
use App\Models\Pekerjaan;
use App\Models\LaporanKendala;

/**
 * @OA\Tag(
 *     name="Dashboard",
 *     description="API endpoints for dashboard"
 * )
 */
class DashboardController extends Controller
{
	/**
	 * @OA\Get(
	 *     path="/api/mobile/dashboard",
	 *     tags={"Dashboard"},
	 *     summary="Get dashboard data",
	 *     description="Mengambil data dashboard untuk user yang sedang login, termasuk informasi profile dan status proyek.",
	 *     security={{"sanctum":{}}},
	 *
	 *     @OA\Response(
	 *         response=200,
	 *         description="Dashboard data retrieved successfully",
	 *         @OA\JsonContent(
	 *             @OA\Property(property="status", type="boolean", example=true),
	 *             @OA\Property(property="message", type="string", example="Dashboard data"),
	 *             @OA\Property(
	 *                 property="data",
	 *                 type="object",
	 *                 @OA\Property(
	 *                     property="profile",
	 *                     type="object",
	 *                     @OA\Property(property="id", type="integer", example=1),
	 *                     @OA\Property(property="name", type="string", example="Abdul"),
	 *                     @OA\Property(property="email", type="string", example="abdul@example.com"),
	 *                     @OA\Property(property="phone", type="string", example="08123456789")
	 *                 ),
	 *                 @OA\Property(
	 *                     property="project_status",
	 *                     type="object",
	 *                     @OA\Property(property="total_proyek", type="integer", example=25),
	 *                     @OA\Property(property="total_on_progress", type="integer", example=10),
	 *                     @OA\Property(property="total_selesai", type="integer", example=5),
	 *                     @OA\Property(property="total_active", type="integer", example=20),
	 *                     @OA\Property(property="total_inactive", type="integer", example=5),
	 *                     @OA\Property(property="total_dokumen", type="integer", example=50),
	 *                     @OA\Property(property="total_pengawasan", type="integer", example=30),
	 *                     @OA\Property(property="total_kendala", type="integer", example=2)
	 *                 )
	 *             )
	 *         )
	 *     ),
	 *
	 *     @OA\Response(
	 *         response=401,
	 *         description="Unauthorized - Token tidak valid"
	 *     )
	 * )
	 */
	public function index(Request $request)
	{
		$me = $request->user()->load('roles');

		// Gunakan subquery untuk menghitung relasi agar LEFT JOIN tidak duplikasi row
		$project_status = Pekerjaan::where('opd_pengawas_id', $me->id)
			->selectRaw("
				COUNT(*) as total_proyek,
				SUM(CASE WHEN status_progress = 'on_progress' THEN 1 ELSE 0 END) as total_on_progress,
				SUM(CASE WHEN status_progress = 'selesai' THEN 1 ELSE 0 END) as total_selesai,
				SUM(CASE WHEN status = 'Active' THEN 1 ELSE 0 END) as total_active,
				SUM(CASE WHEN status = 'Inactive' THEN 1 ELSE 0 END) as total_inactive
			")
			->first();

		$total_dokumen = \App\Models\Dokumen::whereHas('pekerjaan', function ($q) use ($me) {
			$q->where('pekerjaans.opd_pengawas_id', $me->id);
		})->count();

		$total_pengawasan = \App\Models\PengawasanHistories::with('pekerjaan', function ($q) use ($me) {
			$q->where('pekerjaan.opd_pengawas_id', $me->id);
		})->where('user_id', $me->id)->count();

		$total_kendala = \App\Models\LaporanKendala::with('pekerjaan', function ($q) use ($me) {
			$q->where('pekejaan.opd_pengawas_id', $me->id);
		})->where('user_id', $me->id)->count();

		$projectstatus = [
			'total_proyek' => (int) ($project_status->total_proyek ?? 0),
			'total_on_progress' => (int) ($project_status->total_on_progress ?? 0),
			'total_selesai' => (int) ($project_status->total_selesai ?? 0),
			'total_active' => (int) ($project_status->total_active ?? 0),
			'total_inactive' => (int) ($project_status->total_inactive ?? 0),
			'total_dokumen' => $total_dokumen ?? 0,
			'total_pengawasan' => $total_pengawasan ?? 0,
			'total_kendala' => $total_kendala ?? 0,
		];

		$profile = [
			'id' => $me->id,
			'name' => $me->name,
			'email' => $me->email,
			'phone' => $me->phone,
		];

		return ApiResponse::success([
			'profile' => $profile,
			'project_status' => $projectstatus,
		], 'Dashboard data');
	}
}

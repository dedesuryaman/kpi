<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Helpers\ApiResponse;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Pekerjaan;
use App\Models\SubPekerjaan;
use App\Models\SubKegiatan;

/**
 * @OA\Tag(name="Pekerjaan", description="API endpoints for pekerjaan")
 */


class PekerjaanController extends Controller
{

	/**
	 * @OA\Get(
	 *     path="/api/mobile/pekerjaans",
	 *     tags={"Pekerjaan"},
	 *     summary="Listing Data Pekerjaan",
	 *     description="List pekerjaan dengan search",
	 *     operationId="mobile/pekerjaans",
	 *     security={{"sanctum": {}}},
	 *     @OA\Parameter(
	 *         name="q",
	 *         in="query",
	 *         description="Keyword pencarian pekerjaan",
	 *         required=false,
	 *         @OA\Schema(type="string", example="jalan")
	 *     ),
	 *     @OA\Parameter(
	 *         name="page",
	 *         in="query",
	 *         description="Nomor halaman",
	 *         required=false,
	 *         @OA\Schema(type="integer", example=1)
	 *     ),
	 *     @OA\Response(
	 *         response=200,
	 *         description="Return list pekerjaan"
	 *     )
	 * )
	 */
	public function index(Request $request)
	{

		try {
			$user = $request->user();
			$q = $request->query('q');

			$pekerjaans = Pekerjaan::with([
				'dokumens',
				'subKegiatan',
				'subPekerjaan',
				'posPengawasan',
				'konPengawas',
				'konPelaksana'
			])
				->where('opd_pengawas_id', $user->id)
				->when($q, function ($query) use ($q) {
					$query->where(function ($sub) use ($q) {
						$sub->where('nm_pekerjaan', 'like', "%{$q}%")
							->orWhereHas('subKegiatan', function ($sk) use ($q) {
								$sk->where('nm_sub_kegiatan', 'like', "%{$q}%");
							})
							->orWhereHas('konPelaksana', function ($kp) use ($q) {
								$kp->where('name', 'like', "%{$q}%");
							})
							->orWhereHas('konPengawas', function ($kw) use ($q) {
								$kw->where('name', 'like', "%{$q}%");
							});
					});
				})
				->whereIn('status_progress', ['on_progress'])
				->whereHas('subPekerjaan', function ($sp) {
					$sp->whereNotIn('status_progress', ['menunggu_mulai']);
				})
				->orderBy('created_at', 'desc')
				->simplePaginate(10)
				->withQueryString();

			return ApiResponse::success(
				[
					'pekerjaans' => $pekerjaans,
					'search' => $q
				],
				'List data pekerjaan'
			);
		} catch (\Throwable $e) {
			return ApiResponse::error(
				'Gagal mengambil data pekerjaan',
				500,
				$e->getMessage()
			);
		}
	}

	// public function index(Request $request)
	// {
	// 	try {
	// 		$user = $request->user()->load('roles');
	// 		$userId = $user->id;
	// 		$userId = Auth::user()->id;
	// 		$pekerjaans = Pekerjaan::with('dokumens', 'subKegiatan', 'subPekerjaan', 'posPengawasan', 'konPengawas', 'konPelaksana')
	// 			->where('opd_pengawas_id', $userId)
	// 			->simplePaginate(10)->withQueryString();
	// 		//
	// 		return ApiResponse::success(
	// 			[
	// 				'pekerjaans' => $pekerjaans,

	// 			],
	// 			'List data pekerjaan'
	// 		);
	// 	} catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {

	// 		return ApiResponse::error('List pekerjaan tidak ditemukan', 404);
	// 	}
	// }

	/**
	 * @OA\Get(
	 *     path="/api/mobile/pekerjaan/{id}",
	 *     tags={"Pekerjaan"},
	 *     summary="Data Pekerjaan",
	 *     description="-",
	 *     operationId="bobile/pekerjaan",
	 *     security={ {"sanctum": {} }},
	 *    @OA\Parameter(
	 *         name="id",
	 *         in="path",
	 *         required=true,
	 *         @OA\Schema(type="integer")
	 *     ),
	 *     @OA\Response(
	 *         response="default",
	 *         description="return model pekrjaan"
	 *     )
	 * )
	 */

	public function pekerjaan(Request $request, $id)
	{
		try {
			$user = $request->user()->load('roles');
			$userId = $user->id;

			$pekerjaan = Pekerjaan::with(['dokumens', 'subPekerjaan' => function ($q) {
				//$q->whereIn('status_progress', ['proses_pengerjaan']);
			}, 'subKegiatan', 'opdPengawas', 'konPengawas', 'konPelaksana'])
				->with('posPengawasan.histories')
				->where('opd_pengawas_id', $userId)
				->whereHas('subPekerjaan', function ($sp) {
					$sp->whereNotIn('status_progress', ['menunggu_mulai']);
				})
				->findOrFail($id);

			return ApiResponse::success(
				[
					'pekerjaan' => $pekerjaan,

				],
				'Detail data pekerjaan'
			);
		} catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {

			return ApiResponse::error('Data pekerjaan tidak ditemukan', 404);
		}
	}
}

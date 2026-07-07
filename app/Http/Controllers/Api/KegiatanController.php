<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Helpers\ApiResponse;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Pekerjaan;
use App\Models\SubKegiatan;

/**
 * @OA\Tag(name="Kegiatan", description="API endpoints for kegiatans")
 */

class KegiatanController extends Controller
{

	/**
	 * @OA\Get(
	 *     path="/api/mobile/kegiatans",
	 *     tags={"Kegiatan"},
	 *     summary="Listing Data Kegiatan",
	 *     description="-",
	 *     operationId="bobile/kegiatans",
	 *     security={ {"sanctum": {} }},
	 *     @OA\Response(
	 *         response="default",
	 *         description="return model kegiatans"
	 *     )
	 * )
	 */

	public function index(Request $request)
	{
		try {
			$user = $request->user()->load('roles');
			$userId = Auth::user()->id;
			$kegiatans = SubKegiatan::with([
				'subPekerjaans' => function ($q) use ($userId) {
					$q->where('opd_pengawas_id', $userId);
				}
			])
				->whereHas('subPekerjaans', function ($q) use ($userId) {
					$q->where('opd_pengawas_id', $userId);
				})
				->simplePaginate(10)->withQueryString();
			return ApiResponse::success(
				[
					'user' => $user,
					'kegiatans' => $kegiatans,

				],
				'List data kegiatan'
			);
		} catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {

			return ApiResponse::error('Data kegiatan tidak ditemukan', 404);
		}
	}
	/**
	 * @OA\Get(
	 *     path="/api/mobile/kegiatan/{id}",
	 *     tags={"Kegiatan"},
	 *     summary="Data Kegiatan",
	 *     description="-",
	 *     operationId="bobile/kegiatan",
	 *     security={ {"sanctum": {} }},
	 *    @OA\Parameter(
	 *         name="id",
	 *         in="path",
	 *         required=true,
	 *         @OA\Schema(type="integer")
	 *     ),
	 *     @OA\Response(
	 *         response="default",
	 *         description="return model kegiatan"
	 *     )
	 * )
	 */

	public function kegiatan(Request $request, $id)
	{
		try {

			$user = $request->user()->load('roles');
			$userId = Auth::user()->id;


			$kegiatan = SubKegiatan::with([
				'subPekerjaans' => function ($q) use ($userId) {
					$q->where('opd_pengawas_id', $userId);
				}
			])
				->where('id', $id)
				->whereHas('subPekerjaans', function ($q) use ($userId) {
					$q->where('opd_pengawas_id', $userId);
				})->with('subPekerjaans.konPengawas')
				->with('subPekerjaans.konPelaksana')
				->with('subPekerjaans.posPengawasan')
				->with('subPekerjaans.posPengawasan.histories')
				->firstOrFail();
			return ApiResponse::success(
				[
					'user' => $user,
					'kegiatan' => $kegiatan,

				],
				'Detail data kegiatan'
			);
		} catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {

			return ApiResponse::error('Data kegiatan tidak ditemukan', 404);
		}
	}
}

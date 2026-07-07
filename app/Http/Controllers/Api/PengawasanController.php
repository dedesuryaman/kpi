<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Helpers\ApiResponse;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Pekerjaan;
use App\Models\SubKegiatan;
use App\Models\PosPengawasan;
use App\Models\PengawasanHistories;

/**
 * @OA\Tag(name="Pengawasan", description="API endpoints for pengawasan")
 */

class PengawasanController extends Controller
{
	/**
	 * @OA\Get(
	 *     path="/api/mobile/pengawasans/{pekerjaan_id}",
	 *     tags={"Pengawasan"},
	 *     summary="Listing Data Pengawasan",
	 *     description="-",
	 *     operationId="bobile/pengawasans",
	 *     security={ {"sanctum": {} }},
	 *		@OA\Parameter(
	 *         name="pekerjaan_id",
	 *         in="path",
	 *         required=true,
	 *         @OA\Schema(type="integer")
	 *     ),
	 *     @OA\Response(
	 *         response="default",
	 *         description="return model pengawasan"
	 *     )
	 * )
	 */
	public function index(Request $request, $pekerjaan_id)
	{ //by pekrjaan
		try {
			//$id  = $request->pekerjaan_id;

			$user = $request->user()->load('roles');
			$userId = $user->id;

			$userId = Auth::user()->id;
			$pengawasan = PosPengawasan::with(['pekerjaan.subKegiatan', 'histories'])
				->whereRelation('pekerjaan', 'opd_pengawas_id', $userId)
				->whereRelation('pekerjaan', 'id', $pekerjaan_id)
				->simplePaginate(10)->withQueryString();


			return ApiResponse::success(
				[
					'pengawasan' => $pengawasan,

				],
				'List data pengawasan'
			);
		} catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {

			return ApiResponse::error('List data pengawasan tidak ditemukan', 404);
		}
	}

	/**
	 * @OA\Get(
	 *     path="/api/mobile/pengawasan/{pengawasan_id}",
	 *     tags={"Pengawasan"},
	 *     summary="Data Pengawasan",
	 *     description="-",
	 *     operationId="bobile/pengawasan",
	 *     security={ {"sanctum": {} }},
	 *		@OA\Parameter(
	 *         name="pengawasan_id",
	 *         in="path",
	 *         required=true,
	 *         @OA\Schema(type="integer")
	 *     ),
	 *     @OA\Response(
	 *         response="default",
	 *         description="return model pengawasan"
	 *     )
	 * )
	 */

	public function pengawasan(Request $request, $pengawasan_id)
	{ //by id pengawasan
		try {

			$user = $request->user()->load('roles');
			$userId = $user->id;

			//$userId = Auth::user()->id;

			$pengawasan = PosPengawasan::with(['pekerjaan.subKegiatan', 'histories'  => function ($q) {
				$q->orderBy('created_at', 'desc');
			}])
				->whereRelation('pekerjaan', 'opd_pengawas_id', $userId)
				->where('id', $pengawasan_id)
				->first();


			return ApiResponse::success(
				[
					'pengawasan' => $pengawasan,

				],
				'List data pengawasan'
			);
		} catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {

			return ApiResponse::error('List data pengawasan tidak ditemukan', 404);
		}
	}
}

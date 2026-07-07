<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Helpers\ApiResponse;
use Illuminate\Support\Facades\Auth;

use App\Models\User;
use App\Models\SubPekerjaan;

/**
 * @OA\Tag(name="SubPekerjaan", description="API endpoints for sub pekerjaan")
 */

class SubPekerjaanController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/mobile/sub-pekerjaans/{pekerjaan_id}",
     *     tags={"SubPekerjaan"},
     *     summary="Listing Data Sub Pekerjaan",
     *     description="-",
     *     operationId="bobile/sub-pekerjaans",
     *     security={ {"sanctum": {} }},
     *		@OA\Parameter(
     *         name="pekerjaan_id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response="default",
     *         description="return model sub pekerjaan"
     *     )
     * )
     */
    public function index(Request $request, $pekerjaan_id)
    {

        try {
            $user = $request->user()->load('roles');
            $userId = $user->id;
            $userId = Auth::user()->id;
            $sub_pekerjaans = SubPekerjaan::with(['pekerjaan.subKegiatan', 'posPengawasans'])
                ->where('pekerjaan_id', $pekerjaan_id)
                ->whereHas('pekerjaan', function ($q) use ($userId) {
                    $q->where('opd_pengawas_id', $userId);
                })
                ->whereIn('status_progress', ['proses_pengerjaan'])
                ->simplePaginate(10)
                ->withQueryString();

            return ApiResponse::success(
                [
                    'sub_pekerjaans' => $sub_pekerjaans,
                ],
                'List data pekerjaan'
            );
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {

            return ApiResponse::error('List pekerjaan tidak ditemukan', 404);
        }
    }

    /**
     * @OA\Get(
     *     path="/api/mobile/sub-pekerjaan/{sub_pekerjaan_id}",
     *     tags={"SubPekerjaan"},
     *     summary="Data Sub Pekerjaan",
     *     description="-",
     *     operationId="bobile/sub-pekerjaan",
     *     security={ {"sanctum": {} }},
     *		@OA\Parameter(
     *         name="sub_pekerjaan_id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response="default",
     *         description="return model sub pekerjaan"
     *     )
     * )
     */
    public function sub_pekerjaan(Request $request, $sub_pekerjaan_id)
    {

        try {
            $user = $request->user()->load('roles');

            $userId = Auth::user()->id;
            $sub_pekerjaan = SubPekerjaan::with(['pekerjaan.subKegiatan', 'posPengawasans.histories'])
                ->where('id', $sub_pekerjaan_id)
                ->whereHas('pekerjaan', function ($q) use ($userId) {
                    $q->where('opd_pengawas_id', $userId);
                })->first();

            return ApiResponse::success(
                [
                    'sub_pekerjaan' => $sub_pekerjaan,

                ],
                'List data sub pekerjaan'
            );
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {

            return ApiResponse::error('List pekerjaan tidak ditemukan', 404);
        }
    }
}

<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Helpers\ApiResponse;
use Illuminate\Support\Facades\Auth;

use App\Models\User;
use App\Models\Dokumen;
use App\Models\Pekerjaan;

/**
 * @OA\Tag(name="Dokumen", description="API endpoints for dokumen")
 */


class DokumenController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/mobile/dokumens/{pekerjaan_id}",
     *     tags={"Dokumen"},
     *     summary="Data Dokumen Pekerjaan",
     *     description="-",
     *     operationId="bobile/dokumens",
     *     security={ {"sanctum": {} }},
     *    @OA\Parameter(
     *         name="pekerjaan_id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response="default",
     *         description="return model dokumen"
     *     )
     * )
     */

    public function index(Request $request, $pekerjaan_id)
    {

        $dokumens = Dokumen::with([

            'kategories',
            'pekerjaan:id,nm_pekerjaan,kegiatan_id', // harus ada foreign key sub_kegiatan_id
            'pekerjaan.subKegiatan:id,tahun,kd_urusan,kd_bidang,kd_unit,kd_sub,nm_unit,nm_sub_unit,kd_urusan90,kd_bidang90,kd_program90,kd_kegiatan90,kd_sub_kegiatan,nm_program,nm_kegiatan,nm_sub_kegiatan,no_id,tolak_ukur,target_angka,target_uraian,pagu_anggaran,realisasi'
        ])->where('pekerjaan_id', $pekerjaan_id)->get();

        return ApiResponse::success([
            'dokumen' => $dokumens
        ], 'Listing data dokumen proyek');
    }

    /**
     * @OA\Get(
     *     path="/api/mobile/dokumen/{dokumen_id}",
     *     tags={"Dokumen"},
     *     summary="Data Dokumen Pekerjaan",
     *     description="-",
     *     operationId="bobile/dokumen",
     *     security={ {"sanctum": {} }},
     *    @OA\Parameter(
     *         name="dokumen_id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response="default",
     *         description="return model dokumen"
     *     )
     * )
     */

    public function dokumen(Request $request, $dokumen_id)
    {

        $dokumen = Dokumen::select('id', 'title', 'description', 'pekerjaan_id')
            ->with([
                'pekerjaan:id,nm_pekerjaan,kegiatan_id', // harus ada foreign key sub_kegiatan_id
                'pekerjaan.subKegiatan:id,tahun,kd_urusan,kd_bidang,kd_unit,kd_sub,nm_unit,nm_sub_unit,kd_urusan90,kd_bidang90,kd_program90,kd_kegiatan90,kd_sub_kegiatan,nm_program,nm_kegiatan,nm_sub_kegiatan,no_id,tolak_ukur,target_angka,target_uraian,pagu_anggaran,realisasi'
            ])
            ->where('id', $dokumen_id)->get();

        return ApiResponse::success([
            'dokumen' => $dokumen
        ], 'Dokumen proyek');
    }
}

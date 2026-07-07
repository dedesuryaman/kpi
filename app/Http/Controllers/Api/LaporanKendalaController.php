<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\LaporanKendala;
use App\Helpers\ApiResponse;

/**
 * @OA\Tag(name="LaporanKendala", description="API endpoints for pos laporan khusus atau kendala")
 */

class LaporanKendalaController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/mobile/laporan/kendalas",
     *     tags={"LaporanKendala"},
     *     summary="History Laporan Kendala",
     *     description="List history laproan kendala dengan search",
     *     operationId="mobile/kendalas",
     *     security={{"sanctum": {}}},
     *     @OA\Parameter(
     *         name="q",
     *         in="query",
     *         description="Keyword pencarian (judul atau nama proyek)",
     *         required=false,
     *         @OA\Schema(type="string", example="cuaca badai")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Return list hstory kendala"
     *     )
     * )
     */
    public function index(Request $request)
    {

        try {
            $user = $request->user();
            $q = $request->query('q');

            $kendalas = LaporanKendala::with([
                'pekerjaan'
            ])
                ->where('user_id', $user->id)
                ->when($q, function ($query) use ($q) {
                    $query->where(function ($sub) use ($q) {
                        $sub->where('judul', 'like', "%{$q}%")
                            //->orWhere('kode_pekerjaan', 'like', "%{$q}%")
                            //->orWhere('tahun', 'like', "%{$q}%")
                            ->orWhereHas('pekerjaan', function ($sk) use ($q) {
                                $sk->where('nm_pekerjaan', 'like', "%{$q}%");
                            });
                    });
                })
                ->whereHas('pekerjaan', function ($query) {
                    $query->where('status', 'Active')
                        ->where('status_progress', 'on_progress');
                })
                ->orderBy('created_at', 'desc')
                ->simplePaginate(10)
                ->withQueryString();

            return ApiResponse::success(
                [
                    'kendalas' => $kendalas,
                    'search' => $q
                ],
                'List data history kendala'
            );
        } catch (\Throwable $e) {
            return ApiResponse::error(
                'Gagal mengambil data histori kendala',
                500,
                $e->getMessage()
            );
        }
    }

    /**
     * @OA\Post(
     *     path="/api/mobile/laporan/kendala",
     *     tags={"LaporanKendala"},
     *     summary="Laporan khusus kendala atau insidentil",
     *     security={{"sanctum":{}}},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\MediaType(
     *             mediaType="multipart/form-data",
     *             @OA\Schema(
     *                 required={"pekerjaan_id", "foto_url", "tipe_masalah", "judul" , "deskripsi"},
     *                 type="object",
     *                 @OA\Property(property="pekerjaan_id", type="integer", example=7),
     *                 @OA\Property(property="tipe_masalah", type="string", enum={"teknis","administrasi","anggaran","koordinasi","lingkungan","regulasi","alam","lainnya"}, example="teknis"),
     *
     *                 @OA\Property(property="judul", type="string", example="Kualitas material tidak sesuai spesifikasi"),
     *                 @OA\Property(property="deskripsi", type="string", example="Bahan yang tidak sesuai dengan perencanaan"),

     *
     *                 @OA\Property(
     *                     property="foto_url",
     *                     type="string",
     *                     format="binary",
     *                     description="Upload foto (jpg, jpeg, png, max 5MB)"
     *                 )
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response="default",
     *         description="return model laporan_kendala"
     *     )
     * )
     */


    public function laporan(Request $request)
    {
        try {

            //$user = $request->user();

            $user = $request->user()->load('roles');

            // VALIDASI
            $validator = Validator::make($request->all(), [

                'pekerjaan_id'        => 'required|integer|exists:pekerjaans,id',
                'judul'             => 'required|string',
                'deskripsi'         => 'required|string',
                'foto_url'               => 'required|image|mimes:jpg,jpeg,png|max:5120', // 5MB
                'tipe_masalah'              => 'required|string|in:teknis,administrasi,anggaran,koordinasi,lingkungan,regulasi,alam,lainnya',

            ]);

            // Jika validasi gagal
            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Validasi gagal',
                    'errors'  => $validator->errors(),
                ], 422);
            }

            // Jika lolos validasi
            $validated = $validator->validated();

            // ============================================
            // UPLOAD FOTO UTAMA
            // ============================================
            $fotoUrl = null;

            if ($request->hasFile('foto_url')) {
                $foto = $request->file('foto_url');

                $fotoName = 'foto_' . time() . '_' . uniqid() . '.' . $foto->getClientOriginalExtension();


                $path = $request->file('foto_url')->storeAs('kendala', $fotoName, 'public');

                $fotoUrl = url('storage/kendala/' . $fotoName);
            }

            // INSERT DATA KE TABEL PENGAWASAN HISTORIES
            $kendala = LaporanKendala::create([

                'pekerjaan_id'      => $validated['pekerjaan_id'],
                'judul'             => $validated['judul'] ?? null,
                'deskripsi'         => $validated['deskripsi'] ?? null,
                'foto_url'          => $fotoUrl,
                'file_path'         => $path,
                'file_name'         => $foto->getClientOriginalName(),
                'file_size'         => $foto->getSize(),
                'mime_type'         => $foto->getMimeType(),
                'tipe_masalah'      => $validated['tipe_masalah'],
                'waktu_pelaporan'   => \Carbon\Carbon::now(), // now()->format('Y-m-d H:i:s'),
                'ip_address'        => $request->ip(),
                'user_id'           => $user->id,
            ]);

            $kendala->load(['pekerjaan']);

            return ApiResponse::success(
                [
                    'kendala' => $kendala
                ],
                'Laporan kendala berhasil disimpan'
            );
        } catch (\Exception $e) {

            return ApiResponse::error(
                'Terjadi kesalahan server: ' . $e->getMessage(),
                500
            );
        }
    }
}

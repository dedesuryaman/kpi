<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

use App\Models\Pekerjaan;
use App\Models\SubKegiatan;
use App\Models\PengawasanHistories;

use App\Helpers\ApiResponse;
use Carbon\Carbon;

use Illuminate\Support\Facades\DB;

use App\Models\PekerjaanProgress;
use App\Models\SubPekerjaan;
use App\Models\SubPekerjaanProgress;
use App\Models\SubKegiatanProgress;

use Illuminate\Support\Facades\Log;

/**
 * @OA\Tag(name="PosPengawasan", description="API endpoints for pos pengawasan")
 */

class PosPengawasanController extends Controller
{

	public function index() {}

	/**
	 * @OA\Post(
	 *     path="/api/mobile/laporan/pengawasan",
	 *     tags={"PosPengawasan"},
	 *     summary="Laporan pengawasan to pos pengawasan",
	 *     security={{"sanctum":{}}},
	 *     @OA\RequestBody(
	 *         required=true,
	 *         @OA\MediaType(
	 *             mediaType="multipart/form-data",
	 *             @OA\Schema(
	 *                 required={"pos_pengawasan_id", "kegiatan_id", "pekerjaan_id", "sub_pekerjaan_id" , "foto_url", "latitude", "longitude", "status" ,"progres_persentase"},
	 *                 type="object",
	 *
	 *                 @OA\Property(property="pos_pengawasan_id", type="integer", example=1),
	 *                 @OA\Property(property="kegiatan_id", type="integer", example=5),
	 *                 @OA\Property(property="pekerjaan_id", type="integer", example=7),
	 *				   @OA\Property(property="sub_pekerjaan_id", type="integer", example=2),
	 *                 @OA\Property(property="alamat", type="string", example="Jl. Raya Bandung"),
	 *                 @OA\Property(property="latitude", type="number", example="-6.9123"),
	 *                 @OA\Property(property="longitude", type="number", example="107.6123"),
	 *
	 *                 @OA\Property(property="progres_persentase", type="number", example=40),
	 *                 @OA\Property(property="kondisi_lapangan", type="string", example="Banyak air"),
	 *                 @OA\Property(property="cuaca", type="string", example="Cerah"),
	 *
	 *                 @OA\Property(
	 *                     property="foto_url",
	 *                     type="string",
	 *                     format="binary",
	 *                     description="Upload foto (jpg, jpeg, png, max 5MB)"
	 *                 ),
	 *
	 *                 @OA\Property(property="catatan", type="string", example="Perlu pengawasan tambahan"),
	 *                 @OA\Property(property="status", type="string", enum={"normal","deviasi","kritikal","progress"}, example="normal"),
	 *
	 *                 @OA\Property(property="device_id", type="string", example="ANDROID-12345"),
	 *                 @OA\Property(property="app_version", type="string", example="1.0.5"),
	 *             )
	 *         )
	 *     ),
	 *     @OA\Response(
	 *         response="default",
	 *         description="return model pos pengawasan"
	 *     )
	 * )
	 */


	public function laporan(Request $request)
	{
		try {
			// VALIDASI
			$validator = Validator::make(
				$request->all(),
				[
					'pos_pengawasan_id'   => 'required|integer|exists:pos_pengawasan,id',
					'kegiatan_id'         => 'required|integer|exists:sub_kegiatans,id',
					'pekerjaan_id'        => 'required|integer|exists:pekerjaans,id',
					'sub_pekerjaan_id'    => 'required|integer|exists:sub_pekerjaans,id',

					'alamat'              => 'nullable|string|max:255',
					'latitude'            => 'required|numeric',
					'longitude'           => 'required|numeric',

					'progres_persentase'  => 'required|numeric|min:0|max:100',

					'kondisi_lapangan'    => 'nullable|string',
					'cuaca'               => 'nullable|string|max:50',

					'foto_url' 			  => 'nullable|image|mimes:jpg,jpeg,png|max:5120', // 5MB
					'catatan'             => 'nullable|string',

					'status'              => 'required|string|in:normal,deviasi,kritikal,progress',

					'device_id'           => 'nullable|string|max:100',
					'app_version'         => 'nullable|string|max:50',

				],

				[
					'pos_pengawasan_id.required' => 'Pos pengawasan wajib diisi.',
					'pos_pengawasan_id.integer'  => 'Pos pengawasan tidak valid.',
					'pos_pengawasan_id.exists'   => 'Pos pengawasan tidak ditemukan.',

					'kegiatan_id.required'       => 'Kegiatan wajib diisi.',
					'kegiatan_id.integer'        => 'Kegiatan tidak valid.',
					'kegiatan_id.exists'         => 'Kegiatan tidak ditemukan.',

					'pekerjaan_id.required'      => 'Pekerjaan wajib diisi.',
					'pekerjaan_id.integer'       => 'Pekerjaan tidak valid.',
					'pekerjaan_id.exists'        => 'Pekerjaan tidak ditemukan.',

					'sub_pekerjaan_id.required'  => 'Sub pekerjaan wajib diisi.',
					'sub_pekerjaan_id.integer'   => 'Sub pekerjaan tidak valid.',
					'sub_pekerjaan_id.exists'    => 'Sub pekerjaan tidak ditemukan.',

					'alamat.string'              => 'Alamat harus berupa teks.',
					'alamat.max'                 => 'Alamat maksimal 255 karakter.',

					'latitude.required'          => 'Latitude wajib diisi.',
					'latitude.numeric'           => 'Latitude harus berupa angka.',
					'latitude.between'           => 'Latitude harus berada antara -90 sampai 90.',

					'longitude.required'         => 'Longitude wajib diisi.',
					'longitude.numeric'          => 'Longitude harus berupa angka.',
					'longitude.between'          => 'Longitude harus berada antara -180 sampai 180.',

					'progres_persentase.required'  => 'Progress wajib diisi.',
					'progres_persentase.numeric' => 'Progress harus berupa angka.',
					'progres_persentase.min'     => 'Progress minimal 0%.',
					'progres_persentase.max'     => 'Progress maksimal 100%.',

					'kondisi_lapangan.string'    => 'Kondisi lapangan harus berupa teks.',

					'cuaca.string'               => 'Cuaca harus berupa teks.',
					'cuaca.max'                  => 'Cuaca maksimal 50 karakter.',

					'foto_url.image'             => 'File foto harus berupa gambar.',
					'foto_url.mimes'             => 'Format foto harus JPG, JPEG, atau PNG.',
					'foto_url.max'               => 'Ukuran foto maksimal 5 MB.',

					'catatan.string'             => 'Catatan harus berupa teks.',

					'status.required'            => 'Status wajib diisi.',
					'status.in'                  => 'Status harus salah satu dari: normal, deviasi, kritikal, progress.',

					'device_id.string'           => 'Device ID harus berupa teks.',
					'device_id.max'              => 'Device ID maksimal 100 karakter.',

					'app_version.string'         => 'Versi aplikasi harus berupa teks.',
					'app_version.max'            => 'Versi aplikasi maksimal 50 karakter.',
				]
			);



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
			$path = null;



			if ($request->hasFile('foto_url')) {
				$foto = $request->file('foto_url');

				$fotoName = 'foto_' . time() . '_' . uniqid() . '.' . $foto->getClientOriginalExtension();
				$path = $request->file('foto_url')->storeAs('pengawasan', $fotoName, 'public');

				$fotoUrl = '/storage/pengawasan/' . $fotoName;
			}

			// INSERT DATA KE TABEL PENGAWASAN HISTORIES
			$history = PengawasanHistories::create([
				'pos_pengawasan_id'  => $validated['pos_pengawasan_id'],
				'kegiatan_id'        => $validated['kegiatan_id'],
				'pekerjaan_id'       => $validated['pekerjaan_id'],
				'sub_pekerjaan_id' 	 => $validated['sub_pekerjaan_id'],
				'opd_pengawas_id'    => Auth::id(),
				'alamat'             => $validated['alamat'] ?? null,
				'latitude'           => $validated['latitude'],
				'longitude'          => $validated['longitude'],
				'progres_persentase' => $validated['progres_persentase'] ?? null,
				'kondisi_lapangan'   => $validated['kondisi_lapangan'] ?? null,
				'cuaca'              => $validated['cuaca'] ?? null,
				'foto_path'           => $path,
				'foto_url'           => $fotoUrl,
				'catatan'            => $validated['catatan'] ?? null,
				'status'             => $validated['status'],
				'waktu_pengawasan'   =>  now()->format('Y-m-d H:i:s'),
				'device_id'          => $validated['device_id'] ?? null,
				'app_version'        => $validated['app_version'] ?? null,
				'ip_address'         => $request->ip(),
				'user_id'    		=> Auth::id(),

			]);

			$history->load(['posPengawasan', 'posPengawasan.pekerjaan']);

			$persentase_progress = $request->progres_persentase ?? 0;
			$pekerjaan_id  = $history->pekerjaan_id;
			$sub_pekerjaan_id  = $history->sub_pekerjaan_id;

			//pastikan data 

			$tmp = SubPekerjaan::where('id', $sub_pekerjaan_id)->first();

			$start = Carbon::parse($tmp->tanggal_awal);
			$end   = Carbon::parse($tmp->tanggal_akhir);
			$lapor = Carbon::parse(now())->format('Y-m-d');
			// total bulan proyek
			$totalBulan = $start->diffInMonths($end) + 1;


			// bulan laporan ke-
			$bulanKe = $start->diffInMonths($lapor) + 1;
			$bulanKe = max(1, min($bulanKe, $totalBulan));

			// progress waktu (0–1)
			$x = $bulanKe / $totalBulan;
			// TARGET otomatis (kurva-S)
			$persentase_target = round(kurva_s($x), 2);
			//jika mau linier 
			//$persentase_target = round(($bulanKe / $totalBulan) * 100, 2);

			$realisasi = $request->persentase_progress;
			$deviasi   = round($realisasi - $persentase_target, 2);

			if ($deviasi >= 5) {
				$status = 'Ahead';
			} elseif ($deviasi <= -5) {
				$status = 'Delay';
			} else {
				$status = 'On Track';
			}

			SubPekerjaanProgress::updateOrCreate(
				[
					'sub_pekerjaan_id' => $sub_pekerjaan_id,
					'pekerjaan_id' => $tmp->pekerjaan_id,
					'tanggal' => date('Y-m-d')
				],
				[
					'persentase_progress' => $persentase_progress,
					'persentase_target' => $persentase_target,
					'deviasi' => $deviasi,
					'status_deviasi' => $status,
				]
			);



			SubPekerjaan::whereId($sub_pekerjaan_id)
				->update(['persentase_progress' => $persentase_progress]);

			$avg1 = SubPekerjaan::where('pekerjaan_id', $tmp->pekerjaan_id)
				->whereNotNull('persentase_progress')
				->avg('persentase_progress');

			$pekerjaan = Pekerjaan::where('id', $pekerjaan_id)->first();

			$start = Carbon::parse($pekerjaan->tanggal_awal);
			$end   = Carbon::parse($pekerjaan->tanggal_akhir);
			$lapor = Carbon::parse(now())->format('Y-m-d');
			// total bulan proyek
			$totalBulan = $start->diffInMonths($end) + 1;


			// bulan laporan ke-
			$bulanKe = $start->diffInMonths($lapor) + 1;
			$bulanKe = max(1, min($bulanKe, $totalBulan));

			// progress waktu (0–1)
			$x = $bulanKe / $totalBulan;
			// TARGET otomatis (kurva-S)
			$persentase_target = round(kurva_s($x), 2);
			//jika mau linier 
			//$persentase_target = round(($bulanKe / $totalBulan) * 100, 2);
			$realisasi = $avg1;
			$deviasi   = round($realisasi - $persentase_target, 2);

			if ($deviasi >= 5) {
				$status = 'Ahead';
			} elseif ($deviasi <= -5) {
				$status = 'Delay';
			} else {
				$status = 'On Track';
			}


			PekerjaanProgress::updateOrCreate(
				[
					'pekerjaan_id' => $tmp->pekerjaan_id,
					'bulan' => Carbon::parse(now())->format('Y-m')
				],
				[
					'tanggal' => now()->toDateString(),
					'persentase_progress' => $avg1,
					'persentase_target' => $persentase_target,
					'deviasi' => $deviasi,
					'status_deviasi' => $status,
				]
			);

			$persenPP = SubPekerjaan::where('pekerjaan_id', $tmp->pekerjaan_id)
				->whereNotNull('persentase_progress')
				->avg('persentase_progress');
			Pekerjaan::where('id', $pekerjaan_id)
				->update([
					'progress' => $persenPP,
				]);



			//naik level

			$pekerjaan = Pekerjaan::find($tmp->pekerjaan_id);


			if ($pekerjaan) {

				$subKegiatan = SubKegiatan::find($pekerjaan->kegiatan_id);



				if ($subKegiatan) {

					$kegiatan_id = $pekerjaan->kegiatan_id;

					$persenP =  Pekerjaan::where('kegiatan_id', $kegiatan_id)
						->whereNotNull('progress')
						->avg('progress');




					SubKegiatanProgress::updateOrCreate(
						[
							'sub_kegiatan_id' => $kegiatan_id,
							'bulan' => Carbon::parse(now())->format('Y-m')

						],
						[
							'tanggal' =>  now()->toDateString(),
							'progress' => $persenP
						]
					);


					// return ApiResponse::success(
					// 	[
					// 		'history' => $history
					// 	],
					// 	'Laporan pengawasan berhasil disimpan'
					// );

					$tahun = $subKegiatan->tahun;

					$progressData = DB::table('sub_pekerjaan_progress as spp')
						->join('sub_pekerjaans as sp', 'spp.sub_pekerjaan_id', '=', 'sp.id')
						->selectRaw('
							sp.pekerjaan_id,
							sp.id as sub_pekerjaan_id,
							MONTH(spp.tanggal) as bulan,
							YEAR(spp.tanggal) as tahun,

							/* TARGET berdasarkan waktu */
							MAX(
								LEAST(
									(
										DATEDIFF(spp.tanggal, sp.tanggal_mulai) + 1
									) / NULLIF(
										DATEDIFF(sp.tanggal_selesai, sp.tanggal_mulai) + 1, 0
									) * 100,
								100)
							) as persentase_target,

							/* PROGRESS AKTUAL */
							MAX(spp.persentase_progress) as persentase_progress
    					')
						->where('sp.pekerjaan_id', $tmp->pekerjaan_id)
						->whereYear('spp.tanggal', $tahun)

						->groupBy(
							'sp.pekerjaan_id',
							'sp.id',
							DB::raw('YEAR(spp.tanggal)'),
							DB::raw('MONTH(spp.tanggal)')
						)
						->orderBy('tahun')
						->orderBy('bulan')
						->get();

					foreach ($progressData as $data) {
						DB::table('pekerjaan_targets')->updateOrInsert([
							'sub_kegiatan_id' => $kegiatan_id,
							'pekerjaan_id' => $data->pekerjaan_id,
							'sub_pekerjaan_id' => $data->sub_pekerjaan_id,
							'bulan' => $data->bulan,
							'tahun' => $data->tahun
						], [
							'persentase_target' => $data->persentase_target
						]);
					}
				}
			}
			return ApiResponse::success(
				[
					'history' => $history
				],
				'Laporan pengawasan berhasil disimpan'
			);
		} catch (\Exception $e) {
			// Log the error details
			Log::error('Terjadi kesalahan server', [
				'message' => $e->getMessage(),
				'file' => $e->getFile(),
				'line' => $e->getLine(),
				'trace' => $e->getTraceAsString()
			]);

			return ApiResponse::error(
				'Terjadi kesalahan server: ' . $e->getMessage(),
				500
			);
		}
	}
}

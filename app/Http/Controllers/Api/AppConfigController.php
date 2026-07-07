<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\AppSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

/**
 * @OA\Version(
 *     title="Mobile App Config API",
 *     version="1.0.0",
 *     description="API untuk versioning, maintenance, dan informasi aplikasi mobile"
 * )
 */



class AppConfigController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/mobile/app/config",
     *     tags={"App"},
     *     summary="Get konfigurasi aplikasi",
     *     description="Mengambil informasi versi aplikasi, maintenance, dan support",
     *
     *     @OA\Parameter(
     *         name="platform",
     *         in="query",
     *         required=false,
     *         description="Platform aplikasi",
     *         @OA\Schema(
     *             type="string",
     *             enum={"android","ios","web"},
     *             default="android"
     *         )
     *     ),
     *
     *     @OA\Response(
     *         response=200,
     *         description="Berhasil",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="status", type="boolean", example=true),
     *             @OA\Property(
     *                 property="data",
     *                 type="object",
     *                 @OA\Property(property="app_name", type="string", example="MyApp Mobile"),
     *                 @OA\Property(property="platform", type="string", example="android"),
     *                 @OA\Property(
     *                     property="version",
     *                     type="object",
     *                     @OA\Property(property="current", type="string", example="1.4.2"),
     *                     @OA\Property(property="minimum", type="string", example="1.3.0"),
     *                     @OA\Property(property="build", type="string", example="42"),
     *                     @OA\Property(property="force_update", type="boolean", example=true),
     *                     @OA\Property(property="update_url", type="string", example="https://play.google.com/store/apps/details")
     *                 ),
     *                 @OA\Property(
     *                     property="maintenance",
     *                     type="object",
     *                     @OA\Property(property="status", type="boolean", example=false),
     *                     @OA\Property(property="message", type="string", nullable=true)
     *                 ),
     *                 @OA\Property(property="release_notes", type="string", example="Bug fixing"),
     *                 @OA\Property(
     *                     property="support",
     *                     type="object",
     *                     @OA\Property(property="email", type="string", example="support@myapp.com"),
     *                     @OA\Property(property="whatsapp", type="string", example="628123456789")
     *                 )
     *             )
     *         )
     *     ),
     *
     *     @OA\Response(
     *         response=404,
     *         description="Config tidak ditemukan"
     *     )
     * )
     */

    public function index(Request $request) //get
    {
        $platform = $request->query('platform', 'android');
        // android | ios | web

        $cacheKey = "app_config_{$platform}";

        $config = Cache::remember($cacheKey, 300, function () use ($platform) {
            return AppSetting::where('platform', $platform)->first();
        });

        if (!$config) {
            return response()->json([
                'status' => false,
                'message' => 'Config aplikasi tidak ditemukan'
            ], 404);
        }

        return response()->json([
            'status' => true,
            'data' => [
                'app_name' => $config->app_name,
                'platform' => $config->platform,
                'version' => [
                    'current' => $config->current_version,
                    'minimum' => $config->min_version,
                    'build' => $config->build_number,
                    'force_update' => $config->force_update,
                    'update_url' => $config->update_url,
                ],
                'maintenance' => [
                    'status' => $config->maintenance_mode,
                    'message' => $config->maintenance_message,
                ],
                'release_notes' => $config->release_notes,
                'support' => [
                    'email' => $config->support_email,
                    'whatsapp' => $config->support_whatsapp,
                ],
            ]
        ]);
    }
    /**
     * @OA\Post(
     *     path="/api/mobile/app/check-version",
     *     tags={"App"},
     *     summary="Cek versi aplikasi",
     *     description="Validasi versi aplikasi terhadap versi minimum dan versi terbaru",
     *
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"platform","version"},
     *             @OA\Property(property="platform", type="string", enum={"android","ios","web"}, example="android"),
     *             @OA\Property(property="version", type="string", example="1.2.0")
     *         )
     *     ),
     *
     *     @OA\Response(
     *         response=200,
     *         description="OK / Force Update / Blocked",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="status", type="string", example="force_update"),
     *             @OA\Property(property="message", type="string", example="Versi aplikasi sudah tidak didukung"),
     *             @OA\Property(property="update_url", type="string", example="https://play.google.com/store/apps/details")
     *         )
     *     ),
     *
     *     @OA\Response(
     *         response=422,
     *         description="Validasi gagal"
     *     )
     * )
     */
    public function checkVersion(Request $request) //post
    {
        $request->validate([
            'platform' => 'required|in:android,ios,web',
            'version' => 'required',
        ]);

        $config = AppSetting::where('platform', $request->platform)->firstOrFail();

        if (version_compare($request->version, $config->min_version, '<')) {
            return response()->json([
                'status' => 'blocked',
                'message' => 'Versi aplikasi sudah tidak didukung',
                'update_url' => $config->update_url
            ]);
        }

        if (
            version_compare($request->version, $config->current_version, '<') &&
            $config->force_update
        ) {
            return response()->json([
                'status' => 'force_update',
                'update_url' => $config->update_url
            ]);
        }

        return response()->json(['status' => 'ok']);
    }
}

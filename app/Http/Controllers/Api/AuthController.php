<?php

namespace App\Http\Controllers\Api; // <- HARUS App (huruf besar)

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Helpers\ApiResponse;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

use Illuminate\Validation\ValidationException;


/**
 * @OA\Tag(
 *     name="User",
 *     description="API endpoints for user"
 * )
 */
class AuthController extends Controller
{

    /**
     * @OA\Post(
     *     path="/api/auth/login",
     *     tags={"Auth"},
     *     summary="Login user menggunakan email dan password",
     *
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"email", "password"},
     *             @OA\Property(
     *                 property="email",
     *                 type="string",
     *                 format="email",
     *                 example="budi@gmail.com"
     *             ),
     *             @OA\Property(
     *                 property="password",
     *                 type="string",
     *                 format="password",
     *                 example="password123"
     *             ),
     *              @OA\Property(
     *                  property="fcm_token",
     *                  type="string",
     *                  example="dHSu2a1sdfwq0oEXAMPLEfcmToken123"
     *              )
     *         )
     *     ),
     *
     *     @OA\Response(
     *         response=200,
     *         description="Login berhasil",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="boolean", example=true),
     *             @OA\Property(property="message", type="string", example="Login berhasil"),
     *             @OA\Property(
     *                 property="data",
     *                 type="object",
     *                 @OA\Property(property="token", type="string", example="33|i9WddcEnTSY5kinmw52yoA7Fpnpb2M7V25pK6aeJd6827832"),
     *                 @OA\Property(
     *                     property="user",
     *                     type="object",
     *                     @OA\Property(property="id", type="integer", example=3),
     *                     @OA\Property(property="name", type="string", example="Budi"),
     *                     @OA\Property(property="username", type="string", nullable=true, example=null),
     *                     @OA\Property(property="email", type="string", example="budi@gmail.com"),
     *                     @OA\Property(property="phone", type="string", nullable=true, example=null),
     *                     @OA\Property(property="address", type="string", nullable=true, example=null),
     *                     @OA\Property(property="email_verified_at", type="string", format="date-time", nullable=true, example=null),
     *                     @OA\Property(property="status", type="string", example="active"),
     *                     @OA\Property(property="created_at", type="string", format="date-time", nullable=true, example=null),
     *                     @OA\Property(property="updated_at", type="string", format="date-time", example="2025-12-12T04:10:45.000000Z"),
     *                     @OA\Property(property="deleted_at", type="string", format="date-time", nullable=true, example=null),
     *                     @OA\Property(property="avatar", type="string", example="avatars/XKRrDWndZDgtTLTbQsSAsJvJvQLtwS1dBr57v3D3.png"),
     *                     @OA\Property(property="device_id", type="string", nullable=true, example=null),
     *                     @OA\Property(property="fcm_token", type="string", nullable=true, example=null),
     *                     @OA\Property(property="last_login_at", type="string", format="date-time", nullable=true, example=null),
     *                     @OA\Property(property="last_login_ip", type="string", nullable=true, example=null),
     *                     @OA\Property(property="is_online", type="integer", example=0),
     *                     @OA\Property(property="api_token", type="string", nullable=true, example=null),
     *                     @OA\Property(
     *                         property="roles",
     *                         type="array",
     *                         @OA\Items(
     *                             type="object",
     *                             @OA\Property(property="id", type="integer", example=5),
     *                             @OA\Property(property="name", type="string", example="opd_pengawas"),
     *                             @OA\Property(property="guard_name", type="string", example="web"),
     *                             @OA\Property(property="man", type="integer", example=1),
     *                             @OA\Property(property="show_name", type="string", example="OPD Pengawas"),
     *                             @OA\Property(property="created_at", type="string", format="date-time", example="2025-11-26T05:22:43.000000Z"),
     *                             @OA\Property(property="updated_at", type="string", format="date-time", example="2025-11-26T05:22:43.000000Z"),
     *                             @OA\Property(
     *                                 property="pivot",
     *                                 type="object",
     *                                 @OA\Property(property="model_type", type="string", example="App\\Models\\User"),
     *                                 @OA\Property(property="model_id", type="integer", example=3),
     *                                 @OA\Property(property="role_id", type="integer", example=5)
     *                             )
     *                         )
     *                     )
     *                 )
     *             ),
     *             @OA\Property(
     *                 property="meta",
     *                 type="object",
     *                 @OA\Property(property="timestamp", type="string", format="date-time", example="2025-12-16T06:17:33.935441Z")
     *             )
     *         )
     *     ),
     *
     *     @OA\Response(
     *         response=401,
     *         description="Email atau password salah"
     *     )
     * )
     */

    public function login(Request $request)
    {
        // Validasi wajib
        $request->validate([
            'email'     => 'required|email',
            'password'  => 'required|string',
            'fcm_token' => 'nullable|string', // tidak wajib
        ]);

        if (!Auth::attempt($request->only('email', 'password'))) {
            return ApiResponse::error(
                'Login gagal',
                ['auth' => ['Email atau password salah...']],
                401
            );
        }

        /** @var User $user */
        $user = Auth::user();
        // Cek status user (active / inactive)
        // Sesuaikan: status = 'active'
        if ($user->status !== 'active') {
            Auth::logout();

            throw ValidationException::withMessages([
                'email' => 'Akun Anda tidak aktif. Silakan hubungi administrator.',
            ]);
        }


        // TOLAK backend/admin login lewat API
        if ($user->hasAnyRole(['super_admin', 'sys_admin', 'admin', 'staff'])) {
            Auth::logout();
            return ApiResponse::error('Autentikasi ditolak');
        }

        // Simpan fcm_token ke user hanya jika ada
        if ($request->filled('fcm_token')) {
            $user->update([
                'fcm_token' => $request->fcm_token,
            ]);
        }

        $token = $user->createToken('api_token')->plainTextToken;

        $roles = $user->getRoleNames(); // collection: ["admin", "project-member"]

        $user->avatar = $user->avatar ? asset('storage/' . $user->avatar) : null;

        return ApiResponse::success([
            'token' => $token,
            'user'  => $user,
            'roles' => $roles,
        ], 'Login berhasil');
    }

    /**
     * @OA\Post(
     *     path="/api/auth/logout",
     *     tags={"Auth"},
     *     summary="Logout user",
     *     description="Menghapus token akses user yang sedang login (Sanctum).",
     *     security={{"sanctum":{}}},
     *     @OA\Response(
     *         response=200,
     *         description="Berhasil logout",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Loged out")
     *         )
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthorized - Token invalid atau tidak ada"
     *     )
     * )
     */
    public function logout(Request $request)
    {
        $user = $request->user();

        // hapus token FCM
        $user->update([
            'fcm_token' => null
        ]);

        // hapus token auth (Sanctum)
        $user->currentAccessToken()->delete();

        //$request->user()->currentAccessToken()->delete();
        return response()->json(['message' => 'Loged out']);
    }

    /**
     * Get authenticated user profile
     * 
     * @OA\Get(
     *     path="/api/auth/me",
     *     tags={"User"},
     *     summary="Get authenticated user profile",
     *     description="Returns current authenticated user",
     *     operationId="getUserProfile",
     *     security={ {"sanctum": {} }},
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="id", type="integer"),
     *             @OA\Property(property="name", type="string"),
     *             @OA\Property(property="email", type="string"),
     *              @OA\Property(property="phone", type="string")
     *         )
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthorized"
     *     )
     * )
     */

    public function me(Request $request)
    {
        return response()->json($request->user()->load('roles'));
    }

    /**
     * @OA\Post(
     *     path="/api/profile/change-password",
     *     tags={"Profile"},
     *     summary="Change user password",
     *     description="Ganti password user yang sudah login",
     *     security={{"sanctum":{}}},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 required={"current_password","new_password"},
     *                 @OA\Property(
     *                     property="current_password",
     *                     type="string",
     *                     example="OldPassword123!"
     *                 ),
     *                 @OA\Property(
     *                     property="new_password",
     *                     type="string",
     *                     example="NewPassword123!"
     *                 )
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Password berhasil diubah",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="boolean", example=true),
     *             @OA\Property(property="message", type="string", example="Password berhasil diubah.")
     *         )
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Validasi gagal / password lama salah",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="boolean", example=false),
     *             @OA\Property(property="message", type="string", example="Password lama tidak sesuai.")
     *         )
     *     )
     * )
     */

    public function changePassword(Request $request)
    {
        $user = Auth::user();


        $request->validate([
            'current_password' => 'required|string',
            'new_password' => [
                'required',
                'string',
                'min:8',
                //'confirmed',         // harus ada new_password_confirmation
                'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*#?&]).+$/',
            ],
        ], [
            'new_password.regex' => 'Password harus mengandung huruf besar, huruf kecil, angka, dan simbol.',
            'new_password.confirmed' => 'Konfirmasi password tidak cocok.',
        ]);



        if (!Hash::check($request->current_password, $user->password)) {
            return response()->json([
                'status' => false,
                'message' => 'Password lama tidak sesuai.'
            ], 422);
        }
        // Update password
        $user->password = Hash::make($request->new_password); // gunakan Hash::make

        $user->save();

        return response()->json([
            'status' => true,
            'message' => 'Password berhasil diubah.'
        ]);
    }
}

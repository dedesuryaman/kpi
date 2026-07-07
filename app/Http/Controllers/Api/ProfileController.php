<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

/**
 * @OA\Tag(name="Profile", description="API endpoints for user profile")
 */
class ProfileController extends Controller
{
    /**
     * @OA\Post(
     *     path="/api/profile/update",
     *     tags={"Profile"},
     *     summary="Update user profile",
     *     security={{"sanctum":{}}},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\MediaType(
     *             mediaType="multipart/form-data",
     *             @OA\Schema(
     *                 @OA\Property(property="name", type="string", example="Abdul"),
     *                 @OA\Property(property="address", type="string", example="Jl. Merdeka No. 10"),
     *                 @OA\Property(property="photo", type="file")
     *             )
     *         )
     *     ),
     *     @OA\Response(response=200, description="Success"),
     *     @OA\Response(response=422, description="Validation error")
     * )
     */
    public function updateProfile(Request $request)
    {
        $user = Auth::user();

        // Validasi input
        $validated = $request->validate([
            'name'    => 'required|string|max:255',
            'address' => 'nullable|string|max:255',
            'photo'   => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        // Update foto jika ada
        if ($request->hasFile('photo')) {

            // Hapus foto lama jika ada
            if ($user->avatar && Storage::disk('public')->exists($user->avatar)) {
                Storage::disk('public')->delete($user->avatar);
            }

            // Upload foto baru
            $path = $request->file('photo')->store('avatars', 'public');

            $validated['avatar'] = $path;  // Masukkan ke DB
        }

        // Update user
        $user->update($validated);
        return response()->json([
            'status'  => true,
            'message' => 'Profile updated successfully',
            'data'    => [
                'id'      => $user->id,
                'name'    => $user->name,
                'address' => $user->address,
                'avatar'  => $user->avatar ? asset('storage/' . $user->avatar) : null,
            ]
        ], 200);
    }
}

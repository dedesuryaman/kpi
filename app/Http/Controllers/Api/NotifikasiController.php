<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Helpers\ApiResponse;
use Illuminate\Support\Facades\Auth;
use App\Models\Notification;

/**
 * @OA\Tag(name="Notifikasi", description="API endpoints for notifikasi")
 */

class NotifikasiController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/mobile/notifikasi",
     *     tags={"Notifikasi"},
     *     summary="Listing notifikasi aktif",
     *     description="Listing notifikasi aktif dengan pagination",
     *     operationId="getMobileNotifikasi",
     *     security={{"bearerAuth": {}}},
     *
     *     @OA\Parameter(
     *         name="per_page",
     *         in="query",
     *         description="Jumlah data per halaman",
     *         @OA\Schema(type="integer", example=20)
     *     ),
     *     @OA\Parameter(
     *         name="page",
     *         in="query",
     *         description="Nomor halaman",
     *         @OA\Schema(type="integer", example=1)
     *     ),
     *
     *     @OA\Response(
     *         response=200,
     *         description="Berhasil mengambil list notifikasi",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="message", type="string", example="List notifikasi"),
     *             @OA\Property(
     *                 property="data",
     *                 type="object",
     *                 @OA\Property(
     *                     property="data",
     *                     type="array",
     *                     @OA\Items(
     *                         type="object",
     *                         @OA\Property(property="id", type="integer", example=1),
     *                         @OA\Property(property="title", type="string", example="Pekerjaan Baru"),
     *                         @OA\Property(property="message", type="string", example="Anda ditugaskan"),
     *                         @OA\Property(property="type", type="string", example="pekerjaan"),
     *                         @OA\Property(property="is_read", type="boolean", example=false),
     *                         @OA\Property(property="sent_at", type="string", format="date-time")
     *                     )
     *                 ),
     *                 @OA\Property(property="current_page", type="integer", example=1),
     *                 @OA\Property(property="per_page", type="integer", example=20),
     *                 @OA\Property(property="total", type="integer", example=100)
     *             )
     *         )
     *     ),
     *
     *     @OA\Response(
     *         response=401,
     *         description="Unauthorized"
     *     )
     * )
     */
    public function index(Request $request)
    {
        $perPage = $request->get('per_page', 20);

        $data = Notification::where('user_id', Auth::id())
            ->where('is_archive', 0)
            ->where('is_delete', 0)
            ->latest('sent_at')
            ->paginate($perPage);

        return ApiResponse::success($data, 'Listing notifikasi aktif');
    }


    /**
     * @OA\Get(
     *     path="/api/mobile/notifikasi/arsip-list",
     *     tags={"Notifikasi"},
     *     summary="Listing arsip notifikasi",
     *     description="List arsip notifikasi user dengan pagination",
     *     operationId="getMobileArsipNotifikasi",
     *     security={{"bearerAuth": {}}},
     *
     *     @OA\Parameter(
     *         name="per_page",
     *         in="query",
     *         description="Jumlah data per halaman",
     *         @OA\Schema(type="integer", example=20)
     *     ),
     *     @OA\Parameter(
     *         name="page",
     *         in="query",
     *         description="Nomor halaman",
     *         @OA\Schema(type="integer", example=1)
     *     ),
     *
     *     @OA\Response(
     *         response=200,
     *         description="Berhasil mengambil list arsip notifikasi",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="message", type="string", example="List notifikasi"),
     *             @OA\Property(
     *                 property="data",
     *                 type="object",
     *                 @OA\Property(
     *                     property="data",
     *                     type="array",
     *                     @OA\Items(
     *                         type="object",
     *                         @OA\Property(property="id", type="integer", example=1),
     *                         @OA\Property(property="title", type="string", example="Pekerjaan Baru"),
     *                         @OA\Property(property="message", type="string", example="Anda ditugaskan"),
     *                         @OA\Property(property="type", type="string", example="pekerjaan"),
     *                         @OA\Property(property="is_read", type="boolean", example=true),
     *                          @OA\Property(property="is_archive", type="boolean", example=true),
     *                          @OA\Property(property="is_delete", type="boolean", example=true),
     *                         @OA\Property(property="sent_at", type="string", format="date-time")
     *                     )
     *                 ),
     *                 @OA\Property(property="current_page", type="integer", example=1),
     *                 @OA\Property(property="per_page", type="integer", example=20),
     *                 @OA\Property(property="total", type="integer", example=100)
     *             )
     *         )
     *     ),
     *
     *     @OA\Response(
     *         response=401,
     *         description="Unauthorized"
     *     )
     * )
     */
    public function archiveList(Request $request)
    {
        $perPage = $request->get('per_page', 20);

        $data = Notification::where('user_id', Auth::id())
            ->where('is_archive', 1)
            ->where('is_delete', 0)
            ->latest('sent_at')
            ->paginate($perPage);

        return ApiResponse::success($data, 'List archive');
    }


    /**
     * @OA\Get(
     *     path="/api/mobile/notifikasi/unread-count",
     *     tags={"Notifikasi"},
     *     summary="Jumlah notifikasi belum dibaca",
     *     operationId="getUnreadNotifikasi",
     *     security={{"bearerAuth": {}}},
     *
     *     @OA\Response(
     *         response=200,
     *         description="Berhasil",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="message", type="string", example="Jumlah notifikasi belum dibaca"),
     *             @OA\Property(
     *                 property="data",
     *                 type="object",
     *                 @OA\Property(property="unread", type="integer", example=5)
     *             )
     *         )
     *     ),
     *
     *     @OA\Response(response=401, description="Unauthorized")
     * )
     */
    public function unreadCount()
    {
        $count = Notification::where('user_id', Auth::id())
            ->where('is_read', 0)
            ->where('is_archive', 0)
            ->where('is_delete', 0)

            ->count();

        return ApiResponse::success(['unread' => $count], 'Jumlah notifikasi belum dibaca');
    }


    /**
     * @OA\Get(
     *     path="/api/mobile/notifikasi/arsip-count",
     *     tags={"Notifikasi"},
     *     summary="Jumlah notifikasi yang diarsipkan",
     *     operationId="getArchiveNotifikasi",
     *     security={{"bearerAuth": {}}},
     *
     *     @OA\Response(
     *         response=200,
     *         description="Berhasil",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="message", type="string", example="Jumlah notifikasi dalam arsip"),
     *             @OA\Property(
     *                 property="data",
     *                 type="object",
     *                 @OA\Property(property="archive", type="integer", example=5)
     *             )
     *         )
     *     ),
     *
     *     @OA\Response(response=401, description="Unauthorized")
     * )
     */
    public function archiveCount()
    {
        $count = Notification::where('user_id', Auth::id())
            ->where('is_archive', 1)
            ->where('is_delete', 0)
            ->count();

        return ApiResponse::success(['archive' => $count], 'Jumlah notifikasi dalam arsip');
    }

    /**
     * @OA\Post(
     *     path="/api/mobile/notifikasi/mark-arsip/{id}",
     *     tags={"Notifikasi"},
     *     summary="Tandai notifikasi status diarsipkan",
     *     operationId="markNotifikasiAsArchive",
     *     security={{"bearerAuth": {}}},
     *
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer", example=1)
     *     ),
     *
     *     @OA\Response(
     *         response=200,
     *         description="Berhasil",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="message", type="string", example="Notifikasi ditandai sebagai arsip"),
     *             @OA\Property(
     *                 property="data",
     *                 type="object",
     *                 @OA\Property(property="id", type="integer", example=1),
     *                 @OA\Property(property="is_archive", type="boolean", example=true)
     *             )
     *         )
     *     ),
     *
     *     @OA\Response(response=404, description="Notifikasi tidak ditemukan"),
     *     @OA\Response(response=401, description="Unauthorized")
     * )
     */
    public function markAsArchive($id)
    {
        $notif = Notification::where('user_id', Auth::id())
            ->find($id);

        if (!$notif) {
            return ApiResponse::error('Notifikasi tidak ditemukan', 404);
        }

        $notif->update(['is_archive' => 1]);

        return ApiResponse::success([
            'id' => $notif->id,
            'is_archive' => $notif->is_archive
        ], 'Notifikasi ditandai sebagai arsip');
    }




    /**
     * @OA\Post(
     *     path="/api/mobile/notifikasi/mark-read/{id}",
     *     tags={"Notifikasi"},
     *     summary="Tandai notifikasi status dibaca",
     *     operationId="markNotifikasiAsRead",
     *     security={{"bearerAuth": {}}},
     *
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer", example=1)
     *     ),
     *
     *     @OA\Response(
     *         response=200,
     *         description="Berhasil",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="message", type="string", example="Notifikasi ditandai dibaca"),
     *             @OA\Property(
     *                 property="data",
     *                 type="object",
     *                 @OA\Property(property="id", type="integer", example=1),
     *                 @OA\Property(property="is_read", type="boolean", example=true)
     *             )
     *         )
     *     ),
     *
     *     @OA\Response(response=404, description="Notifikasi tidak ditemukan"),
     *     @OA\Response(response=401, description="Unauthorized")
     * )
     */
    public function markAsRead($id)
    {
        $notif = Notification::where('id', $id)
            ->where('user_id', Auth::id())
            ->first();

        if (!$notif) {
            return ApiResponse::error('Notifikasi tidak ditemukan', 404);
        }

        $notif->update(['is_read' => 1]);

        return ApiResponse::success([
            'id' => $notif->id,
            'is_read' => $notif->is_read
        ], 'Notifikasi ditandai dibaca');
    }

    /**
     * @OA\Post(
     *     path="/api/mobile/notifikasi/mark-read-all",
     *     tags={"Notifikasi"},
     *     summary="Tandai beberapa notifikasi sebagai dibaca berdasarkan ID",
     *     operationId="markSelectedNotifikasiAsRead",
     *     security={{"bearerAuth": {}}},
     *
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             type="object",
     *             required={"ids"},
     *             @OA\Property(
     *                 property="ids",
     *                 type="array",
     *                 @OA\Items(type="integer"),
     *                 example={1,5,8,10}
     *             )
     *         )
     *     ),
     *
     *     @OA\Response(
     *         response=200,
     *         description="Berhasil",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="message", type="string", example="Notifikasi berhasil ditandai dibaca")
     *         )
     *     ),
     *
     *     @OA\Response(response=401, description="Unauthorized"),
     *     @OA\Response(response=422, description="Validation Error")
     * )
     */

    public function markAllAsRead(Request $request)
    {
        $request->validate([
            'ids' => 'required|array',
            'ids.*' => 'integer|exists:notifications,id'
        ]);

        Notification::where('user_id', Auth::id())
            ->whereIn('id', $request->ids)
            ->where('is_archive', 0)
            ->where('is_delete', 0)
            ->update(['is_read' => 1]);

        return ApiResponse::success(null, 'Notifikasi berhasil ditandai dibaca');
    }

    /**
     * @OA\Post(
     *     path="/api/mobile/notifikasi/mark-arsip-all",
     *     tags={"Notifikasi"},
     *     summary="Tandai beberapa notifikasi sebagai arsip berdasarkan ID",
     *     operationId="markSelectedNotifikasiAsArchive",
     *     security={{"bearerAuth": {}}},
     *
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             type="object",
     *             required={"ids"},
     *             @OA\Property(
     *                 property="ids",
     *                 type="array",
     *                 @OA\Items(type="integer"),
     *                 example={1,5,8,10}
     *             )
     *         )
     *     ),
     *
     *     @OA\Response(
     *         response=200,
     *         description="Berhasil",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="message", type="string", example="Notifikasi berhasil ditandai diarsipkan")
     *         )
     *     ),
     *
     *     @OA\Response(response=401, description="Unauthorized"),
     *     @OA\Response(response=422, description="Validation Error")
     * )
     */

    public function markAllAsArchive(Request $request)
    {
        $request->validate([
            'ids' => 'required|array',
            'ids.*' => 'integer|exists:notifications,id'
        ]);

        Notification::where('user_id', Auth::id())
            ->whereIn('id', $request->ids)
            ->where('is_read', 1)
            ->where('is_delete', 0)
            ->update(['is_archive' => 1]);

        return ApiResponse::success(null, 'Notifikasi berhasil ditandai diarsipkan');
    }

    /**
     * @OA\Post(
     *     path="/api/mobile/notifikasi/mark-delete-all",
     *     tags={"Notifikasi"},
     *     summary="Tandai beberapa notifikasi untuk dihapus berdasarkan ID",
     *     operationId="markSelectedNotifikasiAsDelete",
     *     security={{"bearerAuth": {}}},
     *
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             type="object",
     *             required={"ids"},
     *             @OA\Property(
     *                 property="ids",
     *                 type="array",
     *                 @OA\Items(type="integer"),
     *                 example={1,5,8,10}
     *             )
     *         )
     *     ),
     *
     *     @OA\Response(
     *         response=200,
     *         description="Berhasil",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="message", type="string", example="Notifikasi berhasil dihapus")
     *         )
     *     ),
     *
     *     @OA\Response(response=401, description="Unauthorized"),
     *     @OA\Response(response=422, description="Validation Error")
     * )
     */

    public function markAllAsDelete(Request $request)
    {
        $request->validate([
            'ids' => 'required|array',
            'ids.*' => 'integer|exists:notifications,id'
        ]);

        Notification::where('user_id', Auth::id())
            ->whereIn('id', $request->ids)
            ->where('is_read', 1)
            ->update(['is_delete' => 1]);

        return ApiResponse::success(null, 'Notifikasi berhasil dihapus');
    }

    /**
     * @OA\Delete(
     *     path="/api/mobile/notifikasi/{id}",
     *     tags={"Notifikasi"},
     *     summary="Hapus notifikasi",
     *     operationId="deleteNotifikasi",
     *     security={{"bearerAuth": {}}},
     *
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer", example=1)
     *     ),
     *
     *     @OA\Response(
     *         response=200,
     *         description="Berhasil",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="message", type="string", example="Notifikasi dihapus")
     *         )
     *     ),
     *
     *     @OA\Response(response=404, description="Notifikasi tidak ditemukan"),
     *     @OA\Response(response=401, description="Unauthorized")
     * )
     */
    public function destroy($id)
    {
        // Ambil notifikasi milik user yang login, atau return 404 otomatis
        $notif = Notification::where('id', $id)
            ->where('user_id', Auth::id())
            ->first();

        if (!$notif) {
            return ApiResponse::error('Notifikasi tidak ditemukan', 404);
        }

        // Lakukan soft delete
        $notif->update(['is_delete' => 1, 'deleted_at' => now()]);

        return ApiResponse::success(null, 'Notifikasi berhasil dihapus');
    }


    public function read_all(Request $request)
    {
        Notification::where('user_id', Auth::id())
            ->where('is_read', 0)
            ->where('is_archive', 0)
            ->where('is_delete', 0)
            ->update(['is_read' => 1]);

        return ApiResponse::success(null, 'Semua notifikasi ditandai dibaca');
    }
}

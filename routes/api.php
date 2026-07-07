<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;

use App\Http\Controllers\Api\ProjectController;
use App\Http\Controllers\Api\DashboardController;
use App\Http\Controllers\Api\HomeController;
use App\Http\Controllers\Api\TaskController;

use App\Http\Controllers\Api\KegiatanController;
use App\Http\Controllers\Api\PekerjaanController;
use App\Http\Controllers\Api\SubPekerjaanController;

use App\Http\Controllers\Api\PengawasanController;
use App\Http\Controllers\Api\PosPengawasanController;
use App\Http\Controllers\Api\DokumenController;
use App\Http\Controllers\Api\LaporanKendalaController;
use App\Http\Controllers\Api\ProfileController;
use App\Http\Controllers\Api\NotifikasiController;

Route::middleware('throttle:60,1')->group(
    function () {
        Route::get('/mobile/app/config', [App\Http\Controllers\Api\AppConfigController::class, 'index']);
        Route::post('/mobile/app/check-version', [App\Http\Controllers\Api\AppConfigController::class, 'checkVersion']);
    }
);

/*
|--------------------------------------------------------------------------
| AUTH PUBLIC
|--------------------------------------------------------------------------
*/

Route::prefix('auth')->controller(AuthController::class)->group(function () {
    Route::post('login', 'login');
});


Route::middleware('auth:sanctum')->group(
    function () {

        Route::post('/notifikasi/read-all', [NotifikasiController::class, 'read_all']); //ini yang lama

    }
);

/*
|--------------------------------------------------------------------------
| AUTH PROTECTED
|--------------------------------------------------------------------------
*/
Route::middleware('auth:sanctum')->prefix('auth')->controller(AuthController::class)->group(function () {
    Route::get('me', 'me');
    Route::post('logout', 'logout');
});

Route::middleware('auth:sanctum')->prefix('profile')->controller(AuthController::class)->group(function () {

    Route::post('/update', [ProfileController::class, 'updateProfile']);
    Route::post('/change-password', [AuthController::class, 'changePassword']);
});

/*
|--------------------------------------------------------------------------
| ROLE BASED ROUTES
|--------------------------------------------------------------------------
*/
Route::middleware(['auth:sanctum'])->prefix('mobile')->name('mobile.')->group(function () {

    // ADMIN
    Route::middleware('role:admin')->prefix('admin')->group(function () {
        // Route::get('/dashboard', ...);
    });

    // OWNER MANAGER
    Route::middleware('role:owner_manager')->prefix('owner')->group(function () {
        // Route::get('/projects', ...);
    });

    // CONTRACTOR MANAGER
    Route::middleware('role:contractor_manager')->prefix('contractor')->group(function () {
        // Route::get('/tasks', ...);
    });

    // SUPERVISOR
    Route::middleware('role:supervisor')->prefix('supervisor')->group(function () {
        // Route::get('/monitoring', ...);
    });

    // EXECUTOR / PELAKSANA
    Route::middleware('role:executor')->prefix('executor')->group(function () {
        // Route::get('/my-jobs', ...);
    });

    // EXECUTOR / PELAKSANA
    Route::middleware('role:kontraktor')->group(function () {
        // Route::get('/my-jobs', ...);
    });

    // PENGAWAS
    Route::middleware('role:opd_pengawas')->group(function () {

        Route::get('/home', [HomeController::class, 'index'])->name('home');


        Route::prefix('dashboard')->group(function () {
            Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
        });


        Route::get('/kegiatans', [KegiatanController::class, 'index'])->name('kegiatans');
        Route::get('/kegiatan/{id}', [KegiatanController::class, 'kegiatan'])->name('kegiatan');


        Route::get('/pekerjaans', [PekerjaanController::class, 'index'])->name('pekerjaans');
        Route::get('/pekerjaan/{id}', [PekerjaanController::class, 'pekerjaan'])->name('pekerjaan');


        Route::get('/sub-pekerjaans/{pekerjaan_id}', [SubPekerjaanController::class, 'index'])->name('sub-pekerjaans');
        Route::get('/sub-pekerjaan/{sub_pekerjaan_id}', [SubPekerjaanController::class, 'sub_pekerjaan'])->name('sub-pekerjaan');

        Route::get('/pengawasans/{pekerjaan_id}', [PengawasanController::class, 'index'])->name('pengawasans');
        Route::get('/pengawasan/{pengawasan_id}', [PengawasanController::class, 'pengawasan'])->name('pengawasan');

        //transact laporan
        Route::post('/laporan/pengawasan', [PosPengawasanController::class, 'laporan'])->name('laporan.pengawasan');

        Route::get('/laporan/kendalas', [LaporanKendalaController::class, 'index'])->name('laporan.kendalas');
        Route::post('/laporan/kendala', [LaporanKendalaController::class, 'laporan'])->name('laporan.kendala');
        //dokumen
        Route::get('/dokumens/{pekerjaan_id}', [DokumenController::class, 'index'])->name('dokumens');
        Route::get('/dokumen/{dokumen_id}', [DokumenController::class, 'dokumen'])->name('dokumen');


        Route::get('/notifikasi', [NotifikasiController::class, 'index']);

        Route::get('/notifikasi/read/{id}', [NotifikasiController::class, 'readNotifikasi']);

        Route::get('/notifikasi/read-all', [NotifikasiController::class, 'read_all']); //ini yang lama


        Route::get('/notifikasi/arsip-list', [NotifikasiController::class, 'archiveList']);

        Route::get('/notifikasi/unread-count', [NotifikasiController::class, 'unreadCount']);
        Route::get('/notifikasi/arsip-count', [NotifikasiController::class, 'archiveCount']);


        Route::post('/notifikasi/mark-read/{id}', [NotifikasiController::class, 'markAsRead']);
        Route::post('/notifikasi/mark-arsip/{id}', [NotifikasiController::class, 'markAsArchive']);

        Route::post('/notifikasi/mark-arsip-all', [NotifikasiController::class, 'markAllAsArchive']);
        Route::post('/notifikasi/mark-delete-all', [NotifikasiController::class, 'markAllAsDelete']);


        Route::post('/notifikasi/mark-read-all', [NotifikasiController::class, 'markAllAsRead']);
        Route::delete('/notifikasi/{id}', [NotifikasiController::class, 'destroy']);
    });
});

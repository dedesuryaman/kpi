<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\AppSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class AppConfigAdminController extends Controller
{
    public function index()
    {
        $configs = AppSetting::all();
        return view('admin.app-config.index', compact('configs'));
    }

    public function edit($platform)
    {
        $config = AppSetting::where('platform', $platform)->firstOrFail();
        return view('admin.app-config.edit', compact('config'));
    }

    public function update(Request $request, $platform)
    {
        $request->validate([
            'current_version' => 'required',
            'min_version' => 'required',
            'update_url' => 'nullable|url',
        ]);

        $config = AppSetting::where('platform', $platform)->firstOrFail();

        $user = $request->user();

        $config->update([
            'current_version' => $request->current_version,
            'min_version' => $request->min_version,
            'build_number' => $request->build_number,
            'force_update' => $request->boolean('force_update'),
            'maintenance_mode' => $request->boolean('maintenance_mode'),
            'maintenance_message' => $request->maintenance_message,
            'update_url' => $request->update_url,
            'release_notes' => $request->release_notes,
            'updated_by' => $user->id,
        ]);

        // Clear cache bootstrap
        Cache::forget("mobile_bootstrap_android");
        Cache::forget("mobile_bootstrap_ios");
        Cache::forget("mobile_bootstrap_web");

        return redirect()->back()->with('success', 'App config berhasil diperbarui');
    }
}

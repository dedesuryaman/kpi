<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class SettingController extends Controller
{
    public function index()
    {
        $settings = Setting::whereNull('opd_id')
            ->whereNull('tahun_anggaran')
            ->orderBy('setting_group')
            ->get()
            ->groupBy('setting_group');

        return view('settings.index', compact('settings'));
    }

    public function update(Request $request)
    {
        foreach ($request->settings as $id => $value) {
            $setting = Setting::find($id);

            if (!$setting) continue;

            // Casting sesuai type
            $setting->setting_value = $this->castValue(
                $value,
                $setting->setting_type
            );

            $setting->save();

            Cache::forget("setting_{$setting->setting_key}");
        }

        return redirect()
            ->route('settings.index')
            ->with('success', 'Pengaturan berhasil diperbarui');
    }

    private function castValue($value, $type)
    {
        return match ($type) {
            'boolean' => $value ? 1 : 0,
            'number' => (int) $value,
            'json' => json_encode($value),
            default => $value
        };
    }
}

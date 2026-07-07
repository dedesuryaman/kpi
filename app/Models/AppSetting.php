<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AppSetting extends Model
{
    protected $table = 'app_settings';

    protected $fillable = [
        'platform',
        'app_name',
        'current_version',
        'min_version',
        'build_number',
        'force_update',
        'update_url',
        'maintenance_mode',
        'maintenance_message',
        'release_notes',
        'support_email',
        'support_whatsapp',
    ];

    protected $casts = [
        'force_update' => 'boolean',
        'maintenance_mode' => 'boolean',
    ];
}

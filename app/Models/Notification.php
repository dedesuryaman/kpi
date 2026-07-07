<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    protected $fillable = [
        'user_id',
        'sent_by',
        'title',
        'message',
        'type',
        'data',
        'is_read',
        'is_archive',
        'is_delete',
        'sent_at',
        'deleted_at',
    ];

    protected $casts = [
        'data'          => 'array',
        'is_read'       => 'boolean',
        'is_archive'    => 'boolean',
        'is_delete'     => 'boolean',
        'sent_at'       => 'datetime',
        'deleted_at'    => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id')->withDefault();
    }

    public function sender()
    {
        return $this->belongsTo(User::class, 'sent_by')->withDefault();
    }
}

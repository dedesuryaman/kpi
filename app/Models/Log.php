<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @mixin IdeHelperLog
 */
class Log extends Model
{
    protected $table = 'log';

    protected $fillable = [
        'id', 'user_id', 'data',
    ];
}

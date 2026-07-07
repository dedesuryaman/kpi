<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @mixin IdeHelperRefUrusan
 */
class Setting extends Model
{
    protected $table = 'settings';


    protected $fillable = [
        'app_name',
        'time_zone'
    ];
}

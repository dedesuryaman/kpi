<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Models\Role as SpatieRole;
use Illuminate\Database\Eloquent\Relations\MorphToMany;

class Role extends SpatieRole
{

    protected $fillable = ['name', 'guard_name', 'show_name'];


    public function user()
    {
        return $this->hasOne(User::class);
    }


    // public function users()
    // {
    //     return $this->belongsToMany(User::class);
    // }

    public function users(): MorphToMany
    {
        return $this->morphedByMany(User::class, 'model', 'model_has_roles', 'role_id', 'model_id');
    }
}

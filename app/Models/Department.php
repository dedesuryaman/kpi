<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    use HasFactory;

    protected $table = 'departments';

    protected $fillable = [
        'division_id',
        'name',
    ];

    /**
     * Division
     */
    public function division()
    {
        return $this->belongsTo(Division::class);
    }

    /**
     * Employees
     */
    public function employees()
    {
        return $this->hasMany(Employee::class);
    }
}

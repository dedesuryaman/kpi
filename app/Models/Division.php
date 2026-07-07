<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Division extends Model
{
    use HasFactory;

    protected $table = 'divisions';

    protected $fillable = [
        'name',
        'description',
    ];

    /**
     * Departments dalam division
     */
    public function departments()
    {
        return $this->hasMany(Department::class);
    }

    /**
     * KPI Master dalam division
     */
    public function kpiMasters()
    {
        return $this->hasMany(KpiMaster::class);
    }

    /**
     * Employees melalui Department
     */
    public function employees()
    {
        return $this->hasManyThrough(
            Employee::class,
            Department::class,
            'division_id',   // FK di departments
            'department_id', // FK di employees
            'id',            // PK divisions
            'id'             // PK departments
        );
    }
}

<?php

namespace App\Http\Controllers\KPI;

use App\Http\Controllers\Controller;
use App\Models\Department;
use Illuminate\Http\Request;

class KpiScoreController extends Controller
{
    public function index()
    {
        $departments = \App\Models\Department::all();
        $divisions = \App\Models\Division::all();

        return view('kpi.score.index', compact('departments', 'divisions'));
    }
}

<?php

namespace App\Http\Controllers\KPI;

use App\Http\Controllers\Controller;
use App\Models\Division;
use App\Models\Period;
use Illuminate\Http\Request;

class KpiSetupController extends Controller
{
    public function index()
    {

        return view('kpi-setup.menu');
    }

    public function period()
    {
        $periods = Period::orderBy('start_date', 'desc')->get();

        return view('kpi-setup.period.index', compact('periods'));
    }
}

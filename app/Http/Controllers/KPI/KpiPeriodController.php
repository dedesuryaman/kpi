<?php

namespace App\Http\Controllers\KPI;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Period;
use Illuminate\Support\Facades\DB;

class KpiPeriodController extends Controller
{
    public function index()
    {
        $periods = Period::latest()->get();

        return view('kpi.period.index', compact('periods'));
    }

    public function store(Request $request)
    {
        Period::create([
            'name' => $request->name,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'status' => $request->status,
        ]);

        return response()->json(['success' => true]);
    }
    public function edit($id)
    {
        $period = Period::findOrFail($id);

        return response()->json([
            'id'         => $period->id,
            'name'       => $period->name,
            'start_date' => $period->start_date
                ->timezone('Asia/Jakarta')
                ->format('Y-m-d'),
            'end_date'   => $period->end_date
                ->timezone('Asia/Jakarta')
                ->format('Y-m-d'),
            'status'  => $period->status,
        ]);
    }


    public function update(Request $request, $id)
    {
        $period = Period::findOrFail($id);


        if ($request->status === 'active') {
            Period::where('id', '!=', $period->id)
                ->update([
                    'status' => 'closed',
                ]);
        }

        $period->update([
            'name'       => $request->name,
            'start_date' => $request->start_date,
            'end_date'   => $request->end_date,
            'status'  => $request->status,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Period updated successfully.'
        ]);
    }


    public function destroy($id)
    {
        Period::findOrFail($id)->delete();

        return response()->json(['success' => true]);
    }
}

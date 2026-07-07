<?php

namespace App\Http\Controllers\KPI;

use App\Http\Controllers\Controller;
use App\Models\Employee;
use App\Models\KpiIndicator;
use App\Models\KpiIndicatorValue;
use Illuminate\Http\Request;

class KpiEmployeeController extends Controller
{
    public function index()
    {
        //$employees = Employee::orderBy('name')->get();


        // $employees = Employee::with([
        //     'kpiIndicatorValues.indicator'
        // ])->get();

        // $indicators = KpiIndicator::orderBy('name')->get();

        // $values = KpiIndicatorValue::with([
        //     'employee',
        //     'indicator'
        // ])->latest()->get();


        $periods = \App\Models\Period::orderBy('start_date', 'desc')->get();

        return view(
            'kpi.employee.index',
            compact(
                'periods'
            )
        );
    }

    public function store(Request $request)
    {
        KpiIndicatorValue::create([
            'employee_id'      => $request->employee_id,
            'kpi_indicator_id' => $request->kpi_indicator_id,
            'weight'           => $request->weight,
            'target_value'     => $request->target_value,
            'actual_value'     => $request->actual_value,
            'score'            => $request->score,
            'remarks'          => $request->remarks,
        ]);

        return response()->json([
            'success' => true
        ]);
    }

    public function edit($id)
    {
        return response()->json(
            KpiIndicatorValue::findOrFail($id)
        );
    }

    public function update(Request $request, $id)
    {
        $value = KpiIndicatorValue::findOrFail($id);

        $value->update([
            'employee_id'      => $request->employee_id,
            'kpi_indicator_id' => $request->kpi_indicator_id,
            'weight'           => $request->weight,
            'target_value'     => $request->target_value,
            'actual_value'     => $request->actual_value,
            'score'            => $request->score,
            'remarks'          => $request->remarks,
        ]);

        return response()->json([
            'success' => true
        ]);
    }

    public function destroy($id)
    {
        KpiIndicatorValue::findOrFail($id)->delete();

        return response()->json([
            'success' => true
        ]);
    }
}

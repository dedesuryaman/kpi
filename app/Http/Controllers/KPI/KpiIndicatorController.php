<?php

namespace App\Http\Controllers\KPI;

use App\Http\Controllers\Controller;
use App\Models\Department;
use App\Models\Division;
use App\Models\KpiIndicator;
use App\Models\KpiMaster;
use App\Models\Period;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

class KpiIndicatorController extends Controller
{
    public function index(Request $request)
    {


        $indicators = KpiIndicator::with('master')
            ->when(request('search'), function ($q) {
                $q->where('name', 'like', '%' . request('search') . '%');
            })
            ->when(request('master'), function ($q) {
                $q->where('kpi_master_id', request('master'));
            })
            ->when(request('type'), function ($q) {
                $q->where('measurement_type', request('type'));
            })
            ->when(request('status') !== null && request('status') !== '', function ($q) {
                $q->where('is_active', request('status'));
            })
            ->latest()
            ->paginate(10)
            ->withQueryString();


        $masters = KpiMaster::where('status', 1)
            ->orderBy('name')
            ->get();

        return view('kpi.indicator.index', compact('indicators', 'masters'));
    }

    public function create()
    {
        return view('kpi.indicator.create', [
            'masters' => KpiMaster::all(),
            'periods' => Period::all(),
            'divisions' => Division::all()
        ]);
    }


    public function store(Request $request)
    {
        $validated = $request->validate([
            'kpi_master_id' => [
                'required',
                'exists:kpi_masters,id',
            ],

            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('kpi_indicators', 'name')
                    ->where(fn($query) => $query->where('kpi_master_id', $request->kpi_master_id)),
            ],

            'description' => [
                'nullable',
                'string',
                'max:1000',
            ],

            'weight' => [
                'required',
                'numeric',
                'between:0,100',
            ],

            'min_score' => [
                'required',
                'numeric',
            ],

            'max_score' => [
                'required',
                'numeric',
                'gt:min_score',
            ],

            'measurement_type' => [
                'required',
                Rule::in([
                    'percentage',
                    'number',
                    'score',
                    'boolean',
                ]),
            ],

            'is_active' => [
                'nullable',
                'boolean',
            ],
        ]);

        try {

            DB::transaction(function () use ($validated) {


                $totalWeight = KpiIndicator::where(
                    'kpi_master_id',
                    $validated['kpi_master_id']
                )->sum('weight');

                if (($totalWeight + $validated['weight']) > 100) {

                    throw ValidationException::withMessages([
                        'weight' => 'Total KPI weight cannot exceed 100%.'
                    ]);
                }



                KpiIndicator::create([
                    'kpi_master_id'   => $validated['kpi_master_id'],
                    'name'            => $validated['name'],
                    'description'     => $validated['description'],
                    'weight'          => $validated['weight'],
                    'min_score'       => $validated['min_score'],
                    'max_score'       => $validated['max_score'],
                    'measurement_type' => $validated['measurement_type'],
                    'is_active'       => $validated['is_active'] ?? true,
                ]);
            });

            return redirect()
                ->route('kpi.indicator.index')
                ->with('success', 'KPI Indicator created successfully.');
        } catch (ValidationException $e) {
            throw $e;
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }


    public function edit($id)
    {

        $indicator = KpiIndicator::findOrFail($id);

        return view('kpi.indicator.edit', [
            'indicator' => $indicator,
            'masters' => KpiMaster::all(),
            'periods' => Period::all(),
            'divisions' => Division::all()
        ]);
    }

    public function update(Request $request, $id)
    {
        $indicator = KpiIndicator::findOrFail($id);

        $validated = $request->validate([
            'kpi_master_id' => [
                'required',
                'exists:kpi_masters,id',
            ],

            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('kpi_indicators', 'name')
                    ->where(fn($query) => $query->where('kpi_master_id', $request->kpi_master_id))
                    ->ignore($indicator->id),
            ],

            'description' => [
                'nullable',
                'string',
                'max:1000',
            ],

            'weight' => [
                'required',
                'numeric',
                'between:0,100',
            ],

            'min_score' => [
                'required',
                'numeric',
            ],

            'max_score' => [
                'required',
                'numeric',
                'gt:min_score',
            ],

            'measurement_type' => [
                'required',
                Rule::in([
                    'percentage',
                    'number',
                    'score',
                    'boolean',
                ]),
            ],

            'is_active' => [
                'nullable',
                'boolean',
            ],
        ]);

        try {

            DB::transaction(function () use ($validated, $indicator) {

                // Hitung total weight selain record yang sedang diedit
                $totalWeight = KpiIndicator::where('kpi_master_id', $validated['kpi_master_id'])
                    ->where('id', '!=', $indicator->id)
                    ->sum('weight');

                if (($totalWeight + $validated['weight']) > 100) {
                    throw ValidationException::withMessages([
                        'weight' => 'Total KPI weight cannot exceed 100%.'
                    ]);
                }

                $indicator->update([
                    'kpi_master_id'    => $validated['kpi_master_id'],
                    'name'             => $validated['name'],
                    'description'      => $validated['description'],
                    'weight'           => $validated['weight'],
                    'min_score'        => $validated['min_score'],
                    'max_score'        => $validated['max_score'],
                    'measurement_type' => $validated['measurement_type'],
                    'is_active'        => $validated['is_active'] ?? 0,
                ]);
            });

            return redirect()
                ->route('kpi.indicator.index')
                ->with('success', 'KPI Indicator updated successfully.');
        } catch (ValidationException $e) {
            throw $e;
        } catch (\Throwable $e) {
            return back()
                ->withInput()
                ->with('error', $e->getMessage());
        }
    }

    public function destroy($id)
    {
        KpiIndicator::destroy($id);


        return redirect()
            ->route('kpi.indicator.index')
            ->with('success', 'KPI Indicator deleted successfully.');
    }
}

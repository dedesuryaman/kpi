<?php

namespace App\Http\Controllers\KPI;

use App\Http\Controllers\Controller;

use App\Models\Department;
use App\Models\Division;
use App\Models\KpiMaster;
use App\Models\Period;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class KpiMasterController extends Controller
{

    public function index()
    {
        $masters = KpiMaster::with('indicators')
            ->when(request()->filled('search'), function ($query) {
                $search = trim(request('search'));

                $query->where(function ($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%")
                        ->orWhere('description', 'like', "%{$search}%");
                });
            })
            ->orderBy('name')
            ->paginate(10)
            ->withQueryString();

        return view('kpi.master.index', compact('masters'));
    }

    public function create()
    {
        return view('kpi.master.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:kpi_masters,name',
            'description' => 'nullable|string',
            'status' => 'required|boolean',
        ], [
            'name.required' => 'KPI Master name is required.',
            'name.unique' => 'KPI Master name already exists.',
        ]);

        KpiMaster::create([
            'name'        => $validated['name'],
            'description' => $validated['description'],
            'status'      => $validated['status'],
            'created_by'  => auth()->id(),
        ]);

        return redirect()
            ->route('kpi.master.index')
            ->with('success', 'KPI Master created successfully.');
    }

    public function edit($id)
    {
        $kpi = KpiMaster::findOrFail($id);

        return view('kpi.master.edit', compact(
            'kpi'
        ));
    }

    public function update(Request $request, $id)
    {
        $kpi = KpiMaster::findOrFail($id);

        $validated = $request->validate([
            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('kpi_masters', 'name')->ignore($kpi->id),
            ],
            'description' => 'nullable|string',
            'status' => 'nullable|boolean',
        ], [
            'name.required' => 'KPI Master name is required.',
            'name.unique'   => 'KPI Master name already exists.',
        ]);

        $kpi->update([
            'name'        => $validated['name'],
            'description' => $validated['description'],
            'status'      => $request->boolean('status'),
        ]);

        return redirect()
            ->route('kpi.master.index')
            ->with('success', 'KPI Master updated successfully.');
    }

    public function destroy($id)
    {
        $kpi = KpiMaster::findOrFail($id);

        $kpi->delete();

        return redirect()
            ->route('kpi.master.index')
            ->with('success', 'KPI Master deleted successfully.');
    }
}

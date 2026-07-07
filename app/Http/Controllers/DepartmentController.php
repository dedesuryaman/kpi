<?php

namespace App\Http\Controllers;

use App\Models\Department;
use Illuminate\Http\Request;

class DepartmentController extends Controller
{
    public function index()
    {
        $departments = \App\Models\Department::all();
        $divisions = \App\Models\Division::all();

        return view('departments.index', compact('departments', 'divisions'));
    }


    public function data(Request $request)
    {
        $query = Department::query()
            ->leftJoin('divisions', 'departments.division_id', '=', 'divisions.id')
            ->select(
                'departments.*',
                'divisions.name as division_name'
            );

        // 🔍 SEARCH GLOBAL
        if ($request->search) {
            $search = $request->search;

            $query->where(function ($q) use ($search) {
                $q->where('departments.name', 'like', "%{$search}%")
                    ->orWhere('divisions.name', 'like', "%{$search}%");
            });
        }

        // 🏢 FILTER DEPARTMENT
        if ($request->division_id) {

            $query->where('departments.division_id', $request->division_id);
        }

        // 📄 PAGINATION (WAJIB untuk UI kamu)
        $perPage = $request->per_page ?? 10;

        $data = $query
            ->orderBy('departments.id', 'desc')
            ->paginate($perPage);

        return response()->json([
            'data' => $data->items(),
            'total' => $data->total(),
            'current_page' => $data->currentPage(),
            'last_page' => $data->lastPage(),
            'per_page' => $data->perPage(),
        ]);
    }

    // STORE
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|unique:departments,name',
            'division_id' => 'required|exists:divisions,id',
        ]);

        $department = Department::create($validated);

        return response()->json([
            'message' => 'Department created',
            'data' => $department
        ]);
    }

    // EDIT GET DATA
    public function edit(Department $department)
    {
        return response()->json($department);
    }

    // UPDATE
    public function update(Request $request, Department $department)
    {
        $validated = $request->validate([
            'name' => 'required|unique:departments,name,' . $department->id . ',id,division_id,' . $request->division_id,
            'division_id' => 'required|exists:divisions,id',
        ]);

        $department->update($validated);

        return response()->json([
            'message' => 'Department updated'
        ]);
    }

    // DELETE
    public function destroy(Department $department)
    {
        $department->delete();

        return response()->json([
            'message' => 'Department deleted'
        ]);
    }
}

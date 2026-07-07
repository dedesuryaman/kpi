<?php

namespace App\Http\Controllers;

use App\Models\Division;
use Illuminate\Http\Request;

class DivisionController extends Controller
{
    public function index()
    {
        $divisions = \App\Models\Division::all();

        return view('divisions.index', compact('divisions'));
    }

    public function data(Request $request)
    {
        $query = Division::query()
            ->select(
                'divisions.*'
            );

        // 🔍 SEARCH GLOBAL
        if ($request->filled('search')) {
            $search = $request->search;

            $query->where(function ($q) use ($search) {
                $q->where('divisions.name', 'like', "%{$search}%")
                    ->orWhere('divisions.description', 'like', "%{$search}%");
            });
        }

        // 📄 PAGINATION (WAJIB untuk UI kamu)
        $perPage = $request->per_page ?? 10;

        $data = $query
            ->orderBy('divisions.name', 'asc')
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
            'name' => 'required|unique:divisions,name',
            'description' => 'required',
        ]);

        $div = Division::create($validated);

        return response()->json([
            'message' => 'Division created',
            'data' => $div
        ]);
    }

    // EDIT GET DATA
    public function edit(Division $division)
    {
        return response()->json($division);
    }

    // UPDATE
    public function update(Request $request, Division $division)
    {
        $validated = $request->validate([
            'name' => 'required|unique:divisions,name,' . $division->id,
            'description' => 'required',
        ]);

        $division->update($validated);

        return response()->json([
            'message' => 'Division updated'
        ]);
    }

    // DELETE
    public function destroy(Division $division)
    {
        $division->delete();

        return response()->json([
            'message' => 'Division deleted'
        ]);
    }
}

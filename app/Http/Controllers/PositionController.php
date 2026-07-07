<?php

namespace App\Http\Controllers;

use App\Models\Position;
use App\Models\Department;
use Illuminate\Http\Request;

class PositionController extends Controller
{
    public function index()
    {
        $departments = Department::all();

        return view('positions.index', compact('departments'));
    }

    public function data(Request $request)
    {
        $query = Position::query()
            ->select(
                'positions.*'
            );

        // 🔍 SEARCH GLOBAL
        if ($request->filled('search')) {
            $search = $request->search;

            $query->where(function ($q) use ($search) {
                $q->where('positions.name', 'like', "%{$search}%");
            });
        }

        // 📄 PAGINATION (WAJIB untuk UI kamu)
        $perPage = $request->per_page ?? 10;

        $data = $query
            ->orderBy('positions.name', 'asc')
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
            'name' => 'required|unique:positions,name',
            'description' => 'nullable|string',
        ]);

        $div = Position::create($validated);

        return response()->json([
            'message' => 'Position created',
            'data' => $div
        ]);
    }

    // EDIT GET DATA
    public function edit(Position $position)
    {
        return response()->json($position);
    }

    // UPDATE
    public function update(Request $request, Position $position)
    {
        $validated = $request->validate([
            'name' => 'required|unique:positions,name,' . $position->id,
            'description' => 'nullable|string',
        ]);

        $position->update($validated);

        return response()->json([
            'message' => 'Position updated'
        ]);
    }

    // DELETE
    public function destroy(Position $position)
    {
        $position->delete();

        return response()->json([
            'message' => 'Position deleted'
        ]);
    }
}

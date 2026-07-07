<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Opd;
use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    public function search(Request $request)
    {
        $q = $request->query('q', '');
        $page = max(1, (int)$request->query('page', 1));
        $perPage = (int)$request->query('per_page', 20);

        $query = User::query();

        if ($q !== '') {
            $query->where('name', 'like', "%{$q}%");
        }

        $total = $query->count();

        $items = $query->orderBy('name')
            ->skip(($page - 1) * $perPage)
            ->take($perPage)
            ->get(['id', 'name']);

        $results = $items->map(function ($it) {
            return [
                'id' => $it->id,
                'text' => $it->name,
                // tambahkan field lain kalau perlu, mis. 'desc'
            ];
        })->toArray();

        return response()->json([
            'results' => $results,
            'pagination' => [
                'more' => ($page * $perPage) < $total
            ]
        ]);
    }

    public function search_opd_pengawas(Request $request)
    {

        $q = $request->query('q', '');
        $page = max(1, (int)$request->query('page', 1));
        $perPage = (int)$request->query('per_page', 20);

        $query = User::with('opds');

        // Filter berdasarkan nama user atau nama OPD jika ingin
        if ($q !== '') {
            $query->where('name', 'like', "%{$q}%")
                ->orWhereHas('opds', function ($qOpd) use ($q) {
                    $qOpd->where('name', 'like', "%{$q}%");
                });
        }

        $total = $query->count();

        $items = $query->orderBy('name')
            ->skip(($page - 1) * $perPage)
            ->take($perPage)
            ->get();

        $results = $items->map(function ($user) {
            return [
                'id' => $user->id,
                'text' => $user->name,
                'opds' => $user->opds->pluck('name')->toArray(), // daftar OPD user
            ];
        })->toArray();

        return response()->json([
            'results' => $results,
            'pagination' => [
                'more' => ($page * $perPage) < $total
            ]
        ]);
    }
}

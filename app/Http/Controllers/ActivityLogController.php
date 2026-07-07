<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Activitylog\Models\Activity;
use Carbon\Carbon;
use Symfony\Component\HttpFoundation\StreamedResponse;

class ActivityLogController extends Controller
{
    public function index(Request $request)
    {
        $logs = Activity::with('causer')

            ->when(
                $request->user_id,
                fn($q) =>
                $q->where('causer_id', $request->user_id)
            )

            ->when($request->search, function ($q) use ($request) {
                $q->where(function ($query) use ($request) {
                    $query->where('event', 'like', '%' . $request->search . '%')
                        ->orWhere('description', 'like', '%' . $request->search . '%')
                        ->orWhereHas('causer', function ($sub) use ($request) {
                            $sub->where('name', 'like', '%' . $request->search . '%');
                        });
                });
            })

            ->when(
                $request->start_date,
                fn($q) =>
                $q->whereDate('created_at', '>=', $request->start_date)
            )

            ->when(
                $request->end_date,
                fn($q) =>
                $q->whereDate('created_at', '<=', $request->end_date)
            )

            ->latest()
            ->paginate(10)
            ->withQueryString();


        // ✅ Versi JOIN (lebih optimal)
        $causers = User::select('users.id', 'users.name')
            ->join('activity_log', 'activity_log.causer_id', '=', 'users.id')
            ->whereNotNull('activity_log.causer_id')
            ->distinct()
            ->orderBy('users.name')
            ->get();

        return view('activity.index', compact('logs', 'causers'));
    }


    public function export(Request $request)
    {
        $fileName = 'activity_log_' . now()->format('Ymd_His') . '.csv';

        $logs = Activity::with('causer')

            ->when(
                $request->user_id,
                fn($q) =>
                $q->where('causer_id', $request->user_id)
            )

            ->when($request->search, function ($q) use ($request) {
                $q->where(function ($query) use ($request) {
                    $query->where('event', 'like', '%' . $request->search . '%')
                        ->orWhere('description', 'like', '%' . $request->search . '%')
                        ->orWhereHas('causer', function ($sub) use ($request) {
                            $sub->where('name', 'like', '%' . $request->search . '%');
                        });
                });
            })

            ->when(
                $request->start_date,
                fn($q) =>
                $q->whereDate('created_at', '>=', $request->start_date)
            )

            ->when(
                $request->end_date,
                fn($q) =>
                $q->whereDate('created_at', '<=', $request->end_date)
            )

            ->latest()
            ->get();

        $response = new StreamedResponse(function () use ($logs) {

            $handle = fopen('php://output', 'w');

            // Header CSV
            fputcsv($handle, [
                'Tanggal',
                'User',
                'Event',
                'Description',
                'IP Address',
            ]);

            foreach ($logs as $log) {
                fputcsv($handle, [
                    $log->created_at,
                    $log->causer->name ?? '-',
                    $log->event,
                    $log->description,
                    $log->properties['ip'] ?? '-',
                ]);
            }

            fclose($handle);
        });

        $response->headers->set('Content-Type', 'text/csv');
        $response->headers->set('Content-Disposition', "attachment; filename={$fileName}");

        return $response;
    }
}

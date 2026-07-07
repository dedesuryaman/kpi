<?php

namespace App\Http\Controllers;

use App\Models\AbcResult;
use App\Models\Period;
use App\Services\ABC\AbcResultService;
use App\Services\ABC\ArtificialBeeColony;
use App\Services\ABC\EmployeePerformanceService;
use Illuminate\Http\Request;

class AbcController extends Controller
{
    /**
     * Halaman utama ABC
     */

    public function index()
    {
        $periods = Period::orderByDesc('id')->get();

        $results = AbcResult::with([
            'period',
            'details.kpiMaster'
        ])
            ->latest()
            ->get();

        return view('abc.index', compact(
            'periods',
            'results'
        ));
    }

    /**
     * Jalankan optimasi ABC
     */
    public function run(
        Request $request,
        AbcResultService $abcResultService,
        EmployeePerformanceService $employeePerformanceService
    ) {

        $validated = $request->validate([

            'period_id' => ['required', 'exists:periods,id'],

            'population_size' => ['required', 'integer', 'min:5'],

            'max_iteration' => ['required', 'integer', 'min:1'],

            'limit_trial' => ['required', 'integer', 'min:1'],

        ]);

        $periodId = $validated['period_id'];

        /*
        |--------------------------------------------------------------------------
        | Run Artificial Bee Colony
        |--------------------------------------------------------------------------
        */

        $abc = new ArtificialBeeColony(

            $validated['population_size'],

            $validated['max_iteration'],

            $validated['limit_trial']

        );

        $result = $abc->run($periodId);



        /*
        |--------------------------------------------------------------------------
        | Simpan hasil optimasi ABC
        |--------------------------------------------------------------------------
        */

        $abcResultService->store($periodId, $result);

        /*
        |--------------------------------------------------------------------------
        | Hitung Employee Performance
        |--------------------------------------------------------------------------
        */

        $employeePerformanceService->generate($periodId);

        return redirect()
            ->route('abc.show', $periodId)
            ->with(
                'success',
                'Artificial Bee Colony optimization completed successfully.'
            );
    }

    /**
     * Tampilkan hasil optimasi
     */
    public function show(AbcResult $result)
    {
        $result->load([
            'period',
            'details.kpiMaster'
        ]);

        return view('abc.show', compact('result'));
    }
}

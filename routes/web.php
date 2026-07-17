<?php

use App\Http\Controllers\AbcController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\DivisionController;
use App\Http\Controllers\DivisionPerformanceController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\KPI\KpiAssessmentController;
use App\Http\Controllers\KPI\KpiIndicatorController;
use App\Http\Controllers\KPI\KpiMasterController;
use App\Http\Controllers\KPI\KpiPeriodController;
use App\Http\Controllers\KPI\KpiSetupController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\PositionController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\Karyawan\MyAssessmentController;
use App\Http\Controllers\Karyawan\KpiResultController;
use App\Http\Controllers\Karyawan\MyProfileController;
use App\Http\Controllers\Karyawan\PerformanceHistoryController;
use App\Http\Controllers\MdpController;
use App\Http\Controllers\Report\EmployeePerformanceReportController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\Reports\AbcReportController;
use App\Http\Controllers\Reports\AiReportController;
use App\Http\Controllers\Reports\AssessmentReportController;
use App\Http\Controllers\Reports\ExecutiveReportController;
use App\Http\Controllers\Reports\MainReportController;
use App\Http\Controllers\Reports\MasterReportController;
use App\Http\Controllers\Reports\MdpReportController;
use App\Http\Controllers\Reports\PerformanceReportController;
use App\Http\Controllers\Reports\RewardReportController;
use App\Http\Controllers\Reports\StatisticsReportController;
use App\Http\Controllers\RewardPunishmentController;

use App\Models\KpiScore;
use App\Models\KpiTarget;
use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//     return view('welcome');
// });

Route::redirect('/', '/login');

Route::middleware('auth')->group(function () {

    //Route::resources(['profile' => ProfileController::class]);

    Route::get('/profile', [ProfileController::class, 'index'])->name('profile.index');

    // Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');

    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');

    Route::put('/profile/password', [ProfileController::class, 'password'])->name('profile.password');


    //dasbord nanti dibedakan berdasarkan role
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::middleware(['auth', 'role:super-admin|hrd'])->group(function () {

        Route::get('employees-data', [EmployeeController::class, 'data'])->name('employees.data');
        Route::prefix('/employees')->group(function () {
            Route::get('/', [EmployeeController::class, 'index'])->name('employees.index');
            Route::get('/create', [EmployeeController::class, 'create'])->name('employees.create');
            Route::post('/store', [EmployeeController::class, 'store'])->name('employees.store');
            Route::get('/{id}/edit', [EmployeeController::class, 'edit'])->name('employees.edit');
            Route::put('/{id}', [EmployeeController::class, 'update'])->name('employees.update');
            Route::delete('/{id}', [EmployeeController::class, 'destroy'])->name('employees.destroy');
        });


        Route::get('divisions-data', [DivisionController::class, 'data'])->name('divisions.data');
        Route::resource('divisions', DivisionController::class);


        Route::get('departments-data', [DepartmentController::class, 'data'])->name('departments.data');
        Route::resource('departments', DepartmentController::class);


        Route::get('positions-data', [PositionController::class, 'data'])->name('positions.data');
        Route::resource('positions', PositionController::class);


        Route::prefix('kpi/period')->group(function () {
            Route::get('/', [KpiPeriodController::class, 'index'])->name('kpi.period.index');
            Route::post('/', [KpiPeriodController::class, 'store']);
            Route::get('/{id}/edit', [KpiPeriodController::class, 'edit']);
            Route::put('/{id}', [KpiPeriodController::class, 'update']);
            Route::delete('/{id}', [KpiPeriodController::class, 'destroy']);
        });

        Route::prefix('kpi/master')->group(function () {
            Route::get('/', [KpiMasterController::class, 'index'])->name('kpi.master.index');
            Route::get('/create', [KpiMasterController::class, 'create'])->name('kpi.master.create');
            Route::post('/', [KpiMasterController::class, 'store'])->name('kpi.master.store');
            Route::get('/{id}/edit', [KpiMasterController::class, 'edit'])->name('kpi.master.edit');
            Route::put('/{id}', [KpiMasterController::class, 'update'])->name('kpi.master.update');
            Route::delete('/{id}', [KpiMasterController::class, 'destroy'])->name('kpi.master.destroy');
        });

        Route::prefix('kpi/indicator')->group(function () {
            Route::get('/', [KpiIndicatorController::class, 'index'])->name('kpi.indicator.index');
            Route::get('/create', [KpiIndicatorController::class, 'create'])->name('kpi.indicator.create');
            Route::post('/store', [KpiIndicatorController::class, 'store'])->name('kpi.indicator.store');
            Route::get('/{id}/edit', [KpiIndicatorController::class, 'edit'])->name('kpi.indicator.edit');
            Route::put('/{id}', [KpiIndicatorController::class, 'update'])->name('kpi.indicator.update');
            Route::delete('/{id}', [KpiIndicatorController::class, 'destroy'])->name('kpi.indicator.destroy');
        });

        Route::prefix('kpi/score')->group(function () {
            Route::get('/', [KpiScore::class, 'index'])->name('kpi.score.index');
            Route::post('/', [KpiScore::class, 'store']);
            Route::get('/{id}/edit', [KpiScore::class, 'edit']);
            Route::put('/{id}', [KpiScore::class, 'update']);
            Route::delete('/{id}', [KpiScore::class, 'destroy']);
        });

        Route::prefix('kpi/target')->group(function () {
            Route::get('/', [KpiTarget::class, 'index'])->name('kpi.target.index');
            Route::post('/', [KpiTarget::class, 'store']);
            Route::get('/{id}/edit', [KpiTarget::class, 'edit']);
            Route::put('/{id}', [KpiTarget::class, 'update']);
            Route::delete('/{id}', [KpiTarget::class, 'destroy']);
        });

        Route::prefix('kpi/assessments')->group(function () {
            Route::get('/', [KpiAssessmentController::class, 'index'])->name('kpi.assessments.index');
            Route::get('/create', [KpiAssessmentController::class, 'create'])->name('kpi.assessments.create');
            Route::post('/store', [KpiAssessmentController::class, 'store'])->name('kpi.assessments.store');
            Route::delete('/{id}', [KpiAssessmentController::class, 'destroy'])->name('kpi.assessments.destroy');
            Route::get('/{employee}/{period}', [KpiAssessmentController::class, 'show'])->name('kpi.assessments.show');
            Route::get('/{employee}/{period}/edit', [KpiAssessmentController::class, 'edit'])->name('kpi.assessments.edit');
            Route::put('/{employee}/{period}', [KpiAssessmentController::class, 'update'])->name('kpi.assessments.update');
        });


        Route::prefix('kpi/result')->group(function () {

            Route::get('/', [KpiResultController::class, 'resultIndex'])
                ->name('kpi-results.index');

            Route::get('/{result}', [KpiResultController::class, 'resultShow'])
                ->name('kpi-results.show');

            Route::post('/{result}/approve', [KpiResultController::class, 'resultApprove'])
                ->name('kpi-results.approve');

            Route::post('/{result}/reject', [KpiResultController::class, 'resultReject'])
                ->name('kpi-results.reject');


            Route::post(
                '/{result}/generate-ai',
                [KpiResultController::class, 'generateAI']
            )->name('kpi-results.generate-ai');
        });

        Route::prefix('kpi/ranking')->group(function () {
            Route::get('/', [KpiTarget::class, 'index'])->name('kpi.ranking.index');
            Route::post('/', [KpiTarget::class, 'store']);
            Route::get('/{id}/edit', [KpiTarget::class, 'edit']);
            Route::put('/{id}', [KpiTarget::class, 'update']);
            Route::delete('/{id}', [KpiTarget::class, 'destroy']);
        });


        Route::prefix('kpi/report')->group(function () {
            Route::get('/', [KpiTarget::class, 'index'])->name('kpi.report.index');
            Route::post('/', [KpiTarget::class, 'store']);
            Route::get('/{id}/edit', [KpiTarget::class, 'edit']);
            Route::put('/{id}', [KpiTarget::class, 'update']);
            Route::delete('/{id}', [KpiTarget::class, 'destroy']);
        });


        Route::prefix('reports')->group(function () {

            Route::get(
                'employee-performance',
                [EmployeePerformanceReportController::class, 'index']
            )->name('reports.employee-performance.index');

            Route::get(
                'employee-performance/table',
                [EmployeePerformanceReportController::class, 'table']
            )->name('reports.employee-performance.table');


            Route::get(
                'employee-performance/print',
                [EmployeePerformanceReportController::class, 'print']
            )->name('reports.employee-performance.print');

            Route::get(
                'reports/employee-performance/pdf',
                [EmployeePerformanceReportController::class, 'pdf']
            )->name('reports.employee-performance.pdf');

            Route::get(
                'employee-performance/excel',
                [EmployeePerformanceReportController::class, 'excel']
            )->name('reports.employee-performance.excel');
        });
        ///baru

        /*
        |--------------------------------------------------------------------------
        | Reports & Export
        |--------------------------------------------------------------------------
        */

        Route::prefix('reports')
            ->name('reports.')
            ->middleware(['auth'])
            ->group(function () {

                /*
        |--------------------------------------------------------------------------
        | Dashboard Report Center
        |--------------------------------------------------------------------------
        */
                Route::get('/', [MainReportController::class, 'index'])
                    ->name('index');

                /*
        |--------------------------------------------------------------------------
        | Master Data
        |--------------------------------------------------------------------------
        */
                Route::prefix('master')->name('master.')->group(function () {
                    Route::get('/employees', [MasterReportController::class, 'employees'])->name('employees');
                    Route::get('/employees/excel', [MasterReportController::class, 'employeesExcel'])
                        ->name('employees.excel');
                    Route::get('/employees/pdf', [MasterReportController::class, 'employeesPdf'])
                        ->name('employees.pdf');

                    Route::get('/departments', [MasterReportController::class, 'departments'])->name('departments');
                    Route::get('/departments/excel', [MasterReportController::class, 'departmentsExcel'])
                        ->name('departments.excel');
                    Route::get('/departments/pdf', [MasterReportController::class, 'departmentsPdf'])
                        ->name('departments.pdf');

                    Route::get('/divisions', [MasterReportController::class, 'divisions'])->name('divisions');
                    Route::get('/divisions/excel', [MasterReportController::class, 'divisionsExcel'])
                        ->name('divisions.excel');
                    Route::get('/divisions/pdf', [MasterReportController::class, 'divisionsPdf'])
                        ->name('divisions.pdf');

                    Route::get('/positions', [MasterReportController::class, 'positions'])->name('positions');
                    Route::get('/positions/excel', [MasterReportController::class, 'positionsExcel'])
                        ->name('positions.excel');
                    Route::get('/positions/pdf', [MasterReportController::class, 'positionsPdf'])
                        ->name('positions.pdf');

                    Route::get('/kpi-master', [MasterReportController::class, 'kpiMaster'])->name('kpi-master');
                    Route::get('/kpi-master/excel', [MasterReportController::class, 'kpiMasterExcel'])
                        ->name('kpi-master.excel');
                    Route::get('/kpi-master/pdf', [MasterReportController::class, 'kpiMasterPdf'])
                        ->name('kpi-master.pdf');

                    Route::get('/kpi-indicators', [MasterReportController::class, 'kpiIndicators'])->name('kpi-indicators');
                    Route::get('/kpi-indicators/excel', [MasterReportController::class, 'kpiIndicatorsExcel'])
                        ->name('kpi-indicators.excel');
                    Route::get('/kpi-indicators/pdf', [MasterReportController::class, 'kpiIndicatorsPdf'])
                        ->name('kpi-indicators.pdf');

                    Route::get('/kpi-targets', [MasterReportController::class, 'kpiTargets'])->name('kpi-targets');
                    Route::get('/kpi-targets/excel', [MasterReportController::class, 'kpiTargetsExcel'])
                        ->name('kpi-targets.excel');
                    Route::get('/kpi-targets/pdf', [MasterReportController::class, 'kpiTargetsPdf'])
                        ->name('kpi-targets.pdf');

                    Route::get('/periods', [MasterReportController::class, 'periods'])->name('periods');
                });

                /*
        |--------------------------------------------------------------------------
        | KPI Assessment
        |--------------------------------------------------------------------------
        */
                Route::prefix('assessment')->name('assessment.')->group(function () {
                    Route::get('/summary', [AssessmentReportController::class, 'summary'])->name('summary');
                    Route::get('/summary/excel', [AssessmentReportController::class, 'assessmentExcel'])
                        ->name('summary.excel');

                    Route::get('/summary/pdf', [AssessmentReportController::class, 'assessmentPdf'])
                        ->name('summary.pdf');

                    Route::get('/employee-scores', [AssessmentReportController::class, 'employeeScores'])->name('employee-scores');
                    Route::get(
                        '/employee-scores/excel',
                        [AssessmentReportController::class, 'employeeScoresExcel']
                    )->name('employee-scores.excel');

                    Route::get(
                        '/employee-scores/pdf',
                        [AssessmentReportController::class, 'employeeScoresPdf']
                    )->name('employee-scores.pdf');

                    Route::get('/department-scores', [AssessmentReportController::class, 'departmentScores'])->name('department-scores');
                    Route::get(
                        '/department-scores/excel',
                        [AssessmentReportController::class, 'departmentScoresExcel']
                    )->name('department-scores.excel');

                    Route::get(
                        '/department-scores/pdf',
                        [AssessmentReportController::class, 'departmentScoresPdf']
                    )->name('department-scores.pdf');

                    Route::get('/completion', [AssessmentReportController::class, 'completion'])->name('completion');
                    Route::get(
                        '/completion/excel',
                        [AssessmentReportController::class, 'assessmentCompletionExcel']
                    )->name('completion.excel');

                    Route::get(
                        '/completion/pdf',
                        [AssessmentReportController::class, 'assessmentCompletionPdf']
                    )->name('completion.pdf');

                    Route::get('/monthly', [AssessmentReportController::class, 'monthly'])->name('monthly');
                    Route::get('/annual', [AssessmentReportController::class, 'annual'])->name('annual');
                });

                /*
        |--------------------------------------------------------------------------
        | Employee Performance
        |--------------------------------------------------------------------------
        */
                Route::prefix('performance')->name('performance.')->group(function () {
                    Route::get('/summary', [PerformanceReportController::class, 'summary'])->name('summary');
                    Route::get(
                        '/summary/excel',
                        [PerformanceReportController::class, 'summaryExcel']
                    )->name('summary.excel');

                    Route::get(
                        '/summary/pdf',
                        [PerformanceReportController::class, 'summaryPdf']
                    )->name('summary.pdf');

                    Route::get('/detail', [PerformanceReportController::class, 'detail'])->name('detail');
                    Route::get('/ranking', [PerformanceReportController::class, 'ranking'])->name('ranking');
                    Route::get(
                        '/ranking/excel',
                        [PerformanceReportController::class, 'rankingExcel']
                    )->name('ranking.excel');

                    Route::get(
                        '/ranking/pdf',
                        [PerformanceReportController::class, 'rankingPdf']
                    )->name('ranking.pdf');


                    Route::get('/top', [PerformanceReportController::class, 'top'])->name('top');
                    Route::get('/lowest', [PerformanceReportController::class, 'lowest'])->name('lowest');
                    Route::get('/department', [PerformanceReportController::class, 'department'])->name('department');
                });

                /*
        |--------------------------------------------------------------------------
        | ABC Optimization
        |--------------------------------------------------------------------------
        */
                Route::prefix('abc')->name('abc.')->group(function () {
                    Route::get('/summary', [AbcReportController::class, 'summary'])->name('summary');
                    Route::get('/fitness', [AbcReportController::class, 'fitness'])->name('fitness');
                    Route::get('/iterations', [AbcReportController::class, 'iterations'])->name('iterations');
                    Route::get('/best-solution', [AbcReportController::class, 'bestSolution'])->name('best-solution');
                });

                /*
        |--------------------------------------------------------------------------
        | MDP Analysis
        |--------------------------------------------------------------------------
        */
                Route::prefix('mdp')->name('mdp.')->group(function () {
                    Route::get('/summary', [MdpReportController::class, 'summary'])->name('summary');
                    Route::get('/states', [MdpReportController::class, 'states'])->name('states');
                    Route::get('/actions', [MdpReportController::class, 'actions'])->name('actions');
                    Route::get('/rewards', [MdpReportController::class, 'rewards'])->name('rewards');
                    Route::get('/transitions', [MdpReportController::class, 'transitions'])->name('transitions');
                });

                /*
        |--------------------------------------------------------------------------
        | AI Analysis
        |--------------------------------------------------------------------------
        */
                Route::prefix('ai')->name('ai.')->group(function () {
                    Route::get('/summary', [AiReportController::class, 'summary'])->name('summary');
                    Route::get('/individual', [AiReportController::class, 'individual'])->name('individual');
                    Route::get('/department', [AiReportController::class, 'department'])->name('department');
                    Route::get('/recommendations', [AiReportController::class, 'recommendations'])->name('recommendations');
                });

                /*
        |--------------------------------------------------------------------------
        | Reward & Punishment
        |--------------------------------------------------------------------------
        */
                Route::prefix('reward')->name('reward.')->group(function () {
                    Route::get('/reward', [RewardReportController::class, 'reward'])->name('reward');
                    Route::get('/punishment', [RewardReportController::class, 'punishment'])->name('punishment');
                    Route::get('/approval', [RewardReportController::class, 'approval'])->name('approval');
                    Route::get('/statistics', [RewardReportController::class, 'statistics'])->name('statistics');
                });

                /*
        |--------------------------------------------------------------------------
        | Statistics
        |--------------------------------------------------------------------------
        */
                Route::prefix('statistics')->name('statistics.')->group(function () {
                    Route::get('/attendance', [StatisticsReportController::class, 'attendance'])->name('attendance');
                    Route::get('/productivity', [StatisticsReportController::class, 'productivity'])->name('productivity');
                    Route::get('/quality', [StatisticsReportController::class, 'quality'])->name('quality');
                    Route::get('/discipline', [StatisticsReportController::class, 'discipline'])->name('discipline');
                    Route::get('/innovation', [StatisticsReportController::class, 'innovation'])->name('innovation');
                    Route::get('/department-comparison', [StatisticsReportController::class, 'departmentComparison'])->name('department-comparison');
                    Route::get('/period-comparison', [StatisticsReportController::class, 'periodComparison'])->name('period-comparison');
                });

                /*
        |--------------------------------------------------------------------------
        | Executive Reports
        |--------------------------------------------------------------------------
        */
                Route::prefix('executive')->name('executive.')->group(function () {
                    Route::get('/dashboard', [ExecutiveReportController::class, 'dashboard'])->name('dashboard');
                    Route::get('/company-kpi', [ExecutiveReportController::class, 'companyKpi'])->name('company-kpi');
                    Route::get('/performance-summary', [ExecutiveReportController::class, 'performanceSummary'])->name('performance-summary');
                    Route::get('/strategic-kpi', [ExecutiveReportController::class, 'strategicKpi'])->name('strategic-kpi');
                });
            });



        Route::prefix('division-performance')
            ->name('division-performance.')
            ->group(function () {

                Route::get(
                    '/',
                    [DivisionPerformanceController::class, 'index']
                )->name('index');

                Route::get(
                    '/{department}',
                    [DivisionPerformanceController::class, 'show']
                )->name('show');
            });
    });





    Route::middleware(['auth', 'role:hrd|director|supervisor|employee'])->prefix('my-assessment')->group(function () {
        Route::get('/', [MyAssessmentController::class, 'index'])->name('my-assessment.index');
        Route::get('/{period}', [MyAssessmentController::class, 'show'])->name('my-assessment.show');
    });

    Route::middleware(['auth', 'role:hrd|director|supervisor|employee'])->prefix('my-result')->group(function () {

        Route::get('/', [KpiResultController::class, 'index'])
            ->name('my-result.index');

        Route::get('/{period}', [KpiResultController::class, 'show'])
            ->name('my-result.show');
    });

    Route::middleware(['auth', 'role:hrd|director|supervisor|employee'])
        ->prefix('performance-history')
        ->group(function () {

            Route::get('/', [PerformanceHistoryController::class, 'index'])
                ->name('performance-history.index');
        });


    Route::prefix('my-profile')
        ->middleware(['auth', 'role:hrd|director|supervisor|employee'])
        ->group(function () {

            Route::get('/', [MyProfileController::class, 'index'])
                ->name('my-profile.index');

            Route::put('/password', [MyProfileController::class, 'updatePassword'])
                ->name('my-profile.password');
        });

    // Route::prefix('abc')
    //     ->middleware(['auth', 'role:super-admin|hrd'])
    //     ->group(function () {

    //         Route::get('/', [AbcController::class, 'index'])
    //             ->name('abc.index');

    //         Route::post('/run', [AbcController::class, 'run'])
    //             ->name('abc.run');

    //         Route::get('/{id}', [AbcController::class, 'show'])
    //             ->name('abc.show');
    //     });



    Route::prefix('abc')->name('abc.')->group(function () {

        Route::get('/', [AbcController::class, 'index'])
            ->name('index');

        Route::post('/run', [AbcController::class, 'run'])
            ->name('run');

        // Route::get('/{periodId}', [AbcController::class, 'show'])
        //     ->name('show');

        Route::get('/{result}', [AbcController::class, 'show'])
            ->name('show');
    });


    Route::prefix('mdp')
        ->name('mdp.')
        ->middleware(['auth'])
        ->group(function () {

            Route::get('/', [MdpController::class, 'index'])
                ->name('index');

            Route::post('/run', [MdpController::class, 'run'])
                ->name('run');

            Route::get('/result/{period}', [MdpController::class, 'show'])
                ->name('show');

            Route::delete('/period/{period}', [MdpController::class, 'destroy'])
                ->name('destroy');
            // Route::delete('/{id}', [MdpController::class, 'destroy'])
            //     ->name('destroy');
        });


    Route::middleware(['auth'])
        ->prefix('reward-punishment')
        ->name('reward-punishment.')
        ->group(function () {

            Route::get('/', [RewardPunishmentController::class, 'index'])
                ->name('index');

            Route::get('/reward', [RewardPunishmentController::class, 'reward'])
                ->name('reward');

            Route::get('/punishment', [RewardPunishmentController::class, 'punishment'])
                ->name('punishment');

            Route::get(
                '/punishment/{result}/review',
                [RewardPunishmentController::class, 'review']
            )->name('punishment.review');

            Route::post(
                '/punishment/{result}/review',
                [RewardPunishmentController::class, 'storeReview']
            )->name('punishment.review.store');


            Route::get('/history', [RewardPunishmentController::class, 'history'])
                ->name('history');

            Route::get('/{result}', [RewardPunishmentController::class, 'show'])
                ->name('show');

            Route::post(
                '/{result}/approve',
                [RewardPunishmentController::class, 'approve']
            )->name('approve');

            Route::post(
                '/{result}/reject',
                [RewardPunishmentController::class, 'reject']
            )->name('reject');

            Route::get(
                '/{result}/print',
                [RewardPunishmentController::class, 'print']
            )->name('print');
        });


    Route::middleware(['auth'])->prefix('reports')->name('reports.')->group(function () {

        // Halaman Report
        Route::get('/', [ReportController::class, 'index'])
            ->name('index');

        // KPI Report
        Route::get('/kpi', [ReportController::class, 'kpi'])
            ->name('kpi');

        // KPI Detail
        Route::get('/kpi-detail', [ReportController::class, 'kpiDetail'])
            ->name('kpi-detail');

        // Department Summary
        Route::get('/department-summary', [ReportController::class, 'departmentSummary'])
            ->name('department-summary');

        // Performance Ranking
        Route::get('/ranking', [ReportController::class, 'ranking'])
            ->name('ranking');

        // Reward Recommendation
        Route::get('/reward-recommendation', [ReportController::class, 'rewardRecommendation'])
            ->name('reward-recommendation');

        // Approval History
        Route::get('/approval-history', [ReportController::class, 'approvalHistory'])
            ->name('approval-history');

        // Top Performer
        Route::get('/top-performer', [ReportController::class, 'topPerformer'])
            ->name('top-performer');

        // Grade Distribution
        Route::get('/grade-distribution', [ReportController::class, 'gradeDistribution'])
            ->name('grade-distribution');

        // Reward Statistics
        Route::get('/reward-statistics', [ReportController::class, 'rewardStatistics'])
            ->name('reward-statistics');

        /*
    |--------------------------------------------------------------------------
    | Export
    |--------------------------------------------------------------------------
    */

        Route::get('/export/excel', [ReportController::class, 'exportExcel'])
            ->name('export.excel');

        Route::get('/export/pdf', [ReportController::class, 'exportPdf'])
            ->name('export.pdf');

        Route::get('/export/csv', [ReportController::class, 'exportCsv'])
            ->name('export.csv');
    });


    Route::middleware(['auth', 'role:karyawan'])->group(function () {});

    Route::middleware(['auth', 'role:director'])->group(function () {});
    Route::middleware(['auth', 'role:supervisor'])->group(function () {});


    Route::get('kpi/parameters', [KpiSetupController::class, 'parameters'])->name('kpi.parameters.index');
    Route::get('kpi/targets', [KpiSetupController::class, 'targets'])->name('kpi.targets.index');
    Route::resource('roles', RoleController::class);
    Route::resource('permissions', PermissionController::class);
    Route::resource('users', UserController::class);
    Route::post('/users/{user}/reset-password', [UserController::class, 'resetPassword'])->name('users.reset-password');
    Route::post('/users/{user}/toggle-status', [UserController::class, 'toggleStatus'])->name('users.toggle-status');
});

require __DIR__ . '/auth.php';

@extends('layouts.admin.app')

@section('title', 'Employee Performance Report')

@section('content')


<div class="container-fluid">

    <div class="mb-4">
        <h3 class="fw-bold">
            <i class="bi bi-file-earmark-bar-graph me-2"></i>
            Reports & Export Center
        </h3>
        <p class="text-muted">
            Export reports in Excel or PDF format.
        </p>
    </div>

    <div class="row g-4">

        <!-- Master Data -->
        <div class="col-lg-4">
            <div class="card shadow-sm h-100">
                <div class="card-header bg-primary text-white">
                    <i class="bi bi-people me-2"></i>
                    Master Data
                </div>
                <div class="list-group list-group-flush">
                    <a href="{{ route('reports.master.employees') }}" class="list-group-item">Employee List</a>
                    <a href="{{ route('reports.master.departments') }}" class="list-group-item">Department List</a>
                    <a href="{{ route('reports.master.divisions') }}" class="list-group-item">Division List</a>
                    <a href="{{ route('reports.master.positions') }}" class="list-group-item">Position List</a>
                    <a href="{{ route('reports.master.kpi-master') }}" class="list-group-item">KPI Master</a>
                    <a href="{{ route('reports.master.kpi-indicators') }}" class="list-group-item">KPI Indicators</a>
                    <a href="{{ route('reports.master.kpi-targets') }}" class="list-group-item">KPI Targets</a>
                    <!--a href="{{ route('reports.master.periods') }}" class="list-group-item">Periods</a-->
                </div>
            </div>
        </div>

        <!-- KPI Assessment -->
        <div class="col-lg-4">
            <div class="card shadow-sm h-100">
                <div class="card-header bg-success text-white">
                    <i class="bi bi-clipboard-check me-2"></i>
                    KPI Assessment
                </div>
                <div class="list-group list-group-flush">
                    <a href="{{ route('reports.assessment.summary') }}" class="list-group-item">Assessment Summary</a>
                    <a href="{{ route('reports.assessment.employee-scores') }}" class="list-group-item">Employee KPI
                        Scores</a>
                    <a href="{{ route('reports.assessment.department-scores') }}" class="list-group-item">Department KPI
                        Scores</a>
                    <a href="{{ route('reports.assessment.completion') }}" class="list-group-item">Completion
                        Status</a>
                    <!--a href="{{ route('reports.assessment.monthly') }}" class="list-group-item">Monthly Report</a>
                    <a href="{{ route('reports.assessment.annual') }}" class="list-group-item">Annual Report</a-->
                </div>
            </div>
        </div>

        <!-- Performance -->
        <div class="col-lg-4">
            <div class="card shadow-sm h-100">
                <div class="card-header bg-info text-white">
                    <i class="bi bi-graph-up-arrow me-2"></i>
                    Employee Performance
                </div>
                <div class="list-group list-group-flush">
                    <a href="{{ route('reports.performance.summary') }}" class="list-group-item">Performance Summary</a>
                    <!--a href="{{ route('reports.performance.detail') }}" class="list-group-item">Performance Detail</a-->
                    <a href="{{ route('reports.performance.ranking') }}" class="list-group-item">Performance Ranking</a>
                    <a href="{{ route('reports.performance.top') }}" class="list-group-item">Top Employees</a>
                    <a href="{{ route('reports.performance.lowest') }}" class="list-group-item">Lowest Employees</a>
                    <a href="{{ route('reports.performance.department') }}" class="list-group-item">Department
                        Performance</a>
                </div>
            </div>
        </div>

        <!-- ABC -->
        <div class="col-lg-4">
            <div class="card shadow-sm h-100">
                <div class="card-header bg-warning">
                    <i class="bi bi-bezier2 me-2"></i>
                    ABC Optimization
                </div>
                <div class="list-group list-group-flush">
                    <a href="{{ route('reports.abc.summary') }}" class="list-group-item">Optimization Summary</a>
                    <a href="{{ route('reports.abc.fitness') }}" class="list-group-item">Fitness Result</a>
                    <a href="{{ route('reports.abc.iterations') }}" class="list-group-item">Iteration History</a>
                    <a href="{{ route('reports.abc.best-solution') }}" class="list-group-item">Best Solution</a>
                </div>
            </div>
        </div>

        <!-- MDP -->
        <div class="col-lg-4">
            <div class="card shadow-sm h-100">
                <div class="card-header bg-secondary text-white">
                    <i class="bi bi-diagram-3 me-2"></i>
                    MDP Analysis
                </div>
                <div class="list-group list-group-flush">
                    <a href="{{ route('reports.mdp.summary') }}" class="list-group-item">Decision Summary</a>
                    <a href="{{ route('reports.mdp.states') }}" class="list-group-item">State Analysis</a>
                    <a href="{{ route('reports.mdp.actions') }}" class="list-group-item">Actions Analysis</a>
                    <a href="{{ route('reports.mdp.rewards') }}" class="list-group-item">Reward Analysis</a>
                    <a href="{{ route('reports.mdp.transitions') }}" class="list-group-item">Transition Probability</a>
                </div>
            </div>
        </div>

        <!-- AI -->
        <div class="col-lg-4">
            <div class="card shadow-sm h-100">
                <div class="card-header bg-dark text-white">
                    <i class="bi bi-stars me-2"></i>
                    AI Performance Analysis
                </div>
                <div class="list-group list-group-flush">
                    <a href="{{ route('reports.ai.summary') }}" class="list-group-item">AI Summary</a>
                    <a href="{{ route('reports.ai.individual') }}" class="list-group-item">Individual Analysis</a>
                    <a href="{{ route('reports.ai.department') }}" class="list-group-item">Department Analysis</a>
                    <a href="{{ route('reports.ai.recommendations') }}" class="list-group-item">Development
                        Recommendation</a>
                </div>
            </div>
        </div>

        <!-- Reward -->
        <!--div class="col-lg-6">
            <div class="card shadow-sm h-100">
                <div class="card-header bg-danger text-white">
                    <i class="bi bi-award me-2"></i>
                    Reward & Punishment
                </div>
                <div class="list-group list-group-flush">
                    <a href="#" class="list-group-item">Reward Report</a>
                    <a href="#" class="list-group-item">Punishment Report</a>
                    <a href="#" class="list-group-item">Approval Status</a>
                    <a href="#" class="list-group-item">Statistics</a>
                </div>
            </div>
        </div-->

        <!-- Executive -->
        <!--div class="col-lg-6">
            <div class="card shadow-sm h-100">
                <div class="card-header bg-primary text-white">
                    <i class="bi bi-briefcase me-2"></i>
                    Executive Reports
                </div>
                <div class="list-group list-group-flush">
                    <a href="#" class="list-group-item">Executive Dashboard</a>
                    <a href="#" class="list-group-item">Company KPI Report</a>
                    <a href="#" class="list-group-item">Performance Summary</a>
                    <a href="#" class="list-group-item">Strategic KPI Report</a>
                </div>
            </div>
        </div-->

    </div>

</div>


@endsection

@push('scripts')

@endpush
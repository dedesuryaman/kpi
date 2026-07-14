@extends('layouts.admin.app')

@section('title', 'Employee Performance Detail Report')

@section('content')

<div class="container-fluid">

    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>

            <h4 class="fw-bold mb-1">
                <i class="bi bi-person-lines-fill text-primary me-2"></i>
                Employee Performance Detail Report
            </h4>

            <p class="text-muted mb-0">
                Detailed employee performance report based on KPI assessment, ABC optimization, MDP analysis, AI
                recommendation, and reward recommendation.
            </p>

        </div>

        <div class="btn-group">

            <a href="#" class="btn btn-success">
                <i class="bi bi-file-earmark-excel me-1"></i>
                Excel
            </a>

            <a href="#" class="btn btn-danger">
                <i class="bi bi-file-earmark-pdf me-1"></i>
                PDF
            </a>

            <button class="btn btn-secondary" onclick="window.print()">

                <i class="bi bi-printer me-1"></i>
                Print

            </button>

        </div>

    </div>

    <form method="GET">

        <div class="card shadow-sm mb-4">

            <div class="card-body">

                <div class="row g-3">

                    <div class="col-md-3">

                        <label class="form-label">
                            Period
                        </label>

                        <select class="form-select" name="period_id">

                            @foreach($periods as $period)

                            <option value="{{ $period->id }}" @selected($selectedPeriod==$period->id)>

                                {{ $period->name }}

                            </option>

                            @endforeach

                        </select>

                    </div>

                    <div class="col-md-3">

                        <label class="form-label">
                            Department
                        </label>

                        <select class="form-select" name="department_id">

                            <option value="">
                                All Department
                            </option>

                            @foreach($departments as $department)

                            <option value="{{ $department->id }}" @selected($selectedDepartment==$department->id)>

                                {{ $department->name }}

                            </option>

                            @endforeach

                        </select>

                    </div>

                    <div class="col-md-4">

                        <label class="form-label">
                            Employee
                        </label>

                        <input type="text" class="form-control" name="keyword" value="{{ request('keyword') }}"
                            placeholder="Search employee...">

                    </div>

                    <div class="col-md-2 d-grid">

                        <label class="form-label">&nbsp;</label>

                        <button class="btn btn-primary">

                            <i class="bi bi-search me-1"></i>

                            Filter

                        </button>

                    </div>

                </div>

            </div>

        </div>

    </form>

    <div class="card shadow-sm">

        <div class="card-body">

            <div class="table-responsive">

                <table class="table table-hover table-bordered align-middle">

                    <thead class="table-light">

                        <tr>

                            <th width="60">#</th>
                            <th>Employee</th>
                            <th>Department</th>
                            <th>Position</th>
                            <th class="text-center">Final Score</th>
                            <th class="text-center">Category</th>
                            <th class="text-center">ABC Fitness</th>
                            <th class="text-center">MDP State</th>
                            <th>AI Recommendation</th>
                            <th class="text-center">Reward</th>

                        </tr>

                    </thead>

                    <tbody>

                        @forelse($results as $result)

                        <tr>

                            <td>

                                {{ $results->firstItem() + $loop->index }}

                            </td>

                            <td>

                                <strong>

                                    {{ $result->employee->name }}

                                </strong>

                            </td>

                            <td>

                                {{ $result->employee->department->name ?? '-' }}

                            </td>

                            <td>

                                {{ $result->employee->position->name ?? '-' }}

                            </td>

                            <td class="text-center">

                                <span class="badge bg-primary fs-6">

                                    {{ number_format($result->final_score,2) }}

                                </span>

                            </td>

                            <td class="text-center">

                                @php($score = $result->final_score)

                                @if($score >= 90)

                                <span class="badge bg-success">Excellent</span>

                                @elseif($score >= 80)

                                <span class="badge bg-primary">Very Good</span>

                                @elseif($score >= 70)

                                <span class="badge bg-info">Good</span>

                                @elseif($score >= 60)

                                <span class="badge bg-warning text-dark">Fair</span>

                                @else

                                <span class="badge bg-danger">Poor</span>

                                @endif

                            </td>

                            <td class="text-center">

                                {{ number_format($result->fitness_score ?? 0,4) }}

                            </td>

                            <td class="text-center">

                                {{ $result->mdp_state ?? '-' }}

                            </td>

                            <td style="min-width:250px">

                                {{ Str::limit($result->latestRewardRecommendation->ai_analysis ?? '-',100) }}

                            </td>

                            <td class="text-center">


                                @if(optional($result->latestRewardRecommendation)->recommendation === 'Reward')

                                <span class="badge bg-success">
                                    Reward
                                </span>

                                @elseif(optional($result->latestRewardRecommendation)->recommendation === 'Punishment')

                                <span class="badge bg-danger">
                                    Punishment
                                </span>

                                @else

                                <span class="badge bg-secondary">
                                    No Recommendation
                                </span>

                                @endif

                            </td>

                        </tr>

                        @empty

                        <tr>

                            <td colspan="10" class="text-center py-5">

                                <i class="bi bi-inbox display-5 text-muted"></i>

                                <div class="mt-3">

                                    No performance data available.

                                </div>

                            </td>

                        </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>

            <div class="mt-3">

                {{ $results->links() }}

            </div>

        </div>

    </div>

</div>

@endsection
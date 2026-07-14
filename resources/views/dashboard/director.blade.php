@extends('layouts.admin.app')

@section('title','Director Dashboard')

@section('content')

<div class="container-fluid">

    <!-- Header -->
    <div class="row mb-4">

        <div class="col-md-8">

            <h3 class="fw-bold mb-1">
                Executive Dashboard
            </h3>

            <p class="text-muted mb-0">
                Company Performance Overview
            </p>

        </div>

        <div class="col-md-4 text-md-end">

            <span class="badge bg-primary fs-6 px-3 py-2">
                {{ now()->format('d F Y') }}
            </span>

        </div>

    </div>

    <!-- Executive Cards -->

    <div class="row g-4 mb-4">

        <div class="col-xl-3 col-md-6">

            <div class="card shadow-sm border-0 h-100">

                <div class="card-body">

                    <div class="d-flex justify-content-between">

                        <div>

                            <small class="text-muted">
                                Company KPI Score
                            </small>

                            <h2 class="fw-bold text-primary mt-2">
                                {{ number_format($companyScore,2) }}
                            </h2>

                        </div>

                        <div class="align-self-center">

                            <i class="bi bi-speedometer2 text-primary" style="font-size:40px"></i>

                        </div>

                    </div>

                </div>

            </div>

        </div>

        <div class="col-xl-3 col-md-6">

            <div class="card shadow-sm border-0 h-100">

                <div class="card-body">

                    <div class="d-flex justify-content-between">

                        <div>

                            <small class="text-muted">
                                Employees
                            </small>

                            <h2 class="fw-bold text-success mt-2">
                                {{ $employeeCount }}
                            </h2>

                        </div>

                        <div class="align-self-center">

                            <i class="bi bi-people-fill text-success" style="font-size:40px"></i>

                        </div>

                    </div>

                </div>

            </div>

        </div>

        <div class="col-xl-3 col-md-6">

            <div class="card shadow-sm border-0 h-100">

                <div class="card-body">

                    <div class="d-flex justify-content-between">

                        <div>

                            <small class="text-muted">
                                Reward Candidate
                            </small>

                            <h2 class="fw-bold text-warning mt-2">
                                {{ $rewardApprovedCount }}
                            </h2>

                        </div>

                        <div class="align-self-center">

                            <i class="bi bi-award-fill text-warning" style="font-size:40px"></i>

                        </div>

                    </div>

                </div>

            </div>

        </div>

        <div class="col-xl-3 col-md-6">

            <div class="card shadow-sm border-0 h-100">

                <div class="card-body">

                    <div class="d-flex justify-content-between">

                        <div>

                            <small class="text-muted">
                                Rejected Candidate
                            </small>

                            <h2 class="fw-bold text-danger mt-2">
                                {{ $rewardRejectedCount }}
                            </h2>

                        </div>

                        <div class="align-self-center">

                            <i class="bi bi-exclamation-triangle-fill text-danger" style="font-size:40px"></i>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>

    <!-- Charts -->

    <div class="row g-4">

        <!-- Performance Trend -->

        <div class="col-lg-8">

            <div class="card shadow-sm border-0">

                <div class="card-header bg-white">

                    <h5 class="mb-0 fw-bold">

                        Company Performance Trend

                    </h5>

                </div>

                <div class="card-body">

                    <canvas id="performanceChart" height="110"></canvas>

                </div>

            </div>

        </div>

        <!-- Employee Distribution -->

        <div class="col-lg-4">

            <div class="card shadow-sm border-0">

                <div class="card-header bg-white">

                    <h5 class="mb-0 fw-bold">

                        Employee Distribution

                    </h5>

                </div>

                <div class="card-body">

                    <canvas id="distributionChart" height="240"></canvas>

                </div>

            </div>

        </div>

    </div>

    <!-- Department Ranking -->

    <div class="row mt-4">

        <div class="col-12">

            <div class="card shadow-sm border-0">

                <div class="card-header bg-white">

                    <h5 class="fw-bold mb-0">

                        Department Ranking

                    </h5>

                </div>

                <div class="card-body">

                    <canvas id="departmentChart" height="120"></canvas>

                </div>

            </div>

        </div>

    </div>

    <!-- Next Section -->

    <div class="row mt-4">

        <!-- Top Employee -->

        <div class="col-lg-6">

            <div class="card shadow-sm border-0">

                <div class="card-header bg-white">

                    <h5 class="fw-bold mb-0">

                        Top Employee

                    </h5>

                </div>

                <div class="card-body">

                    {{-- Part 3 --}}
                    <div class="table-responsive">

                        <table class="table table-hover align-middle">

                            <thead class="table-light">

                                <tr>
                                    <th>#</th>
                                    <th>Employee</th>
                                    <th>Department</th>
                                    <th class="text-end">Score</th>
                                </tr>

                            </thead>

                            <tbody>

                                @forelse($topEmployees as $employee)

                                <tr>

                                    <td>{{ $loop->iteration }}</td>

                                    <td>
                                        {{ $employee->employee->name ?? '-' }}
                                    </td>

                                    <td>
                                        {{ $employee->employee->department->name ?? '-' }}
                                    </td>

                                    <td class="text-end">

                                        <span class="badge bg-success">

                                            {{ number_format($employee->final_score,2) }}

                                        </span>

                                    </td>

                                </tr>

                                @empty

                                <tr>

                                    <td colspan="4" class="text-center">

                                        No Data

                                    </td>

                                </tr>

                                @endforelse

                            </tbody>

                        </table>

                    </div>

                </div>

            </div>

        </div>

        <!-- Need Improvement -->

        <div class="col-lg-6">

            <div class="card shadow-sm border-0">

                <div class="card-header bg-white">

                    <h5 class="fw-bold mb-0">

                        Need Improvement

                    </h5>

                </div>

                <div class="card-body">

                    {{-- Part 3 --}}
                    <div class="table-responsive">

                        <table class="table table-hover align-middle">

                            <thead class="table-light">

                                <tr>

                                    <th>#</th>

                                    <th>Employee</th>

                                    <th>Department</th>

                                    <th class="text-end">Score</th>

                                </tr>

                            </thead>

                            <tbody>

                                @forelse($needImprovement as $employee)

                                <tr>

                                    <td>{{ $loop->iteration }}</td>

                                    <td>{{ $employee->employee->name ?? '-' }}</td>

                                    <td>{{ $employee->employee->department->name ?? '-' }}</td>

                                    <td class="text-end">

                                        <span class="badge bg-danger">

                                            {{ number_format($employee->final_score,2) }}

                                        </span>

                                    </td>

                                </tr>

                                @empty

                                <tr>

                                    <td colspan="4" class="text-center">

                                        No Data

                                    </td>

                                </tr>

                                @endforelse

                            </tbody>

                        </table>

                    </div>


                </div>

            </div>

        </div>

    </div>

    <!-- Reward Recommendation -->

    <div class="row mt-4">

        <div class="col-12">

            <div class="card shadow-sm border-0">

                <div class="card-header bg-white">

                    <h5 class="fw-bold mb-0">

                        Reward Recommendation

                    </h5>

                </div>

                <div class="card-body">

                    {{-- Part 3 --}}
                    <div class="table-responsive">

                        <table class="table table-striped align-middle">

                            <thead class="table-light">

                                <tr>

                                    <th>Employee</th>

                                    <th>Department</th>

                                    <th>Recommendation</th>

                                    <th>Status</th>

                                </tr>

                            </thead>

                            <tbody>

                                @forelse($rewardRecommendations as $reward)

                                <tr>

                                    <td>

                                        {{ $reward->employee->name ?? '-' }}

                                    </td>

                                    <td>

                                        {{ $reward->employee->department->name ?? '-' }}

                                    </td>

                                    <td>

                                        @if($reward->recommendation=='Reward')

                                        <span class="badge bg-success">

                                            Reward

                                        </span>

                                        @else

                                        <span class="badge bg-danger">

                                            Punishment

                                        </span>

                                        @endif

                                    </td>

                                    <td>

                                        @switch($reward->status)

                                        @case('Approved')

                                        <span class="badge bg-success">

                                            Approved

                                        </span>

                                        @break

                                        @case('Rejected')

                                        <span class="badge bg-danger">

                                            Rejected

                                        </span>

                                        @break

                                        @default

                                        <span class="badge bg-warning text-dark">

                                            Pending

                                        </span>

                                        @endswitch

                                    </td>

                                </tr>

                                @empty

                                <tr>

                                    <td colspan="4" class="text-center">

                                        No Recommendation

                                    </td>

                                </tr>

                                @endforelse

                            </tbody>

                        </table>

                    </div>




                </div>

            </div>

        </div>

    </div>

</div>

@endsection

@push('styles')

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

@endpush

@push('scripts')

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

{{-- Part 3 --}}

<script>
    const performanceCtx =
document.getElementById('performanceChart');

new Chart(performanceCtx,{

type:'line',

data:{

labels:@json($months),

datasets:[{

label:'Company KPI',

data:@json($scores),

fill:false,

tension:.35,

borderWidth:3

}]

},

options:{

responsive:true,

plugins:{

legend:{
display:false
}

}

}

});

const departmentCtx =
document.getElementById('departmentChart');

new Chart(departmentCtx,{

type:'bar',

data:{

labels:@json($departmentLabels),

datasets:[{

label:'Average Score',

data:@json($departmentScores),

borderWidth:1

}]

},

options:{

indexAxis:'y',

responsive:true,

plugins:{

legend:{
display:false
}

}

}

});

const distributionCtx =
document.getElementById('distributionChart');

new Chart(distributionCtx,{

type:'doughnut',

data:{

labels:[

'Excellent',

'Good',

'Average',

'Poor'

],

datasets:[{

data:[

{{ $excellent }},

{{ $good }},

{{ $average }},

{{ $poor }}

]

}]

},

options:{

responsive:true,

plugins:{

legend:{

position:'bottom'

}

}

}

});

</script>


@endpush
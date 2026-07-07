@extends('layouts.admin.app')

@section('title', 'ABC Result')

@section('content')

<div class="container-fluid">

    <div class="row">

        <div class="col-lg-12">

            <div class="d-flex justify-content-between align-items-center mb-3">

                <h4 class="mb-0">
                    Artificial Bee Colony Result
                </h4>

                <a href="{{ route('abc.index') }}" class="btn btn-secondary">

                    <i class="fa fa-arrow-left me-1"></i>

                    Back

                </a>

            </div>

        </div>

    </div>

    <div class="row">

        {{-- Parameter --}}

        <div class="col-lg-4">

            <div class="card shadow-sm border-0 mb-4">

                <div class="card-header bg-primary text-white">

                    ABC Parameter

                </div>

                <div class="card-body">

                    <table class="table table-sm">

                        <tr>
                            <th width="180">Period</th>
                            <td>{{ $result->period->name }}</td>
                        </tr>

                        <tr>
                            <th>Population</th>
                            <td>{{ $result->population_size }}</td>
                        </tr>

                        <tr>
                            <th>Iteration</th>
                            <td>{{ $result->max_iteration }}</td>
                        </tr>

                        <tr>
                            <th>Limit Trial</th>
                            <td>{{ $result->limit_trial }}</td>
                        </tr>

                        <tr>
                            <th>Execution Time</th>
                            <td>{{ $result->execution_time }} ms</td>
                        </tr>

                        <tr>
                            <th>Fitness</th>

                            <td>

                                <span class="badge bg-success fs-6">

                                    {{ number_format($result->fitness,8) }}

                                </span>

                            </td>

                        </tr>

                    </table>

                </div>

            </div>

        </div>

        {{-- Bobot KPI --}}

        <div class="col-lg-8">

            <div class="card shadow-sm border-0 mb-4">

                <div class="card-header bg-success text-white">

                    Best Weight

                </div>

                <div class="card-body">


                    <table class="table table-bordered align-middle">

                        <thead class="table-light">

                            <tr>

                                <th>No</th>

                                <th>KPI Indicator</th>

                                <th class="text-end">Weight</th>

                                <th class="text-end">Percentage</th>

                            </tr>

                        </thead>

                        <tbody>

                            @php($total = 0)

                            @foreach($result->details as $detail)

                            @php($total += $detail->weight)

                            <tr>

                                <td>{{ $loop->iteration }}</td>

                                <td>{{ $detail->kpiMaster->name }}</td>

                                <td class="text-end">

                                    {{ number_format($detail->weight,10) }}

                                </td>

                                <td class="text-end">

                                    {{ number_format($detail->weight*100,2) }} %

                                </td>

                            </tr>

                            @endforeach

                        </tbody>

                        <tfoot>

                            <tr class="table-success">

                                <th colspan="2">

                                    Total

                                </th>

                                <th class="text-end">

                                    {{ number_format($total,6) }}

                                </th>

                                <th class="text-end">

                                    {{ number_format($total*100,2) }} %

                                </th>

                            </tr>

                        </tfoot>

                    </table>

                </div>

            </div>

        </div>

    </div>

    <div class="row">

        <div class="col-lg-8">

            <div class="card shadow-sm border-0">

                <div class="card-header bg-info text-white">

                    KPI Weight Distribution

                </div>

                <div class="card-body">

                    <div style="height:380px">

                        <canvas id="weightChart"></canvas>

                    </div>

                </div>

            </div>

        </div>

        <div class="col-lg-4">

            <div class="card shadow-sm border-0">

                <div class="card-header bg-success text-white">

                    Percentage

                </div>

                <div class="card-body">

                    <div style="height:380px">

                        <canvas id="pieChart"></canvas>

                    </div>

                </div>

            </div>

        </div>

    </div>

</div>

@endsection
@push('scripts')

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
    const labels = [
    @foreach($result->details as $detail)
        "{{ $detail->kpiMaster->name }}",
    @endforeach
];

const weights = [
    @foreach($result->details as $detail)
        {{ $detail->weight }},
    @endforeach
];

// ==========================
// Bar Chart
// ==========================
new Chart(document.getElementById('weightChart'), {

    type: 'bar',

    data: {
        labels: labels,

        datasets: [{
            label: 'Weight',
            data: weights,
            borderWidth: 1
        }]
    },

    options: {

        responsive: true,

        maintainAspectRatio: false,

        plugins: {

            legend: {
                display: false
            },

            tooltip: {

                callbacks: {

                    label: function(context){

                        return context.raw.toFixed(4) +
                            ' (' + (context.raw * 100).toFixed(2) + '%)';
                    }
                }
            }
        },

        scales: {

            y: {

                beginAtZero: true,

                max: 1,

                ticks: {

                    callback: function(value){

                        return (value * 100) + '%';
                    }

                }

            }

        }

    }

});


new Chart(document.getElementById('pieChart'),{

type:'doughnut',

data:{

labels:labels,

datasets:[{

data:weights

}]

},

options:{

responsive:true,

maintainAspectRatio:false,

plugins:{

legend:{
position:'bottom'
},

tooltip:{

callbacks:{

label:function(context){

return context.label + ': ' +
(context.raw*100).toFixed(2)+'%';

}

}

}

}

}

});

</script>

@endpush
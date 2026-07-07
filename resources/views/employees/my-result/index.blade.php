@extends('layouts.admin.app')

@section('content')

<div class="container-fluid">

    <div class="card shadow-sm">

        <div class="card-header">

            <h4 class="mb-0">
                My KPI Result
            </h4>

        </div>

        <div class="table-responsive">

            <table class="table table-hover align-middle mb-0">

                <thead>

                    <tr>

                        <th>Period</th>
                        <th>Total KPI</th>
                        <th>Average</th>
                        <th>Final Score</th>
                        <th>Rating</th>
                        <th></th>

                    </tr>

                </thead>

                <tbody>

                    @forelse($results as $item)

                    <tr>

                        <td>{{ $item['period']->name }}</td>

                        <td>{{ $item['total_kpi'] }}</td>

                        <td>{{ number_format($item['average_score'],2) }}</td>

                        <td>

                            <strong>

                                {{ number_format($item['final_score'],2) }}

                            </strong>

                        </td>

                        <td>

                            <span class="badge bg-primary">

                                {{ $item['rating'] }}

                            </span>

                        </td>

                        <td>

                            <a href="{{ route('my-result.show',$item['period']) }}" class="btn btn-sm btn-primary">

                                Detail

                            </a>

                        </td>

                    </tr>

                    @empty

                    <tr>

                        <td colspan="6" class="text-center py-5">

                            No KPI Result

                        </td>

                    </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

    </div>

</div>

@endsection
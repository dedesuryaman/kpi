@extends('reports.template')
@section('content')
<div class="title">
    <h2>Employee KPI Score Report</h2>

    <div class="subtitle">
        Generated : {{ now()->format('d M Y H:i') }}
    </div>
</div>

<table class="report">

    <thead>

        <tr>
            <th width="40">#</th>
            <th>Employee</th>
            <th>Department</th>
            <th>Position</th>
            <th width="80">Score AVG</th>
            <th width="70">Grade</th>
            <th width="60">Rank</th>
            <th width="90">Final Score</th>
        </tr>

    </thead>

    <tbody>

        @forelse($results as $result)

        <tr>

            <td class="text-center">
                {{ $loop->iteration }}
            </td>

            <td>
                {{ $result->employee->name }}
            </td>

            <td>
                {{ $result->employee->department->name ?? '-' }}
            </td>

            <td>
                {{ $result->employee->position->name ?? '-' }}
            </td>

            <td class="text-right">
                {{ number_format($result->average_score,2) }}
            </td>

            <td class="text-center">
                {{ $result->grade }}
            </td>

            <td class="text-center">
                {{ $result->rank }}
            </td>

            <td class="text-right">
                <strong>{{ number_format($result->final_score,2) }}</strong>
            </td>

        </tr>

        @empty

        <tr>
            <td colspan="8" class="text-center">
                No employee score data found.
            </td>
        </tr>

        @endforelse

    </tbody>

</table>

<div class="footer">
    Total Records : {{ $results->count() }}
</div>

@endsection
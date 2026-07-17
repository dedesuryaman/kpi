@extends('reports.template')
@section('content')
<div class="title">
    <h2>Department KPI Score Report</h2>

    <div class="subtitle">
        Generated at {{ now()->format('d M Y H:i') }}
    </div>
</div>
<table class="report">

    <thead>

        <tr>

            <th width="40">No</th>

            <th>Division</th>

            <th>Department</th>

            <th width="90">Employee</th>

            <th width="90">Average</th>

            <th width="90">Highest</th>

            <th width="90">Lowest</th>

        </tr>

    </thead>

    <tbody>

        @forelse($results as $result)

        <tr>

            <td class="text-center">
                {{ $loop->iteration }}
            </td>

            <td>
                {{ $result->division_name ?? '-' }}
            </td>

            <td>
                {{ $result->department_name }}
            </td>

            <td class="text-center">
                {{ $result->total_employee }}
            </td>

            <td class="text-right">
                {{ number_format($result->average_score,2) }}
            </td>

            <td class="text-right">
                {{ number_format($result->highest_score,2) }}
            </td>

            <td class="text-right">
                {{ number_format($result->lowest_score,2) }}
            </td>

        </tr>

        @empty

        <tr>

            <td colspan="7" class="text-center">

                No department score data found.

            </td>

        </tr>

        @endforelse

    </tbody>

</table>

<div class="footer">

    <strong>Total Department :</strong> {{ $results->count() }}

</div>

@endsection
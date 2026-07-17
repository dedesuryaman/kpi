@extends('reports.template')

@section('content')
<style>
    h2,
    h4 {
        margin: 0;
        text-align: center;
    }

    .subtitle {
        text-align: center;
        margin-top: 5px;
        margin-bottom: 20px;
        font-size: 12px;
    }

    table {
        width: 100%;
        border-collapse: collapse;
    }



    th {
        background: #e9ecef;
        font-weight: bold;
        text-align: center;
    }

    td {
        vertical-align: middle;
    }

    .text-center {
        text-align: center;
    }

    .text-right {
        text-align: right;
    }

    .summary-table {
        margin-bottom: 20px;
    }

    .summary-table td {
        border: 1px solid #aaa;
        padding: 8px;
    }

    .footer {
        margin-top: 20px;
        text-align: right;
        font-size: 10px;
    }
</style>


<h2>Employee Performance Summary Report</h2>

<div class="subtitle">
    <strong>Period :</strong> {{ $period->name ?? '-' }}
</div>

{{-- Summary --}}
<table class="summary-table">
    <tr>
        <td><strong>Total Employees</strong></td>
        <td>{{ $summary['employees'] }}</td>

        <td><strong>Average Score</strong></td>
        <td>{{ number_format($summary['average'],2) }}</td>

        <td><strong>Highest Score</strong></td>
        <td>{{ number_format($summary['highest'],2) }}</td>

        <td><strong>Lowest Score</strong></td>
        <td>{{ number_format($summary['lowest'],2) }}</td>
    </tr>
</table>

{{-- Detail --}}
<table class="report">

    <thead>

        <tr>
            <th width="5%">No</th>
            <th width="22%">Employee</th>
            <th width="18%">Department</th>
            <th width="10%">Score</th>
            <th width="12%">ABC Fitness</th>
            <th width="12%">MDP State</th>
            <th>Ai Recommendation</th>
        </tr>

    </thead>

    <tbody>

        @forelse($results as $index => $row)

        <tr>

            <td class="text-center">
                {{ $index + 1 }}
            </td>

            <td>
                {{ $row->employee->name }}
            </td>

            <td>
                {{ $row->employee->department->name ?? '-' }}
            </td>

            <td class="text-right">
                {{ number_format($row->final_score,2) }}
            </td>

            <td class="text-right">
                {{ number_format(optional($row->abcResult)->fitness ?? 0,4) }}
            </td>

            <td class="text-center">
                {{ optional($row->mdpResult)->state->name ?? '-' }}
            </td>

            <td>
                {{ optional($row->latestAiAnalysis)->recommendation ?? '-' }}
            </td>

        </tr>

        @empty

        <tr>

            <td colspan="7" class="text-center">
                No data available.
            </td>

        </tr>

        @endforelse

    </tbody>

</table>

<div class="footer">
    Generated at {{ now()->format('d M Y H:i') }}
</div>

@endsection
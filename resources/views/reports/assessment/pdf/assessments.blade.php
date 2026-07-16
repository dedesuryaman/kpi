@extends('reports.template')


@section('content')
<!-- TITLE -->

<div class="title">

    <h2>KPI ASSESSMENT REPORT</h2>

    <p>
        Assessment Data Report
    </p>

</div>

<!-- INFORMATION -->

<table class="info">

    <tr>

        <td width="18%">
            Report Date
        </td>

        <td width="2%">
            :
        </td>

        <td>
            {{ now()->format('d F Y') }}
        </td>

    </tr>

    <tr>

        <td>Total KPI Assessment</td>

        <td>:</td>

        <td>{{ $results->count() }}</td>

    </tr>


</table>

<table class="report">

    <thead class="table-light">

        <tr>

            <th>#</th>
            <th>Employee</th>
            <th>Department</th>
            <th>Position</th>
            <th>Final Score</th>
            <th>Category</th>

        </tr>

    </thead>

    <tbody>

        @forelse($results as $result)

        <tr>

            <td>

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

            <td>

                <strong>

                    {{ number_format($result->final_score,2) }}

                </strong>

            </td>

            <td>

                @php

                $score = $result->final_score;

                @endphp

                @if($score >= 90)

                <span class="badge bg-success">
                    Excellent
                </span>

                @elseif($score >= 80)

                <span class="badge bg-primary">
                    Very Good
                </span>

                @elseif($score >= 70)

                <span class="badge bg-info">
                    Good
                </span>

                @elseif($score >= 60)

                <span class="badge bg-warning">
                    Fair
                </span>

                @else

                <span class="badge bg-danger">
                    Poor
                </span>

                @endif

            </td>

        </tr>

        @empty

        <tr>

            <td colspan="6" class="text-center py-5">

                <i class="bi bi-inbox display-5 text-muted"></i>

                <div class="mt-2">

                    No assessment data found.

                </div>

            </td>

        </tr>

        @endforelse

    </tbody>



    </tbody>

</table>

@endsection
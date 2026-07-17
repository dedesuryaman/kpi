@extends('reports.template')
@section('content')
<div class="title">
    <h2>ASSESSMENT COMPLETION STATUS REPORT</h2>
    <div class="subtitle">
        Assessment completion status by department.
    </div>
</div>
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

        <td>Period</td>

        <td>:</td>

        <td><strong>{{ $period?->name ?? '-' }}</strong></td>

    </tr>


</table>
<table class="report">

    <thead class="table-light">

        <tr>

            <th width="60">#</th>
            <th>Department</th>
            <th>Division</th>
            <th>Total Employees</th>
            <th>Completed</th>

            <th>Not Assessed</th>
            <th>Completion (%)</th>

        </tr>

    </thead>

    <tbody>

        @forelse($results as $department)



        <tr>

            <td>

                {{ $loop->iteration }}

            </td>

            <td>

                <strong>

                    {{ $department->department_name }}

                </strong>

            </td>
            <td>

                {{ $department->division_name }}

            </td>
            <td>

                {{ $department->total_employee }}

            </td>

            <td>


                {{ $department->assessed_employee }}


            </td>


            <td>

                {{ $department->not_assessed_employee }}

            </td>

            <td>

                {{ number_format($department->completion_percentage ,2) }}

            </td>

        </tr>

        @empty

        <tr>

            <td colspan="7" class="text-center py-5">

                <i class="bi bi-inbox display-5 text-muted"></i>

                <div class="mt-2">

                    No assessment completion data found.

                </div>

            </td>

        </tr>

        @endforelse

    </tbody>

</table>

<div class="footer">

    <strong>Total Data :</strong> {{ $results->count() }} record

</div>

@endsection
@extends('reports.template')
@section('content')
<div class="header">
    <div class="title">
        <h2>EMPLOYEE MASTER REPORT</h2>

    </div>
    <p>Employee Master Data</p>

    <p>
        Printed :
        {{ now()->format('d M Y H:i') }}
    </p>

</div>

<table class="report">

    <thead>

        <tr>

            <th width="5%">No</th>

            <th width="12%">Code</th>

            <th width="22%">Employee</th>

            <th width="15%">Division</th>

            <th width="15%">Department</th>

            <th width="15%">Position</th>

            <th width="8%">Status</th>

        </tr>

    </thead>

    <tbody>

        @forelse($employees as $employee)

        <tr>

            <td class="text-center">
                {{ $loop->iteration }}
            </td>

            <td>
                {{ $employee->employee_code }}
            </td>

            <td>
                {{ $employee->name }}
            </td>

            <td>
                {{ $employee->department?->division?->name ?? '-' }}
            </td>

            <td>
                {{ $employee->department?->name ?? '-' }}
            </td>

            <td>
                {{ $employee->position?->name ?? '-' }}
            </td>

            <td class="text-center">
                {{ $employee->employment_status ?? '-' }}
            </td>

        </tr>

        @empty

        <tr>

            <td colspan="7" class="text-center">
                No employee data.
            </td>

        </tr>

        @endforelse

    </tbody>

</table>

<div class="footer">

    Total Employee :
    <strong>{{ $employees->count() }}</strong>

</div>

@endsection
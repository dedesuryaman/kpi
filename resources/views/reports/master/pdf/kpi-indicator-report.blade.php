@extends('reports.template')


@section('content')

<!-- TITLE -->

<div class="title">

    <h2>KPI INDICATOR REPORT</h2>

    <p>
        Master Position Data Report
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

        <td>Total KPI Indicator</td>

        <td>:</td>

        <td>{{ $kpiIndicators->count() }}</td>

    </tr>


</table>

<table class="report">

    <thead>

        <tr>

            <th width="6%">No</th>

            <th>KPI Master</th>

            <th>Indicator</th>

            <th>Description</th>
            <th width="10%">Weight</th>

            <th width="10%">Status</th>

        </tr>

    </thead>

    <tbody>

        @forelse($kpiIndicators as $indicator)

        <tr>

            <td class="text-center">
                {{ $loop->iteration }}
            </td>

            <td>
                {{ $indicator->kpiMaster->name ?? '-' }}
            </td>

            <td>
                {{ $indicator->name }}
            </td>

            <td>
                {{ $indicator->description ?? '-' }}
            </td>

            <td class="text-center">
                {{ $indicator->weight }}
            </td>

            <td class="text-center">
                {{ $indicator->status ? 'Active' : 'Inactive' }}
            </td>

        </tr>

        @empty

        <tr>

            <td colspan="6" class="text-center">
                No KPI Indicator data available.
            </td>

        </tr>

        @endforelse

    </tbody>

</table>

<div class="summary">

    Total KPI Indicator :
    {{ $kpiIndicators->count() }}

</div>
@endsection
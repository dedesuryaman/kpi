<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">

    <style>
        @page {
            margin: 25px;
        }

        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 11px;
            color: #333;
        }

        .header {
            border-bottom: 3px solid #054550;
            padding-bottom: 12px;
            margin-bottom: 20px;
        }

        .company {
            font-size: 14px;
            font-weight: bold;
            color: #05425a;
        }

        .company-sub {
            font-size: 11px;
            color: #666;
            margin-top: 3px;
        }

        .title {
            text-align: center;
            margin: 20px 0;
        }

        .title h2 {
            margin: 0;
            font-size: 16px;
            color: #222;
        }

        .title p {
            margin: 5px 0;
            color: #777;
        }

        .info {
            width: 100%;
            margin-bottom: 18px;
        }

        .info td {
            padding: 3px 0;
            border: none;
        }

        table.report {
            width: 100%;
            border-collapse: collapse;
        }

        table.report thead th {
            background: #04475c;
            color: #fff;
            padding: 4px;
            border: 1px solid #dcdcdc;
            text-align: center;
        }

        table.report tbody td {
            border: 1px solid #dcdcdc;
            padding: 4px;
        }

        table.report tbody tr:nth-child(even) {
            background: #f8f9fa;
        }

        .text-center {
            text-align: center;
        }

        .footer {
            margin-top: 30px;
            border-top: 1px solid #ccc;
            padding-top: 10px;
            font-size: 10px;
            color: #666;
        }

        .summary {
            margin-top: 15px;
            font-size: 11px;
            font-weight: bold;
        }
    </style>

</head>

<body>

    <!-- HEADER -->

    <table width="100%" class="header">

        <tr>

            <td width="60px;">
                <img src="{{ public_path('assets/images/logo-putih.jpg') }}" style="width:60px;">
            </td>

            <td width="65%">

                <div class="company">
                    PT. MAKERINDO PRIMA SOLUSI
                </div>

                <div class="company-sub">
                    Employee Performance Management System
                </div>

            </td>

            <td align="right">

                <strong>Printed :</strong><br>

                {{ now()->format('d F Y') }}<br>

                {{ now()->format('H:i') }}

            </td>

        </tr>

    </table>

    <!-- TITLE -->

    <div class="title">

        <h2>EMPLOYEE KPI TARGET REPORT</h2>

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

            <td>{{ $kpiTargets->count() }}</td>

        </tr>


    </table>

    <table class="report">

        <thead>

            <tr>

                <th>No</th>

                <th>Employee</th>

                <th>Department</th>

                <th>Position</th>

                <th>KPI Master</th>

                <th>KPI Indicator</th>

                <th>Target</th>

                <th>Weight</th>

                <th>Period</th>
            </tr>

        </thead>

        <tbody>

            @forelse($kpiTargets as $target)

            <tr>

                <td>{{ $loop->iteration }}</td>

                <td>{{ $target->employee->name ?? '-' }}</td>

                <td>{{ $target->employee->department->name ?? 'N/A' }}</td>

                <td>{{ $target->employee->position->name ?? '-' }}</td>

                <td>{{ $target->indicator->master->name ?? '-' }}</td>

                <td>{{ $target->indicator->name ?? '-' }}</td>

                <td style="text-align:center">
                    {{ $target->target_value }}
                </td>

                <td style="text-align:center">
                    {{ $target->indicator->weight }}
                </td>

                <td>

                    {{ $target->period->name ?? '-' }}

                </td>

            </tr>

            @empty

            <tr>

                <td colspan="8" style="text-align:center">
                    No KPI Target data available.
                </td>

            </tr>

            @endforelse

        </tbody>

    </table>

    <div class="summary">

        Total KPI Target :
        {{ $kpiTargets->count() }}

    </div>

    <!-- FOOTER -->

    <div class="footer">

        This report is automatically generated by the
        <strong>Employee Performance Management System</strong>.

        <br>

        Generated on
        {{ now()->format('d F Y H:i:s') }}

    </div>

</body>

</html>
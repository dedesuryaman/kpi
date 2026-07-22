<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <title>Employee Performance Report</title>

    <style>
        @page {
            size: A4 landscape;
            margin: 15mm;
        }

        * {
            box-sizing: border-box;
        }

        body {
            font-family: Arial, Helvetica, sans-serif;
            font-size: 12px;
            color: #000;
        }

        h2,
        h3,
        h4,
        p {
            margin: 0;
        }

        .header {
            text-align: center;
            margin-bottom: 20px;
        }

        .header h2 {
            margin-bottom: 5px;
        }

        .header p {
            color: #555;
        }

        .info {
            width: 100%;
            margin-bottom: 15px;
        }

        .info td {
            padding: 4px 0;
            font-size: 12px;
        }

        table.report {
            width: 100%;
            border-collapse: collapse;
        }

        table.report th,
        table.report td {
            border: 1px solid #000;
            padding: 6px;
        }

        table.report th {
            background: #efefef;
            text-align: center;
        }

        .text-center {
            text-align: center;
        }

        .text-right {
            text-align: right;
        }

        .footer {
            margin-top: 50px;
        }

        .signature {
            width: 250px;
            float: right;
            text-align: center;
        }

        .signature .space {
            height: 80px;
        }
    </style>

</head>

<body>

    <div class="header">

        <h2>EMPLOYEE PERFORMANCE REPORT</h2>

        <p>Employee Performance Evaluation</p>

    </div>

    <table class="info">

        <tr>

            <td width="120"><strong>Period</strong></td>

            <td width="10">:</td>

            <td>
                {{ $period?->name ?? 'All Period' }}
            </td>

            <td class="text-right">

                Printed :

                {{ now()->format('d M Y H:i') }}

            </td>

        </tr>

    </table>

    @php
    $average = 0;
    @endphp

    <table class="report">

        <thead>

            <tr>

                <th width="50">Rank</th>

                <th width="60">No</th>

                <th>Employee Code</th>

                <th>Employee Name</th>

                <th>Department</th>

                <th>Position</th>

                <th width="120">Average Score</th>

                <th width="120">Final Score</th>

                <th width="80">Grade</th>

            </tr>

        </thead>

        <tbody>

            @forelse($results as $result)

            @php
            $average += $result->final_score;
            @endphp

            <tr>

                <td class="text-center">

                    {{ $result->rank }}

                </td>

                <td class="text-center">

                    {{ $loop->iteration }}

                </td>

                <td>

                    {{ $result->employee->employee_code }}

                </td>

                <td>

                    {{ $result->employee->name }}

                </td>

                <td>

                    {{ $result->employee->department?->name  ?? '-'}}

                </td>

                <td>

                    {{ $result->employee->position?->name ?? '-'}}

                </td>

                <td class="text-right">

                    {{ number_format($result->average_score,2) }}

                </td>

                <td class="text-right">

                    <strong>

                        {{ number_format($result->final_score,2) }}

                    </strong>

                </td>

                <td class="text-center">

                    {{ $result->grade }}

                </td>

            </tr>

            @empty

            <tr>

                <td colspan="9" class="text-center">

                    No data available.

                </td>

            </tr>

            @endforelse

        </tbody>

        @if($results->count())

        <tfoot>

            <tr>

                <th colspan="7" class="text-right">

                    Average Final Score

                </th>

                <th class="text-right">

                    {{ number_format($average / $results->count(),2) }}

                </th>

                <th></th>

            </tr>

        </tfoot>

        @endif

    </table>

    <div class="footer">

        <div class="signature">

            <p>

                {{ now()->format('d F Y') }}

            </p>

            <p>

                Human Resources

            </p>

            <div class="space"></div>

            <strong>

                (__________________________)

            </strong>

        </div>

    </div>

    <script>
        window.onload = function () {

            window.print();

        }

    </script>

</body>

</html>
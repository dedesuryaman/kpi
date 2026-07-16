<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">

    <title>Employee Report</title>

    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 11px;
            color: #333;
        }

        .header {
            text-align: center;
            margin-bottom: 20px;
        }

        .header h2 {
            margin: 0;
        }

        .header p {
            margin: 3px 0;
            color: #777;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        table th {
            background: #0d6efd;
            color: white;
            border: 1px solid #ddd;
            padding: 8px;
            text-align: center;
        }

        table td {
            border: 1px solid #ddd;
            padding: 6px;
        }

        tbody tr:nth-child(even) {
            background: #f5f5f5;
        }

        .text-center {
            text-align: center;
        }

        .footer {
            margin-top: 25px;
            font-size: 10px;
            text-align: right;
            color: #666;
        }
    </style>

</head>

<body>

    <div class="header">

        <h2>EMPLOYEE MASTER REPORT</h2>

        <p>Employee Master Data</p>

        <p>
            Printed :
            {{ now()->format('d M Y H:i') }}
        </p>

    </div>

    <table>

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

</body>

</html>
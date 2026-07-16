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
            color: #2c3e50;
        }

        /* ===========================
           HEADER
        =========================== */

        .header {
            width: 100%;
            border-bottom: 3px solid #0b4161;
            padding-bottom: 12px;
            margin-bottom: 18px;
        }

        .company-name {
            font-size: 14px;
            font-weight: bold;
            color: #07566e;
        }

        .company-desc {
            font-size: 10px;
            color: #666;
            margin-top: 3px;
        }

        .report-info {
            text-align: right;
            font-size: 10px;
        }

        /* ===========================
           TITLE
        =========================== */

        .title {
            text-align: center;
            margin: 15px 0 20px;
        }

        .title h2 {
            margin: 0;
            font-size: 16px;
            color: #1b1b1b;
        }

        .title p {
            margin-top: 5px;
            color: #777;
            font-size: 11px;
        }

        /* ===========================
           SUMMARY
        =========================== */

        .summary {
            margin-bottom: 18px;
        }

        .summary table {
            width: 45%;
        }

        .summary td {
            padding: 4px;
            border: none;
        }

        /* ===========================
           TABLE
        =========================== */

        table.report {
            width: 100%;
            border-collapse: collapse;
        }

        table.report thead th {
            background: #075377;
            color: white;
            padding: 4px;
            border: 1px solid #cfd8dc;
            text-align: center;
        }

        table.report tbody td {
            border: 1px solid #d9d9d9;
            padding: 4px;
        }

        table.report tbody tr:nth-child(even) {
            background: #f8f9fa;
        }

        .text-center {
            text-align: center;
        }

        /* ===========================
           FOOTER
        =========================== */

        .footer {
            margin-top: 35px;
            border-top: 1px solid #ddd;
            padding-top: 10px;
            font-size: 10px;
            color: #666;
        }

        .signature {
            margin-top: 45px;
            width: 100%;
        }

        .signature td {
            border: none;
            text-align: center;
            vertical-align: top;
        }

        .sign-space {
            height: 70px;
        }
    </style>

</head>

<body>

    <!-- HEADER -->

    <table class="header">

        <tr>

            <td width="70%" style="border:none">

                <div class="company-name">
                    PT. MAKERINDO PRIMA SOLUSI
                </div>

                <div class="company-desc">
                    Employee Performance Management System
                </div>

            </td>

            <td width="30%" class="report-info" style="border:none">

                <strong>Printed</strong><br>

                {{ now()->format('d F Y') }}<br>

                {{ now()->format('H:i:s') }}

            </td>

        </tr>

    </table>

    <!-- TITLE -->

    <div class="title">

        <h2>DEPARTMENT MASTER REPORT</h2>

        <p>
            Department Master Data
        </p>

    </div>

    <!-- SUMMARY -->

    <div class="summary">

        <table>

            <tr>

                <td width="130"><strong>Report Date</strong></td>

                <td width="10">:</td>

                <td>{{ now()->format('d F Y') }}</td>

            </tr>

            <tr>

                <td><strong>Total Department</strong></td>

                <td>:</td>

                <td>{{ $departments->count() }}</td>

            </tr>

        </table>

    </div>

    <!-- TABLE -->

    <table class="report">

        <thead>

            <tr>

                <th width="8%">No</th>

                <th>Department Name</th>

                <th width="35%">Division</th>
                <th width="15%">Employee</th>

            </tr>

        </thead>

        <tbody>

            @forelse($departments as $department)

            <tr>

                <td class="text-center">
                    {{ $loop->iteration }}
                </td>

                <td>
                    {{ $department->name }}
                </td>

                <td>
                    {{ $department->division->name ?? '-' }}
                </td>

                <td>
                    {{ $department->employees->count() ?? '-' }}
                </td>

            </tr>

            @empty

            <tr>

                <td colspan="3" class="text-center">
                    No department data available.
                </td>

            </tr>

            @endforelse

        </tbody>

    </table>

    <!-- SIGNATURE -->

    <table class="signature">

        <tr>

            <td width="50%">

                Prepared By

                <div class="sign-space"></div>

                _______________________

            </td>

            <td width="50%">

                Approved By

                <div class="sign-space"></div>

                _______________________

            </td>

        </tr>

    </table>

    <!-- FOOTER -->

    <div class="footer">

        This report was generated automatically by the
        <strong>Employee Performance Management System</strong>.

        <br>

        PT. MAKERINDO PRIMA SOLUSI © {{ date('Y') }}

    </div>

</body>

</html>
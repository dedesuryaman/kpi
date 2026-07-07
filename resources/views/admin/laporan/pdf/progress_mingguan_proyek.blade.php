<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Laporan Progres Proyek Mingguan</title>

    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 9px;
            /* FONT UTAMA */
            color: #333;
        }

        .header {
            text-align: center;
            margin-bottom: 12px;
        }

        .header h2 {
            margin: 0;
            font-size: 14px;
            text-transform: uppercase;
        }

        .header p {
            margin: 4px 0 0;
            font-size: 11px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        table th,
        table td {
            border: 1px solid #000;
            padding: 4px;
            /* diperkecil */
            font-size: 9px;
        }

        table th {
            background-color: #f2f2f2;
            text-align: center;
            font-weight: bold;
        }

        table td {
            vertical-align: middle;
        }

        .text-center {
            text-align: center;
        }

        .footer {
            margin-top: 12px;
            font-size: 8px;
        }
    </style>
</head>

<body>

    {{-- HEADER --}}
    <div class="header">
        <h2>Laporan Progres Proyek Mingguan</h2>
        <p>Bulan {{ $bulan ?? '-' }} Tahun {{ $tahun ?? '-' }}</p>
    </div>

    {{-- TABEL --}}
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Pekerjaan</th>
                <th>Kegiatan</th>
                <th>Tangal Mulai</th>
                <th>Tanggal Selesai</th>
                @for($w=1;$w<=5;$w++) <th>Minggu {{ $w }}</th>
                    @endfor
            </tr>
        </thead>
        <tbody>
            @php $n = 1 @endphp

            @forelse($data as $item)
            <tr>
                <td>{{ $n++ }}</td>
                <td>{{ $item['pekerjaan'] }}</td>
                <td>{{ $item['nm_sub_kegiatan']}}</td>
                <td>{{ tanggalIndoSm($item['tanggal_mulai']) }}</td>
                <td>{{ tanggalIndoSm($item['tanggal_selesai']) }}</td>
                @for($w=1;$w<=5;$w++) <td>
                    {{ number_format($item['mingguan'][$w] ?? 0 , '2' ) }} %
                    </td>
                    @endfor
            </tr>

            @empty
            <tr>
                <td colspan="5" class="text-center">Tidak ada data</td>
            </tr>
            @endforelse
        </tbody>
    </table>

    {{-- FOOTER --}}
    <div class="footer">
        Dicetak pada: {{ date('d-m-Y H:i') }}
    </div>

</body>

</html>
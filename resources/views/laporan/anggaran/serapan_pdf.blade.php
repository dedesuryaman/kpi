<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Laporan Kendala Proyek</title>

    <style>
        @page {
            margin: 130px 40px 40px 40px;
        }

        body {
            font-family: Arial, Helvetica, sans-serif;
            font-size: 12px;
            margin: 0;
        }

        .watermark {
            position: fixed;
            top: 45%;
            left: 15%;
            opacity: 0.05;
            font-size: 80px;
            transform: rotate(-30deg);
        }

        .header {
            position: fixed;
            top: -110px;
            left: 0;
            right: 0;
        }

        .kop-table {
            width: 100%;
        }

        .kop-table td {
            border: none;
            vertical-align: middle;
        }

        .logo {
            width: 90px;
        }

        .text-center {
            text-align: center;
        }

        .text-right {
            text-align: right;
        }

        .garis {
            border-top: 3px solid black;
            border-bottom: 1px solid black;
            margin-top: 5px;
            margin-bottom: 10px;
        }

        .judul {
            text-align: center;
            font-size: 14px;
            font-weight: bold;
            margin-top: 10px;
            margin-bottom: 15px;
        }

        table.data {
            width: 100%;
            border-collapse: collapse;
        }

        table.data th,
        table.data td {
            border: 1px solid #000;
            padding: 6px;
            vertical-align: top;
        }

        table.data th {
            background: #f2f2f2;
            font-weight: bold;
            text-align: center;
        }

        table.data tr {
            page-break-inside: avoid;
        }

        .footer-table {
            margin-top: 60px;
            width: 100%;
        }

        .footer-table td {
            border: none;
        }

        .info-row {
            display: flex;
            flex-wrap: wrap;
            /* agar value tetap wrap jika panjang */
            gap: 5px;
            /* jarak antara label dan value */
            margin-bottom: 2px;
        }

        .info-row .label {
            min-width: 80px;
            /* lebar tetap untuk label */
            font-weight: 600;
        }

        .info-row .value {
            flex: 1;
            /* value ambil sisa space */
            word-wrap: break-word;
            /* text panjang tetap wrap */
        }
    </style>
</head>

<body>

    <div class="watermark">DOKUMEN RESMI</div>

    <!-- HEADER -->
    <div class="header">
        <table class="kop-table">
            <tr>
                <td width="15%">
                    <img src="{{ public_path('assets/images/logo.png') }}" class="logo">
                </td>
                <td class="text-center">
                    <div style="font-size:16px; font-weight:bold;">
                        {{ setting('nama_instansi', 'PEMERINTAH KABUPATEN BANDUNG BARAT ') }}
                    </div>
                    <div style="font-size:12px;">
                        {{ setting('alamat' , 'Jl. Raya Padalarang – Cisarua Km. 2 Ngamprah 40552') }}<br>
                        Website: {{ setting('website' , 'www.bandungbaratkab.go.id') }}
                    </div>
                </td>
                <td width="15%"></td>
            </tr>
        </table>
        <div class="garis"></div>
    </div>

    <!-- JUDUL -->
    <div class="judul">
        LAPORAN SERAPAN ANGGARAN
    </div>

    <table class="info">
        <tr>
            <td width="80">Tahun Anggaran</td>
            <td>: {{ $tahun }}</td>
        </tr>
        <tr>
            <td>OPD</td>
            <td>: {{ $opd }}</td>
        </tr>
        <tr>
            <td>Proyek</td>
            <td>: {{ $proyek }}</td>
        </tr>
    </table>
    <table class="data">
        <thead>
            <tr>
                <th width="20%">Bulan</th>
                <th width="30%">Realisasi Bulan Ini</th>
                <th width="30%">Realisasi Kumulatif</th>
                <th width="20%">Serapan (%)</th>
            </tr>
        </thead>
        <tbody>

            @php
            $bulanNama=[
            1=>'Januari','Februari','Maret','April','Mei','Juni',
            'Juli','Agustus','September','Oktober','November','Desember'
            ];
            @endphp

            @foreach($data as $row)
            <tr>
                <td class="text-center">{{ $bulanNama[$row['bulan']] }}</td>
                <td class="text-right">{{ number_format($row['realisasi'],0,',','.') }}</td>
                <td class="text-right">{{ number_format($row['kumulatif'],0,',','.') }}</td>
                <td class="text-center">{{ number_format($row['persen'],2) }} %</td>
            </tr>
            @endforeach

        </tbody>
    </table>


    <!-- FOOTER TANDA TANGAN (TIDAK FIXED SUPAYA SELALU DI HALAMAN TERAKHIR) -->
    <table class="footer-table">
        <tr>
            <!-- QR di kiri -->
            <td width="40%" class="text-center">
                <img src="data:image/png;base64,{{ $qr }}" width="100"><br>
                <span style="font-size:10px;">
                    Scan untuk verifikasi<br>
                    Kode: {{ $token ?? '-' }}
                </span>
            </td>

            <!-- TTD di kanan -->
            <td width="60%" class="text-center">
                Bandung Barat, {{ now()->format('d F Y') }}<br><br>
                <br><br><br><br>
                <strong>(___________________________)</strong>
            </td>
        </tr>
    </table>

</body>

</html>
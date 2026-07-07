<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Laporan Pengawasan Proyek</title>

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
                        {{ setting('nama_instansi', 'PEMERINTAH KABUPATEN BANDUNG BARAT') }}
                    </div>
                    <div style="font-size:12px;">
                        {{ setting('alamat', 'Jl. Raya Padalarang – Cisarua Km. 2 Ngamprah 40552') }}<br>
                        Website: {{ setting('website', 'www.bandungbaratkab.go.id') }}
                    </div>
                </td>
                <td width="15%"></td>
            </tr>
        </table>
        <div class="garis"></div>
    </div>

    <!-- JUDUL -->
    <div class="judul">
        LAPORAN PENGAWASAN PROYEK
    </div>
    <!-- FILTER INFO -->
    <table style="margin-bottom:15px;">
        <tr>
            <td width="100">Tahun</td>
            <td width="10">:</td>
            <td>{{ $request->tahun ?? 'Semua' }}</td>
        </tr>
        <tr>
            <td>Status</td>
            <td>:</td>
            <td>{{ $request->status ?? 'Semua' }}</td>
        </tr>
        <tr>
            <td>OPD</td>
            <td>:</td>
            <td>{{ $opdName ?? '-' }}</td>
        </tr>
    </table>

    <!-- TABEL DATA -->
    <table class="data">
        <thead>
            <tr>
                <th width="30">No</th>
                <th width="70">Tanggal</th>
                <th>Pekerjaan</th>
                <th>Lokasi & Catatan</th>
                <th width="60">Progress</th>
                <th width="70">Status</th>
                <th width="90">Petugas</th>
            </tr>
        </thead>
        <tbody>
            @foreach($data as $i => $row)
            <tr>
                <td class="text-center">{{ $i+1 }}</td>
                <td>{{ \Carbon\Carbon::parse($row->waktu_pengawasan)->format('d-m-Y') }}</td>
                <td>
                    <strong>{{ $row->pekerjaan?->nm_pekerjaan ?? '-' }}</strong><br>
                    Kegiatan: {{ $row->pekerjaan?->subKegiatan?->nm_kegiatan ?? '-' }}
                </td>
                <td>
                    {{ $row->alamat ?? '-' }}<br>
                    <em>Catatan:</em> {{ $row->catatan ?? '-' }}
                </td>
                <td class="text-center">
                    {{ $row->progres_persentase ?? 0 }}%
                </td>
                <td class="text-center">
                    {{ ucwords(str_replace('_',' ', $row->status ?? 'normal')) }}
                </td>
                <td>
                    {{ $row->pengawas?->name ?? '-' }}
                </td>
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
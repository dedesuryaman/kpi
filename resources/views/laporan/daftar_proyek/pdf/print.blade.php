<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Laporan Daftar Proyek</title>

    <style>
        @page {
            margin: 25px 25px;
        }

        body {
            font-family: Arial, Helvetica, sans-serif;
            font-size: 11px;
        }

        /* watermark */
        .watermark {
            position: fixed;
            top: 40%;
            left: 15%;
            opacity: 0.05;
            font-size: 90px;
            transform: rotate(-30deg);
        }

        /* kop */
        .kop-table {
            width: 100%;
        }

        .kop-table td {
            border: none;
            vertical-align: middle;
        }

        .logo {
            width: 85px;
        }

        .text-center {
            text-align: center;
        }

        .text-right {
            text-align: right;
        }

        .judul {
            font-size: 14px;
            font-weight: bold;
            margin-top: 10px;
            margin-bottom: 10px;
        }

        .garis {
            border-top: 3px solid #000;
            border-bottom: 1px solid #000;
            margin-top: 5px;
            margin-bottom: 15px;
        }

        /* tabel */
        table.data {
            width: 100%;
            border-collapse: collapse;
            font-size: 11px;
        }

        table.data th,
        table.data td {
            border: 1px solid #000;
            padding: 6px;
        }

        table.data th {
            background: #efefef;
        }

        /* hindari baris tabel terpotong */
        tr {
            page-break-inside: avoid;
        }

        /* area tanda tangan */

        .ttd-area {
            margin-top: 40px;
            page-break-inside: avoid;
        }

        .ttd-box {
            width: 260px;
            float: right;
            text-align: center;
        }

        /* qr */
        .qr-box {
            left: 40px;
            text-align: center;
            font-size: 9px;
        }
    </style>
</head>

<body>

    <div class="watermark">DOKUMEN RESMI</div>

    <!-- KOP -->
    <table class="kop-table">
        <tr>
            <td width="15%">
                <img src="{{ public_path('assets/images/logo.png') }}" class="logo">
            </td>

            <td class="text-center">
                <div style="font-size:16px;font-weight:bold;">
                    {{ setting('nama_instatnsi' , 'PEMERINTAH KABUPATEN BANDUNG BARAT') }}
                </div>

                <div style="font-size:11px;">
                    {{ setting('alamat' , 'Jl. Raya Padalarang – Cisarua Km. 2 Ngamprah 40552') }}<br>
                    Website: {{ setting('website', 'www.bandungbaratkab.go.id') }}
                </div>
            </td>

            <td width="15%"></td>
        </tr>
    </table>

    <div class="garis"></div>

    <div class="judul text-center">
        LAPORAN DAFTAR PROYEK
    </div>

    <!-- FILTER -->
    <table style="margin-bottom:15px;">
        <tr>
            <td width="120">Tahun</td>
            <td width="10">:</td>
            <td>{{ $request->tahun ?? 'Semua' }}</td>
        </tr>

        <tr>
            <td>Status</td>
            <td>:</td>
            <td>{{ $request->status_progress ?? 'Semua' }}</td>
        </tr>
    </table>

    <!-- TABEL -->
    <table class="data">
        <thead>
            <tr>
                <th width="10">No</th>
                <th>Proyek Dinas</th>
                <th>Nomor Kontrak</th>
                <th>Tanggal Kontrak</th>
                <th>Nilai Kontrak</th>
                <th>Tanggal Mulai</th>
                <th>Tanggal Selesai</th>
                <th>Kontraktor Pelaksana</th>
                <th>Kontraktor Pengawas</th>
            </tr>
        </thead>

        <tbody>

            @forelse($projects as $i => $row)
            <tr>
                <td class="text-center">{{ $i+1 }}</td>
                <td>{{ $row->nm_pekerjaan }}
                    <hr>{{ $row->subKegiatan?->nm_unit ?? '-' }}
                </td>

                <td>{{ $row->nomor_kontrak }}</td>
                <td class="text-center">{{ $row->tanggal_kontrak }}</td>
                <td class="text-right">
                    {{ number_format($row->pagu_anggaran,0,',','.') }}
                </td>
                <td class="text-center">{{ $row->tanggal_mulai }}</td>
                <td class="text-center">{{ $row->tanggal_selesai }}</td>
                <td>{{ $row->konPelaksana?->name ?? '-' }}</td>
                <td>{{ $row->konPengawas?->name ?? '-' }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="10" class="text-center">
                    Tidak ada data
                </td>
            </tr>
            @endforelse

        </tbody>
    </table>

    <div class="ttd-area">

        <table width="100%">
            <tr>

                <td width="50%" style="vertical-align:bottom">

                    <div style="text-align:center;font-size:10px">
                        <img src="data:image/png;base64,{{ $qr }}" width="80"><br>
                        Scan Verifikasi<br>
                        {{ $token }}
                    </div>

                </td>

                <td width="50%" class="text-center">

                    Bandung Barat, {{ now()->translatedFormat('d F Y') }}
                    <br><br>

                    Kepala Dinas
                    <br><br><br><br>

                    <b>(_____________________)</b>

                </td>

            </tr>
        </table>

    </div>

</body>

</html>
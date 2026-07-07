<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <style>
        body {
            font-family: Arial, Helvetica, sans-serif;
            font-size: 12px;
        }

        .watermark {
            position: fixed;
            top: 40%;
            left: 20%;
            opacity: 0.05;
            font-size: 80px;
            transform: rotate(-30deg);
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

        .judul {
            font-size: 14px;
            font-weight: bold;
            margin-top: 15px;
            margin-bottom: 10px;
        }

        .garis {
            border-top: 3px solid black;
            border-bottom: 1px solid black;
            margin-top: 5px;
            margin-bottom: 15px;
        }

        .nomor {
            margin-top: 5px;
            font-size: 11px;
        }

        .summary-box {
            border: 0px solid #000;
            padding: 8px;
            margin: 10px 0;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th,
        td {
            border: 1px solid #000;
            padding: 5px;
        }

        th {
            background: #eaeaea;
        }

        .footer {
            margin-top: 40px;
        }

        .qr-box {
            position: absolute;
            bottom: 50px;
            left: 30px;
            text-align: center;
            font-size: 9px;
        }
    </style>
</head>

<body>

    <div class="watermark">DOKUMEN RESMI</div>

    <!-- KOP SURAT -->
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

    <div class="nomor">
        Nomor Dokumen : {{ $nomor_dokumen }}<br>
        Tahun Anggaran : {{ request('tahun') ?? 'Semua Tahun' }}
    </div>

    <div class="judul text-center">
        <div style="font-size:13px; font-weight:bold;">
            LAPORAN PROGRES PROYEK
        </div>
    </div>

    <div class="summary-box">
        <strong>Ringkasan Eksekutif:</strong><br>
        Total Proyek : {{ $total }} <br>
        On Track : {{ $onTrack }} <br>
        Selesai : {{ $selesai }}
    </div>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nomor Kontrak</th>
                <th>Nama Proyek</th>
                <th>Nilai Kontrak</th>
                <th>Progress</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach($data as $i => $row)
            <tr>
                <td class="text-center">{{ $i+1 }}</td>
                <td>{{ $row->nomor_kontrak ?? '-' }}</td>
                <td>{{ $row->nm_pekerjaan ?? '-' }}</td>
                <td class="text-right">
                    Rp {{ number_format($row->pagu_anggaran ?? 0,0,',','.') }}
                </td>
                <td class="text-center">
                    {{ $row->progress_summary ?? 0 }}%
                </td>
                <td>
                    {{ ucwords(str_replace('_',' ', $row->status_progress ?? '-')) }}
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="footer text-right">
        Bandung Barat, {{ now()->format('d F Y') }}<br><br>
        Kepala Dinas<br><br><br><br>
        (_______________________)
    </div>

    <!-- QR CODE -->
    <div class="qr-box">
        <img src="data:image/png;base64,{{ $qr }}">
        <br>
        Scan untuk verifikasi<br>
        Kode: {{ $token }}
    </div>
</body>

</html>
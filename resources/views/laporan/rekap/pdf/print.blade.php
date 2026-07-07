<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">

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

        .judul {
            font-size: 12px;
            font-weight: bold;
            margin-top: 20px;
            margin-bottom: 10px;
        }

        .garis {
            border-top: 3px solid black;
            border-bottom: 1px solid black;
            margin-top: 5px;
            margin-bottom: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th,
        td {
            font-size: 9px;
            border: 1px solid #333;
            padding: 3px;
        }

        th {
            background: #e8f1ff;
        }

        .opd {
            background: #d9d9d9;
            font-weight: bold;
        }

        .pekerjaan {
            background: #eef6ff;
            font-weight: bold;
        }

        .total {
            background: #f5f5f5;
            font-weight: bold;
        }


        hr {
            border: 1px solid #000;
            margin-top: 5px;
        }

        .footer {
            margin-top: 40px;
        }

        .page-footer {
            position: fixed;
            bottom: -30px;
            left: 0;
            right: 0;
            height: 50px;
            text-align: center;
            font-size: 10px;
        }


        .qr-box {

            text-align: center;
            font-size: 9px;
        }




        .page-footer table,
        .page-footer table th,
        .page-footer table td {
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
        LAPORAN PROYEK TAHUNAN
    </div>
    <!-- FILTER INFO -->
    <table style="margin-bottom:15px;border:none;">
        <tr>
            <td style="border:none;" width="50">Tahun</td>
            <td style="border:none;" width="5">:</td>
            <td style="border:none;">{{ $request->tahun ?? 'Semua' }}</td>
        </tr>
        @if($request->status)
        <tr>
            <td style="border:none;">Status</td>
            <td style="border:none;">:</td>
            <td style="border:none;">{{ $request->status ?? 'Semua' }}</td>
        </tr>
        @endif
    </table>

    <table class="table table-bordered table-striped align-middle">
        <thead class="table-light">
            <tr>
                <th width="20">No</th>
                <th>Nama Pekerjaan</th>
                <th>Status</th>
                <th>Progress (%)</th>
                <th class="text-center">Sub Pekerjaan</th>
                <th class="text-center">Pengawasan</th>
                <th class="text-center">Foto</th>
                <th class="text-center">Kendala</th>
            </tr>
        </thead>
        <tbody>
            @php $n = 1; @endphp
            @forelse($data as $row)
            <tr>
                <td class="text-center">{{ $n++ }}</td>

                <td>
                    <strong>{{ $row->nm_pekerjaan }}</strong>
                </td>

                <td>
                    @php
                    $warna = match($row->status_progress){
                    'on_progress' => 'primary',
                    'verifikasi' => 'warning',
                    'selesai' => 'success',
                    default => 'secondary'
                    };
                    @endphp

                    <span class="badge bg-{{ $warna }}">
                        {{ strtoupper(str_replace('_',' ',$row->status_progress)) }}
                    </span>
                </td>
                <td class="text-center">
                    {{ $row->progress }}
                </td>
                <td class="text-center">
                    {{ $row->total_sub_pekerjaan }}
                </td>

                <td class="text-center">
                    {{ $row->total_pengawasan }}
                </td>

                <td class="text-center">
                    {{ $row->total_foto }}
                </td>

                <td class="text-center">
                    @if($row->total_kendala > 0)
                    <span class="badge bg-danger">
                        {{ $row->total_kendala }}
                    </span>
                    @else
                    <span class="badge bg-success">0</span>
                    @endif
                </td>

            </tr>
            @empty

            <tr>
                <td colspan="7" class="text-center text-muted">
                    Tidak ada data
                </td>
            </tr>

            @endforelse

        </tbody>
    </table>

    <br><br>

    <table width="100%" style="border:0">
        <tr style="border:0">
            <td width="30%" style="border:0">
                <div class="qr-box">
                    <img src="data:image/png;base64,{{ $qr }}">
                    <br>
                    Scan untuk verifikasi<br>
                    Kode: {{ $token }}
                </div>
            </td>
            <td width="30%" style="border:0"></td>

            <td style="border:0;text-align:center">

                Bandung Barat, {{ date('d F Y') }}

                <br><br><br><br>

                <b>Pejabat Penanggung Jawab</b>

            </td>

        </tr>
    </table>

    <script type="text/php">
        if (isset($pdf)) {
    
        $font = $fontMetrics->get_font("Helvetica", "normal");
        $size = 9;
    
        $text = "Halaman {PAGE_NUM} dari {PAGE_COUNT}";
    
        $y = $pdf->get_height() - 28;
        $x = $pdf->get_width() / 2 - 60;
    
        $pdf->page_text($x, $y, $text, $font, $size);
    }
    </script>


    <div class="page-footer" style="border-top:solid 1px gray;">
        <table width="100%">
            <tr>
                <td width="33%">Dicetak: {{ date('d-m-Y H:i') }}</td>

                <td width="33%" class="text-center">
                    <span class="page-number"></span>
                </td>

                <td width="33%" class="text-right">
                    Sistem Monitoring Proyek
                </td>
            </tr>
        </table>
    </div>
</body>

</html>
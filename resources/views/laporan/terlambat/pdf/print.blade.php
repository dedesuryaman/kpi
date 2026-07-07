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
        LAPORAN PROYEK TERLAMBAT
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
        @if($opdName)
        <tr>
            <td style="border:none;">OPD</td>
            <td style="border:none;">:</td>
            <td style="border:none;">{{ $opdName ?? '-' }}</td>
        </tr>
        @endif
    </table>

    <table>
        <thead>
            <tr>
                <th width="10">No</th>
                <th colspan="2">Proyek</th>
                <th width="120">Anggaran</th>
                <th width="90">Mulai</th>
                <th width="90">Selesai</th>
                <th width="70">Progress</th>
                <th width="120">Status</th>
            </tr>
        </thead>

        <tbody>

            @php
            $lastOpd = null;
            $opdIndex = 0;
            @endphp

            @foreach($data as $row)

            @if($lastOpd != $row->subKegiatan?->nm_sub_unit)

            @php
            $opdIndex++;
            $lastOpd = $row->subKegiatan?->nm_sub_unit;
            @endphp

            <tr class="opd">
                <td>{{ $opdIndex }}</td>
                <td colspan="7">
                    {{ $lastOpd }}
                </td>
            </tr>

            @endif



            @php
            $isTerlambat = $row->tanggal_selesai
            ? \Carbon\Carbon::parse($row->tanggal_selesai)->lt(now())
            : false;
            @endphp

            <tr class="{{ $isTerlambat ? 'table-warning' : 'table-primary' }}">
                <td style="border:none;border-left:solid 1px;"></td>
                <td colspan="2"><strong>{{ $row->nm_pekerjaan ?? '-' }}</strong></td>
                <td class="text-end"><strong>{{ number_format($row->pagu_anggaran ?? 0) }}</strong></td>
                <td><strong>{{ $row->tanggal_mulai
                        ? \Carbon\Carbon::parse($row->tanggal_mulai)->translatedFormat('d M Y')
                        : '-' }}</strong></td>
                <td><strong>{{ $row->tanggal_mulai
                        ? \Carbon\Carbon::parse($row->tanggal_selesai)->translatedFormat('d M Y')
                        : '-' }}</strong></td>
                <td class="text-center"><strong>{{ $row->progress ?? '0' }} %</td>
                <td>
                    @php
                    $status = [
                    'on_progress' => '<span class="text-primary">ON PROGRESS</span>',
                    'draft' => '<span class="text-secondary">DRAFT</span>',
                    'verifikasi' => '<span class="text-warning">VERIFIKASI</span>',
                    'selesai' => '<span class="text-success">SELESAI DISETUJUI</span>'
                    ];
                    @endphp
                    <strong>
                        {!! $status[$row->status_progress] ?? '-' !!}
                    </strong>
                </td>

            </tr>

            <tr class="pekerjaan">
                <td style="border:none;border-left:solid 1px;"></td>
                <td colspan="7">
                    Sub Pekerjaan

                </td>

            </tr>

            @php
            $totalAnggaran = 0;
            $totalProgress = 0;
            $jumlah = $row->subPekerjaan->count();
            @endphp

            @foreach($row->subPekerjaan as $sub)

            @php
            $totalAnggaran += $sub->anggaran ?? 0;
            $totalProgress += $sub->persentase_progress ?? 0;
            @endphp

            <tr>
                <td style="border:none;border-left:solid 1px;"></td>
                <td style="border:none;border-left:solid 1px; " width="10px;"></td>
                <td>{{ $sub->judul }}</td>

                <td class="text-right">
                    Rp {{ number_format($sub->anggaran,0,',','.') }}
                </td>

                <td class="text-center">
                    {{ $sub->tanggal_mulai }}
                </td>

                <td class="text-center">
                    {{ $sub->tanggal_selesai }}
                </td>

                <td class="text-center">
                    {{ $sub->persentase_progress }} %
                </td>

                <td class="text-center">
                    {{ strtoupper($sub->status_progress) }}
                </td>
            </tr>

            @endforeach


            <tr class="total">
                <td style="border:none;border-left:solid 1px;border-bottom:solid:1px;"></td>
                <td style="border:none; border-left:solid 1px;border-bottom:solid:1px;"></td>
                <td class="text-right">TOTAL</td>

                <td class="text-right">
                    Rp {{ number_format($totalAnggaran,0,',','.') }}
                </td>

                <td colspan="2"></td>

                <td class="text-center">
                    {{ $jumlah ? number_format($totalProgress/$jumlah,2) : 0 }} %
                </td>

                <td></td>
            </tr>

            @endforeach

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
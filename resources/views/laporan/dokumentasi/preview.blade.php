<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <title>Album Dokumentasi Proyek</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            background: #f5f6fa;
            font-size: 14px;
        }

        .page {
            background: white;
            padding: 30px;
            margin: 30px auto;
            max-width: 1000px;
            box-shadow: 0 0 10px rgba(0, 0, 0, .05);
        }

        .kop {
            border-bottom: 3px solid black;
            padding-bottom: 15px;
            margin-bottom: 25px;
        }

        .logo {
            width: 70px;
        }

        .kop-title {
            font-weight: 700;
            font-size: 20px;
            letter-spacing: 1px;
        }

        .kop-sub {
            font-size: 14px;
        }

        .alamat {
            font-size: 12px;
        }

        table {
            width: 100%;
        }

        th {
            background: #f1f1f1;
            text-align: center;
        }

        td,
        th {
            border: 1px solid #ddd;
            padding: 8px;
            vertical-align: top;
        }

        .foto {
            width: 180px;
            border-radius: 6px;
        }

        .btn-print {
            margin-bottom: 20px;
        }

        /* PRINT STYLE */
        @media print {

            body {
                background: white;
            }

            .btn-print {
                display: none;
            }

            .page {
                box-shadow: none;
                margin: 0;
                max-width: 100%;
            }

            .foto {
                width: 150px;
            }

        }
    </style>
</head>

<body>

    <div class="container">

        <div class="text-end btn-print">
            <button onclick="window.print()" class="btn btn-primary">
                Print / Simpan PDF
            </button>
        </div>

        <div class="page">

            <!-- KOP SURAT -->
            <div class="kop">
                <div class="row align-items-center">

                    <div class="col-2">
                        <img src="{{ asset('assets/images/logo.png') }}" class="logo">
                    </div>

                    <div class="col-10 text-center">
                        <div class="kop-title">
                            PEMERINTAH KABUPATEN BANDUNG BARAT
                        </div>
                        <div class="alamat">
                            Jl. Raya Padalarang - Cisarua Km 2, Ngamprah, Kabupaten Bandung Barat, Jawa Barat
                        </div>
                        <br>
                        <div class="kop-sub">
                            LAPORAN DOKUMENTASI PENGAWASAN PROYEK
                        </div>


                    </div>

                </div>
            </div>



            @foreach($data as $proyek_id => $rows)

            <h5 class="mb-3">
                {{ $rows->first()->subPekerjaan->pekerjaan->nm_pekerjaan ?? '-' }}
            </h5>
            @php $no = 1; @endphp
            <table class="table table-bordered">

                <thead>
                    <tr>
                        <th width="60">No</th>
                        <th>Catatan Pengawasan</th>
                        <th width="220">Foto</th>
                    </tr>
                </thead>

                <tbody>

                    @foreach($rows as $row)

                    <tr>

                        <td class="text-center">
                            {{ $no++ }}
                        </td>

                        <td>
                            <div class="">
                                <strong>Tanggal :</strong>
                                {{ \Carbon\Carbon::parse($row->waktu_pengawasan)->translatedFormat('d F Y') }}
                            </div>
                            <div class="mt-1">
                                Sub : {{ $row->subPekerjaan?->judul ?? '-' }}
                            </div>

                            <div class="mt-1">
                                Pos : {{ $row->posPengawasan?->nm_pos ?? '-' }}
                            </div>
                            <div class="mt-1">
                                Lokasi : {{ $row->posPengawasan?->nm_lokasi ?? '-' }}
                            </div>
                            <div class="mt-1">
                                Alamat : {{ $row->alamat ?? '-' }}
                            </div>
                            <div class="mt-1">
                                Catatan : {{ $row->catatan ?? '-' }}
                            </div>
                            <div class="mt-1">
                                Lat/Lng : {{ ($row->latitude ?? '') . '/' . ($row->longitude ?? '') }}
                            </div>
                        </td>

                        <td class="text-center">

                            @if($row->foto_path && Storage::disk('public')->exists($row->foto_path))
                            <img src="{{ asset('storage/'.$row->foto_path) }}" class="foto">
                            @else
                            <img src="{{ asset('assets/images/no-image.png') }}" class="foto">
                            @endif

                        </td>

                    </tr>

                    @endforeach

                </tbody>

            </table>

            <br>

            @endforeach

        </div>

    </div>

</body>

</html>
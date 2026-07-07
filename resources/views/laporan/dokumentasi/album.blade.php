<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <style>
        body {
            font-family: sans-serif;
            font-size: 12px;
        }

        .page-break {
            page-break-after: always;
        }

        .header {
            text-align: center;
            margin-bottom: 20px;
        }

        .grid {
            width: 100%;
        }

        .item {
            width: 48%;
            display: inline-block;
            margin-bottom: 20px;
        }

        img {
            width: 100%;
            height: 200px;
            object-fit: cover;
        }

        .title {
            font-weight: bold;
            margin-top: 5px;
        }
    </style>
</head>

<body>

    <div class="header">
        <h2>PEMERINTAH KABUPATEN BANDUNG BARAT</h2>
        <h3>ALBUM DOKUMENTASI PROYEK</h3>
        Tahun {{ $tahun ?? date('Y') }}
    </div>

    <hr>

    @foreach($data->chunk(4) as $chunk)

    <div class="grid">

        @foreach($chunk as $row)

        <div class="item">

            @if($row->foto_path && Storage::disk('public')->exists($row->foto_path))
            <img src="{{ asset('storage/'.$row->foto_path) }}" class="card-img-top"
                data-img="{{ asset('storage/'.$row->foto_path) }}" style="cursor:pointer;">
            @else
            <img src="{{ asset('assets/images/no-image.png') }}" class="card-img-top"
                data-img="{{ asset('assets/images/no-image.png') }}" style="cursor:pointer;">
            @endif

            <div class="title">
                {{ $row->pekerjaan->nm_pekerjaan ?? '-' }}
            </div>

            <div>
                Tanggal : {{ date('d M Y',strtotime($row->waktu_pengawasan)) }}
            </div>

            <div>
                {{ $row->catatan }}
            </div>

        </div>

        @endforeach

    </div>

    <div class="page-break"></div>

    @endforeach

</body>

</html>
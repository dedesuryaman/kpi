@extends('layouts.admin.app')
@push('title', 'Monitoring Proyek')

@push('styles')
<style>
    .legend-toggle {
        position: absolute;
        top: 10px;
        right: 10px;
        z-index: 999;
    }

    /* PANEL */
    .legend-panel {
        position: absolute;
        top: 80px;
        right: -280px;
        /* tersembunyi */
        width: 260px;
        padding: 15px;
        background: rgb(187 187 187 / 55%);
        backdrop-filter: blur(6px);
        color: #fff;
        border-radius: 12px 0 0 12px;
        transition: all 0.35s ease;
        z-index: 999;
    }

    /* Saat aktif */
    .legend-panel.show {
        right: 11px;
    }

    /* Dot warna */
    .dot {
        display: inline-block;
        width: 14px;
        height: 14px;
        border-radius: 50%;
        margin-right: 8px;
    }

    .selesai {
        background: green;
    }

    .berjalan {
        background: orange;
    }

    .terlambat {
        background: red;
    }

    /* RESPONSIVE */
    @media (max-width: 576px) {
        .legend-panel {
            width: 200px;
            font-size: 14px;
        }
    }

    .search-wrapper {
        position: absolute;
        left: 5vw;
        top: 1rem;
        z-index: 1000;
    }

    .result-search {
        position: absolute;
        z-index: 9999;
    }

    .result-search .list-group {
        max-height: 400px;
        overflow-y: scroll;
    }

    .text-left {
        text-align: left !important;
    }

    .list-group {
        display: -ms-flexbox;
        display: flex;
        -ms-flex-direction: column;
        flex-direction: column;
        padding-left: 0;
        margin-bottom: 0;
        border-radius: .25rem;
    }

    /*==================================*/
    .pengawasan-card {
        transition: all 0.2s ease-in-out;
    }

    .pengawasan-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 8px 20px rgba(0, 0, 0, .08);
    }

    .pengawasan-img {
        height: 180px;
        overflow: hidden;
    }

    .pengawasan-img img {
        width: 100%;
        height: 180px;
        object-fit: cover;
    }

    .img-overlay {
        position: absolute;
        inset: 0;
        background: linear-gradient(to top,
                rgba(0, 0, 0, 0.55),
                rgba(0, 0, 0, 0.15),
                rgba(0, 0, 0, 0));
    }

    .img-caption {
        position: absolute;
        bottom: 10px;
        left: 10px;
    }
</style>
@endpush


@section('content')


<div class="row">
    <div class="col-12">
        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
            <h4 class="mb-sm-0 font-size-18">Monitoring Pengawasan</h4>

            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="javascript: void(0);">Monitoring</a></li>
                    <li class="breadcrumb-item active">Pengawasan Proyek</li>
                </ol>
            </div>

        </div>
    </div>
</div>


<div class="row">
    <div class="col-md-8">
        <div id="grafikPengawasan" style="height: 400px;"></div>




    </div>
    <div class="col-md-4">
        <div id="piePengawasan" style="height: 400px;"></div>




    </div>

</div>
<hr>
<div class="row">
    <div class="col-12">
        <div class="row g-2"> {{-- g-2 = jarak lebih rapat --}}
            @foreach($pengawasans as $row)
            <div class="col-xl-2 col-lg-3 col-md-4 col-sm-6">
                <div class="card border-0 shadow-sm h-100">

                    {{-- FOTO --}}
                    <div class="position-relative">
                        @if($row->foto_url)
                        <img src="{{ $row->foto_url }}" class="img-fluid w-100 rounded-top"
                            style="height:130px; object-fit:cover;">
                        @else
                        <div class="bg-light d-flex align-items-center justify-content-center rounded-top"
                            style="height:130px;">
                            <i class="bi bi-image text-muted"></i>
                        </div>
                        @endif

                        {{-- TEXT OVER FOTO --}}
                        <div class="position-absolute bottom-0 start-0 w-100 px-1 py-1"
                            style="background:rgba(0,0,0,.55); font-size:9px;">
                            <div class="text-white fw-semibold text-truncate">
                                {{ $row->posPengawasan->nm_lokasi ?? '-' }}
                            </div>
                            <div class="text-white-50 text-truncate">
                                {{ $row->alamat ?? '-' }}
                            </div>
                        </div>
                    </div>

                    {{-- BODY --}}
                    <div class="card-body p-2 small text-secondary">
                        <div class="text-dark fw-semibold text-truncate">
                            🏗 {{ $row->pekerjaan->nm_pekerjaan ?? '-' }}
                        </div>

                        <div class="text-muted text-truncate">
                            🏢 {{ $row->posPengawasan->nm_pos ?? '-' }}
                        </div>

                        <div class="text-muted" style="font-size:10px; line-height:1.2;">
                            📸 {{ Str::limit($row->kondisi_lapangan, 45) }}
                        </div>

                        <div class="text-muted mt-1" style="font-size:9px;">
                            📅 {{ tanggalIndoSm($row->waktu_pengawasan ?? '') }} |
                            📍 {{ $row->latitude ?? '-' }}, {{ $row->longitude ?? '-' }}
                        </div>
                    </div>

                    {{-- FOOTER --}}
                    @if($row->foto_url)
                    <div class="card-footer p-1 bg-white border-top-0">
                        <button type="button" class="btn btn-outline-secondary btn-sm w-100 py-0"
                            style="font-size:11px;" data-bs-toggle="modal" data-bs-target="#modalFotoPengawasan"
                            data-img="{{ $row->foto_url }}"
                            data-title="{{ $row->posPengawasan->nm_lokasi ?? 'Foto Pengawasan' }}">
                            <i class="fa fa-eye"></i> Foto
                        </button>
                    </div>
                    @endif

                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>

<div class="modal fade" id="modalFotoPengawasan" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg modal-dialog-scrollable">
        <div class="modal-content border-0">

            <div class="modal-header py-2">
                <h6 class="modal-title" id="modalFotoTitle">Foto Pengawasan</h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body p-2 text-center bg-light">
                <img id="modalFotoImg" src="" class="img-fluid rounded" style="max-height:75vh;">
            </div>

        </div>
    </div>
</div>

@endsection

@push('js')
<script src="https://code.highcharts.com/highcharts.js"></script>
<script src="https://code.highcharts.com/modules/accessibility.js"></script>
@endpush
@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
    const modal = document.getElementById('modalFotoPengawasan');

    modal.addEventListener('show.bs.modal', function (event) {
        const button = event.relatedTarget;
        const imgUrl = button.getAttribute('data-img');
        const title = button.getAttribute('data-title');

        modal.querySelector('#modalFotoImg').src = imgUrl;
        modal.querySelector('#modalFotoTitle').textContent = title;
    });
});
</script>

<script>
    (() => {
    document.addEventListener("DOMContentLoaded", function () {

        const container = document.getElementById("piePengawasan");
        if (!container) return; // aman kalau div tidak ditemukan

        Highcharts.chart('piePengawasan', {
            chart: {
                type: 'pie'
            },
            title: {
                text: 'Persentase Status Pengawasan Proyek'
            },
            tooltip: {
                pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b> ({point.y})'
            },
            plotOptions: {
                pie: {
                    allowPointSelect: true,
                    cursor: 'pointer',
                    dataLabels: {
                        enabled: true,
                        format: '<b>{point.name}</b>: {point.percentage:.1f} %'
                    }
                }
            },
            series: [{
                name: 'Persentase',
                colorByPoint: true,
                data: [
                    { name: 'Kritikal', y: {{ $pieData['kritikal'] }} },
                    { name: 'Normal',   y: {{ $pieData['normal'] }} },
                    { name: 'Deviasi',  y: {{ $pieData['deviasi'] }} },
                    { name: 'Selesai',  y: {{ $pieData['selesai'] }} }
                ]
            }]
        });
    });
})();
</script>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        
            Highcharts.chart('piePengawasan', {
                chart: {
                    type: 'pie'
                },
                title: {
                    text: 'Persentase Status Pengawasan Proyek'
                },
                tooltip: {
                    pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b> ({point.y})'
                },
                plotOptions: {
                    pie: {
                        allowPointSelect: true,
                        cursor: 'pointer',
                        dataLabels: {
                            enabled: true,
                            format: '<b>{point.name}</b>: {point.percentage:.1f} %'
                        }
                    }
                },
                series: [{
                    name: 'Persentase',
                    colorByPoint: true,
                    data: [
                        { name: 'Kritikal', y: {{ $pieData['kritikal'] }} },
                        { name: 'Normal',   y: {{ $pieData['normal'] }} },
                        { name: 'Deviasi',  y: {{ $pieData['deviasi'] }} },
                        { name: 'Selesai',  y: {{ $pieData['selesai'] }} }
                    ]
                }]
            });
        
        });
 
    document.addEventListener("DOMContentLoaded", function () {
        
            Highcharts.chart('grafikPengawasan', {
                chart: {
                    type: 'column'
                },
                title: {
                    text: 'Jumlah Laporan Pengawasan per Bulan ({{ date("Y") }})'
                },
                xAxis: {
                    categories: [
                        'Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun',
                        'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'
                    ],
                    crosshair: true
                },
                yAxis: {
                    min: 0,
                    title: {
                        text: 'Jumlah Laporan'
                    }
                },
                tooltip: {
                    shared: true,
                    valueSuffix: ' laporan'
                },
                series: [{
                    name: 'Laporan',
                    data: @json($bulanData),
                    colorByPoint: true,
                    borderRadius: 5
                }]
            });
        
        });
</script>
@endpush
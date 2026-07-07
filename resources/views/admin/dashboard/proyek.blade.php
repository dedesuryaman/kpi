@extends('layouts.admin.app')
@push('title', 'Dashboard >> Proyek')
@push('css')
<script src="https://code.highcharts.com/highcharts.js"></script>
@endpush
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
</style>
@endpush

@section('content')
<div class="row">
    <div class="col-12">
        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
            <h4 class="mb-sm-0 font-size-18">Dashboard</h4>

            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="javascript: void(0);">Dashboards</a></li>
                    <li class="breadcrumb-item active">Proyek</li>
                </ol>
            </div>

        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-12 col-lg-4 mb-2">
        <a href="#" class="d-block --xhr" data-toggle="tooltip" title="Anggaran Keuangan">
            <div class="card border-0 bg-primary text-center text-sm-start" style="overflow:hidden">
                <div class="row">
                    <div class="col-sm-4">
                        <div class="p-3 text-center" style="background:rgba(0, 0, 0, .1)"> <i
                                class="fa fa-file fa-4x text-light"> </i> </div>
                    </div>
                    <div class="col-sm-7 p-0">
                        <h6 class="mt-1 text-truncate text-light"> Anggaran </h6>
                        <h6 class="mt-1 text-truncate text-light"> Rp. 2.315.127.742.700 </h6>
                        <div class="progress" style="height:8px">
                            <div class="progress-bar bg-warning progress-bar-striped progress-bar-animated"
                                role="progressbar" style="width: 66.434230604574%" aria-valuenow=" 66.434230604574"
                                aria-valuemin="0" aria-valuemax="100">
                            </div>
                        </div>
                        <h6 class="text-truncate text-light" style="font-size:12px;"> 66,43% sampai dengan Bulan
                            Desember </h6>
                    </div>
                </div>
            </div>
        </a>
    </div>
    <div class="col-md-12 col-lg-4 mb-2">
        <a href="#" class="d-block --xhr" data-toggle="tooltip" title="Realisasi">
            <div class="card border-0 bg-info text-center text-sm-start" style="overflow:hidden">
                <div class="row">
                    <div class="col-sm-4">
                        <div class="p-3 text-center" style="background:rgba(0, 0, 0, .1)"> <i
                                class="fa fa-file fa-4x text-light"> </i> </div>
                    </div>
                    <div class="col-sm-7 p-0">
                        <h6 class="mt-1 text-truncate text-light"> Realisasi </h6>
                        <h6 class="mt-1 text-truncate text-light"> Rp. 2.315.127.742.700 </h6>
                        <div class="progress" style="height:8px">
                            <div class="progress-bar bg-warning progress-bar-striped progress-bar-animated"
                                role="progressbar" style="width: 66.434230604574%" aria-valuenow=" 66.434230604574"
                                aria-valuemin="0" aria-valuemax="100">
                            </div>
                        </div>
                        <h6 class="text-truncate text-light" style="font-size:12px;"> 66,43% sampai dengan Bulan
                            Desember </h6>
                    </div>
                </div>
            </div>
        </a>
    </div>
    <div class="col-md-12 col-lg-4 mb-2">
        <a href="#" class="d-block --xhr" data-toggle="tooltip" title="Deviasi">
            <div class="card border-0 bg-success text-center text-sm-start" style="overflow:hidden">
                <div class="row">
                    <div class="col-sm-4">
                        <div class="p-3 text-center" style="background:rgba(0, 0, 0, .1)"> <i
                                class="fa fa-file fa-4x text-light"> </i> </div>
                    </div>
                    <div class="col-sm-7 p-0">
                        <h6 class="mt-1 text-truncate text-light"> Deviasi </h6>
                        <h6 class="mt-1 text-truncate text-light"> Rp. 2.315.127.742.700 </h6>
                        <div class="progress" style="height:8px">
                            <div class="progress-bar bg-warning progress-bar-striped progress-bar-animated"
                                role="progressbar" style="width: 66.434230604574%" aria-valuenow=" 66.434230604574"
                                aria-valuemin="0" aria-valuemax="100">
                            </div>
                        </div>
                        <h6 class="text-truncate text-light" style="font-size:12px;"> 66,43% sampai dengan Bulan
                            Desember </h6>
                    </div>
                </div>
            </div>
        </a>
    </div>
</div>
<div class="row">
    <div class="col-md-8">
        <div id="linePenyerapanChart" class="mb-3"></div>
    </div>
    <div class="col-md-4">
        <div id="projectStatusChart" class="mb-3"></div>
    </div>
</div>
<hr>
<div class="row">
    @foreach($projects as $row)
    <div class="col-md-4 mb-3">
        <a href="{{ url('/sub-kegiatan/pekerjaan/sub-pekerjaan/show?id=') . $row->id }}"
            class="text-decoration-none text-dark">
            <div class="card border border-primary h-100">

                <div class="card-body d-flex flex-column">
                    <!-- penting: flex column -->

                    <h5 class="card-title">{{ $row->nm_pekerjaan ?? '-' }}</h5>

                    <p class="card-text">
                        {{ Str::limit($row->deskripsi, 100) }}
                    </p>

                    <!-- progress bar dibawah (mt-auto memastikan selalu di bawah) -->
                    <div class="mt-auto pt-3">
                        <h6 class="card-title">Status / Progress</h6>

                        @php
                        $percent = $row->progress_summary;
                        if ($percent < 50) { $colorClass='bg-danger' ; } elseif ($percent < 80) {
                            $colorClass='bg-warning' ; } else { $colorClass='bg-success' ; } @endphp <div
                            class="progress" style="height: 15px;">
                            <div class="progress-bar {{ $colorClass }}" role="progressbar"
                                style="width: {{ number_format($percent,2) }}%;"
                                aria-valuenow="{{ number_format($percent,2) }}" aria-valuemin="0" aria-valuemax="100">
                                {{ number_format($percent,2) }}%
                            </div>
                    </div>
                </div>

            </div>

    </div>
    </a>
</div>
@endforeach
</div>
@endsection

@push('css')
<link rel="stylesheet" href="{{ asset('vendor/leaflet/leaflet.css') }}" />
<link rel="stylesheet" href="{{ asset('assets/css/L.Icon.Pulse.css') }}">
<link rel="stylesheet" href="{{ asset('assets/css/leaflet.awesome-markers.css') }}">
<link rel="stylesheet" href="{{ asset('vendor/leaflet-search/leaflet-search.min.css') }}">
<link rel="stylesheet" href="{{ asset('assets/css/leaflet-routing-machine.css') }}" />
<link rel="stylesheet" href="{{ asset('vendor/leaflet-markercluster/MarkerCluster.css') }}" />
<link rel="stylesheet" href="{{ asset('vendor/leaflet-markercluster/MarkerCluster.Default.css') }}" />
<link rel="stylesheet" href="{{ asset('vendor/leaflet-beautify-marker/leaflet-beautify-marker-icon.css') }}" />

@endpush

@push('js')
<script src="{{ asset('vendor/leaflet/leaflet.js') }}"></script>
<script src="{{ asset('assets/js/MovingMarker.js') }}"></script>
<script src="{{ asset('assets/js/L.Icon.Pulse.js') }}"></script>
<script src="{{ asset('assets/js/leaflet.awesome-markers.js') }}"></script>
<script src="{{ asset('vendor/leaflet-search/leaflet-search.min.js') }}"></script>
<script src="{{ asset('vendor/leaflet-markercluster/leaflet.markercluster-src.js') }}"></script>
<script src="{{ asset('vendor/leaflet-beautify-marker/leaflet-beautify-marker-icon.js') }}"></script>
<script src="https://kit.fontawesome.com/c75f60c9db.js" crossorigin="anonymous"></script>
<script src="{{ asset('assets/js/leaflet-routing-machine.js') }}"></script>


<script src="https://code.highcharts.com/highcharts.js"></script>
<script src="https://code.highcharts.com/highcharts-3d.js"></script>
<script>
    document.addEventListener("DOMContentLoaded", () => {

    Highcharts.chart('linePenyerapanChart', {
        chart: {
            type: 'line'
        },

        title: {
            text: 'Penyerapan Anggaran Bulanan'
        },

        xAxis: {
            categories: {!! json_encode($months) !!}
        },

        yAxis: {
            title: {
                text: 'Persentase (%)'
            }
        },

        tooltip: {
            shared: true,
            crosshairs: true,
            valueSuffix: '%'
        },

        series: [
            {
                name: 'Rencana (RPD)',
                data: {!! json_encode($rpd) !!},
                color: '#0d6efd',
                lineWidth: 3
            },
            {
                name: 'Realisasi',
                data: {!! json_encode($realisasi) !!},
                color: '#198754',
                lineWidth: 3
            },
            {
                name: 'Deviasi',
                data: {!! json_encode($deviasi) !!},
                color: '#dc3545',
                dashStyle: 'ShortDash',
                lineWidth: 2
            }
        ]
    });
});
</script>

<script>
    document.addEventListener("DOMContentLoaded", function () {

    Highcharts.chart('projectStatusChart', {
        chart: {
            type: 'pie',
            backgroundColor: null,
            options3d: {
                enabled: true,
                alpha: 45,
                beta: 0,
                depth: 60
            }
        },

        title: {
            text: 'Persentase Status Proyek'
        },

        tooltip: {
            pointFormat: '<b>{point.percentage:.1f}%</b>'
        },

        plotOptions: {
            pie: {
                allowPointSelect: true,
                depth: 45,
                cursor: 'pointer',
                innerSize: 0, /* jika ingin donut -> ubah ke 50 */
                dataLabels: {
                    enabled: true,
                    format: '<b>{point.name}</b><br>{point.percentage:.1f} %',
                    style: {
                        fontSize: '12px',
                        color : 'dark',
                        textOutline: 'none'
                    }
                },
                showInLegend: true
            },
            series: {
                animation: {
                    duration: 1000,
                    easing: 'easeOutBounce'
                }
            }
        },

        series: [{
            name: 'Persentase',
            colorByPoint: true,
            data: [
                {
                    name: 'Draft',
                    y: {{ $project_status->draft }},
                    color: '#6c757d',
                    sliced: true,
                    selected: true
                },
                {
                    name: 'On Progress',
                    y: {{ $project_status->on_progress }},
                    color: '#0d6efd'
                },
                {
                    name: 'Selesai',
                    y: {{ $project_status->selesai }},
                    color: '#198754'
                }
            ]
        }]
    });

});
</script>

@endpush
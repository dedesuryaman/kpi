@extends('layouts.admin.app')
@push('title', 'Dashboard')
@push('css')

@endpush
@push('styles')
<style>
    .map-control {
        background: white;
        padding: 6px;
        border-radius: 6px;
        box-shadow: 0 0 6px rgba(0, 0, 0, 0.2);
    }

    .map-control select {
        width: 420px;
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

    .legend {
        background: white;
        padding: 10px 14px;
        border-radius: 8px;
        box-shadow: 0 0 15px rgba(0, 0, 0, 0.2);
        line-height: 18px;
    }

    .legend i {
        width: 18px;
        height: 18px;
        float: left;
        margin-right: 8px;
        opacity: 0.9;
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

    .marker-icon {
        font-size: 22px;
        color: white;
        background: #3498db;
        border-radius: 50%;
        width: 36px;
        height: 36px;
        display: flex;
        align-items: center;
        justify-content: center;
        border: 2px solid white;
    }

    .marker-gedung {
        background: #1e4ce2;
    }

    .marker-jalan {
        background: #2ecc71;
    }

    .legend {
        background: white;
        padding: 10px 12px;
        font-size: 13px;
        color: #333;
        line-height: 18px;
        border-radius: 6px;
        box-shadow: 0 0 8px rgba(0, 0, 0, 0.15);
    }

    .legend-title {
        font-weight: bold;
        margin-bottom: 6px;
    }

    .legend-item {
        display: flex;
        align-items: center;
        margin-bottom: 6px;
    }

    .legend-icon {
        width: 22px;
        height: 22px;
        border-radius: 50%;
        color: white;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-right: 8px;
        font-size: 12px;
    }

    .legend-gedung {
        background: #e74c3c;
    }

    .legend-jalan {
        background: #2ecc71;
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
                    <li class="breadcrumb-item active">Analitic</li>
                </ol>
            </div>

        </div>
    </div>
</div>

<div class="toast-container position-fixed top-0 end-0 p-3" id="toast-container"></div>

<div class="row">
    <div class="col-md-4">
        <div class="card mini-stats-wid border border-primary">
            <a href="{{ url('proyek') }}">
                <div class="card-body">
                    <div class="d-flex">
                        <div class="flex-grow-1">
                            <p class="text-muted fw-medium">Proyek Tahun {{ session('tahun_aktif') }}</p>
                            <h4 class="mb-0">{{ $jumlah_proyek ?? 0 }}</h4>
                        </div>

                        <div class="flex-shrink-0 align-self-center">
                            <div class="mini-stat-icon avatar-sm rounded-circle bg-primary">
                                <span class="avatar-title">
                                    <i class="bx bx-copy-alt font-size-24"></i>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </a>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card mini-stats-wid border border-primary">
            <div class="card-body">
                <div class="d-flex">
                    <div class="flex-grow-1">
                        <p class="text-muted fw-medium">Kontraktor</p>
                        <h4 class="mb-0">{{ $jumlah_kontraktor ?? 0 }}</h4>
                    </div>

                    <div class="flex-shrink-0 align-self-center ">
                        <div class="avatar-sm rounded-circle bg-primary mini-stat-icon">
                            <span class="avatar-title rounded-circle bg-primary">
                                <i class="bx bx-archive-in font-size-24"></i>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card mini-stats-wid border border-primary">
            <div class="card-body">
                <div class="d-flex">
                    <div class="flex-grow-1">
                        <p class="text-muted fw-medium">Pengguna</p>
                        <h4 class="mb-0">{{ $users ?? 0 }}</h4>
                    </div>

                    <div class="flex-shrink-0 align-self-center">
                        <div class="avatar-sm rounded-circle bg-primary mini-stat-icon">
                            <span class="avatar-title rounded-circle bg-primary">
                                <i class="bx bx-purchase-tag-alt font-size-24"></i>
                            </span>
                        </div>
                    </div>
                </div>
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
                                class="fas fa-money-bill fa-4x text-light"> </i> </div>
                    </div>
                    <div class="col-sm-7 p-2">
                        <h2 class="mt-1 text-truncate text-light"> Anggaran </h2>
                        <h6 class="mt-1 text-truncate text-light"> {{ rupiah($anggaran ?? 0) }} </h6>

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
                                class="fas fa-money-bill-wave fa-4x text-light"> </i> </div>
                    </div>
                    <div class="col-sm-7 p-0">
                        <h6 class="mt-1 text-truncate text-light"> Realisasi </h6>
                        <h6 class="mt-1 text-truncate text-light"> {{ rupiah($realisasi ?? 0) }} </h6>
                        <div class="progress" style="height:8px">
                            <div class="progress-bar bg-warning progress-bar-striped progress-bar-animated"
                                role="progressbar" style="width: {{ $persenRealisasi }}%"
                                aria-valuenow="{{ $persenRealisasi }}" aria-valuemin="0" aria-valuemax="100">
                            </div>
                        </div>
                        <h6 class="text-truncate text-light" style="font-size:12px;margin-top:5px;">{{
                            $teksPersenRealisasi ?? '-' }}
                        </h6>
                    </div>
                </div>
            </div>
        </a>
    </div>
    @php
    $deviasi = $deviasi ?? 0;
    $persenDeviasi = $persenDeviasi ?? 0;

    $absPersen = abs($persenDeviasi);
    $absPersen = $absPersen > 100 ? 100 : $absPersen;

    if ($persenDeviasi > 0) {
    $bg = 'bg-success';
    $bar = 'bg-success';
    $icon = 'fa-arrow-up';
    $teks = 'Surplus';
    } elseif ($persenDeviasi < 0) { $bg='bg-danger' ; $bar='bg-danger' ; $icon='fa-arrow-down' ; $teks='Defisit' ; }
        else { $bg='bg-secondary' ; $bar='bg-secondary' ; $icon='fa-minus' ; $teks='Seimbang' ; } @endphp <div
        class="col-md-12 col-lg-4 mb-2">
        <a href="#" class="d-block --xhr" data-toggle="tooltip" title="Deviasi">
            <div class="card border-0 bg-warning text-center text-sm-start" style="overflow:hidden">
                <div class="row">
                    <div class="col-sm-4">
                        <div class="p-3 text-center" style="background:rgba(0, 0, 0, .1)"> <i
                                class="fas fa-money-check fa-4x text-light"> </i> </div>
                    </div>
                    <div class="col-sm-7 p-0">
                        <h6 class="mt-1 text-truncate text-light"> Deviasi </h6>
                        <h6 class="mt-1 text-truncate text-light"> {{ rupiah($deviasi) }} </h6>
                        <div class="progress mt-2" style="height:8px;">
                            <div class="progress-bar {{ $bar }} progress-bar-striped progress-bar-animated"
                                role="progressbar" style="width: {{ $absPersen }}%" aria-valuenow="{{ $absPersen }}"
                                aria-valuemin="0" aria-valuemax="100">
                            </div>
                        </div>
                        <h6 class="text-truncate text-light" style="font-size:12px; margin-top:5px;"> {{
                            number_format($persenDeviasi,2) }}% ({{ $teks }}) </h6>
                    </div>
                </div>
            </div>
        </a>
</div>
</div>

<div class="">
    <div class="row">
        <div class="col-md-8 mb-3">
            <div class="card border border-primary">
                <div class="card-body">
                    <h5><i class="fas fa-chart-bar"></i> Penyerapan Anggaran</h5>
                    <div id="keuanganChart" style="width:100%; height:420px;"></div>
                </div>
            </div>
        </div>
        <div class="col-md-4 mb-3">
            <div class="card border border-primary">
                <div class="card-body">
                    <h5><i class="fas fa-chart-pie"></i> Status Proyek</h5>
                    <div id="projectStatusChart" style="width:100%; height:420px;"></div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="card border border-primary">
    <div class="row card-body">
        <div class="col-md-8 mb-3">
            <div class="col-md-12 mb-3">
                <h5><i class="fas fa-chart-line"></i> Progress Proyek</h5>
                <div id="progressChart" style="width:100%; height:420px;"></div>
                <hr>
                <div id="laporanChart" style="height: 420px;"></div>

            </div>

        </div>
        <div class="col-md-4 mb-3">
            <h5><i class="fas fa-camera-retro"></i> Laporan Pengawasan</h5>
            <div id="statusPengawasanChart" style="height: 420px;"></div>
            <hr>
            <div id="kendalaChart" style="height: 420px;"></div>

            <div id=""></div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-12 mb-3">
        <h5><i class="fas fa-map-marked-alt"></i> Peta Lokasi Proyek</h5>
        <div id="projectMap" style="height: 800px; width: 100%; border-radius: 12px;" class="border border-primary">

        </div>
    </div>

</div>
<style>
    .pendapatan-card {
        border-radius: 14px;
        transition: all .25s ease;
    }

    .pendapatan-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.08);
    }

    .icon-circle {
        width: 42px;
        height: 42px;
        border-radius: 50%;
        background: rgba(13, 110, 253, .1);
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .belanja-card {
        border-radius: 14px;
        transition: all .25s ease;
    }

    .belanja-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 12px 28px rgba(0, 0, 0, 0.08);
    }

    .icon-circle {
        width: 42px;
        height: 42px;
        border-radius: 50%;
        background: rgba(220, 53, 69, .1);
        display: flex;
        align-items: center;
        justify-content: center;
    }
</style>


<HR>
<H4>PENDAPATAN</H4>
<div class="row">

    @foreach($api_pendapatan as $row)

    @php
    $anggaran = (float) $row['anggaran'];
    $realisasi = (float) $row['realisasi'];
    $persen = $anggaran > 0 ? ($realisasi / $anggaran) * 100 : 0;
    @endphp

    <div class="col-md-3 col-sm-6 mb-4">
        <div class="card border-0 shadow-sm h-100 pendapatan-card">
            <div class="card-body">

                <!-- Header -->
                <div class="d-flex justify-content-between align-items-start mb-3">
                    <div class="icon-circle bg-soft-primary">
                        <i class="bi bi-cash-stack text-primary"></i>
                    </div>

                    <span class="badge bg-light text-dark">
                        {{ number_format($persen, 1) }}%
                    </span>
                </div>

                <!-- Title -->
                <h6 class="text-muted small text-uppercase mb-2">
                    {{ $row['nama_4'] }}
                </h6>

                <!-- Anggaran -->
                <div class="mb-1">
                    <small class="text-muted">Anggaran</small>
                    <div class="fw-semibold">
                        Rp {{ number_format($anggaran, 0, ',', '.') }}
                    </div>
                </div>

                <!-- Realisasi -->
                <div class="mb-3">
                    <small class="text-muted">Realisasi</small>
                    <div class="fw-semibold text-success">
                        Rp {{ number_format($realisasi, 0, ',', '.') }}
                    </div>
                </div>

                <!-- Progress Bar -->
                <div class="progress" style="height:6px;">
                    <div class="progress-bar bg-success" role="progressbar" style="width: {{ $persen }}%">
                    </div>
                </div>

            </div>
        </div>
    </div>

    @endforeach

</div>
<hr>
<h4>BELANJA</h4>
<div class="row">

    @foreach($api_belanja as $row)

    @php
    // Total Anggaran
    $anggaran =
    (float)$row['anggaran_operasi'] +
    (float)$row['anggaran_modal'] +
    (float)$row['anggaran_btt'] +
    (float)$row['anggaran_transfer'] +
    (float)$row['anggaran_pengeluaran_pembiayaan'];

    // Total Realisasi
    $realisasi =
    (float)$row['realisasi_operasi'] +
    (float)$row['realisasi_modal'] +
    (float)$row['realisasi_btt'] +
    (float)$row['realisasi_transfer'] +
    (float)$row['realisasi_pengeluaran_pembiayaan'];

    $persen = $anggaran > 0 ? ($realisasi / $anggaran) * 100 : 0;

    // Warna progress dinamis
    if($persen < 50){ $color='danger' ; } elseif($persen < 80){ $color='warning' ; } else { $color='success' ; } @endphp
        <div class="col-md-3 col-sm-6 mb-4">
        <div class="card border-0 shadow-sm h-100 belanja-card">
            <div class="card-body">

                <!-- Header -->
                <div class="d-flex justify-content-between align-items-start mb-3">
                    <div class="icon-circle bg-soft-danger">
                        <i class="bi bi-building text-danger"></i>
                    </div>

                    <span class="badge bg-{{ $color }}-subtle text-{{ $color }}">
                        {{ number_format($persen,1) }}%
                    </span>
                </div>

                <!-- Nama OPD -->
                <h6 class="text-muted small text-uppercase mb-2">
                    {{ $row['nm_unit'] }}
                </h6>

                <!-- Total Anggaran -->
                <div class="mb-1">
                    <small class="text-muted">Total Anggaran</small>
                    <div class="fw-semibold">
                        Rp {{ number_format($anggaran, 0, ',', '.') }}
                    </div>
                </div>

                <!-- Total Realisasi -->
                <div class="mb-3">
                    <small class="text-muted">Total Realisasi</small>
                    <div class="fw-semibold text-{{ $color }}">
                        Rp {{ number_format($realisasi, 0, ',', '.') }}
                    </div>
                </div>

                <!-- Progress -->
                <div class="progress" style="height:6px;">
                    <div class="progress-bar bg-{{ $color }}" style="width: {{ $persen }}%">
                    </div>
                </div>

            </div>
        </div>
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

@push('styles')
<style>
    .custom-marker {
        display: flex;
        align-items: center;
        justify-content: center;
    }
</style>

<style>
    /* Animasi garis putus-putus */
    .highcharts-series-dash path {
        animation: dashmove 2s linear infinite;
    }

    @keyframes dashmove {
        to {
            stroke-dashoffset: -20;
        }
    }
</style>

@endpush
@push('js')
<script src="{{ asset('vendor/leaflet/leaflet.js') }}"></script>
<script src="{{ asset('assets/js/MovingMarker.js') }}"></script>
<script src="{{ asset('assets/js/L.Icon.Pulse.js') }}"></script>
<script src="{{ asset('assets/js/leaflet.awesome-markers.js') }}"></script>
<script src="{{ asset('vendor/leaflet-search/leaflet-search.min.js') }}"></script>
<script src="{{ asset('vendor/leaflet-markercluster/leaflet.markercluster-src.js') }}"></script>
<script src="{{ asset('vendor/leaflet-beautify-marker/leaflet-beautify-marker-icon.js') }}"></script>
<script src="{{ asset('assets/js/leaflet-routing-machine.js') }}"></script>
<script src="{{ asset('assets/libs/highcharts/js/highcharts.js') }}"></script>
<script src="{{ asset('assets/libs/highcharts/js/accessibility.js') }}"></script>
@endpush

@push('scripts')
<script>
    Highcharts.chart('progressChart', {
    chart: {
        type: 'line'
    },

    title: {
        text: `Target vs Realisasi Progress Tahun {{ $dataChart['tahun'] }}`
    },

    subtitle: {
        text: 'Rekap seluruh pekerjaan'
    },

    xAxis: {
        categories: @json($dataChart['labels']),
        title: {
            text: 'Bulan'
        }
    },

    yAxis: {
        min: 0,
        max: 100,
        title: {
            text: 'Progress (%)'
        },
        labels: {
            format: '{value}%'
        }
    },

    tooltip: {
        shared: true,
        valueSuffix: '%'
    },

    legend: {
        layout: 'horizontal',
        align: 'center',
        verticalAlign: 'bottom'
    },

    series: [
        {
            name: 'Target',
            type: 'areaspline',
            data: @json($dataChart['targetData']),
            dashStyle: 'Dash',
            className: 'highcharts-series-dash',
            marker: {
                enabled: false
            },
            color: '#FF9800',
            fillColor: {
                linearGradient: [0, 0, 0, 300],
                stops: [
                    [0, 'rgba(255,152,0,0.35)'],
                    [1, 'rgba(255,152,0,0.05)']
                ]
            }
        },
        {
            name: 'Realisasi',
            type: 'areaspline',
            data: @json($dataChart['realisasiData']),
            dashStyle: 'Dash',
            className: 'highcharts-series-dash',
            marker: {
                symbol: 'circle'
            },
            color: '#2196F3',
            fillColor: {
                linearGradient: [0, 0, 0, 300],
                stops: [
                    [0, 'rgba(33,150,243,0.4)'],
                    [1, 'rgba(33,150,243,0.05)']
                ]
            }
        }
    ],

    credits: {
        enabled: false
    }
});
</script>
<script>
    Highcharts.chart('laporanChart', {
    chart: {
       type: 'spline'
    },

    title: {
        text: 'Laporan Pengawasan vs Laporan Kendala'
    },

    subtitle: {
        text: 'Tahun {{ $grafikPengawasan["tahun"] }}'
    },

    xAxis: {
        categories: @json($grafikPengawasan['labels']),
        title: {
            text: 'Bulan'
        }
    },

    yAxis: {
        title: {
            text: 'Jumlah Laporan'
        },
        allowDecimals: false
    },

    tooltip: {
        shared: true,
        valueSuffix: ' laporan'
    },

    plotOptions: {
        
        spline: {
            dataLabels: { enabled: true },
            marker: { enabled: true }
        }
    },

    series: @json($grafikPengawasan['series'])
});
</script>

<script>
    Highcharts.chart('statusPengawasanChart', {
    chart: {
        type: 'pie'
    },

    title: {
        text: 'Status Pengawasan Proyek'
    },

    subtitle: {
        text: `Tahun {{ $tahun_aktif ?? date('Y') }}`
    },

    tooltip: {
        pointFormat: '<b>{point.y}</b> laporan ({point.percentage:.1f}%)'
    },

    plotOptions: {
        pie: {
            innerSize: '55%',
            allowPointSelect: true,
            cursor: 'pointer',
            dataLabels: {
                enabled: true,
                format: '{point.name}: {point.y}'
            }
        }
    },

    series: [{
        name: 'Jumlah',
       
        colorByPoint: true,
        data: @json($statusPengawasanChart)
    }]
});
</script>
<script>
    Highcharts.chart('kendalaChart', {
    chart: {
        type: 'pie'
    },

    title: {
        text: 'Distribusi Jenis Kendala Proyek'
    },

    subtitle: {
        text: 'Tahun {{ $tahun_aktif }}'
    },

    tooltip: {
        pointFormat: '<b>{point.y}</b> laporan ({point.percentage:.1f}%)'
    },

    plotOptions: {
        pie: {
            innerSize: '55%',
            allowPointSelect: true,
            cursor: 'pointer',
            dataLabels: {
                enabled: true,
                format: '{point.name}: {point.y}'
            }
        }
    },

    series: [{
        name: 'Jumlah Kendala',
        
        colorByPoint: true,
        data: @json($pieDataKendala)
    }]
});
</script>
<script>
    function showToast(title, message, type = 'info') {
    const container = document.getElementById('toast-container');

    const toast = document.createElement('div');
    toast.className = `toast align-items-center text-bg-${type} border-0`;
    toast.role = 'alert';
    toast.innerHTML = `
        <div class="d-flex">
            <div class="toast-body">
                <strong>${title}</strong><br>
                ${message}
            </div>
            <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
        </div>
    `;

    container.appendChild(toast);

    const bsToast = new bootstrap.Toast(toast, {
        delay: 5000
    });

    bsToast.show();

    toast.addEventListener('hidden.bs.toast', () => toast.remove());
}

</script>
@endpush
@push('scripts')
<script>
    let selectedMarker = null;
let projectMarkers = {};

// Default koordinat
let defaultCoordinate = [-6.83, 107.48];

// =====================
// TILE LAYER
// =====================
let googleStreets = L.tileLayer(
'https://{s}.google.com/vt/lyrs=m&x={x}&y={y}&z={z}', {
maxZoom: 20,
subdomains: ['mt0','mt1','mt2','mt3']
});


// =====================
// INIT MAP
// =====================
const map = L.map('projectMap', {
preferCanvas: true,
layers: [googleStreets],
zoomControl: false
}).setView(defaultCoordinate, 11);

new L.Control.Zoom({ position: 'topright' }).addTo(map);


// =====================
// LAYER GROUP
// =====================
let markers = L.layerGroup().addTo(map);
let polygons = L.layerGroup().addTo(map);


// =====================
// DATA DARI LARAVEL
// =====================
const projects = @json($projects);


map.createPane('panePolygon');
map.createPane('paneCircle');
map.createPane('paneMarker');

map.getPane('panePolygon').style.zIndex = 200;
map.getPane('paneCircle').style.zIndex = 300;
map.getPane('paneMarker').style.zIndex = 400;

// =====================
// LOOP PROJECT
// =====================
projects.forEach(project => {

if (!project.latitude || !project.longitude) return;


// =====================
// WARNA STATUS
// =====================
let color = 'blue';

if (project.status_progress === 'selesai') color = 'green';
if (project.status_progress === 'on_progress') color = 'orange';
if (project.status_progress === 'verifikasi') color = 'yellow';
if (project.status_terlabat === 'Y') color = 'red';

// =====================
// MARKER
// =====================
const marker = L.circleMarker(
[project.latitude, project.longitude],
{
pane: 'paneMarker',
radius: 8,
color: '#ffffff', // border
weight: 3, // tebal border
fillColor: color,
fillOpacity: 0.9
}
)
.bindPopup(`
<b>${project.nm_pekerjaan}</b><br>
Status: ${formatStatus(project.status_progress)}<br>
Progress: ${project.progress ?? 0}%<br>
<a href="/sub-kegiatan/pekerjaan/sub-pekerjaan/show?id=${project.id}"
    class="btn btn-sm btn-primary mt-2 w-100 text-light">
    Detail
</a>
`);
markers.addLayer(marker);
projectMarkers[project.id] = marker;


// =====================
// BLINK EFFECT
// =====================
let visible = true;

setInterval(() => {
visible = !visible;

marker.setStyle({
fillOpacity: visible ? 0.9 : 0.2,
opacity: visible ? 1 : 0.3
});

}, 600);


// =====================
// POLYGON
// =====================
if (project.area) {

try {

let geo = JSON.parse(project.area);

let polygon = L.geoJSON(geo, {
style:{
    pane:'panePolygon',
color: color,
fillColor: color,
fillOpacity:0.25,
weight:4
}
}).bindPopup(`<b>${project.nm_pekerjaan}</b><br>Area Proyek`);

polygons.addLayer(polygon);

} catch(e){}

}


// =====================
// RADIUS
// =====================
if(project.radius){

L.circle(
[project.latitude, project.longitude],
{
    pane:'paneCircle',
radius: project.radius,
color: color,
fillColor: color,
fillOpacity:0.15
}
).addTo(map);

}

});

fetch('data/32.17_kecamatan.geojson')
.then(response => response.json())
.then(data => {

const kabBandungBarat = L.geoJSON(data, {
style: {
color: '#e74c3c',
weight: 2,
opacity: 1,
fillColor: '#f39c12',
fillOpacity: 0.25
},

onEachFeature: function (feature, layer) {

const kecamatan = feature.properties.nm_kecamatan;

layer.bindPopup(`<b>Kecamatan ${kecamatan}</b>`);

layer.on({
mouseover: function (e) {
e.target.setStyle({ fillOpacity: 0.5 });
},
mouseout: function (e) {
kabBandungBarat.resetStyle(e.target);
}
});

}
}).addTo(map);

});
// =====================
// LEGEND
// =====================
var legend = L.control({ position: "bottomright" });

legend.onAdd = function () {

var div = L.DomUtil.create("div","info legend");

div.innerHTML += "<h6>Status Proyek</h6>";
div.innerHTML += '<i style="background:green"></i> Selesai<br>';
div.innerHTML += '<i style="background:orange"></i> On Progress<br>';
div.innerHTML += '<i style="background:red"></i> Terlambat<br>';

return div;

};

legend.addTo(map);


// =====================
// SELECT CONTROL
// =====================
var controlProyek = L.control({ position: 'topleft' });

controlProyek.onAdd = function () {

var div = L.DomUtil.create('div','leaflet-bar leaflet-control');

div.style.background = "white";
div.style.padding = "6px";

div.innerHTML = `
<select id="pilihProyek" class="form-control form-control-sm">
    <option value="">Semua Proyek</option>
    @foreach($projects as $p)
    <option value="{{ $p->id }}">
        {{ $p->nm_pekerjaan }}
    </option>
    @endforeach
</select>
`;

L.DomEvent.disableClickPropagation(div);

return div;

};

controlProyek.addTo(map);


// =====================
// EVENT SELECT
// =====================
document.addEventListener("change", function(e){

if(e.target.id !== "pilihProyek") return;

let id = e.target.value;

if(!id){

map.flyTo(defaultCoordinate,11);

if(selectedMarker){
selectedMarker.closePopup();
}

return;

}

let marker = projectMarkers[id];

if(marker){

selectedMarker = marker;

map.flyTo(marker.getLatLng(),16,{
animate:true,
duration:1.5
});

setTimeout(()=>{
marker.openPopup();
},500);

}

});

// const legend = L.control({ position: 'bottomright' });

// legend.onAdd = function () {
// const div = L.DomUtil.create('div', 'legend');

// div.innerHTML = `
// <div class="legend-title">Keterangan</div>

// <div class="legend-item">
//     <div class="legend-icon legend-gedung">
//         <i class="fa-solid fa-building"></i>
//     </div>
//     Gedung
// </div>

// <div class="legend-item">
//     <div class="legend-icon legend-jalan">
//         <i class="fa-solid fa-road"></i>
//     </div>
//     Jalan
// </div>
// `;

// return div;
// };

function formatStatus(status) {
if (!status) return '-';

return status
.replaceAll('_', ' ')
.replace(/\b\w/g, char => char.toUpperCase());
}

</script>

<script>
    const grafik = @json($grafik_anggaran);

Highcharts.chart('keuanganChart', {

    chart: {
        zoomType: 'xy'
    },

    title: {
        text: 'Ringkasan Keuangan: Penyerapan Anggaran'
    },

    xAxis: [{
        categories: grafik.labels,
        crosshair: true
    }],

    yAxis: [{
        // kiri
        labels: {
            formatter: function () {
                return 'Rp ' + Highcharts.numberFormat(this.value, 0, ',', '.');
            }
        },
        title: {
            text: 'Nilai (Rp)'
        }
    }, {
        // kanan
        title: {
            text: 'Persentase (%)'
        },
        labels: {
            format: '{value}%'
        },
        max: 100,
        opposite: true
    }],

    tooltip: {
        shared: true,
        formatter: function () {

            let s = '<b>' + this.x + '</b>';

            this.points.forEach(function (p) {

                if (p.series.name === 'Persentase Penyerapan') {
                    s += '<br/>' + p.series.name + ': ' + p.y.toFixed(2) + '%';
                } else {
                    s += '<br/>' + p.series.name + ': Rp ' +
                        Highcharts.numberFormat(p.y, 0, ',', '.');
                }

            });

            return s;
        }
    },

    series: [
    {
        name: 'Anggaran',
        type: 'column',
        data: grafik.anggaran
    },
    {
        name: 'Realisasi',
        type: 'column',
        data: grafik.realisasi
    },
    {
        name: 'Persentase Penyerapan',
        type: 'line',
        yAxis: 1,
        data: grafik.serapan
    }]
});
</script>



<script>
    document.addEventListener("DOMContentLoaded", function () {

    Highcharts.chart('projectStatusChart', {
        chart: {
            type: 'pie'
        },

        title: {
            text: 'Persentase Status Proyek'
        },

        tooltip: {
            pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
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
                {
                    name: 'Draft',
                    y: {{ $project_status->draft  ?? 0}},
                    color: '#6c757d'
                },
                {
                    name: 'On Progress',
                    y: {{ $project_status->on_progress ?? 0}},
                    color: '#0d6efd'
                },
                {
                    name: 'Selesai',
                    y: {{ $project_status->selesai ?? 0 }},
                    color: '#198754'
                }
            ]
        }]
    });

});
</script>


@endpush
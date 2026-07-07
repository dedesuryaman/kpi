@extends('layouts.admin.app')
@push('styles')
<style>
    .search-wrapper {
        position: absolute;
        left: 5vw;
        top: 1rem;
        z-index: 1000;
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
                    <li class="breadcrumb-item"><a href="javascript: void(0);">Dashboard</a></li>
                    <li class="breadcrumb-item active">Keuangan</li>
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

<div class="row">
    <div class="col-md-8">

        <div id="chart3"></div>
        <div id="chart3"></div>
        <div id="chart3"></div>
    </div>
    <div class="col-md-4"></div>

</div>

<div id="chartGroup" style="height: 450px;"></div>
@endsection

@push('css')

@endpush
@push('js')

<script src="https://code.highcharts.com/highcharts.js"></script>
<script src="https://code.highcharts.com/modules/accessibility.js"></script>
@endpush
@push('scripts')

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
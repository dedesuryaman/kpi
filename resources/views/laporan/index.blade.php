@extends('layouts.admin.app')

@push('title', 'Laporan')
@push('styles')
<style>
    .report-card {
        transition: all 0.3s ease;
        border: 1px solid #f1f1f1;
    }

    .report-card:hover {
        transform: translateY(-6px);
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.08);
    }
</style>
@endpush
@section('content')

<div class="row">
    <div class="col-12">
        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
            <h4 class="mb-sm-0 font-size-18">Laporan Pekerjaan</h4>

            <div class="page-title-right">

            </div>

        </div>
    </div>
</div>

<style>
    .executive-card {
        border: none;
        border-radius: 12px;
        transition: all 0.3s ease;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
    }

    .executive-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.08);
    }

    .icon-box {
        width: 50px;
        height: 50px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 22px;
    }
</style>
<div class="row g-3 mb-3 d-none">

    <!-- Daftar Proyek -->
    <div class="col-md-3">
        <a href="#" class="text-decoration-none">
            <div class="card shadow shadow-sm executive-card h-100">
                <div class="card-body">

                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <p class="text-muted mb-1">Total Proyek</p>
                            <h4 class="mb-0 fw-bold">24</h4>
                        </div>
                        <div class="icon-box bg-primary-subtle text-primary">
                            <i class="bx bx-briefcase-alt"></i>
                        </div>
                    </div>

                    <div class="progress mt-3" style="height:6px;">
                        <div class="progress-bar bg-primary" style="width: 75%"></div>
                    </div>

                    <small class="text-muted mt-2 d-block">
                        75% proyek aktif berjalan
                    </small>

                </div>
            </div>
        </a>
    </div>


    <!-- Progress On Track -->
    <div class="col-md-3">
        <a href="#" class="text-decoration-none">
            <div class="card executive-card h-100">
                <div class="card-body">

                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <p class="text-muted mb-1">On Track</p>
                            <h4 class="mb-0 fw-bold text-success">18</h4>
                        </div>
                        <div class="icon-box bg-success-subtle text-success">
                            <i class="bx bx-line-chart"></i>
                        </div>
                    </div>

                    <div class="progress mt-3" style="height:6px;">
                        <div class="progress-bar bg-success" style="width: 80%"></div>
                    </div>

                    <small class="text-success mt-2 d-block">
                        Kinerja sesuai rencana
                    </small>

                </div>
            </div>
        </a>
    </div>


    <!-- Proyek Terlambat -->
    <div class="col-md-3">
        <a href="#" class="text-decoration-none">
            <div class="card executive-card h-100">
                <div class="card-body">

                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <p class="text-muted mb-1">Terlambat</p>
                            <h4 class="mb-0 fw-bold text-danger">4</h4>
                        </div>
                        <div class="icon-box bg-danger-subtle text-danger">
                            <i class="bx bx-time-five"></i>
                        </div>
                    </div>

                    <div class="progress mt-3" style="height:6px;">
                        <div class="progress-bar bg-danger" style="width: 20%"></div>
                    </div>

                    <small class="text-danger mt-2 d-block">
                        Perlu perhatian khusus
                    </small>

                </div>
            </div>
        </a>
    </div>


    <!-- Serapan Anggaran -->
    <div class="col-md-3">
        <a href="#" class="text-decoration-none">
            <div class="card executive-card h-100">
                <div class="card-body">

                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <p class="text-muted mb-1">Serapan Anggaran</p>
                            <h4 class="mb-0 fw-bold text-warning">70%</h4>
                        </div>
                        <div class="icon-box bg-warning-subtle text-warning">
                            <i class="bx bx-money"></i>
                        </div>
                    </div>

                    <div class="progress mt-3" style="height:6px;">
                        <div class="progress-bar bg-warning" style="width: 70%"></div>
                    </div>

                    <small class="text-muted mt-2 d-block">
                        Rp 8.7 M dari Rp 12.5 M
                    </small>

                </div>
            </div>
        </a>
    </div>

</div>

<div class="row g-3 ">

    <!-- Daftar Proyek -->
    <div class="col-md-3">
        <a href="{{ url('/laporan/daftar-proyek') }}" class="text-decoration-none">
            <div class="card report-card executive-card h-100">
                <div class="card-body text-center">
                    <div class="avatar-sm mx-auto mb-3">
                        <span class="avatar-title bg-primary-subtle text-light rounded-circle fs-3">
                            <i class="bx bx-list-ul"></i>
                        </span>
                    </div>
                    <h5 class="mb-1 text-dark">Daftar Proyek</h5>
                    <p class="text-muted small mb-0">
                        Rekap seluruh proyek
                    </p>
                </div>
            </div>
        </a>
    </div>

    <!-- Progress Proyek -->
    <div class="col-md-3">
        <a href="{{  url('/laporan/progress-proyek') }}" class="text-decoration-none">
            <div class="card report-card executive-card h-100">
                <div class="card-body text-center">
                    <div class="avatar-sm mx-auto mb-3">
                        <span class="avatar-title bg-success-subtle text-light rounded-circle fs-3">
                            <i class="bx bx-line-chart"></i>
                        </span>
                    </div>
                    <h5 class="mb-1 text-dark">Progress Proyek</h5>
                    <p class="text-muted small mb-0">
                        Monitoring progres fisik
                    </p>
                </div>
            </div>
        </a>
    </div>

    <!-- Keuangan -->
    <div class="col-md-3">
        <a href="{{ url('/laporan/anggaran') }}" class="text-decoration-none">
            <div class="card report-card executive-card h-100">
                <div class="card-body text-center">
                    <div class="avatar-sm mx-auto mb-3">
                        <span class="avatar-title bg-warning-subtle text-light rounded-circle fs-3">
                            <i class="bx bx-money"></i>
                        </span>
                    </div>
                    <h5 class="mb-1 text-dark">Keuangan/Anggaran Proyek</h5>
                    <p class="text-muted small mb-0">
                        Realisasi & serapan anggaran
                    </p>
                </div>
            </div>
        </a>
    </div>

    <!-- Pengawasan -->
    <div class="col-md-3">
        <a href="{{ url('/laporan/pengawasan') }}" class="text-decoration-none">
            <div class="card report-card executive-card h-100">
                <div class="card-body text-center">
                    <div class="avatar-sm mx-auto mb-3">
                        <span class="avatar-title bg-info-subtle text-light rounded-circle fs-3">
                            <i class="bx bx-camera"></i>
                        </span>
                    </div>
                    <h5 class="mb-1 text-dark">Pengawasan</h5>
                    <p class="text-muted small mb-0">
                        Laporan lapangan & foto
                    </p>
                </div>
            </div>
        </a>
    </div>

    <!-- Kendala -->
    <div class="col-md-3">
        <a href="{{ url('/laporan/kendala') }}" class="text-decoration-none">
            <div class="card report-card  executive-card h-100">
                <div class="card-body text-center">
                    <div class="avatar-sm mx-auto mb-3">
                        <span class="avatar-title bg-danger-subtle text-light rounded-circle fs-3">
                            <i class="bx bx-error-circle"></i>
                        </span>
                    </div>
                    <h5 class="mb-1 text-dark">Kendala</h5>
                    <p class="text-muted small mb-0">
                        Permasalahan proyek
                    </p>
                </div>
            </div>
        </a>
    </div>

    <!-- Sub Pekerjaan -->
    <div class="col-md-3">
        <a href="{{ url('/laporan/sub-pekerjaan') }}" class="text-decoration-none">
            <div class="card report-card executive-card h-100">
                <div class="card-body text-center">
                    <div class="avatar-sm mx-auto mb-3">
                        <span class="avatar-title bg-secondary-subtle text-light rounded-circle fs-3">
                            <i class="bx bx-task"></i>
                        </span>
                    </div>
                    <h5 class="mb-1 text-dark">Sub Pekerjaan</h5>
                    <p class="text-muted small mb-0">
                        Detail pekerjaan proyek
                    </p>
                </div>
            </div>
        </a>
    </div>

    <!-- Proyek Terlambat -->
    <div class="col-md-3">
        <a href="{{ url('/laporan/proyek-terlambat') }}" class="text-decoration-none">
            <div class="card report-card executive-card h-100">
                <div class="card-body text-center">
                    <div class="avatar-sm mx-auto mb-3">
                        <span class="avatar-title bg-dark-subtle text-light rounded-circle fs-3">
                            <i class="bx bx-time"></i>
                        </span>
                    </div>
                    <h5 class="mb-1 text-dark">Proyek Terlambat</h5>
                    <p class="text-muted small mb-0">
                        Monitoring keterlambatan
                    </p>
                </div>
            </div>
        </a>
    </div>

    <!-- Dokumentasi -->
    <div class="col-md-3">
        <a href="{{ url('/laporan/dokumentasi') }}" class="text-decoration-none">
            <div class="card report-card executive-card h-100">
                <div class="card-body text-center">
                    <div class="avatar-sm mx-auto mb-3">
                        <span class="avatar-title bg-primary-subtle text-light rounded-circle fs-3">
                            <i class="bx bx-image"></i>
                        </span>
                    </div>
                    <h5 class="mb-1 text-dark">Dokumentasi</h5>
                    <p class="text-muted small mb-0">
                        Galeri foto proyek
                    </p>
                </div>
            </div>
        </a>
    </div>

    <!-- Rekap Tahunan -->
    <div class="col-md-3">
        <a href="{{ url('/laporan/rekap-tahunan') }}" class="text-decoration-none">
            <div class="card report-card executive-card h-100">
                <div class="card-body text-center">
                    <div class="avatar-sm mx-auto mb-3">
                        <span class="avatar-title bg-success-subtle text-light rounded-circle fs-3">
                            <i class="bx bx-bar-chart-alt-2"></i>
                        </span>
                    </div>
                    <h5 class="mb-1 text-dark">Rekap Tahunan</h5>
                    <p class="text-muted small mb-0">
                        Ringkasan laporan tahunan
                    </p>
                </div>
            </div>
        </a>
    </div>

</div>



<script>
    var options = {
    series: [{
        name: 'Rencana',
        data: [10,20,35,50,65,80,100]
    },{
        name: 'Realisasi',
        data: [8,18,30,45,60,75,90]
    }],
    chart: {
        height: 350,
        type: 'line',
        toolbar: { show: false }
    },
    stroke: { curve: 'smooth', width: 3 },
    xaxis: {
        categories: ['Jan','Feb','Mar','Apr','Mei','Jun','Jul']
    },
    colors: ['#556ee6','#34c38f']
};

var chart = new ApexCharts(document.querySelector("#progress_chart"), options);
chart.render();
</script>

<script>
    document.querySelectorAll('.counter-value').forEach(counter => {
    const updateCount = () => {
        const target = +counter.getAttribute('data-target');
        const count = +counter.innerText;
        const increment = target / 50;

        if (count < target) {
            counter.innerText = Math.ceil(count + increment);
            setTimeout(updateCount, 20);
        } else {
            counter.innerText = target;
        }
    };
    updateCount();
});
</script>


@endsection
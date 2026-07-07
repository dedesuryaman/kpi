@extends('layouts.admin.app')
@push('title', 'Dashboard >> Pekerjaan')
@push('css')
<script src="https://code.highcharts.com/highcharts.js"></script>
@endpush
@push('styles')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
            <h4 class="mb-sm-0 font-size-18">Data Proyek (Progress Pekerjaan)</h4>

            <div class="page-title-right">
                <ol class="breadcrumb m-0 d-none">
                    <li class="breadcrumb-item"><a href="javascript: void(0);">Pekerjaan</a></li>
                    <li class="breadcrumb-item active">Laporan Progress Pekerjaan</li>
                </ol>
            </div>

        </div>
    </div>
</div>

<div class=" mt-2">
    <div class="card border border-primary">
        <div class="card-body">
            <!-- Form Filter -->
            <form id="filterForm" class="row g-3 mb-4" method="get">
                <div class="col-md-1">
                    <label for="tahun" class="form-label">Tahun</label>
                    <input type="tahun" class="form-control" name="tahun" id="tahun"
                        value="{{ $tahun ?? session('tahun_aktif') }}">
                </div>

                <div class="col-md-1">
                    <label for="bulan" class="form-label">Bulan</label>
                    <select name="bulan" id="bulan" class="form-control">
                        <option value="1" @selected(($bulan ?? 0)==1)>Januari</option>
                        <option value="2" @selected(($bulan ?? 0)==2)>Februari</option>
                        <option value="3" @selected(($bulan ?? 0)==3)>Maret</option>
                        <option value="4" @selected(($bulan ?? 0)==4)>April</option>
                        <option value="5" @selected(($bulan ?? 0)==5)>Mei</option>
                        <option value="6" @selected(($bulan ?? 0)==6)>Juni</option>
                        <option value="7" @selected(($bulan ?? 0)==7)>Juli</option>
                        <option value="8" @selected(($bulan ?? 0)==8)>Agustus</option>
                        <option value="9" @selected(($bulan ?? 0)==9)>September</option>
                        <option value="10" @selected(($bulan ?? 0)==10)>Oktober</option>
                        <option value="11" @selected(($bulan ?? 0)==11)>November</option>
                        <option value="12" @selected(($bulan ?? 0)==12)>Desember</option>
                    </select>
                </div>


                <div class="col-md-8">
                    <label for="bulan" class="form-label">Pilih Proyek</label>
                    <select class="form-control" name="pekerjaan">
                        <option value="">--All--</option>
                        @foreach ($proyek as $row)
                        <option value="{{ $row->id }}">{{ $row->nm_pekerjaan }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-2 align-self-end">
                    <button type="submit" class="btn btn-primary btn-sm">Tampilkan Laporan</button>
                    <button type="reset" class="btn btn-secondary btn-sm ms-2">Reset</button>
                </div>

            </form>
        </div>
    </div>
    @if ($report)
    <div class="card border border-primary">
        <div class="card-body">
            <div class="mb-3 text-end btn-group">
                <form method="get" action="{{ url('/laporan/pekerjaan/progress-mingguan/print-excel') }}"
                    target="_blank">
                    <input type="hidden" name="tahun" value="{{ $tahun }}">
                    <input type="hidden" name="bulan" value="{{ $bulan }}">
                    <input type="hidden" name="print" value="excel">
                    <button type="submit" class="btn btn-sm btn-primary ms-2">Print</button>
                </form>
                <form method="get" action="{{ url('/laporan/pekerjaan/progress-mingguan/print-pdf') }}" target="_blank">
                    <input type="hidden" name="tahun" value="{{ $tahun }}">
                    <input type="hidden" name="bulan" value="{{ $bulan }}">
                    <input type="hidden" name="print" value="pdf">
                    <button type="submit" class="btn btn-sm btn-warning ms-2">PDF</button>
                </form>
            </div>
            <!-- Tabel Laporan -->
            <div class="table-responsive">
                <table class="table table-sm">
                    <thead class="">
                        <tr>
                            <th>No</th>
                            <th>Pekerjaan</th>
                            <th>Kegiatan</th>
                            <th>Tangal Mulai</th>
                            <th>Tanggal Selesai</th>
                            @for($w=1;$w<=5;$w++) <th>Minggu {{ $w }}</th>
                                @endfor
                        </tr>
                    </thead>
                    <tbody>
                        <?php $n =1 ;?>
                        @foreach($report as $item)
                        <tr>
                            <td>{{ $n++ }}</td>
                            <td>{{ $item['pekerjaan'] }}</td>
                            <td>{{ $item['nm_sub_kegiatan']}}</td>
                            <td>{{ tanggalIndoSm($item['tanggal_mulai']) }}</td>
                            <td>{{ tanggalIndoSm($item['tanggal_selesai']) }}</td>
                            @for($w=1;$w<=5;$w++) <td>
                                {{ $item['mingguan'][$w] ?? '-' }} %
                                </td>
                                @endfor
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @else
            @if ($tahun|| $bulan)
            <div class="alert alert-warning">Data tidak ditemukan , silahkan filter !</div>
            @else
            <div class="alert alert-info">Silahkan filter !</div>
            @endif
            @endif
        </div>
    </div>
</div>

@endsection
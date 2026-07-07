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
                        <option value="{{ $row->id }}" {{ $row->id == $pekerjaan_id ? "selected" : "" }}>{{
                            $row->nm_pekerjaan }}</option>
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
    <div class="card border border-primary">
        <div class="card-body">
            @if ($report)
            <h5>Identitas Proyek</h5>
            <hr>
            <table class="table table-sm">
                <tr>
                    <td width="20%">Nama Proyek</td>
                    <td width="2%">:</td>
                    <td>{{ $report->nm_pekerjaan }}</td>
                </tr>
                <tr>
                    <td width="20%">Deskripsi</td>
                    <td width="2%">:</td>
                    <td>{{ $report->deskripsi ?? '-' }}</td>
                </tr>
                <tr>
                    <td width="20%">Lokasi</td>
                    <td width="2%">:</td>
                    <td>{{ $report->lokasi ?? '-' }}</td>
                </tr>

                <tr>
                    <td width="20%">Nomor Kontrak</td>
                    <td width="2%">:</td>
                    <td>{{ $report->nomor_kontrak ?? '-' }}</td>
                </tr>

                <tr>
                    <td width="20%">Tanggal Kontrak</td>
                    <td width="2%">:</td>
                    <td>{{ $report->tanggal_kontrak }}</td>
                </tr>

                <tr>
                    <td width="20%">OPD Pengawas</td>
                    <td width="2%">:</td>
                    <td>{{ $report->opdPengawas->name ?? '-' }}</td>
                </tr>

                <tr>
                    <td width="20%">Kontraktor Pelaksana</td>
                    <td width="2%">:</td>
                    <td>{{ $report->konPelaksana->name ?? '-' }}</td>
                </tr>

                <tr>
                    <td width="20%">Kontraktor Pengawas</td>
                    <td width="2%">:</td>
                    <td>{{ $report->konPengawas->name ?? '-' }}</td>
                </tr>


                <tr>
                    <td>Tanggal Mulai</td>
                    <td>:</td>
                    <td>{{ $report->tanggal_mulai ?? '-' }}</td>
                </tr>

                <tr>
                    <td>Pagu Anggaran</td>
                    <td>:</td>
                    <td>{{ $report->pagu_anggaran ?? '-' }}</td>
                </tr>

                <tr>
                    <td>Progress Rencana</td>
                    <td>:</td>
                    <td>{{ $report->progress ?? '0' }}%</td>
                </tr>

                <tr>
                    <td>Progress Realisasi</td>
                    <td>:</td>
                    <td>{{ $report->progress ?? '0' }}%</td>
                </tr>

                <tr>
                    <td>Deviasi</td>
                    <td>:</td>
                    <td>{{ $report->progress ?? '0' }}%</td>
                </tr>

                <tr>
                    <td>Status</td>
                    <td>:</td>
                    <td>On Track/Terlambat/Lebih Cepat </td>
                </tr>


            </table>

            @if($report->subPekerjaan)
            <h5>Sub Pekerjaan</h5>
            <hr>
            <table class="table table-sm">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Pekerjaan</th>
                        <th>Tanggal Mulai</th>

                        <th>Progress</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($report->subPekerjaan as $row)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $row->judul }}</td>
                        <td>{{ $row->tanggal_mulai}}</td>

                        <td>{{ $row->persentase_progress }}</td>
                        <td>{{ $row->status_progress}}</td>
                    </tr>
                    <tr>
                        <td colspan="5">

                            <table class="table table-bordered table-sm mb-0">
                                <thead>
                                    <tr>
                                        <th>Tanggal</th>
                                        <th>Minggu Ke</th>
                                        <th>Progress</th>
                                        <th>Keterangan</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($row->progress as $prog)
                                    <tr>
                                        <td>{{ \Carbon\Carbon::parse($prog->tanggal)->format('d-m-Y') }}</td>
                                        <td>@php
                                            $tgl = \Carbon\Carbon::parse($prog->tanggal);
                                            $minggu = ceil($tgl->day / 7);
                                            @endphp
                                            {{ $minggu }}</td>
                                        <td>{{ $prog->persentase_progress }} %</td>
                                        <td>{{ $prog->keterangan ?? '-' }}</td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="4" class="text-center text-muted">
                                            Tidak ada progress di bulan ini
                                        </td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            @else

            @endif

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
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
            <h4 class="mb-sm-0 font-size-18">Data Laporan Proyek (Dokumentasi Foto)</h4>

            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="javascript: void(0);">Pekerjaan</a></li>
                    <li class="breadcrumb-item active">Dokumentasi Foto</li>
                </ol>
            </div>

        </div>
    </div>
</div>
<div class="card mt-2 p-2">

    <!-- Form Filter -->
    <form id="filterForm" class="row g-3 mb-4" method="get">
        <div class="col-md-4">
            <label for="tahun" class="form-label">Tahun</label>
            <input type="tahun" class="form-control" name="tahun" id="tahun"
                value="{{ $tahun ?? session('tahun_aktif') }}">
        </div>

        <div class="col-md-4">
            <label for="bulan" class="form-label">Bulan</label>
            <select name="bulan" id="bulan" class="form-control">
                <option value="0" {{ $bulan==0 ? 'selected' : '' }}>--All--</option>
                <option value="1" {{ $bulan==1 ? 'selected' : '' }}>Januari</option>
                <option value="2" {{ $bulan==2 ? 'selected' : '' }}>Februari</option>
                <option value="3" {{ $bulan==3 ? 'selected' : '' }}>Maret</option>
                <option value="4" {{ $bulan==4 ? 'selected' : '' }}>April</option>
                <option value="5" {{ $bulan==5 ? 'selected' : '' }}>Mei</option>
                <option value="6" {{ $bulan==6 ? 'selected' : '' }}>Juni</option>
                <option value="7" {{ $bulan==7 ? 'selected' : '' }}>Juli</option>
                <option value="8" {{ $bulan==8 ? 'selected' : '' }}>Agustus</option>
                <option value="9" {{ $bulan==9 ? 'selected' : '' }}>September</option>
                <option value="10" {{ $bulan==10 ? 'selected' : '' }}>Oktober</option>
                <option value="11" {{ $bulan==11 ? 'selected' : '' }}>November</option>
                <option value="12" {{ $bulan==12 ? 'selected' : '' }}>Desember</option>
            </select>
        </div>

        <div class="col-md-4 align-self-end">
            <button type="submit" class="btn btn-primary btn-sm">Tampilkan Laporan</button>
            <button type="reset" class="btn btn-secondary btn-sm ms-2">Reset</button>
        </div>
    </form>

    @if($fotos)
    <?php $n = 1 ;?>
    <table class="table table-sm">
        <tbody>
            @foreach($fotos as $foto)
            <tr>
                <td>{{ $fotos->firstItem() + $loop->index }}</td>
                <td><img src="{{ $foto->foto_url }}" style="width:60px;"></td>
                <td>{{ $foto->catatan ?? '' }}</td>
                <td>{{ $foto->status ?? '' }}</td>
                <td>{{ $foto->latitude ?? ''}}</td>
                <td>{{ $foto->longitude ?? '' }}</td>
                <td>{{ tanggalIndo($foto->created_at) }}</td>
                <td>{{ $foto->posPengawasan->nm_pos ?? ''}}</td>
                <td>{{ $foto->subPekerjaan->judul ?? ''}}</td>
                <td>{{ $foto->posPengawasan->subPekerjaan->pekerjaan->nm_pekerjaan ?? ''}}</td>
            </tr>

            @endforeach
        </tbody>
    </table>

    <hr>
    {{ $fotos->links('vendor.pagination.bootstrap-first-last') }}
    @else
    <div class="alert alert-info">Silahkan filter data!</div>
    @endif
</div>

@endsection
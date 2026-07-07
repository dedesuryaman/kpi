@extends('layouts.admin.app')
@push('title' , 'Detail Proyek')
@push('css')
<link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
@endpush

@push('styles')
.cursor-move {
cursor: move;
}
@endpush
@section('content')
<div class="row">
    <div class="col-12">
        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
            <h4 class="mb-sm-0 font-size-18">Pekerjaan dan Proyek</h4>

            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="javascript: void(0);">Proyek</a></li>
                    <li class="breadcrumb-item active">Detail Proyek</li>
                </ol>
            </div>

        </div>
    </div>
</div>
<div class="card">
    <div class="card-body">
        <div class="row">
			<div class="col-md-12">
            <table class="table table-sm">
                <tr>
                    <td>PROGRAM</td>
                    <td colspan="5">: {{ $project->subKegiatan->nm_program ?? ''}}</td>
                </tr>
                <tr>
                    <td>KEGIATAN</td>
                    <td colspan="5">: {{ $project->subKegiatan->nm_kegiatan ?? ''}}</td>
                </tr>
                <tr>
                    <td>SUB KEGIATAN</td>
                    <td colspan="5">: {{ $project->subKegiatan->nm_sub_kegiatan ?? ''}}</td>
                </tr>
                <tr>
                    <td width="10%">ANGGARAN</td>
                    <td width="15%" class="text-danger">: {{ rupiah($project->subKegiatan->pagu_anggaran ?? 0)}}</td>
                    <td width="10%">REALISASI UANG</td>
                    <td width="15%" class="text-danger">: {{ rupiah($project->subKegiatan->realisasi ?? 0) }}</td>
                    <td width="10%">REALISASI FISIK</td>
                    <td class="text-danger">: {{ rupiah(0) }}</td>

                </tr>
            </table>
			</div>
        </div>

        <div class="row">
            <div class="col-md-7 mb-3">


                <h3 class="mt-0 mb-3 text-primary">{{ $project->name }}</h3>

                <h5 class="card-title">Deskripsi</h5>
                <p>{{ $project->deskripsi }}</p>
                <h5 class="card-title">Pagu Anggaran</h5>
                <p>{{ 'Rp ' . number_format($project->pagu_anggaran, 0, ',', '.') }} </p>
                <h5 class="card-title"><i class="fas fa-map-marker-alt"></i> Lokasi</h5>
                <div class="d-flex align-items-center">
                    <p class="mb-0">{{ $project->lokasi }}</p>
                    <button type="button" class="btn btn-sm btn-info ms-auto" data-bs-toggle="modal"
                        data-bs-target="#mapModal" id="btnShowMap">
                        Show Map
                    </button>
                </div>

                <div class="mt-2">
                    <h5 class="card-title">Status/Progress</h5>
                    @php
                    $percent = $project->progress_summary;

                    // tentukan class warna
                    if ($percent < 50) { $colorClass='bg-danger' ; } elseif ($percent < 80) { $colorClass='bg-warning' ;
                        } else { $colorClass='bg-success' ; } @endphp <div class="progress" style="height: 15px;">
                        <div class="progress-bar {{ $colorClass }}" role="progressbar" style="width: {{ $percent }}%;"
                            aria-valuenow="{{ $percent }}" aria-valuemin="0" aria-valuemax="100">
                            {{ $percent }}%
                        </div>
                </div>
            </div>

        </div>
        <div class="col-md-5">

            <div class="mb-3 row">
                <div class="col-4">
                    <label>Kontraktor Pelaksana</label>
                </div>
                <div class="col-8">
                    : {{ $kontraktor_proyek->name ?? '-' }}
                </div>
            </div>
			<div class="mb-3 row">
                <div class="col-4">
                    : Kontraktor Pengawas
                </div>
                <div class="col-8">
                    : {{ $kontraktor_proyek->name ?? '-' }}
                </div>
            </div>
            <div class="mb-3 row">
                <div class="col-4">
                    <label>Kode Proyek</label>
                </div>
                <div class="col-8">
                    : {{ $project->kode_proyek }}
                </div>
            </div>
            <div class="mb-3 row">
                <div class="col-4">
                    <label>Tanggal Mulai</label>
                </div>
                <div class="col-8">
                    : {{ tanggalIndo($project->tanggal_mulai) }}
                </div>
            </div>
            <div class="mb-3 row">
                <div class="col-4">
                    <label>Target Selesai</label>
                </div>
                <div class="col-8">
                    : {{ tanggalIndo($project->tanggal_selesai) }}
                </div>
            </div>

            <div class="mb-3 row">
                <div class="col-4">
                    <label>Post Anggaran</label>
                </div>
                <div class="col-8">
                    : {{ rupiah($project->total_anggaran ?? 0) }}
                </div>
            </div>

            <div class="mb-3 row">
                <div class="col-4">
                    <label>Realisasi Anggaran</label>
                </div>
                <div class="col-8">
                    : {{ rupiah($project->total_realisasi ?? 0) }}
                </div>
            </div>

            <div class="mb-3 row">
                <div class="col-4">
                    <label>Persentase Serapan</label>
                </div>
                <div class="col-8">
                    : {{ number_format($project->persentase_realisasi, 2, ',', '.') }} %
                </div>
            </div>

            <div class="mb-3 row">
                <div class="col-4">
                    <label>Status</label>
                </div>
                <div class="col-8">
                    : {{$project->status->name}}
                </div>
            </div>
            <div class="mb-3 row">
                <div class="col-xl-4"></div>
                <div class="col-xl-4 mb-2">
                    @if($project->tanggal_realisasi != '')
                    <a href="{{ route('admin.proyek.belum_selesai', $project->id) }}"
                        class="btn btn-sm btn-danger pull-right w-100"
                        onclick="return confirm('Tandai kegiatan belum selesai?')"><span
                            class="fa fa-stop"></span>Tandai proyek belum selesai</a>
                    @elseif($project->tanggal_realisasi == '')
                    @if(in_array($project->status_id ,[8,9]))
                    <a href="{{ route('admin.proyek.tandai_selesai', $project->id) }}"
                        class="btn btn-sm btn-primary pull-right w-100"
                        onclick="return confirm('Tandai proyek selesai?')"><span class="fa fa-check"></span> Tandai
                        Selesai</a>
                    @endif
                    @endif

                </div>
                @php
                $status_id = $project->status_id ?? 0;
                @endphp
                @if($status_id < 2) <div class="col-xl-4 mb-2">
                    <a href="{{ route('proyek.edit', $project->id ) }}" class="btn btn-sm btn-primary w-100"><i
                            class="fa fa-edit"></i> Ubah Proyek</a>
            </div>
            @endif
        </div>
    </div>
</div>
</div>
</div>

<!-- MODAL -->
<div class="modal fade" id="mapModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title">Lokasi di Peta</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">
                <div id="map" style="height:400px;width:100%;"></div>
            </div>

            <div class="modal-footer">
                <button class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
            </div>

        </div>
    </div>
</div>


@if($status_id >= 1)
<div class="card">
    <div class="card-body">
        <h4 class="card-title">Detail Proyek</h4>
        <div class="card-title-desc">Ruang lingkup pekerjaan,kegiatan/aktifitas proyek dan dokumentasi</div>

        <!-- Nav tabs -->
        <ul class="nav nav-tabs nav-tabs-custom nav-justified" role="tablist">
            <li class="nav-item">
                <a class="nav-link active" data-bs-toggle="tab" href="#home1" role="tab" aria-selected="true" title="Ruang lingkup pekerjaan">
                    <span class="d-block d-sm-none"><i class="fas fa-home"></i></span>
                    <span class="d-none d-sm-block">RUANG LINGKUP PEKERJAAN</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-bs-toggle="tab" href="#approval" role="tab" title="Aktivitas pengaswan proyek">
                    <span class="d-block d-sm-none"><i class="far fa-envelope"></i></span>
                    <span class="d-none d-sm-block">AKTIVITAS PENGAWASAN</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-bs-toggle="tab" href="#pic-anggota" role="tab" title="User pengawas proyek">
                    <span class="d-block d-sm-none"><i class="far fa-envelope"></i></span>
                    <span class="d-none d-sm-block">PENGAWAS OPD</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-bs-toggle="tab" href="#dokumen-proyek" role="tab" title="Dokumen-dokumen proyek">
                    <span class="d-block d-sm-none"><i class="far fa-envelope"></i></span>
                    <span class="d-none d-sm-block">DOKUMEN</span>
                </a>
            </li>

        </ul>

        <!-- Tab panes -->
        <div class="tab-content p-3 text-muted">
            <div class="tab-pane active" id="home1" role="tabpanel">
                <div class="d-flex align-items-center w-100 mb-3">
                    <button type="button" class="btn btn-sm btn-primary waves-effect waves-light ms-auto"
                        data-bs-toggle="modal" data-bs-target="#progress_baru">
                        Subtask Baru
                    </button>
                </div>
                <div class="table-responsive">
                    <table class="table table-condensed" id="sortable-table">
                        <thead>
                            <tr>
                                <th>Options</th>
                                <th width="40x;">No</th>
                                <th>Judul Kegiatan</th>
                                <th>Deskripsi</th>
                                <th>Durasi (hari)</th>
                                <th>Anggaran</th>
                                <th>Realisasi</th>
                                <th>Progress Pekerjaan</th>
                                <th width="120px;">Status</th>
                                
                            </tr>
                        </thead>
                        <tbody>
                            @php $n =1 @endphp

                            @foreach($project_subtasks as $subtask)
                            <tr>
                                <td>
									<div class="btn-group">
                                        <button class="btn btn-sm btn-info btn-edit-task" data-id="{{ $subtask->id }}"
                                            data-bs-toggle="modal" data-bs-target="#progress_edit{{$subtask->id}}"><i
                                                class="fa fa-edit"></i>
                                            </button>
                                        <button class="btn btn-sm btn-danger btn-delete-task"
                                            data-id="{{ $subtask->id }}"><i class="fa fa-trash"></i>
                                            </button>
                                    </div>	
								</td>
                                <td>{{ $n++ }}</td>
                                <td>{{ $subtask->nama_subtask }}</td>
                                <td>{!! nl2br(e($subtask->deskripsi)) !!} </td>
                                <td>{{ $subtask->durasi }}</td>
                                <td>{{ rupiah($subtask->anggaran ?? 0) }}</td>
                                <td>{{ rupiah($subtask->realisasi ?? 0) }}</td>
                                <td>{{ $subtask->progress ?? 0 }}%</td>
                                <td>
                                    @switch($subtask->status)
                                    @case(0)
                                    On To-do
                                    @break
                                    @case(1)
                                    On Progress
                                    @break
                                    @case(2)
                                    Request Selesai
                                    @break
                                    @case(3)
                                    Selesai
                                    @break
                                    @default
                                    Tidak diketahui
                                    @endswitch
                                </td>
                                
                            </tr>
							<tr>
								<td colspan="2"></td>
								<td colspan="7">{{ $subtask->deskripsi }}</td>
							</tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="tab-pane" id="approval" role="tabpanel">


            </div>
            <div class="tab-pane" id="pic-anggota" role="tabpanel">
                <div class="d-flex align-items-center w-100 mb-3">
                    <button type="button" class="btn btn-sm btn-primary waves-effect waves-light ms-auto"
                        data-bs-toggle="modal" data-bs-target="#tambah_anggota_proyek">
                        Tambah Anggota
                    </button>
                </div>
                <div>
                    <?php 
						//dd($project_members);
                        $n = 1;
                    ?>
                    <table class="table">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama</th>
                                <th>Email</th>
                                <th>Phone</th>
                                <th>Role</th>
                                <th>Kelola</th>
                            </tr>
                        </thead>
                        @foreach($project_members as $row)
                        <tr>
                            <td>{{$n++}}</td>
                            <td>{{ $row->contact->name ?? "-" }}</td>
                            <td>{{ $row->contact->email ?? "-" }}</td>
                            <td>{{ $row->contact->phone ?? "-"}}</td>
                            <td>
                                @if($row->memberUsers->user->roles)
                                @foreach($row->memberUsers->user->roles as $role)
                                <span class="badge bg-primary">{{ $role->name }}</span>
                                @endforeach
                                @else
                                -
                                @endif
                            </td>
                            <td><button class="btn btn-sm btn-danger btn-delete-anggota-proyek" data-id="{{ $row->id }}"
                                    data-kontak_id="{{ $row->contact_id }}"
                                    data-project_id="{{ $row->project_id }}">Delete</button></td>
                        </tr>
                        @endforeach
                    </table>
                </div>

            </div>
            <div class="tab-pane" id="dokumen-proyek" role="tabpanel">
                <div class="d-flex align-items-center w-100 mb-3">
                    <button type="button" class="btn btn-sm btn-primary waves-effect waves-light ms-auto"
                        data-bs-toggle="modal" data-bs-target="#upload_dokumen">
                        Upload Dokumen
                    </button>
                </div>
                <table class="table table-condensed">
                    <thead>
                        <tr>
                            <th width="40x;">No</th>
                            <th>Judul</th>
                            <th>Nama Dokumen</th>
                            <th>Task</th>
                            <th width="120px;">Kelola</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php $n =1 @endphp
                        @foreach ($project_documents as $dokumen )

                        <tr>
                            <td>{{ $n++ }}</td>
                            <td>{{ $dokumen->judul }}</td>
                            <td>{{ $dokumen->nama_dokumen }} </td>
                            <td>{{ $dokumen->nama_subtask }}</td>
                            <td>
                                <button class="btn btn-sm btn-danger btn-delete-dokumen" data-id="{{ $dokumen->id }}"><i
                                        class="fa fa-trash"></i>
                                    Hapus</button>
                            </td>
                        </tr>

                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>


    </div>

</div>
<div class="modal fade" id="progress_baru" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="progress_baruLabel" style="display: none;" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="progress_baru   Label">Sub Task Proyek</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="post" action="{{ route('admin.subtask.store') }}" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">

                    <div class="modal-body row">
                        <div class="col-lg-12">
                            <div class="form-group hidden">
                                <input type="hidden" name="project_id" value="{{ $project->id }}">
                            </div>

                            <div class="form-group">
                                <label>Nama/Judul Sub Task</label>
                                <input type="text" name="nama_subtask" class="form-control">
                            </div>

                            <div class="form-group">
                                <label>Deskripsi</label>
                                <textarea name="deskripsi" class="form-control"></textarea>
                            </div>
                            <div class="form-group">
                                <label>Durasi (hari)</label>
                                <input type="number" name="durasi" class="form-control">
                            </div>
                            <div class="form-group">
                                <label>Anggaran</label>
                                <input type="number" name="anggaran" class="form-control">
                            </div>
                            <hr>
                            <h4>Upload Dokumen (Opsional)</h4><br>
                            <div class="form-group">
                                <label>Nama Dokumen</label>
                                <input type="text" name="judul_dokumen" class="form-control">
                            </div>
                            <br>
                            <div class="form-group">
                                <label class="control-label">Pilih Dokumen</label>
                                <input type="file" name="dokumen">
                            </div>


                        </div>


                    </div>


                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light btn-sm" data-bs-dismiss="modal">Tutup</button>
                    <button type="submit" class="btn btn-sm btn-primary">Buat Subtask</button>
                </div>

            </form>
        </div>
    </div>
</div>
@foreach($project_subtasks as $subtask)

<div class="modal fade" id="progress_edit{{ $subtask->id }}" data-bs-backdrop="static" data-bs-keyboard="false"
    tabindex="-1" aria-labelledby="progress_editLabel" style="display: none;" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="progress_editLabel">Update Sub Task Proyek</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="post" action="{{ route('admin.subtask.update' , ['id' => $subtask->id ]) }}"
                enctype="multipart/form-data">
                @csrf
                <div class="modal-body">

                    <div class="modal-body row">
                        <div class="col-lg-12">
                            <div class="form-group hidden">
                                <input type="hidden" name="project_id" value="{{ $project->id }}">
                                <input type="hidden" name="subtask_id" value="{{ $subtask->id }}">
                            </div>

                            <div class="form-group">
                                <label>Nama/Judul Sub Task</label>
                                <input type="text" name="nama_subtask" class="form-control"
                                    value="{{ $subtask->nama_subtask }}">
                            </div>

                            <div class="form-group">
                                <label>Deskripsi</label>
                                <textarea name="deskripsi" class="form-control">{{ $subtask->deskripsi }}</textarea>
                            </div>
                            <div class="form-group">
                                <label>Durasi (hari)</label>
                                <input type="number" name="durasi" class="form-control"
                                    value="{{ $subtask->durasi ?? 0}}">
                            </div>
                            <div class="form-group">
                                <label>Anggaran (Rp.)</label>
                                <input type="number" name="anggaran" class="form-control"
                                    value="{{ $subtask->anggaran ?? 0 }}">
                            </div>
                            <div class="form-group">
                                <label>Realisasi (Rp.)</label>
                                <input type="number" name="realisasi" class="form-control"
                                    value="{{ $subtask->realisasi ?? 0 }}">
                            </div>
                            <div class="mt-3 mb-3">
                                <label for="progressRange{{ $subtask->id }}" class="form-label">
                                    Progress: <span id="rangeValue{{ $subtask->id }}">{{ $subtask->progress }}%</span>
                                </label>
                                <input type="range" name="progress" class="form-range progressRange"
                                    id="progressRange{{ $subtask->id }}" data-id="{{ $subtask->id }}"
                                    value="{{ $subtask->progress ?? 0 }}" min="0" max="100">
                            </div>

                        </div>


                    </div>


                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light btn-sm" data-bs-dismiss="modal">Tutup</button>
                    <button type="submit" class="btn btn-sm btn-primary">Update Subtask</button>
                </div>

            </form>
        </div>
    </div>
</div>

@endforeach

<div class="modal fade" id="tambah_anggota_proyek" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="tambah_anggota_proyekLabel" style="display: none;" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="tambah_anggota_proyekLabel">Anggota Proyek</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="formTambahAnggotaProyek" method="post" action="{{ route('member.store') }}"
                enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="project_id" value="{{ $project->id}}">
                <div class="modal-body">
                    <div class="alert alert-info">Jika kontak belum tersedia, silahkan datakan kontak/user pada menu:
                        Data Master > Kontraktor > <a href="{{ route('kontak.index') }}">Data Kontak</a>.</div>

                    <div id="error-area"></div>
                    <div class="form-group">
                        <label>Contact</label>
                        <select name="contact_id" class="form-control">
                            <option value="">--Pilih anggota--</option>
                            @foreach($contacts as $contact)
                            <option value="{{ $contact->id}}">{{ $contact->name}}</option>
                            @endforeach
                        </select>
                        <small class="invalid-feedback error-contact_id"></small>
                    </div>

                    <div class="form-group mt-1">
                        <label>Tugas/Role</label>
                        <select name="role_in_project" class="form-control">
                            <option value="kontraktor">Kontraktor</option>
                            <option value="pengawas">Pengawas</option>
                            <option value="pelaksana">Pelaksana</option>
                        </select>
                        <small class="invalid-feedback error-role_in_project"></small>
                    </div>

                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-sm btn-light" data-bs-dismiss="modal">Tutup</button>
                    <button type="submit" class="btn btn-sm btn-primary">Simpan</button>
                </div>

            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="upload_dokumen" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="upload_dokumenLabel" style="display: none;" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="upload_dokumenLabel">Upload Dokumen</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="formUploadDokumen" method="post" action="{{ route('admin.subtask.dokumen.store') }}"
                enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="project_id" value="{{ $project->id}}">
                <div class="modal-body">
                    <div id="error-area"></div>

                    <div class="form-group">
                        <label>Jenis Dokumen</label>
                        <select name="jenis_dokumen_id" class="form-control">
                            <option value="0">-</option>
                            <option value="1">Dokumen Kontrak</option>
                            <option value="2">Dokumen ???</option>

                        </select>
                    </div>

                    <div class="form-group">
                        <label>Task</label>
                        <select name="subtask_id" class="form-control">
                            <option value="0">-</option>
                            @foreach($project_subtasks as $subtask)
                            <option value="{{ $subtask->id}}">{{ $subtask->nama_subtask}}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group mt-1">
                        <label>Nama Dokumen</label>
                        <input type="text" name="judul_dokumen" class="form-control">
                    </div>
                    <br>
                    <div class="form-group">
                        <label class="control-label">Pilih Dokumen</label>
                        <input type="file" name="dokumen">
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-sm btn-light" data-bs-dismiss="modal">Tutup</button>
                    <button type="submit" class="btn btn-sm btn-primary">Upload</button>
                </div>

            </form>
        </div>
    </div>
</div>
@endif


@endsection
@push('js')
<script src="https://cdnjs.cloudflare.com/ajax/libs/Sortable/1.15.0/Sortable.min.js"></script>
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
@endpush
@push('scripts')

<script>
    $(document).ready(function() {
    $('#formTambahAnggotaProyek').on('submit', function(e) {
        e.preventDefault(); // mencegah submit default

        let form = $(this);
        let url = form.attr('action');
        let data = form.serialize(); // ambil semua field + csrf

        $.ajax({
            url: url,
            method: 'POST',
            data: data,
            success: function(response) {
                // jika sukses
                if(response.success) {
                    // Tutup modal
                    $('#add-contact').modal('hide');

                    // Reset form
                    form[0].reset();

                    // Optional: tampilkan notifikasi
                    alert(response.message || 'Kontak berhasil ditambahkan');
 
                }
            },
            error: function(xhr) {
                // Handle error validation
                let errors = xhr.responseJSON.errors;
                if(errors) {
                    if (xhr.status === 422) {

                    let errors = xhr.responseJSON.errors;

                    $.each(errors, function (key, value) {
                        // Tambah class is-invalid
                        $('[name="' + key + '"]').addClass('is-invalid');

                        // Tampilkan error di bawah input
                        $('.error-' + key).text(value[0]);
                    });
                }
                } else {
                    alert('Terjadi kesalahan. Silakan coba lagi.');
                }
            }
        });
    });
});
</script>

<script>
    $(document).on('click', '.btn-delete-anggota-proyek', function () {

    let id = $(this).data('id');

    Swal.fire({
        title: "Yakin ingin menghapus?",
        text: "Data tidak dapat dikembalikan!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonText: "Ya, hapus",
        cancelButtonText: "Batal"
    }).then((result) => {
        if (result.isConfirmed) {

            $.ajax({
                url: "{{ url('/member') }}/" + id,
                type: "DELETE",
                data: {
                    _token: "{{ csrf_token() }}"
                },
                success: function (res) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil',
                        text: res.message,
                        timer: 1500,
                        showConfirmButton: false
                    });

                    setTimeout(() => {
                        location.reload();
                    }, 1500);
                },
                error: function(xhr) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Gagal',
                        text: xhr.responseJSON.message || "Terjadi kesalahan."
                    });
                }
            });

        }
    });

});
</script>


<script>
    document.querySelectorAll('.progressRange').forEach(slider => {
    const id = slider.dataset.id;
    const rangeValue = document.getElementById('rangeValue' + id);

    function updateSlider(value) {
        rangeValue.textContent = value + '%';

        // Tentukan warna angka
        let color;
        if (value < 50) color = 'red';
        else if (value < 80) color = 'orange'; // kuning agak gelap supaya terbaca
        else color = 'green';

        // Ganti warna teks saja, bukan slider
        rangeValue.style.color = color;
    }

    // Inisialisasi
    updateSlider(slider.value);

    // Event listener
    slider.addEventListener('input', (e) => updateSlider(e.target.value));
});
</script>

<script>
    $(document).on('click', '.btn-delete-task', function() {
    let id = $(this).data('id');
    let url = "{{ route('admin.proyek.subtask.delete', ':id') }}";
    url = url.replace(':id', id);

    Swal.fire({
        title: "Are you sure?",
        text: "Data will be permanently deleted!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#34c38f",
        cancelButtonColor: "#f46a6a",
        confirmButtonText: "Yes, delete it!"
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: url,
                type: "POST",
                data: {
                    _token: "{{ csrf_token() }}",
                    _method: "DELETE"
                },
                success: function(response) {
                    Swal.fire("Deleted!", response.message, "success")
                    .then(() => {
                        location.reload(); // ✅ Reload halaman
                    });
                },
                error: function() {
                    Swal.fire("Error!", "Failed to delete data.", "error");
                }
            });
        }
    });
});

$(document).on('click', '.btn-delete-dokumen', function() {
    let id = $(this).data('id');
    let url = "{{ route('admin.proyek.subtask.delete.dokumen', ':id') }}";
    url = url.replace(':id', id);

    Swal.fire({
    title: "Are you sure?",
    text: "Data will be permanently deleted!",
    icon: "warning",
    showCancelButton: true,
    confirmButtonColor: "#34c38f",
    cancelButtonColor: "#f46a6a",
    confirmButtonText: "Yes, delete it!"
    }).then((result) => {
    if (result.isConfirmed) {
    $.ajax({
    url: url,
    type: "POST",
    data: {
    _token: "{{ csrf_token() }}",
    _method: "DELETE"
    },
    success: function(response) {
    Swal.fire("Deleted!", response.message, "success")
    .then(() => {
    location.reload(); // ✅ Reload halaman
    });
    },
    error: function() {
    Swal.fire("Error!", "Failed to delete data.", "error");
    }
    });
    }
    });
});
$(document).ready(function(){
    $('#formUploadDokumen').on('submit', function(e){
        e.preventDefault();

        let formData = new FormData(this);

        $.ajax({
        url: $(this).attr('action'),
        type: "POST",
        data: formData,
        contentType: false,
        processData: false,
        beforeSend: function(){
        $('#error-area').addClass('d-none').html('');
        },
        success: function(response){
        if(response.status === 'success'){
        Swal.fire('Berhasil', response.message, 'success');

        $('#upload_dokumen').modal('hide');
        $('#formUploadDokumen')[0].reset();
        }
        },
        error: function(xhr){
        if(xhr.status === 422){
        let errors = xhr.responseJSON.errors;
        let html = '<ul>';

            $.each(errors, function(key, value){
            html += `<li>${value[0]}</li>`;
            });

            html += '</ul>';

        $('#error-area').removeClass('d-none').html(html);
        }
        }
        });
    });

});

// @if(session('success'))

    
    // Command: toastr["info"]("{{ session('success') }}")

// @endif

// @if(session('error'))

    // Command: toastr["error"]("{{session('error')}}")

// @endif

</script>
@endpush



@push('scripts')
<script>
    let map, marker;

const projectLat = {{ $project->latitude ?? 'null' }};
const projectLng = {{ $project->longitude ?? 'null' }};

document.getElementById('mapModal').addEventListener('shown.bs.modal', function () {

    if (!map) {

        let defaultLat = -6.84;
        let defaultLng = 107.59;

        let centerLat = projectLat !== null ? projectLat : defaultLat;
        let centerLng = projectLng !== null ? projectLng : defaultLng;

        // ✅ MODE READ ONLY
        map = L.map('map', {
            dragging: false,
            zoomControl: false,
            scrollWheelZoom: false,
            doubleClickZoom: false,
            boxZoom: false,
            keyboard: false,
            tap: false,
            touchZoom: false
        }).setView([centerLat, centerLng], 13);

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 19
        }).addTo(map);

        // ✅ Marker statis
        if (projectLat !== null && projectLng !== null) {
            marker = L.marker([projectLat, projectLng], {
                draggable: false
            }).addTo(map)
              .bindPopup(
                `<b>Lokasi Project {{ $project->name }}</b><br>
                 Latitude: ${projectLat}<br>
                 Longitude: ${projectLng}`
              )
              .openPopup();
        }
    }

    // Fix agar map tidak blank saat modal tampil
    setTimeout(() => {
        map.invalidateSize();
    }, 300);
});
</script>
@endpush
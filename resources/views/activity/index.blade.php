@extends('layouts.admin.app')
@push('title', "Logs")
@section('content')
<div class="container-fluid">
    <h4 class="mb-4">Log Aktivitas</h4>

    <div class="d-flex flex-wrap align-items-center justify-content-between mb-3">
        <div>
            <h4 class="card-title mb-1">Log Aktivitas Sistem</h4>
            <p class="card-title-desc mb-0">Rekam jejak seluruh kegiatan pengguna dan sistem</p>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('activity.export', request()->query()) }}" class="btn btn-sm btn-outline-secondary">
                <i class="bx bx-download"></i> Export CSV
            </a>
            <a href="{{ url('/activity-log') }}" class="btn btn-sm btn-primary">
                <i class="bx bx-refresh"></i> Refresh
            </a>
        </div>
    </div>

    <form id="filterForm" method="GET" action="{{ url('activity-log') }}" class="mb-3">
        <div class="row g-2 align-items-end">
            <div class="col-md-5">
                <input type="text" name="search" class="form-control form-control-sm"
                    placeholder="Cari user / aktivitas..." value="{{ request('search') ?? ''}}">
            </div>
            <div class="col-md-2">
                <select name="user_id" class="form-select form-select-sm" onchange="this.form.submit()">
                    <option value="">Semua User</option>

                    @foreach($causers as $user)
                    <option value="{{ $user->id }}" {{ request('user_id')==$user->id ? 'selected' : '' }}>
                        {{ $user->name }}
                    </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-2">
                <input type="date" name="start_date" class="form-control form-control-sm"
                    value="{{ request('start_date') ?? ''}}" placeholder="Dari">
            </div>
            <div class="col-md-2">
                <input type="date" name="end_date" class="form-control form-control-sm"
                    value="{{ request('end_date') ?? ''}}" placeholder="Sampai">
            </div>
            <div class="col-md-1">
                <div class="d-flex gap-1">
                    <button class="btn btn-sm btn-primary" type="submit"><i class="bx bx-search"></i></button>
                </div>
            </div>
        </div>
    </form>

    <div class="card shadow shadow-sm">
        <div class="card-body table-responsive">
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Waktu</th>
                        <th>User</th>
                        <th>Event</th>
                        <th>Modul</th>
                        <th>Model</th>
                        <th>Subject ID</th>

                        <th>Detail</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($logs as $log)
                    <tr>
                        <td>{{ ($logs->currentPage() - 1) * $logs->perPage() + $loop->iteration }}</td>
                        <td>{{ $log->created_at->format('d-m-Y H:i:s') }}</td>
                        <td>
                            <div class="d-flex align-items-center">
                                <span class="avatar-xs me-2">
                                    <span
                                        class="avatar-title rounded-circle bg-primary bg-soft text-primary font-size-12">
                                        {{ strtoupper(substr($log->causer->name ?? '?', 0, 1)) }}</span>
                                </span>
                                {{ $log->causer->name ?? '-' }}
                            </div>
                        </td>
                        <td>
                            @if($log->event)
                            <span class="badge rounded-pill badge-soft-info">
                                {{ $log->event }}
                            </span>
                            @endif
                        </td>
                        <td>{{ $log->log_name }}</td>
                        <td>{{ class_basename($log->subject_type) }}</td>
                        <td>{{ $log->subject_id }}</td>

                        <td>
                            <button class="btn btn-sm btn-outline-primary btn-detail" data-bs-toggle="modal"
                                data-bs-target="#modal{{ $log->id }}">
                                <i class="fa fa-eye"></i>
                            </button>
                            @php
                            $properties = $log->properties->toArray() ?? [];

                            // Detect structure
                            $newData = $properties['new']
                            ?? $properties['attributes']
                            ?? [];

                            $oldData = $properties['old'] ?? [];

                            // Jika tidak ada old (create event), tampilkan semua sebagai new
                            $isUpdate = !empty($oldData);

                            $changes = [];

                            if ($isUpdate) {
                            foreach ($newData as $key => $value) {
                            $oldValue = $oldData[$key] ?? null;

                            if ($oldValue != $value) {
                            $changes[$key] = [
                            'old' => $oldValue,
                            'new' => $value
                            ];
                            }
                            }
                            } else {
                            foreach ($newData as $key => $value) {
                            $changes[$key] = [
                            'old' => null,
                            'new' => $value
                            ];
                            }
                            }
                            @endphp

                            <!-- Modal -->
                            <div class="modal fade" id="modal{{ $log->id }}" tabindex="-1">
                                <div class="modal-dialog modal-lg">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">
                                                Detail Log
                                            </h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="modal-body">

                                                <div class="mb-3 small">
                                                    <strong>User :</strong> {{ $log->causer->name ?? '-' }} <br>
                                                    <strong>Event :</strong>
                                                    <span class="badge bg-primary">{{ $log->event }}</span><br>
                                                    <strong>Tanggal :</strong> {{ $log->created_at->format('d M Y
                                                    H:i:s') }}
                                                </div>

                                                <div class="table-responsive">
                                                    <table class="table table-bordered table-sm align-middle">
                                                        <thead class="table-light">
                                                            <tr>
                                                                <th width="30%">Field</th>
                                                                <th width="35%">Old Value</th>
                                                                <th width="35%">New Value</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @forelse($changes as $field => $row)
                                                            <tr>
                                                                <td><strong>{{ $field }}</strong></td>

                                                                <td class="text-danger">
                                                                    {{ $row['old'] ?? '-' }}
                                                                </td>

                                                                <td class="text-success">
                                                                    {{ $row['new'] ?? '-' }}
                                                                </td>
                                                            </tr>
                                                            @empty
                                                            <tr>
                                                                <td colspan="3" class="text-center text-muted">
                                                                    Tidak ada perubahan
                                                                </td>
                                                            </tr>
                                                            @endforelse
                                                        </tbody>
                                                    </table>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="text-center">Tidak ada data</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>

            <div class="mt-3">

                @if ($logs->hasPages())
                <div class="d-flex flex-column flex-md-row justify-content-between align-items-center mt-3 gap-2">

                    {{-- Info Data --}}
                    <div class="text-muted small">
                        Menampilkan
                        <strong>{{ $logs->firstItem() }}</strong>
                        –
                        <strong>{{ $logs->lastItem() }}</strong>
                        dari
                        <strong>{{ $logs->total() }}</strong>
                        data
                    </div>

                    {{-- Pagination --}}
                    <div>
                        {{ $logs->onEachSide(1)->links() }}
                    </div>

                </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
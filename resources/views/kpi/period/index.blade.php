@extends('layouts.admin.app')

@push('styles')
<style>
    .card-header-title {
        font-weight: 600;
        letter-spacing: .2px;
    }

    .table-hover tbody tr:hover {
        background-color: rgba(13, 110, 253, .04);
    }

    .badge-soft {
        padding: .4em .7em;
        font-weight: 500;
        border-radius: 50rem;
    }

    .action-btns button,
    .action-btns a {
        margin-right: 6px;
    }

    .page-title {
        font-weight: 700;
    }
</style>
@endpush

@section('content')

<div class="container-fluid">

    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="page-title mb-0">Performance Period</h4>
            <small class="text-muted">Manage KPI evaluation periods</small>
        </div>

        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#periodModal">
            <i class="fas fa-plus me-1"></i> New Period
        </button>
    </div>

    <!-- Card -->
    <div class="card shadow-sm border-0">
        <div class="card-header bg-white py-3">
            <span class="card-header-title">List of Periods</span>
        </div>

        <div class="card-body p-0">

            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>#</th>
                            <th>Period Name</th>
                            <th>Start Date</th>
                            <th>End Date</th>
                            <th>Status</th>
                            <th width="160">Action</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse($periods as $key => $period)
                        <tr>
                            <td>{{ $key + 1 }}</td>
                            <td class="fw-semibold">{{ $period->name }}</td>
                            <td>{{ \Carbon\Carbon::parse($period->start_date)->translatedFormat('d F Y') }}</td>
                            <td>{{ \Carbon\Carbon::parse($period->end_date)->translatedFormat('d F Y') }}</td>

                            <td>
                                @if($period->status === 'active')
                                <span class="badge bg-success badge-soft">Active</span>

                                @elseif($period->status === 'closed')
                                <span class="badge bg-danger badge-soft">Closed</span>
                                @else
                                <span class="badge bg-secondary badge-soft">Draft</span>
                                @endif
                            </td>

                            <td class="action-btns">

                                <button class="btn btn-sm btn-outline-primary editBtn" data-id="{{ $period->id }}">
                                    <i class="fas fa-edit"></i>
                                </button>

                                <button class="btn btn-sm btn-outline-danger deleteBtn" data-id="{{ $period->id }}">
                                    <i class="fas fa-trash"></i>
                                </button>

                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center py-4 text-muted">
                                No data available
                            </td>
                        </tr>
                        @endforelse
                    </tbody>

                </table>
            </div>

        </div>
    </div>

</div>

<!-- MODAL CREATE/EDIT -->
<div class="modal fade" id="periodModal" tabindex="-1">
    <div class="modal-dialog modal-md modal-dialog-centered">
        <div class="modal-content border-0 shadow">

            <div class="modal-header">
                <h5 class="modal-title">Performance Period</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <form id="periodForm">
                <div class="modal-body">

                    <input type="hidden" id="period_id">

                    <div class="mb-3">
                        <label class="form-label">Period Name</label>
                        <input type="text" class="form-control" id="name" placeholder="e.g. 2026 Q1">
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Start Date</label>
                            <input type="date" class="form-control" id="start_date">
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">End Date</label>
                            <input type="date" class="form-control" id="end_date">
                        </div>
                    </div>

                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="status">
                        <label class="form-check-label">
                            Active Period
                        </label>
                    </div>

                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">
                        Save
                    </button>
                </div>

            </form>

        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
    $(document).ready(function () {


    // CREATE / UPDATE
    $('#periodForm').on('submit', function (e) {
        e.preventDefault();

        let id = $('#period_id').val();
        let url = id ? `/kpi/period/${id}` : `/kpi/period`;
        let method = id ? 'PUT' : 'POST';

        $.ajax({
            url: url,
            method: method,
            data: {
                name: $('#name').val(),
                start_date: $('#start_date').val(),
                end_date: $('#end_date').val(),
                status : $('#status').is(':checked') ? 'active' : 'closed',
                _token: '{{ csrf_token() }}'
            },
            success: function () {
                location.reload();
            }
        });
    });

    function formatDate(dateString) {
    if (!dateString) return '';
    
    const date = dateString.substring(0, 10); // 2026-06-30
    const [year, month, day] = date.split('-');
    
    return `${day}/${month}/${year}`;
    }

    // EDIT
    $('.editBtn').on('click', function () {

        let id = $(this).data('id');

        $.get(`/kpi/period/${id}/edit`, function (data) {

            $('#period_id').val(data.id);
            $('#name').val(data.name);

          
            $('#start_date').val(data.start_date.substring(0, 10));
            $('#end_date').val(data.end_date.substring(0, 10));

            //$('#is_active').prop('checked', data.is_active);
            $('#status').prop('checked', data.status === 'active');


            $('#periodModal').modal('show');
        });
    });

    // DELETE
    $('.deleteBtn').on('click', function () {

        if (!confirm('Delete this period?')) return;

        let id = $(this).data('id');

        $.ajax({
            url: `/kpi/period/${id}`,
            method: 'DELETE',
            data: {
                _token: '{{ csrf_token() }}'
            },
            success: function () {
                location.reload();
            }
        });

    });

});
</script>
@endpush
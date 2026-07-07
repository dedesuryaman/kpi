@extends('layouts.admin.app')

@section('content')

<div class="container-fluid">

    {{-- Header --}}
    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>
            <h3 class="fw-bold mb-1">
                KPI Master
            </h3>
            <p class="text-muted mb-0">
                Manage KPI Master & Indicators
            </p>
        </div>

        <a href="{{ route('kpi.master.create') }}" class="btn btn-primary">
            <i class="fas fa-plus me-2"></i>
            Create KPI Master
        </a>

    </div>

    {{-- Search --}}
    <div class="card shadow-sm border-0 mb-4">

        <div class="card-body">

            <form method="GET" action="{{ route('kpi.master.index') }}">

                <div class="row">

                    <div class="col-md-10">

                        <div class="input-group">

                            <span class="input-group-text bg-white">
                                <i class="fas fa-search text-secondary"></i>
                            </span>

                            <input type="text" name="search" class="form-control" placeholder="Search KPI Master..."
                                value="{{ request('search') }}">

                        </div>

                    </div>

                    <div class="col-md-2 d-grid">

                        <button class="btn btn-primary">
                            <i class="fas fa-search me-2"></i>
                            Search
                        </button>

                    </div>

                </div>

            </form>

        </div>

    </div>

    {{-- Table --}}
    <div class="card shadow-sm border-0">

        <div class="table-responsive">

            <table class="table table-hover align-middle mb-0">

                <thead class="table-light">

                    <tr>

                        <th width="60">#</th>

                        <th>KPI Master</th>

                        <th>Description</th>

                        <th class="text-center" width="120">
                            Indicators
                        </th>

                        <th class="text-center" width="120">
                            Status
                        </th>

                        <th class="text-center" width="150">
                            Action
                        </th>

                    </tr>

                </thead>

                <tbody>

                    @forelse($masters as $master)

                    <tr>

                        <td>
                            {{ $loop->iteration }}
                        </td>

                        <td>

                            <div class="fw-semibold">
                                {{ $master->name }}
                            </div>

                        </td>

                        <td>

                            <span class="text-muted">
                                {{ $master->description ?: '-' }}
                            </span>

                        </td>

                        <td class="text-center">

                            <span class="badge bg-primary">
                                {{ $master->indicators->count() }}
                            </span>

                        </td>

                        <td class="text-center">

                            @if($master->status)

                            <span class="badge bg-success">
                                Active
                            </span>

                            @else

                            <span class="badge bg-secondary">
                                Inactive
                            </span>

                            @endif

                        </td>

                        <td>

                            <div class="d-flex justify-content-center gap-2">

                                <a href="{{ route('kpi.master.edit',$master->id) }}" class="btn btn-sm btn-warning">

                                    <i class="fas fa-pen"></i>

                                </a>
                                <form action="{{ route('kpi.master.destroy', $master->id) }}" method="POST"
                                    class="delete-form d-inline">

                                    @csrf
                                    @method('DELETE')

                                    <button type="submit" class="btn btn-sm btn-danger delete-btn"
                                        data-name="{{ $master->name }}">

                                        <i class="fas fa-trash"></i>

                                    </button>

                                </form>

                            </div>

                        </td>

                    </tr>

                    @empty

                    <tr>

                        <td colspan="6">

                            <div class="text-center py-5">

                                <i class="fas fa-chart-line fa-4x text-secondary mb-3"></i>

                                <h5>No KPI Master Found</h5>

                                <p class="text-muted">
                                    There are no KPI Master records available.
                                </p>

                            </div>

                        </td>

                    </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

        @if(method_exists($masters,'links'))

        <div class="card-footer bg-white">

            {{ $masters->links() }}

        </div>

        @endif

    </div>

</div>

@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {

    document.querySelectorAll('.delete-form').forEach(function(form){

        form.addEventListener('submit', function(e){

            e.preventDefault();

            const button = form.querySelector('.delete-btn');
            const name = button.dataset.name;

            Swal.fire({

                title: 'Delete KPI Master?',
                html: `
                    Are you sure you want to delete
                    <br><br>
                    <strong>${name}</strong>?
                    <br><br>
                    This action cannot be undone.
                `,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#dc3545',
                cancelButtonColor: '#6c757d',
                confirmButtonText: '<i class="fas fa-trash me-1"></i> Delete',
                cancelButtonText: '<i class="fas fa-times me-1"></i> Cancel',
                reverseButtons: true

            }).then((result) => {

                if (result.isConfirmed) {

                    button.disabled = true;

                    button.innerHTML = `
                        <span class="spinner-border spinner-border-sm"></span>
                    `;

                    form.submit();

                }

            });

        });

    });

});


</script>

@if(session('success'))
<script>
    Swal.fire({
    icon: 'success',
    title: 'Success',
    text: '{{ session("success") }}',
    timer: 2000,
    showConfirmButton: false
});
</script>
@endif

@if(session('error'))
<script>
    Swal.fire({
    icon: 'error',
    title: 'Failed',
    text: '{{ session("error") }}'
});
</script>
@endif

@endpush
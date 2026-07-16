@extends('layouts.admin.app')

@section('title', 'Position Report')

@section('content')

<div class="container-fluid">

    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>

            <h4 class="fw-bold mb-1">
                <i class="bi bi-briefcase-fill text-primary me-2"></i>
                Position Report
            </h4>

            <p class="text-muted mb-0">
                Position master data report.
            </p>

        </div>

        <div class="btn-group">

            <a href="{{ route('reports.master.positions.excel', request()->query()) }}" class="btn btn-success">
                <i class="bi bi-file-earmark-excel me-1"></i>
                Export Excel

            </a>

            <a href="{{ route('reports.master.positions.pdf', request()->query()) }}" class="btn btn-danger">


                <i class="bi bi-file-earmark-pdf me-1"></i>
                Export PDF

            </a>

            <a href="{{ route('reports.index') }}" class="btn btn-secondary">

                <i class="bi bi-arrow-left-circle me-2"></i>

                Back

            </a>

        </div>

    </div>

    <div class="card shadow-sm">

        <div class="card-body">

            <div class="row mb-3">

                <div class="col-md-4">

                    <input type="text" class="form-control" placeholder="Search position...">

                </div>

            </div>

            <div class="table-responsive">

                <table class="table table-hover align-middle">

                    <thead class="table-light">

                        <tr>

                            <th width="70">#</th>

                            <th>Position Name</th>
                            <th>Description</th>
                            <th>Total Employees</th>

                        </tr>

                    </thead>

                    <tbody>

                        @forelse($positions as $position)

                        <tr>

                            <td>
                                {{ $loop->iteration + ($positions->firstItem() - 1) }}
                            </td>


                            <td>
                                {{ $position->name }}
                            </td>

                            <td>
                                {{ $position->description ?? '-' }}
                            </td>

                            <td>

                                <span class="badge bg-primary">

                                    {{ $position->employees->count() }}

                                </span>

                            </td>

                        </tr>

                        @empty

                        <tr>

                            <td colspan="5" class="text-center py-5">

                                <i class="bi bi-inbox display-6 text-muted"></i>

                                <div class="mt-2">
                                    No position data found.
                                </div>

                            </td>

                        </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>

            <div class="mt-3">

                {{ $positions->links() }}

            </div>

        </div>

    </div>

</div>

@endsection
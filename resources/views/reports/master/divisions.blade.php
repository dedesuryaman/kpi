@extends('layouts.admin.app')

@section('title', 'Division Report')

@section('content')

<div class="container-fluid">

    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>

            <h4 class="fw-bold mb-1">
                <i class="bi bi-diagram-2-fill text-primary me-2"></i>
                Division Report
            </h4>

            <p class="text-muted mb-0">
                Division master data report.
            </p>

        </div>

        <div class="btn-group">



            <a href="{{ route('reports.master.divisions.excel', request()->query()) }}" class="btn btn-success">
                <i class="bi bi-file-earmark-excel me-1"></i>
                Export Excel

            </a>

            <a href="{{ route('reports.master.divisions.pdf', request()->query()) }}" class="btn btn-danger">


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



            <div class="table-responsive">

                <table class="table table-hover align-middle">

                    <thead class="table-light">

                        <tr>

                            <th width="70">#</th>

                            <th>Division Name</th>
                            <th>Description</th>
                            <th>Total Employees</th>

                        </tr>

                    </thead>

                    <tbody>

                        @forelse($divisions as $division)

                        <tr>

                            <td>
                                {{ $loop->iteration + ($divisions->firstItem() - 1) }}
                            </td>



                            <td>
                                {{ $division->name }}
                            </td>

                            <td>
                                {{ $division->description ?? '-' }}
                            </td>

                            <td>

                                <span class="badge bg-primary">

                                    {{ $division->employees->count() }}

                                </span>

                            </td>

                        </tr>

                        @empty

                        <tr>

                            <td colspan="5" class="text-center py-5">

                                <i class="bi bi-inbox display-6 text-muted"></i>

                                <div class="mt-2">
                                    No division data found.
                                </div>

                            </td>

                        </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>

            <div class="mt-3">

                {{ $divisions->links() }}

            </div>

        </div>

    </div>

</div>

@endsection
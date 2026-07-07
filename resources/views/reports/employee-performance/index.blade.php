@extends('layouts.admin.app')

@section('title', 'Employee Performance Report')

@section('content')

<div class="container-fluid">

    {{-- Page Header --}}
    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>
            <h3 class="fw-bold mb-1">
                Employee Performance Report
            </h3>

            <p class="text-muted mb-0">
                View and print employee performance evaluation reports.
            </p>
        </div>

        <div>


            <button type="button" id="btnExcel" class="btn btn-success">

                <i class="fas fa-file-excel me-2"></i>

                Export Excel

            </button>

            <a href="#" class="btn btn-danger" id="btnPdf">
                <i class="fas fa-file-pdf me-2"></i>
                Export PDF
            </a>

        </div>

    </div>

    {{-- Filter --}}
    <div class="card border-0 shadow-sm mb-4">

        <div class="card-header bg-white">

            <h5 class="mb-0 fw-bold">

                <i class="fas fa-filter me-2 text-primary"></i>

                Filter Report

            </h5>

        </div>

        <div class="card-body">

            <form id="filterForm">

                <div class="row g-3">

                    {{-- Period --}}
                    <div class="col-lg-3">

                        <label class="form-label fw-semibold">

                            Period

                        </label>

                        <select class="form-select select2" name="period_id">

                            <option value="">
                                All Period
                            </option>

                            @foreach($periods as $period)

                            <option value="{{ $period->id }}">



                                {{ ucfirst($period->name) }}

                            </option>

                            @endforeach

                        </select>

                    </div>

                    {{-- Department --}}
                    <div class="col-lg-3">

                        <label class="form-label fw-semibold">

                            Department

                        </label>

                        <select class="form-select select2" name="department_id">

                            <option value="">
                                All Department
                            </option>

                            @foreach($departments as $department)

                            <option value="{{ $department->id }}">

                                {{ $department->name }}

                            </option>

                            @endforeach

                        </select>

                    </div>

                    {{-- Position --}}
                    <div class="col-lg-3">

                        <label class="form-label fw-semibold">

                            Position

                        </label>

                        <select class="form-select select2" name="position_id">

                            <option value="">
                                All Position
                            </option>

                            @foreach($positions as $position)

                            <option value="{{ $position->id }}">

                                {{ $position->name }}

                            </option>

                            @endforeach

                        </select>

                    </div>

                    {{-- Employment --}}
                    <div class="col-lg-3">

                        <label class="form-label fw-semibold">

                            Employment Status

                        </label>

                        <select class="form-select select2" name="employment_status">

                            <option value="">
                                All Status
                            </option>

                            <option value="Permanent">
                                Permanent
                            </option>

                            <option value="Contract">
                                Contract
                            </option>

                            <option value="Probation">
                                Probation
                            </option>

                            <option value="Intern">
                                Intern
                            </option>

                        </select>

                    </div>

                    {{-- Search --}}
                    <div class="col-lg-6">

                        <label class="form-label fw-semibold">

                            Employee

                        </label>

                        <input type="text" class="form-control" name="keyword"
                            placeholder="Employee Code / Employee Name">

                    </div>

                    <div class="col-lg-6 d-flex align-items-end">

                        <div class="d-flex gap-2">

                            <button type="submit" class="btn btn-primary">

                                <i class="fas fa-search me-2"></i>

                                Search

                            </button>

                            <button type="reset" class="btn btn-secondary">

                                <i class="fas fa-sync-alt me-2"></i>

                                Reset

                            </button>

                        </div>

                    </div>

                </div>

            </form>

        </div>

    </div>

    {{-- Result --}}
    <div class="card border-0 shadow-sm">

        <div class="card-header bg-white">

            <h5 class="mb-0 fw-bold">

                <i class="fas fa-table me-2 text-success"></i>

                Employee Performance

            </h5>

        </div>

        <div class="card-body">

            <div id="reportResult">

                <div class="text-center py-5">

                    <i class="fas fa-chart-line fa-3x text-secondary mb-3"></i>

                    <h5 class="fw-bold">

                        Employee Performance Report

                    </h5>

                    <p class="text-muted mb-0">

                        Select filter then click

                        <strong>Search</strong>

                        to display report.

                    </p>

                </div>

            </div>

        </div>

    </div>

</div>

@endsection

@push('scripts')

<script>
    $(function (){

        $('#btnPrint').click(function(){
        
        let query = $('#filterForm').serialize();
        
        window.open(
        "{{ route('reports.employee-performance.print') }}?" + query,
        '_blank'
        );
        
        });

        $('#btnExcel').click(function () {
        
        let query = $('#filterForm').serialize();
        
        window.location.href =
        "{{ route('reports.employee-performance.excel') }}?" + query;
        
        });
        

        $('#btnPdf').click(function () {
        
        let query = $('#filterForm').serialize();
        
        window.open(
        "{{ route('reports.employee-performance.pdf') }}?" + query,
        '_blank'
        );
        
        });


    $('.select2').select2({

        theme:'bootstrap-5',

        width:'100%'

    });

    $('#filterForm').submit(function(e){

        e.preventDefault();

        $('#reportResult').html(

            '<div class="text-center py-5">'+
            '<div class="spinner-border text-primary"></div>'+
            '<p class="mt-3">Loading...</p>'+
            '</div>'

        );

        $.ajax({

            url:'{{ route("reports.employee-performance.table") }}',

            data:$(this).serialize(),

            success:function(response){

                $('#reportResult').html(response);

            }

        });

    });

    $('#filterForm').on('reset',function(){

        setTimeout(function(){

            $('.select2').val('').trigger('change');

        },100);

    });

});

</script>

@endpush
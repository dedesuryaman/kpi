@extends('layouts.admin.app')

@section('title', 'Markov Decision Process Analysis')

@section('content')

<div class="container-fluid">

    {{-- Header --}}
    <div class="row mb-3">

        <div class="col-lg-12">

            <div class="d-flex justify-content-between align-items-center">

                <div>

                    <h3 class="mb-0">
                        <i class="fas fa-project-diagram text-primary"></i>
                        Markov Decision Process Analysis
                    </h3>

                    <small class="text-muted">
                        Employee Performance Decision Support System
                    </small>

                </div>

            </div>

        </div>

    </div>

    {{-- Alert --}}
    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show">

        {{ session('success') }}

        <button class="btn-close" data-bs-dismiss="alert"></button>

    </div>
    @endif

    @if($errors->any())

    <div class="alert alert-danger">

        <ul class="mb-0">

            @foreach($errors->all() as $error)

            <li>{{ $error }}</li>

            @endforeach

        </ul>

    </div>

    @endif

    {{-- Run Analysis --}}
    <div class="card shadow-sm border-0">

        <div class="card-header bg-primary text-white">

            <h5 class="mb-0">

                <i class="fas fa-play-circle"></i>

                Run Markov Decision Process

            </h5>

        </div>

        <div class="card-body">

            <form method="POST" action="{{ route('mdp.run') }}">

                @csrf

                <div class="row">

                    <div class="col-lg-8">

                        <label class="form-label fw-bold">

                            Period

                        </label>

                        <select name="period_id" class="form-select select2" required>

                            <option value="">

                                -- Select Period --

                            </option>

                            @foreach($periods as $period)

                            <option value="{{ $period->id }}">

                                {{ $period->name }}

                            </option>

                            @endforeach

                        </select>

                    </div>

                    <div class="col-lg-4 d-flex align-items-end">

                        <button class="btn btn-success w-100">

                            <i class="fas fa-play"></i>

                            Run Analysis

                        </button>

                    </div>

                </div>

            </form>

        </div>

    </div>

    {{-- History --}}
    <div class="card shadow-sm border-0 mt-4">

        <div class="card-header bg-secondary text-white">

            <h5 class="mb-0">

                <i class="fas fa-history"></i>

                Analysis History

            </h5>

        </div>

        <div class="card-body">

            <div class="table-responsive">

                <table class="table table-bordered table-hover align-middle" id="historyTable">

                    <thead class="table-light">

                        <tr>

                            <th width="60">

                                #

                            </th>

                            <th>

                                Period

                            </th>

                            <th class="text-center">

                                Employee

                            </th>

                            <th class="text-center">

                                Avg Reward

                            </th>

                            <th class="text-center">

                                Last Analysis

                            </th>

                            <th width="180">

                                Action

                            </th>

                        </tr>

                    </thead>

                    <tbody>
                        @foreach($results as $item)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ optional($item->period)->name }}</td>
                            <td class="text-center">
                                <span class="badge bg-info">{{ $item->total_employee }}</span>
                            </td>
                            <td class="text-center">
                                <span class="badge bg-success">{{ number_format($item->average_reward, 2) }}</span>
                            </td>
                            <td class="text-center">{{ $item->created_at?->format('d M Y H:i') }}</td>
                            <td>
                                <a href="{{ route('mdp.show',$item->period_id) }}" class="btn btn-sm btn-primary">
                                    <i class="fas fa-eye"></i> Detail
                                </a>
                                <form action="{{ route('mdp.destroy', $item->period_id) }}" method="POST"
                                    class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-danger"
                                        onclick="return confirm('Delete this analysis?')">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>

            </div>

        </div>

    </div>

</div>

@endsection

@push('scripts')

<script>
    $(function(){

    $('.select2').select2({

        theme:'bootstrap-5',

        width:'100%',

        placeholder:'Select Period'

    });

    
    $('#historyTable').DataTable({
    pageLength: 10,
    responsive: true,
    ordering: true,
    language: {
    search: "Search :",
    // Menangani ketika data dari database benar-benar kosong
    emptyTable: "No analysis data available in this table.",
    // Menangani ketika hasil pencarian (search) tidak ditemukan
    zeroRecords: "No matching records found."
    }
    });

});

</script>

@endpush
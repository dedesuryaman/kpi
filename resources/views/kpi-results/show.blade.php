@extends('layouts.admin.app')

@section('title','Review KPI Result')

@push('styles')
<style>
    .avatar-lg {

        width: 64px;

        height: 64px;

        border-radius: 50%;

        background: #0d6efd;

        color: #fff;

        display: flex;

        align-items: center;

        justify-content: center;

        font-size: 24px;

        font-weight: 700;

    }
</style>
@endpush
@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">

    <div>

        <h3 class="fw-bold mb-1">

            KPI Result Review

        </h3>

        <small class="text-muted">

            Review supervisor assessment before approval.

        </small>

    </div>

    <a href="{{ route('kpi-results.index') }}" class="btn btn-light rounded-pill">

        <i class="fas fa-arrow-left me-2"></i>

        Back

    </a>

</div>

<div class="container-fluid">

    <div class="row">

        <div class="col-lg-8">

            <div class="card border-0 shadow-sm rounded-4 mb-3">

                <div class="card-body">

                    <div class="d-flex align-items-center">

                        <div class="avatar-lg">

                            {{ strtoupper(substr($result->employee->name,0,1)) }}

                        </div>

                        <div class="ms-3">

                            <h4 class="mb-1">
                                {{ $result->employee->name }}
                            </h4>

                            <div class="text-muted small">
                                <i class="bi bi-person-badge"></i>
                                {{ $result->employee->employee_code }}
                            </div>

                            <div class="text-muted">
                                {{ $result->employee->department->name ?? 'No Department' }}
                                <span class="mx-2">•</span>
                                {{ $result->employee->position->name ?? 'No Position' }}
                            </div>

                        </div>

                        <div class="ms-auto text-end">

                            <div class="text-muted">

                                Final Score

                            </div>

                            <h2 class="text-primary">

                                {{ number_format($result->final_score,2) }}

                            </h2>

                        </div>

                    </div>

                </div>

            </div>

            <div class="card border-0 shadow-sm rounded-4">

                <div class="card-header bg-white border-0 py-3">

                    <div class="d-flex justify-content-between align-items-center">

                        <div>
                            <h5 class="mb-0">
                                <i class="bi bi-bar-chart-line-fill text-primary me-2"></i>
                                Employee KPI
                            </h5>
                            <small class="text-muted">
                                Performance by KPI Category
                            </small>
                        </div>

                        <span class="badge bg-primary rounded-pill">
                            {{ $result->details->count() }} KPI
                        </span>

                    </div>

                </div>

                <div class="card-body pt-2">

                    @foreach($result->details as $detail)

                    <div class="mb-3">

                        <div class="d-flex justify-content-between align-items-center mb-1">

                            <span class="fw-semibold">
                                {{ $detail->kpiMaster->name }}
                            </span>

                            <span class="badge bg-light text-dark border">
                                {{ number_format($detail->score,1) }}
                            </span>

                        </div>

                        <div class="progress rounded-pill" style="height:8px;">

                            <div class="progress-bar
                                @if($detail->score >= 85)
                                    bg-success
                                @elseif($detail->score >= 70)
                                    bg-primary
                                @elseif($detail->score >= 50)
                                    bg-warning
                                @else
                                    bg-danger
                                @endif" style="width: {{ min($detail->score,100) }}%">
                            </div>

                        </div>

                    </div>

                    @endforeach

                </div>

            </div>


            <div class="card border-0 shadow rounded-4 mt-3 mb-3">

                <div class="card-header bg-white py-3 border-0">

                    <div class="d-flex justify-content-between align-items-center">

                        <div>
                            <h5 class="mb-0">
                                <i class="bi bi-stars text-primary"></i>
                                AI Performance Analysis
                            </h5>
                            <small class="text-muted">
                                Powered by Gemini AI
                            </small>
                        </div>

                        @if(!$result->aiAnalysis)

                        <div class="d-flex align-items-center gap-2">

                            <span class="badge bg-warning text-dark">
                                <i class="fas fa-clock me-1"></i>
                                No Analysis
                            </span>

                            <button class="btn btn-primary" id="btnGenerateAI" data-id="{{ $result->id }}">

                                <i class="fas fa-brain me-2"></i>
                                Generate AI Analysis

                            </button>

                        </div>

                        @else

                        <div class="d-flex align-items-center gap-2">

                            <span class="badge bg-success">
                                <i class="fas fa-circle-check me-1"></i>
                                Analysis Ready
                            </span>

                            <button class="btn btn-outline-primary" id="btnGenerateAI" data-id="{{ $result->id }}">

                                <i class="fas fa-rotate-right me-2"></i>
                                Regenerate AI Analysis

                            </button>

                        </div>

                        @endif
                    </div>

                </div>

                <div class="card-body">

                    @if($result->aiAnalysis)

                    <!-- Summary -->
                    <div class="alert alert-primary border-0 rounded-4 mb-3">

                        <div class="d-flex">

                            <i class="bi bi-robot fs-3 me-3"></i>

                            <div>
                                <strong>Executive Summary</strong>
                                <div class="small mt-1">
                                    {{ $result->aiAnalysis->summary }}
                                </div>
                            </div>

                        </div>

                    </div>

                    <div class="row g-3">

                        <div class="col-lg-6">

                            <div class="border rounded-4 p-3 h-100">

                                <div class="fw-semibold text-success mb-2">
                                    <i class="bi bi-check-circle-fill"></i>
                                    Strengths
                                </div>

                                <div class="small text-muted">
                                    {{ $result->aiAnalysis->strengths }}
                                </div>

                            </div>

                        </div>

                        <div class="col-lg-6">

                            <div class="border rounded-4 p-3 h-100">

                                <div class="fw-semibold text-danger mb-2">
                                    <i class="bi bi-x-circle-fill"></i>
                                    Weaknesses
                                </div>

                                <div class="small text-muted">
                                    {{ $result->aiAnalysis->weaknesses }}
                                </div>

                            </div>

                        </div>

                        <div class="col-12">

                            <div class="border rounded-4 p-3">

                                <div class="fw-semibold text-warning mb-2">
                                    <i class="bi bi-lightbulb-fill"></i>
                                    Recommendation
                                </div>

                                <div class="small text-muted">
                                    {{ $result->aiAnalysis->recommendation }}
                                </div>

                            </div>

                        </div>

                        <div class="col-lg-6">

                            <div class="bg-success bg-opacity-10 rounded-4 p-3">

                                <div class="fw-semibold text-success mb-2">
                                    <i class="bi bi-award-fill"></i>
                                    Reward
                                </div>

                                <div class="small">
                                    {{ $result->aiAnalysis->reward_recommendation }}
                                </div>

                            </div>

                        </div>

                        <div class="col-lg-6">

                            <div class="bg-danger bg-opacity-10 rounded-4 p-3">

                                <div class="fw-semibold text-danger mb-2">
                                    <i class="bi bi-shield-exclamation"></i>
                                    Punishment
                                </div>

                                <div class="small">
                                    {{ $result->aiAnalysis->punishment_recommendation }}
                                </div>

                            </div>

                        </div>

                    </div>

                    @else

                    <div class="text-center py-5">

                        <i class="bi bi-stars display-5 text-primary"></i>

                        <h6 class="mt-3">
                            AI Analysis Not Available
                        </h6>

                        <p class="text-muted small">
                            Click Generate to create an AI performance analysis.
                        </p>

                    </div>

                    @endif

                </div>

            </div>


        </div>

        <div class="col-lg-4">

            <div class="text-center mb-4">

                @if($result->approval_status=='Approved')

                <div class="alert alert-success rounded-4">

                    <i class="fas fa-check-circle"></i>

                    Approved

                </div>


                @elseif($result->approval_status=='Rejected')

                <div class="alert alert-danger rounded-4">

                    Rejected

                </div>

                @else

                <div class="alert alert-warning text-center rounded-4">

                    <i class="fas fa-clock me-2"></i>

                    Waiting Approval

                </div>


                @endif

            </div>


            <div class="card border-0 shadow-sm rounded-4">

                <div class="card-header bg-white border-0 py-3">

                    <div class="d-flex justify-content-between align-items-center">

                        <div>

                            <h5 class="fw-bold mb-1">
                                <i class="fas fa-user-check text-primary me-2"></i>
                                Manager Approval
                            </h5>

                            <small class="text-muted">
                                Review the KPI assessment before making a decision.
                            </small>

                        </div>



                    </div>

                </div>


                <div class="card-body">

                    <form id="approvalForm" method="POST">
                        @csrf

                        <div class="mb-4">

                            <label class="form-label fw-semibold">
                                Manager Notes
                            </label>

                            <textarea name="approval_notes" id="approval_notes" class="form-control" rows="5"
                                placeholder="Write your review, approval reason, or rejection reason...">{{ old('approval_notes') }}</textarea>

                            <small class="text-muted">
                                Notes will be saved as part of the approval history.
                            </small>

                        </div>

                        <div class="d-flex gap-2">

                            <button type="button" class="btn btn-success flex-fill" onclick="submitApproval('approve')">

                                <i class="fas fa-check-circle me-2"></i>

                                Approve

                            </button>

                            <button type="button" class="btn btn-outline-danger flex-fill"
                                onclick="submitApproval('reject')">

                                <i class="fas fa-times-circle me-2"></i>

                                Reject

                            </button>

                        </div>

                    </form>

                </div>

            </div>

        </div>

    </div>


</div>

@endsection

@push('scripts')

<script>
    function submitApproval(type){

    const form = document.getElementById('approvalForm');

    if(type === 'approve'){

        form.action = "{{ route('kpi-results.approve',$result) }}";

    }else{

        form.action = "{{ route('kpi-results.reject',$result) }}";

    }

    form.submit();

}

$('#btnGenerateAI').click(function () {

    let id = $(this).data('id');

    Swal.fire({
        title: 'Generate AI Analysis?',
        text: 'Gemini akan menganalisis hasil KPI ini.',
        icon: 'question',
        showCancelButton: true,
        confirmButtonText: 'Generate',
        cancelButtonText: 'Batal'
    }).then((result)=>{

        if(!result.isConfirmed)
            return;

        Swal.fire({
            title:'Generating...',
            html:'<br>Gemini sedang menganalisis KPI.<br><br>Mohon tunggu...',
            allowOutsideClick:false,
            allowEscapeKey:false,
            didOpen:()=>{
                Swal.showLoading();
            }
        });

        $.ajax({

            url:'/kpi/result/'+id+'/generate-ai',

            type:'POST',

            headers:{
                'X-CSRF-TOKEN':'{{ csrf_token() }}'
            },

            success:function(res){

                Swal.fire({
                    icon:'success',
                    title:'Berhasil',
                    text:'AI Analysis berhasil dibuat.',
                    timer:1500,
                    showConfirmButton:false
                });

                setTimeout(function(){
                    location.reload();
                },1500);

            },

            error:function(xhr){

                Swal.fire({
                    icon:'error',
                    title:'Gagal',
                    text:xhr.responseJSON?.message ?? 'Terjadi kesalahan.'
                });

            }

        });

    });

});

</script>

<script>
    function submitApproval(type) {

    const form = document.getElementById('approvalForm');
    const notes = document.getElementById('approval_notes').value.trim();

    let config = {};

    if (type === 'approve') {

        config = {
            title: 'Approve KPI Result?',
            text: 'This action will approve the KPI result.',
            icon: 'question',
            confirmButtonText: '<i class="fas fa-check"></i> Yes, Approve',
            confirmButtonColor: '#198754'
        };

        form.action = "{{ route('kpi-results.approve', $result) }}";

    } else {

        if (notes === '') {
            Swal.fire({
                icon: 'warning',
                title: 'Notes Required',
                text: 'Please enter the reason for rejecting this KPI result.'
            });
            return;
        }

        config = {
            title: 'Reject KPI Result?',
            text: 'This action will reject the KPI result.',
            icon: 'warning',
            confirmButtonText: '<i class="fas fa-times"></i> Yes, Reject',
            confirmButtonColor: '#dc3545'
        };

        form.action = "{{ route('kpi-results.reject', $result) }}";
    }

    Swal.fire({
        ...config,
        showCancelButton: true,
        cancelButtonText: 'Cancel',
        reverseButtons: true,
        allowOutsideClick: false,
        focusCancel: true
    }).then((result) => {

        if (result.isConfirmed) {
            form.submit();
        }

    });

}
</script>


@endpush
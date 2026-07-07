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

            <div class="card border-0 shadow-sm rounded-4">

                <div class="card-body">

                    <div class="d-flex align-items-center">

                        <div class="avatar-lg">

                            {{ strtoupper(substr($result->employee->name,0,1)) }}

                        </div>

                        <div class="ms-3">

                            <h4 class="mb-1">

                                {{ $result->employee->name }}

                            </h4>

                            <div class="text-muted">

                                {{ $result->employee->department->name }}

                                •

                                {{ $result->employee->position->name }}

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

            <div class="card">

                <div class="card-header">

                    Employee KPI

                </div>

                <div class="card-body">



                    <table class="table align-middle">

                        <thead class="table-light">

                            <tr>

                                <th>KPI</th>

                                <th width="120">

                                    Score

                                </th>

                                <th width="120">

                                    Performance

                                </th>

                            </tr>

                        </thead>

                        <tbody>

                            @foreach($result->details as $detail)

                            <tr>

                                <td>

                                    {{ $detail->kpiMaster->name }}

                                </td>

                                <td>

                                    <strong>

                                        {{ number_format($detail->score,1) }}

                                    </strong>

                                </td>

                                <td>

                                    <div class="progress" style="height:7px">

                                        <div class="progress-bar" style="width:{{ $detail->score }}%">

                                        </div>

                                    </div>

                                </td>

                            </tr>

                            @endforeach

                        </tbody>

                    </table>


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
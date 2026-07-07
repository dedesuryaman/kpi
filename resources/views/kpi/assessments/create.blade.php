@extends('layouts.admin.app')

@push('styles')
<style>
    .wizard-header {
        display: flex;
        align-items: center;
        justify-content: center;
        margin-top: 25px;
        margin-bottom: 10px;
    }

    .wizard-item {
        display: flex;
        flex-direction: column;
        align-items: center;
        min-width: 160px;
        position: relative;
        transition: .3s;
    }

    .wizard-circle {
        width: 52px;
        height: 52px;
        border-radius: 50%;
        border: 2px solid #d7dce3;
        background: #fff;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 18px;
        font-weight: 700;
        color: #6c757d;
        transition: .3s;
    }

    .wizard-title {
        margin-top: 10px;
        font-weight: 600;
        color: #6c757d;
        font-size: 15px;
    }

    .wizard-line {
        flex: 1;
        height: 3px;
        background: #dee2e6;
        margin: 0 15px;
        margin-bottom: 38px;
    }

    .wizard-item.active .wizard-circle {
        background: #0d6efd;
        color: #fff;
        border-color: #0d6efd;
    }

    .wizard-item.active .wizard-title {
        color: #0d6efd;
    }

    .wizard-item.completed .wizard-circle {
        background: #198754;
        border-color: #198754;
        color: #fff;
    }

    .wizard-item.completed .wizard-title {
        color: #198754;
    }

    .indicator-card {
        border-radius: 14px;
        transition: .25s;
    }

    .indicator-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 .5rem 1rem rgba(0, 0, 0, .12) !important;
    }

    .progress {
        border-radius: 50px;
    }

    .progress-bar {
        transition: .35s;
    }

    .check-icon {
        font-size: 18px;
    }
</style>
@endpush

@section('content')

<div class="container-fluid">

    <form id="assessmentForm" action="{{ route('kpi.assessments.store') }}" method="POST">

        @csrf

        <div class="card border-0 shadow-lg">

            <div class="card-header bg-white py-4">

                <div class="d-flex justify-content-between align-items-center">

                    <div>

                        <h4 class="fw-bold mb-1">

                            <i class="fas fa-clipboard-check text-primary me-2"></i>

                            New KPI Assessment

                        </h4>

                        <small class="text-muted">

                            Complete all steps to create an employee KPI assessment.

                        </small>

                    </div>

                    <span class="badge bg-primary fs-6 px-3 py-2">

                        Step
                        <span id="currentStepText">1</span>
                        /
                        3

                    </span>

                </div>

                <div class="progress mt-4" style="height:8px">

                    <div id="wizardProgress" class="progress-bar progress-bar-striped progress-bar-animated"
                        style="width:33%">

                    </div>

                </div>

                <div class="wizard-header">

                    <div class="wizard-item active" data-step="1">

                        <div class="wizard-circle">

                            <span class="step-number">1</span>

                            <i class="fas fa-check check-icon d-none"></i>

                        </div>

                        <div class="wizard-title">

                            Employee

                        </div>

                    </div>

                    <div class="wizard-line"></div>

                    <div class="wizard-item" data-step="2">

                        <div class="wizard-circle">

                            <span class="step-number">2</span>

                            <i class="fas fa-check check-icon d-none"></i>

                        </div>

                        <div class="wizard-title">

                            Assessment

                        </div>

                    </div>

                    <div class="wizard-line"></div>

                    <div class="wizard-item" data-step="3">

                        <div class="wizard-circle">

                            <span class="step-number">3</span>

                            <i class="fas fa-check check-icon d-none"></i>

                        </div>

                        <div class="wizard-title">

                            KPI Score

                        </div>

                    </div>

                </div>

            </div>

            <div class="card-body p-5">

                {{-- ================= STEP 1 ================= --}}

                <div class="wizard-step" id="step1">

                    <h5 class="fw-bold mb-4">

                        Employee Information

                    </h5>

                    <div class="row">

                        <div class="col-lg-6 mb-4">

                            <label class="form-label fw-semibold">

                                Employee

                            </label>

                            <select class="form-select select2" id="employee_id" name="employee_id">

                                <option value="">

                                    Select Employee

                                </option>

                                @foreach($employees as $employee)

                                <option value="{{ $employee->id }}" data-leader="{{ $employee->leader?->name }}"
                                    data-leader-id="{{ $employee->leader?->id }}">

                                    {{ $employee->employee_code }}

                                    -

                                    {{ $employee->name }}

                                </option>

                                @endforeach

                            </select>

                        </div>

                        <div class="col-lg-6 mb-4">

                            <label class="form-label fw-semibold">

                                Assessment Period

                            </label>

                            <input class="form-control form-control-md   bg-light" value="{{ $activePeriod->name }}"
                                readonly>

                            <input type="hidden" name="period_id" value="{{ $activePeriod->id }}">

                        </div>

                    </div>

                </div>

                {{-- ================= STEP 2 ================= --}}
                <div class="wizard-step d-none" id="step2">

                    <h5 class="fw-bold mb-4">
                        Assessment Detail
                    </h5>

                    <div class="row">

                        <div class="col-lg-6 mb-4">

                            <label class="form-label fw-semibold">
                                Assessment Date
                            </label>

                            <input type="date" class="form-control form-control-md" name="assessment_date"
                                value="{{ date('Y-m-d') }}">

                        </div>

                        <div class="col-lg-6 mb-4">

                            <label class="form-label fw-semibold">
                                Assessor
                            </label>

                            <input type="text" class="form-control form-control-md bg-light" id="assessor_name"
                                readonly>

                            <input type="hidden" id="assessor_id" name="assessor_id">

                        </div>

                    </div>

                </div>

                {{-- ================= STEP 3 ================= --}}

                <div class="wizard-step d-none" id="step3">

                    <h5 class="fw-bold mb-4">

                        KPI Indicators

                    </h5>

                    {{-- ================= SUMMARY EMPLOYEE & ASSESSMENT ================= --}}
                    <div class="card border-0 shadow-sm mb-4">
                        <div class="card-body p-4">

                            <div class="row g-4">

                                {{-- Employee --}}
                                <div class="col-lg-6">
                                    <label class="text-muted small">Employee</label>
                                    <div class="fw-bold" id="summaryEmployee">-</div>
                                </div>

                                {{-- Assessor --}}
                                <div class="col-lg-6">
                                    <label class="text-muted small">Assessor</label>
                                    <div class="fw-bold" id="summaryAssessor">-</div>
                                </div>

                                {{-- Period --}}
                                <div class="col-lg-6">
                                    <label class="text-muted small">Assessment Period</label>
                                    <div class="fw-bold">{{ $activePeriod->name }}</div>
                                </div>

                                {{-- Date --}}
                                <div class="col-lg-6">
                                    <label class="text-muted small">Assessment Date</label>
                                    <div class="fw-bold" id="summaryDate">-</div>
                                </div>

                            </div>

                        </div>
                    </div>


                    @foreach($indicators->groupBy('master.name') as $master => $items)

                    <div class="card border-0 shadow-sm mb-4">

                        <div class="card-header bg-primary bg-opacity-10 border-0 py-3">

                            <div class="d-flex justify-content-between align-items-center">

                                <div>

                                    <h5 class="fw-bold mb-0">

                                        <i class="fas fa-chart-line text-primary me-2"></i>

                                        {{ $master }}

                                    </h5>

                                    <small class="text-muted">

                                        {{ $items->count() }} KPI Indicators

                                    </small>

                                </div>

                                <span class="badge bg-primary rounded-pill">

                                    {{ $items->count() }}

                                </span>

                            </div>

                        </div>

                        <div class="card-body p-4">

                            @foreach($items as $indicator)

                            <div class="card border-0 shadow-sm mb-3 indicator-card">

                                <div class="card-body">

                                    <div class="row g-4 align-items-start">

                                        {{-- Indicator --}}
                                        <div class="col-lg-5">

                                            <div class="d-flex">

                                                <div class="me-3">

                                                    <span class="badge bg-primary rounded-circle p-3">

                                                        <i class="fas fa-bullseye"></i>

                                                    </span>

                                                </div>

                                                <div>

                                                    <h6 class="fw-bold mb-1">

                                                        {{ $indicator->name }}

                                                    </h6>

                                                    @if($indicator->description)

                                                    <p class="text-muted small mb-0">

                                                        {{ $indicator->description }}

                                                    </p>

                                                    @endif

                                                </div>

                                            </div>

                                        </div>

                                        {{-- Achievement --}}
                                        <div class="col-lg-3">

                                            <label class="form-label fw-semibold">

                                                Achievement (%)

                                            </label>

                                            <div class="input-group">

                                                <input type="number" class="form-control score-input text-end"
                                                    name="scores[{{ $indicator->id }}][score]" min="0" max="100"
                                                    step="0.01" placeholder="0.00" required>

                                                <span class="input-group-text">

                                                    %

                                                </span>

                                            </div>

                                            <div class="progress mt-2" style="height:6px;">

                                                <div class="progress-bar score-progress" style="width:0%"></div>

                                            </div>

                                        </div>

                                        {{-- Notes --}}
                                        <div class="col-lg-4">

                                            <label class="form-label fw-semibold">

                                                Assessment Notes

                                            </label>

                                            <textarea class="form-control" rows="3"
                                                name="scores[{{ $indicator->id }}][notes]"
                                                placeholder="Write assessment notes..."></textarea>

                                        </div>

                                    </div>

                                </div>

                            </div>

                            @endforeach

                        </div>

                    </div>

                    @endforeach

                </div>

            </div>

            <div class="card-footer bg-white">

                <div class="d-flex justify-content-between">

                    <button type="button" class="btn btn-outline-secondary d-none" id="prevBtn">

                        Previous

                    </button>

                    <button type="button" class="btn btn-primary" id="nextBtn">

                        Next

                    </button>

                    <button type="submit" class="btn btn-success d-none" id="submitBtn">

                        <i class="fas fa-save me-2"></i>

                        Save Assessment

                    </button>

                </div>

            </div>

        </div>

    </form>

</div>

@endsection

@push('scripts')

<script>
    $(function () {
                
       
        $('.select2').select2({
            theme: 'bootstrap-5',
            
        width: '100%',
        placeholder: 'Please select',
        allowClear: true
        });


                
    });
</script>

@endpush
@push('scripts')
<script>
    $(function () {

        function updateSummary() {
                            
                            let selected = $('#employee_id').find(':selected');
                            
                            let employeeText = selected.text() || '-';
                            
                            let assessorText = $('#assessor_name').val() || '-';
                            
                            let date = $('[name=assessment_date]').val() || '-';
                            
                            $('#summaryEmployee').text(employeeText);
                            $('#summaryAssessor').text(assessorText);
                            $('#summaryDate').text(date);
                            }
    // =====================================
    // SCORE PROGRESS
    // =====================================

    $(document).on('input', '.score-input', function () {

        let value = parseFloat($(this).val()) || 0;

        value = Math.max(0, Math.min(100, value));

        $(this).val(value);

        let bar = $(this)
            .closest('.col-lg-3')
            .find('.score-progress');

        bar.css('width', value + '%');

        bar.removeClass('bg-danger bg-warning bg-success');

        if (value < 60) {

            bar.addClass('bg-danger');

        } else if (value < 85) {

            bar.addClass('bg-warning');

        } else {

            bar.addClass('bg-success');

        }

    });

    // =====================================
    // WIZARD
    // =====================================

    let currentStep = 1;
    const totalSteps = 3;

    function updateWizard() {

        // -----------------------------
        // Show Current Step
        // -----------------------------

        $('.wizard-step').addClass('d-none');

        $('#step' + currentStep).removeClass('d-none');

        // -----------------------------
        // Step Text
        // -----------------------------

        $('#currentStepText').text(currentStep);

        // -----------------------------
        // Progress
        // -----------------------------

        let progress = (currentStep / totalSteps) * 100;

        $('#wizardProgress').css('width', progress + '%');

        // -----------------------------
        // Header Step
        // -----------------------------

        $('.wizard-item')
            .removeClass('active completed');

        $('.step-number').removeClass('d-none');

        $('.check-icon').addClass('d-none');

        $('.wizard-item').each(function () {

            let step = parseInt($(this).data('step'));

            if (step < currentStep) {

                $(this).addClass('completed');

                $(this)
                    .find('.step-number')
                    .addClass('d-none');

                $(this)
                    .find('.check-icon')
                    .removeClass('d-none');

            }

            else if (step === currentStep) {

                $(this).addClass('active');

            }

        });

        // -----------------------------
        // Previous Button
        // -----------------------------

        if (currentStep === 1) {

            $('#prevBtn').addClass('d-none');

        } else {

            $('#prevBtn').removeClass('d-none');

        }

        // -----------------------------
        // Next / Submit
        // -----------------------------

        if (currentStep === totalSteps) {

            $('#nextBtn').addClass('d-none');

            $('#submitBtn').removeClass('d-none');

        } else {

            $('#nextBtn').removeClass('d-none');

            $('#submitBtn').addClass('d-none');

        }

        


    }

    // =====================================
    // NEXT
    // =====================================

    $('#nextBtn').click(function () {

        if (currentStep === 1) {

            if ($('#employee_id').val() == '') {

                Swal.fire({
                    icon: 'warning',
                    title: 'Employee Required',
                    text: 'Please select employee first.'
                });

                return;

            }

        }

        if (currentStep === 2) {

            if ($('[name=assessment_date]').val() == '') {

                Swal.fire({
                    icon: 'warning',
                    title: 'Assessment Date',
                    text: 'Please choose assessment date.'
                });

                return;

            }

        }


        if (currentStep < totalSteps) {

            currentStep++;

            updateWizard();

            $('html, body').animate({
                scrollTop: 0
            }, 250);

        }

        updateSummary();

    });

    // =====================================
    // PREVIOUS
    // =====================================

    $('#prevBtn').click(function () {

        if (currentStep > 1) {

            currentStep--;

            updateWizard();

            $('html, body').animate({
                scrollTop: 0
            }, 250);

        }

    });

    // =====================================
    // Employee Change
    // =====================================

    $('#employee_id').change(function () {

        let selected = $(this).find(':selected');

        $('#assessor_name').val(selected.data('leader') || '');

        $('#assessor_id').val(selected.data('leader-id') || '');

    });

    // =====================================
    // Submit
    // =====================================

    $('#assessmentForm').on('submit', function () {

        $('#submitBtn')
            .prop('disabled', true)
            .html('<i class="fas fa-spinner fa-spin me-2"></i>Saving Assessment...');

    });

    // =====================================
    // INIT
    // =====================================

    updateWizard();

});
</script>
@endpush
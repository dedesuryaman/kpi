<div class="modal fade" id="crudModal">

    <div class="modal-dialog modal-lg">

        <div class="modal-content">

            <form id="crudForm">

                <input type="hidden" id="id">

                <div class="modal-header">
                    <h5 class="modal-title">
                        KPI Evaluation
                    </h5>
                </div>

                <div class="modal-body">

                    <div class="row">

                        <div class="col-md-6 mb-3">

                            <label>Employee</label>

                            <select id="employee_id" class="form-select">

                                @foreach($employees as $employee)
                                <option value="{{ $employee->id }}">
                                    {{ $employee->name }}
                                </option>
                                @endforeach

                            </select>

                        </div>

                        <div class="col-md-6 mb-3">

                            <label>KPI Indicator</label>

                            <select id="kpi_indicator_id" class="form-select">

                                @foreach($indicators as $indicator)
                                <option value="{{ $indicator->id }}">
                                    {{ $indicator->name }}
                                </option>
                                @endforeach

                            </select>

                        </div>

                        <div class="col-md-4 mb-3">
                            <label>Weight (%)</label>
                            <input type="number" class="form-control" id="weight">
                        </div>

                        <div class="col-md-4 mb-3">
                            <label>Target</label>
                            <input type="number" class="form-control" id="target_value">
                        </div>

                        <div class="col-md-4 mb-3">
                            <label>Actual</label>
                            <input type="number" class="form-control" id="actual_value">
                        </div>

                        <div class="col-md-4 mb-3">
                            <label>Score</label>
                            <input type="number" class="form-control" id="score">
                        </div>

                        <div class="col-md-8 mb-3">
                            <label>Remarks</label>
                            <textarea id="remarks" class="form-control" rows="3"></textarea>
                        </div>

                    </div>

                </div>

                <div class="modal-footer">

                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">

                        Cancel

                    </button>

                    <button type="submit" class="btn btn-primary">

                        Save

                    </button>

                </div>

            </form>

        </div>

    </div>

</div>
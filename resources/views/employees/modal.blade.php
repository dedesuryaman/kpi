<div class="modal fade" id="employeeModal">
    <div class="modal-dialog">
        <div class="modal-content">

            <div class="modal-header">
                <h5>Employee Form</h5>
            </div>

            <div class="modal-body">

                <input type="hidden" id="employee_id">

                <input class="form-control mb-2" id="employee_code" placeholder="Code">
                <input class="form-control mb-2" id="name" placeholder="Full Name">
                <input class="form-control mb-2" id="salary" placeholder="Salary">

                <select class="form-control mb-2" id="employment_status">
                    <option value="permanent">Permanent</option>
                    <option value="contract">Contract</option>
                    <option value="probation">Probation</option>
                    <option value="intern">Intern</option>
                    <option value="resigned">Resigned</option>
                </select>

            </div>

            <div class="modal-footer">
                <button class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button class="btn btn-primary" id="saveBtn">Save</button>
            </div>

        </div>
    </div>
</div>
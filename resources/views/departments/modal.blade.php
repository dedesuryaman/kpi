<div class="modal fade" id="crudModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content shadow">

            <div class="modal-header">
                <h5 class="modal-title">Department Form</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">

                <input type="hidden" id="department_id">

                <!-- Department Name -->
                <div class="mb-3">
                    <label for="name" class="form-label">Department Name</label>
                    <input type="text" class="form-control" id="name" placeholder="Enter department name">
                </div>

                <!-- Division -->
                <div class="mb-3">
                    <label for="division_id" class="form-label">Division</label>
                    <select class="form-select" id="division_id">
                        <option value="">-- Select Division --</option>

                        @foreach($divisions as $division)
                        <option value="{{ $division->id }}">
                            {{ $division->name }}
                        </option>
                        @endforeach

                    </select>
                </div>

            </div>

            <div class="modal-footer">
                <button class="btn btn-outline-secondary" data-bs-dismiss="modal">
                    Close
                </button>
                <button class="btn btn-primary" id="saveBtn">
                    Save Department
                </button>
            </div>

        </div>
    </div>
</div>
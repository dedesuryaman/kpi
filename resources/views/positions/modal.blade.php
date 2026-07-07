<div class="modal fade" id="crudModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title">Position Form</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">

                <input type="hidden" id="position_id">

                <div class="mb-3">
                    <label for="name" class="form-label fw-semibold">
                        Position Name
                    </label>
                    <input type="text" class="form-control" id="name" placeholder="Enter position name">
                </div>

                <div class="mb-3">
                    <label for="description" class="form-label fw-semibold">
                        Description
                    </label>
                    <textarea class="form-control" id="description" rows="4"
                        placeholder="Enter position description"></textarea>
                </div>

            </div>

            <div class="modal-footer">
                <button class="btn btn-light border" data-bs-dismiss="modal">
                    Close
                </button>
                <button class="btn btn-primary" id="saveBtn">
                    Save
                </button>
            </div>

        </div>
    </div>
</div>
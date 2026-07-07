@extends('layouts.admin.app')

@push('styles')

<style>
    .employee-card {
        background: #fff;
        border-radius: 12px;
        box-shadow: 0 6px 18px rgba(0, 0, 0, 0.08);
        padding: 16px;
        border: 1px solid #eef0f3;
    }

    /* HEADER */
    .employee-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 12px;
    }

    .employee-header h4 {
        margin: 0;
        font-weight: 600;
        font-size: 18px;
        color: #111827;
    }

    .meta {
        font-size: 12px;
        color: #6b7280;
        margin-top: 3px;
    }

    /* SEARCH */
    .employee-search {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 12px;
        gap: 10px;
    }

    /* TABLE */
    .employee-table {
        width: 100%;
        border-collapse: collapse;
        font-size: 13px;
    }

    .employee-table thead {
        background: #f9fafb;
    }

    .employee-table th {
        text-align: left;
        padding: 8px 10px;
        font-weight: 600;
        color: #374151;
        border-bottom: 1px solid #e5e7eb;
    }

    .employee-table td {
        padding: 6px 10px;
        /* 🔥 lebih rapat */
        border-bottom: 1px solid #f1f5f9;
    }

    .employee-table tr:hover {
        background: #f9fafb;
    }

    /* STATUS */
    .badge {
        padding: 3px 8px;
        font-size: 11px;
        border-radius: 999px;
        font-weight: 500;
    }

    .badge.permanent {
        background: #dcfce7;
        color: #166534;
    }

    .badge.contract {
        background: #dbeafe;
        color: #1e40af;
    }

    .badge.probation {
        background: #fef3c7;
        color: #92400e;
    }

    .badge.intern {
        background: #ede9fe;
        color: #5b21b6;
    }

    .badge.resigned {
        background: #fee2e2;
        color: #991b1b;
    }

    /* FOOTER */
    .employee-footer {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-top: 12px;
        font-size: 12px;
        color: #6b7280;
    }

    /* PAGINATION */
    .pagination {
        display: flex;
        gap: 5px;
    }

    .pagination button {
        border: 1px solid #e5e7eb;

        padding: 4px 12px;
        border-radius: 6px;
        font-size: 12px;
        cursor: pointer;
    }

    .pagination button.active {
        background: #3b82f6;
        color: #c9a019;
        border-color: #3b82f6;
    }

    .pagination button:hover {
        border-color: #7c7d80;
        background: #eaecee;
        color: rgb(80, 77, 77);

    }

    /**/
    .btn-icon {
        width: 28px;
        height: 28px;
        border-radius: 6px;
        border: 1px solid transparent;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        margin-left: 4px;
        cursor: pointer;
        transition: all 0.2s ease;
        font-size: 12px;
    }

    /* EDIT */
    .btn-edit {
        background: #fff7ed;
        color: #f59e0b;
        border-color: #fed7aa;
    }

    .btn-edit:hover {
        background: #f59e0b;
        color: #fff;
    }

    /* DELETE */
    .btn-delete {
        background: #fef2f2;
        color: #ef4444;
        border-color: #fecaca;
    }

    .btn-delete:hover {
        background: #ef4444;
        color: #fff;
    }

    /* ICON SIZE */
    .btn-icon i {
        font-size: 12px;
    }

    .employee-card {
        position: relative;
        min-height: 300px;
        /* agar ada area untuk overlay */
    }

    .loading-overlay {
        position: absolute;
        inset: 0;

        display: none;
        align-items: center;
        justify-content: center;

        background: rgba(255, 255, 255, .75);
        backdrop-filter: blur(2px);

        z-index: 9999;
        border-radius: 12px;
    }

    .loading-spinner {
        width: 50px;
        height: 50px;
        border: 4px solid #e5e7eb;
        border-top-color: #0d6efd;
        border-radius: 50%;
        animation: spin .8s linear infinite;
    }

    @keyframes spin {
        to {
            transform: rotate(360deg);
        }
    }
</style>
@endpush

@section('content')

<div class="employee-card position-relative">

    <div id="loadingOverlay" class="loading-overlay">
        <div class="loading-spinner"></div>
    </div>


    <!-- HEADER -->
    <div class="employee-header">

        <div>
            <h4>Departmen Management</h4>
            <div class="meta">
                Total: <b id="totalCount">0</b> •
                Page: <b id="pageInfo">1 / 1</b>
            </div>
        </div>

        <button class="btn btn-primary" id="btnAdd">+ Add Department</button>

    </div>


    <div class="row g-3 align-items-end mb-4">

        <div class="col-md-6">
            <label for="search" class="form-label fw-semibold">
                Search Department
            </label>

            <div class="input-group">
                <span class="input-group-text">
                    <i class="fas fa-search"></i>
                </span>

                <input type="text" class="form-control" id="search" placeholder="Search department...">
            </div>
        </div>

        <div class="col-md-6">
            <label for="search_division_id" class="form-label fw-semibold">
                Division
            </label>

            <select class="form-select select2-department" name="search_division_id" id="search_division_id">
                <option value="">All Divisions</option>

                @foreach($divisions as $div)
                <option value="{{ $div->id }}">
                    {{ $div->name }}
                </option>
                @endforeach
            </select>
        </div>

    </div>

    <!-- TABLE -->
    <div class="table-responsive">
        <table class="employee-table">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Department</th>
                    <th>Division</th>
                    <th class="text-end">Action</th>
                </tr>
            </thead>

            <tbody id="dataTable"></tbody>
        </table>
    </div>

    <!-- FOOTER -->
    <div class="employee-footer">

        <div id="statusInfo">Showing 0 data</div>

        <div id="pagination" class="pagination"></div>

    </div>

</div>


@include('departments.modal')

@endsection


@push('scripts')

<script>
    let modal = new bootstrap.Modal(document.getElementById('crudModal'));

let currentPage = 1;

function showLoading() {
$('#loadingOverlay').css('display', 'flex');
}

function hideLoading() {
$('#loadingOverlay').hide();
}


$(document).ready(function() {



$('.select2-element').select2({
placeholder: "Select Department",
allowClear: true,
width: '100'
});


});

/* =========================
   LOAD DATA
========================= */

function loadData(page = 1, search = '', div = '') {

showLoading();

$.get("{{ route('departments.data') }}", {
page: page,
search: search,
division_id: div,
}, function(res) {

let rows = '';

res.data.forEach(dep => {
rows += `
<tr>
    <td>${dep.name}</td>
    <td>${dep.name}</td>
    <td>${dep.division_name ?? '-'}</td>
    <td class="text-end">

        <button class="btn-icon btn-edit editBtn" data-id="${dep.id}" title="Edit">
            <i class="fas fa-pen"></i>
        </button>

        <button class="btn-icon btn-delete deleteBtn" data-id="${dep.id}" title="Delete">
            <i class="fas fa-trash"></i>
        </button>

    </td>
</tr>
`;
});

$('#dataTable').html(rows);

$('#totalCount').text(res.total);
$('#pageInfo').text(`${res.current_page} / ${res.last_page}`);

$('#statusInfo').text(
`Showing ${res.data.length} of ${res.total} employees`
);

renderPagination(res.last_page, res.current_page);

}).fail(function(xhr) {

toastr.error('Failed load data');

}).always(function() {

hideLoading();

});
}

function loadDatax(page = 1, search = '', div = '') {
    
    $.get("{{ route('departments.data') }}", {
        page: page,
        search: search,
        division_id: div,
    }, function (res) {

        let rows = '';

        res.data.forEach(dep => {

            rows += `
            <tr>
                <td>${dep.name}</td>
                <td>${dep.name}</td>
                <td>${dep.division_name}</td>
               <td class="text-end">
            
                <button class="btn-icon btn-edit editBtn" data-id="${dep.id}" title="Edit">
                    <i class="fas fa-pen"></i>
                </button>
            
                <button class="btn-icon btn-delete deleteBtn" data-id="${dep.id}" title="Delete">
                    <i class="fas fa-trash"></i>
                </button>
            
            </td>
            </tr>
            `;
        });

        $('#dataTable').html(rows);

        // META INFO UPDATE
        $('#totalCount').text(res.total);
        $('#pageInfo').text(`${res.current_page} / ${res.last_page}`);

        let showingFrom = (res.current_page - 1) * res.per_page || 0;
        $('#statusInfo').text(
            `Showing ${res.data.length} of ${res.total} employees`
        );

        renderPagination(res.last_page, res.current_page);
    });
}
/* =========================
   PAGINATION
========================= */
function renderPagination(lastPage, current) {

    let html = '';

    for (let i = 1; i <= lastPage; i++) {
        html += `
            <button class="btn btn-sm ${i == current ? 'btn-primary' : 'btn-light'} pageBtn"
                data-page="${i}">
                ${i}
            </button>
        `;
    }

    $('#pagination').html(html);
}


/* =========================
   FIRST LOAD
========================= */
loadData();


/* =========================
   SEARCH (DEBOUNCE SIMPLE)
========================= */
let searchTimeout = null;

$('#search').on('keyup', function () {

    clearTimeout(searchTimeout);

    let value = $(this).val();
    let dept = $('#search_division_id').val();

    searchTimeout = setTimeout(() => {
        loadData(1, value ,dept);
    }, 300);
});


// filter select2 department
$('#search_division_id').on('change', function () {
let dept = $(this).val();
loadData(1,$('#search').val(),dept);
});

/* =========================
   PAGINATION CLICK
========================= */
$(document).on('click', '.pageBtn', function () {
    loadData($(this).data('page'),  $('#search').val() , $('#search_division_id').val());
});


/* =========================
   OPEN CREATE
========================= */
$('#btnAdd').click(function () {

    $('#department_id').val('');
    $('#name').val('');
    $('#division_id').val('');

    modal.show();
});


/* =========================
   SAVE (CREATE + UPDATE)
   + SWEETALERT CONFIRM
========================= */
$('#saveBtn').click(function () {

    let id = $('#department_id').val();

    Swal.fire({
        title: id ? "Update department?" : "Create department?",
        text: "Please confirm action",
        icon: "question",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Yes, proceed"
    }).then((result) => {

        if (!result.isConfirmed) return;

        let url = id ? `/departments/${id}` : '/departments';
        let method = id ? 'PUT' : 'POST';

        $.ajax({
            url: url,
            method: method,
            data: {
                _token: "{{ csrf_token() }}",
                name: $('#name').val(),
                division_id: $('#division_id').val(),
            },
            success: function () {

                modal.hide();
                loadData(currentPage, $('#search').val()), $('#search_division_id').val();

                toastr.success(id ? 'Updated successfully' : 'Created successfully');
            },
            error: function (xhr) {
                toastr.error(xhr.responseJSON?.message || 'Error');
            }
        });

    });
});




/* =========================
   EDIT
========================= */
$(document).on('click', '.editBtn', function () {

    let id = $(this).data('id');

    $.get(`/departments/${id}/edit`, function (data) {

        $('#department_id').val(data.id);
        $('#name').val(data.name);
        $('#division_id').val(data.division_id);

        modal.show();
    });
});


/* =========================
   DELETE (SWEETALERT)
========================= */
$(document).on('click', '.deleteBtn', function () {

    let id = $(this).data('id');

    Swal.fire({
        title: "Delete department?",
        text: "Data cannot be recovered",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#d33",
        confirmButtonText: "Yes delete"
    }).then((result) => {

        if (!result.isConfirmed) return;

        $.ajax({
            url: `/departments/${id}`,
            method: 'DELETE',
            data: {
                _token: "{{ csrf_token() }}"
            },
            success: function () {

                loadData(currentPage, $('#search').val(), $('#search_division_id').val());
                toastr.success('Deleted successfully');
            }
        });
    });
});

</script>

@endpush
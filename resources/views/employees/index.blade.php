@extends('layouts.admin.app')

@push('styles')
<style>
    .employee-card {
        background: #fff;
        border-radius: 12px;
        box-shadow: 0 6px 18px rgba(0, 0, 0, 0.08);
        padding: 20px;
        border: 1px solid #eef0f3;
    }

    /* HEADER */
    .employee-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 20px;
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
        margin-top: 4px;
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
        padding: 12px 10px;
        font-weight: 600;
        color: #374151;
        border-bottom: 1px solid #e5e7eb;
    }

    .employee-table td {
        padding: 10px 10px;
        border-bottom: 1px solid #f1f5f9;
        vertical-align: middle;
    }

    .employee-table tr:hover {
        background: #f9fafb;
    }

    /* STATUS BADGE */
    .badge {
        padding: 4px 8px;
        font-size: 11px;
        border-radius: 999px;
        font-weight: 500;
        text-transform: capitalize;
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

    /* FOOTER & PAGINATION */
    .employee-footer {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-top: 16px;
        font-size: 12px;
        color: #6b7280;
    }

    .pagination {
        display: flex;
        gap: 5px;
    }

    /* ACTION BUTTONS */
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
    }

    .btn-edit {
        background: #fff7ed;
        color: #f59e0b;
        border-color: #fed7aa;
    }

    .btn-edit:hover {
        background: #f59e0b;
        color: #fff;
    }

    .btn-delete {
        background: #fef2f2;
        color: #ef4444;
        border-color: #fecaca;
    }

    .btn-delete:hover {
        background: #ef4444;
        color: #fff;
    }

    .btn-icon i {
        font-size: 12px;
    }
</style>
@endpush

@section('content')
<div class="employee-card">

    <div class="employee-header">
        <div>
            <h4>Employee Management</h4>
            <div class="meta">
                Total: <b id="totalCount">0</b> •
                Page: <b id="pageInfo">1 / 1</b>
            </div>
        </div>
        <a href="{{ route('employees.create') }}" class="btn btn-primary btn-sm" id="btnAdd">
            <i class="fas fa-plus me-1"></i> Add Employee
        </a>
    </div>

    <div class="row g-3 align-items-center mb-4">
        <div class="col-md-6">
            <label for="search" class="form-label fw-semibold text-secondary small">Search Employee</label>
            <div class="input-group input-group-sm">
                <span class="input-group-text bg-white"><i class="fas fa-search text-muted"></i></span>
                <input type="text" class="form-control" id="search" placeholder="Type name, code, or keyword...">
            </div>
        </div>

        <div class="col-md-6">
            <label for="department_id" class="form-label fw-semibold text-secondary small">Filter Department</label>
            <select class="form-select select2-department" name="department_id" id="department_id">
                <option value="">All Department</option>
                @foreach($departments as $dept)
                <option value="{{ $dept->id }}">{{ $dept->name }}</option>
                @endforeach
            </select>
        </div>
    </div>

    <div class="table-responsive">
        <table class="employee-table">
            <thead>
                <tr>
                    <th>Code</th>
                    <th>Name</th>
                    <th>Department</th>
                    <th>Division</th>
                    <th>Salary</th>
                    <th>Status</th>
                    <th class="text-end">Action</th>
                </tr>
            </thead>
            <tbody id="employeeTable">
                <tr>
                    <td colspan="7" class="text-center py-4 text-muted">Loading data...</td>
                </tr>
            </tbody>
        </table>
    </div>

    <div class="employee-footer">
        <div id="statusInfo">Showing 0 data</div>
        <div id="pagination" class="pagination"></div>
    </div>

</div>
@endsection

@push('scripts')
<script>
    let currentPage = 1;
    const employeeEditUrl = "{{ url('employees') }}";

    $(document).ready(function() {
        // Fix: Mengubah selector target select2 agar sesuai dengan class elemen di HTML
        $('.select2-department').select2({
            placeholder: "All Department",
            allowClear: true,
            width: '100%'
        });

        // Load data pertama kali saat page ready
        loadData();
    });

    /* =========================
       LOAD DATA
    ========================= */
    function loadData(page = 1, search = '', dept = '') {
        currentPage = page; // Update current page state

        $.get("{{ route('employees.data') }}", {
            page: page,
            search: search,
            department_id: dept,
        }, function (res) {
            let rows = '';

            if(res.data.length === 0) {
                rows = `<tr><td colspan="7" class="text-center py-4 text-muted">No data found</td></tr>`;
            } else {
                res.data.forEach(emp => {
                    // Opsional: Format mata uang untuk Salary (contoh Rupiah sederhana)
                    let formattedSalary = new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', maximumFractionDigits: 0 }).format(emp.salary);

                    rows += `
                    <tr>
                        <td><strong>${emp.employee_code}</strong></td>
                        <td>${emp.name}</td>
                        <td>${emp.department_name ?? '-'}</td>
                        <td>${emp.division_name ?? '-'}</td>
                        <td>${formattedSalary}</td>
                        <td>
                            <span class="badge ${emp.employment_status}">
                                ${emp.employment_status}
                            </span>
                        </td>
                        <td class="text-end">
                            <a href="${employeeEditUrl}/${emp.id}/edit" class="btn-icon btn-edit" title="Edit">
                                <i class="fas fa-pen"></i>
                            </a>
                            <button class="btn-icon btn-delete deleteBtn" data-id="${emp.id}" title="Delete">
                                <i class="fas fa-trash"></i>
                            </button>
                        </td>
                    </tr>
                    `;
                });
            }

            $('#employeeTable').html(rows);

            // META INFO UPDATE
            $('#totalCount').text(res.total);
            $('#pageInfo').text(`${res.current_page} / ${res.last_page}`);
            $('#statusInfo').text(`Showing ${res.data.length} of ${res.total} employees`);

            renderPagination(res.last_page, res.current_page);
        }).fail(function() {
            $('#employeeTable').html(`<tr><td colspan="7" class="text-center py-4 text-danger">Failed to fetch data.</td></tr>`);
        });
    }

    /* =========================
       PAGINATION
    ========================= */
    function renderPagination(lastPage, current) {
        let html = '';
        
        // Paginasi dinamis sederhana menggunakan class bawaan Bootstrap untuk standarisasi tombol
        for (let i = 1; i <= lastPage; i++) {
            html += `
                <button class="btn btn-sm ${i == current ? 'btn-primary' : 'btn-outline-secondary'} pageBtn"
                    data-page="${i}">
                    ${i}
                </button>
            `;
        }
        $('#pagination').html(html);
    }

    /* =========================
       FILTER & SEARCH EVENTS
    ========================= */
    let searchTimeout = null;

    $('#search').on('keyup', function () {
        clearTimeout(searchTimeout);
        let value = $(this).val();
        let dept = $('#department_id').val();

        searchTimeout = setTimeout(() => {
            loadData(1, value, dept);
        }, 400); // 400ms debounce aman untuk server
    });

    // Event select2 penyesuaian jika menggunakan plugin Select2
    $('#department_id').on('change', function () {
        let dept = $(this).val();
        loadData(1, $('#search').val(), dept);
    });

    $(document).on('click', '.pageBtn', function () {
        let targetPage = $(this).data('page');
        loadData(targetPage, $('#search').val(), $('#department_id').val());
    });

    /* =========================
       DELETE ACTION (SWEETALERT)
    ========================= */
    $(document).on('click', '.deleteBtn', function () {
        let id = $(this).data('id');

        Swal.fire({
            title: "Are you sure?",
            text: "This employee data will be permanently deleted!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#ef4444",
            cancelButtonColor: "#6b7280",
            confirmButtonText: "Yes, delete it!"
        }).then((result) => {
            if (!result.isConfirmed) return;

            $.ajax({
                url: `/employees/${id}`,
                method: 'DELETE',
                data: {
                    _token: "{{ csrf_token() }}"
                },
                success: function () {
                    // Memuat ulang halaman aktif saat ini
                    loadData(currentPage, $('#search').val(), $('#department_id').val());
                    toastr.success('Employee deleted successfully');
                },
                error: function() {
                    toastr.error('Something went wrong. Could not delete data.');
                }
            });
        });
    });
</script>
@endpush
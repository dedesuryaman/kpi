<div class="table-responsive">

    <table class="table table-bordered table-hover align-middle" id="reportTable">

        <thead class="table-light">
            <tr class="text-center">
                <th width="70">No</th>


                <th>Employee Code</th>
                <th>Employee Name</th>
                <th>Department</th>
                <th>Position</th>
                <th width="120">Average Score</th>
                <th width="120">Final Score</th>
                <th width="70">Rank</th>
                <th width="100">Grade</th>
                <th width="140">Period</th>
            </tr>
        </thead>

        <tbody>

            @php
            $totalFinalScore = 0;
            @endphp

            @forelse($results as $result)

            @php
            $totalFinalScore += $result->final_score;
            @endphp

            <tr>



                <td class="text-center">
                    {{ $loop->iteration }}
                </td>

                <td>
                    {{ $result->employee->employee_code }}
                </td>

                <td>
                    {{ $result->employee->name }}
                </td>

                <td>
                    {{ $result->employee->department?->name ?? '-' }}
                </td>

                <td>
                    {{ $result->employee->position?->name ?? '-'}}
                </td>

                <td class="text-end">
                    {{ number_format($result->average_score, 2) }}
                </td>

                <td class="text-end fw-bold">
                    {{ number_format($result->final_score, 2) }}
                </td>
                <td class="text-center fw-bold">
                    {{ $result->rank }}
                </td>
                <td class="text-center">

                    @switch($result->grade)

                    @case('A')
                    <span class="badge bg-success">A</span>
                    @break

                    @case('B')
                    <span class="badge bg-primary">B</span>
                    @break

                    @case('C')
                    <span class="badge bg-warning text-dark">C</span>
                    @break

                    @default
                    <span class="badge bg-danger">D</span>

                    @endswitch

                </td>
                <td>
                    {{ $result->period?->name }}
                </td>
            </tr>

            @empty

            <tr>

                <td colspan="9" class="text-center text-muted py-4">

                    No employee performance data found.

                </td>

            </tr>

            @endforelse

        </tbody>

        @if($results->count())

        <tfoot class="table-light">

            <tr>

                <th colspan="6" class="text-end">

                    Average Final Score

                </th>

                <th class="text-end">

                    {{ number_format($totalFinalScore / $results->count(), 2) }}

                </th>

                <th colspan="3"></th>

            </tr>

        </tfoot>

        @endif

    </table>

</div>

<script>
    $(function () {

    if ($.fn.DataTable.isDataTable('#reportTable')) {
        $('#reportTable').DataTable().destroy();
    }

    $('#reportTable').DataTable({

        responsive: true,

        pageLength: 25,

        autoWidth: false,

        order: [[0, 'asc']],

        language: {

            search: "Search:",

            lengthMenu: "Show _MENU_ rows",

            zeroRecords: "No matching records found",

            info: "Showing _START_ to _END_ of _TOTAL_ entries",

            infoEmpty: "No data available",

            paginate: {

                previous: "Previous",

                next: "Next"

            }

        }

    });

});

</script>
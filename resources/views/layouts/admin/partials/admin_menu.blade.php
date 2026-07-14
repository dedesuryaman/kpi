<ul class="sidebar-menu">

    <!-- MASTER DATA -->
    <li class="menu-title">
        MASTER DATA
    </li>

    <li>
        <a href="{{ route('divisions.index') }}">
            <i class="fas fa-building"></i>
            <span>Divisions</span>
        </a>
    </li>

    <li>
        <a href="{{ route('departments.index') }}">
            <i class="fas fa-diagram-project"></i>
            <span>Departments</span>
        </a>
    </li>

    <li>
        <a href="{{ route('positions.index') }}">
            <i class="fas fa-user-tie"></i>
            <span>Positions</span>
        </a>
    </li>

    <li>
        <a href="{{ route('employees.index') }}">
            <i class="fas fa-users"></i>
            <span>Employees</span>
        </a>
    </li>

    <!-- KPI MANAGEMENT -->
    <li class="menu-title">
        KPI MANAGEMENT
    </li>

    <li>
        <a href="{{ route('kpi.period.index') }}">
            <i class="fas fa-calendar-days"></i>
            <span>Periods</span>
        </a>
    </li>

    <li>
        <a href="{{ route('kpi.master.index') }}">
            <i class="fas fa-bullseye"></i>
            <span>KPI Master</span>
        </a>
    </li>

    <li>
        <a href="{{ route('kpi.indicator.index') }}">
            <i class="fas fa-list-check"></i>
            <span>KPI Indicators</span>
        </a>
    </li>

    <li>
        <a href="{{ route('kpi.assessments.index') }}">
            <i class="fas fa-clipboard-check"></i>
            <span>KPI Assessments</span>
        </a>
    </li>

    <li>
        <a href="{{ route('kpi-results.index') }}">
            <i class="fas fa-square-poll-horizontal"></i>
            <span>KPI Results</span>
        </a>
    </li>

    <!-- OPTIMIZATION -->
    <li class="menu-title">
        OPTIMIZATION
    </li>

    <li>
        <a href="{{ route('abc.index')}}">
            <i class="fas fa-cubes-stacked"></i>
            <span>ABC Optimization</span>
        </a>
    </li>

    <li>
        <a href="{{ route('mdp.index') }}">
            <i class="fas fa-route"></i>
            <span>MDP Analysis</span>
        </a>
    </li>

    <li>
        <a href="{{ route('reward-punishment.index') }}">
            <i class="fas fa-medal"></i>
            <span>Reward &amp; Punishment</span>
        </a>
    </li>

    <!-- REPORTS -->
    <li class="menu-title">
        REPORTS
    </li>

    <li>
        <a href="{{ route('reports.employee-performance.index') }}">
            <i class="fas fa-chart-line"></i>
            <span>Employee Performance</span>
        </a>
    </li>

    <li>
        <a href="{{ route('division-performance.index') }}">
            <i class="fas fa-chart-pie"></i>
            <span>Division Performance</span>
        </a>
    </li>

    <li>
        <a href="{{ route('reports.index')}}">
            <i class="fas fa-file-export"></i>
            <span>Export Excel / PDF</span>
        </a>
    </li>


    <!-- SYSTEM SETTINGS -->
    <li class="menu-title">
        SYSTEM SETTINGS
    </li>

    <li>
        <a href="#">
            <i class="fas fa-clipboard-list"></i>
            <span>Audit Log</span>
        </a>
    </li>

    <li>
        <a href="#">
            <i class="fas fa-gears"></i>
            <span>General Settings</span>
        </a>
    </li>

    <li>
        <a href="#">
            <i class="fas fa-database"></i>
            <span>Backup</span>
        </a>
    </li>

</ul>
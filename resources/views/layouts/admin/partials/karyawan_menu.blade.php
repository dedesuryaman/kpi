<ul class="sidebar-menu">

    <!-- DASHBOARD -->
    <li>
        <a href="{{ route('dashboard') }}">
            <i class="fas fa-gauge-high"></i>
            <span>Dashboard</span>
        </a>
    </li>

    <!-- MY PERFORMANCE -->
    <li class="menu-title">
        MY PERFORMANCE
    </li>

    <li>
        <a href="{{ route('my-assessment.index') }}">
            <i class="fas fa-clipboard-check"></i>
            <span>My Assessments</span>
        </a>
    </li>

    <li>
        <a href="{{ route('my-result.index') }}">
            <i class="fas fa-square-poll-horizontal"></i>
            <span>KPI Results</span>
        </a>
    </li>

    <li>
        <a href="{{ route('performance-history.index') }}">
            <i class="fas fa-chart-line"></i>
            <span>Performance History</span>
        </a>
    </li>

    <!-- ACCOUNT -->
    <li class="menu-title">
        ACCOUNT
    </li>

    <li>
        <a href="{{ route('my-profile.index') }}">
            <i class="fas fa-id-card"></i>
            <span>My Profile</span>
        </a>
    </li>

</ul>
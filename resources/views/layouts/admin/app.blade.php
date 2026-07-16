<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="{{ asset('favicon.ico') }}" type="image/x-icon">
    <title>{{ config('app.name') }}</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.1/css/all.min.css" rel="stylesheet">

    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />


    <!-- Bootstrap 5 Theme -->
    <link href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css"
        rel="stylesheet">

    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.8/css/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.bootstrap5.min.css">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">

    <style>
        :root {
            --sidebar-width: 260px;
            --sidebar-collapsed: 80px;

            --sidebar-bg: #0f172a;
            --sidebar-hover: #1e293b;
            --primary: #2563eb;
            --content-bg: #f8fafc;

            --radius: 18px;
            --transition: .3s ease;
        }

        body {
            background: var(--content-bg);
            overflow-x: hidden;
        }

        /* ================= SIDEBAR ================= */
        .sidebar {
            position: fixed;
            inset: 0 auto 0 0;
            width: var(--sidebar-width);
            height: 100vh;
            background: var(--sidebar-bg);
            z-index: 1000;

            display: flex;
            flex-direction: column;

            overflow: hidden;
            scrollbar-width: thin;
            scrollbar-color: #334155 transparent;

            transition: width var(--transition);
        }

        /* HEADER */
        .sidebar-header {
            flex-shrink: 0;
        }

        .logo {
            height: 70px;
            display: flex;
            align-items: center;
            padding: 20px;
            color: #fff;
            border-bottom: 1px solid rgba(255, 255, 255, .08);
        }

        .logo-icon {
            width: 40px;
            height: 40px;
            /*border-radius: 12px;
            background: linear-gradient(135deg, #2563eb, #06b6d4);
            */
            display: flex;
            align-items: center;
            justify-content: center;
        }



        .logo-title {
            display: flex;
            flex-direction: column;
            line-height: 1;
            margin-left: 10px;
        }

        .logo-main {
            font-size: 17px;
            font-weight: 800;
            letter-spacing: 1px;
            color: #ffffff;
            margin-bottom: 2px;
            /* ini yang bikin rapat tapi masih enak dibaca */
        }

        .logo-sub {
            font-size: 6px;
            font-weight: 500;
            letter-spacing: 2px;
            text-transform: uppercase;
            color: rgba(255, 255, 255, 0.6);
        }

        /* BODY MENU */
        .sidebar-body {
            flex: 1;
            overflow: hidden;
        }

        .sidebar:hover .sidebar-body {
            overflow-y: auto;
        }

        .sidebar-menu {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .sidebar-menu li a {
            display: flex;
            align-items: center;
            gap: 10px;
            color: #cbd5e1;
            text-decoration: none;
            padding: 4px 20px;
            transition: var(--transition);
        }

        .sidebar-menu li a:hover {
            background: var(--sidebar-hover);
            color: #fff;
        }

        .sidebar-menu li a.active {
            background: var(--primary);
            color: #fff;
        }

        .sidebar-menu i {
            width: 25px;
        }

        /* TITLE */
        .menu-title {
            color: #94a3b8;
            font-size: 12px;
            text-transform: uppercase;
            padding: 20px 20px 10px;
        }

        .menu-title {
            font-size: 11px;
            font-weight: 700;
            letter-spacing: 2px;
            text-transform: uppercase;

            color: rgba(255, 255, 255, 0.35);

            /* efek terukir (inset/engraved) */
            text-shadow:
                0 1px 0 rgba(0, 0, 0, 0.9),
                0 -1px 0 rgba(255, 255, 255, 0.05);
        }


        /* ================= MAIN ================= */
        .main {
            margin-left: var(--sidebar-width);
            transition: margin var(--transition);
        }

        /* TOPBAR */
        .topbar {
            background: #fff;
            height: 70px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, .05);
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 25px;
        }

        /* CONTENT */
        .content {
            padding: 25px;
        }

        /* ================= CARDS ================= */
        .dashboard-card {
            background: #fff;
            border-radius: var(--radius);
            padding: 20px;
            box-shadow: 0 5px 20px rgba(0, 0, 0, .05);
        }

        .stat-card {
            border-radius: var(--radius);
            color: #fff;
            padding: 25px;
        }

        .stat-number {
            font-size: 32px;
            font-weight: 700;
        }

        /* COLORS */
        .bg-blue {
            background: linear-gradient(135deg, #2563eb, #3b82f6);
        }

        .bg-green {
            background: linear-gradient(135deg, #059669, #10b981);
        }

        .bg-orange {
            background: linear-gradient(135deg, #ea580c, #f97316);
        }

        .bg-purple {
            background: linear-gradient(135deg, #7c3aed, #9333ea);
        }

        /* AVATAR */
        .avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: var(--primary);
            color: #fff;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 600;
        }

        /* ================= COLLAPSE ================= */
        body.sidebar-collapsed .sidebar {
            width: var(--sidebar-collapsed);
        }

        body.sidebar-collapsed .main {
            margin-left: var(--sidebar-collapsed);
        }

        body.sidebar-collapsed .logo-title,
        body.sidebar-collapsed .menu-title,
        body.sidebar-collapsed .sidebar-menu span {
            display: none;
        }

        body.sidebar-collapsed .sidebar-menu a {
            justify-content: center;
            padding: 18px;
        }

        /* ================= MOBILE ================= */
        @media (max-width: 991px) {
            .sidebar {
                left: -260px;
            }

            .sidebar.show {
                left: 0;
            }

            .main {
                margin-left: 0 !important;
            }

            /* overlay default aktif di mobile */
            .sidebar-overlay {
                display: block;
            }

            .sidebar-overlay.show {
                display: block;
            }
        }

        @media (min-width: 992px) {

            .sidebar {
                left: 0;
            }

            .main {
                margin-left: 260px;
            }

            /* 🔥 ini kunci: paksa overlay mati di desktop */
            .sidebar-overlay {
                display: none !important;
            }
        }

        /* ================= OVERLAY ================= */
        .sidebar-overlay {
            position: fixed;
            inset: 0;
            background: rgba(0, 0, 0, .5);
            z-index: 999;
            display: none;
        }

        .sidebar-overlay.show {
            display: block;
        }

        /* ================= SCROLLBAR ================= */
        .sidebar::-webkit-scrollbar {
            width: 3px;
        }

        .sidebar::-webkit-scrollbar-thumb {
            background: #334155;
            border-radius: 10px;
        }

        .sidebar::-webkit-scrollbar-thumb:hover {
            background: #475569;
        }

        .sidebar-body::-webkit-scrollbar {
            width: 3px;
        }

        .sidebar-body::-webkit-scrollbar-thumb {
            background: rgba(255, 255, 255, .15);
        }

        /*=============================*/

        .user-dropdown .user-toggle {
            background: rgba(255, 255, 255, 0.04);
            border: 1px solid rgba(255, 255, 255, 0.08);
            backdrop-filter: blur(10px);
            transition: all 0.2s ease;
        }

        .user-dropdown .user-toggle:hover {
            background: rgba(255, 255, 255, 0.08);
            transform: translateY(-1px);
        }

        .user-avatar {
            width: 38px;
            height: 38px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 600;
            background: linear-gradient(135deg, #2563eb, #1e40af);
            color: #fff;
            box-shadow: 0 6px 18px rgba(37, 99, 235, 0.25);
        }



        .user-name {
            font-size: 14px;
            font-weight: 600;
            letter-spacing: 1.5px;
            line-height: 1.5px;
            margin-top: 10px;
            color: rgba(255, 255, 255, 0.35);

            /* efek engraved / inset */
            text-shadow:
                0 1px 0 rgba(0, 0, 0, 0.9),
                0 -1px 0 rgba(255, 255, 255, 0.05);
        }

        .user-role {
            font-size: 10px;
            letter-spacing: 1.5px;

            color: rgba(255, 255, 255, 0.25);

            text-shadow:
                0 1px 0 rgba(0, 0, 0, 0.85),
                0 -1px 0 rgba(255, 255, 255, 0.04);
        }


        .user-menu {
            border-radius: 12px;
            overflow: hidden;
        }

        .user-menu .dropdown-item {
            padding: 10px 14px;
            font-size: 13px;
            transition: all 0.15s ease;
        }

        .user-menu .dropdown-item:hover {
            background: #f3f6ff;
        }
    </style>

    @stack('styles')

</head>

<body>
    <div class="sidebar-overlay" id="sidebarOverlay"></div>
    <!-- Sidebar -->
    <div class="sidebar">

        <!-- FIXED HEADER -->
        <div class="sidebar-header">

            <div class="logo">

                <div class="logo-icon">
                    <img src="{{ asset('assets/images/Logomk-white.png')}}" alt="" width="50">
                </div>

                <div class="logo-title">
                    <div class="logo-main">PT. MAKERINDO</div>
                    <small class="logo-sub">Build Solution With Exception</small>
                </div>

            </div>

        </div>
        <!-- SCROLLABLE MENU -->
        <div class="sidebar-body">

            <ul class="sidebar-menu">
                @if (auth()->user()->hasRole('super-admin'))
                @include('layouts.admin.partials.admin_menu')
                @endif

                @if (auth()->user()->hasRole('director'))
                @include('layouts.admin.partials.direktur_menu')
                @endif

                @if (auth()->user()->hasRole('manager'))
                @include('layouts.admin.partials.manager_menu')
                @endif

                @if (auth()->user()->hasRole('supervisor'))
                @include('layouts.admin.partials.supervisor_menu')
                @endif

                @if (auth()->user()->hasRole('hrd'))
                @include('layouts.admin.partials.hrd_menu')
                @endif

                @if (auth()->user()->hasRole('employee'))
                @include('layouts.admin.partials.karyawan_menu')
                @endif

        </div>
    </div>

    <!-- Main -->
    <div class="main">

        <!-- Topbar -->
        <div class="topbar">

            <div class="d-flex align-items-center">

                <button class="btn btn-light me-3" id="sidebarToggle">

                    <i class="fas fa-bars"></i>

                </button>

                <!--h5 class="mb-0">
                    Dashboard
                </h5-->

            </div>

            <div class="dropdown user-dropdown">

                <a class="user-toggle d-flex align-items-center text-decoration-none px-3 py-2 rounded-3" href="#"
                    data-bs-toggle="dropdown">

                    <div class="user-avatar me-2">
                        <span>{{ strtoupper(substr(auth()->user()->name, 0, 1)) }}</span>
                    </div>

                    <div class="user-info text-start">
                        <div class="user-name">
                            {{ auth()->user()->name }}
                        </div>
                        <small class="user-role text-muted">
                            {{ auth()->user()->email }}
                        </small>
                    </div>

                    <i class="fas fa-chevron-down ms-2 opacity-50"></i>

                </a>

                <ul class="dropdown-menu dropdown-menu-end user-menu shadow-lg border-0 mt-2">

                    <li>
                        <a class="dropdown-item d-flex align-items-center gap-2" href="{{ route('profile.index') }}">
                            <i class="fas fa-user-circle"></i>
                            Profile
                        </a>
                    </li>

                    <li>
                        <hr class="dropdown-divider">
                    </li>

                    <li>
                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button class="dropdown-item text-danger d-flex align-items-center gap-2">
                                <i class="fas fa-sign-out-alt"></i>
                                Logout
                            </button>
                        </form>
                    </li>

                </ul>
            </div>

        </div>

        <!-- Content -->
        <div class="content">

            @yield('content')

        </div>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.8/js/jquery.dataTables.min.js"></script>

    <script src="https://cdn.datatables.net/1.13.8/js/dataTables.bootstrap5.min.js"></script>

    <script src="https://cdn.datatables.net/responsive/2.5.0/js/dataTables.responsive.min.js"></script>

    <script src="https://cdn.datatables.net/responsive/2.5.0/js/responsive.bootstrap5.min.js"></script>
</body>

<script>
    const sidebar =
    document.querySelector('.sidebar');

const toggleBtn =
    document.getElementById('sidebarToggle');

const overlay =
    document.getElementById('sidebarOverlay');

toggleBtn.addEventListener('click', function() {

    if(window.innerWidth <= 991){

        sidebar.classList.toggle('show');
        overlay.classList.toggle('show');
        
    }else{

      
        document.body.classList.toggle('sidebar-collapsed');

        localStorage.setItem(
            'sidebar-collapsed',
            document.body.classList.contains('sidebar-collapsed')
        );

        
    }

});

overlay.addEventListener('click', function(){

    sidebar.classList.remove('show');
    overlay.classList.remove('show');

});

if(localStorage.getItem('sidebar-collapsed') === 'true'){

    document.body.classList.add('sidebar-collapsed');
    

}

</script>

@if(session('success'))

<script>
    Swal.fire({

    icon:'success',

    title:'Success',

    text:'{{ session('success') }}',

    timer:2000,

    showConfirmButton:false

});

</script>

@endif

@stack('scripts')

</html>
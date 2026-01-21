<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin SPK Sampah | @yield('title')</title>
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css"> <!-- font-awesome, yang meyebabkan cssnya tdk tampil-->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/css/adminlte.min.css"> <!-- admin-lte, yang meyebabkan cssnya tdk tampil -->
    @stack('styles')

</head>

<body class="hold-transition sidebar-mini">
    <div class="wrapper">
        <nav class="main-header navbar navbar-expand navbar-white navbar-light">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" data-widget="pushmenu" href="#"
                        role="button"><i class="fas fa-bars"></i></a>
                </li>
                <li class="nav-item d-none d-sm-inline-block">
                    <span class="nav-link fw-bold text-dark">SISTEM MONITORING SAMPAH (VIKOR)</span>
                </li>
            </ul>
        </nav>
        <aside class="main-sidebar sidebar-dark-success elevation-4">
            <a href="#" class="brand-link">
                <span class="brand-text font-weight-light ms-3">ADMIN PANEL</span>
            </a>
            <div class="sidebar">
                <nav class="mt-3">
                    <ul class="nav nav-pills nav-sidebar flex-column" datawidget="treeview" role="menu">
                        <li class="nav-item">
                            <a href="{{ route('admin.dashboard') }}" class="nav-link {{ request()->is('admin/dashboard') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-tachometer-alt"></i>
                                <p>Dashboard</p>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="{{ route('admin.peta') }}" class="nav-link {{ request()->is('admin/peta-laporan') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-map-marked-alt"></i>
                                <p>Peta Sebaran</p>
                            </a>
                        </li>

                        <li class="nav-header">ANALISIS SPK</li>
                        <li class="nav-item">
                            <a href="{{ route('admin.vikor') }}" class="nav-link {{ request()->is('admin/perhitungan-vikor') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-calculator"></i>
                                <p>Metode VIKOR</p>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="{{ route('admin.wp') }}" class="nav-link {{ request()->is('admin/perhitungan-wp') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-balance-scale"></i>
                                <p>Metode WP</p>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="{{ route('admin.perbandingan') }}" class="nav-link {{ request()->is('admin/perbandingan-metode') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-balance-scale"></i>
                                <p>Perbandingan Metode</p>
                            </a>
                        </li>

                    </ul>
                </nav>
            </div>
        </aside>
        <div class="content-wrapper">
            <section class="content-header">
                <div class="container-fluid">
                    <h1>@yield('title')</h1>
                </div>
            </section>
            <section class="content">
                <div class="container-fluid">
                    @yield('content')
                </div>
            </section>
        </div>
        <footer class="main-footer text-sm">
            <strong>Copyright &copy; 2026 <a href="#">Dinas Lingkungan Hidup</a>.</strong>
        </footer>
    </div>
    <script
        src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script
        src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/js/adminlte.min.js"></script>
    @stack('scripts')
</body>

</html>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') Monitoring Sampah</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <link href="https://fonts.googleapis.com/css?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #f8f9fa;
        }

        .navbar {
            /* shadow-sm dihapus dari sini */
            background-color: #ffffff;
            box-shadow: 0 .125rem .25rem rgba(0, 0, 0, .075) !important;
            /* Opsional: Jika ingin manual pakai CSS */
        }

        .footer {
            background: #343a40;
            color: white;
            padding: 40px 0;
            margin-top: 50px;
        }
    </style>
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-light sticky-top shadow-sm">
        <div class="container">
            <a class="navbar-brand fw-bold text-success" href="/">
                <i class="fas fa-recycle me-2"></i>LaporSampah!
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto align-items-center">
                    @if(session('login_masyarakat'))
                    <li class="nav-item"><a class="nav-link" href="{{ route('lapor.history') }}">Dashboard</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('lapor.index') }}">Buat Laporan</a></li>
                    <li class="nav-item ms-lg-3">
                        <form action="{{ route('logout') }}" method="POST" class="d-inline">
                            @csrf
                            <button type="submit" class="btn btn-outline-danger px-x">Keluar</button>
                        </form>
                    </li>

                    @else
                    {{-- Tombol Login & Daftar Sebelumnya --}}
                    @endif

                    <!-- <li class="nav-item"><a class="nav-link" href="{{ url('/') }}">Beranda</a></li>
                <li class="nav-item"><a class="nav-link" href="#panduan">Panduan</a></li>
                    <li class="nav-item ms-lg-3">
                        <a class="nav-link btn btn-outline-success px-4 me-2"
                            href="{{ route('login') }}">Masuk</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link btn btn-success text-white px-4 shadow-sm" href="{{ route('masyarakat.index') }}">Daftar</a>
                    </li> -->
                </ul>
            </div>
        </div>
    </nav>
    <div class="py-5">
        @yield('content')
    </div>
    <footer class="footer">
        <div class="container text-center">
            <p class="mb-0">&copy; 2026 Sistem Monitoring Sampah Liar. All Rights
                Reserved.</p>
            <small class="text-muted">Dikelola oleh Dinas Kebersihan Kota</small>
        </div>
    </footer>
    <script
        src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
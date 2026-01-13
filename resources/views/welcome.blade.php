@extends('layouts.public')
@section('title', 'Selamat Datang')
@section('content')
<div class="container mb-5">
    <div class="row align-items-center">
        <div class="col-lg-6">
            <h1 class="display-4 fw-bold text-dark">Wujudkan Kota Bersih <br><span
                    class="text-success">Mulai dari Laporan Anda</span></h1>
            <p class="lead text-muted">Laporkan tumpukan sampah liar di sekitar Anda secara
                cepat menggunakan sistem berbasis koordinat GPS.</p>
            <div class="d-grid gap-2 d-md-flex justify-content-md-start">
                <a href="{{ route('masyarakat.index') }}" class="btn btn-success btn-lg px-4 me-md-2 fw-bold shadow">
                    <i class="fas fa-user-plus me-2"></i>Daftar Sekarang
                </a>
                <a href="{{ route('login') }}" class="btn btn-outline-success btn-lg px-4 fw-bold">
                    <i class="fas fa-sign-in-alt me-2"></i>Sudah Punya Akun?
                </a>
            </div>
        </div>
        <div class="col-lg-6 d-none d-lg-block">
            <img src="https://img.freepik.com/free-vector/environmental-protection-conceptillustration_114360-1029.jpg" class="img-fluid" alt="Ilustrasi Kebersihan">
        </div>
    </div>
</div>
<div id="panduan" class="bg-white py-5 shadow-sm">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="fw-bold">Cara Melaporkan Sampah</h2>
            <p class="text-muted">Ikuti 4 langkah mudah berikut ini</p>
        </div>
        <div class="row g-4">
            <div class="col-md-3">
                <div class="card h-100 border-0 text-center p-3">
                    <div class="rounded-circle bg-success text-white mx-auto d-flex align-items-center justify-content-center mb-3" style="width: 60px; height: 60px;">
                        <i class="fas fa-user-plus fa-lg"></i>
                    </div>
                    <h5 class="fw-bold">1. Registrasi</h5>
                    <p class="text-sm text-muted">Daftarkan diri Anda menggunakan NIK yang
                        valid untuk mulai menggunakan sistem.</p>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card h-100 border-0 text-center p-3">
                    <div class="rounded-circle bg-success text-white mx-auto d-flex align-items-center justify-content-center mb-3" style="width: 60px; height: 60px;">
                        <i class="fas fa-camera fa-lg"></i>
                    </div>
                    <h5 class="fw-bold">2. Foto & Lokasi</h5>
                    <p class="text-sm text-muted">Ambil foto tumpukan sampah di lokasi.
                        Pastikan GPS HP Anda aktif.</p>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card h-100 border-0 text-center p-3">
                    <div class="rounded-circle bg-success text-white mx-auto d-flex align-items-center justify-content-center mb-3" style="width: 60px; height: 60px;">
                        <i class="fas fa-edit fa-lg"></i>
                    </div>
                    <h5 class="fw-bold">3. Isi Kriteria</h5>
                    <p class="text-sm text-muted">Pilih kriteria sampah (bau, volume, jenis)
                        untuk membantu tim teknis kami.</p>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card h-100 border-0 text-center p-3">
                    <div class="rounded-circle bg-success text-white mx-auto d-flex align-items-center justify-content-center mb-3" style="width: 60px; height: 60px;">
                        <i class="fas fa-check-double fa-lg"></i>
                    </div>
                    <h5 class="fw-bold">4. Selesai</h5>
                    <p class="text-sm text-muted">Laporan masuk ke sistem SPK admin untuk
                        segera diprioritaskan pengangkutannya.</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

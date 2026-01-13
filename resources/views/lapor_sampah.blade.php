@extends('layouts.public')
@section('title', 'Buat Laporan Sampah')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card border-0 shadow-lg">
                <div class="card-header bg-success text-white p-3">
                    <h5 class="mb-0 fw-bold"><i class="fas fa-bullhorn me-2"></i>
                        Form Pelaporan Sampah Liar</h5>
                </div>
                <div class="card-body p-4">
                    <form action="" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="alert alert-info border-0 mb-4">
                            <strong>Identitas Pelapor:</strong> {{ session('user_nama') }} (NIK: {{ session('user_nik') }})
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Foto
                                    Bukti</label>
                                <input type="file" name="foto" class="formcontrol" accept="image/*" capture="environment" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Lokasi GPS</label>
                                <input type="text" name="koordinat"
                                    id="koordinat" class="form-control bg-light" readonly required>
                                <small id="status-gps" class="text-muted">Mencariposisi...</small>
                            </div>
                        </div>
                        <hr>
                        <h6 class="fw-bold mb-3 text-success"><i class="fas falist-check me-2"></i>KRITERIA PENILAIAN (SPK)</h6>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">C1 - Estimasi Volume</label>
                                <select name="c1" class="form-select" required>
                                    <option value="1">1 (Sangat Sedikit / < 1 Karung)</option>
                                    <option value="2">2 (Sedikit / 2-3 Karung)</option>
                                    <option value="3">3 (Sedang / 1 Gerobak)</option>
                                    <option value="4">4 (Banyak / 1 Pick Up)</option>
                                    <option value="5">5 (Sangat Banyak / > 1 Truk)</option>
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">C2 - Tingkat Kebauan</label>
                                <select name="c2" class="form-select" required>
                                    <option value="1">1 (Tidak Berbau)</option>
                                    <option value="2">2 (Bau Ringan)</option>
                                    <option value="3">3 (Bau Mengganggu)</option>
                                    <option value="4">4 (Sangat Bau/Menyengat)</option>
                                    <option value="5">5 (Sangat Busuk/Radius Jauh)</option>
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">C3 - Karakteristik
                                    Jenis</label>
                                <select name="c3" class="form-select" required>
                                    <option value="1">1 (Anorganik - Plastik/Kertas)</option>
                                    <option value="2">2 (Organik - Sisa Makanan)</option>
                                    <option value="3">3 (Campuran Organik & Anorganik)</option>
                                    <option value="4">4 (Sampah Bangunan/Puing)</option>
                                    <option value="5">5 (B3 / Limbah Medis / Bangkai)</option>
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">C4 - Kedekatan
                                    Fasilitas Umum</label>
                                <select name="c4" class="form-select" required>
                                    <option value="1">1 (Jauh dari Pemukiman)</option>
                                    <option value="2">2 (Pinggir Jalan Sepi)</option>
                                    <option value="3">3 (Dekat Area Perkantoran)</option>
                                    <option value="4">4 (Dekat Pemukiman Warga)</option>
                                    <option value="5">5 (Dekat Pasar/Sekolah/RS)</option>
                                </select>
                            </div>
                        </div>
                        <div class="mb-4">
                            <label class="form-label">C5 - Durasi Tumpukan (Lama
                                Sampah Dibiarkan)</label>
                            <select name="c5" class="form-select" required>
                                <option value="1">1 (Baru Hari Ini)</option>
                                <option value="2">2 (Sudah 2-3 Hari)</option>
                                <option value="3">3 (Sudah 1 Minggu)</option>
                                <option value="4">4 (Sudah Lebih dari 2
                                    Minggu)</option>
                                <option value="5">5 (Sudah Sangat Lama /
                                    Menetap)</option>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-success btn-lg w-100 fw-bold shadow">
                            <i class="fas fa-paper-plane me-2"></i>KIRIM LAPORAN</button>

                        @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm mb-4" role="alert">
                            <div class="d-flex align-items-center">
                                <i class="fas fa-check-circle fa-2x me-3"></i>
                                <div>
                                    <h5 class="alert-heading mb-1 fw bold">Berhasil!</h5>
                                    <p class="mb-0">{{ session('success') }}</p>
                                </div>
                            </div>
                            <button type="button" class="btn-close" data-bs
                                dismiss="alert" aria-label="Close"></button>
                        </div>
                        @endif

                        @if(session('error'))
                        <div class="alert alert-danger alert-dismissible fade show border-0 shadow-sm mb-4" role="alert">
                            <i class="fas fa-exclamation-triangle me-2"></i> {{ session('error') }}
                            <button type="button" class="btn-close" data-bs
                                dismiss="alert" aria-label="Close"></button>
                        </div>
                        @endif

                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function getLocation() {
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition((position) => {
                document.getElementById('koordinat').value =
                    position.coords.latitude + ", " + position.coords.longitude;
                document.getElementById('status-gps').innerHTML = "<span class = 'text-success'> Lokasi Terdeteksi </span>";
            });
        }
    }
    window.onload = getLocation;
</script>
@stop
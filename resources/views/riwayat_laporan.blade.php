@extends('layouts.public')
@section('title', 'Dashboard Pelapor')
@section('content')
<div class="container">
    <div class="row mb-4">
        <div class="col-md-12">
            <div class="card bg-success text-white border-0 shadow-sm">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-itemscenter">
                        <div>
                            <h4 class="fw-bold mb-1">Halo, {{ session('user_nama') }}!</h4>
                            <p class="mb-0">Selamat datang di dashboard pelaporan sampah liar.</p>
                        </div>
                        <div class="text-end">
                            <h2 class="fw-bold mb-0">{{ $riwayat->count() }}</h2>
                            <small>Total Laporan Anda</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="card border-0 shadow-lg">
        <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
            <h5 class="mb-0 fw-bold text-dark">Riwayat Laporan Anda</h5>
            <a href="{{ route('lapor.index') }}" class="btn btn-success btn-sm fw-bold">
                <i class="fas fa-plus me-1"></i> Buat Laporan Baru
            </a>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>Tanggal</th>
                            <th>Foto</th>
                            <th>Kriteria (C1-C5)</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($riwayat as $item)
                        <tr>
                            <td>{{ $item->created_at->format('d M Y H:i') }}</td>
                            <td>
                                <a href="{{ asset('storage/sampah/' . $item->foto) }}" target="_blank">
                                    <img src="{{ asset('storage/sampah/' . $item->foto) }}"
                                        class="rounded shadow-sm" style="width: 80px; height: 60px; object-fit: cover;">
                                </a>
                            </td>
                            <td>
                                <span class="badge bg-secondary">V:{{ $item->c1 }}</span> <span class="badge bg-secondary">B:{{ $item->c2 }}</span>
                                <span class="badge bg-secondary">J:{{ $item->c3 }}</span>
                                <span class="badge bg-secondary">L:{{ $item->c4 }}</span>
                                <span class="badge bg-secondary">W:{{ $item->c5 }}</span>
                            </td>
                            <td>
                                @if($item->status == 'pending')
                                <span class="badge rounded-pill bg-warning text-dark">Menunggu</span>
                                @elseif($item->status == 'proses')
                                <span class="badge rounded-pill bgprimary">Diproses</span>
                                @else
                                <span class="badge rounded-pill bgsuccess">Selesai</span>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="text-center py-5 text-muted">
                                <i class="fas fa-folder-open fa-3x mb-3 dblock"></i>
                                Belum ada laporan yang Anda buat.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@stop
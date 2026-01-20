@extends('layouts.admin')

@section('title', 'Analisis SPK Metode VIKOR')

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card card-success card-outline">
            <div class="card-header">
                <h3 class="card-title fw-bold">
                    <i class="fas fa-chart-line me-2"></i> Perankingan Prioritas Penanganan Sampah
                </h3>
            </div>
            <div class="card-body">
                <p class="text-muted">
                    Metode VIKOR menentukan solusi kompromi berdasarkan jarak
                    terdekat dengan nilai ideal.
                    <strong>Semakin kecil nilai Q, semakin tinggi prioritas
                        laporan tersebut.</strong>
                </p>

                <div class="table-responsive">
                    <table class="table table-bordered table-hover">
                        <thead class="bg-light">
                            <tr class="text-center">
                                <th width="50">Rank</th>
                                <th>Foto</th>
                                <th>NIK Pelapor</th>
                                <th>Nilai S (Utility)</th>
                                <th>Nilai R (Regret)</th>
                                <th>Indeks Q (Final)</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($hasil_vikor as $index => $h)
                            <tr class="{{ $index == 0 ? 'table-warning' : '' }}">
                                <td class="text-center fw-bold">
                                    @if($index == 0)
                                    <i class="fas fa-crown text-warning"></i>
                                    1
                                    @else
                                    {{ $index + 1 }}
                                    @endif
                                </td>
                                <td class="text-center">
                                    @php
                                    $data_laporan = $laporan->firstWhere('id', $h['id']);
                                    @endphp
                                    <img src="{{ asset('storage/sampah/' .$data_laporan->foto) }}"
                                        class="img-thumbnail" style="width: 80px;">
                                </td>
                                <td>{{ $h['nik'] }}</td>
                                <td class="text-center">{{ number_format($h['s'], 4) }}</td>
                                <td class="text-center">{{ number_format($h['r'], 4) }}</td>
                                <td class="text-center fw-bold text-primary">
                                    {{ number_format($h['q'], 4) }}
                                </td>
                                <td class="text-center">
                                    <a href="#" class="btn btn-sm btn-info">
                                        <i class="fas fa-eye"></i> Detail
                                    </a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="card-footer text-muted small">
                * Perhitungan menggunakan bobot default: C1=0.30, C2=0.15,
                C3=0.15, C4=0.20, C5=0.20
            </div>
        </div>
    </div>
</div>
@endsection
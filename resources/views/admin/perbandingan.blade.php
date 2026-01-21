@extends('layouts.admin')

@section('title', 'Analisis Korelasi Spearman')

@section('content')

<div class="row">
    <div class="col-md-4">
        <div class="small-box bg-info shadow">
            <div class="inner">
                <h3>{{ number_format($spearman, 4) }}</h3>
                <p>Koefisien Spearman (ρ)</p>
            </div>
            <div class="icon"><i class="fas fa-chart-line"></i></div>
        </div>
        <div class="card">
            <div class="card-body">
                <h6><b>Interpretasi:</b></h6>
                <ul class="text-sm">
                    <li><b>> 0.8:</b> Korelasi Sangat Kuat (Hasil hampir sama)</li>
                    <li><b>0.4 - 0.7:</b> Korelasi Sedang</li>
                    <li><b>
                            < 0.3:</b> Korelasi Lemah (Hasil berbeda jauh)</li>
                </ul>
            </div>
        </div>
    </div>

    <div class="col-md-8">
        <div class="card shadow">
            <div class="card-header bg-dark text-white">
                <h3 class="card-title">Perbandingan Peringkat VIKOR vs WP</h3>
            </div>
            <div class="card-body p-0">
                <table class="table table-bordered table-striped mb-0">
                    <thead class="text-center">
                        <tr>
                            <th>Laporan (ID)</th>
                            <th>Rank VIKOR</th>
                            <th>Rank WP</th>
                            <th>d (Selisih)</th>
                            <th>d²</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($perbandingan as $p)
                        <tr class="text-center">
                            <td>#{{ $p['id'] }}</td>
                            <td><span class="badge badge-success">{{ $p['rank_vikor'] }}</span></td>
                            <td><span class="badge badge-primary">{{ $p['rank_wp'] }}</span></td>
                            <td>{{ $p['d'] }}</td>
                            <td>{{ $p['d_kuadrat'] }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                    <tfoot class="bg-light fw-bold text-center">
                        <tr>
                            <td colspan="4">Total Σd²</td>
                            <td>{{ array_sum(array_column($perbandingan, 'd_kuadrat')) }}</td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
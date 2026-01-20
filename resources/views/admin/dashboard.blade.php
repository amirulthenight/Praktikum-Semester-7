@extends('layouts.admin')

@section('title', 'Daftar Laporan Masyarakat')
@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Tabel Data Masuk</h3>
    </div>
    <div class="card-body p-0">
        <table class="table table-striped table-valign-middle">
            <thead>
                <tr>
                    <th>Foto</th>
                    <th>NIK Pelapor</th>
                    <th>Status</th>
                    <th>Tanggal</th>
                </tr>
            </thead>
            <tbody>
                @foreach($laporan as $l)
                <tr>
                    <td><img src="{{ asset('storage/sampah/'.$l->foto) }}"
                            width="60" class="img-thumbnail"></td>
                    <td>{{ $l->nik_pelapor }}</td>
                    <td><span class="badge badge-warning">{{ $l->status }}</span></td>
                    <td>{{ $l->created_at->format('d/m/Y') }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
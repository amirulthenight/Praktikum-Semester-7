@extends('layouts.admin')

@section('title', 'Peta Sebaran Laporan')

@push('styles')
<link rel="stylesheet"
    href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
<style>
    #map {
        height: 600px;
        border-radius: 8px;
    }
</style>
@endpush

@section('content')
<div class="card">
    <div class="card-body">
        <div id="map"></div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script>
    var map = L.map('map').setView([-1.269160, 116.825264], 5);
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png').addTo(map);
    @foreach ($laporan as $l)
        @if ($l->koordinat)
            L.marker([{{ $l->koordinat }}]).addTo(map)
                .bindPopup(`
                    <div class="text-center">
                        <img src="{{ asset('storage/sampah/' . $l->foto) }}" width="120"><br>
                        <strong>NIK: {{ $l->nik_pelapor }}</strong>
                    </div>
                `);
        @endif
    @endforeach
</script>
@endpush

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
                                    <a href="#" class="btn btn-sm btn-info btn-detail" data-id="{{ $h['id'] }}">
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
<div class="modal fade" id="modalDetail" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header bg-info">
                <h5 class="modal-title text-white" id="exampleModalLabel"><i
                        class="fas fa-info-circle"></i> Detail Laporan Prioritas</h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-5">
                        <label>Foto Lokasi:</label>
                        <img id="view-foto" src="" class="img-fluid rounded shadow-sm border" alt="Foto Sampah">
                    </div>
                    <div class="col-md-7">
                        <table class="table table-sm table-borderless">
                            <tr>
                                <th width="150">NIK Pelapor</th>
                                <td>: <span id="view-nik"></span></td>
                            </tr>
                            <tr>
                                <th>Status Laporan</th>
                                <td>: <span id="view-status" class="badge"></span></td>
                            </tr>
                            <tr>
                                <th>Koordinat</th>
                                <td>: <span id="view-koordinat"></span></td>
                            </tr>
                        </table>
                        <hr>
                        <h6><b>Nilai Kriteria (Input Masyarakat):</b></h6>
                        <div class="row text-center">
                            <div class="col-2 borderright"><small>C1</small><br><b id="view-c1"></b></div>
                            <div class="col-2 borderright"><small>C2</small><br><b id="view-c2"></b></div>
                            <div class="col-2 borderright"><small>C3</small><br><b id="view-c3"></b></div>
                            <div class="col-2 borderright"><small>C4</small><br><b id="view-c4"></b></div>
                            <div class="col-2"><small>C5</small><br><b id="viewc5"></b></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">

                <div class="modal-footer justify-content-between">
                    <div>
                        <form id="form-update-status" method="POST" class="d-inline">
                            @csrf
                            <input type="hidden" name="status" value="selesai">
                            <button type="submit" id="btn-selesai" class="btn btn-success"><i class="fas fa-check"></i>Tandai Selesai</button>
                        </form>
                    </div>
                </div>

                <!-- <form id="form-update-status" method="POST" style="display:inline;">
                    @csrf
                    <button type="submit" id="btn-selesai" class="btn btn-success"><i class="fas fa-check"></i> Selesai</button>
                </form> -->
                <a id="btn-map" href="" target="_blank" class="btn btn-primary"><i class="fas fa-map-marker-alt"></i> Lihat di Peta</a>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
    $(document).ready(function() {
        // Gunakan delegasi event pada document agar lebih pasti terpanggil
        $(document).on('click', '.btn-detail', function(e) {
            e.preventDefault(); // Mencegah reload halaman karena tag <a>
            var id = $(this).data('id');
            console.log("ID Laporan yang diklik: " + id); // Cek di F12 Console
            $.ajax({
                url: '/admin/laporan/' + id,
                type: 'GET',
                dataType: 'JSON',
                success: function(data) {
                    // Mapping data ke elemen modal
                    $('#view-foto').attr('src', '/storage/sampah/' + data.foto);
                    $('#view-nik').text(data.nik_pelapor);
                    $('#view-koordinat').text(data.koordinat);
                    $('#view-c1').text(data.c1);
                    $('#view-c2').text(data.c2);
                    $('#view-c3').text(data.c3);
                    $('#view-c4').text(data.c4);
                    $('#viewc5').text(data.c5);
                    // Warna Badge Status
                    var statusBadge = $('#view-status');
                    statusBadge.text(data.status.toUpperCase());
                    statusBadge.removeClass('badge-warning badge-success')
                        .addClass(data.status == 'pending' ? 'badge-warning' : 'badge-success');

                    // Link Peta
                    $('#btn-map').attr('href',
                        'https://www.google.com/maps/search/?api=1&query=' + data.koordinat);

                    // Form Update Status
                    $('#form-update-status').attr('action', '/admin/laporan/update-status/' + data.id);
                    // Sembunyikan tombol "Selesai" jika status memang sudah selesai
                    if (data.status == 'selesai') {
                        $('#btn-selesai').hide();
                    } else {
                        $('#btn-selesai').show();
                    }

                    // Tampilkan Modal secara manual
                    $('#modalDetail').modal('show');
                },
                error: function(xhr) {
                    console.error(xhr.responseText);
                    alert("Gagal mengambil data. Pastikan Route & Controller sudah benar.");
                }
            });
        });
    });
</script>
@endpush
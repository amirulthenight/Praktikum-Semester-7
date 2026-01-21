@extends('layouts.admin')

@section('title', 'Ranking Prioritas (Metode WP)')

@section('content')

<div class="row">
    <div class="col-md-12">
        <div class="card card-primary card-outline shadow-sm">
            <div class="card-header">
                <h3 class="card-title fw-bold">Prioritas Pengangkutan (Metode WP)</h3>
            </div>
            <div class="card-body p-0">
                <table class="table table-hover table-striped mb-0">
                    <thead class="bg-light">
                        <tr class="text-center">
                            <th width="80">Rank</th>
                            <th>Foto</th>
                            <th>NIK Pelapor</th>
                            <th>Skor (Vektor V)</th>
                            <th width="150">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($hasil_wp as $index => $h)
                        <tr>
                            <td class="text-center fw-bold">
                                @if($index == 0)
                                <span class="badge badge-success px-3"><i
                                        class="fas fa-star"></i> 1</span>
                                @else
                                {{ $index + 1 }}
                                @endif
                            </td>
                            <td class="text-center">
                                @php $item = $laporan->firstWhere('id', $h['id']); @endphp
                                <img src="{{ asset('storage/sampah/' . $item->foto) }}" class="rounded border" style="width: 60px; height: 45px; object-fit: cover;">
                            </td>
                            <td>{{ $h['nik'] }}</td>
                            <td class="text-center text-success fw-bold">
                                {{ number_format($h['vektor_v'], 4) }}
                            </td>
                            <td class="text-center">
                                <button type="button" class="btn btn-info btn-sm btn-detail" data-id="{{ $h['id'] }}">
                                    <i class="fas fa-eye"></i> Detail
                                </button>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modalDetail" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header bg-info">
                <h5 class="modal-title text-white"><i class="fas fa-info-circle"></i> Detail Laporan WP</h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">x</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-5">
                        <img id="view-foto" src="" class="img-fluid rounded shadow-sm border">
                    </div>
                    <div class="col-md-7">
                        <table class="table table-sm table-borderless">
                            <tr>
                                <th width="150">NIK Pelapor</th>
                                <td>: <span
                                        id="view-nik"></span></td>
                            </tr>
                            <tr>
                                <th>Status</th>
                                <td>: <span id="view-status"
                                        class="badge"></span></td>
                            </tr>
                            <tr>
                                <th>Koordinat</th>
                                <td>: <span id="view-koordinat"></span></td>
                            </tr>
                        </table>
                        <hr>
                        <h6><b>Kriteria:</b></h6>
                        <div class="row text-center">
                            <div class="col-2 border-right"><small>C1</small><br><b id="view-c1"></b></div>
                            <div class="col-2 border-right"><small>C2</small><br><b id="view-c2"></b></div>
                            <div class="col-2 border-right"><small>C3</small><br><b id="view-c3"></b></div>
                            <div class="col-2 border-right"><small>C4</small><br><b id="view-c4"></b></div>
                            <div class="col-2"><small>C5</small><br><b id="viewc5"></b></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer justify-content-between">
                <a id="btn-map" href="" target="_blank" class="btn btn-primary"><i class="fas fa-map-marker-alt"></i> Peta</a>
                <form id="form-update-status" action="" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-success" onclick="return confirm('Selesaikan laporan?')">Tandai Selesai</button>
                    <button type="button" class="btn btn-secondary" datadismiss="modal">Tutup</button>
                </form>
            </div>
        </div>
    </div>
</div>
<div>

    @endsection

    @push('scripts')

    <script>
        $(document).on('click', '.btn-detail', function() {
            var id = $(this).data('id');
            $.get('/admin/laporan/detail/' + id, function(data) {
                $('#view-foto').attr('src', '/storage/sampah/' + data.foto);
                $('#view-nik').text(data.nik_pelapor);
                $('#view-koordinat').text(data.koordinat);
                $('#view-c1').text(data.c1);
                $('#view-c2').text(data.c2);
                $('#view-c3').text(data.c3);
                $('#view-c4').text(data.c4);
                $('#view-c5').text(data.c5);

                $('#form-update-status').attr('action', '/admin/laporan/update-status/' + data.id);

                var badge = $('#view-status');
                badge.text(data.status.toUpperCase()).removeClass('badge-warning badge-success')
                    .addClass(data.status == 'pending' ? 'badge-warning' : 'badge-success');
                $('#btn-map').attr('href', 'https://www.google.com/maps?q=' + data.koordinat);
                $('#modalDetail').modal('show');
            });
        });
    </script>
    @endpush
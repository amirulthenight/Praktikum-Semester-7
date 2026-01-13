@extends('layouts.public')
@section('title', 'Registrasi Masyarakat')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-lg-6">
            <div class="card border-0 shadow-lg">
                <div class="card-body p-5">
                    <h3 class="fw-bold text-center mb-4">Registrasi Masyarakat</h3>
                    <p class="text-muted text-center mb-4">Silakan lengkapi data diri Anda
                        untuk mulai melaporkan tumpukan sampah liar.</p>
                    @if(session('success'))
                    <div class="alert alert-success border-0 shadow-sm mb-4">
                        <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
                    </div>
                    @endif
                    <form action="{{ route('masyarakat.store') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label fw-semibold">NIK (16 Digit)</label>
                            <input type="text" name="nik" class="form-control form-control-lg @error('nik') is-invalid @enderror" value="{{ old('nik') }}" placeholder="Masukkan NIK sesuai KTP">
                            @error('nik') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Nama Lengkap</label>
                            <input type="text" name="nama" class="form-control form-control-lg @error('nama') is-invalid @enderror" value="{{ old('nama') }}" placeholder="Nama Lengkap">
                            @error('nama') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-semibold">No. Telepon</label>
                                <input type="text" name="telp" class="form-control form-control-lg @error('telp') is-invalid @enderror" value="{{ old('telp') }}" placeholder="08xxx">
                                @error('telp') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-semibold">Email</label>
                                <input type="email" name="email" class="form-control form-control-lg @error('email') is-invalid @enderror" value="{{ old('email') }}" placeholder="email@contoh.com">
                                @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                        </div>
                        <div class="mb-4">
                            <label class="form-label fw-semibold">Alamat Lengkap</label>
                            <textarea name="alamat" class="form-control @error('alamat') is-invalid @enderror" rows="3" placeholder="Alamat Domisili">{{ old('alamat') }}</textarea>
                            @error('alamat') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <button type="submit" class="btn btn-success btn-lg w-100 shadow-sm fw-bold">
                            Daftar Sekarang
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
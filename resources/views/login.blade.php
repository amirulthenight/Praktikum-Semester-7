@extends('layouts.public')

@section('title', 'Login Pelapor')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-lg-5">
            <div class="card border-0 shadow-lg">
                <div class="card-body p-5">
                    <div class="text-center mb-4">
                        <i class="fas fa-user-circle fa-4x text-success mb-3"></i>
                        <h3 class="fw-bold">Login Pelapor</h3>
                        <p class="text-muted">Gunakan NIK dan Email yang sudah terdaftar</p>
                    </div>

                    @if(session('error'))
                    <div class="alert alert-danger border-0 shadow-sm">
                        <i class="fas fa-exclamation-triangle me-2"></i> {{ session('error') }}
                    </div>
                    @endif
                    <form action="{{ route('login.process') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label fw-semibold">NIK</label>
                            <input type="text" name="nik" class="form-control form-control-lg @error('nik') is-invalid @enderror" placeholder="16 Digit NIK" required>
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-semibold">Email Terdaftar</label>
                            <input type="email" name="email" class="form-control form-control lg @error('email') is-invalid @enderror" placeholder="email@contoh.com" required>
                        </div>

                        <button type="submit" class="btn btn-success btn-lg w-100 shadow-smfw-bold">
                            Masuk Ke Panel Lapor
                        </button>
                    </form>

                    <div class="text-center mt-4">
                        <p class="mb-0 text-muted">Belum punya akun? <a href="{{route('masyarakat.index') }}" class="text-success fw-bold text-decoration-none">Daftar di
                                sini</a></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@stop
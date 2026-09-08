@extends('layouts.app')

@section('title', 'Pengaduan Sarana Keyla')

@section('content')
    <div class="container py-5">
        <!-- Hero Section -->
        <div class="row align-items-center min-vh-75 py-5">
            <div class="col-lg-6">
                <h1 class="display-4 fw-bold text-primary mb-4">
                    <i class="fas fa-school me-3"></i>
                    Pengaduan Sarana Sekolah
                </h1>
                <p class="lead text-muted mb-4">
                    Sampaikan aspirasi, keluhan, dan masukan Anda terkait sarana dan prasarana sekolah
                    dengan mudah dan cepat. Bersama kita wujudkan sekolah yang lebih baik!
                </p>
                <div class="d-flex gap-3 flex-wrap">
                    @guest
                        <a href="{{ route('register') }}" class="btn btn-primary-custom btn-lg">
                            <i class="fas fa-user-plus me-2"></i> Daftar Sekarang
                        </a>
                        <a href="{{ route('login') }}" class="btn btn-outline-primary btn-lg">
                            <i class="fas fa-sign-in-alt me-2"></i> Login
                        </a>
                    @else
                        <a href="{{ route('dashboard') }}" class="btn btn-primary-custom btn-lg">
                            <i class="fas fa-chart-pie me-2"></i> Ke Dashboard
                        </a>
                    @endguest
                </div>
            </div>
            <div class="col-lg-6 text-center">
                <img src="https://via.placeholder.com/500x400/4F46E5/FFFFFF?text=Pengaduan+Sarana" alt="Illustration"
                    class="img-fluid rounded shadow-lg">
            </div>
        </div>

        <!-- Features -->
        <div class="row mt-5 pt-5 g-4">
            <h2 class="text-center mb-4 fw-bold">Kenapa Memilih Kami?</h2>

            <div class="col-md-3">
                <div class="card-custom p-4 text-center h-100">
                    <div class="icon bg-primary text-white mx-auto mb-3"
                        style="width:60px;height:60px;border-radius:50%;display:flex;align-items:center;justify-content:center;font-size:24px;">
                        <i class="fas fa-bolt"></i>
                    </div>
                    <h5>Cepat & Mudah</h5>
                    <p class="text-muted small">Sampaikan aspirasi dalam hitungan menit</p>
                </div>
            </div>

            <div class="col-md-3">
                <div class="card-custom p-4 text-center h-100">
                    <div class="icon bg-success text-white mx-auto mb-3"
                        style="width:60px;height:60px;border-radius:50%;display:flex;align-items:center;justify-content:center;font-size:24px;">
                        <i class="fas fa-eye"></i>
                    </div>
                    <h5>Transparan</h5>
                    <p class="text-muted small">Pantau status pengaduan Anda secara real-time</p>
                </div>
            </div>

            <div class="col-md-3">
                <div class="card-custom p-4 text-center h-100">
                    <div class="icon bg-warning text-white mx-auto mb-3"
                        style="width:60px;height:60px;border-radius:50%;display:flex;align-items:center;justify-content:center;font-size:24px;">
                        <i class="fas fa-reply"></i>
                    </div>
                    <h5>Umpan Balik</h5>
                    <p class="text-muted small">Dapatkan respon dari pihak sekolah</p>
                </div>
            </div>

            <div class="col-md-3">
                <div class="card-custom p-4 text-center h-100">
                    <div class="icon bg-danger text-white mx-auto mb-3"
                        style="width:60px;height:60px;border-radius:50%;display:flex;align-items:center;justify-content:center;font-size:24px;">
                        <i class="fas fa-chart-line"></i>
                    </div>
                    <h5>Terintegrasi</h5>
                    <p class="text-muted small">Data terpusat dan mudah dikelola</p>
                </div>
            </div>
        </div>

        <!-- Stats -->
        <div class="row mt-5 pt-4 g-4 bg-light rounded-4 p-4">
            <div class="col-md-3 text-center">
                <h2 class="fw-bold text-primary">{{ \App\Models\Aspirasi::count() }}</h2>
                <p class="text-muted">Total Aspirasi</p>
            </div>
            <div class="col-md-3 text-center">
                <h2 class="fw-bold text-success">{{ \App\Models\Aspirasi::where('status', 'selesai')->count() }}</h2>
                <p class="text-muted">Selesai Diproses</p>
            </div>
            <div class="col-md-3 text-center">
                <h2 class="fw-bold text-warning">{{ \App\Models\Aspirasi::where('status', 'proses')->count() }}</h2>
                <p class="text-muted">Sedang Diproses</p>
            </div>
            <div class="col-md-3 text-center">
                <h2 class="fw-bold text-info">{{ \App\Models\User::where('role', 'guest')->count() }}</h2>
                <p class="text-muted">Pengguna Aktif</p>
            </div>
        </div>
    </div>
@endsection
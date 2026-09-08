@extends('layouts.app')

@section('title', 'Dashboard User')

@section('content')
    <div class="container-fluid">
        <!-- Welcome -->
        <div class="row mb-4">
            <div class="col-12">
                <h2 class="fw-bold">
                    <i class="fas fa-home text-primary me-2"></i>
                    Halo, {{ auth()->user()->name }}!
                </h2>
                <p class="text-muted">Selamat datang di dashboard pengaduan sarana sekolah</p>
            </div>
        </div>

        <!-- Stats -->
        <div class="row g-3 mb-4">
            <div class="col-md-3">
                <div class="stat-card">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <p class="text-muted small mb-1">Total Aspirasi</p>
                            <h3 class="fw-bold mb-0">{{ $totalAspirasi }}</h3>
                        </div>
                        <div class="icon bg-primary text-white">
                            <i class="fas fa-file-alt"></i>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stat-card">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <p class="text-muted small mb-1">Menunggu</p>
                            <h3 class="fw-bold mb-0 text-warning">{{ $pending }}</h3>
                        </div>
                        <div class="icon bg-warning text-white">
                            <i class="fas fa-clock"></i>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stat-card">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <p class="text-muted small mb-1">Diproses</p>
                            <h3 class="fw-bold mb-0 text-info">{{ $proses }}</h3>
                        </div>
                        <div class="icon bg-info text-white">
                            <i class="fas fa-spinner"></i>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stat-card">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <p class="text-muted small mb-1">Selesai</p>
                            <h3 class="fw-bold mb-0 text-success">{{ $selesai }}</h3>
                        </div>
                        <div class="icon bg-success text-white">
                            <i class="fas fa-check-circle"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Recent Aspirasi -->
        <div class="row">
            <div class="col-12">
                <div class="card-custom p-4">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h5 class="fw-bold mb-0">
                            <i class="fas fa-history me-2"></i> Aspirasi Terbaru
                        </h5>
                        <a href="{{ route('aspirasi.index') }}" class="btn btn-sm btn-outline-primary">
                            Lihat Semua <i class="fas fa-arrow-right ms-1"></i>
                        </a>
                    </div>

                    @if($recentAspirasi->isEmpty())
                        <div class="text-center py-4">
                            <i class="fas fa-inbox fa-3x text-muted mb-3"></i>
                            <p class="text-muted">Belum ada aspirasi. Buat aspirasi pertama Anda!</p>
                            <a href="{{ route('aspirasi.create') }}" class="btn btn-primary-custom">
                                <i class="fas fa-plus me-2"></i> Buat Aspirasi
                            </a>
                        </div>
                    @else
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Judul</th>
                                        <th>Kategori</th>
                                        <th>Status</th>
                                        <th>Tanggal</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($recentAspirasi as $aspirasi)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ Str::limit($aspirasi->judul, 30) }}</td>
                                            <td>
                                                <span class="badge bg-secondary">
                                                    <i class="fas {{ $aspirasi->kategori->icon ?? 'fa-tag' }} me-1"></i>
                                                    {{ $aspirasi->kategori->nama_kategori }}
                                                </span>
                                            </td>
                                            <td>
                                                <span class="badge-status badge-{{ $aspirasi->status_badge }}">
                                                    {{ $aspirasi->status_label }}
                                                </span>
                                            </td>
                                            <td>{{ $aspirasi->created_at->format('d/m/Y') }}</td>
                                            <td>
                                                <a href="{{ route('aspirasi.show', $aspirasi) }}"
                                                    class="btn btn-sm btn-outline-primary">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
@extends('layouts.app')

@section('title', 'Dashboard Admin')

@section('content')
    <div class="container-fluid">
        <!-- Welcome -->
        <div class="row mb-4">
            <div class="col-12">
                <h2 class="fw-bold">
                    <i class="fas fa-user-shield text-primary me-2"></i>
                    Dashboard Admin
                </h2>
                <p class="text-muted">Selamat datang, {{ auth()->user()->name }}! Kelola semua aspirasi di sini.</p>
            </div>
        </div>

        <!-- Stats -->
        <div class="row g-3 mb-4">
            <div class="col-md-2">
                <div class="stat-card text-center">
                    <h4 class="fw-bold mb-1">{{ $totalAspirasi }}</h4>
                    <p class="text-muted small mb-0">Total</p>
                </div>
            </div>
            <div class="col-md-2">
                <div class="stat-card text-center border-start border-warning border-4">
                    <h4 class="fw-bold mb-1 text-warning">{{ $pending }}</h4>
                    <p class="text-muted small mb-0">Menunggu</p>
                </div>
            </div>
            <div class="col-md-2">
                <div class="stat-card text-center border-start border-info border-4">
                    <h4 class="fw-bold mb-1 text-info">{{ $proses }}</h4>
                    <p class="text-muted small mb-0">Diproses</p>
                </div>
            </div>
            <div class="col-md-2">
                <div class="stat-card text-center border-start border-success border-4">
                    <h4 class="fw-bold mb-1 text-success">{{ $selesai }}</h4>
                    <p class="text-muted small mb-0">Selesai</p>
                </div>
            </div>
            <div class="col-md-2">
                <div class="stat-card text-center border-start border-danger border-4">
                    <h4 class="fw-bold mb-1 text-danger">{{ $ditolak }}</h4>
                    <p class="text-muted small mb-0">Ditolak</p>
                </div>
            </div>
            <div class="col-md-2">
                <div class="stat-card text-center border-start border-primary border-4">
                    <h4 class="fw-bold mb-1">{{ $aspirasiPerKategori->count() }}</h4>
                    <p class="text-muted small mb-0">Kategori</p>
                </div>
            </div>
        </div>

        <!-- Chart & Kategori -->
        <div class="row g-4 mb-4">
            <div class="col-md-8">
                <div class="card-custom p-4">
                    <h5 class="fw-bold mb-3">
                        <i class="fas fa-chart-bar me-2"></i> Statistik Aspirasi per Bulan
                    </h5>
                    <canvas id="chartAspirasi" height="200"></canvas>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card-custom p-4">
                    <h5 class="fw-bold mb-3">
                        <i class="fas fa-chart-pie me-2"></i> Per Kategori
                    </h5>
                    <div class="list-group list-group-flush">
                        @foreach($aspirasiPerKategori as $kat)
                            <div class="list-group-item d-flex justify-content-between align-items-center px-0">
                                <span>
                                    <i class="fas {{ $kat->icon ?? 'fa-tag' }} me-2 text-primary"></i>
                                    {{ $kat->nama_kategori }}
                                </span>
                                <span class="badge bg-primary rounded-pill">{{ $kat->aspirasis_count }}</span>
                            </div>
                        @endforeach
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
                            <i class="fas fa-tasks me-2"></i> Aspirasi Terbaru
                        </h5>
                        <a href="{{ route('admin.all-aspirasi') }}" class="btn btn-sm btn-outline-primary">
                            Kelola Semua <i class="fas fa-arrow-right ms-1"></i>
                        </a>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Pengadu</th>
                                    <th>Judul</th>
                                    <th>Kategori</th>
                                    <th>Status</th>
                                    <th>Prioritas</th>
                                    <th>Tanggal</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($recentAspirasi as $aspirasi)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $aspirasi->user->name }}</td>
                                        <td>{{ Str::limit($aspirasi->judul, 25) }}</td>
                                        <td>{{ $aspirasi->kategori->nama_kategori }}</td>
                                        <td>
                                            <span class="badge-status badge-{{ $aspirasi->status_badge }}">
                                                {{ $aspirasi->status_label }}
                                            </span>
                                        </td>
                                        <td>
                                            <span
                                                class="badge bg-{{ $aspirasi->prioritas == 'tinggi' ? 'danger' : ($aspirasi->prioritas == 'sedang' ? 'warning' : 'info') }}">
                                                {{ ucfirst($aspirasi->prioritas) }}
                                            </span>
                                        </td>
                                        <td>{{ $aspirasi->created_at->format('d/m/Y H:i') }}</td>
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
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                const ctx = document.getElementById('chartAspirasi').getContext('2d');
                new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: {!! json_encode($bulanLabels) !!},
                        datasets: [{
                            label: 'Jumlah Aspirasi',
                            data: {!! json_encode($dataBulan) !!},
                            backgroundColor: 'rgba(79, 70, 229, 0.7)',
                            borderColor: '#4F46E5',
                            borderWidth: 2,
                            borderRadius: 8
                        }]
                    },
                    options: {
                        responsive: true,
                        plugins: {
                            legend: {
                                display: false
                            }
                        },
                        scales: {
                            y: {
                                beginAtZero: true,
                                ticks: {
                                    stepSize: 1
                                }
                            }
                        }
                    }
                });
            });
        </script>
    @endpush
@endsection
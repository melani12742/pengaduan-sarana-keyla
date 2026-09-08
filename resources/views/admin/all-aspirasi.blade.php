@extends('layouts.app')

@section('title', 'Semua Aspirasi - Admin')

@section('content')
    <div class="container-fluid">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h2 class="fw-bold">
                    <i class="fas fa-tasks me-2 text-primary"></i>
                    Semua Aspirasi
                </h2>
                <p class="text-muted">Kelola semua aspirasi dari seluruh pengguna</p>
            </div>
        </div>

        <!-- Filter -->
        <div class="card-custom p-3 mb-4">
            <form method="GET" class="row g-2">
                <div class="col-md-3">
                    <select name="status" class="form-select">
                        <option value="">Semua Status</option>
                        <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Menunggu</option>
                        <option value="proses" {{ request('status') == 'proses' ? 'selected' : '' }}>Diproses</option>
                        <option value="selesai" {{ request('status') == 'selesai' ? 'selected' : '' }}>Selesai</option>
                        <option value="ditolak" {{ request('status') == 'ditolak' ? 'selected' : '' }}>Ditolak</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <select name="kategori" class="form-select">
                        <option value="">Semua Kategori</option>
                        @foreach($kategoris as $id => $nama)
                            <option value="{{ $id }}" {{ request('kategori') == $id ? 'selected' : '' }}>{{ $nama }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3">
                    <input type="date" name="tanggal" class="form-control" value="{{ request('tanggal') }}">
                </div>
                <div class="col-md-3">
                    <button type="submit" class="btn btn-primary-custom w-100">
                        <i class="fas fa-filter me-1"></i> Filter
                    </button>
                </div>
            </form>
        </div>

        <!-- Tabel -->
        <div class="card-custom p-0 overflow-hidden">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="bg-light">
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
                        @forelse($aspirasis as $aspirasi)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $aspirasi->user->name }}</td>
                                <td>{{ Str::limit($aspirasi->judul, 30) }}</td>
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
                                <td>{{ $aspirasi->created_at->format('d/m/Y') }}</td>
                                <td>
                                    <a href="{{ route('aspirasi.show', $aspirasi) }}" class="btn btn-sm btn-outline-primary">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center py-4">
                                    <i class="fas fa-inbox fa-2x text-muted mb-2 d-block"></i>
                                    <p class="text-muted mb-0">Tidak ada data aspirasi</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <div class="mt-3">
            {{ $aspirasis->withQueryString()->links() }}
        </div>
    </div>
@endsection
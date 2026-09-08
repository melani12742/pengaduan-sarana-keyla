@extends('layouts.app')

@section('title', 'Daftar Aspirasi')

@section('content')
    <div class="container-fluid">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h2 class="fw-bold">
                    <i class="fas fa-list me-2 text-primary"></i>
                    Daftar Aspirasi
                </h2>
                <p class="text-muted">Kelola aspirasi yang telah Anda kirimkan</p>
            </div>
            <a href="{{ route('aspirasi.create') }}" class="btn btn-primary-custom">
                <i class="fas fa-plus me-2"></i> Buat Aspirasi
            </a>
        </div>

        @if($aspirasis->isEmpty())
            <div class="card-custom p-5 text-center">
                <i class="fas fa-inbox fa-4x text-muted mb-3"></i>
                <h4 class="fw-bold">Belum Ada Aspirasi</h4>
                <p class="text-muted">Mulai sampaikan aspirasi Anda sekarang!</p>
                <a href="{{ route('aspirasi.create') }}" class="btn btn-primary-custom">
                    <i class="fas fa-plus me-2"></i> Buat Aspirasi
                </a>
            </div>
        @else
            <div class="card-custom p-0 overflow-hidden">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead class="bg-light">
                            <tr>
                                <th>#</th>
                                <th>Judul</th>
                                <th>Kategori</th>
                                <th>Status</th>
                                <th>Prioritas</th>
                                <th>Tanggal</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($aspirasis as $aspirasi)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>
                                        <strong>{{ Str::limit($aspirasi->judul, 40) }}</strong>
                                        @if($aspirasi->umpanBalik && !$aspirasi->umpanBalik->is_read)
                                            <span class="badge bg-danger ms-2">Baru</span>
                                        @endif
                                    </td>
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
                                    <td>
                                        <span
                                            class="badge bg-{{ $aspirasi->prioritas == 'tinggi' ? 'danger' : ($aspirasi->prioritas == 'sedang' ? 'warning' : 'info') }}">
                                            {{ ucfirst($aspirasi->prioritas) }}
                                        </span>
                                    </td>
                                    <td>{{ $aspirasi->created_at->format('d/m/Y H:i') }}</td>
                                    <td>
                                        <div class="btn-group btn-group-sm">
                                            <a href="{{ route('aspirasi.show', $aspirasi) }}" class="btn btn-outline-primary">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            @if($aspirasi->status == 'pending')
                                                <a href="{{ route('aspirasi.edit', $aspirasi) }}" class="btn btn-outline-warning">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <form action="{{ route('aspirasi.destroy', $aspirasi) }}" method="POST"
                                                    class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-outline-danger delete-confirm">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </form>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="mt-3">
                {{ $aspirasis->links() }}
            </div>
        @endif
    </div>
@endsection
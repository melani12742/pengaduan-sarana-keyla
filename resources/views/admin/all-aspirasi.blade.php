@extends('layouts.app')

@section('title', 'Semua Aspirasi')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-12">
                <h1 class="mb-4">Semua Aspirasi</h1>

                <div class="card">
                    <div class="card-body">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Judul</th>
                                    <th>User</th>
                                    <th>Kategori</th>
                                    <th>Status</th>
                                    <th>Prioritas</th>
                                    <th>Tanggal</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($aspirasis as $key => $aspirasi)
                                    <tr>
                                        <td>{{ $key + 1 }}</td>
                                        <td>{{ $aspirasi->judul }}</td>
                                        <td>{{ $aspirasi->user->name ?? 'Unknown' }}</td>
                                        <td>{{ $aspirasi->category->nama_kategori ?? 'N/A' }}</td>
                                        <td>
                                            <span
                                                class="badge bg-{{ $aspirasi->status === 'selesai' ? 'success' : ($aspirasi->status === 'proses' ? 'info' : ($aspirasi->status === 'ditolak' ? 'danger' : 'warning')) }}">
                                                {{ $aspirasi->status }}
                                            </span>
                                        </td>
                                        <td>
                                            <span
                                                class="badge bg-{{ $aspirasi->prioritas === 'tinggi' ? 'danger' : ($aspirasi->prioritas === 'sedang' ? 'warning' : 'secondary') }}">
                                                {{ $aspirasi->prioritas }}
                                            </span>
                                        </td>
                                        <td>{{ $aspirasi->created_at->format('d/m/Y') }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="text-center">Belum ada aspirasi</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>

                        {{ $aspirasis->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
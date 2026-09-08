@extends('layouts.app')

@section('title', 'Kelola Kategori - Admin')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-8">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <div>
                        <h2 class="fw-bold">
                            <i class="fas fa-tags me-2 text-primary"></i>
                            Kelola Kategori
                        </h2>
                        <p class="text-muted">Kelola kategori aspirasi</p>
                    </div>
                </div>

                <div class="card-custom p-0 overflow-hidden">
                    <table class="table table-hover mb-0">
                        <thead class="bg-light">
                            <tr>
                                <th>#</th>
                                <th>Icon</th>
                                <th>Nama Kategori</th>
                                <th>Total Aspirasi</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($kategoris as $kategori)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td><i class="fas {{ $kategori->icon ?? 'fa-tag' }} fa-2x text-primary"></i></td>
                                    <td>{{ $kategori->nama_kategori }}</td>
                                    <td>{{ $kategori->aspirasis_count }}</td>
                                    <td>
                                        <button class="btn btn-sm btn-outline-warning" data-bs-toggle="modal"
                                            data-bs-target="#editKategori{{ $kategori->id }}">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <form action="{{ route('kategori.destroy', $kategori) }}" method="POST"
                                            class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger delete-confirm">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>

                                <!-- Modal Edit -->
                                <div class="modal fade" id="editKategori{{ $kategori->id }}" tabindex="-1">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <form action="{{ route('kategori.update', $kategori) }}" method="POST">
                                                @csrf
                                                @method('PUT')
                                                <div class="modal-header">
                                                    <h5 class="modal-title">Edit Kategori</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="mb-3">
                                                        <label class="form-label">Nama Kategori</label>
                                                        <input type="text" name="nama_kategori" class="form-control"
                                                            value="{{ $kategori->nama_kategori }}" required>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label class="form-label">Icon (Font Awesome)</label>
                                                        <input type="text" name="icon" class="form-control"
                                                            placeholder="fa-school" value="{{ $kategori->icon }}">
                                                        <small class="text-muted">Contoh: fa-school, fa-book, fa-flask</small>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary"
                                                        data-bs-dismiss="modal">Batal</button>
                                                    <button type="submit" class="btn btn-primary">Simpan</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="card-custom p-4">
                    <h5 class="fw-bold mb-3">
                        <i class="fas fa-plus-circle me-2 text-primary"></i>
                        Tambah Kategori
                    </h5>
                    <form action="{{ route('kategori.store') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label">Nama Kategori</label>
                            <input type="text" name="nama_kategori" class="form-control" placeholder="Contoh: Ruang Kelas"
                                required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Icon (Font Awesome)</label>
                            <input type="text" name="icon" class="form-control" placeholder="fa-school" value="fa-tag">
                            <small class="text-muted">Contoh: fa-school, fa-book, fa-flask</small>
                        </div>
                        <button type="submit" class="btn btn-primary-custom w-100">
                            <i class="fas fa-save me-1"></i> Tambah Kategori
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
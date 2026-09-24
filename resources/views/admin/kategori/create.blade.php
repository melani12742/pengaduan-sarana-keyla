@extends('layouts.app')

@section('title', 'Tambah Kategori')

@section('content')
    <div class="container-fluid">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 style="color: var(--text-white);">
                <span style="color: var(--gold);">Tambah</span> Kategori
            </h1>
            <a href="{{ route('admin.kategori.index') }}" class="btn-outline-gold">
                <i class="fas fa-arrow-left me-2"></i> Kembali
            </a>
        </div>

        <div class="card-gold" style="max-width: 600px;">
            <form action="{{ route('admin.kategori.store') }}" method="POST">
                @csrf

                <div class="mb-3">
                    <label for="nama_kategori" class="form-label" style="color: var(--text-gray);">Nama Kategori</label>
                    <input type="text" class="form-control form-control-gold @error('nama_kategori') is-invalid @enderror"
                        id="nama_kategori" name="nama_kategori" value="{{ old('nama_kategori') }}"
                        placeholder="Contoh: Fasilitas Kelas" required>
                    @error('nama_kategori')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="icon" class="form-label" style="color: var(--text-gray);">Icon (Font Awesome)</label>
                    <input type="text" class="form-control form-control-gold @error('icon') is-invalid @enderror" id="icon"
                        name="icon" value="{{ old('icon') }}" placeholder="Contoh: fa-school">
                    <small style="color: var(--text-gray);">Cek icon di <a href="https://fontawesome.com/icons"
                            target="_blank" style="color: var(--gold);">Font Awesome</a></small>
                    @error('icon')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <button type="submit" class="btn-gold w-100">Simpan Kategori</button>
            </form>
        </div>
    </div>
@endsection
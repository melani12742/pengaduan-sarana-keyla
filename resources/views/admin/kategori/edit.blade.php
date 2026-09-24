@extends('layouts.app')

@section('title', 'Edit Kategori')

@section('content')
    <div class="container-fluid">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 style="color: var(--text-white);">
                <span style="color: var(--gold);">Edit</span> Kategori
            </h1>
            <a href="{{ route('admin.kategori.index') }}" class="btn-outline-gold">
                <i class="fas fa-arrow-left me-2"></i> Kembali
            </a>
        </div>

        <div class="card-gold" style="max-width: 600px;">
            <form action="{{ route('admin.kategori.update', $kategori) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label for="nama_kategori" class="form-label" style="color: var(--text-gray);">Nama Kategori</label>
                    <input type="text" class="form-control form-control-gold @error('nama_kategori') is-invalid @enderror"
                        id="nama_kategori" name="nama_kategori" value="{{ old('nama_kategori', $kategori->nama_kategori) }}"
                        required>
                    @error('nama_kategori')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="icon" class="form-label" style="color: var(--text-gray);">Icon (Font Awesome)</label>
                    <input type="text" class="form-control form-control-gold @error('icon') is-invalid @enderror" id="icon"
                        name="icon" value="{{ old('icon', $kategori->icon) }}" placeholder="Contoh: fa-school">
                    <small style="color: var(--text-gray);">Cek icon di <a href="https://fontawesome.com/icons"
                            target="_blank" style="color: var(--gold);">Font Awesome</a></small>
                    @error('icon')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <button type="submit" class="btn-gold w-100">Update Kategori</button>
            </form>
        </div>
    </div>
@endsection
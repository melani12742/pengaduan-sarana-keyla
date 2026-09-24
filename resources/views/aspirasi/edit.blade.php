@extends('layouts.app')

@section('title', 'Edit Aspirasi')

@section('header', 'Edit Aspirasi')

@section('actions')
    <a href="{{ route('aspirasi.show', $aspirasi) }}" class="btn-outline-gold">
        <i class="fas fa-arrow-left me-2"></i> Kembali
    </a>
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="card-gold">
                    <form action="{{ route('aspirasi.update', $aspirasi) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        {{-- KATEGORI --}}
                        <div class="mb-3">
                            <label class="form-label fw-semibold" style="color: var(--text-gray);">
                                <i class="fas fa-tag me-2 text-gold"></i> Kategori
                            </label>
                            <select name="category_id" class="form-select form-control-gold @error('category_id') is-invalid @enderror" required>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" {{ $aspirasi->category_id == $category->id ? 'selected' : '' }}>
                                        {{ $category->nama_kategori }}
                                    </option>
                                @endforeach
                            </select>
                            @error('category_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- JUDUL --}}
                        <div class="mb-3">
                            <label class="form-label fw-semibold" style="color: var(--text-gray);">
                                <i class="fas fa-heading me-2 text-gold"></i> Judul
                            </label>
                            <input type="text" name="judul" class="form-control form-control-gold @error('judul') is-invalid @enderror"
                                value="{{ old('judul', $aspirasi->judul) }}" required>
                            @error('judul')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- DESKRIPSI --}}
                        <div class="mb-3">
                            <label class="form-label fw-semibold" style="color: var(--text-gray);">
                                <i class="fas fa-align-left me-2 text-gold"></i> Deskripsi
                            </label>
                            <textarea name="deskripsi" rows="5"
                                class="form-control form-control-gold @error('deskripsi') is-invalid @enderror"
                                required>{{ old('deskripsi', $aspirasi->deskripsi) }}</textarea>
                            @error('deskripsi')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- LOKASI & PRIORITAS --}}
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-semibold" style="color: var(--text-gray);">
                                    <i class="fas fa-map-marker-alt me-2 text-gold"></i> Lokasi
                                </label>
                                <input type="text" name="lokasi" class="form-control form-control-gold"
                                    value="{{ old('lokasi', $aspirasi->lokasi) }}">
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-semibold" style="color: var(--text-gray);">
                                    <i class="fas fa-flag me-2 text-gold"></i> Prioritas
                                </label>
                                <select name="prioritas" class="form-select form-control-gold" required>
                                    <option value="rendah" {{ $aspirasi->prioritas == 'rendah' ? 'selected' : '' }}>🔵 Rendah</option>
                                    <option value="sedang" {{ $aspirasi->prioritas == 'sedang' ? 'selected' : '' }}>🟡 Sedang</option>
                                    <option value="tinggi" {{ $aspirasi->prioritas == 'tinggi' ? 'selected' : '' }}>🟠 Tinggi</option>
                                    <option value="urgent" {{ $aspirasi->prioritas == 'urgent' ? 'selected' : '' }}>🔴 Urgent</option>
                                </select>
                            </div>
                        </div>

                        {{-- FOTO --}}
                        <div class="mb-3">
                            <label class="form-label fw-semibold" style="color: var(--text-gray);">
                                <i class="fas fa-image me-2 text-gold"></i> Foto Bukti (Opsional)
                            </label>

                            @if($aspirasi->foto)
                                <div class="mb-2">
                                    <img src="{{ $aspirasi->foto_url }}" alt="Foto Lama" class="img-fluid rounded" style="max-height: 200px;">
                                    <small style="color: var(--text-gray); display: block;">Foto saat ini</small>
                                </div>
                            @endif

                            <input type="file" name="foto" class="form-control form-control-gold" accept="image/*">
                            <small style="color: var(--text-gray);">Kosongkan jika tidak ingin ganti foto</small>
                        </div>

                        {{-- TOMBOL --}}
                        <div class="d-flex gap-3 mt-4">
                            <button type="submit" class="btn-gold">
                                <i class="fas fa-save me-2"></i> Simpan Perubahan
                            </button>
                            <a href="{{ route('aspirasi.show', $aspirasi) }}" class="btn-outline-gold">
                                <i class="fas fa-times me-2"></i> Batal
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
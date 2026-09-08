@extends('layouts.app')

@section('title', 'Buat Aspirasi')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card-custom p-4">
                <h2 class="fw-bold mb-4">
                    <i class="fas fa-plus-circle text-primary me-2"></i>
                    Buat Aspirasi Baru
                </h2>
                
                <form action="{{ route('aspirasi.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    
                    <div class="mb-3">
                        <label class="form-label fw-semibold">
                            <i class="fas fa-tag me-2 text-primary"></i> Kategori <span class="text-danger">*</span>
                        </label>
                        <select name="kategori_id" class="form-select @error('kategori_id') is-invalid @enderror" required>
                            <option value="">Pilih Kategori</option>
                            @foreach($kategoris as $kategori)
                                <option value="{{ $kategori->id }}" {{ old('kategori_id') == $kategori->id ? 'selected' : '' }}>
                                    <i class="fas {{ $kategori->icon }}"></i> {{ $kategori->nama_kategori }}
                                </option>
                            @endforeach
                        </select>
                        @error('kategori_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label fw-semibold">
                            <i class="fas fa-heading me-2 text-primary"></i> Judul <span class="text-danger">*</span>
                        </label>
                        <input type="text" name="judul" class="form-control @error('judul') is-invalid @enderror" 
                               placeholder="Masukkan judul aspirasi" value="{{ old('judul') }}" required>
                        @error('judul')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label fw-semibold">
                            <i class="fas fa-align-left me-2 text-primary"></i> Deskripsi <span class="text-danger">*</span>
                        </label>
                        <textarea name="deskripsi" rows="5" class="form-control @error('deskripsi') is-invalid @enderror" 
                                  placeholder="Jelaskan secara detail aspirasi Anda..." required>{{ old('deskripsi') }}</textarea>
                        @error('deskripsi')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-semibold">
                                <i class="fas fa-map-marker-alt me-2 text-primary"></i> Lokasi
                            </label>
                            <input type="text" name="lokasi" class="form-control @error('lokasi') is-invalid @enderror" 
                                   placeholder="Contoh: Ruang Kelas X IPA" value="{{ old('lokasi') }}">
                            @error('lokasi')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-semibold">
                                <i class="fas fa-flag me-2 text-primary"></i> Prioritas <span class="text-danger">*</span>
                            </label>
                            <select name="prioritas" class="form-select @error('prioritas') is-invalid @enderror" required>
                                <option value="rendah" {{ old('prioritas') == 'rendah' ? 'selected' : '' }}>Rendah</option>
                                <option value="sedang" {{ old('prioritas') == 'sedang' ? 'selected' : '' }} selected>Sedang</option>
                                <option value="tinggi" {{ old('prioritas') == 'tinggi' ? 'selected' : '' }}>Tinggi</option>
                            </select>
                            @error('prioritas')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label fw-semibold">
                            <i class="fas fa-image me-2 text-primary"></i> Foto Pendukung
                        </label>
                        <input type="file" name="foto" class="form-control @error('foto') is-invalid @enderror" accept="image/*">
                        <small class="text-muted">Format: JPG, PNG, JPEG (Max 2MB)</small>
                        @error('foto')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary-custom">
                            <i class="fas fa-paper-plane me-2"></i> Kirim Aspirasi
                        </button>
                        <a href="{{ route('aspirasi.index') }}" class="btn btn-outline-secondary">
                            <i class="fas fa-arrow-left me-2"></i> Kembali
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
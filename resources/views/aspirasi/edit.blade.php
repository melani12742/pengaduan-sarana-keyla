@extends('layouts.app')

@section('title', 'Edit Aspirasi')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="card-custom p-4">
                    <h2 class="fw-bold mb-4">
                        <i class="fas fa-edit text-primary me-2"></i>
                        Edit Aspirasi
                    </h2>

                    <form action="{{ route('aspirasi.update', $aspirasi) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label class="form-label fw-semibold">Kategori <span class="text-danger">*</span></label>
                            <select name="kategori_id" class="form-select @error('kategori_id') is-invalid @enderror"
                                required>
                                @foreach($kategoris as $kategori)
                                    <option value="{{ $kategori->id }}" {{ $aspirasi->kategori_id == $kategori->id ? 'selected' : '' }}>
                                        {{ $kategori->nama_kategori }}
                                    </option>
                                @endforeach
                            </select>
                            @error('kategori_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold">Judul <span class="text-danger">*</span></label>
                            <input type="text" name="judul" class="form-control @error('judul') is-invalid @enderror"
                                value="{{ old('judul', $aspirasi->judul) }}" required>
                            @error('judul')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold">Deskripsi <span class="text-danger">*</span></label>
                            <textarea name="deskripsi" rows="5"
                                class="form-control @error('deskripsi') is-invalid @enderror"
                                required>{{ old('deskripsi', $aspirasi->deskripsi) }}</textarea>
                            @error('deskripsi')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-semibold">Lokasi</label>
                                <input type="text" name="lokasi" class="form-control"
                                    value="{{ old('lokasi', $aspirasi->lokasi) }}">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-semibold">Prioritas <span class="text-danger">*</span></label>
                                <select name="prioritas" class="form-select @error('prioritas') is-invalid @enderror"
                                    required>
                                    <option value="rendah" {{ $aspirasi->prioritas == 'rendah' ? 'selected' : '' }}>Rendah
                                    </option>
                                    <option value="sedang" {{ $aspirasi->prioritas == 'sedang' ? 'selected' : '' }}>Sedang
                                    </option>
                                    <option value="tinggi" {{ $aspirasi->prioritas == 'tinggi' ? 'selected' : '' }}>Tinggi
                                    </option>
                                </select>
                                @error('prioritas')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold">Foto Pendukung</label>
                            @if($aspirasi->foto)
                                <div class="mb-2">
                                    <img src="{{ asset('storage/' . $aspirasi->foto) }}" alt="Foto saat ini"
                                        style="max-height: 100px;" class="rounded">
                                </div>
                            @endif
                            <input type="file" name="foto" class="form-control @error('foto') is-invalid @enderror"
                                accept="image/*">
                            <small class="text-muted">Kosongkan jika tidak ingin mengganti foto</small>
                            @error('foto')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary-custom">
                                <i class="fas fa-save me-2"></i> Update Aspirasi
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
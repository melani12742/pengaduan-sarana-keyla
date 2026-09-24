@extends('layouts.app')

@section('title', 'Buat Aspirasi')

@section('header', 'Buat Aspirasi Baru')

@section('actions')
    <a href="{{ route('aspirasi.index') }}" class="btn-outline-modern">
        <i class="fas fa-arrow-left"></i> Kembali
    </a>
@endsection

@section('content')
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card-modern">
                <form action="{{ route('aspirasi.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    {{-- NISN & KELAS --}}
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label
                                style="font-size: 13px; font-weight: 600; color: var(--text-gray); margin-bottom: 8px; display: block;">
                                <i class="fas fa-id-card me-1" style="color: var(--primary);"></i> NISN <span
                                    class="text-danger">*</span>
                            </label>
                            <input type="text" name="nisn" class="form-control @error('nisn') is-invalid @enderror"
                                style="padding: 12px 18px; border: 2px solid var(--border); border-radius: 12px; background: var(--bg-alt); font-size: 14px;"
                                placeholder="Nomor Induk Siswa" value="{{ old('nisn', Auth::user()->nisn ?? '') }}"
                                maxlength="20" required>
                            @error('nisn')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        {{-- ✅ KELAS - INPUT TEXT (BUKAN DROPDOWN) --}}
                        <div class="col-md-6 mb-3">
                            <label
                                style="font-size: 13px; font-weight: 600; color: var(--text-gray); margin-bottom: 8px; display: block;">
                                <i class="fas fa-school me-1" style="color: var(--primary);"></i> Kelas <span
                                    class="text-danger">*</span>
                            </label>
                            <input type="text" name="kelas" class="form-control @error('kelas') is-invalid @enderror"
                                style="padding: 12px 18px; border: 2px solid var(--border); border-radius: 12px; background: var(--bg-alt); font-size: 14px;"
                                placeholder="Contoh: XII RPL 2" value="{{ old('kelas', Auth::user()->kelas ?? '') }}"
                                maxlength="50" required>
                            @error('kelas')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>

                    {{-- KATEGORI --}}
                    <div class="mb-3">
                        <label
                            style="font-size: 13px; font-weight: 600; color: var(--text-gray); margin-bottom: 8px; display: block;">
                            <i class="fas fa-tag me-1" style="color: var(--primary);"></i> Kategori <span
                                class="text-danger">*</span>
                        </label>
                        <select name="category_id" class="form-control @error('category_id') is-invalid @enderror"
                            style="padding: 12px 18px; border: 2px solid var(--border); border-radius: 12px; background: var(--bg-alt); font-size: 14px;"
                            required>
                            <option value="">-- Pilih Kategori --</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                    {{ $category->nama_kategori }}
                                </option>
                            @endforeach
                        </select>
                        @error('category_id')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    {{-- JUDUL --}}
                    <div class="mb-3">
                        <label
                            style="font-size: 13px; font-weight: 600; color: var(--text-gray); margin-bottom: 8px; display: block;">
                            <i class="fas fa-heading me-1" style="color: var(--primary);"></i> Judul Aspirasi <span
                                class="text-danger">*</span>
                        </label>
                        <input type="text" name="judul" class="form-control @error('judul') is-invalid @enderror"
                            style="padding: 12px 18px; border: 2px solid var(--border); border-radius: 12px; background: var(--bg-alt); font-size: 14px;"
                            placeholder="Masukkan judul aspirasi" value="{{ old('judul') }}" required>
                        @error('judul')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    {{-- DESKRIPSI --}}
                    <div class="mb-3">
                        <label
                            style="font-size: 13px; font-weight: 600; color: var(--text-gray); margin-bottom: 8px; display: block;">
                            <i class="fas fa-align-left me-1" style="color: var(--primary);"></i> Deskripsi <span
                                class="text-danger">*</span>
                        </label>
                        <textarea name="deskripsi" rows="5" class="form-control @error('deskripsi') is-invalid @enderror"
                            style="padding: 12px 18px; border: 2px solid var(--border); border-radius: 12px; background: var(--bg-alt); font-size: 14px;"
                            placeholder="Jelaskan secara detail aspirasi Anda..." required>{{ old('deskripsi') }}</textarea>
                        @error('deskripsi')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    {{-- LOKASI & PRIORITAS --}}
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label
                                style="font-size: 13px; font-weight: 600; color: var(--text-gray); margin-bottom: 8px; display: block;">
                                <i class="fas fa-map-marker-alt me-1" style="color: var(--primary);"></i> Lokasi
                            </label>
                            <input type="text" name="lokasi" class="form-control"
                                style="padding: 12px 18px; border: 2px solid var(--border); border-radius: 12px; background: var(--bg-alt); font-size: 14px;"
                                placeholder="Contoh: Ruang Kelas X RPL 1" value="{{ old('lokasi') }}">
                        </div>

                        <div class="col-md-6 mb-3">
                            <label
                                style="font-size: 13px; font-weight: 600; color: var(--text-gray); margin-bottom: 8px; display: block;">
                                <i class="fas fa-flag me-1" style="color: var(--primary);"></i> Prioritas <span
                                    class="text-danger">*</span>
                            </label>
                            <select name="prioritas" class="form-control"
                                style="padding: 12px 18px; border: 2px solid var(--border); border-radius: 12px; background: var(--bg-alt); font-size: 14px;"
                                required>
                                <option value="rendah" {{ old('prioritas') == 'rendah' ? 'selected' : '' }}>🔵 Rendah</option>
                                <option value="sedang" {{ old('prioritas') == 'sedang' ? 'selected' : '' }}>🟡 Sedang</option>
                                <option value="tinggi" {{ old('prioritas') == 'tinggi' ? 'selected' : '' }}>🟠 Tinggi</option>
                                <option value="urgent" {{ old('prioritas') == 'urgent' ? 'selected' : '' }}>🔴 Urgent</option>
                            </select>
                        </div>
                    </div>

                    {{-- FOTO --}}
                    <div class="mb-3">
                        <label
                            style="font-size: 13px; font-weight: 600; color: var(--text-gray); margin-bottom: 8px; display: block;">
                            <i class="fas fa-image me-1" style="color: var(--primary);"></i> Foto Bukti Kerusakan
                        </label>
                        <input type="file" name="foto" class="form-control"
                            style="padding: 12px 18px; border: 2px solid var(--border); border-radius: 12px; background: var(--bg-alt); font-size: 14px;"
                            accept="image/*" id="fotoInput">
                        <small style="color: var(--text-gray); font-size: 12px;">Format: JPG, PNG, JPEG (Max 2MB)</small>

                        <div id="previewContainer" class="mt-2" style="display: none;">
                            <img id="previewImage" src="" alt="Preview" style="max-height: 200px; border-radius: 12px;">
                        </div>
                    </div>

                    {{-- ANONIM --}}
                    <div class="mb-3 p-3 rounded" style="background: var(--bg-alt); border: 1px solid var(--border);">
                        <div class="form-check">
                            <input type="checkbox" name="is_anonymous" id="is_anonymous" class="form-check-input" value="1"
                                style="accent-color: var(--primary);" {{ old('is_anonymous') ? 'checked' : '' }}>
                            <label for="is_anonymous" class="form-check-label"
                                style="color: var(--text-gray); font-size: 14px;">
                                <i class="fas fa-user-secret me-1" style="color: var(--primary);"></i>
                                <strong>Kirim sebagai Anonim</strong>
                                <br>
                                <small style="font-size: 12px;">Nama Anda tidak akan ditampilkan ke publik.</small>
                            </label>
                        </div>
                    </div>

                    {{-- TOMBOL --}}
                    <div class="d-flex gap-3 mt-4">
                        <button type="submit" class="btn-primary-modern">
                            <i class="fas fa-paper-plane"></i> Kirim Aspirasi
                        </button>
                        <a href="{{ route('aspirasi.index') }}" class="btn-outline-modern">
                            <i class="fas fa-times"></i> Batal
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        document.getElementById('fotoInput').addEventListener('change', function (e) {
            const file = e.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function (event) {
                    document.getElementById('previewImage').src = event.target.result;
                    document.getElementById('previewContainer').style.display = 'block';
                };
                reader.readAsDataURL(file);
            }
        });
    </script>
@endsection
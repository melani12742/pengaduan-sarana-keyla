@extends('layouts.app')

@section('title', 'Semua Aspirasi')

@section('header', 'Semua Aspirasi')

@section('actions')
    <a href="{{ route('dashboard') }}" class="btn-outline-gold">
        <i class="fas fa-arrow-left me-2"></i> Kembali ke Dashboard
    </a>
@endsection

@section('content')
    <div class="container-fluid">
        <div class="card-gold">
            <div class="table-responsive">
                <table class="table" style="color: var(--text-gray);">
                    <thead>
                        <tr style="border-bottom: 1px solid var(--gold-dark);">
                            <th>No</th>
                            <th>Judul</th>
                            <th>User</th>
                            <th>Kategori</th>
                            <th>Status</th>
                            <th>Prioritas</th>
                            <th>Tanggal</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($aspirasis as $key => $aspirasi)
                            <tr>
                                <td>{{ $aspirasis->firstItem() + $key }}</td>
                                <td>{{ $aspirasi->judul }}</td>
                                <td>{{ $aspirasi->user->name ?? 'Unknown' }}</td>
                                <td>{{ $aspirasi->category->nama_kategori ?? 'N/A' }}</td>
                                <td>
                                    <span class="badge bg-{{ $aspirasi->status_badge }}">
                                        {{ $aspirasi->status_label }}
                                    </span>
                                </td>
                                <td>
                                    <span
                                        class="badge bg-{{ $aspirasi->prioritas === 'tinggi' || $aspirasi->prioritas === 'urgent' ? 'danger' : ($aspirasi->prioritas === 'sedang' ? 'warning' : 'secondary') }}">
                                        {{ ucfirst($aspirasi->prioritas) }}
                                    </span>
                                </td>
                                <td>{{ $aspirasi->created_at->format('d/m/Y H:i') }}</td>
                                <td>
                                    {{-- Lihat Detail --}}
                                    <a href="{{ route('aspirasi.show', $aspirasi) }}" class="btn btn-sm"
                                        style="color: var(--gold); border-color: var(--gold-dark);" title="Lihat Detail">
                                        <i class="fas fa-eye"></i>
                                    </a>

                                    {{-- Umpan Balik (ADMIN ONLY) --}}
                                    @if(Auth::user()->role === 'admin')
                                        <button type="button" class="btn btn-sm"
                                            style="color: var(--info); border-color: var(--gold-dark);" data-bs-toggle="modal"
                                            data-bs-target="#umpanBalikModal{{ $aspirasi->id }}" title="Beri Umpan Balik">
                                            <i class="fas fa-reply"></i>
                                        </button>
                                    @endif

                                    {{-- Edit --}}
                                    <a href="{{ route('aspirasi.edit', $aspirasi) }}" class="btn btn-sm"
                                        style="color: var(--warning); border-color: var(--gold-dark);" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>

                                    {{-- Hapus --}}
                                    <form action="{{ route('aspirasi.destroy', $aspirasi) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm"
                                            style="color: var(--danger); border-color: var(--gold-dark);"
                                            onclick="return confirm('Yakin ingin menghapus aspirasi ini?')" title="Hapus">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>

                            {{-- MODAL UMPAN BALIK --}}
                            @if(Auth::user()->role === 'admin')
                                <div class="modal fade" id="umpanBalikModal{{ $aspirasi->id }}" tabindex="-1" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content"
                                            style="background: var(--bg-card); border: 1px solid var(--gold-dark);">
                                            <div class="modal-header" style="border-bottom: 1px solid var(--gold-dark);">
                                                <h5 class="modal-title" style="color: var(--gold);">
                                                    <i class="fas fa-reply me-2"></i>
                                                    Umpan Balik: {{ $aspirasi->judul }}
                                                </h5>
                                                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                            </div>
                                            <form action="{{ route('umpan-balik.store', $aspirasi) }}" method="POST"
                                                enctype="multipart/form-data">
                                                @csrf
                                                <div class="modal-body">
                                                    {{-- Info Aspirasi --}}
                                                    <div class="mb-3 p-3 rounded" style="background: var(--bg-card-hover);">
                                                        <div class="row">
                                                            <div class="col-6">
                                                                <small style="color: var(--text-gray);">Pelapor:</small>
                                                                <div style="color: var(--text-white);">
                                                                    {{ $aspirasi->display_name }}
                                                                </div>
                                                            </div>
                                                            <div class="col-6">
                                                                <small style="color: var(--text-gray);">Status:</small>
                                                                <div>
                                                                    <span class="badge bg-{{ $aspirasi->status_badge }}">
                                                                        {{ $aspirasi->status_label }}
                                                                    </span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    {{-- Textarea Umpan Balik --}}
                                                    <div class="mb-3">
                                                        <label for="isi_umpan_balik_{{ $aspirasi->id }}" class="form-label"
                                                            style="color: var(--text-gray);">
                                                            <i class="fas fa-pen me-2 text-gold"></i>
                                                            Tulis Umpan Balik Manual <span class="text-danger">*</span>
                                                        </label>
                                                        <textarea name="isi_umpan_balik" id="isi_umpan_balik_{{ $aspirasi->id }}"
                                                            rows="4" class="form-control form-control-gold"
                                                            placeholder="Contoh: Terima kasih sudah memberikan aspirasi. Kami akan segera menindaklanjuti laporan ini..."
                                                            required></textarea>
                                                        <small style="color: var(--text-gray);">
                                                            <i class="fas fa-info-circle me-1"></i>
                                                            Tulis manual, bukan bot/otomatis.
                                                        </small>
                                                    </div>

                                                    {{-- Jenis Umpan Balik --}}
                                                    <div class="mb-3">
                                                        <label for="jenis_{{ $aspirasi->id }}" class="form-label"
                                                            style="color: var(--text-gray);">
                                                            <i class="fas fa-tag me-2 text-gold"></i> Jenis
                                                        </label>
                                                        <select name="jenis" id="jenis_{{ $aspirasi->id }}"
                                                            class="form-select form-control-gold" required>
                                                            <option value="eksternal" selected>Eksternal (Untuk User)</option>
                                                            <option value="internal">Internal (Hanya Admin)</option>
                                                        </select>
                                                    </div>

                                                    {{-- Lampiran --}}
                                                    <div class="mb-3">
                                                        <label for="lampiran_{{ $aspirasi->id }}" class="form-label"
                                                            style="color: var(--text-gray);">
                                                            <i class="fas fa-paperclip me-2 text-gold"></i> Lampiran (Opsional)
                                                        </label>
                                                        <input type="file" name="lampiran" id="lampiran_{{ $aspirasi->id }}"
                                                            class="form-control form-control-gold" accept="image/*,.pdf">
                                                        <small style="color: var(--text-gray);">
                                                            Format: JPG, PNG, PDF (Max 2MB)
                                                        </small>
                                                    </div>
                                                </div>
                                                <div class="modal-footer" style="border-top: 1px solid var(--gold-dark);">
                                                    <button type="button" class="btn-outline-gold" data-bs-dismiss="modal">
                                                        Batal
                                                    </button>
                                                    <button type="submit" class="btn-gold">
                                                        <i class="fas fa-paper-plane me-2"></i> Kirim Umpan Balik
                                                    </button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            @endif

                        @empty
                            <tr>
                                <td colspan="8" class="text-center" style="color: var(--text-gray); padding: 40px 0;">
                                    <i class="fas fa-inbox"
                                        style="font-size: 40px; display: block; margin-bottom: 10px; opacity: 0.3;"></i>
                                    Belum ada aspirasi
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Pagination --}}
            @if($aspirasis->hasPages())
                <div class="mt-3">
                    {{ $aspirasis->links() }}
                </div>
            @endif
        </div>
    </div>
@endsection
@extends('layouts.app')

@section('title', 'Semua Aspirasi')

@section('header', 'Semua Aspirasi')

@section('actions')
    <a href="{{ route('dashboard') }}" class="btn-outline-modern">
        <i class="fas fa-arrow-left"></i> Kembali ke Dashboard
    </a>
@endsection

@section('content')
    <div class="card-modern">
        <div class="table-responsive">
            <table class="table-modern">
                <thead>
                    <tr>
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
                            <td style="font-weight: 600;">{{ $aspirasi->judul }}</td>
                            <td>{{ $aspirasi->user->name ?? 'Unknown' }}</td>
                            <td>{{ $aspirasi->category->nama_kategori ?? 'N/A' }}</td>
                            <td>
                                <span class="badge-modern badge-{{ $aspirasi->status }}">
                                    {{ $aspirasi->status_label }}
                                </span>
                            </td>
                            <td>
                                <span class="badge-modern"
                                    style="background: {{ $aspirasi->prioritas === 'tinggi' || $aspirasi->prioritas === 'urgent' ? '#FEE2E2' : ($aspirasi->prioritas === 'sedang' ? '#FEF3C7' : '#F3F4F6') }}; color: {{ $aspirasi->prioritas === 'tinggi' || $aspirasi->prioritas === 'urgent' ? '#991B1B' : ($aspirasi->prioritas === 'sedang' ? '#92400E' : '#6B5B6E') }};">
                                    {{ ucfirst($aspirasi->prioritas) }}
                                </span>
                            </td>
                            <td>{{ $aspirasi->created_at->format('d/m/Y H:i') }}</td>
                            <td>
                                {{-- Lihat Detail --}}
                                <a href="{{ route('aspirasi.show', $aspirasi) }}"
                                    style="display: inline-flex; align-items: center; justify-content: center; width: 36px; height: 36px; border-radius: 10px; border: 2px solid var(--border); color: var(--primary); background: var(--bg-white); text-decoration: none; transition: all 0.3s ease; margin-right: 4px;"
                                    onmouseover="this.style.background='var(--primary)'; this.style.color='white'; this.style.borderColor='var(--primary)'"
                                    onmouseout="this.style.background='var(--bg-white)'; this.style.color='var(--primary)'; this.style.borderColor='var(--border)'"
                                    title="Lihat Detail">
                                    <i class="fas fa-eye"></i>
                                </a>

                                {{-- ✅ UMPAN BALIK (ADMIN) — Ganti icon dari edit ke reply --}}
                                <button type="button"
                                    style="display: inline-flex; align-items: center; justify-content: center; width: 36px; height: 36px; border-radius: 10px; border: 2px solid var(--border); color: #3B82F6; background: var(--bg-white); cursor: pointer; transition: all 0.3s ease; margin-right: 4px;"
                                    onmouseover="this.style.background='#3B82F6'; this.style.color='white'; this.style.borderColor='#3B82F6'"
                                    onmouseout="this.style.background='var(--bg-white)'; this.style.color='#3B82F6'; this.style.borderColor='var(--border)'"
                                    data-bs-toggle="modal" data-bs-target="#umpanBalikModal{{ $aspirasi->id }}"
                                    title="Beri Umpan Balik">
                                    <i class="fas fa-reply"></i>
                                </button>

                                {{-- ✅ HAPUS TOMBOL EDIT — ADMIN TIDAK BOLEH EDIT LAPORAN SISWA --}}

                                {{-- Hapus --}}
                                <form action="{{ route('aspirasi.destroy', $aspirasi) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                        style="display: inline-flex; align-items: center; justify-content: center; width: 36px; height: 36px; border-radius: 10px; border: 2px solid var(--border); color: #EF4444; background: var(--bg-white); cursor: pointer; transition: all 0.3s ease;"
                                        onmouseover="this.style.background='#EF4444'; this.style.color='white'; this.style.borderColor='#EF4444'"
                                        onmouseout="this.style.background='var(--bg-white)'; this.style.color='#EF4444'; this.style.borderColor='var(--border)'"
                                        onclick="return confirm('Yakin ingin menghapus aspirasi ini?')" title="Hapus">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>

                        {{-- ============================================= --}}
                        {{-- MODAL UMPAN BALIK --}}
                        {{-- ============================================= --}}
                        <div class="modal fade" id="umpanBalikModal{{ $aspirasi->id }}" tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content"
                                    style="background: var(--bg-white); border: 1px solid var(--border); border-radius: 20px;">
                                    <div class="modal-header" style="border-bottom: 1px solid var(--border); padding: 20px;">
                                        <h5 class="modal-title" style="color: var(--primary); font-weight: 700;">
                                            <i class="fas fa-reply me-2"></i>
                                            Umpan Balik
                                        </h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>
                                    <form action="{{ route('umpan-balik.store', $aspirasi) }}" method="POST"
                                        enctype="multipart/form-data">
                                        @csrf
                                        <div class="modal-body" style="padding: 20px;">
                                            {{-- Info Aspirasi --}}
                                            <div
                                                style="padding: 16px; border-radius: 12px; background: var(--bg-alt); margin-bottom: 20px;">
                                                <div class="row">
                                                    <div class="col-6">
                                                        <small style="color: var(--text-gray); font-size: 12px;">Judul:</small>
                                                        <div
                                                            style="color: var(--text-dark); font-weight: 600; font-size: 14px;">
                                                            {{ $aspirasi->judul }}
                                                        </div>
                                                    </div>
                                                    <div class="col-6">
                                                        <small
                                                            style="color: var(--text-gray); font-size: 12px;">Pelapor:</small>
                                                        <div
                                                            style="color: var(--text-dark); font-weight: 600; font-size: 14px;">
                                                            {{ $aspirasi->display_name }}
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            {{-- Textarea Umpan Balik --}}
                                            <div class="mb-3">
                                                <label for="isi_umpan_balik_{{ $aspirasi->id }}"
                                                    style="font-size: 13px; font-weight: 600; color: var(--text-gray); margin-bottom: 8px; display: block;">
                                                    <i class="fas fa-pen me-1" style="color: var(--primary);"></i>
                                                    Tulis Umpan Balik Manual <span style="color: #EF4444;">*</span>
                                                </label>
                                                <textarea name="isi_umpan_balik" id="isi_umpan_balik_{{ $aspirasi->id }}"
                                                    rows="4"
                                                    style="padding: 12px 18px; border: 2px solid var(--border); border-radius: 12px; background: var(--bg-alt); font-size: 14px; width: 100%;"
                                                    placeholder="Contoh: Terima kasih sudah memberikan aspirasi. Kami akan segera menindaklanjuti laporan ini..."
                                                    required></textarea>
                                                <small style="color: var(--text-gray); font-size: 12px;">
                                                    <i class="fas fa-info-circle me-1"></i>
                                                    Tulis manual, bukan bot/otomatis.
                                                </small>
                                            </div>

                                            {{-- Jenis --}}
                                            <div class="mb-3">
                                                <label for="jenis_{{ $aspirasi->id }}"
                                                    style="font-size: 13px; font-weight: 600; color: var(--text-gray); margin-bottom: 8px; display: block;">
                                                    <i class="fas fa-tag me-1" style="color: var(--primary);"></i> Jenis
                                                </label>
                                                <select name="jenis" id="jenis_{{ $aspirasi->id }}"
                                                    style="padding: 12px 18px; border: 2px solid var(--border); border-radius: 12px; background: var(--bg-alt); font-size: 14px; width: 100%;"
                                                    required>
                                                    <option value="eksternal" selected>Eksternal (Untuk User)</option>
                                                    <option value="internal">Internal (Hanya Admin)</option>
                                                </select>
                                            </div>

                                            {{-- Lampiran --}}
                                            <div class="mb-3">
                                                <label for="lampiran_{{ $aspirasi->id }}"
                                                    style="font-size: 13px; font-weight: 600; color: var(--text-gray); margin-bottom: 8px; display: block;">
                                                    <i class="fas fa-paperclip me-1" style="color: var(--primary);"></i>
                                                    Lampiran (Opsional)
                                                </label>
                                                <input type="file" name="lampiran" id="lampiran_{{ $aspirasi->id }}"
                                                    style="padding: 12px 18px; border: 2px solid var(--border); border-radius: 12px; background: var(--bg-alt); font-size: 14px; width: 100%;"
                                                    accept="image/*,.pdf">
                                                <small style="color: var(--text-gray); font-size: 12px;">Format: JPG, PNG, PDF
                                                    (Max 2MB)</small>
                                            </div>
                                        </div>
                                        <div class="modal-footer" style="border-top: 1px solid var(--border); padding: 20px;">
                                            <button type="button" class="btn-outline-modern" data-bs-dismiss="modal">
                                                Batal
                                            </button>
                                            <button type="submit" class="btn-primary-modern">
                                                <i class="fas fa-paper-plane"></i> Kirim Umpan Balik
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center" style="padding: 40px 0; color: var(--text-gray);">
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
            <div class="mt-4">
                {{ $aspirasis->links() }}
            </div>
        @endif
    </div>
@endsection
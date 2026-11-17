@extends('layouts.app')

@section('title', 'Detail Aspirasi')

@section('header', 'Detail Aspirasi')

@section('actions')
    <a href="{{ route('aspirasi.index') }}" class="btn-outline-modern">
        <i class="fas fa-arrow-left"></i> Kembali
    </a>
@endsection

@section('content')
    <div class="row">
        {{-- KOLOM KIRI --}}
        <div class="col-lg-8">

            {{-- CARD UTAMA --}}
            <div class="card-modern mb-4">
                <div class="d-flex justify-content-between align-items-start mb-3">
                    <h3 style="color: var(--text-dark); margin: 0; font-weight: 700;">{{ $aspirasi->judul }}</h3>
                    <span class="badge-modern badge-{{ $aspirasi->status }}">
                        {{ $aspirasi->status_label }}
                    </span>
                </div>

                {{-- FOTO BUKTI --}}
                @if($aspirasi->foto)
                    <div class="mb-3">
                        <img src="{{ $aspirasi->foto_url }}" alt="Foto Bukti"
                            style="max-height: 400px; width: 100%; object-fit: cover; border-radius: 16px;">
                    </div>
                @endif

                {{-- INFO --}}
                <table class="table" style="color: var(--text-gray); margin-bottom: 0;">
                    <tr>
                        <th width="150" style="border: none; padding: 8px 0; color: var(--text-gray); font-weight: 600;">
                            Kategori</th>
                        <td style="border: none; padding: 8px 0; color: var(--text-dark);">
                            {{ $aspirasi->category->nama_kategori ?? 'N/A' }}</td>
                    </tr>
                    <tr>
                        <th style="border: none; padding: 8px 0; color: var(--text-gray); font-weight: 600;">Prioritas</th>
                        <td style="border: none; padding: 8px 0;">
                            <span class="badge-modern"
                                style="background: {{ $aspirasi->prioritas === 'tinggi' || $aspirasi->prioritas === 'urgent' ? '#FEE2E2' : ($aspirasi->prioritas === 'sedang' ? '#FEF3C7' : '#F3F4F6') }}; color: {{ $aspirasi->prioritas === 'tinggi' || $aspirasi->prioritas === 'urgent' ? '#991B1B' : ($aspirasi->prioritas === 'sedang' ? '#92400E' : '#6B5B6E') }};">
                                {{ ucfirst($aspirasi->prioritas) }}
                            </span>
                        </td>
                    </tr>
                    <tr>
                        <th style="border: none; padding: 8px 0; color: var(--text-gray); font-weight: 600;">Lokasi</th>
                        <td style="border: none; padding: 8px 0; color: var(--text-dark);">{{ $aspirasi->lokasi ?? '-' }}
                        </td>
                    </tr>
                    <tr>
                        <th style="border: none; padding: 8px 0; color: var(--text-gray); font-weight: 600;">Pelapor</th>
                        <td style="border: none; padding: 8px 0; color: var(--text-dark);">
                            {{ $aspirasi->display_name }}
                            @if($aspirasi->is_anonymous)
                                <span class="badge-modern ms-2" style="background: #F3F4F6; color: #6B5B6E;">
                                    <i class="fas fa-user-secret"></i> Anonim
                                </span>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th style="border: none; padding: 8px 0; color: var(--text-gray); font-weight: 600;">NISN</th>
                        <td style="border: none; padding: 8px 0; color: var(--text-dark);">{{ $aspirasi->nisn_display }}
                        </td>
                    </tr>
                    <tr>
                        <th style="border: none; padding: 8px 0; color: var(--text-gray); font-weight: 600;">Kelas</th>
                        <td style="border: none; padding: 8px 0; color: var(--text-dark);">{{ $aspirasi->kelas_display }}
                        </td>
                    </tr>
                    <tr>
                        <th style="border: none; padding: 8px 0; color: var(--text-gray); font-weight: 600;">Tanggal</th>
                        <td style="border: none; padding: 8px 0; color: var(--text-dark);">
                            {{ $aspirasi->created_at->format('d/m/Y H:i') }}</td>
                    </tr>
                    @if($aspirasi->tanggal_selesai)
                        <tr>
                            <th style="border: none; padding: 8px 0; color: var(--text-gray); font-weight: 600;">Selesai</th>
                            <td style="border: none; padding: 8px 0; color: var(--text-dark);">
                                {{ $aspirasi->tanggal_selesai->format('d/m/Y H:i') }}</td>
                        </tr>
                    @endif
                </table>

                {{-- DESKRIPSI --}}
                <div class="mt-3 pt-3" style="border-top: 1px solid var(--border);">
                    <h5 style="color: var(--text-dark); font-weight: 700; font-size: 16px;">Deskripsi</h5>
                    <p style="color: var(--text-gray); margin: 0;">{{ $aspirasi->deskripsi }}</p>
                </div>

                {{-- TOMBOL UPVOTE --}}
                <div class="mt-4 d-flex gap-2 flex-wrap">
                    <button class="btn-primary-modern" id="upvoteBtn" onclick="toggleUpvote({{ $aspirasi->id }})">
                        <i class="fas fa-thumbs-up"></i>
                        <span id="upvoteText">{{ $isUpvoted ? 'Batalkan Dukungan' : 'Dukung Aspirasi' }}</span>
                        (<span id="upvoteCount">{{ $aspirasi->upvotes_count }}</span>)
                    </button>

                    {{-- ✅ EDIT: HANYA PEMILIK (SISWA) & STATUS MASIH MENUNGGU --}}
                    @if(Auth::id() === $aspirasi->user_id && $aspirasi->status === 'menunggu')
                        <a href="{{ route('aspirasi.edit', $aspirasi) }}" class="btn-outline-modern">
                            <i class="fas fa-edit"></i> Edit
                        </a>
                    @endif

                    {{-- ✅ HAPUS: Admin BOLEH (moderasi), Pemilik BOLEH --}}
                    @if(Auth::user()->role === 'admin' || Auth::id() === $aspirasi->user_id)
                        <form action="{{ route('aspirasi.destroy', $aspirasi) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn-outline-modern" style="color: #EF4444; border-color: #EF4444;"
                                onclick="return confirm('Yakin ingin menghapus aspirasi ini?')">
                                <i class="fas fa-trash"></i> Hapus
                            </button>
                        </form>
                    @endif
                </div>
            </div>

            {{-- ============================================= --}}
            {{-- UMPAN BALIK MANUAL DARI ADMIN --}}
            {{-- ============================================= --}}
            <div class="card-modern mb-4">
                <h5 style="color: var(--text-dark); font-weight: 700; margin-bottom: 8px;">
                    <i class="fas fa-reply" style="color: var(--primary);"></i>
                    Umpan Balik dari Admin
                    <span class="badge-modern ms-2" style="background: var(--secondary); color: var(--primary);">
                        {{ $aspirasi->umpanBalik->count() }}
                    </span>
                </h5>
                <p style="color: var(--text-gray); font-size: 13px; margin-bottom: 16px;">
                    <i class="fas fa-info-circle me-1"></i>
                    Admin akan menjawab secara manual, bukan bot/otomatis.
                </p>

                {{-- LIST UMPAN BALIK --}}
                <div>
                    @forelse($aspirasi->umpanBalik as $umpan)
                        <div
                            style="padding: 16px; margin-bottom: 12px; border-radius: 12px; background: var(--bg-alt); border-left: 3px solid var(--primary);">
                            <div class="d-flex justify-content-between align-items-start mb-2">
                                <div>
                                    <strong style="color: var(--primary);">
                                        <i class="fas fa-user-shield me-1"></i>
                                        {{ $umpan->admin->name ?? 'Admin' }}
                                    </strong>
                                    <small style="color: var(--text-gray);">
                                        • {{ $umpan->created_at->format('d/m/Y H:i') }}
                                    </small>
                                    <span class="badge-modern ms-2"
                                        style="background: {{ $umpan->jenis === 'internal' ? '#F3F4F6' : '#DBEAFE' }}; color: {{ $umpan->jenis === 'internal' ? '#6B5B6E' : '#1E40AF' }};">
                                        {{ ucfirst($umpan->jenis ?? 'internal') }}
                                    </span>
                                </div>
                                @if(Auth::id() === $umpan->admin_id)
                                    <form action="{{ route('umpan-balik.destroy', $umpan) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            style="color: #EF4444; border: none; background: transparent; cursor: pointer;"
                                            onclick="return confirm('Hapus umpan balik ini?')">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                @endif
                            </div>
                            <p style="color: var(--text-dark); margin: 0;">{{ $umpan->isi_umpan_balik }}</p>

                            @if($umpan->lampiran)
                                <div class="mt-2">
                                    <a href="{{ asset('storage/' . $umpan->lampiran) }}" target="_blank" class="btn-outline-modern"
                                        style="padding: 6px 12px; font-size: 12px;">
                                        <i class="fas fa-paperclip"></i> Lihat Lampiran
                                    </a>
                                </div>
                            @endif
                        </div>
                    @empty
                        <div class="text-center py-4" style="color: var(--text-gray);">
                            <i class="fas fa-comment-slash" style="font-size: 40px; opacity: 0.3;"></i>
                            <p class="mt-2" style="margin: 0;">Belum ada umpan balik dari admin</p>
                        </div>
                    @endforelse
                </div>

                {{-- FORM UMPAN BALIK (HANYA ADMIN) --}}
                @if(Auth::user()->role === 'admin')
                    <hr style="border-color: var(--border); margin: 20px 0;">
                    <form action="{{ route('umpan-balik.store', $aspirasi) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-3">
                            <label for="isi_umpan_balik"
                                style="font-size: 13px; font-weight: 600; color: var(--text-gray); margin-bottom: 8px; display: block;">
                                <i class="fas fa-pen me-1" style="color: var(--primary);"></i>
                                Tulis Umpan Balik Manual
                            </label>
                            <textarea name="isi_umpan_balik" id="isi_umpan_balik" rows="4"
                                class="form-control @error('isi_umpan_balik') is-invalid @enderror"
                                style="padding: 12px 18px; border: 2px solid var(--border); border-radius: 12px; background: var(--bg-alt); font-size: 14px;"
                                placeholder="Contoh: Terima kasih sudah memberikan aspirasi. Kami akan segera menindaklanjuti laporan ini."
                                required>{{ old('isi_umpan_balik') }}</textarea>
                            @error('isi_umpan_balik')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                            <small style="color: var(--text-gray); font-size: 12px;">
                                <i class="fas fa-info-circle me-1"></i>
                                Pesan ini ditulis manual oleh admin, bukan bot.
                            </small>
                        </div>

                        {{-- JENIS --}}
                        <div class="mb-3">
                            <label for="jenis"
                                style="font-size: 13px; font-weight: 600; color: var(--text-gray); margin-bottom: 8px; display: block;">
                                <i class="fas fa-tag me-1" style="color: var(--primary);"></i> Jenis Umpan Balik
                            </label>
                            <select name="jenis" id="jenis"
                                style="padding: 12px 18px; border: 2px solid var(--border); border-radius: 12px; background: var(--bg-alt); font-size: 14px; width: 100%;"
                                required>
                                <option value="internal">Internal (Hanya Admin)</option>
                                <option value="eksternal" selected>Eksternal (Untuk User)</option>
                            </select>
                        </div>

                        {{-- LAMPIRAN --}}
                        <div class="mb-3">
                            <label for="lampiran"
                                style="font-size: 13px; font-weight: 600; color: var(--text-gray); margin-bottom: 8px; display: block;">
                                <i class="fas fa-paperclip me-1" style="color: var(--primary);"></i> Lampiran (Opsional)
                            </label>
                            <input type="file" name="lampiran" id="lampiran"
                                style="padding: 12px 18px; border: 2px solid var(--border); border-radius: 12px; background: var(--bg-alt); font-size: 14px; width: 100%;"
                                accept="image/*,.pdf">
                            <small style="color: var(--text-gray); font-size: 12px;">Format: JPG, PNG, PDF (Max 2MB)</small>
                        </div>

                        <button type="submit" class="btn-primary-modern">
                            <i class="fas fa-paper-plane"></i> Kirim Umpan Balik
                        </button>
                    </form>
                @endif
            </div>

            {{-- ============================================= --}}
            {{-- KOMENTAR / DISKUSI --}}
            {{-- ============================================= --}}
            <div class="card-modern">
                <h5 style="color: var(--text-dark); font-weight: 700; margin-bottom: 16px;">
                    <i class="fas fa-comments" style="color: var(--primary);"></i>
                    Diskusi ({{ $aspirasi->comments->count() }})
                </h5>

                {{-- LIST KOMENTAR --}}
                <div>
                    @forelse($aspirasi->comments as $comment)
                        <div style="padding: 16px; margin-bottom: 12px; border-radius: 12px; background: var(--bg-alt);">
                            <div class="d-flex justify-content-between mb-2">
                                <strong style="color: var(--primary);">
                                    <i class="fas fa-user me-1"></i>
                                    {{ $comment->display_name }}
                                </strong>
                                <small style="color: var(--text-gray);">
                                    {{ $comment->created_at->diffForHumans() }}
                                </small>
                            </div>
                            <p style="color: var(--text-dark); margin: 0;">{{ $comment->comment }}</p>
                        </div>
                    @empty
                        <p style="color: var(--text-gray); text-align: center; padding: 20px;">
                            <i class="fas fa-comment-slash"
                                style="font-size: 30px; opacity: 0.3; display: block; margin-bottom: 10px;"></i>
                            Belum ada diskusi
                        </p>
                    @endforelse
                </div>

                {{-- FORM KOMENTAR --}}
                <hr style="border-color: var(--border); margin: 20px 0;">
                <form action="{{ route('aspirasi.comment', $aspirasi) }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <textarea name="comment" rows="3" class="form-control @error('comment') is-invalid @enderror"
                            style="padding: 12px 18px; border: 2px solid var(--border); border-radius: 12px; background: var(--bg-alt); font-size: 14px;"
                            placeholder="Tulis komentar..." required>{{ old('comment') }}</textarea>
                        @error('comment')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="form-check mb-3">
                        <input type="checkbox" name="is_anonymous" id="is_anonymous_comment" class="form-check-input"
                            value="1" style="accent-color: var(--primary);">
                        <label for="is_anonymous_comment" class="form-check-label"
                            style="color: var(--text-gray); font-size: 14px;">
                            <i class="fas fa-user-secret me-1"></i> Kirim sebagai anonim
                        </label>
                    </div>
                    <button type="submit" class="btn-primary-modern">
                        <i class="fas fa-paper-plane"></i> Kirim Komentar
                    </button>
                </form>
            </div>
        </div>

        {{-- ============================================= --}}
        {{-- SIDEBAR KANAN (ADMIN) --}}
        {{-- ============================================= --}}
        <div class="col-lg-4">
            @if(Auth::user()->role === 'admin')
                {{-- KELOLA STATUS --}}
                <div class="card-modern mb-4">
                    <h5 style="color: var(--text-dark); font-weight: 700; margin-bottom: 16px;">
                        <i class="fas fa-cog" style="color: var(--primary);"></i>
                        Kelola Status
                    </h5>

                    <form action="{{ route('aspirasi.status', $aspirasi) }}" method="POST">
                        @csrf

                        <div class="mb-3">
                            <label
                                style="font-size: 13px; font-weight: 600; color: var(--text-gray); margin-bottom: 8px; display: block;">Status
                                Pengaduan</label>
                            <select name="status"
                                style="padding: 12px 18px; border: 2px solid var(--border); border-radius: 12px; background: var(--bg-alt); font-size: 14px; width: 100%;"
                                required>
                                <option value="menunggu" {{ $aspirasi->status == 'menunggu' ? 'selected' : '' }}>⏳ Menunggu
                                </option>
                                <option value="ditinjau" {{ $aspirasi->status == 'ditinjau' ? 'selected' : '' }}>🔍 Ditinjau
                                </option>
                                <option value="dalam_perbaikan" {{ $aspirasi->status == 'dalam_perbaikan' ? 'selected' : '' }}>🔧
                                    Dalam Perbaikan</option>
                                <option value="selesai" {{ $aspirasi->status == 'selesai' ? 'selected' : '' }}>✅ Selesai</option>
                                <option value="ditolak" {{ $aspirasi->status == 'ditolak' ? 'selected' : '' }}>❌ Ditolak</option>
                            </select>
                        </div>

                        <button type="submit" class="btn-primary-modern w-100" style="justify-content: center;">
                            <i class="fas fa-save"></i> Simpan Status
                        </button>
                    </form>
                </div>

                {{-- NAVIGASI ADMIN --}}
                <div class="card-modern">
                    <h5 style="color: var(--text-dark); font-weight: 700; margin-bottom: 16px;">
                        <i class="fas fa-compass" style="color: var(--primary);"></i>
                        Navigasi Admin
                    </h5>
                    <div class="d-flex flex-column gap-2">
                        <a href="{{ route('admin.all-aspirasi') }}" class="btn-outline-modern">
                            <i class="fas fa-list"></i> Semua Aspirasi
                        </a>
                        <a href="{{ route('admin.users') }}" class="btn-outline-modern">
                            <i class="fas fa-users"></i> Kelola User
                        </a>
                        <a href="{{ route('admin.kategori.index') }}" class="btn-outline-modern">
                            <i class="fas fa-tags"></i> Kelola Kategori
                        </a>
                    </div>
                </div>
            @endif
        </div>
    </div>

    {{-- SCRIPT UPVOTE --}}
    <script>
        function toggleUpvote(aspirasiId) {
            fetch(`/aspirasi/${aspirasiId}/upvote`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }
            })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        document.getElementById('upvoteCount').textContent = data.upvotes_count;

                        const btnText = document.getElementById('upvoteText');
                        if (btnText.textContent === 'Dukung Aspirasi') {
                            btnText.textContent = 'Batalkan Dukungan';
                        } else {
                            btnText.textContent = 'Dukung Aspirasi';
                        }
                    }
                })
                .catch(error => console.error('Error:', error));
        }
    </script>
@endsection
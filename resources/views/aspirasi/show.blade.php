@extends('layouts.app')

@section('title', 'Detail Aspirasi')

@section('header', 'Detail Aspirasi')

@section('actions')
    <a href="{{ route('aspirasi.index') }}" class="btn-outline-gold">
        <i class="fas fa-arrow-left me-2"></i> Kembali
    </a>
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            {{-- KOLOM KIRI --}}
            <div class="col-lg-8">

                {{-- CARD UTAMA --}}
                <div class="card-gold mb-4">
                    <div class="d-flex justify-content-between align-items-start mb-3">
                        <h3 style="color: var(--text-white);">{{ $aspirasi->judul }}</h3>
                        <span class="badge bg-{{ $aspirasi->status_badge }}">
                            {{ $aspirasi->status_label }}
                        </span>
                    </div>

                    {{-- FOTO BUKTI --}}
                    @if($aspirasi->foto)
                        <div class="mb-3">
                            <img src="{{ $aspirasi->foto_url }}" alt="Foto Bukti" class="img-fluid rounded"
                                style="max-height: 400px; width: 100%; object-fit: cover;">
                        </div>
                    @endif
                    {{-- INFO --}}
                    <table class="table" style="color: var(--text-gray);">
                        <tr>
                            <th width="150">Kategori</th>
                            <td>{{ $aspirasi->category->nama_kategori ?? 'N/A' }}</td>
                        </tr>
                        <tr>
                            <th>Prioritas</th>
                            <td>
                                <span
                                    class="badge bg-{{ $aspirasi->prioritas === 'tinggi' || $aspirasi->prioritas === 'urgent' ? 'danger' : ($aspirasi->prioritas === 'sedang' ? 'warning' : 'secondary') }}">
                                    {{ ucfirst($aspirasi->prioritas) }}
                                </span>
                            </td>
                        </tr>
                        <tr>
                            <th>Lokasi</th>
                            <td>{{ $aspirasi->lokasi ?? '-' }}</td>
                        </tr>
                        <tr>
                            <th>Pelapor</th>
                            <td>
                                {{ $aspirasi->display_name }}
                                @if($aspirasi->is_anonymous)
                                    <span class="badge bg-secondary ms-2">
                                        <i class="fas fa-user-secret"></i> Anonim
                                    </span>
                                @endif
                            </td>
                        </tr>
                        {{-- ✅ NISN --}}
                        <tr>
                            <th>NISN</th>
                            <td>{{ $aspirasi->nisn_display }}</td>
                        </tr>
                        {{-- ✅ KELAS --}}
                        <tr>
                            <th>Kelas</th>
                            <td>{{ $aspirasi->kelas_display }}</td>
                        </tr>
                        <tr>
                            <th>Tanggal</th>
                            <td>{{ $aspirasi->created_at->format('d/m/Y H:i') }}</td>
                        </tr>
                        @if($aspirasi->tanggal_selesai)
                            <tr>
                                <th>Selesai</th>
                                <td>{{ $aspirasi->tanggal_selesai->format('d/m/Y H:i') }}</td>
                            </tr>
                        @endif
                    </table>

                    {{-- DESKRIPSI --}}
                    <div class="mt-3">
                        <h5 style="color: var(--text-white);">Deskripsi</h5>
                        <p style="color: var(--text-gray);">{{ $aspirasi->deskripsi }}</p>
                    </div>

                    {{-- TOMBOL UPVOTE --}}
                    <div class="mt-4 d-flex gap-2 flex-wrap">
                        <button class="btn-gold" id="upvoteBtn" onclick="toggleUpvote({{ $aspirasi->id }})">
                            <i class="fas fa-thumbs-up me-2"></i>
                            <span id="upvoteText">{{ $isUpvoted ? 'Batalkan Dukungan' : 'Dukung Aspirasi' }}</span>
                            (<span id="upvoteCount">{{ $aspirasi->upvotes_count }}</span>)
                        </button>

                        {{-- Tombol Edit (pemilik atau admin) --}}
                        @if(Auth::user()->role === 'admin' || Auth::id() === $aspirasi->user_id)
                            <a href="{{ route('aspirasi.edit', $aspirasi) }}" class="btn-outline-gold">
                                <i class="fas fa-edit me-2"></i> Edit
                            </a>
                        @endif

                        {{-- Tombol Hapus (pemilik atau admin) --}}
                        @if(Auth::user()->role === 'admin' || Auth::id() === $aspirasi->user_id)
                            <form action="{{ route('aspirasi.destroy', $aspirasi) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn-outline-gold"
                                    style="color: var(--danger); border-color: var(--danger);"
                                    onclick="return confirm('Yakin ingin menghapus aspirasi ini?')">
                                    <i class="fas fa-trash me-2"></i> Hapus
                                </button>
                            </form>
                        @endif
                    </div>
                </div>

                {{-- ============================================= --}}
                {{-- UMPAN BALIK MANUAL DARI ADMIN --}}
                {{-- ============================================= --}}
                <div class="card-gold mb-4">
                    <h5 style="color: var(--text-white);">
                        <i class="fas fa-reply text-gold me-2"></i>
                        Umpan Balik dari Admin
                        <span class="badge bg-secondary ms-2">{{ $aspirasi->umpanBalik->count() }}</span>
                    </h5>
                    <p style="color: var(--text-gray); font-size: 13px;">
                        <i class="fas fa-info-circle me-1"></i>
                        Admin akan menjawab secara manual, bukan bot/otomatis.
                    </p>

                    {{-- LIST UMPAN BALIK --}}
                    <div class="mt-3">
                        @forelse($aspirasi->umpanBalik as $umpan)
                            <div class="p-3 mb-3 rounded"
                                style="background: var(--bg-card-hover); border-left: 3px solid var(--gold);">
                                <div class="d-flex justify-content-between align-items-start mb-2">
                                    <div>
                                        <strong style="color: var(--gold);">
                                            <i class="fas fa-user-shield me-1"></i>
                                            {{ $umpan->admin->name ?? 'Admin' }}
                                        </strong>
                                        <small style="color: var(--text-gray);">
                                            • {{ $umpan->created_at->format('d/m/Y H:i') }}
                                        </small>
                                        {{-- Jenis Badge --}}
                                        <span class="badge bg-{{ $umpan->jenis === 'internal' ? 'secondary' : 'info' }} ms-2">
                                            {{ ucfirst($umpan->jenis ?? 'internal') }}
                                        </span>
                                    </div>
                                    @if(Auth::id() === $umpan->admin_id)
                                        <form action="{{ route('umpan-balik.destroy', $umpan) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm"
                                                style="color: var(--danger); border: none; background: transparent;"
                                                onclick="return confirm('Hapus umpan balik ini?')">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    @endif
                                </div>

                                {{-- ISI UMPAN BALIK --}}
                                <p style="color: var(--text-white); margin: 0;">{{ $umpan->isi_umpan_balik }}</p>

                                {{-- LAMPIRAN --}}
                                @if($umpan->lampiran)
                                    <div class="mt-2">
                                        <a href="{{ asset('storage/' . $umpan->lampiran) }}" target="_blank"
                                            class="btn btn-sm btn-outline-gold">
                                            <i class="fas fa-paperclip me-1"></i> Lihat Lampiran
                                        </a>
                                    </div>
                                @endif
                            </div>
                        @empty
                            <div class="text-center py-4" style="color: var(--text-gray);">
                                <i class="fas fa-comment-slash" style="font-size: 40px; opacity: 0.3;"></i>
                                <p class="mt-2">Belum ada umpan balik dari admin</p>
                            </div>
                        @endforelse
                    </div>

                    {{-- FORM UMPAN BALIK (HANYA ADMIN) --}}
                    @if(Auth::user()->role === 'admin')
                        <hr style="border-color: var(--gold-dark);">
                        <form action="{{ route('umpan-balik.store', $aspirasi) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="mb-3">
                                <label for="isi_umpan_balik" class="form-label" style="color: var(--text-gray);">
                                    <i class="fas fa-pen me-2 text-gold"></i>
                                    Tulis Umpan Balik Manual
                                </label>
                                <textarea name="isi_umpan_balik" id="isi_umpan_balik" rows="4"
                                    class="form-control form-control-gold @error('isi_umpan_balik') is-invalid @enderror"
                                    placeholder="Contoh: Terima kasih sudah memberikan aspirasi. Kami akan segera menindaklanjuti laporan ini."
                                    required>{{ old('isi_umpan_balik') }}</textarea>
                                @error('isi_umpan_balik')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <small style="color: var(--text-gray);">
                                    <i class="fas fa-info-circle me-1"></i>
                                    Pesan ini ditulis manual oleh admin, bukan bot.
                                </small>
                            </div>

                            {{-- JENIS --}}
                            <div class="mb-3">
                                <label for="jenis" class="form-label" style="color: var(--text-gray);">
                                    <i class="fas fa-tag me-2 text-gold"></i> Jenis Umpan Balik
                                </label>
                                <select name="jenis" id="jenis" class="form-select form-control-gold" required>
                                    <option value="internal">Internal (Hanya Admin)</option>
                                    <option value="eksternal" selected>Eksternal (Untuk User)</option>
                                </select>
                            </div>

                            {{-- LAMPIRAN --}}
                            <div class="mb-3">
                                <label for="lampiran" class="form-label" style="color: var(--text-gray);">
                                    <i class="fas fa-paperclip me-2 text-gold"></i> Lampiran (Opsional)
                                </label>
                                <input type="file" name="lampiran" id="lampiran" class="form-control form-control-gold"
                                    accept="image/*,.pdf">
                                <small style="color: var(--text-gray);">Format: JPG, PNG, PDF (Max 2MB)</small>
                            </div>

                            <button type="submit" class="btn-gold">
                                <i class="fas fa-paper-plane me-2"></i> Kirim Umpan Balik
                            </button>
                        </form>
                    @endif
                </div>

                {{-- ============================================= --}}
                {{-- KOMENTAR / DISKUSI --}}
                {{-- ============================================= --}}
                <div class="card-gold">
                    <h5 style="color: var(--text-white);">
                        <i class="fas fa-comments text-gold me-2"></i>
                        Diskusi ({{ $aspirasi->comments->count() }})
                    </h5>

                    {{-- LIST KOMENTAR --}}
                    <div class="mt-3">
                        @forelse($aspirasi->comments as $comment)
                            <div class="p-3 mb-3 rounded" style="background: var(--bg-card-hover);">
                                <div class="d-flex justify-content-between mb-2">
                                    <strong style="color: var(--gold);">
                                        <i class="fas fa-user me-1"></i>
                                        {{ $comment->display_name }}
                                    </strong>
                                    <small style="color: var(--text-gray);">
                                        {{ $comment->created_at->diffForHumans() }}
                                    </small>
                                </div>
                                <p style="color: var(--text-white); margin: 0;">{{ $comment->comment }}</p>
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
                    <hr style="border-color: var(--gold-dark);">
                    <form action="{{ route('aspirasi.comment', $aspirasi) }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <textarea name="comment" rows="3"
                                class="form-control form-control-gold @error('comment') is-invalid @enderror"
                                placeholder="Tulis komentar..." required>{{ old('comment') }}</textarea>
                            @error('comment')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-check mb-3">
                            <input type="checkbox" name="is_anonymous" id="is_anonymous_comment" class="form-check-input"
                                value="1">
                            <label for="is_anonymous_comment" class="form-check-label" style="color: var(--text-gray);">
                                <i class="fas fa-user-secret me-1"></i> Kirim sebagai anonim
                            </label>
                        </div>
                        <button type="submit" class="btn-gold">
                            <i class="fas fa-paper-plane me-2"></i> Kirim Komentar
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
                    <div class="card-gold mb-4">
                        <h5 style="color: var(--text-white);">
                            <i class="fas fa-cog text-gold me-2"></i>
                            Kelola Status
                        </h5>

                        <form action="{{ route('aspirasi.status', $aspirasi) }}" method="POST">
                            @csrf

                            <div class="mb-3">
                                <label class="form-label" style="color: var(--text-gray);">Status Pengaduan</label>
                                <select name="status" class="form-select form-control-gold" required>
                                    <option value="menunggu" {{ $aspirasi->status == 'menunggu' ? 'selected' : '' }}>⏳ Menunggu
                                    </option>
                                    <option value="ditinjau" {{ $aspirasi->status == 'ditinjau' ? 'selected' : '' }}>🔍 Ditinjau
                                    </option>
                                    <option value="dalam_perbaikan" {{ $aspirasi->status == 'dalam_perbaikan' ? 'selected' : '' }}>🔧 Dalam Perbaikan</option>
                                    <option value="selesai" {{ $aspirasi->status == 'selesai' ? 'selected' : '' }}>✅ Selesai
                                    </option>
                                    <option value="ditolak" {{ $aspirasi->status == 'ditolak' ? 'selected' : '' }}>❌ Ditolak
                                    </option>
                                </select>
                            </div>

                            <button type="submit" class="btn-gold w-100">
                                <i class="fas fa-save me-2"></i> Simpan Status
                            </button>
                        </form>
                    </div>

                    {{-- NAVIGASI ADMIN --}}
                    <div class="card-gold">
                        <h5 style="color: var(--text-white);">
                            <i class="fas fa-compass text-gold me-2"></i>
                            Navigasi Admin
                        </h5>
                        <div class="d-flex flex-column gap-2">
                            <a href="{{ route('admin.all-aspirasi') }}" class="btn-outline-gold">
                                <i class="fas fa-list me-2"></i> Semua Aspirasi
                            </a>
                            <a href="{{ route('admin.users') }}" class="btn-outline-gold">
                                <i class="fas fa-users me-2"></i> Kelola User
                            </a>
                            <a href="{{ route('admin.kategori.index') }}" class="btn-outline-gold">
                                <i class="fas fa-tags me-2"></i> Kelola Kategori
                            </a>
                        </div>
                    </div>
                @endif
            </div>
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
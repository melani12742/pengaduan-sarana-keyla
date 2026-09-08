@extends('layouts.app')

@section('title', 'Detail Aspirasi')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-lg-8">
            <!-- Detail Aspirasi -->
            <div class="card-custom p-4 mb-4">
                <div class="d-flex justify-content-between align-items-start mb-3">
                    <div>
                        <span class="badge-status badge-{{ $aspirasi->status_badge }}">
                            {{ $aspirasi->status_label }}
                        </span>
                        <span class="badge bg-{{ $aspirasi->prioritas == 'tinggi' ? 'danger' : ($aspirasi->prioritas == 'sedang' ? 'warning' : 'info') }} ms-2">
                            Prioritas: {{ ucfirst($aspirasi->prioritas) }}
                        </span>
                    </div>
                    <small class="text-muted">
                        <i class="far fa-calendar-alt me-1"></i>
                        {{ $aspirasi->created_at->format('d F Y H:i') }}
                    </small>
                </div>
                
                <h3 class="fw-bold">{{ $aspirasi->judul }}</h3>
                
                <div class="mb-3">
                    <span class="badge bg-secondary">
                        <i class="fas {{ $aspirasi->kategori->icon ?? 'fa-tag' }} me-1"></i>
                        {{ $aspirasi->kategori->nama_kategori }}
                    </span>
                    @if($aspirasi->lokasi)
                        <span class="badge bg-info">
                            <i class="fas fa-map-marker-alt me-1"></i>
                            {{ $aspirasi->lokasi }}
                        </span>
                    @endif
                </div>
                
                <div class="mb-4">
                    <h6 class="fw-bold">Deskripsi:</h6>
                    <p class="text-muted">{{ $aspirasi->deskripsi }}</p>
                </div>
                
                @if($aspirasi->foto)
                    <div class="mb-3">
                        <h6 class="fw-bold">Foto Pendukung:</h6>
                        <img src="{{ asset('storage/' . $aspirasi->foto) }}" 
                             alt="Foto Aspirasi" 
                             class="img-fluid rounded" 
                             style="max-height: 300px;">
                    </div>
                @endif
                
                <div class="d-flex gap-2">
                    @if(auth()->user()->role == 'admin')
                        <form action="{{ route('aspirasi.status', $aspirasi) }}" method="POST" class="d-inline">
                            @csrf
                            <select name="status" class="form-select d-inline-block w-auto" onchange="this.form.submit()">
                                <option value="pending" {{ $aspirasi->status == 'pending' ? 'selected' : '' }}>Menunggu</option>
                                <option value="proses" {{ $aspirasi->status == 'proses' ? 'selected' : '' }}>Diproses</option>
                                <option value="selesai" {{ $aspirasi->status == 'selesai' ? 'selected' : '' }}>Selesai</option>
                                <option value="ditolak" {{ $aspirasi->status == 'ditolak' ? 'selected' : '' }}>Ditolak</option>
                            </select>
                        </form>
                    @endif
                    
                    @if(auth()->user()->id == $aspirasi->user_id && $aspirasi->status == 'pending')
                        <a href="{{ route('aspirasi.edit', $aspirasi) }}" class="btn btn-warning">
                            <i class="fas fa-edit me-1"></i> Edit
                        </a>
                    @endif
                    
                    <a href="{{ route('aspirasi.index') }}" class="btn btn-outline-secondary">
                        <i class="fas fa-arrow-left me-1"></i> Kembali
                    </a>
                </div>
            </div>
            
            <!-- Umpan Balik -->
            <div class="card-custom p-4">
                <h5 class="fw-bold mb-3">
                    <i class="fas fa-reply text-primary me-2"></i>
                    Umpan Balik
                </h5>
                
                @if($aspirasi->umpanBalik)
                    <div class="bg-light p-3 rounded-3">
                        <div class="d-flex align-items-center mb-2">
                            <div class="avatar me-2" style="width:32px;height:32px;font-size:12px;">
                                {{ strtoupper(substr($aspirasi->umpanBalik->admin->name ?? 'A', 0, 2)) }}
                            </div>
                            <div>
                                <strong>{{ $aspirasi->umpanBalik->admin->name ?? 'Admin' }}</strong>
                                <small class="text-muted ms-2">
                                    {{ $aspirasi->umpanBalik->created_at->format('d F Y H:i') }}
                                </small>
                                <span class="badge bg-{{ $aspirasi->umpanBalik->jenis == 'internal' ? 'info' : 'success' }} ms-2">
                                    {{ ucfirst($aspirasi->umpanBalik->jenis) }}
                                </span>
                            </div>
                        </div>
                        <p class="mb-2">{{ $aspirasi->umpanBalik->isi_umpan_balik }}</p>
                        @if($aspirasi->umpanBalik->lampiran)
                            <a href="{{ asset('storage/' . $aspirasi->umpanBalik->lampiran) }}" target="_blank" class="btn btn-sm btn-outline-primary">
                                <i class="fas fa-paperclip me-1"></i> Lihat Lampiran
                            </a>
                        @endif
                    </div>
                @elseif(auth()->user()->role == 'admin')
                    <form action="{{ route('umpan-balik.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="aspirasi_id" value="{{ $aspirasi->id }}">
                        
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Isi Umpan Balik</label>
                            <textarea name="isi_umpan_balik" rows="3" class="form-control" placeholder="Berikan umpan balik..." required></textarea>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-semibold">Jenis</label>
                                <select name="jenis" class="form-select">
                                    <option value="internal">Internal</option>
                                    <option value="eksternal">Eksternal</option>
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-semibold">Lampiran</label>
                                <input type="file" name="lampiran" class="form-control">
                            </div>
                        </div>
                        
                        <button type="submit" class="btn btn-primary-custom">
                            <i class="fas fa-paper-plane me-1"></i> Kirim Umpan Balik
                        </button>
                    </form>
                @else
                    <p class="text-muted text-center py-3">
                        <i class="fas fa-clock me-2"></i>
                        Belum ada umpan balik. Tunggu respon dari pihak sekolah.
                    </p>
                @endif
            </div>
        </div>
        
        <!-- Sidebar -->
        <div class="col-lg-4">
            <div class="card-custom p-4">
                <h6 class="fw-bold">
                    <i class="fas fa-user me-2 text-primary"></i>
                    Informasi Pengadu
                </h6>
                <div class="d-flex align-items-center mb-3">
                    <div class="avatar me-3" style="width:50px;height:50px;font-size:18px;">
                        {{ strtoupper(substr($aspirasi->user->name, 0, 2)) }}
                    </div>
                    <div>
                        <strong>{{ $aspirasi->user->name }}</strong>
                        <p class="text-muted small mb-0">{{ $aspirasi->user->email }}</p>
                    </div>
                </div>
                
                @if($aspirasi->user->no_telepon)
                    <p class="mb-1"><i class="fas fa-phone me-2 text-primary"></i> {{ $aspirasi->user->no_telepon }}</p>
                @endif
                @if($aspirasi->user->alamat)
                    <p class="mb-0"><i class="fas fa-home me-2 text-primary"></i> {{ $aspirasi->user->alamat }}</p>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
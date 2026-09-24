@extends('layouts.app')

@section('title', 'Dashboard Saya')

@section('header', 'Dashboard Saya')

@section('content')
<div class="row g-4 mb-4">
    {{-- TOTAL ASPIRASI --}}
    <div class="col-md-3">
        <div class="card-modern">
            <div class="d-flex justify-content-between align-items-start">
                <div>
                    <p style="font-size: 13px; color: var(--text-gray); margin: 0;">Total Aspirasi</p>
                    <h2 style="font-size: 32px; font-weight: 700; color: var(--primary); margin: 8px 0 0;">{{ $totalAspirasi ?? 0 }}</h2>
                </div>
                <div style="width: 48px; height: 48px; background: var(--secondary); border-radius: 12px; display: flex; align-items: center; justify-content: center; color: var(--primary); font-size: 20px;">
                    <i class="fas fa-clipboard-list"></i>
                </div>
            </div>
        </div>
    </div>

    {{-- MENUNGGU --}}
    <div class="col-md-3">
        <div class="card-modern">
            <div class="d-flex justify-content-between align-items-start">
                <div>
                    <p style="font-size: 13px; color: var(--text-gray); margin: 0;">Menunggu</p>
                    <h2 style="font-size: 32px; font-weight: 700; color: #F59E0B; margin: 8px 0 0;">{{ $menunggu ?? 0 }}</h2>
                </div>
                <div style="width: 48px; height: 48px; background: #FEF3C7; border-radius: 12px; display: flex; align-items: center; justify-content: center; color: #F59E0B; font-size: 20px;">
                    <i class="fas fa-clock"></i>
                </div>
            </div>
        </div>
    </div>

    {{-- DALAM PERBAIKAN --}}
    <div class="col-md-3">
        <div class="card-modern">
            <div class="d-flex justify-content-between align-items-start">
                <div>
                    <p style="font-size: 13px; color: var(--text-gray); margin: 0;">Dalam Perbaikan</p>
                    <h2 style="font-size: 32px; font-weight: 700; color: #3B82F6; margin: 8px 0 0;">{{ $dalamPerbaikan ?? 0 }}</h2>
                </div>
                <div style="width: 48px; height: 48px; background: #DBEAFE; border-radius: 12px; display: flex; align-items: center; justify-content: center; color: #3B82F6; font-size: 20px;">
                    <i class="fas fa-tools"></i>
                </div>
            </div>
        </div>
    </div>

    {{-- SELESAI --}}
    <div class="col-md-3">
        <div class="card-modern">
            <div class="d-flex justify-content-between align-items-start">
                <div>
                    <p style="font-size: 13px; color: var(--text-gray); margin: 0;">Selesai</p>
                    <h2 style="font-size: 32px; font-weight: 700; color: #10B981; margin: 8px 0 0;">{{ $selesai ?? 0 }}</h2>
                </div>
                <div style="width: 48px; height: 48px; background: #D1FAE5; border-radius: 12px; display: flex; align-items: center; justify-content: center; color: #10B981; font-size: 20px;">
                    <i class="fas fa-check-circle"></i>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- TABEL ASPIRASI --}}
<div class="card-modern">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h5 style="margin: 0; font-weight: 700;">Aspirasi Saya</h5>
        <a href="{{ route('aspirasi.create') }}" class="btn-primary-modern" style="padding: 8px 16px; font-size: 13px;">
            <i class="fas fa-plus"></i> Buat Aspirasi
        </a>
    </div>

    <div class="table-responsive">
        <table class="table-modern">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Judul</th>
                    <th>Kategori</th>
                    <th>Status</th>
                    <th>Tanggal</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($recentAspirasis ?? [] as $key => $aspirasi)
                    <tr>
                        <td>{{ $key + 1 }}</td>
                        <td style="font-weight: 600;">{{ $aspirasi->judul }}</td>
                        <td>{{ $aspirasi->category->nama_kategori ?? 'N/A' }}</td>
                        <td>
                            <span class="badge-modern badge-{{ $aspirasi->status }}">
                                {{ $aspirasi->status_label }}
                            </span>
                        </td>
                        <td>{{ $aspirasi->created_at->format('d/m/Y') }}</td>
                        <td>
                            <a href="{{ route('aspirasi.show', $aspirasi) }}" class="btn-outline-modern" style="padding: 6px 12px; font-size: 12px;">
                                Detail
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center" style="padding: 40px; color: var(--text-gray);">
                            Anda belum membuat aspirasi
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
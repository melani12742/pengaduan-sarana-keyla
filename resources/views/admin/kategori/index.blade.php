@extends('layouts.app')

@section('title', 'Kelola Kategori')

@section('header', 'Kelola Kategori')

@section('actions')
    <a href="{{ route('admin.kategori.create') }}" class="btn-gold">
        <i class="fas fa-plus-circle me-2"></i> Tambah Kategori
    </a>
    <a href="{{ route('dashboard') }}" class="btn-outline-gold">
        <i class="fas fa-arrow-left me-2"></i> Kembali
    </a>
@endsection

@section('content')
    <div class="container-fluid">
        @if(session('success'))
            <div class="alert-custom alert-success">
                <i class="fas fa-check-circle"></i> {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="alert-custom alert-danger">
                <i class="fas fa-exclamation-circle"></i> {{ session('error') }}
            </div>
        @endif

        <div class="card-gold">
            <div class="table-responsive">
                <table class="table" style="color: var(--text-gray);">
                    <thead>
                        <tr style="border-bottom: 1px solid var(--gold-dark);">
                            <th>No</th>
                            <th>Nama Kategori</th>
                            <th>Icon</th>
                            <th>Total Aspirasi</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($kategoris as $key => $kategori)
                            <tr>
                                <td>{{ $key + 1 }}</td>
                                <td>{{ $kategori->nama_kategori }}</td>
                                <td>
                                    @if($kategori->icon)
                                        <i class="fas {{ $kategori->icon }}" style="color: var(--gold); font-size: 20px;"></i>
                                    @else
                                        <span style="color: var(--text-gray);">-</span>
                                    @endif
                                </td>
                                <td>{{ $kategori->aspirasis_count ?? $kategori->aspirasis()->count() }}</td>
                                <td>
                                    <a href="{{ route('admin.kategori.edit', $kategori) }}" class="btn btn-sm"
                                        style="color: var(--gold); border-color: var(--gold-dark);">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('admin.kategori.destroy', $kategori) }}" method="POST"
                                        class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm"
                                            style="color: var(--danger); border-color: var(--gold-dark);"
                                            onclick="return confirm('Yakin ingin menghapus kategori ini?')">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center" style="color: var(--text-gray); padding: 40px 0;">
                                    <i class="fas fa-tags"
                                        style="font-size: 40px; display: block; margin-bottom: 10px; opacity: 0.3;"></i>
                                    Belum ada kategori
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
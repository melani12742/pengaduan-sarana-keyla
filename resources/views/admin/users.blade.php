@extends('layouts.app')

@section('title', 'Kelola User')

@section('header', 'Kelola User')

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
                            <th>Nama</th>
                            <th>Email</th>
                            <th>Role</th>
                            <th>Total Aspirasi</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($users as $key => $user)
                            <tr>
                                <td>{{ $key + 1 }}</td>
                                <td>{{ $user->name }}</td>
                                <td>{{ $user->email }}</td>
                                <td>
                                    <span class="badge bg-{{ $user->role === 'admin' ? 'danger' : 'primary' }}">
                                        {{ $user->role }}
                                    </span>
                                </td>
                                <td>{{ $user->aspirasis_count ?? 0 }}</td>
                                <td>
                                    @if($user->id !== auth()->id())
                                        <form action="{{ route('admin.toggle-role', $user) }}" method="POST" class="d-inline">
                                            @csrf
                                            <button type="submit" class="btn btn-sm"
                                                style="color: var(--gold); border-color: var(--gold-dark);">
                                                <i class="fas fa-exchange-alt"></i>
                                            </button>
                                        </form>
                                        <form action="{{ route('admin.delete-user', $user) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm"
                                                style="color: var(--danger); border-color: var(--gold-dark);"
                                                onclick="return confirm('Yakin ingin menghapus user ini?')">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    @else
                                        <span class="text-muted">Anda sendiri</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center" style="color: var(--text-gray); padding: 40px 0;">
                                    <i class="fas fa-users"
                                        style="font-size: 40px; display: block; margin-bottom: 10px; opacity: 0.3;"></i>
                                    Belum ada user
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
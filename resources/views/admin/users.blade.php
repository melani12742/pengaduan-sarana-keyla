@extends('layouts.app')

@section('title', 'Kelola User - Admin')

@section('content')
    <div class="container-fluid">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h2 class="fw-bold">
                    <i class="fas fa-users me-2 text-primary"></i>
                    Kelola User
                </h2>
                <p class="text-muted">Kelola semua pengguna aplikasi</p>
            </div>
        </div>

        <div class="card-custom p-0 overflow-hidden">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="bg-light">
                        <tr>
                            <th>#</th>
                            <th>Nama</th>
                            <th>Email</th>
                            <th>Role</th>
                            <th>No. Telepon</th>
                            <th>Total Aspirasi</th>
                            <th>Tanggal Daftar</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($users as $user)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $user->name }}</td>
                                <td>{{ $user->email }}</td>
                                <td>
                                    <span
                                        class="badge bg-{{ $user->role == 'admin' ? 'danger' : ($user->role == 'guest' ? 'warning' : 'info') }}">
                                        {{ ucfirst($user->role) }}
                                    </span>
                                </td>
                                <td>{{ $user->no_telepon ?? '-' }}</td>
                                <td>{{ $user->aspirasis_count }}</td>
                                <td>{{ $user->created_at->format('d/m/Y') }}</td>
                                <td>
                                    <div class="btn-group btn-group-sm">
                                        <form action="{{ route('admin.toggle-role', $user) }}" method="POST" class="d-inline">
                                            @csrf
                                            <button type="submit" class="btn btn-outline-warning"
                                                onclick="return confirm('Ubah role user ini?')">
                                                <i class="fas fa-exchange-alt"></i>
                                            </button>
                                        </form>
                                        <form action="{{ route('admin.delete-user', $user) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-outline-danger delete-confirm">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center py-4">
                                    <i class="fas fa-users fa-2x text-muted mb-2 d-block"></i>
                                    <p class="text-muted mb-0">Tidak ada user terdaftar</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <div class="mt-3">
            {{ $users->links() }}
        </div>
    </div>
@endsection
@extends('layouts.landing')

@section('title', 'Register')

@section('content')
    <div class="container py-5">
        <div class="row justify-content-center align-items-center" style="min-height: 90vh;">
            <div class="col-lg-6">
                <div class="card-modern" style="padding: 50px 40px;">
                    <div class="text-center mb-4">
                        <div
                            style="width: 70px; height: 70px; background: var(--primary); border-radius: 20px; display: flex; align-items: center; justify-content: center; margin: 0 auto 20px; color: white; font-size: 28px;">
                            <i class="fas fa-user-plus"></i>
                        </div>
                        <h2 style="color: var(--primary); font-weight: 700; margin-bottom: 8px;">Create Account</h2>
                        <p style="color: var(--text-gray); font-size: 14px;">Daftar untuk mulai melapor</p>
                    </div>

                    <form method="POST" action="{{ route('register') }}">
                        @csrf

                        {{-- NAMA & EMAIL --}}
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label
                                    style="font-size: 13px; font-weight: 600; color: var(--text-gray); margin-bottom: 8px; display: block;">
                                    <i class="fas fa-user me-1" style="color: var(--primary);"></i> Nama Lengkap
                                </label>
                                <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                                    style="padding: 14px 20px; border: 2px solid var(--border); border-radius: 12px; background: var(--bg-alt); font-size: 14px;"
                                    placeholder="Nama Anda" value="{{ old('name') }}" required autofocus>
                                @error('name')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label
                                    style="font-size: 13px; font-weight: 600; color: var(--text-gray); margin-bottom: 8px; display: block;">
                                    <i class="fas fa-envelope me-1" style="color: var(--primary);"></i> Email
                                </label>
                                <input type="email" name="email" class="form-control @error('email') is-invalid @enderror"
                                    style="padding: 14px 20px; border: 2px solid var(--border); border-radius: 12px; background: var(--bg-alt); font-size: 14px;"
                                    placeholder="email@sekolah.com" value="{{ old('email') }}" required>
                                @error('email')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>

                        {{-- NISN & KELAS --}}
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label
                                    style="font-size: 13px; font-weight: 600; color: var(--text-gray); margin-bottom: 8px; display: block;">
                                    <i class="fas fa-id-card me-1" style="color: var(--primary);"></i> NISN
                                </label>
                                <input type="text" name="nisn" class="form-control @error('nisn') is-invalid @enderror"
                                    style="padding: 14px 20px; border: 2px solid var(--border); border-radius: 12px; background: var(--bg-alt); font-size: 14px;"
                                    placeholder="Nomor Induk Siswa" value="{{ old('nisn') }}" maxlength="20" required>
                                @error('nisn')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            {{-- ✅ KELAS - INPUT TEXT (BUKAN DROPDOWN) --}}
                            <div class="col-md-6 mb-3">
                                <label
                                    style="font-size: 13px; font-weight: 600; color: var(--text-gray); margin-bottom: 8px; display: block;">
                                    <i class="fas fa-school me-1" style="color: var(--primary);"></i> Kelas
                                </label>
                                <input type="text" name="kelas" class="form-control @error('kelas') is-invalid @enderror"
                                    style="padding: 14px 20px; border: 2px solid var(--border); border-radius: 12px; background: var(--bg-alt); font-size: 14px;"
                                    placeholder="Contoh: XII RPL 2" value="{{ old('kelas') }}" maxlength="50" required>
                                @error('kelas')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>

                        {{-- PASSWORD --}}
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label
                                    style="font-size: 13px; font-weight: 600; color: var(--text-gray); margin-bottom: 8px; display: block;">
                                    <i class="fas fa-lock me-1" style="color: var(--primary);"></i> Password
                                </label>
                                <input type="password" name="password"
                                    class="form-control @error('password') is-invalid @enderror"
                                    style="padding: 14px 20px; border: 2px solid var(--border); border-radius: 12px; background: var(--bg-alt); font-size: 14px;"
                                    placeholder="Minimal 8 karakter" required>
                                @error('password')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label
                                    style="font-size: 13px; font-weight: 600; color: var(--text-gray); margin-bottom: 8px; display: block;">
                                    <i class="fas fa-lock me-1" style="color: var(--primary);"></i> Konfirmasi Password
                                </label>
                                <input type="password" name="password_confirmation" class="form-control"
                                    style="padding: 14px 20px; border: 2px solid var(--border); border-radius: 12px; background: var(--bg-alt); font-size: 14px;"
                                    placeholder="Ulangi password" required>
                            </div>
                        </div>

                        <button type="submit" class="btn-primary-modern w-100"
                            style="justify-content: center; padding: 14px;">
                            <i class="fas fa-user-plus"></i> Daftar Sekarang
                        </button>

                        <div class="text-center mt-4">
                            <p style="color: var(--text-gray); font-size: 14px; margin: 0;">
                                Sudah punya akun?
                                <a href="{{ route('login') }}"
                                    style="color: var(--primary); font-weight: 600; text-decoration: none;">
                                    Login
                                </a>
                            </p>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
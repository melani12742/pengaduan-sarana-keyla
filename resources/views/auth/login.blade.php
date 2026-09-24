@extends('layouts.landing')

@section('title', 'Login')

@section('content')
    <div class="container py-5">
        <div class="row justify-content-center align-items-center" style="min-height: 80vh;">
            <div class="col-lg-5">
                <div class="card-modern" style="padding: 50px 40px;">
                    <div class="text-center mb-4">
                        <div
                            style="width: 70px; height: 70px; background: var(--primary); border-radius: 20px; display: flex; align-items: center; justify-content: center; margin: 0 auto 20px; color: white; font-size: 28px;">
                            <i class="fas fa-sign-in-alt"></i>
                        </div>
                        <h2 style="color: var(--primary); font-weight: 700; margin-bottom: 8px;">Welcome Back</h2>
                        <p style="color: var(--text-gray); font-size: 14px;">Login ke akun Anda</p>
                    </div>

                    @if(session('status'))
                        <div class="alert alert-success"
                            style="border-radius: 12px; font-size: 13px; background: #D1FAE5; border: 1px solid #10B981; color: #065F46;">
                            {{ session('status') }}
                        </div>
                    @endif

                    <form method="POST" action="{{ route('login') }}">
                        @csrf

                        <div class="mb-3">
                            <label
                                style="font-size: 13px; font-weight: 600; color: var(--text-gray); margin-bottom: 8px; display: block;">
                                Email
                            </label>
                            <input type="email" name="email" class="form-control @error('email') is-invalid @enderror"
                                style="padding: 14px 20px; border: 2px solid var(--border); border-radius: 12px; background: var(--bg-alt); font-size: 14px;"
                                placeholder="your@email.com" value="{{ old('email') }}" required autofocus>
                            @error('email')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label
                                style="font-size: 13px; font-weight: 600; color: var(--text-gray); margin-bottom: 8px; display: block;">
                                Password
                            </label>
                            <input type="password" name="password"
                                class="form-control @error('password') is-invalid @enderror"
                                style="padding: 14px 20px; border: 2px solid var(--border); border-radius: 12px; background: var(--bg-alt); font-size: 14px;"
                                placeholder="••••••••" required>
                            @error('password')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <label
                                style="font-size: 13px; color: var(--text-gray); display: flex; align-items: center; gap: 8px; cursor: pointer;">
                                <input type="checkbox" name="remember" style="accent-color: var(--primary);">
                                Ingat saya
                            </label>
                            @if (Route::has('password.request'))
                                <a href="{{ route('password.request') }}"
                                    style="color: var(--primary); font-size: 13px; font-weight: 600; text-decoration: none;">
                                    Lupa password?
                                </a>
                            @endif
                        </div>

                        <button type="submit" class="btn-primary-modern w-100"
                            style="justify-content: center; padding: 14px;">
                            <i class="fas fa-sign-in-alt"></i> Login
                        </button>

                        <div class="text-center mt-4">
                            <p style="color: var(--text-gray); font-size: 14px; margin: 0;">
                                Belum punya akun?
                                <a href="{{ route('register') }}"
                                    style="color: var(--primary); font-weight: 600; text-decoration: none;">
                                    Daftar Sekarang
                                </a>
                            </p>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
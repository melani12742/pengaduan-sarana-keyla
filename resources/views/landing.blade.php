@extends('layouts.landing')

@section('title', 'Pengaduan Sarana Sekolah')

@section('content')
    <div class="container py-5">
        {{-- HERO --}}
        <div class="row align-items-center" style="min-height: 80vh;">
            <div class="col-lg-6">
                <h1
                    style="font-size: 56px; font-weight: 700; color: var(--primary); line-height: 1.1; margin-bottom: 20px;">
                    Pengaduan<br>Sarana Sekolah
                </h1>
                <p style="font-size: 18px; color: var(--text-gray); margin-bottom: 30px; max-width: 500px;">
                    Sampaikan aspirasi, keluhan, dan masukan Anda terkait sarana dan prasarana sekolah dengan mudah dan
                    cepat.
                </p>
                <div class="d-flex gap-3 flex-wrap">
                    @guest
                        <a href="{{ route('register') }}" class="btn-primary-modern">
                            <i class="fas fa-user-plus"></i> Daftar Sekarang
                        </a>
                        <a href="{{ route('login') }}" class="btn-outline-modern">
                            <i class="fas fa-sign-in-alt"></i> Login
                        </a>
                    @else
                        <a href="{{ route('dashboard') }}" class="btn-primary-modern">
                            <i class="fas fa-chart-pie"></i> Ke Dashboard
                        </a>
                    @endguest
                </div>
            </div>
            <div class="col-lg-6 text-center">
                <div style="background: var(--secondary); border-radius: 30px; padding: 60px; position: relative;">
                    <i class="fas fa-school" style="font-size: 120px; color: var(--primary);"></i>
                    <h3 style="color: var(--primary); margin-top: 20px; font-weight: 700;">SMKN 8 JEMBER</h3>
                    <p style="color: var(--text-gray);">Bersama kita wujudkan perubahan</p>
                </div>
            </div>
        </div>

        {{-- FEATURES --}}
        <div class="py-5">
            <h2 class="text-center mb-5" style="font-size: 36px; font-weight: 700; color: var(--text-dark);">
                Keunggulan <span style="color: var(--primary);">Kami</span>
            </h2>

            <div class="row g-4">
                <div class="col-md-3">
                    <div class="card-modern text-center h-100">
                        <div
                            style="width: 70px; height: 70px; background: var(--secondary); border-radius: 20px; display: flex; align-items: center; justify-content: center; margin: 0 auto 20px; color: var(--primary); font-size: 28px;">
                            <i class="fas fa-bolt"></i>
                        </div>
                        <h5 style="font-weight: 700; color: var(--text-dark);">Cepat & Mudah</h5>
                        <p style="color: var(--text-gray); font-size: 14px; margin: 0;">Sampaikan aspirasi dalam hitungan
                            menit</p>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="card-modern text-center h-100">
                        <div
                            style="width: 70px; height: 70px; background: var(--secondary); border-radius: 20px; display: flex; align-items: center; justify-content: center; margin: 0 auto 20px; color: var(--primary); font-size: 28px;">
                            <i class="fas fa-eye"></i>
                        </div>
                        <h5 style="font-weight: 700; color: var(--text-dark);">Transparan</h5>
                        <p style="color: var(--text-gray); font-size: 14px; margin: 0;">Pantau status pengaduan real-time
                        </p>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="card-modern text-center h-100">
                        <div
                            style="width: 70px; height: 70px; background: var(--secondary); border-radius: 20px; display: flex; align-items: center; justify-content: center; margin: 0 auto 20px; color: var(--primary); font-size: 28px;">
                            <i class="fas fa-reply"></i>
                        </div>
                        <h5 style="font-weight: 700; color: var(--text-dark);">Umpan Balik</h5>
                        <p style="color: var(--text-gray); font-size: 14px; margin: 0;">Dapatkan respon dari pihak sekolah
                        </p>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="card-modern text-center h-100">
                        <div
                            style="width: 70px; height: 70px; background: var(--secondary); border-radius: 20px; display: flex; align-items: center; justify-content: center; margin: 0 auto 20px; color: var(--primary); font-size: 28px;">
                            <i class="fas fa-chart-line"></i>
                        </div>
                        <h5 style="font-weight: 700; color: var(--text-dark);">Terintegrasi</h5>
                        <p style="color: var(--text-gray); font-size: 14px; margin: 0;">Data terpusat dan mudah dikelola</p>
                    </div>
                </div>
            </div>
        </div>

        {{-- STATS --}}
        <div class="py-5">
            <div class="card-modern" style="background: var(--primary); color: white; border: none;">
                <div class="row text-center">
                    <div class="col-md-3">
                        <h2 style="font-size: 42px; font-weight: 700; color: white;">{{ \App\Models\Aspirasi::count() }}
                        </h2>
                        <p style="opacity: 0.9; margin: 0; color: white;">Total Aspirasi</p>
                    </div>
                    <div class="col-md-3">
                        <h2 style="font-size: 42px; font-weight: 700; color: white;">
                            {{ \App\Models\Aspirasi::where('status', 'selesai')->count() }}
                        </h2>
                        <p style="opacity: 0.9; margin: 0; color: white;">Selesai</p>
                    </div>
                    <div class="col-md-3">
                        <h2 style="font-size: 42px; font-weight: 700; color: white;">
                            {{ \App\Models\Aspirasi::where('status', 'dalam_perbaikan')->count() }}
                        </h2>
                        <p style="opacity: 0.9; margin: 0; color: white;">Dalam Perbaikan</p>
                    </div>
                    <div class="col-md-3">
                        <h2 style="font-size: 42px; font-weight: 700; color: white;">
                            {{ \App\Models\User::where('role', 'guest')->count() }}
                        </h2>
                        <p style="opacity: 0.9; margin: 0; color: white;">Pengguna</p>
                    </div>
                </div>
            </div>
        </div>

        {{-- CTA --}}
        <div class="py-5 text-center">
            <h2 style="font-size: 36px; font-weight: 700; color: var(--text-dark); margin-bottom: 20px;">
                Siap Membuat Perubahan?
            </h2>
            <p style="color: var(--text-gray); margin-bottom: 30px; font-size: 16px;">Bergabung dengan kami sekarang</p>
            <a href="{{ route('register') }}" class="btn-primary-modern" style="padding: 16px 40px; font-size: 16px;">
                <i class="fas fa-rocket"></i> Mulai Sekarang
            </a>
        </div>
    </div>
@endsection
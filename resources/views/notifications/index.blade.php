@extends('layouts.app')

@section('title', 'Notifikasi')

@section('header', 'Notifikasi')

@section('actions')
    @if($notifications->count() > 0)
        <form action="{{ route('notifications.read-all') }}" method="POST" class="d-inline">
            @csrf
            <button type="submit" class="btn-outline-modern">
                <i class="fas fa-check-double"></i> Tandai Semua Dibaca
            </button>
        </form>
    @endif
@endsection

@section('content')
    <div class="card-modern">
        @forelse($notifications as $notification)
            @php
                // Icon & warna berdasarkan type
                $iconConfig = [
                    'new_aspirasi' => ['icon' => 'fa-envelope', 'color' => '#3B82F6', 'bg' => '#DBEAFE', 'label' => 'Pengaduan Baru'],
                    'status_update' => ['icon' => 'fa-sync-alt', 'color' => '#F59E0B', 'bg' => '#FEF3C7', 'label' => 'Status Diperbarui'],
                    'new_comment' => ['icon' => 'fa-comment', 'color' => '#8B5CF6', 'bg' => '#EDE9FE', 'label' => 'Komentar Baru'],
                    'umpan_balik' => ['icon' => 'fa-reply', 'color' => '#10B981', 'bg' => '#D1FAE5', 'label' => 'Umpan Balik'],
                    'upvote' => ['icon' => 'fa-thumbs-up', 'color' => '#EF4444', 'bg' => '#FEE2E2', 'label' => 'Dukungan'],
                ];
                $config = $iconConfig[$notification->type] ?? ['icon' => 'fa-bell', 'color' => '#6B5B6E', 'bg' => '#F3F4F6', 'label' => 'Notifikasi'];
            @endphp

            <a href="{{ $notification->aspirasi_id ? route('notifications.read', $notification->id) : '#' }}" style="text-decoration: none; display: block; padding: 16px; border-radius: 12px; margin-bottom: 10px; 
                          background: {{ $notification->is_read ? 'var(--bg-white)' : 'var(--secondary)' }}; 
                          border: 1px solid var(--border); transition: all 0.3s ease;"
                onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 8px 20px rgba(106, 30, 85, 0.1)'"
                onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='none'">
                <div class="d-flex align-items-start gap-3">
                    {{-- Icon --}}
                    <div style="width: 45px; height: 45px; border-radius: 12px; background: {{ $config['bg'] }}; 
                                    display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                        <i class="fas {{ $config['icon'] }}" style="color: {{ $config['color'] }}; font-size: 18px;"></i>
                    </div>

                    {{-- Content --}}
                    <div style="flex: 1; min-width: 0;">
                        {{-- Label Jenis --}}
                        <span style="display: inline-block; font-size: 10px; font-weight: 600; text-transform: uppercase; 
                                         letter-spacing: 0.5px; padding: 2px 8px; border-radius: 20px;
                                         background: {{ $config['bg'] }}; color: {{ $config['color'] }}; margin-bottom: 6px;">
                            {{ $config['label'] }}
                        </span>

                        {{-- Pesan --}}
                        <p
                            style="margin: 0; color: var(--text-dark); font-size: 14px; font-weight: {{ $notification->is_read ? '500' : '600' }};">
                            {{ $notification->message }}
                        </p>

                        {{-- Judul Aspirasi (jika ada) --}}
                        @if($notification->aspirasi)
                            <div style="margin-top: 6px; font-size: 12px; color: var(--text-gray);">
                                <i class="fas fa-file-alt me-1"></i>
                                <strong>{{ $notification->aspirasi->judul }}</strong>
                                <span class="badge-modern badge-{{ $notification->aspirasi->status }}" style="margin-left: 8px;">
                                    {{ $notification->aspirasi->status_label }}
                                </span>
                            </div>
                        @endif

                        {{-- Waktu --}}
                        <small style="color: var(--text-gray); font-size: 12px; display: block; margin-top: 6px;">
                            <i class="fas fa-clock me-1"></i>
                            {{ $notification->created_at->diffForHumans() }}
                        </small>
                    </div>

                    {{-- Unread Dot --}}
                    @if(!$notification->is_read)
                        <div
                            style="width: 10px; height: 10px; background: var(--primary); border-radius: 50%; flex-shrink: 0; margin-top: 6px;">
                        </div>
                    @endif
                </div>
            </a>
        @empty
            <div class="text-center py-5" style="color: var(--text-gray);">
                <i class="fas fa-bell-slash" style="font-size: 48px; opacity: 0.3; display: block; margin-bottom: 15px;"></i>
                <p style="margin: 0; font-size: 16px;">Belum ada notifikasi</p>
                <small>Notifikasi akan muncul saat ada aktivitas</small>
            </div>
        @endforelse

        {{-- Pagination --}}
        @if($notifications->hasPages())
            <div class="mt-4">
                {{ $notifications->links() }}
            </div>
        @endif
    </div>
@endsection
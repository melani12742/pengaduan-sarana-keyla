<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    /**
     * Tampilkan semua notifikasi milik user yang login
     */
    public function index()
    {
        $notifications = Notification::where('user_id', Auth::id())
            ->with('aspirasi')
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        // Tandai semua sudah dibaca saat buka halaman
        Notification::where('user_id', Auth::id())
            ->where('is_read', false)
            ->update(['is_read' => true]);

        return view('notifications.index', compact('notifications'));
    }

    /**
     * ✅ Tandai 1 notifikasi sudah dibaca & redirect ke DETAIL PENGADUAN
     */
    public function markAsRead($id)
    {
        $notification = Notification::where('user_id', Auth::id())
            ->where('id', $id)
            ->first();

        if (!$notification) {
            return redirect()->route('notifications.index')
                ->with('error', 'Notifikasi tidak ditemukan.');
        }

        // Tandai sudah dibaca
        $notification->update(['is_read' => true]);

        // ✅ Redirect ke DETAIL PENGADUAN (jika ada)
        if ($notification->aspirasi_id) {
            return redirect()->route('aspirasi.show', $notification->aspirasi_id);
        }

        // Kalau tidak ada aspirasi, kembali ke halaman notifikasi
        return redirect()->route('notifications.index');
    }

    /**
     * Tandai semua notifikasi sebagai sudah dibaca
     */
    public function markAllAsRead()
    {
        Notification::where('user_id', Auth::id())
            ->where('is_read', false)
            ->update(['is_read' => true]);

        return redirect()->back()->with('success', 'Semua notifikasi ditandai sudah dibaca.');
    }

    /**
     * API: Ambil jumlah notifikasi belum dibaca
     */
    public function unreadCount()
    {
        $count = Notification::where('user_id', Auth::id())
            ->where('is_read', false)
            ->count();

        return response()->json(['count' => $count]);
    }
}
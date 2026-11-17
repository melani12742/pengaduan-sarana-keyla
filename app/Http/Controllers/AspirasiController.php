<?php

namespace App\Http\Controllers;

use App\Models\Aspirasi;
use App\Models\Category;
use App\Models\Upvote;
use App\Models\Comment;
use App\Models\Notification;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AspirasiController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        if ($user->role === 'admin') {
            $aspirasis = Aspirasi::with(['user', 'category'])
                ->orderBy('created_at', 'desc')
                ->paginate(10);
        } else {
            $aspirasis = Aspirasi::with(['user', 'category'])
                ->where('user_id', $user->id)
                ->orderBy('created_at', 'desc')
                ->paginate(10);
        }

        return view('aspirasi.index', compact('aspirasis'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('aspirasi.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'judul' => 'required|string|max:200',
            'category_id' => 'required|exists:categories,id',
            'deskripsi' => 'required|string|min:10',
            'lokasi' => 'nullable|string|max:255',
            'prioritas' => 'required|in:rendah,sedang,tinggi,urgent',
            'is_anonymous' => 'boolean',
            'foto' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'nisn' => 'required|string|max:20',
            'kelas' => 'required|string|max:50',
        ]);

        $fotoPath = null;
        if ($request->hasFile('foto')) {
            $fotoPath = $request->file('foto')->store('aspirasi', 'public');
        }

        $aspirasi = Aspirasi::create([
            'user_id' => Auth::id(),
            'nisn' => $validated['nisn'],
            'kelas' => $validated['kelas'],
            'category_id' => $validated['category_id'],
            'judul' => $validated['judul'],
            'deskripsi' => $validated['deskripsi'],
            'lokasi' => $validated['lokasi'] ?? null,
            'prioritas' => $validated['prioritas'],
            'is_anonymous' => $request->has('is_anonymous'),
            'foto' => $fotoPath,
            'status' => 'menunggu',
            'tanggal_aspirasi' => now(),
            'upvotes_count' => 0,
        ]);

        // ✅ Notifikasi ke SEMUA ADMIN (surat masuk)
        $admins = User::where('role', 'admin')->get();
        foreach ($admins as $admin) {
            Notification::create([
                'user_id' => $admin->id,
                'aspirasi_id' => $aspirasi->id,
                'type' => 'new_aspirasi',
                'message' => 'Surat masuk: "' . $aspirasi->judul . '" dari ' . (Auth::user()->is_anonymous ?? false ? 'Anonim' : Auth::user()->name),
                'is_read' => false,
            ]);
        }

        return redirect()->route('aspirasi.index')
            ->with('success', 'Aspirasi berhasil dikirim!');
    }

    public function show(Aspirasi $aspirasi)
    {
        $aspirasi->load(['user', 'category', 'comments.user', 'umpanBalik.admin']);

        $isUpvoted = Upvote::where('aspirasi_id', $aspirasi->id)
            ->where('user_id', Auth::id())
            ->exists();

        return view('aspirasi.show', compact('aspirasi', 'isUpvoted'));
    }

    /**
     * ✅ EDIT: HANYA PEMILIK (SISWA), BUKAN ADMIN
     * Admin TIDAK BOLEH edit laporan siswa
     */
    public function edit(Aspirasi $aspirasi)
    {
        // ✅ HANYA PEMILIK yang bisa edit — Admin TIDAK BOLEH!
        if (Auth::id() !== $aspirasi->user_id) {
            return redirect()->route('aspirasi.index')
                ->with('error', 'Admin tidak diizinkan mengedit laporan siswa!');
        }

        // Hanya bisa edit jika status masih 'menunggu'
        if ($aspirasi->status !== 'menunggu') {
            return redirect()->route('aspirasi.show', $aspirasi)
                ->with('error', 'Aspirasi yang sudah diproses tidak bisa diedit!');
        }

        $categories = Category::all();
        return view('aspirasi.edit', compact('aspirasi', 'categories'));
    }

    /**
     * ✅ UPDATE: HANYA PEMILIK (SISWA), BUKAN ADMIN
     */
    public function update(Request $request, Aspirasi $aspirasi)
    {
        // ✅ HANYA PEMILIK yang bisa update — Admin TIDAK BOLEH!
        if (Auth::id() !== $aspirasi->user_id) {
            return redirect()->route('aspirasi.index')
                ->with('error', 'Admin tidak diizinkan mengedit laporan siswa!');
        }

        // Hanya bisa update jika status masih 'menunggu'
        if ($aspirasi->status !== 'menunggu') {
            return redirect()->route('aspirasi.show', $aspirasi)
                ->with('error', 'Aspirasi yang sudah diproses tidak bisa diedit!');
        }

        $validated = $request->validate([
            'judul' => 'required|string|max:200',
            'category_id' => 'required|exists:categories,id',
            'deskripsi' => 'required|string|min:10',
            'lokasi' => 'nullable|string|max:255',
            'prioritas' => 'required|in:rendah,sedang,tinggi,urgent',
            'foto' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'nisn' => 'required|string|max:20',
            'kelas' => 'required|string|max:50',
        ]);

        if ($request->hasFile('foto')) {
            $fotoPath = $request->file('foto')->store('aspirasi', 'public');
            $validated['foto'] = $fotoPath;
        }

        $aspirasi->update($validated);

        return redirect()->route('aspirasi.show', $aspirasi)
            ->with('success', 'Aspirasi berhasil diperbarui!');
    }

    public function destroy(Aspirasi $aspirasi)
    {
        // Admin BOLEH hapus (untuk moderasi), pemilik juga boleh
        if (Auth::user()->role !== 'admin' && Auth::id() !== $aspirasi->user_id) {
            return redirect()->route('aspirasi.index')
                ->with('error', 'Anda tidak memiliki akses!');
        }

        $aspirasi->delete();

        return redirect()->route('aspirasi.index')
            ->with('success', 'Aspirasi berhasil dihapus!');
    }

    public function upvote(Aspirasi $aspirasi)
    {
        $existing = Upvote::where('aspirasi_id', $aspirasi->id)
            ->where('user_id', Auth::id())
            ->first();

        if ($existing) {
            $existing->delete();
            $aspirasi->decrement('upvotes_count');
            $message = 'Upvote dibatalkan';
        } else {
            Upvote::create([
                'aspirasi_id' => $aspirasi->id,
                'user_id' => Auth::id(),
            ]);
            $aspirasi->increment('upvotes_count');
            $message = 'Berhasil mendukung aspirasi ini!';

            // ✅ Notifikasi ke PEMILIK aspirasi (jika bukan dia sendiri)
            if ($aspirasi->user_id !== Auth::id()) {
                Notification::create([
                    'user_id' => $aspirasi->user_id,
                    'aspirasi_id' => $aspirasi->id,
                    'type' => 'upvote',
                    'message' => Auth::user()->name . ' mendukung pengaduan: ' . $aspirasi->judul,
                    'is_read' => false,
                ]);
            }
        }

        return response()->json([
            'success' => true,
            'message' => $message,
            'upvotes_count' => $aspirasi->fresh()->upvotes_count,
        ]);
    }

    public function comment(Request $request, Aspirasi $aspirasi)
    {
        $validated = $request->validate([
            'comment' => 'required|string|min:3',
            'is_anonymous' => 'boolean',
        ]);

        Comment::create([
            'aspirasi_id' => $aspirasi->id,
            'user_id' => Auth::id(),
            'comment' => $validated['comment'],
            'is_anonymous' => $request->has('is_anonymous'),
        ]);

        // ✅ Notifikasi ke PEMILIK aspirasi
        if (Auth::id() !== $aspirasi->user_id) {
            Notification::create([
                'user_id' => $aspirasi->user_id,
                'aspirasi_id' => $aspirasi->id,
                'type' => 'new_comment',
                'message' => 'Komentar baru pada pengaduan: ' . $aspirasi->judul,
                'is_read' => false,
            ]);
        }

        // ✅ Notifikasi ke SEMUA ADMIN
        $admins = User::where('role', 'admin')->get();
        foreach ($admins as $admin) {
            if ($admin->id !== Auth::id()) {
                Notification::create([
                    'user_id' => $admin->id,
                    'aspirasi_id' => $aspirasi->id,
                    'type' => 'new_comment',
                    'message' => 'Komentar baru pada pengaduan: ' . $aspirasi->judul,
                    'is_read' => false,
                ]);
            }
        }

        return redirect()->back()->with('success', 'Komentar berhasil ditambahkan!');
    }

    public function updateStatus(Request $request, Aspirasi $aspirasi)
    {
        if (Auth::user()->role !== 'admin') {
            return redirect()->back()->with('error', 'Hanya admin yang bisa mengubah status!');
        }

        $validated = $request->validate([
            'status' => 'required|in:menunggu,ditinjau,dalam_perbaikan,selesai,ditolak',
        ]);

        $oldStatus = $aspirasi->status;

        $aspirasi->update([
            'status' => $validated['status'],
            'tanggal_selesai' => $validated['status'] === 'selesai' ? now() : null,
        ]);

        // ✅ Notifikasi ke PEMILIK aspirasi dengan pesan yang jelas
        if ($oldStatus !== $validated['status']) {
            $statusMessages = [
                'menunggu' => 'Pengaduan Anda sedang menunggu untuk ditinjau.',
                'ditinjau' => 'Pengaduan Anda sedang ditinjau oleh admin.',
                'dalam_perbaikan' => 'Pengaduan Anda sedang dalam proses perbaikan.',
                'selesai' => 'Pengaduan Anda telah selesai ditangani. Terima kasih!',
                'ditolak' => 'Pengaduan Anda ditolak. Silakan cek umpan balik admin.',
            ];

            Notification::create([
                'user_id' => $aspirasi->user_id,
                'aspirasi_id' => $aspirasi->id,
                'type' => 'status_update',
                'message' => 'Status pengaduan "' . $aspirasi->judul . '": ' . ($statusMessages[$validated['status']] ?? 'Status diperbarui'),
                'is_read' => false,
            ]);
        }

        return redirect()->back()->with('success', 'Status berhasil diperbarui!');
    }
}
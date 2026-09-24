<?php

namespace App\Http\Controllers;

use App\Models\UmpanBalik;
use App\Models\Aspirasi;
use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UmpanBalikController extends Controller
{
    public function store(Request $request, Aspirasi $aspirasi)
    {
        if (Auth::user()->role !== 'admin') {
            return redirect()->back()->with('error', 'Hanya admin yang bisa memberikan umpan balik!');
        }

        $validated = $request->validate([
            'isi_umpan_balik' => 'required|string|min:5|max:2000',  // ← PAKAI INI
            'lampiran' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
            'jenis' => 'required|in:internal,eksternal',
        ]);

        $lampiranPath = null;
        if ($request->hasFile('lampiran')) {
            $lampiranPath = $request->file('lampiran')->store('umpan-balik', 'public');
        }

        UmpanBalik::create([
            'aspirasi_id' => $aspirasi->id,
            'admin_id' => Auth::id(),
            'isi_umpan_balik' => $validated['isi_umpan_balik'],  // ← PAKAI INI
            'lampiran' => $lampiranPath,
            'jenis' => $validated['jenis'],
            'is_read' => false,
        ]);

        // Notifikasi IN-APP ke pemilik aspirasi
        Notification::create([
            'user_id' => $aspirasi->user_id,
            'aspirasi_id' => $aspirasi->id,
            'type' => 'umpan_balik',
            'message' => 'Admin memberikan umpan balik pada pengaduan: ' . $aspirasi->judul,
            'is_read' => false,
        ]);

        return redirect()->back()->with('success', 'Umpan balik berhasil dikirim!');
    }

    public function destroy(UmpanBalik $umpanBalik)
    {
        if (Auth::id() !== $umpanBalik->admin_id) {
            return redirect()->back()->with('error', 'Anda tidak bisa menghapus umpan balik orang lain!');
        }

        $umpanBalik->delete();

        return redirect()->back()->with('success', 'Umpan balik berhasil dihapus!');
    }
}
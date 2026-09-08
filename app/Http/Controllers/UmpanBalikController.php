<?php

namespace App\Http\Controllers;

use App\Models\Aspirasi;
use App\Models\UmpanBalik;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UmpanBalikController extends Controller
{
    public function store(Request $request)
    {
        if (Auth::user()->role !== 'admin') {
            abort(403);
        }

        $request->validate([
            'aspirasi_id' => 'required|exists:aspirasis,id',
            'isi_umpan_balik' => 'required|string',
            'jenis' => 'required|in:internal,eksternal',
            'lampiran' => 'nullable|file|max:5120',
        ]);

        $data = $request->all();
        $data['admin_id'] = Auth::id();

        if ($request->hasFile('lampiran')) {
            $path = $request->file('lampiran')->store('umpan-balik', 'public');
            $data['lampiran'] = $path;
        }

        UmpanBalik::create($data);

        // Update status aspirasi menjadi proses jika belum
        $aspirasi = Aspirasi::find($request->aspirasi_id);
        if ($aspirasi->status === 'pending') {
            $aspirasi->update(['status' => 'proses']);
        }

        return back()->with('success', 'Umpan balik berhasil dikirim!');
    }

    public function markAsRead(UmpanBalik $umpanBalik)
    {
        $umpanBalik->update(['is_read' => true]);
        return response()->json(['success' => true]);
    }
}
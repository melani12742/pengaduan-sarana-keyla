<?php

namespace App\Http\Controllers;

use App\Models\Aspirasi;
use App\Models\Kategori;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class AspirasiController extends Controller
{
    public function index()
    {
        $aspirasis = Aspirasi::with(['user', 'kategori', 'umpanBalik'])
            ->when(Auth::user()->role !== 'admin', function ($query) {
                return $query->where('user_id', Auth::id());
            })
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('aspirasi.index', compact('aspirasis'));
    }

    public function create()
    {
        $kategoris = Kategori::all();
        return view('aspirasi.create', compact('kategoris'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'kategori_id' => 'required|exists:kategoris,id',
            'judul' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'lokasi' => 'nullable|string|max:255',
            'foto' => 'nullable|image|max:2048',
            'prioritas' => 'required|in:rendah,sedang,tinggi',
        ]);

        $data = $request->all();
        $data['user_id'] = Auth::id();
        $data['status'] = 'pending';
        $data['tanggal_aspirasi'] = now();

        if ($request->hasFile('foto')) {
            $path = $request->file('foto')->store('aspirasi-foto', 'public');
            $data['foto'] = $path;
        }

        Aspirasi::create($data);

        return redirect()->route('aspirasi.index')
            ->with('success', 'Aspirasi berhasil dikirim!');
    }

    public function show(Aspirasi $aspirasi)
    {
        $this->authorizeAccess($aspirasi);
        
        $aspirasi->load(['user', 'kategori', 'umpanBalik.admin']);
        
        return view('aspirasi.show', compact('aspirasi'));
    }

    public function edit(Aspirasi $aspirasi)
    {
        $this->authorizeAccess($aspirasi);
        
        if ($aspirasi->status !== 'pending') {
            return back()->with('error', 'Aspirasi yang sudah diproses tidak dapat diubah.');
        }

        $kategoris = Kategori::all();
        return view('aspirasi.edit', compact('aspirasi', 'kategoris'));
    }

    public function update(Request $request, Aspirasi $aspirasi)
    {
        $this->authorizeAccess($aspirasi);

        if ($aspirasi->status !== 'pending') {
            return back()->with('error', 'Aspirasi yang sudah diproses tidak dapat diubah.');
        }

        $request->validate([
            'kategori_id' => 'required|exists:kategoris,id',
            'judul' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'lokasi' => 'nullable|string|max:255',
            'foto' => 'nullable|image|max:2048',
            'prioritas' => 'required|in:rendah,sedang,tinggi',
        ]);

        $data = $request->all();

        if ($request->hasFile('foto')) {
            if ($aspirasi->foto) {
                Storage::disk('public')->delete($aspirasi->foto);
            }
            $path = $request->file('foto')->store('aspirasi-foto', 'public');
            $data['foto'] = $path;
        }

        $aspirasi->update($data);

        return redirect()->route('aspirasi.index')
            ->with('success', 'Aspirasi berhasil diupdate!');
    }

    public function destroy(Aspirasi $aspirasi)
    {
        $this->authorizeAccess($aspirasi);

        if ($aspirasi->status !== 'pending') {
            return back()->with('error', 'Aspirasi yang sudah diproses tidak dapat dihapus.');
        }

        if ($aspirasi->foto) {
            Storage::disk('public')->delete($aspirasi->foto);
        }

        $aspirasi->delete();

        return redirect()->route('aspirasi.index')
            ->with('success', 'Aspirasi berhasil dihapus!');
    }

    public function updateStatus(Request $request, Aspirasi $aspirasi)
    {
        if (Auth::user()->role !== 'admin') {
            abort(403);
        }

        $request->validate([
            'status' => 'required|in:pending,proses,selesai,ditolak',
        ]);

        $data = ['status' => $request->status];
        
        if ($request->status === 'selesai') {
            $data['tanggal_selesai'] = now();
        }

        $aspirasi->update($data);

        return back()->with('success', 'Status aspirasi berhasil diupdate!');
    }

    private function authorizeAccess($aspirasi)
    {
        if (Auth::user()->role !== 'admin' && $aspirasi->user_id !== Auth::id()) {
            abort(403, 'Anda tidak memiliki akses ke aspirasi ini.');
        }
    }
}
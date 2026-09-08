<?php

namespace App\Http\Controllers;

use App\Models\Kategori;
use Illuminate\Http\Request;

class KategoriController extends Controller
{
    public function __construct()
    {
        $this->middleware('admin');
    }

    public function index()
    {
        $kategoris = Kategori::withCount('aspirasis')->get();
        return view('admin.kategori', compact('kategoris'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_kategori' => 'required|string|max:255|unique:kategoris',
            'icon' => 'nullable|string|max:50',
        ]);

        Kategori::create($request->all());
        return back()->with('success', 'Kategori berhasil ditambahkan!');
    }

    public function update(Request $request, Kategori $kategori)
    {
        $request->validate([
            'nama_kategori' => 'required|string|max:255|unique:kategoris,nama_kategori,' . $kategori->id,
            'icon' => 'nullable|string|max:50',
        ]);

        $kategori->update($request->all());
        return back()->with('success', 'Kategori berhasil diupdate!');
    }

    public function destroy(Kategori $kategori)
    {
        if ($kategori->aspirasis()->count() > 0) {
            return back()->with('error', 'Kategori tidak dapat dihapus karena masih digunakan.');
        }

        $kategori->delete();
        return back()->with('success', 'Kategori berhasil dihapus!');
    }
}
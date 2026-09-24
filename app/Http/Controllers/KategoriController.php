<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class KategoriController extends Controller
{
    public function index()
    {
        $kategoris = Category::all();
        return view('admin.kategori.index', compact('kategoris'));
    }

    public function create()
    {
        return view('admin.kategori.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_kategori' => 'required|string|max:100|unique:categories',
            'icon' => 'nullable|string|max:50',
        ]);

        Category::create($validated);

        return redirect()->route('admin.kategori.index')
            ->with('success', 'Kategori berhasil ditambahkan!');
    }

    public function edit(Category $kategori)
    {
        return view('admin.kategori.edit', compact('kategori'));
    }

    public function update(Request $request, Category $kategori)
    {
        $validated = $request->validate([
            'nama_kategori' => 'required|string|max:100|unique:categories,nama_kategori,' . $kategori->id,
            'icon' => 'nullable|string|max:50',
        ]);

        $kategori->update($validated);

        return redirect()->route('admin.kategori.index')
            ->with('success', 'Kategori berhasil diperbarui!');
    }

    public function destroy(Category $kategori)
    {
        // Cek apakah ada aspirasi yang menggunakan kategori ini
        if ($kategori->aspirasis()->count() > 0) {
            return redirect()->route('admin.kategori.index')
                ->with('error', 'Kategori tidak bisa dihapus karena masih digunakan oleh aspirasi!');
        }

        $kategori->delete();

        return redirect()->route('admin.kategori.index')
            ->with('success', 'Kategori berhasil dihapus!');
    }
}
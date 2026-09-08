<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Aspirasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware('admin');
    }

    public function users()
    {
        $users = User::withCount('aspirasis')
            ->where('role', 'guest')
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        return view('admin.users', compact('users'));
    }

    public function allAspirasi(Request $request)
    {
        $query = Aspirasi::with(['user', 'kategori', 'umpanBalik']);

        // Filter
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('kategori')) {
            $query->where('kategori_id', $request->kategori);
        }

        if ($request->filled('tanggal')) {
            $query->whereDate('tanggal_aspirasi', $request->tanggal);
        }

        if ($request->filled('user')) {
            $query->where('user_id', $request->user);
        }

        $aspirasis = $query->orderBy('created_at', 'desc')->paginate(20);

        $users = User::where('role', 'guest')->pluck('name', 'id');
        $kategoris = \App\Models\Kategori::pluck('nama_kategori', 'id');

        return view('admin.all-aspirasi', compact('aspirasis', 'users', 'kategoris'));
    }

    public function toggleUserRole(User $user)
    {
        if ($user->role === 'admin') {
            return back()->with('error', 'Tidak dapat mengubah role admin.');
        }

        $newRole = $user->role === 'guest' ? 'user' : 'guest';
        $user->update(['role' => $newRole]);

        return back()->with('success', "Role user berhasil diubah menjadi {$newRole}.");
    }

    public function deleteUser(User $user)
    {
        if ($user->role === 'admin') {
            return back()->with('error', 'Tidak dapat menghapus admin.');
        }

        $user->delete();
        return back()->with('success', 'User berhasil dihapus.');
    }
}
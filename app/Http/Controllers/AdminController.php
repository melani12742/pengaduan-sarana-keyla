<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Aspirasi;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function users()
    {
        $users = User::withCount('aspirasis')->get();
        return view('admin.users', compact('users'));
    }

    public function allAspirasi()
{
    $aspirasis = Aspirasi::with(['user', 'category'])
        ->orderBy('created_at', 'desc')
        ->paginate(20);
    
    return view('admin.aspirasi', compact('aspirasis'));
}

    public function toggleUserRole(User $user)
    {
        if ($user->id === auth()->id()) {
            return redirect()->back()->with('error', 'Anda tidak bisa mengubah role sendiri.');
        }

        $user->role = $user->role === 'admin' ? 'guest' : 'admin';
        $user->save();

        return redirect()->back()->with('success', 'Role user berhasil diubah.');
    }

    public function deleteUser(User $user)
    {
        if ($user->id === auth()->id()) {
            return redirect()->back()->with('error', 'Anda tidak bisa menghapus akun sendiri.');
        }

        $user->delete();

        return redirect()->back()->with('success', 'User berhasil dihapus.');
    }
}
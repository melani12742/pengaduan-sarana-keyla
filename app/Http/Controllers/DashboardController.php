<?php

namespace App\Http\Controllers;

use App\Models\Aspirasi;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        if (!$user) {
            return redirect()->route('login');
        }

        // Jika role bukan admin, redirect ke halaman user biasa
        if ($user->role === 'guest' || $user->role === 'student') {
            return $this->userDashboard();
        }

        // Admin
        return $this->adminDashboard();
    }

    /**
     * ============================================
     * DASHBOARD ADMIN
     * ============================================
     */
    private function adminDashboard()
    {
        // ✅ STATISTIK — pakai status BARU
        $totalAspirasi = Aspirasi::count();
        $menunggu = Aspirasi::where('status', 'menunggu')->count();
        $ditinjau = Aspirasi::where('status', 'ditinjau')->count();
        $dalamPerbaikan = Aspirasi::where('status', 'dalam_perbaikan')->count();
        $selesai = Aspirasi::where('status', 'selesai')->count();
        $ditolak = Aspirasi::where('status', 'ditolak')->count();

        $aspirasiPerKategori = Category::withCount('aspirasis')->get();

        // ✅ VARIABEL: recentAspirasis (pakai 's')
        $recentAspirasis = Aspirasi::with(['user', 'category'])
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get();

        // Statistik bulanan
        $statistikBulanan = Aspirasi::selectRaw('MONTH(created_at) as bulan, COUNT(*) as total')
            ->whereYear('created_at', date('Y'))
            ->groupBy('bulan')
            ->orderBy('bulan')
            ->get();

        $bulanLabels = ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'];
        $dataBulan = array_fill(0, 12, 0);

        foreach ($statistikBulanan as $stat) {
            $dataBulan[$stat->bulan - 1] = $stat->total;
        }

        return view('admin.dashboard', compact(
            'totalAspirasi',
            'menunggu',
            'ditinjau',
            'dalamPerbaikan',
            'selesai',
            'ditolak',
            'aspirasiPerKategori',
            'recentAspirasis',   // ✅ pakai 's'
            'bulanLabels',
            'dataBulan'
        ));
    }

    /**
     * ============================================
     * DASHBOARD USER (GUEST/STUDENT)
     * ============================================
     */
    private function userDashboard()
    {
        $user = Auth::user();

        // ✅ STATISTIK — pakai status BARU
        $totalAspirasi = Aspirasi::where('user_id', $user->id)->count();
        $menunggu = Aspirasi::where('user_id', $user->id)->where('status', 'menunggu')->count();
        $ditinjau = Aspirasi::where('user_id', $user->id)->where('status', 'ditinjau')->count();
        $dalamPerbaikan = Aspirasi::where('user_id', $user->id)->where('status', 'dalam_perbaikan')->count();
        $selesai = Aspirasi::where('user_id', $user->id)->where('status', 'selesai')->count();
        $ditolak = Aspirasi::where('user_id', $user->id)->where('status', 'ditolak')->count();

        // ✅ VARIABEL: recentAspirasis (pakai 's')
        $recentAspirasis = Aspirasi::with(['category', 'umpanBalik'])
            ->where('user_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        return view('user.dashboard', compact(
            'totalAspirasi',
            'menunggu',
            'ditinjau',
            'dalamPerbaikan',
            'selesai',
            'ditolak',
            'recentAspirasis'   // ✅ pakai 's'
        ));
    }
}
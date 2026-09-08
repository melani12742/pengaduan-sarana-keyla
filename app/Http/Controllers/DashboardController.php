<?php

namespace App\Http\Controllers;

use App\Models\Aspirasi;
use App\Models\Kategori;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // Jika user belum login, redirect ke login
        if (!$user) {
            return redirect()->route('login');
        }

        if ($user->role === 'admin') {
            return $this->adminDashboard();
        }

        return $this->userDashboard();
    }

    private function adminDashboard()
    {
        $totalAspirasi = Aspirasi::count();
        $pending = Aspirasi::where('status', 'pending')->count();
        $proses = Aspirasi::where('status', 'proses')->count();
        $selesai = Aspirasi::where('status', 'selesai')->count();
        $ditolak = Aspirasi::where('status', 'ditolak')->count();

        $aspirasiPerKategori = Kategori::withCount('aspirasis')->get();

        $recentAspirasi = Aspirasi::with(['user', 'kategori'])
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get();

        $statistikBulanan = Aspirasi::selectRaw('MONTH(tanggal_aspirasi) as bulan, COUNT(*) as total')
            ->whereYear('tanggal_aspirasi', date('Y'))
            ->groupBy('bulan')
            ->orderBy('bulan')
            ->get();

        $bulanLabels = ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'];
        $dataBulan = array_fill(0, 12, 0);

        foreach ($statistikBulanan as $stat) {
            $dataBulan[$stat->bulan - 1] = $stat->total;
        }

        // Untuk Breeze, kirim data ke view admin.dashboard
        return view('admin.dashboard', compact(
            'totalAspirasi',
            'pending',
            'proses',
            'selesai',
            'ditolak',
            'aspirasiPerKategori',
            'recentAspirasi',
            'bulanLabels',
            'dataBulan'
        ));
    }

    private function userDashboard()
    {
        $user = Auth::user();

        $totalAspirasi = Aspirasi::where('user_id', $user->id)->count();
        $pending = Aspirasi::where('user_id', $user->id)->where('status', 'pending')->count();
        $proses = Aspirasi::where('user_id', $user->id)->where('status', 'proses')->count();
        $selesai = Aspirasi::where('user_id', $user->id)->where('status', 'selesai')->count();

        $recentAspirasi = Aspirasi::with(['kategori', 'umpanBalik'])
            ->where('user_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        // Untuk Breeze, kirim data ke view user.dashboard
        return view('user.dashboard', compact(
            'totalAspirasi',
            'pending',
            'proses',
            'selesai',
            'recentAspirasi'
        ));
    }
}
<?php

namespace App\Http\Controllers;

use App\Models\Aspirasi;
use App\Models\User;
use Illuminate\Http\Request;

class LandingController extends Controller
{
    public function index()
    {
        // Data statistik
        $totalAspirasi = Aspirasi::count();

        // Sesuaikan dengan status yang ada di database Anda
        $selesai = Aspirasi::where('status', 'completed')->count(); // atau 'selesai'
        $proses = Aspirasi::where('status', 'processing')->count(); // atau 'proses'

        // User dengan role student/guest
        $users = User::where('role', 'student')->count(); // atau 'guest'

        return view('landing', compact(
            'totalAspirasi',
            'selesai',
            'proses',
            'users'
        ));
    }
}
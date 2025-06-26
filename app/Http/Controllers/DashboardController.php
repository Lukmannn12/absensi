<?php

namespace App\Http\Controllers;

use App\Models\Absensi;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function adminDashboard()
    {
        // Ambil timeline absensi terakhir (10 data terbaru)
        $timeline = Absensi::with('user')
            ->orderByDesc('created_at')
            ->take(10)
            ->get();

        // Tanggal hari ini
        $today = Carbon::today()->toDateString();

        // Statistik
        $totalKaryawan = User::where('role', 'karyawan')->count();

        $absenHariIni = Absensi::where('tanggal', $today)->count();
        $sudahPulang = Absensi::where('tanggal', $today)
            ->whereNotNull('jam_pulang')
            ->count();
        $belumPulang = Absensi::where('tanggal', $today)
            ->whereNull('jam_pulang')
            ->count();

        return view('admin.dashboard', compact(
            'timeline',
            'totalKaryawan',
            'absenHariIni',
            'sudahPulang',
            'belumPulang'
        ));
    }
}

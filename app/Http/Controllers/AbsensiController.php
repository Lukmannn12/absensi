<?php

namespace App\Http\Controllers;

use App\Models\Absensi;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AbsensiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Cek role user
        if (Auth::user()->role === 'admin') {
            // Ambil semua data absensi
            $data = Absensi::with('user')
                ->orderByDesc('tanggal')
                ->get();

            // Tampilkan view untuk admin
            return view('admin.absensi.index', compact('data'));
        } else {
            // Ambil data absensi berdasarkan user login
            $data = Absensi::with('user')
                ->where('user_id', Auth::id())
                ->orderByDesc('tanggal')
                ->get();

            // Tampilkan view untuk karyawan
            return view('absensi.index', compact('data'));
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('absensi.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $userId = Auth::id();
        $today = now()->toDateString();
        $currentTime = now();

        // Waktu mulai dan akhir absensi
        $startTime = Carbon::createFromTime(8, 30);
        $endTime = Carbon::createFromTime(17, 30);

        // Cek apakah waktu sekarang berada di antara 08.30 - 17.30
        if (!$currentTime->between($startTime, $endTime)) {
            return redirect()->route('absensi.index')
                ->with('success', 'Absensi hanya bisa dilakukan antara pukul 08:30 hingga 17:30.');
        }

        $absensi = Absensi::where('user_id', $userId)
            ->where('tanggal', $today)
            ->first();

        if (!$absensi) {
            // Absen Masuk
            Absensi::create([
                'user_id' => $userId,
                'tanggal' => $today,
                'jam_masuk' => now()->toTimeString(),
            ]);

            return redirect()->route('absensi.index')->with('success', 'Absensi masuk berhasil.');
        } elseif (!$absensi->jam_pulang) {
            // Absen Pulang
            $absensi->update([
                'jam_pulang' => now()->toTimeString(),
            ]);

            return redirect()->route('absensi.index')->with('success', 'Absensi pulang berhasil.');
        }

        return redirect()->route('absensi.index')->with('success', 'Anda sudah absen masuk dan pulang hari ini.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}

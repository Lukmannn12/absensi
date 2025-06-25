<?php

namespace App\Http\Controllers;

use App\Models\JatahCuti;
use App\Models\PengajuanCuti;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PengajuanCutiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (Auth::user()->role === 'admin') {
            // Untuk admin: tampilkan semua pengajuan cuti
            $data = PengajuanCuti::with('user')->latest()->get();
            return view('admin.pengajuan_cuti.index', compact('data'));
        } else {
            // Untuk karyawan: tampilkan hanya miliknya
            $data = PengajuanCuti::where('user_id', Auth::id())->latest()->get();
            return view('karyawann.pengajuan_cuti.index', compact('data'));
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('karyawann.pengajuan_cuti.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'required|date|after_or_equal:tanggal_mulai',
            'alasan' => 'nullable|string',
        ]);

        // Hitung durasi cuti
        $mulai = Carbon::parse($request->tanggal_mulai);
        $selesai = Carbon::parse($request->tanggal_selesai);
        $durasi = $mulai->diffInDays($selesai) + 1;

        // Ambil sisa cuti
        $jatah = JatahCuti::where('user_id', Auth::id())->first();

        if (!$jatah || $jatah->sisa_cuti < $durasi) {
            return back()->with('error', 'Sisa cuti tidak mencukupi.');
        }

        PengajuanCuti::create([
            'user_id' => Auth::id(),
            'tanggal_mulai' => $request->tanggal_mulai,
            'tanggal_selesai' => $request->tanggal_selesai,
            'alasan' => $request->alasan,
            'status' => 'pending',
        ]);

        return redirect()->route('pengajuan-cuti.index')->with('success', 'Pengajuan cuti berhasil dikirim.');
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
        // Hanya admin yang boleh mengakses
    if (Auth::user()->role !== 'admin') {
        abort(403, 'Akses ditolak');
    }

    $cuti = PengajuanCuti::findOrFail($id);
    return view('admin.pengajuan_cuti.update', compact('cuti'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        if (Auth::user()->role !== 'admin') {
        abort(403, 'Akses ditolak');
    }

    $request->validate([
        'status' => 'required|in:pending,disetujui,ditolak',
    ]);

    $cuti = PengajuanCuti::findOrFail($id);

    // Hanya kurangi sisa cuti jika disetujui dan status sebelumnya belum disetujui
    if ($cuti->status !== 'disetujui' && $request->status === 'disetujui') {
        $durasi = Carbon::parse($cuti->tanggal_mulai)->diffInDays($cuti->tanggal_selesai) + 1;

        $jatah = JatahCuti::where('user_id', $cuti->user_id)->first();
        if ($jatah && $jatah->sisa_cuti >= $durasi) {
            $jatah->decrement('sisa_cuti', $durasi);
        } else {
            return back()->with('error', 'Sisa cuti tidak mencukupi untuk menyetujui.');
        }
    }

    $cuti->update([
        'status' => $request->status,
    ]);

    return redirect()->route('pengajuan-cuti.index')->with('success', 'Status pengajuan cuti berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}

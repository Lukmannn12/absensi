<?php

namespace App\Http\Controllers;

use App\Models\JatahCuti;
use App\Models\User;
use Illuminate\Http\Request;

class JatahCutiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
         $data = JatahCuti::with('user')->get();
        return view('jatah_cuti.index', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $pengguna = User::where('role', 'karyawan')->get();
        return view('jatah_cuti.create', compact('pengguna'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'total_cuti' => 'required|integer|min:0',
        ]);

        JatahCuti::create([
            'user_id' => $request->user_id,
            'total_cuti' => $request->total_cuti,
            'sisa_cuti' => $request->total_cuti,
        ]);

        return redirect()->route('jatah-cuti.index')->with('success', 'Jatah cuti berhasil ditambahkan.');
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

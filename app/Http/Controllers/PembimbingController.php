<?php

namespace App\Http\Controllers;

use App\Models\Nilai;
use App\Models\Pembimbing;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PembimbingController extends Controller
{
    public function dashboard()
    {
        $pembimbing = Auth::user()->pembimbing;

        $pkl = $pembimbing->pkl()
            ->with([
                'pengajuan.siswa',
                'pengajuan.perusahaan',
                'nilai',
            ])
            ->get();

        return view('pembimbing.dashboard', compact(
            'pembimbing',
            'pkl'
        ));
    }

    public function nilai(Request $request, $id_pkl)
    {
        $request->validate([
            'nilai' => ['required', 'numeric', 'min:0', 'max:100'],
            'catatan' => ['nullable', 'string'],
        ]);

        Nilai::updateOrCreate(
            [
                'id_pkl' => $id_pkl,
            ],
            [
                'nilai' => $request->nilai,
                'catatan' => $request->catatan,
                'tanggal_input' => now()->toDateString(),
            ]
        );

        return back()->with('success', 'Nilai berhasil disimpan.');
    }
}
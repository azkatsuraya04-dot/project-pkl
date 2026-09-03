<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;

class SiswaDashboardController extends Controller
{
    public function index()
    {
        $siswa = Auth::user()->siswa;

        $pengajuan = $siswa->pengajuan()
            ->with([
                'perusahaan',
                'pkl.pembimbing',
                'pkl.nilai',
            ])
            ->latest('id_pengajuan')
            ->first();

        return view('siswa.dashboard', compact(
            'siswa',
            'pengajuan'
        ));
    }
}
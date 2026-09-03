<?php

namespace App\Http\Controllers;

use App\Models\Pengajuan;
use App\Models\Pembimbing;
use App\Models\Pkl;
use Illuminate\Http\Request;

class HubinController extends Controller
{
    /**
     * Dashboard Hubin
     */
    public function dashboard()
    {
        $pengajuan = Pengajuan::with([
            'siswa',
            'perusahaan',
            'pkl.pembimbing',
        ])
        ->where('status_kaprog', 'disetujui')
        ->latest('id_pengajuan')
        ->get();

        $pembimbing = Pembimbing::orderBy('nama_pembimbing')->get();

        return view('hubin.dashboard', compact(
            'pengajuan',
            'pembimbing'
        ));
    }

    /**
     * Proses pengajuan dan membuat penempatan PKL
     */
    public function proses(Request $request, Pengajuan $pengajuan)
    {
        // Validasi pembimbing
        $validated = $request->validate([
            'pembimbing' => [
                'required',
                'exists:pembimbing,id_pembimbing',
            ],
        ]);

        // Pengajuan harus sudah disetujui Kaprog
        if ($pengajuan->status_kaprog !== 'disetujui') {
            return back()->with(
                'error',
                'Pengajuan belum disetujui Kaprog.'
            );
        }

        /*
        |--------------------------------------------------------------------------
        | UPDATE STATUS PENGAJUAN
        |--------------------------------------------------------------------------
        */

        $pengajuan->update([
            'status_kaprog' => 'disetujui',
            'status_hubin' => 'surat_dikirim',
            'status_perusahaan' => 'disetujui',
        ]);


        /*
        |--------------------------------------------------------------------------
        | BUAT / UPDATE PENEMPATAN PKL
        |--------------------------------------------------------------------------
        */

        Pkl::updateOrCreate(
            [
                'id_pengajuan' => $pengajuan->id_pengajuan,
            ],
            [
                'id_pembimbing' => $validated['pembimbing'],
                'tanggal_mulai' => '2026-09-01',
                'tanggal_selesai' => '2026-12-01',
                'status' => 'berlangsung',
            ]
        );


        return back()->with(
            'success',
            'Pengajuan berhasil disetujui dan siswa telah ditempatkan ke PKL.'
        );
    }


    /**
     * Menolak pengajuan
     */
    public function tolak(Pengajuan $pengajuan)
    {
        $pengajuan->update([
            'status_hubin' => 'diproses',
            'status_perusahaan' => 'ditolak',
        ]);

        return back()->with(
            'success',
            'Pengajuan berhasil ditolak.'
        );
    }
}
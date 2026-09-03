<?php

namespace App\Http\Controllers;

use App\Models\Perusahaan;
use App\Models\Pengajuan;
use Illuminate\Support\Facades\Auth;

class SiswaPerusahaanController extends Controller
{
    // Halaman daftar perusahaan
    public function index()
    {
        $siswa = Auth::user()->siswa;

        $perusahaan = Perusahaan::orderBy('nama_perusahaan')->get();

        $pengajuan = $siswa->pengajuan()
            ->latest('id_pengajuan')
            ->first();

        return view('siswa.perusahaan', compact(
            'siswa',
            'perusahaan',
            'pengajuan'
        ));
    }

    // Proses mengajukan PKL
    public function ajukan(Perusahaan $perusahaan)
    {
        $siswa = Auth::user()->siswa;

        // Cek apakah masih ada pengajuan yang sedang diproses
        $pengajuanAktif = $siswa->pengajuan()
            ->where('status_perusahaan', 'menunggu')
            ->exists();

        if ($pengajuanAktif) {
            return back()->with(
                'error',
                'Kamu masih memiliki pengajuan yang sedang diproses.'
            );
        }

        Pengajuan::create([
            'id_siswa' => $siswa->id_siswa,
            'id_perusahaan' => $perusahaan->id_perusahaan,
            'tanggal_pengajuan' => now()->toDateString(),
            'status_kaprog' => 'menunggu',
            'status_hubin' => 'belum_diproses',
            'status_perusahaan' => 'menunggu',
        ]);

        return redirect()
            ->route('siswa.perusahaan')
            ->with('success', 'Pengajuan PKL berhasil dikirim.');
    }

    // Halaman status/riwayat pengajuan
    public function pengajuan()
    {
        $siswa = Auth::user()->siswa;

        $pengajuan = $siswa->pengajuan()
            ->with([
                'perusahaan',
                'pkl.pembimbing',
                'pkl.nilai',
            ])
            ->latest('id_pengajuan')
            ->get();

        return view('siswa.pengajuan', compact(
            'siswa',
            'pengajuan'
        ));
    }
}
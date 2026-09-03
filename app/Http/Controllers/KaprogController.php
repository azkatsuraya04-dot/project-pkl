<?php

namespace App\Http\Controllers;

use App\Models\Pengajuan;
use App\Models\Siswa;
use App\Models\Perusahaan;
use App\Models\Pkl;
use Illuminate\Support\Facades\DB;

class KaprogController extends Controller
{
    public function dashboard()
    {
        $pengajuan = Pengajuan::with([
            'siswa',
            'perusahaan'
        ])
        ->latest('id_pengajuan')
        ->get();

        /*
        |--------------------------------------------------------------------------
        | STATISTIK
        |--------------------------------------------------------------------------
        */

        $totalSiswa = Siswa::count();

        $totalPerusahaan = Perusahaan::count();

        $totalPengajuan = Pengajuan::count();

        $totalPKL = Pkl::count();

        $pklBerlangsung = Pkl::where(
            'status',
            'berlangsung'
        )->count();

        $pklSelesai = Pkl::where(
            'status',
            'selesai'
        )->count();


        /*
        |--------------------------------------------------------------------------
        | JUMLAH SISWA PER PERUSAHAAN
        |--------------------------------------------------------------------------
        */

        $siswaPerPerusahaan = DB::table('pengajuan')
            ->join(
                'perusahaan',
                'pengajuan.id_perusahaan',
                '=',
                'perusahaan.id_perusahaan'
            )
            ->join(
                'siswa',
                'pengajuan.id_siswa',
                '=',
                'siswa.id_siswa'
            )
            ->select(
                'perusahaan.nama_perusahaan',
                DB::raw('COUNT(siswa.id_siswa) as jumlah_siswa')
            )
            ->where(
                'pengajuan.status_perusahaan',
                'disetujui'
            )
            ->groupBy(
                'perusahaan.id_perusahaan',
                'perusahaan.nama_perusahaan'
            )
            ->orderByDesc('jumlah_siswa')
            ->get();


        return view('kaprog.dashboard', compact(
            'pengajuan',
            'totalSiswa',
            'totalPerusahaan',
            'totalPengajuan',
            'totalPKL',
            'pklBerlangsung',
            'pklSelesai',
            'siswaPerPerusahaan'
        ));
    }

    public function setujui(Pengajuan $pengajuan)
    {
        $pengajuan->update([
            'status_kaprog' => 'disetujui',
        ]);

        return back()->with(
            'success',
            'Pengajuan berhasil disetujui.'
        );
    }

    public function tolak(Pengajuan $pengajuan)
    {
        $pengajuan->update([
            'status_kaprog' => 'ditolak',
        ]);

        return back()->with(
            'success',
            'Pengajuan berhasil ditolak.'
        );
    }
}
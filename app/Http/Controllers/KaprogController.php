<?php

namespace App\Http\Controllers;

use App\Models\Pengajuan;
use App\Models\Siswa;
use App\Models\Perusahaan;
use App\Models\Pkl;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class KaprogController extends Controller
{
    public function dashboard(Request $request)
    {
        $search = $request->input('search');
        $status = $request->input('status');

        /*
        |--------------------------------------------------------------------------
        | Data Pengajuan
        |--------------------------------------------------------------------------
        */

        $pengajuanQuery = Pengajuan::with([
            'siswa',
            'perusahaan',
            'pkl'
        ])->latest('id_pengajuan');

        // Search berdasarkan nama siswa
        if ($search) {
            $pengajuanQuery->whereHas('siswa', function ($query) use ($search) {
                $query->where(
                    'nama_siswa',
                    'like',
                    '%' . $search . '%'
                );
            });
        }

        // Filter berdasarkan status PKL
        if ($status) {
            $pengajuanQuery->whereHas('pkl', function ($query) use ($status) {
                $query->where('status', $status);
            });
        }

        $pengajuan = $pengajuanQuery->get();

        /*
        |--------------------------------------------------------------------------
        | Statistik
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
        | Jumlah Siswa per Perusahaan
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
                DB::raw(
                    'COUNT(siswa.id_siswa) as jumlah_siswa'
                )
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

        return view(
            'kaprog.dashboard',
            compact(
                'pengajuan',
                'totalSiswa',
                'totalPerusahaan',
                'totalPengajuan',
                'totalPKL',
                'pklBerlangsung',
                'pklSelesai',
                'siswaPerPerusahaan',
                'search',
                'status'
            )
        );
    }

    /*
    |--------------------------------------------------------------------------
    | Setujui Pengajuan
    |--------------------------------------------------------------------------
    */

    public function setujui(Pengajuan $pengajuan)
    {
        $pengajuan->update([
            'status_kaprog' => 'disetujui'
        ]);

        return back()->with(
            'success',
            'Pengajuan berhasil disetujui.'
        );
    }

    /*
    |--------------------------------------------------------------------------
    | Tolak Pengajuan
    |--------------------------------------------------------------------------
    */

    public function tolak(Pengajuan $pengajuan)
    {
        $pengajuan->update([
            'status_kaprog' => 'ditolak'
        ]);

        return back()->with(
            'success',
            'Pengajuan berhasil ditolak.'
        );
    }
}
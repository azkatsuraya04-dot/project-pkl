<?php

namespace App\Http\Controllers;

use App\Models\Pkl;
use App\Models\Nilai;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PembimbingController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Dashboard Pembimbing
    |--------------------------------------------------------------------------
    */

    public function dashboard(Request $request)
    {
        $search = $request->input('search');
        $status = $request->input('status');

        $pembimbing = Auth::user()->pembimbing;


        /*
        |--------------------------------------------------------------------------
        | Query Siswa Bimbingan
        |--------------------------------------------------------------------------
        */

        $pklQuery = Pkl::with([
            'pengajuan.siswa',
            'pengajuan.perusahaan',
            'nilai'
        ])->where(
            'id_pembimbing',
            $pembimbing->id_pembimbing
        );


        /*
        |--------------------------------------------------------------------------
        | Search Nama Siswa
        |--------------------------------------------------------------------------
        */

        if ($search) {
            $pklQuery->whereHas(
                'pengajuan.siswa',
                function ($query) use ($search) {
                    $query->where(
                        'nama_siswa',
                        'like',
                        '%' . $search . '%'
                    );
                }
            );
        }


        /*
        |--------------------------------------------------------------------------
        | Filter Status PKL
        |--------------------------------------------------------------------------
        */

        if ($status) {
            $pklQuery->where(
                'status',
                $status
            );
        }


        $pkl = $pklQuery
            ->latest('id_pkl')
            ->get();


        return view(
            'pembimbing.dashboard',
            compact(
                'pembimbing',
                'pkl',
                'search',
                'status'
            )
        );
    }


    /*
    |--------------------------------------------------------------------------
    | Input Nilai
    |--------------------------------------------------------------------------
    */

    public function nilai(
        Request $request,
        $id_pkl
    ) {
        $validated = $request->validate([
            'nilai' => [
                'required',
                'numeric',
                'min:0',
                'max:100'
            ],

            'catatan' => [
                'nullable',
                'string'
            ],
        ]);


        $pkl = Pkl::where(
            'id_pkl',
            $id_pkl
        )->firstOrFail();


        /*
        |--------------------------------------------------------------------------
        | Pastikan PKL milik pembimbing yang login
        |--------------------------------------------------------------------------
        */

        if (
            $pkl->id_pembimbing
            !== Auth::user()->pembimbing->id_pembimbing
        ) {
            abort(
                403,
                'Kamu tidak memiliki akses ke data siswa ini.'
            );
        }


        /*
        |--------------------------------------------------------------------------
        | Simpan / Update Nilai
        |--------------------------------------------------------------------------
        */

        Nilai::updateOrCreate(
            [
                'id_pkl' => $pkl->id_pkl
            ],
            [
                'nilai' => $validated['nilai'],
                'catatan' => $validated['catatan'] ?? null,
                'tanggal_input' => now()->toDateString(),
            ]
        );


        return back()->with(
            'success',
            'Nilai siswa berhasil disimpan.'
        );
    }
}
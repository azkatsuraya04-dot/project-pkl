<?php

namespace App\Http\Controllers;

use App\Models\Siswa;
use App\Models\User;
use Illuminate\Http\Request;

class HubinSiswaController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Tampilkan Data Siswa
    |--------------------------------------------------------------------------
    */

    public function index(Request $request)
    {
        $search = $request->input('search');
        $status = $request->input('status');

        $siswaQuery = Siswa::with([
            'user',
            'pengajuan.perusahaan',
            'pengajuan.pkl'
        ])->orderBy('nama_siswa');

        /*
        |--------------------------------------------------------------------------
        | Search Nama Siswa
        |--------------------------------------------------------------------------
        */

        if ($search) {
            $siswaQuery->where(
                'nama_siswa',
                'like',
                '%' . $search . '%'
            );
        }

        /*
        |--------------------------------------------------------------------------
        | Filter Status PKL
        |--------------------------------------------------------------------------
        */

        if ($status) {
            $siswaQuery->whereHas(
                'pengajuan.pkl',
                function ($query) use ($status) {
                    $query->where(
                        'status',
                        $status
                    );
                }
            );
        }

        $siswa = $siswaQuery->get();

        return view(
            'hubin.siswa',
            compact(
                'siswa',
                'search',
                'status'
            )
        );
    }


    /*
    |--------------------------------------------------------------------------
    | Tambah Siswa
    |--------------------------------------------------------------------------
    */

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_siswa' => [
                'required',
                'string',
                'max:100'
            ],

            'nis' => [
                'required',
                'string',
                'max:20',
                'unique:siswa,nis'
            ],

            'kelas' => [
                'required',
                'string',
                'max:20'
            ],

            'jurusan' => [
                'required',
                'string',
                'max:50'
            ],

            'email' => [
                'required',
                'email',
                'max:100',
                'unique:users,email'
            ],

            'password' => [
                'required',
                'string',
                'min:8'
            ],
        ]);


        /*
        |--------------------------------------------------------------------------
        | Buat User
        |--------------------------------------------------------------------------
        */

        $user = User::create([
            'name' => $validated['nama_siswa'],
            'email' => $validated['email'],
            'password' => $validated['password'],
            'role' => 'siswa',
        ]);


        /*
        |--------------------------------------------------------------------------
        | Buat Data Siswa
        |--------------------------------------------------------------------------
        */

        Siswa::create([
            'id_user' => $user->id,
            'nis' => $validated['nis'],
            'nama_siswa' => $validated['nama_siswa'],
            'kelas' => $validated['kelas'],
            'jurusan' => $validated['jurusan'],
        ]);


        return back()->with(
            'success',
            'Data siswa berhasil ditambahkan.'
        );
    }


    /*
    |--------------------------------------------------------------------------
    | Update Siswa
    |--------------------------------------------------------------------------
    */

    public function update(
        Request $request,
        Siswa $siswa
    ) {
        $validated = $request->validate([
            'nama_siswa' => [
                'required',
                'string',
                'max:100'
            ],

            'nis' => [
                'required',
                'string',
                'max:20',
                'unique:siswa,nis,' .
                $siswa->id_siswa .
                ',id_siswa'
            ],

            'kelas' => [
                'required',
                'string',
                'max:20'
            ],

            'jurusan' => [
                'required',
                'string',
                'max:50'
            ],

            'email' => [
                'required',
                'email',
                'max:100',
                'unique:users,email,' .
                $siswa->id_user
            ],
        ]);


        $siswa->update([
            'nama_siswa' => $validated['nama_siswa'],
            'nis' => $validated['nis'],
            'kelas' => $validated['kelas'],
            'jurusan' => $validated['jurusan'],
        ]);


        if ($siswa->user) {
            $siswa->user->update([
                'name' => $validated['nama_siswa'],
                'email' => $validated['email'],
            ]);
        }


        return back()->with(
            'success',
            'Data siswa berhasil diperbarui.'
        );
    }


    /*
    |--------------------------------------------------------------------------
    | Hapus Siswa
    |--------------------------------------------------------------------------
    */

    public function destroy(Siswa $siswa)
    {
        /*
        |--------------------------------------------------------------------------
        | Jangan hapus siswa yang sudah punya pengajuan
        |--------------------------------------------------------------------------
        */

        if ($siswa->pengajuan()->exists()) {
            return back()->with(
                'error',
                'Siswa tidak dapat dihapus karena sudah memiliki pengajuan PKL.'
            );
        }


        $user = $siswa->user;


        $siswa->delete();


        if ($user) {
            $user->delete();
        }


        return back()->with(
            'success',
            'Data siswa berhasil dihapus.'
        );
    }
}
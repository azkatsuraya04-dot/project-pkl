<?php

namespace App\Http\Controllers;

use App\Models\Siswa;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class HubinSiswaController extends Controller
{
    public function index()
    {
        $siswa = Siswa::with('user')
            ->orderBy('nama_siswa')
            ->get();

        return view('hubin.siswa', compact('siswa'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_siswa' => ['required', 'string', 'max:100'],
            'nis' => ['required', 'string', 'max:20', 'unique:siswa,nis'],
            'kelas' => ['required', 'string', 'max:20'],
            'jurusan' => ['required', 'string', 'max:50'],
            'email' => ['required', 'email', 'max:100', 'unique:users,email'],
            'password' => ['required', 'string', 'min:8'],
        ]);

        $user = User::create([
            'name' => $validated['nama_siswa'],
            'email' => $validated['email'],
            'password' => $validated['password'],
            'role' => 'siswa',
        ]);

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

    public function update(Request $request, Siswa $siswa)
    {
        $validated = $request->validate([
            'nama_siswa' => ['required', 'string', 'max:100'],
            'nis' => [
                'required',
                'string',
                'max:20',
                'unique:siswa,nis,' . $siswa->id_siswa . ',id_siswa',
            ],
            'kelas' => ['required', 'string', 'max:20'],
            'jurusan' => ['required', 'string', 'max:50'],
            'email' => [
                'required',
                'email',
                'max:100',
                'unique:users,email,' . $siswa->id_user,
            ],
        ]);

        $siswa->update([
            'nis' => $validated['nis'],
            'nama_siswa' => $validated['nama_siswa'],
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

    public function destroy(Siswa $siswa)
    {
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
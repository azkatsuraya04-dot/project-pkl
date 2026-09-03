<?php

namespace App\Http\Controllers;

use App\Models\Perusahaan;
use Illuminate\Http\Request;

class PerusahaanController extends Controller
{
    public function index()
    {
        $perusahaan = Perusahaan::orderBy('nama_perusahaan')->get();

        return view('hubin.perusahaan', compact('perusahaan'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_perusahaan' => ['required', 'string', 'max:150'],
            'alamat' => ['required', 'string'],
            'no_telp' => ['nullable', 'string', 'max:20'],
            'email' => ['nullable', 'email', 'max:100'],
        ]);

        Perusahaan::create($validated);

        return back()->with(
            'success',
            'Data perusahaan berhasil ditambahkan.'
        );
    }

    public function update(Request $request, Perusahaan $perusahaan)
    {
        $validated = $request->validate([
            'nama_perusahaan' => ['required', 'string', 'max:150'],
            'alamat' => ['required', 'string'],
            'no_telp' => ['nullable', 'string', 'max:20'],
            'email' => ['nullable', 'email', 'max:100'],
        ]);

        $perusahaan->update($validated);

        return back()->with(
            'success',
            'Data perusahaan berhasil diperbarui.'
        );
    }

    public function destroy(Perusahaan $perusahaan)
    {
        if ($perusahaan->pengajuan()->exists()) {
            return back()->with(
                'error',
                'Perusahaan tidak dapat dihapus karena sudah memiliki pengajuan PKL.'
            );
        }

        $perusahaan->delete();

        return back()->with(
            'success',
            'Data perusahaan berhasil dihapus.'
        );
    }
}
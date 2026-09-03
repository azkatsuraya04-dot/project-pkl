@extends('layouts.app')

@section('title', 'Data Siswa')

@section('content')

<div class="mx-auto max-w-7xl px-5 py-10 lg:px-8">

    {{-- HEADER --}}
    <div class="mb-8">
        <p class="text-sm font-semibold text-[#9E2F37]">
            Hubin
        </p>

        <div class="mt-1 flex flex-col gap-4 md:flex-row md:items-end md:justify-between">

            <div>
                <h1 class="text-3xl font-black tracking-tight text-[#3D2528]">
                    Data Siswa
                </h1>

                <p class="mt-2 text-[#8B7477]">
                    Kelola data siswa dan pantau status PKL.
                </p>
            </div>

            {{-- TOMBOL TAMBAH --}}
            <button
                type="button"
                onclick="document.getElementById('modalTambahSiswa').classList.remove('hidden')"
                class="rounded-full bg-[#9E2F37] px-5 py-3 text-sm font-bold text-white transition hover:bg-[#84262D]"
            >
                + Tambah Siswa
            </button>

        </div>
    </div>


    {{-- ALERT SUCCESS --}}
    @if(session('success'))
        <div class="mb-6 rounded-2xl border border-green-200 bg-green-50 px-5 py-4 text-sm font-semibold text-green-700">
            {{ session('success') }}
        </div>
    @endif


    {{-- ALERT ERROR --}}
    @if(session('error'))
        <div class="mb-6 rounded-2xl border border-red-200 bg-red-50 px-5 py-4 text-sm font-semibold text-red-700">
            {{ session('error') }}
        </div>
    @endif


    {{-- VALIDATION ERROR --}}
    @if($errors->any())
        <div class="mb-6 rounded-2xl border border-red-200 bg-red-50 px-5 py-4 text-sm text-red-700">

            <p class="font-bold">
                Terjadi kesalahan:
            </p>

            <ul class="mt-2 list-disc pl-5">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>

        </div>
    @endif


    {{-- SEARCH + FILTER --}}
    <div class="rounded-3xl bg-white p-6 shadow-sm ring-1 ring-[#F1D9D9]">

        <div class="mb-5">
            <h2 class="text-lg font-black text-[#3D2528]">
                Cari Siswa
            </h2>

            <p class="mt-1 text-sm text-[#8B7477]">
                Cari berdasarkan nama siswa atau filter status PKL.
            </p>
        </div>


        <form
            method="GET"
            action="{{ route('hubin.siswa') }}"
            class="grid gap-4 lg:grid-cols-[1fr_240px_auto_auto]"
        >

            {{-- SEARCH NAMA --}}
            <div>
                <label class="mb-2 block text-sm font-semibold text-[#5D4548]">
                    Nama Siswa
                </label>

                <input
                    type="text"
                    name="search"
                    value="{{ $search ?? '' }}"
                    placeholder="Cari nama siswa..."
                    class="w-full rounded-2xl border border-[#E8D4D4] bg-white px-4 py-3 text-sm text-[#3D2528] outline-none transition focus:border-[#9E2F37] focus:ring-2 focus:ring-[#9E2F37]/10"
                >
            </div>


            {{-- FILTER STATUS --}}
            <div>
                <label class="mb-2 block text-sm font-semibold text-[#5D4548]">
                    Status PKL
                </label>

                <select
                    name="status"
                    class="w-full rounded-2xl border border-[#E8D4D4] bg-white px-4 py-3 text-sm text-[#3D2528] outline-none transition focus:border-[#9E2F37] focus:ring-2 focus:ring-[#9E2F37]/10"
                >

                    <option value="">
                        Semua Status
                    </option>

                    <option
                        value="belum_mulai"
                        {{ ($status ?? '') === 'belum_mulai' ? 'selected' : '' }}
                    >
                        Belum Mulai
                    </option>

                    <option
                        value="berlangsung"
                        {{ ($status ?? '') === 'berlangsung' ? 'selected' : '' }}
                    >
                        Berlangsung
                    </option>

                    <option
                        value="selesai"
                        {{ ($status ?? '') === 'selesai' ? 'selected' : '' }}
                    >
                        Selesai
                    </option>

                </select>
            </div>


            {{-- TOMBOL CARI --}}
            <div class="flex items-end">
                <button
                    type="submit"
                    class="w-full rounded-2xl bg-[#9E2F37] px-5 py-3 text-sm font-bold text-white transition hover:bg-[#84262D]"
                >
                    Cari
                </button>
            </div>


            {{-- RESET --}}
            <div class="flex items-end">
                <a
                    href="{{ route('hubin.siswa') }}"
                    class="w-full rounded-2xl border border-[#E8D4D4] px-5 py-3 text-center text-sm font-bold text-[#6B5053] transition hover:bg-[#FFF8F3]"
                >
                    Reset
                </a>
            </div>

        </form>

    </div>


    {{-- TABEL DATA SISWA --}}
    <div class="mt-8 overflow-hidden rounded-3xl bg-white shadow-sm ring-1 ring-[#F1D9D9]">

        <div class="border-b border-[#F1D9D9] px-6 py-5">

            <h2 class="text-lg font-black text-[#3D2528]">
                Daftar Siswa
            </h2>

            <p class="mt-1 text-sm text-[#8B7477]">
                {{ $siswa->count() }} data ditemukan.
            </p>

        </div>


        @if($siswa->count())

            <div class="overflow-x-auto">

                <table class="w-full min-w-[1100px] text-left">

                    <thead class="bg-[#FFF8F3]">

                        <tr class="text-sm text-[#6B5053]">

                            <th class="px-6 py-4 font-bold">
                                Siswa
                            </th>

                            <th class="px-6 py-4 font-bold">
                                Kelas / Jurusan
                            </th>

                            <th class="px-6 py-4 font-bold">
                                Email
                            </th>

                            <th class="px-6 py-4 font-bold">
                                Perusahaan
                            </th>

                            <th class="px-6 py-4 font-bold">
                                Status PKL
                            </th>

                            <th class="px-6 py-4 font-bold">
                                Aksi
                            </th>

                        </tr>

                    </thead>


                    <tbody class="divide-y divide-[#F4E8E8]">

                        @foreach($siswa as $item)

                            @php
                                $pengajuanTerakhir = $item->pengajuan
                                    ->sortByDesc('id_pengajuan')
                                    ->first();

                                $pkl = $pengajuanTerakhir?->pkl;

                                $perusahaan = $pengajuanTerakhir?->perusahaan;
                            @endphp


                            <tr class="transition hover:bg-[#FFFDFC]">

                                {{-- SISWA --}}
                                <td class="px-6 py-5">

                                    <p class="font-bold text-[#3D2528]">
                                        {{ $item->nama_siswa }}
                                    </p>

                                    <p class="mt-1 text-xs text-[#8B7477]">
                                        NIS: {{ $item->nis }}
                                    </p>

                                </td>


                                {{-- KELAS / JURUSAN --}}
                                <td class="px-6 py-5">

                                    <p class="font-semibold text-[#3D2528]">
                                        {{ $item->kelas }}
                                    </p>

                                    <p class="mt-1 text-xs text-[#8B7477]">
                                        {{ $item->jurusan }}
                                    </p>

                                </td>


                                {{-- EMAIL --}}
                                <td class="px-6 py-5 text-sm text-[#6B5053]">
                                    {{ $item->user->email ?? '-' }}
                                </td>


                                {{-- PERUSAHAAN --}}
                                <td class="px-6 py-5">

                                    @if($perusahaan)

                                        <p class="font-semibold text-[#3D2528]">
                                            {{ $perusahaan->nama_perusahaan }}
                                        </p>

                                    @else

                                        <span class="text-sm text-[#9A8588]">
                                            Belum ada
                                        </span>

                                    @endif

                                </td>


                                {{-- STATUS PKL --}}
                                <td class="px-6 py-5">

                                    @if($pkl)

                                        @if($pkl->status === 'berlangsung')

                                            <span class="inline-flex rounded-full bg-green-100 px-3 py-1 text-xs font-bold text-green-700">
                                                Berlangsung
                                            </span>

                                        @elseif($pkl->status === 'selesai')

                                            <span class="inline-flex rounded-full bg-blue-100 px-3 py-1 text-xs font-bold text-blue-700">
                                                Selesai
                                            </span>

                                        @elseif($pkl->status === 'belum_mulai')

                                            <span class="inline-flex rounded-full bg-yellow-100 px-3 py-1 text-xs font-bold text-yellow-700">
                                                Belum Mulai
                                            </span>

                                        @else

                                            <span class="inline-flex rounded-full bg-gray-100 px-3 py-1 text-xs font-bold text-gray-600">
                                                {{ $pkl->status }}
                                            </span>

                                        @endif

                                    @else

                                        <span class="inline-flex rounded-full bg-gray-100 px-3 py-1 text-xs font-bold text-gray-600">
                                            Belum Ada PKL
                                        </span>

                                    @endif

                                </td>


                                {{-- AKSI --}}
                                <td class="px-6 py-5">

                                    <div class="flex flex-wrap gap-2">

                                        {{-- EDIT --}}
                                        <button
                                            type="button"
                                            onclick="document.getElementById('modalEdit{{ $item->id_siswa }}').classList.remove('hidden')"
                                            class="rounded-full border border-[#E8D4D4] px-4 py-2 text-xs font-bold text-[#6B5053] transition hover:bg-[#FFF8F3]"
                                        >
                                            Edit
                                        </button>


                                        {{-- HAPUS --}}
                                        <form
                                            action="{{ route('hubin.siswa.destroy', $item) }}"
                                            method="POST"
                                            onsubmit="return confirm('Yakin ingin menghapus siswa {{ addslashes($item->nama_siswa) }}?')"
                                        >

                                            @csrf
                                            @method('DELETE')

                                            <button
                                                type="submit"
                                                class="rounded-full bg-red-50 px-4 py-2 text-xs font-bold text-red-600 transition hover:bg-red-100"
                                            >
                                                Hapus
                                            </button>

                                        </form>

                                    </div>

                                </td>

                            </tr>


                            {{-- MODAL EDIT --}}
                            <div
                                id="modalEdit{{ $item->id_siswa }}"
                                class="fixed inset-0 z-[100] hidden overflow-y-auto bg-black/40 p-5"
                            >

                                <div class="flex min-h-full items-center justify-center">

                                    <div class="w-full max-w-2xl rounded-3xl bg-white p-6 shadow-2xl">

                                        {{-- HEADER MODAL --}}
                                        <div class="mb-6 flex items-start justify-between gap-4">

                                            <div>

                                                <h3 class="text-xl font-black text-[#3D2528]">
                                                    Edit Data Siswa
                                                </h3>

                                                <p class="mt-1 text-sm text-[#8B7477]">
                                                    Perbarui informasi siswa.
                                                </p>

                                            </div>


                                            <button
                                                type="button"
                                                onclick="document.getElementById('modalEdit{{ $item->id_siswa }}').classList.add('hidden')"
                                                class="text-2xl leading-none text-[#8B7477] hover:text-[#9E2F37]"
                                            >
                                                ×
                                            </button>

                                        </div>


                                        {{-- FORM EDIT --}}
                                        <form
                                            action="{{ route('hubin.siswa.update', $item) }}"
                                            method="POST"
                                            class="grid gap-4 md:grid-cols-2"
                                        >

                                            @csrf
                                            @method('PUT')


                                            {{-- NAMA --}}
                                            <div class="md:col-span-2">

                                                <label class="mb-2 block text-sm font-semibold text-[#5D4548]">
                                                    Nama Siswa
                                                </label>

                                                <input
                                                    type="text"
                                                    name="nama_siswa"
                                                    value="{{ $item->nama_siswa }}"
                                                    required
                                                    class="w-full rounded-2xl border border-[#E8D4D4] px-4 py-3 text-sm outline-none focus:border-[#9E2F37]"
                                                >

                                            </div>


                                            {{-- NIS --}}
                                            <div>

                                                <label class="mb-2 block text-sm font-semibold text-[#5D4548]">
                                                    NIS
                                                </label>

                                                <input
                                                    type="text"
                                                    name="nis"
                                                    value="{{ $item->nis }}"
                                                    required
                                                    class="w-full rounded-2xl border border-[#E8D4D4] px-4 py-3 text-sm outline-none focus:border-[#9E2F37]"
                                                >

                                            </div>


                                            {{-- KELAS --}}
                                            <div>

                                                <label class="mb-2 block text-sm font-semibold text-[#5D4548]">
                                                    Kelas
                                                </label>

                                                <input
                                                    type="text"
                                                    name="kelas"
                                                    value="{{ $item->kelas }}"
                                                    required
                                                    class="w-full rounded-2xl border border-[#E8D4D4] px-4 py-3 text-sm outline-none focus:border-[#9E2F37]"
                                                >

                                            </div>


                                            {{-- JURUSAN --}}
                                            <div>

                                                <label class="mb-2 block text-sm font-semibold text-[#5D4548]">
                                                    Jurusan
                                                </label>

                                                <input
                                                    type="text"
                                                    name="jurusan"
                                                    value="{{ $item->jurusan }}"
                                                    required
                                                    class="w-full rounded-2xl border border-[#E8D4D4] px-4 py-3 text-sm outline-none focus:border-[#9E2F37]"
                                                >

                                            </div>


                                            {{-- EMAIL --}}
                                            <div>

                                                <label class="mb-2 block text-sm font-semibold text-[#5D4548]">
                                                    Email
                                                </label>

                                                <input
                                                    type="email"
                                                    name="email"
                                                    value="{{ $item->user->email ?? '' }}"
                                                    required
                                                    class="w-full rounded-2xl border border-[#E8D4D4] px-4 py-3 text-sm outline-none focus:border-[#9E2F37]"
                                                >

                                            </div>


                                            {{-- TOMBOL --}}
                                            <div class="md:col-span-2 flex justify-end gap-3 pt-2">

                                                <button
                                                    type="button"
                                                    onclick="document.getElementById('modalEdit{{ $item->id_siswa }}').classList.add('hidden')"
                                                    class="rounded-full border border-[#E8D4D4] px-5 py-3 text-sm font-bold text-[#6B5053] hover:bg-[#FFF8F3]"
                                                >
                                                    Batal
                                                </button>

                                                <button
                                                    type="submit"
                                                    class="rounded-full bg-[#9E2F37] px-6 py-3 text-sm font-bold text-white hover:bg-[#84262D]"
                                                >
                                                    Simpan Perubahan
                                                </button>

                                            </div>

                                        </form>

                                    </div>

                                </div>

                            </div>

                        @endforeach

                    </tbody>

                </table>

            </div>

        @else

            {{-- DATA KOSONG --}}
            <div class="px-6 py-16 text-center">

                <div class="mx-auto flex h-16 w-16 items-center justify-center rounded-full bg-[#FFF1F1] text-2xl">
                    🔍
                </div>

                <h3 class="mt-4 text-lg font-black text-[#3D2528]">
                    Data tidak ditemukan
                </h3>

                <p class="mt-2 text-sm text-[#8B7477]">
                    Coba gunakan kata kunci atau filter yang berbeda.
                </p>

            </div>

        @endif

    </div>

</div>


{{-- ========================================================= --}}
{{-- MODAL TAMBAH SISWA --}}
{{-- ========================================================= --}}

<div
    id="modalTambahSiswa"
    class="fixed inset-0 z-[100] hidden overflow-y-auto bg-black/40 p-5"
>

    <div class="flex min-h-full items-center justify-center">

        <div class="w-full max-w-2xl rounded-3xl bg-white p-6 shadow-2xl">

            {{-- HEADER --}}
            <div class="mb-6 flex items-start justify-between gap-4">

                <div>

                    <h2 class="text-xl font-black text-[#3D2528]">
                        Tambah Siswa
                    </h2>

                    <p class="mt-1 text-sm text-[#8B7477]">
                        Tambahkan akun dan data siswa baru.
                    </p>

                </div>


                <button
                    type="button"
                    onclick="document.getElementById('modalTambahSiswa').classList.add('hidden')"
                    class="text-2xl leading-none text-[#8B7477] hover:text-[#9E2F37]"
                >
                    ×
                </button>

            </div>


            {{-- FORM TAMBAH --}}
            <form
                action="{{ route('hubin.siswa.store') }}"
                method="POST"
                class="grid gap-4 md:grid-cols-2"
            >

                @csrf


                {{-- NAMA --}}
                <div class="md:col-span-2">

                    <label class="mb-2 block text-sm font-semibold text-[#5D4548]">
                        Nama Siswa
                    </label>

                    <input
                        type="text"
                        name="nama_siswa"
                        value="{{ old('nama_siswa') }}"
                        placeholder="Nama lengkap siswa"
                        required
                        class="w-full rounded-2xl border border-[#E8D4D4] px-4 py-3 text-sm outline-none focus:border-[#9E2F37]"
                    >

                </div>


                {{-- NIS --}}
                <div>

                    <label class="mb-2 block text-sm font-semibold text-[#5D4548]">
                        NIS
                    </label>

                    <input
                        type="text"
                        name="nis"
                        value="{{ old('nis') }}"
                        placeholder="Contoh: 12345678"
                        required
                        class="w-full rounded-2xl border border-[#E8D4D4] px-4 py-3 text-sm outline-none focus:border-[#9E2F37]"
                    >

                </div>


                {{-- KELAS --}}
                <div>

                    <label class="mb-2 block text-sm font-semibold text-[#5D4548]">
                        Kelas
                    </label>

                    <input
                        type="text"
                        name="kelas"
                        value="{{ old('kelas') }}"
                        placeholder="XII RPL 2"
                        required
                        class="w-full rounded-2xl border border-[#E8D4D4] px-4 py-3 text-sm outline-none focus:border-[#9E2F37]"
                    >

                </div>


                {{-- JURUSAN --}}
                <div>

                    <label class="mb-2 block text-sm font-semibold text-[#5D4548]">
                        Jurusan
                    </label>

                    <input
                        type="text"
                        name="jurusan"
                        value="{{ old('jurusan') }}"
                        placeholder="RPL"
                        required
                        class="w-full rounded-2xl border border-[#E8D4D4] px-4 py-3 text-sm outline-none focus:border-[#9E2F37]"
                    >

                </div>


                {{-- EMAIL --}}
                <div>

                    <label class="mb-2 block text-sm font-semibold text-[#5D4548]">
                        Email
                    </label>

                    <input
                        type="email"
                        name="email"
                        value="{{ old('email') }}"
                        placeholder="siswa@email.com"
                        required
                        class="w-full rounded-2xl border border-[#E8D4D4] px-4 py-3 text-sm outline-none focus:border-[#9E2F37]"
                    >

                </div>


                {{-- PASSWORD --}}
                <div class="md:col-span-2">

                    <label class="mb-2 block text-sm font-semibold text-[#5D4548]">
                        Password
                    </label>

                    <input
                        type="password"
                        name="password"
                        placeholder="Minimal 8 karakter"
                        minlength="8"
                        required
                        class="w-full rounded-2xl border border-[#E8D4D4] px-4 py-3 text-sm outline-none focus:border-[#9E2F37]"
                    >

                </div>


                {{-- TOMBOL --}}
                <div class="md:col-span-2 flex justify-end gap-3 pt-2">

                    <button
                        type="button"
                        onclick="document.getElementById('modalTambahSiswa').classList.add('hidden')"
                        class="rounded-full border border-[#E8D4D4] px-5 py-3 text-sm font-bold text-[#6B5053] transition hover:bg-[#FFF8F3]"
                    >
                        Batal
                    </button>


                    <button
                        type="submit"
                        class="rounded-full bg-[#9E2F37] px-6 py-3 text-sm font-bold text-white transition hover:bg-[#84262D]"
                    >
                        Simpan Siswa
                    </button>

                </div>

            </form>

        </div>

    </div>

</div>

@endsection
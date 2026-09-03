@extends('layouts.app')

@section('title', 'Dashboard Kaprog')

@section('content')

<div class="mx-auto max-w-7xl px-5 py-10 lg:px-8">

    {{-- HEADER --}}
    <div class="mb-8">
        <p class="text-sm font-semibold text-[#9E2F37]">
            Kaprog
        </p>

        <h1 class="mt-1 text-3xl font-black tracking-tight text-[#3D2528]">
            Pengajuan PKL
        </h1>

        <p class="mt-2 text-[#8B7477]">
            Kelola pengajuan dan pantau data PKL siswa.
        </p>
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


    {{-- STATISTIK --}}
    <div class="grid gap-5 sm:grid-cols-2 lg:grid-cols-6">

        <div class="rounded-3xl bg-white p-5 shadow-sm ring-1 ring-[#F1D9D9]">
            <p class="text-sm text-[#8B7477]">
                Total Siswa
            </p>

            <p class="mt-2 text-3xl font-black text-[#3D2528]">
                {{ $totalSiswa }}
            </p>
        </div>


        <div class="rounded-3xl bg-white p-5 shadow-sm ring-1 ring-[#F1D9D9]">
            <p class="text-sm text-[#8B7477]">
                Perusahaan
            </p>

            <p class="mt-2 text-3xl font-black text-[#3D2528]">
                {{ $totalPerusahaan }}
            </p>
        </div>


        <div class="rounded-3xl bg-white p-5 shadow-sm ring-1 ring-[#F1D9D9]">
            <p class="text-sm text-[#8B7477]">
                Pengajuan
            </p>

            <p class="mt-2 text-3xl font-black text-[#3D2528]">
                {{ $totalPengajuan }}
            </p>
        </div>


        <div class="rounded-3xl bg-white p-5 shadow-sm ring-1 ring-[#F1D9D9]">
            <p class="text-sm text-[#8B7477]">
                Total PKL
            </p>

            <p class="mt-2 text-3xl font-black text-[#3D2528]">
                {{ $totalPKL }}
            </p>
        </div>


        <div class="rounded-3xl bg-white p-5 shadow-sm ring-1 ring-[#F1D9D9]">
            <p class="text-sm text-[#8B7477]">
                Berlangsung
            </p>

            <p class="mt-2 text-3xl font-black text-green-600">
                {{ $pklBerlangsung }}
            </p>
        </div>


        <div class="rounded-3xl bg-white p-5 shadow-sm ring-1 ring-[#F1D9D9]">
            <p class="text-sm text-[#8B7477]">
                Selesai
            </p>

            <p class="mt-2 text-3xl font-black text-blue-600">
                {{ $pklSelesai }}
            </p>
        </div>

    </div>


    {{-- SEARCH + FILTER --}}
    <div class="mt-8 rounded-3xl bg-white p-6 shadow-sm ring-1 ring-[#F1D9D9]">

        <div class="mb-5">
            <h2 class="text-lg font-black text-[#3D2528]">
                Cari Data Siswa
            </h2>

            <p class="mt-1 text-sm text-[#8B7477]">
                Cari berdasarkan nama siswa atau filter status PKL.
            </p>
        </div>


        <form
            method="GET"
            action="{{ route('kaprog.dashboard') }}"
            class="grid gap-4 lg:grid-cols-[1fr_240px_auto_auto]"
        >

            {{-- SEARCH --}}
            <div>
                <label class="mb-2 block text-sm font-semibold text-[#5D4548]">
                    Nama Siswa
                </label>

                <input
                    type="text"
                    name="search"
                    value="{{ $search ?? '' }}"
                    placeholder="Cari nama siswa..."
                    class="w-full rounded-2xl border border-[#E8D4D4] px-4 py-3 text-sm outline-none transition focus:border-[#9E2F37] focus:ring-2 focus:ring-[#9E2F37]/10"
                >
            </div>


            {{-- STATUS --}}
            <div>
                <label class="mb-2 block text-sm font-semibold text-[#5D4548]">
                    Status PKL
                </label>

                <select
                    name="status"
                    class="w-full rounded-2xl border border-[#E8D4D4] bg-white px-4 py-3 text-sm outline-none transition focus:border-[#9E2F37] focus:ring-2 focus:ring-[#9E2F37]/10"
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


            {{-- SEARCH BUTTON --}}
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
                    href="{{ route('kaprog.dashboard') }}"
                    class="w-full rounded-2xl border border-[#E8D4D4] px-5 py-3 text-center text-sm font-bold text-[#6B5053] transition hover:bg-[#FFF8F3]"
                >
                    Reset
                </a>
            </div>

        </form>

    </div>


    {{-- TABEL PENGAJUAN --}}
    <div class="mt-8 overflow-hidden rounded-3xl bg-white shadow-sm ring-1 ring-[#F1D9D9]">

        <div class="border-b border-[#F1D9D9] px-6 py-5">
            <h2 class="text-lg font-black text-[#3D2528]">
                Daftar Pengajuan
            </h2>

            <p class="mt-1 text-sm text-[#8B7477]">
                {{ $pengajuan->count() }} data ditemukan.
            </p>
        </div>


        @if($pengajuan->count())

            <div class="overflow-x-auto">

                <table class="w-full min-w-[1000px] text-left">

                    <thead class="bg-[#FFF8F3]">
                        <tr class="text-sm text-[#6B5053]">

                            <th class="px-6 py-4 font-bold">
                                Siswa
                            </th>

                            <th class="px-6 py-4 font-bold">
                                Perusahaan
                            </th>

                            <th class="px-6 py-4 font-bold">
                                Tanggal Pengajuan
                            </th>

                            <th class="px-6 py-4 font-bold">
                                Status Kaprog
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

                        @foreach($pengajuan as $item)

                            <tr class="text-sm">

                                {{-- SISWA --}}
                                <td class="px-6 py-5">

                                    <p class="font-bold text-[#3D2528]">
                                        {{ $item->siswa->nama_siswa ?? '-' }}
                                    </p>

                                    <p class="mt-1 text-xs text-[#8B7477]">
                                        {{ $item->siswa->nis ?? '-' }}
                                        •
                                        {{ $item->siswa->kelas ?? '-' }}
                                    </p>

                                </td>


                                {{-- PERUSAHAAN --}}
                                <td class="px-6 py-5">

                                    <p class="font-semibold text-[#3D2528]">
                                        {{ $item->perusahaan->nama_perusahaan ?? '-' }}
                                    </p>

                                </td>


                                {{-- TANGGAL --}}
                                <td class="px-6 py-5 text-[#6B5053]">

                                    {{ $item->tanggal_pengajuan
                                        ? $item->tanggal_pengajuan->format('d-m-Y')
                                        : '-'
                                    }}

                                </td>


                                {{-- STATUS KAPROG --}}
                                <td class="px-6 py-5">

                                    @if($item->status_kaprog === 'disetujui')

                                        <span class="inline-flex rounded-full bg-green-100 px-3 py-1 text-xs font-bold text-green-700">
                                            Disetujui
                                        </span>

                                    @elseif($item->status_kaprog === 'ditolak')

                                        <span class="inline-flex rounded-full bg-red-100 px-3 py-1 text-xs font-bold text-red-700">
                                            Ditolak
                                        </span>

                                    @else

                                        <span class="inline-flex rounded-full bg-yellow-100 px-3 py-1 text-xs font-bold text-yellow-700">
                                            Menunggu
                                        </span>

                                    @endif

                                </td>


                                {{-- STATUS PKL --}}
                                <td class="px-6 py-5">

                                    @if($item->pkl)

                                        @if($item->pkl->status === 'berlangsung')

                                            <span class="inline-flex rounded-full bg-green-100 px-3 py-1 text-xs font-bold text-green-700">
                                                Berlangsung
                                            </span>

                                        @elseif($item->pkl->status === 'selesai')

                                            <span class="inline-flex rounded-full bg-blue-100 px-3 py-1 text-xs font-bold text-blue-700">
                                                Selesai
                                            </span>

                                        @else

                                            <span class="inline-flex rounded-full bg-yellow-100 px-3 py-1 text-xs font-bold text-yellow-700">
                                                Belum Mulai
                                            </span>

                                        @endif

                                    @else

                                        <span class="text-xs font-semibold text-[#9A8588]">
                                            Belum ditempatkan
                                        </span>

                                    @endif

                                </td>


                                {{-- AKSI --}}
                                <td class="px-6 py-5">

                                    @if($item->status_kaprog === 'menunggu')

                                        <div class="flex flex-wrap gap-2">

                                            <form
                                                action="{{ route('kaprog.setujui', $item) }}"
                                                method="POST"
                                            >
                                                @csrf
                                                @method('PUT')

                                                <button
                                                    type="submit"
                                                    class="rounded-full bg-green-600 px-4 py-2 text-xs font-bold text-white transition hover:bg-green-700"
                                                >
                                                    Setujui
                                                </button>
                                            </form>


                                            <form
                                                action="{{ route('kaprog.tolak', $item) }}"
                                                method="POST"
                                            >
                                                @csrf
                                                @method('PUT')

                                                <button
                                                    type="submit"
                                                    class="rounded-full bg-red-600 px-4 py-2 text-xs font-bold text-white transition hover:bg-red-700"
                                                >
                                                    Tolak
                                                </button>
                                            </form>

                                        </div>

                                    @else

                                        <span class="text-xs font-semibold text-[#9A8588]">
                                            Tidak ada tindakan
                                        </span>

                                    @endif

                                </td>

                            </tr>

                        @endforeach

                    </tbody>

                </table>

            </div>

        @else

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


    {{-- JUMLAH SISWA PER PERUSAHAAN --}}
    <div class="mt-8 rounded-3xl bg-white p-6 shadow-sm ring-1 ring-[#F1D9D9]">

        <div class="mb-5">
            <h2 class="text-lg font-black text-[#3D2528]">
                Jumlah Siswa per Perusahaan
            </h2>

            <p class="mt-1 text-sm text-[#8B7477]">
                Rekap siswa berdasarkan perusahaan yang disetujui.
            </p>
        </div>


        @if($siswaPerPerusahaan->count())

            <div class="grid gap-4 md:grid-cols-2 lg:grid-cols-3">

                @foreach($siswaPerPerusahaan as $data)

                    <div class="rounded-2xl border border-[#F1D9D9] bg-[#FFF8F3] p-5">

                        <p class="font-bold text-[#3D2528]">
                            {{ $data->nama_perusahaan }}
                        </p>

                        <p class="mt-3 text-3xl font-black text-[#9E2F37]">
                            {{ $data->jumlah_siswa }}
                        </p>

                        <p class="text-xs text-[#8B7477]">
                            siswa
                        </p>

                    </div>

                @endforeach

            </div>

        @else

            <p class="text-sm text-[#8B7477]">
                Belum ada data perusahaan dengan siswa yang disetujui.
            </p>

        @endif

    </div>

</div>

@endsection
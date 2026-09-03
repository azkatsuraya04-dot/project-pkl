@extends('layouts.app')

@section('title', 'Dashboard Hubin')

@section('content')

<div class="mx-auto max-w-7xl px-5 py-10 lg:px-8">

    {{-- HEADER --}}
    <div class="mb-8">

        <p class="text-sm font-bold uppercase tracking-widest text-[#D96C73]">
            Hubin
        </p>

        <h1 class="mt-2 text-4xl font-black text-[#3D2528]">
            Proses Pengajuan PKL
        </h1>

        <p class="mt-2 text-[#7B6669]">
            Kelola proses pengajuan dan penempatan siswa.
        </p>

    </div>


    {{-- SUCCESS --}}
    @if (session('success'))

        <div class="mb-6 rounded-2xl bg-green-50 px-5 py-4 text-sm font-semibold text-green-700">
            {{ session('success') }}
        </div>

    @endif


    {{-- ERROR --}}
    @if (session('error'))

        <div class="mb-6 rounded-2xl bg-red-50 px-5 py-4 text-sm font-semibold text-red-700">
            {{ session('error') }}
        </div>

    @endif


    {{-- VALIDATION --}}
    @if ($errors->any())

        <div class="mb-6 rounded-2xl bg-red-50 px-5 py-4 text-sm text-red-700">

            <ul class="list-disc pl-5">

                @foreach ($errors->all() as $error)

                    <li>
                        {{ $error }}
                    </li>

                @endforeach

            </ul>

        </div>

    @endif


    {{-- DATA PENGAJUAN --}}
    <div class="space-y-6">

        @forelse ($pengajuan as $item)

            <div class="rounded-[1.75rem] bg-white p-7 shadow-sm ring-1 ring-[#F1D9D9]">

                {{-- INFORMASI --}}
                <div class="grid gap-6 lg:grid-cols-3">


                    {{-- SISWA --}}
                    <div>

                        <p class="text-xs font-bold uppercase tracking-wider text-[#9B8587]">
                            Siswa
                        </p>

                        <h2 class="mt-2 text-xl font-black text-[#3D2528]">
                            {{ $item->siswa->nama_siswa }}
                        </h2>

                        <p class="mt-1 text-sm text-[#8B7477]">
                            {{ $item->siswa->kelas }}
                            •
                            {{ $item->siswa->jurusan }}
                        </p>

                    </div>


                    {{-- PERUSAHAAN --}}
                    <div>

                        <p class="text-xs font-bold uppercase tracking-wider text-[#9B8587]">
                            Perusahaan
                        </p>

                        <h2 class="mt-2 text-xl font-black text-[#3D2528]">
                            {{ $item->perusahaan->nama_perusahaan }}
                        </h2>

                        <p class="mt-1 text-sm text-[#8B7477]">
                            {{ $item->perusahaan->alamat }}
                        </p>

                    </div>


                    {{-- STATUS --}}
                    <div>

                        <p class="text-xs font-bold uppercase tracking-wider text-[#9B8587]">
                            Status
                        </p>

                        <div class="mt-3 space-y-2">

                            <span class="block rounded-full bg-green-100 px-4 py-2 text-xs font-bold text-green-700">
                                Kaprog:
                                {{ str_replace('_', ' ', $item->status_kaprog) }}
                            </span>

                            <span class="block rounded-full bg-[#F5C2C7] px-4 py-2 text-xs font-bold text-[#9E2F37]">
                                Hubin:
                                {{ str_replace('_', ' ', $item->status_hubin) }}
                            </span>

                            <span class="block rounded-full bg-[#FFF1F2] px-4 py-2 text-xs font-bold text-[#9E2F37]">
                                Perusahaan:
                                {{ str_replace('_', ' ', $item->status_perusahaan) }}
                            </span>

                        </div>

                    </div>

                </div>


                {{-- JIKA SUDAH ADA PKL --}}
                @if ($item->pkl)

                    <div class="mt-6 rounded-2xl bg-green-50 p-5">

                        <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">

                            <div>

                                <p class="text-xs font-bold uppercase tracking-wider text-green-700">
                                    Pengajuan Diterima
                                </p>

                                <h3 class="mt-2 text-lg font-black text-[#3D2528]">
                                    Penempatan PKL Berhasil
                                </h3>

                                <p class="mt-2 text-sm text-[#6B7A6D]">
                                    Pembimbing:
                                    <span class="font-bold">
                                        {{ $item->pkl->pembimbing->nama_pembimbing }}
                                    </span>
                                </p>

                                <p class="mt-1 text-sm text-[#6B7A6D]">
                                    Periode:
                                    {{ $item->pkl->tanggal_mulai->format('d M Y') }}
                                    -
                                    {{ $item->pkl->tanggal_selesai->format('d M Y') }}
                                </p>

                            </div>


                            <div>

                                <span class="rounded-full bg-white px-5 py-2.5 text-sm font-bold text-green-700">
                                    {{ str_replace('_', ' ', $item->pkl->status) }}
                                </span>

                            </div>

                        </div>

                    </div>


                @else


                    {{-- FORM PENEMPATAN --}}
                    <div class="mt-6 border-t border-[#F1D9D9] pt-6">

                        <form
                            action="{{ route('hubin.proses', $item->id_pengajuan) }}"
                            method="POST"
                        >

                            @csrf

                            @method('PUT')


                            <div class="grid gap-4 md:grid-cols-[1fr_auto] md:items-end">

                                <div>

                                    <label
                                        for="pembimbing-{{ $item->id_pengajuan }}"
                                        class="mb-2 block text-sm font-bold text-[#3D2528]"
                                    >
                                        Pilih Pembimbing
                                    </label>

                                    <select
                                        id="pembimbing-{{ $item->id_pengajuan }}"
                                        name="pembimbing"
                                        required
                                        class="w-full rounded-2xl border border-[#E8D6D7] bg-[#FFF8F3] px-4 py-3 text-sm outline-none focus:border-[#D96C73]"
                                    >

                                        <option value="">
                                            Pilih pembimbing
                                        </option>

                                        @foreach ($pembimbing as $guru)

                                            <option value="{{ $guru->id_pembimbing }}">
                                                {{ $guru->nama_pembimbing }}
                                            </option>

                                        @endforeach

                                    </select>

                                </div>


                                <button
                                    type="submit"
                                    class="rounded-full bg-[#9E2F37] px-6 py-3 text-sm font-bold text-white transition hover:bg-[#84262D]"
                                >
                                    Setujui & Tempatkan
                                </button>

                            </div>

                        </form>


                        {{-- TOLAK --}}
                        <form
                            action="{{ route('hubin.tolak', $item->id_pengajuan) }}"
                            method="POST"
                            class="mt-3"
                        >

                            @csrf

                            @method('PUT')

                            <button
                                type="submit"
                                class="rounded-full bg-red-100 px-5 py-2.5 text-sm font-bold text-red-700 transition hover:bg-red-200"
                            >
                                Tolak Pengajuan
                            </button>

                        </form>

                    </div>

                @endif

            </div>


        @empty

            <div class="rounded-[1.75rem] bg-white p-10 text-center shadow-sm ring-1 ring-[#F1D9D9]">

                <div class="text-5xl">
                    📋
                </div>

                <h2 class="mt-4 text-xl font-black text-[#3D2528]">
                    Belum Ada Pengajuan
                </h2>

                <p class="mt-2 text-sm text-[#8B7477]">
                    Belum ada pengajuan yang disetujui Kaprog.
                </p>

            </div>

        @endforelse

    </div>

</div>

@endsection
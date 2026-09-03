@extends('layouts.app')

@section('title', 'Pengajuan PKL')

@section('content')

<div class="mx-auto max-w-7xl px-5 py-10 lg:px-8">

    {{-- HEADER --}}
    <div class="mb-8">

        <p class="text-sm font-bold uppercase tracking-widest text-[#D96C73]">
            Siswa
        </p>

        <h1 class="mt-2 text-4xl font-black text-[#3D2528]">
            Pengajuan PKL
        </h1>

        <p class="mt-2 text-[#7B6669]">
            Pantau perkembangan pengajuan Praktik Kerja Lapangan kamu.
        </p>

    </div>


    @forelse ($pengajuan as $item)

        <div class="mb-6 rounded-[1.75rem] bg-white p-7 shadow-sm ring-1 ring-[#F1D9D9]">

            {{-- HEADER PENGAJUAN --}}
            <div class="flex flex-col justify-between gap-5 md:flex-row">

                <div>

                    <p class="text-sm text-[#8B7477]">
                        Perusahaan tujuan
                    </p>

                    <h2 class="mt-1 text-2xl font-black text-[#3D2528]">
                        {{ $item->perusahaan->nama_perusahaan }}
                    </h2>

                    <p class="mt-2 text-sm text-[#8B7477]">
                        Diajukan:
                        {{ $item->tanggal_pengajuan->format('d M Y') }}
                    </p>

                </div>


                {{-- STATUS UTAMA --}}
                <div class="rounded-2xl bg-green-50 px-5 py-4">

                    <p class="text-xs font-bold uppercase text-green-700">
                        Status
                    </p>

                    <p class="mt-1 font-black text-green-700">

                        @if ($item->status_perusahaan === 'disetujui')

                            Disetujui

                        @elseif ($item->status_perusahaan === 'ditolak')

                            Ditolak

                        @else

                            Menunggu

                        @endif

                    </p>

                </div>

            </div>


            {{-- STATUS PROSES --}}
            <div class="mt-7 grid gap-4 md:grid-cols-3">

                {{-- KAPROG --}}
                <div class="rounded-2xl bg-[#FFF8F3] p-5">

                    <p class="text-xs font-bold uppercase text-[#9B8587]">
                        Kaprog
                    </p>

                    <p class="mt-2 font-black
                        {{ $item->status_kaprog === 'disetujui'
                            ? 'text-green-700'
                            : ($item->status_kaprog === 'ditolak'
                                ? 'text-red-700'
                                : 'text-[#9E2F37]') }}"
                    >

                        {{ str_replace('_', ' ', $item->status_kaprog) }}

                    </p>

                </div>


                {{-- HUBIN --}}
                <div class="rounded-2xl bg-[#FFF8F3] p-5">

                    <p class="text-xs font-bold uppercase text-[#9B8587]">
                        Hubin
                    </p>

                    <p class="mt-2 font-black
                        {{ $item->status_hubin === 'surat_dikirim'
                            ? 'text-green-700'
                            : 'text-[#9E2F37]' }}"
                    >

                        {{ str_replace('_', ' ', $item->status_hubin) }}

                    </p>

                </div>


                {{-- PERUSAHAAN --}}
                <div class="rounded-2xl bg-[#FFF8F3] p-5">

                    <p class="text-xs font-bold uppercase text-[#9B8587]">
                        Perusahaan
                    </p>

                    <p class="mt-2 font-black
                        {{ $item->status_perusahaan === 'disetujui'
                            ? 'text-green-700'
                            : ($item->status_perusahaan === 'ditolak'
                                ? 'text-red-700'
                                : 'text-[#9E2F37]') }}"
                    >

                        {{ str_replace('_', ' ', $item->status_perusahaan) }}

                    </p>

                </div>

            </div>


            {{-- PKL --}}
            @if ($item->pkl)

                <div class="mt-6 rounded-2xl bg-[#F5C2C7] p-5">

                    <p class="text-xs font-bold uppercase tracking-wider text-[#9E2F37]">
                        Penempatan PKL
                    </p>

                    <div class="mt-4 grid gap-4 md:grid-cols-4">

                        <div>

                            <p class="text-xs text-[#6E4448]">
                                Pembimbing
                            </p>

                            <p class="font-black text-[#3D2528]">
                                {{ $item->pkl->pembimbing->nama_pembimbing }}
                            </p>

                        </div>


                        <div>

                            <p class="text-xs text-[#6E4448]">
                                Mulai
                            </p>

                            <p class="font-black text-[#3D2528]">
                                {{ $item->pkl->tanggal_mulai->format('d M Y') }}
                            </p>

                        </div>


                        <div>

                            <p class="text-xs text-[#6E4448]">
                                Selesai
                            </p>

                            <p class="font-black text-[#3D2528]">
                                {{ $item->pkl->tanggal_selesai->format('d M Y') }}
                            </p>

                        </div>


                        <div>

                            <p class="text-xs text-[#6E4448]">
                                Status PKL
                            </p>

                            <p class="font-black text-green-700">
                                {{ str_replace('_', ' ', $item->pkl->status) }}
                            </p>

                        </div>

                    </div>

                </div>

            @endif


            {{-- NILAI --}}
            @if ($item->pkl && $item->pkl->nilai)

                <div class="mt-4 rounded-2xl bg-[#3D2528] p-5 text-white">

                    <p class="text-xs font-bold uppercase tracking-wider text-[#F5C2C7]">
                        Nilai PKL
                    </p>

                    <div class="mt-2 flex items-end gap-2">

                        <span class="text-4xl font-black">
                            {{ $item->pkl->nilai->nilai }}
                        </span>

                        <span class="pb-1 text-white/60">
                            / 100
                        </span>

                    </div>

                    <p class="mt-3 text-sm leading-6 text-white/70">
                        {{ $item->pkl->nilai->catatan ?? 'Tidak ada catatan.' }}
                    </p>

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
                Kamu belum memiliki pengajuan PKL.
            </p>

            <a
                href="{{ route('siswa.perusahaan') }}"
                class="mt-6 inline-block rounded-full bg-[#9E2F37] px-6 py-3 text-sm font-bold text-white"
            >
                Cari Perusahaan
            </a>

        </div>

    @endforelse

</div>

@endsection
@extends('layouts.app')

@section('title', 'Dashboard Siswa')

@section('content')

<div class="mx-auto max-w-7xl px-5 py-10 lg:px-8">

    {{-- HERO --}}
    <section class="overflow-hidden rounded-[2rem] bg-[#9E2F37] px-6 py-10 text-white shadow-lg sm:px-10">

        <div class="grid items-center gap-8 lg:grid-cols-[1.5fr_1fr]">

            <div>

                <p class="mb-3 text-sm font-bold uppercase tracking-[0.2em] text-[#F5C2C7]">
                    Dashboard Siswa
                </p>

                <h1 class="text-4xl font-black leading-tight sm:text-5xl">
                    Halo, {{ $siswa->nama_siswa }} 👋
                </h1>

                <p class="mt-4 max-w-xl text-base leading-7 text-white/80">
                    Pantau pengajuan, penempatan, pembimbing,
                    dan hasil PKL kamu dalam satu tempat.
                </p>

            </div>

            <div class="hidden justify-end lg:flex">

                <div class="rounded-[2rem] bg-white/10 px-8 py-6 text-right backdrop-blur">

                    <p class="text-sm text-white/70">
                        Kelas
                    </p>

                    <p class="mt-1 text-3xl font-black">
                        {{ $siswa->kelas }}
                    </p>

                    <p class="mt-1 text-sm text-white/70">
                        {{ $siswa->jurusan }}
                    </p>

                </div>

            </div>

        </div>

    </section>


    {{-- STATISTIK --}}
    <section class="mt-6 grid gap-4 sm:grid-cols-2 lg:grid-cols-4">

        <div class="rounded-[1.5rem] bg-white p-6 shadow-sm ring-1 ring-[#F1D9D9]">

            <p class="text-sm font-semibold text-[#8B7477]">
                Pengajuan
            </p>

            <p class="mt-2 text-4xl font-black text-[#9E2F37]">
                {{ $pengajuan ? '1' : '0' }}
            </p>

        </div>


        <div class="rounded-[1.5rem] bg-white p-6 shadow-sm ring-1 ring-[#F1D9D9]">

            <p class="text-sm font-semibold text-[#8B7477]">
                Status PKL
            </p>

            <p class="mt-2 text-2xl font-black text-[#3D2528]">
                {{ $pengajuan?->pkl?->status ?? 'Belum ada' }}
            </p>

        </div>


        <div class="rounded-[1.5rem] bg-white p-6 shadow-sm ring-1 ring-[#F1D9D9]">

            <p class="text-sm font-semibold text-[#8B7477]">
                Pembimbing
            </p>

            <p class="mt-2 text-xl font-black text-[#3D2528]">
                {{ $pengajuan?->pkl?->pembimbing?->nama_pembimbing ?? 'Belum ditentukan' }}
            </p>

        </div>


        <div class="rounded-[1.5rem] bg-[#F5C2C7] p-6 shadow-sm">

            <p class="text-sm font-semibold text-[#6E4448]">
                Nilai PKL
            </p>

            <p class="mt-2 text-4xl font-black text-[#9E2F37]">
                {{ $pengajuan?->pkl?->nilai?->nilai ?? '-' }}
            </p>

        </div>

    </section>


    <section class="mt-6 grid gap-6 lg:grid-cols-3">

        {{-- STATUS --}}
        <div class="rounded-[1.75rem] bg-white p-7 shadow-sm ring-1 ring-[#F1D9D9] lg:col-span-2">

            <div class="flex items-center justify-between">

                <div>
                    <p class="text-sm font-bold uppercase tracking-wider text-[#D96C73]">
                        Perjalanan Pengajuan
                    </p>

                    <h2 class="mt-1 text-2xl font-black text-[#3D2528]">
                        Status Pengajuan PKL
                    </h2>
                </div>

            </div>


            @if ($pengajuan)

                <div class="mt-8 space-y-4">

                    {{-- KAPROG --}}
                    <div class="flex items-center gap-4 rounded-2xl bg-[#FFF8F3] p-4">

                        <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-full bg-[#9E2F37] text-white">
                            ✓
                        </div>

                        <div class="flex-1">

                            <p class="font-bold text-[#3D2528]">
                                Persetujuan Kaprog
                            </p>

                            <p class="text-sm text-[#8B7477]">
                                {{ str_replace('_', ' ', $pengajuan->status_kaprog) }}
                            </p>

                        </div>

                    </div>


                    {{-- HUBIN --}}
                    <div class="flex items-center gap-4 rounded-2xl bg-[#FFF8F3] p-4">

                        <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-full bg-[#D96C73] text-white">
                            ✓
                        </div>

                        <div class="flex-1">

                            <p class="font-bold text-[#3D2528]">
                                Proses Hubin
                            </p>

                            <p class="text-sm text-[#8B7477]">
                                {{ str_replace('_', ' ', $pengajuan->status_hubin) }}
                            </p>

                        </div>

                    </div>


                    {{-- PERUSAHAAN --}}
                    <div class="flex items-center gap-4 rounded-2xl bg-[#FFF8F3] p-4">

                        <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-full bg-[#F5C2C7] text-[#9E2F37]">
                            {{ $pengajuan->status_perusahaan === 'disetujui' ? '✓' : '•' }}
                        </div>

                        <div class="flex-1">

                            <p class="font-bold text-[#3D2528]">
                                Keputusan Perusahaan
                            </p>

                            <p class="text-sm text-[#8B7477]">
                                {{ str_replace('_', ' ', $pengajuan->status_perusahaan) }}
                            </p>

                        </div>

                    </div>

                </div>

            @else

                <div class="mt-8 rounded-2xl bg-[#FFF8F3] p-6">

                    <p class="font-bold text-[#3D2528]">
                        Belum ada pengajuan PKL
                    </p>

                    <p class="mt-1 text-sm text-[#8B7477]">
                        Silakan pilih perusahaan dan ajukan PKL.
                    </p>

                </div>

            @endif

        </div>


        {{-- PERUSAHAAN --}}
        <div class="rounded-[1.75rem] bg-[#3D2528] p-7 text-white">

            <p class="text-sm font-bold uppercase tracking-wider text-[#F5C2C7]">
                Tempat PKL
            </p>

            <h2 class="mt-2 text-2xl font-black">
                {{ $pengajuan?->perusahaan?->nama_perusahaan ?? 'Belum ada' }}
            </h2>

            @if ($pengajuan?->perusahaan)

                <p class="mt-4 text-sm leading-6 text-white/70">
                    {{ $pengajuan->perusahaan->alamat }}
                </p>

                <div class="mt-6 space-y-2 text-sm">

                    <p>
                        <span class="font-bold">Telepon:</span>
                        {{ $pengajuan->perusahaan->no_telp ?? '-' }}
                    </p>

                    <p>
                        <span class="font-bold">Email:</span>
                        {{ $pengajuan->perusahaan->email ?? '-' }}
                    </p>

                </div>

            @else

                <p class="mt-4 text-sm text-white/70">
                    Belum ada perusahaan yang dipilih.
                </p>

                <a
                    href="#"
                    class="mt-6 inline-block rounded-full bg-[#F5C2C7] px-5 py-3 text-sm font-bold text-[#9E2F37]"
                >
                    Cari Perusahaan
                </a>

            @endif

        </div>

    </section>


    {{-- DETAIL PKL + NILAI --}}
    <section class="mt-6 grid gap-6 md:grid-cols-2">

        <div class="rounded-[1.75rem] bg-white p-7 shadow-sm ring-1 ring-[#F1D9D9]">

            <p class="text-sm font-bold uppercase tracking-wider text-[#D96C73]">
                Penempatan
            </p>

            <h2 class="mt-1 text-2xl font-black">
                Data PKL
            </h2>

            @if ($pengajuan?->pkl)

                <div class="mt-6 space-y-4">

                    <div>
                        <p class="text-xs font-bold uppercase text-[#9B8587]">
                            Pembimbing
                        </p>

                        <p class="mt-1 font-bold">
                            {{ $pengajuan->pkl->pembimbing->nama_pembimbing }}
                        </p>
                    </div>

                    <div class="grid grid-cols-2 gap-4">

                        <div>
                            <p class="text-xs font-bold uppercase text-[#9B8587]">
                                Mulai
                            </p>

                            <p class="mt-1 font-bold">
                                {{ $pengajuan->pkl->tanggal_mulai->format('d M Y') }}
                            </p>
                        </div>

                        <div>
                            <p class="text-xs font-bold uppercase text-[#9B8587]">
                                Selesai
                            </p>

                            <p class="mt-1 font-bold">
                                {{ $pengajuan->pkl->tanggal_selesai->format('d M Y') }}
                            </p>
                        </div>

                    </div>

                </div>

            @else

                <p class="mt-6 text-sm text-[#8B7477]">
                    Data penempatan PKL belum tersedia.
                </p>

            @endif

        </div>


        <div class="rounded-[1.75rem] bg-[#F5C2C7] p-7">

            <p class="text-sm font-bold uppercase tracking-wider text-[#9E2F37]">
                Hasil
            </p>

            <h2 class="mt-1 text-2xl font-black text-[#3D2528]">
                Penilaian PKL
            </h2>

            @if ($pengajuan?->pkl?->nilai)

                <div class="mt-5 flex items-end gap-3">

                    <span class="text-6xl font-black text-[#9E2F37]">
                        {{ $pengajuan->pkl->nilai->nilai }}
                    </span>

                    <span class="pb-2 font-bold text-[#6E4448]">
                        / 100
                    </span>

                </div>

                <p class="mt-4 leading-7 text-[#6E4448]">
                    {{ $pengajuan->pkl->nilai->catatan ?? 'Tidak ada catatan.' }}
                </p>

            @else

                <p class="mt-6 text-sm text-[#6E4448]">
                    Nilai belum tersedia.
                </p>

            @endif

        </div>

    </section>

</div>

@endsection
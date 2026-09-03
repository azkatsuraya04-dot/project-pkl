@extends('layouts.app')

@section('title', 'Siswa Bimbingan')

@section('content')

<div class="mx-auto max-w-7xl px-5 py-10 lg:px-8">

    {{-- HEADER --}}
    <div class="mb-8">

        <p class="text-sm font-semibold text-[#9E2F37]">
            Pembimbing
        </p>

        <h1 class="mt-1 text-3xl font-black tracking-tight text-[#3D2528]">
            Siswa Bimbingan
        </h1>

        <p class="mt-2 text-[#8B7477]">
            Kelola siswa yang menjadi tanggung jawab pembimbing.
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


    {{-- VALIDATION --}}
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


    {{-- INFO PEMBIMBING --}}
    <div class="rounded-3xl bg-white p-6 shadow-sm ring-1 ring-[#F1D9D9]">

        <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">

            <div>

                <p class="text-sm text-[#8B7477]">
                    Nama Pembimbing
                </p>

                <h2 class="mt-1 text-xl font-black text-[#3D2528]">
                    {{ $pembimbing->nama_pembimbing }}
                </h2>

            </div>


            <div class="rounded-2xl bg-[#FFF8F3] px-5 py-4">

                <p class="text-xs text-[#8B7477]">
                    NIP
                </p>

                <p class="mt-1 font-bold text-[#3D2528]">
                    {{ $pembimbing->nip }}
                </p>

            </div>

        </div>

    </div>


    {{-- SEARCH + FILTER --}}
    <div class="mt-8 rounded-3xl bg-white p-6 shadow-sm ring-1 ring-[#F1D9D9]">

        <div class="mb-5">

            <h2 class="text-lg font-black text-[#3D2528]">
                Cari Siswa Bimbingan
            </h2>

            <p class="mt-1 text-sm text-[#8B7477]">
                Cari berdasarkan nama siswa atau status PKL.
            </p>

        </div>


        <form
            method="GET"
            action="{{ route('pembimbing.dashboard') }}"
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
                    class="w-full rounded-2xl border border-[#E8D4D4] bg-white px-4 py-3 text-sm outline-none focus:border-[#9E2F37]"
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


            {{-- CARI --}}
            <div class="flex items-end">

                <button
                    type="submit"
                    class="w-full rounded-2xl bg-[#9E2F37] px-5 py-3 text-sm font-bold text-white hover:bg-[#84262D]"
                >
                    Cari
                </button>

            </div>


            {{-- RESET --}}
            <div class="flex items-end">

                <a
                    href="{{ route('pembimbing.dashboard') }}"
                    class="w-full rounded-2xl border border-[#E8D4D4] px-5 py-3 text-center text-sm font-bold text-[#6B5053] hover:bg-[#FFF8F3]"
                >
                    Reset
                </a>

            </div>

        </form>

    </div>


    {{-- DAFTAR SISWA --}}
    <div class="mt-8">

        <div class="mb-5">

            <h2 class="text-xl font-black text-[#3D2528]">
                Daftar Siswa
            </h2>

            <p class="mt-1 text-sm text-[#8B7477]">
                {{ $pkl->count() }} siswa ditemukan.
            </p>

        </div>


        @if($pkl->count())

            <div class="grid gap-6 lg:grid-cols-2">

                @foreach($pkl as $item)

                    @php
                        $siswa = $item->pengajuan?->siswa;
                        $perusahaan = $item->pengajuan?->perusahaan;
                        $nilai = $item->nilai;
                    @endphp


                    <div class="rounded-3xl bg-white p-6 shadow-sm ring-1 ring-[#F1D9D9]">

                        {{-- SISWA --}}
                        <div class="flex items-start justify-between gap-4">

                            <div>

                                <p class="text-xs font-semibold uppercase tracking-wide text-[#9E2F37]">
                                    Siswa
                                </p>

                                <h3 class="mt-1 text-xl font-black text-[#3D2528]">
                                    {{ $siswa->nama_siswa ?? '-' }}
                                </h3>

                                <p class="mt-1 text-sm text-[#8B7477]">
                                    NIS {{ $siswa->nis ?? '-' }}
                                </p>

                            </div>


                            {{-- STATUS --}}
                            <div>

                                @if($item->status === 'berlangsung')

                                    <span class="inline-flex rounded-full bg-green-100 px-3 py-1 text-xs font-bold text-green-700">
                                        Berlangsung
                                    </span>

                                @elseif($item->status === 'selesai')

                                    <span class="inline-flex rounded-full bg-blue-100 px-3 py-1 text-xs font-bold text-blue-700">
                                        Selesai
                                    </span>

                                @else

                                    <span class="inline-flex rounded-full bg-yellow-100 px-3 py-1 text-xs font-bold text-yellow-700">
                                        Belum Mulai
                                    </span>

                                @endif

                            </div>

                        </div>


                        {{-- INFO PKL --}}
                        <div class="mt-6 grid gap-4 sm:grid-cols-2">

                            <div class="rounded-2xl bg-[#FFF8F3] p-4">

                                <p class="text-xs text-[#8B7477]">
                                    Perusahaan
                                </p>

                                <p class="mt-1 font-bold text-[#3D2528]">
                                    {{ $perusahaan->nama_perusahaan ?? '-' }}
                                </p>

                            </div>


                            <div class="rounded-2xl bg-[#FFF8F3] p-4">

                                <p class="text-xs text-[#8B7477]">
                                    Kelas
                                </p>

                                <p class="mt-1 font-bold text-[#3D2528]">
                                    {{ $siswa->kelas ?? '-' }}
                                </p>

                            </div>


                            <div class="rounded-2xl bg-[#FFF8F3] p-4">

                                <p class="text-xs text-[#8B7477]">
                                    Mulai PKL
                                </p>

                                <p class="mt-1 font-bold text-[#3D2528]">
                                    {{
                                        $item->tanggal_mulai
                                        ? $item->tanggal_mulai->format('d-m-Y')
                                        : '-'
                                    }}
                                </p>

                            </div>


                            <div class="rounded-2xl bg-[#FFF8F3] p-4">

                                <p class="text-xs text-[#8B7477]">
                                    Selesai PKL
                                </p>

                                <p class="mt-1 font-bold text-[#3D2528]">
                                    {{
                                        $item->tanggal_selesai
                                        ? $item->tanggal_selesai->format('d-m-Y')
                                        : '-'
                                    }}
                                </p>

                            </div>

                        </div>


                        {{-- NILAI --}}
                        <div class="mt-6 rounded-2xl border border-[#F1D9D9] p-5">

                            <div class="flex items-center justify-between gap-3">

                                <div>

                                    <p class="text-sm font-bold text-[#3D2528]">
                                        Nilai PKL
                                    </p>

                                    <p class="mt-1 text-xs text-[#8B7477]">
                                        Input atau perbarui nilai siswa.
                                    </p>

                                </div>


                                @if($nilai)

                                    <div class="rounded-full bg-[#FFF1F1] px-4 py-2">

                                        <span class="text-lg font-black text-[#9E2F37]">
                                            {{ number_format($nilai->nilai, 2) }}
                                        </span>

                                    </div>

                                @else

                                    <span class="text-xs font-bold text-[#9A8588]">
                                        Belum dinilai
                                    </span>

                                @endif

                            </div>


                            <form
                                action="{{ route('pembimbing.nilai', $item->id_pkl) }}"
                                method="POST"
                                class="mt-5"
                            >

                                @csrf

                                <div class="grid gap-4 sm:grid-cols-[160px_1fr]">

                                    {{-- NILAI --}}
                                    <div>

                                        <label class="mb-2 block text-sm font-semibold text-[#5D4548]">
                                            Nilai
                                        </label>

                                        <input
                                            type="number"
                                            name="nilai"
                                            min="0"
                                            max="100"
                                            step="0.01"
                                            value="{{ $nilai->nilai ?? '' }}"
                                            required
                                            class="w-full rounded-2xl border border-[#E8D4D4] px-4 py-3 outline-none focus:border-[#9E2F37]"
                                        >

                                    </div>


                                    {{-- CATATAN --}}
                                    <div>

                                        <label class="mb-2 block text-sm font-semibold text-[#5D4548]">
                                            Catatan
                                        </label>

                                        <input
                                            type="text"
                                            name="catatan"
                                            value="{{ $nilai->catatan ?? '' }}"
                                            placeholder="Contoh: Kinerja baik dan aktif selama PKL."
                                            class="w-full rounded-2xl border border-[#E8D4D4] px-4 py-3 outline-none focus:border-[#9E2F37]"
                                        >

                                    </div>

                                </div>


                                <div class="mt-4 flex justify-end">

                                    <button
                                        type="submit"
                                        class="rounded-full bg-[#9E2F37] px-5 py-2.5 text-sm font-bold text-white hover:bg-[#84262D]"
                                    >
                                        Simpan Nilai
                                    </button>

                                </div>

                            </form>

                        </div>

                    </div>

                @endforeach

            </div>

        @else

            <div class="rounded-3xl bg-white px-6 py-16 text-center shadow-sm ring-1 ring-[#F1D9D9]">

                <div class="mx-auto flex h-16 w-16 items-center justify-center rounded-full bg-[#FFF1F1] text-2xl">
                    🔍
                </div>

                <h3 class="mt-4 text-lg font-black text-[#3D2528]">
                    Data tidak ditemukan
                </h3>

                <p class="mt-2 text-sm text-[#8B7477]">
                    Tidak ada siswa yang sesuai dengan pencarian atau filter.
                </p>

            </div>

        @endif

    </div>

</div>

@endsection
@extends('layouts.app')

@section('title', 'Dashboard Kaprog')

@section('content')

<div class="mx-auto max-w-7xl px-5 py-10 lg:px-8">

    {{-- HEADER --}}
    <div class="mb-8">

        <p class="text-sm font-bold uppercase tracking-widest text-[#D96C73]">
            Kaprog
        </p>

        <h1 class="mt-2 text-4xl font-black text-[#3D2528]">
            Dashboard Program Keahlian
        </h1>

        <p class="mt-2 text-[#7B6669]">
            Pantau data siswa, perusahaan, pengajuan, dan penempatan PKL.
        </p>

    </div>


    {{-- PESAN --}}
    @if (session('success'))

        <div class="mb-6 rounded-2xl bg-green-50 px-5 py-4 text-sm font-semibold text-green-700">
            {{ session('success') }}
        </div>

    @endif


    {{-- STATISTIK --}}
    <div class="grid gap-5 sm:grid-cols-2 lg:grid-cols-4">

        <div class="rounded-[1.5rem] bg-white p-6 shadow-sm ring-1 ring-[#F1D9D9]">

            <p class="text-sm font-semibold text-[#8B7477]">
                Total Siswa
            </p>

            <p class="mt-2 text-4xl font-black text-[#9E2F37]">
                {{ $totalSiswa }}
            </p>

        </div>


        <div class="rounded-[1.5rem] bg-white p-6 shadow-sm ring-1 ring-[#F1D9D9]">

            <p class="text-sm font-semibold text-[#8B7477]">
                Perusahaan
            </p>

            <p class="mt-2 text-4xl font-black text-[#9E2F37]">
                {{ $totalPerusahaan }}
            </p>

        </div>


        <div class="rounded-[1.5rem] bg-white p-6 shadow-sm ring-1 ring-[#F1D9D9]">

            <p class="text-sm font-semibold text-[#8B7477]">
                Total Pengajuan
            </p>

            <p class="mt-2 text-4xl font-black text-[#9E2F37]">
                {{ $totalPengajuan }}
            </p>

        </div>


        <div class="rounded-[1.5rem] bg-[#F5C2C7] p-6">

            <p class="text-sm font-semibold text-[#6E4448]">
                PKL Berlangsung
            </p>

            <p class="mt-2 text-4xl font-black text-[#9E2F37]">
                {{ $pklBerlangsung }}
            </p>

        </div>

    </div>


    {{-- STATISTIK TAMBAHAN --}}
    <div class="mt-5 grid gap-5 md:grid-cols-2">

        <div class="rounded-[1.5rem] bg-[#3D2528] p-6 text-white">

            <p class="text-sm text-white/60">
                Total Penempatan PKL
            </p>

            <p class="mt-2 text-4xl font-black">
                {{ $totalPKL }}
            </p>

        </div>


        <div class="rounded-[1.5rem] bg-white p-6 ring-1 ring-[#F1D9D9]">

            <p class="text-sm text-[#8B7477]">
                PKL Selesai
            </p>

            <p class="mt-2 text-4xl font-black text-green-700">
                {{ $pklSelesai }}
            </p>

        </div>

    </div>


    {{-- JUMLAH SISWA PER PERUSAHAAN --}}
    <div class="mt-6 rounded-[1.75rem] bg-white p-7 shadow-sm ring-1 ring-[#F1D9D9]">

        <div class="mb-6">

            <p class="text-sm font-bold uppercase tracking-widest text-[#D96C73]">
                Statistik
            </p>

            <h2 class="mt-1 text-2xl font-black text-[#3D2528]">
                Jumlah Siswa per Perusahaan
            </h2>

        </div>


        <div class="overflow-x-auto">

            <table class="w-full text-left text-sm">

                <thead class="bg-[#FFF8F3]">

                    <tr>

                        <th class="px-5 py-4 font-bold">
                            Perusahaan
                        </th>

                        <th class="px-5 py-4 text-right font-bold">
                            Jumlah Siswa
                        </th>

                    </tr>

                </thead>


                <tbody>

                    @forelse ($siswaPerPerusahaan as $data)

                        <tr class="border-t border-[#F1D9D9]">

                            <td class="px-5 py-4 font-semibold">
                                {{ $data->nama_perusahaan }}
                            </td>

                            <td class="px-5 py-4 text-right">

                                <span class="rounded-full bg-[#F5C2C7] px-4 py-2 font-bold text-[#9E2F37]">
                                    {{ $data->jumlah_siswa }}
                                </span>

                            </td>

                        </tr>

                    @empty

                        <tr>

                            <td
                                colspan="2"
                                class="px-5 py-8 text-center text-[#8B7477]"
                            >
                                Belum ada data penempatan.
                            </td>

                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

    </div>


    {{-- DAFTAR PENGAJUAN --}}
    <div class="mt-6 rounded-[1.75rem] bg-white p-7 shadow-sm ring-1 ring-[#F1D9D9]">

        <div class="mb-6">

            <p class="text-sm font-bold uppercase tracking-widest text-[#D96C73]">
                Persetujuan
            </p>

            <h2 class="mt-1 text-2xl font-black text-[#3D2528]">
                Pengajuan PKL
            </h2>

        </div>


        <div class="space-y-4">

            @forelse ($pengajuan as $item)

                <div class="rounded-2xl bg-[#FFF8F3] p-5">

                    <div class="flex flex-col justify-between gap-4 md:flex-row md:items-center">

                        <div>

                            <h3 class="font-black text-[#3D2528]">
                                {{ $item->siswa->nama_siswa }}
                            </h3>

                            <p class="mt-1 text-sm text-[#8B7477]">
                                {{ $item->perusahaan->nama_perusahaan }}
                            </p>

                        </div>


                        @if ($item->status_kaprog === 'menunggu')

                            <div class="flex gap-2">

                                <form
                                    action="{{ route('kaprog.setujui', $item->id_pengajuan) }}"
                                    method="POST"
                                >

                                    @csrf
                                    @method('PUT')

                                    <button
                                        type="submit"
                                        class="rounded-full bg-green-600 px-5 py-2.5 text-xs font-bold text-white"
                                    >
                                        Setujui
                                    </button>

                                </form>


                                <form
                                    action="{{ route('kaprog.tolak', $item->id_pengajuan) }}"
                                    method="POST"
                                >

                                    @csrf
                                    @method('PUT')

                                    <button
                                        type="submit"
                                        class="rounded-full bg-red-100 px-5 py-2.5 text-xs font-bold text-red-700"
                                    >
                                        Tolak
                                    </button>

                                </form>

                            </div>

                        @else

                            <span class="rounded-full bg-green-100 px-4 py-2 text-xs font-bold text-green-700">
                                {{ str_replace('_', ' ', $item->status_kaprog) }}
                            </span>

                        @endif

                    </div>

                </div>

            @empty

                <p class="py-8 text-center text-[#8B7477]">
                    Belum ada pengajuan.
                </p>

            @endforelse

        </div>

    </div>

</div>

@endsection
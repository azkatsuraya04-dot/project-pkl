@extends('layouts.app')

@section('title', 'Kelola Perusahaan')

@section('content')

<div class="mx-auto max-w-7xl px-5 py-10 lg:px-8">

    <div class="mb-8">
        <p class="text-sm font-bold uppercase tracking-widest text-[#D96C73]">
            Hubin
        </p>

        <h1 class="mt-2 text-4xl font-black text-[#3D2528]">
            Kelola Perusahaan
        </h1>

        <p class="mt-2 text-[#7B6669]">
            Tambah, ubah, dan hapus data perusahaan tujuan PKL.
        </p>
    </div>


    @if(session('success'))
        <div class="mb-6 rounded-2xl bg-green-50 px-5 py-4 text-sm font-semibold text-green-700">
            {{ session('success') }}
        </div>
    @endif


    @if(session('error'))
        <div class="mb-6 rounded-2xl bg-red-50 px-5 py-4 text-sm font-semibold text-red-700">
            {{ session('error') }}
        </div>
    @endif


    @if($errors->any())
        <div class="mb-6 rounded-2xl bg-red-50 px-5 py-4 text-sm text-red-700">
            <ul class="list-disc pl-5">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif


    {{-- TAMBAH PERUSAHAAN --}}
    <div class="rounded-[1.75rem] bg-white p-7 shadow-sm ring-1 ring-[#F1D9D9]">

        <div class="mb-6">
            <p class="text-sm font-bold text-[#D96C73]">
                Tambah Data
            </p>

            <h2 class="mt-1 text-2xl font-black">
                Tambah Perusahaan
            </h2>
        </div>


        <form
            action="{{ route('hubin.perusahaan.store') }}"
            method="POST"
            class="grid gap-5 md:grid-cols-2"
        >

            @csrf

            <div>
                <label class="mb-2 block text-sm font-bold">
                    Nama Perusahaan
                </label>

                <input
                    type="text"
                    name="nama_perusahaan"
                    placeholder="Contoh: PT Teknologi Maju"
                    class="w-full rounded-2xl border border-[#E8D6D7] bg-[#FFF8F3] px-4 py-3 outline-none focus:border-[#D96C73]"
                    required
                >
            </div>


            <div>
                <label class="mb-2 block text-sm font-bold">
                    Email
                </label>

                <input
                    type="email"
                    name="email"
                    placeholder="email@perusahaan.com"
                    class="w-full rounded-2xl border border-[#E8D6D7] bg-[#FFF8F3] px-4 py-3 outline-none focus:border-[#D96C73]"
                >
            </div>


            <div>
                <label class="mb-2 block text-sm font-bold">
                    No. Telepon
                </label>

                <input
                    type="text"
                    name="no_telp"
                    placeholder="08xxxxxxxxxx"
                    class="w-full rounded-2xl border border-[#E8D6D7] bg-[#FFF8F3] px-4 py-3 outline-none focus:border-[#D96C73]"
                >
            </div>


            <div>
                <label class="mb-2 block text-sm font-bold">
                    Alamat
                </label>

                <textarea
                    name="alamat"
                    rows="1"
                    placeholder="Alamat perusahaan"
                    class="w-full rounded-2xl border border-[#E8D6D7] bg-[#FFF8F3] px-4 py-3 outline-none focus:border-[#D96C73]"
                    required
                ></textarea>
            </div>


            <div class="md:col-span-2">

                <button
                    type="submit"
                    class="rounded-full bg-[#9E2F37] px-6 py-3 text-sm font-bold text-white transition hover:bg-[#84262D]"
                >
                    + Tambah Perusahaan
                </button>

            </div>

        </form>

    </div>


    {{-- DAFTAR PERUSAHAAN --}}
    <div class="mt-6 rounded-[1.75rem] bg-white p-7 shadow-sm ring-1 ring-[#F1D9D9]">

        <div class="mb-6">

            <p class="text-sm font-bold text-[#D96C73]">
                Data Perusahaan
            </p>

            <h2 class="mt-1 text-2xl font-black">
                Daftar Perusahaan
            </h2>

        </div>


        <div class="space-y-4">

            @forelse($perusahaan as $item)

                <details class="group rounded-2xl border border-[#F1D9D9] bg-[#FFF8F3]">

                    <summary class="flex cursor-pointer list-none items-center justify-between gap-4 p-5">

                        <div>

                            <h3 class="font-black text-[#3D2528]">
                                {{ $item->nama_perusahaan }}
                            </h3>

                            <p class="mt-1 text-sm text-[#8B7477]">
                                {{ $item->alamat }}
                            </p>

                        </div>

                        <span class="rounded-full bg-[#F5C2C7] px-4 py-2 text-xs font-bold text-[#9E2F37]">
                            Edit
                        </span>

                    </summary>


                    <div class="border-t border-[#F1D9D9] p-5">

                        {{-- EDIT --}}
                        <form
                            action="{{ route('hubin.perusahaan.update', $item->id_perusahaan) }}"
                            method="POST"
                            class="grid gap-4 md:grid-cols-2"
                        >

                            @csrf
                            @method('PUT')

                            <div>
                                <label class="mb-2 block text-sm font-bold">
                                    Nama Perusahaan
                                </label>

                                <input
                                    type="text"
                                    name="nama_perusahaan"
                                    value="{{ $item->nama_perusahaan }}"
                                    class="w-full rounded-2xl border border-[#E8D6D7] bg-white px-4 py-3"
                                    required
                                >
                            </div>


                            <div>
                                <label class="mb-2 block text-sm font-bold">
                                    Email
                                </label>

                                <input
                                    type="email"
                                    name="email"
                                    value="{{ $item->email }}"
                                    class="w-full rounded-2xl border border-[#E8D6D7] bg-white px-4 py-3"
                                >
                            </div>


                            <div>
                                <label class="mb-2 block text-sm font-bold">
                                    No. Telepon
                                </label>

                                <input
                                    type="text"
                                    name="no_telp"
                                    value="{{ $item->no_telp }}"
                                    class="w-full rounded-2xl border border-[#E8D6D7] bg-white px-4 py-3"
                                >
                            </div>


                            <div>
                                <label class="mb-2 block text-sm font-bold">
                                    Alamat
                                </label>

                                <textarea
                                    name="alamat"
                                    rows="2"
                                    class="w-full rounded-2xl border border-[#E8D6D7] bg-white px-4 py-3"
                                    required
                                >{{ $item->alamat }}</textarea>
                            </div>


                            <div class="flex flex-wrap gap-3 md:col-span-2">

                                <button
                                    type="submit"
                                    class="rounded-full bg-[#9E2F37] px-5 py-3 text-sm font-bold text-white"
                                >
                                    Simpan Perubahan
                                </button>

                        </form>


                                {{-- HAPUS --}}
                                <form
                                    action="{{ route('hubin.perusahaan.destroy', $item->id_perusahaan) }}"
                                    method="POST"
                                    onsubmit="return confirm('Yakin ingin menghapus perusahaan ini?')"
                                >

                                    @csrf
                                    @method('DELETE')

                                    <button
                                        type="submit"
                                        class="rounded-full bg-red-100 px-5 py-3 text-sm font-bold text-red-700"
                                    >
                                        Hapus
                                    </button>

                                </form>

                            </div>

                    </div>

                </details>

            @empty

                <div class="rounded-2xl bg-[#FFF8F3] p-8 text-center text-[#8B7477]">
                    Belum ada data perusahaan.
                </div>

            @endforelse

        </div>

    </div>

</div>

@endsection
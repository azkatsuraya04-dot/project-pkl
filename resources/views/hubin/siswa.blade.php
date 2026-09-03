@extends('layouts.app')

@section('title', 'Data Siswa')

@section('content')

<div class="mx-auto max-w-7xl px-5 py-10 lg:px-8">

    <div class="mb-8">
        <p class="text-sm font-bold uppercase tracking-widest text-[#D96C73]">
            Hubin
        </p>

        <h1 class="mt-2 text-4xl font-black text-[#3D2528]">
            Data Siswa
        </h1>

        <p class="mt-2 text-[#7B6669]">
            Kelola data siswa dan akun login siswa.
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


    {{-- TAMBAH SISWA --}}
    <div class="rounded-[1.75rem] bg-white p-7 shadow-sm ring-1 ring-[#F1D9D9]">

        <p class="text-sm font-bold text-[#D96C73]">
            Data Baru
        </p>

        <h2 class="mt-1 text-2xl font-black">
            Tambah Siswa
        </h2>


        <form
            action="{{ route('hubin.siswa.store') }}"
            method="POST"
            class="mt-6 grid gap-5 md:grid-cols-2"
        >

            @csrf

            <div>
                <label class="mb-2 block text-sm font-bold">
                    Nama Siswa
                </label>

                <input
                    type="text"
                    name="nama_siswa"
                    value="{{ old('nama_siswa') }}"
                    required
                    class="w-full rounded-2xl border border-[#E8D6D7] bg-[#FFF8F3] px-4 py-3 outline-none focus:border-[#D96C73]"
                >
            </div>


            <div>
                <label class="mb-2 block text-sm font-bold">
                    NIS
                </label>

                <input
                    type="text"
                    name="nis"
                    value="{{ old('nis') }}"
                    required
                    class="w-full rounded-2xl border border-[#E8D6D7] bg-[#FFF8F3] px-4 py-3 outline-none focus:border-[#D96C73]"
                >
            </div>


            <div>
                <label class="mb-2 block text-sm font-bold">
                    Kelas
                </label>

                <input
                    type="text"
                    name="kelas"
                    placeholder="Contoh: XII RPL 2"
                    value="{{ old('kelas') }}"
                    required
                    class="w-full rounded-2xl border border-[#E8D6D7] bg-[#FFF8F3] px-4 py-3 outline-none focus:border-[#D96C73]"
                >
            </div>


            <div>
                <label class="mb-2 block text-sm font-bold">
                    Jurusan
                </label>

                <input
                    type="text"
                    name="jurusan"
                    placeholder="Contoh: RPL"
                    value="{{ old('jurusan') }}"
                    required
                    class="w-full rounded-2xl border border-[#E8D6D7] bg-[#FFF8F3] px-4 py-3 outline-none focus:border-[#D96C73]"
                >
            </div>


            <div>
                <label class="mb-2 block text-sm font-bold">
                    Email Login
                </label>

                <input
                    type="email"
                    name="email"
                    value="{{ old('email') }}"
                    placeholder="siswa@email.com"
                    required
                    class="w-full rounded-2xl border border-[#E8D6D7] bg-[#FFF8F3] px-4 py-3 outline-none focus:border-[#D96C73]"
                >
            </div>


            <div>
                <label class="mb-2 block text-sm font-bold">
                    Password Login
                </label>

                <input
                    type="password"
                    name="password"
                    required
                    class="w-full rounded-2xl border border-[#E8D6D7] bg-[#FFF8F3] px-4 py-3 outline-none focus:border-[#D96C73]"
                >
            </div>


            <div class="md:col-span-2">

                <button
                    type="submit"
                    class="rounded-full bg-[#9E2F37] px-6 py-3 text-sm font-bold text-white transition hover:bg-[#84262D]"
                >
                    + Tambah Siswa
                </button>

            </div>

        </form>

    </div>


    {{-- DAFTAR SISWA --}}
    <div class="mt-6 overflow-hidden rounded-[1.75rem] bg-white shadow-sm ring-1 ring-[#F1D9D9]">

        <div class="p-7">

            <p class="text-sm font-bold text-[#D96C73]">
                Data Siswa
            </p>

            <h2 class="mt-1 text-2xl font-black">
                Daftar Siswa
            </h2>

        </div>


        <div class="overflow-x-auto">

            <table class="w-full text-left text-sm">

                <thead class="bg-[#FFF8F3]">

                    <tr>

                        <th class="px-6 py-4 font-bold">
                            Nama
                        </th>

                        <th class="px-6 py-4 font-bold">
                            NIS
                        </th>

                        <th class="px-6 py-4 font-bold">
                            Kelas
                        </th>

                        <th class="px-6 py-4 font-bold">
                            Jurusan
                        </th>

                        <th class="px-6 py-4 font-bold">
                            Email
                        </th>

                        <th class="px-6 py-4 font-bold">
                            Aksi
                        </th>

                    </tr>

                </thead>


                <tbody>

                    @forelse($siswa as $item)

                        <tr class="border-t border-[#F1D9D9]">

                            <td class="px-6 py-4 font-bold">
                                {{ $item->nama_siswa }}
                            </td>

                            <td class="px-6 py-4">
                                {{ $item->nis }}
                            </td>

                            <td class="px-6 py-4">
                                {{ $item->kelas }}
                            </td>

                            <td class="px-6 py-4">
                                {{ $item->jurusan }}
                            </td>

                            <td class="px-6 py-4">
                                {{ $item->user?->email ?? '-' }}
                            </td>

                            <td class="px-6 py-4">

                                <div class="flex gap-2">

                                    {{-- EDIT --}}
                                    <details>

                                        <summary class="cursor-pointer rounded-full bg-[#F5C2C7] px-4 py-2 text-xs font-bold text-[#9E2F37]">
                                            Edit
                                        </summary>

                                        <div class="fixed inset-0 z-50 flex items-center justify-center bg-black/40 p-5">

                                            <div class="w-full max-w-lg rounded-3xl bg-white p-7">

                                                <h2 class="text-2xl font-black">
                                                    Edit {{ $item->nama_siswa }}
                                                </h2>

                                                <form
                                                    action="{{ route('hubin.siswa.update', $item->id_siswa) }}"
                                                    method="POST"
                                                    class="mt-6 space-y-4"
                                                >

                                                    @csrf
                                                    @method('PUT')

                                                    <input
                                                        type="text"
                                                        name="nama_siswa"
                                                        value="{{ $item->nama_siswa }}"
                                                        required
                                                        class="w-full rounded-2xl border border-gray-200 px-4 py-3"
                                                    >

                                                    <input
                                                        type="text"
                                                        name="nis"
                                                        value="{{ $item->nis }}"
                                                        required
                                                        class="w-full rounded-2xl border border-gray-200 px-4 py-3"
                                                    >

                                                    <input
                                                        type="text"
                                                        name="kelas"
                                                        value="{{ $item->kelas }}"
                                                        required
                                                        class="w-full rounded-2xl border border-gray-200 px-4 py-3"
                                                    >

                                                    <input
                                                        type="text"
                                                        name="jurusan"
                                                        value="{{ $item->jurusan }}"
                                                        required
                                                        class="w-full rounded-2xl border border-gray-200 px-4 py-3"
                                                    >

                                                    <input
                                                        type="email"
                                                        name="email"
                                                        value="{{ $item->user?->email }}"
                                                        required
                                                        class="w-full rounded-2xl border border-gray-200 px-4 py-3"
                                                    >

                                                    <button
                                                        type="submit"
                                                        class="w-full rounded-full bg-[#9E2F37] px-5 py-3 font-bold text-white"
                                                    >
                                                        Simpan
                                                    </button>

                                                </form>

                                            </div>

                                        </div>

                                    </details>


                                    {{-- HAPUS --}}
                                    <form
                                        action="{{ route('hubin.siswa.destroy', $item->id_siswa) }}"
                                        method="POST"
                                        onsubmit="return confirm('Yakin ingin menghapus siswa ini?')"
                                    >

                                        @csrf
                                        @method('DELETE')

                                        <button
                                            type="submit"
                                            class="rounded-full bg-red-100 px-4 py-2 text-xs font-bold text-red-700"
                                        >
                                            Hapus
                                        </button>

                                    </form>

                                </div>

                            </td>

                        </tr>

                    @empty

                        <tr>

                            <td
                                colspan="6"
                                class="px-6 py-10 text-center text-[#8B7477]"
                            >
                                Belum ada data siswa.
                            </td>

                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

    </div>

</div>

@endsection
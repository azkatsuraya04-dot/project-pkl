@extends('layouts.app')

@section('title', 'Daftar Perusahaan')

@section('content')

<div class="mx-auto max-w-7xl px-5 py-10 lg:px-8">

    <div class="mb-8">
        <p class="text-sm font-bold uppercase tracking-widest text-[#D96C73]">
            Pilihan PKL
        </p>

        <h1 class="mt-2 text-4xl font-black text-[#3D2528]">
            Daftar Perusahaan
        </h1>

        <p class="mt-2 text-[#7B6669]">
            Pilih perusahaan yang ingin kamu jadikan tempat PKL.
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

    <div class="grid gap-6 md:grid-cols-2 lg:grid-cols-3">

        @forelse($perusahaan as $item)

            <div class="rounded-[1.75rem] bg-white p-6 shadow-sm ring-1 ring-[#F1D9D9]">

                <div class="flex h-14 w-14 items-center justify-center rounded-2xl bg-[#F5C2C7] text-2xl">
                    🏢
                </div>

                <h2 class="mt-5 text-xl font-black text-[#3D2528]">
                    {{ $item->nama_perusahaan }}
                </h2>

                <p class="mt-3 text-sm leading-6 text-[#7B6669]">
                    {{ $item->alamat }}
                </p>

                <div class="mt-4 space-y-1 text-sm text-[#7B6669]">
                    <p>📞 {{ $item->no_telp ?? '-' }}</p>
                    <p>✉ {{ $item->email ?? '-' }}</p>
                </div>

                <form
                    action="{{ route('siswa.perusahaan.ajukan', $item->id_perusahaan) }}"
                    method="POST"
                    class="mt-6"
                >

                    @csrf

                    <button
                        type="submit"
                        class="w-full rounded-full bg-[#9E2F37] px-5 py-3 text-sm font-bold text-white transition hover:bg-[#84262D]"
                    >
                        Ajukan PKL
                    </button>

                </form>

            </div>

        @empty

            <div class="rounded-[1.75rem] bg-white p-8 text-center md:col-span-2 lg:col-span-3">
                <p class="font-bold text-[#3D2528]">
                    Belum ada perusahaan.
                </p>
            </div>

        @endforelse

    </div>

</div>

@endsection
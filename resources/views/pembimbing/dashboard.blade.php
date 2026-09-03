@extends('layouts.app')

@section('title', 'Dashboard Pembimbing')

@section('content')

<div class="mx-auto max-w-7xl px-5 py-10 lg:px-8">

    <div class="mb-8">

        <p class="text-sm font-bold uppercase tracking-widest text-[#D96C73]">
            Pembimbing
        </p>

        <h1 class="mt-2 text-4xl font-black">
            Siswa Bimbingan
        </h1>

    </div>


    @if(session('success'))

        <div class="mb-6 rounded-2xl bg-green-50 px-5 py-4 text-sm font-semibold text-green-700">
            {{ session('success') }}
        </div>

    @endif


    <div class="grid gap-6 lg:grid-cols-2">

        @forelse($pkl as $item)

            <div class="rounded-[1.75rem] bg-white p-6 shadow-sm ring-1 ring-[#F1D9D9]">

                <h2 class="text-xl font-black">
                    {{ $item->pengajuan->siswa->nama_siswa }}
                </h2>

                <p class="mt-1 text-sm text-[#8B7477]">
                    {{ $item->pengajuan->perusahaan->nama_perusahaan }}
                </p>


                <div class="mt-6 rounded-2xl bg-[#FFF8F3] p-5">

                    <p class="text-xs font-bold uppercase text-[#9B8587]">
                        Nilai Saat Ini
                    </p>

                    <p class="mt-1 text-4xl font-black text-[#9E2F37]">
                        {{ $item->nilai?->nilai ?? '-' }}
                    </p>

                </div>


                <form
                    action="{{ route('pembimbing.nilai', $item->id_pkl) }}"
                    method="POST"
                    class="mt-6 space-y-4"
                >

                    @csrf

                    <div>

                        <label class="mb-2 block text-sm font-bold">
                            Nilai
                        </label>

                        <input
                            type="number"
                            name="nilai"
                            min="0"
                            max="100"
                            step="0.01"
                            value="{{ $item->nilai?->nilai }}"
                            class="w-full rounded-2xl border border-[#E8D6D7] bg-[#FFF8F3] px-4 py-3 outline-none focus:border-[#D96C73]"
                            required
                        >

                    </div>


                    <div>

                        <label class="mb-2 block text-sm font-bold">
                            Catatan
                        </label>

                        <textarea
                            name="catatan"
                            rows="3"
                            class="w-full rounded-2xl border border-[#E8D6D7] bg-[#FFF8F3] px-4 py-3 outline-none focus:border-[#D96C73]"
                        >{{ $item->nilai?->catatan }}</textarea>

                    </div>


                    <button
                        type="submit"
                        class="w-full rounded-full bg-[#9E2F37] px-5 py-3 font-bold text-white"
                    >
                        Simpan Nilai
                    </button>

                </form>

            </div>

        @empty

            <div class="rounded-[1.75rem] bg-white p-8 lg:col-span-2">
                Belum ada siswa bimbingan.
            </div>

        @endforelse

    </div>

</div>

@endsection
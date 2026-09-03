@extends('layouts.app')

@section('title', 'Login')

@section('content')

<div class="flex min-h-[calc(100vh-80px)] items-center justify-center px-5 py-12">

    <div class="grid w-full max-w-5xl overflow-hidden rounded-[2rem] bg-white shadow-xl md:grid-cols-2">

        {{-- SISI KIRI --}}
        <div class="relative hidden min-h-[600px] overflow-hidden bg-[#9E2F37] p-10 text-white md:flex md:flex-col md:justify-between">

            <div class="absolute -right-20 -top-20 h-64 w-64 rounded-full bg-[#D96C73]/50"></div>

            <div class="absolute -bottom-20 -left-20 h-64 w-64 rounded-full bg-[#F5C2C7]/20"></div>

            <div class="relative">

                <div class="mb-8 inline-flex rounded-full bg-white/15 px-4 py-2 text-sm font-bold backdrop-blur">
                    SISTEM INFORMASI PKL
                </div>

                <h1 class="max-w-md text-5xl font-black leading-tight">
                    Mulai perjalanan PKL kamu di sini.
                </h1>

                <p class="mt-5 max-w-md leading-7 text-white/80">
                    Kelola pengajuan, perusahaan tujuan,
                    penempatan, hingga nilai PKL dalam satu sistem.
                </p>

            </div>

            <div class="relative rounded-3xl bg-white/10 p-5 backdrop-blur">

                <p class="text-sm font-semibold">
                    Satu platform untuk seluruh proses PKL siswa.
                </p>

            </div>

        </div>


        {{-- FORM LOGIN --}}
        <div class="flex items-center p-7 sm:p-10 lg:p-14">

            <div class="mx-auto w-full max-w-md">

                <p class="text-sm font-bold uppercase tracking-widest text-[#D96C73]">
                    Welcome back
                </p>

                <h2 class="mt-2 text-4xl font-black text-[#3D2528]">
                    Login
                </h2>

                <p class="mt-2 text-sm text-[#7B6669]">
                    Masuk ke akun Sistem Informasi PKL.
                </p>


                @if ($errors->any())

                    <div class="mt-6 rounded-2xl border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-700">
                        {{ $errors->first() }}
                    </div>

                @endif


                <form
                    action="{{ route('login.process') }}"
                    method="POST"
                    class="mt-8 space-y-5"
                >

                    @csrf


                    <div>

                        <label
                            for="email"
                            class="mb-2 block text-sm font-bold text-[#4D373A]"
                        >
                            Email
                        </label>

                        <input
                            type="email"
                            id="email"
                            name="email"
                            value="{{ old('email') }}"
                            placeholder="nama@email.com"
                            required
                            class="w-full rounded-2xl border border-[#E8D6D7] bg-[#FFF8F3] px-4 py-3.5 text-sm outline-none transition placeholder:text-[#B9A3A5] focus:border-[#D96C73] focus:ring-4 focus:ring-[#F5C2C7]/30"
                        >

                    </div>


                    <div>

                        <label
                            for="password"
                            class="mb-2 block text-sm font-bold text-[#4D373A]"
                        >
                            Password
                        </label>

                        <input
                            type="password"
                            id="password"
                            name="password"
                            placeholder="Masukkan password"
                            required
                            class="w-full rounded-2xl border border-[#E8D6D7] bg-[#FFF8F3] px-4 py-3.5 text-sm outline-none transition placeholder:text-[#B9A3A5] focus:border-[#D96C73] focus:ring-4 focus:ring-[#F5C2C7]/30"
                        >

                    </div>


                    <button
                        type="submit"
                        class="w-full rounded-full bg-[#9E2F37] px-5 py-3.5 text-sm font-bold text-white shadow-lg shadow-[#9E2F37]/20 transition hover:-translate-y-0.5 hover:bg-[#84262D]"
                    >
                        Masuk ke Sistem
                    </button>

                </form>

            </div>

        </div>

    </div>

</div>

@endsection
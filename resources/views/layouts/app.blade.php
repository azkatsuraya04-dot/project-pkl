<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>
        @yield('title', 'Sistem Informasi PKL')
    </title>

    @vite([
        'resources/css/app.css',
        'resources/js/app.js'
    ])
</head>

<body class="min-h-screen bg-[#FFF8F3] text-[#3D2528]">

    {{-- =========================================================
         NAVBAR
    ========================================================== --}}
    <nav class="sticky top-0 z-50 border-b border-[#F1D9D9] bg-white/95 backdrop-blur">

        <div class="mx-auto flex max-w-7xl items-center justify-between gap-6 px-5 py-4 lg:px-8">

            {{-- LOGO --}}
            @auth
                <a
                    href="{{
                        match (Auth::user()->role) {
                            'siswa' => route('siswa.dashboard'),
                            'kaprog' => route('kaprog.dashboard'),
                            'hubin' => route('hubin.dashboard'),
                            'pembimbing' => route('pembimbing.dashboard'),
                            default => route('login'),
                        }
                    }}"
                    class="shrink-0 text-2xl font-black tracking-tight text-[#9E2F37]"
                >
                    PKL<span class="text-[#D96C73]">.</span>
                </a>
            @else
                <a
                    href="{{ route('login') }}"
                    class="shrink-0 text-2xl font-black tracking-tight text-[#9E2F37]"
                >
                    PKL<span class="text-[#D96C73]">.</span>
                </a>
            @endauth


            {{-- =====================================================
                 NAVIGASI DESKTOP
            ====================================================== --}}
            @auth

                <div class="hidden items-center gap-7 md:flex">

                    {{-- SISWA --}}
                    @if (Auth::user()->role === 'siswa')

                        <a
                            href="{{ route('siswa.dashboard') }}"
                            class="
                                text-sm font-semibold transition
                                {{ request()->routeIs('siswa.dashboard')
                                    ? 'text-[#9E2F37]'
                                    : 'text-[#5D4548] hover:text-[#9E2F37]' }}
                            "
                        >
                            Dashboard
                        </a>

                        <a
                            href="{{ route('siswa.perusahaan') }}"
                            class="
                                text-sm font-semibold transition
                                {{ request()->routeIs('siswa.perusahaan')
                                    ? 'text-[#9E2F37]'
                                    : 'text-[#5D4548] hover:text-[#9E2F37]' }}
                            "
                        >
                            Perusahaan
                        </a>

                        <a
                            href="{{ route('siswa.pengajuan') }}"
                            class="
                                text-sm font-semibold transition
                                {{ request()->routeIs('siswa.pengajuan')
                                    ? 'text-[#9E2F37]'
                                    : 'text-[#5D4548] hover:text-[#9E2F37]' }}
                            "
                        >
                            Pengajuan
                        </a>


                    {{-- KAPROG --}}
                    @elseif (Auth::user()->role === 'kaprog')

                        <a
                            href="{{ route('kaprog.dashboard') }}"
                            class="
                                text-sm font-semibold transition
                                {{ request()->routeIs('kaprog.dashboard')
                                    ? 'text-[#9E2F37]'
                                    : 'text-[#5D4548] hover:text-[#9E2F37]' }}
                            "
                        >
                            Pengajuan
                        </a>


                    {{-- HUBIN --}}
                    @elseif (Auth::user()->role === 'hubin')

                        <a
                            href="{{ route('hubin.dashboard') }}"
                            class="
                                text-sm font-semibold transition
                                {{ request()->routeIs('hubin.dashboard')
                                    ? 'text-[#9E2F37]'
                                    : 'text-[#5D4548] hover:text-[#9E2F37]' }}
                            "
                        >
                            Pengajuan
                        </a>

                        <a
                            href="{{ route('hubin.siswa') }}"
                            class="
                                text-sm font-semibold transition
                                {{ request()->routeIs('hubin.siswa')
                                    ? 'text-[#9E2F37]'
                                    : 'text-[#5D4548] hover:text-[#9E2F37]' }}
                            "
                        >
                            Data Siswa
                        </a>

                        <a
                            href="{{ route('hubin.perusahaan') }}"
                            class="
                                text-sm font-semibold transition
                                {{ request()->routeIs('hubin.perusahaan')
                                    ? 'text-[#9E2F37]'
                                    : 'text-[#5D4548] hover:text-[#9E2F37]' }}
                            "
                        >
                            Perusahaan
                        </a>


                    {{-- PEMBIMBING --}}
                    @elseif (Auth::user()->role === 'pembimbing')

                        <a
                            href="{{ route('pembimbing.dashboard') }}"
                            class="
                                text-sm font-semibold transition
                                {{ request()->routeIs('pembimbing.dashboard')
                                    ? 'text-[#9E2F37]'
                                    : 'text-[#5D4548] hover:text-[#9E2F37]' }}
                            "
                        >
                            Siswa Bimbingan
                        </a>

                    @endif

                </div>

            @endauth


            {{-- =====================================================
                 USER INFO + LOGOUT
            ====================================================== --}}
            @auth

                <div class="flex shrink-0 items-center gap-3">

                    <div class="hidden text-right sm:block">

                        <p class="text-xs capitalize text-[#8B7477]">
                            {{ Auth::user()->role }}
                        </p>

                        <p class="text-sm font-bold text-[#3D2528]">
                            {{ Auth::user()->name }}
                        </p>

                    </div>


                    <form
                        action="{{ route('logout') }}"
                        method="POST"
                    >

                        @csrf

                        <button
                            type="submit"
                            class="rounded-full bg-[#9E2F37] px-5 py-2.5 text-sm font-bold text-white transition hover:bg-[#84262D]"
                        >
                            Logout
                        </button>

                    </form>

                </div>

            @endauth

        </div>

    </nav>


    {{-- =========================================================
         KONTEN
    ========================================================== --}}
    <main class="min-h-[calc(100vh-300px)]">

        @yield('content')

    </main>


    {{-- =========================================================
         FOOTER
    ========================================================== --}}
    <footer class="mt-16 bg-[#3D2528] text-white">

        <div class="mx-auto max-w-7xl px-5 py-10 lg:px-8">

            <div class="grid gap-10 md:grid-cols-3">

                {{-- BRAND --}}
                <div>

                    <div class="text-2xl font-black text-white">
                        PKL<span class="text-[#D96C73]">.</span>
                    </div>

                    <p class="mt-4 max-w-sm text-sm leading-6 text-white/65">
                        Sistem informasi untuk membantu proses pengajuan,
                        penempatan, dan penilaian Praktik Kerja Lapangan siswa.
                    </p>

                </div>


                {{-- INFORMASI --}}
                <div>

                    <h3 class="font-bold">
                        Informasi
                    </h3>

                    <div class="mt-4 space-y-2">

                        <p class="text-sm text-white/70">
                            SMKN 1 Katapang
                        </p>

                        <p class="text-sm text-white/70">
                            XII RPL
                        </p>

                        <p class="text-sm text-white/70">
                            Sistem Informasi PKL Siswa
                        </p>

                    </div>

                </div>


                {{-- NAVIGASI --}}
                <div>

                    <h3 class="font-bold">
                        Navigasi
                    </h3>

                    <div class="mt-4 space-y-2">

                        @auth

                            {{-- SISWA --}}
                            @if (Auth::user()->role === 'siswa')

                                <a
                                    href="{{ route('siswa.dashboard') }}"
                                    class="block text-sm text-white/70 transition hover:text-white"
                                >
                                    Dashboard
                                </a>

                                <a
                                    href="{{ route('siswa.perusahaan') }}"
                                    class="block text-sm text-white/70 transition hover:text-white"
                                >
                                    Perusahaan
                                </a>

                                <a
                                    href="{{ route('siswa.pengajuan') }}"
                                    class="block text-sm text-white/70 transition hover:text-white"
                                >
                                    Pengajuan
                                </a>


                            {{-- KAPROG --}}
                            @elseif (Auth::user()->role === 'kaprog')

                                <a
                                    href="{{ route('kaprog.dashboard') }}"
                                    class="block text-sm text-white/70 transition hover:text-white"
                                >
                                    Pengajuan
                                </a>


                            {{-- HUBIN --}}
                            @elseif (Auth::user()->role === 'hubin')

                                <a
                                    href="{{ route('hubin.dashboard') }}"
                                    class="block text-sm text-white/70 transition hover:text-white"
                                >
                                    Pengajuan
                                </a>

                                <a
                                    href="{{ route('hubin.siswa') }}"
                                    class="block text-sm text-white/70 transition hover:text-white"
                                >
                                    Data Siswa
                                </a>

                                <a
                                    href="{{ route('hubin.perusahaan') }}"
                                    class="block text-sm text-white/70 transition hover:text-white"
                                >
                                    Perusahaan
                                </a>


                            {{-- PEMBIMBING --}}
                            @elseif (Auth::user()->role === 'pembimbing')

                                <a
                                    href="{{ route('pembimbing.dashboard') }}"
                                    class="block text-sm text-white/70 transition hover:text-white"
                                >
                                    Siswa Bimbingan
                                </a>

                            @endif

                        @endauth

                    </div>

                </div>

            </div>


            {{-- COPYRIGHT --}}
            <div class="mt-10 border-t border-white/10 pt-5">

                <p class="text-sm text-white/45">
                    © {{ date('Y') }} Sistem Informasi PKL
                </p>

            </div>

        </div>

    </footer>

</body>

</html>
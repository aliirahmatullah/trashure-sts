<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet" />
    <title>Trashure</title>
    @vite('resources/css/app.css')
    <style>
        html {
            scroll-behavior: smooth;
        }

        .nav-link {
            position: relative;
        }

        .nav-link::after {
            content: '';
            position: absolute;
            bottom: -2px;
            left: 0;
            width: 0;
            height: 2px;
            background: #14b8a6;
            transition: width .25s ease;
        }

        .nav-link:hover::after {
            width: 100%;
        }

        .dropdown-enter {
            transition: all .2s ease;
            transform: translateY(-8px);
            opacity: 0;
            pointer-events: none;
        }

        .dropdown-hover:hover .dropdown-enter {
            transform: translateY(0);
            opacity: 1;
            pointer-events: auto;
        }
    </style>
</head>

<body class="bg-gray-50">
    <header class="sticky top-0 z-40 bg-white/90 backdrop-blur border-b border-gray-200">
        <div class="mx-auto flex h-16 max-w-screen-xl items-center gap-8 px-4 sm:px-6 lg:px-8">

            <!-- Logo / Home Icon -->
            <a class="flex items-center gap-2 text-teal-600 font-semibold" href="{{ route('home') }}">
                @if (request()->routeIs('home.reward.active'))
                    {{-- Ketika User di halaman all rewards maka navbar hanya memunculkan tombol kembali ke home --}}
                @else
                    {{-- Logo Trashure untuk halaman lain --}}
                    <img src="{{ asset('asset/logo.jpg') }}" alt="Trashure" class="h-10 w-auto object-contain">
                    <span class="hidden sm:inline">Trashure</span>
                @endif
            </a>

            <!-- Nav -->
            <div class="flex flex-1 items-center justify-end md:justify-between">
                <nav aria-label="Global" class="hidden md:block">
                    <ul class="flex items-center gap-7 text-sm font-medium">
                        <!-- Navbar Admin -->
                        @if (Auth::check() && Auth::user()->role == 'admin')
                            <li><a href="{{ route('admin.dashboard') }}"
                                    class="nav-link text-gray-600 hover:text-teal-600">Dashboard</a></li>
                            <li><a href="#" class="nav-link text-gray-600 hover:text-teal-600">Laporan &
                                    Statistik</a></li>

                            <!-- Dropdown Data Master -->
                            <li class="relative">
                                <button id="dropdown-master-btn"
                                    class="inline-flex items-center gap-1 text-gray-600 hover:text-teal-600 transition">
                                    Data Master
                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                            d="M5.22 8.22a.75.75 0 011.06 0L10 11.94l3.72-3.72a.75.75 0 111.06 1.06l-4.25 4.25a.75.75 0 01-1.06 0L5.22 9.28a.75.75 0 010-1.06z"
                                            clip-rule="evenodd" />
                                    </svg>
                                </button>

                                <div id="dropdown-master-menu"
                                    class="hidden absolute top-full right-0 mt-2 w-52 origin-top-right rounded-lg bg-white shadow-xl ring-1 ring-gray-100 z-50">
                                    <div class="p-2 space-y-1">
                                        <a href="{{ route('admin.users.index') }}"
                                            class="block px-3 py-2 text-sm text-gray-700 rounded-md hover:bg-teal-50 hover:text-teal-700">Data
                                            User</a>
                                        <a href="{{ route('admin.waste-types.index') }}"
                                            class="block px-3 py-2 text-sm text-gray-700 rounded-md hover:bg-teal-50 hover:text-teal-700">Data
                                            Sampah</a>
                                        <a href="{{ route('admin.locations.index') }}"
                                            class="block px-3 py-2 text-sm text-gray-700 rounded-md hover:bg-teal-50 hover:text-teal-700">Data
                                            Lokasi</a>
                                        <a href="{{ route('admin.transactions.index') }}"
                                            class="block px-3 py-2 text-sm text-gray-700 rounded-md hover:bg-teal-50 hover:text-teal-700">Data
                                            Transaksi</a>
                                        <a href="#"
                                            class="block px-3 py-2 text-sm text-gray-700 rounded-md hover:bg-teal-50 hover:text-teal-700">Data
                                            Poin</a>
                                        <a href="{{ route('admin.rewards.index') }}"
                                            class="block px-3 py-2 text-sm text-gray-700 rounded-md hover:bg-teal-50 hover:text-teal-700">Data
                                            Reward</a>
                                        <a href="{{ route('admin.redeems.index') }}"
                                            class="block px-3 py-2 text-sm text-gray-700 rounded-md hover:bg-teal-50 hover:text-teal-700">Data
                                            Redeem Reward</a>
                                    </div>
                                </div>
                            </li>

                            <!-- Navbar Staff -->
                        @elseif (Auth::check() && Auth::user()->role == 'staff')
                            <li><a href="{{ route('staff.dashboard') }}"
                                    class="nav-link text-gray-600 hover:text-teal-600">Dashboard</a></li>
                            <li><a href="{{ route('staff.transactions.index') }}"
                                    class="nav-link text-gray-600 hover:text-teal-600">Kelola Transaksi</a></li>
                            <li><a href="#" class="nav-link text-gray-600 hover:text-teal-600">Kelola Poin</a>
                            </li>
                            <li><a href="#" class="nav-link text-gray-600 hover:text-teal-600">Laporan Harian</a>
                            </li>

                            <!-- Navbar User  -->
                        @else
                            @if (request()->routeIs('home.reward.active'))
                                <li>
                                    <a href="{{ route('home') }}"
                                        class="inline-flex items-center gap-2 text-gray-600 hover:text-teal-600">
                                        {{-- Icon home --}}
                                        <i class="fa-house fa-solid text-lg"></i>Home
                                    </a>
                                </li>
                            @else
                                <li>
                                    <a href="#about" class="nav-link text-gray-600 hover:text-teal-600">About</a>
                                </li>
                                <li>
                                    <a href="#works" class="nav-link text-gray-600 hover:text-teal-600">How It
                                        Works</a>
                                </li>
                                <li>
                                    <a href="#reward" class="nav-link text-gray-600 hover:text-teal-600">Redeem
                                        Rewards</a>
                                </li>
                                <li>
                                    <a href="{{ route('user.points.index') }}"
                                        class="nav-link text-gray-600 hover:text-teal-600">
                                        My Points</a>
                                </li>
                            @endif
                        @endif
                    </ul>
                </nav>

                <!-- Auth buttons -->
                <div class="flex items-center gap-3">
                    @if (Auth::check())
                        <a href="{{ route('logout') }}"
                            class="hidden sm:inline-block rounded-lg bg-gray-200 px-4 py-2 text-sm font-semibold text-gray-800 hover:bg-red-500 hover:text-white transition">Logout</a>
                    @else
                        <a href="{{ route('login') }}"
                            class="rounded-lg bg-teal-600 px-4 py-2 text-sm font-semibold text-white hover:bg-teal-700 transition">Login</a>
                        <a href="{{ route('signup') }}"
                            class="hidden sm:inline-block rounded-lg bg-gray-100 px-4 py-2 text-sm font-semibold text-teal-600 hover:bg-gray-200 transition">Register</a>
                    @endif

                    <!-- Mobile menu -->
                    <button class="md:hidden p-2 rounded-md text-gray-600 hover:bg-gray-100">
                        <span class="sr-only">Toggle menu</span>
                        <svg class="w-5 h-5" stroke="currentColor" stroke-width="2" fill="none" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                    </button>
                </div>
            </div>
        </div>
    </header>

    @yield('navbar')

    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Script click-to-open -->
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const btn = document.querySelector('#dropdown-master-btn');
            const menu = document.querySelector('#dropdown-master-menu');

            /* toggle saat tombol diklik */
            btn.addEventListener('click', (e) => {
                e.stopPropagation(); // jangan bubbl ke document
                menu.classList.toggle('hidden');
            });

            /* tutup saat klik di luar elemen dropdown */
            document.addEventListener('click', () => menu.classList.add('hidden'));

            /* hindari menu tertutup saat klik di dalam menu */
            menu.addEventListener('click', (e) => e.stopPropagation());
        });
    </script>

    <!-- Footer -->
    <footer class="bg-white border-t border-gray-200 mt-16">
        <div class="max-w-screen-xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8 text-sm text-gray-600">

                <div class="md:col-span-1">
                    <a href="{{ route('home') }}" class="flex items-center gap-2 text-teal-600 font-semibold">
                        <img src="{{ asset('asset/logo.jpg') }}" alt="Trashure" class="h-10 w-auto object-contain">
                        <span>Trashure</span>
                    </a>
                    <p class="mt-3">Kelola sampahmu, raih manfaatnya.</p>
                </div>

                <div>
                    <h6 class="font-semibold text-gray-800 mb-3">Menu</h6>
                    <ul class="space-y-2">
                        <li><a href="{{ route('home') }}" class="hover:text-teal-600 transition">Home</a></li>
                        <li><a href="#" class="hover:text-teal-600 transition">About</a></li>
                        <li><a href="{{ route('home.reward.active') }}"
                                class="hover:text-teal-600 transition">Rewards</a></li>
                        <li><a href="#" class="hover:text-teal-600 transition">My Points</a></li>
                    </ul>
                </div>

                <div>
                    <h6 class="font-semibold text-gray-800 mb-3">Bantuan</h6>
                    <ul class="space-y-2">
                        <li><a href="#" class="hover:text-teal-600 transition">Syarat & Ketentuan</a></li>
                        <li><a href="#" class="hover:text-teal-600 transition">Kebijakan Privasi</a></li>
                        <li><a href="#" class="hover:text-teal-600 transition">FAQ</a></li>
                        <li><a href="#" class="hover:text-teal-600 transition">Kontak Kami</a></li>
                    </ul>
                </div>

                <div>
                    <h6 class="font-semibold text-gray-800 mb-3">Ikuti Kami</h6>
                    <div class="flex gap-4 text-lg">
                        <a href="#" aria-label="Facebook"
                            class="text-gray-400 hover:text-teal-600 transition"><i
                                class="fa-brands fa-facebook"></i></a>
                        <a href="#" aria-label="Instagram"
                            class="text-gray-400 hover:text-teal-600 transition"><i
                                class="fa-brands fa-instagram"></i></a>
                        <a href="#" aria-label="Twitter"
                            class="text-gray-400 hover:text-teal-600 transition"><i
                                class="fa-brands fa-twitter"></i></a>
                        <a href="#" aria-label="TikTok" class="text-gray-400 hover:text-teal-600 transition"><i
                                class="fa-brands fa-tiktok"></i></a>
                    </div>
                </div>
            </div>

            <div class="mt-8 pt-6 border-t border-gray-200 text-center text-xs text-gray-500">
                © <span id="year"></span> Trashure. All rights reserved.
            </div>
        </div>
    </footer>

    <script>
        // auto-update tahun
        document.getElementById('year').textContent = new Date().getFullYear();
    </script>
</body>

</html>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Trashure</title>
    @vite('resources/css/app.css')
    <style>
        /* ====== Micro-interactions ====== */
        .nav-link{ position: relative; }
        .nav-link::after{
            content: '';
            position: absolute;
            bottom: -2px;
            left: 0;
            width: 0;
            height: 2px;
            background: #14b8a6; /* teal-500 */
            transition: width .25s ease;
        }
        .nav-link:hover::after{ width: 100%; }
        .dropdown-enter{ transition: all .2s ease; transform: translateY(-8px); opacity: 0; pointer-events: none; }
        .dropdown-hover:hover .dropdown-enter{ transform: translateY(0); opacity: 1; pointer-events: auto; }
    </style>
</head>
<body class="bg-gray-50">

<!-- ========== HEADER ========== -->
<header class="sticky top-0 z-40 bg-white/90 backdrop-blur border-b border-gray-200">
    <div class="mx-auto flex h-16 max-w-screen-xl items-center gap-8 px-4 sm:px-6 lg:px-8">

        <!-- Logo -->
        <a class="flex items-center gap-2 text-teal-600 font-semibold" href="#">
            <img src="{{ asset('asset/logo.jpg') }}" alt="Trashure" class="h-10 w-auto object-contain">
            <span class="hidden sm:inline">Trashure</span>
        </a>

        <!-- Nav -->
        <div class="flex flex-1 items-center justify-end md:justify-between">
            <nav aria-label="Global" class="hidden md:block">
                <ul class="flex items-center gap-7 text-sm font-medium">
                    <!-- Navbar Admin -->
                    @if (Auth::check() && Auth::user()->role == 'admin')
                        <li><a href="{{ route('admin.dashboard') }}" class="nav-link text-gray-600 hover:text-teal-600">Dashboard</a></li>
                        <li><a href="#" class="nav-link text-gray-600 hover:text-teal-600">Laporan & Statistik</a></li>

                        <!-- Dropdown Data Master -->
                        <li class="relative">
                            <button id="dropdown-master-btn"
                                    class="inline-flex items-center gap-1 text-gray-600 hover:text-teal-600 transition">
                                Data Master
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.22 8.22a.75.75 0 011.06 0L10 11.94l3.72-3.72a.75.75 0 111.06 1.06l-4.25 4.25a.75.75 0 01-1.06 0L5.22 9.28a.75.75 0 010-1.06z" clip-rule="evenodd"/>
                                </svg>
                            </button>

                            <div id="dropdown-master-menu"
                                 class="hidden absolute top-full right-0 mt-2 w-52 origin-top-right rounded-lg bg-white shadow-xl ring-1 ring-gray-100 z-50">
                                <div class="p-2 space-y-1">
                                    <a href="{{ route('admin.users.index') }}" class="block px-3 py-2 text-sm text-gray-700 rounded-md hover:bg-teal-50 hover:text-teal-700">Data User</a>
                                    <a href="{{ route('admin.waste-types.index') }}" class="block px-3 py-2 text-sm text-gray-700 rounded-md hover:bg-teal-50 hover:text-teal-700">Data Sampah</a>
                                    <a href="{{ route('admin.locations.index') }}" class="block px-3 py-2 text-sm text-gray-700 rounded-md hover:bg-teal-50 hover:text-teal-700">Data Lokasi</a>
                                    <a href="{{ route('admin.transactions.index') }}" class="block px-3 py-2 text-sm text-gray-700 rounded-md hover:bg-teal-50 hover:text-teal-700">Data Transaksi</a>
                                    <a href="#" class="block px-3 py-2 text-sm text-gray-700 rounded-md hover:bg-teal-50 hover:text-teal-700">Data Poin</a>
                                    <a href="{{ route('admin.rewards.index') }}" class="block px-3 py-2 text-sm text-gray-700 rounded-md hover:bg-teal-50 hover:text-teal-700">Data Reward</a>
                                    <a href="#" class="block px-3 py-2 text-sm text-gray-700 rounded-md hover:bg-teal-50 hover:text-teal-700">Data Redeem Reward</a>
                                </div>
                            </div>
                        </li>

                    <!-- Navbar Staff -->
                    @elseif (Auth::check() && Auth::user()->role == 'staff')
                        <li><a href="{{ route('staff.dashboard') }}" class="nav-link text-gray-600 hover:text-teal-600">Dashboard</a></li>
                        <li><a href="{{route('staff.transactions.index')}}" class="nav-link text-gray-600 hover:text-teal-600">Kelola Transaksi</a></li>
                        <li><a href="#" class="nav-link text-gray-600 hover:text-teal-600">Kelola Poin</a></li>
                        <li><a href="#" class="nav-link text-gray-600 hover:text-teal-600">Laporan Harian</a></li>

                    <!-- Navbar User (default) -->
                    @else
                        <li><a href="{{ route('home') }}" class="nav-link text-gray-600 hover:text-teal-600">Home</a></li>
                        <li><a href="#" class="nav-link text-gray-600 hover:text-teal-600">About</a></li>
                        <li><a href="#" class="nav-link text-gray-600 hover:text-teal-600">Redeem Rewards</a></li>
                        <li><a href="#" class="nav-link text-gray-600 hover:text-teal-600">My Points</a></li>
                    @endif
                </ul>
            </nav>

            <!-- Auth buttons & hamburger -->
            <div class="flex items-center gap-3">
                @if (Auth::check())
                    <a href="{{ route('logout') }}" class="hidden sm:inline-block rounded-lg bg-gray-200 px-4 py-2 text-sm font-semibold text-gray-800 hover:bg-red-500 hover:text-white transition">Logout</a>
                @else
                    <a href="{{ route('login') }}" class="rounded-lg bg-teal-600 px-4 py-2 text-sm font-semibold text-white hover:bg-teal-700 transition">Login</a>
                    <a href="{{ route('signup') }}" class="hidden sm:inline-block rounded-lg bg-gray-100 px-4 py-2 text-sm font-semibold text-teal-600 hover:bg-gray-200 transition">Register</a>
                @endif

                <!-- Mobile menu -->
                <button class="md:hidden p-2 rounded-md text-gray-600 hover:bg-gray-100">
                    <span class="sr-only">Toggle menu</span>
                    <svg class="w-5 h-5" stroke="currentColor" stroke-width="2" fill="none" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16"/>
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
    const btn  = document.querySelector('#dropdown-master-btn');
    const menu = document.querySelector('#dropdown-master-menu');

    /* toggle saat tombol diklik */
    btn.addEventListener('click', (e) => {
        e.stopPropagation();                 // jangan bubbl ke document
        menu.classList.toggle('hidden');
    });

    /* tutup saat klik di luar elemen dropdown */
    document.addEventListener('click', () => menu.classList.add('hidden'));

    /* hindari menu tertutup saat klik di dalam menu */
    menu.addEventListener('click', (e) => e.stopPropagation());
});
</script>

</body>
</html>
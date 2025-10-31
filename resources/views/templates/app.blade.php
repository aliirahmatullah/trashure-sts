<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Trashure</title>
    <!-- Font Awesome -->
    @vite('resources/css/app.css')
<link
  href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css"
  rel="stylesheet"
/>
<!-- Google Fonts -->
<link
  href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700&display=swap"
  rel="stylesheet"
/>
<!-- MDB -->
<link
  href="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/9.1.0/mdb.min.css"
  rel="stylesheet"
/>
</head>
<body>
        <!-- Navbar -->
    <nav class="navbar navbar-expand-lg bg-body-tertiary">
    <!-- Container wrapper -->
    <div class="container">
        <!-- Navbar brand -->
        <a class="navbar-brand me-2" href="">
        <img
            src="{{asset('asset/logo.jpg')}}"
            height="45"
            alt="Trashure"
            loading="lazy"
            style="margin-top: -1px;"
        />
        </a>

        <!-- Toggle button -->
        <button
        data-mdb-collapse-init
        class="navbar-toggler"
        type="button"
        data-mdb-target="#navbarButtonsExample"
        aria-controls="navbarButtonsExample"
        aria-expanded="false"
        aria-label="Toggle navigation"
        >
        <i class="fas fa-bars"></i>
        </button>

        <!-- Collapsible wrapper -->
        <div class="collapse navbar-collapse" id="navbarButtonsExample">
            <!-- Left links -->
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                {{-- Navbar Admin --}}
                @if (Auth::check() && Auth::user()->role == 'admin')
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('admin.dashboard') }}">Dashboard</a>
                </li>
                <li>
                    <a class="nav-link" href="#">Laporan & Statistik</a>
                </li>
                <li class="nav-item dropdown">
                    <a
                      data-mdb-dropdown-init
                      class="nav-link dropdown-toggle"
                      href="#"
                      id="navbarDropdownMenuLink"
                      role="button"
                      aria-expanded="false"
                    >
                      Data Master
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                      <li>
                        <a class="dropdown-item" href="{{ route('admin.users.index') }}">Data User</a>
                      </li>
                      <li>
                        <a class="dropdown-item" href="#">Data Sampah</a>
                      </li>
                      <li>
                        <a class="dropdown-item" href="#">Data Lokasi</a>
                      </li>
                      <li>
                        <a class="dropdown-item" href="#">Data Transaksi</a>
                      </li>
                      <li>
                        <a class="dropdown-item" href="#">Data Poin</a>
                      </li>
                      <li>
                        <a class="dropdown-item" href="#">Data Reward</a>
                      </li>
                      <li>
                        <a class="dropdown-item" href="#">Data Redeem Reward</a>
                      </li>
                    </ul>
                </li>

            {{-- Navbar Staff --}}
            @elseif (Auth::check() && Auth::user()->role == 'staff')
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('staff.dashboard') }}">Dashboard </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Kelola Transaksi</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Kelola Poin</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Laporan Harian</a>
                </li>

            {{-- Navbar User (default) --}}
            @else
                <li class="nav-item">
                    <a class="nav-link text-dark" href="{{ route('home') }}">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-dark" href="#">About</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-dark" href="#">Deposit Waste</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-dark" href="#">Redeem Rewards</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-dark" href="#">My Point</a>
                </li>
            @endif
        </ul>
        <!-- Left links -->


        <div class="d-flex align-items-center">
            @if (Auth::check())
            {{--Auth::check() : ngecek uda login atau belum--}}
                <a href="{{route('logout')}}" class="btn btn-danger">Logout</a>
            @else
                <a href="{{route('login')}}" class="btn btn-link text-success px-3 me-2" type="button">Login</a>
                <a href="{{route('signup')}}" class="btn btn-success me-3" type="button">Sign Up</a>
            @endif
        </div>
        </div>
        <!-- Collapsible wrapper -->
    </div>
    <!-- Container wrapper -->
    </nav>
    <!-- Navbar -->



    {{--konten dinamis--}}
    @yield('content')

    <!-- MDB -->
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/9.1.0/mdb.umd.min.js"></script>
</body>
</html>
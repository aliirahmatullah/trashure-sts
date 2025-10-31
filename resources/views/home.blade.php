@extends('templates.nav')

@section('navbar')

{{-- FLASH MESSAGES --}}
@if (Session::get('success'))
    <div class="w-full bg-green-100 text-green-700 px-4 py-3 rounded-md font-sans shadow">
        {{ Session::get('success') }} <b>Selamat Datang, {{ Auth::user()->nama }}</b>
    </div>
@endif

@if (Session::get('logout'))
    <div class="w-full bg-red-100 text-red-700 px-4 py-3 rounded-md font-sans shadow">
        {{ Session::get('logout') }}
    </div>
@endif

{{-- HERO SECTION --}}
<section class="min-h-screen bg-gradient-to-r from-emerald-50 to-lime-100 flex items-center">
    <div class="max-w-7xl mx-auto px-6 md:px-12 w-full grid md:grid-cols-2 gap-12 items-center mb-16">
        {{-- Text --}}
        <div class="text-emerald-700 space-y-6">
            <h1 class="text-4xl md:text-6xl font-extrabold leading-tight">
                Turn Trash<br>
                <span class="text-amber-500">Into Treasure</span>
            </h1>
            <p class="text-base md:text-lg leading-relaxed text-gray-700">
                Trashure adalah platform digital yang mengubah sampah menjadi bernilai.
                Setiap sampah yang kamu setor akan dikonversi menjadi poin yang bisa
                ditukar dengan hadiah, sekaligus membantu menjaga lingkungan lebih
                bersih dan berkelanjutan.
            </p>
            {{-- CTA --}}
            <div class="flex flex-col sm:flex-row gap-4 pt-4">
                <button class="px-8 py-3 rounded-full bg-amber-400 text-emerald-900 font-semibold
                               hover:bg-amber-500 hover:scale-105 transition">
                    Join
                </button>
                <button class="px-8 py-3 rounded-full border-2 border-emerald-600 text-emerald-700 font-semibold
                               hover:bg-emerald-600 hover:text-white hover:scale-105 transition">
                    Start Recycling
                </button>
            </div>
        </div>
        {{-- Image --}}
        <div class="flex justify-end">
            <img src="{{ asset('asset/logo-removebg-preview.png') }}" alt="Trashure illustration"
                 class="w-full max-w-sm drop-shadow-2xl rounded-3xl">
        </div>
    </div>
</section>

{{-- ABOUT SECTION --}}
<section class="bg-emerald-800 py-16 md:py-24">
    <div class="max-w-7xl mx-auto px-6 md:px-12 grid md:grid-cols-2 gap-12 items-center">
        {{-- Text --}}
        <div class="text-emerald-50 space-y-6">
            <h2 class="text-3xl md:text-5xl font-extrabold leading-tight">
                About <span class="text-amber-400">Trashure</span>
            </h2>
            <h3 class="text-xl md:text-2xl font-semibold">Apa itu Trashure?</h3>
            <p class="text-base md:text-lg leading-relaxed text-emerald-100">
                Trashure adalah platform digital pengelolaan sampah yang mengubah
                sampah menjadi sesuatu yang bernilai. Dengan sistem reward, setiap
                sampah yang kamu setor akan dikonversi menjadi poin yang bisa
                ditukar dengan hadiah menarik.
            </p>
            {{-- Visi --}}
            <div class="bg-emerald-50 border-l-4 border-emerald-500 p-4 rounded-r-lg text-emerald-900">
                <h4 class="font-bold mb-1">Visi</h4>
                <p class="text-sm md:text-base">
                    Menjadikan sampah sebagai sumber daya baru yang bermanfaat, serta menciptakan masa depan yang lebih bersih, hijau, dan berkelanjutan.
                </p>
            </div>
            {{-- Misi --}}
            <div class="bg-amber-50 border-l-4 border-amber-500 p-4 rounded-r-lg text-amber-900">
                <h4 class="font-bold mb-2">Misi</h4>
                <ol class="list-decimal list-inside space-y-1 text-sm md:text-base">
                    <li>Meningkatkan kesadaran masyarakat terhadap pentingnya pengelolaan sampah.</li>
                    <li>Memberikan insentif nyata bagi siapa saja yang berkontribusi dalam daur ulang.</li>
                    <li>Membangun ekosistem hijau yang menghubungkan masyarakat, bank sampah, pengepul, dan industri daur ulang.</li>
                    <li>Mendukung ekonomi sirkular melalui pemanfaatan kembali sampah menjadi produk bernilai.</li>
                </ol>
            </div>
        </div>
        {{-- Image --}}
        <div class="flex justify-center md:justify-end">
            <img src="" alt="About Trashure"
                 class="w-full max-w-md drop-shadow-xl rounded-3xl">
        </div>
    </div>
</section>

{{-- HOW IT WORKS SECTION --}}
<section class="py-16 md:py-24 bg-white">
    <div class="max-w-6xl mx-auto px-6 md:px-12 text-center">
        <h2 class="text-3xl md:text-5xl font-extrabold text-emerald-700 mb-4">
            How it <span class="text-amber-400">Works?</span>
        </h2>
        <p class="text-gray-600 mb-12 max-w-2xl mx-auto">
            Tiga langkah mudah menuju lingkungan yang lebih bersih dan reward menarik.
        </p>

        <div class="grid md:grid-cols-3 gap-8 items-end">

            {{-- Step 1 --}}
            <div class="flex flex-col items-center">
                <img src="{{ asset('asset/tukar.jpg') }}" alt="Setor Sampah"
                     class="h-48 mb-4 object-cover rounded-3xl max-w-xs">
                <div class="flex items-center justify-center w-16 h-16 mx-auto mb-4 rounded-full
                            bg-emerald-100 text-emerald-700 font-bold text-2xl">
                    1
                </div>
                <h3 class="text-xl font-bold text-emerald-700 mb-2">Setor Sampah</h3>
                <p class="text-gray-600">Kumpulkan sampahmu, lalu setor ke bank sampah mitra kami yang terdekat.</p>
            </div>

            {{-- Step 2 (sedikit lebih panjang) --}}
            <div class="flex flex-col items-center">
                <img src="{{ asset('asset/poin.jpg') }}" alt="Dapot Poin"
                     class="h-56 mb-4 object-cover rounded-3xl max-w-xs">
                <div class="flex items-center justify-center w-16 h-16 mx-auto mb-4 rounded-full
                            bg-amber-100 text-amber-700 font-bold text-2xl">
                    2
                </div>
                <h3 class="text-xl font-bold text-amber-600 mb-2">Dapot Poin</h3>
                <p class="text-gray-600">Sampahmu akan ditimbang dan dikonversi menjadi poin Trashure.</p>
            </div>

            {{-- Step 3 --}}
            <div class="flex flex-col items-center">
                <img src="{{ asset('asset/hadiah.jpg') }}" alt="Tukar Hadiah"
                     class="h-48 mb-4 object-cover rounded-3xl max-w-xs">
                <div class="flex items-center justify-center w-16 h-16 mx-auto mb-4 rounded-full
                            bg-emerald-100 text-emerald-700 font-bold text-2xl">
                    3
                </div>
                <h3 class="text-xl font-bold text-emerald-700 mb-2">Tukar Hadiah</h3>
                <p class="text-gray-600">Tukarkan poinmu dengan beragam hadiah menarik yang tersedia.</p>
            </div>
        </div>
    </div>
</section>



@endsection
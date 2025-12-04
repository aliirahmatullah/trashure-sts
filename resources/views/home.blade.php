@extends('templates.nav')

@section('navbar')
    {{-- Alert --}}
    @if (Session::get('success'))
        <div class="w-full bg-green-100 text-green-700 px-4 py-3 rounded-md font-sans shadow mb-4">
            {{ Session::get('success') }} <b>Selamat Datang, {{ Auth::user()->nama }}</b>
        </div>
    @endif
    @if (Session::get('logout'))
        <div class="w-full bg-red-100 text-red-700 px-4 py-3 rounded-md font-sans shadow mb-4">
            {{ Session::get('logout') }}
        </div>
    @endif

    {{-- Hero Section --}}
    <section class="min-h-screen bg-gradient-to-r from-emerald-50 to-lime-100 flex items-center">
        <div class="max-w-7xl mx-auto px-6 md:px-12 w-full grid md:grid-cols-2 gap-12 items-center">
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
                <div class="flex flex-col sm:flex-row gap-4 pt-4">
                    <button
                        class="px-8 py-3 rounded-full bg-amber-400 text-emerald-900 font-semibold hover:bg-amber-500 hover:scale-105 transition">Join</button>
                    <button
                        class="px-8 py-3 rounded-full border-2 border-emerald-600 text-emerald-700 font-semibold hover:bg-emerald-600 hover:text-white hover:scale-105 transition">Start
                        Recycling</button>
                </div>
            </div>
            <div class="flex justify-end">
                <img src="{{ asset('asset/logo-removebg-preview.png') }}" alt="Trashure illustration"
                    class="w-full max-w-sm drop-shadow-2xl rounded-3xl">
            </div>
        </div>
    </section>

    {{-- ABOUT SECTION --}}
    <section id="about" class="bg-emerald-800 py-16 md:py-24">
        <div class="max-w-7xl mx-auto px-6 md:px-12 grid md:grid-cols-2 gap-12 items-center">
            <div class="text-emerald-50 space-y-6">
                <h2 class="text-3xl md:text-5xl font-extrabold leading-tight">About <span
                        class="text-amber-400">Trashure</span></h2>
                <h3 class="text-xl md:text-2xl font-semibold">Apa itu Trashure?</h3>
                <p class="text-base md:text-lg leading-relaxed text-emerald-100">
                    Trashure adalah platform digital pengelolaan sampah yang mengubah sampah menjadi sesuatu yang bernilai.
                    Dengan sistem reward, setiap sampah yang kamu setor akan dikonversi menjadi poin yang bisa ditukar
                    dengan hadiah menarik.
                </p>
                <div class="bg-emerald-50 border-l-4 border-emerald-500 p-4 rounded-r-lg text-emerald-900">
                    <h4 class="font-bold mb-1">Visi</h4>
                    <p class="text-sm md:text-base">Menjadikan sampah sebagai sumber daya baru yang bermanfaat, serta
                        menciptakan masa depan yang lebih bersih, hijau, dan berkelanjutan.</p>
                </div>
                <div class="bg-amber-50 border-l-4 border-amber-500 p-4 rounded-r-lg text-amber-900">
                    <h4 class="font-bold mb-2">Misi</h4>
                    <ol class="list-decimal list-inside space-y-1 text-sm md:text-base">
                        <li>Meningkatkan kesadaran masyarakat terhadap pentingnya pengelolaan sampah.</li>
                        <li>Memberikan insentif nyata bagi siapa saja yang berkontribusi dalam daur ulang.</li>
                        <li>Membangun ekosistem hijau yang menghubungkan masyarakat, bank sampah, pengepul, dan industri
                            daur ulang.</li>
                        <li>Mendukung ekonomi sirkular melalui pemanfaatan kembali sampah menjadi produk bernilai.</li>
                    </ol>
                </div>
            </div>
            <div class="flex justify-center md:justify-end">
                {{-- Ganti dengan gambar about sesuai kebutuhan --}}
                <img src="{{ asset('asset/logo.jpg') }}" alt="About Trashure"
                    class="w-full max-w-md drop-shadow-xl rounded-3xl">
            </div>
        </div>
    </section>

    {{-- HOW IT WORKS SECTION --}}
    <section id="works" class="py-16 md:py-24 bg-white">
        <div class="max-w-6xl mx-auto px-6 md:px-12 text-center">
            <h2 class="text-3xl md:text-5xl font-extrabold text-emerald-700 mb-4">How it <span
                    class="text-amber-400">Works?</span></h2>
            <p class="text-gray-600 mb-12 max-w-2xl mx-auto">Tiga langkah mudah menuju lingkungan yang lebih bersih dan
                reward menarik.</p>
            <div class="grid md:grid-cols-3 gap-8 items-end">
                <div class="flex flex-col items-center">
                    <img src="{{ asset('asset/tukar.jpg') }}" alt="Setor Sampah"
                        class="h-48 mb-4 object-cover rounded-3xl max-w-xs">
                    <div
                        class="flex items-center justify-center w-16 h-16 mx-auto mb-4 rounded-full bg-emerald-100 text-emerald-700 font-bold text-2xl">
                        1</div>
                    <h3 class="text-xl font-bold text-emerald-700 mb-2">Setor Sampah</h3>
                    <p class="text-gray-600">Kumpulkan sampahmu, lalu setor ke bank sampah mitra kami yang terdekat.</p>
                </div>
                <div class="flex flex-col items-center">
                    <img src="{{ asset('asset/poin.jpg') }}" alt="Dapat Poin"
                        class="h-56 mb-4 object-cover rounded-3xl max-w-xs">
                    <div
                        class="flex items-center justify-center w-16 h-16 mx-auto mb-4 rounded-full bg-amber-100 text-amber-700 font-bold text-2xl">
                        2</div>
                    <h3 class="text-xl font-bold text-amber-600 mb-2">Dapat Poin</h3>
                    <p class="text-gray-600">Sampahmu akan ditimbang dan dikonversi menjadi poin Trashure.</p>
                </div>
                <div class="flex flex-col items-center">
                    <img src="{{ asset('asset/hadiah.jpg') }}" alt="Tukar Hadiah"
                        class="h-48 mb-4 object-cover rounded-3xl max-w-xs">
                    <div
                        class="flex items-center justify-center w-16 h-16 mx-auto mb-4 rounded-full bg-emerald-100 text-emerald-700 font-bold text-2xl">
                        3</div>
                    <h3 class="text-xl font-bold text-emerald-700 mb-2">Tukar Hadiah</h3>
                    <p class="text-gray-600">Tukarkan poinmu dengan beragam hadiah menarik yang tersedia.</p>
                </div>
            </div>
        </div>
    </section>

    {{-- Rewards Section --}}
    <section id="reward" class="bg-emerald-800 px-6 sm:px-8 lg:px-8 py-16 md:py-24">
        <div class="max-w-6xl mx-auto text-center">
            <h2 class="text-3xl md:text-5xl font-extrabold text-white">Trashure <span class="text-amber-400">Rewards</span>
            </h2>
            <p class="text-white mt-4 max-w-2xl mx-auto">Hadiah menarik yang tersedia untuk kamu.</p>

            <div class="max-w-5xl mx-auto mt-12 flex justify-between items-center">
                <h5 class="text-emerald-900 rounded-r-full bg-white font-semibold py-2 px-4">
                    <i class="fa-solid fa-gift text-amber-500"></i> Hadiah Tersedia
                </h5>
            </div>
        </div>

        {{-- Preview Hadiah --}}
        <div class="max-w-5xl mx-auto mt-8">
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                @foreach ($reward as $r)
                    <div class="bg-white rounded-xl shadow-lg overflow-hidden flex flex-col">
                        <img src="{{ asset('storage/' . $r->gambar_hadiah) }}" alt="{{ $r->nama_hadiah }}"
                            class="w-full h-52 object-cover">
                        <div class="p-4 flex flex-col flex-1">
                            <h3 class="text-lg font-bold text-emerald-700 mb-2">{{ $r->nama_hadiah }}</h3>
                            <p class="text-gray-600 text-sm mb-4 line-clamp-3">{{ $r->desk_hadiah }}</p>
                            <div class="flex items-center justify-between gap-2 mt-auto">
                                <button type="button"
                                    class="inline-flex items-center gap-1 rounded-full bg-amber-400 text-white text-xs font-semibold py-1 px-3 hover:bg-amber-500 transition-colors duration-200"
                                    onclick="showDetail({
                                        nama: '{{ $r->nama_hadiah }}',
                                        desk: '{{ $r->desk_hadiah }}',
                                        gambar: '{{ asset('storage/' . $r->gambar_hadiah) }}',
                                        poin: '{{ $r->p_dibutuhkan }}',
                                        id: '{{ $r->id_hadiah }}'
                                    })">
                                    Lihat Detail
                                </button>
                                <span
                                    class="inline-flex items-center gap-1 rounded-full bg-emerald-500 text-white text-xs font-semibold py-1 px-3">
                                    {{ number_format($r->p_dibutuhkan, 0, ',', '.') }} Poin
                                </span>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        {{-- Button All Rewards --}}
        <div class="flex justify-center mt-10">
            <a href="{{ route('home.reward.active') }}"
                class="rounded-full bg-amber-400 text-emerald-900 font-semibold py-2 px-6 hover:bg-white transition-colors duration-200">
                All Rewards
            </a>
        </div>
    </section>

    {{-- Modal Detail --}}
    <div id="detailModal"
        class="fixed inset-0 z-50 hidden items-center justify-center bg-black bg-opacity-50 overflow-auto">
        <div class="bg-white rounded-2xl shadow-2xl w-11/12 max-w-lg my-8">
            {{-- header --}}
            <div class="flex justify-between items-center px-5 py-4 border-b">
                <h2 id="modalTitle" class="text-lg font-bold text-emerald-700"></h2>
                <button onclick="closeModal()" class="text-gray-400 hover:text-gray-600 text-2xl">&times;</button>
            </div>
            {{-- body --}}
            <div class="p-5">
                <img id="modalImg" class="w-full h-72 object-contain rounded-3xl mb-4" src="" alt="">
                <p id="modalDesc" class="text-gray-600 text-sm mb-4"></p>
                <p class="text-sm text-gray-700 font-semibold">
                    Poin yang dibutuhkan: <span id="modalPoin" class="text-emerald-600"></span>
                </p>
            </div>
            {{-- footer --}}
            <div class="px-5 pb-4 flex justify-end items-center gap-3">
    <button onclick="closeModal()"
            class="px-4 py-2 rounded-lg bg-gray-200 text-gray-700 hover:bg-gray-300 transition">
        Batal
    </button>
    <form id="formTukar" method="POST" action="">
        @csrf
        <button type="submit"
            class="px-4 py-2 rounded-lg bg-emerald-600 text-white hover:bg-emerald-700 transition">
            Tukar Hadiah
        </button>
    </form>
</div>
        </div>
    </div>

    <script>
        function showDetail(data) {
            document.getElementById('modalTitle').innerText = data.nama;
            document.getElementById('modalDesc').innerText = data.desk;
            document.getElementById('modalPoin').innerText = parseInt(data.poin).toLocaleString('id-ID') + ' Poin';
            document.getElementById('modalImg').src = data.gambar;
            document.getElementById('formTukar').action =  `/my/redeem/${data.id}`;
            document.getElementById('detailModal').classList.remove('hidden');
            document.getElementById('detailModal').classList.add('flex');
            document.body.classList.add('overflow-hidden');
        }

        function closeModal() {
            document.getElementById('detailModal').classList.add('hidden');
            document.getElementById('detailModal').classList.remove('flex');
            document.body.classList.remove('overflow-hidden');
        }

        // Tutup modal saat tekan Escape
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') closeModal();
        });
    </script>
@endsection

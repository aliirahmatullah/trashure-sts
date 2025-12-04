@extends('templates.nav')
@section('navbar')
    {{-- Container + judul --}}
    <div class="py-16 md:py-24 bg-emerald-800">
        <h5 class="text-center text-4xl font-extrabold text-white">Reward <span class="text-amber-500">Tersedia</span></h5>

        <div class="max-w-5xl mx-auto mt-8">
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                @foreach ($reward as $r)
                    <div class="bg-white rounded-xl shadow-lg overflow-hidden flex flex-col">
                        <img src="{{ asset('storage/' . $r->gambar_hadiah) }}" alt="{{ $r->nama_hadiah }}"
                            class="w-full h-52 object-cover">

                        <div class="p-4 flex flex-col flex-1">
                            <h3 class="text-lg font-bold text-emerald-700 mb-2">
                                {{ $r->nama_hadiah }}
                            </h3>
                            <p class="text-gray-600 text-sm mb-4 line-clamp-3">
                                {{ $r->desk_hadiah }}
                            </p>

                            <div class="flex-1"></div>

                            <div class="flex items-center justify-between gap-2 mt-auto">
                                <button type="button"
                                    class="inline-flex items-center gap-1 rounded-full bg-amber-400 text-white text-xs font-semibold py-1 px-3 hover:bg-amber-500 transition-colors duration-200"
                                    onclick="showDetail
                            ({
                            nama: '{{ $r->nama_hadiah }}',
                            desk: '{{ $r->desk_hadiah }}',
                            gambar: '{{ asset('storage/' . $r->gambar_hadiah) }}',
                            poin: '{{ $r->p_dibutuhkan }}',
                            id: '{{ $r->id_hadiah }}'
                            })
">
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

        {{-- Modal Detail --}}
        <div id="detailModal" class="fixed inset-0 z-50 hidden items-center justify-center bg-black bg-opacity-50">
            <div class="bg-white rounded-2xl shadow-2xl w-11/12 max-w-lg">
                {{-- header --}}
                <div class="flex justify-between items-center px-5 py-4 border-b">
                    <h2 id="modalTitle" class="text-lg font-bold text-emerald-700"></h2>
                    <button onclick="closeModal()" class="text-gray-400 hover:text-gray-600">
                    </button>
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
                <div class="px-5 pb-4 flex justify-end gap-2">
                    <button onclick="closeModal()" class="px-4 py-2 rounded-lg bg-gray-200 text-gray-700 hover:bg-gray-300">
                        Batal
                    </button>
                    {{-- === PERUBAHAN : form & tombol tukar --}}
                    {{-- tombol Tukar Hadiah --}}
                    <a id="btnTukar"
                        class="px-4 py-2 rounded-lg bg-emerald-600 text-white hover:bg-emerald-700 cursor-pointer">
                        Tukar Hadiah
                    </a>
                </div>
            </div>
        </div>
    </div>

    <script>
        function showDetail(data) {
            document.getElementById('modalTitle').innerText = data.nama;
            document.getElementById('modalDesc').innerText = data.desk;
            document.getElementById('modalPoin').innerText = data.poin.toLocaleString('id-ID') + ' Poin';
            document.getElementById('modalImg').src = data.gambar;
            document.getElementById('btnTukar').href = `/my/redeem/form/${data.id}`;
            document.getElementById('detailModal').classList.remove('hidden');
            document.getElementById('detailModal').classList.add('flex');
        }

        function closeModal() {
            document.getElementById('detailModal').classList.add('hidden');
            document.getElementById('detailModal').classList.remove('flex');
        }
    </script>
@endsection

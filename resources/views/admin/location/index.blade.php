@extends('templates.nav')

@section('navbar')
<div class="container mx-auto mt-4">
    {{-- Alert --}}
    @if (session('success'))
        <div class="mb-4 flex items-center gap-2 rounded-lg bg-green-100 px-4 py-3 text-sm font-medium text-green-700">
            {{ session('success') }}
        </div>
    @elseif (session('error'))
        <div class="mb-4 flex items-center gap-2 rounded-lg bg-red-100 px-4 py-3 text-sm font-medium text-red-700">
            {{ session('error') }}
        </div>
    @endif

    {{-- Header & Tombol Tambah --}}
    <div class="mb-4 flex items-center justify-end">
        <a href="{{ route('admin.locations.trash')}}" class="rounded-md bg-yellow-600 px-4 py-2 mr-2 text-sm font-medium text-white transition hover:bg-yellow-700">Data Sampah</a>
        <a href="{{ route('admin.locations.export')}}" class="rounded-md bg-blue-600 px-4 py-2 mr-2 text-sm font-medium text-white transition hover:bg-blue-700mom">Export Data (.xlsx)</a>
        <a href="{{ route('admin.locations.create') }}"
           class="rounded-md bg-green-600 px-4 py-2 text-sm font-medium text-white transition hover:bg-green-700">
            Tambah Data
        </a>
    </div>
    <h1 class="text-xl font-semibold text-gray-800 mb-2">Data Lokasi Cabang</h1>


    {{-- Tabel --}}
    <div class="overflow-hidden rounded-lg border border-gray-200 shadow-sm">
        <table class="min-w-full divide-y divide-gray-200 text-sm text-gray-700">
            <thead class="bg-gray-100 text-xs font-semibold uppercase text-gray-600">
                <tr>
                    <th class="px-6 py-3 text-center">#</th>
                    <th class="px-6 py-3 text-center">Nama Cabang</th>
                    <th class="px-6 py-3 text-center">Alamat Cabang</th>
                    <th class="px-6 py-3 text-center">Kontak Cabang</th>
                    <th class="px-6 py-3 text-center">Aksi</th>
                </tr>
            </thead>

            <tbody class="divide-y divide-gray-200 bg-white">
                @foreach ($location as $key => $loc)
                <tr class="transition hover:bg-gray-50">
                    <td class="whitespace-nowrap px-6 py-3 text-center">{{ $key + 1 }}</td>
                    <td class="whitespace-nowrap px-6 py-3 text-center">{{ $loc->nama_lok }}</td>
                    <td class="whitespace-nowrap px-6 py-3 text-center">{{ $loc->alamat_lok }}</td>
                    <td class="whitespace-nowrap px-6 py-3 text-center">{{ $loc->kontak_lok }}</td>
                    <td class="whitespace-nowrap px-6 py-3 text-center">
                        <div class="flex items-center justify-center gap-2">
                            {{-- Tombol Detail (Tailwind) --}}
                            <button onclick="openModal({{ json_encode($loc) }})"
                                    class="rounded-md bg-slate-600 px-3 py-1 text-xs font-medium text-white transition hover:bg-slate-700">
                                Detail
                            </button>

                            <a href="{{ route('admin.locations.edit', $loc->id_lokasi) }}"
                               class="rounded-md bg-blue-600 px-3 py-1 text-xs font-medium text-white transition hover:bg-blue-700">
                               Edit
                            </a>

                            <form action="{{ route('admin.locations.delete', $loc->id_lokasi) }}" method="POST">
                                @csrf @method('DELETE')
                                <button type="submit"
                                        class="rounded-md bg-red-600 px-3 py-1 text-xs font-medium text-white transition hover:bg-red-700">
                                    Hapus
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

{{-- Modal Detail --}}
<div id="detailModal" class="fixed inset-0 z-50 hidden items-center justify-center bg-black bg-opacity-40">
    <div class="w-11/12 max-w-lg rounded-xl bg-white p-6 shadow-lg sm:p-8">
        <div class="mb-4 flex items-center justify-between">
            <h2 class="text-lg font-semibold text-gray-800">Detail Cabang</h2>
            <button onclick="closeModal()" class="text-gray-400 hover:text-gray-600">
                <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>

        <div class="space-y-3 text-sm text-gray-700">
            <p><span class="font-medium text-black">Nama Cabang:</span> <span id="detNama" class="text-black"></span></p>
            <p><span class="font-medium text-black">Alamat Cabang:</span> <span id="detAlamat" class="text-black"></span></p>
            <p><span class="font-medium text-black">Kota:</span> <span id="detKota" class="text-black"></span></p>
            <p><span class="font-medium text-black">Provinsi:</span> <span id="detProvinsi" class="text-black"></span></p>
            <p><span class="font-medium text-black">Kontak Cabang:</span> <span id="detKontak" class="text-black"></span></p>
        </div>

        <div class="mt-6 text-right">
            <button onclick="closeModal()"
                    class="rounded-md bg-gray-200 px-4 py-2 text-sm font-medium text-white-700 transition hover:bg-red-500 transition hover:text-white">
                Tutup
            </button>
        </div>
    </div>
</div>

<script>
    function openModal(data) {
        document.getElementById('detNama').textContent     = data.nama_lok ?? '-';
        document.getElementById('detAlamat').textContent   = data.alamat_lok ?? '-';
        document.getElementById('detKota').textContent     = data.kota ?? '-';
        document.getElementById('detProvinsi').textContent = data.provinsi ?? '-';
        document.getElementById('detKontak').textContent   = data.kontak_lok ?? '-';
        document.getElementById('detailModal').classList.remove('hidden');
        document.getElementById('detailModal').classList.add('flex');
    }
    function closeModal() {
        document.getElementById('detailModal').classList.add('hidden');
        document.getElementById('detailModal').classList.remove('flex');
    }
</script>
@endsection
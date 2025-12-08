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
        <a href="{{ route('admin.waste-types.trash')}}" class="rounded-md bg-yellow-600 px-4 py-2 mr-2 text-sm font-medium text-white transition hover:bg-yellow-700">Data Sampah</a>
        <a href="{{ route('admin.waste-types.export')}}" class="rounded-md bg-blue-600 px-4 py-2 mr-2 text-sm font-medium text-white transition hover:bg-blue-700mom">Export Data (.xlsx)</a>
        <a href="{{ route('admin.waste-types.create') }}"
           class="rounded-md bg-green-600 px-4 py-2 text-sm font-medium text-white transition hover:bg-green-700">
            Tambah Data
        </a>
    </div>
    <h1 class="text-xl font-semibold text-gray-800 mb-2">Data Jenis Sampah</h1>


    {{-- Tabel --}}
    <div class="overflow-hidden rounded-lg border border-gray-200 shadow-sm">
        <table class="min-w-full divide-y divide-gray-200 text-sm text-gray-700">
            <thead class="bg-gray-100 text-xs font-semibold uppercase text-gray-600">
                <tr>
                    <th class="px-6 py-3 text-center">#</th>
                    <th class="px-6 py-3 text-center">Nama Jenis</th>
                    <th class="px-6 py-3 text-center">Poin per Kg</th>
                    <th class="px-6 py-3 text-center">Kategori Sampah</th>
                    <th class="px-6 py-3 text-center">Aksi</th>
                </tr>
            </thead>

            <tbody class="divide-y divide-gray-200 bg-white">
                @foreach ($wasteType as $key => $wasteType)
                <tr class="transition hover:bg-gray-50">
                    <td class="whitespace-nowrap px-6 py-3 text-center">{{ $key + 1 }}</td>
                    <td class="whitespace-nowrap px-6 py-3 text-center">{{ $wasteType->nama_jenis }}</td>
                    <td class="whitespace-nowrap px-6 py-3 text-center">{{ $wasteType->poin_per_kg }}</td>
                    <td class="whitespace-nowrap px-6 py-3 text-center">{{ $wasteType->kategori }}</td>
                    <td class="whitespace-nowrap px-6 py-3 text-center">
                        <div class="flex items-center justify-center gap-2">
                            <a href="{{ route('admin.waste-types.edit', $wasteType->id_jenis) }}"
                               class="rounded-md bg-blue-600 px-3 py-1 text-xs font-medium text-white transition hover:bg-blue-700">
                               Edit
                            </a>

                            <form action="{{ route('admin.waste-types.delete', $wasteType->id_jenis) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                        class="rounded-md bg-red-600 px-3 py-1 text-xs font-medium text-white transition hover:bg-red-700">
                                    Hapus
                                </button>
                            </form>
                        </div>
                    </td>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection

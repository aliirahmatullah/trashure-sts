@extends('templates.nav')

@section('navbar')
<div class="container mx-auto mt-4">
    @if (session('success'))
        <div class="mb-4 rounded-lg bg-green-100 px-4 py-3 text-sm font-medium text-green-700">
            {{ session('success') }}
        </div>
    @elseif (session('error'))
        <div class="mb-4 rounded-lg bg-red-100 px-4 py-3 text-sm font-medium text-red-700">
            {{ session('error') }}
        </div>
    @endif

    <div class="mb-4 flex items-center justify-end">
        <a href="{{ route('admin.rewards.trash')}}" class="rounded-md bg-yellow-600 px-4 py-2 mr-2 text-sm font-medium text-white transition hover:bg-yellow-700">Data Sampah</a>
        <a href="{{ route('admin.rewards.export')}}" class="rounded-md bg-blue-600 px-4 py-2 mr-2 text-sm font-medium text-white transition hover:bg-blue-700">Export Data</a>
        <a href="{{ route('admin.rewards.create') }}" class="rounded-md bg-green-600 px-4 py-2 text-sm font-medium text-white hover:bg-green-700">
            Tambah Data
        </a>
    </div>
    <h1 class="text-xl font-semibold text-gray-800 mb-2">Data Reward</h1>


    <div class="overflow-hidden rounded-lg border border-gray-200 shadow-sm">
        <table class="min-w-full divide-y divide-gray-200 text-sm text-gray-700">
            <thead class="bg-gray-100 text-xs font-semibold uppercase text-gray-600">
                <tr>
                    <th class="px-6 py-3 text-center">#</th>
                    <th class="px-6 py-3 text-center">Nama Hadiah</th>
                    <th class="px-6 py-3 text-center">Deskripsi Hadiah</th>
                    <th class="px-6 py-3 text-center">Poin Dibutuhkan</th>
                    <th class="px-6 py-3 text-center">Stok Hadiah</th>
                    <th class="px-6 py-3 text-center">Gambar Hadiah</th>
                    <th class="px-6 py-3 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200 bg-white">
                @foreach ($reward as $key => $r)
                <tr class="hover:bg-gray-50">
                    <td class="px-6 py-3 text-center">{{ $key + 1 }}</td>
                    <td class="px-6 py-3 text-center">{{ $r->nama_hadiah }}</td>
                    <td class="px-6 py-3 text-center">{{ $r->desk_hadiah }}</td>
                    <td class="px-6 py-3 text-center">{{ $r->p_dibutuhkan }}</td>
                    <td class="px-6 py-3 text-center">{{ $r->stok }}</td>
                    <td class="px-6 py-3 text-center">
                        <img src="{{ asset('storage/' . $r->gambar_hadiah) }}" alt="Gambar Hadiah" class="h-125 w-20 rounded object-cover">
                    </td>
                    <td class="px-6 py-3 text-center">
                        <div class="flex items-center justify-center gap-2">
                            <a href="{{ route('admin.rewards.edit', $r->id_hadiah) }}" class="rounded-md bg-blue-600 px-3 py-1 text-xs font-medium text-white hover:bg-blue-700">Edit</a>
                            <form action="{{ route('admin.rewards.delete', $r->id_hadiah) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="rounded-md bg-red-600 px-3 py-1 text-xs font-medium text-white hover:bg-red-700">Hapus</button>
                            </form>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
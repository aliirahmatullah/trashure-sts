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

    {{-- Header & Tombol Navigasi --}}
    <div class="mb-4 flex items-center justify-between">
        <h1 class="text-xl font-semibold text-gray-800">Data Redeem Reward (Trash)</h1>
        <div class="flex gap-2">
            <a href="{{ route('admin.redeems.index') }}"
               class="rounded-md bg-gray-600 px-4 py-2 text-sm font-medium text-white transition hover:bg-gray-700">
                Kembali
            </a>
        </div>
    </div>

    {{-- Tabel --}}
    <div class="overflow-hidden rounded-lg border border-gray-200 shadow-sm">
        <table class="min-w-full divide-y divide-gray-200 text-sm text-gray-700">
            <thead class="bg-gray-100 text-xs font-semibold uppercase text-gray-600">
                <tr>
                    <th class="px-6 py-3 text-center">#</th>
                    <th class="px-6 py-3 text-center">Nama</th>
                    <th class="px-6 py-3 text-center">No.Transaksi</th>
                    <th class="px-6 py-3 text-center">Status</th>
                    <th class="px-6 py-3 text-center">Aksi</th>
                </tr>
            </thead>

            <tbody class="divide-y divide-gray-200 bg-white">
                @forelse ($redeem_reward as $key => $trash)
                <tr class="transition hover:bg-gray-50">
                    <td class="whitespace-nowrap px-6 py-3 text-center">{{ $key + 1 }}</td>
                    <td class="whitespace-nowrap px-6 py-3 text-center">{{ $trash->user->nama ?? '-' }}</td>
                    <td class="whitespace-nowrap px-6 py-3 text-center">{{ $trash->no_transaksi }}</td>
                    <td class="whitespace-nowrap px-6 py-3 text-center">
                        <span class="rounded-full px-3 py-1 text-xs font-semibold
                            @if($trash->status_tukar === 'pending')   bg-yellow-200 text-yellow-700
                            @elseif($trash->status_tukar === 'approved') bg-blue-100 text-blue-700
                            @elseif($trash->status_tukar === 'done') bg-green-100 text-green-700
                            @elseif($trash->status_tukar === 'canceled') bg-red-100 text-red-700
                            @endif">
                            {{ ucfirst($trash->status_tukar) }}
                        </span>
                    </td>
                    <td class="whitespace-nowrap px-6 py-3 text-center">
                        <div class="flex items-center justify-center gap-2">
                            {{-- Kembalikan --}}
                            <form action="{{ route('admin.redeems.restore', $trash->id_tukar) }}" method="POST">
                                @csrf @method('PATCH')
                                <button type="submit"
                                        class="rounded-md bg-yellow-500 px-3 py-1 text-xs font-medium text-white transition hover:bg-yellow-600">
                                    Kembalikan
                                </button>
                            </form>

                            {{-- Hapus Permanen --}}
                            <form action="{{ route('admin.redeems.delete_permanent', $trash->id_tukar) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                        class="rounded-md bg-red-600 px-3 py-1 text-xs font-medium text-white transition hover:bg-red-700">
                                    Hapus Permanen
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="px-6 py-3 text-center text-sm text-gray-500">
                        Tidak ada data transaksi yang dihapus.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
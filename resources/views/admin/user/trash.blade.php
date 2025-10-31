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
        <h1 class="text-xl font-semibold text-gray-800">Data Pengguna & Staff (Trash)</h1>
        <div class="flex gap-2">
            <a href="{{ route('admin.users.index') }}"
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
                    <th class="px-6 py-3 text-center">Email</th>
                    <th class="px-6 py-3 text-center">Role</th>
                    <th class="px-6 py-3 text-center">Aksi</th>
                </tr>
            </thead>

            <tbody class="divide-y divide-gray-200 bg-white">
                @forelse ($users as $key => $u)
                <tr class="transition hover:bg-gray-50">
                    <td class="whitespace-nowrap px-6 py-3 text-center">{{ $key + 1 }}</td>
                    <td class="whitespace-nowrap px-6 py-3 text-center">{{ $u->nama }}</td>
                    <td class="whitespace-nowrap px-6 py-3 text-center">{{ $u->email }}</td>
                    <td class="whitespace-nowrap px-6 py-3 text-center">
                        @php
                            $badge = match($u->role) {
                                'admin' => 'bg-red-500 text-white',
                                'staff' => 'bg-blue-500 text-white',
                                'user'  => 'bg-green-500 text-white',
                                default => 'bg-gray-400 text-white'
                            };
                        @endphp
                        <span class="inline-block rounded-full px-3 py-1 text-xs font-medium {{ $badge }}">
                            {{ ucfirst($u->role) }}
                        </span>
                    </td>
                    <td class="whitespace-nowrap px-6 py-3 text-center">
                        <div class="flex items-center justify-center gap-2">
                            {{-- Kembalikan --}}
                            <form action="{{ route('admin.users.restore', $u->id_user) }}" method="POST">
                                @csrf @method('PATCH')
                                <button type="submit"
                                        class="rounded-md bg-yellow-500 px-3 py-1 text-xs font-medium text-white transition hover:bg-yellow-600">
                                    Kembalikan
                                </button>
                            </form>

                            {{-- Hapus Permanen --}}
                            <form action="{{ route('admin.users.delete_permanent', $u->id_user) }}" method="POST">
                                @csrf @method('DELETE')
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
                    <td colspan="5" class="px-6 py-3 text-center text-sm text-gray-500">
                        Tidak ada data yang dihapus.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
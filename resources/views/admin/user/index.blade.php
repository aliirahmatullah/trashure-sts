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
        <a href="{{ route('admin.users.trash')}}" class="rounded-md bg-yellow-600 px-4 py-2 mr-2 text-sm font-medium text-white transition hover:bg-yellow-700">Data Sampah</a>
        <a href="{{ route('admin.users.export')}}" class="rounded-md bg-blue-600 px-4 py-2 mr-2 text-sm font-medium text-white transition hover:bg-blue-700">Export Data</a>
        <a href="{{ route('admin.users.create') }}"
           class="rounded-md bg-green-600 px-4 py-2 text-sm font-medium text-white transition hover:bg-green-700">
           Tambah Data
        </a>
    </div>
    <h1 class="text-xl font-semibold text-gray-800 mb-2">Data Pengguna & Staff</h1>


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
                @foreach ($user as $key => $u)
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
                            <a href="{{ route('admin.users.edit', $u->id_user) }}"
                               class="rounded-md bg-blue-600 px-3 py-1 text-xs font-medium text-white transition hover:bg-blue-700">
                               Edit
                            </a>

                            <form action="{{ route('admin.users.delete', $u->id_user) }}" method="POST">
                                @csrf
                                @method('DELETE')
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

@endsection

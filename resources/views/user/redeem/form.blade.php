@extends('templates.nav')
@section('navbar')
    <div class="max-w-xl mx-auto px-6 py-8">
        @if (session('error'))
            <div class="mb-4 p-3 rounded bg-red-100 text-red-700">{{ session('error') }}</div>
        @endif
        @if (session('success'))
            <div class="mb-4 p-3 rounded bg-green-100 text-green-700">{{ session('success') }}</div>
        @endif
        {{-- Judul --}}
        <h2 class="text-xl font-semibold text-gray-800 mb-4">Tukar Hadiah</h2>

        {{-- Info Hadiah --}}
        <div class="bg-white rounded-lg border p-4 mb-6">
            <img src="{{ asset('storage/' . $reward->gambar_hadiah) }}" class="w-full h-full object-cover rounded mb-3">
            <p class="text-gray-700 font-medium">{{ $reward->nama_hadiah }}</p>
            <p class="text-sm text-gray-600 mt-1">{{ $reward->desk_hadiah }}</p>
            <p class="text-sm text-gray-500 mt-2">
                Poin dibutuhkan: <span
                    class="font-semibold text-emerald-600">{{ number_format($reward->p_dibutuhkan, 0, ',', '.') }}</span>
            </p>
            <p class="text-sm text-gray-500">
                Poin Anda: <span class="font-semibold">{{ number_format(auth()->user()->poin, 0, ',', '.') }}</span>
            </p>
        </div>

        {{-- Form --}}
        <form action="{{ route('user.redeem.process', $reward->id_hadiah) }}" method="POST" class="space-y-4">
            @csrf

            {{-- Nama --}}
            <div>
                <label class="block text-sm font-medium text-gray-700">Nama Penerima</label>
                <input type="text" name="nama_penerima" value="{{ old('nama_penerima', auth()->user()->nama) }}" required
                    class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-emerald-500">
            </div>

            {{-- Alamat --}}
            <div>
                <label class="block text-sm font-medium text-gray-700">Alamat Pengiriman</label>
                <textarea name="alamat_pengiriman" rows="3" required
                    class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-emerald-500">{{ old('alamat_pengiriman', auth()->user()->alamat) }}</textarea>
            </div>

            {{-- No HP --}}
            <div>
                <label class="block text-sm font-medium text-gray-700">No. HP Penerima</label>
                <input type="text" name="no_hp_penerima" value="{{ old('no_hp_penerima', auth()->user()->no_hp) }}"
                    required class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-emerald-500">
            </div>

            <button type="submit" class="w-full py-2 bg-emerald-600 text-white rounded-md hover:bg-emerald-700 transition">
                Tukar
            </button>
        </form>



    </div>
@endsection

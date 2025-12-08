@extends('templates.nav')

@section('navbar')
    <div class="min-h-screen bg-gray-50 py-10">
        <form action="{{ route('admin.redeems.update', $redeem->id_tukar) }}" method="POST"
            class="mx-auto max-w-xl rounded-xl bg-white p-6 shadow-sm sm:p-8">
            @csrf
            @method('PUT')

            {{-- Judul --}}
            <h2 class="mb-6 text-lg font-semibold text-gray-800">
                Edit Data Penerima Hadiah
            </h2>

            {{-- Nama Penerima --}}
            <div class="mb-5">
                <label class="mb-1 block text-sm font-medium text-gray-700">
                    Nama Penerima
                </label>
                <input type="text" name="nama_penerima" required value="{{ old('nama_penerima', $redeem->nama_penerima) }}"
                    class="w-full rounded-lg border border-gray-300 px-3 py-2.5 text-sm
                       focus:border-emerald-500 focus:ring-emerald-400 focus:outline-none focus:ring-1
                       @error('nama_penerima') border-red-500 @enderror">
                @error('nama_penerima')
                    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                @enderror
            </div>

            {{-- Alamat Pengiriman --}}
            <div class="mb-5">
                <label class="mb-1 block text-sm font-medium text-gray-700">
                    Alamat Pengiriman
                </label>
                <textarea name="alamat_pengiriman" rows="3" required
                    class="w-full rounded-lg border border-gray-300 px-3 py-2.5 text-sm
                       focus:border-emerald-500 focus:ring-emerald-400 focus:outline-none focus:ring-1
                       @error('alamat_pengiriman') border-red-500 @enderror">{{ old('alamat_pengiriman', $redeem->alamat_pengiriman) }}</textarea>
                @error('alamat_pengiriman')
                    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                @enderror
            </div>

            {{-- No HP --}}
            <div class="mb-6">
                <label class="mb-1 block text-sm font-medium text-gray-700">
                    No. HP Penerima
                </label>
                <input type="text" name="no_hp_penerima" required
                    value="{{ old('no_hp_penerima', $redeem->no_hp_penerima) }}"
                    class="w-full rounded-lg border border-gray-300 px-3 py-2.5 text-sm
                       focus:border-emerald-500 focus:ring-emerald-400 focus:outline-none focus:ring-1
                       @error('no_hp_penerima') border-red-500 @enderror">
                @error('no_hp_penerima')
                    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                @enderror
            </div>

            {{-- Tombol --}}
            <div class="flex items-center justify-end gap-3">
                <a href="{{ route('admin.redeems.index') }}"
                    class="rounded-lg border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50">
                    Batal
                </a>
                <button type="submit"
                    class="rounded-lg bg-emerald-600 px-6 py-2 text-sm font-semibold text-white hover:bg-emerald-700 transition">
                    Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
@endsection

@extends('templates.nav')

@section('navbar')
<div class="min-h-screen bg-gray-50 py-10">
    <form action="{{ route('admin.transactions.update', $transaction['id_transaksi']) }}" method="POST"
          class="mx-auto max-w-2xl rounded-xl bg-white p-6 shadow-sm sm:p-8">
        @csrf
        @method('PUT')

        {{-- Pilih User --}}
        <div class="mb-5">
            <label class="mb-1 flex items-center text-sm font-medium text-gray-700">
                Pilih User
            </label>
            <select name="id_user" required
                    class="w-full rounded-lg border border-gray-300 px-3 py-2.5 text-sm
                           focus:border-green-500 focus:ring-green-400 focus:outline-none focus:ring-1
                           @error('id_user') border-red-500 @enderror">
                <option hidden disabled selected> Pilih User </option>
                @foreach ($user as $u)
                <option value="{{ $u->id_user }}"
                    {{ old('id_user', $transaction) == $u->id_user ? 'selected' : '' }}>
                    {{ $u->nama }}
                </option>
                @endforeach
            </select>
            @error('id_user') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
        </div>

        {{-- Jenis Sampah --}}
        <div class="mb-5">
            <label class="mb-1 flex items-center text-sm font-medium text-gray-700">
                Jenis Sampah
            </label>
            <select name="id_jenis" required
                    class="w-full rounded-lg border border-gray-300 px-3 py-2.5 text-sm
                           focus:border-green-500 focus:ring-green-400 focus:outline-none focus:ring-1
                           @error('id_jenis') border-red-500 @enderror">
                <option hidden disabled selected> Pilih Jenis Sampah </option>
                @foreach ($wasteType as $jenis)
                <option value="{{ $jenis->id_jenis }}"
                    {{ old('id_jenis', $transaction) == $jenis->id_jenis ? 'selected' : '' }}>
                    {{ $jenis->nama_jenis }}
                </option>
                @endforeach
            </select>
            @error('id_jenis') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
        </div>

        {{-- Berat --}}
        <div class="mb-5">
            <label class="mb-1 flex items-center text-sm font-medium text-gray-700">
                Berat (Kg)
            </label>
            <input type="number" step="0.01" min="0.1" name="berat" required
                   placeholder="Masukkan berat sampah (Kg)"
                   class="w-full rounded-lg border border-gray-300 px-3 py-2.5 text-sm
                          focus:border-green-500 focus:ring-green-400 focus:outline-none focus:ring-1
                          @error('berat') border-red-500 @enderror"
                   value="{{ old('berat', $transaction['berat'] ?? '') }}">
            @error('berat') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
        </div>

        {{-- Lokasi (Admin only) --}}
        @if (auth()->user()->role === 'admin')
            <div class="mb-5">
                <label class="mb-1 flex items-center text-sm font-medium text-gray-700">
                    Lokasi Penukaran
                </label>
                <select name="id_lokasi" required
                        class="w-full rounded-lg border border-gray-300 px-3 py-2.5 text-sm
                               focus:border-green-500 focus:ring-green-400 focus:outline-none focus:ring-1
                               @error('id_lokasi') border-red-500 @enderror">
                    <option hidden disabled selected> Pilih Lokasi </option>
                    @foreach ($location as $loc)
                    <option value="{{ $loc->id_lokasi }}"
                        {{ old('id_lokasi', $transaction) == $loc->id_lokasi ? 'selected' : '' }}>
                        {{ $loc->nama_lok }}
                    </option>
                    @endforeach
                </select>
                @error('id_lokasi') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
            </div>
        @else
            <input type="hidden" name="id_lokasi" value="{{ auth()->user()->id_lokasi }}">
        @endif

       {{-- Submit --}}
       <div class="flex items-center justify-end gap-3">
        <a href="{{ route('admin.transactions.index') }}"
           class="rounded-lg border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50">
            Batal
        </a>
        <button type="submit"
                class="rounded-lg bg-green-600 px-6 py-2 text-sm font-semibold text-white hover:bg-green-700">
            Simpan Perubahan
        </button>
    </div>
    </form>
</div>
@endsection
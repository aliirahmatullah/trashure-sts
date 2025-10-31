@extends('templates.nav')

@section('navbar')
<div class="min-h-screen bg-gray-50 py-10">
    <form action="{{ route('admin.waste-types.store') }}" method="POST"
          class="mx-auto max-w-2xl rounded-xl bg-white p-6 shadow-sm sm:p-8">

        @csrf

        {{-- Jenis Sampah --}}
        <div class="mb-5">
            <label class="mb-1 flex items-center text-sm font-medium text-gray-700">
                Jenis Sampah
                <svg width="6" height="6" class="ml-1 text-red-500" fill="currentColor" viewBox="0 0 7 7"></svg>
            </label>
            <div class="relative">
                <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-400"></span>
                <input type="text" name="nama_jenis" placeholder="Masukkan jenis sampah"
                       class="w-full rounded-lg border border-gray-300 pl-10 pr-4 py-2.5 text-sm
                              focus:border-green-500 focus:ring-green-400 focus:outline-none focus:ring-1
                              @error('nama_jenis') border-red-500 @enderror"
                       value="{{ old('nama_jenis') }}">
            </div>
            @error('nama_jenis') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
        </div>

        {{-- Point per Kg --}}
        <div class="mb-5">
            <label class="mb-1 flex items-center text-sm font-medium text-gray-700">
                Point per Kg
                <svg width="6" height="6" class="ml-1 text-red-500" fill="currentColor" viewBox="0 0 7 7"></svg>
            </label>
            <div class="relative">
                <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-400"></span>
                <input type="number" name="poin_per_kg" placeholder="Masukkan jumlah point per kg"
                       class="w-full rounded-lg border border-gray-300 pl-10 pr-4 py-2.5 text-sm
                              focus:border-green-500 focus:ring-green-400 focus:outline-none focus:ring-1
                              @error('poin_per_kg') border-red-500 @enderror"
                       value="{{ old('poin_per_kg') }}">
            </div>
            @error('poin_per_kg') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
        </div>

        {{-- Kategori --}}
        <div class="mb-5">
            <label class="mb-1 flex items-center text-sm font-medium text-gray-700">
                Kategori
                <svg width="6" height="6" class="ml-1 text-red-500" fill="currentColor" viewBox="0 0 7 7"></svg>
            </label>
            <div class="relative">
                <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-400"></span>
                <select name="kategori"
                        class="w-full rounded-lg border border-gray-300 pl-10 pr-4 py-2.5 text-sm
                               focus:border-green-500 focus:ring-green-400 focus:outline-none focus:ring-1
                               @error('kategori') border-red-500 @enderror">
                    <option value ="" disabled selected>Pilih kategori</option>
                    <option value="Plastik" {{ old('kategori') =='plastik' ? 'selected' : '' }}>Plastik</option>
                    <option value="Kertas" {{ old('kategori') =='kertas' ? 'selected' : '' }}>Kertas</option>
                    <option value="Logam" {{ old('kategori') =='logam' ? 'selected' : '' }}>Logam</option>
                    <option value="Kaca" {{ old('kategori') =='kaca' ? 'selected' : '' }}>Kaca</option>
                </select>
            </div>
            @error('kategori') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
        </div>

        {{-- Deskripsi --}}
        <div class="mb-6">
            <label class="mb-1 flex items-center text-sm font-medium text-gray-700">
                Deskripsi
                <svg width="6" height="6" class="ml-1 text-red-500" fill="currentColor" viewBox="0 0 7 7"></svg>
            </label>
            <div class="relative">
                <span class="absolute top-3 left-0 flex items-center pl-3 text-gray-400"></span>
                <textarea name="deskripsi_jenis" rows="4" placeholder="Tulis deskripsi singkat"
                          class="w-full resize-none rounded-lg border border-gray-300 pl-10 pr-4 py-2.5 text-sm
                                 focus:border-green-500 focus:ring-green-400 focus:outline-none focus:ring-1
                                 @error('deskripsi') border-red-500 @enderror">{{ old('deskripsi_jenis') }}</textarea>
            </div>
            @error('deskripsi_jenis') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
        </div>

        <div class="flex items-center justify-end gap-3 border-t border-gray-200 bg-gray-50 px-6 py-4 sm:px-8">
            <a href="{{ route('admin.waste-types.index') }}" class="rounded-lg border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50">Batal</a>
            <button type="submit" class="rounded-lg bg-green-600 px-6 py-2 text-sm font-semibold text-white hover:bg-green-700">Tambah Jenis Sampah</button>
        </div>
    </form>
</div>
@endsection
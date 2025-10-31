@extends('templates.nav')

@section('navbar')
<div class="min-h-screen bg-gray-50 py-10">
    <form action="{{ route('admin.users.store') }}" method="POST"
          class="mx-auto max-w-2xl rounded-xl bg-white p-6 shadow-sm sm:p-8">

        @csrf

        <h2 class="mb-6 text-lg font-semibold text-gray-800">Tambah Staff</h2>

        {{-- Nama --}}
        <div class="mb-5">
            <label class="mb-1 flex items-center text-sm font-medium text-gray-700">
                Nama Lengkap
                <svg width="6" height="6" class="ml-1 text-red-500" fill="currentColor" viewBox="0 0 7 7"></svg>
            </label>
            <input type="text" name="nama" placeholder="Masukkan nama lengkap"
                   class="w-full rounded-lg border border-gray-300 px-3 py-2.5 text-sm
                          focus:border-green-500 focus:ring-green-400 focus:outline-none focus:ring-1
                          @error('nama') border-red-500 @enderror"
                   value="{{ old('nama') }}">
            @error('nama') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
        </div>

        {{-- Email --}}
        <div class="mb-5">
            <label class="mb-1 flex items-center text-sm font-medium text-gray-700">
                Email
                <svg width="6" height="6" class="ml-1 text-red-500" fill="currentColor" viewBox="0 0 7 7"></svg>
            </label>
            <input type="email" name="email" placeholder="Masukkan email"
                   class="w-full rounded-lg border border-gray-300 px-3 py-2.5 text-sm
                          focus:border-green-500 focus:ring-green-400 focus:outline-none focus:ring-1
                          @error('email') border-red-500 @enderror"
                   value="{{ old('email') }}">
            @error('email') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
        </div>

        {{-- Password --}}
        <div class="mb-5">
            <label class="mb-1 flex items-center text-sm font-medium text-gray-700">
                Password
                <svg width="6" height="6" class="ml-1 text-red-500" fill="currentColor" viewBox="0 0 7 7"></svg>
            </label>
            <input type="password" name="password" placeholder="Minimal 6 karakter"
                   class="w-full rounded-lg border border-gray-300 px-3 py-2.5 text-sm
                          focus:border-green-500 focus:ring-green-400 focus:outline-none focus:ring-1
                          @error('password') border-red-500 @enderror">
            @error('password') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
        </div>

        {{-- Lokasi (ganti alamat) --}}
        <div class="mb-5">
            <label class="mb-1 flex items-center text-sm font-medium text-gray-700">
                Lokasi
                <svg width="6" height="6" class="ml-1 text-red-500" fill="currentColor" viewBox="0 0 7 7"></svg>
            </label>
            <select name="id_lokasi"
                    class="w-full rounded-lg border border-gray-300 px-3 py-2.5 text-sm
                           focus:border-green-500 focus:ring-green-400 focus:outline-none focus:ring-1
                           @error('id_lokasi') border-red-500 @enderror">
                <option hidden disabled selected> Pilih Lokasi</option>
                @foreach($locations as $loc)
                    <option value="{{ $loc->id_lokasi }}" {{ old('id_lokasi') == $loc->id_lokasi ? 'selected' : '' }}>
                        {{ $loc->nama_lok }} - {{ $loc->kota }}
                    </option>
                @endforeach
            </select>
            @error('id_lokasi') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
        </div>

        {{-- No HP --}}
        <div class="mb-5">
            <label class="mb-1 flex items-center text-sm font-medium text-gray-700">
                Nomor HP
                <svg width="6" height="6" class="ml-1 text-red-500" fill="currentColor" viewBox="0 0 7 7"></svg>
            </label>
            <input type="text" name="no_hp" placeholder="Contoh: 081234567890"
                   class="w-full rounded-lg border border-gray-300 px-3 py-2.5 text-sm
                          focus:border-green-500 focus:ring-green-400 focus:outline-none focus:ring-1
                          @error('no_hp') border-red-500 @enderror"
                   value="{{ old('no_hp') }}">
            @error('no_hp') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
        </div>

        {{-- Tombol --}}
        <div class="flex items-center justify-end gap-3 border-t border-gray-200 bg-gray-50 px-6 py-4 sm:px-8">
            <a href="{{ route('admin.users.index') }}"
               class="rounded-lg border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50">
               Batal
            </a>
            <button type="submit"
                    class="rounded-lg bg-green-600 px-6 py-2 text-sm font-semibold text-white hover:bg-green-700">
                Simpan
            </button>
        </div>
    </form>
</div>
@endsection
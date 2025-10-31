@extends('templates.nav')

@section('navbar')
@php
    // true  -> staff (alamat cabang)
    // false -> user biasa (alamat rumah)
    $isStaff = ($user['role'] ?? '') === 'staff';
@endphp

<div class="min-h-screen bg-gray-50 py-10">
    <form action="{{ route('admin.users.update', $user['id_user']) }}"
          method="POST"
          class="mx-auto max-w-2xl rounded-xl bg-white p-6 shadow-sm sm:p-8">
        @csrf
        @method('PUT')

        {{-- Nama --}}
        <div class="mb-5">
            <label for="nama" class="mb-1 flex items-center text-sm font-medium text-gray-700">
                Nama
            </label>
            <input type="text"
                   id="nama"
                   name="nama"
                   value="{{ old('nama', $user['nama']) }}"
                   placeholder="Masukkan nama"
                   class="w-full rounded-lg border border-gray-300 px-4 py-2.5 text-sm
                          focus:border-green-500 focus:ring-green-400 focus:outline-none focus:ring-1
                          @error('nama') border-red-500 @enderror">
            @error('nama') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
        </div>

        {{-- Email --}}
        <div class="mb-5">
            <label for="email" class="mb-1 flex items-center text-sm font-medium text-gray-700">
                Email
            </label>
            <input type="email"
                   id="email"
                   name="email"
                   value="{{ old('email', $user['email']) }}"
                   placeholder="contoh@email.com"
                   class="w-full rounded-lg border border-gray-300 px-4 py-2.5 text-sm
                          focus:border-green-500 focus:ring-green-400 focus:outline-none focus:ring-1
                          @error('email') border-red-500 @enderror">
            @error('email') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
        </div>

        {{-- No. Handphone --}}
        <div class="mb-5">
            <label for="no_hp" class="mb-1 flex items-center text-sm font-medium text-gray-700">
                No. Handphone
            </label>
            <input type="tel"
                   id="no_hp"
                   name="no_hp"
                   value="{{ old('no_hp', $user['no_hp']) }}"
                   pattern="[0-9]{10,15}"
                   maxlength="15"
                   placeholder="081234567890"
                   class="w-full rounded-lg border border-gray-300 px-4 py-2.5 text-sm
                          focus:border-green-500 focus:ring-green-400 focus:outline-none focus:ring-1
                          @error('no_hp') border-red-500 @enderror">
            @error('no_hp') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
        </div>

        {{-- Alamat : rumah / cabang --}}
        <div class="mb-5">
            <label for="alamat" class="mb-1 flex items-center text-sm font-medium text-gray-700">
                @if($isStaff)
                    Alamat Cabang Kerja
                @else
                    Alamat Rumah
                @endif
            </label>
            <textarea id="alamat"
                      name="alamat"
                      rows="4"
                      placeholder="{{ $isStaff ? 'Tulis alamat cabang kerja' : 'Tulis alamat rumah lengkap' }}"
                      class="w-full resize-none rounded-lg border border-gray-300 px-4 py-2.5 text-sm
                             focus:border-green-500 focus:ring-green-400 focus:outline-none focus:ring-1
                             @error('alamat') border-red-500 @enderror">{{ old('alamat', $user['alamat']) }}</textarea>
            @error('alamat') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
        </div>

        {{-- Password (opsional) --}}
        <div class="mb-6">
            <label for="password" class="mb-1 flex items-center text-sm font-medium text-gray-700">
                Password (opsional)
            </label>
            <input type="password"
                   id="password"
                   name="password"
                   placeholder="••••••••"
                   class="w-full rounded-lg border border-gray-300 px-4 py-2.5 text-sm
                          focus:border-green-500 focus:ring-green-400 focus:outline-none focus:ring-1
                          @error('password') border-red-500 @enderror">
            <p class="text-xs text-gray-500 mt-1">Kosongkan jika tidak ingin mengubah password</p>
            @error('password') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
        </div>

       {{-- Submit --}}
       <div class="flex items-center justify-end gap-3">
        <a href="{{ route('admin.users.index') }}"
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
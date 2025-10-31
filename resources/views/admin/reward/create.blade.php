@extends('templates.nav')
@section('navbar')
<div class="min-h-screen bg-gray-50 py-10">
    <form action="{{ route('admin.rewards.store') }}" method="POST" enctype="multipart/form-data" class="mx-auto max-w-2xl rounded-2xl bg-white shadow-md">
        @csrf
        <div class="border-b border-gray-200 px-6 py-4 sm:px-8">
            <h2 class="text-lg font-semibold text-gray-800">Tambah Hadiah Baru</h2>
            <p class="mt-1 text-sm text-gray-500">Lengkapi informasi hadiah di bawah ini.</p>
        </div>
        <div class="space-y-5 p-6 sm:p-8">
            <div>
                <label for="nama_hadiah" class="mb-1 flex items-center text-sm font-medium text-gray-700">Nama Hadiah <span class="ml-1 text-red-500"></span></label>
                <input id="nama_hadiah" type="text" name="nama_hadiah" placeholder="Contoh: Keychain Trashure" value="{{ old('nama_hadiah') }}" class="w-full rounded-lg border border-gray-300 px-4 py-2.5 text-sm focus:border-green-500 focus:ring-green-500 @error('nama_hadiah') border-red-500 @enderror">
                @error('nama_hadiah') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
            </div>
            <div>
                <label for="desk_hadiah" class="mb-1 flex items-center text-sm font-medium text-gray-700">Deskripsi Hadiah <span class="ml-1 text-red-500"></span></label>
                <textarea id="desk_hadiah" name="desk_hadiah" rows="4" placeholder="Deskripsi singkat hadiah" class="w-full resize-none rounded-lg border border-gray-300 px-4 py-2.5 text-sm focus:border-green-500 focus:ring-green-500 @error('desk_hadiah') border-red-500 @enderror">{{ old('desk_hadiah') }}</textarea>
                @error('desk_hadiah') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
            </div>
            <div>
                <label for="p_dibutuhkan" class="mb-1 flex items-center text-sm font-medium text-gray-700">Poin Dibutuhkan <span class="ml-1 text-red-500"></span></label>
                <input id="p_dibutuhkan" type="number" min="0" name="p_dibutuhkan" placeholder="0" value="{{ old('p_dibutuhkan') }}" class="w-full rounded-lg border border-gray-300 px-4 py-2.5 text-sm focus:border-green-500 focus:ring-green-500 @error('p_dibutuhkan') border-red-500 @enderror">
                @error('p_dibutuhkan') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
            </div>
            <div>
                <label for="stok" class="mb-1 flex items-center text-sm font-medium text-gray-700">Stok Hadiah <span class="ml-1 text-red-500"></span></label>
                <input id="stok" type="number" min="0" name="stok" placeholder="0" value="{{ old('stok') }}" class="w-full rounded-lg border border-gray-300 px-4 py-2.5 text-sm focus:border-green-500 focus:ring-green-500 @error('stok') border-red-500 @enderror">
                @error('stok') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
            </div>
            <div>
                <label class="mb-1 flex items-center text-sm font-medium text-gray-700">Gambar Hadiah <span class="ml-1 text-red-500"></span></label>
                <div id="dropzone" class="relative flex cursor-pointer flex-col items-center justify-center rounded-lg border-2 border-dashed border-gray-300 bg-gray-50 py-6 hover:border-green-400">
                    <p class="text-sm text-gray-500">Klik atau tarik gambar ke sini</p>
                    <p class="mt-1 hidden text-xs text-gray-400" id="file-name"></p>
                    <input id="gambar_hadiah" type="file" name="gambar_hadiah" accept="image/*" class="absolute inset-0 h-full w-full opacity-0">
                </div>
                @error('gambar_hadiah') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
            </div>
        </div>
        <div class="flex items-center justify-end gap-3 border-t border-gray-200 bg-gray-50 px-6 py-4 sm:px-8">
            <a href="{{ route('admin.rewards.index') }}" class="rounded-lg border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50">Batal</a>
            <button type="submit" class="rounded-lg bg-green-600 px-6 py-2 text-sm font-semibold text-white hover:bg-green-700">Tambah Hadiah</button>
        </div>
    </form>
</div>

<script>
    const input = document.getElementById('gambar_hadiah');
    const fileName = document.getElementById('file-name');
    input.addEventListener('change', () => {
        if (input.files.length) {
            fileName.textContent = input.files[0].name;
            fileName.classList.remove('hidden');
        }
    });
</script>
@endsection
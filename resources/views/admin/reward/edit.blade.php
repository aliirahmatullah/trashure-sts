@extends('templates.nav')

@section('navbar')
<div class="min-h-screen bg-gray-50 py-10">
    <form action="{{ route('admin.rewards.update', $reward->id_hadiah) }}"
          method="POST"
          enctype="multipart/form-data"
          class="mx-auto max-w-2xl rounded-xl bg-white p-6 shadow-sm sm:p-8">
        @csrf
        @method('PUT')

        {{-- Nama Hadiah --}}
        <div class="mb-5">
            <label class="mb-1 flex items-center text-sm font-medium text-gray-700">
                Nama Hadiah
            </label>
            <div class="relative">
                <input type="text" name="nama_hadiah" placeholder="Contoh: Voucher Grab 50k"
                       class="w-full rounded-lg border border-gray-300 pl-10 pr-4 py-2.5 text-sm
                              focus:border-green-500 focus:ring-green-400 focus:outline-none focus:ring-1
                              @error('nama_hadiah') border-red-500 @enderror"
                       value="{{ old('nama_hadiah', $reward->nama_hadiah) }}">
            </div>
            @error('nama_hadiah') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
        </div>

        {{-- Deskripsi Hadiah --}}
        <div class="mb-5">
            <label class="mb-1 flex items-center text-sm font-medium text-gray-700">
                Deskripsi Hadiah
            </label>
            <div class="relative">
                <textarea name="desk_hadiah" rows="4" placeholder="Jelaskan sedikit tentang hadiah ini"
                          class="w-full resize-none rounded-lg border border-gray-300 pl-10 pr-4 py-2.5 text-sm
                                 focus:border-green-500 focus:ring-green-400 focus:outline-none focus:ring-1
                                 @error('desk_hadiah') border-red-500 @enderror">{{ old('desk_hadiah', $reward->desk_hadiah) }}</textarea>
            </div>
            @error('desk_hadiah') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
        </div>

        {{-- Poin Dibutuhkan --}}
        <div class="mb-5">
            <label class="mb-1 flex items-center text-sm font-medium text-gray-700">
                Poin Dibutuhkan
            </label>
            <div class="relative">
                <input type="number" min="0" name="p_dibutuhkan" placeholder="0"
                       class="w-full rounded-lg border border-gray-300 pl-10 pr-4 py-2.5 text-sm
                              focus:border-green-500 focus:ring-green-400 focus:outline-none focus:ring-1
                              @error('p_dibutuhkan') border-red-500 @enderror"
                       value="{{ old('p_dibutuhkan', $reward->p_dibutuhkan) }}">
            </div>
            @error('p_dibutuhkan') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
        </div>

        {{-- Stok Hadiah --}}
        <div class="mb-5">
            <label class="mb-1 flex items-center text-sm font-medium text-gray-700">
                Stok Hadiah
            </label>
            <div class="relative">
                <input type="number" min="0" name="stok" placeholder="0"
                       class="w-full rounded-lg border border-gray-300 pl-10 pr-4 py-2.5 text-sm
                              focus:border-green-500 focus:ring-green-400 focus:outline-none focus:ring-1
                              @error('stok') border-red-500 @enderror"
                       value="{{ old('stok', $reward->stok) }}">
            </div>
            @error('stok') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
        </div>

        {{-- Gambar Hadiah --}}
        <div class="mb-6">
            <label class="mb-1 flex items-center text-sm font-medium text-gray-700">
                Gambar Hadiah
            </label>
            <div id="dropzone" class="relative flex cursor-pointer flex-col items-center justify-center
                                      rounded-lg border-2 border-dashed border-gray-300 bg-gray-50 py-6
                                      hover:border-green-400">
                <p class="text-sm text-gray-500">Klik atau tarik gambar ke sini</p>
                <p class="mt-1 hidden text-xs text-gray-400" id="file-name"></p>
                <input id="gambar_hadiah" type="file" name="gambar_hadiah" accept="image/*"
                       class="absolute inset-0 h-full w-full opacity-0">
            </div>
            @error('gambar_hadiah') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror

            {{-- Preview gambar lama --}}
            @if($reward->gambar_hadiah)
                <div class="mt-3">
                    <p class="text-xs text-gray-500 mb-1">Gambar saat ini:</p>
                    <img src="{{ Storage::url($reward->gambar_hadiah) }}"
                         alt="gambar-hadiah"
                         class="h-32 rounded-lg border object-cover">
                </div>
            @endif
        </div>

        {{-- Submit --}}
        <div class="flex items-center justify-end gap-3">
            <a href="{{ route('admin.rewards.index') }}"
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

<script>
    const input  = document.getElementById('gambar_hadiah');
    const fileName = document.getElementById('file-name');
    input.addEventListener('change', () => {
        if (input.files.length) {
            fileName.textContent = input.files[0].name;
            fileName.classList.remove('hidden');
        } else {
            fileName.classList.add('hidden');
        }
    });
</script>
@endsection
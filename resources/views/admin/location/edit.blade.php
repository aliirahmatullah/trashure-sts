@extends('templates.nav')

@section('navbar')
<div class="min-h-screen bg-gray-50 py-10">
    <form action="{{ route('admin.locations.update', $location['id_lokasi']) }}" method="POST"
          class="mx-auto max-w-2xl rounded-xl bg-white p-6 shadow-sm sm:p-8">
        @csrf
        @method('PUT')

        {{-- Nama Cabang --}}
        <div class="mb-5">
            <label class="mb-1 flex items-center text-sm font-medium text-gray-700">
                Nama Cabang <span class="text-red-500"></span>
            </label>
            <input type="text" name="nama_lok" placeholder="Masukkan Nama Cabang"
                   class="w-full rounded-lg border border-gray-300 px-4 py-2.5 text-sm
                          focus:border-green-500 focus:ring-green-400 @error('nama_lok') border-red-500 @enderror"
                   value="{{ old('nama_lok', $location['nama_lok'] ?? '') }}">
            @error('nama_lok') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
        </div>

        {{-- Alamat Cabang --}}
        <div class="mb-6">
            <label class="mb-1 flex items-center text-sm font-medium text-gray-700">
                Alamat Cabang <span class="text-red-500"></span>
            </label>
            <textarea name="alamat_lok" rows="4" placeholder="Masukkan Alamat Cabang"
                      class="w-full resize-none rounded-lg border border-gray-300 px-4 py-2.5 text-sm
                             focus:border-green-500 focus:ring-green-400 @error('alamat_lok') border-red-500 @enderror">{{ old('alamat_lok', $location['alamat_lok'] ?? '') }}</textarea>
            @error('alamat_lok') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
        </div>

        {{-- Provinsi --}}
        <div class="mb-5">
            <label class="mb-1 flex items-center text-sm font-medium text-gray-700">
                Provinsi <span class="text-red-500"></span>
            </label>
            <select name="provinsi" id="provinsi" required
                    class="w-full rounded-lg border border-gray-300 px-4 py-2.5 text-sm focus:border-green-500 focus:ring-green-400">
                <option value="">Pilih Provinsi</option>
                @foreach($provinces as $id => $name)
                    <option value="{{ $id }}"
                        {{ old('provinsi', $location['provinsi']) == $name ? 'selected' : '' }}>
                        {{ $name }}
                    </option>
                @endforeach
            </select>
            @error('provinsi') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
        </div>

        {{-- Kota --}}
        <div class="mb-5">
            <label class="mb-1 flex items-center text-sm font-medium text-gray-700">
                Kota/Kabupaten <span class="text-red-500"></span>
            </label>
            <select name="kota" id="kota" required
                    class="w-full rounded-lg border border-gray-300 px-4 py-2.5 text-sm focus:border-green-500 focus:ring-green-400">
                <option value="">Pilih Kota/Kab</option>
                @foreach($cities as $id => $name)
                    <option value="{{ $id }}"
                        {{ old('kota', $location['kota']) == $name ? 'selected' : '' }}>
                        {{ $name }}
                    </option>
                @endforeach
            </select>
            @error('kota') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
        </div>

        {{-- Kontak Cabang --}}
        <div class="mb-5">
            <label class="mb-1 flex items-center text-sm font-medium text-gray-700">
                Kontak Cabang <span class="text-red-500"></span>
            </label>
            <input type="tel" pattern="[0-9]{10,15}" name="kontak_lok" placeholder="Masukkan Nomor HP"
                   class="w-full rounded-lg border border-gray-300 px-4 py-2.5 text-sm
                          focus:border-green-500 focus:ring-green-400 @error('kontak_lok') border-red-500 @enderror"
                   value="{{ old('kontak_lok', $location['kontak_lok'] ?? '') }}">
            @error('kontak_lok') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
        </div>

        {{-- Submit --}}
        <div class="flex items-center justify-end gap-3">
            <a href="{{ route('admin.locations.index') }}"
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
const prov = document.getElementById('provinsi');
const city = document.getElementById('kota');

// Load kota berdasarkan provinsi saat ganti dropdown
prov.addEventListener('change', async () => {
    const id = prov.value;
    if (!id) {
        city.innerHTML = '<option value="">- Pilih Kota/Kab -</option>';
        city.disabled = true;
        return;
    }

    try {
        const res = await fetch(`/admin/locations/api/cities/${id}`);
        if (!res.ok) throw new Error(`HTTP ${res.status}`);
        const data = await res.json();

        city.innerHTML = '<option value="">Pilih Kota/Kab</option>';
        data.forEach(c => {
            const selected = c.name === @json(old('kota', $location['kota'])) ? 'selected' : '';
            city.insertAdjacentHTML('beforeend', `<option value="${c.id}" ${selected}>${c.name}</option>`);
        });
        city.disabled = false;
    } catch (err) {
        console.error("Gagal fetch kota:", err);
    }
});
</script>
@endsection

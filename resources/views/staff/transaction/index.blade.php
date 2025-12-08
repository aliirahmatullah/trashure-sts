@extends('templates.nav')

@section('navbar')
<div class="container mx-auto mt-4">
    @if (session('success'))
        <div class="mb-4 rounded-lg bg-green-100 px-4 py-3 text-sm font-medium text-green-700">
            {{ session('success') }}
        </div>
    @elseif (session('error'))
        <div class="mb-4 rounded-lg bg-red-100 px-4 py-3 text-sm font-medium text-red-700">
            {{ session('error') }}
        </div>
    @endif

    <div class="mb-4 flex items-center justify-end">
        {{-- Staff tidak bisa tambah data dari index --}}
        <a href="{{ route('staff.transactions.trash')}}" class="rounded-md bg-yellow-600 px-4 py-2 mr-2 text-sm font-medium text-white transition hover:bg-yellow-700">Data Sampah</a>
        <a href="{{ route('staff.transactions.export')}}" class="rounded-md bg-blue-600 px-4 py-2 mr-2 text-sm font-medium text-white transition hover:bg-blue-700mom">Export Data (.xlsx)</a>
        <a href="{{ route('staff.transactions.export-pdf')}}" class="rounded-md bg-red-600 px-4 py-2 mr-2 text-sm font-medium text-white transition hover:bg-blue-700mom">Export Data (.pdf)</a>
        <a href="{{ route('staff.transactions.create') }}" class="rounded-md bg-green-600 px-4 py-2 text-sm font-medium text-white hover:bg-green-700">
            Tambah Data
        </a>
    </div>
    <h1 class="text-xl font-semibold text-gray-800 mb-2">Data Transaksi</h1>


    <div class="overflow-hidden rounded-lg border border-gray-200 shadow-sm">
        <table class="min-w-full divide-y divide-gray-200 text-sm text-gray-700">
            <thead class="bg-gray-100 text-xs font-semibold uppercase text-gray-600">
                <tr>
                    <th class="px-6 py-3 text-center">#</th>
                    <th class="px-6 py-3 text-center">Nama</th>
                    <th class="px-6 py-3 text-center">No.Transaksi</th>
                    <th class="px-6 py-3 text-center">Status</th>
                    <th class="px-6 py-3 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200 bg-white">
                @foreach ($transaction as $index => $key)
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-3 text-center">{{ $index + 1 }}</td>
                        <td class="px-6 py-3 text-center">{{ $key->user->nama }}</td>
                        <td class="px-6 py-3 text-center">{{ $key->no_transaksi }}</td>

                        {{-- Status dengan warna --}}
                        <td class="px-6 py-3 text-center">
                            <span class="rounded-full px-3 py-1 text-xs font-semibold
                                @if($key->status === 'pending')   bg-yellow-200 text-yellow-700
                                @elseif($key->status === 'approved') bg-blue-100 text-blue-700
                                @elseif($key->status === 'completed') bg-green-100 text-green-700
                                @elseif($key->status === 'canceled') bg-red-100 text-red-700
                                @endif">
                                {{ ucfirst($key->status) }}
                            </span>
                        </td>

                        {{-- Aksi: dropdown ganti status + edit + hapus --}}
                        <td class="px-6 py-3 text-center">
                            <div class="flex items-center justify-center gap-2">

                                {{-- Dropdown ganti status --}}
                                <form action="{{ route('staff.transactions.updateStatus', $key->id_transaksi) }}" method="POST" class="inline">
                                    @csrf @method('PATCH')
                                    <select name="status" onchange="this.form.submit()"
                                            class="rounded-md border border-gray-300 px-6 py-1 text-xs
                                                @if($key->status === 'pending')   border-yellow-500 text-yellow-700
                                                @elseif($key->status === 'approved') border-blue-400 text-blue-700
                                                @elseif($key->status === 'completed') border-green-400 text-green-700
                                                @elseif($key->status === 'canceled') border-red-400 text-red-700
                                                @endif">
                                        <option value="pending"   {{ $key->status === 'pending'   ? 'selected' : '' }}>Pending</option>
                                        <option value="approved"  {{ $key->status === 'approved'  ? 'selected' : '' }}>Approved</option>
                                        <option value="completed" {{ $key->status === 'completed' ? 'selected' : '' }}>Completed</option>
                                        <option value="canceled"  {{ $key->status === 'canceled'  ? 'selected' : '' }}>Canceled</option>
                                    </select>
                                </form>

                                <button
                                    onclick="openModal({
                                        no_transaksi: '{{ $key->no_transaksi }}',
                                        nama: '{{ $key->user->nama }}',
                                        jenis_sampah: '{{ $key->wasteType->nama_jenis }}',
                                        berat: '{{ $key->berat }} kg',
                                        poin_didapat: '{{ $key->poin_didapat }}',
                                        lokasi: '{{ $key->location->nama_lok ?? '-' }}',
                                        tanggal: '{{ \Carbon\Carbon::parse($key->tanggal)->format('d-m-Y') }}',
                                        status: '{{ ucfirst( $key->status) }}'
                                    })"
                                    class="rounded-md bg-slate-600 px-3 py-1 text-xs font-medium text-white hover:bg-slate-700">
                                    Detail
                                </button>

                                {{-- Tombol Edit --}}
                                <a href="{{ route('staff.transactions.edit', $key->id_transaksi) }}" class="rounded-md bg-blue-600 px-3 py-1 text-xs font-medium text-white hover:bg-blue-700">Edit</a>

                                {{-- Tombol Hapus --}}
                                <form action="{{ route('staff.transactions.delete', $key->id_transaksi) }}" method="POST" class="inline">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="rounded-md bg-red-600 px-3 py-1 text-xs font-medium text-white hover:bg-red-700">Hapus</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

{{-- Modal Detail --}}
<div id="detailModal" class="fixed inset-0 z-50 hidden items-center justify-center bg-black bg-opacity-40">
    <div class="w-11/12 max-w-lg rounded-xl bg-white p-6 shadow-lg sm:p-8">
        <div class="mb-4 flex items-center justify-between">
            <h2 class="text-lg font-semibold text-gray-800">Detail Transaksi</h2>
            <button onclick="closeModal()" class="text-gray-400 hover:text-gray-600">
                <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>

        <div class="space-y-3 text-sm text-gray-700">
            <p><span class="font-medium text-black">No.Transaksi:</span> <span id="detTransaksi" class="text-black"></span></p>
            <p><span class="font-medium text-black">Nama:</span> <span id="detNama" class="text-black"></span></p>
            <p><span class="font-medium text-black">Jenis Sampah:</span> <span id="detSampah" class="text-black"></span></p>
            <p><span class="font-medium text-black">Berat:</span> <span id="detBerat" class="text-black"></span></p>
            <p><span class="font-medium text-black">Poin Didapat:</span> <span id="detPoin" class="text-black"></span></p>
            <p><span class="font-medium text-black">Lokasi:</span> <span id="detLokasi" class="text-black"></span></p>
            <p><span class="font-medium text-black">Tanggal:</span> <span id="detTanggal" class="text-black"></span></p>
            <p><span class="font-medium text-black">Status:</span> <span id="detStatus" class="text-black"></span></p>
        </div>

        <div class="mt-6 text-right">
            <button onclick="closeModal()"
                    class="rounded-md bg-gray-200 px-4 py-2 text-sm font-medium text-white-700 transition hover:bg-red-500 transition hover:text-white">
                Tutup
            </button>
        </div>
    </div>
</div>

<script>
    function openModal(data) {
        document.getElementById('detTransaksi').textContent = data.no_transaksi ?? '-';
        document.getElementById('detNama').textContent = data.nama ?? '-';
        document.getElementById('detSampah').textContent = data.jenis_sampah ?? '-';
        document.getElementById('detBerat').textContent = data.berat ?? '-';
        document.getElementById('detPoin').textContent = data.poin_didapat ?? '-';
        document.getElementById('detLokasi').textContent = data.lokasi ?? '-';
        document.getElementById('detTanggal').textContent = data.tanggal ?? '-';
        document.getElementById('detStatus').textContent = data.status ?? '-';
        document.getElementById('detailModal').classList.remove('hidden');
        document.getElementById('detailModal').classList.add('flex');
    }
    function closeModal() {
        document.getElementById('detailModal').classList.add('hidden');
        document.getElementById('detailModal').classList.remove('flex');
    }
</script>
@endsection


{{-- dalam database transaksi munculkan juga nama penggunanya bukan hanya id nya}}
{{-- dalam penambahan jenis sampah, tambahkan poin per kg untuk perhitungan di transaksi (tambahkan poin_per_kg di tabel sampah) --}}
{{-- membuat sistem perhitungan poin untuk berbeda jenis sampah--}}



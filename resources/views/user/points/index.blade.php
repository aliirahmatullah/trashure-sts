@extends('templates.nav')

@section('navbar')
    <div class="max-w-5xl mx-auto px-6 py-10">

        {{-- alert --}}
        @if (session('error'))
            <div class="mb-4 p-3 rounded bg-red-100 text-red-700">{{ session('error') }}</div>
        @endif
        @if (session('success'))
            <div class="mb-4 p-3 rounded bg-green-100 text-green-700">{{ session('success') }}</div>
        @endif

        {{-- baris atas : tukar + jumlah poin --}}
        <div class="flex items-center justify-between mb-6">
            <a href="{{ route('home.reward.active') }}"
                class="px-4 py-2 rounded-t-lg bg-emerald-600 text-white font-medium hover:bg-emerald-700 transition">
                Tukar Hadiah
            </a>
            <div class="text-right">
                <p class="text-sm text-gray-500">Jumlah Poin</p>
                <p class="text-3xl font-bold text-emerald-600">{{ number_format($totalSisa, 0, ',', '.') }}</p>
            </div>
        </div>

        {{-- ringkasan simpel (opsional) --}}
        <div class="grid grid-cols-3 gap-4 mb-6 text-center text-sm">
            <div class="bg-white p-3 rounded shadow">
                <p class="text-gray-500">Terkumpul</p>
                <p class="font-bold text-emerald-600">{{ number_format($totalEarned ?? 0, 0, ',', '.') }}</p>
            </div>
            <div class="bg-white p-3 rounded shadow">
                <p class="text-gray-500">Terpakai</p>
                <p class="font-bold text-red-600">{{ number_format($totalSpent ?? 0, 0, ',', '.') }}</p>
            </div>
            <div class="bg-white p-3 rounded shadow">
                <p class="text-gray-500">Sisa</p>
                <p class="font-bold text-yellow-600">{{ number_format($totalSisa ?? 0, 0, ',', '.') }}</p>
            </div>
        </div>

        {{-- riwayat transaksi --}}
        <div class="bg-white rounded-xl shadow p-4">
            <h3 class="text-base font-semibold text-gray-700 mb-3">Riwayat Transaksi Sampah</h3>
            <div class="overflow-x-auto">
                <table class="w-full text-sm text-center text-gray-700">
                    <thead class="text-xs text-black uppercase bg-gray-200">
                        <tr>
                            <th class="px-3 py-2">No.Transaksi</th>
                            <th class="px-3 py-2">Tanggal</th>
                            <th class="px-3 py-2">Lokasi</th>
                            <th class="px-3 py-2">Jenis</th>
                            <th class="px-3 py-2">Berat</th>
                            <th class="px-3 py-2">Poin</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($transactions as $t)
                            <tr class="border-b hover:bg-gray-50">
                                <td class="px-3 py-2">{{ $t->no_transaksi }}</td>
                                <td class="px-3 py-2">
                                    {{ optional($t->tanggal)->timezone('Asia/Jakarta')->format('d/m/Y') ?? '-' }}</td>
                                <td class="px-3 py-2">{{ $t->location->nama_lok }}</td>
                                <td class="px-3 py-2">{{ $t->wasteType->nama_jenis }}</td>
                                <td class="px-3 py-2">{{ $t->berat }} kg</td>
                                <td class="px-3 py-2 font-semibold text-emerald-600">+{{ $t->poin_didapat }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-3 py-4 text-center text-gray-500">Belum ada transaksi.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
                {{ $transactions->links() }}
            </div>
        </div>
        {{-- riwayat redeem hadiah --}}
        <div class="bg-white rounded-xl shadow p-4 mt-8">
            <h3 class="text-base font-semibold text-gray-700 mb-3">Riwayat Penukaran Hadiah</h3>

            <div class="overflow-x-auto">
                <table class="w-full text-sm text-center text-gray-700">
                    <thead class="text-xs text-black uppercase bg-gray-200">
                        <tr>
                            <th class="px-3 py-2">Nama Hadiah</th>
                            <th class="px-3 py-2">Tanggal Tukar</th>
                            <th class="px-3 py-2">Status</th>
                            <th class="px-3 py-2">Poin Terpakai</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse ($redeemHistory as $redeem)
                            <tr class="border-b hover:bg-gray-50">
                                {{-- nama hadiah --}}
                                <td class="px-3 py-2 font-medium">
                                    {{ $redeem->reward->nama_hadiah ?? '-' }}
                                </td>

                                {{-- tanggal --}}
                                <td class="px-3 py-2">
                                    {{ optional($redeem->tanggal_tukar)->format('d/m/Y') }}
                                </td>

                                {{-- status badge --}}
                                <td class="px-3 py-2">
                                    <span
                                        class="px-3 py-1 rounded-full text-xs font-semibold
                                @if ($redeem->status_tukar == 'pending') bg-yellow-200 text-yellow-700
                                @elseif($redeem->status_tukar == 'approved') bg-blue-200 text-blue-700
                                @elseif($redeem->status_tukar == 'done') bg-green-200 text-green-700
                                @elseif($redeem->status_tukar == 'canceled') bg-red-200 text-red-700
                                @else bg-gray-200 text-gray-700 @endif">
                                        {{ ucfirst($redeem->status_tukar) }}
                                    </span>
                                </td>

                                {{-- poin terpakai --}}
                                <td class="px-3 py-2 font-bold text-red-600">
                                    -{{ number_format($redeem->reward->p_dibutuhkan ?? 0, 0, ',', '.') }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-3 py-4 text-gray-500">
                                    Belum ada transaksi penukaran hadiah.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>

                {{-- pagination --}}
                {{ $redeemHistory->links() }}
            </div>
        </div>

    </div>
@endsection

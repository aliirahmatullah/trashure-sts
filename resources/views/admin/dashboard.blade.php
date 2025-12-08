@extends('templates.nav')

@section('navbar')
    <div class="container mx-auto mt-6 px-4">
        @if (Session::get('success'))
            <div class="w-full bg-green-100 text-green-700 px-4 py-3 rounded relative font-sans">
                {{ Session::get('success') }} <b>Selamat Datang, {{ Auth::user()->nama }}</b></div>
        @endif

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-6">
            {{-- Chart Redeem Reward --}}
            <div class="rounded-xl bg-white shadow">
                <div class="border-b px-4 py-3 text-center font-semibold">
                    Data Redeem Reward (Bulan Ini)
                </div>
                <div class="flex items-center justify-center h-[220px] px-4">
                    <canvas id="chartRedeem" class="w-full"></canvas>
                </div>
            </div>

            {{-- Chart Transaksi --}}
            <div class="rounded-xl bg-white shadow">
                <div class="border-b px-4 py-3 text-center font-semibold">
                    Data Transaksi Sampah (Bulan Ini)
                </div>
                <div class="flex items-center justify-center h-[220px] px-4">
                    <canvas id="chartTransaction" class="w-full"></canvas>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('script')
    <script>
        $(function() {
            $.ajax({
                url: "{{ route('admin.redeems.chart') }}",
                type: "GET",
                success: function(response) {

                    const ctx = document.getElementById('chartRedeem');

                    new Chart(ctx, {
                        type: 'bar',
                        data: {
                            labels: response.labels,
                            datasets: [{
                                label: 'Jumlah Redeem Reward',
                                data: response.data,
                                backgroundColor: '#0d6efd',
                                borderWidth: 1
                            }]
                        },
                        options: {
                            responsive: true,
                            maintainAspectRatio: false,
                            scales: {
                                y: {
                                    beginAtZero: true,
                                    ticks: {
                                        precision: 0
                                    }
                                }
                            }
                        }
                    });
                },
                error: function() {
                    alert('Gagal mengambil data chart!');
                }
            });

            $.ajax({
                url: "{{ route('admin.transactions.chart') }}",
                type: "GET",
                success: function(response) {

                    const ctx = document.getElementById('chartTransaction');

                    new Chart(ctx, {
                        type: 'bar',
                        data: {
                            labels: response.labels,
                            datasets: [{
                                label: 'Jumlah Transaksi Sampah',
                                data: response.data,
                                backgroundColor: '#0d6efd',
                                borderWidth: 1
                            }]
                        },
                        options: {
                            responsive: true,
                            maintainAspectRatio: false,
                            scales: {
                                y: {
                                    beginAtZero: true,
                                    ticks: {
                                        precision: 0
                                    }
                                }
                            }
                        }
                    });
                },
                error: function() {
                    alert('Gagal mengambil data chart!');
                }
            });
        });
    </script>
@endpush

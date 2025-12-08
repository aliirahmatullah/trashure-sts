@extends('templates.nav')
@section('navbar')
    <div class="container">
        @if (Session::get('success'))
            <div class="w-full bg-green-100 text-green-700 px-4 py-3 rounded relative font-sans">
                {{ Session::get('success') }} <b>Selamat Datang, {{ Auth::user()->nama }}</b></div>
        @endif
        <div class="mt-6 flex justify-center y">
            <div class="w-full max-w-xl rounded-xl bg-white shadow">
                <div class="border-b px-4 py-3 text-center font-semibold">
                    Data Transaksi Sampah (Bulan Ini)
                </div>
                <div class="flex items-center justify-center h-[260px] px-4">
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
                url: "{{ route('staff.transactions.chart') }}",
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

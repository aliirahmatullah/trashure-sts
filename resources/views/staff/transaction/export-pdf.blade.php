<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Data PDF Transaksi Staff</title>
</head>
<style>
    body {
        font-family: Quicksand, sans-serif;
        font-size: 12px;
        color: #000;
    }

    h2 {
        text-align: center;
        margin-bottom: 20px;
    }

    table {
        width: 100%;
        border-collapse: collapse;
    }

    thead {
        background-color: #e5e7eb;
    }

    th,
    td {
        border: 1px solid #000;
        padding: 6px 8px;
        text-align: center;
    }

    th {
        font-weight: bold;
    }

    .footer {
        margin-top: 20px;
        font-size: 10px;
        text-align: right;
    }
</style>

<body>
    <h2>DATA TRANSAKSI STAFF</h2>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nama</th>
                <th>No. Transaksi</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($transactions as $index => $transaction)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $transaction->user->nama ?? '-' }}</td>
                    <td>{{ $transaction->no_transaksi ?? '-' }}</td>
                    <td>{{ ucfirst($transaction->status) }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="4">Tidak ada data</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="footer">
        Dicetak pada: {{ \Carbon\Carbon::now()->format('d-m-Y H:i') }}
    </div>
</body>

</html>

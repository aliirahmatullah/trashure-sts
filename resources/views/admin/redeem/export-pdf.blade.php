<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Data PDF Redeem</title>
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
</head>

<body>

    <h2>DATA REDEEM REWARD</h2>

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
            @forelse ($redeem_reward as $index => $redeem)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $redeem->user->nama ?? '-' }}</td>
                    <td>{{ $redeem->no_transaksi ?? '-' }}</td>
                    <td>{{ ucfirst($redeem->status_tukar) }}</td>
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

<?php

namespace App\Exports;

use App\Models\Transaction;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;


class TransactionAdminExport implements FromCollection, WithHeadings, WithMapping
{
    private $key = 0;
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Transaction::all();
    }

    public function headings(): array
    {
        return [
            'No', 'Nama', 'No.Transaksi', 'Status'
        ];
    }

    public function map($transaction): array
    {
        $this->key++;
        return [
            $this->key,
            $transaction->user->nama,
            $transaction->no_transaksi,
            ucFirst($transaction->status),
        ];
    }
}

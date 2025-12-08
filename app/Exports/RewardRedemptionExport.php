<?php

namespace App\Exports;

use App\Models\RewardRedemption;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class RewardRedemptionExport implements FromCollection, WithHeadings, WithMapping
{
    private $key = 0;
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return RewardRedemption::all();
    }

    public function headings(): array
    {
        return [
            'No', 'Nama', 'No.Transaksi', 'Status'
        ];
    }

    public function map($redeem): array
    {
        $this->key++;
        return [
            $this->key,
            $redeem->user->nama,
            $redeem->no_transaksi,
            ucFirst($redeem->status_tukar),
        ];
    }
}

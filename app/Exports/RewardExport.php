<?php

namespace App\Exports;

use App\Models\Reward;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class RewardExport implements FromCollection, WithHeadings, WithMapping
{
    private $key = 0;
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Reward::all();
    }

    public function headings(): array
    {
        return [
            'No', 'Nama Hadiah', 'Deskripsi', 'Poin Dibutuhkan', 'Stok Hadiah', 'Gambar Hadiah'
        ];
    }

    public function map($reward): array
    {
        $this->key++;
        return [
            $this->key,
            $reward->nama_hadiah,
            $reward->desk_hadiah,
            $reward->p_dibutuhkan,
            $reward->stok,
            asset('storage/' . $reward->gambar_hadiah),
        ];
    }
}

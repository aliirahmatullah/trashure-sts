<?php

namespace App\Exports;

use App\Models\WasteType;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class WasteTypeExport implements FromCollection, WithHeadings, WithMapping
{
    private $key = 0;
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return WasteType::all();
    }

    public function headings(): array
    {
        return [
            'No',
            'Nama Jenis',
            'Kategori',
            'Deskripsi Jenis',
        ];
    }

    public function map($wasteType): array
    {
        $this->key++;
        return [
            $this->key,
            $wasteType->nama_jenis,
            $wasteType->kategori,
            $wasteType->deskripsi_jenis,
        ];
    }

    
}

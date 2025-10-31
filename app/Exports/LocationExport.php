<?php

namespace App\Exports;

use App\Models\Location;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;


class LocationExport implements FromCollection, WithHeadings, WithMapping
{
    private $key = 0;
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Location::all();
    }

    public function headings(): array
    {
        return [
            'No', 'Nama Cabang', 'Alamat Cabang', 'Kota', 'Provinsi', 'Kontak Cabang'
        ];
    }

    public function map($location): array
    {
        $this->key++;
        return [
            $this->key,
            $location->nama_lok,
            $location->alamat_lok,
            $location->kota,
            $location->provinsi,
            $location->kontak_lok,
        ];
    }
}

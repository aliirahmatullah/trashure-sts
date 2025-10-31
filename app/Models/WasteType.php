<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class WasteType extends Model
{
    use HasFactory, SoftDeletes;

    // Sesuaikan dengan nama tabel di database
    protected $table = 'waste_types';

    // Primary key
    protected $primaryKey = 'id_jenis';

    // Mass assignable
    protected $fillable = [
        'nama_jenis',
        'deskripsi_jenis',
        'kategori',
        'poin_per_kg',
    ];

    // Relasi ke transaksi
    public function transactions()
    {
        return $this->hasMany(Transaction::class, 'id_jenis');
    }

    public function wasteType()
    {
        return $this->belongsTo(WasteType::class, 'id_jenis');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'transactions';
    protected $primaryKey = 'id_transaksi';
    protected $casts = [
        'tanggal' => 'datetime:Y-m-d',
    ];

    protected $fillable = [
        'no_transaksi',
        'id_user',
        'id_jenis',
        'id_lokasi',
        'berat',
        'poin_didapat',
        'tanggal',
        'status',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }

    public function wasteType()
    {
        return $this->belongsTo(WasteType::class, 'id_jenis');
    }

    public function location()
    {
        return $this->belongsTo(Location::class, 'id_lokasi');
    }
}

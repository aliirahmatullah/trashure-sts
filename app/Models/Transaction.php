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

    protected static function boot()
   {
    parent::boot();

    static::creating(function ($model) {
        // Format: TRX-YYYYMMDD-0001
        $today = now()->format('Ymd');

        // Ambil transaksi terakhir di hari ini
        $lastTransaction = self::whereDate('created_at', now()->toDateString())
            ->orderBy('id_transaksi', 'desc')
            ->first();

        // Ambil nomor urut berikutnya
        $nextNumber = $lastTransaction
            ? ((int)substr($lastTransaction->no_transaksi, -4)) + 1 : 1;

        // Bentuk kode transaksi
        $model->no_transaksi = 'TRSH-' . $today . '-' . str_pad($nextNumber, 4, '0', STR_PAD_LEFT);
    });
    }


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

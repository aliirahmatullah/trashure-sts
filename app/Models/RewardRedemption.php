<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class RewardRedemption extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'reward_redemptions';
    protected $primaryKey = 'id_tukar';
    protected $casts = [
        'tanggal_tukar' => 'date',
    ];

    protected $fillable = [
        'id_user',
        'id_hadiah',
        'no_transaksi',
        'jumlah_hadiah',
        'tanggal_tukar',
        'status_tukar',
        'nama_penerima',
        'alamat_pengiriman',
        'no_hp_penerima',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }

    public function reward()
    {
        return $this->belongsTo(Reward::class, 'id_hadiah');
    }
}

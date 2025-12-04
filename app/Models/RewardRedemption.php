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
        'jumlah_hadiah',
        'tanggal_tukar',
        'status_tukar',
    ];

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            $today = now()->format('Y-m-d');
            $lastRedeem = self::whereDate('tanggal_tukar', now()->toDateString())
                ->orderBy('id_tukar', 'desc')
                ->first();

            $nextNumber = $lastRedeem ? ((int)substr($lastRedeem->no_transaksi, -4)) + 1 : 1;
            $model->no_transaksi = 'THRR-' . $today . '-' . str_pad($nextNumber, 4, '0', STR_PAD_LEFT);
        });
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }

    public function reward()
    {
        return $this->belongsTo(Reward::class, 'id_hadiah');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class Reward extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'rewards';
    protected $primaryKey = 'id_hadiah';

    protected $fillable = [
        'nama_hadiah',
        'desk_hadiah',
        'p_dibutuhkan',
        'stok',
        'gambar_hadiah'
    ];

    public function redemptions()
    {
        return $this->hasMany(RewardRedemption::class, 'id_hadiah');
    }
}

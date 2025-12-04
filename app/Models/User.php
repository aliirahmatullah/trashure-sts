<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;


class User extends Authenticatable
{
    use HasFactory, SoftDeletes;

    protected $table = 'users';
    protected $primaryKey = 'id_user';
    protected $casts = [
        'poin' => 'integer',
        'total_poin' => 'integer',
    ];

    protected $fillable = [
        'nama',
        'email',
        'password',
        'alamat',
        'no_hp',
        'poin',
        'total_poin',
        'role',
        'tanggal_daftar',
        'id_lokasi', // relasi ke location
    ];

    protected $hidden = ['password', 'remember_token'];

    public function location()
    {
        return $this->belongsTo(Location::class, 'id_lokasi', 'id_lokasi');
    }

    // Relasi
    public function transactions()
    {
        return $this->hasMany(Transaction::class, 'id_user');
    }

    public function rewardRedemptions()
    {
        return $this->hasMany(RewardRedemption::class, 'id_user');
    }

}

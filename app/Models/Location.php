<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;
use Laravolt\Indonesia\Models\Provinsi;
use Laravolt\Indonesia\Models\City;

class Location extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'locations';
    protected $primaryKey = 'id_lokasi';

    protected $fillable = [
        'nama_lok',
        'alamat_lok',
        'kota',
        'provinsi',
        'kontak_lok',
    ];

    public function users()
    {
        return $this->hasMany(User::class, 'id_lokasi', 'id_lokasi');
    }

    public function transactions()
    {
        return $this->hasMany(Transaction::class, 'id_lokasi');
    }

    public function province()
    {
        return $this->belongsTo(Provinsi::class, 'provinsi', 'id');
    }

    /* relasi nama kota */
    public function city()
    {
        return $this->belongsTo(City::class, 'kota', 'id');
    }

}

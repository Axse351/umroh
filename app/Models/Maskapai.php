<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Maskapai extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'kode_maskapai',
        'nama_maskapai',
        'kode_iata',
        'no_telepon',
        'email',
        'website',
        'status'
    ];

    public function pakets()
    {
        return $this->hasMany(Paket::class);
    }
}

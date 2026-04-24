<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Agent extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'kode_agent',
        'nama_agent',
        'nama_pic',
        'jenis',
        'no_telepon',
        'email',
        'alamat',
        'kota',
        'provinsi',
        'komisi_persen',
        'status'
    ];

    public function pendaftarans()
    {
        return $this->hasMany(Pendaftaran::class);
    }
}

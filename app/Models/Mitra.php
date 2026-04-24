<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Mitra extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'kode_mitra',
        'nama_mitra',
        'jenis',
        'nama_pic',
        'no_telepon',
        'email',
        'alamat',
        'keterangan',
        'status'
    ];
}

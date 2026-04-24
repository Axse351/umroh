<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Tabungan extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'no_rekening_tabungan',
        'jamaah_id',
        'jenis',
        'target_tabungan',
        'saldo',
        'tanggal_buka',
        'tanggal_target',
        'status',
        'catatan'
    ];

    protected $casts = [
        'tanggal_buka'   => 'date',
        'tanggal_target' => 'date',
    ];

    public function jamaah()
    {
        return $this->belongsTo(Jamaah::class);
    }

    public function setorans()
    {
        return $this->hasMany(Setoran::class);
    }

    public function getSisaTargetAttribute()
    {
        return $this->target_tabungan - $this->saldo;
    }

    public function getPersentaseAttribute()
    {
        if ($this->target_tabungan == 0) return 0;
        return round(($this->saldo / $this->target_tabungan) * 100, 2);
    }
}

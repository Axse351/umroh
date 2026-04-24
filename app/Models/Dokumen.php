<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Dokumen extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'pendaftaran_id',
        'jamaah_id',
        'jenis_dokumen',
        'file_path',
        'nama_file',
        'tanggal_upload',
        'tanggal_expired',
        'status',
        'catatan'
    ];

    protected $casts = [
        'tanggal_upload'  => 'date',
        'tanggal_expired' => 'date',
    ];

    public function pendaftaran()
    {
        return $this->belongsTo(Pendaftaran::class);
    }

    public function jamaah()
    {
        return $this->belongsTo(Jamaah::class);
    }

    public function getIsExpiredAttribute()
    {
        if (!$this->tanggal_expired) return false;
        return $this->tanggal_expired->isPast();
    }

    public function getIsExpiringSoonAttribute()
    {
        if (!$this->tanggal_expired) return false;
        return $this->tanggal_expired->diffInDays(now()) <= 30
            && !$this->is_expired;
    }

    public function getUrlAttribute()
    {
        return asset('storage/' . $this->file_path);
    }
}

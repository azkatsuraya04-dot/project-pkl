<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Pengajuan extends Model
{
    protected $table = 'pengajuan';

    protected $primaryKey = 'id_pengajuan';

    public $timestamps = false;

    protected $fillable = [
        'id_siswa',
        'id_perusahaan',
        'tanggal_pengajuan',
        'status_kaprog',
        'status_hubin',
        'status_perusahaan',
    ];

    protected $casts = [
        'tanggal_pengajuan' => 'date',
    ];

    public function siswa(): BelongsTo
    {
        return $this->belongsTo(
            Siswa::class,
            'id_siswa',
            'id_siswa'
        );
    }

    public function perusahaan(): BelongsTo
    {
        return $this->belongsTo(
            Perusahaan::class,
            'id_perusahaan',
            'id_perusahaan'
        );
    }

    public function pkl(): HasOne
    {
        return $this->hasOne(
            Pkl::class,
            'id_pengajuan',
            'id_pengajuan'
        );
    }
}
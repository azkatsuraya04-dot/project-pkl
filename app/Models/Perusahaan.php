<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Perusahaan extends Model
{
    protected $table = 'perusahaan';

    protected $primaryKey = 'id_perusahaan';

    public $timestamps = false;

    protected $fillable = [
        'nama_perusahaan',
        'alamat',
        'no_telp',
        'email',
    ];

    public function pengajuan(): HasMany
    {
        return $this->hasMany(
            Pengajuan::class,
            'id_perusahaan',
            'id_perusahaan'
        );
    }
}
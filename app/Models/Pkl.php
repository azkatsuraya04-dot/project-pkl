<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Pkl extends Model
{
    protected $table = 'pkl';

    protected $primaryKey = 'id_pkl';

    public $timestamps = false;

    protected $fillable = [
        'id_pengajuan',
        'id_pembimbing',
        'tanggal_mulai',
        'tanggal_selesai',
        'status',
    ];

    protected $casts = [
        'tanggal_mulai' => 'date',
        'tanggal_selesai' => 'date',
    ];

    public function pengajuan(): BelongsTo
    {
        return $this->belongsTo(
            Pengajuan::class,
            'id_pengajuan',
            'id_pengajuan'
        );
    }

    public function pembimbing(): BelongsTo
    {
        return $this->belongsTo(
            Pembimbing::class,
            'id_pembimbing',
            'id_pembimbing'
        );
    }

    public function nilai(): HasOne
    {
        return $this->hasOne(
            Nilai::class,
            'id_pkl',
            'id_pkl'
        );
    }
}
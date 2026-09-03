<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Nilai extends Model
{
    protected $table = 'nilai';

    protected $primaryKey = 'id_nilai';

    public $timestamps = false;

    protected $fillable = [
        'id_pkl',
        'nilai',
        'catatan',
        'tanggal_input',
    ];

    protected $casts = [
        'nilai' => 'decimal:2',
        'tanggal_input' => 'date',
    ];

    public function pkl(): BelongsTo
    {
        return $this->belongsTo(
            Pkl::class,
            'id_pkl',
            'id_pkl'
        );
    }
}
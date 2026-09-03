<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Pembimbing extends Model
{
    protected $table = 'pembimbing';

    protected $primaryKey = 'id_pembimbing';

    public $incrementing = true;

    protected $keyType = 'int';

    public $timestamps = false;

    protected $fillable = [
        'id_user',
        'nama_pembimbing',
        'nip',
        'no_hp',
        'email',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'id_user', 'id');
    }

    public function pkl(): HasMany
    {
        return $this->hasMany(
            Pkl::class,
            'id_pembimbing',
            'id_pembimbing'
        );
    }
}
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class riwayat extends Model
{
    use HasFactory;
    protected $table = 'riwayat';
    protected $fillable = [
        'kepada',
        'pengirim',
        'reservasi_id',
        'subjek',
        'deskripsi'
    ];
    public function reservasi(): HasMany {
        return $this->HasMany(reservasi::class);
    }

}

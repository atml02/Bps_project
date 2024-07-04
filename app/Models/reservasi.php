<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class reservasi extends Model
{
    use HasFactory;
    protected $table = 'reservasi';
    protected $fillable = [
        'user_id',
        'kegiatan_id',
        'riwayat_id',
        'tgl_req',
        'wkt_req',
        'temu_req',
        'plat_req',
        'keperluan',
        'status',
    ];
    public function user(): BelongsTo {
        return $this->BelongsTo(user::class);
    }
    public function kegiatan(): BelongsTo {
        return $this->BelongsTo(kegiatan::class);
    }
    public function riwayat(): BelongsTo {
        return $this->BelongsTo(riwayat::class);
    }
}

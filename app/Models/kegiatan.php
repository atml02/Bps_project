<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class kegiatan extends Model
{
    use HasFactory;
    protected $table = 'kegiatan';
    protected $fillable =[
        'nama'
    ];
    public function reservasi() : HasMany {
        return $this->hasMany(reservasi::class);
    }
}

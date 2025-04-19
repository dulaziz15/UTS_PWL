<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class DetailMobil extends Model
{
    use HasFactory;

    protected $table = 'detail_mobil';
    protected $primaryKey = 'detail_mobil_id';

    protected $fillable = [
        'mobil_id' ,
        'usia' ,
        'kilometer' ,
        'cylinder' ,
        'no_mesin' ,
        'transmisi' ,
        'hp' ,
        'warna' ,
    ];

    public function mobil(): BelongsTo {
        return $this->belongsTo(Mobil::class, 'mobil_id', 'mobil_id');
    }
}

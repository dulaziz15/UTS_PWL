<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Mobil extends Model
{
    use HasFactory;

    protected $table = 'mobil';
    protected $primaryKey = 'mobil_id';

    protected $fillable = [
        'kategori_id',
        'merk',
        'tahun',
        'harga',
        'type',
        'image',
        'status'
    ];

    public function kategori(): BelongsTo {
        return $this->belongsTo(Kategori::class, 'kategori_id', 'kategori_id');
    }

    public function detail(){
        return $this->hasOne(DetailMobil::class, 'mobil_id');
    }
    
    public function transaksi(){
        return $this->hasOne(Transaksi::class, 'mobil_id');
    }
}

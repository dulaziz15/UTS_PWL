<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Kategori extends Model
{
    use HasFactory;

    protected $table = 'kategori';
    protected $primaryKey = 'kategori_id';

    protected $fillable = [
        'kode_kategori',
        'nama_kategori'
    ];

    public function mobil(): HasMany {
        return $this->hasMany(Mobil::class, 'mobil_id', 'mobil_id');
    }
}

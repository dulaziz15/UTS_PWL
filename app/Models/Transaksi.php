<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Transaksi extends Model
{
    use HasFactory;

    protected $table = 'transaksi';
    protected $primaryKey = 'transaksi_id';

    protected $fillable = [
        'mobil_id',
        'user_id',
        'status',
        'pembeli',
        'telp_pembeli'
    ];

    public function mobil(): BelongsTo {
        return $this->belongsTo(Mobil::class, 'mobil_id', 'mobil_id');
    }

    public function user(): BelongsTo {
        return $this->belongsTo( User::class, 'user_id', 'user_id');
    }
}

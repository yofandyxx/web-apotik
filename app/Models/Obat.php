<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Obat extends Model
{
    use HasFactory;

    protected $fillable = [
        'kode_obat',
        'nama_obat',
        'kategori_id',
        'harga_beli',
        'harga_jual',
        'stok',
        'stok_minimal',
        'expired_date',
        'deskripsi',
        'satuan'
    ];

    protected $casts = [
        'expired_date' => 'date',
    ];

    public function kategori()
    {
        return $this->belongsTo(Kategori::class);
    }

    public function transaksiDetails()
    {
        return $this->hasMany(TransaksiDetail::class);
    }
}
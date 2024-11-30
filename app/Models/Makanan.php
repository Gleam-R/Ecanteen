<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Makanan extends Model
{
    use HasFactory;

    protected $table = 'makanan';

    protected $fillable = [
        'nama_makanan',
        'deskripsi',
        'gambar',
        'store_id',
        'harga',
    ];

    public function komentar()
    {
        return $this->hasMany(Komentar::class);
    }

    public function rating()
    {
        return $this->hasMany(Rating::class);
    }

    public function pesanan()
    {
        return $this->hasMany(Pesanan::class);
    }

    public function store()
    {
        return $this->belongsTo(store::class);
    }

}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class store extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'description'];

    // Definisikan relasi One-to-Many dengan model Makanan
    public function makanan()
    {
        return $this->hasMany(Makanan::class);
    }
}

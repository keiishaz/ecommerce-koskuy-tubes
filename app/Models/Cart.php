<?php

namespace App\Models;

use App\Models\User;
use App\Models\Product;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Cart extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'product_id',
        'jumlah',
    ];

    // Relasi ke tabel 'users' (cart dimiliki oleh user)
    public function user() {
        return $this->belongsTo(User::class);
    }

    // Relasi ke tabel 'products' (cart berisi produk)
    public function product() {
        return $this->belongsTo(Product::class);
    }
}

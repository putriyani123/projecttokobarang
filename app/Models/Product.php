<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id',
        'name',
        'price',
        'discount',
        'stock',
        'description',
        'image',
        'is_custom',
        'is_preorder',
        'preorder_days'
        
    ];

    // ACCESSOR: Harga setelah diskon
    public function getDiscountedPriceAttribute()
    {
        if ($this->discount > 0) {
            return round($this->price - ($this->price * $this->discount / 100));
        }
        return $this->price;
    }

    // ACCESSOR: Apakah produk sedang diskon
    public function getIsOnSaleAttribute()
    {
        return $this->discount > 0;
    }

    // RELASI
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function transactionItems()
    {
        return $this->hasMany(TransactionItem::class);
    }
}
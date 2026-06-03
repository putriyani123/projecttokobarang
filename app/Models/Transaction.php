<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'address_id',
        'midtrans_order_id',
        'total_price',
        'status',
        'tracking_number',
        'proof_of_delivery',
        'delivery_date'
    ];

    // RELASI
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function address()
    {
        return $this->belongsTo(Address::class);
    }

    public function items()
    {
        return $this->hasMany(TransactionItem::class);
    }
}
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RentItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'rent_id',
        'item_id',
        'quantity',
        'price_per_unit',
        'subtotal',
    ];

    /**
     * Setiap rent_item dimiliki oleh satu pemesanan (rent).
     */
    public function rent()
    {
        return $this->belongsTo(Rent::class);
    }

    /**
     * Setiap rent_item merujuk ke satu item di inventory.
     */
    public function product()
    {
        return $this->belongsTo(
            Product::class,
            'item_id',
            'id'
        );
    }
}

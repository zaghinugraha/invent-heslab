<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rent extends Model
{
    use HasFactory;

    protected $table = 'rent';

    protected $fillable = [
        'user_id',
        'order_date',
        'start_date',
        'end_date',
        'return_date',
        'total_cost',
        'snap_token',
        'payment_status',
        'order_status',
        'notes',
        'nim_nip',
        'phone',
        'ktm_image',
        'before_documentation',
        'after_documentation',
    ];

    protected $hidden = [
        'ktm_image',
        'before_documentation',
        'after_documentation',
    ];

    protected static function boot()
    {
        parent::boot();

        static::updated(function ($rent) {
            // Decrease stock when payment_status changes to 'paid'
            if ($rent->isDirty('payment_status') && $rent->payment_status === 'paid') {
                foreach ($rent->items as $item) {
                    $product = $item->product;
                    $product->decrement('quantity', $item->quantity);
                }
            }

            // Increase stock when order_status changes to 'returned'
            if ($rent->isDirty('order_status') && $rent->order_status === 'returned') {
                foreach ($rent->items as $item) {
                    $product = $item->product;
                    $product->increment('quantity', $item->quantity);
                }
            }
        });
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function items()
    {
        return $this->hasMany(RentItem::class);
    }

    public function getKtmImageUrlAttribute()
    {
        return $this->ktm_image ? route('rent.ktmImage', $this->id) : null;
    }

    public function getBeforeDocumentationUrlAttribute()
    {
        return $this->before_documentation ? route('rent.beforeDocumentation', $this->id) : null;
    }

    public function getAfterDocumentationUrlAttribute()
    {
        return $this->after_documentation ? route('rent.afterDocumentation', $this->id) : null;
    }
}

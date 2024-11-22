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
        'total_cost',
        'payment_method',
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

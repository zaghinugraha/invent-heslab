<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rent extends Model
{
    use HasFactory;

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
        'nim_nip',       // NIM/NIP
        'phone',         // Nomor WhatsApp Aktif
        'ktm_image',     // Path atau URL gambar KTM
    ];

    /**
     * Relasi ke model User
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relasi ke model RentItem
     */
    public function items()
    {
        return $this->hasMany(RentItem::class);
    }
}

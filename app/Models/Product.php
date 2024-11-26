<?php

namespace App\Models;

use App\Enums\TaxType;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Model
{
    use HasFactory;

    protected $guarded = ['id'];
    protected $appends = ['specification_plain'];

    public $fillable = [
        'name',
        'slug',
        'code',
        'quantity',
        'quantity_alert',
        'notes',
        'brand',
        'source',
        'dateArrival',
        'price',
        'product_image',
        'category_id',
        'created_at',
        'updated_at',
        'user_id',
        'uuid',
        'specification'
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime'
    ];

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function scopeSearch($query, $value): void
    {
        $query->where('name', 'like', "%{$value}%")
            ->orWhere('code', 'like', "%{$value}%");
    }
    /**
     * Get the user that owns the Category
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }


    public function getSpecificationPlainAttribute()
    {
        // Convert the HTML list to plain text with newlines
        $html = $this->specification;
        if ($html) {
            // Replace closing </li> tags with newlines
            $text = str_replace('</li>', "\n", $html);
            // Remove any remaining <li> or other HTML tags
            $text = strip_tags($text);
            // Trim any extra whitespace
            return trim($text);
        }
        return '';
    }

    public function maintenance()
    {
        return $this->hasMany(Maintenance::class);
    }
}

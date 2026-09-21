<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Items extends Model
{
    protected $fillable = [
        'vendor_id',
        'items_category_id',
        'name',
        'description',
        'price_per_day',
        'status',
        'items_photo',
    ];

    protected $casts = [
        'price_per_day' => 'decimal:2',
    ];

    public function vendor(): BelongsTo
    {
        return $this->belongsTo(User::class, 'vendor_id');
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(ItemsCategory::class, 'items_category_id');
    }

    public function bookings(): HasMany
    {
        return $this->hasMany(Booking::class, 'item_id');
    }
}

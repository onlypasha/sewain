<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ItemsCategory extends Model
{
    protected $table = 'items_categories';

    protected $fillable = [
        'vendor_id',
        'name',
    ];

    public function vendor(): BelongsTo
    {
        return $this->belongsTo(User::class, 'vendor_id');
    }

    public function items(): HasMany
    {
        return $this->hasMany(Items::class, 'items_category_id');
    }
}

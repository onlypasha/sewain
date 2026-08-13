<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class VendorProfiles extends Model
{
    public $fillable = [
        'user_id',
        'owner_name',
        'subscription',
        'assets',
        'status',
        'address',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function subscriptions(): HasMany
    {
        return $this->hasMany(Subscription::class, 'vendor_profile_id');
    }
}

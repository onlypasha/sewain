<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Subscription extends Model
{
    protected $fillable = [
        'vendor_id',
        'subscription_plan_id',
        'status',
        'start_date',
        'end_date',
    ];

    public function vendorProfile()
    {
        return $this->belongsTo(VendorProfiles::class, 'vendor_profile_id');
    }

    public function subscriptionPlan(): HasMany
    {
        return $this->hasMany(SubscriptionPlan::class);
    }
}

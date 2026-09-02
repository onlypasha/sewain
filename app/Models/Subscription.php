<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Subscription extends Model
{
    protected $fillable = [
        'vendor_profile_id',
        'subscription_plan_id',
        'status',
        'start_date',
        'end_date',
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
    ];

    public function getRemainingDaysAttribute(): int
    {
        if (! $this->end_date || now()->startOfDay()->gt($this->end_date)) {
            return 0;
        }

        return (int) now()->startOfDay()->diffInDays($this->end_date);
    }

    public function vendorProfile()
    {
        return $this->belongsTo(VendorProfiles::class, 'vendor_profile_id');
    }

    public function subscriptionPlan()
    {
        return $this->belongsTo(SubscriptionPlan::class);
    }
}

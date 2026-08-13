<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SubscriptionPlan extends Model
{
    public $fillable = [
        'name',
        'slug',
        'price',
        'billing_cycle',
        'features',
        'is_active',
    ];
}

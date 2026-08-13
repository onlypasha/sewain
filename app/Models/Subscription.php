<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Subscription extends Model
{
    protected $fillable = [
        'vendor_id',
        'subscription_plan_id',
        'status',
        'start_date',
        'end_date',
    ];
}

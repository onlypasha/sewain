<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

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
}

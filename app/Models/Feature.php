<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Feature extends Model
{
    protected $fillable = [
        'name',
        'key',
        'description',
        'is_maintenance',
        'maintenance_message',
    ];

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'is_maintenance' => 'boolean',
        ];
    }

    public function subscriptionPlans(): BelongsToMany
    {
        return $this->belongsToMany(SubscriptionPlan::class)->withTimestamps();
    }
}

<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

#[Fillable(['name', 'email', 'password', 'role', 'slug', 'phone'])]
#[Hidden(['password', 'remember_token'])]
class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function vendorProfiles(): HasOne
    {
        return $this->hasOne(VendorProfiles::class);
    }

    public function items(): HasMany
    {
        return $this->hasMany(Items::class, 'vendor_id');
    }

    public function itemsCategories(): HasMany
    {
        return $this->hasMany(ItemsCategory::class, 'vendor_id');
    }

    public function isSubscriptionActive(): bool
    {
        $profile = $this->vendorProfiles;
        if (! $profile) {
            return false;
        }

        $subscription = $profile->subscriptions()->latest()->first();

        return $subscription && $subscription->status === 'active';
    }

    public function hasFeatureAccess(string $featureKey): bool
    {
        if ($this->role !== 'vendor') {
            return true; // Superadmins might not need this check, but just in case
        }

        $profile = $this->vendorProfiles;
        if (! $profile) {
            return false;
        }

        $subscription = $profile->subscriptions()->latest()->first();
        if (! $subscription || $subscription->status !== 'active') {
            return false;
        }

        $plan = $subscription->subscriptionPlan;
        if (! $plan) {
            return false;
        }

        // Load features list if not already loaded to avoid N+1 queries when checked multiple times
        if (! $plan->relationLoaded('featuresList')) {
            $plan->load('featuresList');
        }

        return $plan->featuresList->contains('key', $featureKey);
    }
}

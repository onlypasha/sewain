<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class VendorProfiles extends Model
{
    public $fillable = [
        'user_id',
        'owner_name',
        'address',
        'profiles_picture',
        'status',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function subscriptions(): HasMany
    {
        return $this->hasMany(Subscription::class, 'vendor_profile_id');
    }

    /**
     * Langganan terakhir milik profil ini, apa pun statusnya. Dipakai untuk
     * tampilan dan riwayat, bukan untuk menentukan hak akses.
     */
    public function latestSubscription(): ?Subscription
    {
        return $this->subscriptions()->latest('id')->first();
    }
}

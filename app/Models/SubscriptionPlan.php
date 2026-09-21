<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class SubscriptionPlan extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'price',
        'billing_cycle',
        'max_assets',
        'features',
        'is_active',
    ];

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'features' => 'array',
            'is_active' => 'boolean',
            'max_assets' => 'integer',
        ];
    }

    public function subscriptions(): HasMany
    {
        return $this->hasMany(Subscription::class);
    }

    public function featuresList(): BelongsToMany
    {
        return $this->belongsToMany(Feature::class)->withTimestamps();
    }

    /**
     * Hitung kuota maksimal aset untuk paket ini.
     * Mengutamakan kolom max_assets jika terisi.
     * Jika tidak, mencari teks fitur yang menyebutkan aset/asset dan mengekstrak angkanya.
     * Jika tidak ditemukan, menggunakan nilai default berdasarkan tingkatan paket (slug).
     */
    public function getMaxAssets(): int|string
    {
        if (! is_null($this->max_assets) && $this->max_assets > 0) {
            return (int) $this->max_assets;
        }

        if (is_array($this->features)) {
            foreach ($this->features as $feature) {
                $text = '';
                $value = null;

                if (is_array($feature)) {
                    $text = $feature['text'] ?? $feature['name'] ?? '';
                    $value = $feature['value'] ?? $feature['limit'] ?? null;
                } elseif (is_string($feature)) {
                    $text = $feature;
                }

                if (stripos($text, 'aset') !== false || stripos($text, 'asset') !== false) {
                    if (! is_null($value) && is_numeric($value)) {
                        return (int) $value;
                    }

                    if (stripos($text, 'unlimited') !== false || stripos($text, 'tanpa batas') !== false) {
                        return 'Unlimited';
                    }

                    if (preg_match('/\d+/', $text, $matches)) {
                        return (int) $matches[0];
                    }
                }
            }
        }

        return match (strtolower($this->slug ?? '')) {
            'basic' => 20,
            'pro' => 100,
            'enterprise' => 500,
            default => 50,
        };
    }
}

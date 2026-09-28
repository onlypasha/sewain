<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Booking extends Model
{
    use HasFactory;

    protected $fillable = [
        'vendor_id',
        'item_id',
        'customer_id',
        'booking_code',
        'customer_name',
        'customer_phone',
        'customer_email',
        'rental_start',
        'rental_end',
        'total_price',
        'status',
        'notes',
    ];

    protected $casts = [
        'vendor_id' => 'integer',
        'item_id' => 'integer',
        'customer_id' => 'integer',
        'rental_start' => 'date',
        'rental_end' => 'date',
        'total_price' => 'decimal:2',
    ];

    /**
     * Relasi ke vendor (User dengan role vendor).
     */
    public function vendor(): BelongsTo
    {
        return $this->belongsTo(User::class, 'vendor_id');
    }

    /**
     * Relasi ke customer (User dengan role customer) yang menyewa.
     */
    public function customer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'customer_id');
    }

    /**
     * Relasi ke item yang disewa.
     */
    public function item(): BelongsTo
    {
        return $this->belongsTo(Items::class, 'item_id');
    }

    /**
     * Relasi ke pembayaran sewa.
     */
    public function payments(): HasMany
    {
        return $this->hasMany(BookingPayment::class);
    }

    /**
     * Scope untuk booking yang aktif dalam rentang tanggal tertentu.
     */
    public function scopeOverlappingDateRange($query, $start, $end)
    {
        return $query->where('rental_start', '<=', $end)
            ->where('rental_end', '>=', $start);
    }

    /**
     * Scope untuk booking yang dianggap "aktif" (belum dibatalkan).
     */
    public function scopeActiveStatus($query)
    {
        return $query->where('status', '!=', 'cancelled');
    }
}

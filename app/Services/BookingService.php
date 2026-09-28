<?php

namespace App\Services;

use App\Models\Booking;
use App\Models\Items;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class BookingService
{
    public function create(array $data): Booking
    {
        return DB::transaction(function () use ($data) {
            $item = Items::lockForUpdate()->findOrFail($data['item_id']);

            $start = $data['rental_start'];
            $end = $data['rental_end'];

            if ($this->hasConflict($item->id, $start, $end)) {
                throw ValidationException::withMessages([
                    'rental_start' => 'Tanggal yang dipilih sudah dipesan untuk item ini.',
                ]);
            }

            $data['vendor_id'] = $item->vendor_id;
            $data['status'] = $data['status'] ?? 'pending';

            if (! isset($data['total_price'])) {
                $days = (new \DateTime($start))->diff(new \DateTime($end))->days + 1;
                $data['total_price'] = $item->price_per_day * $days;
            }

            // Generate unique booking_code dengan retry (race-safe karena unique index DB).
            for ($attempt = 0; $attempt < 3; $attempt++) {
                $data['booking_code'] = $data['booking_code'] ?? $this->generateCode();
                try {
                    return Booking::create($data);
                } catch (\Illuminate\Database\QueryException $e) {
                    if ($e->errorInfo[1] ?? 0 !== 1062) { // 1062 = duplicate entry
                        throw $e;
                    }
                    // Kode duplikat, reset supaya generateCode() dijalankan lagi.
                    unset($data['booking_code']);
                }
            }
            throw ValidationException::withMessages([
                'booking_code' => 'Gagal membuat kode booking unik, silakan coba lagi.',
            ]);
        });
    }

    public function hasConflict(int $itemId, string $start, string $end, ?int $ignoreBookingId = null): bool
    {
        return Booking::query()
            ->where('item_id', $itemId)
            ->where('status', '!=', 'cancelled')
            ->when($ignoreBookingId, fn ($q) => $q->where('id', '!=', $ignoreBookingId))
            ->overlappingDateRange($start, $end)
            ->exists();
    }

    public function generateCode(): string
    {
        $date = now()->format('Ymd');
        $seq = Booking::whereDate('created_at', today())->count() + 1;

        return sprintf('SWN-%s-%04d', $date, $seq);
    }
}

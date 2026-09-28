<?php

namespace App\Services;

use App\Models\Booking;
use Illuminate\Validation\ValidationException;

class BookingStatusService
{
    /**
     * Transisi status yang sah: [dari => [ke, ...]]
     */
    public const TRANSITIONS = [
        'pending' => ['confirmed', 'cancelled'],
        'confirmed' => ['active', 'cancelled'],
        'active' => ['completed'],
        'completed' => [],
        'cancelled' => [],
    ];

    /**
     * Ubah status booking dengan validasi transisi.
     *
     * @throws ValidationException kalau transisi tidak sah.
     */
    public function transition(Booking $booking, string $newStatus, ?int $actorId = null): Booking
    {
        $allowed = self::TRANSITIONS[$booking->status] ?? [];

        if (! in_array($newStatus, $allowed, true)) {
            throw ValidationException::withMessages([
                'status' => "Tidak bisa mengubah status dari '{$booking->status}' ke '{$newStatus}'.",
            ]);
        }

        // Aktor (kalau ada) harus pemilik booking.
        if ($actorId !== null && $booking->vendor_id !== $actorId) {
            abort(403, 'Anda tidak berhak mengubah booking ini.');
        }

        $booking->update(['status' => $newStatus]);

        return $booking->refresh();
    }

    public function canTransition(Booking $booking, string $newStatus): bool
    {
        return in_array($newStatus, self::TRANSITIONS[$booking->status] ?? [], true);
    }
}

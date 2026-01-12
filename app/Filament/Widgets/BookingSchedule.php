<?php

namespace App\Filament\Widgets;

use Filament\Widgets\Widget;
use App\Models\Order;
use Illuminate\Support\Carbon;

class BookingSchedule extends Widget
{
    protected string $view = 'filament.widgets.booking-schedule';

    protected static ?int $sort = 20;

    protected int|string|array $columnSpan = 'full';

    public string $selectedDate = '';

    public string $locationFilter = 'all';

    public array $bookings = [];

    public array $timeOptions = [];

    public static bool $isDiscovered = false;

    public static bool $isLazy = false;

    public function mount(): void
    {
        $this->selectedDate = Carbon::now()->format('Y-m-d');
        $this->initializeTimeOptions();
        $this->loadBookings();
    }

    private function initializeTimeOptions(): void
    {
        $this->timeOptions = [
            '09:00', '09:30', '10:00', '10:30', '11:00', '11:30',
            '12:00', '12:30', '13:00', '13:30', '14:00', '14:30',
            '15:00', '15:30', '16:00', '16:30', '17:00', '17:30', '18:00',
        ];
    }

    public function loadBookings(): void
    {
        $this->bookings = Order::where('book_date', $this->selectedDate)
            ->orderBy('book_time')
            ->get()
            ->toArray();
    }

    public function updatedSelectedDate(): void
    {
        $this->loadBookings();
    }

    public function updatedLocationFilter(): void
    {
        $this->loadBookings();
    }

    public function isTimeSlotBooked(string $time, string $location): bool
    {
        return collect($this->bookings)->contains(function (array $booking) use ($time, $location) {
            return substr($booking['book_time'], 0, 5) === $time && $booking['location'] === $location;
        });
    }

    public function getBookingForSlot(string $time, string $location): ?array
    {
        return collect($this->bookings)->first(function (array $booking) use ($time, $location) {
            return substr($booking['book_time'], 0, 5) === $time && $booking['location'] === $location;
        });
    }
}

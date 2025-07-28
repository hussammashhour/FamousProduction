<?php

namespace App\Filament\Widgets;

use App\Models\Booking;
use Filament\Widgets\ChartWidget;

class BookingStatusChart extends ChartWidget
{
    protected static ?string $heading = 'Booking Status Distribution';

    protected function getData(): array
    {
        $pending = Booking::where('status', 'pending')->count();
        $confirmed = Booking::where('status', 'confirmed')->count();
        $completed = Booking::where('status', 'completed')->count();
        $cancelled = Booking::where('status', 'cancelled')->count();

        return [
            'datasets' => [
                [
                    'label' => 'Bookings',
                    'data' => [$pending, $confirmed, $completed, $cancelled],
                    'backgroundColor' => [
                        '#F59E0B', // Amber for pending
                        '#3B82F6', // Blue for confirmed
                        '#10B981', // Green for completed
                        '#EF4444', // Red for cancelled
                    ],
                ],
            ],
            'labels' => ['Pending', 'Confirmed', 'Completed', 'Cancelled'],
        ];
    }

    protected function getType(): string
    {
        return 'doughnut';
    }
}

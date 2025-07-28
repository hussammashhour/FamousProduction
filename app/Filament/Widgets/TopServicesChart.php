<?php

namespace App\Filament\Widgets;

use App\Models\Service;
use App\Models\Booking;
use Filament\Widgets\ChartWidget;

class TopServicesChart extends ChartWidget
{
    protected static ?string $heading = 'Top Services by Bookings';

    protected function getData(): array
    {
        $services = Service::withCount(['bookings' => function ($query) {
            $query->whereIn('status', ['confirmed', 'completed']);
        }])
        ->orderBy('bookings_count', 'desc')
        ->limit(8)
        ->get();

        $labels = $services->pluck('name')->toArray();
        $data = $services->pluck('bookings_count')->toArray();

        return [
            'datasets' => [
                [
                    'label' => 'Bookings',
                    'data' => $data,
                    'backgroundColor' => [
                        '#3B82F6', '#10B981', '#F59E0B', '#EF4444',
                        '#8B5CF6', '#06B6D4', '#84CC16', '#F97316'
                    ],
                ],
            ],
            'labels' => $labels,
        ];
    }

    protected function getType(): string
    {
        return 'bar';
    }
}

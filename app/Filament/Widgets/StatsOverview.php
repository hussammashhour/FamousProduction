<?php

namespace App\Filament\Widgets;

use App\Models\Booking;
use App\Models\Payment;
use App\Models\User;
use App\Models\Service;
use App\Models\Review;
use App\Models\SupportTicket;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverview extends BaseWidget
{
    protected function getStats(): array
    {
        $totalRevenue = Payment::where('status', 'completed')->sum('amount');
        $totalBookings = Booking::whereIn('status', ['confirmed', 'completed'])->count();
        $totalUsers = User::count();
        $averageRating = Review::avg('rating');
        $openTickets = SupportTicket::whereIn('status', ['open', 'pending'])->count();
        $totalServices = Service::where('available', true)->count();

        return [
            Stat::make('Total Revenue', '$' . number_format($totalRevenue, 2))
                ->description('Total completed payments')
                ->descriptionIcon('heroicon-m-currency-dollar')
                ->color('success'),

            Stat::make('Active Bookings', $totalBookings)
                ->description('Confirmed and completed bookings')
                ->descriptionIcon('heroicon-m-calendar')
                ->color('primary'),

            Stat::make('Total Users', $totalUsers)
                ->description('Registered users')
                ->descriptionIcon('heroicon-m-users')
                ->color('info'),

            Stat::make('Average Rating', number_format($averageRating, 1) . '/5')
                ->description('Customer satisfaction')
                ->descriptionIcon('heroicon-m-star')
                ->color('warning'),

            Stat::make('Open Tickets', $openTickets)
                ->description('Pending support requests')
                ->descriptionIcon('heroicon-m-ticket')
                ->color('danger'),

            Stat::make('Available Services', $totalServices)
                ->description('Active photography services')
                ->descriptionIcon('heroicon-m-briefcase')
                ->color('success'),
        ];
    }
}

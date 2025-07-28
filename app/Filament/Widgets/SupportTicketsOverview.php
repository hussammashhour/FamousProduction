<?php

namespace App\Filament\Widgets;

use App\Models\SupportTicket;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class SupportTicketsOverview extends BaseWidget
{
    protected function getStats(): array
    {
        $openTickets = SupportTicket::where('status', 'open')->count();
        $pendingTickets = SupportTicket::where('status', 'pending')->count();
        $resolvedTickets = SupportTicket::where('status', 'resolved')->count();
        $closedTickets = SupportTicket::where('status', 'closed')->count();

        return [
            Stat::make('Open Tickets', $openTickets)
                ->description('Requires immediate attention')
                ->descriptionIcon('heroicon-m-exclamation-triangle')
                ->color('danger'),

            Stat::make('Pending Tickets', $pendingTickets)
                ->description('Under review')
                ->descriptionIcon('heroicon-m-clock')
                ->color('warning'),

            Stat::make('Resolved Tickets', $resolvedTickets)
                ->description('Successfully resolved')
                ->descriptionIcon('heroicon-m-check-circle')
                ->color('success'),

            Stat::make('Closed Tickets', $closedTickets)
                ->description('Completed and closed')
                ->descriptionIcon('heroicon-m-x-circle')
                ->color('gray'),
        ];
    }
}

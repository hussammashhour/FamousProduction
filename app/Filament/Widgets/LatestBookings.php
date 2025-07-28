<?php

namespace App\Filament\Widgets;

use App\Models\Booking;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\BadgeColumn;

class LatestBookings extends BaseWidget
{
    protected static ?string $heading = 'Latest Bookings';

    protected int | string | array $columnSpan = 'full';

    public function table(Table $table): Table
    {
        return $table
            ->query(
                Booking::query()
                    ->with(['client', 'photographer', 'service'])
                    ->latest()
                    ->limit(5)
            )
            ->columns([
                TextColumn::make('client.first_name')
                    ->label('Client')
                    ->searchable(),
                TextColumn::make('photographer.first_name')
                    ->label('Photographer')
                    ->searchable(),
                TextColumn::make('service.name')
                    ->label('Service')
                    ->searchable(),
                TextColumn::make('scheduled_date')
                    ->label('Scheduled Date')
                    ->date()
                    ->sortable(),
                BadgeColumn::make('status')
                    ->colors([
                        'warning' => 'pending',
                        'primary' => 'confirmed',
                        'success' => 'completed',
                        'danger' => 'cancelled',
                    ]),
            ])
            ->paginated(false);
    }
}

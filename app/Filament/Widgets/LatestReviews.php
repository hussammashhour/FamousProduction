<?php

namespace App\Filament\Widgets;

use App\Models\Review;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;
use Filament\Tables\Columns\TextColumn;

class LatestReviews extends BaseWidget
{
    protected static ?string $heading = 'Latest Reviews';

    public function table(Table $table): Table
    {
        return $table
            ->query(
                Review::query()
                    ->with(['client', 'service'])
                    ->latest()
                    ->limit(5)
            )
            ->columns([
                TextColumn::make('client.first_name')
                    ->label('Client')
                    ->searchable(),
                TextColumn::make('service.name')
                    ->label('Service')
                    ->searchable(),
                TextColumn::make('rating')
                    ->label('Rating')
                    ->formatStateUsing(fn (int $state): string => str_repeat('⭐', $state) . ' (' . $state . '/5)'),
                TextColumn::make('comment')
                    ->label('Comment')
                    ->limit(50)
                    ->searchable(),
                TextColumn::make('created_at')
                    ->label('Date')
                    ->dateTime()
                    ->sortable(),
            ])
            ->paginated(false);
    }
}

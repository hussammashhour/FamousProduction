<?php

namespace App\Filament\Resources;

use App\Filament\Resources\BookingResource\Pages;
use App\Models\Booking;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Infolists\Infolist;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Components\Section;
use Illuminate\Database\Eloquent\Model;

class BookingResource extends Resource
{
    protected static ?string $model = Booking::class;

    protected static ?string $navigationIcon = 'heroicon-o-calendar-days';
    protected static ?string $navigationGroup = 'Management';
    protected static ?string $recordTitleAttribute = 'scheduled_date';
protected static ?int $navigationSort = 2;

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Select::make('client_id')
                ->relationship('client', 'email')
                ->label('Client')
                ->searchable()
                ->required(),

            Forms\Components\Select::make('photographer_id')
                ->relationship('photographer', 'email')
                ->label('Photographer')
                ->searchable()
                ->required(),

            Forms\Components\Select::make('service_id')
                ->relationship('service', 'name')
                ->label('Service')
                ->searchable()
                ->required(),

            Forms\Components\DatePicker::make('scheduled_date')
                ->label('Scheduled Date')
                ->required(),

            Forms\Components\Select::make('status')
                ->options([
                    'pending' => 'Pending',
                    'confirmed' => 'Confirmed',
                    'cancelled' => 'Cancelled',
                    'completed' => 'Completed',
                ])
                ->required(),

            Forms\Components\Textarea::make('comment')
                ->rows(3)
                ->maxLength(1000),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('client.email')->label('Client')->sortable()->searchable(),
                Tables\Columns\TextColumn::make('photographer.email')->label('Photographer')->sortable()->searchable(),
                Tables\Columns\TextColumn::make('service.name')->label('Service')->sortable(),
                Tables\Columns\TextColumn::make('scheduled_date')->date()->sortable(),
                Tables\Columns\BadgeColumn::make('status')
                    ->colors([
                        'gray' => 'pending',
                        'info' => 'confirmed',
                        'danger' => 'cancelled',
                        'success' => 'completed',
                    ])
                    ->sortable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->options([
                        'pending' => 'Pending',
                        'confirmed' => 'Confirmed',
                        'cancelled' => 'Cancelled',
                        'completed' => 'Completed',
                    ]),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function infolist(Infolist $infolist): Infolist
    {
        return $infolist->schema([
            Section::make('Booking Details')->schema([
                TextEntry::make('client.email')->label('Client'),
                TextEntry::make('photographer.email')->label('Photographer'),
                TextEntry::make('service.name')->label('Service'),
                TextEntry::make('scheduled_date')->date()->label('Date'),
                TextEntry::make('status')->label('Status'),
                TextEntry::make('comment')->label('Comment'),
                TextEntry::make('created_at')->dateTime(),
            ])->columns(2),
        ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListBookings::route('/'),
            'create' => Pages\CreateBooking::route('/create'),
            'edit' => Pages\EditBooking::route('/{record}/edit'),
        ];
    }
}

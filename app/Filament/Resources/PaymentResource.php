<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PaymentResource\Pages;
use App\Models\Payment;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Infolists\Infolist;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Components\Section;
use Illuminate\Database\Eloquent\Model;

class PaymentResource extends Resource
{
    protected static ?string $model = Payment::class;
protected static ?int $navigationSort = 2;

    protected static ?string $navigationIcon = 'heroicon-o-credit-card';
    protected static ?string $navigationGroup = 'Management';
    protected static ?string $recordTitleAttribute = 'id';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Select::make('booking_id')
                ->relationship('booking', 'id')
                ->label('Booking')
                ->searchable()
                ->required(),

            Forms\Components\TextInput::make('amount')
                ->numeric()
                ->required(),

            Forms\Components\Select::make('method')
                ->options([
                    'cash' => 'Cash',
                    'credit_card' => 'Credit Card',
                    'paypal' => 'PayPal',
                    'bank_transfer' => 'Bank Transfer',
                ])
                ->required(),

            Forms\Components\Select::make('status')
                ->options([
                    'pending' => 'Pending',
                    'paid' => 'Paid',
                    'failed' => 'Failed',
                ])
                ->required(),

            Forms\Components\DateTimePicker::make('paid_at')
                ->label('Paid At')
                ->required(),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table->columns([
            Tables\Columns\TextColumn::make('booking.id')
                ->label('Booking ID')
                ->sortable(),

            Tables\Columns\TextColumn::make('booking.client.email')
                ->label('Client')
                ->searchable(),

            Tables\Columns\TextColumn::make('amount')
                ->money('usd')
                ->sortable(),

            Tables\Columns\TextColumn::make('method')
                ->sortable(),

            Tables\Columns\BadgeColumn::make('status')
                ->colors([
                    'gray' => 'pending',
                    'success' => 'paid',
                    'danger' => 'failed',
                ])
                ->sortable(),

            Tables\Columns\TextColumn::make('paid_at')
                ->dateTime()
                ->sortable(),
        ])
        ->filters([
            Tables\Filters\SelectFilter::make('status')
                ->options([
                    'pending' => 'Pending',
                    'paid' => 'Paid',
                    'failed' => 'Failed',
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
            Section::make('Payment Details')->schema([
                TextEntry::make('booking.id')->label('Booking ID'),
                TextEntry::make('booking.client.email')->label('Client'),
                TextEntry::make('amount')->money('usd')->label('Amount'),
                TextEntry::make('method')->label('Method'),
                TextEntry::make('status')->label('Status'),
                TextEntry::make('paid_at')->dateTime()->label('Paid At'),
                TextEntry::make('created_at')->dateTime()->label('Created'),
            ])->columns(2),
        ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPayments::route('/'),
            'create' => Pages\CreatePayment::route('/create'),
            'edit' => Pages\EditPayment::route('/{record}/edit'),
        ];
    }
}

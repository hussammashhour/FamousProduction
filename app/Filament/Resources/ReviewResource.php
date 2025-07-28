<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ReviewResource\Pages;
use App\Models\Review;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Infolists\Infolist;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Components\Section;
use Illuminate\Database\Eloquent\Model;

class ReviewResource extends Resource
{
    protected static ?string $model = Review::class;

    protected static ?string $navigationIcon = 'heroicon-o-star';
    protected static ?string $navigationGroup = 'Management';
    protected static ?string $recordTitleAttribute = 'comment';
protected static ?int $navigationSort = 2;

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Select::make('client_id')
                ->relationship('client', 'email')
                ->searchable()
                ->required()
                ->label('Client'),

            Forms\Components\Select::make('service_id')
                ->relationship('service', 'name')
                ->searchable()
                ->required()
                ->label('Service'),

            Forms\Components\TextInput::make('rating')
                ->label('Rating')
                ->numeric()
                ->minValue(1)
                ->maxValue(5)
                ->step(0.1)
                ->required(),

            Forms\Components\Textarea::make('comment')
                ->rows(3)
                ->maxLength(1000)
                ->nullable(),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('client.email')
                    ->label('Client')
                    ->sortable()
                    ->searchable(),

                Tables\Columns\TextColumn::make('service.name')
                    ->label('Service')
                    ->sortable()
                    ->searchable(),

                Tables\Columns\TextColumn::make('rating')
                    ->badge()
                    ->color(fn (string $state): string => match (true) {
                        $state >= 4.5 => 'success',
                        $state >= 3   => 'warning',
                        default       => 'danger',
                    }),

                Tables\Columns\TextColumn::make('comment')
                    ->limit(30),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Reviewed At')
                    ->dateTime(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('rating')
                    ->options([
                        '5' => '5 stars',
                        '4' => '4 stars',
                        '3' => '3 stars',
                        '2' => '2 stars',
                        '1' => '1 star',
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
            Section::make('Review Info')->schema([
                TextEntry::make('client.email')->label('Client'),
                TextEntry::make('service.name')->label('Service'),
                TextEntry::make('rating'),
                TextEntry::make('comment'),
                TextEntry::make('created_at')->dateTime(),
            ])->columns(2),
        ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListReviews::route('/'),
            'create' => Pages\CreateReview::route('/create'),
            'edit' => Pages\EditReview::route('/{record}/edit'),
        ];
    }
}

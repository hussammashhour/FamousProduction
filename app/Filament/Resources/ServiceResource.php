<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ServiceResource\Pages;
use App\Models\Service;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Infolists\Infolist;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Components\BooleanEntry;
use Filament\Infolists\Components\Section;
use Illuminate\Database\Eloquent\Model;

class ServiceResource extends Resource
{
    protected static ?string $model = Service::class;

    protected static ?string $navigationIcon = 'heroicon-o-briefcase';
    protected static ?string $navigationGroup = 'Management';
    protected static ?string $recordTitleAttribute = 'name';
protected static ?int $navigationSort = 2;

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\TextInput::make('name')->required()->maxLength(255),
            Forms\Components\Textarea::make('description')->nullable()->rows(3),
            Forms\Components\TextInput::make('price')->required()->numeric()->prefix('€'),
            Forms\Components\TextInput::make('duration')->required()->maxLength(255),
            Forms\Components\Toggle::make('available')->label('Is Available?')->default(false),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')->searchable()->sortable(),
                Tables\Columns\TextColumn::make('price')->money('eur')->sortable(),
                Tables\Columns\TextColumn::make('duration')->sortable(),
                Tables\Columns\IconColumn::make('available')
                    ->boolean()
                    ->label('Available'),
                Tables\Columns\TextColumn::make('created_at')->dateTime()->sortable(),
            ])
            ->filters([
                Tables\Filters\TernaryFilter::make('available')
                    ->label('Availability')
                    ->trueLabel('Only Available')
                    ->falseLabel('Only Unavailable'),
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
            Section::make('Service Details')->schema([
                TextEntry::make('name'),
                TextEntry::make('description'),
                TextEntry::make('price')->label('Price (€)'),
                TextEntry::make('duration'),
                BooleanEntry::make('available')->label('Available'),
                TextEntry::make('created_at')->dateTime(),
            ])->columns(2),
        ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListServices::route('/'),
            'create' => Pages\CreateService::route('/create'),
            'edit' => Pages\EditService::route('/{record}/edit'),
        ];
    }
}

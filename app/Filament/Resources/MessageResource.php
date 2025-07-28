<?php

namespace App\Filament\Resources;

use App\Filament\Resources\MessageResource\Pages;
use App\Filament\Resources\MessageResource\RelationManagers;
use App\Models\Message;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Infolists\Infolist;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Components\Section;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class MessageResource extends Resource
{
    protected static ?string $model = Message::class;

    protected static ?string $navigationIcon = 'heroicon-o-chat-bubble-left-right';
    protected static ?string $navigationGroup = 'Communication';
    protected static ?string $recordTitleAttribute = 'content';
    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('sender_id')
                    ->label('Sender')
                    ->options(User::all()->pluck('first_name', 'id'))
                    ->searchable()
                    ->required(),
                Forms\Components\Select::make('receiver_id')
                    ->label('Receiver')
                    ->options(User::all()->pluck('first_name', 'id'))
                    ->searchable()
                    ->required(),
                Forms\Components\Textarea::make('content')
                    ->required()
                    ->maxLength(1000)
                    ->rows(4),
                Forms\Components\Toggle::make('is_read')
                    ->label('Is Read?')
                    ->default(false),
                Forms\Components\DateTimePicker::make('read_at')
                    ->label('Read At')
                    ->nullable(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('sender.first_name')
                    ->label('Sender')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('receiver.first_name')
                    ->label('Receiver')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('content')
                    ->limit(50)
                    ->searchable(),
                Tables\Columns\IconColumn::make('is_read')
                    ->boolean()
                    ->label('Read'),
                Tables\Columns\TextColumn::make('read_at')
                    ->dateTime()
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\TernaryFilter::make('is_read')
                    ->label('Read Status')
                    ->trueLabel('Only Read')
                    ->falseLabel('Only Unread'),
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
            Section::make('Message Details')->schema([
                TextEntry::make('sender.first_name')->label('Sender'),
                TextEntry::make('receiver.first_name')->label('Receiver'),
                TextEntry::make('content'),
                TextEntry::make('is_read')->label('Is Read'),
                TextEntry::make('read_at')->dateTime(),
                TextEntry::make('created_at')->dateTime(),
            ])->columns(2),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListMessages::route('/'),
            'create' => Pages\CreateMessage::route('/create'),
            'edit' => Pages\EditMessage::route('/{record}/edit'),
        ];
    }
}

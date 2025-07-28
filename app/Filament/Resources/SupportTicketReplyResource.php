<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SupportTicketReplyResource\Pages;
use App\Filament\Resources\SupportTicketReplyResource\RelationManagers;
use App\Models\SupportTicketReply;
use App\Models\SupportTicket;
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

class SupportTicketReplyResource extends Resource
{
    protected static ?string $model = SupportTicketReply::class;

    protected static ?string $navigationIcon = 'heroicon-o-chat-bubble-oval-left';
    protected static ?string $navigationGroup = 'Support';
    protected static ?string $recordTitleAttribute = 'message';
    protected static ?int $navigationSort = 2;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('support_ticket_id')
                    ->label('Support Ticket')
                    ->options(SupportTicket::all()->pluck('subject', 'id'))
                    ->searchable()
                    ->required(),
                Forms\Components\Select::make('user_id')
                    ->label('User')
                    ->options(User::all()->pluck('first_name', 'id'))
                    ->searchable()
                    ->required(),
                Forms\Components\Textarea::make('message')
                    ->required()
                    ->maxLength(1000)
                    ->rows(4),
                Forms\Components\Toggle::make('is_internal')
                    ->label('Internal Reply?')
                    ->default(false),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('ticket.subject')
                    ->label('Ticket Subject')
                    ->limit(30)
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('user.first_name')
                    ->label('User')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('message')
                    ->limit(50)
                    ->searchable(),
                Tables\Columns\IconColumn::make('is_internal')
                    ->boolean()
                    ->label('Internal'),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable(),
            ])
            ->filters([
                Tables\Filters\TernaryFilter::make('is_internal')
                    ->label('Internal Replies')
                    ->trueLabel('Only Internal')
                    ->falseLabel('Only External'),
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
            Section::make('Reply Details')->schema([
                TextEntry::make('ticket.subject')->label('Ticket Subject'),
                TextEntry::make('user.first_name')->label('User'),
                TextEntry::make('message'),
                TextEntry::make('is_internal')->label('Internal Reply'),
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
            'index' => Pages\ListSupportTicketReplies::route('/'),
            'create' => Pages\CreateSupportTicketReply::route('/create'),
            'edit' => Pages\EditSupportTicketReply::route('/{record}/edit'),
        ];
    }
}

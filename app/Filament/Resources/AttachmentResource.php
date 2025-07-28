<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AttachmentResource\Pages;
use App\Filament\Resources\AttachmentResource\RelationManagers;
use App\Models\Attachment;
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

class AttachmentResource extends Resource
{
    protected static ?string $model = Attachment::class;

    protected static ?string $navigationIcon = 'heroicon-o-paper-clip';
    protected static ?string $navigationGroup = 'Support';
    protected static ?string $recordTitleAttribute = 'original_name';
    protected static ?int $navigationSort = 3;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('file_path')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('original_name')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('mime_type')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('attachable_id')
                    ->required()
                    ->numeric(),
                Forms\Components\TextInput::make('attachable_type')
                    ->required()
                    ->maxLength(255),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('original_name')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('mime_type')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('file_path')
                    ->limit(30)
                    ->searchable(),
                Tables\Columns\TextColumn::make('attachable_type')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('attachable_type')
                    ->options([
                        'App\Models\SupportTicket' => 'Support Ticket',
                        'App\Models\SupportTicketReply' => 'Support Ticket Reply',
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
            Section::make('Attachment Details')->schema([
                TextEntry::make('original_name'),
                TextEntry::make('mime_type'),
                TextEntry::make('file_path'),
                TextEntry::make('attachable_type'),
                TextEntry::make('attachable_id'),
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
            'index' => Pages\ListAttachments::route('/'),
            'create' => Pages\CreateAttachment::route('/create'),
            'edit' => Pages\EditAttachment::route('/{record}/edit'),
        ];
    }
}

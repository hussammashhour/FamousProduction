<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AnnouncementResource\Pages;
use App\Filament\Resources\AnnouncementResource\RelationManagers;
use App\Models\Announcement;
use App\Models\Photo;
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

class AnnouncementResource extends Resource
{
    protected static ?string $model = Announcement::class;

    protected static ?string $navigationIcon = 'heroicon-o-megaphone';
    protected static ?string $navigationGroup = 'Content';
    protected static ?string $recordTitleAttribute = 'body';
    protected static ?int $navigationSort = 3;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('photo_id')
                    ->label('Photo')
                    ->options(Photo::all()->pluck('caption', 'id'))
                    ->searchable()
                    ->nullable(),
                Forms\Components\Select::make('created_by')
                    ->label('Created By')
                    ->options(User::all()->pluck('first_name', 'id'))
                    ->searchable()
                    ->required(),
                Forms\Components\Select::make('announcement_type')
                    ->options([
                        'news' => 'News',
                        'promotion' => 'Promotion',
                        'event' => 'Event',
                        'update' => 'Update',
                    ])
                    ->required(),
                Forms\Components\Select::make('announcement_status')
                    ->options([
                        'draft' => 'Draft',
                        'published' => 'Published',
                        'archived' => 'Archived',
                    ])
                    ->required(),
                Forms\Components\Textarea::make('body')
                    ->required()
                    ->maxLength(1000)
                    ->rows(4),
                Forms\Components\DatePicker::make('published_at')
                    ->label('Published At')
                    ->nullable(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('body')
                    ->limit(50)
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('announcement_type')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'news' => 'info',
                        'promotion' => 'success',
                        'event' => 'warning',
                        'update' => 'gray',
                    })
                    ->sortable(),
                Tables\Columns\TextColumn::make('announcement_status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'draft' => 'gray',
                        'published' => 'success',
                        'archived' => 'danger',
                    })
                    ->sortable(),
                Tables\Columns\TextColumn::make('author.first_name')
                    ->label('Author')
                    ->sortable(),
                Tables\Columns\TextColumn::make('published_at')
                    ->dateTime()
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('announcement_type')
                    ->options([
                        'news' => 'News',
                        'promotion' => 'Promotion',
                        'event' => 'Event',
                        'update' => 'Update',
                    ]),
                Tables\Filters\SelectFilter::make('announcement_status')
                    ->options([
                        'draft' => 'Draft',
                        'published' => 'Published',
                        'archived' => 'Archived',
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
            Section::make('Announcement Details')->schema([
                TextEntry::make('body'),
                TextEntry::make('announcement_type'),
                TextEntry::make('announcement_status'),
                TextEntry::make('author.first_name')->label('Author'),
                TextEntry::make('published_at')->dateTime(),
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
            'index' => Pages\ListAnnouncements::route('/'),
            'create' => Pages\CreateAnnouncement::route('/create'),
            'edit' => Pages\EditAnnouncement::route('/{record}/edit'),
        ];
    }
}

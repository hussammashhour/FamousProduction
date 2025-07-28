<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PostResource\Pages;
use App\Models\Post;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Infolists\Infolist;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Components\Section;

class PostResource extends Resource
{
    protected static ?string $model = Post::class;
    protected static ?int $navigationSort = 1;

    protected static ?string $navigationIcon = 'heroicon-o-document-text';
    protected static ?string $navigationGroup = 'Content';
    protected static ?string $recordTitleAttribute = 'title';

public static function form(Form $form): Form
{
    return $form->schema([
        Forms\Components\Select::make('user_id')
            ->relationship('user', 'email')
            ->label('Author')
            ->required()
            ->searchable(),

        Forms\Components\TextInput::make('title')->required(),
        Forms\Components\Textarea::make('description')->required(),

        Forms\Components\Repeater::make('photos')
            ->label('Photos')
            ->relationship()
            ->schema([
                Forms\Components\FileUpload::make('image_url')
                    ->image()
                    ->directory('photos')
                    ->required(),
                Forms\Components\TextInput::make('caption')->maxLength(255),
            ])
            ->columns(2)
            ->defaultItems(1)
            ->collapsible()
            ->cloneable(),
    ]);
}

    public static function table(Table $table): Table
    {
        return $table->columns([
            Tables\Columns\TextColumn::make('title')->sortable()->searchable(),
            Tables\Columns\TextColumn::make('user.email')->label('Author')->sortable()->searchable(),
            Tables\Columns\TextColumn::make('description')->limit(40),
            Tables\Columns\TextColumn::make('created_at')->label('Posted')->dateTime()->sortable(),
        ])
        ->filters([])
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
            Section::make('Post Details')->schema([
                TextEntry::make('title'),
                TextEntry::make('user.email')->label('Author'),
                TextEntry::make('description'),
                TextEntry::make('created_at')->label('Posted')->dateTime(),
            ])->columns(2),
        ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPosts::route('/'),
            'create' => Pages\CreatePost::route('/create'),
            'edit' => Pages\EditPost::route('/{record}/edit'),
        ];
    }
}

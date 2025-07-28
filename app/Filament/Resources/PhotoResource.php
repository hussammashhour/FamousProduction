<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PhotoResource\Pages;
use App\Models\Photo;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Infolists\Infolist;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Components\Section;
use Filament\Forms\Components\FileUpload;
use Illuminate\Support\Str;

class PhotoResource extends Resource
{
    protected static ?string $model = Photo::class;
    protected static ?int $navigationSort = 1;

    protected static ?string $navigationIcon = 'heroicon-o-photo';
    protected static ?string $navigationGroup = 'Content';
    protected static ?string $recordTitleAttribute = 'caption';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Select::make('post_id')
                ->relationship('post', 'title')
                ->label('Post')
                ->searchable()
                ->required(),

            FileUpload::make('image_url')
                ->label('Photo')
                ->image()
                ->directory('photos')
                ->preserveFilenames()
                ->required(),

            Forms\Components\TextInput::make('caption')
                ->maxLength(255)
                ->nullable(),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table->columns([
            Tables\Columns\ImageColumn::make('image_url')->label('Photo')->circular(),
            Tables\Columns\TextColumn::make('caption')->wrap()->limit(30),
            Tables\Columns\TextColumn::make('post.title')->label('Post')->sortable()->searchable(),
            Tables\Columns\TextColumn::make('created_at')->dateTime()->sortable(),
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
            Section::make('Photo Details')->schema([
                TextEntry::make('post.title')->label('Post'),
                TextEntry::make('caption'),
                TextEntry::make('image_url')->label('File')->url(fn (Photo $photo) => asset('storage/' . $photo->image_url)),
                TextEntry::make('created_at')->dateTime(),
            ])->columns(2),
        ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPhotos::route('/'),
            'create' => Pages\CreatePhoto::route('/create'),
            'edit' => Pages\EditPhoto::route('/{record}/edit'),
        ];
    }
}

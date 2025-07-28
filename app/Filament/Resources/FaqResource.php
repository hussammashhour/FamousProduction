<?php

namespace App\Filament\Resources;

use App\Filament\Resources\FaqResource\Pages;
use App\Models\Faq;
use App\Models\Role;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Database\Eloquent\Model;
use Filament\Forms\Components\Select;

class FaqResource extends Resource
{
    protected static ?string $model = Faq::class;
    protected static ?int $navigationSort = 5;

    protected static ?string $navigationIcon = 'heroicon-o-question-mark-circle';
    protected static ?string $navigationGroup = 'Content Management';
    protected static ?string $recordTitleAttribute = 'question';


public static function form(Form $form): Form
{
    return $form->schema([
        Forms\Components\TextInput::make('question')->required(),
        Forms\Components\Textarea::make('answer')->required(),

        // Role
        Select::make('roles')
            ->label('Visible to Roles')
            ->multiple()
            ->relationship('roles', 'name'),

        // Service
        Select::make('services')
            ->label('Related Services')
            ->multiple()
            ->relationship('services', 'name'),

        // Payment
        Select::make('payments')
            ->label('Related Payments')
            ->multiple()
            ->relationship('payments', 'id'), // or any suitable label
    ]);
}


   public static function table(Table $table): Table
{
    return $table->columns([
        TextColumn::make('question')->searchable(),

        TextColumn::make('roles.name')
            ->label('Roles')
            ->badge()
            ->limit(2),

        TextColumn::make('services.name')
            ->label('Services')
            ->badge()
            ->limit(2),
    ]);
}

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListFaqs::route('/'),
            'create' => Pages\CreateFaq::route('/create'),
            'edit' => Pages\EditFaq::route('/{record}/edit'),
        ];
    }
}

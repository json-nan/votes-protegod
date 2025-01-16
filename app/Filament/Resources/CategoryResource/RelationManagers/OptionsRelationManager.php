<?php

namespace App\Filament\Resources\CategoryResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class OptionsRelationManager extends RelationManager
{
    protected static string $relationship = 'options';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('title')
                    ->required()
                    ->maxLength(255),
                Forms\Components\Select::make('content_type')
                    ->options([
                        'text' => 'Texto',
                        'image' => 'Imagen',
                        'twitch-clip' => 'Twitch Clip',
                    ])
                    ->required()
                    ->live()
                    ->afterStateUpdated(fn(Set $set, ?string $state) => $set('content', null)),

                Grid::make(1)->schema(fn(Get $get): array => match ($get('content_type')) {
                    'text' => [
                        TextInput::make('content')
                            ->required()
                            ->maxLength(255),
                    ],
                    'image' => [
                        FileUpload::make('content')
                            ->required()
                            ->image(),
                    ],
                    'twitch-clip' => [
                        TextInput::make('content')
                            ->required()
                            ->maxLength(255),
                    ],
                    default => [],
                })
                    ->key('content')
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('id')
            ->columns([
                Tables\Columns\TextColumn::make('id'),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
}

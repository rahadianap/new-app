<?php

namespace App\Filament\Resources\CategoryResource\RelationManagers;

use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Resources\Table;
use Filament\Tables;

class ProductsRelationManager extends RelationManager
{
    protected static string $relationship = 'products';
    protected static ?string $inverseRelationship = 'category';

    protected static ?string $recordTitleAttribute = 'product_name';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Card::make()
                    ->schema([
                        Forms\Components\TextInput::make('product_name')
                            ->required()
                            ->maxLength(255),
                    ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('product_code'),
                Tables\Columns\TextColumn::make('product_name'),
                Tables\Columns\TextColumn::make('product_price')
                    ->money('IDR', true),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime(),
            ])
            ->filters([
                //
            ])
            ->headerActions(actions: [
                Tables\Actions\AssociateAction::make()
                    ->preloadRecordSelect()
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\DissociateAction::make(),
            ])
            ->bulkActions([
            ]);
    }
}
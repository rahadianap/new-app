<?php

namespace App\Filament\Resources\ProductResource\RelationManagers;

use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Resources\Table;
use Filament\Tables;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class SuppliersRelationManager extends RelationManager
{
    protected static string $relationship = 'suppliers';

    protected static ?string $recordTitleAttribute = 'supplier_name';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('supplier_code'),
                Forms\Components\TextInput::make('supplier_name'),
                Forms\Components\TextInput::make('supplier_type'),
                Forms\Components\TextInput::make('supplier_address'),
                Forms\Components\TextInput::make('supplier_phone'),
                Forms\Components\TextInput::make('supplier_account'),
                Forms\Components\TextInput::make('supplier_account_no'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('supplier_code'),
                Tables\Columns\TextColumn::make('supplier_name'),
                Tables\Columns\TextColumn::make('supplier_type'),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\AttachAction::make()
                    ->preloadRecordSelect()
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\DetachAction::make(),
            ])
            ->bulkActions([
            ]);
    }
}
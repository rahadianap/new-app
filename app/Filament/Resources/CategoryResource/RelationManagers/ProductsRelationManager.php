<?php

namespace App\Filament\Resources\CategoryResource\RelationManagers;

use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Resources\Table;
use Filament\Tables;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\FileUpload;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ProductsRelationManager extends RelationManager
{
    protected static string $relationship = 'products';

    protected static ?string $recordTitleAttribute = 'product_name';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Card::make()
                    ->schema([
                        Forms\Components\Grid::make()
                            ->schema([
                                Forms\Components\TextInput::make('product_code')
                                    ->label(__('Kode Barang')),
                                Forms\Components\TextInput::make('product_name')
                                    ->label(__('Nama Barang')),
                                Forms\Components\TextInput::make('product_price')
                                    ->label(__('Harga Barang'))
                                    ->numeric(),
                                Forms\Components\TextInput::make('product_description')
                                    ->label(__('Deskripsi Barang')),
                                Select::make('available_status')
                                    ->options([
                                        'available' => 'Available',
                                        'unavailable' => 'Unavailable',
                                        'temporary_unavailable' => 'Temporary Unavailable',
                                    ]),
                                Forms\Components\TextInput::make('initial_stock')
                                    ->label(__('Stok Awal'))
                                    ->numeric(),
                                Select::make('category_id')
                                    ->relationship('category', 'category_name')
                                    ->searchable()
                                    ->preload(),
                                Select::make('unit_id')
                                    ->relationship('unit', 'unit_name')
                                    ->searchable()
                                    ->preload(),
                                FileUpload::make('Product Image')
                                    ->disk('s3')
                                    ->directory('form-attachments')
                                    ->visibility('private')
                                    ->columnSpan(2),

                            ])
                    ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('product_code')
                    ->label(__('Kode Barang'))
                    ->sortable()
                    ->searchable(),

                Tables\Columns\TextColumn::make('product_name')
                    ->label(__('Nama Barang'))
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('product_price')
                    ->label(__('Harga Barang'))
                    ->money('IDR')
                    ->sortable(),

                Tables\Columns\TextColumn::make('created_at')
                    ->label(__('Tanggal Dibuat'))
                    ->dateTime()
                    ->sortable()
            ])
            ->filters([
                //
            ])
            ->headerActions([
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
            ])
            ->bulkActions([
            ]);
    }
}
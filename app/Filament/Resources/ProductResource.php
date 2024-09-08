<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProductResource\Pages;
use App\Filament\Resources\ProductResource\RelationManagers;
use App\Filament\Resources\ProductResource\RelationManagers\SuppliersRelationManager;
use App\Models\Product;
use Filament\Forms;
use Filament\Forms\Components\Select;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Filament\Forms\Components\FileUpload;
use Illuminate\Database\Eloquent\Builder;
use Filament\Notifications\Notification;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ProductResource extends Resource
{
    protected static ?string $model = Product::class;

    protected static ?string $navigationIcon = 'heroicon-o-cube';

    protected static ?int $navigationSort = 7;

    protected static function getNavigationLabel(): string
    {
        return __('Barang');
    }

    public static function getPluralLabel(): ?string
    {
        return static::getNavigationLabel();
    }

    protected static function getNavigationGroup(): ?string
    {
        return __('Master Data');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Card::make()
                    ->schema([
                        Forms\Components\Grid::make()
                            ->schema([
                                Forms\Components\TextInput::make('product_code')
                                    ->label(__('Kode Barang'))
                                    ->required()
                                    ->disabled()
                                    ->maxLength(255)
                                    ->visibleOn(['view', 'edit']),
                                Forms\Components\TextInput::make('product_name')
                                    ->label(__('Nama Barang'))
                                    ->required()
                                    ->maxLength(255),
                                Forms\Components\TextInput::make('product_price')
                                    ->label(__('Harga Barang'))
                                    ->numeric()
                                    ->required()
                                    ->maxLength(255),
                                Forms\Components\TextInput::make('product_description')
                                    ->label(__('Deskripsi Barang'))
                                    ->required()
                                    ->maxLength(255),
                                Select::make('available_status')
                                    ->label(__('Status Barang'))
                                    ->options([
                                        'available' => 'Available',
                                        'unavailable' => 'Unavailable',
                                        'temporary_unavailable' => 'Temporary Unavailable',
                                    ]),
                                Forms\Components\TextInput::make('initial_stock')
                                    ->label(__('Stok Awal'))
                                    ->numeric()
                                    ->required()
                                    ->maxLength(255),
                                Select::make('category_id')
                                    ->label(__('Kategori Barang'))
                                    ->relationship('category', 'category_name')
                                    ->searchable()
                                    ->preload(),
                                Select::make('unit_id')
                                    ->label(__('Satuan Barang'))
                                    ->relationship('unit', 'unit_name')
                                    ->searchable()
                                    ->preload(),
                                Select::make('suppliers')
                                    ->label(__('Supplier'))
                                    ->multiple()
                                    ->relationship('suppliers', 'supplier_name')
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
                    ->money('IDR', true)
                    ->sortable(),

                Tables\Columns\TextColumn::make('created_at')
                    ->label(__('Tanggal Dibuat'))
                    ->dateTime()
                    ->sortable()
            ])
            ->filters([
                Tables\Filters\TrashedFilter::make(),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make()
                    ->successNotification(
                        Notification::make()
                            ->success()
                            ->title('Updated Successfully')
                            ->body('Data Barang berhasil diubah!'),
                    )
                ,
                Tables\Actions\DeleteAction::make()
                    ->successNotification(
                        Notification::make()
                            ->success()
                            ->title('Updated Successfully')
                            ->body('Data Barang berhasil dihapus!'),
                    ),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
                Tables\Actions\ForceDeleteBulkAction::make(),
                Tables\Actions\RestoreBulkAction::make(),
            ])
            ->defaultSort('product_code');
    }

    public static function getRelations(): array
    {
        return [
            SuppliersRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListProducts::route('/'),
            'create' => Pages\CreateProduct::route('/create'),
            'view' => Pages\ViewProduct::route('/{record}'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);
    }
}
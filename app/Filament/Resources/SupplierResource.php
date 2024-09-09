<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SupplierResource\RelationManagers\ProductsRelationManager;
use App\Filament\Resources\SupplierResource\Pages;
use App\Filament\Resources\SupplierResource\RelationManagers;
use App\Models\Supplier;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Forms\Components\Select;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Illuminate\Database\Eloquent\Builder;
use Filament\Notifications\Notification;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class SupplierResource extends Resource
{
    protected static ?string $model = Supplier::class;

    protected static ?string $navigationIcon = 'heroicon-o-user-group';

    protected static ?int $navigationSort = 9;

    protected static function getNavigationLabel(): string
    {
        return __('Supplier');
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
                                Forms\Components\TextInput::make('supplier_code')
                                    ->label(__('Kode Supplier'))
                                    ->required()
                                    ->disabled()
                                    ->maxLength(255)
                                    ->visibleOn(['view', 'edit']),
                                Forms\Components\TextInput::make('supplier_name')
                                    ->label(__('Nama Supplier'))
                                    ->required()
                                    ->maxLength(255),
                                Select::make('supplier_type')
                                    ->label(__('Jenis Supplier'))
                                    ->required()
                                    ->options([
                                        'buah' => 'Buah',
                                        'sayur' => 'Sayur',
                                        'kue_basah' => 'Kue Basah',
                                    ]),
                                Forms\Components\TextInput::make('supplier_address')
                                    ->label(__('Alamat Supplier'))
                                    ->maxLength(255),
                                Forms\Components\TextInput::make('supplier_phone')
                                    ->label(__('Nomor Telepon'))
                                    ->numeric()
                                    ->maxLength(255),
                                Select::make('supplier_account')
                                    ->label(__('Akun Supplier'))
                                    ->options([
                                        'BCA' => 'BCA',
                                        'Mandiri' => 'Mandiri',
                                        'BRI' => 'BRI',
                                    ]),
                                Forms\Components\TextInput::make('supplier_account_no')
                                    ->label(__('Nomor Rekening Supplier'))
                                    ->numeric()
                                    ->maxLength(255),
                            ])
                    ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('supplier_code')
                    ->label(__('Kode Supplier'))
                    ->sortable()
                    ->searchable(),

                Tables\Columns\TextColumn::make('supplier_name')
                    ->label(__('Nama Supplier'))
                    ->sortable()
                    ->searchable(),

                Tables\Columns\TextColumn::make('supplier_type')
                    ->label(__('Jenis Supplier'))
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
                            ->body('Data Supplier berhasil diubah!'),
                    )
                ,
                Tables\Actions\DeleteAction::make()
                    ->successNotification(
                        Notification::make()
                            ->success()
                            ->title('Updated Successfully')
                            ->body('Data Supplier berhasil dihapus!'),
                    ),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
                Tables\Actions\ForceDeleteBulkAction::make(),
                Tables\Actions\RestoreBulkAction::make(),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            ProductsRelationManager::class
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListSuppliers::route('/'),
            'create' => Pages\CreateSupplier::route('/create'),
            'view' => Pages\ViewSupplier::route('/{record}'),
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
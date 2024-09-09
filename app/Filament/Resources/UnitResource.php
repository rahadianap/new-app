<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UnitResource\Pages;
use App\Filament\Resources\UnitResource\RelationManagers;
use App\Models\Unit;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Notifications\Notification;

class UnitResource extends Resource
{
    protected static ?string $model = Unit::class;

    protected static ?string $navigationIcon = 'heroicon-o-at-symbol';

    protected static ?int $navigationSort = 8;

    protected static function getNavigationLabel(): string
    {
        return __('Satuan Barang');
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
                                Forms\Components\TextInput::make('unit_code')
                                    ->label(__('Kode Satuan'))
                                    ->required()
                                    ->disabled()
                                    ->maxLength(255)
                                    ->visibleOn(['view', 'edit']),
                                Forms\Components\TextInput::make('unit_name')
                                    ->label(__('Nama Satuan'))
                                    ->required()
                                    ->maxLength(255),
                                Forms\Components\TextInput::make('unit_description')
                                    ->label(__('Deskripsi Satuan'))
                                    ->required()
                                    ->maxLength(255),
                            ])
                    ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('unit_code')
                    ->label(__('Kode Satuan'))
                    ->sortable()
                    ->searchable(),

                Tables\Columns\TextColumn::make('unit_name')
                    ->label(__('Nama Satuan'))
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('unit_description')
                    ->label(__('Deskripsi Satuan'))
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
                            ->body('Data Satuan berhasil diubah!'),
                    )
                ,
                Tables\Actions\DeleteAction::make()
                    ->successNotification(
                        Notification::make()
                            ->success()
                            ->title('Deleted Successfully')
                            ->body('Data Satuan berhasil dihapus!'),
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
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListUnits::route('/'),
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
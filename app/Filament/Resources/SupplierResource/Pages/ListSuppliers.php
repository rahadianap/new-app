<?php

namespace App\Filament\Resources\SupplierResource\Pages;

use App\Filament\Resources\SupplierResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ListRecords;
use Filament\Notifications\Notification;
use Konnco\FilamentImport\Actions\ImportField;
use Konnco\FilamentImport\Actions\ImportAction;
use pxlrbt\FilamentExcel\Columns\Column;
use pxlrbt\FilamentExcel\Exports\ExcelExport;
use pxlrbt\FilamentExcel\Actions\Pages\ExportAction;

class ListSuppliers extends ListRecords
{
    protected static string $resource = SupplierResource::class;

    protected function getActions(): array
    {
        return [
            Actions\CreateAction::make(),
            ImportAction::make()
                ->fields([
                    ImportField::make('product_code')
                        ->required(),
                    ImportField::make('product_name')
                        ->required()
                        ->label('Product name')
                ]),
            ExportAction::make()
                ->exports([
                    ExcelExport::make()
                        ->fromTable()
                        ->withFilename(fn($resource) => $resource::getModelLabel() . date('Y-m-d'))
                        ->withWriterType(\Maatwebsite\Excel\Excel::XLSX)
                        ->withColumns([
                            Column::make('created_by'),
                            Column::make('updated_by'),
                            Column::make('deleted_by'),
                        ])
                ]),
        ];
    }
}
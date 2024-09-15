<?php

namespace App\Filament\Resources\ProductResource\Pages;

use App\Filament\Resources\ProductResource;
use App\Imports\ProductsImport;
use Filament\Pages\Actions;
use Filament\Pages\Actions\Action;
use Filament\Resources\Pages\ListRecords;
use Filament\Notifications\Notification;
use Filament\Forms\Components\FileUpload;
use Maatwebsite\Excel\Facades\Excel;
use Konnco\FilamentImport\Actions\ImportField;
use Konnco\FilamentImport\Actions\ImportAction;
use pxlrbt\FilamentExcel\Columns\Column;
use pxlrbt\FilamentExcel\Exports\ExcelExport;
use pxlrbt\FilamentExcel\Actions\Pages\ExportAction;

class ListProducts extends ListRecords
{
    protected static string $resource = ProductResource::class;

    protected function getTableRecordsPerPageSelectOptions(): array
    {
        return [10, 20, 50, 100];
    }

    protected function getDefaultTableRecordsPerPageSelectOption(): int
    {
        return 20;
    }

    protected function getActions(): array
    {
        return [
            Actions\CreateAction::make(),
            Action::make('importExcel')
                ->label('Import')
                ->color('success')
                ->form([
                    FileUpload::make('attachment'),
                ])
                ->action(function (array $data) {
                    // $data is an array which consists of all the form data
                    $file = public_path("storage/" . $data['attachment']);

                    Excel::import(new ProductsImport, $file);

                    Notification::make()
                        ->success()
                        ->title('Data Imported!')
                        ->body('Data Barang berhasil diunggah')
                        ->send();
                }),
            ExportAction::make()
                ->color('success')
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
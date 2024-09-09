<?php

namespace App\Filament\Resources\CategoryResource\Pages;

use App\Filament\Resources\CategoryResource;
use App\Imports\CategoriesImport;
use Filament\Pages\Actions;
use Filament\Pages\Actions\Action;
use Filament\Resources\Pages\ListRecords;
use Haruncpi\LaravelIdGenerator\IdGenerator;
use Filament\Notifications\Notification;
use Filament\Forms\Components\FileUpload;
use Maatwebsite\Excel\Facades\Excel;
use pxlrbt\FilamentExcel\Columns\Column;
use pxlrbt\FilamentExcel\Exports\ExcelExport;
use pxlrbt\FilamentExcel\Actions\Pages\ExportAction;

class ListCategories extends ListRecords
{
    protected static string $resource = CategoryResource::class;

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
            Actions\CreateAction::make()
                ->mutateFormDataUsing(function (array $data): array {
                    $data['category_code'] = IdGenerator::generate(['table' => 'categories', 'field' => 'category_code', 'length' => 7, 'prefix' => 'CAT-']);
                    return $data;
                })
                ->successNotification(
                    Notification::make()
                        ->success()
                        ->title('Saved Successfully')
                        ->body('Data Kategori baru berhasil dibuat!'),
                ),
            Action::make('importExcel')
                ->label('Import')
                ->form([
                    FileUpload::make('attachment'),
                ])
                ->action(function (array $data) {
                    $file = public_path("storage/" . $data['attachment']);

                    Excel::import(new CategoriesImport, $file);

                    Notification::make()
                        ->success()
                        ->title('Data Imported!')
                        ->body('Data Kategori berhasil diunggah')
                        ->send();
                }),
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
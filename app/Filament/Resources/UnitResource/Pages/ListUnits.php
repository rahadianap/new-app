<?php

namespace App\Filament\Resources\UnitResource\Pages;

use App\Filament\Resources\UnitResource;
use App\Imports\UnitsImport;
use Filament\Pages\Actions;
use Filament\Pages\Actions\Action;
use Haruncpi\LaravelIdGenerator\IdGenerator;
use Filament\Notifications\Notification;
use Filament\Forms\Components\FileUpload;
use Maatwebsite\Excel\Facades\Excel;
use Filament\Resources\Pages\ListRecords;
use pxlrbt\FilamentExcel\Columns\Column;
use pxlrbt\FilamentExcel\Exports\ExcelExport;
use pxlrbt\FilamentExcel\Actions\Pages\ExportAction;

class ListUnits extends ListRecords
{
    protected static string $resource = UnitResource::class;

    protected function getActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->mutateFormDataUsing(function (array $data): array {
                    $data['unit_code'] = IdGenerator::generate(['table' => 'units', 'field' => 'unit_code', 'length' => 8, 'prefix' => 'UNIT-']);
                    return $data;
                })
                ->successNotification(
                    Notification::make()
                        ->success()
                        ->title('Saved Successfully')
                        ->body('Data Satuan baru berhasil dibuat!'),
                ),
            Action::make('importExcel')
                ->label('Import')
                ->form([
                    FileUpload::make('attachment'),
                ])
                ->action(function (array $data) {
                    $file = public_path("storage/" . $data['attachment']);

                    Excel::import(new UnitsImport, $file);

                    Notification::make()
                        ->success()
                        ->title('Data Imported!')
                        ->body('Data Satuan berhasil diunggah')
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
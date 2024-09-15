<?php

namespace App\Filament\Resources\SupplierResource\Pages;

use App\Filament\Resources\SupplierResource;
use Filament\Resources\Pages\CreateRecord;
use Haruncpi\LaravelIdGenerator\IdGenerator;
use Filament\Notifications\Notification;

class CreateSupplier extends CreateRecord
{
    protected static string $resource = SupplierResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['supplier_code'] = IdGenerator::generate(['table' => 'suppliers', 'field' => 'supplier_code', 'length' => 8, 'prefix' => 'SUP-']);
        return $data;
    }

    protected function getCreatedNotification(): ?Notification
    {
        return Notification::make()
            ->success()
            ->title('Saved Successfully')
            ->body('Data Supplier baru berhasil dibuat!');
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
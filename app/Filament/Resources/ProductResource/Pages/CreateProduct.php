<?php

namespace App\Filament\Resources\ProductResource\Pages;

use App\Filament\Resources\ProductResource;
use Filament\Resources\Pages\CreateRecord;
use Haruncpi\LaravelIdGenerator\IdGenerator;
use Filament\Notifications\Notification;

class CreateProduct extends CreateRecord
{
    protected static string $resource = ProductResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['product_code'] = IdGenerator::generate(['table' => 'products', 'field' => 'product_code', 'length' => 8, 'prefix' => 'PRD-']);
        return $data;
    }

    protected function getCreatedNotification(): ?Notification
    {
        return Notification::make()
            ->success()
            ->title('Saved Successfully')
            ->body('Data Barang baru berhasil dibuat!');
    }
}
<?php

namespace App\Imports;

use App\Models\Product;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ProductsImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        return new Product([
            'id' => $row['id'],
            'product_code' => $row['product_code'],
            'product_name' => $row['product_name'],
            'product_price' => $row['product_price'],
            'product_description' => $row['product_description'],
            'product_image' => $row['product_image'],
            'available_status' => $row['available_status'],
            'initial_stock' => $row['initial_stock'],
            'category_id' => $row['category_id'],
            'unit_id' => $row['unit_id'],
            'created_by' => $row['created_by'],
            'updated_by' => $row['updated_by'],
            'deleted_by' => $row['deleted_by'],
            'created_at' => $row['created_at'],
            'updated_at' => $row['updated_at'],
            'deleted_at' => $row['deleted_at'],
        ]);
    }
}
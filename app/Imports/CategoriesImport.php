<?php

namespace App\Imports;

use App\Models\Category;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class CategoriesImport implements ToModel, WithHeadingRow
{
    use Importable;
    public function model(array $row)
    {
        return new Category([
            'id' => $row['id'],
            'category_code' => $row['category_code'],
            'category_name' => $row['category_name'],
            'created_by' => $row['created_by'],
            'updated_by' => $row['updated_by'],
            'deleted_by' => $row['deleted_by'],
            'created_at' => $row['created_at'],
            'updated_at' => $row['updated_at'],
            'deleted_at' => $row['deleted_at'],
        ]);
    }
}
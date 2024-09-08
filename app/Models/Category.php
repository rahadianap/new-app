<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Product;

class Category extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'category_code',
        'category_name'
    ];

    public function products(): HasMany
    {
        return $this->hasMany(Product::class);
    }
}
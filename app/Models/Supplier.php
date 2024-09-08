<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Supplier extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'supplier_code',
        'supplier_name',
        'supplier_type',
        'supplier_address',
        'supplier_phone',
        'supplier_account',
        'supplier_account_no'
    ];

    public function products(): BelongsToMany
    {
        return $this->belongsToMany(Product::class);
    }
}
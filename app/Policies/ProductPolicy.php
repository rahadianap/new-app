<?php

namespace App\Policies;

use App\Models\Product;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ProductPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user)
    {
        return $user->can('List products');
    }

    public function view(User $user, Product $product)
    {
        return $user->can('View product');
    }

    public function create(User $user)
    {
        return $user->can('Create product');
    }

    public function update(User $user, Product $product)
    {
        return $user->can('Update product');
    }

    public function delete(User $user, Product $product)
    {
        return $user->can('Delete product');
    }

    public function restore(User $user, Product $product)
    {
        //
    }

    public function forceDelete(User $user, Product $product)
    {
        //
    }
}